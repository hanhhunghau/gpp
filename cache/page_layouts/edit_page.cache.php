<?php
            Module::invoke_event('ONLOAD',System::$false,System::$false);
            global $blocks;
            global $plugins;
            $plugins = array (
);$blocks = array (
  3 => 
  array (
    'id' => '3',
    'module_id' => '3',
    'page_id' => '2',
    'region' => 'center',
    'position' => '2',
    'container_id' => '0',
    'skin_name' => 'default',
    'layout' => 'default',
    'name' => '',
    'settings' => '',
    'module' => 
    array (
      'id' => '3',
      'name' => 'EditPage',
      'path' => 'packages/core/modules/EditPage/',
      'type' => '',
      'package_id' => '2',
    ),
  ),
);
		PageSetting::$page = array (
  'id' => '2',
  'package_id' => '2',
  'layout' => 'packages/core/layouts/simple.php',
  'name' => 'edit_page',
  'title_1' => 'edit_page',
  'title_2' => 'edit_page',
  'description_1' => 'edit_page',
  'description_2' => 'edit_page',
  'show' => '1',
  'type' => 'SERVICE',
);
		foreach($blocks as $id=>$block)
		{
			if($block['module']['type'] == 'WRAPPER')
			{
				require_once $block['wrapper']['path'].'class.php';
				$blocks[$id]['object'] = new $block['wrapper']['name']($block);
				if(URL::get('form_block_id')==$id)
				{
					$blocks[$id]['object']->submit();
				}
			}
			else
			if($block['module']['type'] != 'HTML' and $block['module']['type'] != 'CONTENT' and $block['module']['name'] != 'HTML')
			{
				require_once $block['module']['path'].'class.php';
				$blocks[$id]['object'] = new $block['module']['name']($block);
				if(URL::get('form_block_id')==$id)
				{
					$blocks[$id]['object']->submit();
				}
			}
		}
		require_once 'packages/core/includes/utils/draw.php';
		?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml"><!--<![endif]-->
<HEAD>

<LINK REV="made" href=""><META HTTP-EQUIV="Content-Type" CONTENT="text/css; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="cache-control" content="no-store">
<META NAME="keywords" CONTENT="<?php echo isset(PageSetting::$meta_keywords)?PageSetting::$meta_keywords:PageSetting::get_setting('website_keywords');?>">
<META NAME="description" CONTENT="<?php echo PageSetting::get_setting('website_description')?PageSetting::get_setting('website_description'):PageSetting::$meta_description;?>">
<META NAME="ROBOTS" CONTENT="ALL">
<META NAME="author" CONTENT="">
<TITLE><?php echo COMPANY;?></TITLE>
<LINK rel="stylesheet" href="<?php echo PageSetting::template('core');?>/css/global.css" type="text/css">
<LINK rel="stylesheet" href="assets/css/themes/smoothness/jquery-ui.min.css" type="text/css">
<?php echo PageSetting::$extra_css;?>
<LINK rel="stylesheet" href="assets/css/jquery-ui-timepicker-addon.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" >
<script src="packages/core/includes/js/common.js" type="text/javascript"></script>
<script src="packages/core/includes/js/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>    
<script src="packages/core/includes/js/Highcharts-3.0.6/js/jquery.min.js" type="text/javascript" ></script>
<script src="packages/core/includes/js/Highcharts-3.0.6/js/highcharts.js" type="text/javascript"></script>
<script src="packages/core/includes/js/Highcharts-3.0.6/js/modules/exporting.js" type="text/javascript"></script>    
<script src="packages/core/includes/js/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="packages/core/includes/js/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="packages/core/includes/js/jquery/jquery-migrate-1.2.1.js" type="text/javascript"></script>
<script src="packages/core/includes/js/jquery/ui/jquery.ui.core.js" type="text/javascript"></script>
<script src="packages/core/includes/js/jquery/ui/jquery.ui.widget.js" type="text/javascript"></script>
<script src="assets/js/touchable.js" type="text/javascript"></script>


<?php echo PageSetting::$extra_js;
	$pos = strrpos(PageSetting::$extra_js, "datepicker.js");
	if ($pos) {
		echo "<script src='packages/core/includes/js/jquery/jquery-ui-timepicker-addon.js' type='text/javascript' ></script>";
	}
?>

<script src="packages/core/includes/js/jquery/ui/jquery.ui.button.js" type="text/javascript"></script>

<script>	
	languageId = <?php echo PageSetting::language();?>;
</script>
<style>
.ui-button-text-only .ui-button-text {
	padding:0px;
}
fieldset .title, fieldset .check-availability-title {
text-transform: uppercase;
line-height:24px;
padding: 3px;
border-top: 1px solid #CCCCCC;
border-bottom: 1px solid #CCCCCC;
border-left: 2px solid #5BA5FF;
border-right: 2px solid #5BA5FF;
color: #000000;
font-weight: bold;
font-size: 11px;
background: #FFFFFF;
}
</style>
<?php echo PageSetting::$extra_header;?></HEAD><BODY><div id='loading-layer' style="display:none">
	<div id='loading-layer-text'><img src="packages/core/skins/default/images/ajax-loader.gif" align="absmiddle" width="16" height="16" hspace="5" class="displayIn"><?php echo PageSetting::language('Loading');?>......</div>
</div>
<div class="simple-layout-bound">
	<div class="simple-layout-middle">
		<div class="simple-layout-content">
			<div class="simple-layout-banner" id="_header_region"></div>		
			<div class="simple-layout-center" id="printer" style="margin-top: 50px;">
			
<?php $blocks[3]['object']->on_draw();?>
			</div>
		</div>
	</div>
</div></div>
</body>
</html><?php Module::invoke_event('ONUNLOAD',System::$false,System::$false);?>