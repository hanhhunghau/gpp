<style>
#menu
{
    font-family: "Segoe UI" , Verdana, Tahoma, Helvetica, sans-serif;
    line-height: normal;
    box-sizing: content-box;
	cursor: default;
	font-size: 8pt;
	/*padding-top: 10px;*/
	background-color: #eaedf1;
	border-bottom: 1px solid #8b9097;
	-webkit-box-shadow: #8b9097 0px 1px 3px;
	-moz-box-shadow: #8b9097 0px 1px 3px;
	box-shadow: #8b9097 0px 1px 3px;
	overflow: hidden;
	behavior: url(/PIE.htc);
	z-index: 25;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	height: 50px;
    box-sizing: content-box;
	float:left
}
</style>
<div id="menu">
	<?php if(isset($this->map['categories'])  and  is_array($this->map['categories'])){ foreach($this->map['categories'] as $key1=>&$item1){if($key1!='current'){$this->map['categories']['current'] = &$item1;?>
	<div class="menu-tab" id="tab-<?php echo $this->map['categories']['current']['id'];?>" style="overflow: hidden;float:left;width:100px">
		<div id="subtab-<?php echo $this->map['categories']['current']['id'];?>" style="width: 5000px;">
			<span class="menu-title" id="tab_<?php echo $this->map['categories']['current']['id'];?>"><?php echo PageSetting::language()==1?$this->map['categories']['current']['name_1']:$this->map['categories']['current']['name_2']; ?></span>
			<div class="menu-section">
                <?php if(isset($this->map['categories']['current']['child'])  and  is_array($this->map['categories']['current']['child'])){ foreach($this->map['categories']['current']['child'] as $key2=>&$item2){if($key2!='current'){$this->map['categories']['current']['child']['current'] = &$item2;?>
                    <?php  
                if((!$this->map['categories']['current']['child']['current']['child'])) 
                {?>
						<a class="nodecor" href="<?php echo $this->map['categories']['current']['child']['current']['url'];?>&amp;#menu_<?php echo $this->map['categories']['current']['id'];?>_<?php echo $this->map['categories']['current']['child']['current']['id'];?>">
							<div class="menu-button menu-button-large" id="<?php echo $this->map['categories']['current']['child']['current']['id'];?>" onclick="gotoUrl('<?php echo $this->map['categories']['current']['child']['current']['url'];?>&amp;#menu_<?php echo $this->map['categories']['current']['id'];?>_<?php echo $this->map['categories']['current']['child']['current']['id'];?>')">
								<span class="button-title">
									<?php $title = (PageSetting::language()==1)?$this->map['categories']['current']['child']['current']['name_1']:$this->map['categories']['current']['child']['current']['name_2']; 
									echo $title;
									?>
								</span>
							</div>
                        </a>
                     
                <?php 
                } 
                ?>
                <?php }}unset($this->map['categories']['current']['child']['current']);} ?>
			</div>
		</div> 
	</div>
	<?php }}unset($this->map['categories']['current']);} ?>
</div>