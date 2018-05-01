<?php

namespace Dancesmile\Foundation;


require_once  __DIR__."/../vendor/autoload.php";

/**
 * phpunit test foundation
 */
class FoundationTest   extends Foundation
{

	
    
}


$obj = new FoundationTest([
		"username" => "username",
		"password"  => "password"
]); 


$config = $obj->config;

// dd($obj->httpClient);


$cache = $obj->cache;

$cache->save("name","cailei");




try{
	$a = 1/0/0;
}catch( \Exception $e){

 echo 999;
}








