<?php
class Domenia3n
{
	function dbconnect()
	{
		$dbhost="localhost";
		$dbuser="adminhdd_domenia3n";
		$dbpassword="p@MjdhfBSmbXWv68";
		$database="adminhdd_domenia3n";

		$mysqli=mysqli_connect($dbhost,$dbuser,$dbpassword,$database) or die("Sorry, Can't connect to database. Try later !");
		mysqli_set_charset($mysqli,'utf8');
		
		return $mysqli;
	}

    function get_colorset_group($name){

		$mysqli=$this->dbconnect();
		$name=mysqli_real_escape_string($mysqli,$name);
		$sql="SELECT * FROM `b3-colorset` WHERE `cls_name` LIKE '%{$name}%'";

		$stmt=mysqli_prepare($mysqli,$sql);
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

    function get_colorsets_count($type)
    {

		$mysqli=$this->dbconnect();
		$type=mysqli_real_escape_string($mysqli,$type);
		$query=mysqli_query($mysqli,"SELECT COUNT(*) FROM `{$type}-colorset`");
		$row=mysqli_fetch_row($query);
		$result=$row[0];
		mysqli_close($mysqli);

		return $result;
	}

    function get_parent_colorsets(){

		$mysqli=$this->dbconnect();

		$sql="select * from `b3-colorset` where `cls_parent_id`=''";
		$stmt=mysqli_prepare($mysqli,$sql);
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}


	function get_colorsets_per_page($type, $limit, $per_page)
	{
		$mysqli=$this->dbconnect();		
		
		$type=mysqli_real_escape_string($mysqli,$type);
		$limit=mysqli_real_escape_string($mysqli,$limit);
		$per_page=mysqli_real_escape_string($mysqli,$per_page);

		//$tab=$type."-colorset";
		//$stmt=mysqli_prepare($mysqli,"SELECT * FROM `?` order by `cls_id` DESC limit ?,?");
		//mysqli_stmt_bind_param($stmt, "sii", $tab, $limit, $per_page);
		
		$sql="select * from `".$type."-colorset` order by `cls_id` DESC limit ".$limit.", ".$per_page;
		$stmt=mysqli_prepare($mysqli,$sql);

		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

	function get_all_colorsets($type)
	{
		$mysqli=$this->dbconnect();		
		
		$type=mysqli_real_escape_string($mysqli,$type);
		$sql="select * from `".$type."-colorset` order by `cls_name` ASC";

		$stmt=mysqli_prepare($mysqli,$sql);

		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

	function get_colorset_any_quality($id){

		$mysqli=$this->dbconnect();

		$id=mysqli_real_escape_string($mysqli,$id);
		$quality_list=array('b3','b5','b7');

		for($i=0;$i<count($quality_list);$i++):

			$sql="select * from `".$quality_list[$i]."-colorset` where `cls_id`=?";
			$stmt=mysqli_prepare($mysqli,$sql);
			mysqli_stmt_bind_param($stmt,"s",$id);

			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);

			$row['data']=mysqli_fetch_array($result,MYSQLI_ASSOC);

			if(!empty($row['data'])){

				$row['quality']=$quality_list[$i];
				mysqli_stmt_close($stmt);
				mysqli_close($mysqli);

				break;
			}	
			
		endfor;
		return $row;
	}

	function create_colorset($data){

		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$quality_id=mysqli_real_escape_string($mysqli,$data->quality_id);
		$cls_id=mysqli_real_escape_string($mysqli,$data->cls_id);
		$cls_name=mysqli_real_escape_string($mysqli,$data->cls_name);
		$cls_parent_id=mysqli_real_escape_string($mysqli,$data->cls_parent_id);
		$cls_name_world=mysqli_real_escape_string($mysqli,$data->cls_name_world);
		$cls_description=mysqli_real_escape_string($mysqli,$data->cls_description);
		$cls_demo_empty=mysqli_real_escape_string($mysqli,$data->cls_demo_empty);
		$cls_demo_live=mysqli_real_escape_string($mysqli,$data->cls_demo_live);
		$cls_demo_office=mysqli_real_escape_string($mysqli,$data->cls_demo_office);
		$cls_demo_shop=mysqli_real_escape_string($mysqli,$data->cls_demo_shop);
		$cls_demo_medicin=mysqli_real_escape_string($mysqli,$data->cls_demo_medicin);
		$cls_demo_gym=mysqli_real_escape_string($mysqli,$data->cls_demo_gym);
		$cls_demo_restaurant=mysqli_real_escape_string($mysqli,$data->cls_demo_restaurant);
		$cls_demo_part_furnished=mysqli_real_escape_string($mysqli,$data->cls_demo_part_furnished);
		$cl_01=mysqli_real_escape_string($mysqli,$data->cl_01);
		$cl_02=mysqli_real_escape_string($mysqli,$data->cl_02);
		$cl_03=mysqli_real_escape_string($mysqli,$data->cl_03);
		$cl_03a=mysqli_real_escape_string($mysqli,$data->cl_03a);
		$cl_04=mysqli_real_escape_string($mysqli,$data->cl_04);
		$cl_05=mysqli_real_escape_string($mysqli,$data->cl_05);
		$cl_06=mysqli_real_escape_string($mysqli,$data->cl_06);
		$cl_07=mysqli_real_escape_string($mysqli,$data->cl_07);
		$cl_08=mysqli_real_escape_string($mysqli,$data->cl_08);
		$texture_01=mysqli_real_escape_string($mysqli,$data->texture_01);
		$texture_02=mysqli_real_escape_string($mysqli,$data->texture_02);
		$texture_03=mysqli_real_escape_string($mysqli,$data->texture_03);
		$texture_04=mysqli_real_escape_string($mysqli,$data->texture_04);

		if($quality_id=="b3"){

			$stmt="insert into `b3-colorset` (`cls_id`, `cls_name`, `cls_parent_id`, `cls_name_world`, `cls_description`, `cls_demo_office`, `cls_demo_empty`, `cls_demo_live`, `cls_demo_shop`, `cls_demo_medicin`, `cls_demo_gym`, `cls_demo_restaurant`, `cls_demo_part_furnished`, `cl_01`, `cl_02`, `cl_03`, `cl_03a`, `cl_04`, `cl_05`, `cl_06`, `cl_07`, `cl_08`, `texture_01`, `texture_02`, `texture_03`, `texture_04`) values('$cls_id', '$cls_name', '$cls_parent_id', '$cls_name_world', '$cls_description', '$cls_demo_office', '$cls_demo_empty', '$cls_demo_live', '$cls_demo_shop', '$cls_demo_medicin', '$cls_demo_gym', '$cls_demo_restaurant', '$cls_demo_part_furnished', '$cl_01', '$cl_02', '$cl_03', '$cl_03a', '$cl_04', '$cl_05', '$cl_06', '$cl_07', '$cl_08', '$texture_01', '$texture_02', '$texture_03', '$texture_04')";

		}elseif($quality_id=="b5" || $quality_id=="b7"){

			$stmt="insert into `".$quality_id."-colorset` (`cls_id`, `cls_name`, `cls_description`, `cl1_floor`, `cl2_walls`, `cl3_tiles`, `cl4_furniture`) values ('$cls_id', '$cls_name', '$cls_description', '$cl_01', '$cl_02', '$cl_03', '$cl_04') ";
		}

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);
	}

	function update_colorset($data,$id){

		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$id=mysqli_real_escape_string($mysqli,$id);

		$quality_id=mysqli_real_escape_string($mysqli,$data->quality_id);
		$cls_id=mysqli_real_escape_string($mysqli,$data->cls_id);
		$cls_name=mysqli_real_escape_string($mysqli,$data->cls_name);
		$cls_parent_id=mysqli_real_escape_string($mysqli,$data->cls_parent_id);
		$cls_name_world=mysqli_real_escape_string($mysqli,$data->cls_name_world);
		$cls_description=mysqli_real_escape_string($mysqli,$data->cls_description);
		$cls_demo_empty=mysqli_real_escape_string($mysqli,$data->cls_demo_empty);
		$cls_demo_live=mysqli_real_escape_string($mysqli,$data->cls_demo_live);
		$cls_demo_office=mysqli_real_escape_string($mysqli,$data->cls_demo_office);
		$cls_demo_shop=mysqli_real_escape_string($mysqli,$data->cls_demo_shop);
		$cls_demo_medicin=mysqli_real_escape_string($mysqli,$data->cls_demo_medicin);
		$cls_demo_gym=mysqli_real_escape_string($mysqli,$data->cls_demo_gym);
		$cls_demo_restaurant=mysqli_real_escape_string($mysqli,$data->cls_demo_restaurant);
		$cls_demo_part_furnished=mysqli_real_escape_string($mysqli,$data->cls_demo_part_furnished);
		$cl_01=mysqli_real_escape_string($mysqli,$data->cl_01);
		$cl_02=mysqli_real_escape_string($mysqli,$data->cl_02);
		$cl_03=mysqli_real_escape_string($mysqli,$data->cl_03);
		$cl_03a=mysqli_real_escape_string($mysqli,$data->cl_03a);
		$cl_04=mysqli_real_escape_string($mysqli,$data->cl_04);
		$cl_05=mysqli_real_escape_string($mysqli,$data->cl_05);
		$cl_06=mysqli_real_escape_string($mysqli,$data->cl_06);
		$cl_07=mysqli_real_escape_string($mysqli,$data->cl_07);
		$cl_08=mysqli_real_escape_string($mysqli,$data->cl_08);
		$texture_01=mysqli_real_escape_string($mysqli,$data->texture_01);
		$texture_02=mysqli_real_escape_string($mysqli,$data->texture_02);
		$texture_03=mysqli_real_escape_string($mysqli,$data->texture_03);
		$texture_04=mysqli_real_escape_string($mysqli,$data->texture_04);


		if($quality_id=="b3"){

			$sql="update `".$quality_id."-colorset` set `cls_name`='$cls_name', `cls_parent_id`='$cls_parent_id', `cls_name_world`='$cls_name_world', `cls_description`='$cls_description', `cls_demo_empty`='$cls_demo_empty', `cls_demo_live`='$cls_demo_live', `cls_demo_office`='$cls_demo_office', `cls_demo_shop`='$cls_demo_shop', `cls_demo_medicin`='$cls_demo_medicin', `cls_demo_gym`='$cls_demo_gym', `cls_demo_restaurant`='$cls_demo_restaurant', `cls_demo_part_furnished`='$cls_demo_part_furnished', `cl_01`='$cl_01', `cl_02`='$cl_02', `cl_03`='$cl_03', `cl_03a`='$cl_03a', `cl_04`='$cl_04', `cl_05`='$cl_05', `cl_06`='$cl_06', `cl_07`='$cl_07', `cl_08`='$cl_08', `texture_01`='$texture_01', `texture_02`='$texture_02', `texture_03`='$texture_03', `texture_04`='$texture_04' where `cls_id`='$id'";

		}elseif($quality_id=="b5" || $quality_id=="b7"){

			$sql="update `".$quality_id."-colorset` set `cls_id`='$cls_id', `cls_name`='$cls_name', `cls_description`='$cls_description', `cl1_floor`='$cl_01', `cl2_walls`='$cl_02', `cl3_tiles`='$cl_03', `cl4_furniture`='$cl_04' where `cls_id`='$id'";

		}

		mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);

	}

