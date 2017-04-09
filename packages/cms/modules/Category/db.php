<?php
class CategoryDB
{	
	function GetZone($structure_id='1010000000000000000')
	{
		return DB::fetch_all('
			SELECT
				*
			FROM
				zone 
			WHERE
				'.IDStructure::direct_child_cond($structure_id,true).'	
			ORDER BY
				structure_id		
		');	
	}	
	static function check_categories($categories)
	{
		foreach($categories as $id=>$category)
		{
			//if(!User::can_view(false,$category['structure_id']))
			{
				//unset($categories[$id]);
			}
		}
		return $categories;
	}
	static function get_categories($cond = false)
	{
		return DB::fetch_all('select category.* from category where structure_id <>'.ID_ROOT.' '.($cond?' AND '.$cond:'').' order by structure_id');
	}
}
?>