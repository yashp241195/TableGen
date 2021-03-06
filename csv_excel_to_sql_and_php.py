# SQL Generator
print("SQL TABLE GENERATOR \n")


def sql_table_generate(table_name, col_arr, col_type_arr):
    cmd = 'CREATE TABLE '+table_name+'('

    size = len(col_arr)

    for i in range(size):

        column = col_arr[i]
        column_type = col_type_arr[i]

        cmd += column+' '+column_type

        if i < size-1:
            cmd += ','

    cmd += ');'

    return cmd


def insert_table_values(table_name, col_arr, col_val_arr):
    cmd = 'INSERT INTO '+table_name+'('

    size = len(col_arr)

    for i in range(size):
        column = col_arr[i]
        cmd += column
        if i < size-1:
            cmd += ','

    cmd += ')VALUES('
    home_address = "C:\\Users\Yash\PycharmProjects\Arrays\\"

    for i in range(size):
        column = col_val_arr[i]
        if(column[0] == "{" and column[len(column)-1]=="}"):
            blob_src = '\"'+home_address+column[1:len(column)-1]+'\"'
            cmd += blob_src
            pass
        else:
            cmd += '\''+column+'\''
        if i < size-1:
            cmd += ','

    cmd += ');'

    return cmd


def export_table_php_html(table_name, col_arr):
    cmd = '<thead><tr>'
    size = len(col_arr)
    for i in range(size):
        column = col_arr[i]
        cmd += '<th>'+column+'</th>'

    cmd += '</tr></thead>'

    cmd += '''<tbody>
                <?php
                     while ($row = mysqli_fetch_array($'''+table_name+''')){
                ?>
                <tr>'''

    for i in range(size):
        column = col_arr[i]

        text = '''
        <?php echo $row[\''''+column+'''\'];?>
        '''

        cmd += '<td>'+text+'</td>'

    cmd += '</tr>'

    cmd += '''<?php } ?></tbody>'''

    return cmd


def export_form_php_html(f_name,t_name, f_labels, f_values):

    action_script = '''  <?php  '''

    col_list = []
    col_val_list = []

    cmd = '''<form class="form" method="post" 
    action="'''+f_name+'''.php" role="form">
        <fieldset>
    '''

    for i in range(len(f_labels)):

        if(str(f_values[i])[0] == '{' and str(f_values[i])[len(str(f_values[i]))-1] == '}'):

            cmd += '''<div class="form-group">
                            <input class="form-control" 
                            name="''' + f_labels[i].replace(" ", "_").lower() + '''" 
                            type="file"
                            accept="file_extension|audio/*|video/*|image/*|media_type" 
                            value="">
                        </div>'''

            att = f_labels[i].replace(" ", "_").lower()
            col_list.append(att)
            col_val_list.append(att)
            action_script += '''$'''+att+''' = base64_encode(file_get_contents
            ($_FILES["'''+att+'''"]['tmp_name']));'''

        else:

            cmd += '''<div class="form-group">
                            <input class="form-control" 
                            name="'''+f_labels[i].replace(" ", "_").lower()+'''" 
                            type="'''+get_input_type(f_values[i])+'''" 
                            value="">
                        </div>'''

            att = f_labels[i].replace(" ", "_").lower()
            col_list.append(att)
            col_val_list.append(att)
            action_script += '''$'''+att+''' = $_POST["'''+att+'''"];'''

    my_cmd = insert_table_values(t_name, col_list, col_val_list)
    action_script += '''
    '''+my_cmd+'''
    ?>'''
    cmd += "</fieldset></form>"

    return cmd, action_script


def get_input_type(input_text):
    if(input_text == "email"):
        return "email"
    if (input_text == "password"):
        return "password"
    if (get_type(input_text) == "int(11)" or get_type(input_text) == "DECIMAL(10,4)"):
        return "number"

    return "text"


def is_float(s):
    try:
        float(s)
        return True
    except ValueError:
        return False


