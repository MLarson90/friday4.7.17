<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Brand.php";
  require_once __DIR__.'/../src/Store.php';

  use Symfony\Component\Debug\Debug;
  Debug::enable();

  $app = new Silex\Application();
  $DB = new PDO('mysql:host=localhost:8889;dbname=shoes', 'root', 'root');
  $app['debug'] = true;
  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  $app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig');
  });
  $app->get("/seestores", function() use ($app) {
    return $app['twig']->render('seestores.html.twig', array("stores" => Store::getAll()));
  });
  $app->get("/seebrands", function() use ($app) {
    return $app['twig']->render('seebrands.html.twig', array("brands" => Brand::getAll()));
  });
  $app->get("/addstore", function() use ($app){
    return $app['twig']->render('addstore.html.twig');
  });
  $app->post("/addstore", function() use ($app){
    $store = new Store ($_POST['name'], $_POST['city']);
    $store->save();
    return $app['twig']->render("seestores.html.twig", array( "stores" => Store::getAll()));
  });
  $app->get("/addbrand", function() use ($app){
    return $app['twig']->render("addbrand.html.twig");
  });
  $app->post("/addbrand", function() use ($app){
    $brand = new Brand ($_POST['name'], $_POST['type']);
    $brand->save();
    return $app['twig']->render("seebrands.html.twig", array("brands" => Brand::getAll()));
  });
  $app->get('/store{id}', function($id) use ($app){
    $store = Store::findStorebyId($id);
    $brands = $store->findBrands();
    return $app['twig']->render("store.html.twig", array( 'store' => $store, 'brands' =>$brands, 'allbrands' => Brand::getAll()));
  });
  $app->post("/store/{id}", function($id) use ($app){
    $store = Store::findStorebyId($id);
    $store->update_name($_POST['name']);
    $brands = $store->findBrands();
    return $app['twig']->render("store.html.twig", array( 'store' => $store, 'brands' =>$brands, 'allbrands' => Brand::getAll()));
  });
  $app->post("/newbrand", function() use ($app){
    $newBrand = Brand::findBrandbyId($_POST['brand']);
    $store = Store::findStorebyId($_POST['id']);
    $store->addBrand($newBrand);
    $brands = $store->findBrands();
    return $app['twig']->render("store.html.twig", array('store' => $store, 'brands' => $brands, 'allbrands' => Brand::getAll()));
  });
  $app->post("/store/{id}/edit", function($id) use ($app){
    $store= Store::findStorebyId($id);
    $store->delete();
    return $app['twig']->render("index.html.twig");
  });
  $app->get('/brand{id}', function($id) use ($app){
    $brand = Brand::findBrandbyId($id);
    $stores = $brand->findStores();
    return $app['twig']->render("brand.html.twig", array( 'brand' => $brand, 'stores' =>$stores, 'allstores' => Store::getAll()));
  });
  $app->post("/brand/{id}", function($id) use ($app){
    $brand = Brand::findBrandbyId($id);
    $stores = $brand->findStores();
    return $app['twig']->render("brand.html.twig", array( 'brand' => $brand, 'stores' =>$stores, 'allstores' => Store::getAll()));
  });
  $app->post("/newstore", function() use ($app){
    $newStore = Store::findStorebyId($_POST['store']);
    $brand = Brand::findBrandbyId($_POST['id']);
    $brand->addStore($newStore);
    $brands = $brand->findStores();
    return $app['twig']->render("brand.html.twig", array('brand' => $brand, 'stores' => $brands, 'allstores' => Store::getAll()));
  });
  $app->get("/terminate", function() use ($app){
    return $app['twig']->render("terminate.html.twig");
  });
  $app->post("/index.html", function() use ($app){
    return $app['twig']->render("index.html.twig");
  });
  $app->post("/deleteStores", function() use ($app){
    Store::deleteAll();
    return $app['twig']->render("index.html.twig");
  });
  $app->post("/deleteBrands", function() use ($app){
    Brand::deleteAll();
    return $app['twig']->render("index.html.twig");
  });
  return $app;
 ?>
