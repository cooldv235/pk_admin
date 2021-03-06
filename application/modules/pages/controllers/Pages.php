<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 |--------------------------------------------------------------------------
 |	CONTROLLER SUMMARY AND DATABASE TABLES
 |--------------------------------------------------------------------------
 | 
 |	This is where you can start your admin/manage/password protected stuff.
 | 
 |	Database table structure
 |
 |	Table name(s) - no tables
 |
 |
 */
 
 
class Pages extends MY_Controller {
	function __construct() {

		parent::__construct();

        
        // Check login and make sure email has been verified
        foreach(custom_constants::$protected_pages as $page)
        {   
            if(strpos($this->uri->uri_string, $page) === 0)
            {   
                check_user_login(FALSE);
            }
        }
        $format = $this->config->item( 'response_format' );
        $this->load->model("pages/page_model");
        $this->page_model->set_table('pages');

	}

    function view($slug) {
        //print_r($slug);
        $this->page_model->set_table('pages');
        $pages = $this->page_model->get_where_custom('slug', $slug);
        //print_r($pages);
        $data['pages'] = $pages->row_array();
        $data['meta_title'] = "ERP";
        $data['meta_keyword'] = "ERP";
        $data['title'] = "ERP : Pages";
        $data['meta_description'] = "Erp Page Module";
        
        $data['modules'][] = "pages";
        $data['methods'][] = "page_listing";
        $format = $this->config->item('response_format' );
        //print_r($format);
        echo Modules::run("templates/oxiinc_template", $data);
    }

    function page_listing() {
        
        $this->load->view("pages/index");
        //$this->load->view("admin_panel/login_register");
    }

    function admin_index() {
        $this->page_model->set_table('pages');
        $pages = $this->page_model->get('id desc');
        $data['pages'] = $pages->result_array();
        $data['meta_title'] = "ERP";
        $data['title'] = "ERP : Pages";
        $data['meta_description'] = "Erp Page Module";
        
        $data['modules'][] = "pages";
        $data['methods'][] = "admin_page_listing";
        
        echo Modules::run("templates/admin_template", $data);
    }

	function admin_page_listing() {
		$this->load->view("pages/admin_index");
		//$this->load->view("admin_panel/login_register");
	}

