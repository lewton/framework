<?php
/**
 * Response.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/19
 * Time: 16:59
 */
namespace lewton\framework;

use lewton\framework\response\ResponseAbstract;
use lewton\framework\response\ResponseObject;

class Response extends ResponseAbstract {

    use Singleton;

    public function output(ResponseObject $object){
        // TODO: Implement output() method.
    }
}