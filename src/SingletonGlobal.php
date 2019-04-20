<?php
/**
 * SingletonGlobal.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/16
 * Time: 14:07
 */
namespace lewton\framework;

abstract class SingletonGlobal
{
    protected static $instance = [];
    public static function getInstance(...$args){
        // 获取静态方法调用的类名，可以是子类名称
        $class = static::class;
        //$class = get_called_class();
        if( isset(self::$instance[$class]) ){
            return self::$instance[$class];
        }
        self::$instance[$class] = new static(...$args);
        return self::$instance[$class];
    }
}