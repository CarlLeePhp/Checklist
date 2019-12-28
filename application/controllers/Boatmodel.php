<?php
/* Functions
 * 1. List all boat models. => index
 * 2. 
 * AJAX:
 * 1. return check list item as per boat model ID
 */

class Boatmodel extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // Load Models
        $this->load->model('boatmodel_model');
    }

    function index(){
        $data['message'] = "";

        // when get update, update the boat model
        if(isset($_POST['update'])){
            $model_id = $_POST['update'];
            $model = $_POST['BoatModel'];

            $this->boatmodel_model->update_model($model_id, $model);
            $data['message'] = $model." was updated.";
        }
        // when get remove, set available = no
        if(isset($_POST['remove'])){
            $model_id = $_POST['remove'];
            $model = $_POST['BoatModel'];

            $this->boatmodel_model->remove_model($model_id);
            $data['message'] = $model." was removed.";
        }
        // when get new, add a new model
        if(isset($_POST['new'])){
            $new_model = $_POST['BoatModel'];
        
            $this->boatmodel_model->add_model($new_model);
            $data['message'] = $new_model." was added.";
        }
        // get all boat model to fill the dropdown
        $data['models'] = $this->boatmodel_model->get_model();

        $data['title'] = 'Boat Model Page';
        $this->load->view('templates/header');
        $this->load->view('boatmodel/main', $data);
        $this->load->view('templates/footer');
    }

    function edit_model($model_id){
        // find the boat model by ID
        $data['boat_model'] = $this->boatmodel_model->get_model_id($model_id);
        $data['title'] = "Boat Model Edit";
        $this->load->view('templates/header');
        $this->load->view('boatmodel/edit_model', $data);
        $this->load->view('templates/footer');
    }

    function remove_model($model_id){
        // find the boat model by ID
        $data['boat_model'] = $this->boatmodel_model->get_model_id($model_id);
        $data['title'] = "Are you sure you want to remove:";
        $this->load->view('templates/header');
        $this->load->view('boatmodel/remove_model', $data);
        $this->load->view('templates/footer');
    }

    /**
     * AJAX
     */

    // add a new boat model, could be removed
    function add_model(){
        $new_model = $_POST['new_model'];
        
        $this->boatmodel_model->add_model($new_model);

    }
}