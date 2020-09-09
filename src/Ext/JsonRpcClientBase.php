<?php declare(strict_types=1);
/**
 * DuckPhp
 * From this time, you never be alone~
 */
namespace DuckPhp\Ext;

use DuckPhp\Ext\JsonRpcExt;
use DuckPhp\SingletonEx\SingletonEx;

class JsonRpcClientBase
{
    use SingletonEx;
    public $_base_class = null;

    
    public function __construct()
    {
    }
    public function __call($method, $arguments)
    {
        $this->_base_class = $this->_base_class?$this->_base_class:JsonRpcExt::G()->getRealClass($this);
        $ret = JsonRpcExt::G()->callRPC($this->_base_class, $method, $arguments);
        return $ret;
    }
}
