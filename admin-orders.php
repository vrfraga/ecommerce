<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use Hcode\Model\Order;
use Hcode\Model\OrderStatus;


$app->get("/admin/orders/:idorder/status", function ($idorder){ 
    
    User::verifyLogin();
    
    $order = new Order();
    
    $order->get((int)$idorder);
    
    $page = new PageAdmin();
    
    $page->setTpl("order-status", [ 
        'order'=>$order->getValues(),
        'status'=>OrderStatus::listAll(),
        'msgSuccess'=>Order::getSuccess(),
        'msgErros'=>Order::getError()
    
        
    ]);   
    
});

$app->post("/admin/orders/:idorder/status", function ($idorder){ 
    
    User::verifyLogin();

    if (!isset($_POST['idstatus']) || !(int) $_POST['idstatus'] > 0) { 
       Order::setError("Informe o status atual.");
       header("Location: /admin/orders/".$idorder."/status");
       exit;        
    }    
   
    $order = new Order();
    
    $order->get((int)$idorder);

    $order->setidstatus((int)$_POST['idstatus']);
    
    $order->save();
    
    Order::setSucssess("Status Atualizado");
    header("Location: /admin/orders/".$idorder."/status");
    exit; 
    
});   



$app->get("/admin/orders/:idorder/delete", function ($idorder){
    
   User::verifyLogin();
   
   $order->get((int)$idorder);
   
   $order->delete();
   
   header("Location: /admin/orders");
   exit;    
    
});

    
$app->get("/admin/orders/:idorder", function($idorder){
    
   User::verifyLogin();
   
   $order = new Order();
   
   $order->get((int)$idorder); 
   
   $cart = $order->getCart();
   
   $page = new PageAdmin();
   
   $page->setTpl("order", [
       'order'=>$order->getValues(),  
       'cart'=>$cart->getValues(),
       'products'=>$cart->getProducts()
       
    ]);
    
});
       


$app->get("/admin/orders", function(){  
    
    User::verifyLogin(); /* na classe user e executa o objeto verifyLogin */
    
    /* executa o tamplate orders*/
    $page->setTpl("orders", [   
        "orders"=>Order::listAll()    /*na classe order e executa o objeto listAll */
        
        
    ]);   
    
    
});


$app->get("/admin/orders/:idorder/status", function($idorder){ 
    
    User::verifyLogin();
    
    $order = new Order();  
    
    
});

