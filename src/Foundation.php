<?php 
namespace Dancesmile\Foundation;


use Pimple\Container;
use stdclass;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
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



