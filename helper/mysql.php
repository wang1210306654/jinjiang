<?php
namespace Helper;
class MysqlHelper
{
    private $mysqli;
    private static $host = 'localhost';
    private static $user = 'www.jjwxc.net';
    private static $pwd = 'www.jjwxc.net';
    private static $dbname = 'jinjiang';

    /** 
    * @info  通过构造方法进行初始化操作
    * 
    * @author      wsh 
    * @data        2020-07-28 
    **/ 
    public function __construct()
    {
        $this->mysqli = new \mysqli(self::$host, self::$user, self::$pwd, self::$dbname);
    }

    /** 
    * @info 执行查询语句 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $sql string sql语句
    * @return      array
    **/ 
    public function execute_dml($sql)
    {
        $arr = array();
        $result = $this->mysqli->query($sql) or die($this->mysqli->error);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                //将查询结果封装到一个数组中，返回给方法调用处
                $arr[] = $row;
            }
            //释放查询结果资源
            $result->free();
        }
        return $arr;
    }

    /** 
    * @info 执行删除、更新语句 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $sql
    * @return      int 
    **/ 
    public function execute_dql($sql)
    {
        $result = $this->mysqli->query($sql) or die($this->mysqli->error);
        var_dump($result);exit;
        if (!$result) {
            return 0; //表示操作失败    
        } else {
            if ($this->mysqli->affected_rows > 0) {
                return 1; //操作成功    
            } else {
                return 2; //没有受影响的行    
            }
        }
    }

    /** 
    * @info 执行增加语句 
    * 
    * @author      wsh 
    * @data        2020-07-28 
    * @param       $sql
    * @return      int 
    **/ 
    public function execute_in($sql)
    {
        $result = $this->mysqli->query($sql) or die($this->mysqli->error);
        if (!$result) {
            return 0; //表示操作失败    
        } else {
            return $this->mysqli->insert_id;
        }
    }
}
