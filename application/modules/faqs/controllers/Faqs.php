<?php 

class Faqs extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('faqs/faq_model');
	}

	function index() {
		//$id = 1;
		//$data = ['id'=>$id];
		//$data['faqDetail'] = Modules::run('faqs/get_faq_details', $data);
		$this->faq_model->set_table("faques");
		$faqDetail = $this->faq_model->get_where_custom('is_active', TRUE);
		$data['faqDetail'] = $faqDetail->result_array();
		//echo '<pre>';
		//print_r($data['faqDetail']);
		$data['title'] = "Frequently Asked Question";
		$data['meta_title'] = "Frequently Asked Question";
		$data['meta_description'] = "Frequently Asked Question";
		$data['meta_keyword'] = "Frequently Asked Question";
		$data['content'] = 'faqs/index';

		$data['breadCrumbs'] = [
			['url'=>'/', 'title'=>'Home'],
			['url'=>'#', 'title'=>'FAQs']
		];
		echo Modules::run('templates/obaju_inner_template', $data);
	}

	function admin_index() {
		$data['meta_title'] = 'Faqs';
		$data['meta_description'] = 'Faqs';
		$data['modules'][] = 'faqs';
		$data['methods'][] = 'admin_faq_listing';
		echo Modules::run("templates/admin_template", $data); 
	}

	function admin_faq_listing($data = []) {
		$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		//echo "string"; exit;
		$this->faq_model->set_table("faques");
		
		$faq = $this->faq_model->get('is_active', 'DESC');
		$data['faqs'] = $faq->result_array();
		//print_r($data['faqs']);exit;
		$this->load->view("faqs/admin_index", $data);
	}

	function admin_add() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			echo '<pre>';
			//print_r($_POST);exit;
			$data['values_posted'] = $_POST;
			//print_r(expression)
			//print_r($data['values_posted']['faques']);exit;
			$this->form_validation->set_rules('data[faques][faq_category]', 'category');
			$this->form_validation->set_rules('data[faques][question]', 'question');
			$this->form_validation->set_rules('data[faques][answer]', 'answer');
			if($this->form_validation->set_rules('faqs')!== FALSE) {
				$postData = $data['values_posted']['faques'];
				//echo '<pre>';print_r($postData);exit;
				$insert = [];
				$update = [];
				foreach ($data['values_posted']['faques'] as $faquesKey => $faque) {
					//print_r($faque);
					//print_r($faque['id']);
					//$data['values_posted']['faques'][$faquesKey]['id'] = $faque['id'];
					//$data['values_posted']['faques'][$faquesKey]['faq_category_input'] = $faque['faq_category'];
					$faque['modified'] = date('Y-m-d H:i:s'); 

					/*if(empty($faque['faq_category'])) {
						echo "fac_category is empty";//exit;
						$faque['faq_category'] = $faque['faq_category_input'];
					}*/
					if(!isset($faque['faq_category']))
						$faque['faq_category'] = 'Others';
					
					if($faque['faq_category']==='0')
					{ 
						if(trim($faque['faq_category_input'])==''){ 
							$faque['faq_category'] = 'Others';
						}
						else{
							$faque['faq_category'] = $faque['faq_category_input'];
						}
							
					}
						//print_r($faque['faq_category']);
					unset($faque['faq_category_input']);

					if(isset($faque['is_active'])){
						$faque['is_active'] = TRUE;
					}else{
						$faque['is_active'] = FALSE;

					}
						//print_r($data['values_posted']['faques'][$faquesKey]);exit;

					if(isset($faque['id']) && !empty($faque['id'])) {
						$update[] = $faque;
					}else {
						unset($faque['id']);
	 					$faque['created'] = date('Y-m-d H:i:s');
	 					$insert[] = $faque;
					}
				}
				//print_r($data['values_posted']['faques'][$faquesKey]);exit;
				/*print_r($data['values_posted']['faques']);
				exit;*/
				/*print_r($insert);
				print_r($update);exit;*/
				//$insert = $postData;
				if(!empty($insert)) {
					$this->insert_multiple_faqs($insert);
					$msg = array('message' => 'FAQs Inserted Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
				}

				if(!empty($update)) {
					$this->update_multiple_faqs($update);
					$msg = array('message' => 'FAQs updated Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
				}
				redirect(custom_constants::new_faq_url);

			}else {
				$msg = array('message' => 'Validation error occured'. validation_errors(), 'class'=>'alert alert-danger');
				$this->session->set_flashdata('message', $msg);

			}
		}
		$this->faq_model->set_table("faques");
		$faques = $this->faq_model->get('is_active DESC');
		$data['faques'] = $faques->result_array();
		//echo '<pre>';print_r($data['faques']->result_array());
		$data['categories'] = $this->faq_category();
		$data['option']['category'][0] = 'Select category';
		foreach($data['categories'] as $categoryKey => $category){
			
			$data['option']['category'][$category['faq_category']] = $category['faq_category'];
		}
		//print_r($data['option']);
		$data['modules'][] = 'faqs';
		$data['methods'][]= 'admin_add_faqs';
		$data['title'] = 'Add FAQs';
		$data['meta_title'] = 'Add FAQs';
		$data['meta_description'] = 'Add FAQs';
		echo Modules::run('templates/admin_template', $data);
	}

	function admin_add_faqs() {
		$this->load->view('faqs/admin_add');
	}

	function faq_category() {
		$this->faq_model->set_table("faques");
		$query = $this->faq_model->get_distinct_category_dropdown_list();
		//echo '<pre>';print_r($query);
		return $query;
	}

	function update_multiple_faqs($data) {
		//echo "reched in update_multiple_product_images";
		$this->faq_model->set_table("faques");
		$query = $this->faq_model->_update_multiple('id',$data);
		return $query;
	}

	function insert_multiple_faqs($data) {
		 $this->faq_model->set_table("faques");
		$query = $this->faq_model->_insert_multiple($data);
		return $query;
	}

	function deleteFaqDetails() {
		$_POST['id'] = 1;
		$_POST['table'] = 'faques';
		$_POST['is_active'] = 'is_active';

		$_SERVER['REQUEST_METHOD'] = 'POST';
		//print_r($_SERVER['REQUEST_METHOD']);exit;
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			echo "hi";
			$id = $this->input->post('id');
			//echo $id;exit;
			$this->faq_model->set_table($this->input->post('table'));
			$faqDetails = $this->faq_model->get_where($id);
			//print_r($faqDetails);
			//$faqDet = $faqDetails->row_array();
			$arrayData['is_active'] = $this->input->post('is_active');
			$arrayData['modified'] = date('Y-m-d H:i:s');
			$response = $this->faq_model->_update($id, $arrayData);
			if($response){
				echo json_encode(['status'=>'success', 'id'=>$id]);
				exit;
			}
		}
			
		echo json_encode(['status'=>'error', 'msg'=>'Invalid Input']);
		exit;
		
	}

	function get_faq_details($data = []){
		//print_r($data);exit;
		$this->faq_model->set_table("faques");
		$faqDetail = $this->faq_model->get_where($data['id']);

		return $faqDetail;
	}
}
