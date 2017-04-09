<script src="packages/core/modules/ModuleAdmin/edit_module.js" type="text/javascript"></script>
<?php 
$title = (URL::get('cmd')=='edit_code')?PageSetting::language('edit_code_title'):PageSetting::language('edit_code_title');
$action = (URL::get('cmd')=='edit_code')?'edit':'add';
System::set_page_title(COMPANY.' - '.$title);
?>
<br />
<div class="form-bound" style="background:#FFF;padding-top:10px;height:800px;width:99%;padding:5px;">
<table cellpadding="0" width="100%">
	<tr>
    	<td class="form-title" width="80%">SQL Query</td>
        <td>&nbsp;</td>
    	<td>
   		<a  onclick="if(confirm('Ban co chac khong?')){window.close();}"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>go_back_button.gif"/><br />[[.close.]]</a></td>
    	<?php if($action=='edit'){?><td class="form_title_button">
		<a  onclick="location='<?php echo URL::build_current(array('cmd'=>'edit','id'));?>';"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>edit_button.gif"/><br />[[.Edit.]]</a></td><?php }?>
   	 	<td class="form_title_button">
		<a target="_blank" href="<?php echo URL::build('room_map');?>"><img src="<?php echo PageSetting::template('core').'/images/buttons/';?>frontpage.gif" alt=""/><br />Trang ch&#7911;</a></td></tr></table>
		<div>
            <form name="EditModuleContentAdminForm" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
            <?php if(Form::$current->is_error()){?><?php echo Form::$current->error_messages();?><br><?php }?>		
            <br />
            <table cellspacing="0" width="100%">
                <tr>
                    <td>
                    	SQL STATEMENT <input name="execute_sql" type="submit" value="Execute" /><br />
                        <textarea name="sql_statement" id="sql_statement" style="width:970px;height:200px;background-color:#FFC;color:#03C;border:1px solid #999;" onkeydown="if(edit_code_keypress(this)){ if(document.all)event.returnValue=false;else return false;}"></textarea>
                    </td>
                </tr>
            </table>
            <input type="hidden" value="1" name="confirm_edit"/>
        	</form>
		</div><br />
        <fieldset>
        <!--IF:cond1([[=select_statement=]])-->
        <legend class="title">QUERY RESULT ([[.total.]]: [[|total|]])</legend>
            <table width="100%" border="1" cellspacing="0" cellpadding="2" bordercolor="#999999">
                <tr bgcolor="#FFCCCC">
                	<!--LIST:columns-->
                	<td>[[|columns.id|]]</td>
                    <!--/LIST:columns-->
                </tr>
                <!--LIST:items-->
                <tr bgcolor="#FFCCCC">
                	<!--LIST:columns-->
                	<td><?php echo $this->map['items']['current'][strtolower([[=columns.id=]])];?></td>
                    <!--/LIST:columns-->
                </tr>
                <!--/LIST:items-->
            </table><br />
        </fieldset>
        <!--/IF:cond1-->
        <div id="sql_history"><br />
         <fieldset>
        <legend>History</legend>
        <div style="padding:10px;">[[|sql_histories|]]</div>
        </fieldset>
        </div>
</div>