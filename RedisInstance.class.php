<?php

class RedisInstance
{
    private $redis;

    public function __construct($host = '127.0.0.1', $port = 6379)
    {
        $this->redis = new Redis();

        $this->redis->connect($host, $port);
    }


    public function psubscribe($patterns = array(), $callback)
    {
        $this->redis->psubscribe($patterns, $callback);
    }
    public function setOption()
    {
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT,-1);
    }

}