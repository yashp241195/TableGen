<?php
include('../includes/common.php');

header("Content-Type: application/json; charset=UTF-8");


if($_POST['t_id'] != Null && $_POST['t_name'] != Null){

    $t_id = json_decode($_POST['t_id']);
    $t_name = json_decode($_POST['t_name']);

    $t_col_name = $t_name."_id";
    // console.log($t_col_name);

    $remove_cart_query = "DELETE FROM $t_name WHERE $t_col_name = $t_id ";
    $remove_cart_result = mysqli_query($conn, $remove_cart_query) or die(mysqli_error($conn));

    echo 'row deleted';

} 
else {
    echo 'Invalid parameters!';
}

?>
