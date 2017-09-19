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
        $model = new PassportModel();
        $check = $model->isOnline();
        if(!$ckeck['status']) {
            echo $check['msg'];
            return false;
        } else {
            return true;
        }
	}

    public function getcAction() {
        $model = new PassportModel();
        $check = $model->isOnline();
        if(!$ckeck['status']) {
            $this->getView()->assign("msg",$check['msg']);
        }
        return true;
    }
}
