<?php
/**
 * Error.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/3/7
 * Time: 13:32
 */
namespace lewton\framework\error;

class Error implements Handler {
    public static function fatalError(){
        if ($e = error_get_last()) {
            switch($e['type']){
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    ob_end_clean();

                    // 请再这里进行实现
                    var_dump('fatalError',$e);

                    break;
            }
        }
        // app end
        // 正常结束程序
        exit;
    }
    public static function appError($errNo, $errStr, $errFile, $errLine){
        var_dump('appError',$errNo, $errStr, $errFile, $errLine);
    }
    public static function appException($e)
    {
        var_dump('appException',$e);
    }
}