<?php
class Review extends CI_Controller {
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

        $data['isSpecific'] = 0;
        $data['boat_id'] = 0;

        $data['title'] = 'Review';
        $this->load->view('review/header', $data);
        $this->load->view('review/main', $data);
        $this->load->view('review/footer', $data);

    }

    // show a specific one
    public function specific($boat_id){
        // Default Message
        $data['message'] = "";

        // get dealer ID from database
        $data['dealers'] = $this->dealer_model->get_dealer();
        $data['models'] = $this->boatmodel_model->get_model();
        $data['boats'] = $this->boat_model->get_boats();

        $data['isSpecific'] = 1;
        
        /**
         * Pass the boat id, then do the rest by ajax, as what it has done.
         */
        $data['boat_id'] = $boat_id;


        $data['title'] = 'Review';
        $this->load->view('review/header', $data);
        $this->load->view('review/main', $data);
        $this->load->view('review/footer', $data);
    }
    /**
     * AJAX
     * Sharing the methods from Updateit Controller
     */
    public function get_boat(){
        $boat_id = $_POST['boat_id'];

        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        $result = json_encode($data['boat']);
        
        echo $result;
    }

    public function get_transporter(){
        $boat_id = $_POST['boat_id'];

        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        $data['transporter'] = $this->transporter_model->get_transporter_id($data['boat']['TP_ID']);
        $result = json_encode($data['transporter']);
        
        echo $result;
    }
    
    public function get_pictures(){
        $boat_id = $_POST['boat_id'];

        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        $data['dealer'] = $this->dealer_model->get_dealer_id($data['boat']['DEALER_ID']);
        $dealer_name = $data['dealer']['DEALER_NAME'];
        $serial = $data['boat']['BOAT_SERIAL'];
        $dealer_name = str_replace(' ', '_',$dealer_name);
        $path = '/var/www/html/dealers/'.$dealer_name.'/'.$serial.'/';
        $map = directory_map($path);

        // sort the map
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


        for($x = 0; $x < count($map); $x ++){
            $map[$x] = base_Url().'dealers/'.$dealer_name.'/'.$serial.'/'.$map[$x];
        }
        $result = json_encode($map);
        
        echo $result;
        
    }

    public function get_serial(){
        $boat_id = $_POST['boat_id'];

        $data['boat'] = $this->boat_model->get_boat_id($boat_id);
        $data['boats'] = $this->boat_model->get_boat($data['boat']['DEALER_ID']);
        $result = json_encode($data['boats']);
      
        echo $result;
    }
}
