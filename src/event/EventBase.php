<?php
/**
 * EventBase.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/18
 * Time: 9:41
 */
namespace lewton\framework\event;

abstract class EventBase {
    // 全局配置
    abstract public static function onConfig(): array;
    // 运行前
    abstract public static function onBefore();
    // 运行后
    abstract public static function onAfter();
    // 抛出异常
    abstract public static function onThrowable();
    // shutdown
    abstract public static function onShutdown();
}