    function admin_add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //echo '<pre>';print_r($_POST);exit;
            $data['value_posted'] = $_POST['data'];
            $this->form_validation->set_rules('data[pages][title]', 'Page Title', 'required|max_length[255]');
            $this->form_validation->set_rules('data[pages][slug]', 'Page Slug', 'required|trim|is_unique[pages.slug]|min_length[3]|max_length[255]');
             $this->form_validation->set_rules('data[pages][content]', 'Page Content', 'required');
            if($this->form_validation->run()!== FALSE) { //echo "hii";
                $error = [];
                //print_r($_FILES);exit;
                $post_data = $this->input->post('data[pages]');
                $featuredImage = '';
                if(!empty($_FILES['featured_image']['name'])) {
                    $profileFileValidationParams = ['file' => $_FILES['featured_image'], 'path'=> '../content/uploads/featured_images/', 'ext' => 'gif|jpg|png|jpeg', 'fieldname' =>'featured_image', 'arrindex' =>'featured_image'];
                    $featuredImage = $this->pktlib->upload_single_file($profileFileValidationParams);
                    //print_r($featuredImage);exit;
                    if(empty($featuredImage['error'])) {
                        $post_data['featured_image'] = $featuredImage['filename'];
                    }
                    else {
                        $error['featured_image'] = $featuredImage['error'];

                    }
                } else {
                    $post_data['featured_image'] = '';
                }
                //print_r($error);exit;
                if (empty($error)) {
                    $post_data['created'] = date('Y-m-d H:i:s');
                    $post_data['modified'] = date('Y-m-d H:i:s');
                    $reg_page = json_decode($this->_register_admin_add($post_data), true);
                    //print_r($reg_page);exit;

                    if($reg_page['status'] === 'success') {
                        $msg = array('message'=> 'Page Created Successfully', 'class' => 'alert alert-success');
                        $this->session->set_flashdata('message', $msg);
                        redirect(custom_constants::edit_page_url."/".$reg_page['id']);
                    }
                    else {
                        $data['form_error'] = $reg_page['msg'];
                    }
                }else{
                    //print_r($error['profile_img']);
                    $msg = array('message'=> 'Error while uploading file'.$error['profile_img'], 'class' => 'alert alert-danger');
                        $this->session->set_flashdata('message', $msg);
                }


            }else{
                $msg = array('message'=> 'Error while uploading file'.validation_errors(), 'class' => 'alert alert-danger');
                $this->session->set_flashdata('message', $msg);
                //echo validation_errors();
            }
             
        }
        
        $data['meta_title'] = "ERP : Page Module";
        $data['title'] = "ERP : Page Module";
        $data['meta_description'] = "New Page";
        /*$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            $(document).on("submit", "#pages", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';*/
        /*$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
            CKEDITOR.replace("editor1");
            $(document).on("submit", "#pages", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';*/
        $data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
             var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#pages", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';
        $data['modules'][] = "pages";
        $data['methods'][] = "admin_add_page";
        
        echo Modules::run("templates/admin_template", $data);
           // }
            
            
    }

    function _register_admin_add($data) {
        
        $this->page_model->set_table("pages");
        $id = $this->page_model->_insert($data);
        
        $page = $this->get_page_details($id);
        //print_r($id);
        return json_encode(["msg" => "Page Created Successfully", "status" => "success", 'id' => $id, 'pages' => $page, 'is_new'=>true ]);
    }

    function edit_page($id=NULL, $post_data = []) {
        if(NULL == $id)
            return false;

        if($this->page_model->_update($id,$post_data))
            return true;
        else
            return false;
    }
    

	function admin_add_page() {
		$this->load->view("pages/admin_add");
		//$this->load->view("admin_panel/login_register");
	}

    function admin_edit($id = NULL) {

    	if($_SERVER['REQUEST_METHOD'] == 'POST') {
            /*print_r($this->input->post('data'));
            exit;*/
    		$this->form_validation->set_rules('data[pages][title]', 'Page Title', 'required|max_length[255]');
            $this->form_validation->set_rules('data[pages][slug]', 'Page Slug', 'required|max_length[255]');
             $this->form_validation->set_rules('data[pages][content]', 'Page Content', 'required');
           
    		if($this->form_validation->run()!== FALSE) {
    			$profileImg = '';
    			$post_data = $data['value_posted']['pages'] = $_POST['data']['pages'];
    			if(!empty($_FILES['featured_image']['name'])) {
    				$profileFileValidationParams = ['file'=>$_FILES['featured_image'], 'path' => '../content/uploads/featured_images/', 'ext' => 'jpg|png|gif|jpeg', 'fieldname' =>'featured_image', 'arrindex' => 'featured_image'];
    				$profileImg = $this->pktlib->upload_single_file($profileFileValidationParams);
    				//print_r($profileImg);exit;
    				if(empty($profileImg['error'])) {
    					$post_data['featured_image'] = $profileImg['filename'];
    					unset($post_data['featured_image2']);
    				}
    				else {
    					$error['featured_image'] = $profileImg['error'];
     				}
    			}
    			else {
    				$post_data['featured_image'] = $post_data['featured_image2'];
    				unset($post_data['featured_image2']);
    			}

    			if(empty($error)) {
                    $post_data['modified'] = date('Y-m-d H:i:s');
    				if($this->edit_page($id, $post_data)) {
    					$msg = array('message' => "Page Update successfully", 'class' => 'alert alert-success fade-in');
    					$this->session->set_flashdata('message', $msg);
    				}
    				else {
    					$msg = array('message' => 'some problem occured while updating', 'class' => 'alert alert-danger fade-in');
    					$this->session->set_flashdata('message', $msg);
    				}
    				redirect(custom_constants::edit_page_url."/".$id);
    			}
    			else {
    				$msg = array('message' => $error, 'class' =>'alert alert-danger fade-in');
    				$this->session->set_flashdata('error', $msg);
    			}
     		} 
     		else {
     			$msg = array('message' => 'some validation error occured', 'class' => 'alert alert-danger fade-in');
     		}

    	}
    	else {
    		$this->page_model->set_table("pages");
    		$data['pages'] = $this->get_page_details($id);
    		$data['value_posted']['pages'] = $data['pages'];
    	}


    	$data['id'] = $id;
    	if(!($this->input->get('tab')))
    		$data['tab'] = 'personal_info';
    	else
    		$data['tab'] = $this->input->get('tab');
        $data['meta_title'] = "Edit Pages";
        $data['title'] = "ERP Edit Pages";
        /*$data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1");
            var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#pages", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
              //return false;
            });
        </script>';*/
        $data['js'][] = '<script type="text/javascript">
            CKEDITOR.replace("editor1",{
                height:400,
                filebrowserUploadUrl:assets_url+"admin_lte/plugins/ckeditor_full/fileupload.php",
            });
             var html = $(".editor1").val();
            CKEDITOR.instances["editor1"].setData(html);
            $(document).on("submit", "#pages", function(){
              $(".editor1").val(CKEDITOR.instances.editor1.getData());
              $(".editor1").show();
            });
        </script>';
        $data['meta_description'] = "Edit Customer";
       	$data['content'] = 'pages/admin_edit';

        echo Modules::run('templates/admin_template', $data);
    }  

    function edit_page_details() {
        $this->load->view("pages/edit_page");
    }

    function get_page_details($id) {
        //echo "reached in Customer module";
        //print_r($id);
        $this->page_model->set_table('pages');
        $customerdetails = $this->page_model->get_where($id);
        return $customerdetails->row_array();
    }

    function admin_view($id=NULL){
        if(NULL==$id){
            redirect('customers');
        }
        $this->page_model->set_table('customers');
        $customer = $this->page_model->get_where($id);
        $data['user'] = $customer->row_array();
        $data['content'] = 'customers/admin_view';
        $data['meta_title'] = 'Customers';
        $data['meta_description'] = 'Customers';
        $addressListData = ['condition'=>['address.user_id'=>$id, 'address.type'=>'customers'], 'module'=>'customers'];
        //$this->address_model->set_table('address');
        $data['addressList'] = Modules::run("address/address_listing", $addressListData);

        $bankAccountListData = ['condition'=>['bank_accounts.user_id'=>$id, 'bank_accounts.user_type'=>'customers'], 'module'=>'customers'];
        //$this->address_model->set_table('address');
        $data['bankAccountList'] = Modules::run("bank_accounts/account_listing", $bankAccountListData);

        /*Documents*/
        $documentListData = ['condition'=>['user_documents.user_id'=>$id, 'user_documents.user_type'=>'customers'], 'module'=>'customers'];
        //$this->address_model->set_table('bank_accounts');
        $data['documentList'] = Modules::run("upload_documents/admin_document_listing", $documentListData);

        $data['otherDetailsList'] = Modules::run('customers/employee_other_details', ['customer_id'=>$id]);

        echo Modules::run("templates/admin_template", $data);
        //$this->templates->admin_template('', $data);
        //print_r($data['employee']);
    }

    /**
     * Validation function. Checks field value isn't a controller name.
     *
     * @access private
     * @param  string : field name
     * @return bool
     */
    function _reserved_word($field)
    {
        $controller = array();

        $this->load->helper('directory');

        $map = directory_map(BASEPATH."application/controllers");

        foreach ($map as $value)
        {

                $filename_array = explode(".", $value);
                if ($filename_array[1] == EXT)
                {

                    //If file extension is php then store filename in array.
                    $controller[] = $filename_array[0];
                }
        }

        if (in_array($this->{$field}, $controller))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    /**
     * Converts the route into a search engine friendly URL
     *
     * @access private
     * @param string : field value
     * @return void
     */
    function _dash_url($field)
    {
        $this->{$field} = dash($this->{$field});
    }

}
