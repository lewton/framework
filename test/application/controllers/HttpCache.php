<?php
/**
 * HttpCache.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/04/21
 * Time: 19:08
 */
namespace test\controllers;

use lewton\framework\Controller;

class HttpCache extends Controller {
    static $_status = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily ',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',
        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    );
    public function cache(){
        /**
         * 客户端缓存生效的常见流程
         * 服务器收到请求时，会在200OK中回送该资源的Last-Modified和ETag头，
         * 客户端将该资源保存在cache中，并记录这两个属性。
         * 当客户端需要发送相同的请求时，
         * 会在请求中携带If-Modified-Since和If-None-Match两个头。
         * 两个头的值分别是响应中Last-Modified和ETag头的值。
         * 服务器通过这两个头判断本地资源未发生变化，
         * 客户端不需要重新下载，返回304响应。
         */
        // 服务端有内容变化，就更新 $ETag的值，即可通知所有客户端更新数据
        $ETag = "cache test";
        header("Last-Modified: ".gmdate("D, d M Y H:i:s",time()) . " GMT");
        header("ETag: $ETag");
        if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $ETag){
            // 客户端不需要重新下载，返回304响应。
            $code = 304;
            header('HTTP/1.1 '.$code.' '.self::$_status[$code]);
            // 确保FastCGI模式下正常
            header('Status:'.$code.' '.self::$_status[$code]);
            exit("cache");
        }else{
            $code = 200;
            header('HTTP/1.1 '.$code.' '.self::$_status[$code]);
            // 确保FastCGI模式下正常
            header('Status:'.$code.' '.self::$_status[$code]);
            exit("new");
        }
    }

    public function cacheExpires(){
        $ETag = "cache test";
        $expire = 30;
        // 更细致的控制缓存的内容
        header("Cache-Control: max-age=" . $expire . ",must-revalidate");
        // 指示响应内容过期的时间，格林威治时间GMT
        header("Last-Modified: ".gmdate("D, d M Y H:i:s",time()) . " GMT");
        header("Expires: ".gmdate("D, d M Y H:i:s", $_SERVER['REQUEST_TIME'] + $expire) . " GMT");
        header("ETag: $ETag");
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) + $expire > $_SERVER['REQUEST_TIME'] && $_SERVER['HTTP_IF_NONE_MATCH'] == $ETag) {
            // 如果设置了过期时间，在过期时间之前客户端不需要重新下载，返回304响应。
            $code = 304;
            header('HTTP/1.1 '.$code.' '.self::$_status[$code]);
            // 确保FastCGI模式下正常
            header('Status:'.$code.' '.self::$_status[$code]);
            exit("cache");
        }else{
            $code = 200;
            header('HTTP/1.1 '.$code.' '.self::$_status[$code]);
            // 确保FastCGI模式下正常
            header('Status:'.$code.' '.self::$_status[$code]);
            exit("new");
        }
    }
}