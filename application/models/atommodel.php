<?php
class Atommodel extends CI_Model{
    
	/*index -----------------------------------------------------------------------*/
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('model');
		$result['list']=$this->model->getCountry();
		//$this->load->view('top');
		$this->load->view('atom_voters_registers',$result);
		//$this->load->view('footer');
	}

	public function loadData()
	{
		$loadType=$_POST['loadType'];
		$loadId=$_POST['loadId'];

		$this->load->model('model');
		$result=$this->model->getData($loadType,$loadId);
		$HTML="";

		if($result->num_rows() > 0){
			foreach($result->result() as $list){
				$HTML.="<option value='".$list->id."'>".$list->name."</option>";
			}
		}
		echo $HTML;
	}

/*----------------------------------------------------------------------------------*/


	function trans_start() {
		$this->db->trans_start();
	}
	function trans_complete() {
		$this->db->trans_complete();
	}
	function trans_status() {
		if($this->db->trans_status() === TRUE) {
			//log_message('debug', 'trans_status: true');
		} else {
			//log_message('debug', 'trans_status: false');
			//log_message('debug', $this->db->_error_message());
		}
	}
	
    function  get_timesid() {
		$t='Times of Ceylon';
		$this->db->select('*');
		$this->db->where('title', $t);
		$query = $this->db->get('information_object_i18n');
		return $query->row_array();
    }
    
    function  add_objects($data) {
		$this->db->insert('object', $data);
    }
    function  add_information_objects($data) {
		$this->db->insert('information_object', $data);
    }
    function  add_information_object_i18n($data) {
		$this->db->insert('information_object_i18n', $data);
    }
    function  add_slug($data) {
		$this->db->insert('slug', $data);
    }
    function  add_status($data) {
		$this->db->insert('status', $data);
    }
    function  add_digital_object($data) {
		$this->db->insert('digital_object', $data);
    }
    function add_post($data) {
		$this->db->insert('object', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
    }
    
    // level of discription ID for the titiel(if its for the Subject name = ' File ')
    function level_of_discription_id() {
//     	SELECT u.id FROM atom.taxonomy_i18n t
//		JOIN term u ON u.taxonomy_id = t.id
//		JOIN term_i18n i ON i.id = u.id
//		WHERE t.name = 'Levels of description' AND i.culture = 'en' AND i.name = 'File';
		
		$this->db->select('term.id');
		$this->db->from('taxonomy_i18n');
		$this->db->join('term','term.taxonomy_id = taxonomy_i18n.id', 'left');
		$this->db->join('term_i18n','term_i18n.id = term.id', 'left');
		$this->db->where('taxonomy_i18n.name','Levels of description');
		$this->db->where('term_i18n.culture','en');
		$this->db->where('term_i18n.name','Item');
		$query = $this->db->get();
		return $query->row_array();
    }
    //DE
    function get_series_forvoters() {
		$this->db->select('j.id, j.title');
		$this->db->from('information_object as i');
		$this->db->join('information_object p','p.id = i.parent_id', 'left');
		$this->db->join('information_object_i18n j','j.id = i.id', 'left');
		$this->db->where('p.identifier','DE');
		$query = $this->db->get();
		return $query->result_array();
    }
    
    function get_series() {
//      SELECT j.id, j.title FROM atom.information_object i
//      JOIN atom.information_object p ON p.id = i.parent_id
//      JOIN atom.information_object_i18n j ON j.id = i.id
//      WHERE p.identifier = '326'
		
		$this->db->select('j.id, j.title');
		$this->db->from('information_object as i');
		$this->db->join('information_object p','p.id = i.parent_id', 'left');
		$this->db->join('information_object_i18n j','j.id = i.id', 'left');
		$this->db->where('p.identifier','326');
		$query = $this->db->get();
		return $query->result_array();
		
//      SELECT j.id, j.title FROM atom.information_object i
//		JOIN atom.information_object p ON
//		p.id = i.parent_id
//		JOIN atom.information_object_i18n j ON
//		j.id = i.id
//		JOIN term t ON t.id = p.level_of_description_id
//		JOIN term_i18n u ON u.id = t.id
//		JOIN taxonomy v ON v.id = t.taxonomy_id
//		JOIN taxonomy_i18n w ON w.id = v.id
//		WHERE u.culture = 'en' AND u.name = 'Collection' AND w.name = 'Levels of description' AND p.identifier = '326'
         
//      $this->db->select('j.id, j.title');
//      $this->db->from('information_object as i');
//      $this->db->join('information_object p','p.id = i.parent_id', 'left');
//      $this->db->join('information_object_i18n j','j.id = i.id', 'left');
//      $this->db->join('term t','t.id = i.level_of_description_id', 'left');
//      $this->db->join('term_i18n u','u.id = t.id', 'left', 'left');
//      $this->db->join('taxonomy v','v.id = t.taxonomy_id', 'left');
//      $this->db->join('taxonomy_i18n w','w.id = v.id', 'left');
//      $this->db->where('u.culture','en');
//      $this->db->where('u.name','Collection');
//      $this->db->where('w.name','Levels of description');
//      $this->db->where('p.identifier','326');
//      $query = $this->db->get();
//      return $query->result_array();
	}
	
    //get the rgt value from the parent
	function get_rgt($id) {
		$this->db->select('rgt');
		$this->db->from('information_object');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
     
	function get_subjects($ser) {
//      SELECT i.id, i.identifier, j.title FROM atom.information_object i
//      JOIN atom.information_object_i18n j ON
//      j.id = i.id
//      WHERE i.parent_id = '391'
		$this->db->select('i.id, i.identifier');
		$this->db->from('information_object as i');
		$this->db->join('information_object_i18n j','j.id = i.id');
		$this->db->where('i.parent_id',$ser);//391
		$this->db->order_by('i.identifier');
		$query = $this->db->get();
		return $query->result_array();
	}
     
    function get_title_of_subject($id) {
		$this->db->select('title');
		$this->db->from('information_object_i18n');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
     
    function update_all_lft($lft, $delta) {
//      $statement = $connection->prepare('
//      UPDATE '.QubitInformationObject::TABLE_NAME.' //information_object
//      SET '.QubitInformationObject::LFT.' = '.QubitInformationObject::LFT.' + ?
//      WHERE '.QubitInformationObject::LFT.' >= ?');
//      $statement->execute(array($delta, $parent->rgt));
		
		//try {
			$this->db->where('lft >= ',$lft );
			$this->db->set('lft','lft+'.$delta,FALSE);
			$this->db->update('information_object');
		//} catch(Exception $x) {
			//log_message('debug', $x->getMessage());
		//}
	}
     
    function  update_all_rgt($rgt, $delta) {
//      $statement = $connection->prepare('
//      UPDATE '.QubitInformationObject::TABLE_NAME.'
//      SET '.QubitInformationObject::RGT.' = '.QubitInformationObject::RGT.' + ?
//      WHERE '.QubitInformationObject::RGT.' >= ?');
//      $statement->execute(array($delta, $parent->rgt));
		
		$this->db->where('rgt >=',$rgt );
		$this->db->set('rgt','rgt+'.$delta,FALSE);
		$this->db->update('information_object');
	}
	function addDetails($title) {
	
		// $bool = $this->db->insert ( $table, $array );
		$object_id = $this->insertObject ();
		// $information_object_id = $this->insetInformationObject ($object_id,157854);
	}
}
