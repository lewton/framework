<?php
/**
 * Bootstrap.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/16
 * Time: 14:07
 */
namespace lewton\framework;

use lewton\framework\event\Event;
use lewton\framework\event\EventBase;
use lewton\framework\util\Hump;
use lewton\framework\lang\LangBase;

final class Bootstrap {

    use Singleton;

    // 配置
    private $config = [
        'level' => 3,
        'route_key' => 's',
        'app' => 'app',
        'controllers' => 'controllers',
        'def_c' => 'Index',
        'def_a' => 'index',
        'try_handler' => 'onThrowable',
        'cache_expire' => 30
    ];

    /**
     * 请求对象
     */
    private $request = null;
    /**
     * 响应对象
     */
    private $response = null;
    /**
     * 全局事件
     */
    private $event = null;
    /**
     * 语言
     */
    private $lang = null;

    // 路由
    private $route = [];
    /**
     * 构造方法
     * @param array $options 配置
     */
    public function __construct($options = []){
        /* 获取配置 */
        $this->config   =   array_merge($this->config, $options);
    }

    public function requestDefine($requestClass){
        $reflectionClass = new \ReflectionClass($requestClass);
        $this->request = $reflectionClass->newInstance();
    }
    public function responseDefine($responseClass){
        $reflectionClass = new \ReflectionClass($responseClass);
        $this->response = $reflectionClass->newInstance();
    }
    public function eventDefine($eventClass){
        $reflectionClass = new \ReflectionClass($eventClass);
        $this->event = $reflectionClass->newInstance();
    }
    public function langDefine($langClass){
        $reflectionClass = new \ReflectionClass($langClass);
        $this->lang = $reflectionClass->newInstance();
    }

    public function setRoute(string $route_key = ""){
        // 逻辑层级
        $level = intval($this->config['level']);
        if($level < 2){
            // level必须大于2
            throw new \Exception($this->lang::SYS_MSG_LEVEL);
        }

        $route = [];
        $route_temp = "";

        if($route_key === ""){
            $route_temp = $_GET[$this->config['route_key']]??"";
        }else{
            $route_temp = $route_key;
        }

        if($route_temp !== ""){
            $route = explode("/",trim($route_temp,"/"));
        }else{
            $route[] = $this->config['def_c'];
        }

        // 路由层级
        $routeLevel = count($route);

//        $cName = "\\app\\controllers\\";
        $cName = [$this->config['app'],$this->config['controllers']];
        $rParam = [];
        if($routeLevel == 1){
            // /index
            $cName[] = Hump::camel($route[0]);
            $aName = $this->config['def_a'];
        }else if($routeLevel > $level){
            // /a/b/c/d/e/f/g
            for($i=0;$i<$level-2;$i++){
                $cName[] = $route[$i];
            }
            $cName[] = Hump::camel($route[$level-2]);
            // $aName = Hump::camel($route[$level-1]);
            $aName = $route[$level-1];
            for($ii=$level;$ii<$routeLevel;$ii++){
                if( ($ii-$level)%2 == 0 ){
                    $rParam[$route[$ii]] = $route[$ii+1]??"";
                }
            }
        }else{
            // /a/b/c
            $pop1 = array_pop($route);
            $pop2 = array_pop($route);
            foreach ($route as $v){
                $cName[] = $v;
            }
            $cName[] = Hump::camel($pop2);
            // $aName = Hump::camel($pop1);
            $aName = $pop1;
        }

        if($route_key !== ""){
            return ["cName"=>$cName,"aName"=>$aName];
        }

        $this->route = ["cName"=>$cName,"aName"=>$aName];
        return $this->route;
    }

    /**
     * @throws \Exception
     */
    public function run(){
        if(method_exists($this->event,"onRouteBefore")){
            $this->event::onRouteBefore();
        }
        $this->setRoute();
        if(method_exists($this->event,"onRouteAfter")){
            $this->event::onRouteAfter();
        }
        // 控制器
        $c = "\\".implode("\\",$this->route['cName']);
        // 方法
        // $a = lcfirst($aName);
        $a = $this->route['aName'];

        // 反射实例化控制器类
        $reflectionClass = new \ReflectionClass($c);
        $cInstance = $reflectionClass->newInstance(Request::getInstance());

        if(!method_exists($cInstance,$a)){
            // 当前访问的action不存在
            throw new \Exception($this->lang::SYS_MSG_ACTION);
        }

        try{
//            // 设置请求路由
            Request::getInstance()->controller($c);
            Request::getInstance()->action($a);
//            // 开始执行业务
            if(method_exists($this->event,"onBefore")){
                $this->event::onBefore();
            }
            // call_user_func_array([$cInstance,$a],[param1,param2]);
            // call_user_func([$cInstance,$a],param1,param2);
//            Response::getInstance()->send( call_user_func([$cInstance,$a]) );
            call_user_func([$cInstance,$a]);
            if(method_exists($this->event,"onAfter")){
                $this->event::onAfter();
            }
        }catch (\Throwable $e){
            if(method_exists($this->event,"onThrowable")){
                $this->event::onThrowable($e);
            }
            if(method_exists($cInstance,$this->config['try_handler'])){
//                Response::getInstance()->send( call_user_func([$cInstance,$this->config['try_handler']],$e) );
                call_user_func([$cInstance,$this->config['try_handler']],$e);
            }
        }

        if(method_exists($this->event,"onShutdown")){
            $this->event::onShutdown();
        }
    }
}