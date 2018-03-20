<?php

  require 'vendor/autoload.php';
  
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  
  $app = new Silex\Application(); 
  
  
  if (isset($_GET['public'])) {
	$app->before(function (Request $request, Response $response) {
		$response = new Response();
		$response->headers->set('Access-Control-Allow-Origin', '*');
		$response->headers->set('Content-type', 'text/plain; charset=utf-8');
		$response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	});
  }
  
  $app->get('/print', function(){
	 return file_get_contents(basename(__FILE__)); 
  });
  
  $app->get('/author', function(){
	 return '<h4 title="GossJS" id="author">Антон Бабахин</h4>'; 
  });
  
  $app->get('/info', function(){
	 return phpinfo(); 
  });
  
  
  $app->run();