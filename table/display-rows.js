function get_table_data(t_name){

    var xmlhttp = new XMLHttpRequest();

    // always put address of the page where function is called
    // here ../ajax_php/is_email_available.php does not work

    xmlhttp.open("POST", "ajax_php/display_row.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var profile_item = document.getElementById(t_name+"_rows"); 
            profile_item.innerHTML = xmlhttp.responseText;
            
            console.log(xmlhttp.responseText);
        }
    };

    xmlhttp.send('t_name='+t_name);

}

get_table_data("body_measurements");
