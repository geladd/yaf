<?php
/**
 * @name IndexController
 * @author root
 * @desc 后台默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf_Controller_Abstract {

	/** 
     * 默认动作
     */
	public function indexAction() {
		/*$config = Yaf_Application::app()->getConfig()->db;
        $db = Db_MySql::getInstance($config);
        $rows = $db->fetchAll('select * from `shop`');
        $this->getView()->assign("rows", $rows);*/
        return TRUE;
	}
}
