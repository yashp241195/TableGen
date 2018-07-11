<?php 

include('../includes/common.php');
include('../includes/is_auth.php');
header("Content-Type: application/json; charset=UTF-8");

$Isadmin = $_SESSION['Isadmin'];

if($_POST['t_name'] != Null){
	
	$t_name = $_POST['t_name'];
	$all_row = "";	


	if($t_name == "body_measurements"){

		 // Body Measurements - latest

		if($Isadmin==true){

			$query = "SELECT * from body_measurements inner join member_users on 
			body_measurements.user_id=member_users.member_id ORDER BY date DESC";

		}else{
			$uid = $_SESSION['id'];			
			$query = "SELECT * from body_measurements WHERE user_id = $uid ORDER BY date DESC";

		}

    
		$user_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$body_measurements = $user_query;
		

		while ($row = mysqli_fetch_array($body_measurements)){

		    $body_measurements_id = $row['body_measurements_id'];		    
		    $date = date_format(date_create($row['date']), 'd-m-Y');
		    $height = $row['height']." cm ";
		    $weight = $row['weight']." kg ";
		    $upper_abs = $row['upper_abs']." inch ";
		    $middle_abs = $row['middle_abs']." inch ";
		    $lower_abs = $row['lower_abs']." inch ";
		    $hips = $row['hips']." inch ";
		    $thighs = $row['thighs']." inch ";
		    $left_arm = $row['left_arm']." inch ";
		    $right_arm = $row['right_arm']." inch ";

		    $delete = "<a id=\"body_measurements_row_$body_measurements_id\" onclick='delete_row_db($body_measurements_id,\"body_measurements\")' class=\"glyphicon glyphicon-trash btn btn-xs btn-danger
		    \">Delete</a>";

		    $edit = "<a id=\"body_measurements_edit_row_$body_measurements_id\" 
		    onclick='edit_row($body_measurements_id,\"body_measurements\")' 
		    class=\"glyphicon glyphicon-pencil btn btn-xs btn-primary
		    \">Edit</a>";

		    if($Isadmin){

			$email = $row['email'];

			$display_row = "<tr><td>$date</td><td>$email</td><td>$height</td>".
			"<td>$weight</td><td>$upper_abs</td><td>$middle_abs</td>".
			"<td>$lower_abs</td><td>$hips</td><td>$thighs</td>".
			"<td>$left_arm</td><td>$right_arm</td></tr>";

		    }else{

			$display_row = "<tr><td>$date</td><td>$height</td>".
			"<td>$weight</td><td>$upper_abs</td><td>$middle_abs</td>".
			"<td>$lower_abs</td><td>$hips</td><td>$thighs</td>".
			"<td>$left_arm</td><td>$right_arm</td><td>$edit $delete</td></tr>";


		    }
				 
		    
		    $all_row .= $display_row;

		}

	}


	
	echo $all_row;


}

?>
