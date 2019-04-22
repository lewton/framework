<?php
/**
 * Controller.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/04/20
 * Time: 20:13
 */
namespace lewton\framework;

use lewton\framework\response\ResponseObject;

abstract class Controller {

    protected $request = null;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public static function __callStatic($name, $arguments){
        // TODO: Implement __callStatic() method.
    }

    abstract public function index();

    /**
     * 创建ResponseObject对象
     * @access public
     * @param mixed  $data    输出数据
     * @param string $type    输出类型
     * @param int    $code
     * @param array  $header
     * @param array  $options 输出参数
     */
    protected function responseObject($data = null, $type = 'json', $code = 200, array $header = [], $options = []){
        return new ResponseObject($data,$type,$code,$header,$options);
    }
}