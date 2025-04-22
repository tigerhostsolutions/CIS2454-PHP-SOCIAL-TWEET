<?php
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
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        
        // Use the script's directory name to avoid file-specific paths
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        $projectRoot = rtrim(str_replace('/views', '', $scriptDir)) . '/';
        define('BASE_URL', $protocol . $host . $projectRoot);
    }
// Directory Paths
    const BASE_DIR = __DIR__; // Project root directory
    const CSS_PATH = BASE_URL . 'css/';
    const UPLOAD_PATH = BASE_URL . 'uploads/';
    const CONTROLLER_PATH = BASE_URL . 'controllers/';
    const MODEL_PATH = BASE_URL . 'models/';
    const VIEW_PATH = BASE_URL . 'views/';