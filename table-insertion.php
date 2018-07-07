<?php
include('../includes/common.php');

header("Content-Type: application/json; charset=UTF-8");

if(isset($_SESSION['id']) == false){
  header('location: ../index.php');
}

if ($_POST['bm_val'] != Null && $_POST['bm_name'] != Null && $_POST['t_name'] != Null) {


    $bm_val = json_decode($_POST["bm_val"]);
	$bm_name = json_decode($_POST["bm_name"]);
    $table_name = json_decode($_POST['t_name']);

	$uid = $_SESSION['id'];
    
    $insert_cmd = "insert into ".$table_name."(";

    if($_SESSION['Isadmin']){
        $args = "admin_id,";
        $vals = "'".$uid."',";  
    }else{
        $args = "user_id,";
        $vals = "'".$uid."',";
    }
    

    $max_size = sizeof($bm_val);

    for ($i = 0; $i < $max_size; $i++) { 

    	$args .= $bm_name[$i];
    	$vals .= "'".$bm_val[$i]."'";


    	if($i < $max_size - 1){
    		$args .=",";
    		$vals .=",";

    	}

    }

    $insert_cmd .= $args.")values(".$vals.")";


    $user_registration_submit = mysqli_query($conn, $insert_cmd) or die(
	header('location: ../index.php')
	);

    echo 'row inserted';

} 
else {
    echo 'Invalid parameters!';
}

?>
