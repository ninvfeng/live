<?php
/*
* 系统函数
*/

//调试函数
function dump($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

//读取配置文件
function config($key=''){
    static $config;
    if(!$config){
        $config=require APP.'/'.'config.php';
    }
    $key=explode('.',$key);
    $res=$config;
    foreach($key as $k => $v){
        $res=$res[$v];
    }
    return $res;
}

//数据库操作快捷方式
function db($table='null'){
    static $_db=[];
    if($_db[$table]){
        return $_db[$table];
    }else{
        $_db[$table]=new \ninvfeng\mysql($table,config('mysql'));
        return $_db[$table];
    }
}

//实例化验证器
function validate($rules=[],$message=[]){
    static $_validate;
    $_validate=new think\Validate();
    $_validate->rule($rules)->message($message);
    return $_validate;
}

//响应请求
function response($data,$msg="数据为空",$code='400'){
    if(isset($data)&&(!empty($data))){
        $code=200;
        $msg='success';
    }
    header('Content-type: application/json');
    $arr = array(
        'data'=>$data,
        'code'=>$code,
        'message'=>$msg,
    );
    echo json_encode($arr);
    exit();
}

//获取get参数
function get($key='null',$rule='null',$message=[]){
    if($key==='null'){
        if($rule==='null'){
            return $_GET;
        }else{
            if(!validate($rule,$message)->check($_GET)){
                response(null,validate()->getError());
            }
            return $_GET;
        }
    }else{
        $key2=explode('.',$key);
        $res=$_GET;
        foreach($key2 as $k => $v){
            $res=$res[$v];
        }
        if($rule==='null'){
            return $res;
        }else{
            if(!validate([$key=>$rule])->check([$key=>$res])){
                if($message){
                    response(null,$message);
                }
                response(null,validate()->getError());
            }
            return $res;
        }
    }
}

//获取post参数
function post($key='null',$rule='null',$message=[]){
    $data = $_POST;
    foreach ($data as $k =>$v){
        if(substr($v,0,1)==':'){
            $data[$k] = substr_replace($v,'',0,1);
        }
    }
    if($key==='null'){
        if($rule==='null'){
            return $data;
        }else{
            if(!validate($rule,$message)->check($data)){
                response(null,validate()->getError());
            }
            return $data;
        }
    }else{
        $key2=explode('.',$key);
        $res=$data;
        foreach($key2 as $k => $v){
            $res=$res[$v];
        }
        if($rule==='null'){
            return $res;
        }else{
            if(!validate([$key=>$rule])->check([$key=>$res])){
                if($message){
                    response(null,$message);
                }
                response(null,validate()->getError());
            }
            return $res;
        }
    }
}

//http请求
function http($url, $params = array(), $method = 'GET', $ssl = false){
    $opts = array(
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $getQuerys = !empty($params) ? '?'. http_build_query($params) : '';
            $opts[CURLOPT_URL] = $url . $getQuerys;
            break;
        case 'POST':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
    }
    if ($ssl) {
        $opts[CURLOPT_SSLCERTTYPE] = 'PEM';
        $opts[CURLOPT_SSLCERT]     = $ssl['cert'];
        $opts[CURLOPT_SSLKEYTYPE]  = 'PEM';
        $opts[CURLOPT_SSLKEY]      = $ssl['key'];;
    }
    /* 初始化并执行curl请求 */
    $ch     = curl_init();
    curl_setopt_array($ch, $opts);
    $data   = curl_exec($ch);
    $err    = curl_errno($ch);
    $errmsg = curl_error($ch);
    curl_close($ch);
    if ($err > 0) {
        $this->error = $errmsg;
        return false;
    }else {
        return $data;
    }
}
