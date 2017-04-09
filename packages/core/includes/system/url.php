<?php 
class Url {
  static public $root='';
	static function build_all($except=array(),$addition=false) {
		$url=false;
		foreach($_GET as $key=>$value) {
			if(!in_array($key,$except)) {
				if(!$url) {
					$url='?'.urlencode($key).'='.urlencode($value);
				}
				else {
					$url.='&'.urlencode($key).'='.urlencode($value);
				}
			}
		}
		foreach($_POST as $key=>$value) {
			if($key!='form_block_id') {
				if(!in_array($key,$except)) {
					if(is_array($value)) {
						$value='';
					}
					if(!$url) {
						$url='?'.urlencode($key).'='.urlencode($value);
					}
					else {
						$url.='&'.urlencode($key).'='.urlencode($value);
					}
				}
			}
		}
		if($addition) {
			if($url) {
				$url.='&'.$addition;
			}
			else {
				$url.='?'.$addition;
			}
		}
		return $url;
	}
	static function build_current($params=array(),$smart=false,$anchor='') {
		return URL::build(PageSetting::$page['name'],$params,$smart,$anchor);
	}
	static function build($page,$params=array(),$smart=false,$anchor='') {
		if($smart) {
			$request_string='/'.$page;
			if($params) {
			foreach($params as $param=>$value) {
				if(is_numeric($param)) {
					if(isset($_REQUEST[$value])) {
						$request_string.='/'.urlencode($_REQUEST[$value]);
					}
				}
				else {
					if($param=='name') {
						$request_string.='/'.convert_utf8_to_url_rewrite($value);
					}
					else {
						if(preg_match('/page_no/',$param,$matches)) {
							$request_string.='/trang-'.$value;
						}
						else {
							$request_string.='/'.substr($param,0,1).$value;
						}
					}
				}
			}
		}
		$request_string.='.html';
		}
		else {
			$request_string='?page='.$page;
			if($params) {
				foreach($params as $param=>$value) {
					if(is_numeric($param)) {
						if(isset($_REQUEST[$value])) {
							$request_string.='&'.$value.'='.urlencode($_REQUEST[$value]);
						}
					}
					else {
						$request_string.='&'.$param.'='.urlencode($value);
					}
				}
			}
		}  
		return $request_string.$anchor;
	}
	static function build_page($page,$params=array(),$anchor='') {
		return URL::build(PageSetting::get_setting('page_name_'.$page),$params,$anchor);
	}
	static function redirect_current($params=array(),$anchor='') {    
		URL::redirect(PageSetting::$page['name'],$params,$anchor);
	}
	static function redirect_href($params=false) {
		if(Url::check('href')) {
			Url::redirect_url(Url::attach($_REQUEST['href'],$params));
			return true;
		}
	}
	static function check($params) {
		if(!is_array($params)) {
			$params=array(0=>$params);
		}
		foreach($params as $param=>$value) {
			if(is_numeric($param)) {
				if(!isset($_REQUEST[$value])) {
					return false;
				}
			}
			else {
				if(!isset($_REQUEST[$param])) {
					return false;
				}
				else {
					if($_REQUEST[$param]!=$value) {
						return false;
					}
				}
			}
		}
		return true;
	}
	static function check_link($link) {
		if(preg_match('/http:\/\//',$link,$matches)) {
			return $link;
		}
		else {
			return WEB_ROOT.$link;
		}
	}
	static function redirect($page=false,$params=false,$smart=false,$anchor='') {   
		if(!$page and !$params) {   
		  Url::redirect_url();
		}
		else {     
			Url::redirect_url(Url::build($page,$params,$smart,$anchor));
		}
	}
	static function redirect_url($url=false) {
		if(!$url||$url=='') {
			$url='?'.$_SERVER['QUERY_STRING'];
		}
		$fol = explode('/',$_SERVER['PHP_SELF']);
		header('Location:'.str_replace('&','&','http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$fol[1].'/'.Url::$root.$url));
		System::end_conn();
	}
	static function access_denied() {
		if(PageSetting::$page['name']!='home') {
			Url::redirect('access_denied');
		}
		else {
			System::end_conn();
		}
	}
	static function get_num($name,$default='') {
		if(preg_match('/[^0-9.,]/',URL::get($name))) {
			return $default;
		}
		else {
			return str_replace(',','.',str_replace('.','',$_REQUEST[$name]));
		}
	}
	static function get_value($name,$default='') {
		if(isset($_REQUEST[$name])) {
			return $_REQUEST[$name];
		}
		elseif(isset($_POST[$name])) {
			return $_POST[$name];
		}
		elseif(isset($_GET[$name])) {
			return $_GET[$name];
		}
		else {
		  return $default;
		}
	}
	static function get($name,$default='') {    
		if(isset($_REQUEST[$name])) {
			return Url::get_value($name,$default='');
		}
		elseif(isset($_REQUEST[strtoupper($name)])) {
			return Url::get_value(strtoupper($name),$default='');
		}
		elseif(isset($_REQUEST[substr($name,0,1)])) {
			return Url::get_value(substr($name,0,1),$default='');
		}
		else {
			return $default;
		}
	}
	static function sget($name,$default='') {
		return strtr(URL::get($name,$default),array('"'=>'\\"'));
	}
	static function iget($name) {
		if(!is_numeric(Url::sget($name))) {
		return 0;
		}
		else {
			return intval(Url::sget($name));
		}
	}
	static function fget($name) {
		if(!is_numeric(Url::sget($name))) {
			return 0;
		}
		else {
			return floatval(Url::sget($name));
		}
	}
	static function jget($name,$default='') {
		return String::string2js(URL::get($name,$default));
	}
	static function curpageURL() {
        $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
        $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
        $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
        $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
        return $url;
    }
	static function curDomain() {
        $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
        $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
        $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
        $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.'/';
        return $url;
    }
	static function addchar($strvalue,$maxchar) {
       
        $restringvalue=$strvalue;
        for ($i = strlen(utf8_decode($strvalue)); $i < $maxchar; $i++) {
            $restringvalue .=" ";
        }
        return $restringvalue;
    }
	static function addchartotal($strvalue,$maxchar) {       
        $restringvalue=$strvalue;
        $space="";
        for ($i = strlen(utf8_decode($strvalue)); $i < $maxchar; $i++) {
            $space .=" ";
        }
        $restringvalue =$space.$restringvalue;
        return $restringvalue;
    }
}
?>