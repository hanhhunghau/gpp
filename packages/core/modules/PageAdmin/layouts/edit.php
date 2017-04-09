<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<span style="display:none">
</span>
<?php 
$title = (URL::get('cmd')=='edit')?PageSetting::language('edit_title'):PageSetting::language('add_title');
$action = (URL::get('cmd')=='edit')?'edit':'add';?><div class="form_bound">
<table cellpadding="10" width="100%">
	<tr>
    	<td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td>
        <td class="form_title_button" width="1%" nowrap="nowrap"><a href="javascript:void(0)" onclick="EditpageAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br />[[.save.]]</a></td>
		<td class="form_title_button" width="1%" nowrap="nowrap">
			<a href="javascript:void(0)" onclick="location='<?php echo URL::build_current(array('package_id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br />[[.back.]]</a></td>
		<?php if($action=='edit'){?><td class="form_title_button" width="1%" nowrap="nowrap">
			<a href="javascript:void(0)" onclick="location='<?php echo URL::build_current(array('package_id','cmd'=>'delete','id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" alt=""/><br />[[.Delete.]]</a></td><?php }?>
		</tr></table>
	<div class="form_content">
<?php if(Form::$current->is_error())
		{
		?>		<strong>B&#225;o l&#7895;i</strong><br>
		<?php echo Form::$current->error_messages();?><br>
		<?php
		}
		?>		
	<form name="EditpageAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
	<table cellspacing="0" width="100%"><tr><td>
				<div class="tab-pane-1" id="tab-pane-page">
				<!--LIST:languages-->
				<div class="tab-page" id="tab-page-page-[[|languages.id|]]">
					<h2 class="tab">[[|languages.name|]]</h2>
					<div class="form_input_label">[[.title.]]:</div>
					<div class="form_input">
							<input name="title_[[|languages.id|]]" type="text" id="title_[[|languages.id|]]" style="width:400">
					</div><div class="form_input_label">[[.description.]]:</div>
					<div class="form_input">
							<textarea name="description_[[|languages.id|]]" id="description_[[|languages.id|]]" style="width:100%" rows="10"></textarea><br />
					</div>
				</div>
				<!--/LIST:languages-->
				</div>
				</td></tr></table>
		<div class="form_input_label">[[.name.]]:</div>
		<div class="form_input">
			<input name="name" type="text" id="name" style="width:300">
		<div class="form_input_label">[[.package_id.]]:</div>
		<div class="form_input">
			<select name="package_id" id="package_id"></select>
		</div><div class="form_input_label">[[.layout.]]:</div>
		<div class="form_input">
			<select name="layout" id="layout"></select>
		</div>        
		<input type="hidden" value="1" name="confirm_edit"/>
	</form>
	</div>
</div>
