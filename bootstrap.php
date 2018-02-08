<?php

//框架核心文件
class bootstrap{

    //启动框架
    static public function run(){

        //解析路由
        $path=$_SERVER['REQUEST_URI']=='/'?'index/index':$_SERVER['REQUEST_URI'];
        $path=str_replace('index.php','',trim($path));
        if(strstr($path,'?'))
            $path=trim(strstr($path,'?',true),'/');
        else
            $path=trim($path,'/');
        unset($_GET[$path]);
        $path=explode('/',$path);
        $action=array_pop($path);
        $controller=array_pop($path);
        $dir=implode('/',$path);

        //控制器文件
        $file=APP.'controller/'.$dir.'/'.$controller.'.php';

        //控制器类名
        $class='\\app\\controller\\'.str_replace('/','\\',$dir).($dir?'\\':'').$controller;

        //调用控制器方法
        static $_controller;
        if(!$_controller[$class]){
            $_controller[$class]=new $class;
        }
        if(method_exists($_controller[$class],$action)){
            $_controller[$class]->{$action}($param);
        }
    }

    //根据命名空间自动加载php文件
    static public function autoload($class){
        $class=str_replace('\\','/',$class);
        $file=PATH.'/'.$class.'.php';
        require $file;
    }
}
