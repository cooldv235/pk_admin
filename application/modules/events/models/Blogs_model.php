<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event_model extends CI_Model {
	private $database;
	private $table;

	function __construct(){
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

    function tbl_event_categories(){
    	$check = $this->check_table('event_categories');
    	//print_r($check);exit;
    	if(!$check){
    		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `event_categories` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`parent_id` int(11) NOT NULL,
				`category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`gst` varchar(255) NOT NULL,
				`image_name_1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`image_name_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`is_active` tinyint(1) NOT NULL DEFAULT '1',
				`created` datetime NOT NULL,
				`modified` datetime NOT NULL,
				`meta_keyword` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`meta_title` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`meta_description` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				PRIMARY KEY (id),
				UNIQUE KEY (slug)
			  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
    		);
		if($query){
				$blogs = $this->db->query("CREATE TABLE IF NOT EXISTS `blogs` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`blogs_category_id` int(11) NOT NULL,
						`type` enum('text','video','','') NOT NULL DEFAULT 'text',
						`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`short_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`user_id` int(11) NOT NULL,
						`state_id` int(11) NOT NULL,
						`featured_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`published_on` datetime NOT NULL,
						`slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
						`meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`meta_keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						`is_trend` tinyint(1) NOT NULL DEFAULT '0',
						`is_hot` tinyint(1) NOT NULL DEFAULT '0',
						`is_featured` tinyint(1) NOT NULL DEFAULT '0',
						`is_active` tinyint(1) NOT NULL DEFAULT '1',
						`read_count` int(11) NOT NULL,
						`created` datetime NOT NULL,
						`modified` datetime NOT NULL,
						PRIMARY KEY (id),
						UNIQUE KEY (slug)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
				);

				$blogs_category_section = $this->db->query("CREATE TABLE IF NOT EXISTS `blogs_category_sections` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `section_id` int(11) NOT NULL,
					  `blogs_category_id` int(11) NOT NULL,
					  `is_active` tinyint(1) NOT NULL DEFAULT '1',
					  `created` datetime NOT NULL,
					  `modified` datetime NOT NULL,
					  PRIMARY KEY (id)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
				);

				$blogCities = $this->db->query("CREATE TABLE IF NOT EXISTS `blogs_cities` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`blogs_id` int(11) NOT NULL,
					`city_id` int(11) NOT NULL,
					`is_active` tinyint(1) NOT NULL DEFAULT '1',
					`created` datetime NOT NULL,
					`modified` datetime NOT NULL,
					PRIMARY KEY (id)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
				);

				$sections = $this->db->query("CREATE TABLE IF NOT EXISTS `sections` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`page` enum('homepage') NOT NULL,
					`title` varchar(255) NOT NULL,
					`is_active` tinyint(1) NOT NULL DEFAULT '1',
					`created` datetime NOT NULL,
					`modified` datetime NOT NULL,
					PRIMARY KEY(id)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
				);


			}
		}
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
		//print_r($query->row_array());exit;
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

	function get_blogs_category_list($id=null) {
		$db = $this->database;
		$condition['is_active'] = true;
		
		$db->select('id,category_name')->where('`id` NOT IN (SELECT blogs_category_id from `blogs`)');
		$query = $db->get_where('event_categories', $condition);
		//print_r($db->last_query());
		return $query->result_array();
	}

	function get_distinct_categorylist_for_blogs() {
		$condition['is_active'] = true;
		$db = $this->database;
		$table = $this->get_table();
		$db->select(['DISTINCT(event_categories.id)', 'event_categories.category_name']);
		$db->join('blogs', 'blogs.blogs_category_id = event_categories.id');
		$query = $db->get($table);
		return $query->result_array(); 
		}

		function get_category_dropdown_list_for_category($id = NULL) {
		$db = $this->database;
        $table = $this->get_table();
		$condition['is_active'] = TRUE;
		//$db->select('id,category_name');
		$db->select('id', 'DISTINCT(category_name)');
        $query = $db->get_where('event_categories', $condition);
        return $query->result_array();
	}


	function get_city_list($id=null) {
		$db = $this->database;
		$condition['blogs_cities.is_active'] = true;
		$condition['blogs_cities.blogs_id'] = $id;
		$db->select(['blogs_cities.*', 'cities.city_name']);
		//$db->select(['blogs.*', 'states.state_name']);
		$db->join('cities', 'cities.id = blogs_cities.city_id');
		//$db->join('states', 'states.id = blogs.state_id');

		//$db->join()
		//$db->select('id,category_name')->where('`id` NOT IN (SELECT blogs_category_id from `blogs`)');
		$query = $db->get_where('blogs_cities', $condition);
		//print_r($db->last_query());
		return $query->result_array();
	}

	function get_state_list($id=null) {
		$db = $this->database;
		$condition['blogs.is_active'] = true;
		$condition['blogs.id'] = $id;
		$db->select(['blogs.*', 'states.state_name']);
		//$db->select(['blogs.*', 'states.state_name']);
		$db->join('states', 'states.id = blogs.state_id');
		//$db->join('states', 'states.id = blogs.state_id');

		//$db->join()
		//$db->select('id,category_name')->where('`id` NOT IN (SELECT blogs_category_id from `blogs`)');
		$query = $db->get_where('blogs', $condition);
		//print_r($db->last_query());
		return $query->result_array();
	}

	function get_category_dropdown_list($id = NULL) {
		$db = $this->database;
		$condition['is_active'] = TRUE;
		$db->select('id,category_name');
        $query = $db->get_where('event_categories', $condition);
        return $query->result_array();
	}

	function get_category_list($condition = []){
    	$db = $this->database;
		$table = $this->get_table();
		//$condition[$table.'.is_active'] = true;
//db->join($table.' c2', 'c2.parent_id='.$table.'.id', 'left');
		$db->select($table.'.*, (select category_name from event_categories nc where nc.id='.$table.'.parent_id) as parent');
		$db->order_by($table.'.is_active desc, '.$table.'.id DESC');
		//$db->limit(3, 0);
		$query = $db->get_where($table, $condition);
		//print_r($db->last_query());
		return $query->result_array();
    }

	function get_categorylist_for_blogs() {
		$db = $this->database;
		$condition['is_active'] = true;
		//$sql = 'Select id, category_name from event_categories where id in (Select distinct blogs_category_id from blogs) union Select id, category_name from event_categories where id Not in (Select distinct blogs_category_id from blogs)';
		//$db->select('id,category_name')->where('id not IN(SELECT distinct `parent_id` from `event_categories`)');
		$query = $db->get_where('event_categories', $condition);
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
    	//echo '<pre>';print_r($data);
    	$db = $this->database;
    	$table = $this->get_table();
    	$num_rows = $db->insert_batch($table,$data);
    	//echo "inserted";
    	//print_r($db->last_query());exit;
    	return $num_rows;
    }

    function update_event_categories($id, $data) {
    	$db = $this->database;
    	$table = $this->get_table();
    	$db->where('id', $id);
    	$update = $db->update('event_categories', $data);
    	//print_r($db->last_query());
    	return $update;
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
		if (empty($id))
        {
			//print_r("reached here");exit;
            $query = $this->db->get_where('blogs', $condition);
            return $query->result_array();
        }
        $condition['id'] = $id;
        $query = $this->db->get_where('blogs', $condition);
       //print_r($db->last_query());
        return $query->row_array();
	}

	function get_blogs_list($conditions){
		$db = $this->database;
		$table = $this->get_table();
		//$condition['blogs.id'] = $id;
		//echo $conditons;exit;
		//$db->select(['products.*', 'product_categories.category_name', 'product_images.image_name_1', 'product_images.image_name_2']);
		$db->select(['blogs.*', 'event_categories.category_name', 'login.first_name', 'login.surname', 'states.state_name']);
		$db->join('event_categories', 'event_categories.id = blogs.blogs_category_id', 'left');
		$db->join('login', 'login.employee_id = blogs.user_id and account_type="employees"', 'left');
		$db->join('states', 'states.id = blogs.state_id', 'left');
		foreach ($conditions as $key => $condition) {
			$db->where($key, $condition);

		}
		$db->order_by('modified DESC');
		$query = $db->get($table);
		//print_r($db->last_query());exit;
		return $query->result_array(); 
	}

	function get_product_list($conditions){
		$db = $this->database;
		$table = $this->get_table();
		$db->select(['products.*', 'product_categories.category_name', 'product_images.image_name_1', 'product_images.image_name_2']);
		$db->join('product_categories', 'product_categories.id = products.product_category_id');
		$db->join('product_images', 'product_images.product_id='.$table.'.id AND product_images.featured_image = 1', 'left');
		foreach ($conditions as $key => $condition) {
			$db->where($key, $condition);
		}
		$db->order_by('created DESC');
		$query = $db->get($table);
		return $query->result_array(); 
	}

	function delete($id) {

		$db = $this->database;
		$table = $this->get_table();
		$query = $db->delete($table, array('blogs_id' => $id));
		return $query;
    }
}
