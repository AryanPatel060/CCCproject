<?php

// $string = 'a b c d';
// if($string)
// {
//     $arr = explode( ' ', $string );
//     $max = 0;
//     $word = '';
//     foreach ( $arr as $k ) {
//         if ( $max < strlen( $k ) )
//         {
//             $max = strlen( $k );
//             $word = $k;
//         }
//     }

//     echo $word."\n";
// }

// $string = "a a b b b";
// $arr = explode( ' ', $string );
// $res = array_count_values( $arr );
// print_r( $res );
// function profitCostPrice(){

//     $cp = 0;
//     $price = 500;
//     $profit = -10;
//     $margin = 100;

//     function cppricetoProfit($cp, $price) {
//         return  (($price / $cp) *100)-100;
//     }
//     function cpprofittoPrice($cp, $profit) {
//         return ((100-$profit) * $cp) /100;
//     }
//     function priceprofittoCp($price, $profit) {
//         return ($price*100)/($profit-100);
//     }

//     if($cp == 0){
//         $cp = priceprofittoCp($price, $profit);
//     } else if ($price == 0){
//         $price = cpprofittoPrice($cp, $profit);
//     } else {
//         $profit = cppricetoProfit($cp, $price);
//     }

//     echo "cost price = ". $cp ."\nprice = ".$price."\nprofit = ".$profit ."%";
// }


// global $data; 


// $data = [
//     'id' => [12, 34, 54, 23, 45, 67, 89, 90, 21, 43],
//     'price' => [110, 2070, 330, 440, 550, 660, 770, 880, 990, 1100],
//     'costprice' => [100, 2000, 300, 400, 500, 600, 700, 800, 900, 1000],
//     'clicks' => [55, 140, 165, 20, 25, 30, 35, 40, 45, 50],
//     'categoryid' => [2, 2, 3, 2, 3, 1, 1, 1, 2, 4]
// ];
// function getdataGoodness($data)
// {

//     $goodness= array_map(function($price, $costprice,$clicks) {
//         return ($price/$costprice)*70 + $clicks*0.3;
//     }, $data['price'], $data['costprice'],$data['clicks']);

//     $data['goodness'] = $goodness;

//     array_multisort($data['goodness'], SORT_DESC, $data['id'], $data['price'],$data['costprice'], $data['clicks']);


//     echo "<pre>";

//     $maxGoodness = max($data["goodness"]);
//     $minGoodness = min($data["goodness"]);

//     foreach ($data["goodness"] as $key => $value)
//     {
//         $data['goodness'][$key] = ($value-$minGoodness)*100/($maxGoodness-$minGoodness);
//     }

//     return $data;
// }
// // $data = getdataGoodness($data);
// // print_r($data);



// function insertcat()
// {

//     $array = [
//         1=>[3,5],
//         2=>[1,2,4]
//     ];

//     // for($i =0; $i<count($productdata);$i++)
//     // {
//         //     foreach ($array as $key => $value) {
//             //         if(in_array($productdata[$i]['product_id'],$value))
//             //         {
//                 //             $productdata[$i]['catagory_id'] = $key;
// //         }
// //     }
// // }



// echo"<pre>";
// print_r($flipp);
// }






// function getcupondiscount(){

//     $productdata = [ 
//         [   
//             'product_id'=>1,
//             'price' => 110,
//             'costprice' => 100,
//             'clicks' => 55,
//         ],
//         [
//             'product_id'=>2,
//             'price' => 2070,
//             'costprice' => 2000,
//             'clicks' => 140,
//         ],
//         [
//             'product_id'=>3,
//             'price' => 330,
//             'costprice' => 300,
//             'clicks' => 165,
//         ],
//         [
//             'product_id'=>4,
//             'price' => 440,
//             'costprice' => 400,
//             'clicks' => 20,
//         ],
//     [
//         'product_id'=>5,
//         'price' => 550,
//         'costprice' => 500,
//         'clicks' => 25,
//         ]    
//     ];

//     $customer = [
//         ['product_id' =>1 , 'qnt'=>8],
//         ['product_id' =>1 , 'qnt'=>8],  
//         // ['product_id' =>1 , 'qnt'=>18],    
//     ];

//     $totalbill = 0;
//     $totalcost = 0 ;
//     $productdatawithkey = [];
//     foreach($productdata as $product)
//     {
//         $productdatawithkey[$product['product_id']] = $product;
//     }


//     foreach($customer as $item)
//     {

//         $totalbill += $productdatawithkey[$item['product_id']]['price']*$item['qnt'];
//         $totalcost += $productdatawithkey[$item['product_id']]['costprice']*$item['qnt'];

//     }
//     echo $totalbill;


//     $cupons = [
//         ['coupon_code' => 'TEST30','from'=>2000, 'to'=>9999999 ,'discount' => 30],
//         ['coupon_code' => 'TEST20','from'=>1500, 'to'=>9999999 ,'discount' => 20],
//         ['coupon_code' => 'TEST10','from'=>0, 'to'=>9999999 ,'discount' => 10],
//     ];
//     $discount = 0;
//     $couponname = "";
// $maxdiscount = 0;

// foreach ($cupons as $cupon)
// {
//     if($totalbill >= $cupon['from'])
//     {
//         $discount = $totalbill*($cupon['discount']/100);
//         if($discount > $maxdiscount)
//         {
//             $maxdiscount = $discount;
//             $couponname = $cupon['coupon_code'];
//         }

//     }
// }


// echo "totalbill = ".$totalbill;
// echo "<br>";
// echo "totalcost = ".$totalcost;
// echo "<br>";

// echo"discount = ".$discount;

// // }
// echo "<br>-------------------<br>";

// echo"fianl amount = ".($totalbill-$discount);

// echo "<br>";
// echo "Coupon :".$couponname;
// echo "<br>";
// echo "<br>";

// echo "Profit = ". round(((($totalbill-$discount)/$totalcost)*100)-100,2) ."%";

// }

// function readcsv()
// {

//     $productdata = [
//         [
//             'product_id',
//             'price',
//             'costprice'
//         ],
//         [
//             2,
//             2070,
//             2000,
//         ],
//         [
//             22,
//             270,
//             4000,
//         ],


//     ];

//     foreach ($productdata as $key => $value) {
//         $array[] = array_combine($productdata[0], $value);
//     }

//     array_shift($array);
//     echo "<pre>";
//     print_r($array);
// }
?>
<?php

class Student
{
    private $name;
    public function __get($name)
    {
        return $name;
    }
}
$s = new Student();
// $s(name) = "charli";
echo $s->name;


class Fruit
{
    public $name;
}
$apple = new Fruit();
$apple->name = "Apple";

echo $apple->name;
?>


<select id='category' name='product[categoryname]' required>
                    <option value='<?php echo ($producteditactive) ? $product['categoryname'] : ""; ?>'><?php echo ($producteditactive) ? $product['categoryname'] : "select category"; ?> </option>
                    <?php foreach ($categories as $category): ?>
                        <?php if ($category['categoryname'] != $product['categoryname']): ?>
                            <option value='<?php echo $category['categoryname']; ?>'><?php echo $category['categoryname']; ?>
                            </option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>