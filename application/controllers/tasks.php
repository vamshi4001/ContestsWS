<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Data extends REST_Controller
{
	
	function getTheatres_get(){		
		$this->db->from("theatres");
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
	function getCities_get (){
		$this->db->from("cities");
		$this->db->order_by("city", "asc");
		if($this->get('cityId')){
			$cityId = $this->get('cityId');
        		$this->db->where('id',$cityId);
        		        
		}
		$this->db->where('active',1);   
		$query = $this->db->get(); 
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else {
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}	
	function getMovies_get (){
		$this->db->from("movies");
		$this->db->order_by("name", "asc");
		$queryString = "";
		if($this->get('cityid')){
			$cityid = $this->get('cityid');
        	$queryString = "SELECT COUNT(t.id) as theatrecount, m.*  
							FROM theatres_movies tm 
							join theatres t on t.id = tm.theatreid 
							join movies m on m.id = tm.movieid
							where t.cityid=".$cityid." group by m.id";			
		}
		if($this->get('movieId')){
			$movieid = $this->get('movieId');
        	$queryString = "SELECT * FROM movies where id = ".$movieid;
		}
		$query = $this->db->query($queryString);
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else {
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}
	function getShows_get (){
		$this->db->from("theatres_movies");
		// $this->db->order_by("showtimes", "desc");
		if($this->get('theatreid')){
			$theatreid = $this->get('theatreid');
        	$this->db->where('theatreid', $theatreid);
        	$tqueryString = 'SELECT * from theatres where id='.$theatreid;			
			$theatrequery = $this->db->query($tqueryString);		      		        	
		}
		if($this->get('movieid')){
			$movieid = $this->get('movieid');
    		$this->db->where('movieid', $movieid);  
        	$mqueryString = 'SELECT * from movies where id='.$movieid;			
			$moviequery = $this->db->query($mqueryString);		      	
		}
		if($this->get('theatreid') && $this->get('movieid')){
			$theatreid = $this->get('theatreid');
			$movieid = $this->get('movieid');
    		$queryString = 'SELECT * from theatres_movies where movieid = '.$movieid.' and theatreid = '.$theatreid.' and date >= CURDATE()';			
			$query = $this->db->query($queryString);		      	
			
		}	
		

		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else if($this->get('theatreid') && $this->get('movieid')){
			$response = array('result' => $query->result(), 'movie'=>$moviequery->result(), 'theatre'=>$theatrequery->result());
		} else if($this->get('theatreid')){
			$response = array('result' => $query->result(), 'theatre'=>$theatrequery->result());
		} else if($this->get('movieid')){
			$response = array('result' => $query->result(), 'movie'=>$moviequery->result());
		}


		$this->response($response, 200);
	}
	function getTickets_get (){
		if($this->get('cityid')){
			$cityid = $this->get('cityid');
		}
		if($this->get('movieid')){
			$movieid = $this->get('movieid');
		}
		if($this->get('date')){
			$date = $this->get('date');
		}
		if($movieid && $cityid){
			$queryString = " SELECT t.name AS theatre_name,
			         t.location AS theatre_location,
			         m.name AS movie_name,
			         tm.showtimes show_time,
			         SUM(ti.quantity) AS tickets_available,
			         tm.id AS theatre_movie_id,
			         t.id theatreid
			    FROM theatres t,
			         theatres_movies tm,
			         movies m,
			         tickets ti
			   WHERE     t.id = tm.theatreid
			         AND m.id = tm.movieid
			         AND ti.theatre_movie_id = tm.id
			         AND tm.date = date('".$date."')
			         AND t.cityid = ".$cityid."
			         AND m.id = ".$movieid."
			GROUP BY t.name, t.location, m.name, tm.showtimes";
			$query = $this->db->query($queryString);	

			$mqueryString = "SELECT * FROM movies WHERE id = ".$movieid;
			$mquery = $this->db->query($mqueryString);			        
		}
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else if($movieid){
			$response = array('result' => $query->result(), 'movie'=> $mquery->result());
		} else{
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}
	function removeMyTicket_get(){
		if($this->get('ticketid')){
			$ticketid = $this->get('ticketid');
			$delString = "Delete from tickets where id=".$ticketid;
			$delquery = $this->db->query($delString);				
		}
		$response = array();
		if($delquery->num_rows() == 0){
			$response = array('isSuccess'=>false);			
		}
		else{
			$response = array('isSuccess'=>true);			
		}		
		$this->response($response, 200);
	}
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
	function getDates_get (){
		if($this->get('cityid')){
			$cityid = $this->get('cityid');
		}
		if($this->get('movieid')){
			$movieid = $this->get('movieid');
		}
		if($movieid && $cityid){
			$queryString = 'SELECT DISTINCT date from tickets where cityid = '.$cityid.' AND theatre_movie_id IN (SELECT id from theatres_movies where movieid = '.$movieid.') and date >=CURDATE()';						
			$query = $this->db->query($queryString);		
		}
		if($movieid){
			$mqueryString = "SELECT * FROM movies WHERE id = ".$movieid;
			$mquery = $this->db->query($mqueryString);		
		}
		$response = array();
		if ($query->num_rows() == 0) {
			$response = array('message'=> 'No results');
		} else if($movieid){
			$response = array('result' => $query->result(), 'movie' => $mquery->result());
		} else{
			$response = array('result' => $query->result());
		}
		$this->response($response, 200);
	}
	function getMoviesTickets_get(){
		if($this->get('cityid')){
			$cityid = $this->get('cityid');
		}
		if($cityid){
			$queryString = 'select m.id, m.name, m.imageurl, tm.date, SUM(quantity) as tickets 
							from theatres_movies tm
							join tickets t
							on t.theatre_movie_id = tm.id
							join movies m 
							on m.id = tm.movieid
							where t.cityid = '.$cityid.' and tm.date>=curdate() group by movieid,tm.date';
			// $queryString = 'select count(*) as tickets, m.* from movies m join theatres_movies t on t.movieid = m.id where t.id in (SELECT theatre_movie_id from tickets where cityid = '.$cityid.') group by m.id';			
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
	function getInfoTMID_get(){
		if($this->get('tmid')){
			$tmid = $this->get('tmid');
		}
		if($tmid){
			$queryString = 'SELECT * from theatres_movies where id ='.$tmid;			
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
	function getPostedTickets_get(){
		if($this->get('tmid')){
			$tmid = $this->get('tmid');
		}
		if($tmid){
			$queryString = 'SELECT * from tickets where theatre_movie_id ='.$tmid;			
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
	function newTicket_post (){
		$name = $this->post('name');
		$phone = $this->post('phone');
		$quantity = $this->post('quantity');		
		$showid = $this->post('showId');
		$userid = $this->post('user');
		$price = $this->post('price');
		$date = $this->post('date');
		// $nop = $this->post('needOnlinePayment');
		$cityid = $this->post('cityid');
		
		$response = array();
		$params = array('userid' => $userid, 
				'theatre_movie_id'	=> $showid,
				'price'=> $price,
				'quantity'=> $quantity,
				'phone'=> $phone,
				'name'=> $name,
				'date'=> $date,
				'cityid'=> $cityid
		);
		
		$this->db->insert('tickets', $params);
		
		$response = array("message"=>"Ticket successfully posted", "isSuccess"=>"true");
		$this->response($response);	
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
