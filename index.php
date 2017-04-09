<?php date_default_timezone_set('Asia/Saigon');
    define( 'ROOT_PATH', strtr(dirname('index.php') ."/",array('\\'=>'/')));
    require_once ROOT_PATH.'packages/core/includes/system/config.php'; 
    define('DEVELOPING',true);
    define('REWRITE',false);
    define('BEGINNING_YEAR',2011);
    PageSetting::run(); ?>