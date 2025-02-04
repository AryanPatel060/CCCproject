<?php 
class Admin_Code_Product{
    public function list()
    {
        echo "List";
        include_once(BASE_DIRECTORY."/Admin/Design/Product.phtml");
    }
    public function getProducts()
    {
        echo "get product";

        include_once(BASE_DIRECTORY."/Admin/Design/ListProduct.phtml");
        return [1,2,3,4];
    }
}
?>