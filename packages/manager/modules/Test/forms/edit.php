<?php
class TestForm extends Form
{
	function TestForm()
	{
		Form::Form('TestForm');
	}
	function on_submit()
	{
				
	}	
	function draw()
	{	    
		$this->map['test'] = array();
		$this->parse_layout('edit',$this->map);
	}
	
}
?>