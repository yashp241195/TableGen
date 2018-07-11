<?php
include('../includes/common.php');
include('../includes/is_auth.php');
header("Content-Type: application/json; charset=UTF-8");

// can_only_delete_their_own

$self_delete_tables_by_id = array("body_measurements", "body_scanning", "scientific_test");
$self_delete_tables_by_email = array("workout_schedule");
$uid = $_SESSION['id'];
$Isadmin = $_SESSION['Isadmin'];
$email = $_SESSION['email'];
if($_POST['t_id'] != Null && $_POST['t_name'] != Null){
    $t_id = json_decode($_POST['t_id']);
    $t_name = json_decode($_POST['t_name']);
    $t_col_name = $t_name."_id";
    // console.log($t_col_name);
    if($Isadmin == false){
    	if(in_array($t_name, $self_delete_tables_by_id)){
		    $delete_query = "DELETE FROM $t_name WHERE $t_col_name = $t_id and user_id = $uid";
	    }
	    if(in_array($t_name, $self_delete_tables_by_email)){
		    $delete_query = "DELETE FROM $t_name WHERE $t_col_name = $t_id and email = '$email'";
	    }
    }else{
    	// admin users can delete anything
    	$delete_query = "DELETE FROM $t_name WHERE $t_col_name = $t_id";
    }
    
	$delete_query_result = mysqli_query($conn, $delete_query) or die(mysqli_error($conn));
    echo 'row deleted';
} 
else {
    echo 'Invalid parameters!';
}
?>
