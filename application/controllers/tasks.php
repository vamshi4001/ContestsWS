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
		Based on userid check has to be performed, whether user has any active tickets for this task already
		if yes display user what is task, when he performed task when is the contest scheduled.
			if no return task details from task table and contents table
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
		Based on taskid get task type 
		depending on task type input arguments defer 
		if questions is task type, userid and choosed option will be input 
			validate wheter that is right answer or not 
		Thinking whether we require this or can be perform same thing on View and call generate ticket directly
	}
	function getClosedTasks_get(){
		This function is also not required, there is nothing like closed tasks.
		there will be only contests.
	}
	function getOpenSystemTask_get(){
		This function is to get system task id at any time 
		When user creates a new account or when he refers new user get the open system task
		and generate ticket
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
