<?php
/**
 * Handler.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/3/7
 * Time: 13:37
 */
namespace lewton\framework\error;

interface Handler {
    // 致命错误捕获
    public static function fatalError();
    /**
     * 自定义错误处理
     * ex:
     * trigger_error("用户常用错误信息，后续代码继续执行",E_USER_ERROR);
     * trigger_error("用户注意错误信息，后续代码继续执行",E_USER_NOTICE);
     * trigger_error("用户弃用错误信息，后续代码继续执行",E_USER_DEPRECATED);
     * trigger_error("用户警告错误信息，后续代码继续执行",E_USER_WARNING);
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    public static function appError($errNo, $errStr, $errFile, $errLine);
    /**
     * 自定义异常处理
     * ex:
     * throw new \Exception("抛出异常了，后续程序不再执行",0);
     * @access public
     * @param mixed $e 异常对象
     */
    public static function appException($e);
}