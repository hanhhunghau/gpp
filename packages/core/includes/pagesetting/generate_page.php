<?php 
/******************************
COPY RIGHT BY EZ SOLUTION
WRITTEN BY DUNGNN
******************************/
if(!DB::exists('select * from page where name=\''.Url::get('page').'\''))
{
	Url::redirect('home');
}
require_once 'page_layout.php';

class Generatepage
{
	var $regions = array();
	var $modules = array();
	var $blocks = array();
	/**
	 * Generatepage::Generatepage()
	 * 
	 * @param mixed $row
	 * @return void
	 */
	function Generatepage($row)
	{
		$this->data = $row;
		require_once 'cache/language_'.PageSetting::language().'.php';
	}
	/**
	 * Generatepage::generate()
	 * 
	 * @param bool $return
	 * @return
	 */
	function generate($return =false)
	{
	  
		$code = '';
		$code .= $this->generate_text();
		
    
        $cache_file=ROOT_PATH.'cache/page_layouts/'.$this->data['name'].'.cache.php';
	
		if($fp = @fopen($cache_file, 'w+'))
		{
			fwrite ($fp, $code );
			fclose($fp);
			if($return)
			{
				ob_start();
			}
			require_once $cache_file;
			if($return)
			{
				$st = ob_get_contents();
				ob_end_clean();
				return $st;
			}
		}
		else
		{
			eval('?>'.$code.'<?php ');
		}
	}
	/**
	 * Generatepage::generate_text()
	 * 
	 * @return
	 */
	function generate_text()
	{
		$code='<?php
            Module::invoke_event(\'ONLOAD\',System::$false,System::$false);
            global $blocks;
            global $plugins;
            $plugins = ';
		$this->plugins = DB::select_all('module','type = \'PLUGIN\'');
		$code .= var_export($this->plugins,true);
		$code.=';$blocks = ';
		$this->blocks = DB::select_all('block','page_id = '.$this->data['id'],'container_id,position asc');
		foreach($this->blocks as $id=>$block)
		{
			$this->blocks[$id]['settings'] = '';
			$this->blocks[$id]['module'] = DB::fetch('select id, name, path, type,package_id from module where id=\''.$block['module_id'].'\'');
			if($this->blocks[$id]['module']['type'] == 'WRAPPER')
			{
				$this->blocks[$id]['wrapper'] = '';
			}
		}	
		$code .= var_export($this->blocks,true).';
		PageSetting::$page = '.var_export($this->data,true).';
		foreach($blocks as $id=>$block)
		{
			if($block[\'module\'][\'type\'] == \'WRAPPER\')
			{
				require_once $block[\'wrapper\'][\'path\'].\'class.php\';
				$blocks[$id][\'object\'] = new $block[\'wrapper\'][\'name\']($block);
				if(URL::get(\'form_block_id\')==$id)
				{
					$blocks[$id][\'object\']->submit();
				}
			}
			else
			if($block[\'module\'][\'type\'] != \'HTML\' and $block[\'module\'][\'type\'] != \'CONTENT\' and $block[\'module\'][\'name\'] != \'HTML\')
			{
				require_once $block[\'module\'][\'path\'].\'class.php\';
				$blocks[$id][\'object\'] = new $block[\'module\'][\'name\']($block);
				if(URL::get(\'form_block_id\')==$id)
				{
					$blocks[$id][\'object\']->submit();
				}
			}
		}
		require_once \'packages/core/includes/utils/draw.php\';
		?>';
		$filename = ROOT_PATH.'packages/core/includes/pagesetting/header.php';
		$fp = fopen($filename, 'r');
		$code .= fread($fp,filesize($filename));
		fclose($fp);
		
		$text = file_get_contents($this->data['layout']);
		//DB::fetch('select content from layout where id="'.$this->data['layout_id'].'"','content');
		while(($pos=strpos($text,'[[|'))!==false)
		{
			$code .= substr($text, 0,  $pos);
			$text = substr($text, $pos+3,  strlen($text)-$pos-3);
			if(preg_match('/([^\|]*)/',$text, $match))
			{
				if(isset($match[1]))
				{
					$code .= $this->generate_region($match[1]);
				}
				if(($pos = strpos($text,'|]]',0))!==false)
				{
					$text = substr($text, $pos+3,  strlen($text)-$pos-3);
				}
			}
			else
			{
				break;
			}
		}
		$code .= $text;
		
		$filename = ROOT_PATH.'packages/core/includes/pagesetting/footer.php';
		$fp = fopen($filename, 'r');
		$code .= fread($fp,filesize($filename));
		$code .= '<?php Module::invoke_event(\'ONUNLOAD\',System::$false,System::$false);?>';
		fclose($fp);
		return $code;
	}
	/**
	 * Generatepage::generate_region()
	 * 
	 * @param mixed $region
	 * @return
	 */
	function generate_region($region)
	{
		$code = '';
		foreach($this->blocks as $id=>$block)
		{			
			if($block['region']==$region and $block['container_id'] == 0)
			{
				if($block['module']['type'] == 'HTML')
				{
					$code .= $this->generate_module_html($id,$block['module']);
				}
				else
				if($block['module']['type'] == 'CONTENT')
				{
					$code .= $this->generate_module_content($id,$block['module']);
				}
				else
				{
					
$code .= '
<?php $blocks['.$id.'][\'object\']->on_draw();?>';
				}
			}
		}
		return $code;
	}
	/**
	 * Generatepage::generate_module_html()
	 * 
	 * @param mixed $block_id
	 * @param mixed $module
	 * @return
	 */
	function generate_module_html($block_id,$module)
	{
		$module_data = DB::select('module',$module['id']);
		$code = '
		<?php 
		$blocks['.$block_id.'][\'object\'] = new Module($blocks['.$block_id.']);
		Module::$current=&$blocks['.$block_id.'][\'object\'];
		echo \'<div id="module_'.$block_id.'">\';
		
		Module::invoke_event(\'ONDRAW\',$blocks['.$block_id.'][\'object\'],System::$false);';
		$results = $this->convert_language($module['id'],$module_data['layout']);
		$code .= '
?>'.$results.'<?php
		Module::invoke_event(\'ONDRAW\',$blocks['.$block_id.'][\'object\'],System::$false);';
		$code .='echo \'</div>\';
		Module::$current=&System::$false;
?>';
		
		return $code;
	}
	function generate_module_content($block_id, $module)
	{
		$module_data = DB::select('module',$module['id']);
		$code = '';
		$code = '
		<?php 
		$blocks['.$block_id.'][\'object\'] = new Module($blocks['.$block_id.']);
		echo \'<div id="module_'.$block_id.'">\';
		Module::$current = &$blocks['.$block_id.'][\'object\'];';

				require_once 'packages/core/includes/pagesetting/generate_layout.php';
				$generate_layout = new GenerateLayout($module_data['layout']);
				$layout = str_replace('$this->map','$map',$generate_layout->generate_text($generate_layout->synchronize())); 
				//if(!$row['is_cached'])
				$results = $this->convert_language($module['id'],$layout);
				$code.=' 
					$map = array(\'content_name\'=>\''.$module['name'].'\');$ok=true;'.$module_data['code'].' 
					if($ok){
				Module::invoke_event(\'ONDRAW\',$blocks['.$block_id.'][\'object\'],System::$false);';
				$code.='?>'.$results.'<?php 
				Module::invoke_event(\'ONENDDRAW\',$blocks['.$block_id.'][\'object\'],System::$false);';
				$code.=' }';
				$code .='echo \'</div>\';
		Module::$current=&System::$false;
?>';
			
		return $code;
	}
	/**
	 * Generatepage::convert_language()
	 * 
	 * @param mixed $module_id
	 * @param mixed $layout
	 * @return
	 */
	function convert_language($module_id, $layout)
	{
		return preg_replace('/\[\[\.(\w+)\.\]\]/','<?php echo PageSetting::language(\'\\1\');?>',$layout);
	}
}
?>