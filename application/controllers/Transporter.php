<?php
/* Functions
 * 
 */

class Transporter extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // Load Models
        $this->load->model('transporter_model');
    }

    function index(){
        $data['message'] = "";

        // when get update, update the sale
        if(isset($_POST['update'])){
            $id = $_POST['update'];
            $name = $_POST['name'];

            $this->transporter_model->update_transporter($id, $name);
            $data['message'] = "Information of ".$name." was updated.";
        }
        // when get new, insert a sale
        if(isset($_POST['new'])){
            $name = $_POST['name'];
            
            $name = trim($name);

            if($name == '') {
                $data['message'] = 'Name cannot be empty.';
            } else {
                $this->transporter_model->add_transporter($name);
                $data['message'] = $name." was added.";
            }
        }

        // when get remove, update the sale, set available = no
        if(isset($_POST['remove'])){
            $id = $_POST['remove'];
            $name = $_POST['name'];
            
            $this->transporter_model->remove_transporter($id);
            $data['message'] = $name." was removed.";
        }
        // get transporter to fill the table
        $data['transporters'] = $this->transporter_model->get_transporter();

        $data['title'] = 'Transporter Page';
        $this->load->view('templates/header');
        $this->load->view('transporter/main', $data);
        $this->load->view('templates/footer');
    }

    function edit($id){
        // find the transporter by ID
        $data['transporter'] = $this->transporter_model->get_transporter_id($id);
        $data['title'] = "Transporter Edit";
        $this->load->view('templates/header');
        $this->load->view('transporter/edit', $data);
        $this->load->view('templates/footer');
    }

    function remove($id){
        $data['transporter'] = $this->transporter_model->get_transporter_id($id);
        $data['title'] = "Are you sure you want to remove:";

        $this->load->view('templates/header');
        $this->load->view('transporter/remove', $data);
        $this->load->view('templates/footer');        
    }

    /**
     * AJAX
     */
}