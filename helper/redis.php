<?php
namespace Helper;
class RedisHelper{
    private $redis;
    private static $host = 'localhost';
    private static $port = 6379;
    private static $db = 1;
    //通过构造方法进行初始化操作
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->open(self::$host, self::$port);
        $this->redis->select(self::$db);
    }
    /** 
    * @info 设置zset值 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $key    string zset 集合名称
    * @param       $member string 元素
    * @param       $source int    权重
    * @return      int 0 已存在 1 插入成功
    **/ 
    public function zadd($key,$member,$source){
        return $this->redis->zAdd($key,$member,$source);
    }

    /** 
    * @info 删除成员 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $key    string zset 集合名称
    * @param       $member string 元素
    * @return      int 返回删除个数
    **/ 
    public function zdel($key,$member){
        return $this->redis->zrem($key,$member);
    }

    /** 
    * @info 通过(score从小到大)排名次序获取member值 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $key   strring zset 集合名
    * @param       $start int 开始
    * @param       $stop  int 结束
    * @return      array
    **/ 
    public function zrange($key,$start,$stop){
        return $this->redis->zrange($key,$start,$stop);
    }

    /** 
    * @info 通过(score从大到小)排名次序获取member值 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $key   strring zset 集合名
    * @param       $start int 开始
    * @param       $stop  int 结束
    * @return      array
    **/ 
    public function zrevrange($key,$start,$stop){
        return $this->redis->zrevrange($key,$start,$stop);
    }

    /** 
    * @info 返回zset中元素个数 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $key  string zset集合名
    * @return      int 元素个数
    **/ 
    public function znum($key){
        return $this->redis->zcard($key);
    }

}