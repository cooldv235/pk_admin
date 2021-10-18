<?php 

class Countries extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('countries/countries_model');
		//$this->load->library('pktdblib');
		$setup = $this->setup();	
	}

	function setup(){
		$countries = $this->countries_model->tbl_countries();
		return TRUE;
	}

	function index($id = NULL) {
		$data['countries'] = $this->pktdblib->get_active_list();
		$data['content'] = 'countries/index';
		$this->template->static_layout($data);
		//print_r($data['countries']);exit;
	}

	function get_dropdown_list($id = NULL)
	{
		$countryList = [];
		$this->pktdblib->set_table('countries');
		$countries = $this->pktdblib->get_active_list();
		foreach($countries as $key => $country) {
			$countryList[$country['id']] = $country['name'];
		}
		return $countryList;	
	}

	function _register_admin_add($data) {
		$this->pktdblib->set_table("countries");
		$id = $this->pktdblib->_insert($data);
		return json_encode(["msg"=>"Countries Successfully Inserted", "status"=>"success", 'id'=>$id['id']]);
	}
	
	function upload_address_csv_file(){
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //echo '<pre>';print_r($_POST);print_r($_FILES);
            //exit;
            $countryId = 0;
            $stateId = 0;
            $cityId = 0;
            $areaId = 0;
            $address = [];
            $error = [];
            if(!empty($_FILES)) {
                $fname = $_FILES['sel_file']['name'];
                $chk_ext = explode('.',$fname);
                if(end($chk_ext)=='xlsx' || end($chk_ext) == 'xls' || end($chk_ext) == 'csv') {
	                $filename = $_FILES['sel_file']['tmp_name'];
	                $this->load->library('excel');
	                $objPHPExcel = PHPExcel_IOFactory::load($filename);
	                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	                //echo "<pre>";
	                foreach ($cell_collection as $cell) {
	                //print_r($cell);exit();
	                   $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
	                   $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
	                   $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
	                   if ($row == 1) {
	                       $header[$row][$column] = $data_value;
	                   } else {
	                       $arr_data[$row][$column] = $data_value;
	                   }
	                }
	                //exit;
	                $data['header'] = $header;
	                $data['values'] = $arr_data;
	                //echo "<pre>";
	                foreach ($data['values'] as $xlsxkey => $xlsxvalue) {foreach ($xlsxvalue as $key => $value) {
	                        $xlsxUploadedData[$xlsxkey-2][] = $value;
	                    }
	                }
	                foreach ($xlsxUploadedData as $xlskey => $xlsvalue) {
	                	//echo '<pre>';print_r($xlsvalue);exit;
	                    $this->pktdblib->set_table('countries');
	                    $countries = $this->pktdblib->custom_query('select c.* from countries c where c.name="'.trim(ucfirst($xlsvalue[0])).'"');
	                    //echo '<pre>';print_r($countries);exit;
	                    if(count($countries)>=1){
	                        //$error[]= "Duplicate entry at row ".$xlskey;
	                        $countryId = $countries[0]['id'];
	                    }else{
	                    	$countryData['name'] = trim(ucfirst($xlsvalue[0]));
	                    	$countryData['short_name'] = trim(ucfirst($xlsvalue[0]));
	                    	$countryData['created'] = $countryData['modified'] = date('Y-m-d H:i:s');
	                    	$countryData['created_by'] = $countryData['modified_by'] = $this->session->userdata('user_id');
	                    	$this->pktdblib->set_table('countries');
	                    	$country = $this->pktdblib->_insert($countryData);
	                    	if($country['status'] == 'success'){
	                    		$CountryId = $country['id'];
	                    		$msg = array('message'=>'Country Added Successfull', 'class'=>'alert alert-success');
	                    	}else{
	                        	$error[]= "Error Occured at row ".$xlskey;
	                    	}
	                    	$addressData['country_id'] = $countryId;
	                    }
	                   // echo $countryId;exit;
	                    $this->pktdblib->set_table('states');
	                    $states = $this->pktdblib->custom_query('select s.* from states s where s.state_name="'.trim(ucfirst($xlsvalue[1])).'" and country_id='.$countryId);
	                   

	                    if(count($states)>=1){
	                        //$error[]= "Duplicate entry at row ".$xlskey;
	                        $stateId = $states[0]['id'];
	                    }else{
	                    	$stateData['state_name'] = trim(ucfirst($xlsvalue[1]));
	                    	$stateData['country_id'] = $countryId;
	                    	$stateData['slug'] = strtolower($stateData['state_name']);
	                    	$stateData['is_active'] = true;
	                    	$stateData['created'] = $stateData['modified'] = date('Y-m-d H:i:s');
	                    	$stateData['created_by'] = $stateData['modified_by'] = $this->session->userdata('user_id');
	                    	$this->pktdblib->set_table('states');
	                    	$state = $this->pktdblib->_insert($stateData);
	                    	if($state['status'] == 'success'){
	                    		$stateId = $state['id'];
	                    		$msg = array('message'=>'State Added Successfull', 'class'=>'alert alert-success');
	                    	}else{
	                        	$error[]= "Error Occured while adding state at row ".$xlskey;
	                    	}
	                    	$addressData['state_id'] = $stateId;
	                    }
	                    $this->pktdblib->set_table('cities');
	                    $cities = $this->pktdblib->custom_query('select ct.* from cities ct where ct.city_name="'.trim(ucfirst($xlsvalue[2])).'" and ct.country_id='.$countryId.' and state_id='.$stateId);
	                    if(count($cities)>=1){
	                        //$error[]= "Duplicate entry at row ".$xlskey;
	                        $cityId = $cities[0]['id'];
	                    }else{
	                    	$cityData['city_name'] = trim(ucfirst($xlsvalue[2]));
	                    	$cityData['country_id'] = $countryId;
	                    	$cityData['state_id'] = $stateId;
	                    	$cityData['is_active'] = true;	                    	$cityData['short_name'] = strtoupper($xlsvalue[2]);
	                    	$cityData['created'] = $cityData['modified'] = date('Y-m-d H:i:s');
	                    	$cityData['created_by'] = $cityData['modified_by'] = $this->session->userdata('user_id');

	                    	$this->pktdblib->set_table('cities');
	                    	$city = $this->pktdblib->_insert($cityData);
	                    	if($city['status'] == 'success'){
	                    		$cityId = $city['id'];
	                    		$msg = array('message'=>'City Added Successfull', 'class'=>'alert alert-success');
	                    	}else{
	                        	$error[]= "Error Occured while adding City at row ".$xlskey;
	                    	}
	                    	$cityId = $city['id'];
	                    	$addressData['city_id'] = $cityId;
	                    }

	                    $this->pktdblib->set_table('areas');
	                    $areas = $this->pktdblib->custom_query('select a.* from areas a where a.area_name="'.trim(ucfirst($xlsvalue[3])).'" and city_id='.$cityId);
	                    if(count($areas)>=1){
	                        //$error[]= "Duplicate entry at row ".$xlskey;
	                        $areaId = $areas[0]['id'];
	                    }else{
	                    	$areaData['area_name'] = trim(ucfirst($xlsvalue[3]));
	                    	$areaData['city_id'] = $cityId;
	                    	$areaData['created'] = $areaData['modified'] = date('Y-m-d H:i:s');
	                    	$areaData['created_by'] = $areaData['modified_by'] = $this->session->userdata('user_id');

	                    	$this->pktdblib->set_table('areas');
	                    	$area = $this->pktdblib->_insert($areaData);
	                    	if($area['status'] == 'success'){
	                    		$areaId = $area['id'];
	                    		$msg = array('message'=>'Area Added Successfull', 'class'=>'alert alert-success');
	                    	}else{
	                        	$error[]= "Error Occured while adding Area at row ".$xlskey;
	                    	}
	                    	$areaId = $area['id'];
	                    	$addressData['city_id'] = $areaId;
	                    }
	                    //echo $countryId;echo $stateId; echo $cityId; echo $areaId;exit;
	                    

	                }
            	} 
               	if(empty($error)){
               		$msg = array('message'=>'Data Added Successfully', 'class'=>'alert alert-success');
           			$this->session->set_flashdata('message',$msg);
            		redirect('countries/upload_address_csv_file');
               	}else{
	                $csv = array('error' => $error, 'class' => 'alert alert-danger');
	                $this->session->set_flashdata('error',$csv);
	                redirect('countries/upload_address_csv_file');
	            }
	            	
        	}
        }
		$data['content'] = 'countries/upload_address_csv_file';
        $data['meta_title'] = "ERP : Upload Address CSV File";
        $data['title'] = "ERP : Upload Address CSV File";
        $data['meta_description'] = "ERP :Upload Address CSV File";
        echo Modules::run("templates/admin_template", $data);
        //exit;
    }
}
	