<?php
require './vendor/autoload.php';

$config = require './includes/config.php';

\Slim\Slim::registerAutoloader();

// create new Slim instance
$app = new \Slim\Slim();

$app->get('/', function () use ($app) {
  print 'Installation successful';
});

$app->run();
