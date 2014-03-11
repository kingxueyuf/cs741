<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//防止用户直接访问该类文件

/*
|--------------------------------------------------------------------------
| ShopAssistent
|--------------------------------------------------------------------------
| @user robin-xue
| @email robin.xueyufan@gmail.com
| @website http://robin-xueyufan.appspot.com/
| @todo ProductManager is a controller for most of action user can take
| user can get the product list through 1)categoty
|                                       2)search
| there are two data interface for two ways upon to get product list data
|
|
|
*/

class ShopAssistant extends CI_Controller
{
	/*
	* @todo just return the shop page
	* see whether user has login by check cookie
	* maintain the cookie if user has login 
	*/
	function shop()
	{
		if(isset($_COOKIE["login-user"]))
		{
			$user_cookie = $_COOKIE["login-user"];
			setcookie("login-user",$user_cookie, time()+3600*24*24,"/index.php/ShopAssistant/","localhost",false,false);
		}
		$this->load->view("shop.html");
		// echo 'here';
	}

	/*
	* @todo just return the home page
	* see whether user has login by check cookie
	* maintain the cookie if user has login
	*/
	function home()
	{
		if(isset($_COOKIE["login-user"]))
		{
			$user_cookie = $_COOKIE["login-user"];
			setcookie("login-user",$user_cookie, time()+3600*24*24,"/index.php/ShopAssistant/","localhost",false,false);
		}
		$this->load->view("main.html");
	}


	/*
	* @todo return the product list , write the JSON data into the http response
	* get the input parameter from http request
	* pull data from database based on the condition category
	* transform the data from object into JSON
	* write the data to http response
	*/
	function cate_pro_list() 
	{
		//view product list based on category
		$input = array_merge($_POST,$_GET);
		$category = $input['category'];
		$this->load->model('ProductDAO');
		$res = $this->ProductDAO->selectOnCategory($category);
		$this->outputJSON($res);
	}

	/*
	* @todo just return the register page
	* I didn't use this function
	* just leave it here
	*/
	function register()
	{
		$this->load->view("register.html");
	}

	/*
	* @todo just return the manager login page
	*/
	function productmanager()
	{
		//check if has login
		//if not login
		$this->load->view("manager_login.html");
		//if has login
		//$this->load->view("productmanger.html");
	}

	/*
	* @todo just return the product manage page
	*/
	function product_manager()
	{
		$this->load->view("productmanager.html");
	}

	/*
	* @todo return the product list , write the JSON data into the http response
	* get the product data based on search condition
	* get the input parameter from http request
	* pull data from database based on the condition keyword
	* transform the data from array to JSON and write it into http response
	*/
	function search()
	{
		//view product list based on category
		$input = array_merge($_POST,$_GET);
		$key_word = $input['keyword'];
		$this->load->model('ProductDAO');
		$res = $this->ProductDAO->selectOnKeyword($key_word);
		$this->outputJSON($res);
	}


	/*
	* @todo return the product list , write the JSON data into the http response
	* get all the product data
	* pull data from database
	* transform the data from array to JSON and write it into http response
	*/
	function getAllProduct()
	{
		$input = array_merge($_POST,$_GET);
		$this->load->model('ProductDAO');
		$res = $this->ProductDAO->selectAllProduct();
		$this->outputJSON($res);
	}


	/*
	* @todo upload the picture
	* pull file data from http request and write into file system
	* file name: original file name( I didn't use UUID to generate the unique ID to indentify file 
	* there might crash once admin upload two file with same file name )
	* max size of the picture = 100M
	* max width of the picture = 1024px
	* max height of the picture = 768px
	* type of the picture = gif | jpg | png
	*/
	function upload()
	{
		$image_path = realpath(APPPATH . '../pic');
		$config['upload_path'] = $image_path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		  
		$this->load->library('upload', $config);
		 
		if ( !$this->upload->do_upload())
		{
		 $error = array('error' => $this->upload->display_errors());
		   
		 echo "error";
		} 
		else
		{
			$upload_data = $this->upload->data(); 
  			$file_name =   $upload_data['file_name'];
  			session_start();
  			// store session data
  			$_SESSION['pic_path'] = $file_name;
		 	echo $file_name;
		}
	}

	/*
	* @todo write data with JSON format into http response
	* transform the data from array to JSON
	* write JSON data to http response
	*/
	function outputJSON($res)
	{
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
				 array_push($res_array,$temp);
			}
		}
		echo json_encode($res_array);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
// localhost/index.php/welcome/index
                       //welcome控制器/index方法