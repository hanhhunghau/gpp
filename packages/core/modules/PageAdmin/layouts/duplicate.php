<?php System::set_page_title(COMPANY.' - '.'duplicate_title');?><?php echo Draw::begin_round_table();?><table cellspacing="0" width="100%">
	<tr valign="top">
		<td>&nbsp;</td>
		<td align="left" colspan="2"><font class="form_title"><b>[[.duplicate_title.]]</b></font></td>
	</tr>
	<tr bgcolor="#EEEEEE" valign="top">
	<td align="right">&nbsp;</td>
	<td bgcolor="#EEEEEE"><div style="width:10px;">&nbsp;</div></td>
	<td bgcolor="#EEEEEE">&nbsp;</td>
	</tr>
	<?php if(Form::$current->is_error())
	{
	?>	<tr bgcolor="#EEEEEE" valign="top">
	<td align="right">&nbsp;</td>
	<td bgcolor="#EEEEEE"><div style="width:10px;">&nbsp;</div></td>
	<td bgcolor="#EEEEEE">B&#225;o l&#7895;i<br /><?php echo Form::$current->error_messages();?></td>
	</tr>
	<?php
	}
	?>	<tr bgcolor="#EEEEEE" valign="top">
	<td>&nbsp;</td>
	<td bgcolor="#EEEEEE">&nbsp;</td>
	<td bgcolor="#EEEEEE">
      <form name="addLayout" method="post" action="?<?php echo htmlentities($_SERVER['QUERY_STRING']);?>">
        <table width="100%" border="0" class="body_text">
          <tr>
            <td width="149">[[.page_name.]]</td>
            <td width="14" class="body_text">:</td>
            <td width="452"><input name="name" type="text" id="name" value="[[|name|]]" size="30">
            </td>
          </tr>
		   <tr>
		  	<td colspan="3">
			
<script src="<?php echo PageSetting::template('core');?>/css/tabs/tabpane.js" type="text/javascript"></script>
			<table width="100%" cellpadding="5" cellspacing="0">
			<tr><td>
				<!--LIST:languages-->
				<table width="100%" border="0" class="body_text" id="enl_[[|languages.id|]]" <?php echo (($this->map['languages']['current']['id']==PageSetting::language())?'':'style="display:none"');?>>
				  <tr>
					<td width="141"><span class="style1">[[.title.]]</span></td>
					<td width="10" class="body_text">:</td>
					<td width="446"><input name="title_[[|languages.id|]]" type="text" id="title_[[|languages.id|]]" value="[[|languages.title|]]" style="width:100%" /></td>
				  </tr>
				  <tr>
				    <td valign="top"><span class="style1">[[.description.]]</span></td>
					<td>:</td>
					<td>
						<textarea name="description_[[|languages.id|]]" style="width:100%" rows="7" id="description_[[|languages.id|]]">[[|languages.description|]]</textarea>
						<script type="text/javascript">editor_generate("description_[[|languages.id|]]");</script>
					</td>
				  </tr>
				</table>
				<!--/LIST:languages-->
			</td></tr></table>
			</td></tr>  
		   <tr>
            <td>[[.params.]]</td>
            <td>:</td>
            <td><input name="params" type="text" id="params" size="30"></td>
          </tr>
          <tr>
            <td><input type="submit" name="Submit" value="   [[.Add.]]   "></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <hr size="1" style="color:white">      
      <p><a href="<?php echo URL::build_current(array('package_id'));?>">[[.page_list.]]</a></p>
    </td>
  </tr>
</table>
<?php echo Draw::end_round_table();?>
