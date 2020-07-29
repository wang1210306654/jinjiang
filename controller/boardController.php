<?php 
require_once './helper/mysql.php';
require_once './helper/redis.php';
use Helper\MysqlHelper as mysql;
use Helper\RedisHelper as redis;
class boardController{

    /** 
    * @info 写入数据 
    * @methond     POST
    * @author      wsh 
    * @data        2020-07-28 
    * @param       
    * @return      
    **/ 
    public function wirte(){
        $subject = $_POST['subject']?$_POST['subject']:'测试';
        $author = $_POST['author']?$_POST['author']:'测试';
        $body = $_POST['body']?$_POST['body']:'测试';
        $time = time();
        /**
         * mysql插入数据
         */
        $sql = "insert into board(`subject`,`author`,`idate`,`body`,`ip`) value('{$subject}','{$author}',{$time},'{$body}','127.0.0.1');";
        $mysql = new mysql();
        $re = $mysql->execute_in($sql);
        if (!$re){
            exit(json_encode(['code'=>500,'message'=>'插入失败']));
        } 
        /**
         * redis插入数据
         */
        $redis = new redis();
        $re = $redis->zadd('board',$time,$re);
        exit(json_encode(['code'=>200,'message'=>'添加成功']));
    }

    /** 
    * @info 查看数据 
    * @method      POST
    * @author      wsh 
    * @data        2020-07-29 
    * @param       $page int 页码
    * @return      
    **/ 
    public function read(){
        $page = $_POST['page']?$_POST['page']:1;
        /**
         * 通过zset，获倒序ID的数组
         */
        $start = ($page-1)*50;
        $stop = $page*50 - 1;
        $redis = new redis();
        $re = $redis->zrevrange('board',$start,$stop);
        //获取id的集合
        $ids = implode(',',$re);
        //mysql查询
        $sql = "select * from board WHERE id in ({$ids}) order by id desc";
        $mysql = new mysql();
        $re = $mysql->execute_dml($sql);
        exit(json_encode(['code'=>200,'message'=>'','data'=>$re,'page'=>$page+1]));
    }
}