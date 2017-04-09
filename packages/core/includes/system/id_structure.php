<?php 
define('ID_BASE',100.0);
//So ban ghi toi da o cung mot cap thuoc mot goc
define('ID_MAX_LEVEL',9);
//So level toi da
define('ID_ROOT',"1000000000000000000");
//ID goc
//Tap hop cac ham thao tac voi cac bang co ID co cau truc cay
class IDStructure {
  static function have_child($table,$structure_id,$extra_cond='',$database=false) {
    return DB::select($table,IDStructure::child_cond($structure_id,true).$extra_cond);
  }
  //Tra ve structure_id cha cua $structure_id
  //$structure_id: structure_id can tinh
  static function parent($structure_id) {
    if($structure_id==ID_ROOT) {
      return false;
    }
    else {
      $level=IDStructure::level($structure_id);
      $structure_id=number_format($structure_id,0,'','').'';
      if($level!=0) {
        $structure_id {
          $level*2-1
        }='0';
        $structure_id {
          $level*2
        }='0';
      }
	  if($structure_id>=1000000000000000000)
	  {
		$structure_id = ($structure_id/1000000000000000000).'e18';
		return $structure_id;
	  }		  
      else return number_format($structure_id,0,'','');
    }
  }
  //Tra ve level cua $structure_id
  //$structure_id: structure_id can tinh
  static function level($structure_id) {
    $level=0;
    if($structure_id>=ID_ROOT) {
      $i=0;
      $st='_'.number_format($structure_id,0,'','');
      while(substr($st,$level*2,2)!='00') {
        $level++;
      }
      $level--;
    }
    return $level;
  }
  //Tra ve structure_id ke sau cua $structure_id
  //$structure_id: structure_id can tinh
  static function next($structure_id) {
    return number_format($structure_id+pow(ID_BASE,ID_MAX_LEVEL-IDStructure::level($structure_id)),0,'','');
  }
  //Kiem tra $structure_id co phai la con cua $parent_id khong
  //$structure_id: structure_id con
  //$parent_id: structure_id cha
  static function is_child($structure_id,$parent_id) {
    return $structure_id>$parent_id and $structure_id<IDStructure::next($parent_id);
  }
  //Tra ve dieu kien de truy van ra duong dan cua idstruture, tu con den cha
  static function path_cond($structure_id) {
    $path=$structure_id;
    while($structure_id=IDStructure::parent($structure_id)) {
      $path.=','.$structure_id;
    }
    return '(instr(structure_id,'.$path.')>0)';
  }
  //Tra ve bieu thuc dieu kien truy van tat ca con cua $id
  //$structure_id: can tinh dieu kien
  //$except_me: co loai tru chinh $structure_id nay khong
  static function child_cond($structure_id,$except_me=false,$extra='') {
    if($except_me) {
      return '('.$extra.'structure_id > '.$structure_id.'  and  '.$extra.'structure_id < '.IDStructure::next($structure_id).')';
    }
    else {
      return '('.$extra.'structure_id >= '.$structure_id.'  and  '.$extra.'structure_id < '.IDStructure::next($structure_id).')';
    }
  }
  //Tra ve bieu thuc dieu kien truy van tat ca con truc tiep cua $id (truc tiep nghia la co level = level ($structure_id)-1)
  //$structure_id: can tinh dieu kien
  static function direct_child_cond($structure_id,$child_level=1) {
    $level=IDStructure::level($structure_id);
    $child_offset=number_format(pow(ID_BASE,ID_MAX_LEVEL-($level+$child_level)),0,'','');
    return '('.IDStructure::child_cond($structure_id,true).') ';
  }
}
?>