<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Tickets extends REST_Controller
{
	
	function generateTicket_get(){
		// taskId, type, userId
		This has to be post function.
		ticket table should have type field also 
		based on taskId and type generate one unique ticket like this,
		<TSK><TimeStamp><randomnumber>
		first 3 letters denote task, next time stamp and next 4 or 5 digit random number.
		type requied to decide validity of ticket.
	}
	function getAllTickets_get(){
		//taskId
	}
	function invalidateTickets_get(){
		//taskId
	}
}