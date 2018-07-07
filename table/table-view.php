    <table id="body_measurements" style="font-size:12px" class="table table-striped table-bordered table-list">
        <thead>
            <tr>
                <th>Date </th>
                <?php if($Isadmin){ echo "<th>Member Email</th>"; } ?>
                <th>Height </th>
                <th>Weight</th>
                <th>Upper Abs</th>
                <th>Middle Abs</th>
                <th>Lower Abs</th>
                <th>Hips</th>
                <th>Thighs</th>
                <th>Left Arm</th>
                <th>Right Arm</th>
                <?php if($Isadmin==false){ echo "<th>Action</th>"; } ?>
            </tr>
        </thead>

        <tbody>

        <?php
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

                if($Isadmin){

                    $email = $row['email'];

                    $display_row = "<tr><td>$date</td><td>$email</td><td>$height</td>".
                    "<td>$weight</td><td>$upper_abs</td><td>$middle_abs</td>".
                    "<td>$lower_abs</td><td>$hips</td><td>$thighs</td>".
                    "<td>$left_arm</td><td>$right_arm</td></tr>";

                }
                else{

                    $display_row = "<tr><td>$date</td><td>$height</td>".
                    "<td>$weight</td><td>$upper_abs</td><td>$middle_abs</td>".
                    "<td>$lower_abs</td><td>$hips</td><td>$thighs</td>".
                    "<td>$left_arm</td><td>$right_arm</td><td>$delete</td></tr>";


                }


                echo $display_row;

            }

        ?> 



      </tbody>
  </table>
