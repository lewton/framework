<?php
/**
 * Event.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/04/20
 * Time: 23:32
 */
namespace test\event;

use lewton\framework\event\EventBase;

class Event extends EventBase {
    // 全局配置
    public static function onConfig(): array{
        return [];
    }
    // 运行前
    public static function onBefore(){

    }
    // 运行后
    public static function onAfter(){

    }
    // shutdown
    public static function onShutdown(){

    }

    public static function onThrowable(){
        // TODO: Implement onThrowable() method.
    }
}