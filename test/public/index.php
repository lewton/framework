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
register_shutdown_function('\lewton\framework\error\Error::fatalError');
set_error_handler('\lewton\framework\error\Error::appError');
set_exception_handler('\lewton\framework\error\Error::appException');

use lewton\framework\Bootstrap;

// 初始化
Bootstrap::getInstance([
    'app'=>'test'
]);

// 请求定义
Bootstrap::getInstance()->requestDefine(
    \test\request\Request::class
);

// 响应定义
Bootstrap::getInstance()->responseDefine(
    \test\response\Response::class
);

// 全局事件定义
Bootstrap::getInstance()->eventDefine(
    \test\event\Event::class
);

// 语言定义
Bootstrap::getInstance()->langDefine(
    \lewton\framework\lang\LangZhcn::class
);

// 运行
Bootstrap::getInstance()->run();

exit;

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