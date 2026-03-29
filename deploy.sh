#!/bin/bash

################################################################################
# SMANeka CMS - Automated Deployment Script
# Usage: ./deploy.sh
################################################################################

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="comprof-smaneka"
DEPLOY_DIR="/home/user/${PROJECT_NAME}"
BACKUP_DIR="/home/user/backups/${PROJECT_NAME}"
DATE=$(date +%Y%m%d_%H%M%S)

echo -e "${BLUE}╔════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║     SMANeka CMS - Automated Deployment Script         ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════╝${NC}"
echo ""

# Function to print status
print_status() {
    echo -e "${YELLOW}[$(date +'%H:%M:%S')]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[$(date +'%H:%M:%S')] ✓${NC} $1"
}

print_error() {
    echo -e "${RED}[$(date +'%H:%M:%S')] ✗${NC} $1"
}

# Check if running as root
if [ "$EUID" -eq 0 ]; then
    print_error "Please do not run this script as root"
    exit 1
fi

# Step 1: Create backup
print_status "Creating backup..."
mkdir -p ${BACKUP_DIR}

if [ -d "${DEPLOY_DIR}" ]; then
    tar -czf ${BACKUP_DIR}/backup_files_${DATE}.tar.gz ${DEPLOY_DIR} 2>/dev/null
    print_success "Files backed up to ${BACKUP_DIR}/backup_files_${DATE}.tar.gz"
    
    # Backup database
    read -p "Backup database? (y/n): " backup_db
    if [ "$backup_db" = "y" ]; then
        read -p "Database name: " db_name
        read -p "Database user: " db_user
        mysqldump -u ${db_user} -p ${db_name} > ${BACKUP_DIR}/backup_db_${DATE}.sql 2>/dev/null
        print_success "Database backed up to ${BACKUP_DIR}/backup_db_${DATE}.sql"
    fi
else
    print_status "No existing deployment found, skipping backup"
fi

echo ""

# Step 2: Pull latest code from Git
print_status "Pulling latest code from Git..."
if [ -d "${DEPLOY_DIR}/.git" ]; then
    cd ${DEPLOY_DIR}
    git pull origin main
    print_success "Code updated successfully"
else
    print_error "Git repository not found. Please clone manually first."
    exit 1
fi

echo ""

# Step 3: Install Composer dependencies
print_status "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction
print_success "Composer dependencies installed"

echo ""

# Step 4: Setup environment
print_status "Setting up environment..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    print_success ".env file created"
    print_status "Please update .env file with your database credentials"
    read -p "Continue with migration? (y/n): " continue_migration
    if [ "$continue_migration" != "y" ]; then
        print_error "Deployment paused. Update .env and run migrations manually"
        exit 1
    fi
else
    print_success ".env file exists"
fi

echo ""

# Step 5: Generate APP_KEY
print_status "Checking APP_KEY..."
if grep -q "APP_KEY=base64:" .env; then
    print_success "APP_KEY already set"
else
    php artisan key:generate
    print_success "APP_KEY generated"
fi

echo ""

# Step 6: Run migrations
print_status "Running database migrations..."
php artisan migrate --force
print_success "Migrations completed"

echo ""

# Step 7: Seed database (optional)
read -p "Seed database? (y/n): " seed_db
if [ "$seed_db" = "y" ]; then
    print_status "Seeding database..."
    php artisan db:seed --class=TestSeeder --force
    print_success "Database seeded"
fi

echo ""

# Step 8: Create storage link
print_status "Creating storage link..."
php artisan storage:link
print_success "Storage link created"

echo ""

# Step 9: Set permissions
print_status "Setting permissions..."
chmod -R 755 storage bootstrap/cache
print_success "Permissions set"

echo ""

# Step 10: Optimize for production
print_status "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
print_success "Optimization completed"

echo ""

# Step 11: Clear old cache
print_status "Clearing old cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
print_success "Cache cleared"

echo ""

# Final checks
print_status "Running final checks..."

# Check if .env is secure
if [ -f ".env" ]; then
    chmod 644 .env
    print_success ".env file secured"
fi

# Check storage permissions
if [ -d "storage" ]; then
    chown -R www-data:www-data storage 2>/dev/null || true
    print_success "Storage ownership set"
fi

echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║           Deployment Completed Successfully!          ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}Next Steps:${NC}"
echo "1. Update .env with your database credentials"
echo "2. Run: php artisan migrate --force"
echo "3. Run: php artisan storage:link"
echo "4. Set permissions: chmod -R 755 storage bootstrap/cache"
echo "5. Optimize: php artisan optimize"
echo "6. Visit your website!"
echo ""
echo -e "${YELLOW}Backup Location: ${BACKUP_DIR}${NC}"
echo -e "${YELLOW}Deployment Log: ${DEPLOY_DIR}/deployment.log${NC}"
echo ""

# Log deployment
echo "Deployment completed at $(date)" >> ${DEPLOY_DIR}/deployment.log

exit 0
