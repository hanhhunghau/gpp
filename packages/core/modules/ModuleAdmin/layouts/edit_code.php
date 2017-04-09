<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<script src="packages/core/modules/ModuleAdmin/edit_module.js" type="text/javascript"></script>
<script src="packages/core/includes/js/editor/wysiwyg/wysiwyg.js" type="text/javascript"></script>

<script src="packages/core/includes/js/multi_items.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit_code')?PageSetting::language('edit_code_title'):PageSetting::language('edit_code_title');
$action = (URL::get('cmd')=='edit_code')?'edit':'add';
?><div class="form_bound">
	<table cellpadding="0" width="100%"><tr><td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?> module [[|name|]]</td><td class="form_title_button"><a  onclick="EditModuleCodeAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br />[[.save.]]</a></td><td>&nbsp;</td>
		<td class="form_title_button">
			<a  onclick="location=\'<?php echo URL::build_current();?>\';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br />[[.back.]]</a></td>
		<?php if($action=='edit'){?><td class="form_title_button">
			<a  onclick="location=\'<?php echo URL::build_current(array('cmd'=>'edit','id'));?>\';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit_button.gif"/><br />[[.Edit.]]</a></td><?php }?>
		<td class="form_title_button">
			<a target="_blank" href="<?php echo URL::build('help',array('id'=>Module::$current->data['module_id'],'href'=>'?'.$_SERVER['QUERY_STRING']));?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>frontpage.gif" alt=""/><br />Trang ch&#7911;</a></td></tr></table>
	<div class="form_content">
<?php if(Form::$current->is_error())
		{
		?>		<strong>B&#225;o l&#7895;i</strong><br>
		<?php echo Form::$current->error_messages();?><br>
		<?php
		}
		?>		
		<form name="EditModuleCodeAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
		<table cellspacing="0" width="100%"><tr><td>
			<div class="tab-pane-1" id="tab-pane-dir">
				<!--LIST:dirs-->
				<div class="tab-page" id="tab-page-dir-[[|dirs.name|]]">
					<h2 class="tab">[[|dirs.name|]]</h2>
					<div class="tab-pane-1" id="tab-pane-file">
						<!--LIST:dirs.files-->
						<div class="tab-page" id="tab-page-file-[[|dirs.files.id|]]">
							<h2 class="tab">[[|dirs.files.name|]]</h2>
							<textarea  name="files[[[|dirs.files.path|]]]" id="file_[[[|dirs.files.id|]]]" style="width:100%;font-family:'Courier New', Courier, monospace;font-size:16px" rows="24" onkeydown="if(edit_code_keypress(this)){ if(document.all)event.returnValue=false;else return false;}">[[|dirs.files.content|]]</textarea>
						</div>
						<!--/LIST:dirs.files-->
					</div>
				</div>
				<!--/LIST:dirs-->
			</div>
		</td></tr></table>
		<input type="hidden" value="1" name="confirm_edit"/>
	</form>
	</div>
</div>