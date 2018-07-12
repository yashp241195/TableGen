<div class="panel-body">
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

</div>
<div class="panel-footer">
    <div class="row">
        <div class="col col-xs-4" id="body_measurements_page_no">
            <p>Page 1 of 5</p>
        </div>

        <div class="col col-xs-8">
            <ul id="body_measurements_pagination" class="pagination hidden-xs pull-right">
            </ul>
        </div>

    </div>
</div>

