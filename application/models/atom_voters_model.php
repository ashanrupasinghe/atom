<?php
/*for adding polling district*/
class atom_voters_model extends CI_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->helper ( 'string' );
	}
	/*
	 * NEW CHANGES BY
	 */
	/* function getDroDownList($table_name, $column_name, $where_array = '') { */
	function getDroDownList($super_parent) {
		$list = array ();
		$this->db->select ( 'io.id,io.parent_id,ioi.title' );
		$this->db->from ( 'information_object io' );
		$this->db->join ( 'information_object_i18n ioi', 'io.id = ioi.id' );
		$this->db->where ( 'io.parent_id', $super_parent );
		$query = $this->db->get ();
		$results = $query->result ();
		// return $results;
		$count = 0;
		foreach ( $results as $result ) {
			$list [$count] = array (
					'id' => $result->id,
					'title' => $result->title,
					'parent_id' => $result->parent_id 
			);
			$count ++;
		}
		return $list;
		/*
		 * $result[]= $query->result ();
		 * return getDroDownList($result[]);
		 */
		/*
		 * $this->db->select ( $column_name );
		 * $this->db->from ( $table_name );
		 * if ($where_array != '') :
		 * foreach ( $where_array as $col => $val ) :
		 * $this->db->where ( $col, $val );
		 * endforeach
		 * ;
		 *
		 * endif;
		 * $query = $this->db->get ();
		 * $colvalues = $query->result ();
		 * $list = '';
		 * foreach ( $colvalues as $colvalue ) {
		 * $list [] = $colvalue->$column_name;
		 * }
		 * return $list;
		 */
		
		/*
		 * recursion
		 * ---
		 * function fact($n) {
		 * if ($n === 0) { // our base case
		 * return 1;
		 * }
		 * else {
		 * return $n * fact($n-1); // <--calling itself.
		 * }
		 * }
		 *
		 * echo fact(5);
		 */
	}
	// return true if available $val:title, $parentid
	function isAvailable($val, $parentid) {
		// $val = urldecode ( $val );
		$this->db->trans_start ();
		$this->db->select ( 'io.*,ioi.*' );
		$this->db->from ( 'information_object io' );
		$this->db->join ( 'information_object_i18n ioi', 'io.id = ioi.id' );
		$this->db->where ( 'io.parent_id', $parentid );
		$this->db->where ( 'ioi.title', $val );
		$query = $this->db->get ();
		$results = $query->result ();
		$this->db->trans_complete ();
		
		if ($query->num_rows () > 0) {
			$id = $results [0]->id;
			return array (
					'bool' => true,
					'id' => $id 
			);
		} else {
			return array (
					'bool' => false 
			);
		}
	}
	// call sql queries to add object[polling district], up to status table
	function addDetails($title, $parent_id, $slug) {
		$title = urldecode ( $title );
		$this->db->trans_start ();
		$object_id = $this->insertObject ();
		$information_object_id = $this->insetInformationObject ( $object_id, $parent_id, $title );
		$info_ob_i18n = $this->insertInfoObject_i18n ( $title, $object_id );
		$this->insert_slug ( $object_id, $title, $slug );
		$this->insert_status ( $object_id );
		$this->db->trans_complete ();
		return $object_id;
	}
	// insert object
	function insertObject() {
		$time = date ( 'Y-m-d G:i:s' );
		$array = array (
				'class_name' => 'QubitInformationObject',
				'created_at' => $time,
				'updated_at' => $time,
				'serial_number' => 0 
		);
		$this->db->insert ( 'object', $array );
		return $this->db->insert_id ();
	}
	// insert information object
	function insetInformationObject($id, $parent_id, $title) {
		// get level_of_discription_id: get from atommodel
		$tt = $this->level_of_discription_id ( 'Polling District', 'Levels of description' );
		$level_of_description_id = $tt ['id'];
		
		$no_of_siblings = $this->countSiblings ( $parent_id );
		$left = '';
		$right = '';
		if ($no_of_siblings > 0) {
			/*
			 * if there are children for the parent node,
			 * rgt for have existing sibling
			 */
			$last_left_sibling = $this->get_latest_left_siblng ( $parent_id );
			$myrgt = $this->get_my_rgt ( $last_left_sibling );
			$this->update_lft ( $myrgt );
			$this->update_rgt ( $myrgt );
			$left = $myrgt + 1;
			$right = $myrgt + 2;
		} else {
			/*
			 * if there is no chiled for the parent node,
			 * lft for NOT have existing siblings
			 */
			$mylft = $this->get_my_lft ( $parent_id );
			$this->update_lft ( $mylft );
			$this->update_rgt ( $mylft );
			$left = $mylft + 1;
			$right = $mylft + 2;
		}
		
		/**
		 * *************
		 */
		
		$array = array (
				'id' => $id,
				'identifier' => $title,
				'oai_local_identifier' => '',
				'level_of_description_id' => $level_of_description_id,
				'collection_type_id' => null,
				'repository_id' => null,
				'parent_id' => $parent_id,
				'description_status_id' => null,
				'description_detail_id' => null,
				'description_identifier' => null,
				'source_standard' => 'ISAD(G) 2nd edition',
				'display_standard_id' => null,
				'lft' => $left,
				'rgt' => $right,
				'source_culture' => 'en' 
		);
		$this->db->insert ( 'information_object', $array );
		return $this->db->insert_id ();
	}
	
	// insert information object i18n(collection)
	function insertInfoObject_i18n($title, $obj_id) {
		$array = array (
				'title' => $title,
				'alternate_title' => null,
				'edition' => null,
				'extent_and_medium' => 'Unspecified',
				'archival_history' => null,
				'acquisition' => null,
				'scope_and_content' => null,
				'appraisal' => null,
				'accruals' => null,
				'arrangement' => null,
				'access_conditions' => null,
				'reproduction_conditions' => null,
				'physical_characteristics' => null,
				'finding_aids' => null,
				'location_of_originals' => null,
				'location_of_copies' => null,
				'related_units_of_description' => null,
				'institution_responsible_identifier' => null,
				'rules' => null,
				'sources' => null,
				'revision_history' => null,
				'id' => $obj_id,
				'culture' => 'en' 
		);
		
		$this->db->insert ( 'information_object_i18n', $array );
		return $this->db->insert_id ();
	}
	
	// insert slug
	function insert_slug($id, $title, $slug) {
		// http://stackoverflow.com/questions/20439834/make-a-post-slug-unique
		$array = array (
				'id' => '',
				'slug' => $slug,
				'serial_number' => 0,
				'object_id' => $id 
		);
		
		$this->db->insert ( 'slug', $array );
	}
	// insert status
	function insert_status($id) {
		$array = array (
				'id' => '',
				'type_id' => 158,
				'status_id' => 160,
				'serial_number' => 0,
				'object_id' => $id 
		);
		$this->db->insert ( 'status', $array );
	}
	
	// get parent id, after given $myid
	function getParentId($myid) {
		$this->db->select ( 'parent_id' );
		$this->db->from ( 'information_object' );
		$this->db->where ( 'id', $myid );
		$query = $this->db->get ();
		$results = $query->row_array ();
		echo $results ['parent_id'];
		// return $results['parent_id'];
	}
	function get_slug($slug) {
		$this->db->select ( 'slug' );
		$this->db->from ( 'slug' );
		$this->db->where ( 'slug', $slug );
		$query = $this->db->get ();
		$result = $query->row_array ();
		if (! empty ( $result )) {
			return true;
		} else {
			return false;
		}
	}
	
	/* get from atommodel */
	
	// level of discription ID
	// $term_name=Polling District; $taxonomy_name=Levels of description
	function level_of_discription_id($term_name, $taxonomy_name) {
		$this->db->select ( 'term.id' );
		$this->db->from ( 'taxonomy_i18n' );
		$this->db->join ( 'term', 'term.taxonomy_id = taxonomy_i18n.id', 'left' );
		$this->db->join ( 'term_i18n', 'term_i18n.id = term.id', 'left' );
		$this->db->where ( 'taxonomy_i18n.name', $taxonomy_name );
		$this->db->where ( 'term_i18n.culture', 'en' );
		$this->db->where ( 'term_i18n.name', $term_name );
		$query = $this->db->get ();
		return $query->row_array ();
	}
	// return lft value of a given id
	function get_my_lft($id) {
		$this->db->select ( 'lft' );
		$this->db->from ( 'information_object' );
		$this->db->where ( 'id', $id );
		$query = $this->db->get ();
		$results = $query->row_array ();
		return $results ['lft'];
	}
	// return rgt value of a given id
	function get_my_rgt($id) {
		$this->db->select ( 'rgt' );
		$this->db->from ( 'information_object' );
		$this->db->where ( 'id', $id );
		$query = $this->db->get ();
		$results = $query->row_array ();
		return $results ['rgt'];
	}
	// update lft for all field
	function update_lft($my_lft_rgt) {
		/*
		 * $sql = "UPDATE information_object as t1 JOIN
		 * (SELECT node.*
		 * FROM (select ioi.title,io.* From information_object_i18n as ioi JOIN information_object as io ON io.id=ioi.id) AS node,
		 * (select io.id,ioi.title,io.parent_id,io.lft,io.rgt From information_object_i18n as ioi JOIN information_object as io ON io.id=ioi.id) AS parent
		 * WHERE node.lft BETWEEN parent.lft AND parent.rgt
		 * AND parent.id = 390
		 * ORDER BY node.lft) as t2
		 * ON t1.id=t2.id
		 *
		 * SET t1.lft = t1.lft + 2
		 * WHERE t2.lft > $my_lft_rgt";
		 */
		$sql = "UPDATE information_object SET lft = lft + 2 WHERE lft > $my_lft_rgt";
		$this->db->query ( $sql );
	}
	// update rgt for all field
	function update_rgt($my_lft_rgt) {
		$sql = "UPDATE information_object SET rgt = rgt + 2 WHERE rgt > $my_lft_rgt";
		$this->db->query ( $sql );
	}
	// count number of sibling return 0 for no select element, or intiger, @parent_id: parent id of the siblings
	function countSiblings($parent_id) {
		$this->db->select ( '*' );
		$this->db->from ( 'information_object' );
		$this->db->where ( 'parent_id', $parent_id );
		$count = $this->db->count_all_results ();
		return $count;
	}
	// get latest lft sibling @parent_id: parent id of the siblings
	function get_latest_left_siblng($parent_id) {
		$this->db->select ( 'id' );
		$this->db->from ( 'information_object' );
		$this->db->where ( 'parent_id', $parent_id );
		$this->db->order_by ( "oai_local_identifier", "DESC" );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			$results = $query->result ();
			return $results [0]->id;
		}
	}
	// select query for table that supper paret act as
	function getMyTable() {
		$this->db->select ( 'node.id,node.lft,node.rgt,node.parent_id' );
		$this->db->from ( 'information_object node,information_object as parent' );
		$this->db->where ( "node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = 390" );
		$query = $this->db->get ();
		$result = $query->result ();
		return $query;
	}
	// function from atom
}