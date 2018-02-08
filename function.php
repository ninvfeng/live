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

//调试函数, 将数据记录到debug表
function debug($data){
    if(is_array($data)){
        $data=json_encode($data);
    }
    return db('debug')->insert(['data'=>$data,'created_at'=>date('Y-m-d H:i:s')]);
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
