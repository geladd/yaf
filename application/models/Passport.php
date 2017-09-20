<?php
/**
 * @name PasspostModel
 * @desc 账户
 * @author geladd
 */
class PassportModel {
	private $db;

    public function __construct() {
    	$config = Yaf_Application::app()->getConfig()->db;
        $this->db = Db_MySql::getInstance($config);
    }

    /**
     *	用户登录状态检测
     */
    public function isOnline() {
    	$result = array();
    	$result['status'] = false;
		$login = $this->db->fetchRow("SELECT prefix, `value`, dateline, ttl FROM sdb_kvstore WHERE `key`='".$_COOKIE['UNAME']."'");
		if($login['prefix'] == 'login') {
			$current_date = time();
			if($current_date >= $login['dateline'] && $current_date <= $login['ttl']) {
				$userinfo = unserialize($login['value']);
				$info = $this->db->fetchRow("SELECT username, password FROM sdb_admin WHERE username='".$userinfo['username']."'");
				if($info['username']) {
					if($info['password'] == $userinfo['password'] ) {
				        $result['status'] = true;
						$result['username'] = $userinfo['username'];
					}
				} 
			} 
		}
		if($result['status']) {
			return $result;
		} else {
			header("location:/Admin/Error/index");
		}
    }

    /**
     *	用户登录状态异常进入该函数
     */
    public function isOnlineError() {
    	$result = array();
    	$result['status'] = false;
    	$result['redirect'] = '/Admin/Login/index';
		$login = $this->db->fetchRow("SELECT prefix, `value`, dateline, ttl FROM sdb_kvstore WHERE `key`='".$_COOKIE['UNAME']."'");
		if($login['prefix'] == 'login') {
			$current_date = time();
			if($current_date >= $login['dateline'] && $current_date <= $login['ttl']) {
				$userinfo = unserialize($login['value']);
				$info = $this->db->fetchRow("SELECT username, password FROM sdb_admin WHERE username='".$userinfo['username']."'");
				if($info['username']) {
					if($info['password'] != $userinfo['password'] ) {
				        $result['msg'] = '登录密码错误，<a href="/Admin/Login/index">点击重新登录</a>';
				        $result['status'] = false;
					} else {
						$result['username'] = $userinfo['username'];
						$result['redirect'] = '/index.php/Admin/Index/index';
						$result['status'] = true;
					}
				} else {
	        		$result['msg'] = '登录用户名不存在，<a href="/Admin/Login/index">点击重新登录</a>';
				    $result['status'] = false;
				}
			} else {
	      		$result['msg'] = '登录已过期，<a href="/Admin/Login/index">点击重新登录</a>';
				$result['status'] = false;
			}
		} else {
	    	$result['msg'] = '登录信息异常，<a href="/Admin/Login/index">点击重新登录</a>';
			$result['status'] = false;
		}
		return $result;
    }

    /**
     *	登录
     */
    public function login($username, $password) {
		if($username && $password) {
			$user = $this->db->fetchRow("SELECT username, password FROM sdb_admin WHERE username='$username'");
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
					setcookie('UNAME', $key, $ttl, '/'); 
					$kv = $this->db->fetchRow("SELECT `key` FROM sdb_kvstore WHERE `key` = '$key'");
					if($kv['key']) {
						$data['value'] = $value;
						$data['dateline'] = $dateline;
						$data['ttl'] = $ttl;
						$this->db->update('sdb_kvstore', $data, "`key` = '$key'");
					} else {
						$data['prefix'] = 'login';
						$data['key'] = $key;
						$data['value'] = $value;
						$data['dateline'] = $dateline;
						$data['ttl'] = $ttl;
						$this->db->insert('sdb_kvstore', $data);
					}
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


    /**
     *	退出
     */
    public function logout() {
		$kv = $this->db->fetchRow("SELECT `key` FROM sdb_kvstore WHERE `key` = '".$_COOKIE['UNAME']."'");
		if($kv['key']) {
			$data['value'] = '';
			$data['dateline'] = 1;
			$data['ttl'] = 2;
			$this->db->update('sdb_kvstore', $data, "`key` = '".$kv['key']."'");
			setcookie('UNAME', '', time()-3600*6, '/');
		}
    }
}
