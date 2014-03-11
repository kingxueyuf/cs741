<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//防止用户直接访问该类文件


/*
|--------------------------------------------------------------------------
| ProductManager
|--------------------------------------------------------------------------
| @user robin-xue
| @email robin.xueyufan@gmail.com
| @website http://robin-xueyufan.appspot.com/
| @todo ProductManager is a controller for admin to manage product
| admin will  1)login
|			  2)addProduct
|
|
*/
class ProductManager extends CI_Controller
{


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
			}else
			{
				echo "failure";
			}
		}
	}

	/*
	* @todo add a new product
	* get product properties from http request
	* insert into database
	*/

	function addProduct()
	{
		$input = array_merge($_POST,$_GET);
		$name = $input['name'];
		$price = $input['price'];
		$v_price = $input['v_price'];
		$location = $input['location'];
		$amount = $input['amount'];
		$detail = $input['detail'];
		$other = $input['other'];
		$category = $input['category'];
		$brand = $input['brand'];

		session_start();
		$file_name = $_SESSION['pic_path'] ;
		$file_name = "/pic/".$file_name;
		$this->load->model('ProductDAO');

		$arr = array(
			"name"=>$name,
			"price"=>$price,
			"v_price"=>$v_price,
			"location"=>$location,
			"amount"=>$amount,
			"detail"=>$detail,
			"other"=>$other,
			"picpath"=>$file_name,
			"category"=>$category,
			"brand"=>$brand,
			);

		$res = $this->ProductDAO->insertProduct($arr);

		if($res)
		{
			echo "success";
		}else
		{
			echo "failure";
		}

	}


	/*
	* @todo get top nth products
	* get number from http request
	* insert into database
	*/
	function getTopNumberInfo()
	{
		$input = array_merge($_POST,$_GET);
		$arr = array("amount"=>$input['amount']);

		$this->load->model('ProductDAO');
		$res = $this->ProductDAO->select_num($arr);

		$res_array = array();
		if($res ==false)
		{
			echo "failure";
		}else
		{
			foreach($res->result() as $row)
			{
				 $temp = array("name"=>$row->name,
				 				"id" =>$row->id,
				 				"normal_price"=>$row->normal_price,
				 				"member_price"=>$row->member_price,
				 				"amount"=>$row->amount,
				 				"location"=>$row->location,
				 				"brand"=>$row->brand,
				 				"category"=>$row->category,
				 				"picture_url"=>$row->picture_url);
				 $res_array += $temp;
			}
		}
		echo json_encode($res_array);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
// localhost/index.php/welcome/index
                       //welcome控制器/index方法