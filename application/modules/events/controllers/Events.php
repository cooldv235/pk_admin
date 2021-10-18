<?php 

class Events extends MY_Controller {
	function __construct() {
		parent::__construct();
		check_user_login(TRUE);
		$this->load->model('events/event_model');
		/*$this->load->model('states/states_model');
		$this->load->model('cities/cities_model');*/

		$setup = $this->setup();
	}

	function setup(){
		$setup = $this->event_model->tbl_event_categories();
		return TRUE;
	}

	function admin_category_index($id = NULL) {
		$data['meta_title'] = "Event Category";
		$data['meta_description'] = "Event Category";
		$data['title'] = "Modules :: Event";
		$data['heading'] = '<i class="fa fa-edit margin-r-5"></i> Blog Categories';
		$data['modules'][] = "events";
		$data['methods'][] = "admin_events_category_listing";
		echo modules::run('templates/admin_template', $data);
	}

	function admin_events_category_listing() {
		$condition = '';
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->event_model->set_table('event_categories');

		$data['categories'] = $this->event_model->get_category_list();
		$this->load->view("events/admin_category_listing", $data);
	}

	function admin_index($id = NULL) {
		$data['title'] = 'Modules :: Blog';
		$data['heading'] = '<i class="fa fa-list margin-r-5"></i> Blogs';
		$data['meta_title'] = "Event";
		$data['meta_description'] = "Event";
		$data['modules'][] = "events";
		$data['methods'][] = "admin_event_listing";
		echo modules::run('templates/admin_template', $data);
	}

	function admin_event_listing() {
		$condition = '';
		if(isset($data['condition']))
			$condition = $data['condition'];
		$data['events_category'] = $this->category_wise_events_listing($condition);
		$this->load->view('events/admin_index',$data);
	}

	function category_wise_events_listing($data = []){
		$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->event_model->set_table('events');
		$res = $this->event_model->get_events_list($condition);
		return $res;
	}

