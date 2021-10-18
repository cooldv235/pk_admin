<?php 

class Faq_model extends CI_Model {

	private $database;
	private $table;
    function __construct() {
		parent::__construct();
		$this->database = $this->load->database('login', TRUE);
    }

     // Unique to models with multiple tables
	function set_table($table) {
		$this->table = $table;
	}
	
	// Get table from table property
    function get_table() {
		$table = $this->table;
		return $table;
    }

    // Retrieve all data from database and order by column return query
    function get($order_by) {
		$db = $this->database;
		$table = $this->get_table();
		$db->order_by($order_by);
		$query=$db->get($table);
		return $query;
    }

	// Limit results, then offset and order by column return query
    function get_with_limit($limit, $offset, $order_by) {
		$db = $this->database;
		$table = $this->get_table();
		$db->limit($limit, $offset);
		$db->order_by($order_by);
		$query=$db->get($table);
		return $query;
    }

	// Get where column id is ... return query
    function get_where($id) {
		$db = $this->database;
		$table = $this->get_table();
		$db->where('id', $id);
		$query=$db->get($table);
		return $query->row_array();
    }

	// Get where custom column is .... return query
    function get_where_custom($col, $value) {
		$db = $this->database;
		$table = $this->get_table();
		$db->where($col, $value);
		$query=$db->get($table);
		return $query;
    }

	function get_list($id = NULL) {
		$db = $this->database;
		$table = $this->get_table();
		if (empty($id)) {
            $query = $db->get($table);
            return $query->result_array();
        }

        $query = $db->get_where($table, array('id' => $id));
        return $query->row_array();
	}

	function get_category_dropdown_list($id = NULL) {
		$db = $this->database;
		$condition['is_active'] = TRUE;
		$db->select('id,faq_category');
        $query = $db->get_where('faques', $condition);
        return $query->result_array();
	}

	function get_distinct_category($id = NULL) {
		$db = $this->database;
		$condition['is_active'] = TRUE;
		$db->distinct('faq_category');
		//$db->select('id,faq_category');
        $query = $db->get_where('faques', $condition);
        
        return $query->result_array();
	}

	function _insert($data) {
		$response['status'] = 'failed';
		$db = $this->database;
		$table = $this->get_table();
		$res = $db->insert($table, $data);
		//print_r($res);
		if($res){
			$response['status'] = 'success';
			$response['id'] = $db->insert_id();
		}else{
			echo $db->_error_message();
		}
   		return  $response;
    }

    function _insert_multiple($data) {
    	$db = $this->database;
    	$table = $this->get_table();
    	$num_rows = $db->insert_batch($table,$data);
    	return $num_rows;
    }

   	function _update($id, $data) {
    	$db = $this->database;
    	$table = $this->get_table();
    	$db->where('id', $id);
    	$update = $db->update($table, $data);
    	return $update;
    } 

    function update_multiple($field, $data) {
		$db = $this->database;
		$table = $this->get_table();
		$updt = $db->update_batch($table, $data, $field);
		return $updt;
	}

	function get_active_list($id = NULL) {
		$db = $this->database;
		$table = $this->get_table();
		$condition['is_active'] = TRUE;
		//$db->select(['products.*', 'product_categories.category_name']);
		//$db->join('product_categories', 'product_categories.id = products.product_category_id');
		
		if (empty($id))
        {
			//print_r("reached here");exit;
            $query = $this->db->get_where('faqs', $condition);
            return $query->result_array();
        }
        $condition['id'] = $id;
        $query = $this->db->get_where('faqs', $condition);
       //print_r($db->last_query());
        return $query->row_array();
	}

	function get_category() {
		$db = $this->database;
		$table = $this->get_table();
	}

}