	public function delete_colorset($quality,$cls_id){

		$mysqli=$this->dbconnect();

		$cls_id=mysqli_real_escape_string($mysqli,$cls_id);
		$quality=mysqli_real_escape_string($mysqli,$quality);

		$sql="delete from `".$quality."-colorset` where `cls_id`=?";
		$stmt=mysqli_prepare($mysqli,$sql);
		mysqli_stmt_bind_param($stmt,"s",$cls_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

	}

    /*function delete_file_link_b3($cls_id, $column_name){

		$mysqli=$this->dbconnect();

		$cls_id=mysqli_real_escape_string($mysqli,$cls_id);
		$column_name=mysqli_real_escape_string($mysqli,$column_name);

		if(!empty($cls_id) && !empty($column_name)){

			$query=mysqli_query($mysqli, "select `".$column_name."` from `b3-colorset` where `cls_id`='$cls_id'");
			$row=mysqli_fetch_row($query);
			$link=$row[0];

			$sql="update `b3-colorset` set `".$column_name."`='' where `cls_id`='$cls_id'";
			mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
			mysqli_close($mysqli);

			return $link;
		}	
	}*/

	//

	//b3_textures

	function get_b3_textures_count(){

		$mysqli=$this->dbconnect();
		$query=mysqli_query($mysqli,"SELECT COUNT(*) FROM `b3-textures`");
		$row=mysqli_fetch_row($query);
		$result=$row[0];
		mysqli_close($mysqli);

		return $result;
	}

	function get_b3_textures_count_by_type($type=null){

		$mysqli=$this->dbconnect();
		$type=mysqli_real_escape_string($mysqli,$type);

		switch ($type) {
			case 'texture_03':
				$query=mysqli_query($mysqli,"SELECT COUNT(*) FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_100' and 'b3tx_200' ");
				break;

			case 'texture_01':
			case 'texture_02':
				$query=mysqli_query($mysqli,"SELECT COUNT(*) FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_200' and 'b3tx_400' ");
				break;

			case 'texture_04':
				$query=mysqli_query($mysqli,"SELECT COUNT(*) FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_400' and 'b3tx_600' ");
				break;		
			
			default:
				$query=mysqli_query($mysqli,"SELECT COUNT(*) FROM `b3-textures`");
				break;
		}
		
		$row=mysqli_fetch_row($query);
		$result=$row[0];
		mysqli_close($mysqli);

		return $result;
	}

	function get_b3_textures(){

		$mysqli=$this->dbconnect();
		$stmt=mysqli_prepare($mysqli,"select * from `b3-textures` order by `b3tx_id` ASC");
		
		mysqli_stmt_execute($stmt);	
		$result=mysqli_stmt_get_result($stmt);		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

	function get_b3_examples($data)
	{

		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$sl_id=mysqli_real_escape_string($mysqli,$data->sl_id);
		$cls_id=mysqli_real_escape_string($mysqli,$data->cls_id);
		$use_id=mysqli_real_escape_string($mysqli,$data->use_id);

		$stmt="SELECT * FROM `b3-examples` WHERE `sl_id` LIKE '%$sl_id%' AND `cls_id` LIKE '%$cls_id%' AND `use_id` = '$use_id'";

		$result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
		mysqli_close($mysqli);
		
		return $row;
	}

	function get_b3_examples_link($data)
	{

		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$pic_link=mysqli_real_escape_string($mysqli,$data->pic_link);
		$cls_id=mysqli_real_escape_string($mysqli,$data->cls_id);		

		$stmt="SELECT * FROM `b3-examples` WHERE `pic_link` LIKE '%$pic_link%' AND `cls_id` LIKE '%$cls_id%'";

		$result = mysqli_query($mysqli, $stmt) or die(mysqli_error($mysqli));
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
		mysqli_close($mysqli);
		
		return $row;
	}

	function update_b3_examples($data)
	{
		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$sl_id=mysqli_real_escape_string($mysqli,$data->sl_id);
		$cls_id=mysqli_real_escape_string($mysqli,$data->cls_id);
		$use_id=mysqli_real_escape_string($mysqli,$data->use_id);
		$pic_link=mysqli_real_escape_string($mysqli,$data->pic_link);

		$stmt="update `b3-examples` set `pic_link`='$pic_link' where `sl_id`='$sl_id' and `cls_id`='$cls_id' and `use_id`='$use_id'";

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);
	}

	function create_b3_examples($data)
	{
		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$sl_id=mysqli_real_escape_string($mysqli,$data->sl_id);
		$cls_id=mysqli_real_escape_string($mysqli,$data->cls_id);
		$use_id=mysqli_real_escape_string($mysqli,$data->use_id);
		$pic_link=mysqli_real_escape_string($mysqli,$data->pic_link);

		$stmt="insert into `b3-examples`(`sl_id`, `cls_id`, `use_id`, `pic_link`) values ('$sl_id', '$cls_id', '$use_id', '$pic_link')";

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);
	}

