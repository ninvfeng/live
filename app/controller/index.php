<?php
namespace app\controller;
class index{

    public function index(){
        $id=get('id','require|min:5','请填写ID且最小长度为5');
        $name=get('name','require','名称必填');
        dump($id);
        dump($name);
    }
}
