<?php
define('TMP_PATH', __DIR__.'/../.tmp');
define('FS_CHMOD_FILE', '0777');
require_once __DIR__.'/../../vendor/autoload.php';
require_once 'wp-functions.php';
require_once 'class-wp-filesystem.php';

$wp_filesystem = new WP_Filesystem;