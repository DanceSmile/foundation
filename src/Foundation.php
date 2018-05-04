<?php 
namespace Dancesmile\Foundation;


use Pimple\Container;
use stdclass;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\ErrorHandler;
use Dancesmile\Foundation\Support\Config;
use Monolog\Handler\HandlerInterface;


use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\ChromePHPFormatter;
use Monolog\Formatter\HtmlFormatter;


/**
 * Foundation
 */

abstract class Foundation extends Container
{

	public $middleware = [];

	protected $providers = [];



    
	public function __construct( array $config = [])
	{
		parent::__construct();

		$this["config"] = function (Container $container) use ( $config )
		{
			return new Config($config);
		};


        if ($this['config']->get('debug', false)) {
            error_reporting(E_ALL);
        }

        $this->registerBase();

		$this->registerProviders();

		$this->initializeLogger();



		
	}

	private function registerBase()
	{
		if (!empty($this['config']['cache']) && $this['config']['cache'] instanceof Cache) {
            $this['cache'] = $this['config']['cache'];
        } else {
            $this['cache'] = function () {
                return new FilesystemCache(sys_get_temp_dir());
            };
        }

	}

	public function initializeLogger()
	{
		if (Log::hasLogger()) {
            return;
        }
        $ChromePHPFormatter = $this['config']->get('log.handler');
        // dd($ChromePHPFormatter instanceof HandlerInterface);
        $logger = new Logger($this['config']->get('log.name', 'foundation'));
        if (!$this['config']->get('debug') || defined('PHPUNIT_RUNNING')) {
            $logger->pushHandler(new NullHandler());
        } elseif ($this['config']->get('log.handler') instanceof HandlerInterface) {
            $logger->pushHandler($this['config']->get('log.handler'));
        } elseif ($logFile = $this['config']->get('log.file')) {
        	$logger->pushProcessor(function ($record)
                    {
                    	return $record;
                   }
            );
            $logger->pushHandler(
            	(
            		new StreamHandler(
                    $logFile,
                    $this['config']->get('log.level', Logger::WARNING),
                    true,
                    $this['config']->get('log.permission', null)
                    )
                )
            );
        }

        Log::setLogger($logger);
	}
	public function __get($id)
	{

		return $this->offsetGet($id);
		
	}

	public function __set($id, $value)
	{
		return $this->offsetSet($id, $value);
		
	}

	protected  function registerProviders()
	{

		foreach ($this->providers as $provider) {
			$this->register(new $provider());

		}
		
	}


}



