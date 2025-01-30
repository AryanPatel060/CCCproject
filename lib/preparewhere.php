<?php
// function preparewhere( $where=[] ) {
//       if ( $where && count( $where ) ) {
//         $sql = "";
//         $condition = [];
//         foreach ( $where as $field => $value ) {      
//             if ( !is_array( $value ) ) {
//                 $condition[] =  " {$field} = '{$value}' ";
//             } else {
//                 switch ($field) {
//                     case 'AND':
//                     case 'OR':
//                         foreach ($value as $key =>$_value)
//                         {
//                             if (is_array($value)) {
//                                 $condition[] = preparewhere($value);
//                             } else {
//                             $condition[] = preparewhere([$key => $_value]);
//                             }
//                         }
//                     $sql.=implode(" ".$field." ",$condition);

//                     return "(".$sql.")";
//                     default:
//                         if ( is_array( $value ) ) 
//                         {
//                             foreach ($value as $operator => $_value) {
//                                 switch ( $operator ) {
//                                     case 'IN':
//                                         $_value = ( is_array( $_value ) ) ? $_value : [ $_value ];

//                                         foreach ( $_value as $key => $val ) {

//                                             $inarryvalues[] = (is_string($val))?"'{$val}'": "{$val}";;

//                                         }
//                                         $_value = implode( ',', $inarryvalues );

//                                         $condition[]= " {$field} {$operator} ({$_value}) ";
//                                         break;

//                                     case 'BETWEEN':
//                                         foreach ( $_value as $key => $val ) {
//                                             $betweenvalues[] = (is_string($val))?"'{$val}'": "{$val}";
//                                         }
//                                         $betweenvaluestring = implode( ' AND ', $betweenvalues );
//                                         $condition[]= " {$field} {$operator} {$betweenvaluestring}";
//                                         break;

//                                     default:
//                                         print_r( $_value);
//                                         $condition[] = " {$field} {$operator} '{$_value}' ";
//                                         break;
//                                 }
//                             }
//                         }
//                 }


//             }
//         }
//         $sql = implode(" AND ", $condition);
//         return $sql;
//     }
//     // return $sql;
// }

// // $pera =

// //         ['OR' => [
// //             'name' => ['IN'=>['b','c']],
// //             'age' => 25
// //         ]]

// //         ;

//         $pera =[
//             'OR' => [
//                 ['AND' => [
//                     'name' => 'aryan',
//                     'age' => 25
//                 ]], 
//                 ['AND' => [
//                     'name' => 'kush',
//                     'age' => 23
//                 ]]
//             ]
//                 ];

// // $pera = ['id'=>['>'=>'32'],'name'=>['LIKE'=>'%yan']];


// $sql = preparewhere($pera);
// echo $sql;










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
                                        $_value = (is_array($_value)) ? $_value : [$_value];

                                        foreach ($_value as $key => $val) {

                                            $inarryvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";;
                                        }
                                        $_value = implode(',', $inarryvalues);

                                        $condition[] = " {$field} {$operator} ({$_value}) ";
                                        break;

                                    case 'BETWEEN':

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
        $sql = implode(" OR ", $condition);
        return $sql;
    }
}

// $pera =

//         ['OR' => [
//             'name' => ['IN'=>['b','c']],
//             'age' => 25
//         ]]

//         ;





// $pera = ['id'=>32,'name'=>'%yan'];
$pera = [
    'AND' => [
        [
            'AND' => [
                [
                    "AND" =>
                    [
                        ["cname" => ["LIKE" => "%hg"]],
                        ['age' => [">" => 89]]
                    ]
                ],
                [
                    'OR' =>
                    [
                        "cname" => "yash",
                        ['age' => ['IN' => [34, 56, 43]]]
                    ]
                ],
                [
                    'AND' =>
                    [
                        "cname" => "Nisarg",
                        ['age' => ['in' => 34]]
                    ]
                ]

            ]
        ],
        [
            'OR' => [
                'name' => 'kush',
                ['age' => ["BETWEEN" => [26, 27]]]
            ]
        ],
        [
            'AND' => [
                'name' => 'jahanvi',
                ['age' => [">" => 26]]
            ]
        ]
    ]
];
$pera = ['name' => '32', 'id' => ['IN' => [32, 45, 67]], 'salary' => ['BETWEEN' => [30000, 40000]], 'age' => ['>' => 18]];



$pera = [

    'AND' => [
        ['OR' => [
            ['AND' => [
                ['name' => ['>' => 'aryan']],
                'age' => 25
            ]],
            ['AND' => [
                'name' => 'kush',
                'age' => 23
            ]]
        ]
    ],
        'name' => '32'
        ]
];


$sql = preparewhere($pera, "AND");
echo "<br>";
echo $sql;

// ------------------------------ Output Generated -------------------------->
// ((( cname LIKE '%hg' AND age = '25' ) OR ( cname = 'yash' OR age = '30' )) AND ( name = 'kush' OR age IN (26,27,28,29) ) AND ( name = 'jahanvi' AND age > '26' ))
