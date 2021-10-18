<?php 

class Blogs extends MY_Controller {
	function __construct() {
		parent::__construct();
		check_user_login(TRUE);
		$this->load->model('blogs/blogs_model');
		/*$this->load->model('states/states_model');
		$this->load->model('cities/cities_model');*/

		$setup = $this->setup();
	}

	function setup(){
		$setup = $this->blogs_model->tbl_blogs_categories();
		return TRUE;
	}

	function admin_category_index($id = NULL) {
		$data['meta_title'] = "Blogs Category";
		$data['meta_description'] = "Blogs Category";
		$data['title'] = "Modules :: Blog";
		$data['heading'] = '<i class="fa fa-edit margin-r-5"></i> Blog Categories';
		$data['modules'][] = "blogs";
		$data['methods'][] = "admin_blogs_category_listing";
		echo modules::run('templates/admin_template', $data);
	}

	function admin_blogs_category_listing() {
		$condition = '';
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->blogs_model->set_table('blogs_categories');

		$data['categories'] = $this->blogs_model->get_category_list();
		$this->load->view("blogs/admin_category_listing", $data);
	}

	function admin_index($id = NULL) {
		$data['title'] = 'Modules :: Blog';
		$data['heading'] = '<i class="fa fa-list margin-r-5"></i> Blogs';
		$data['meta_title'] = "blogs";
		$data['meta_description'] = "blogs";
		$data['modules'][] = "blogs";
		$data['methods'][] = "admin_blogs_listing";
		echo modules::run('templates/admin_template', $data);
	}

	function admin_blogs_listing() {
		$condition = '';
		if(isset($data['condition']))
			$condition = $data['condition'];
		$data['blogs_category'] = $this->category_wise_blogs_listing($condition);
		$this->load->view('blogs/admin_index',$data);
	}

	function category_wise_blogs_listing($data = []){
		$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->blogs_model->set_table('blogs');
		$res = $this->blogs_model->get_blogs_list($condition);
		return $res;
	}

