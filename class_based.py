class CommonPHP2ConnDB(object):
    def __init__(self):
        pass


class HeaderPHP(object):
    def __init__(self):
        pass


class FooterPHP(object):
    def __init__(self):
        pass


class Table(object):
    def __init__(self, t_name, column_list):
        self.table_name = t_name
        self.attributes = column_list

    def get_type(self):
        pass

    def create_query(self):
        pass

    def insert_query(self):
        pass

    def export_php_html_table(self):
        pass


class Form(object):
    def __init__(self, f_name, t_name):
        self.form_name = f_name
        self.table_name = t_name

    def get_input_type(self):
        pass

    def export_form_php_html(self):
        pass

    def export_form_validator(self):
        pass


class MergedForm(object):
    def __init__(self, forms):
        pass

    def export_merged_form_php_html(self):
        pass

    def export_merged_form_validator(self):
        pass
