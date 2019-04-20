<?php
/**
 * DbConfig.php
 * Created by PhpStorm.
 * User: 江小波
 * Date: 2019/04/20
 * Time: 22:11
 */
namespace test\config;

use lewton\framework\config\ConfigAbstract;

/**
 * Class DbConfig
 * @package test\config
 */
class DbConfig extends ConfigAbstract {
    protected $config = [
        'debug' => false,
        'name' => 'db',
        'group' => [
            'a' => [1,2,3],
            'b' => [
                'c' => 'd'
            ]
        ]
    ];
}