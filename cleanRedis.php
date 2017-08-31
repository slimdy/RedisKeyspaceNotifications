<?php
/**
 * Created by PhpStorm.
 * User: slimdy
 * Date: 2017/8/14
 * Time: 下午1:56
 */

$redis = new Redis();
$redis->connect('127.0.0.1', '6379');
$conn_string  =  "host=127.0.0.1 port=5432 dbname=test user=root password=root" ;
$dbconn = pg_connect($conn_string) or die('连接失败');
function logOut($token){
    $url = "http://127.0.0.1/quitQuery?token".$token; //请求地址
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $content = curl_exec($ch); //执行并获取返回数据
    curl_close($ch);
    return $content;
}
if (is_string($argv[1])){
    print_r('接受到'.$argv[1]."\n");
    $result = logOut($argv[1]);
    try{
        $str = base64_decode($argv[1]);
        $username = explode(':',$str)[2];
        var_dump($username."\n");
        $r = $redis->keys($argv[1].'*');
        print_r($r."\n");
        $redis->del($r);
        $sql = 'update "public".yd_developer set "token"=NULL , "isLogin"= 0 where(username= \''.$username.'\')';
        print_r($sql."\n");
        pg_prepare($dbconn,'update',$sql);
        pg_exec($dbconn,$sql);
    } catch (Exception $e){
        print_r($result.'\n');
    }
}else{
    print_r('参数错误'."\n");
}
