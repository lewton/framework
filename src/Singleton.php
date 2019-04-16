<?php
/**
 * Singleton.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/16
 * Time: 14:07
 */
namespace lewton\framework;

trait Singleton
{
    private static $instance;

    static function getInstance(...$args)
    {
        if(!isset(self::$instance)){
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}