<?php
use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace
//include productsProc.php file
include __DIR__ . '/function/productProc.php';
//read table products
$app->get('/product', function (Request $request, Response $response, array $arg){
 return $this->response->withJson(array('data' => 'success'), 200);
});
//request table products by condition
$app->get('/products/[{name}]', function ($request, $response, $args){

 $productname = $args['name'];
 if (!is_string($productname)) {
 return $this->response->withJson(array('error' => 'please enter product name only'), 422);
 }
 $data = getProduct($this->db,$productname);
 if (empty($data)) {
 return $this->response->withJson(array('error' => 'no data'), 404);
}
 return $this->response->withJson(array('data' => $data), 200);
});


$app->post('/insertProduct', function(Request $request, Response $response,array $arg){  

    $form_data=$request->getParsedBody();
    $data = createProduct($this->db, $form_data);
  
    if (is_null($data)) {
      return $this->response->withJson(array('error' => 'no data'), 404);
    }
    
  
  return $this->response->withJson(array('data' => 'successfully added'), 200);
    
  
  });

  //delete row
    $app->delete('/products/del/[{name}]', function ($request, $response, $args){

    $productname = $args['name'];
   if (!is_string($productname)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
   }
   $data = deleteProduct($this->db,$productname);
   if (empty($data)) {
   return $this->response->withJson(array($productname=> 'is successfully deleted'), 202);};
   });


   //put table products
   $app->put('/products/put/[{name}]', function ($request, $response, $args){
    $productname = $args['name'];
    $date = date("Y-m-j h:i:s");
   
   if (!is_string($productname)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
   }
    $form_dat=$request->getParsedBody();
   
   $data=updateProduct($this->db,$form_dat,$productname,$date);
   if ($data <=0)
   return $this->response->withJson(array('data' => 'successfully updated'), 200);
});
