<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Referral extends REST_Controller
{
	
	function generateRefCode_post(){
		$userId 		= $this->post('userId');		
		$queryString = "select fullname from users where id = ".$userId;
		$query = $this->db->query($queryString);
		$response = array();	
		if($query->num_rows()==0){
			//Change error messages according to exceptions			
			$response = array('errorMessage' => "Invalid userid", "message"=>"Referral code generation failed", "isSuccess"=>"false");
		}		
		else{
			$fullname = $query->result()[0]->fullname;	
			//taking the remainder of time in milli seconds, to get changing value from microtime
			$pieces = explode(" ", $fullname);			
			$code1 = $pieces[0].$pieces[1][0];			
			$code1 = strtolower($code1);
			$queryString1 = "select count(*) as count from referralcodes where code1 = '".$code1."'";
			$query1 = $this->db->query($queryString1);	
			$code2 = $query1->result()[0]->count;
			
			$insertString = "INSERT INTO `referralcodes`(`userid`, `code1`, `code2`, `referralcode`, `isActive`, `creation_date`, `last_update_date`, `createdby`, `updatedby`) VALUES ($userId,'$code1','$code2','$code1$code2',1,now(),now(),1,1)";
			$insertQuery = $this->db->query($insertString);	
			$response = array('insertedId' => $this->db->insert_id(), "message"=>"Ticket generated successfully", "isSuccess"=>"true");
		}		
		$this->response($response);	
	}
	function updatePromo(){
		// //userid and refCode
		// Check if this user already used refCode previously using referralscode table.
		// if yes 
		// 	return error message saying this promo code can be used only once 
		// if no 
		// 	Get userid whose refCode is passed
		// 	generate tickets for both users with ticket type as REF so that validity come as 2
  //           update referralscode table
  //           	increment count for userid whose refCode is used 
  //           	update referredby for current user
  //           notify user whose refCode is used
	}
	function getRefCode_get(){
		// //userID
		// return Ref code to user 
	}
}