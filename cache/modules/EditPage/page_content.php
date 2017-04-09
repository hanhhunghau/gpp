<script language="javascript">
packages = {
'':''
<?php if(isset($this->map['packages'])  and  is_array($this->map['packages'])){ foreach($this->map['packages'] as $key1=>&$item1){if($key1!='current'){$this->map['packages']['current'] = &$item1;?>
,<?php echo $this->map['packages']['current']['id'];?>:{
	'':''
	<?php if(isset($this->map['packages']['current']['modules'])  and  is_array($this->map['packages']['current']['modules'])){ foreach($this->map['packages']['current']['modules'] as $key2=>&$item2){if($key2!='current'){$this->map['packages']['current']['modules']['current'] = &$item2;?>
	,<?php echo $this->map['packages']['current']['modules']['current']['id'];?>:'<?php echo $this->map['packages']['current']['modules']['current']['name'];?>'
	<?php }}unset($this->map['packages']['current']['modules']['current']);} ?>
}
<?php }}unset($this->map['packages']['current']);} ?>
};
block_moved = false;
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white">
<tr>
	<td align="center"><?php echo $this->map['name'];?> - <?php echo $this->map['title'];?></td>
</tr>
<tr>
	<td align="center"><?php echo $this->map['regions'];?></td>
</tr>
<tr>
<td>
	&nbsp;Modules: 
	<?php if(isset($this->map['new_modules'])  and  is_array($this->map['new_modules'])){ foreach($this->map['new_modules'] as $key3=>&$item3){if($key3!='current'){$this->map['new_modules']['current'] = &$item3;?>
	&nbsp;&nbsp;<a href = "#" ondragstart="event.dataTransfer.setData('Text', '-<?php echo $this->map['new_modules']['current']['id'];?>');event.dataTransfer.effectAllowed = 'copy';"><?php echo $this->map['new_modules']['current']['name'];?></a>
	<?php }}unset($this->map['new_modules']['current']);} ?>
</td>
</tr>
</table>
