<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enquiries_model extends CI_Model
{

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

    function tbl_enquiries(){
        $check = $this->check_table('enquiries');
        //print_r($check);exit;
        if(!$check){
            //echo "table does not exists<br>";
            $query = $this->db->query("CREATE TABLE IF NOT EXISTS `enquiries`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `referred_by` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `primary_email` varchar(255) NOT NULL,
  `secondary_email` varchar(255) NOT NULL,
  `contact_1` varchar(12) NOT NULL,
  `contact_2` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `blood_group` varchar(3) NOT NULL,
  `profile_img` varchar(255) NOT NULL DEFAULT 'defaultm.jpg',
  `enq_code` varchar(250) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `message` longtext NOT NULL,
  `amount_before_tax` float(10,2) NOT NULL,
  `amount_after_tax` float(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enq_code` (`enq_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            if($query){
                $query2 = $this->db->query("CREATE TABLE IF NOT EXISTS `enquiry_details` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `enquiry_id` int(11) NOT NULL,
                    `product_id` int(11) NOT NULL,
                    `pack_product_id` int(11) NOT NULL,
                    `unit_price` float(10,2) NOT NULL,
                    `qty` int(11) NOT NULL,
                    `uom` varchar(100) NOT NULL,
                    `tax` float(10,2) NOT NULL,
                    `is_active` tinyint(1) NOT NULL DEFAULT '1',
                    `created` datetime NOT NULL,
                    `modified` datetime NOT NULL,
                    `comment` longtext NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
                );
            }
            return $query;
        }
        else
            return FALSE;
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

    function count_where($column, $value) {
        //print_r($column." ".$value);//exit;
        $db = $this->database;
        $table = $this->get_table();
        //print_r($table);/*exit;*/
        $db->where($column, $value);
        $query=$db->get($table);
        /*echo "<pre>";
        print_r($query);exit;*/
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    // Insert data into table $data is an associative array column=>value
    function _insert($data) {
        $db = $this->database;
        $table = $this->get_table();
        $db->insert($table, $data);
        $insert_id = $db->insert_id();
        return  $insert_id;

    }

    function _insert_multiple($data) {
        $db = $this->database;
        $table = $this->get_table();
        $num_rows = $db->insert_batch($table,$data);
        return $num_rows;
    }

    // Get where custom column is .... return query
    function get_where_custom($col, $value) {
        $db = $this->database;
        $table = $this->get_table();
        $db->where($col, $value);
        $query=$db->get($table);
        return $query;
    }

    // Get where column id is ... return query
    function get_where($conditions = []) {
        
        $db = $this->database;
        $table = $this->get_table();
        if(is_array($conditions)){
            foreach ($conditions as $key => $condition) {
                $db->where($key, $condition);
            }
        }else{
            $db->where('id', $conditions);
        }
        $query=$db->get($table);
        //print_r($db->last_query());exit;
        return $query;
    }

    // Retrieve all data from database and order by column return query
    function get($order_by) {
        $db = $this->database;
        $table = $this->get_table();
        $db->order_by($order_by);
        $query=$db->get($table);
        return $query;
    }


    function _update($id,$data) {
        $db = $this->database;
        $table = $this->get_table();
        $this->db->where('id',$id);
        $updt = $this->db->update($table,$data);
        return $updt;
    }

    function _update_multiple($field, $data) {
        $db = $this->database;
        $table = $this->get_table();
        $updt = $db->update_batch($table, $data, $field);
        return $updt;
    }

    function get_custom_address_type_users($addressBelongsTo){
        //echo $addressBelongsTo;
        $db = $this->database;
        $table = $this->get_table();
        $sql = '';

        if($addressBelongsTo=='companies'){
            $sql = "Select 
            ".$addressBelongsTo.".id, 
            ".$addressBelongsTo.".company_name as fullname,
            ".$addressBelongsTo.".logo as image, 
            ".$addressBelongsTo.".short_code as emp_code  from ".$addressBelongsTo." WHERE ".$addressBelongsTo.".is_active=true order by fullname asc";
        } else {

            $sql = "Select 
            ".$addressBelongsTo.".id, 
            Concat(".$addressBelongsTo.".first_name, ' ', ".$addressBelongsTo.".middle_name, ' ', ".$addressBelongsTo.".surname) as fullname,
            ".$addressBelongsTo.".profile_img as image, 
            ".$addressBelongsTo.".emp_code  from ".$addressBelongsTo." WHERE ".$addressBelongsTo.".is_active=true order by fullname asc";
        }
        $query = $db->query($sql);
        //print_r($db->last_query());
        return $query->result_array();
    }


    function enquiry_followup($order_by) {
        $db = $this->database;
        $table = $this->get_table();
        
        $query = $db->query('Select enquiries.*, (select concat(f.followup_date," ", f.followup_time) from follow_ups f where f.id=MAX(follow_ups.id)) as followupdate, (select message from follow_ups f where f.id=MAX(follow_ups.id)) as followup from enquiries left join follow_ups on follow_ups.type="enquiries" AND follow_ups.type_id=enquiries.id Where follow_ups.followup_date>=CURDATE() GROUP BY follow_ups.type_id

UNION

Select enquiries.*, (select concat(f.followup_date," ", f.followup_time) from follow_ups f where f.id=MAX(follow_ups.id)) as followupdate, (select message from follow_ups f where f.id=MAX(follow_ups.id)) as followup from enquiries left join follow_ups on follow_ups.type="enquiries" AND follow_ups.type_id=enquiries.id Where follow_ups.followup_date<CURDATE() GROUP BY follow_ups.type_id');
        return $query;
    }

    function enquiryListData($postData=null){
        //echo " reached here";exit;
        //echo "<pre>";print_r($postData);exit;
        $response = array();
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        //echo "<pre>"; print_r($postData);exit;
   
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " AND (t.first_name like '%".$searchValue."%' or t.contact_1 like '%".$searchValue."%' or t.enq_code like'%".$searchValue."%' or t.message like'%".$searchValue."%' or t.primary_email like '%".$searchValue."%' or t.type like '%".$searchValue."%' or t.referred_by like '%".$searchValue."%')";
        }
        $condition = [];
        //print_r($_SESSION['roles']);
        
        if(NULL!==$postData['type']){
            $condition['e.type']= $postData['type'];      
        }
        $condition['e.is_active'] = true;

        /*echo $this->uri->segment(3);
        if(NULL!==$this->uri->segment(3)){
            $condition['cl.type'] = $this->uri->segment(3);
        }
        print_r($condition);*/
        $this->db->select(['e.id', 'e.type', 'e.message', 'e.enq_code', 'e.referred_by','e.is_active', 'concat(e.first_name," ", e.middle_name, " ", e.surname," - ",e.company_name) as customer_name', 'e.first_name', 'e.primary_email', 'e.contact_1','e.image_name_1']);
        

        $this->db->where($condition);

        $sql = $this->db->get_compiled_select('enquiries e');
        $sql2 = 'Select count(*) as allcount from ('.$sql.') t';
        $records = $this->db->query($sql2)->result();
        $totalRecords = $records[0]->allcount;
   
        $sql2 = 'Select count(*) as allcount from ('.$sql.') t where 1=1'.$searchQuery;
        $records = $this->db->query($sql2)->result();
        $totalRecordwithFilter = $records[0]->allcount;
        
        $sql2 = 'Select * from ('.$sql.') t where 1=1'.$searchQuery.' order by '.$columnName.' '.$columnSortOrder;
        if ($rowperpage!='-1') {
            $sql2.=' LIMIT '.$start.', '.$rowperpage;
        }
        $records = $this->db->query($sql2)->result();
        //echo $this->db->last_query();exit;
        /*echo '<pre>';print_r($records);
        exit;*/
        $data = array();
        foreach($records as $recordKey => $record ){
   
           $data[] = array(
            "sr_no"=>$recordKey+1,
            "id"=>$record->id,
            "customer_name"=>($record->customer_name)?$record->customer_name:'',
            "image"=>$record->image_name_1,
            "first_name"=>$record->first_name,
            "contact_1"=>$record->contact_1,
            "type"=>$record->type,
            "email"=>$record->primary_email,
            "message"=>$record->message,

            "enq_code" => $record->enq_code,
            "is_active"=>$record->is_active,
            'action'=>'Action'
           ); 
        }
        //echo "<pre>"; print_r($data);exit;
        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecordwithFilter,
           "iTotalDisplayRecords" => $totalRecords,
           "aaData" => $data
        );

        return $response;
    }

}