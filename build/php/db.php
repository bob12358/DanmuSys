<?php

class DB
{
    var $dbms = 'mysql';     //数据库类型

    // var $host = 'qdm156187226.my3w.com';
    // var $dbName = 'qdm156187226_db';    //使用的数据库
    // var $user = 'qdm156187226';      //数据库连接用户名
    // var $pass = 'codemao91';          //对应的密码*/

    var $host = 'localhost';
    var $dbName = 'danmu';    //使用的数据库
    var $user = 'root';      //数据库连接用户名
    var $pass = 'root';          //对应的密码*/


    private static $_instance = null;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    /**
     * sql语句执行封装
     * @param $sql : sql语句
     * @param $array ：sql语句的参数
     */
    static function sqlExecute($sql, $array = null)
    {
        $dbInfo = self::getInstance();
        $dsn = "$dbInfo->dbms:host=$dbInfo->host;dbname=$dbInfo->dbName";
        try {

            $dbh = new PDO($dsn, $dbInfo->user, $dbInfo->pass); //初始化一个PDO对象
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->exec('set names utf8;');
            $dbh->beginTransaction();

            $sth = $dbh->prepare($sql);


            $sth->execute($array);
            $dbh->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $dbh->rollBack();
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }

    /**
     * sql语句查询封装
     * @param $sql : sql语句
     * @param $array ：sql语句的参数
     * @return string
     */
    static function sqlQuery($sql, $array)
    {
        $dbInfo = self::getInstance();
        $dsn = "$dbInfo->dbms:host=$dbInfo->host;dbname=$dbInfo->dbName";
        try {
            $dbh = new PDO($dsn, $dbInfo->user, $dbInfo->pass); //初始化一个PDO对象
            $dbh->exec('set names utf8;');
            $sth = $dbh->prepare($sql);

//            foreach($array as &$value) {
//                $value = $this->getUtf8Str($value);
//            }

            //unset($value);

            $rows = $sth->execute($array);
            $rowsNum = $sth->fetchColumn();
            return $rowsNum;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }

    /**
     * 单例
     * @return DBInfo|null
     */
    static public function getInstance()
    {
        if (is_null(self::$_instance) || isset (self::$_instance)) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }

}
