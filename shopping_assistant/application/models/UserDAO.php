<?php

/*
|--------------------------------------------------------------------------
| UserDAO
|--------------------------------------------------------------------------
| @user robin-xue
| @email robin.xueyufan@gmail.com
| @website http://robin-xueyufan.appspot.com/
| @todo User data access object
|
*/
class UserDAO extends CI_Model
{

	public $table = "user";
	/*
	* constructer()
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->database();//链接数据库

	}

	/*
	* @todo add new user
	* @return whether add success
	*/
	function user_insert($arr)
	{
		$res = $this->db->insert('user',$arr);
		return $res;
	}


	/*
	* @todo select user
	* @return user item with name equals to
	*/
	function select($arr)
	{
		$sql = "select * from user where name = '".$arr['name']."' limit 1";
		$res = $this->db->query($sql);
		return $res->row();
	}

	/*
	* @todo select admin
	* @return admin item with name equals to
	*/
	function select_admin($arr)
	{
		$sql ="select * from user where name = '".$arr['name']."' and type='admin'";
		$res = $this->db->query($sql);
		return $res->row();
	}
}
?>
