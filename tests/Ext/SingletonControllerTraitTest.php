<?php
namespace tests\DuckPhp\Ext;

use DuckPhp\Ext\SingletonControllerTrait;
use DuckPhp\Core\App;

class SingletonControllerTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testAll()
    {
        \LibCoverage\LibCoverage::Begin(SingletonControllerTrait::class);
        
        $options=[
            'is_debug' => true,
            'namespace_controller'=>'\tests\DuckPhp\Ext',
        ];
        App::G()->init($options);
            App::G()->system_wrapper_replace(['exit'=>function($code=0){
            echo 'Exit';
            return ;
        }]);
        App::Route()->setPathInfo('/MyController/helper');
        App::G()->run();

        App::Route()->setPathInfo('/MyController/foo');
        App::G()->run();
        Base::G(MyBase::G());
        App::Route()->setPathInfo('/MyController/foo');
        App::G()->run();
        \LibCoverage\LibCoverage::End();
    }
}
class ProjectController
{
    use SingletonControllerTrait;
    
    public function helper()
    {
        //
    }
    public static function H()
    {
        return static::G()->helper();
    }
}
class Base extends ProjectController
{
}
class MyBase extends Base
{
}
class MyController extends Base
{
    public function foo()
    {
        Base::H();
    }
    public function __construct()
    {
        parent::__construct();
    }

}
