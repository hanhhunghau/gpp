<?php
class Menu extends Module
{
	function Menu($row)
	{
		Module::Module($row);
		require_once 'forms/list.php';
		require_once 'db.php';
		$this->add_form(new MenuForm());
	}
}
?>
