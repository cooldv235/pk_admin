<?php 

class Products extends MY_Controller {
	function __construct() {
		parent::__construct();

		foreach(custom_constants::$protected_pages as $page)
		{	
			if(strpos($this->uri->uri_string, $page) === 0)
			{ 	
				check_user_login(FALSE);
			}
		}
		$this->load->model('products/product_model');
		$setup = $this->setup();	
	}

	function setup(){
		//exit;
		$products = $this->product_model->tbl_product_categories();
		return TRUE;
	}

	function admin_index($id = NULL) {

		$data['meta_title'] = "Products";
		$data['meta_description'] = "Products";
		$data['modules'][] = "products";
		$data['methods'][] = "admin_product_listing";

		echo modules::run('templates/admin_template', $data);
		
	}

	function admin_product_listing() {
		$condition = '';
		if(isset($data['condition']))
			$condition = $data['condition'];

		$data['product_category'] = $this->category_wise_product_listing($condition);
		$this->load->view('products/admin_index',$data);
	}

	function admin_product_image_index($id = NULL) {
		$data['meta_title'] = "Product Images";
		$data['meta_description'] = "Product Images";
		$data['modules'][] = "products";
		$data['methods'][] = "admin_product_image_listing";
		echo modules::run('templates/admin_template', $data);
	} 


	function admin_product_image_listing($data = []) {
		//echo $productId;
		$condition = '';
			//$condition['product_id'] = $productId;
		if(isset($data['condition'])) 
			$condition = $data['condition'];
		//print_r($condition);exit;
		$data['productImages'] = $this->product_wise_product_image_listing($condition);
		//echo '<pre>';
		//print_r($data['productImages']);exit;
		$this->load->view('Products/admin_product_image_index', $data);
	}

	function get_service_list_dropdown(){
		$this->load->model('products/product_model');	
		$serviceList = $this->product_model->get_active_service_list();
		$products = [''=>'Select Service'];
		//$serviceList = ['1'=> 'Security Guards', 2 => 'Security Supervisor', 3 => 'Bouncer/Bodyguard'];
		foreach ($serviceList as $key => $service) {
			$products[$service['id']] = $service['product'];
		}
		return $products;
	}

	function admin_add_category() {
		//check_user_login(FALSE);
		$this->load->model('products/product_model');
		//echo "new_product";

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			/*echo '<pre>';
			print_r($_POST);exit;*/
			//print_r($_FILES);
			$data['values_posted'] = $_POST;
			$this->form_validation->set_rules('data[product_categories][parent_id]', 'parent');
			$this->form_validation->set_rules('data[product_categories][category_name]', 'category_name', 'required|max_length[255]');
			$this->form_validation->set_rules('data[product_categories][slug]', 'slug', 'required|max_length[255]|is_unique[product_categories.slug]');
			if($this->form_validation->run('product_categories')!== false) {
				$productImg1 = '';
				$productImg2 = '';

				$error = [];
				/*echo '<pre>';
				print_r($_FILES);
				echo '</pre>';exit;*/
				if(!empty($_FILES['image_name_1']['name'])) {
					//echo "reached in files";
					/*$productCategoriesValidationParams1 =['file' =>$_FILES['image_name_1'], 'path'=>'../content/uploads/product_categories/','ext'=>'gif|jpg|png|jpeg', 'fieldname'=>'image_name_1', 'arrindex'=>'image_name_1'];
					//print_r($productCategoriesValidationParams1);
					$profileImg1 = $this->pktlib->upload_single_file($productCategoriesValidationParams1);*/

					$productImageFileValidationParams1 = ['file'=>$_FILES['image_name_1'], 'path'=>'../content/uploads/product_categories/', 'ext'=>'jpeg|jpg|png|gif', 'fieldname'=>'image_name_1', 'arrindex'=>'image_name_1'];
 					//print_r($productImageFileValidationParams1);
    				$productImg1 = $this->pktlib->upload_single_file($productImageFileValidationParams1);
					//print_r($productImg1);//exit;
					if(empty($productImg1['error'])) {
						//echo "error not found in image 1";
						$_POST['data']['product_categories']['image_name_1'] = $productImg1['filename'];
					} else { //echo "error found in image 1";
						$error['image_name_1'] = $productImg1['error'];
					}
				}
				//exit;

				if(!empty($_FILES['image_name_2']['name'])) {
					//echo "reached in files";
					$productCategoriesValidationParams2 =['file' =>$_FILES['image_name_2'], 'path'=>'../content/uploads/product_categories/','ext'=>'gif|jpg|png|jpeg', 'fieldname'=>'image_name_2', 'arrindex'=>'image_name_2'];
					//print_r($productCategoriesValidationParams2);
					$productImg2 = $this->pktlib->upload_single_file($productCategoriesValidationParams2);
					//print_r($profileImg2);//exit;
					if(empty($productImg2['error'])) {
						if(empty($_POST['data']['product_categories']['image_name_2'])) {
						$_POST['data']['product_categories']['image_name_2'] = $productImg2['filename'];
						}else{
							$_POST['data']['product_categories']['image_name_2'] = $productImg2['filename'];

						}
					} else {
						$error['image_name_2'] = $productImg2['error'];
					}
				}
				//exit;

				//print_r($this->input->post('data'));exit;
				if(empty($error)) {
					$post_data = $this->input->post('data[product_categories]');
					//print_r($post_data);
					$register_product_category = json_decode($this->register_product_category($post_data), true);
					if($register_product_category['status'] === 'success') {
						$msg = array('message'=>'Product Category Added Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					redirect(custom_constants::new_product_category_url);

					}
					else {
						$data['form_error'] = $register_product_category['msg'];
					}
				}
				else {
					//print_r($error);
					$msg = array('message'=>'unable to add product', 'class'=>'alert alert-danger');
					$this->session->set_flashdata('message', $msg);
				}
			}
			else {
				$msg = array('message'=>'unable to add product following error occured. '.validation_errors(), 'class'=>'alert alert-danger');
					$this->session->set_flashdata('message', $msg);
			}

		}

		//echo "<pre>";
		$data['option']['parent'] = $this->parent();
		//print_r($data['parents']);
		/*$data['option']['parent'][0] = 'Select Parent';
		foreach($data['parents'] as $parentKey => $parent){
			
			$data['option']['parent'][$parent['id']] = $parent['category_name'];
		}*/
		
		$data['modules'][] = 'products';
		$data['methods'][]= 'admin_add_product_category';
		//$data['content'] = 'products/add_products';
		$data['title'] = 'Modules :: Products';
		$data['meta_title'] = 'Add Product Category';
		$data['meta_description'] = 'Add Product Category';
		
		echo Modules::run('templates/admin_template', $data);
	}

