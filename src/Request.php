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

    private $_controller = "";
    private $_action = "";

    /**
     * 获取控制器
     * @param string $controller
     * @return string
     */
    public function controller(string $controller = ""): string {
        if($this->_controller === ""){
            $this->_controller = $controller;
        }
        return $this->_controller;
    }

    /**
     * 获取方法
     * @param string $action
     * @return string
     */
    public function action(string $action = ""): string {
        if($this->_action === ""){
            $this->_action = $action;
        }
        return $this->_action;
    }
}