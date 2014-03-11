<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//防止用户直接访问该类文件


/*
|--------------------------------------------------------------------------
| UserManager
|--------------------------------------------------------------------------
| @user robin-xue
| @email robin.xueyufan@gmail.com
| @website http://robin-xueyufan.appspot.com/
| @todo UserManager is a controller for most of action admin to manager user
| admin will  1)login
|             2)add new user
| 
|
|
*/
class UserManager extends CI_Controller
{


	// function insert()
	// {	
	// 	$this->load->model('test_m');

	// 	// $arr = array(''=>)
	// 	$this->test_m->user_insert();
	// }

	// function addSession()
	// {
	// 	$this->load->library('session');//加载SESSION类
	// 	$arr = array('uid'=>'2');//往session里放的东西
	// 	$this->session->set_userdata($arr);//设置session
	// 	echo $this->session->set_userdata('uid');
	// }

	// function checkSession()
	// {
	// 	$this->load->library('session');
	// 	if()
	// }


	/*
	* @todo check user login
	* get the username and password from http request
	* pull user data from database
	* check whether the password from data base is same as it sent from client side
	* return check result
	*/
	function checkLogin()
	{
		$input = array_merge($_POST,$_GET);
		$username = $input['username'];
		$this->load->model('UserDAO');
		$arr = array('name'=>$username);
		$res = $this->UserDAO->select($arr);
		// var_dump($res);
		if($res == false)
		{
			echo 'failure';
		}else
		{
			if($res->password == $input['password'])
			{
				echo 'success';
				setcookie("login-user",$username, time()+3600*24*24,"/index.php/ShopAssistant/","localhost", false, false);
			}else
			{
				echo "failure";
			}
		}
	}

	/*
	* @todo check admin login
	* get the username and password from http request
	* pull user data from database
	* check whether the password from data base is same as it sent from client side
	* return check result
	*/
	function check_admin()
	{
		$input = array_merge($_POST,$_GET);
		$username = $input['username'];
		$this->load->model('UserDAO');
		$arr = array('name'=>$username,
					 'type'=>'admin');
		$res = $this->UserDAO->select($arr);
		// var_dump($res);
		if($res == false)
		{
			echo 'failure';
		}else
		{
			if($res->password == $input['password'])
			{
				echo 'success';
			}else
			{
				echo "failure";
			}
		}
	}


	/*
	* @todo add a new user into database
	* get the data from http request 
	* insert the data into database
	* set cookie
	*/
	function addUser()
	{
		$input = array_merge($_POST,$_GET);
		$username = $input['username'];
		$password = $input['password'];
		$this->load->model('UserDAO');
		$arr = array('name'=>$username,
					 'password'=>$password,
					 'type'=>'user');
		$res = $this->UserDAO->user_insert($arr);
		if($res == false)
		{
			echo 'failure';
		}else
		{
			setcookie("login-user",$username, time()+3600*24*24,"/index.php/ShopAssistant/","localhost", false, false);
			echo "success";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
// localhost/index.php/welcome/index
                       //welcome控制器/index方法