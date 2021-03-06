<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Contests extends REST_Controller
{

	// Get Tasks Data 
	
	
	function getClosedContests_get(){
		//get all the closed contests 
		//Along with Contest details get description from task table to display
		//This function is require to list all contests with description and completed time.
		$queryString = 'SELECT c.taskid, c.ticketid, c.completedat, t.ticketnumber, t.userid, u.username, u.fullname, u.emailid 
						FROM contests c, tickets t, users u
						WHERE c.ticketid = t.id
						AND t.userid = u.id
						ORDER BY c.taskid';
		$query = $this->db->query($queryString);		
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else{
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);

	}
	function getContestDetails_get(){
		//contestId
		//Once user selects one contest from list, get the contest specific details like winner, ticket number and show banner for task.
	}
	
}
