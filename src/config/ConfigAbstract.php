<?php
/**
 * ConfigAbstract.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/04/20
 * Time: 21:32
 */
namespace lewton\framework\config;

use lewton\framework\SingletonGlobal;

abstract class ConfigAbstract extends SingletonGlobal {

    protected $config = [];

    public function get(string $name){
        $value = '$this->config';
        foreach (explode(".",$name) as $key){
            $value .= '["'.$key.'"]';
        }
        $val = null;
        @eval('$val = '.$value.'??null;');
        return $val;
    }
}