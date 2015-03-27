<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Tasks extends REST_Controller
{

	// Get Tasks Data 
	
	function getTasks_get(){
		//location

		$this->db->from("tasks");
		$this->db->order_by("name", "desc");
		if($this->get('cityid')){
			$cityid = $this->get('cityid');		
			$this->db->where('cityid',$cityid);
		}			
		if($this->get('movieid')){
			$movieid = $this->get('movieid');
        	$this->db->where('`id` IN (SELECT `theatreid` FROM `theatres_movies` where movieid='.$movieid.')', NULL, FALSE);        	
        	// SELECT distinct t.* FROM theatres_movies tm join theatres t on tm.theatreid = t.id where tm.movieid = 112 and t.cityid = 1
        	$queryString = 'SELECT * from movies where id='.$movieid;			
			$moviequery = $this->db->query($queryString);		
		}
		if($this->get('theatreId')){
			$theatreid = $this->get('theatreId');
        		$this->db->where('id', $theatreid);        	
		}
		$query = $this->db->get();
        $response = array();
        if ($query->num_rows() == 0) {
                $response = array('message'=> 'No results');
        } else if($this->get('movieid')){
                $response = array('result' => $query->result(), 'movie'=>$moviequery->result());
        } else{
        		$response = array('result' => $query->result());
        }
        $this->response($response, 200);
	}	
	function getTaskDetails_get(){// get details and actions to be performned in a task given an id
		//taskId, userid
	}
	function executeContest_get(){//trigger a task completion and then run contest based on timestamp
		get list fo active tasks whose timestamp < current timestamp
		for each task
			get all tickets which are active 
			pick a random ticket
			deactivate task 
			reduce validity by 1 and have a trigger which sets isActive to false if validity is 0 related tickets
			create an entry in contest table with this taskid, ticketid
	}
	function validateTask_get(){//Verify the validity of task and completion and add to db on success
	}
	function getClosedTasks_get(){
	}
	function newUser_post (){
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
