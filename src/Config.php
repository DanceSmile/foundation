<?php 
namespace Dancesmile\Foundation;

use Tightenco\Collect\Support\Collection;

/**
 * Config
 */
class Config extends Collection
{


	public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->items[$key];
        }elseif(trim(strpos($key, "."),".") ){
        	$keys = explode(".", $key);
            if($this->offsetExists($keys[0]) && $parentValue = $this->items[$keys[0]]  && isset($this->items[$keys[0]][$keys[1]]) ){
        	  return ($this->items[$keys[0]][$keys[1]]);
            }
        }

        return value($default);
    }

    
}