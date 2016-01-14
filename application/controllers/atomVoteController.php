<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class atomVoteController extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->helper ( array (
				'url',
				'html',
				'form' 
		) );
		
		$this->load->model ( 'atom_voters_model' );
		/* $this->load->model ( 'atommodel' ); */
		// for get lft,rgt,..level_of_description_id
	}
	public function index() {
		$this->load->model ( 'atomRegModel' );
		$result ['list'] = $this->atomRegModel->getCollection ();
		$this->load->view ( 'atom_voter_register', $result );
	}
	public function loadData() {
		$loadType = $_POST ['loadType'];
		$loadId = $_POST ['loadId'];
		
		$this->load->model ( 'atomRegModel' );
		$result = $this->atomRegModel->getData ( $loadType, $loadId );
		$HTML = "";
		
		if ($result->num_rows () > 0) {
			foreach ( $result->result () as $list ) {
				$HTML .= "<option value='" . $list->id . "'>" . $list->name . "</option>";
			}
		}
		echo $HTML;
	}
	
	/*
	 *
	 * @param $val:title of polling district
	 * @param $parentid: parent district id
	 * @return : an array('bool'=>true),array('bool'=>false,'id'=>id)
	 *
	 * check availability
	 */
	public function isavailable($val, $parentid) {
		$available = $this->atom_voters_model->isAvailable ( $val, $parentid );
		return $available;
	}
	
	/*
	 * add $par1 to db
	 * @param $title
	 * $param $parent_id
	 */
	public function adddata($title, $parent_id) {
		$title = urldecode ( $title );
		$slug = url_title ( $title, '-', true );
		$slug = $this->createSlug ( $slug );
		$available = $this->isavailable ( $title, $parent_id );
		if (! $available ['bool']) {
			$data ['objectid'] = $this->atom_voters_model->addDetails ( $title, $parent_id, $slug );
		} else {
			$data ['objectid'] = $available ['id'];
		}
		$data ['list'] = $this->atom_voters_model->getDroDownList ( $parent_id );
		$this->load->view ( 'dropdown', $data );
	}
	
	// create a slug for title of polling district,
	function createSlug($slug) {
		$i = 1;
		$baseSlug = $slug;
		while ( $this->atom_voters_model->get_slug ( $slug ) ) {
			$slug = $baseSlug . "-" . $i ++;
		}
		
		return $slug;
	}
	
	// when give the row id return parent id
	public function getParentId($myid) {
		$this->atom_voters_model->getParentId ( $myid );
	}
	function test($id) {
		$result = $this->atom_voters_model->get_first_last_node_id ( $id );
		print '<pre>';
		print_r ( $result );
		// echo $result;
	}
}
?>