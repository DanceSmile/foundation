<?php 
namespace Dancesmile\Foundation\Support;

use ArrayAccess;


/**
 * Config
 */
class Config  implements ArrayAccess
{

    protected $items;

    /**
     * [__construct description]
     * @param array $items [description]
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * [offsetExists description]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);

    }

    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;

    }

    /**
     * [offsetGet description]
     * @param  [type] $offset [description]
     * @return [type]         [description]
     */
    public function offsetGet($offset)
    {

        return $this->get($offset);

    }

    /**
     * [offsetUnset description]
     * @param  [type] $offset [description]
     * @return [type]         [description]
     */
    public function offsetUnset($offset)
    {

        if(isset($this->items[$offset])){
            unset($this->items[$offset]);
        }
    }


    /**
     * [get description]
     * @param  [type] $key     [description]
     * @param  [type] $default [description]
     * @return [type]          [description]
     */
	public function get($key, $default = null)
    {

        $config = $this->items;

        if(is_null($key)){
            return $default;
        }

        if(isset($config[$key])){
            return $config[$key];
        }

         foreach (explode('.', $key) as $segment) {
            if (!is_array($config) || !array_key_exists($segment, $config)) {
                return $default;
            }
            $config = $config[$segment];
        }

        return $config;
        
    }

    
}