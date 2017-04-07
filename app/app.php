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

  return $app;
 ?>
