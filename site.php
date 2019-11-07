<?php

use \Hcode\Page;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Model\Cart;


$app->get('/', function() {
    
    $products = Product::listAll();
     
    $page = new Page();
    
    $page->setTpl("index" , [
        "products"=> Product::checkList($products)
        
    ]);
    
});

$app->get("/categories/:idcategory", function($idcategory){
    
        $page = (isset($_GET['page'])) ?(int)$_GET['page'] : 1;
               
        $category = new Category();
        
        $category->get((int)$idcategory);
        
        $pagination = $category->getProductsPage($page);
        
        $pages = [];
        
        for ($i=1; $i <= $pagination['pages']; $i++) {
            array_push($pages, [
                'link'=>'/category/'.$category->getidcategory().'?page='.$i,
                'page'=>$i
            ]);
        }
        
        $page = new Page();
    
        $page->setTpl("category", [
            'category'=>$category->getValues(),
            'products'=>$pagination["data"],
            'pages'=>$pages
                
        ]);
            
});

$app->get("products/:desurl", function($desurl){
        
        $product = new Product();
        
        $product->getFromURL($desurl);
        
        $page = new Page();
        
        $page->setTpl("product-detail", [
            'product'=>$product->getValues(),
            'categorias'=>$product->getCategories()
        ]);
    
});

$app->get("/cart", function(){
    
    
    $cart = Cart::getFromSession();
    
    $page = new Page();
    
    $page->setTpl("cart",[
        'cart'=>$cart->getValues(),
        'products'=>$cart->getProducts(),
        'error'=>Cart::getMsgError()    
            
    ]);
    
});

$app->get("/cart/:idproduct/add", function ($idproduct){
    
    $producto = new Product();
    
    $product->get((int)$idproduct);
    
    $cart = Cart::getFromSession();
    
    $qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;
    
    for ($i = 0; $i < $qtd; $i++) {
        
        $cart->addProduct($product);
    }
    
    $cart->addProduct($product);
    
    header("Location: /cart");
    exit;
        
});

/*remove 1 a 1 */
$app->get("/cart/:idproduct/minus", function ($idproduct){
    
    $producto = new Product();
    
    $product->get((int)$idproduct);
    
    $cart = Cart::getFromSession();
    
    $cart->addProduct($product);
    
    header("Location: /cart");
    exit;
    
    
});

/*remove todos de uma vez */
$app->get("/cart/:idproduct/remove", function ($idproduct){
    
    $product = new Product();
    
    $product->get((int)$idproduct);
    
    $cart = Cart::getFromSession();
    
    $cart->addProduct($product);
    
    header("Location: /cart");
    exit;
    
    
});


$app->post("/cart/freight", function (){
    
    
    $cart = Cart::getFromSession();
    
    $cart->setFreight($_POST['zipcode']);
    
    header("Location: /cart");
    exit;
    
    
    
});


?>
