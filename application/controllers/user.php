<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Data extends REST_Controller
{	
	function getMyTickets_get(){
		
		if($this->get('userid')){
			$userid = $this->get('userid');
			$queryString = "SELECT T.id as id , T.name as user, T.price, T.quantity,T.expired, M.name as movie, TH.name as theatre, TM.showtimes, TM.date, M.imageurl, TH.location FROM tickets T
								join theatres_movies TM on T.theatre_movie_id = TM.id
								join movies M on TM.movieid = M.id
								join theatres TH on TH.id = TM.theatreid
								where userid=".$userid;
			$query = $this->db->query($queryString);		
		}
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else{
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}
	function getUserInfo_get(){
		if($this->get('userid')){
			$userid = $this->get('userid');
		}
		if($userid){
			$queryString = 'SELECT id, emailid, fullname, contactnumber, cityid from users where id ='.$userid;			
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
			$queryString = 'SELECT id, emailid, fullname, contactnumber from users where emailid ="'.$uname.'" and password = "'.$password.'"';			
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
	function newUser_post ()
	{
		$name = $this->post('name');
		$password = $this->post('password');
		$email = $this->post('email');
		$phone = $this->post('phone');
		

		
		$response = array();
		$params = array('emailid' => $email, 
				'password'	=> $password,
				'fullname'=> $name,
				'contactnumber'=> $phone,				
		);
		
		$this->db->insert('users', $params);
		
		$response = array("message"=>"Loggedin successfully", "isSuccess"=>"true");
		$this->response($response);	
	}
}
