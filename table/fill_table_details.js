    // Define each column with it's property in the array
    // col_name, col_type, col_width, col_text_suffix, col_value

    var body_measurements = [

            ["date","date","140","",""],
            ["height","number","70","cm","0.0"],
            ["weight","number","70","kg","0"],
            ["upper_abs","number","70","inch","0"],
            ["middle_abs","number","70","inch","0"],
            ["lower_abs","number","70","inch","0"],
            ["hips","number","70","inch","0"],
            ["thighs","number","70","inch","0"],
            ["left_arm","number","70","inch","0"],
            ["right_arm","number","70","inch","0"],
        ];

    
    // 


    var col_count_bm = col_count_bs = col_count_st = col_count_ws = 1;

    var col_max_count_bm = body_measurements.length;
   

    function col_count_change(table_name,sign_value=0){

        switch(table_name){

            case "body_measurements":                
                col_count_bm += sign_value;
                break;

            
        }

    }


    function get_col_count_array(table_name){

        switch(table_name){

            case "body_measurements":
                col_count = col_count_bm;
                col_max_count = col_max_count_bm;
                break;

            
        }

        return [col_count,col_max_count];

    }


    function get_col_property_array(table_name,column_no){

        var i = column_no;

        switch(table_name){

                case "body_measurements":
                    col_name = body_measurements[i][0];
                    col_type = body_measurements[i][1];
                    col_width = body_measurements[i][2];
                    col_text_suffix = body_measurements[i][3];
                    col_value = body_measurements[i][4];
                    break;

                
        }

        return [col_name, col_type, col_width, col_text_suffix, col_value];

    }

/*
    Please don't touch the code below
*/
        
    function insert_row(table_name){
                
        table = document.getElementById(table_name);

        var array = [];
        array = get_col_count_array(table_name);
        
        var col_count = array[0];
        var col_max_count = array[1];
        
        var row = table.insertRow(col_count);
                
        for (var i = 0; i < col_max_count; i++) {

            var column_property_array = [];
            column_property_array = get_col_property_array(table_name,i);

            col_name = column_property_array[0];
            col_type = column_property_array[1];
            col_width = column_property_array[2];
            col_text_suffix = column_property_array[3];
            col_value = column_property_array[4];

            row.insertCell(i).innerHTML = "<input"+ " name='"+col_name+
            "' type='"+ col_type+"' "+"value='"+col_value+"' "+
            "class='input-sm' style='height:25px; width:"+col_width+"px;' >"
            +col_text_suffix;

        }

        var del_str = "<a class='glyphicon glyphicon-trash btn btn-xs btn-danger' ";
        del_str += "onclick= \"delete_row("+col_count+",'"+table_name+"')\">Delete</a>";

        var save_str = "<a class='glyphicon glyphicon-save btn btn-xs btn-success' ";
        save_str += "onclick= \"save_row("+col_count+",'"+table_name+"')\">Save</a>";

        row.insertCell(col_max_count).innerHTML ="<div><div class='row'>"+
        "<div class='col-xs-4'>"+save_str+"</div><div class='col-xs-4'>"+
        del_str+"</div><div class='col-xs-4'></div></div></div>";

        // increment count
        col_count_change(table_name,1);


    }


    function delete_row(j,table_name) {

      document.getElementById(table_name).deleteRow(j);
      
      // decrement count
      col_count_change(table_name,-1);
      
    }


    function delete_row_db(j,table_name) {

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "ajax_php/delete_row.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var table_row_action = document.getElementById(table_name+"_row_"+j).parentElement;
                // delete button does not exist in edit_row, table updatation 
                if(table_row_action != null){
                    table_row_action.innerHTML =  xmlhttp.responseText;
                }                 
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

            var column_property_array = [];

            column_property_array = get_col_property_array(table_name,i);
            col_text_suffix = column_property_array[3];
           
            var units = String(col_text_suffix);

            content[i].innerHTML = ""+my_value+" "+units;
            
        }


        var arr_vals = JSON.stringify(cell_values);
        var arr_names = JSON.stringify(cell_col_names);
        var t_name = JSON.stringify(table_name);

        console.log(t_name,arr_vals,arr_names);


        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "ajax_php/insert_row.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var status = content[content.length-1]; 
                status.innerHTML =  xmlhttp.responseText;
                console.log(xmlhttp.responseText);
            }
        
        };

        xmlhttp.send('arr_vals='+arr_vals+'&arr_names='+arr_names+'&t_name='+t_name);


    }


    function edit_row(j,table_name){

        var table = document.getElementById(table_name);
        var table_edit_row_action = document.getElementById(table_name+"_edit_row_"+j).parentElement; 

        var row = table_edit_row_action.parentElement;
        var row_Index = row.rowIndex;

        var content = row.cells;
        var max_count = content.length - 1;
        var string = "";

        // console.log(max_count);

        for (var i = 0; i < max_count; i++) {


            var column_property_array = [];
            column_property_array = get_col_property_array(table_name,i);

            col_name = column_property_array[0];
            col_type = column_property_array[1];
            col_width = column_property_array[2];
            col_text_suffix = column_property_array[3];
            
            col_value = content[i].textContent;
    
            if(col_type == "number"){
                col_value = parseFloat(col_value);
            }
            if(col_type == "date"){
                col_value = "2012-12-12";
            }

                        
            col_string = "<td><input"+ " name='"+col_name+
            "' type='"+ col_type+"' "+"value='"+col_value+"' "+
            "class='input-sm' style='height:25px; width:"+col_width+"px;' >"
            +col_text_suffix+"</td>";

            string += col_string;

            console.log(col_value+" \n "+col_string);
        
        }


        var save_str = "<a class='glyphicon glyphicon-save btn btn-xs btn-warning' ";
        save_str += "onclick= \"update_row("+j+","+row_Index+",'"+table_name+"') \">update</a>";

        string += "<td> "+"<div><div class='row'><div class='col-xs-4'>"+save_str+
        "</div><div class='col-xs-4'></div></div></div></td>";

        row.innerHTML= string;


    }


    function update_row(j,row_Index,table_name){

        save_row(row_Index,table_name);
        delete_row_db(j,table_name);

    }



    function refresh_table(){
        window.location.reload(true);
    }
      

/* 
    code not to Touch End here 
*/        

    function insert_multiple_rows(table_name,num){

        for(i=0; i<num; i++){
            insert_row(table_name);
        }
        

    }
