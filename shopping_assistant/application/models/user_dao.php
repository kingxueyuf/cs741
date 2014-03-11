<?php

class Test_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();//链接数据库

	}

	function user_insert($arr)
	{
		$this->db->insert('user',$arr);
	}

	

}
?>
