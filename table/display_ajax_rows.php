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


	if($t_name == "body_scanning"){

		// Body Scanning - latest

		if($Isadmin==true){


    		$query = "SELECT * from body_scanning inner join member_users on 
    		body_scanning.user_id=member_users.member_id ORDER BY date DESC";


		}else{

			$uid = $_SESSION['id'];	
			$query = "SELECT * from body_scanning WHERE user_id = $uid ORDER BY date DESC";		

		}

    
		$user_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$body_scanning = $user_query;

		

		while ($row = mysqli_fetch_array($body_scanning)){
                           
            $body_scanning_id = $row['body_scanning_id'];

            $date = date_format(date_create($row['date']), 'd-m-Y');
            $body_fat = $row['body_fat']." % ";
            $metabolic_age = $row['metabolic_age']." years ";
            $bmi = $row['bmi']." ";
            $bmr = $row['bmr']." ";
            $visceral_fat = $row['visceral_fat']." % ";
            $subcutaneous_fat = $row['subcutaneous_fat']." % ";
            $skeletal_muscle = $row['skeletal_muscle']." % ";
                                 
                                    
            $delete = "<a id=\"body_scanning_row_$body_scanning_id\" onclick='delete_row_db($body_scanning_id,\"body_scanning\")' class=\"glyphicon glyphicon-trash btn btn-xs btn-danger
            \">Delete</a>";

            $edit = "<a id=\"body_scanning_edit_row_$body_scanning_id\" 
		    onclick='edit_row($body_scanning_id,\"body_scanning\")' 
		    class=\"glyphicon glyphicon-pencil btn btn-xs btn-primary
		    \">Edit</a>";

                if($Isadmin){

                    $email = $row['email'];

                    $display_row = "<tr><td>$date</td><td>$email</td><td>$body_fat</td>".
                "<td>$metabolic_age</td><td>$bmi</td><td>$bmr</td>".
                "<td>$visceral_fat</td><td>$subcutaneous_fat</td><td>$skeletal_muscle</td>".
                "</tr>";


                }else{

                    $display_row = "<tr><td>$date</td><td>$body_fat</td>".
                "<td>$metabolic_age</td><td>$bmi</td><td>$bmr</td>".
                "<td>$visceral_fat</td><td>$subcutaneous_fat</td><td>$skeletal_muscle</td>".
                "<td>$edit $delete</td></tr>";

                }
             
                              
            $all_row .= $display_row;

        }


	}

	if($t_name == "scientific_test"){

		// scientific_test - latest

		if($Isadmin==true){


    		$query = "SELECT * from scientific_test inner join member_users on 
    		scientific_test.user_id=member_users.member_id ORDER BY date DESC";


		}else{

			$uid = $_SESSION['id'];	
    		$query = "SELECT * from scientific_test WHERE user_id = $uid ORDER BY date DESC";

		}

    
		$user_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$scientific_test = $user_query;

		

		while ($row = mysqli_fetch_array($scientific_test)){
                               
            $scientific_test_id = $row['scientific_test_id'];
            
            $date = date_format(date_create($row['date']), 'd-m-Y');
            $cardio_test = $row['cardio_test']." ";
            $strength_test = $row['strength_test']." ";
            $endurance_test = $row['endurance_test']." ";
            $rpr_test = $row['rpr_test']." ";
            $flexiblity_test = $row['flexiblity_test']." ";
            $lungs_capacity = $row['lungs_capacity']." ";
            $stress_test = $row['stress_test']." ";
            $skin_fold = $row['skin_fold']." ";
            $psychological_test = $row['psychological_test']." ";
                                        
                                        
            $delete = "<a id=\"scientific_test_row_$scientific_test_id\" onclick='delete_row_db($scientific_test_id,\"scientific_test\")' class=\"glyphicon glyphicon-trash btn btn-xs btn-danger
            \">Delete</a>";

            $edit = "<a id=\"scientific_test_edit_row_$scientific_test_id\" 
		    onclick='edit_row($scientific_test_id,\"scientific_test\")' 
		    class=\"glyphicon glyphicon-pencil btn btn-xs btn-primary
		    \">Edit</a>";

            if($Isadmin){
                $email = $row['email'];

            $display_row = "<tr><td>$date</td><td>$email</td><td>$cardio_test</td>".
            "<td>$strength_test</td><td>$endurance_test</td><td>$rpr_test</td>".
            "<td>$flexiblity_test</td><td>$lungs_capacity</td><td>$stress_test</td>".
            "<td>$skin_fold</td><td>$psychological_test</td></tr>";


            }else{

            $display_row = "<tr><td>$date</td><td>$cardio_test</td>".
            "<td>$strength_test</td><td>$endurance_test</td><td>$rpr_test</td>".
            "<td>$flexiblity_test</td><td>$lungs_capacity</td><td>$stress_test</td>".
            "<td>$skin_fold</td><td>$psychological_test</td><td>$edit $delete</td></tr>";

            }

         	$all_row .= $display_row;
            

        }


	}

	if($t_name == "workout_schedule"){

		// workout_schedule - latest

		if($Isadmin==true){

    		$query = "SELECT * from workout_schedule inner join member_users on 
    		workout_schedule.email=member_users.email ORDER BY date DESC";


		}else{

			$email = $_SESSION['email'];	
			$query = "SELECT * from workout_schedule WHERE email = '$email' ORDER BY date DESC";

		}

    
		$user_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$workout_schedule = $user_query;

		while ($row = mysqli_fetch_array($workout_schedule)){
                               
            $workout_schedule_id = $row['workout_schedule_id'];
            
            $date = date_format(date_create($row['date']), 'd-m-Y');
            $exercise_name = $row['exercise_name']." ";
            $reps_current = $row['reps_current']." ";
            $reps_target = $row['reps_target']." ";
            $body_area = $row['body_area']." ";
            $exercise_category = $row['exercise_category']." ";
            $remarks = $row['remarks']." ";
                                        
                                        
            $delete = "<a id=\"workout_schedule_row_$workout_schedule_id\" onclick='delete_row_db($workout_schedule_id,\"workout_schedule\")' class=\"glyphicon glyphicon-trash btn btn-xs btn-danger
            \">Delete</a>";

            $edit = "<a id=\"workout_schedule_edit_row_$workout_schedule_id\" 
		    onclick='edit_row($workout_schedule_id,\"workout_schedule\")' 
		    class=\"glyphicon glyphicon-pencil btn btn-xs btn-primary
		    \">Edit</a>";

	            if($Isadmin){
	                
		            $email = $row['email'];
		            $display_row = "<tr><td>$date</td><td>$email</td><td>$exercise_name</td><td>$reps_current</td><td>$reps_target</td><td>$body_area</td><td>$exercise_category</td><td>$remarks</td><td>$delete</td></tr>";

	            }
	            else{

		            $display_row = "<tr><td>$date</td><td>$exercise_name</td><td>$reps_current</td><td>$reps_target</td><td>$body_area</td><td>$exercise_category</td><td>$remarks</td><td>$edit $delete</td></tr>";

	            }

            $all_row .= $display_row;
            

        }

	}


	echo $all_row;


}

?>
