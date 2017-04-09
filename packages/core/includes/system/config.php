<?php
session_start();
define('DEBUG',1);
define('COMPANY','GPP');
header("Content-Type: text/html; charset=utf-8");
ini_set('zend.ze1_compatibility_mode','off');

require_once 'packages/core/includes/system/database.php';
require_once 'packages/core/includes/system/database_session.php';
require_once 'packages/core/includes/system/system.php';
require_once 'packages/core/includes/system/id_structure.php';
require_once 'packages/core/includes/system/url.php';
require_once 'packages/core/includes/pagesetting/form.php';
require_once 'packages/core/includes/pagesetting/pagesetting.php';
init_pagesetting();

require_once 'packages/core/includes/system/user.php';
require_once 'packages/core/includes/pagesetting/module.php';
error_reporting(E_ALL);
ini_set('magic_quotes_runtime',0);
if(get_magic_quotes_gpc()) {
  function stripslashes_deep($value) {
    $value=is_array($value)?array_map('stripslashes_deep',$value):stripslashes($value);
    return $value;
  }
  $_REQUEST=array_map('stripslashes_deep',$_REQUEST);
  $_COOKIE=array_map('stripslashes_deep',$_COOKIE);
}

function init_pagesetting() {
  if(isset($_REQUEST['page'])) {
    $page=$_REQUEST['page'];
  }
}
function make_account_setting_cache($id) {
	$user_settings=DB::fetch_all('     
        SELECT  
            SETTING_ID as ID, 
            SETTING.STYLE as VALUE  
        FROM  
            SETTING,account_SETTING 
        WHERE 
            account_SETTING.account_ID=\''.$id.'\' AND account_SETTING.SETTING_ID = SETTING.ID 
    ');
	$settings=array();
	foreach($user_settings as $user_setting) {
		$settings[$user_setting['id']]=$user_setting['value'];
	}
	if(!empty($settings)) {
		$code=var_export($settings,true).';';
	}
	else {
		$code='';
	} 
	DB::update('account',array('cache_setting'=>$code),'id=\''.$id.'\'');
	return $code;
}
?>