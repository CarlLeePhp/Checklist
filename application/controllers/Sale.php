<?php
/* Functions
 * 1. List all boat models. => index
 * 2. 
 * AJAX:
 * 1. return check list item as per boat model ID
 */

class Sale extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // Load Models
        $this->load->model('sale_model');
    }

    function index(){
        $data['message'] = "";

        // when get update, update the sale
        if(isset($_POST['update'])){
            $sale_id = $_POST['update'];
            $sale_name = $_POST['sale_name'];
            $sale_email = $_POST['sale_email'];

            $this->sale_model->update_sale($sale_id, $sale_name, $sale_email);
            $data['message'] = "Information of ".$sale_name." was updated.";
        }
        // when get new, insert a sale
        if(isset($_POST['new'])){
            $sale_name = $_POST['sale_name'];
            $sale_email = $_POST['sale_email'];
            
            $sale_name = trim($sale_name);
            $sale_email = trim($sale_email);

            if($sale_name == '' || $sale_email == '') {
                $data['message'] = 'Name and Email cannot be empty.';
            } else {
                $this->sale_model->add_sale($sale_name, $sale_email);
                $data['message'] = $sale_name." was added.";
            }
        }

        // when get remove, update the sale, set available = no
        if(isset($_POST['remove'])){
            $sale_id = $_POST['remove'];
            $sale_name = $_POST['sale_name'];
            
            $this->sale_model->remove_sale($sale_id);
            $data['message'] = $sale_name." was removed.";
        }
        // get sale to fill the table
        $data['sales'] = $this->sale_model->get_sale();

        $data['title'] = 'Salesperson Page';
        $this->load->view('templates/header');
        $this->load->view('sale/main', $data);
        $this->load->view('templates/footer');
    }

    function edit_sale($sale_id){
        // find the sale by ID
        $data['sale'] = $this->sale_model->get_sale_id($sale_id);
        $data['title'] = "Sale Edit";
        $this->load->view('templates/header');
        $this->load->view('sale/edit_sale', $data);
        $this->load->view('templates/footer');
    }

    function remove_sale($sale_id){
        $data['sale'] = $this->sale_model->get_sale_id($sale_id);
        $data['title'] = "Are you sure you want to remove:";

        $this->load->view('templates/header');
        $this->load->view('sale/remove_sale', $data);
        $this->load->view('templates/footer');        
    }

    /**
     * AJAX
     */
}