<?php 
class System{
    static function json_encode($obj) {
        if (phpversion()=='5.2.5')
        {
            return json_encode($obj);
        }
        else 
        {
            return json_encode($obj, 512);
        }
    }
	static $false = false;
	static function send_mail($from,$to,$subject,$content){
		if(!class_exists('PHPMailer'))
		{
			require(ROOT_PATH.'packages/core/includes/utils/mailer/class.phpmailer.php');
		}	
		$mail = new PHPMailer();		
		$mail->IsSMTP();
		$mail->SetLanguage("vn", "");
		$mail->Host     = "gmail.com";
		$mail->SMTPAuth = true;
		$mail->Username = "abc@gmail.com";
		$mail->Password = "123456";		
		$mail->From     = "admin@gmail.com";
		$mail->FromName = "Admin";
		$mail->AddAddress($to,"");
		$mail->AddReplyTo($from,"Information");		
		$mail->IsHTML(true);		
		$mail->Subject  =  $subject;
		$mail->Body     =  $content;
		if(!$mail->Send())
		{
		   echo "Email loi! <p>";
		   echo "Loi: " . $mail->ErrorInfo;
		   exit;
		}
		else
		{
			return true;
		}
	}	
	static function end_conn(){
		Session::end();
		DB::close();
		exit();
	}
	static function add_meta_tag($tags){
		global $meta_tags;
		if(isset($meta_tags))
		{
	 		$meta_tags.=$tags;
		}
		else
		{
			$meta_tags=$tags;
		}
	}
	static function display_number($num){
		$num = $num?$num:0;
        $chnum =0;
        if($num<0){$chnum =1; $num = abs($num);}
		if($num==round($num))
		{
			if($chnum == 1){
				return '-'.number_format($num,0,'.',',');  
			}else{
				return number_format($num,0,'.',',');
			}			
		}
		else
		{
			if($chnum == 1){
		      	return '-'.number_format($num,2,'.',',');
			}else{
		      	return number_format($num,2,'.',',');
			}		
		}
	}
	static function debug($array){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
	static function array2list($items, $field_name=false){		
		$item_list = array();
		foreach($items as $item)
		{	
			if(!$field_name)
			{
				$field_name=isset($item['name'])?'name':(isset($item['title'])?'title':(isset($item['name_'.PageSetting::language()])?'name_'.PageSetting::language():(isset($item['title_'.PageSetting::language()])?'title_'.PageSetting::language():'id')));
			}
			if(isset($item['structure_id']))
			{
				$level = IDStructure::level($item['structure_id']);
				for($i=0;$i<$level;$i++)
				{
					$item[$field_name] = ' --- '.$item[$field_name];
				}
			}
			$item_list[$item['id']]=isset($item[$field_name])?$item[$field_name]:'';
		}
		return $item_list;
	}
	
}
class String{
	static function bodau ($str){
		$TViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
			"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ", 
			"ì","í","ị","ỉ","ĩ", 
			"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ", 
			"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ", 
			"ỳ","ý","ỵ","ỷ","ỹ", 
			"đ", 
			"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă" 
			,"Ằ","Ắ","Ặ","Ẳ","Ẵ", 
			"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ", 
			"Ì","Í","Ị","Ỉ","Ĩ", 
			"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ" 
			,"Ờ","Ớ","Ợ","Ở","Ỡ", 
			"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ", 
			"Ỳ","Ý","Ỵ","Ỷ","Ỹ", 
			"Đ"," ");  
		$KoDau=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a", 
			"e","e","e","e","e","e","e","e","e","e","e", 
			"i","i","i","i","i", 
			"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o", 
			"u","u","u","u","u","u","u","u","u","u","u", 
			"y","y","y","y","y", 
			"d", 
			"A","A","A","A","A","A","A","A","A","A","A","A" 
			,"A","A","A","A","A", 
			"E","E","E","E","E","E","E","E","E","E","E", 
			"I","I","I","I","I", 
			"O","O","O","O","O","O","O","O","O","O","O","O" 
			,"O","O","O","O","O", 
			"U","U","U","U","U","U","U","U","U","U","U", 
			"Y","Y","Y","Y","Y", 
			"D"," "); 
		$str=str_replace($TViet,$KoDau,$str); 
		return $str; 
	}
	static function convert_money_to_str_vnd($number) {
		$number =  number_format($number,0,'','');
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'Âm ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'Không',
            1                   => 'Một',
            2                   => 'Hai',
            3                   => 'Ba',
            4                   => 'Bốn',
            5                   => 'Năm',
            6                   => 'Sáu',
            7                   => 'Bảy',
            8                   => 'Tám',
            9                   => 'Chín',
            10                  => 'Mười',
            11                  => 'Mười một',
            12                  => 'Mười hai',
            13                  => 'Mười ba',
            14                  => 'Mười bốn',
            15                  => 'Mười năm',
            16                  => 'Mười sáu',
            17                  => 'Mười bảy',
            18                  => 'Mười tám',
            19                  => 'Mười chín',
            20                  => 'Hai mươi',
            30                  => 'Ba mươi',
            40                  => 'Bốn mươi',
            50                  => 'Năm mươi',
            60                  => 'Sáu mươi',
            70                  => 'Bảy mươi',
            80                  => 'Tám mươi',
            90                  => 'Chín mươi',
            100                 => 'trăm',
            1000                => 'ngàn',
            1000000             => 'triệu',
            1000000000          => 'tỷ',
            1000000000000       => 'nghìn tỷ',
            1000000000000000    => 'ngàn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );
        
        if (!is_numeric($number)) {
            return false;
        }        
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			trigger_error(
				'convert_money_to only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
        }        
        if ($number < 0) {
            return $negative . System::convert_money_to_str_vnd(abs($number));
        }        
        $string = $fraction = null;        
        if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
        }        
        switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . System::convert_money_to_str_vnd($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = System::convert_money_to_str_vnd($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= System::convert_money_to_str_vnd($remainder);
				}
				break;
        }        
        if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}        
        return $string;       
	}
	static function html_normalize($st){
		return str_replace(array('"','<'),array('&quot;','&lt;'),$st);
	}
	static function removeEmailAndPhone($string){
    	$string = preg_replace('/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/','',$string);
    	$string = preg_replace('/([0-9]+[\- ]?[0-9]+)/','',$string);
    	return $string;
    }
	static function string2js($st){
		return strtr($st, array('\''=>'\\\'','\\'=>'\\\\','\n'=>'',chr(10)=>'\\',chr(13)=>''));
	}
	static function array2js($array){
		$st = '{';
		foreach($array as $key=>$value)
		{
			if($st!='{')
			{
				$st.=',';
			}
			$st.='\''.String::string2js($key).'\':';
			if(is_array($value))
			{
				$st .= String::array2js($value);
			}
			else
			{
				$st .= '\''.String::string2js($value).'\'';
			}
		}
		return $st.'}';
	}
	static function array2suggest($array){
		$st = '[';
		$i = 0;
		$size_of_array = sizeof($array);
		foreach($array as $key=>$value)
		{
			$st.='{';
			if(isset($value['name']))
			{
				$st.='name:"'.String::string2js($value['name']).'",to:"'.$key.'", id:"'.$key.'"';
			}
			else
			{
				$st.='name:"'.$key.'",to:"'.$key.'", id:"'.$key.'"';
			}
			$i++;
			if($i==$size_of_array)
			{
				$st.='}';
			}
			else
			{
				$st.='},';
			}
		}
		$st.= ']';
		return $st;
	}
	static function array2tree(&$items,$items_name){
		$show_items = array();
		$min = -1;
		foreach($items as $item)
		{
			if($min==-1)
			{
				$min = IDStructure::level($item['structure_id']);
			}
			$structure_ids[number_format($item['structure_id'],0,'','')] = $item['id'];
			if(IDStructure::level($item['structure_id'])<=$min)
			{
				$show_items[$item['id']] = $item+(isset($item['childs'])?array():array($items_name=>array()));
			}
			else
			{
				$st = '';
				$parent = $item['structure_id'];
				
				while(($level=IDStructure::level($parent = IDStructure::parent($parent)))>=$min and $parent and isset($structure_ids[number_format($parent,0,'','')]))
				{					
					$st = '['.$structure_ids[number_format($parent,0,'','')].'][\''.$items_name.'\']'.$st;
				}
				if($level<$min or $level==0)
				{
					eval('$show_items'.$st.'['.$item['id'].'] = $item+array($items_name=>array());');
				}
			}
		}
		return $show_items;
	}
	static function array2autosuggest($array){
		$st = '[';
		$i = 0;
		$size_of_array = sizeof($array);
		foreach($array as $key=>$value)
		{
			$st.='{';
			$f = true;
			foreach($value as $k=>$v){
				if($f){ $f = false; }else{ $st .= ',';}
				$st .= $k.':"'.$v.'"';
			}
			$i++;
			if($i==$size_of_array)
			{
				$st.='}';
			}else{
				$st.='},';
			}
		}
		$st.= ']';
		return $st;
	}
	static function str_to_number($st)	{
		return str_replace(',','',$st);
	}
	static function to_number($st,$count=0)	{
		$temp = substr($st,$count);
		$n = 0;
		for($i=0;$i<strlen($temp);$i++)
		{
			$n = $n*10 + $temp[$i]; 
		}
		return $n;
	}
	static function money_vnd_round($number,$precision=500){
		$number = intval($number,0);
		$pre_len = strlen($precision);
		$result = 0;
		if($number<=$precision){
			return 0;
		}else{
			$new_number = (substr($number,0,-$pre_len));
			$tail = intval(substr($number,-$pre_len,strlen($number)-1));
			$tail_pad = intval(str_pad(1,$pre_len+1,0));
			if($tail >= $precision){
				$new_number = $new_number + 1;	
			}
			$rerult = $new_number*$tail_pad;
			return $rerult;
		}
	}
	static function strip_html_tags( $text ){
		$text = preg_replace(
			array(
			  // Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
			  // Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),
			$text );
		return strip_tags( $text );
	}
}
class Date_Time{
	static function udate($time){
		$pos = strpos($time,'.');
		if($pos){
			$microsecond = substr($time,$pos+1,6);
		}else{
			$microsecond = 000000;
		}
		$time = Date_Time::to_en_date(date('d/m/Y',$time)).' '.date('h.i.s',$time).'.'.$microsecond.' '.date('A',$time);
		return $time;
	}
	static function sudate($time){
		$pos = strpos($time,'.');
		if($pos){
			$microsecond = substr($time,$pos+1,6);
		}else{
			$microsecond = 000000;
		}
		$time = Date_Time::to_en_date(date('d/m/Y',$time)).' '.date('h:i:s',$time);
		return $time;
	}
    static function to_en_date($date){
		if($date){
			$month = array(1=>"JAN",2=>"FEB",3=>"MAR",4=>"APR",5=>"MAY",6=>"JUN",7=>"JUL",8=>"AUG",9=>"SEP",10=>"OCT",11=>"NOV",12=>"DEC");
			$a = explode('/',$date);		
			if(is_numeric($a[1]) and is_numeric($a[2]) and is_numeric($a[0]) and checkdate($a[1],$a[0],$a[2]))
			{
				if(intval($a[0])<10)
				{
					$a[0] = "0".intval($a[0]);
				}
				return $a[0].'-'.$month[intval($a[1])].'-'.$a[2];
			}
			else
			{
				return false;
			}
		}else{
			return false;
		}
	}
	static function convert_time_to_en_date($time=0){
		if($time)
		{
			return Date_Time::to_en_date(date('d/m/Y',$time));
		}
		else
		{
			return Date_Time::to_en_date(date('d/m/Y'));
		}
	}
	static function convert_en_date_to_date2($date,$spe = "-"){
		if($date){
			$month = array("JAN"=>"01","FEB"=>"02","MAR"=>"03","APR"=>"04","MAY"=>"05","JUN"=>"06","JUL"=>"07","AUG"=>"08","SEP"=>"09","OCT"=>"10","NOV"=>"11","DEC"=>"12");
			$a = explode("-",$date);
			if(is_array($a) and isset($month[$a[1]]))
			{
				if(intval($a[0])<10)
				{
					$a[0] = "0".intval($a[0]);
				}
				return $a[0].$spe.$month[$a[1]].$spe.$a[2];
			}			
		}
		return false;
	}
	static function convert_en_date_to_date( $date ){
		return date('d/m/Y',strtotime( $date ) );
	}
	static function to_sql_date($date){
		$a = explode('/',$date);
		if(sizeof($a)==3 and is_numeric($a[1]) and is_numeric($a[2]) and is_numeric($a[0]) and checkdate($a[1],$a[0],$a[2]))
		{
			return ($a[0].'-'.$a[1].'-'.$a[2]);
		}
		else
		{
			return false;
		}
	}
	static function to_time($date){	  
		if(preg_match('/(\d+)\/(\d+)\/(\d+)\s*(\d+)\:(\d+)/',$date,$patterns))
		{
			return strtotime($patterns[2].'/'.$patterns[1].'/'.$patterns[3])+$patterns[4]*3600+$patterns[5]*60;
		}
		else
		{
			$a = explode('/',$date);
			if(sizeof($a)==3 and is_numeric($a[1]) and is_numeric($a[2]) and is_numeric($a[0]) and checkdate($a[1],$a[0],$a[2]))
			{
				return strtotime($a[1].'/'.$a[0].'/'.$a[2]);
			}
			else
			{
				return false;
			}		
		}
	}
	static function daily($time){
		$daily=(getdate($time));
		return $daily['weekday'];
	}
	static function day_of_month($month,$year){
		return cal_days_in_month(CAL_GREGORIAN,$month,$year); 
	}
	static function count_hour($from,$to){
		if($from>=$to){
			return '';
		}else{
			$sub = $to - $from;
			$duration = 0;
			if($sub>=3600){
				$duration = floor($sub/3600).'h ';
				if(($sub%3600)>=60){
					$duration .= ':'.floor(($sub%3600)/60).'\'';
				}
			}else{
				$duration = '0h:'.floor($sub%60).'\'';
			}
			return $duration;
		}
	}
	static function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){
		if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
		if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);
		$diff = date_diff( $dt_menor, $dt_maior, ! $relative);       
		switch( $str_interval){
			case "y": 
				$total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
			case "m":
				$total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
				break;
			case "d":
				$total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
				break;
			case "h": 
				$total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
				break;
			case "i": 
				$total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
				break;
			case "s": 
				$total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
				break;
		}
		if( $diff->invert)
			return -1 * $total;
		else    return $total;
	}
	static function validateDate( $date, $format='DD/MM/YYYY'){
        switch( $format )
        {
            case 'YYYY/MM/DD':
            case 'YYYY-MM-DD':
            list( $y, $m, $d ) = preg_split( '/[-\.\/ ]/', $date );
            break;
            case 'YYYY/DD/MM':
            case 'YYYY-DD-MM':
            list( $y, $d, $m ) = preg_split( '/[-\.\/ ]/', $date );
            break;
            case 'DD-MM-YYYY':
            case 'DD/MM/YYYY':
            list( $d, $m, $y ) = preg_split( '/[-\.\/ ]/', $date );
            break;
            case 'MM-DD-YYYY':
            case 'MM/DD/YYYY':
            list( $m, $d, $y ) = preg_split( '/[-\.\/ ]/', $date );
            break;
            case 'YYYYMMDD':
            $y = substr( $date, 0, 4 );
            $m = substr( $date, 4, 2 );
            $d = substr( $date, 6, 2 );
            break;
            case 'YYYYDDMM':
            $y = substr( $date, 0, 4 );
            $d = substr( $date, 4, 2 );
            $m = substr( $date, 6, 2 );
            break;
            default:
            throw new Exception( "Invalid Date Format" );
        }
        return checkdate( $m, $d, $y );
    }
}
class Type {
	var $required=false;
	var $error=false;
	var $message=false;
	var $name=false;
	var $constrain_column=false;
	var $constrain_value=false;
	function Type($required=false,$message='error') {
		$this->required=$required;
		$this->message=$message;
	}
	function get_message() {
		return PageSetting::language($this->message);
	}
	function check($value) {
		$this->error=false;
		if($this->required and $value=='') {
			$this->error=$this->message;
		}
		return !$this->error;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"text","require":'.($this->required?1:0).',"min":0,"max":255}';
	}
	
}
class TextType extends Type {
	var $min_len=0;
	var $max_len=0;
	function TextType($required=false,$messages=false,$min_len,$max_len,$constrain_column=false,$constrain_value=false) {
		Type::Type($required,$messages);
		$this->min_len=$min_len;
		$this->max_len=$max_len;
		$this->constrain_column=$constrain_column;
		$this->constrain_value=$constrain_value;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"text","require":'.($this->required?1:0).',"min":'.$this->min_len.',"max":'.$this->max_len.'}';
	}
	function check($value) {
		if(Type::check($value)&&$value!='') {
			$len=strlen($value);
			if($len<$this->min_len) {
				$this->error=$this->message;
			}
			elseif($len>$this->max_len) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class SelectType extends TextType {
	function SelectType($required=false,$messages=false,$values) {
		TextType::TextType($required,$messages,0,1000);
		$this->values=$values;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"text","require":'.($this->required?1:0).',"min":'.$this->min_len.',"max":'.$this->max_len.'}';
	}
	function check($value) {
		if(Type::check($value)) {
			if(!in_array($value,array_keys($this->values))) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class NameType extends TextType {
	function NameType($required=true,$messages=false,$min=2,$max=50) {
		TextType::TextType($required,$messages,$min,$max);
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"name","require":'.($this->required?1:0).',"min":'.$this->min_len.',"max":'.$this->max_len.'}';
	}
	function check($value) {
		if(TextType::check($value)&&$value!='') {
			if(preg_match('/[^A-Za-z0-9_]/',$value)) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class PasswordType extends TextType {
	function PasswordType($required=true,$messages=false,$min=0,$max=32) {
		TextType::TextType($required,$messages,$min,$max);
	}
}
class RetypePasswordType extends PasswordType {
	function RetypePasswordType($required=true,$messages=false,$min=0,$max=32) {
		PasswordType::PasswordType($required,$messages,$min,$max);
	}
	function check($value) {
		if(PasswordType::check($value)&&$value!='') {
			if(URL::get('password') and URL::get('password')!=$value) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class UsernameType extends NameType {
	function UsernameType($required=true,$messages=false) {
		NameType::NameType($required,$messages,2,64);
	}
	function check($value) {
		return NameType::check($value);
	}
}
class EmailType extends TextType {
	function EmailType($required=true,$messages=false) {
		TextType::TextType($required,$messages,5,150);
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"email","require":'.($this->required?1:0).',"min":'.$this->min_len.',"max":'.$this->max_len.'}';
	}
	function check($value) {
		if(TextType::check($value)&&$value!='') {
			if(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$",$value)) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class DateType extends TextType {
	var $min='1/1/1900';
	var $max='1/1/2030';
	function DateType($required=false,$messages=false,$min='1/1/1900',$max='1/1/2030') {
		TextType::TextType($required,$messages,6,15);
		$this->min=$min;
		$this->max=$max;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"date","require":'.($this->required?1:0).'}';
	}
	function check($value) {
		if(TextType::check($value)&&$value!='') {
			$params=explode('/',$value);
			if(sizeof($params)!=3or!ctype_digit($params[0])or!ctype_digit($params[1])or!ctype_digit($params[2])or$params[0]<1or$params[1]<1or$params[2]<1800or$params[0]>31or$params[1]>12or$params[2]>2800) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class PhoneType extends TextType {
	function PhoneType($required=false,$messages=false,$min=6,$max=11) {
		TextType::TextType($required,$messages,$min,$max);
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"phone","require":'.($this->required?1:0).',"min":6,"max":11}';
	}
	function check($value) {
		if(TextType::check($value)&&$value!='') {
			if(preg_match('/[^0-9_, ]/',$value)) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class FloatType extends Type {
	var $min=0;
	var $max=0;
	function FloatType($required=false,$messages=false,$min=0,$max=1000000000,$constrain_column=false,$constrain_value=false) {
		Type::Type($required,$messages);
		$this->min=$min;
		$this->max=$max;
		$this->constrain_column=$constrain_column;
		$this->constrain_value=$constrain_value;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"float","require":'.($this->required?1:0).',"min":'.$this->min.',"max":'.$this->max.'}';
	}
	function check($value) {
		$value=str_replace(',','',$value);
		if(Type::check($value)&&$value!='') {
			if(!is_numeric($value) or $value<$this->min or $value>$this->max or preg_match('/[^0-9\.-]/',$value)) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class IntType extends FloatType {
	function IntType($required=false,$messages=false,$min=0,$max=9999,$constrain_column=false,$constrain_value=false) {
		FloatType::FloatType($required,$messages,$min,$max);
		$this->constrain_column=$constrain_column;
		$this->constrain_value=$constrain_value;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"int","require":'.($this->required?1:0).',"min":'.$this->min.',"max":'.$this->max.'}';
	}
	function check($value) {
		$value=str_replace(',','',$value);
		if(FloatType::check($value)&&$value!='') {
			if(floor($value)<>$value or preg_match('/[^0-9-]/',$value)) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class IDType extends NameType {
	var $table=false;
	function IDType($required=false,$messages=false,$table='',$field='ID') {
		NameType::NameType($required,$messages,1,50);
		$this->table=$table;
		$this->field=$field;
	}
	function to_js_data($name,$word) {
		return '{"name":"'.$name.'","message":"'.addslashes($word).'","type":"name","require":'.($this->required?1:0).',"min":'.$this->min_len.',"max":'.$this->max_len.'}';
	}
	function check($value) {
		$value=str_replace(',','',$value);
		if(TextType::check($value)&&$value!='') {
			if(!DB::exists('SELECT ID FROM '.$this->table.' WHERE '.$this->field.'=\''.$value.'\'')) {
				$this->error=$this->message;
			}
		}
		return !$this->error;
	}
}
class UniqueType extends Type {
	var $table=false;
	var $field=false;
	function UniqueType($require,$messages=false,$table,$field,$table_cond='') {
		Type::Type($require,$messages);
		$this->table=$table;
		$this->field=$field;
		$this->table_cond=$table_cond;
	}
	function check($value) {
		if(Type::check($value)&&$value!='') {
			$cond='';
			if(isset($_REQUEST['id'])&&$_REQUEST['id'] and ($this->table)!='account') {
				$cond='ID<> \''.$_REQUEST['id'].'\'  and  ';
			}
			if($this->table_cond) {
				$cond.=$this->table_cond.'  and  ';
			}
			$sql='SELECT ID FROM '.($this->table).' WHERE '.$cond.' '.strtoupper($this->field).'=\''.DB::escape($value).'\'';
			if(DB::exists($sql)) {
				$this->error=$this->message;
			}
			else {
				return !$this->error;
			}
		}
	}
}
?>