<?php 
date_default_timezone_set('Asia/Saigon');
$usingTransaction = false;
class DB {
	static $db_connect_id=false;
	static $db_result=false;
	static $db_cache_tables=array();
	static $db_exists_db=array();
	static $db_select_all_db=array();
	static $db_num_queries=0;
  
	function DB(){       
		DB::$db_connect_id=mysql_connect('localhost','root','');
		mysql_select_db('db_gpp') or die('Could not connect to Database');
		if(isset(DB::$db_connect_id)and DB::$db_connect_id) {
			return DB::$db_connect_id;
		}
		else {
			//die(DB::db_error());
			return false;
		}
	}
	static function db_error($db_connect_id=false){
		$error=$db_connect_id?mysql_error($db_connect_id):mysql_error();
		if(isset($error['message'])) {
			return $error['message'].'<br />'.$error['sqltext'];
		}
		return false;
	}
	static function count($table,$condition=false){
		return DB::fetch('SELECT  id as total FROM '.$table.' '.($condition?' WHERE '.$condition:''),'total');
	}
	static function select($table,$condition){
		if($result=DB::select_id($table,$condition)) {
			return $result;
		}
		else {
			return DB::exists('SELECT * FROM '.($table).' WHERE '.$condition.'');
		}
	}
	static function select_id($table,$condition){
		if($condition and !preg_match('/[^a-zA-Z0-9_#-\.]/',$condition)) {
			if(isset(DB::$db_cache_tables[$table])) {
				$id=$condition;
				$cache_var='cache_'.$table;
				global $$cache_var;
				$cached=isset($$cache_var);
				$data=&$$cache_var;
				if(isset($data[$id])) {
					return $data[$id];
				}
			}
			else {
				return DB::exists_id($table,$condition);
			}
		}
		else {
			return false;
		}
	}
	static function select_all($table,$condition=false,$order=false){       
		if(isset(DB::$db_select_all_db[$table])and!$order and!$condition) {
			return DB::$db_select_all_db[$table];
		}
		elseif(isset($GLOBALS['cache_'.$table])and!$order and!$condition) {
			return $GLOBALS['cache_'.$table];
		}
		else { 
			if($order) {
				$order=' ORDER BY '.$order;
			}
			if($condition) {
				$condition=' WHERE '.$condition;
			}
			DB::query('SELECT * FROM '.($table).' '.$condition.' '.$order);
			$rows=DB::fetch_all();
			if(sizeof($rows)<10) {
				DB::$db_select_all_db[$table]=$rows;
			}
			return $rows;
		}
	}
    static function ConvertTableToArray($array){
        $transposed_array = array();        
        if ($array){            
            foreach($array as $row_key => $row){                
                if (is_array($row) && !empty($row)){                    
                    foreach ($row as $column_key => $element) {
                        $transposed_array[$column_key][strtolower($row_key)] =$element;
                    }
                }
                else {
                    $transposed_array[0][$row_key] = $row;
                }
            }
        }         
        $transposed_array_re = array();  
        if ($transposed_array){
            foreach ($transposed_array as $row_key => $row){                
                $i=0;
                $id=0;
                foreach ($row as $column_key => $element){
                        if ($i==0)
                            $id =$element;
                        else break;
                        $i +=1;        
                }      
                if (is_numeric ($id)) $transposed_array_re[$id]=$row;                
            }
        }       
		return ($transposed_array_re);
    }
	
