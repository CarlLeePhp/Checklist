<?php
class Updateit extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        // email library
        $this->load->library('email');
        // Load Models
        $this->load->model('pages_model');
        $this->load->model('list_model');
        $this->load->model('boatmodel_model');
        $this->load->model('boat_model');
        $this->load->model('checklist_model');
        $this->load->model('dealer_model');
        $this->load->model('sale_model');
        $this->load->model('transporter_model');

        $this->load->helper('form');
        $this->load->helper('directory');
        
    }
    
    // index
    public function index(){
        // Default Message
        $data['message'] = "";
        
        // get dealer ID from database
        $data['dealers'] = $this->dealer_model->get_dealer();
        $data['models'] = $this->boatmodel_model->get_model();
        $data['boats'] = $this->boat_model->get_boats();
        $data['transporters'] = $this->transporter_model->get_transporter();

        $data['title'] = 'Update';
        $this->load->view('templates/header', $data);
        $this->load->view('updateit/main', $data);
        $this->load->view('templates/footer', $data);

    }

    /**
     * AJAX
     */
    // Return all boats for a dealer
    public function get_boats(){
        $dealer_id = $_POST['dealer_id'];

        $data = $this->boat_model->get_boat($dealer_id);

        
        $result = json_encode($data);
        
        echo $result;
    }

    public function get_checklist(){
        $boat_id = $_POST['boat_id'];
        // Return checklist
        $checklist = $this->list_model->get_item($boat_id);
        $result = json_encode($checklist);
        echo $result;
    }
    
    public function get_missed_parts(){
        $boat_id = $_POST['boat_id'];
        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        echo $data['boat']['MISSED'];
    }

    public function get_additional_items(){
        $boat_id = $_POST['boat_id'];
        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        echo $data['boat']['ADDITIONAL'];
    }

    public function get_chdate(){
        $boat_id = $_POST['boat_id'];
        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        echo $data['boat']['CHDATE'];
    }

    public function get_pictures(){
        $dealer_name = $_POST['dealer_name'];
        $dealer_name = str_replace(' ', '_',$dealer_name);
        $serial = $_POST['serial'];
        $path = '/var/www/html/dealers/'.$dealer_name.'/'.$serial.'/';
        $map = directory_map($path);

        // sort the map by DateTimeOriginal
        $mapLength = count($map);
        
        
        $tempName = "";
        for($i=1; $i<$mapLength; $i++){
            for($j=0; $j<$mapLength-$i;$j++){
                $pathOne = $path.$map[$j];
                $pathTwo = $path.$map[$j+1];
    
                $exifOne = exif_read_data($pathOne, 0, true);
                foreach($exifOne as $key => $section){
                    foreach($section as $name => $val){
                        if($name == 'DateTimeOriginal'){
                            $datetimeOne = $val;
                        }
                    }
                }
        
                $exifTwo = exif_read_data($pathTwo, 0, true);
                foreach($exifTwo as $key => $section){
                    foreach($section as $name => $val){
                        if($name == 'DateTimeOriginal'){
                            $datetimeTwo = $val;
                        }
                    }
                }
                
                if($datetimeOne > $datetimeTwo){
                    $temp = $map[$j];
                    $map[$j] = $map[$j+1];
                    $map[$j+1] = $temp;
                    
                }
            } // inner loop
        } // outer loop

        $result = json_encode($map);
        echo $result;
    }

    public function remove_picture(){
        $pic_src = $_POST['pic_src'];
        // Development & Production Environment
        // $pic_src = str_replace('http://localhost/', '/var/www/html/', $pic_src);
        $pic_src = str_replace('http://192.168.10.20/', '/var/www/html/', $pic_src);
        unlink($pic_src);
    }

    public function update_missed(){
        $boat_id = $_POST['boat_id'];
        $missed = $_POST['missed'];

        $this->boat_model->update_missed($boat_id, $missed);
        echo 'Missed parts information was updated successfully';
    }

    public function update_additional(){
        $boat_id = $_POST['boat_id'];
        $additional = $_POST['additional'];

        $this->boat_model->update_additional($boat_id, $additional);
        echo 'Additional information was updated successfully';
    }

    public function update_transporter(){
        $boat_id = $_POST['boat_id'];
        $transporter = $_POST['transporter'];

        $this->boat_model->update_transporter($boat_id, $transporter);
        echo 'Transporter was updated successfully';
    }

    public function update_chdate(){
        $boat_id = $_POST['boat_id'];
        $data['boat'] = $this->boat_model->update_chdate($boat_id);
        echo 'Success';
    }

}
