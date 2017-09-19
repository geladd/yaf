<?php
/**
 * @name LoginController
 * @author root
 * @desc 后台登录控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class LoginController extends Yaf_Controller_Abstract {

    /** 
     * 登录
     */
    public function indexAction() {
        return TRUE;
    }

	/** 
     * 登录
     */
	public function loginAction() {
		$model = new PassportModel();
        echo $model->login($this->getRequest()->getPost('uname',0), $this->getRequest()->getPost('pwd',0));
        return false;
	}

    /**
     * 退出
     */
    public function LogoutAction() {
        $config = Yaf_Application::app()->getConfig()->db;
        $db = Db_MySql::getInstance($config);
        $cookie = $_COOKIE['UNAME'];
        $kv = $db->get_one("SELECT `key` FROM w_kvstore WHERE `key` = '$cookie'");
        if($kv['key']) {
            $db->query("UPDATE w_kvstore SET `value` = '', dateline = 1, ttl = 2 WHERE `key` = '".$kv['key']."'");
        }
        setcookie('UNAME', '', time()-3600*6);
        return true;
    }
}
