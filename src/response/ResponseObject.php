<?php
/**
 * ResponseObject.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/22
 * Time: 9:38
 */
namespace lewton\framework\response;

final class ResponseObject {
    private $param = [
        'data' => null,
        'type' => 'json',
        'code' => 200,
        'header' => [],
        'options' => []
    ];
    public function __construct($data = null, $type = 'json', $code = 200, array $header = [], $options = []){
        $this->param['data'] = $data;
        $this->param['type'] = $type;
        $this->param['code'] = $code;
        $this->param['header'] = $header;
        $this->param['options'] = $options;
    }
    public function __get($name) {
        return $this->param[$name];
    }
    public function __set($name,$value){
        if(isset($this->param[$name])) {
            $this->param[$name] = $value;
        }
    }
}