<?php

require_once dirname(__FILE__).'/RedisInstance.class.php';
$redis = new RedisInstance();
// 解决Redis客户端订阅时候超时情况

$redis->setOption();
print_r('已开启');
$redis->psubscribe(array('__keyevent@0__:expired'), 'psCallback');
// 回调函数,这里写处理逻辑
function psCallback($redis, $pattern, $chan, $msg)
{
    print_r('回调函数开始执行...');
    print_r($msg.'已过期'."\n");
    system('mphp '.dirname(__FILE__).'/cleanRedis.php '.$msg,$out);
    print_r('回调函数结束，等待下次回调...');
}