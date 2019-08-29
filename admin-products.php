<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;

$app->get("/admin/products", function() {
    
    User::verifyLogin();
    
    $products = Product::listAll();
            
    $page = new PageAdmin();
    
    $page->setTpl("products", [
        "products"=>$products
    ]);
    
});

//rota para a tela de criação
$app->get("/admin/products/create", function() {
    
    User::verifyLogin();
                   
    $page = new PageAdmin();
    
    $page->setTpl("products-create");
    
});

//rota para inserir novo produto 
$app->post("/admin/products/create", function() {
    
    User::verifyLogin();
                   
    $product = new Product();
    
    $product->setData($_POST);
    
    $product->save();
        
    header("Location: /admin/products");
    exit;
    
});

//rota para editar um produto 
$app->get("/admin/products/:idproduct", function($idproduct) {
    
    User::verifyLogin();
    
    $product = new Product();
    
    $product->get((int)$idproduct);
                   
    $page = new PageAdmin();
    
    $page->setTpl("products-update" , [
        "product"=>$product->getValues()
    ]);
    
});

//rota para inserir uma foto na pasta products
$app->post("/admin/products/:idproduct", function($idproduct) {
    
    User::verifyLogin();
    
    $product = new Product();
    
    $product->get((int)$idproduct);
                   
    $product->setData($_POST);
    
    $product->save();
    
    $product->setPhoto($_FILES["file"]);
    
    header('LOCATION: /admin/products');
    exit;
    
});   


$app->get("/admin/products/:idproduct/delete", function($idproduct) {
    
    User::verifyLogin();
    
    $product = new Product();
    
    $product->get((int)$idproduct);

    $product->delete();
    
    header('LOCATION: /admin/products');
    exit;
    
    
   
});


?>