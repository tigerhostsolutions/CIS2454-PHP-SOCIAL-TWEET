<?php
    /* https://yagudaev.com/posts/resolving-php-relative-path-problem/*/
    
    // base_url_config
    if (php_sapi_name() === 'cli') {
        // CLI Mode: Dynamically calculate
        $protocol = 'http://';
        $host = 'localhost';
        $projectRoot = str_replace('\\', '/',
                        realpath(dirname(__FILE__) . '/PHPBadTwitter/'));
        $rootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $projectRoot);
        define('BASE_URL', $protocol . $host . $rootPath . '/');
    } else {
        // Web Server Mode: Calculate consistently from project root
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
//        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        // Use the script's directory name to avoid file-specific paths
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        $projectRoot = rtrim(str_replace('/views', '', $scriptDir)) . '/';
        define('BASE_URL', $protocol . $host . $projectRoot);
    }
    /*
     * Base URL for the application
     * This is used to generate links to assets like CSS, JS, and images.
     */
    const CSS_URL = BASE_URL . 'css/';
    const UPLOAD_URL = BASE_URL . 'uploads/';
    const VIEW_URL = BASE_URL . 'views/';
    /*
     * Directory paths for controllers, models, and views
     * These are used to include the respective files in the application.
     */
    const CONTROLLER_PATH = __DIR__ . '/controllers/';
    const MODEL_PATH = __DIR__ . '/models/';
    const VIEW_PATH = __DIR__ . '/views/';