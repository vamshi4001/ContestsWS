<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Referral extends REST_Controller
{
	
	function generateRefCode(){
		// userId
		This will generate unique referral code to each user and insert in referralscode table 
	}
	function updatePromo(){
		//userid and refCode
		Check if this user already used refCode previously using referralscode table.
		if yes 
			return error message saying this promo code can be used only once 
		if no 
			Get userid whose refCode is passed
			generate tickets for both users with ticket type as REF so that validity come as 2
            update referralscode table
            	increment count for userid whose refCode is used 
            	update referredby for current user
            notify user whose refCode is used
	}
	function getRefCode_get(){
		//userID
		return Ref code to user 
	}
}