<?php
            Module::invoke_event('ONLOAD',System::$false,System::$false);
            global $blocks;
            global $plugins;
            $plugins = array (
);$blocks = array (
  8 => 
  array (
    'id' => '8',
    'module_id' => '5',
    'page_id' => '8',
    'region' => 'banner',
    'position' => '1',
    'container_id' => '0',
    'skin_name' => '',
    'layout' => '',
    'name' => '',
    'settings' => '',
    'module' => 
    array (
      'id' => '5',
      'name' => 'Menu',
      'path' => 'packages/cms/modules/Menu/',
      'type' => '',
      'package_id' => '3',
    ),
  ),
  9 => 
  array (
    'id' => '9',
    'module_id' => '6',
    'page_id' => '8',
    'region' => 'center',
    'position' => '1',
    'container_id' => '0',
    'skin_name' => '',
    'layout' => '',
    'name' => '',
    'settings' => '',
    'module' => 
    array (
      'id' => '6',
      'name' => 'Test',
      'path' => 'packages/manager/modules/Test/',
      'type' => '',
      'package_id' => '4',
    ),
  ),
);
		PageSetting::$page = array (
  'id' => '8',
  'package_id' => '4',
  'layout' => 'packages/core/layouts/simple.php',
  'name' => 'test',
  'title_1' => 'test',
  'title_2' => '',
  'description_1' => '',
  'description_2' => '',
  'show' => '0',
  'type' => '',
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
		?><?php if( Url::get('json')!=1 ): ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<?php if(Url::get('page')=='room_revenue_chart' ){?>    
    <script src="packages/core/includes/js/jquery/jquery-1.10.2.min.js" type="text/javascript"></script><?php
?>     
<?php } else if (   Url::get('page')=='classify_customer_report' 
                or (Url::get('chart')=='1') 
                )  {?>   
    <script src="packages/core/includes/js/Highcharts-3.0.6/js/jquery.min.js" type="text/javascript" ></script>
    <script src="packages/core/includes/js/Highcharts-3.0.6/js/highcharts.js" type="text/javascript"></script>
    
    <script src="packages/core/includes/js/Highcharts-3.0.6/js/modules/exporting.js" type="text/javascript"></script>    
    <?php if(Url::get('cmd')!='confirm'): ?>
     <script src="packages/core/includes/js/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
     <?php endif; ?>
 <?php } else {?>
    <script src="packages/core/includes/js/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
 <?php }?>
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
	BEGINNING_YEAR = <?php echo BEGINNING_YEAR;?>;
	var moduleAllowDoubleClick = '<?php echo MODULE_ALLOW_DOUBLE_CLICK;?>';
	query_string = "?<?php echo urlencode($_SERVER['QUERY_STRING']);?>";
	PORTAL_ID = "<?php echo substr(PORTAL_ID,1);?>";
	jQuery.noConflict();
	 
	
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
<?php endif; ?>

<?php if( Url::get('json')!=1 ): ?> 
	<?php if(Url::get('cmd')!='invoice' && Url::get('cmd')!='group_invoice'): ?>
		<div class="simple-layout-bound">
	<?php endif; ?>
	<div class="simple-layout-middle">
	<?php if(Url::get('cmd')!='invoice' && Url::get('cmd')!='group_invoice'): ?>
		<div class="simple-layout-content">
	<?php endif; ?><!-- <div class="simple-layout-content"> -->
		<div class="simple-layout-banner" id="_header_region">
<?php $blocks[8]['object']->on_draw();?></div>		
		<div class="simple-layout-center" id="printer" style="margin-top: 50px;">
		<div class="shownote" id="shownote_content" style="z-index: 999999;display:none;overflow: auto;border-radius:5px;margin-top: 18%;margin-left: 1%;height: 250px;border:1px solid;box-shadow: rgb(136, 136, 136) 10px 10px 5px;width:70%;background-color:#a6c9e2;position:fixed;"></div>
		<?php endif; ?>
		
		
<?php $blocks[9]['object']->on_draw();?>
		<?php if( Url::get('json')!=1 ): ?> 
		</div>
		
		<!-- <div class="simple-layout-footer" id="_footer_region"></div> -->
	</div><!-- </div> -->
	<?php if(Url::get('cmd')!='invoice' && Url::get('cmd')!='group_invoice'): ?>
		</div>
		</div>
	<?php endif; ?>
<?php endif; 
//system::debug($blocks[55]['object']->forms[0]->count);
//system::debug($blocks);

?>
<script>
    jQuery('#shownote').click(function(){
        jQuery('.shownote').toggle(1000);
    });
	jQuery("#shownote_content").html(jQuery("#shownote_content_hide").html());
	gt();
	function gt(){
	var dt = new Date();
	var sendtime = '<?php echo EMAIL_LOG_TIME; ?>';
	//alert(sendtime);
	if(dt.getHours()==sendtime || dt.getHours()==parseFloat(sendtime))
	{
		var tmlurl = 'save_reservation_room.php?sendmaillog=1';
		jQuery.ajax({
			type: 'POST',
			url: tmlurl,
			dataType: 'json',
			success: function(data){
			}
		});
		//console.log("time",time);
		//setTimeout(gt,1000);
	}
	jQuery("#btn_find").click(function(){
		var input_find = jQuery("#input_find").val();
		if(input_find!='')
		{
			var tmlurl = 'save_reservation_room.php?quick_search=1&room_name='+input_find;
			jQuery.ajax({
				type: 'POST',
				url: tmlurl,
				dataType: 'json',
				success: function(data){
					jQuery.each(data,function(key,value){
						window.open('/?page=reservation&cmd=edit&id='+value.reservation_id+'&r_r_id='+key,'_blank');
					});
				}
			});
		}		
	});
}
</script><?php if( Url::get('json')!=1 ): ?> 
</div>
<script type="text/javascript">
 var e = jQuery.Event("keydown", { keyCode: 64 });
  // trigger an artificial keydown event with keyCode 64
 jQuery("body").trigger( e );
//printWebPart('printer')
<?php echo PageSetting::$footer_js;?>
jQuery(document).ready(function($) {
 var hasLogin =!$("#login"); 
 if (!hasLogin) {
	 if ($.datepicker != undefined) {
			
			$.datepicker.setDefaults({ dateFormat: "dd/mm/yy" });
	}
	 //$("select").css("font-size","0.8em");
	 //$("input").css("font-size","1em");
	 $("input[type='button'],input[type='submit'],input[type='reset'],a[class^='button-medium']").button();
	 if ($.datepicker != undefined) { 
		$(".date-input").timepicker();
	 }
	 $("fieldset").addClass("ui-widget ui-widget-content");
	 $("fieldset legend").addClass("ui-widget-header ui-corner-all");
	}
 });
</script>
<script>
 /*
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-43277511-1', 'ezhotel.vn');
  ga('send', 'pageview');
  */
</script>
</body>
</html>
<?php endif; ?><?php Module::invoke_event('ONUNLOAD',System::$false,System::$false);?>