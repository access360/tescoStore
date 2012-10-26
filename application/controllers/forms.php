<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Forms extends CI_Controller {

	/**
	 *
	 */

	public function index() {
		$this -> session -> unset_userdata('sessionID');
		$data['mainContent'] = "content/frontpage";
		$this -> load -> vars($data);
		$this -> load -> view('templates/base');
	}
	
	function rateWine() {
		
		$starValue = $this->input->post('starvalue');
		$wineID = $this->input->post('windeID');
		$sessionID = $this->input->post('sessionID');
		$output = $starValue." ".$wineID." ".$sessionID;
		
		
		
		
		$this->forms_model->add_rating($starValue, $wineID, $sessionID);
		$ratingID = mysql_insert_id();
		echo $ratingID;
		
		
	}
	function addEntry() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$sessionID = $this->input->post('sessionID');
		$lastReview = $this->input->post('lastReview');
		
		$output  = "name:".$name." email:".$email." phone:".$phone." session:".$sessionID;
		$this->forms_model->add_entry($name, $email, $phone, $sessionID);
		$lastEntry = mysql_insert_id();
		$this->forms_model->update_rating_link($lastReview, $lastEntry);
		
		echo $output;
	}
	
	function logAction() {
		$action = $this->input->post('action');
		
$today = date("Ymd"); 

$file = $_SERVER['DOCUMENT_ROOT']."/tescowine/images/log/wine_".$today.".csv";
$fh = fopen($file, 'a') or die("can't open file");
$dateNow = date('l jS \of F Y h:i:s A');

$data = $dateNow.", ". $action."
";
fwrite($fh, $data);
fclose($fh);

	}

}
