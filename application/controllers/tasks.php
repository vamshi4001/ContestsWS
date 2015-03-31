<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Tasks extends REST_Controller
{

	// Get All Active Tasks  
	function getAllActiveTasks_get(){
		
		$queryString = 'SELECT id, content_type, contentid, acronym, isactive, advertiserid, creation_date 
						FROM tasks T WHERE isactive = 1';
		$query = $this->db->query($queryString);		
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No Active Tasks');
		} else{
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}

	// Get Tasks Details for a specific taskid and userid
	function getTaskDetails_get(){
		
		$response = array();

		if($this->get('taskid') && $this->get('userid'))
		{

			$taskid = $this->get('taskid');
			$userid = $this->get('userid');

			$queryString = 'SELECT id, ticketnumber, validity, ticket_type, creation_date  
							FROM tickets T WHERE isactive = 1 and taskid='.$taskid.' and userid ='.$userid;
			$query = $this->db->query($queryString);

			if ($query->num_rows() == 0) 
			{
				$response = array('message'=> 'No Ticket available for the user for this task');
				// No tickets available for this userid and taskid combination. Fetching the Task Content to be displayed to the user.
				
				$queryString2 = 'SELECT content_type, contentid, advertiserid, creation_date 
								 FROM tasks T WHERE isactive = 1 and taskid='.$taskid;
				$query2 = $this->db->query($queryString2);
				
				if ($query2->num_rows() == 0) 
				{
					$response = array('message'=> 'Invalid Taskid');
				} 
				else
				{
					foreach ($query2->result() as $row)
					{
						$contenttype = $row->content_type;
						if ($contenttype == 'QUESTIONS')
						{
							$queryString3 = 'SELECT id, question_text, options, correctAnswer, creation_date 
											 FROM task_questions WHERE isactive = 1 and taskid='.$taskid;
							$query3 = $this->db->query($queryString3);
							if ($query3->num_rows() == 0) 
							{
								$response = array('message'=> 'Questions not available for this task');
							} 
							else
							{
								$response = array('result' => $query->result());
							}
						} 
						elseif ($contenttype == 'VIDEO') 
						{
							# code...
						}
						elseif ($contenttype == 'FBLIKE') 
						{
							# code...
						}
						elseif ($contenttype == 'VOTING') 
						{
							# code...
						}

					}

				}
			} 
			else
			{
				$response = array('result' => $query->result());
			}	
		}
		else
		{
			$response = array('message'=> 'Either taskid or userid is NULL. Please pass both the parameters');
		}
		$this->response($response, 200);
	}

	function executeContest_post(){//trigger a task completion and then run contest based on timestamp
		$currenttime = time(); // Get the current timestamp to be compared.

		//Get list of active tasks whose scheduled runtime of the task is less than current timestamp
		$queryString1 = 'SELECT id, content_type, numofwinners, contentid, acronym, isactive, advertiserid, creation_date AS task_creation_date 
						FROM tasks T 
						WHERE iactive = 1 and scheduledruntime <='.$currenttime;
		$query1 = $this->db->query($queryString1);		
		$response = array();
		if ($query1->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else{		
			$response = array('result' => $query1->result());

			// Loop for each active task
			foreach ($query1->result() as $row)
			{
				// Get all tickets for the selected active task
				$taskid = $row->id;
				$num_of_winners = $row->numofwinners;
				$taskcompletedat = now();

				// Pick the winners for the current taskid
				$winnerlist = pickwinner($num_of_winners, $taskid);

				// Invalidate the Task by updating the isactive field to 0 for the current taskid
				$queryString2 = 'UPDATE tasks SET isactive = 0, last_update_date = now()
								WHERE id='.$taskid;
				$query2 = $this->db->query($queryString2);	

				// Reduce the validity of ticket by 1 for the current taskid
				$queryString3 = 'UPDATE tickets SET validity = validity - 1, last_update_date = now() 
								WHERE (taskid='.$taskid.' OR ticket_type = 'REF') and validity!=0';
				$query3 = $this->db->query($queryString3);	
				
				// Create entries in contest table with this taskid, ticketid
				foreach ($winnerlist as $winner) {
					$queryString4 = 'INSERT INTO contests(taskid, ticketid, completedat) values ('.$tadkid.', '.$winner.', '.$taskcompletedat.')';
					$query4 = $this->db->query($queryString4);	
				}
			}
		}
		$this->response($response, 200);	
	}

	function pickwinner($num_of_winners, $taskid) {
		$winners = array();
		$queryString = 'SELECT id, userid, ticketnumber, validity, ticket_type, isactive, creation_date 
							FROM tickets T WHERE validity!=0 AND (taskid = '.$taskid.' OR ticket_type = 'REF') 	
							ORDER BY RAND()
 							LIMIT '.$num_of_winners;
		$query = $this->db->query($queryString);
		if ($query->num_rows() == 0) {
			return $winners;
		} else{		
			foreach ($query->result() as $row)
			{
				array_push($winners, $row->id);
			}
		}
	}

	function validateTask_get(){//Verify the validity of task and completion and add to db on success
	/*	Based on taskid get task type 
		depending on task type input arguments defer 
		if questions is task type, userid and choosed option will be input 
			validate wheter that is right answer or not 
		Thinking whether we require this or can be perform same thing on View and call generate ticket directly*/
	}
	function getClosedTasks_get(){
		/*This function is also not required, there is nothing like closed tasks.
		there will be only contests.*/
	}
	function getOpenSystemTask_get(){
		/*This function is to get system task id at any time 
		When user creates a new account or when he refers new user get the open system task
		and generate ticket*/
		$userid = $this->get('userid');
		$queryString = 'SELECT id, content_type, contentid, acronym, isactive, advertiserid, creation_date AS task_creation_date FROM tasks T 
						WHERE advertiserid= 1 AND isactive = 1 AND rownum = 1';
		$query = $this->db->query($queryString);		
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No Active System Tasks');
		} else{
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);

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
