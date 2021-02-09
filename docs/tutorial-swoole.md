# 兼容 Swoole v1.2.8 已过时

[toc]
    如果想让你们的项目在 swoole 下也能运行，那就要加上这几点
    
    使用以下参数格式都一样的 swoole 兼容静态方法，代替同名全局方法。
    
    C::session_start(),
    C::session_destroy(),
    C::session_id()，
    如 session_start() => C::session_start();
    
    编写 Swoole 相容的代码，还需要注意到一些写法的改动。
全局变量
```php
global $a='val'; =>  $a=App::GLOBALS('a','val');
```
静态变量 
```php
static $a='val'; =>  $a=App::STATICS('a','val');
```
类内静态变量
```php
$x=static::$abc; => $x=App::CLASS_STATICS(static::class,'abc');
```