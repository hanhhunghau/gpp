<table width="100%"  border="0" cellpadding="3" bgcolor="#FFFFFF" 
		ondragenter="event.returnValue = false;event.dataTransfer.dropEffect = 'copy';" 
		ondrop="if(!block_moved){event.returnValue = false;event.dataTransfer.dropEffect = 'copy';if(event.dataTransfer.getData('Text')<0){ location = '<?php echo Url::build_current(array('id','container_id'));?>&region=<?php echo $this->map['name'];?>&module_id='+(-event.dataTransfer.getData('Text'));}else location = '<?php echo Url::build_current(array('id','container_id','cmd'=>'move_block'));?>&region=<?php echo $this->map['name'];?>&block_id='+event.dataTransfer.getData('Text');}"
		ondragover="event.returnValue = false;event.dataTransfer.dropEffect = 'copy';">
  <tr valign="top">
    <td>
	<span style="text-transform:uppercase;color:#000066">&nbsp;&nbsp;::&nbsp;&nbsp;&nbsp;<b><?php echo $this->map['name'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;::</span>
	<fieldset>
	<table width="100%" cellpadding="5" cellspacing="0" >
      <tr valign="top">
        <td valign="top" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr valign="top">
              <td height="16" colspan="6" valign="top">&nbsp;</td>
            </tr>
			<?php if(isset($this->map['items'])  and  is_array($this->map['items'])){ foreach($this->map['items'] as $key1=>&$item1){if($key1!='current'){$this->map['items']['current'] = &$item1;?>
            <tr valign="top">
              <td height="19" valign="top" nowrap><strong><font color="black">&raquo;&nbsp;&nbsp;</font></strong></td>
              <td align="left" valign="top" nowrap><strong><a href="<?php echo $this->map['items']['current']['href'];?>" ondragstart="event.dataTransfer.setData('Text', '<?php echo $this->map['items']['current']['id'];?>');event.dataTransfer.effectAllowed = 'copy'; "><?php echo $this->map['items']['current']['name'];?><?php  
                if(($this->map['items']['current']['block_name'])) 
                {?><span style="font-size:10px"> - <?php echo $this->map['items']['current']['block_name'];?></span> 
                <?php 
                } 
                ?></a>&nbsp;&nbsp;&nbsp;</strong></td>
              <td valign="top"><a href="<?php echo URL::build_current(array('cmd'=>'delete'));?>&id=<?php echo $this->map['items']['current']['id'];?>"><strong><img src="<?php echo PageSetting::template('core');?>/images/buttons/delete.gif" width="12" height="12" border="0" ></strong></a></td>
              <td valign="top"><strong><?php echo $this->map['items']['current']['move_up'];?></strong></td>
              <td valign="top"><strong><?php echo $this->map['items']['current']['move_down'];?></strong></td>
            </tr>
			<?php  
                if(($this->map['items']['current']['regions'])) 
                {?>
			<tr>
				<td height="16" colspan="5" valign="top">
					<?php echo $this->map['items']['current']['regions'];?>
				</td>
			</tr>
			 
                <?php 
                } 
                ?>
			<?php }}unset($this->map['items']['current']);} ?>
            <tr valign="top">
              <td height="16" colspan="5" valign="top">&nbsp;</td>
            </tr>
          </table>
         </td>
      </tr>
	  <tr><td nowrap>
	  <a href="<?php echo Url::build('module',array('page_id'=>$_REQUEST['id'],'container_id'));?>&region=<?php echo $this->map['name'];?>"><?php echo PageSetting::language('Add_block');?></a>
	  </td></tr>
    </table>
	
	</fieldset>
</td></tr>
    </table>
