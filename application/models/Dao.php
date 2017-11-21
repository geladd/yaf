<?php
/**
 * @name DaoModel
 * @desc 获取数据
 * @author geladd
 */
class DaotModel {
    private $cofig;
	private $db;

    public function __construct() {
    	$this->config = Yaf_Application::app()->getConfig()->db;
        $this->db = Db_MySql::getInstance($config);
    }

    /**
     * 获取多条数据
     * @param string $cols 字段名称用英文点号隔开
     * @param unknown $tableName 表明不带前缀
     * @param array $filter 查询条件组形式
     * @param number $offset 偏移
     * @param unknown $limit 条数
     * @return string $orderby 排序
     * @return unknown
     */
    public function getList($cols='*', $tableName, $filter=array(), $offset=0, $limit=-1, $orderby=null) {
        if($orderby)  $sql_order = ' ORDER BY ' . (is_array($orderby) ? implode($orderby,' ') : $orderby);
        if($filter && is_array($filter)) {
            $where = $this->filter2sql($filter);
            $where = $where ? ' WHERE '.$where : '';
        } else {
            $where = '';
        }
        if ($offset >= 0 || $limit >= 0){
            $offset = ($offset >= 0) ? $offset . "," : '';
            $limit = ($limit >= 0) ? $limit : '18446744073709551615';
            $_limit .= ' LIMIT ' . $offset . ' ' . $limit;
        } else {
            $_limit = '';
        }
        $rows = $this->db->fetchAll("SELECT $cols FROM ".$this->config->prefix.$tableName.$where.$sql_order.$_limit);
        return $rows;
    }
    
    /**
     * 获取单条数据
     * @param string $cols 字段名称用英文点号隔开
     * @param unknown $tableName 表明不带前缀
     * @param array $filter 查询条件组形式
     * @return string $orderby 排序
     * @return unknown
     */
    public function getRow($cols='*', $tableName, $filter=array(), $orderby=null) {
        if($orderby)  $order = ' ORDER BY ' . (is_array($orderby) ? implode($orderby,' ') : $orderby);
        if($filter && is_array($filter)) {
            $where = $this->filter2sql($filter);
            $where = ' WHERE '.$where;
        } else {
            $where = '';
        }
        $limit = ' LIMIT 1';
        $row = $this->db->fetchAll("SELECT $cols FROM ".$this->config->prefix.$tableName.$where.$order.$limit);
        return $row;
    }
    
    /**
     * 数组转为sql条件
     * @param array $filter
     * @return string
     */
    private function filter2sql($filter) {
        $where = array('1');
        if($filter){
            foreach($filter as $k=>$v){
                if(is_array($v)){
                    foreach($v as $m){
                        if($m!=='_ANY_' && $m!=='' && $m!='_ALL_'){
                            $ac[] = $k.'=\''.$m.'\'';
                        }else{
                            $ac = array();
                            break;
                        }
                    }
                    if(count($ac)>0){
                        $where[] = '('.implode($ac,' or ').')';
                    }
                }else{
                    $where[] = '`'.$k.'` = "'.str_replace('"','\\"',$v).'"';
                }
            }
        }
        return implode(' AND ',$where);
    }
}
