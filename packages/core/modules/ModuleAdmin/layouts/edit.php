<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
<script src="packages/core/includes/js/multi_items.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit')?PageSetting::language('edit_title'):PageSetting::language('add_title');
$action = (URL::get('cmd')=='edit')?'edit':'add';
if(isset([[=type=]])){echo [[=type=]];}?>
<div class="form_bound">
<table cellpadding="10" width="100%">
	<tr>
    	<td  class="form_title"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?><?php echo $action;?>_button.gif" align="absmiddle" alt=""/><?php echo $title;?></td>
        <td class="form_title_button" width="1%" nowrap="nowrap"><a href="javascript:void(0)" onclick="EditModuleAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br />[[.save.]]</a></td>
		<?php if($action=='edit'){?>
			<td class="form_title_button"><a href="javascript:void(0)" onclick="location='<?php echo URL::build_current(array('cmd'=>([[=type=]]=='CONTENT')?'edit_content':(([[=type=]]=='HTML')?'edit_html':'edit_code'),'id'));?>';"><img width="30px" src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit_button.gif" style="text-align:center"/><br />[[.edit_code.]]</a></td>
		<?php }?>
			<td class="form_title_button" width="1%" nowrap="nowrap">
				<a href="javascript:void(0)" onclick="location='<?php echo URL::build_current();?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br />[[.back.]]</a>
			</td>
		<?php if($action=='edit'){?>
			<td class="form_title_button" width="1%" nowrap="nowrap">
				<a href="javascript:void(0)") onclick="location='<?php echo URL::build_current(array('cmd'=>'delete','id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>delete_button.gif" alt=""/><br />[[.Delete.]]</a>
			</td>
		<?php }?>
	</tr>
</table>

<div class="form_content">
<form name="EditModuleAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
		<input  name="deleted_ids" id="deleted_ids" type="hidden" value="<?php echo URL::get('deleted_ids');?>">
		<table cellspacing="0" width="100%">
			<tr>
				<td>
					<div class="tab-pane-1" id="tab-pane-module">
						<!--LIST:languages-->
						<div class="tab-page" id="tab-page-module-[[|languages.id|]]">
							<h2 class="tab">[[|languages.name|]]</h2>
							<div class="form_input_label">[[.title.]]:</div>
							<div class="form_input">
								<input name="title_[[|languages.id|]]" type="text" id="title_[[|languages.id|]]" style="width:400">
							</div>
							<div class="form_input_label">[[.description.]]:</div>
							<div class="form_input">
								<textarea name="description_[[|languages.id|]]" id="description_[[|languages.id|]]" style="width:100%" rows="10"></textarea><br />
							</div>
						</div>
						<!--/LIST:languages-->
					</div>
				</td>
			</tr>
		</table>
		<div class="form_input_label">[[.name.]]:</div>
		<div class="form_input">
			<input name="name" type="text" id="name" style="width:150">
		</div>
		<div class="form_input_label">[[.package_id.]]:</div>
		<div class="form_input">
				<select name="package_id" id="package_id"></select>
		</div>
	<input type="hidden" value="1" name="confirm_edit"/>
	</form>
	</div>
</div>
