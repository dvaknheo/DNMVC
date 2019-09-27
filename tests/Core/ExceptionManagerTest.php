<?php
namespace tests\DNMVCS\Core;

use DNMVCS\Core\ExceptionManager;

class ExceptionManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testAll()
    {
        \MyCodeCoverage::G()->begin(ExceptionManager::class);
        
         $exception_options=[
            'exception_handler'=>[ExceptionManagerObject::class,'OnException'],
            'dev_error_handler'=>[ExceptionManagerObject::class,'OnDevErrorHandler'],
            //'system_exception_handler'=>[ExceptionManager::G(),'on_exception'],
        ];
        ExceptionManager::G()->init($exception_options);
        ExceptionManager::G()->init($exception_options);
        ExceptionManager::G()->run();
        ExceptionManager::G()->run();
        
        trigger_error("Just use e11",E_USER_NOTICE);
        error_reporting(error_reporting() & ~E_USER_NOTICE);
        trigger_error("Just use error2222222222",E_USER_NOTICE);
        ExceptionManager::G()->on_error_handler(E_DEPRECATED, "Just use e11",__FILE__,__LINE__);
        ExceptionManager::G()->on_error_handler(E_USER_DEPRECATED, "Just use e11",__FILE__,__LINE__);

        try{
        ExceptionManager::G()->on_error_handler(E_USER_ERROR, "Just use e11",__FILE__,__LINE__);
        }catch(\ErrorException $ex){
        }
        $ex=new ExceptionManagerException("ABC",123);
        $ex2=new \Exception("ABCss",123);
        
        ExceptionManager::G()->assignExceptionHandler(ExceptionManagerException::class, function($ex){
            var_dump("OK");
        });
        ExceptionManager::G()->on_exception($ex);
        ExceptionManager::G()->on_exception($ex2);
        ExceptionManager::G()->checkAndRunErrorHandlers($ex2,true);
        
        ExceptionManager::G()->cleanUp();
        
        $default_exception_handler=[ExceptionManager::G(),'on_exception'];
        $class="EX";
        $callback="callback";
        $classes=["ABC"];
        ExceptionManager::G(new ExceptionManager());
        
        ExceptionManager::G()->setDefaultExceptionHandler($default_exception_handler);
        ExceptionManager::G()->assignExceptionHandler($class, $callback=null);
        ExceptionManager::G()->setMultiExceptionHandler($classes, $callback);
        
        \MyCodeCoverage::G()->end(ExceptionManager::class);
        
        $this->assertTrue(true);
        /*
        
        ExceptionManager::G()->setMultiExceptionHandler(array $classes, $callback);
        ExceptionManager::G()->on_error_handler($errno, $errstr, $errfile, $errline);
        ExceptionManager::G()->checkAndRunErrorHandlers($ex, $inDefault);
        ExceptionManager::G()->on_exception($ex);

        //*/
    }
}
class ExceptionManagerException extends \Exception
{

}
class ExceptionManagerObject
{
    public static function set_exception_handler( $exception_handler)
    {

    }
    static function OnException(\Throwable $ex)
    {
        //if( ExceptionManager::G()->
        echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        var_dump(get_class($ex),DATE(DATE_ATOM));
    }
    static function OnDevErrorHandler($errno, $errstr, $errfile, $errline)
    {
        echo (sprintf("ERROR:%X;",$errno).'~'.$errstr.'~'.$errfile.'~'.$errline."\n");
    }
}