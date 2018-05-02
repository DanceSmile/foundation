<?php

namespace Dancesmile\Foundation;
use stdclass;


require_once  __DIR__."/../vendor/autoload.php";

/**
 * phpunit test foundation
 */
class FoundationTest   extends Foundation
{

	
    
}


/**
 * 		self::DEBUG     => 'DEBUG',
        self::INFO      => 'INFO',
        self::NOTICE    => 'NOTICE',
        self::WARNING   => 'WARNING',
        self::ERROR     => 'ERROR',
        self::CRITICAL  => 'CRITICAL',
        self::ALERT     => 'ALERT',
        self::EMERGENCY => 'EMERGENCY',
 * @var FoundationTest
 */
$obj = new FoundationTest([
		"param1" => "param1",
		"debug" =>  true,
		"log"  => [
			"name" =>  "application name",
			"file" =>  "./log.log",
			"level" => "DEBUG",
			"permission" => 0777
		]
]); 

































