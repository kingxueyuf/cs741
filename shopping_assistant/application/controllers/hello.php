<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//防止用户直接访问该类文件

class Hello extends CI_Controller 
{
	function sayhello($name,$name2)
	{

		echo $name."hello world";
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
// localhost/index.php/welcome/index
                       //welcome控制器/index方法