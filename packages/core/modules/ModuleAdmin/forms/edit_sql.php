<?php
class EditModuleSqlAdminForm extends Form
{
	function EditModuleSqlAdminForm()
	{
		Form::Form('EditModuleSqlAdminForm');
		$this->add('id',new IDType(true,'object_not_exists','module'));
		$this->add('sql_statement',new TextType(true,'sql_yntax_error',0,2550000)); 
	}
	function draw()
	{
		$this->map = array();		
		$this->map['total'] = 0;
		$this->map['select_statement'] = false;
		$this->map['sql_histories'] = '';
		if($sql = Url::get('sql_statement')){
			$_COOKIE['sql_histories'] = $sql;
			$select_partten = '/^SELECT (.)* FROM (\w+)/i';
			$count_partten  = '/^SELECT count\(\*\) as id FROM (\w+)/i';
			if(preg_match($count_partten,$sql,$match)){
				$this->map['select_statement'] = true;
				if(isset($match[1])){
					$table_name = $match[1];
					$columns = array('id'=>array('id'=>'id'));
					$this->map['columns'] = $columns;
					$items = DB::fetch_all($sql);
					$this->map['items'] = $items;
					$this->map['total'] = sizeof($items);
					$this->map['select_statement'] = true;
				}
				
			}else{
				if(preg_match($select_partten,$sql,$match)){
					if(isset($match[2])){
						$table_name = $match[2];
						$show_column_sql = 'select column_name as id from all_tab_columns where table_name = \''.($table_name).'\' order by column_id';
						$columns = DB::fetch_all($show_column_sql);
						$this->map['columns'] = $columns;
						$items = DB::fetch_all($sql);
						$this->map['items'] = $items;
						$this->map['total'] = sizeof($items);
						$this->map['select_statement'] = true;
					}
				}else{
					$this->map['select_statement'] = false;
					$result = DB::query($sql);
				}
				if(isset($_COOKIE['sql_histories'])){
					$this->map['sql_histories'] = $_COOKIE['sql_histories'];
				}
			}
		}
		$this->parse_layout('edit_sql',$this->map);
	}
}
?>