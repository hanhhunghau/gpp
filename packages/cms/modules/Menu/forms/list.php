<?php
class MenuForm extends Form
{
	function MenuForm()
	{
		Form::Form('MenuForm');
	}
	function draw()
	{
		require 'cache/category/category.php';
		$categories = String::array2tree($categories,'child');
		$layout = 'list';
		$this->map['categories'] = $categories;            
        $this->parse_layout($layout,$this->map);		
	}
    
   	
    
}
?>