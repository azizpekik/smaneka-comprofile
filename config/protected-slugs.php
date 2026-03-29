<?php

/**
 * Protected Slugs Configuration
 * 
 * These slugs are reserved for system routes and cannot be used
 * for dynamic pages created from admin panel.
 */

return [
    // Main Routes - System Routes Only
    'guru-staff',
    'guru',
    'berita',
    'prestasi',
    'ekstrakurikuler',
    'galeri',

    // Admin Routes
    'admin',

    // Auth Routes
    'login',
    'register',
    'logout',
    'forgot-password',
    'reset-password',

    // Other System Routes
    'api',
    'storage',
    'vendor',
];
