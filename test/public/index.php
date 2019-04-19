<?php
/**
 * index.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/10
 * Time: 9:46
 */

require "../../vendor/autoload.php";

// 关闭所有PHP错误报告
error_reporting(0);

// 设定错误和异常处理
register_shutdown_function('\lewton\framework\Error::fatalError');
set_error_handler('\lewton\framework\Error::appError');
set_exception_handler('\lewton\framework\Error::appException');

//use lewton\framework\Bootstrap;

\lewton\framework\Bootstrap::getInstance(
// 配置
[
    'app'=>'test'
],
// 事件
new \lewton\framework\Event,
// 语言
new \lewton\framework\lang\LangZhcn
);

//require "../vendor/autoload.php";
//
//use lewton\test\HelloWorld;
//use Medoo\Medoo;
//
//// step1 :
//
//$helloWorld = new HelloWorld();
//$helloWorld->say();
//
//
//// 初始化配置
//$database = new Medoo([
//    'database_type' => 'mysql',
//    'database_name' => 'jifen',
//    'server' => 'localhost',
//    'username' => 'root',
//    'password' => 'root',
//    'charset' => 'utf8'
//]);
//var_dump($database);