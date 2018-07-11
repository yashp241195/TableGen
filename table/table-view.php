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

    <tbody id="body_measurements_rows">                          
    </tbody>

</table>
