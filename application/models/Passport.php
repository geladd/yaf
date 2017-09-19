<?php
/**
 * @name PasspostModel
 * @desc 账户
 * @author geladd
 */
class PassportModel {
    public function __construct() {
    }   
    
    public function isOnline() {
    	$result = array();
    	$result['flag'] = true;
    	$config = Yaf_Application::app()->getConfig()->db;
        $db = Db_MySql::getInstance($config);
        $cookie = $_COOKIE['UNAME'];
		$login = $db->fetchRow("SELECT prefix, `value`, dateline, ttl FROM sdb_kvstore WHERE `key`='$cookie'");
		error_log("SELECT prefix, `value`, dateline, ttl FROM sdb_kvstore WHERE `key`='$cookie'".var_export($login, 1)."\r\n", 3, 'f:/yaf.log');
		if($login['prefix'] == 'login') {
			$current_date = time();
			if($current_date >= $login['dateline'] && $current_date <= $login['ttl']) {
				$userinfo = unserialize($login['value']);
				$info = $db->fetchRow("SELECT username, password FROM sdb_admin WHERE username='".$userinfo['username']."'");
				if($info['username']) {
					if($info['password'] != $userinfo['password'] ) {
				        $result['msg'] = '登录信息异常，<a href="/index.php/Admin/Login/index" data="1">点击重新登录1</a>';
				        $result['status'] = false;
					}
				} else {
	        		$result['msg'] = '登录信息异常，<a href="/index.php/Admin/Login/index" data="2">点击重新登录2</a>';
				    $result['status'] = false;
				}
			} else {
	      		$result['msg'] = '登录已过期，<a href="/index.php/Admin/Login/index">点击重新登录3</a>';
				$result['status'] = false;
			}
		} else {
	    	$result['msg'] = '登录信息异常，<a href="/index.php/Admin/Login/index" data="3">点击重新登录4</a>';
			$result['status'] = false;
		}
		return $result;
    }

    public function login($username, $password) {
    	$config = Yaf_Application::app()->getConfig()->db;
        $db = Db_MySql::getInstance($config);
		if($username && $password) {
			$user = $db->fetchRow("SELECT username, password FROM sdb_admin WHERE username='$username'");
			if($user['username']) {
				if($user['password'] == md5($password)) {
					$userinfo = array(
							'username' => $user['username'],
							'password' => $user['password']
						);
					$key = md5('login'.$user['username']);
					$value = serialize($userinfo);
					$dateline = time();
					$ttl = $dateline+3600*6;// 6小时过期
					setcookie('UNAME', $key, $ttl); 
					$kv = $db->fetchRow("SELECT `key` FROM sdb_kvstore WHERE `key` = '$key'");
					if($kv['key']) {
						$db->query("UPDATE sdb_kvstore SET `value` = '$value', dateline = '$dateline', ttl = '$ttl' WHERE `key` = '$key'");
					} else {
						$db->query("INSERT INTO sdb_kvstore(prefix, `key`, `value`, dateline, ttl) VALUES('login', '$key', '$value', $dateline, $ttl)");
					}
					error_log($_COOKIE['UNAME']."222\r\n", 3, 'f:/yaf.log');
					$result["status"] = "ok";
				} else {
					$result["msg"] = '密码错误';
					$result["status"] = "error";
				}
			} else {
				$result["msg"] = '您输入的用户不存在';
				$result["status"] = "error";
			}
		} else {
			$result["msg"] = '用户名和密码不能为空';
			$result["status"] = "error";
		}
    	return json_encode($result);
    }
}
