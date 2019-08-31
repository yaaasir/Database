Databse Made Easy [![Tweet](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/intent/tweet?text=Check%20out%20this%20made%20easy%20database%20library%205%20on%20GitHub&url=https%3A%2F%2Fgithub.com%yaaasir%Database)
===================================

# Table of contents

* [Select From Database](#Select-From-table)
   * [Basic Select](#Basic-select)
   * [Basic Select](#Basic-select)
* [Insert Into Database](#Insert-into-table)
* [Delete From Database](#Delete-from-table)


## Table of contents
New database instance to be create with new keyword.

```html
$db = new database();
```

###Select From Table:

The select operation is defined as `select( $table, $fields = '*', $alias = '' )`

  ####Basic select

  To select data from table , the table name is to be provided.

  ```html
  $db->select( $table = "mytable" )->run();
  ```

  Default columns selection is set to select all, column names can be provided in space seperated string

  ```html
  $db->select( $table = "mytable", $columns = "ID, Name, Phone" )->run();
  ```
  ####Select Where:
 
  Equity checking can be done through where filtering:

  ```html
  $db->select( $table = "mytable", $columns = "ID, Name, Phone" )->where( ["Name" => "john Doe"] )->run();
  ```
  
  
###Insert Into Table:
Insert operation 
