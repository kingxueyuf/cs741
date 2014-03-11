<?php
/*
|--------------------------------------------------------------------------
| ProductDAO
|--------------------------------------------------------------------------
| @user robin-xue
| @email robin.xueyufan@gmail.com
| @website http://robin-xueyufan.appspot.com/
| @todo Prodcut data access object
|
*/
class ProductDAO extends CI_Model
{

	/*
	* constructer()
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->database();//链接数据库

	}

	/*
	* @todo get all prodcut list
	* @return product list array 
	*/
	function selectAllProduct()
	{
		$sql = "select * from product";
		$res = $this->db->query($sql);
		return $res;
	}

	/*
	* @todo get limit number of product list
	* @return product list array 
	*/
	function select_num($arr)
	{
		$num = $arr['amount'];
		$sql = "select * from product limit ".$num;
		$res = $this->db->query($sql);
		return $res;
	}

	/*
	* @todo get product list  
	* @return product list array based on category
	*/
	function selectOnCategory($category)
	{
		$sql = "select * from product where category ='".$category."'";
		$res = $this->db->query($sql);
		return $res;
	}

	/*
	* @todo get product list  
	* @return product list array based on keyword
	*/
	function selectOnKeyword($key_word)
	{
		$sql = "select * from product where name like "."'%".$key_word."%' or category like "."'%".$key_word."%'";
		$res = $this->db->query($sql);
		return $res;
	}

	/*
	* @todo insert a new product  
	* @return whether insert success
	*/
	function insertProduct($arr)
	{
		$name =$arr['name'];
		$price = $arr['price'];
		$v_price = $arr['v_price'];
		$location = $arr['location'];
		$amount = $arr['amount'];
		$detail = $arr['detail'];
		$other = $arr['other'];
		$picpath = $arr['picpath'];
		$category = $arr['category'];
		$brand = $arr['brand'];
		
		$sql = "insert into product (name,normal_price,member_price,amount,location,brand,category,picture_url) 
		VALUES ('".$name."','".$price."','".$v_price."','".$amount."','".$location."','".$brand."','".$category."','".$picpath."');";

		$res = $this->db->query($sql);
		return $res;
	}
}
?>