	function admin_add_category() {
		//$this->load->model('events/event_model');
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['values_posted'] = $_POST;
			$this->form_validation->set_rules('data[event_categories][parent_id]', 'parent');
			$this->form_validation->set_rules('data[event_categories][category_name]', 'category_name', 'required|max_length[255]');
			$this->form_validation->set_rules('data[event_categories][slug]', 'slug', 'required|max_length[255]|is_unique[event_categories.slug]');
			if($this->form_validation->run('event_categories')!== false) {
				$profileImg1 = '';
				$profileImg2 = '';

				$error = [];
				if(!empty($_FILES['image_name_1']['name'])) {
					$eventCategoriesValidationParams1 =['file' =>$_FILES['image_name_1'], 'path'=>'../content/uploads/event_categories/','ext'=>'gif|jpg|png|jpeg', 'fieldname'=>'image_name_1', 'arrindex'=>'image_name_1'];
					$profileImg1 = $this->pktlib->upload_single_file($eventCategoriesValidationParams1);
					if(empty($profileImg1['error'])) {
						$_POST['data']['event_categories']['image_name_1'] = $profileImg1['filename'];
					} else { 
						$error['image_name_1'] = $profileImg1['error'];
					}
				}

				if(!empty($_FILES['image_name_2']['name'])) {
					$productCategoriesValidationParams2 =['file' =>$_FILES['image_name_2'], 'path'=>'../content/uploads/event_categories/','ext'=>'gif|jpg|png|jpeg', 'fieldname'=>'image_name_2', 'arrindex'=>'image_name_2'];
					$profileImg2 = $this->pktlib->upload_single_file($productCategoriesValidationParams2);
					if(empty($profileImg2['error'])) {
						if(empty($_POST['data']['event_categories']['image_name_2'])) {
						$_POST['data']['event_categories']['image_name_2'] = $profileImg2['filename'];
						}else{
							$_POST['data']['event_categories']['image_name_2'] = $profileImg2['filename'];

						}
					} else {
						$error['image_name_2'] = $profileImg2['error'];
					}
				}else {
					if(isset($profileImg1['filename'])) {
						$_POST['data']['event_categories']['image_name_2'] = $profileImg1['filename'];
					}
					
				}
				if(empty($error)) {
					$post_data = $this->input->post('data[event_categories]');
					$post_data['created'] = date('Y-m-d H:i:s');
                    $post_data['modified'] = date('Y-m-d H:i:s');
                    $post_data['created_by'] = $post_data['modified_by'] = $this->session->userdata('user_id');

					$register_event_category = json_decode($this->register_event_category($post_data), true);
					if($register_event_category['status'] === 'success') {
						$msg = array('message'=>'Event Category Added Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					redirect(custom_constants::edit_events_category_url."/".$register_event_category['id']['id']);

					}
					else {
						$data['form_error'] = $register_event_category['msg'];
					}
				}
				else {
					$msg = array('message'=>'unable to add Event Category', 'class'=>'alert alert-danger');
					$this->session->set_flashdata('message', $msg);
				}
			}
			else {
				$msg = array('message'=>'unable to add blogs following error occured. '.validation_errors(), 'class'=>'alert alert-danger');
					$this->session->set_flashdata('message', $msg);
			}

		}
		$data['option']['parent'] = $this->parentCategories();
		$data['meta_title'] = "New Category";
		$data['meta_description'] = "New Category";
		$data['meta_keyword'] = "New Category";
		$data['title'] = "Module :: Events";
		$data['heading'] = '<i class="fa fa-plus-square margin-r-5"></i> New Event Category';
		$data['modules'][] = "events";
		$data['methods'][] = "admin_add_events_category";
		$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            $(document).on("submit", "#event_categories", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	function register_event_category($data) {
		$insert_data = $data;
		$this->event_model->set_table("event_categories");
		$id = $this->event_model->_insert($insert_data);
		return json_encode(['message' =>'Category added Successfully', "status"=>"success", 'id'=> $id]);
	}

	function admin_add_events_category() {
		$this->load->view("events/admin_add_events_category");
	}

	function admin_edit_category($id = NULL) {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['values_posted'] = $_POST['data'];
			$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
			$this->form_validation->set_rules("data[event_categories][parent_id]", 'Parent', 'required');
			$this->form_validation->set_rules("data[event_categories][category_name]", 'Category Name', 'required|max_length[255]');
			if($this->form_validation->run('event_categories')!== FALSE){
				$productCategoryImg = '';
				$postData = $_POST['data']['event_categories'];
				if(!empty($_FILES['image_name_1']['name'])) {
					$eventsCategoryFileValidationParams = ['file'=>$_FILES['image_name_1'], 'path'=>'../content/uploads/event_categories/', 'fieldname'=>'image_name_1', 'ext'=>'jpeg|png|jpg|gif', 'arrindex'=>'image_name_1'];
					$eventsCategoryImg = $this->pktlib->upload_single_file($eventsCategoryFileValidationParams);
					if(empty($eventsCategoryImg['error'])) {
						$postData['image_name_1'] = $eventsCategoryImg['filename'];
						unset($postData['image_name_1_2']);
					}
					else {
						$error['image_name_1'] = $eventsCategoryImg['error'];
					}
				}
				else {
					$postData['image_name_1'] = $postData['image_name_1_2'];
					unset($postData['image_name_1_2']);
				}
				if(!empty($_FILES['image_name_2']['name'])) {
					$eventsCategoryFileValidationParams = ['file'=>$_FILES['image_name_2'], 'path'=>'../content/uploads/event_categories/', 'fieldname'=>'image_name_2', 'ext'=>'jpeg|png|jpg|gif', 'arrindex'=>'image_name_2'];
					$eventsCategoryImg = $this->pktlib->upload_single_file($eventsCategoryFileValidationParams);
					if(empty($productCategoryImg['error'])) {
						$postData['image_name_2'] = $eventsCategoryImg['filename'];
						unset($postData['image_name_2_2']);
					}
					else {
						$error['image_name_2'] = $eventsCategoryImg['error'];
					}
				}
				else {
					$postData['image_name_2'] = $postData['image_name_2_2'];
					unset($postData['image_name_2_2']);
				}
				if(empty($error)) {
					if($this->event_model->update_event_categories($id, $postData)) {
						$msg = array('message'=>'Data Updated Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					}
					else {
						$msg = array('message'=>'some problem occured', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					}
					redirect(custom_constants::edit_events_category_url."/".$id);
				} 
				else {
					//print_r($error);
					$msg = array('message'=>'some error occured while uploading', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
				}
			} 
			else {
				$data['values_posted']['event_categories']['image_name_1'] = $data['values_posted']['event_categories']['image_name_1_2']; 
				$data['values_posted']['event_categories']['image_name_2'] = $data['values_posted']['event_categories']['image_name_2_2']; 
				$msg = array('message'=>'some validation error occured'.validation_errors(), 'class'=>'alert alert-danger');
					$this->session->set_flashdata('message', $msg);
			}
		}  
		else {
			$data['event_categories'] = $this->get_events_category_details($id);
			$data['values_posted']['event_categories'] = $data['event_categories'];
		} 
		$data['option']['parent'] = $this->parentCategories();
		$data['id'] = $id;
		$data['modules'][] = 'events';
		$data['methods'][]= 'admin_edit_events_category';
		$data['title'] = 'Modules :: events';
		$data['heading'] = '<i class="fa fa-edit margin-r-5"></i> Edit events Category';
		$data['meta_title'] = 'Edit events Category';
		$data['meta_description'] = 'Edit events Category';
		/*$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#events", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
              //return false;
            });
        </script>';*/
        $data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            $(document).on("submit", "#event_categories", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	function admin_edit_events_category() {
		$this->load->view('events/admin_edit_events_category');
	}

	function get_events_category_details($id) {
		$this->event_model->set_table('event_categories');
		$eventsCategoryDetail = $this->event_model->get_where($id);
		return $eventsCategoryDetail;
	}

	function get_events_categories_list() {
		$this->event_model->set_table('event_categories');
		$eventsCategories = $this->event_model->get_events_category_list();
		return $eventsCategories;
	}

	function admin_add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $data['value_posted'] = $_POST['data'];
            $this->form_validation->set_rules('data[events][title]', 'events Title', 'required|max_length[255]');
            $this->form_validation->set_rules('data[events][slug]', 'events Slug', 'required|trim|is_unique[events.slug]|min_length[3]|max_length[255]');
            if($this->form_validation->run()!== FALSE) { 
                $error = [];
                $post_data = $this->input->post('data[events]');
                $featuredImage = ''; 
                if(!empty($_FILES['featured_image']['name'])) { //echo "hi nnme";exit;
                    $eventsFileValidationParams = ['file' => $_FILES['featured_image'], 'path'=> '../content/uploads/events/', 'ext' => 'gif|jpg|png|jpeg', 'fieldname' =>'featured_image', 'arrindex' =>'featured_image',];
                    $featuredImage = $this->pktlib->upload_single_file($eventsFileValidationParams);
                    if(empty($featuredImage['error'])) {
                        $post_data['featured_image'] = $featuredImage['filename'];
                    }
                    else {
                        $error['featured_image'] = $featuredImage['error'];

                    }
                } else {
                	if($this->input->post('data[events][type]') == 'video'){
                		$post_data['featured_image'] = $this->input->post('data[youtube][video]');
                	}else{
                   		 $post_data['featured_image'] = 'default.jpg';
                		
                	}
                }
                if (empty($error)) {
                	$post_data['user_id'] = $_SESSION['user_id'];
					$post_data['published_on'] = $this->pktlib->dmYtoYmd($post_data['published_on']).' '.date('H:i:s');
					$post_data['start_date'] = $this->pktlib->dmYtoYmd($post_data['start_date']);
					$post_data['end_date'] = $this->pktlib->dmYtoYmd($post_data['end_date']);

                    $post_data['created'] = date('Y-m-d H:i:s');
                    $post_data['modified'] = date('Y-m-d H:i:s');
                    $post_data['created_by'] = $post_data['modified_by'] = $this->session->userdata('user_id');
                    $reg_events = json_decode($this->_register_admin_add($post_data), true);
                    if($reg_events['status'] === 'success') {
                    	
						
                        $msg = array('message'=> 'events Created Successfully', 'class' => 'alert alert-success');
                        $this->session->set_flashdata('message', $msg);
                        redirect(custom_constants::new_events_url);
                    }
                    else {
                        $data['form_error'] = $reg_events['msg'];
                    }
                }else{
                    $msg = array('message'=> 'Error while uploading file'.$error['featured_image'], 'class' => 'alert alert-danger');
                        $this->session->set_flashdata('message', $msg);
                }
            }else{
                $msg = array('message'=> 'Error while uploading file'.validation_errors(), 'class' => 'alert alert-danger');
                $this->session->set_flashdata('message', $msg);
            }
        }
        $states = $this->states_model->get_dropdown_list();
        $data['option']['states'][0] = 'Select State';
		foreach($states as $stateKey => $state) {
			$data['option']['states'][$state['id']] = $state['state_name'];
		}

		$cities = $this->cities_model->get_dropdown_list();
        $data['option']['cities'][0] = 'Select City';

		foreach($cities as $cityKey => $city) {
			$data['option']['cities'][$city['id']] = $city['city_name'];
		}
        $data['categories'] = $this->event_model->get_categorylist_for_events();
        $data['option']['type'] = ['Select Type', 'text'=>'text', 'video'=>'video'];
		$data['option']['category'] = $this->parentCategories();
        $data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
            $(document).on("submit", "#events", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });

    		 $("#type").on("change", function() {
			    if (this.value == "text")
			    {
			     console.log("type is text");
			      $("#text").show();
			      $("#video").hide();
			      
			    }
			    else
			    {
			     console.log("type is video");
			      $("#text").hide();
			      $("#video").show();
			    }
  			});
    	
        </script>';
        
        $data['meta_title'] = "ERP : events Module";
        $data['meta_description'] = "New Events";
        $data['title'] = 'Modules :: Events';
		$data['heading'] = '<i class="fa fa-plus-square margin-r-5"></i> New Event';
        $data['modules'][] = "events";
        $data['methods'][] = "admin_add_events";
        
        echo Modules::run("templates/admin_template", $data);
    }

    function _register_admin_add($data) {
        $this->event_model->set_table("events");
        $id = $this->event_model->_insert($data);
        if($id['status']==='success') {
	        $events = $this->get_events_details($id['id']);
	        return json_encode(["msg" => "events Created Successfully", "status" => "success", 'id' => $id['id'], 'events' => $events, 'is_new'=>true ]);
        }else {
        	return json_encode(["msg" => "Failed To Add events ", "status" => "fail"]);
        }

    }

    function admin_add_events($data = []) {
		$this->load->view("events/admin_add", $data);
	}

	function get_events_details($id) {
        $this->event_model->set_table('events');
        $customerdetails = $this->event_model->get_where($id);
        return $customerdetails;
    }

    function insert_multiple($data){
		$this->event_model->set_table("events_cities");
		$query = $this->event_model->_insert_multiple($data);
		return $query;
	}

    function admin_edit($id = NULL) {
    	if($_SERVER['REQUEST_METHOD'] == 'POST') {
    	   /* echo '<pre>';
    	    print_r($_POST);
    	    exit;*/
    	   /* if(!isset($_POST['data']['events'])){
    	        $_POST['data']['events'] = $_POST['data']['news'];
    	    }*/
    	    
    		$this->form_validation->set_rules('data[events][title]', 'Title', 'required|max_length[255]');
            $this->form_validation->set_rules('data[events][slug]', 'Slug', 'required|max_length[255]');
           
    		if($this->form_validation->run()!== FALSE) {
    			$profileImg = '';
    			$post_data['events'] = $data['values_posted']['events'] = $_POST['data']['events'];
    			//print_r($post_data);exit;
    			if(NULL !== $post_data['events']['is_trend'])
					$post_data['events']['is_trend'] = true;
				else
					$post_data['events']['is_trend'] = false;

				if(NULL !== $post_data['events']['is_hot'])
					$post_data['events']['is_hot'] = true;
				else
					$post_data['events']['is_hot'] = false;

				if(NULL !== $post_data['events']['is_featured'])
					$post_data['events']['is_featured'] = true;
				else
					$post_data['events']['is_featured'] = false;
					
				if(NULL !== $post_data['events']['is_active'])
					$post_data['events']['is_active'] = true;
				else
					$post_data['events']['is_active'] = false;
    			$post_data['events_cities'] = $data['values_posted']['events_cities'] = $_POST['data']['events_cities'];
    			if(!empty($_FILES['featured_image']['name'])) {
    				$eventsFileValidationParams = ['file'=>$_FILES['featured_image'], 'path' => '../content/uploads/events/', 'ext' => 'jpg|png|gif|jpeg', 'fieldname' =>'featured_image', 'arrindex' => 'featured_image', 'thumb'=>['path'=>'../content/uploads/events/thumbs/', 'width'=>300]];
    				$profileImg = $this->pktlib->upload_single_file($eventsFileValidationParams);
    				if(empty($profileImg['error'])) {
    					$post_data['events']['featured_image'] = $profileImg['filename'];
    					unset($post_data['events']['featured_image2']);
    				}
    				else {
    					$error['featured_image'] = $profileImg['error'];
     				}
    			}
    			else {
    				if($this->input->post('data[events][type]') == 'video'){
                		$post_data['events']['featured_image'] = $this->input->post('data[youtube][video]');
                	}else{
    						$post_data['events']['featured_image'] = $post_data['events']['featured_image2'];
    					}
    				unset($post_data['events']['featured_image2']);
    			}
    			
    			//print_r($post_data);exit;
    			if(empty($error)) {
    				$post_data['events']['start_date'] = $this->pktlib->dmYtoYmd($post_data['events']['start_date']);
					$post_data['events']['end_date'] = $this->pktlib->dmYtoYmd($post_data['events']['end_date']);
                    $post_data['events']['modified'] = date('Y-m-d H:i:s');
                   	$post_data['modified_by'] = $this->session->userdata('user_id');

    				if($this->edit_events($id, $post_data['events'])) {
	            		
    					$msg = array('message' => "events Update successfully", 'class' => 'alert alert-success fade-in');
    					$this->session->set_flashdata('message', $msg);
    				}
    				else {
    					$msg = array('message' => 'some problem occured while updating', 'class' => 'alert alert-danger fade-in');
    					$this->session->set_flashdata('message', $msg);
    				}
    				redirect(custom_constants::edit_events_url."/".$id);
    			}
    			else {
    				$msg = array('message' => $error, 'class' =>'alert alert-danger fade-in');
    				$this->session->set_flashdata('error', $msg);
    			}
     		} 
     		else {
     		    echo validation_errors();
     			$msg = array('message' => 'some validation error occured', 'class' => 'alert alert-danger fade-in');
     		}

    	}
    	else {
			$this->event_model->set_table("events");
			$data['events'] = $this->event_model->get_where($id);
			$data['values_posted']['events'] = $data['events'];		   	
		}
		$data['eventsCategories'] = $this->event_model->get_categorylist_for_events();
    	$data['id'] = $id;
    	$data['option']['category'] = $this->parentCategories();
    	$data['parents'] = $this->get_events_categories_list();
        //echo '<pre>';print_r($data);exit;
		 $states = $this->states_model->get_dropdown_list();
		 $data['option']['states'][0] = 'Select State';
		foreach($states as $stateKey => $state) {
			$data['option']['states'][$state['id']] = $state['state_name'];
		}

		$cities = $this->cities_model->get_dropdown_list();
		$data['option']['cities'][0] = "Select City";
		foreach($cities as $cityKey => $city) {
			$data['option']['cities'][$city['id']] = $city['city_name'];
		}
		$eventsStates= $this->get_state_list($id);
		 $data['eventsStates'][0] = 'Select State';
		 foreach ($eventsStates as $stateKey => $state) {
		 	$data['eventsStates'][$stateKey] = $state['state_id'];
		 }
		 $eventsCities = $this->get_city_wise_events_list($id);
		 $data['option']['type'] = ['Select Type','text'=>'text', 'video'=>'video'];
		 $data['eventsCities'][0] = 'Select City';
		 foreach ($eventsCities as $cityKey => $city) {
		 	$data['eventsCities'][$cityKey] = $city['city_id'];
		 }
    	if(!($this->input->get('tab')))
    		$data['tab'] = 'personal_info';
    	else
    		$data['tab'] = $this->input->get('tab');
        $data['meta_title'] = "Edit Events";
        $data['title'] = "ERP Edit Events";
        $data['meta_description'] = "Edit events";
       	$data['content'] = 'events/admin_edit';
       	$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
            var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#events", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
            $("#type").on("change", function() {
			    if (this.value == "text")
			    {
			     console.log("type is text");
			      $("#text").show();
			      $("#video").hide();
			      
			    }
			    else
			    {
			     console.log("type is video");
			      $("#text").hide();
			      $("#video").show();
			    }
  			});
        </script>';
        echo Modules::run('templates/admin_template', $data);
    }  

    function edit_events($id=NULL, $post_data = []) {
        if(NULL == $id)
            return false;
        $this->event_model->set_table("events");
        if($this->event_model->_update($id,$post_data))
            return true;
        else
            return false;
    }

    function get_city_wise_events_list($id = NULL) {
    	//echo '<pre>';
    	$data['events_id'] = $id;
    	$this->event_model->set_table("events_cities");
    	$city = $this->event_model->get_city_list($id);
    	//print_r($city);
    	return $city;
    }

    function get_state_list($id = NULL) {
    	$data['events_id'] = $id;
    	$this->event_model->set_table("events");
    	$state = $this->event_model->get_state_list($id);
    	return $state;
    }

    function admin_add_eventsCities($eventsId, $data) {
    	$events_id = $eventsId;
    	$this->event_model->set_table("events_cities");
	    $this->event_model->delete($events_id);

	if(empty($data))
	 return true;
    	
    	$insert = [];
    	foreach ($data as $cityKey => $city) {
			$insert[$cityKey]['events_id'] = $eventsId;
			$insert[$cityKey]['city_id'] = $city;
			$insert[$cityKey]['created'] = date("Y-m-d H:i:s");
			$insert[$cityKey]['modified'] = date("Y-m-d H:i:s");
		}
		if(!empty($insert)) {
			$query = $this->insert_multiple($insert);
			return $query;
		}
    }

    function get_events_list($data = []) {
    	$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->event_model->set_table('events');
		$res = $this->event_model->get_events_list($condition);
		return $res;
    }

    function parentCategories($parent = 0, $level='', $result = [0=>'Select']){
        $parents = $this->pktdblib->custom_query('Select * from event_categories where is_active=true and parent_id='.$parent.' order by category_name ASC');
        foreach ($parents as $key => $parent) {
            $result[$parent['id']] = $parent['category_name']; 
            $result = $this->childCategories($parent['id'],'--', $result);
        }

        return $result;
    }

    function childCategories($parent, $level='--', $result){
        $childs = $this->pktdblib->custom_query('Select * from event_categories where is_active=true and parent_id='.$parent.' order by category_name ASC');
        foreach ($childs as $key => $child) {
            $result[$child['id']] = $level.$child['category_name']; 
            $result = $this->childCategories($child['id'], '--'.$level, $result);
        }
       return $result;
    }

    function createThumbnail(){
    	
    	$this->pktlib->createThumbs("../content/uploads/events/", "../content/uploads/events/thumbs/", 300);
    }
}