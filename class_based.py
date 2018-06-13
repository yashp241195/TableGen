class CommonPHP2ConnDB(object):
    def __init__(self):
        pass


class HeaderPHP(object):
    def __init__(self):
        pass


class FooterPHP(object):
    def __init__(self):
        pass


# Table Object


class Table(object):
    def __init__(self,
                 t_name,
                 column_list,
                 first_row,
                 t_view_fn,
                 t_modify_fn,
                 f_view_fn,
                 f_modify_fn
                 ):

        # Table Data

        self.table_name = t_name
        self.attributes_heading = column_list
        self.sample_attributes_values = first_row
        self.attributes_type = None

        # Table File Name

        self.table_view_file_name = t_view_fn
        self.table_modify_validation_file_name = t_modify_fn

        # Form File Name

        self.form_view_file_name = f_view_fn
        self.form_modify_validation_file_name = f_modify_fn

        # Functionality

        # CRUD Operations in Table SQL

        def create_table_sql():
            pass

        def insert_table_sql():
            pass

        def update_table_sql():
            pass

        def delete_table_sql():
            pass

        # CRUD Operations in Table PHP
        # View table on a web page by reading

        def table_view_php_html():
            pass

        # Perform table row update,delete,insert

        def table_modify_php_html():
            pass

        # Form 
        
        # Insert the value inside the form
        
        def form_fill_php_html():
            pass
        
        # validate the input value in form
        
        def form_validate_php_html():
            pass