	function admin_add_category() {
		$this->load->model('blogs/blogs_model');
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['values_posted'] = $_POST;
			$this->form_validation->set_rules('data[blogs_categories][parent_id]', 'parent');
			$this->form_validation->set_rules('data[blogs_categories][category_name]', 'category_name', 'required|max_length[255]');
			$this->form_validation->set_rules('data[blogs_categories][slug]', 'slug', 'required|max_length[255]|is_unique[blogs_categories.slug]');
			if($this->form_validation->run('blogs_categories')!== false) {
				$profileImg1 = '';
				$profileImg2 = '';

				$error = [];
				if(!empty($_FILES['image_name_1']['name'])) {
					$blogsCategoriesValidationParams1 =['file' =>$_FILES['image_name_1'], 'path'=>'../content/uploads/blogs_categories/','ext'=>'gif|jpg|png|jpeg', 'fieldname'=>'image_name_1', 'arrindex'=>'image_name_1'];
					$profileImg1 = $this->pktlib->upload_single_file($blogsCategoriesValidationParams1);
					if(empty($profileImg1['error'])) {
						$_POST['data']['blogs_categories']['image_name_1'] = $profileImg1['filename'];
					} else { 
						$error['image_name_1'] = $profileImg1['error'];
					}
				}

				if(!empty($_FILES['image_name_2']['name'])) {
					$productCategoriesValidationParams2 =['file' =>$_FILES['image_name_2'], 'path'=>'../content/uploads/blogs_categories/','ext'=>'gif|jpg|png|jpeg', 'fieldname'=>'image_name_2', 'arrindex'=>'image_name_2'];
					$profileImg2 = $this->pktlib->upload_single_file($productCategoriesValidationParams2);
					if(empty($profileImg2['error'])) {
						if(empty($_POST['data']['blogs_categories']['image_name_2'])) {
						$_POST['data']['blogs_categories']['image_name_2'] = $profileImg2['filename'];
						}else{
							$_POST['data']['blogs_categories']['image_name_2'] = $profileImg2['filename'];

						}
					} else {
						$error['image_name_2'] = $profileImg2['error'];
					}
				}else {
					if(isset($profileImg1['filename'])) {
						$_POST['data']['blogs_categories']['image_name_2'] = $profileImg1['filename'];
					}
					
				}
				if(empty($error)) {
					$post_data = $this->input->post('data[blogs_categories]');
					$post_data['created'] = date('Y-m-d H:i:s');
                    $post_data['modified'] = date('Y-m-d H:i:s');
					$register_blogs_category = json_decode($this->register_blogs_category($post_data), true);
					if($register_blogs_category['status'] === 'success') {
						$msg = array('message'=>'Blogs Category Added Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					redirect(custom_constants::edit_blogs_category_url."/".$register_blogs_category['id']['id']);

					}
					else {
						$data['form_error'] = $register_blogs_category['msg'];
					}
				}
				else {
					$msg = array('message'=>'unable to add blogs', 'class'=>'alert alert-danger');
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
		$data['title'] = "Module :: Blogs";
		$data['heading'] = '<i class="fa fa-plus-square margin-r-5"></i> New Blog Category';
		$data['modules'][] = "blogs";
		$data['methods'][] = "admin_add_blogs_category";
		$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            $(document).on("submit", "#blogs_categories", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	function register_blogs_category($data) {
		$insert_data = $data;
		$this->blogs_model->set_table("blogs_categories");
		$id = $this->blogs_model->_insert($insert_data);
		return json_encode(['message' =>'Category added Successfully', "status"=>"success", 'id'=> $id]);
	}

	function admin_add_blogs_category() {
		$this->load->view("blogs/admin_add_blogs_category");
	}

	function admin_edit_category($id = NULL) {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['values_posted'] = $_POST['data'];
			$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
			$this->form_validation->set_rules("data[blogs_categories][parent_id]", 'Parent', 'required');
			$this->form_validation->set_rules("data[blogs_categories][category_name]", 'Category Name', 'required|max_length[255]');
			if($this->form_validation->run('blogs_categories')!== FALSE){
				$productCategoryImg = '';
				$postData = $_POST['data']['blogs_categories'];
				if(!empty($_FILES['image_name_1']['name'])) {
					$blogsCategoryFileValidationParams = ['file'=>$_FILES['image_name_1'], 'path'=>'../content/uploads/blogs_categories/', 'fieldname'=>'image_name_1', 'ext'=>'jpeg|png|jpg|gif', 'arrindex'=>'image_name_1'];
					$blogsCategoryImg = $this->pktlib->upload_single_file($blogsCategoryFileValidationParams);
					if(empty($blogsCategoryImg['error'])) {
						$postData['image_name_1'] = $blogsCategoryImg['filename'];
						unset($postData['image_name_1_2']);
					}
					else {
						$error['image_name_1'] = $blogsCategoryImg['error'];
					}
				}
				else {
					$postData['image_name_1'] = $postData['image_name_1_2'];
					unset($postData['image_name_1_2']);
				}
				if(!empty($_FILES['image_name_2']['name'])) {
					$blogsCategoryFileValidationParams = ['file'=>$_FILES['image_name_2'], 'path'=>'../content/uploads/blogs_categories/', 'fieldname'=>'image_name_2', 'ext'=>'jpeg|png|jpg|gif', 'arrindex'=>'image_name_2'];
					$blogsCategoryImg = $this->pktlib->upload_single_file($blogsCategoryFileValidationParams);
					if(empty($productCategoryImg['error'])) {
						$postData['image_name_2'] = $blogsCategoryImg['filename'];
						unset($postData['image_name_2_2']);
					}
					else {
						$error['image_name_2'] = $blogsCategoryImg['error'];
					}
				}
				else {
					$postData['image_name_2'] = $postData['image_name_2_2'];
					unset($postData['image_name_2_2']);
				}
				if(empty($error)) {
					if($this->blogs_model->update_blogs_categories($id, $postData)) {
						$msg = array('message'=>'Data Updated Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					}
					else {
						$msg = array('message'=>'some problem occured', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					}
					redirect(custom_constants::edit_blogs_category_url."/".$id);
				} 
				else {
					//print_r($error);
					$msg = array('message'=>'some error occured while uploading', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
				}
			} 
			else {
				$data['values_posted']['blogs_categories']['image_name_1'] = $data['values_posted']['blogs_categories']['image_name_1_2']; 
				$data['values_posted']['blogs_categories']['image_name_2'] = $data['values_posted']['blogs_categories']['image_name_2_2']; 
				$msg = array('message'=>'some validation error occured'.validation_errors(), 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
			}
		}  
		else {
			$data['blogs_categories'] = $this->get_blogs_category_details($id);
			$data['values_posted']['blogs_categories'] = $data['blogs_categories'];
		} 
		$data['option']['parent'] = $this->parentCategories();
		$data['id'] = $id;
		$data['modules'][] = 'blogs';
		$data['methods'][]= 'admin_edit_blogs_category';
		$data['title'] = 'Modules :: Blogs';
		$data['heading'] = '<i class="fa fa-edit margin-r-5"></i> Edit blogs Category';
		$data['meta_title'] = 'Edit blogs Category';
		$data['meta_description'] = 'Edit blogs Category';
		$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#blogs", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
              //return false;
            });
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	function admin_edit_blogs_category() {
		$this->load->view('blogs/admin_edit_blogs_category');
	}

	function get_blogs_category_details($id) {
		$this->blogs_model->set_table('blogs_categories');
		$blogsCategoryDetail = $this->blogs_model->get_where($id);
		return $blogsCategoryDetail;
	}

	function get_blogs_categories_list() {
		$this->blogs_model->set_table('blogs_categories');
		$blogsCategories = $this->blogs_model->get_blogs_category_list();
		return $blogsCategories;
	}

	function admin_add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $data['value_posted'] = $_POST['data'];
            $this->form_validation->set_rules('data[blogs][title]', 'Blogs Title', 'required|max_length[255]');
            $this->form_validation->set_rules('data[blogs][slug]', 'Blogs Slug', 'required|trim|is_unique[blogs.slug]|min_length[3]|max_length[255]');
             $this->form_validation->set_rules('data[blogs][content]', 'Blogs Content', 'required');
            if($this->form_validation->run()!== FALSE) { 
                $error = [];
                $post_data = $this->input->post('data[blogs]');
                $featuredImage = ''; 
                if(!empty($_FILES['featured_image']['name'])) { //echo "hi nnme";exit;
                    $blogsFileValidationParams = ['file' => $_FILES['featured_image'], 'path'=> '../content/uploads/blogs/', 'ext' => 'gif|jpg|png|jpeg', 'fieldname' =>'featured_image', 'arrindex' =>'featured_image',];
                    $featuredImage = $this->pktlib->upload_single_file($blogsFileValidationParams);
                    if(empty($featuredImage['error'])) {
                        $post_data['featured_image'] = $featuredImage['filename'];
                    }
                    else {
                        $error['featured_image'] = $featuredImage['error'];

                    }
                } else {
                	if($this->input->post('data[blogs][type]') == 'video'){
                		$post_data['featured_image'] = $this->input->post('data[youtube][video]');
                	}else{
                   		 $post_data['featured_image'] = 'default.jpg';
                		
                	}
                }
                if (empty($error)) {
                	$post_data['user_id'] = $_SESSION['user_id'];
					$post_data['published_on'] = $this->pktlib->dmYtoYmd($post_data['published_on']).' '.date('H:i:s');
                    $post_data['created'] = date('Y-m-d H:i:s');
                    $post_data['modified'] = date('Y-m-d H:i:s');
                    $reg_blogs = json_decode($this->_register_admin_add($post_data), true);
                    if($reg_blogs['status'] === 'success') {
                    	if(isset($data['value_posted']['blogs_cities'])){
	            			$data['city'] = $data['value_posted']['blogs_cities']['city_id'];
	                    	$blogsCities = $this->admin_add_blogsCities($reg_blogs['id'], $data['city']);
	                    }
						if($this->input->post('data[fcm][send_notification]')){
							$notificationArray = [
								'title' => $this->input->post('data[blogs][title]'),
								'body' => $this->input->post('data[blogs][short_description]'),
								'link' => $this->input->post('data[blogs][slug]'),
								'image' => content_url().'uploads/blogs/thumbs/'.$post_data['featured_image'],
							];
							$pushNotification = Modules::run('firebase/admin_add', $notificationArray);
						}
                        $msg = array('message'=> 'Blogs Created Successfully', 'class' => 'alert alert-success');
                        $this->session->set_flashdata('message', $msg);
                        redirect(custom_constants::new_blogs_url);
                    }
                    else {
                        $data['form_error'] = $reg_blogs['msg'];
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
        $data['categories'] = $this->blogs_model->get_categorylist_for_blogs();
        $data['option']['type'] = ['Select Type', 'text'=>'text', 'video'=>'video'];
		$data['option']['category'] = $this->parentCategories();
        $data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
            $(document).on("submit", "#blogs", function(){
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
        
        $data['meta_title'] = "ERP : blogs Module";
        $data['meta_description'] = "New blogs";
        $data['title'] = 'Modules :: Blog';
		$data['heading'] = '<i class="fa fa-plus-square margin-r-5"></i> New Blog';
        $data['modules'][] = "blogs";
        $data['methods'][] = "admin_add_blogs";
        
        echo Modules::run("templates/admin_template", $data);
    }

    function _register_admin_add($data) {
        $this->blogs_model->set_table("blogs");
        $id = $this->blogs_model->_insert($data);
        if($id['status']==='success') {
	        $blogs = $this->get_blogs_details($id['id']);
	        return json_encode(["msg" => "Blogs Created Successfully", "status" => "success", 'id' => $id['id'], 'blogs' => $blogs, 'is_new'=>true ]);
        }else {
        	return json_encode(["msg" => "Failed To Add blogs ", "status" => "fail"]);
        }

    }

    function admin_add_blogs($data = []) {
		$this->load->view("blogs/admin_add", $data);
	}

	function get_blogs_details($id) {
        $this->blogs_model->set_table('blogs');
        $customerdetails = $this->blogs_model->get_where($id);
        return $customerdetails;
    }

    function insert_multiple($data){
		$this->blogs_model->set_table("blogs_cities");
		$query = $this->blogs_model->_insert_multiple($data);
		return $query;
	}

    function admin_edit($id = NULL) {
    	if($_SERVER['REQUEST_METHOD'] == 'POST') {
    	    /*echo '<pre>';
    	    print_r($_POST);
    	    exit;*/
    	   /* if(!isset($_POST['data']['blogs'])){
    	        $_POST['data']['blogs'] = $_POST['data']['news'];
    	    }*/
    	    
    		$this->form_validation->set_rules('data[blogs][title]', 'Title', 'required|max_length[255]');
            $this->form_validation->set_rules('data[blogs][slug]', 'Slug', 'required|max_length[255]');
             $this->form_validation->set_rules('data[blogs][content]', 'Content', 'required');
           
    		if($this->form_validation->run()!== FALSE) {
    			$profileImg = '';
    			$post_data['blogs'] = $data['values_posted']['blogs'] = $_POST['data']['blogs'];
    			//print_r($post_data);exit;
    			if(NULL !== $post_data['blogs']['is_trend'])
					$post_data['blogs']['is_trend'] = true;
				else
					$post_data['blogs']['is_trend'] = false;

				if(NULL !== $post_data['blogs']['is_hot'])
					$post_data['blogs']['is_hot'] = true;
				else
					$post_data['blogs']['is_hot'] = false;

				if(NULL !== $post_data['blogs']['is_featured'])
					$post_data['blogs']['is_featured'] = true;
				else
					$post_data['blogs']['is_featured'] = false;
					
				if(NULL !== $post_data['blogs']['is_active'])
					$post_data['blogs']['is_active'] = true;
				else
					$post_data['blogs']['is_active'] = false;
    			$post_data['blogs_cities'] = $data['values_posted']['blogs_cities'] = $_POST['data']['blogs_cities'];
    			if(!empty($_FILES['featured_image']['name'])) {
    				$blogsFileValidationParams = ['file'=>$_FILES['featured_image'], 'path' => '../content/uploads/blogs/', 'ext' => 'jpg|png|gif|jpeg', 'fieldname' =>'featured_image', 'arrindex' => 'featured_image', 'thumb'=>['path'=>'../content/uploads/blogs/thumbs/', 'width'=>300]];
    				$profileImg = $this->pktlib->upload_single_file($blogsFileValidationParams);
    				if(empty($profileImg['error'])) {
    					$post_data['blogs']['featured_image'] = $profileImg['filename'];
    					unset($post_data['blogs']['featured_image2']);
    				}
    				else {
    					$error['featured_image'] = $profileImg['error'];
     				}
    			}
    			else {
    				if($this->input->post('data[blogs][type]') == 'video'){
                		$post_data['blogs']['featured_image'] = $this->input->post('data[youtube][video]');
                	}else{
    						$post_data['blogs']['featured_image'] = $post_data['blogs']['featured_image2'];
    					}
    				unset($post_data['blogs']['featured_image2']);
    			}
    			
    			//print_r($post_data);exit;
    			if(empty($error)) {
    				$post_data['blogs']['published_on'] = DateTime::createFromFormat('d/m/Y', $post_data['blogs']['published_on']);
					$post_data['blogs']['published_on'] = $post_data['blogs']['published_on']->format('Y-m-d').' '.date('H:i:s');
                    $post_data['blogs']['modified'] = date('Y-m-d H:i:s');
    				if($this->edit_blogs($id, $post_data['blogs'])) {
	            		$data['city'] = $data['values_posted']['blogs_cities']['city_id'];
	                    $blogsCity = $this->admin_add_blogsCities($id, $data['city']);
    					$msg = array('message' => "Blogs Update successfully", 'class' => 'alert alert-success fade-in');
    					$this->session->set_flashdata('message', $msg);
    				}
    				else {
    					$msg = array('message' => 'some problem occured while updating', 'class' => 'alert alert-danger fade-in');
    					$this->session->set_flashdata('message', $msg);
    				}
    				redirect(custom_constants::edit_blogs_url."/".$id);
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
			$this->blogs_model->set_table("blogs");
			$data['blogs'] = $this->blogs_model->get_where($id);
			$data['values_posted']['blogs'] = $data['blogs'];		   	
		}
		$data['blogsCategories'] = $this->blogs_model->get_categorylist_for_blogs();
    	$data['id'] = $id;
    	$data['option']['category'] = $this->parentCategories();
    	$data['parents'] = $this->get_blogs_categories_list();
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
		$blogsStates= $this->get_state_list($id);
		 $data['blogsStates'][0] = 'Select State';
		 foreach ($blogsStates as $stateKey => $state) {
		 	$data['blogsStates'][$stateKey] = $state['state_id'];
		 }
		 $blogsCities = $this->get_city_wise_blogs_list($id);
		 $data['option']['type'] = ['Select Type','text'=>'text', 'video'=>'video'];
		 $data['blogsCities'][0] = 'Select City';
		 foreach ($blogsCities as $cityKey => $city) {
		 	$data['blogsCities'][$cityKey] = $city['city_id'];
		 }
    	if(!($this->input->get('tab')))
    		$data['tab'] = 'personal_info';
    	else
    		$data['tab'] = $this->input->get('tab');
        $data['meta_title'] = "Edit blogs";
        $data['title'] = "ERP Edit blogs";
        
        $data['meta_description'] = "Edit blogs";
       	$data['content'] = 'blogs/admin_edit';
       	$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
            var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#blogs", function(){
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

    function edit_blogs($id=NULL, $post_data = []) {
        if(NULL == $id)
            return false;
        $this->blogs_model->set_table("blogs");
        if($this->blogs_model->_update($id,$post_data))
            return true;
        else
            return false;
    }

    function get_city_wise_blogs_list($id = NULL) {
    	//echo '<pre>';
    	$data['blogs_id'] = $id;
    	$this->blogs_model->set_table("blogs_cities");
    	$city = $this->blogs_model->get_city_list($id);
    	//print_r($city);
    	return $city;
    }

    function get_state_list($id = NULL) {
    	$data['blogs_id'] = $id;
    	$this->blogs_model->set_table("blogs");
    	$state = $this->blogs_model->get_state_list($id);
    	return $state;
    }

    function admin_add_blogsCities($blogsId, $data) {
    	$blogs_id = $blogsId;
    	$this->blogs_model->set_table("blogs_cities");
	    $this->blogs_model->delete($blogs_id);

	if(empty($data))
	 return true;
    	
    	$insert = [];
    	foreach ($data as $cityKey => $city) {
			$insert[$cityKey]['blogs_id'] = $blogsId;
			$insert[$cityKey]['city_id'] = $city;
			$insert[$cityKey]['created'] = date("Y-m-d H:i:s");
			$insert[$cityKey]['modified'] = date("Y-m-d H:i:s");
		}
		if(!empty($insert)) {
			$query = $this->insert_multiple($insert);
			return $query;
		}
    }

    function get_blogs_list($data = []) {
    	$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->blogs_model->set_table('blogs');
		$res = $this->blogs_model->get_blogs_list($condition);
		return $res;
    }

    function parentCategories($parent = 0, $level='', $result = [0=>'Select']){
        $parents = $this->pktdblib->custom_query('Select * from blogs_categories where is_active=true and parent_id='.$parent.' order by category_name ASC');
        foreach ($parents as $key => $parent) {
            $result[$parent['id']] = $parent['category_name']; 
            $result = $this->childCategories($parent['id'],'--', $result);
        }

        return $result;
    }

    function childCategories($parent, $level='--', $result){
        $childs = $this->pktdblib->custom_query('Select * from blogs_categories where is_active=true and parent_id='.$parent.' order by category_name ASC');
        foreach ($childs as $key => $child) {
            $result[$child['id']] = $level.$child['category_name']; 
            $result = $this->childCategories($child['id'], '--'.$level, $result);
        }
       return $result;
    }

    function createThumbnail(){
    	
    	$this->pktlib->createThumbs("../content/uploads/blogs/", "../content/uploads/blogs/thumbs/", 300);
    }
}