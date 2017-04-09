<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit')?PageSetting::language('Edit'):PageSetting::language('Add');
$action = (URL::get('cmd')=='edit')?'edit':'add';
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0" bordercolor="#CCCCCC"  class="table-bound">
	<tr height="40">
		<td width="90" class="form-title"><?php echo $title;?></td>
		<td width="1%" align="right"><a class="button-medium-save" onclick="EditCategoryForm.submit();">[[.save.]]</a></td>
        <td width="1%"><a class="button-medium-back" onclick="location='<?php echo URL::build_current();?>';">[[.back.]]</a></td>
		<?php 
		//if($action=='edit' and User::can_delete(false,ANY_CATEGORY))
		//{
			?>
		<td width="1%"><a class="button-medium-delete" onclick="location='<?php echo URL::build_current(array('cmd'=>'delete','id'));?>';">[[.Delete.]]</a></td>
		<?php// }?>
	</tr>
</table>
<table cellpadding="15" cellspacing="0" width="100%" border="0" bordercolor="#CCCCCC" class="table-bound">	
	<tr>
	<td style="width:100%" valign="top">
	<?php if(Form::$current->is_error()){?><?php echo Form::$current->error_messages();?><br><?php }?>
	<form name="EditCategoryForm" method="post" enctype="multipart/form-data" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
	<input type="hidden" name="confirm_edit" value="1" />
	<table cellspacing="0" width="100%"><tr><td>
	<div class="tab-pane-1" id="tab-pane-category">
	<!--LIST:languages-->
	<div class="tab-page" id="tab-page-category-[[|languages.id|]]">
	<h2 class="tab">[[|languages.name|]]</h2>
	<div class="form-input-label">[[.name.]]:</div>
	<div class="form-input">
	<input name="name_[[|languages.id|]]" type="text" id="name_[[|languages.id|]]" style="width:400px;">
	</div>
	<div class="form-input-label">[[.description.]]:</div>
	<div class="form-input">
	<textarea name="description_[[|languages.id|]]" id="description_[[|languages.id|]]" style="width:400px;" rows="2" ></textarea><br />
    <div class="form-input-label"><strong>[[.group_name.]]:</strong></div>
	<div class="form-input">
	<input name="group_name_[[|languages.id|]]" type="text" id="group_name_[[|languages.id|]]" style="width:400px;">
	</div>
	</div>
	</div>
	<!--/LIST:languages-->
	</div>
	</td></tr></table>
	
	<div class="form-input-label"><strong>[[.parent_name.]]:</strong></div>
	<div class="form-input">
	<select name="parent_id" id="parent_id"></select></div>
    <div class="form-input-label"><strong>[[.module.]]:</strong></div>
	<div class="form-input">
	<select name="module_id" id="module_id"></select></div>
	<div class="form-input-label"><strong>[[.url.]]:</strong></div>
	<div class="form-input">
	<input name="url" type="text" id="url" style="width:400px;">
	</div>
	<div class="form-input-label"><strong>[[.status.]]:</strong></div>
	<div class="form-input">
	<select name="status" id="status"></select>
	</div>
	<div class="form-input-label"><strong>[[.icon_url.]]:</strong></div>
	<div class="form-input">
	<img id="img_icon_url" src="<?php echo URL::get('icon_url')?URL::get('icon_url'):'packages/core/skins/default/images/no_image.gif';?>" width="50" border="0">
	<input name="icon_url" type="hidden" id="icon_url">
	<input name="file_icon_url" type="file" id="file_icon_url" onchange="$('img_icon_url').src='file:///'+this.value;" >
	<input type="image" src="<?php echo PageSetting::template('core');?>/images/buttons/delete.gif" onclick="$('icon_url').value = '';$('file_icon_url').value='';$('img_icon_url').src='<?php echo PageSetting::template('cms');?>/images/spacer.gif';event.returnValue=false;">
	</div>
	</form>
	</td>
	<td valign="top">
	</td>
	</tr>
</table>
