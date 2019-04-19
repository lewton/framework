<?php
/**
 * Request.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/17
 * Time: 11:04
 */
namespace lewton\framework;

class Request {

    use Singleton;

    // php://input
    protected $input;
    /**
     * 构造函数
     * @access public
     */
    public function __construct(){
        // 保存 php://input
        $this->input = file_get_contents('php://input');
    }

    /**
     * 当前是否ssl
     * @access public
     * @return bool
     */
    public function isSsl()
    {
        $server = array_merge($_SERVER, $this->server);
        if (isset($server['HTTPS']) && ('1' == $server['HTTPS'] || 'on' == strtolower($server['HTTPS']))) {
            return true;
        } elseif (isset($server['REQUEST_SCHEME']) && 'https' == $server['REQUEST_SCHEME']) {
            return true;
        } elseif (isset($server['SERVER_PORT']) && ('443' == $server['SERVER_PORT'])) {
            return true;
        } elseif (isset($server['HTTP_X_FORWARDED_PROTO']) && 'https' == $server['HTTP_X_FORWARDED_PROTO']) {
            return true;
        } elseif (Config::get('https_agent_name') && isset($server[Config::get('https_agent_name')])) {
            return true;
        }
        return false;
    }

    /**
     * 当前URL地址中的scheme参数
     * @access public
     * @return string
     */
    public function scheme(){
        return $this->isSsl() ? 'https' : 'http';
    }

    /**
     * 设置或获取当前包含协议的域名
     * @access public
     * @param string $domain 域名
     * @return string
     */
    public function domain($domain = null)
    {
        if (!is_null($domain)) {
            $this->domain = $domain;
            return $this;
        } elseif (!$this->domain) {
            $this->domain = $this->scheme() . '://' . $this->host();
        }
        return $this->domain;
    }
}