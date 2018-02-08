<?php
namespace app\controller;
class index{

    public function index(){
        $res=debug('hello world');
        dump($res);
    }
}
