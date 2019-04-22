<?php
/**
 * ResponseAbstract.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/22
 * Time: 10:10
 */
namespace lewton\framework\response;

abstract class ResponseAbstract {
    abstract public function output(ResponseObject $object);

    public function send(ResponseObject $object){
        // if($c instanceof Closure)
        $type = strtolower($object->type);
        $header = [];
        if( $type === 'json' ){
            $instance = new Json();
        }else {
            $instance = new static();
        }
        $headers = array($object->header,$header);

        // 输出
        $instance->output($object);
    }
}