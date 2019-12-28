<?php
/* Functions
 * 1. List all Dealers. => index
 * 2. 
 * AJAX:
 * 1. return check list item as per boat model ID
 */

class Boat extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // Load Models
        
        $this->load->model('sale_model');

        $this->load->model('dealer_model');
        $this->load->model('boatmodel_model');
        $this->load->model('boat_model');
        $this->load->model('checklist_model');
        $this->load->model('list_model');
    }

    function index(){
        $data['message'] = "";
        // when get new, insert a boat; copy a set of CLTP to CL as per model_id
        if(isset($_POST['new'])){
            $dealer_id = $_POST['dealer'];
            $model_id = $_POST['model'];
        
            $this->boat_model->add_boat($dealer_id, $model_id);
            $data['message'] = "The boat was added.";
            
            // get all CLTP and max boat id
            $items = $this->checklist_model->get_item($model_id);
            $max_id = $this->boat_model->get_max_boat_id();
            
            foreach ($items as $item){
                $cl_des = $item['CLTP_DES'];
                $cl_type = $item['TYPE'];
                $this->list_model->add_item($max_id['MAX_ID'], $cl_des, $cl_type);
            }
        }
        // when get update, update the boat
        // when serial is empty do nothing
        // else the serial in the database is empty -> create a folder
        // 
        if(isset($_POST['update'])){

            $boat_id = $_POST['update'];
            $model_id = $_POST['model'];
            $serial = $_POST['serial'];
            $serial = trim($serial);

            // get boat by id before update it
            $data['boat'] = $this->boat_model->get_boat_id($boat_id);

            $this->boat_model->update_boat($boat_id, $model_id, $serial);
            $data['message'] = "The boat (ID: ".$boat_id.") was updated.";

            
            if ($serial != ""){
               
                if($data['boat']['BOAT_SERIAL'] == 0 || $data['boat']['BOAT_SERIAL'] == null){
                    // create a folder
                    $my_path = "/var/www/html/dealers/".$data['boat']['DEALER_ID']."/".$serial;
                    mkdir($my_path);
                } else if($data['boat']['BOAT_SERIAL'] <> $serial){
                    // rename the folder
                    $old_name = "/var/www/html/dealers/".$data['boat']['DEALER_ID']."/".$data['boat']['BOAT_SERIAL'];
                    $new_name = "/var/www/html/dealers/".$data['boat']['DEALER_ID']."/".$serial;
                    rename($old_name, $new_name);
                }
            }
        }


        // when get remove, update the sale, set available = no
        if(isset($_POST['remove'])){
            $boat_id = $_POST['remove'];

            
            $this->boat_model->remove_boat($boat_id);
            $data['message'] = "The boat (ID: ".$boat_id.") was removed.";
        }
        // get dealers to fill the table
        $data['dealers'] = $this->dealer_model->get_dealer();
        $data['models'] = $this->boatmodel_model->get_model();

        $data['title'] = 'Boats Mangement Page';
        $this->load->view('templates/header');
        $this->load->view('boat/main', $data);
        $this->load->view('templates/footer');
    }

    function edit_boat($boat_id){
        // find the boat by ID
        $data['boat'] = $this->boat_model->get_boat_id($boat_id);

        // get dealer by ID
        $data['dealer'] = $this->dealer_model->get_dealer_id($data['boat']['DEALER_ID']);

        // get boat model by model_id
        $data['model'] = $this->boatmodel_model->get_model_id($data['boat']['BOAT_MODEL']);

        // get all available models for dropdown
        $data['models'] = $this->boatmodel_model->get_model();

        $data['title'] = "Boat Edit";
        $this->load->view('templates/header');
        $this->load->view('boat/edit_boat', $data);
        $this->load->view('templates/footer');
    }

    function remove_boat($boat_id){
        // find the boat by ID
        $data['boat'] = $this->boat_model->get_boat_id($boat_id);

        // get dealer by ID
        $data['dealer'] = $this->dealer_model->get_dealer_id($data['boat']['DEALER_ID']);

        // get boat model by model_id
        $data['model'] = $this->boatmodel_model->get_model_id($data['boat']['BOAT_MODEL']);

        // get all available models for dropdown
        $data['models'] = $this->boatmodel_model->get_model();

        $data['title'] = "Are you sure you want to remove:";

        $this->load->view('templates/header');
        $this->load->view('boat/remove_boat', $data);
        $this->load->view('templates/footer');        
    }

    /**
     * AJAX
     */
    // return boats for a dealer

    function get_boat(){
        $dealer_id = $_POST['dealer_id'];
        $data = $this->boat_model->get_boat($dealer_id);
        $result = "";
        foreach ($data as $item){
            $result = $result.$item['BOAT_ID'].",";
            $result = $result.$item['MODEL'].",";
            $result = $result.$item['BOAT_SERIAL'].",";
        }
        $result = substr($result, 0, strlen($result) - 1);
        echo $result;
    }
}