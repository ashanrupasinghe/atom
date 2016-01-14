<?php

/**
 * Created by PhpStorm.
 * User: Isuru
 * Date: 9/4/2015
 * Time: 11:27 AM
 */
class atomRegModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->library('javascript');
    }

    // populate collection records in level 1
    public function getCollection()
    {
        $this->db->select('id,title');
        $this->db->from('information_object_i18n');
        $this->db->where('id', '390');
        $this->db->order_by('title', 'asc');
        $query = $this->db->get();
        return $query;
    }

    function getData($loadType, $loadId)
    {
        if ($loadType == "Series") {
            $fieldList = 'j.id, j.title as name';
            $table = 'information_object  i';
            $fieldName = 'i.parent_id';
            $orderByField = 'j.title';
        }else {
            $fieldList = 'j.id, j.title as name';
            $table = 'information_object  i';
            $fieldName = 'i.parent_id';
            $orderByField = 'j.title';
        }


        $this->db->select($fieldList);
        $this->db->from($table);
        $this->db->join('information_object_i18n j', 'j.id = i.id', 'inner');
        $this->db->where($fieldName, $loadId);
        $this->db->order_by($orderByField, 'asc');
        $query = $this->db->get();
        return $query;
    }
    }

?>