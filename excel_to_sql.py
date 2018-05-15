print("GENERATORS \n")
# SQL Generator


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

def is_number(s):
    try:
        float(s)
        return True
    except ValueError:
        return False


def get_type(text):
    if(text.isalpha()):
        return "varchar"
    elif(text.isdigit()):
        return "int"
    elif(is_number(text)):
        return "Number"
    else:
        return "varchar"


def ReadFile():
    with open("table.txt", "r+") as f:

        number_of_lines = int(len(f.readlines()))
        f.seek(0)

        for i in range(number_of_lines):

            row = f.readline()

            column_array = row.split(",")
            column_count = len(column_array)

            if(column_array[0].lower()=='th'):
                column_array = column_array[1:column_count-1]
                # print(column_array)
                for j in range(column_count-2):
                    text = column_array[j]
                    text = text.lower()
                    text = text.replace(" ", "_")
                    print(text, end=", ")

                print("")

            if (column_array[0].lower() == 'tn'):
                # print(column_array)
                t_name = column_array[1]

                print(t_name,end="\n")

            if (column_array[0].lower() == 'tr'):
                # print(column_array)
                column_array = column_array[1:column_count-1]

                for j in range(column_count-2):
                    text = column_array[j]
                    text_type = get_type(text)
                    print(text,"",text_type, end=", ")

                print("")


col_arr = ['PersonID','PersonID','PersonID']
col_type_arr = ['int','int','int']
ReadFile()
print("")
cmd = sql_table_generate(t_name,col_arr,col_type_arr)

print(cmd)
