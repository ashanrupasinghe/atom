<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class atom_voters_controler extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->helper ( array (
				'url',
				'html',
				'form' 
		) );
		$this->load->model ( 'atom_voters_model' );
	}
	function votersregister() {
		$data ['districts'] = $this->atom_voters_model->getDroDownList ( 157854 );
		$data ['validate'] = 0;
		$data ['message'] = NULL;
		$data ['title'] = 'ICA ATOM [Voters Registers]';
		$this->load->view ( 'atom_voters_registers', $data );
	}
	// this function build a dropdown
	function buildDropdown($parentid, $selected = '') {
		$list = $this->atommodel->getDroDownList ( $parentid );
		$drop_down = '';
		$count = 1;
		
		foreach ( $list as $item ) {
			if ($item ['title'] == $selected) {
				$drop_down .= '<option value="' . $item ['title'] . '" selected >' . $count . ':' . $item ['title'] . '</option>';
			} else {
				$drop_down .= '<option value="' . $item ['title'] . '" >' . $count . ':' . $item ['title'] . '</option>';
			}
			$count ++;
		}
		$drop_down .= '<option value="Other">Other</option>';
		return $drop_down;
	}
	// check availability
	public function isavailable($val, $parentid) {
		$available = $this->atom_voters_model->isAvailable ( $val, $parentid );
		return $available;
		// echo $available;
	}
	
	/*
	 * add $par1 to db
	 * @param unknown $para1
	 */
	/* public function adddata($id, $title, $parent_id) { */
	public function adddata($title, $parentid) {
		/*
		 * $getData = array (
		 * 'title' => $title
		 * );
		 */
		/*
		 * $available = $this->isavailable ( 'sample', 'pol_dist', $para1 );
		 * if ($available) {
		 * $list = $this->get_dropDownRespondText ( 'sample', 'pol_dist', $para1 );
		 * echo $list;
		 * } else {
		 */
		$this->atom_voters_model->addDetails ( $title );
		// $list = $this->get_dropDownRespondText ( 'sample', 'pol_dist', $para1 );
		// echo $list;
		$this->load->view ( 'dropdown', $data );
		// echo "<option>hello world</option>";
		/* } */
	}
	public function getPagentId($myid) {
		$this->atom_voters_model->getPagentId ( $myid );
	}
}