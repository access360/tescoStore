<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index() {
		$this -> session -> unset_userdata('sessionID');
		$data['recent_wine'] = $this->stand_model->get_recently_reviewed();
		$data['mainContent'] = "content/frontpage";
		$this -> load -> vars($data);
		$this -> load -> view('templates/base');
	}

	public function stand_menu() {
		//set session
		$sessionID = $this -> session -> userdata('sessionID');
		if ($sessionID == NULL) {
			//echo "no session";
			$newdata = array('sessionID' => now());
			$this -> session -> set_userdata($newdata);
		} else {
			$data['currentSession'] = $this -> session -> userdata('sessionID');
		}

		//get all stands

		//display page
		$data['mainContent'] = "content/mapPage";
		$this -> load -> vars($data);
		$this -> load -> view('templates/base');
	}

	public function display_stand($stand_id) {

		//set session
		//TODO this is duplciated, make it a separate function
		$sessionID = $this -> session -> userdata('sessionID');
		if ($sessionID == NULL) {
			//echo "no session";
			$newdata = array('sessionID' => now());
			$this -> session -> set_userdata($newdata);
		} else {
			$data['currentSession'] = $this -> session -> userdata('sessionID');
		}
		
		//get user entry from current session
		$data['entry'] = $this -> forms_model -> check_session_entry($data['currentSession']);
		
		//get reviews from current session
		$data['reviews'] = $this -> stand_model -> get_reviews($stand_id, $data['currentSession']);
		
		//get stand
		$data['stand'] = $this -> stand_model -> get_stand($stand_id);

		//get wines for stand $stand_id
		$data['wines'] = $this -> stand_model -> get_stand_wines($stand_id);

		//display page
		$data['mainContent'] = "content/viewStand";
		$this -> load -> vars($data);
		$this -> load -> view('templates/base');
	}

	function displayxml() {
		$this -> load -> model('stand_model');
		$xml = file_get_contents(base_url() . 'xml/TescoWineFeed.xml');

		$xml = str_replace(".\xe2\x80\xa9<as:eol/>", ".\n\n<as:eol/>", $xml);

		$data['xmlo'] = simplexml_load_string($xml);

		foreach ($data['xmlo']->channel->item as $row) :

			$productID = $row -> TPNB;

			$productname = $row -> Product_name;

			$description = $row -> description;

			$image = $productID . ".jpg";
			//$row->Product_Image

			if ($this -> stand_model -> check_wineID_exists($productID)) {
				//it exists so update it
				echo $productID . " its there - ";

				//update it
				//$this->stand_model->update_wine($productID, $productname, $description, $image);

			} else {
				//it doesn't exist so create it
				echo $productID . " NO -";

			}

			//check if file is on server
			if (file_exists("images/wines/" . $image)) {
				echo $image . " image here<br/>";
			} else {

				echo "no image<br/>";
			}

		endforeach;

		$data['wines'] = $this -> stand_model -> get_all_wines();
		$data['mainContent'] = "content/xmldisplay";
		$this -> load -> vars($data);
		$this -> load -> view('templates/base');
	}

	function import_image() {
		$xml = file_get_contents(base_url() . 'xml/TescoWineFeed.xml');

		$xml = str_replace(".\xe2\x80\xa9<as:eol/>", ".\n\n<as:eol/>", $xml);

		$data['xmlo'] = simplexml_load_string($xml);

		foreach ($data['xmlo']->channel->item as $row) :

			$productID = $row -> TPNB;

			$productname = $row -> Product_name;

			$description = $row -> description;

			$image = $productID . ".jpg";
			//$row->Product_Image
			if (file_exists("images/wines/" . $image)) {
				echo $image . " image here<br/>";
			} else {

				echo $image . " no image<br/>";
				$imageData = file_get_contents($row -> Product_Image);
				if (!write_file('images/wines/' . $image, $imageData)) {
					echo "unable to write file<br/>";
				} else {

					echo "File Written<br/>";
				}
			}

		endforeach;

	}

	function displaycsv() {
		$this -> load -> library('Getcsv');
		$this -> load -> model('stand_model');
		$data = array('CompanyName', 'WineNameVintage', 'StandName', 'Lond', 'product_ref');
		$data['csv_array'] = $this -> getcsv -> get_csv_assoc_array(base_url() . 'xml/master.csv', $data);

		foreach ($data['csv_array'] as $row) :
			$name = $row['StandName'];
			$location = $row['Lond'];
			$wine_id = $row['product_ref'];

			if ($this -> stand_model -> check_stand_exists($name, $location)) {
				//it exists so do nothing
			} else {
				//it doesn't exist so create it
				echo "creating...";
				$this -> stand_model -> create_stand($name, $location);
			}

			if ($this -> stand_model -> check_wine_exists($wine_id, $location)) {
				//it exists so do nothing
			} else {
				//it doesn't exist so create it
				echo "creating wine...";
				$this -> stand_model -> create_wine($wine_id, $location);
			}

		endforeach;

		$data['mainContent'] = "content/csvdisplay";
		$this -> load -> vars($data);
		$this -> load -> view('templates/base');

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
