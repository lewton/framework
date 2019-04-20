<?php
/**
 * Index.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/4/18
 * Time: 14:58
 */
namespace test\controllers;
use lewton\framework\Controller;
use test\config\DbConfig;

class Index extends Controller {
    public function index(){
        /**
         * @var $dbconfig \test\config\DbConfig
         */
        $dbconfig = DbConfig::getInstance();
        var_dump($dbconfig->get('group.b.c'));
    }
}