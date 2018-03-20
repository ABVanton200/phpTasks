<?php

  require 'vendor/autoload.php';
  
  $app = new Silex\Application();
  
  $app->get('/hello/{name}', function($name) use ($app) {
	 return 'Hello '.$app->escape($name); 
  });
  
  $app->get('/date', function(){
	 return date('r'); 
  });
  
  
  $app->run();