<?php
/* Functions
 * 1. List all Dealers. => index
 * 2. 
 * AJAX:
 * 1. return check list item as per boat model ID
 */

class Dealer extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // Load Models
        $this->load->model('dealer_model');
        $this->load->model('sale_model');
    }

    function index(){
        $data['message'] = "";

        // when get update, update the dealer
        if(isset($_POST['update'])){

            $dealer_id = $_POST['update'];
            $dealer = $_POST['dealer'];
            $sale_id = $_POST['sale'];

            $dealer = trim($dealer);
            $shrink = str_replace(' ', 'x', $dealer);
            if($dealer==""){
                $data['message'] = "Dealer name cannot be empty";
            }
            else if(ctype_alpha($shrink)){
                $dealer_old = $this->dealer_model->get_dealer_id($dealer_id);
                $dealer_old['DEALER_NAME'] = str_replace(' ', '_', $dealer_old['DEALER_NAME']);
                $this->dealer_model->update_dealer($dealer_id, $dealer, $sale_id, $dealer_old['DEALER_NAME']);
                $data['message'] = "Information of ".$dealer." was updated.";
            }
            
            else {
                $data['message'] = "Only letters are available for dealer name";
            }

            
        }
        // when get new, insert a sale; and create a folder
        if(isset($_POST['new'])){
            $dealer = $_POST['dealer'];
            $sale_id = $_POST['sale'];
            $dealer = trim($dealer);
            $shrink = str_replace(' ', 'x', $dealer);
            if($dealer==""){
                $data['message'] = "Dealer name cannot be empty";
            }
            else if(ctype_alpha($shrink)){
                $this->dealer_model->add_dealer($dealer, $sale_id);
                $data['message'] = $dealer." was added.";
            }
            
            else {
                $data['message'] = "Only letters are available for dealer name";
            }
        }

        // when get remove, update the sale, set available = no
        if(isset($_POST['remove'])){
            $dealer_id = $_POST['remove'];
            $dealer = $_POST['dealer'];
            
            $this->dealer_model->remove_dealer($dealer_id);
            $data['message'] = $dealer." was removed.";
        }
        // get dealers to fill the table
        $data['dealers'] = $this->dealer_model->get_dealer();
        $data['sales']=$this->sale_model->get_sale();

        $data['title'] = 'Dealer Mangement Page';
        $this->load->view('templates/header');
        $this->load->view('dealer/main', $data);
        $this->load->view('templates/footer');
    }

    function edit_dealer($dealer_id){
        // find the dealer by ID
        $data['dealer'] = $this->dealer_model->get_dealer_id($dealer_id);
        $data['sales']=$this->sale_model->get_sale();
        $data['title'] = "Dealer Edit";
        $this->load->view('templates/header');
        $this->load->view('dealer/edit_dealer', $data);
        $this->load->view('templates/footer');
    }

    function remove_dealer($dealer_id){
        $data['dealer'] = $this->dealer_model->get_dealer_id($dealer_id);
        $data['sales']=$this->sale_model->get_sale();
        $data['title'] = "Are you sure you want to remove:";

        $this->load->view('templates/header');
        $this->load->view('dealer/remove_dealer', $data);
        $this->load->view('templates/footer');        
    }

    /**
     * AJAX
     */

}