<?php
namespace app\controller;
class index{

    public function index(){
        $res=mongodb('user')->insert(['username'=>'ninvfeng','password'=>'goodluck2018']);
        dump($res);
    }
}
