var page_count_bm = page_count_bs = page_count_st = page_count_ws = 1;


function set_table_page_limit(table_name,value){

        switch(table_name){

            case "body_measurements":                
                page_count_bm = value;
                break;

            case "body_scanning":                
                page_count_bs = value;
                break;

            case "scientific_test":                
                page_count_st = value;
                break;

            case "workout_schedule":                
                page_count_ws = value;
                break;
        }

}

function get_table_page_limit(table_name){

        switch(table_name){

            case "body_measurements":                
                return page_count_bm;

            case "body_scanning":                
                return page_count_bs;

            case "scientific_test":                
                return page_count_st;

            case "workout_schedule":                
                return page_count_ws;
        }
        
}

function get_table_data(t_name, page_no){

    var row_limit_per_page = 20;

    var xmlhttp = new XMLHttpRequest();

    // always put address of the page where function is called
    // here ../ajax_php/is_email_available.php does not work

    xmlhttp.open("POST", "ajax_php/display_rows.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var row_item = document.getElementById(t_name+"_rows"); 
            var pagination = document.getElementById(t_name+"_page_no");
            
            
            var recieve = JSON.parse(xmlhttp.responseText);

            row_item.innerHTML = recieve[0];
            page_max_limit = parseInt(recieve[1]/row_limit_per_page)+1;

            set_table_page_limit(t_name,page_max_limit);

            pagination.innerText = "Page "+page_no+" of "+page_max_limit;
            
            console.log(xmlhttp.responseText);
        }
    };

    xmlhttp.send('t_name='+t_name+'&page_no='+page_no+'&row_limit='+row_limit_per_page);

}

function pageination(t_name, pg=1){

    if(pg < 1){
        pg = 1;
    }

    var page_limit = get_table_page_limit(t_name);

    // console.log(page_limit);

    if(pg > page_limit){
        return 0;
    }

    var total_pg = 4;

    pg_before = (pg - total_pg);
    pg_after = (pg + total_pg);

    if((page_limit/total_pg) < 1){
        pg_after = page_limit;
    }

        
    var text = "<li><a href=\"#\" onclick=\"pageination('"+t_name+"',"+pg_before+")\">«</a></li>";
    
    for (var i = pg; i <= pg_after; i++) {
        text += "<li><a href=\"#\" onclick=\"get_table_data('"+t_name+"',"+i+")\">"+i+"</a></li>";
    }

    text += "<li><a href=\"#\" onclick=\"pageination('"+t_name+"',"+pg_after+")\">»</a></li>";

    var pagination_view = document.getElementById(t_name+"_pagination");
    pagination_view.innerHTML = text;


}



get_table_data("body_measurements",1);
get_table_data("body_scanning",1);
get_table_data("scientific_test",1);
get_table_data("workout_schedule",1);

pageination('body_measurements');
pageination('body_scanning');
pageination('scientific_test');
pageination('workout_schedule');
