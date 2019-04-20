<?php
/**
 * Controller.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/04/20
 * Time: 20:13
 */
namespace lewton\framework;

abstract class Controller {

    protected $request = null;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public static function __callStatic($name, $arguments){
        // TODO: Implement __callStatic() method.
    }
}