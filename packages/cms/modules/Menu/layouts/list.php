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
	<!--LIST:categories-->
	<div class="menu-tab" id="tab-[[|categories.id|]]" style="overflow: hidden;float:left;width:100px">
		<div id="subtab-[[|categories.id|]]" style="width: 5000px;">
			<span class="menu-title" id="tab_[[|categories.id|]]"><?php echo PageSetting::language()==1?[[=categories.name_1=]]:[[=categories.name_2=]]; ?></span>
			<div class="menu-section">
                <!--LIST:categories.child-->
                    <!--IF:cond(![[=categories.child.child=]])-->
						<a class="nodecor" href="[[|categories.child.url|]]&amp;#menu_[[|categories.id|]]_[[|categories.child.id|]]">
							<div class="menu-button menu-button-large" id="[[|categories.child.id|]]" onclick="gotoUrl('[[|categories.child.url|]]&amp;#menu_[[|categories.id|]]_[[|categories.child.id|]]')">
								<span class="button-title">
									<?php $title = (PageSetting::language()==1)?[[=categories.child.name_1=]]:[[=categories.child.name_2=]]; 
									echo $title;
									?>
								</span>
							</div>
                        </a>
                    <!--/IF:cond-->
                <!--/LIST:categories.child-->
			</div>
		</div> 
	</div>
	<!--/LIST:categories-->
</div>