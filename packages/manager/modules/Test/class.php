<?php 
class Test extends Module
{
	function Test($row)
	{
		Module::Module($row);
		require_once 'forms/edit.php';
		$this->add_form(new TestForm());
	}
}
?>