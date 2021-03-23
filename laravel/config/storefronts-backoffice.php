<?php

/**
 * |--------------------------------------------------------------------------
 * | Storefronts Backoffice Settings
 * |--------------------------------------------------------------------------
 * 
 * Dedicated to settings specifically for the backoffice only.
 * 
 * If a setting applies to another section as well, then it should go in the common 
 * storefronts.php config.
 */
return [
    //=== PAGINATION SETTINGS ===
    'pagination-default' => 30,
    'pagination-recordsperpage-options' => [10, 20, 30, 100, 500],
    //=== IMAGE SETTINGS ===
    'image-banner-width' => 1000,
    'image-banner-height' => 270,
    'image-logo-width' => 90,
    'image-logo-height' => 90,
    //=== LOG SETTINGS ===
    'logs-max-days' => env('LOGS_MAX_DAYS', 10), //max number of days to keep log files for
    //=== EMAIL SETTINGS ===
    'from_email' => 'noreply@econetwirelss.com',
    'from_name' => 'Econet Wireless'
];
