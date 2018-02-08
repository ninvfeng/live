<?php
namespace app\controller;
class index{

    public function index(){
        $res=mongodb('hello')->where(['name'=>'ninvfeng1'])->delete();
        dump($res);
    }
}