	function get_b3_textures_by_type_per_page($type=null, $limit=10, $offset=0){

		$mysqli=$this->dbconnect();

		$type=mysqli_real_escape_string($mysqli,$type);
		$limit=mysqli_real_escape_string($mysqli,$limit);
		$offset=mysqli_real_escape_string($mysqli,$offset);

		/*switch ($type) {
			case 'texture_03':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_100' and 'b3tx_200' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;

			case 'texture_01':
			case 'texture_02':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_200' and 'b3tx_400' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;

			case 'texture_04':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_400' and 'b3tx_600' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;		
			
			default:
				$stmt=mysqli_prepare($mysqli,"select * from `b3-textures` order by `b3tx_id` ASC");
				break;
		}*/

		switch ($type) {
			case 'walls_exterior':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|1|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;
			case 'walls_interior':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|2|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;
			case 'texture_01':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|4|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;
			case 'texture_02':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|5|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;
			case 'texture_03':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|3|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;			
			case 'texture_04':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|6|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;
			case 'oven_area':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|7|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;
			case 'oven_fields':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures`  WHERE `b3_spaces` LIKE '%|8|%' order by `b3tx_id` ASC limit {$limit}, {$offset}");
				break;			
			default:
				$stmt=mysqli_prepare($mysqli,"select * from `b3-textures` order by `b3tx_id` ASC");
				break;
		}

		//mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
		mysqli_stmt_execute($stmt);	
		$result=mysqli_stmt_get_result($stmt);		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

	function get_b3_textures_by_type($type=null){

		$mysqli=$this->dbconnect();

		$type=mysqli_real_escape_string($mysqli,$type);

		switch ($type) {
			case 'texture_03':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_100' and 'b3tx_200' order by `b3tx_id` ASC");
				break;

			case 'texture_01':
			case 'texture_02':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_200' and 'b3tx_400' order by `b3tx_id` ASC");
				break;

			case 'texture_04':
				$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` where `b3tx_id` BETWEEN 'b3tx_400' and 'b3tx_600' order by `b3tx_id` ASC");
				break;		
			
			default:
				$stmt=mysqli_prepare($mysqli,"select * from `b3-textures` order by `b3tx_id` ASC");
				break;
		}
		
		mysqli_stmt_execute($stmt);	
		$result=mysqli_stmt_get_result($stmt);		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

    function get_b3_textures_per_page($limit, $per_page){

		$mysqli=$this->dbconnect();

		$limit=mysqli_real_escape_string($mysqli,$limit);
		$per_page=mysqli_real_escape_string($mysqli,$per_page);

		$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-textures` order by `b3tx_id` ASC limit ?,?");
		mysqli_stmt_bind_param($stmt, "ii", $limit, $per_page);

		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);	
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_close($mysqli);			
		return $rows;
	}

	function create_b3_texture($data){

		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$b3tx_id=mysqli_real_escape_string($mysqli,$data->b3tx_id);
		$name=mysqli_real_escape_string($mysqli,$data->name);
		$b3_spaces=mysqli_real_escape_string($mysqli,$data->b3_spaces);
		$description=mysqli_real_escape_string($mysqli,$data->description);
		$texture_path=mysqli_real_escape_string($mysqli,$data->texture_path);

		$stmt="insert into `b3-textures` (`b3tx_id`, `name`,`b3_spaces`, `description`, `texture_path`) values ('$b3tx_id', '$name','$b3_spaces', '$description', '$texture_path')";

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);

	}

	function update_b3_texture($data){

		$mysqli=$this->dbconnect();
		$data=json_decode($data);

		$b3tx_id=mysqli_real_escape_string($mysqli,$data->b3tx_id);
		$name=mysqli_real_escape_string($mysqli,$data->name);
		$b3_spaces=mysqli_real_escape_string($mysqli,$data->b3_spaces);
		$description=mysqli_real_escape_string($mysqli,$data->description);
		$texture_path=mysqli_real_escape_string($mysqli,$data->texture_path);

		$stmt="update `b3-textures` set `name`='$name',`b3_spaces`='$b3_spaces', `description`='$description', `texture_path`='$texture_path' where `b3tx_id`='$b3tx_id'";

		mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		mysqli_close($mysqli);

	}

	public function delete_b3_texture($id){

		$mysqli=$this->dbconnect();

		$id=mysqli_real_escape_string($mysqli,$id);

		$sql="delete from `b3-textures` where `b3tx_id`=?";
		$stmt=mysqli_prepare($mysqli,$sql);
		mysqli_stmt_bind_param($stmt,"s",$id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);

	}

	public function delete_file_link_b3($cls_id,$link)
	{

		$mysqli=$this->dbconnect();

		$id=mysqli_real_escape_string($mysqli,$id);

		$sql="DELETE FROM `b3-examples` WHERE `cls_id` LIKE '$cls_id' AND `pic_link` LIKE '%$cls_id%' ";
		
		mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));

		mysqli_close($mysqli);

	}

	function get_b3_texture($id)
	{
		$mysqli=$this->dbconnect();	

		$id=mysqli_real_escape_string($mysqli,$id);
		$stmt=mysqli_prepare($mysqli,"select * from `b3-textures` where `b3tx_id`=?");
        mysqli_stmt_bind_param($stmt,"s",$id);
        
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
    }

	function get_all_b3_shapes()
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-shapes`");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

	function get_all_b3_spaces()
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-spaces`");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}

	function get_b3_space($b3s_id)
	{
		$mysqli=$this->dbconnect();		
		
		$b3s_id=mysqli_real_escape_string($mysqli,$b3s_id);

		$stmt=mysqli_prepare($mysqli,"SELECT * FROM `b3-spaces` WHERE `b3s_id` = ?");
		mysqli_stmt_bind_param($stmt,"i",$b3s_id);

		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
	}

    function delete_b3_texture_link($id){

		$mysqli=$this->dbconnect();

		$id=mysqli_real_escape_string($mysqli,$id);

		if(!empty($id)){

			$query=mysqli_query($mysqli, "select `texture_path` from `b3-textures` where `b3tx_id`='$id'");
			$row=mysqli_fetch_row($query);
			$link=$row[0];

			$sql="update `b3-textures` set `texture_path`='' where `b3tx_id`='$id'";
			mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
			mysqli_close($mysqli);

			return $link;
		}	
	}

	//
	
	function get_all_b3_colorsets()
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-colorset`");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}
    
    function get_all_b3_child_colorsets($cls_parent_id)
    {
        $mysqli=$this->dbconnect();		
        $cls_parent_id=mysqli_real_escape_string($mysqli,$cls_parent_id);
        
		$stmt=mysqli_prepare($mysqli,"select * from `b3-colorset` where `cls_parent_id` like '%$cls_parent_id%'");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
    }

    function get_all_b3_colorsets_except_this($cls_id)
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-colorset` where `cls_id`<>?");
        mysqli_stmt_bind_param($stmt,"s",$cls_id);
        
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
    }
    
	function get_all_b5_colorsets()
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `b5-colorset`");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}
	
	function get_b5_colorset($cls_id)
	{
		$mysqli=$this->dbconnect();		
		$cls_id=mysqli_real_escape_string($mysqli,$cls_id);
		
		$stmt=mysqli_prepare($mysqli,"select * from `b5-colorset` where `cls_id`=?");
		mysqli_stmt_bind_param($stmt,"s",$cls_id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
				
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
	}
	
	function get_all_b7_colorsets()
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `b7-colorset`");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}
	
	function get_b7_colorset($cls_id)
	{
		$mysqli=$this->dbconnect();		
		$cls_id=mysqli_real_escape_string($mysqli,$cls_id);
		
		$stmt=mysqli_prepare($mysqli,"select * from `b7-colorset` where `cls_id`=?");
		mysqli_stmt_bind_param($stmt,"s",$cls_id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
				
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
	}
	
	function get_shape_line($sl_id)
	{
		$mysqli=$this->dbconnect();		
		$sl_id=mysqli_real_escape_string($mysqli,$sl_id);
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-shapes` where `sl_id`=?");
		mysqli_stmt_bind_param($stmt,"s",$sl_id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
			
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
	}
	
	function get_b3_colorset($cls_id)
	{
		$mysqli=$this->dbconnect();		
		$cls_id=mysqli_real_escape_string($mysqli,$cls_id);
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-colorset` where `cls_id`=?");
		mysqli_stmt_bind_param($stmt,"s",$cls_id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $row;
	}
    
    function get_b3_colorset_json($cls_id)
	{
		$mysqli=$this->dbconnect();		
		$cls_id=mysqli_real_escape_string($mysqli,$cls_id);
		
		$stmt=mysqli_prepare($mysqli,"select * from `b3-colorset` where `cls_id`=?");
		mysqli_stmt_bind_param($stmt,"s",$cls_id);
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return json_encode($row);
    }

	function get_all_stairs()
	{
		$mysqli=$this->dbconnect();		
		
		$stmt=mysqli_prepare($mysqli,"select * from `stairs`");
		
		mysqli_stmt_execute($stmt);
		
		$result=mysqli_stmt_get_result($stmt);		
		
		$rows=array();
		
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$rows[]=$row;
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($mysqli);
		
		return $rows;
	}
}
?>