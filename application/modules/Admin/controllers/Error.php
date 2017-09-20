<?php
/**
 * @name ErrorController
 * @author root
 * @desc 后台错误提示控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class ErrorController extends Yaf_Controller_Abstract {

	/** 
     * 默认动作
     */
	public function indexAction() {
        $model = new PassportModel();
        $this->getView()->assign("result", $model->isOnlineError());
        return true;
	}
}
