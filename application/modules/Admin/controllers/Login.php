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
        $model = new PassportModel();
        $model->logout();
        return true;
    }
}
