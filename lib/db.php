<?php
global $conn;
function connect()
{
    global $conn;
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'DummyDB';

    if ($conn) {
        return $conn;
    } else {

        try {
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $conn = new PDO($dsn, $username, $password, $options);

            return $conn; // Return the PDO connection
        } catch (PDOException $e) {
            // Handle connection errors
            die('Connection failed: ' . $e->getMessage());
        }

    }
}


$condition = [];
function preparewhere($where = [], $connect = "AND")
{
    if ($where && count($where)) {
        $sql = "";
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                switch ($field) {
                    case 'AND':
                    case 'OR':
                        foreach ($value as $key => $_value) {
                            if (is_array($_value)) {
                                $condition[] = preparewhere($_value);
                            } else {
                                $condition[] = preparewhere([$key => $_value]);
                            }
                        }
                        $sql .= implode(" " . $field . " ", $condition);
                        return "(" . $sql . ")";
                    default:
                        if (is_array($value)) {

                            foreach ($value as $operator => $_value) {
                                switch ($operator) {
                                    case 'IN':
                                    case 'NOT IN':

                                        $_value = (is_array($_value)) ? $_value : [$_value];

                                        foreach ($_value as $key => $val) {

                                            $inarryvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";
                                        }
                                        $_value = implode(',', $inarryvalues);
                                        $condition[] = " {$field} {$operator} ({$_value}) ";
                                        break;

                                    case 'BETWEEN':
                                    case 'NOT BETWEEN':
                                        foreach ($value as $key => $val) {
                                            if (is_array($val)) {
                                                foreach ($val as $limits) {
                                                    $betweenvalues[] = (is_string($limits)) ? "'{$limits}'" : "{$limits}";
                                                }
                                            } else {
                                                $betweenvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";
                                            }
                                        }
                                        $betweenvaluestring = implode(' AND ', $betweenvalues);
                                        $condition[] =   " {$field} {$operator} {$betweenvaluestring}";
                                        break;

                                    default:
                                        $condition[] = " {$field} {$operator} '{$_value}' ";

                                        break;
                                }
                            }
                        }
                }
            } else {
                $condition[] =  " {$field} = '{$value}' ";
            }
        }
        $sql = implode(" {$connect} ", $condition);
        return $sql;
    }
}
function prepareselect($tablename, $coulmns, $where = [])
{
    $sql = 'SELECT ' . implode(',', $coulmns) . " FROM {$tablename}";
    $sql .= ($where == []) ? "" : " WHERE " . prepareWhere($where);
    return $sql;
}

function preapereDelete($tablename, $where = [])
{
    $sql = "DELETE FROM {$tablename}";
    if ($where && count($where)) {
        $sql .= ($where == []) ? "" : " WHERE " . prepareWhere($where);
    }
    return $sql;
}
function prepareInsert($tablename, $data, $where = [])
{
    $sql = "INSERT INTO {$tablename} ";

    $valuearray = [];
    foreach ($data as $column => $value) {
        $columns[] = $column;
        $valuearray[] = "'{$value}'";
    }

    $sql .= " (" . implode(",", $columns) . ") VALUES";
    $sql .= " (" . implode(",", $valuearray) . ")";
    if ($where && count($where)) {
        $sql .= ($where == []) ? "" : " WHERE " . prepareWhere($where);
    }
    return $sql;
}

function prepareEdit($tablename, $data, $where = [])
{
    $sql = "UPDATE {$tablename} SET ";

    foreach ($data as $column => $value) {
        $cnd[] = "{$column} = '{$value}' ";
    }
    $sql .= implode(',', $cnd);
    if ($where && count($where)) {
        $sql .= ($where == []) ? "" : " WHERE " . prepareWhere($where);
    }
    return $sql;
}

// <-------------------------- callable functions ---------------------------->
function getdata($table, $coulmns, $where = [])
{

    $conn = connect();
    $sql = prepareSelect($table, $coulmns, $where);
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return  $stmt->fetchAll();
}

function deletedata($table, $where)
{
    $conn = connect();
    $sql = preapereDelete($table, $where);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return  $stmt;
}


function insertData($table, $data)
{
    $conn = connect();
    $sql = prepareInsert($table, $data);
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        // Handle execution errors
        die('Execution failed: ' . $e->getMessage());
    }
}


function editdata($table, $data, $where)
{
    $conn = connect();
    $sql = prepareEdit($table, $data, $where);
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        // Handle execution errors
        die('Execution failed: ' . $e->getMessage());
    }
}

