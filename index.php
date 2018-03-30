<?php

  require 'vendor/autoload.php';
  
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  
  use GuzzleHttp\Client;
  
  $app = new Silex\Application();   
  
  
  $app->get('/print', function(){
	  $response = new Response(file_get_contents(basename(__FILE__)), 200);
	  if (isset($_GET['public'])) {
		  $response->headers->set('Access-Control-Allow-Origin', '*');
		  $response->headers->set('Content-type', 'text/plain; charset=utf-8');
		  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  }
	  return $response; 
  });
  
  $app->get('/author', function(){
	  $response = new Response('<h4 title="GossJS" id="author">Антон Бабахин</h4>', 200);
	  if (isset($_GET['public'])) {
		  $response->headers->set('Access-Control-Allow-Origin', '*');
		  $response->headers->set('Content-type', 'text/plain; charset=utf-8');
		  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  }
	  return $response; 
  });
  
  $app->get('/info', function(){
	 return phpinfo(); 
  });
  
  $app->get('/', function(){
	  $response = new Response('<h1>'.date("d/m/Y H:i").'</h1>', 200);
	  if (isset($_GET['public'])) {
		  $response->headers->set('Access-Control-Allow-Origin', '*');
		  $response->headers->set('Content-type', 'text/plain; charset=utf-8');
		  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  }
	  return $response; 
  });
  
  $app->post('/haha', function(){
	  $input = array_shift( unpack("C", file_get_contents("php://input")));
	  $output = ~ $input & '255';	  
	  
	  $response = new Response(pack("C", $output), 200);
	  if (isset($_GET['public'])) {
		  $response->headers->set('Access-Control-Allow-Origin', '*');
		  $response->headers->set('Content-type', 'text/plain; charset=utf-8');
		  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  }
	  return $response;	  
  });
  
  $app->get('/weather', function(){
	  $url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20woeid%3D%222123260%22)%20and%20u%3D'c'&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
	  $client = new Client();
	  $request = $client->get($url);
	  $result = json_decode($request -> getBody());
	  $response = new Response($result -> query -> results -> channel -> item -> forecast[1] -> low, 200);		  
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  $response->headers->set('Content-type', 'text/plain; charset=utf-8');
	  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  
	  return $response; 
  });
  
  $app->get('/add/{num1}/{num2}', function(Request $request, $num1, $num2){
	  $result = round($num1) + round($num2);
	  	
	  if ( strpos($request->headers->get('Content-type'), 'application/json') !== false ) {
		  $response = new Response('{"Сумма":' . $result . '}', 200);		  
		  $response->headers->set('Content-type', 'application/json; charset=utf-8');		  
	  } else {
		  $response = new Response("<h1>Сумма:</h1><h2><span>" . $result . "</span></h2>", 200);		  
		  $response->headers->set('Content-type', 'text/html; charset=utf-8');			  	  
	  }
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  return $response; 
  });
  
  $app->get('/sub/{num1}/{num2}', function(Request $request, $num1, $num2){
	  $result = round($num1) - round($num2);
	  	
	  if ( strpos($request->headers->get('Content-type'), 'application/json') !== false ) {
		  $response = new Response('{"Разность":' . $result . '}', 200);		  
		  $response->headers->set('Content-type', 'application/json; charset=utf-8'); 		  
	  } else {
		  $response = new Response("<h1>Разность:</h1><h2><span>" . $result . "</span></h2>", 200);		  
		  $response->headers->set('Content-type', 'text/html; charset=utf-8');		  		  
	  }
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  return $response; 
  });
  
  $app->get('/mpy/{num1}/{num2}', function(Request $request, $num1, $num2){
	  $result = round($num1) * round($num2);
	  	
	  if ( strpos($request->headers->get('Content-type'), 'application/json') !== false ) {
		  $response = new Response('{"Произведение":' . $result . '}', 200);		  
		  $response->headers->set('Content-type', 'application/json; charset=utf-8'); 		  
	  } else {
		  $response = new Response("<h1>Произведение:</h1><h2><span>" . $result . "</span></h2>", 200);		  
		  $response->headers->set('Content-type', 'text/html; charset=utf-8');		  	  
	  }
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  return $response; 
  });
  
  $app->get('/div/{num1}/{num2}', function(Request $request, $num1, $num2){
	  $result = round($num1) / round($num2);
	  	
	  if ( strpos($request->headers->get('Content-type'), 'application/json') !== false ) {
		  $response = new Response('{"Отношение":' . $result . '}', 200);		  
		  $response->headers->set('Content-type', 'application/json; charset=utf-8');		  
	  } else {
		  $response = new Response("<h1>Отношение:</h1><h2><span>" . $result . "</span></h2>", 200);		  
		  $response->headers->set('Content-type', 'text/html; charset=utf-8');		  	  
	  }
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  return $response; 
  });
  
  $app->get('/pow/{num1}/{num2}', function(Request $request, $num1, $num2){
	  $result = pow($num1, $num2);
	  	
	  if ( strpos($request->headers->get('Content-type'), 'application/json') !== false ) {
		  $response = new Response('{"Возведение в степень":' . $result . '}', 200);		  
		  $response->headers->set('Content-type', 'application/json; charset=utf-8'); 		  
	  } else {
		  $response = new Response("<h1>Возведение в степень:</h1><h2><span>" . $result . "</span></h2>", 200);		  
		  $response->headers->set('Content-type', 'text/html; charset=utf-8');		  	  
	  }
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE');
	  return $response; 
  });
  
  
  $app->run();