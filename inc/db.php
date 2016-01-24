<?php
class connection {
    var $conn;
    var $charset = "utf8";
    //构造：连接数据库
    function connection($servername, $username, $password, $db, $port=3306) {
        $this -> conn = new mysqli($servername, $username, $password, $db, $port);
        if ($this -> conn -> connect_error) {
            die("Connection failed: " . $this -> conn -> connect_error);
        }
        $this -> conn -> set_charset($this -> charset);
    }
 
    //插入
    function insert($table_name, $columns, $values) {
        $sql = "INSERT INTO " . $table_name . " (";
        for ($i = 0, $len = count($columns); $i < $len; $i++) {
            if ($i != 0)
                $sql = $sql . ",";
            $sql = $sql . "`" . $columns[$i] . "`";
        }
        $sql = $sql . ") VALUES (";
        for ($i = 0, $len = count($values); $i < $len; $i++) {
            if ($i != 0)
                $sql = $sql . ",";
            $sql = $sql . "'" . $values[$i] . "'";
        }
        $sql = $sql . ");";
        //echo $sql;
        return $this -> conn -> query($sql);
    }
 
    //读取
    function select($table_name, $columns, $where = "1") {
        $sql = "SELECT ";
        for ($i = 0, $len = count($columns); $i < $len; $i++) {
            if ($i != 0)
                $sql = $sql . ",";
            $sql = $sql . $columns[$i];
        }
        $sql = $sql . " FROM " . $table_name . " WHERE " . $where . ";";
        return $this -> conn -> query($sql);
    }
 
    //SELECT转化二维数组
    function shift($result) {
        $res = array();
        if ($result -> num_rows > 0) {
            // 输出每行数据
            while ($row = $result -> fetch_assoc()) {
                array_push($res, $row);
            }
        }
        return $res;
    }
 
    //修改
    //*忽略values多于columns的部分
    function update($table_name, $columns, $values, $where) {
        $sql = "UPDATE " . $table_name . " SET ";
        for ($i = 0, $len = count($columns); $i < $len; $i++) {
            if ($i != 0)
                $sql = $sql . ",";
            $sql = $sql . $columns[$i] . "=" . $values[$i];
        }
        $sql = $sql . " WHERE " . $where . ";";
        return $this -> conn -> query($sql);
    }
 
    //删除
    function delete($table_name, $where) {
        $sql = "DELETE FROM " . $table_name . " WHERE " . $where . ";";
        return $this -> conn -> query($sql);
    }
 
}
?>