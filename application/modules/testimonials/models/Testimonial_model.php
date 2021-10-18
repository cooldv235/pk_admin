<?php 
class Testimonial_model extends CI_Model {
	private $database;
	private $table;
	function __construct() {
		parent::__construct();
		$this->database = $this->load->database('login', TRUE);
	}

	function check_table($table=''){
    	if(empty($table))
    		return FALSE;

    	$query = $this->db->query('SHOW TABLES LIKE "'.$table.'"');
    	$res = $query->row_array();

    	return $res;
    }

    function tbl_company_testimonials(){
    	$check = $this->check_table('company_testimonials');
    	//print_r($check);exit;
    	if(!$check){
    		
    		//echo "table does not exists<br>";
    		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `company_testimonials` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`company` varchar(255) NOT NULL,
				`designation` varchar(255) NOT NULL,
				`comment` longtext NOT NULL,
				`image` varchar(255) NOT NULL,
				`is_active` tinyint(1) NOT NULL DEFAULT '1',
				`created` datetime NOT NULL,
				`modified` datetime NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
			);

    		if($query){
				
			}
    		return $query;
    	}
    	else
    		return TRUE;
    	
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
		//print_r($query->result_array());exit;
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
    	//echo '<pre>';print_r($data);
    	$db = $this->database;
    	$table = $this->get_table();
    	$num_rows = $db->insert_batch($table,$data);
    	//echo "inserted";
    	//print_r($db->last_query());exit;
    	return $num_rows;
    }

   	function _update($id, $data) {
    	$db = $this->database;
    	$table = $this->get_table();
    	$db->where('id', $id);
    	$update = $db->update($table, $data);
    	return $update;
    } 

    function _update_multiple($field, $data) {
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
            $query = $this->db->get_where('company_testimonials', $condition);
            return $query->result_array();
        }
        $condition['id'] = $id;
        $query = $this->db->get_where('company_testimonials', $condition);
       //print_r($db->last_query());
        return $query->row_array();
	}
}
