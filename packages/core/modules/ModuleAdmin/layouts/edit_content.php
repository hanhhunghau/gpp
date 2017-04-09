<script src="packages/core/modules/ModuleAdmin/edit_module.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit_code')?PageSetting::language('edit_code_title'):PageSetting::language('edit_code_title');
$action = (URL::get('cmd')=='edit_code')?'edit':'add';
System::set_page_title(COMPANY.' - '.$title);
?>
<br />
<div class="form-bound">
<table cellpadding="0" width="100%">
	<tr>
    	<td class="form-title"><?php echo $title;?> module [[|name|]]</td>
        <td class="form_title_button"><a  onclick="EditModuleContentAdminForm.submit();"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>save_button.gif" style="text-align:center"/><br />[[.save.]]</a></td>
        <td>&nbsp;</td>
    <td>
   		<a  onclick="location='<?php echo URL::build_current();?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br />[[.back.]]</a></td>
    <?php if($action=='edit'){?><td class="form_title_button">
		<a  onclick="location='<?php echo URL::build_current(array('cmd'=>'edit','id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit_button.gif"/><br />[[.Edit.]]</a></td><?php }?>
    <td class="form_title_button">
		<a target="_blank" href="<?php echo URL::build('room_map');?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>frontpage.gif" alt=""/><br />Trang ch&#7911;</a></td></tr></table>
		<div>
			<?php if(Form::$current->is_error()){?><strong>B&#225;o l&#7895;i</strong><br><?php echo Form::$current->error_messages();?><br><?php }?>		
          	<form name="EditModuleContentAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
			<br />
            <table cellspacing="0" width="100%">
                <tr>
                    <td>
	                    Upload File from <input name="from_file" type="file" id="from_file"> to folder <input name="to_folder" type="text" id="to_folder" style="width:230px;border:1px solid #CCCCCC;background:#CFF"> <input name="upload_file" type="submit" value="Copy FIle"><br />
                        Create File &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="file" type="text" id="file" style="width:515px;border:1px solid #CCCCCC;background:#CFC"> <input name="create_file" type="submit" value="Create FIle"><br />
                    	File path &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="path" type="text" id="path" style="width:600px;border:1px solid #CCCCCC;background:#FFFF99" onchange="updateContent(this.value);">
                        <div style="padding:10px;">
                        	<a href="#" onclick="$('path').value=this.innerHTML" style="font-weight:bold;text-decoration:underline;">index.php</a> |
                        	<a href="#" onclick="$('path').value=this.innerHTML" style="font-weight:bold;text-decoration:underline;">packages/core/includes/system/</a> |
                            <a href="#" onclick="$('path').value=this.innerHTML" style="font-weight:bold;text-decoration:underline;">packages/hotel/packages/</a>
                        </div>
                   	</td>
                </tr>
                <tr>
                    <td>
                        <textarea name="content" id="content" style="width:970px;height:300px;" onkeydown="if(edit_code_keypress(this)){ if(document.all)event.returnValue=false;else return false;}">[[|content|]]</textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                    	SQL STATEMENT <input name="execute_sql" type="submit" value="Execute" /><br />
                        <textarea name="sql_statement" id="sql_statement" style="width:970px;height:50px;background-color:#E3E4C9;color:#03C;border:1px solid #CCC;" onkeydown="if(edit_code_keypress(this)){ if(document.all)event.returnValue=false;else return false;}"></textarea>
                    </td>
                </tr>
            </table>
            <input type="hidden" value="1" name="confirm_edit"/>
        	</form>
		</div>
</div>
<script>
	function updateContent(path){
		jQuery.ajax({
			type: "POST",
			url: "form.php?block_id=<?php echo Module::block_id();?>",
			data: ({
					'block_id':'<?php echo Module::block_id();?>'
					,'path':path
					,'cmd':'get_path_content'
				}),
			success: function(msg){
				jQuery('#content').html(msg);
			}
		});
	}
</script>