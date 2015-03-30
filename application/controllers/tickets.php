<?php defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Tickets extends REST_Controller
{
	
	function generateTicket_post(){		
		// TODO - Check the generated ticket number is already exists
		// TODO - Validations to catch exceptions
		// TODO - 
		$taskId 		= $this->post('taskId');
		$userId 		= $this->post('userId');
		$ticketType 	= $this->post('ticketType');
		$time 			= microtime(true);
		switch($ticketType){
			case "general":
				$validity = 1;
				break;
			case "referral":
				$validity = 2;
				break;
			default:
				$validity = 1;
				break;
		}
		$response = array();
		$queryString = "select acronym from tasks where id = ".$taskId;
		$query = $this->db->query($queryString);	

		if($query->num_rows()==0){
			//Change error messages according to exceptions			
			$response = array('errorMessage' => "Invalid taskid or userid", "message"=>"Ticket generation failed", "isSuccess"=>"false");
		}		
		else{
			$acronym = $query->result()[0]->acronym;	
			//taking the remainder of time in milli seconds, to get changing value from microtime
			$ticket = $acronym.(string)round($time%100000).(string)(mt_rand(100, 999));
			$insertString = "INSERT INTO `tickets`(`userid`, `taskid`, `validity`, `ticketnumber`, `creation_date`, `last_update_date`) VALUES ($userId,$taskId,$validity,'$ticket',NOW(),NOW());";
			$insertQuery = $this->db->query($insertString);	
			$response = array('insertedId' => $this->db->insert_id(), "message"=>"Ticket generated successfully", "isSuccess"=>"true");
		}		
		$this->response($response);	
	}
	function getAllTickets_get(){
		//taskId
	}
	function invalidateTickets_get(){
		//taskId
	}
}