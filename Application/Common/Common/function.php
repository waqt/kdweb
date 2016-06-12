<?php


/**
 * 创建logic
 * @param string $name logic名称
 * @return Admin\Logic
 * @author liutj
 */
function logic($name) {
	$name = ucfirst($name);
    static $_logic  =   array();
    if(isset($_logic[$name]))
        return $_logic[$name];
    $class      =   '\\Logic\\' . $name . 'Logic';
    $logic      =   class_exists($class)? new $class : new \Admin\Logic\BaseLogic;
    $_logic[$name]  =  $logic;
    return $logic;
}

/**
 * 创建service
 * @param string $name service名称
 * @return Service\BaseService
 * @author liutj 
 */
function service($name) {
    $name = ucfirst($name);
    static $_service  =   array();
    if(isset($_service[$name]))
        return $_service[$name];
    $class      =   '\\Service\\' . $name . 'Service';
	$service      =   class_exists($class)? new $class : new \Service\BaseService;
    $_service[$name]  =  $service;
    return $service;
}


/**
 * 创建service
 * @param string $name service名称
 * @return Model\BaseModel
 * @author liutj
 */
function model($name) {
    $name = ucfirst(parse_name($name, 1));
    static $_model  =   array();
    if(isset($_model[$name]))
        return $_model[$name];
    $class      =   '\\Model\\' . $name . 'Model';
    $model      =   class_exists($class)? new $class : new \Think\Model($name);
    $_model[$name]  =  $model;
    return $model;
}