// <------------------------------  OLD prepareselect function -------------------------->
// function prepareaSelect( $tablename, $coulmns, $where=[] ) {
//     $sql = 'SELECT ' . implode( ',', $coulmns ) . " FROM {$tablename}";
//     // foreach ( $coulmns as $col ) {
//     //     $sql .= "{$col} ";
//     // }

//     if ( $where && count( $where ) ) {
//         $sql .= ' WHERE ';
//         $condition = [];
//         foreach ( $where as $field => $value ) {
//             if ( is_array( $value ) ) {
//                 foreach ( $value as $operator => $_value ) {
//                     # code...
//                     switch ( $operator ) {
//                         case 'IN':
//                         $_value = ( is_array( $_value ) ) ? $_value : [ $_value ];

//                         foreach ( $_value as $key => $val ) {

//                             $inarryvalues[] = (is_string($val))?"'{$val}'": "{$val}";;

//                         }
//                         $_value = implode( ',', $inarryvalues );


//                         $condition[] = " {$field} {$operator} ({$_value}) ";
//                         break;

//                         case 'BETWEEN':
//                             // $_value = ( is_array( $_value ) ) ? $_value : [ $_value ];

//                             foreach ( $_value as $key => $val ) {
//                                 $betweenvalues[] = (is_string($val))?"'{$val}'": "{$val}";
//                             }
//                             $betweenvaluestring = implode( ' AND ', $betweenvalues );
//                             // $sql .= "{$field} {$betweenvaluestring}" ;
//                             $condition[] = " {$field} {$operator} {$betweenvaluestring}";
//                             break;

//                         case 'OR':
//                             // $_value = ( is_array( $_value ) ) ? $_value : [ $_value ];
//                             // $orvalues = [];
//                             foreach ( $_value as $key => $val ) {
//                                 $orvalues[$key] = (is_string($val))?"{$field} = '{$val}'": "{$field} = {$val}";
//                             }
//                             $orvaluestring = implode( ' OR ', $orvalues );
//                             // $sql .= "{$field} {$betweenvaluestring}" ;
//                             $condition[] = "({$orvaluestring})";
//                             break;
//                         default:
//                         $condition[] = " {$field} {$operator} '{$_value}' ";
//                         break;
//                     }

//                 }
//             } else {
//                 $condition[] = " {$field} = '{$value}' ";
//             }

//         }
//         $sql .= implode( ' AND ', $condition );
//     }
//     // echo $sql;
//     // echo " * FROM $tablename WHERE 1";
//     return $sql;
// }

// <------------------------------  OLD preparewhere function -------------------------->
// function preparewhere( $where=[] ) {
//     if ( $where && count( $where ) ) {
//       $sql = "";
//       $condition = [];
//       foreach ( $where as $field => $value ) {

//           if ( !is_array( $value ) ) {
//               return " {$field} = '{$value}' ";
//           }
//           switch ($field) {
//               case 'AND':
//               case 'OR':
//                       foreach($value as $key =>$_value){
//                           if(is_array($_value)){
//                               $condition[] = preparewhere($_value);
//                           }
//                           else{
//                           $condition[] = preparewhere([$key => $_value]);
//                           }
//                       }
//                       $sql.=implode(" ".$field." ",$condition);
//                       echo "<br>";
//                       echo "(".$sql.")";
//                       echo "<br>";

//                       return "(".$sql.")";
//               default:
//               if ( is_array( $value ) ) {

//                   foreach ($value as $operator => $_value) {
//                       switch ( $operator ) {
//                           case 'IN':
//                           $_value = ( is_array( $_value ) ) ? $_value : [ $_value ];

//                           foreach ( $_value as $key => $val ) {

//                               $inarryvalues[] = (is_string($val))?"'{$val}'": "{$val}";;

//                           }
//                           $_value = implode( ',', $inarryvalues );


//                           return " {$field} {$operator} ({$_value}) ";
//                           break;

//                           case 'BETWEEN':

//                               foreach ( $value as $key => $val ) {
//                                   $betweenvalues[] = (is_string($val))?"'{$val}'": "{$val}";
//                               }
//                               $betweenvaluestring = implode( ' AND ', $betweenvalues );
//                               // $sql .= "{$field} {$betweenvaluestring}" ;
//                               return  " {$field} {$operator} {$betweenvaluestring}";

//                           default:
//                           $condition[] = " {$field} {$operator} '{$_value}' ";
//                           break;
//                       }
//                   }

//               }
//           }

//       }
//   }
// }
