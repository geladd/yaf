<?php
/**
 * @name IndexController
 * @author root
 * @desc 后台默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf_Controller_Abstract {
    private $db;
    private $isOnline;
    
    public function init() {
        // 实例数据库操作
        $config = Yaf_Application::app()->getConfig()->db;
        $this->db = Db_MySql::getInstance($config);
        
        $model = new PassportModel();
        $this->isOnline = $model->isOnline();
    }

	/** 
     * 默认动作
     */
	public function indexAction() {
	    $this->getView()->assign("login_username", $this->isOnline['username']);
        return true;
	}

    public function getcAction() {
        if(!$this->isOnline['status']) {
            $this->getView()->assign("msg",$this->isOnline['msg']);
        }
        return true;
    }
}