	function register_product_category($data) {
		$insert_data = $data;
		//echo "hi";

		$this->product_model->set_table("product_categories");
		$id = $this->product_model->_insert($insert_data);
		return json_encode(['message' =>'Enquiry added Successfully', "status"=>"success", 'id'=> $id]);
	}

	function admin_add_product_category() {
		$this->load->view('products/admin_add_product_category');
	}

	function admin_edit_category($id = NULL) {
		//check_user_login(FALSE);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			/*echo '<pre>';
			print_r($_POST);*/
			//echo '</pre>';exit;
			$data['values_posted'] = $_POST['data'];
			$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
			$this->form_validation->set_rules("data[product_categories][parent_id]", 'Parent', 'required');
			$this->form_validation->set_rules("data[product_categories][category_name]", 'Category Name', 'required|max_length[255]');
			//$this->form_validation->set_rules("data[product_categories][description]", 'Description', 'max_length[255]');
			$this->form_validation->set_rules("data[product_categories][gst]", 'GST', 'max_length[255]');
			if($this->form_validation->run('product_categories')!== FALSE){
				$productCategoryImg = '';
				$productCategoryImg2 = '';
				$error = [];
			//echo "hi";
				$postData = $_POST['data']['product_categories'];
				
				if(!empty($_FILES['image_name_1']['name'])) {
					//echo "image 1 found";exit;
					$logoFileValidationParams = ['file'=>$_FILES['image_name_1'], 'path'=>'../content/uploads/product_categories/', 'fieldname'=>'image_name_1', 'ext'=>'jpeg|png|jpg|gif', 'arrindex'=>'image_name_1'];
					//print_r($logoFileValidationParams);exit;
					$productCategoryImg = $this->pktlib->upload_single_file($logoFileValidationParams);
					//print_r($productCategoryImg);exit;
					if(empty($productCategoryImg['error'])) {
						$postData['image_name_1'] = $productCategoryImg['filename'];
						//echo "error empty";exit;
						unset($postData['image_name_1_2']);
					}
					else {
						$error['image_name_1'] = $productCategoryImg['error'];
					}
				}
				else {
					//echo "image 1 is not selected";exit;
					$postData['image_name_1'] = $postData['image_name_1_2'];
					//print_r($postData['image_name_1_2']);exit;
				}
					unset($postData['image_name_1_2']);
				/*echo '<pre>';//print_r($postData);exit;
				print_r($_FILES);*/
				if(!empty($_FILES['image_name_2']['name'])) { 
					$logoFileValidationParams2 = ['file'=>$_FILES['image_name_2'], 'path'=>'../content/uploads/product_categories/', 'fieldname'=>'image_name_2', 'ext'=>'jpeg|png|jpg|gif', 'arrindex'=>'image_name_2'];
					//print_r($logoFileValidationParams2);//exit;
					$productCategoryImg2 = $this->pktlib->upload_single_file($logoFileValidationParams2);
					//print_r($productCategoryImg2);exit;
					if(empty($productCategoryImg2['error'])) {
						$postData['image_name_2'] = $productCategoryImg2['filename'];
						unset($postData['image_name_2_2']);
					}
					else {
						$error['image_name_2'] = $productCategoryImg2['error'];
					}
				}
				else {
					$postData['image_name_2'] = $postData['image_name_2_2'];
				}
				unset($postData['image_name_2_2']);
				//echo '<pre>';print_r($postData);exit;
				//print_r($error);exit;
				if(empty($error)) {
					//echo " error not found";exit;
					if(isset($postData['is_active'])){
					    $postData['is_active'] = 1;
					}else{
					    $postData['is_active'] = 0;
					}
					/*print_r($postData);
					exit;*/
					if($this->product_model->update_product_categories($id, $postData)) {
						$msg = array('message'=>'Data Updated Successfully', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					}
					else {
						$msg = array('message'=>'some problem occured', 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
					}
					redirect(custom_constants::edit_product_category_url."/".$id);
				} 
				else {
					//echo " error found";exit;

					//print_r($error);exit;
					$msg = array('message'=>'some error occured while uploading'.$error, 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
				}
			} 
			else {
				$data['values_posted']['product_categories']['image_name_1'] = $data['values_posted']['product_categories']['image_name_1_2']; 
				$data['values_posted']['product_categories']['image_name_2'] = $data['values_posted']['product_categories']['image_name_2_2']; 
				//echo validation_errors();exit;
				$msg = array('message'=>'some validation error occured'.validation_errors(), 'class'=>'alert alert-success');
					$this->session->set_flashdata('message', $msg);
			}
		}  
		else {
			$data['product_categories'] = $this->get_product_category_details($id);
			//print_r($data['product_categories']);
			$data['values_posted']['product_categories'] = $data['product_categories'];
			

		} 
	    //print_r($data['values_posted']['product_categories']);exit;
		$data['option']['parent'] = $this->parent();
		 //print_r($data['option']['parent'][$parent['id']]);
		$data['id'] = $id;
		$data['modules'][] = 'products';
		$data['methods'][]= 'admin_edit_product_category';
		$data['title'] = 'Edit Product Category';
		$data['meta_title'] = 'Edit Product Category';
		$data['meta_description'] = 'Edit Product Category';
		$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("description",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
            $(document).on("submit", "#product_categories", function(){
            console.log(CKEDITOR.instances.editor1.getData());
            return false;
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	function admin_edit_product_category() {
		$this->load->view('products/admin_edit_product_category');
	}


	function get_product_category_details($id) {
		// echo "reached get_product_category_details";
		$this->product_model->set_table('product_categories');
		$productCategoryDetail = $this->product_model->get_where($id);
		//print_r($productCategoryDetail);
		return $productCategoryDetail;
	}
	function admin_edit($id) {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data['values_posted'] = $_POST;
			
			$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
			$this->form_validation->set_rules("data[products][product_category_id]", 'Product Category', 'required');
			$this->form_validation->set_rules("data[products][product]", 'Product', 'required|max_length[255]');
			$this->form_validation->set_rules("data[products][product_code]", 'Product Code', 'max_length[255]');
			$this->form_validation->set_rules("data[products][base_price]", 'Base Price', 'max_length[255]');

			if($this->form_validation->run('products')!== FALSE){
				$productImg = '';
				$postData = $_POST['data']['products'];
				if(NULL !== $postData['is_sale'])
					$postData['is_sale'] = true;
				else
					$postData['is_sale'] = false;

				if(NULL !== $postData['is_new'])
					$postData['is_new'] = true;
				else
					$postData['is_new'] = false;

				if(NULL !== $postData['is_gift'])
					$postData['is_gift'] = true;
				else
					$postData['is_gift'] = false;

				if(NULL !== $postData['is_pack'])
					$postData['is_pack'] = true;
				else
					$postData['is_pack'] = false;

				if(NULL !== $postData['show_on_website'])
					$postData['show_on_website'] = true;
				else
					$postData['show_on_website'] = false;

				//print_r($postData);exit;
				if(empty($error)) {
					if($this->edit_product($id,$postData))
					{	$msg = array('message' => 'Data Updated Successfully', 'class' => ' alert alert-success');
						$this->session->set_flashdata('message', $msg);
					} 
					else {
						$msg = array('message' => 'Some error occured while updating','class'=>'alert alert-danger');
						$this->session->set_flashdata('message', $msg);
					}
					//exit;
					//print_r(custom_constants::edit_product_url."/".$id);exit;
					redirect(custom_constants::edit_product_url."/".$id."?tab=product_images");
				}
				else {
					$msg = array('message' => 'Some error occured while updating','class'=>'alert alert-danger');
					$this->session->set_flashdata('message', $msg);	
				}
			}
			else {
				$msg = array('message' => 'validation error'.validation_errors() ,'class'=>'alert alert-danger');
				$this->session->set_flashdata('message', $msg);
			}


		}
		else {
			//print_r($data['product_categories']);
			$data['products'] = $this->get_product_details($id);
			//print_r($data['products']);

			$data['values_posted']['products'] = $data['products'];
			$data['product_images'] = $this->get_product_image_details($id); 
			$data['values_posted']['product_images'] = $data['product_images'];

			$this->pktdblib->set_table('product_details');
			$data['productDetails'] = Modules::run('products/admin_edit_product_details', $id);//$this->pktdblib->get_where_custom('product_id', $id);
			//print_r($data['values_posted']['product_images']);
		}
		
		//$data['productCategories'] = $this->product_model->get_categorylist_for_product();
			//print_r($data['products']);
		$data['option']['category'] = $this->category_last_child();

		$data['id'] = $id;
		if(!($this->input->get('tab'))){
			$data['tab'] = 'product';
		}
		else {
			$data['tab'] = $this->input->get('tab');	
		}
		
		//print_r($data['product_images']);
		$data['modules'][0] = 'products';
		$data['methods'][0]= 'admin_edit_product';
		$data['product_type'] = $this->get_product_type();
		$data['option']['product_type'] = $data['product_type'];
		$data['productImages'] = Modules::run('products/admin_edit_product_images', $id);
		$data['title'] = 'Edit Product Detail';
		$data['meta_title'] = 'Edit Product Detail';
		$data['meta_description'] = 'Edit Product Detail';
		$data['js'][] = '<script type="text/javascript">
            $(document).on("change", ".type", function() {
            var trid = $(this).closest("tr").attr("id");
            console.log(trid);
            console.log(this.value);
			    if (this.value == "image")
			    {
			     console.log("type is image");
			      $("#image_name_1_"+trid).show();
			      $("#featured_image_video_"+trid).hide();
			      
			    }
			    else
			    {
			     console.log("type is video");
			      $("#image_name_1_"+trid).hide();
			      $("#featured_image_video_"+trid).show();
			    }
  			});
    	
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	/*function admin_edit_product_images($data = []) {
		$data['product_images'] = $this->get_product_image_details($data['id']); 
		$this->load->view('products/admin_edit_product_images', $data);
	}*/

	function admin_edit_product() {
		$this->load->view('products/admin_edit');
	}
	
    function admin_edit_product_images($productId) {
    	//echo $productId;
 		if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
 			//print_r($_POST);exit;
 			$data['values_posted'] = $_POST; 
 			/*echo '<pre>';
 			print_r($_POST);exit;*/
 			//print_r($data['values_posted']);
 			//print_r($_FILES['product_images']);//exit;
 			$productImg1 = '';
			$productImg2 = '';
			$insert = [];
			$update = [];
			/*echo '<pre>';
			print_r($_FILES['product_images']);exit;*/
 			if(count($_FILES['product_images']['name'])>0) {
 					//echo " multiple images are found";//exit;
 					$productImageFileValidationParams1 = ['file'=>$_FILES['product_images'], 'path'=>'../content/uploads/products', 'ext'=>'jpeg|jpg|png|gif', 'fieldname'=>'image_name_1', 'arrindex'=>'product_images'];
 					//print_r($productImageFileValidationParams1);
    				$productImg1 = $this->pktlib->upload_multiple_file($productImageFileValidationParams1);
    				//print_r($productImg1);
    				//exit;
    				if(empty($productImg1['error'])) {
    					//$postData['productImg1'] = $productImg1['filename'];
						//unset($postData['logo2']);
    				}
    				if(!$productImg1) {
    					$msg = array('message' => "Some error occured with file", 'class'=>'alert alert-danger');
    					$this->session->set_flashdata('message', $msg);	
    				}
    				if(isset($_FILES['product_images']['name'][0]['image_name_2'])){
	    				$productImageFileValidationParams2 = ['file'=>$_FILES['product_images'], 'path'=>'../content/uploads/products', 'ext'=>'jpeg|jpg|png|gif', 'fieldname'=>'image_name_2', 'arrindex'=>'product_images'];
	    				$productImg2 = $this->pktlib->upload_multiple_file($productImageFileValidationParams2);
	    				//print_r($productImg2);

	    				if(!$productImg2) {
	    					$msg = array('message' => "Some error occured with file", 'class'=>'alert alert-danger');
	    					$this->session->set_flashdata('message', $msg);	
	    				}
	    			}
 				}
 				//echo '<pre>';print_r($this->input->post('product_images'));exit;
 			foreach ($this->input->post('product_images') as $imageKey => $value) {
 				//echo $imageKey;
 				//print_r($value);
 				
				if($value['type'] == 'image'){

	 				if(!empty($productImg1['filename'][$imageKey])) {
	 					$value['image_name_1'] = $productImg1['filename'][$imageKey];
	 				}else {
	 					$value['image_name_1'] = $value['image_name_1_2'];
	 				}

	 				if(!empty($productImg2['filename'][$imageKey])) {
			 			$value['image_name_2'] = $productImg2['filename'][$imageKey];	
			 		}else {
			 			$value['image_name_2'] = $value['image_name_2_2'];
			 		}
				}else{
					 			$value['image_name_1'] = $value['video'];
					 			$value['image_name_2'] = '';

					 		}
				unset($value['video']);

 				/*if(!empty($productImg2['filename'][$imageKey])) {
 					$_POST['product_images'][$imageKey]['image_name_2'] = $productImg2['filename'][$imageKey];
 				}else {
 					$_POST['product_images'][$imageKey]['image_name_2'] = $_POST['product_images'][$imageKey]['image_name_2_2'];
 				}*/
 				if(isset($value['featured_image'])) {
					$value['featured_image']= true;
				}else {
					$value['featured_image']= false;
				}
				if(isset($value['is_active'])) {
					$value['is_active']= true;
				}else {
					$value['is_active']= false;
				}
 				$value['product_id'] = $productId;

 				unset($value['image_name_1_2']);

 				unset($value['image_name_2_2']);
 				unset($value['video']);
 				$value['modified'] = date('Y-m-d H:i:s');
 				if(isset($value['id']) && !empty($value['id'])) {
 					$update[] = $value;
 					//print_r($update);
 				}else {
 					unset($value['id']);
 					$value['created'] = date('Y-m-d H:i:s');
 					$insert[] = $value;
 				}
 			}
 			/*echo '<pre>';print_r($update);
 			print_r($insert);
 			exit;*/
 			if(!empty($update)) {
 				//$this->pktdblib->set_table('product_images');
 				//$query = $this->pktdblib->update_multiple('product_id',$update);
				$this->update_multiple_product_images($update);
 			}

 			if(!empty($insert)) {
 				//$this->insert_multiple_product_images($insert);
 				$this->pktdblib->set_table('product_images');
 				$query = $this->pktdblib->_insert_multiple($insert);
 			}
 			$msg = array('message' => 'Data updated Successfully' ,'class'=>'alert alert-success');
			$this->session->set_flashdata('message', $msg);
			redirect('products/admin_edit/'.$productId."?tab=product_images");

 		}
 		$data['id'] = $productId;
 		$data['product_images'] = $this->get_product_image_details($productId);
        $data['option']['type'] = ['Select Type', 'image'=>'image', 'video'=>'video'];

 		//print_r($data['product_images']);
 		$this->load->view('products/admin_edit_product_images', $data);
    }

	function get_product_details($id) {
		$this->product_model->set_table('products');
		$product = $this->product_model->get_where($id);
		//print_r($product);
		return $product;
	}

	function get_product_details_ajax($id) {
		$this->product_model->set_table('products');
		$product = $this->product_model->get_where($id);
		//print_r($product);
		echo json_encode($product);
		exit;
	}

	function product_wise_product_image_listing($data = []){
		//print_r($data);
		$condition = '';
			$condition['product_images.product_id'] = $data['product_images.productid'];

		if(isset($data['condition']))
			$condition = $data['condition'];
		//print_r($condition);exit;
		$this->product_model->set_table('product_images');
		$productImage = $this->product_model->get_product_image_list($condition);
		//print_r($productImage);exit;
		return $productImage;
	}

	function get_product_image_details($productId) {

		$this->product_model->set_table('product_images');
		$productImage = $this->product_model->get_where_custom('product_id', $productId);
		/*echo '<pre>';
		print_r($productImage->result_array());*/
		return $productImage->result_array();
	}


	function get_product_categories_list() {
		$this->product_model->set_table('product_categories');
		$productCategories = $this->product_model->get_product_category_list();
		return $productCategories;
	}

	function admin_add(){
		if($_SERVER['REQUEST_METHOD']=='POST') {
			//echo '<pre>';//print_r($_POST);print_r($_FILES);exit;
			//print_r($_POST['youtube']);exit;
			$data['values_posted'] = $this->input->post('data');
			
			$this->form_validation->set_rules('data[products][product_category_id]', 'category');
			$this->form_validation->set_rules('data[products][product]', 'product', 'required|max_length[255]');
			$this->form_validation->set_rules('data[products][product_type]', 'product type', 'max_length[6]');
			$this->form_validation->set_rules('data[products][slug]', 'Slug', 'required|is_unique[products.slug]');
			$this->form_validation->set_rules('data[products][product_code]', 'product code');
			if($this->form_validation->run('products')!== false) {
				$error=[];
				$productImg1 = [];
				$productImg2 = [];
				if(!empty($_FILES['product_images']['name'])) {
					$productValidationParams1 = ['file'=>$_FILES['product_images'], 'path'=>'../content/uploads/products/', 'fieldname'=>'image_name_1', 'ext'=>'jpg|jpeg|gif|png', 'arrindex'=>'product_images'];
					$productImg1 = $this->pktlib->upload_multiple_file($productValidationParams1);
					//print_r($productImg1['filename']);exit;
					if(!empty($productImg1['error'])) {
						 $msg = array('message' => 'Some Error occured with File','class' => 'alert alert-danger fade in');
                    $this->session->set_flashdata('message',$msg);
                    redirect(custom_constants::new_product_url);
					}
					$productValidationParams2 = ['file'=>$_FILES['product_images'], 'path'=>'../content/uploads/products/', 'fieldname'=>'image_name_2', 'ext'=>'jpg|jpeg|gif|png', 'arrindex'=>'product_images'];
					$productImg2 = $this->pktlib->upload_multiple_file($productValidationParams2);
					//print_r($productImg2);exit;
					if(!empty($productImg2['error'])) {
						 $msg = array('message' => 'Some Error occured with File','class' => 'alert alert-danger fade in');
                    $this->session->set_flashdata('message',$msg);
                    redirect(custom_constants::new_product_url);
					}

				} 
				
				//exit;
					/*echo '<pre>';
					print_r($this->input->post());exit;*/
					$postData = $this->input->post('data[products]');
					$postData['created'] = date('Y-m-d H:i:s');
					$postData['modified'] = date('Y-m-d H:i:s');
					$regProduct = json_decode($this->register_products($postData),true);
					$postProductDetail = $this->input->post('data[product_details]');
					if(!empty($postProductDetail)){
						$postProductDetail['product_id'] = $regProduct['id'];
						$postProductDetail['created'] = $postProductDetail['modified'] = date('Y-m-d H:i:s');
						//print_r($postProductDetail);exit;
						$this->product_model->set_table('product_details');
						$result = $this->product_model->_insert($postProductDetail);
						
					}
					//print_r($regProduct);exit;
					 if($regProduct['status']==='success') {
					 	//echo $regProduct['id'];
					 	

					 	$productImage = [];
					 	//print_r($_POST['product_images']);exit;
					 	foreach($this->input->post('product_images') as $imageKey => $image) {
					 		//print_r($image);

					 		/*if($image['type'] == 'video'){
					 			$productImage[$imageKey]['image_name_1'] = $image['video'];
					 		}*/
					 		//if(!empty($image)) {
					 		if($image['type']=='image'){

						 		$image['image_name_1'] = $productImg1['filename'][$imageKey];
						 		if(empty($productImg2['filename'][$imageKey])) {
						 		$image['image_name_2'] = $productImg1['filename'][$imageKey];
						 		}else {
						 			$image['image_name_2'] = $productImg2['filename'][$imageKey];	
						 		}
					 		}else{
					 			$image['image_name_1'] = $image['video'];
					 			$image['image_name_2'] = '';

					 		}
					 			unset($image['video']);
						 		$image['product_id'] = $regProduct['id']; 
						 		$image['created'] = $image['modified'] = date('Y-m-d H:i:s'); 
						 		if(isset($image['featured_image'])) {
						 			$image['featured_image'] = true;
						 		}else{
						 			$image['featured_image'] = false;
						 		}

						 		if(isset($image['is_active'])) {
						 			$image['is_active'] = true;
						 		}else{
						 			$image['is_active'] = false;
						 		}
						 		$productImage[] = $image;
					 		//}
						}
					//echo '<pre>';print_r($productImage);exit;
						if(!empty($productImage)) {
							$this->pktdblib->set_table('product_images');
							$query = $this->pktdblib->_insert_multiple($productImage);
					 	}
					 	$msg = array('message'=>'Product Added Successfully. Product Id : '.$regProduct['id'], 'class'=>'alert alert-success' );
					 	$this->session->set_flashdata('message', $msg);
					 	redirect('products/admin_add'); 
					 	
					 }
					 else {
					 	$msg = array('message'=>'Failed to add products', 'class'=>'alert alert-danger' );
					 	$this->session->set_flashdata('message', $msg);
					 }				
			} else {
				$msg = array('message'=>'error occured while adding products'.validation_errors(), 'class'=>'alert alert-danger' );
					 	$this->session->set_flashdata('message', $msg);
			}
		}
		$data['option']['category'] = $this->category_last_child();
		$data['products'] = $this->product_model->get_active_list();
		/*echo '<pre>';
		print_r($data['products']);*/
		$data['option']['product'][0] = 'Select Product';
		foreach ($data['products'] as $productKey => $product) {
			$data['option']['product'][$product['id']] = $product['product'];
		}
        $data['option']['type'] = ['Select Type', 'image'=>'image', 'video'=>'video'];

		$data['modules'][] = 'products';
		$data['methods'][]= 'admin_add_product';
		$data['product_type'] = $this->get_product_type();
		$data['title'] = 'Add Products';
		$data['meta_title'] = 'Add Products';
		$data['meta_description'] = 'Add Products';
		$data['js'][] = '<script type="text/javascript">
            $(document).on("change", ".type", function() {
            var trid = $(this).closest("tr").attr("id");
            console.log(trid);
            console.log(this.value);
			    if (this.value == "image")
			    {
			     console.log("type is image");
			      $("#image_name_1_"+trid).show();
			      $("#featured_image_video_"+trid).hide();
			      
			    }
			    else
			    {
			     console.log("type is video");
			      $("#image_name_1_"+trid).hide();
			      $("#featured_image_video_"+trid).show();
			    }
  			});
    	
        </script>';
		echo Modules::run('templates/admin_template', $data);
	}

	function register_products($data) {
		/*echo '<pre>';
		print_r($data);
		exit;*/
		/*if(empty($data['product_code'])){
			echo "hello";exit;
		}*/
		$insert_data = $data;
		$this->product_model->set_table('products');
		$result = $this->product_model->_insert($insert_data);
		if($result['status'] == 'success'){
			if(empty($data['product_code'])){
				$productCode = $this->create_product_code($result['id']);
				$updArr['id'] = $result['id'];
				$updArr['product_code'] = $productCode;
				$updCode = $this->edit_product($result['id'], $updArr);
			}
			$product = $this->get_product_details($result['id']);
			return json_encode(['message'=>'Products Addded Successfully', 'status'=>'success', 'id'=>$result['id'], 'products'=>$product]);
		}else{
			return json_encode(['message'=>'Some Error Occurred', 'status'=>'success', 'id'=>$result['id']]);
		}
	}

	function edit_product($id=NULL, $post_data = []) {
		//print_r($post_data);exit;
		if(NULL == $id)
			return false;
		$this->product_model->set_table('products');
		if($this->product_model->_update($id,$post_data)){
			return true;
		}
		else
			return false;
	}

	function admin_add_product() {
		$this->load->view('products/admin_add');
	}

	function get_product_category_list() {
		$this->product_model->set_table('products');
		$query = $this->product_model->get_product_category_list();
		print_r($query);
		return $query;
	}

	function get_categorywise_product($slug = '') {
		if('' === $slug){
			show_404();
			exit;
		}

		$category = $this->get_slugwise_category($slug);
		$this->product_model->set_table('products');
		$data['categoryWiseProducts'] = $this->product_model->get_categorywise_product($category['id']);
		//print_r($categoryWiseProducts);exit;
		$data['content'] = 'products/categorywise_product_list';
		//$data['content'] = 'products/add_products';
		$data['title'] = $category['category_name'];
		$data['meta_title'] = $category['meta_title'];
		$data['meta_description'] = $category['meta_description'];
		$data['meta_keyword'] = $category['meta_keyword'];
		$data['breadCrumbs'] = [
			['url'=>'/', 'title'=>'Home'],
			['url'=>'#', 'title'=>'Category : : '.ucfirst($category['category_name'])]
		];

		$data['category'] = $category;
		echo Modules::run('templates/obaju_inner_template', $data);
	}

	function get_slugwise_category($slug = ''){
		if(''===$slug){
			show_404();
			exit;
		}
		$this->product_model->set_table('product_categories');
		$category = $this->product_model->get_slugwise_category($slug);
		return $category;
	}

	function id_wise_category($id = ''){
		if(''==$id){
			show_404();
			exit;
		}
		//echo "reached here";
		$this->product_model->set_table('product_categories');
		$product = $this->product_model->get_list($id);
		//print_r($product);
		return $product;
	}

	function get_single_product($slug = ''){
		if(''===$slug){
			show_404();
			exit;
		}
		//print_r($slug);exit;
		$product = $this->get_slugwise_product($slug);
		$category = $this->id_wise_category($product['product_category_id']);
		//print_r($category);exit;
		$data['title'] = $product['product'];
		$data['meta_title'] = $product['meta_title'];
		$data['meta_description'] = $product['meta_description'];
		$data['meta_keyword'] = $product['meta_keyword'];
		$data['breadCrumbs'] = [
			['url'=>'/', 'title'=>'Home'],
			['url'=>'product-category/'.$category['slug'], 'title'=>'Category : : '.ucfirst($category['category_name'])],
			['url'=>'#', 'title'=>'Product : : '.ucfirst($product['product'])]
		];
		$data['productImages'] = $this->get_productwise_images($product['id']);
		//print_r($data['productImages']);exit;
		$data['relatedProducts'] = $this->get_related_products($category['id'], $product['id']);

		//print_r($data['relatedProducts']);exit;
		//$data['viewedProducts'] = $this->get_viewed_products($category['id'], $product['id']);
		$data['product'] = $product;
		$data['category'] = $category;
		$data['content'] = 'products/product_detail';

		echo Modules::run('templates/obaju_inner_template', $data);
	}

	function get_productwise_images($productId){
		$this->product_model->set_table('product_images');
		$images = $this->product_model->get_where_custom('product_id', $productId);
		return $images->result_array();
	}

	function get_slugwise_product($slug = ''){
		/*echo "reached in get_slugwise_product";
		print_r($slug);exit;*/
		if(''===$slug){
			show_404();
			exit;
		}

		$this->product_model->set_table('products');
		$product = $this->product_model->get_slugwise_product($slug);
		//print_r($product);exit;
		return $product;
	}

	function left_get_categorywise_product($slug = '') {
		//echo $slug;
		if('' === $slug){
			show_404();
			exit;
		}

		$category = $this->get_slugwise_category($slug);
		$this->product_model->set_table('products');
		$data['categoryWiseProducts'] = $this->product_model->get_categorywise_product($category['id']);
		//print_r($data['categoryWiseProducts']);exit;
		//$data['content'] = 'products/add_products';
		$data['title'] = $category['category_name'];
		$data['meta_title'] = $category['meta_title'];
		$data['meta_description'] = $category['meta_description'];
		$data['meta_keyword'] = $category['meta_keyword'];
		$data['breadCrumbs'] = [
			['url'=>'/', 'title'=>'Home'],
			['url'=>'#', 'title'=>'Category : : '.ucfirst($category['category_name'])]
		];

		$data['category'] = $category;
		$data['content'] = 'products/categorywise_product_list2';
		echo Modules::run('templates/obaju_inner_template', $data);
	}

	function right_get_categorywise_product($slug = '') {
		if('' === $slug){
			show_404();
			exit;
		}

		$category = $this->get_slugwise_category($slug);
		$this->product_model->set_table('products');
		$data['categoryWiseProducts'] = $this->product_model->get_categorywise_product($category['id']);
		//print_r($categoryWiseProducts);exit;
		$data['content'] = 'products/categorywise_product_list3';
		//$data['content'] = 'products/add_products';
		$data['title'] = $category['category_name'];
		$data['meta_title'] = $category['meta_title'];
		$data['meta_description'] = $category['meta_description'];
		$data['meta_keyword'] = $category['meta_keyword'];
		$data['breadCrumbs'] = [
			['url'=>'/', 'title'=>'Home'],
			['url'=>'#', 'title'=>'Category : : '.ucfirst($category['category_name'])]
		];

		$data['category'] = $category;
		echo Modules::run('templates/obaju_inner_template', $data);
	}

	function get_related_products($categoryId, $productId)
	{
		$this->product_model->set_table('products');
		return $this->product_model->get_related_products($categoryId, $productId);
	}

	function backTraverse_category($parentId, $traverseResult = []) {
		$this->product_model->set_table('product_categories');
		$categories = $this->product_model->get_where_custom('id',$parentId);
		$category = $categories->row_array();
		/*echo '<pre>';
		print_r($category);
		echo '</pre>';*/
		$traverseResult[$category['id']] = $category;
		if($category['parent_id']!=0){
			$this->backTraverse_category($category['parent_id'], $traverseResult);
		}
		return $traverseResult;
	}

	function checkCategory_is_parent($categoryId){
		//print_r($categoryId);echo '<br>';
		$this->product_model->set_table('product_categories');
		$categories = $this->product_model->get_where_custom('parent_id',$categoryId);
		$category = $categories->result_array();
		/*echo '<pre>';
		print_r($category);*/
		//not used so far. remove this line if used anywhere
		return count($category);
	}

	function get_categorylist($parentSlug = '') {
		$parentId = 1;
		$category = $this->id_wise_category($parentId);
		$breadCrumb[0] = ['url'=>'/', 'title'=>'Home'];
		if('' !== $parentSlug){ 
			$category = $this->get_slugwise_category($parentSlug);
			$parentId = $category['id'];
			$backTraverseCategory = $this->backTraverse_category($category['parent_id']);
			
		}

		$this->product_model->set_table('product_categories');
		$query = $this->product_model->get_where_custom('parent_id', $parentId);
		$data['categories'] = $query->result_array();

		foreach ($data['categories'] as $catKey => $cat) {
			$childCategory = $this->product_model->get_where_custom('parent_id', $cat['id']);
			$childCategory = $childCategory->result_array();
			if(count($childCategory)>0)
				$data['categories'][$catKey]['is_parent'] = true;
			else
				$data['categories'][$catKey]['is_parent'] = false;

		}
		$data['category'] = $category;
		$data['content'] = 'products/categorylist2';
		$data['title'] = $category['category_name'];
		$data['meta_title'] = $category['meta_title'];
		$data['meta_description'] = $category['meta_description'];
		$data['meta_keyword'] = $category['meta_keyword'];
		$data['breadCrumbs'] = [
			['url'=>'/', 'title'=>'Home'],
			['url'=>'#', 'title'=>ucfirst($category['category_name'])]
		];
		//echo $category['slug'];exit;
		$data['products'] = Modules::run("products/left_get_categorywise_product", $category['slug']);
		echo Modules::run('templates/obaju_inner_template', $data);

	}


	function update_multiple_product_images($data) {
		echo "reched in update_multiple_product_images";
		$this->product_model->set_table("product_images");
		$query = $this->product_model->update_multiple('id',$data);
		return $query;
	}

	function category_wise_product_listing($data = []){
		$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->product_model->set_table('products');
		$res = $this->product_model->get_product_list($condition);
		//print_r($res);
		return $res;
	}

	function admin_category_index(){
		$data['meta_title'] = 'edit employees';
		$data['meta_description'] = 'edit employees';
		//$data['module'] = 'address';
		//$data['content'] = 'address/address_listing';
		$data['modules'][] = 'products';
		$data['methods'][] = 'admin_category_listing';
		
		echo Modules::run("templates/admin_template", $data); 	
	}

	function admin_category_listing($data = []) {
		$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		//echo "string"; exit;
		$this->product_model->set_table('product_categories');
		$data['categories'] = $this->product_model->get_category_list();
		/*echo '<pre>';
		print_r($data['categories']);
		echo '</pre>';exit;*/
		$this->load->view("products/admin_category_listing", $data);
	}

	function get_product_type(){
		$query = [/*'Select Product Type',*/'Service', 'Product',  'Product & Services']; 
		//print_r($query);
		return $query;
	}

	function admin_view($id=NULL){
		if(NULL==$id){
			redirect('product/admin_product_index');
		}
		$this->product_model->set_table('products');
		//$product = $this->product_model->get_where($id);
		//print_r($product);
		//$product = $this->get_product_list($id);
		//echo $id;
		$product = $this->product_model->get_where_product($id);
		//print_r($product);
		$data['product'] = $product;
		$data['content'] = 'products/admin_view_product';
		$data['meta_title'] = 'Products';
		$data['meta_description'] = 'Products';
		$productListData = ['condition'=>['product_images.productid'=>$id],'module'=>'products'];
		//print_r($productListData);
		$data['productImage'] = Modules::run("products/admin_product_image_listing", $productListData);
		//print_r($data['productImage']);
		echo modules::run('templates/admin_template', $data);
	}

	function admin_view_category($id=NULL) {
		if(NULL==$id) {
			//echo "hi";
			redirect('products/admin_category_index');
		}
		$this->product_model->set_table('product_categories');
		$category = $this->product_model->get_where($id);
		$data['product_category'] = $category;
		//print_r($data['product_category']);
		$data['content'] = 'products/admin_view_category';
		$data['meta_title'] = 'products';
		$data['meta_description'] = 'products';
		$productListData = ['condition'=>['products.product_category_id'=>$id], 'module'=>'products'];
		$data['categoryWiseProducts'] = Modules::run("products/admin_product_listing", $productListData);

		/*$addressListData = ['condition'=>['address.user_id'=>$id, 'address.type'=>'companies'], 'module'=>'companies'];
		//$this->address_model->set_table('address');
		$data['addressList'] = Modules::run("address/address_listing", $addressListData);*/
		//print_r($productListData);
		//print_r($data['categoryWiseProducts']);
		//$data['product_category'] = $this->category_wise_product_listing();
		//$data['content'] = 'Products/admin_index';
		echo modules::run('templates/admin_template', $data);
	}

	function get_product_list($data = []) {
		//print_r($data);
		$condition = [];
		if(isset($data['condition']))
			$condition = $data['condition'];
		$this->product_model->set_table('products');
		$res = $this->product_model->get_product_details($condition);
		/*echo '<pre>';
		print_r($res);exit;*/
		return $res;
	}

	function getProductWisePackProduct() {
		//$_POST['params'] = 1;
		if(!$this->input->post('params'))
			return;

		$condition = [];
		$condition['pack_products.is_active'] = TRUE;
		$basketId = $this->input->post('params');
		if(!empty($basketId)) {
			$condition['pack_products.basket_id'] = $basketId;
		}
		$this->product_model->set_table("pack_products");
		$productWisePackProducts = $this->product_model->get_product_wise_pack_product($condition);
		$packProductList = [0=>['id' => 0, 'text' => 'Select ']];
		foreach ($productWisePackProducts as $key => $packProduct) {
			$packProductList[$key+1]['id'] = $packProduct['id'];
			$packProductList[$key+1]['text'] = $packProduct['product'];
		}
		/*echo '<pre>';
		print_r($packProductList);
		exit;*/
		echo json_encode($packProductList);
		//print_r($stateList);exit;
		exit;

	}

	function get_product_detail_ajax($productId) {
		$this->product_model->set_table('products');
		$product = $this->product_model->get_product_details(['products.id'=>$productId]);
		echo json_encode($product);
		exit;
	}

	function create_product_code($productId) {
		
		$productCode = "P";
		//print_r($companyDetails['short_code']."/"."Driver");exit;
		if($productId>0 && $productId<=9)
			$productCode .= '000000';
			
		elseif($productId>=10 && $productId<=99)
			$productCode .= '00000';
		elseif($productId>=100 && $productId<=999)
			$productCode .= '0000';
		elseif($productId>=1000 && $productId<=9999)
			$productCode .= '000';
		elseif($productId>=10000 && $productId<=99999)
			$productCode .= '00';
		elseif($productId>=100000 && $productId<=999999)
			$productCode .= '0';

		$productCode .= $productId;
		return $productCode;
	}

	function parent($categoryId = 1){
        //echo '<pre>';
        $result = [0=>'Select'];
        $parents = $this->pktdblib->custom_query('Select * from product_categories where is_active=true and parent_id=0 order by id ASC');
        foreach ($parents as $key => $parent) {
            $result[$parent['id']] = $parent['category_name']; 
            $result = $this->child($parent['id'],'---', $result);
        }

        return $result;
        /*echo '<pre>';
       print_r($result);*/
    }

    function child($parent, $level='--', $result){
        //print_r($level);
        //print_r($result);
        //exit;
        $childs = $this->pktdblib->custom_query('Select * from product_categories where is_active=true and parent_id='.$parent.' order by id ASC');
        foreach ($childs as $key => $child) {
            $result[$child['id']] = $level.$child['category_name']; 
            $result = $this->child($child['id'], '---'.$level, $result);
        }
       return $result;
    }
    
    function category_last_child($parentId=1){
        //echo 'select * from product_categories where id not in(select parent_id from product_categories where is_active=true) and is_active=true and parent_id>'.$parentId.' order by priority';
    	//$category = $this->pktdblib->custom_query('select * from product_categories where parent_id='.$parentId.' and is_active=true');
    	$category = $this->pktdblib->custom_query('select * from product_categories where id not in(select parent_id from product_categories where is_active=true) and is_active=true  order by priority');
    	$child = ['Select'];
    	//echo '<pre>';print_r($category);exit;
    	foreach ($category as $key => $value) {
    		//echo count($value['parent_id']);
    		$child[$value['id']] = $value['category_name'];
    		
    	}
    	//echo '<pre>';print_r($child);exit;
    	return $child;
    }

    function admin_edit_product_details($productId) {
    	//echo $productId;
 		if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
 			//print_r($_POST);exit;
 			$data['values_posted'] = $_POST; 
 			
			$insert = [];
			$update = [];
			$data['values_posted'] = $this->input->post('data');
			
			$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
			//$this->form_validation->set_rules("data[product_details][location]", 'Location', 'required');
			//$this->form_validation->set_rules("data[product_details][area]", 'Area', 'required');
			//$this->form_validation->set_rules("data[product_details][landarea]", 'Landarea', 'required');
			//$this->form_validation->set_rules("data[product_details][status]", 'Status', 'required');
			//if($this->form_validation->run('products')!== FALSE){
				$postData = $this->input->post('data[product_details]');
				//print_r($postData);exit;
				$postData['modified'] = date('Y-m-d H:i:s');
				if($postData['id']){
					$update = $postData;
				}else{
					$postData['created'] = date('Y-m-d H:i:s');
					$insert = $postData;
				}
				$flag = false;
				$this->pktdblib->set_table('product_details');
				if(!empty($insert))
					$flag = $this->pktdblib->_insert($postData);

				if(!empty($update))
					$flag = $this->pktdblib->_update($update['id'], $update);

				if($flag){
					$msg = array('message'=>'Product Details updated Successfully', 'class'=>'alert alert-success' );
					$this->session->set_flashdata('message', $msg);
					redirect('products/editproduct/'.$productId.'?tab=product_images');
				}else{
					$msg = array('message'=>'Some Error Occurred.', 'class'=>'alert alert-danger' );
					$this->session->set_flashdata('message', $msg);
					redirect('products/editproduct/'.$productId.'?tab=product_details');
				}
			/*}else{
				$msg = array('message'=>'Following Error Occurred.'.validation_errors(), 'class'=>'alert alert-danger' );
				$this->session->set_flashdata('message', $msg);
				redirect('products/editproduct/'.$productId.'?tab=product_details');
			}*/
 			
 		}else{
 			$this->pktdblib->set_table('product_details');
 			$productDetails = $this->pktdblib->get_where_custom('product_id', $productId);
 			$data['values_posted']['product_details'] = $productDetails->row_array();
 		}
 		$data['id'] = $productId;
 		
 		//print_r($data['product_images']);
 		$this->load->view('products/admin_edit_product_details', $data);
    }

}
	