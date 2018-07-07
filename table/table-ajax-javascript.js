    var row_count_bm = row_count_bs = 1;

    // col_name, col_type, col_width, col_text, col_value

    var body_measurements = [

            ["date","date","140","",""],
            ["height","number","70","cm","1"],
            ["weight","number","70","kg","1"],
            ["upper_abs","number","70","inch","1"],
            ["middle_abs","number","70","inch","1"],
            ["lower_abs","number","70","inch",""],
            ["hips","number","70","inch",""],
            ["thighs","number","70","inch",""],
            ["left_arm","number","70","inch",""],
            ["right_arm","number","70","inch",""],
        ];

    var body_scanning = [
            ["date","date","140","",""],
            ["body_fat","number","70"," % ","1"],
            ["metabolic_age","number","70"," years","1"],
            ["bmi","number","70"," ",""],
            ["bmr","number","70"," ",""],
            ["visceral_fat","number","70"," % ",""],
            ["subcutaneous_fat","number","70"," % ",""],
            ["skeletal_muscle","number","70"," % ",""],
        ];

   

    var row_max_count_bm = body_measurements.length;
    var row_max_count_bs = body_scanning.length;
    
    function insert_multiple_rows(table_name,num){

        workout_schedule[0][4] = 1;
        workout_schedule[1][4] = "yy@gmail.com";
        workout_schedule[2][4] = 1;
        workout_schedule[3][4] = 1;
        workout_schedule[4][4] = 1;
        workout_schedule[5][4] = 1;


        for(i=0; i<num; i++){
            insert_row(table_name);
        }
        
        workout_schedule[0][4] = 1;
        workout_schedule[1][4] = 1;
        workout_schedule[2][4] = 1;
        workout_schedule[3][4] = 1;
        workout_schedule[4][4] = 1;
        workout_schedule[5][4] = 1;
        

    }

        
    function insert_row(table_name){
                
        table = document.getElementById(table_name);
        var row_count = row_max_count = 1;


        switch(table_name){

            case "body_measurements":
                row_count = row_count_bm;
                row_max_count = row_max_count_bm;
                break;

            case "body_scanning":
                row_count = row_count_bs;
                row_max_count = row_max_count_bs;
                break;

            
        }

        var row = table.insertRow(row_count);
                
                
        for (var i = 0; i < row_max_count; i++) {
            
            switch(table_name){

                case "body_measurements":
                    col_name = body_measurements[i][0];
                    col_type = body_measurements[i][1];
                    col_width = body_measurements[i][2];
                    col_text = body_measurements[i][3];
                    col_value = body_measurements[i][4];
                    break;

                case "body_scanning":
                    col_name = body_scanning[i][0];
                    col_type = body_scanning[i][1];
                    col_width = body_scanning[i][2];
                    col_text = body_scanning[i][3];
                    col_value = body_scanning[i][4];
                    break;

                                
            }

            row.insertCell(i).innerHTML = "<input"+ " name='"+col_name+
            "' type='"+ col_type+"' "+"value='"+col_value+"'"+
            "class='input-sm' style='height:25px; width:"+col_width+"px;' >"+col_text;

        }

        var del_str = "<a class='glyphicon glyphicon-trash btn btn-xs btn-danger' ";
        del_str += "onclick= \"delete_row("+row_count+",'"+table_name+"')\">Delete</a>";

        var save_str = "<a class='glyphicon glyphicon-save btn btn-xs btn-success' ";
        save_str += "onclick= \"save_row("+row_count+",'"+table_name+"')\">Save</a>";

        row.insertCell(row_max_count).innerHTML ="<div><div class='row'>"+
        "<div class='col-xs-4'>"+save_str+"</div><div class='col-xs-4'>"+del_str+"</div><div class='col-xs-4'></div></div></div>";

          switch(table_name){

            case "body_measurements":
                
                row_count_bm++;
                break;

            case "body_scanning":
                
                row_count_bs++;
                break;

            
        }

    }

    // function edit_row(j,table_name){

    // }

    function delete_row(j,table_name) {

      document.getElementById(table_name).deleteRow(j);

        switch(table_name){
            case "body_measurements":
               row_count_bm--;
               break;

            case "body_scanning":
                row_count_bs--;
                break;

            
        }
      
    }

    function delete_row_db(j,table_name) {

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "php_scripts/delete_row.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var table_row_action = document.getElementById(table_name+"_row_"+j).parentElement; 
                table_row_action.innerHTML =  xmlhttp.responseText;
                console.log(xmlhttp.responseText);
            }
        };
        
        var t_name = JSON.stringify(table_name);
        var t_id = JSON.stringify(j);

        xmlhttp.send('t_id='+j+'&t_name='+t_name);
      
    }

    function save_row(j,table_name){

        var table = document.getElementById(table_name);

        var content = table.rows[j].cells;

        // accessing each cell

        cell_values = [];
        cell_col_names = [];

        var max_count = content.length-1;

        for (var i = 0; i < max_count; i++) {
            
                var my_value = content[i].firstElementChild.value;
                var my_name = content[i].firstElementChild.name;
                
                cell_values.push(my_value);
                cell_col_names.push(my_name);

                switch(table_name){

                    case "body_measurements":
                        col_text = body_measurements[i][3];
                        break;

                    case "body_scanning":
                        col_text = body_scanning[i][3];
                        break;

                   

                }

                var units = col_text;

                content[i].innerHTML = ""+my_value+" "+String(units);
            }


            var bm_val = JSON.stringify(cell_values);
            var bm_name = JSON.stringify(cell_col_names);
            var t_name = JSON.stringify(table_name);

            console.log(t_name,bm_val,bm_name);


            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "php_scripts/insert_row.php", true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var status = content[content.length-1]; 
                    status.innerHTML =  xmlhttp.responseText;
                    console.log(xmlhttp.responseText);
                }
            };

            xmlhttp.send('bm_val='+bm_val+'&bm_name='+bm_name+'&t_name='+t_name);


        }


    function refresh_table(){
        window.location.reload(true);
    }
    
