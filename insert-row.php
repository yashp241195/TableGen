<?php
include('../includes/common.php');
include('../includes/is_auth.php');

header("Content-Type: application/json; charset=UTF-8");

if ($_POST['arr_vals'] != Null && $_POST['arr_names'] != Null && $_POST['t_name'] != Null) {


    $arr_vals = json_decode($_POST["arr_vals"]);
	$arr_names = json_decode($_POST["arr_names"]);
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
    

    $max_size = sizeof($arr_vals);

    for ($i = 0; $i < $max_size; $i++) { 

    	$args .= $arr_names[$i];
    	$vals .= "'".$arr_vals[$i]."'";


    	if($i < $max_size - 1){
    		$args .=",";
    		$vals .=",";

    	}

    }

    $insert_cmd .= $args.")values(".$vals.")";


    $table_submit = mysqli_query($conn, $insert_cmd) or die(
	mysqli_error($conn)
	);

    echo 'row inserted';

} 
else {
    echo 'Invalid parameters!';
}

?>
