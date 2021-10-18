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
 
 
class Admin_Panel extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		// Check login and make sure email has been verified
		check_user_login(FALSE);
		//$setup = $this->setup();
	}

	function setup(){
		$companies = Modules::run('companies/setup');
		return TRUE;
	}

    function index() {
		$data['user_id'] = $this->session->userdata['user_id'];
		$data['username'] = $this->session->userdata['username'];
		$data['account_type'] = $this->session->userdata['account_type'];
		$data['logged_in_since'] = $this->session->userdata['logged_in_since'];
		
		$data['meta_title'] = "Admin Panel";
		$data['meta_description'] = "Welcome to the admin panel";
		$data['employees'] = Modules::run('employees/admin_employee_listing');		
		/*if((NULL!==$this->session->userdata('roles')) && in_array(1, $this->session->userdata('roles'))){
            	redirect('#');
        }*/
		//echo 1; exit;
		$data['modules'][] = "admin_panel";
		$data['methods'][] = "view_admin_panel_default";
		
		echo Modules::run("templates/admin_template", $data);
    }
	
	function view_admin_panel_default() {
		$this->load->view("admin_panel/admin_panel_default");
		//$this->load->view("admin_panel/login_register");
	}
}
