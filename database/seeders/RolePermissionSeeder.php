<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view posts', 'create posts', 'edit posts', 'delete posts',
            'view pages', 'create pages', 'edit pages', 'delete pages',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view tags', 'create tags', 'edit tags', 'delete tags',
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            'view albums', 'create albums', 'edit albums', 'delete albums',
            'view galleries', 'create galleries', 'edit galleries', 'delete galleries',
            'view achievements', 'create achievements', 'edit achievements', 'delete achievements',
            'view extracurriculars', 'create extracurriculars', 'edit extracurriculars', 'delete extracurriculars',
            'view guest_books', 'create guest_books', 'edit guest_books', 'delete guest_books',
            'view menus', 'create menus', 'edit menus', 'delete menus',
            'view settings', 'create settings', 'edit settings', 'delete settings',
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        // Super Admin has all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Editor has content permissions only
        $editor->givePermissionTo([
            'view posts', 'create posts', 'edit posts', 'delete posts',
            'view pages', 'create pages', 'edit pages', 'delete pages',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view tags', 'create tags', 'edit tags', 'delete tags',
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            'view albums', 'create albums', 'edit albums', 'delete albums',
            'view galleries', 'create galleries', 'edit galleries', 'delete galleries',
            'view achievements', 'create achievements', 'edit achievements', 'delete achievements',
            'view extracurriculars', 'create extracurriculars', 'edit extracurriculars', 'delete extracurriculars',
            'view guest_books', 'create guest_books', 'edit guest_books', 'delete guest_books',
            'view menus', 'create menus', 'edit menus', 'delete menus',
        ]);

        // Create Super Admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@sman1kepanjen.sch.id'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('super-admin');

        // Create Editor user
        $editorUser = User::firstOrCreate(
            ['email' => 'editor@sman1kepanjen.sch.id'],
            [
                'name' => 'Editor',
                'password' => bcrypt('password'),
            ]
        );
        $editorUser->assignRole('editor');

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Super Admin: admin@sman1kepanjen.sch.id / password');
        $this->command->info('Editor: editor@sman1kepanjen.sch.id / password');
    }
}
