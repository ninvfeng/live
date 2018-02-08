<?php
namespace app\controller;
class index{

    public function index(){
        $res=mongodb('hello')->insert(['name'=>'ninvfeng']);
        dump($res);
    }
}
