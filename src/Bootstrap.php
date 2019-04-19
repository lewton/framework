<?php
/**
 * Bootstrap.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/16
 * Time: 14:07
 */
namespace lewton\framework;

use lewton\framework\event\EventBase;
use lewton\framework\util\Hump;

final class Bootstrap {

    use Singleton;

    // 配置
    private $config = [
        'level' => 3,
        'route_key' => 's',
    ];
    private $route = [];
    /**
     * 构造方法
     * @param array $options 配置
     */
    public function __construct($options = [],EventBase $eventInstance = null){
        if(is_null($eventInstance)){
            $eventInstance = new Event();
        }
        $eventInstance::onConfig();
        /* 获取配置 */
        $this->config   =   array_merge($this->config, $options);

        // 逻辑层级
        $level = intval($this->config['level']);
        if($level < 2){
            throw new \Exception("Level must be greater than 2");
        }

        // 获取 $_GET['s']
        if(isset($_GET[$this->config['route_key']])){
            $this->route = explode("/",trim($_GET[$this->config['route_key']],"/"));
        }else{
            $this->route[] = 'Index';
        }

        // 路由层级
        $routeLevel = count($this->route);

//        $cName = "\\app\\controllers\\";
        $cName = ["app","controllers"];
        $rParam = [];
        if($routeLevel == 1){
            // /index
            $cName[] = Hump::camel($this->route[0]);
            $aName = 'index';
        }else if($routeLevel > $level){
            // /a/b/c/d/e/f/g
            for($i=0;$i<$level-2;$i++){
                $cName[] = $this->route[$i];
            }
            $cName[] = Hump::camel($this->route[$level-2]);
            $aName = Hump::camel($this->route[$level-1]);
            for($ii=$level;$ii<$routeLevel;$ii++){
                if( ($ii-$level)%2 == 0 ){
                    $rParam[$this->route[$ii]] = $this->route[$ii+1]??"";
                }
            }
        }else{
            // /a/b/c
            $pop1 = array_pop($this->route);
            $pop2 = array_pop($this->route);
            foreach ($this->route as $v){
                $cName[] = $v;
            }
            $cName[] = Hump::camel($pop2);
            $aName = Hump::camel($pop1);
        }

        $c = "\\".implode("\\",$cName);

        $instance = new $c();
        try{
            $eventInstance::onBefore();
            Response::getInstance($instance->$aName(Request::getInstance()));
            $eventInstance::onAfter();
        }catch (\Throwable $e){
            $eventInstance::onThrowable();
            if(method_exists($instance,"onThrowable")){
                $instance->onThrowable($e);
            }
        }

        $eventInstance::onShutdown();

        exit;
//        var_dump($_SERVER);
//        var_dump($_GET);
//        var_dump($_POST);
//        var_dump($_FILES);
//        var_dump($_SESSION);
//        var_dump($_COOKIE);
//        var_dump($_ENV);
//        var_dump($_REQUEST);
    }
    /**
     * @param string $name 配置名称
     * @return mixed 配置值
     */
    public function __get($name) {
        return $this->config[$name];
    }
    /**
     * @param string $name 配置名称
     * @param string $value 配置值
     */
    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments){
        var_dump($name, $arguments);
    }
}