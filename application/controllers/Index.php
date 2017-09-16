<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf_Controller_Abstract {

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost//data/www/yaf/index/index/index/name/root 的时候, 你就会发现不同
     */
	public function indexAction($name = "Stranger") {
		//1. fetch query
		$get = $this->getRequest()->getQuery("get", "default value");

		//2. fetch model
		$model = new SampleModel();

		//3. assign
		$this->getView()->assign("content", $model->selectSample());
		$this->getView()->assign("name", $name);

		//读取配置文件
        $config = Yaf_Application::app()->getConfig();
        $config1 = Yaf_Registry::get("config");
        //打印配置信息
        echo '<pre>';
        //print_r($config);
        //print_r($config1);
        echo $config['redis']['cache']['host'].'<br>';
        echo $config1['redis']['cache']['port'].'<br>';
        echo $config->db->type;
        echo '</pre>';

		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
	}

	public function testAction($name = "Stranger") {
		//$id = $this->getRequest()->getQuery('id',0); //获取get的值
		$id = $this->getRequest()->getPost('id',0); //获取post的值
		$this->getView()->assign("id", $id);
		return TRUE;
	}

	public function mydbAction()
    {
        $config = Yaf_Application::app()->getConfig()->db;
        $db = Db_MySql::getInstance($config);
        /*$row = $db->fetchOne('select count(*) from `shop`');
        print_r($row);die;*/
        $rows = $db->fetchAll('select * from `shop`');
        $this->getView()->assign("rows", $rows);
        return TRUE;
    }
}
