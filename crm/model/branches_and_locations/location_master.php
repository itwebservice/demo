<?php
class location_master{

public function location_master_save()
{
	$location_name = addslashes($_POST['location_name']);
	$active_flag = $_POST['active_flag'];
	$created_at = date('Y-m-d');

	$location_count = mysqli_num_rows( mysqlQuery("select * from locations where location_name='$location_name'") );
	if($location_count>0){
		echo "error--Sorry, Location name already exists.";
		exit;
	}

	$location_id = mysqli_fetch_assoc(mysqlQuery("select max(location_id) as max from locations"));
	$location_id = $location_id['max']+1;

	$sq_location = mysqlQuery("insert into locations ( location_id, location_name, active_flag, created_at ) values ( '$location_id', '$location_name', '$active_flag', '$created_at' )");
	if($sq_location){
		echo "Your location has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Location not saved";
		exit;
	}
}

public function location_master_update()
{
	$location_id = $_POST['location_id'];
	$location_name = addslashes($_POST['location_name1']);
	$active_flag = $_POST['active_flag'];

	$location_count = mysqli_num_rows( mysqlQuery("select * from locations where location_name='$location_name' and location_id!='$location_id'") );
	if($location_count>0){
		echo "error--Sorry, Location name already exists.";
		exit;
	}

	$sq_location = mysqlQuery("update locations set location_name='$location_name', active_flag='$active_flag' where location_id='$location_id'");
	$sq_location = mysqlQuery("update branches set active_flag='$active_flag' where location_id='$location_id'");
	
	if($sq_location){
		echo "Your location has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Location not updated";
		exit;
	}
}

}
?>