    static function begin_transaction() {
        $GLOBALS['usingTransaction'] = true;
    }
    static function commit_transaction(){
		$GLOBALS['usingTransaction'] = false;
        if(DB::$db_connect_id and !oci_commit(DB::$db_connect_id)) {
			die(DB::db_error(DB::$db_connect_id));
        }
    }
    static function rollback_transaction() {
		$GLOBALS['usingTransaction'] = false;
		if(DB::$db_connect_id and !oci_rollback(DB::$db_connect_id)) {
          die(DB::db_error(DB::$db_connect_id));
		}
    }
	static function query($query) {
		DB::$db_result = mysql_query($query) or die(mysql_error());
		return false;
	}
	static function exists($query) {
		DB::query($query);
		if($item=DB::fetch() and  sizeof($item)>=1) {
			return $item;
		}
		return false;
	}
	static function exists_id($table,$id) {
		if($id) {
			if(!isset(DB::$db_exists_db[$table][$id])) {
				DB::$db_exists_db[$table][$id]=DB::exists('SELECT * FROM '.($table).' WHERE ID = \''.$id.'\'');
			}
			return DB::$db_exists_db[$table][$id];
		}
	}
	static function insert($table,$values,$replace=false){	
		if($replace) {
			$query='REPLACE';
		}
		else {
			$query='INSERT INTO';
		}
		if(!isset($values['id'])) {
			if($item=DB::fetch('select * from (select '.$table.'.* from '.$table.' order by id DESC) as tb') and isset($item['id'])) {
				$id=$item['id']+1;
			}
			else {
				$id=1;
			}
			$values=array('id'=>$id)+$values;
		}
		$query.=' '.($table).'(';
		$i=0;
		if(is_array($values)) {
			foreach($values as $key=>$value) {
				if(($key===0)or is_numeric($key)) {
					$key=$value;
				}
				if($key) {
					if($i<>0) {
						$query.=',';
					}
					$query.=''.strtoupper($key).'';
					$i++;
				}
			}
			$query.=') VALUES(';
			$i=0;
			foreach($values as $key=>$value) {
				if(is_numeric($key)or $key===0) {
					$value=Url::get($value);
				}
				if($i<>0) {
					$query.=',';
				}
				if($value==='NULL') {
					$query.='NULL';
				}
				else {
					$query.='\''.DB::escape($value).'\'';
				}
				$i++;
			}
			$query.=')';
			if(DB::query($query) and isset($id)) {
				return $id;
			}  
		}
	}
	static function calculate_endtime($start_time, $query) {
		global $log;
		$end_time = microtime();
		$diff_time = $end_time -$start_time;
		if ($diff_time >= .5) {
			$log->info($query,"LONG_QUERY",$diff_time);
		}
	}
	static function delete($table,$condition) {
		$query='DELETE FROM '.($table).' WHERE '.$condition;
		if(DB::query($query)) {
		  return true;
		}
	}
	static function store_temp($table,$id,$temp='temp') {
		if($data=DB::exists_id($table,$id)) {
			$new_data=array('name'=>isset($data['name'])?$data['name']:$data['name_1'],'code'=>$data['id'],'ftable'=>$table,'meta'=>var_export($data,true));
			return DB::insert($temp,$new_data);
		}
		return false;
	}
	static function delete_id($table,$id) {
		return DB::delete($table,'ID=\''.addslashes($id).'\'');
	}
	static function update($table,$values,$condition) {
		$query='UPDATE '.($table).' SET ';
		$i=0;
		if($values) {
			foreach($values as $key=>$value) {
				if($key===0 or is_numeric($key)) {
					$key=$value;
					$value=URL::get($value);
				}			
				if ($key=='icon_url' and strlen($value)==0 )
				{
					
				}
				else 
				{
					if($i<>0) {
						$query.=',';
					}
					if($key) {				  
						if(preg_match("/[id]|[code]|[name]|[title]/i",$key)) {
							$key=String::strip_html_tags($key);
						}
						if($value==='NULL') {
							$query.=''.strtoupper($key).'=NULL';
						}
						else {
							$query.=''.strtoupper($key).'=\''.DB::escape($value).'\'';
						}
						$i++;
					}
				}        
			}
			$query.=' WHERE '.$condition;
			if(DB::query($query)) {
				return true;
			}
		}
	}
	static function update_id($table,$values,$id) {   
		return DB::update($table,$values,'ID=\''.$id.'\'');
	}
	static function affected_rows($query_id=0) {
		if(!$query_id) {
			$query_id=DB::$db_result;
		}
		if($query_id) {
			$result=@oci_num_rows($query_id);
			return $result;
		}
		return false;
	}
	static function fetch($sql=false,$field=false,$default=false) {
		if($sql) {
			DB::query($sql);
		}
		$query_id=DB::$db_result;
		if($query_id) {
			if($result=@mysql_fetch_assoc($query_id)) {
				$result=array_change_key_case($result,CASE_LOWER);
				if($field) {
					return $result[$field];
				}
				return $result;
			}
			return $default;
		}
		else {
			return false;
		}
	}
	static function fetch_all($sql=false) {
		if($sql) {
			DB::query($sql);
		}
		$query_id=DB::$db_result;
		if($query_id) {
			$rows=array();
			while($row=@mysql_fetch_assoc($query_id)) {
				if(isset($row['ID']))
					$rows[$row['ID']]=array_change_key_case($row,CASE_LOWER);
				else
					$rows[$row['id']]=array_change_key_case($row,CASE_LOWER);
			}
			return $rows;
		}
	}
	static function escape($sql) {
		$sql=stripslashes($sql);
		$sql=str_replace("'",'"',$sql);
		return $sql;
	}
	static function num_queries() {
		return DB::$db_num_queries;
	}
	static function structure_id($table,$id) {
		$row=DB::select($table,'id = \''.$id.'\'');
		return $row['structure_id'];
	}
	static function search_cond($table,$field) {
		$cond_st='';
		if(URL::get('search_by_'.$field)) {
			$conds=explode('&',URL::get('search_by_'.$field));
			foreach($conds as $cond) {
				if(preg_match('/[><=]/',URL::get('search_by_'.$field))) {
					$cond_st.='  and  '.$table.'.'.$field.' '.$cond;
				}
				else {
					$cond_st.='  and  '.$table.'.'.$field.' LIKE "%'.$cond.'%"';
				}
			}
		}
		return $cond_st;
	}
	static function get_record_title($item) {
		if(isset($item['name'])) {
			return 'name';
		}
		elseif(isset($item['title'])) {
			return 'title';
		}
		elseif(isset($item['name_'.PageSetting::language()])) {
			return 'name_'.PageSetting::language();
		}
		elseif(isset($item['title_'.PageSetting::language()])) {
			return 'title_'.PageSetting::language();
		}
	}
	static function close(){
		if(isset(DB::$db_connect_id) and DB::$db_connect_id) {
			if(isset(DB::$db_result) and DB::$db_result) {
				@oci_free_statement(DB::$db_result);
			}
			return @oci_close(DB::$db_connect_id);
		}
		return false;
	}
}
require_once 'cache/config/db.php';
$db=new DB();
?>