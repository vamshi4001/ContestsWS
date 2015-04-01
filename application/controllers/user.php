<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class User extends REST_Controller
{	
	function getUserInfo_get(){
		if($this->get('userid')){
			$userid = $this->get('userid');
		}
		if($userid){
			$queryString = 'SELECT * from users where id ='.$userid;			
			$query = $this->db->query($queryString);		
		}
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else {
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}
	function userLogin_get(){
		if($this->get('uname')){
			$uname = $this->get('uname');
		}
		if($this->get('password')){
			$password = $this->get('password');
		}
		if($uname && $password){
			$queryString = 'SELECT id, emailid, fullname, mobilenumber from users where username ="'.$uname.'" and password = "'.md5($password).'"';			
			$query = $this->db->query($queryString);		
		}
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results', 'isSuccess'=>false);
		} else {
			$response = array('result' => $query->result(), 'isSuccess'=>true);
		}
		$this->response($response, 200);
	}
	function newUser_post (){
		$uname 		= $this->post('uname');
		$password 	= $this->post('password');
		$fullname 		= $this->post('fullname');		
		$email 		= $this->post('email');
		$age 		= $this->post('age');		
		$city 		= $this->post('city');		
		$mobilenumber= $this->post('mobilenumber');
		$address= $this->post('address');
		$interests= $this->post('interests');
		$fbtoken= $this->post('fbtoken');
		$gplustoken= $this->post('interests');
		
		//Check username availability
		//Check email uniqueness
		//

		$response = array();
		$params = array('username' => $uname, 
				'password'	=> md5($password),
				'fullname'=> $fullname,
				'emailid'=> $email,
				'age'=> $age,
				'city'=> $city,
				'mobilenumber'=> $mobilenumber,				
				'address'=> $address,
				'interests'=> $interests,
				"isActive"=>1
		);		
		$this->db->insert('users', $params);
		
		$response = array("message"=>"Registered successfully", "isSuccess"=>"true");
		$this->response($response);	
	}
}
