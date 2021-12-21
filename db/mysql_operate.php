<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2016/10/5
        * Time: 15:59
    */
    require_once 'DbMysqli.php';


    /**
     * 查找
     * @author aaron
     * @param string    $table_name     表名
     * @param array     $conditions     array('列名'=》$value)
     * @param array     $params         查询的值
     * @return array    $res            数组
     */
//    function db_select($table_name, $conditions, $params="*", $orderBy="") {
//        $db = new DbMysqli();
//
//        // 查询条件
//        $arr_conditions = array();
//        foreach ($conditions as $key => $value) {
//            $arr_conditions[] = "`".$key."` = '".$value."'";
//        }
//
//        $str_where = implode(' and ', $arr_conditions);
//
//        $sql = "select $params from`".$table_name."` where ".$str_where.$orderBy;
//
//        $res = $db->getData($sql);
//        $db->closeDb();
//        return $res;
//    }

    /**
     * 查找
     * @author aaron
     * @param string    $table_name     表名
     * @param array     $conditions     array('列名'=》$value)
     * @param array     $params         查询的值
     * @param string    $limit          分页
     * @return array    $order_by_list  array('desc|asc'=>'排序字段')
     * @param array     $left_join_tab  array（'表名'=>array('as'=>$value, 'param'=>$value, ''=>'$value')）
     */
    function db_select($table_name, $conditions, $params="*", $limit='', $order_by_list=array(), $left_join_tab=array(), $left_join_tab_ands='') {
        $db = new DbMysqli();

        // 左连
        $arr_left_join_tab = array();
        foreach ($left_join_tab as $tab => $param) {
            $arr_left_join_tab[] = " left join $tab as ".$param["as"]."  on a.".$param[""]." =".$param["as"].".".$param["param"]." ".$left_join_tab_ands;
        }
        $str_left_join = implode(' ', $arr_left_join_tab);

        // 查询条件
        $arr_conditions = array();
        foreach ($conditions as $key => $value) {
            $str = " and ".$key;
            if ($value != "") {
                $str = $str." = '".$value."'";
            }
            $arr_conditions[] = $str;
        }
        $str_where = implode(' ', $arr_conditions);

        // 排序
        $str_order_by = "";
        if (count($order_by_list) > 0) {
            $arr_order_buy = array();
            foreach ($order_by_list as $key => $value) {
                $arr_order_buy[] = $key." ".$value;
            }
            $str_order_by = " order by ".implode(' ,', $arr_order_buy);
        }

        $sql = "select ".$params." from ".$table_name." as a ".$str_left_join." where 1=1".$str_where." ".$str_order_by." ".$limit;
        $res = $db->getData($sql);
        $db->closeDb();
        return $res;
    }
	function db_getall($sql){
		$db = new DbMysqli();
		$res = $db->getData($sql);
        $db->closeDb();
        return $res;
	}
	
	
	function db_getrow($sql){
		$db = new DbMysqli();
		$res = $db->getLine($sql);
        $db->closeDb();
        return $res;
	}
	
	function db_getone($sql){
		$db = new DbMysqli();
		$res = $db->getVar($sql);
        $db->closeDb();
        return $res;
	}
    /**
     * 新增
     * @author aaron
     * @param string  $table_name   表名
     * @param array   $params       array('列名'=》'value')
     * @param bool    $boo          默认false返回操作是否成功 true返回新增ID
     * @return $boo=true 返回新增ID  $boo=false 返回新增是否成功
     */
    function db_insert($table_name, $params, $boo=FALSE) {
        $db = new DbMysqli();
        // 列名
        $fileds = array();
        // 值
        $values = array();
        foreach ($params as $key => $value) {
            $fileds[] = "`".$key."`";
            $values[] = "'".$value."'";
        }

        $str_fileds = implode(',', $fileds);
        $str_values = implode(',', $values);
        $sql = "insert into `".$table_name."` (".$str_fileds.") values (".$str_values.")";
        $result = $db->runSql($sql);
        if($boo) {
            // 获取新增后的ID
            $result = $db->lastId();
        }
        $db->closeDb();

        return $result;
    }


    /**
     * 修改
     * @author aaron
     * @param string    $table_name     表名
     * @param array     $params         array('列名'=》$value)
     * @param array     $conditions     array('列名'=》$value)
     * @return bool true 修改成功； false 修改失败
     */
    function db_update($table_name, $params, $conditions) {
        $db = new DbMysqli();
        // 更改的值
        $arr_params = array();
        foreach ($params as $key => $value) {
            if(is_null($value)){
                $arr_params[] = "`".$key."` = NULL";
            } else {
                $arr_params[] = "`".$key."` = '".$value."'";
            }
        }
        // 更改条件
        $arr_conditions = array();
        foreach ($conditions as $key => $value) {
            $arr_conditions[] = "`".$key."` = '".$value."'";
        }

        $str_fileds = implode(',', $arr_params);
        $str_where = implode(' and ', $arr_conditions);

        $sql = "update `".$table_name."` set ".$str_fileds." where ".$str_where;
        $res = $db->runSql($sql);
        $db->closeDb();

        return $res;
    }

    /**
     * 删除
     * @author aaron
     * @param string    $table_name     表名
     * @param array     $conditions     array('列名'=》$value)
     * @return bool 操作是否成功
     */
    function db_delete($table_name, $conditions) {
        $db = new DbMysqli();
        // 更改条件
        $arr_conditions = array();
        foreach ($conditions as $key => $value) {
            $arr_conditions[] = "`".$key."` = '".$value."'";
        }
        $str_where = implode(' and ', $arr_conditions);

        $sql = "delete from `".$table_name."` where ".$str_where;
        $res = $db->runSql($sql);
        $db->closeDb();

        return $res;
    }

    function db_execute($sql) {
        $db = new DbMysqli();
        $res = $db->runSql($sql);
        $db->closeDb();
        return $res;
    }

    function db_execute_select($sql) {
        $db = new DbMysqli();
        $res = $db->getData($sql);
        $db->closeDb();
        return $res;
    }
?>