def get_type(text):

    if(text.isalpha()):
        return "varchar(50)"

    elif(text.isdigit()):
        return "int(11)"

    elif(is_float(text)):
        return "DECIMAL(10,4)"

    elif(text[0] == '{' and text[len(text)-1] == '}'):
        return "BLOB(16000000)"

    else:
        return "varchar(50)"


def ReadFile():
    with open("table.csv", "r+") as f:

        number_of_lines = int(len(f.readlines()))
        f.seek(0)

        html_table_code = []
        html_form_code = []
        command = []

        col_arr = []
        col_type_arr = []
        col_values_arr = []

        t_name = ""

        f_name = ""

        form_col_labels_arr = []
        form_col_types_arr = []

        for i in range(number_of_lines):

            row = f.readline()

            column_array = row.split(",")
            column_count = len(column_array)

            TAG = column_array[0].lower()

            if (TAG=='th'):
                column_array = column_array[1:column_count-1]
                for j in range(column_count-2):
                    text = column_array[j]
                    text = text.lower()
                    text = text.replace(" ", "_")
                    col_arr.append(text)

            if (TAG == 'tn' or TAG == 'ftn'):
                t_name = column_array[1].replace(' ','_').lower()

            if (TAG == 'end'):

                cmd = sql_table_generate(t_name, col_arr, col_type_arr)
                command.append(cmd)
                # print("\n",cmd)
                cmd = insert_table_values(t_name, col_arr, col_values_arr)
                command.append(cmd)

                cmd = export_table_php_html(t_name, col_arr)
                html_table_code.append(cmd)

                # truncate all
                col_arr = []
                col_type_arr = []
                col_values_arr = []
                t_name = ""

            if (TAG == 'tr'):
                # print(column_array)
                column_array = column_array[1:column_count-1]

                for j in range(column_count-2):
                    text = column_array[j]
                    col_values_arr.append(text)
                    text_type = get_type(text)
                    col_type_arr.append(text_type)
                    # print(text, "",text_type, end=", ")

                # print("")

            if (TAG == 'fn'):
                f_name = column_array[1].replace(' ', '_').lower()

            if (TAG == 'fin'):
                form_col_labels_arr = column_array[1:len(column_array)-1]

            if (TAG == 'fv'):
                form_col_types_arr = column_array[1:len(column_array)-1]


            if (TAG == 'fend'):
                cmd1, cmd2 = export_form_php_html(f_name, t_name, form_col_labels_arr, form_col_types_arr)
                html_form_code.append(cmd1)
                html_form_code.append(cmd2)


                f_name = ''
                form_col_labels_arr = []
                form_col_types_arr = []
                t_name = ''



        return command,html_table_code,html_form_code


cmd_list, html_table_code,html_form_code = ReadFile()


for i in range(len(cmd_list)):
    print(cmd_list[i])
    if (i+1) % 2 == 0:
        print("")

print("\n\n Generating Table with PHP Code using Python \n\n ")

# For indentations of the code
# import bs4 as bsoup
# bsoup._soup(HTML_CODE_TEXT).prettify()


for i in range(len(html_table_code)):
    print(html_table_code[i],end='\n\n\n')


for i in range(len(html_form_code)):
    print(html_form_code[i],end='\n\n\n')


import pymysql as p

# 1. Run SQL on CMD,
# 2. Open database connection

db = p.connect(
    user='root',
    password='',
    host='localhost',
    database='test'
    )


def exec_SQL(db, cursor, sql_query):
    try:
        # Execute the SQL command
        cursor.execute(sql_query)
        # Commit your changes in the database
        db.commit()
    except:
        # Rollback in case there is any error
        db.rollback()


# prepare a cursor object using cursor() method
cursor = db.cursor()


# Drop table if it already exist using execute() method.
# cursor.execute("DROP TABLE IF EXISTS EMPLOYEE")

# Create table as per requirement

# for i in range(len(cmd_list)):
#     sql = cmd_list[i]
#     exec_SQL(db, cursor, sql)

print("Executed")

db.close()
