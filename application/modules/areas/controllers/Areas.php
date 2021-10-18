<?php

class Areas extends MY_Controller {
	function __construct() {
		parent::__construct();
		check_user_login(FALSE);
			
		$this->load->model('areas_model',"Areas");
		$setup = $this->setup();	
	}

	function setup(){
		$areas = $this->areas_model->tbl_areas();
		return TRUE;
	}

	function admin_add($id = NULL) {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			// echo "<pre>";print_r($_POST);exit;

	        $redirectUrl = 'areas/admin_add';
	        //echo '<pre>';print_r($_POST);exit;
			// $this->form_validation->set_rules('data[countries][name]', 'country', 'required');
			// $this->form_validation->set_rules('data[states][state_name]', 'state', 'required');
			$this->form_validation->set_rules('data[cities][city_name]', 'city', 'required');
			$this->form_validation->set_rules('data[areas][area_name]', 'area', 'required');
			
			if($this->form_validation->run()!==FALSE)
			{
				// echo "<pre>";print_r($_POST);exit;
				
				$post_data = $this->input->post('data');
				$countryId = '';
				$stateId = '';
				$cityId = '';
				$areaId = '';

				// echo "<pre>";print_r($post_data);exit;


				if(!empty($post_data['countries']['name'])){
					$country['name'] = $post_data['countries']['name'];
					$country['is_active'] = TRUE;
					$country['created'] = date('Y-m-d H:i:s');
					$country['modified'] = date('Y-m-d H:i:s');
					$country_id = json_decode(Modules::run('countries/_register_admin_add', $country), true);
					$countryId = $country_id['id'];
					// $post_data['address']['country_id'] = $countryId['id'];
				} else {
					$countryId = $post_data['states']['country_id'];
				}

				if(!empty($post_data['states']['state_name'])){

					$state['state_name'] = $post_data['states']['state_name'];
					$state['is_active'] = TRUE;
					$state['country_id'] = $countryId;
					$state['created'] = date('Y-m-d H:i:s');
					$state['modified'] = date('Y-m-d H:i:s');
					$state_id = json_decode(Modules::run('states/_register_admin_add', $state),true);
					$stateId = $state_id['id'];

					// $post_data['address']['state_id'] = $stateId['id'];
				} else {
					$stateId = $post_data['cities']['state_id'];
				}

				if(!empty($post_data['cities']['city_name'])){
					$city['city_name'] = $post_data['cities']['city_name'];
					$city['short_name'] = $post_data['cities']['city_name'];
					$city['is_active'] = TRUE;
					$city['country_id'] = $countryId;
					$city['state_id'] = $stateId;
					$city['created'] = date('Y-m-d H:i:s');
					$city['modified'] = date('Y-m-d H:i:s');
					$city_id = json_decode(Modules::run('cities/_register_admin_add', $city), true);
					$cityId = $city_id['id'];

					// echo "<pre>";print_r($cityId);exit;

				} else {
					$cityId = $post_data['areas']['state_id'];
				}

				if(!empty($post_data['areas']['area_name'])){
					$area['area_name'] = $post_data['areas']['area_name'];
					$area['is_active'] = TRUE;
					$area['city_id'] = $cityId;
					$area['created'] = date('Y-m-d H:i:s');
					$area['modified'] = date('Y-m-d H:i:s');
					// echo "<pre>";print_r($area);exit;
					$areaId = json_decode(Modules::run('areas/_register_admin_add', $area),true);
					if($areaId['status'] === "success")
					{ 
						$msg = array('message' => 'Area Added Successfully','class' => 'alert alert-success');
	                    $this->session->set_flashdata('message',$msg);
					}
					else
					{
						$msg = array('message' => $reg_user['msg'], 'class' => 'alert alert-danger');
	                    $this->session->set_flashdata('message',$msg);
						//$data['form_error'] = $reg_user['msg'];
					}
					// $post_data['address']['area_id'] = $areaId['id'];
					unset($post_data['areas']['area_name']);

				}

				// $user_area = json_decode($this->_register_admin_add($post_data['areas']), true);
				
			}else{

					//echo validation_errors();exit;
				$msg = array('message' => "Following Validation Error Occurred.".validation_errors(), 'class' => 'alert alert-danger');
                $this->session->set_flashdata('message',$msg);
			}
				redirect($redirectUrl);
		}
		

		$data['meta_title'] = "New User";
		$data['meta_description'] = "Areas Index";
		$data['modules'][] = "areas";
		$data['methods'][] = "admin_add_form";
		echo Modules::run("templates/admin_template", $data);
	}

	function admin_add_form($data = []) {
		
		$cities = $this->cities_model->get_dropdown_list();
		//$data['option'] = [];
		$data['option']['cities'][0] = "Select City";
		

		$states = $this->states_model->get_dropdown_list();
		$data['option']['states'][0] = "Select State";
		

		$countries =$this->countries_model->get_dropdown_list();
		$data['option']['countries'][0] = "Select Country";
		foreach ($countries as $countryKey => $country) {
			$data['option']['countries'][$country['id']] = $country['name'];
		}
                                   
		$areas =$this->areas_model->get_dropdown_list();
		$data['option']['areas'][0] = "Select Area";
	
		
		$this->load->view('areas/admin_add', $data);
	}

	function getCityWiseAreas() {

		if(!$this->input->post('params'))
			return;
		$condition = [];
		$condition = ['is_active' => TRUE];
		$cityId = $this->input->post('params');
		//echo "hello";exit;
		if(!empty($cityId)) {
			$condition = ['city_id'=>$cityId];
		}

		//echo json_encode($condition);exit;
		$cityWiseAreas = $this->areas_model->get_city_wise_areas($condition);
		$areaList = [0=>['id'=>0, 'text'=>'Select Area']];

		/*$areaList = [];*/
		foreach ($cityWiseAreas as $key => $area) {
			$areaList[$key+1]['id'] = $area['id'];
			$areaList[$key+1]['text'] = $area['area_name'];
		}
		echo json_encode($areaList);
		//print_r($stateList);exit;
		exit;

	}


	function _register_admin_add($data) {
		// echo "<pre>";print_r($data);exit;
		$this->pktdblib->set_table("areas");
		$id = $this->pktdblib->_insert($data);
		return json_encode(["msg"=>"Area Successfully Inserted", "status"=>"success", 'id'=>$id['id']]);
	}
}

?>