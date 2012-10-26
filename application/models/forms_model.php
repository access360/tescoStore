<?php

class Forms_model extends CI_Model {

	function __construct() {
		parent::__construct();

	}

	function check_wine_review($wineID, $sessionID) {

		$this -> db -> where('wine_ref', $wineID);
		$this -> db -> where('session_id', $sessionID);
		$query = $this -> db -> get('ratings');
		if ($query -> num_rows > 0) {
			return false;
		} else {
			return true;
		}
	}
	
	function check_session_entry($sessionID) {
		$this->db->where('session_id', $sessionID);
		$this->db->order_by('entryID', 'desc');
		$this->db->limit(1);
		$query = $this -> db -> get('entries');
		if ($query -> num_rows > 0) {
			return $query -> result();
		} else {
			return false;
		}
	}

	function add_rating($starValue, $wineID, $sessionID) {
		
		$form_data = array(
			'rating' => $starValue, 
			'session_id' => $sessionID, 
			'wine_ref' => $wineID
		);
		if($this->check_wine_review($wineID, $sessionID)) {
			$insert = $this -> db -> insert('ratings', $form_data);
		return $insert;
		} else {
			$this->db->where('session_id', $sessionID);
			$this->db->where('wine_ref', $wineID);
			$update = $this -> db -> update('ratings', $form_data);
			return $update;
		}
		
	}
	
	function add_entry($name, $email, $phone, $sessionID) {
		
		$form_data = array(
			'name' => $name, 
			'session_id' => $sessionID, 
			'email' => $email, 
			'phone' => $phone
			
		);
		$insert = $this -> db -> insert('entries', $form_data);
		return $insert;
	}
	
	function update_rating_link($lastReview, $entryID) {
		$form_data = array(
		'entryID' => $entryID
		);
		$this->db->where('rating_id', $lastReview);
		$update = $this->db->update('ratings', $form_data);
		return $update;
		
	}
}
