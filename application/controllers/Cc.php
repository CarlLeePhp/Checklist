<?php

class Cc extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // Load Models
        $this->load->model('cc_model');
    }

    function index(){
        $data['message'] = "";

        // when get update, update the sale
        if(isset($_POST['update'])){
            $cc_id = $_POST['update'];
            $cc_name = $_POST['cc_name'];
            $cc_email = $_POST['cc_email'];

            $this->cc_model->update_cc($cc_id, $cc_name, $cc_email);
            $data['message'] = "Information of ".$cc_name." was updated.";
        }
        // when get new, insert a sale
        if(isset($_POST['new'])){
            $cc_name = $_POST['cc_name'];
            $cc_email = $_POST['cc_email'];
            
            $cc_name = trim($cc_name);
            $cc_email = trim($cc_email);

            if($cc_name == '' || $cc_email == '') {
                $data['message'] = 'Name and Email cannot be empty.';
            } else {
                $this->cc_model->add_cc($cc_name, $cc_email);
                $data['message'] = $cc_name." was added.";
            }
        }

        // when get remove, update the sale, set available = no
        if(isset($_POST['remove'])){
            $cc_id = $_POST['remove'];
            $cc_name = $_POST['cc_name'];
            
            $this->cc_model->remove_cc($cc_id);
            $data['message'] = $cc_name." was removed.";
        }
        // get sale to fill the table
        $data['ccs'] = $this->cc_model->get_cc();

        $data['title'] = 'Carbon Copy';
        $this->load->view('templates/header');
        $this->load->view('cc/main', $data);
        $this->load->view('templates/footer');
    }

    function edit_cc($cc_id){
        // find the sale by ID
        $data['cc'] = $this->cc_model->get_cc_id($cc_id);
        $data['title'] = "Carbon Copy Edit";
        $this->load->view('templates/header');
        $this->load->view('cc/edit_cc', $data);
        $this->load->view('templates/footer');
    }

    function remove_cc($cc_id){
        $data['cc'] = $this->cc_model->get_cc_id($cc_id);
        $data['title'] = "Are you sure you want to remove:";

        $this->load->view('templates/header');
        $this->load->view('cc/remove_cc', $data);
        $this->load->view('templates/footer');        
    }
}