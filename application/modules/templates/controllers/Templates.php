<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 |--------------------------------------------------------------------------
 |	CONTROLLER SUMMARY AND DATABASE TABLES
 |--------------------------------------------------------------------------
 | 
 |	Templates is used to put together the main structure of the HTML view. It
 |	calls head, header, content and footer in most cases. Other items can been
 |	called and used. Each part can be dynamic but content is loaded through
 |	modules and methods.
 |
 |	Database table structure
 |
 |	No table
 |
 */

class Templates extends MY_Controller
{
	private $meta_module;
	private $id;
	private $templateType;
	function __construct() {
		parent::__construct();
		// change id in case of id other than 1
		$this->id = 1;
		$this->templateType = 'companies';
		
	}

	function admin_template($data) {
	    
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		
		$this->load->view('templates/admin/head', $data);
		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/content', $data);
		$this->load->view('templates/admin/footer', $data);
	}
	
	function admin_template_tab($data) {
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		$this->load->view('templates/admin/admin_template_head', $meta);
		$this->load->view('templates/admin/admin_template_header', $data);
		$this->load->view('templates/admin/admin_template_tab_content', $data);
		$this->load->view('templates/admin/admin_template_footer', $data);
	}

	function login_template($data) {
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		
		$this->load->view('templates/login/head', $meta);

		//$this->load->view('templates/login/header', $data);
		$this->load->view('templates/login/content', $data);
		$this->load->view('templates/login/footer', $data);
	}
	
	function error_template($data) {
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		
		$this->load->view('templates/error/error_template_head', $meta);

		$this->load->view('templates/error/error_template_header', $data);
		$this->load->view('templates/error/error_template_content', $data);
		$this->load->view('templates/error/error_template_footer', $data);
	}

	function obaju_home_template($data = []) {
		
			Modules::run('templates/admin_template', $data);
		}

	function obaju_inner_template($data = []) {
			Modules::run('templates/admin_template', $data);
		
	}

	function templateAddress($companyId = 1, $type = 'companies'){
		//echo $companyId." ".$type;exit;
		$this->load->model('address/address_model');
		//$this->pktdblib->set_table('address');
		$address = $this->address_model->userBasedDefaultAddress($companyId, $type);

		//print_r($address);
		return $address;
	}

	function email_frontTemplate($data = []) {
		$companyData = ['id'=>$this->id];
		$data['websiteInfo'] = Modules::run('companies/get_company_details', $companyData);

		$data['websiteAddress'] = $this->templateAddress($this->id, $this->templateType);
		$this->load->view('templates/email/template_1', $data);
		$this->load->view('templates/email/footer', $data);
	}

	function oxiinc_template($data = []) {
		$companyData = ['id'=>$this->id];
		$data['websiteInfo'] = Modules::run('companies/get_company_details', $companyData);
		//print_r($data['websiteInfo']);
		$data['websiteAddress'] = $this->templateAddress($this->id, $this->templateType);
		/*$data['js'][] = '<script type="text/javascript">
			$(document).on("click", ".main-navigation li a span", function(event){
				event.preventDefault();
				//alert("hii");
				return false;
			})
		</script>';*/
		//print_r($data['websiteInfo']);exit;
		$this->load->view('templates/oxiinc/head', $data);
		$this->load->view('templates/oxiinc/header', $data);
		$this->load->view('templates/oxiinc/content', $data);
		$this->load->view('templates/oxiinc/footer', $data);
	}

	function news_template($data) {
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		$this->load->view('templates/news/head', $meta);
		$this->load->view('templates/news/header', $data);
		$this->load->view('templates/news/content_inner', $data);
		$this->load->view('templates/news/footer', $data);
	}
	
	function subscribe(){
    	if($_SERVER['REQUEST_METHOD'] == 'POST') {
    		echo json_encode($_POST);
    		exit;
    		
    	}else{
    		echo json_encode(['status'=>false, 'message'=>'Invalid Input']);
    		exit;
    	}
    
    }
}
