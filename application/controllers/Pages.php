<?php
class Pages extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        $this->load->helper('directory');
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
        $this->load->model('cc_model');
        $this->load->model('transporter_model');

        $this->load->helper('form');
        
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


        $data['title'] = 'Check List Main Page';
        $this->load->view('templates/header', $data);
        $this->load->view('pages/main', $data);
        $this->load->view('templates/footer', $data);
    }


    /**
     * AJAX
     */
    // Create a new Boat
    public function new_boat(){
        $dealer_id = $_POST['dealer'];
        $model_id = $_POST['model'];
        $serial = $_POST['serial'];
        $transporter_id = $_POST['transporter'];
        
        // Add a new boat 
        $this->boat_model->add_boat($dealer_id, $model_id, $transporter_id);

        // get all CLTP and max boat id
        $items = $this->checklist_model->get_item($model_id);
        $max_id = $this->boat_model->get_max_boat_id();
        
        foreach ($items as $item){
            $cl_des = $item['CLTP_DES'];
            $cl_type = $item['TYPE'];
            $this->list_model->add_item($max_id['MAX_ID'], $cl_des, $cl_type);
        }

        // insert the serial and create a folder
        $this->boat_model->update_boat($max_id['MAX_ID'], $model_id, $serial);

        // get the name of the dealer
        $data['dealer']=$this->dealer_model->get_dealer_id($dealer_id);
        $dealer_name = $data['dealer']['DEALER_NAME'];
        $dealer_name = str_replace(' ', '_',$dealer_name);
        $my_path = "/var/www/html/dealers/".$dealer_name."/".$serial;
        mkdir($my_path);

        // Return checklist
        $checklist = $this->list_model->get_item($max_id['MAX_ID']);
        $result = json_encode($checklist);
        echo $result;

    }

    // update check list
    public function update_list(){
        $cl_id = $_POST['cl_id'];
        $checked_str = $_POST['checked'];
        $checked = 0;
        if($checked_str=="true"){
            $checked = 1;
        }
        
        $this->list_model->update_check($cl_id, $checked);
       
    }

    // update missed parts for the new boat
    public function update_missed(){
        $max_id = $this->boat_model->get_max_boat_id();
        $missed = $_POST['missed'];
        $additional = $_POST['additional'];

        $this->boat_model->update_missed($max_id['MAX_ID'], $missed);
        $this->boat_model->update_additional($max_id['MAX_ID'], $additional);
    }
    // return Boats IDs
    public function getBoat($dealerID){
        $data = $this->pages_model->get_boat($dealerID);
        $result = "";
        foreach ($data as $item){
            $result = $result.$item['BOAT_ID'].",";
            $result = $result.$item['MODEL'].",";
            $result = $result.$item['BOAT_SERIAL'].",";
        }
        $result = substr($result, 0, strlen($result) - 1);
        echo $result;
    }

    // update serial number
    public function updateSerial($boat_id, $serial){
        $this->pages_model->update_serial($boat_id, $serial);
        // echo "Serial: ".$serial." for boat id:".$boat_id;
    }

    /**
     * Get uploaded files
     */
    public function get_file(){

        $dealer_id = $_POST['dealer_id'];
        $serial = $_POST['serial'];

        // get the dealer information
        $data['dealer']=$this->dealer_model->get_dealer_id($dealer_id);
        $dealer_name = $data['dealer']['DEALER_NAME'];
        $dealer_name = str_replace(' ', '_',$dealer_name);

        $data['message'] = "";
        $config['upload_path']      = '/var/www/html/dealers/'.$dealer_name."/".$serial."/";
        $config['allowed_types']      = 'jpg|jpeg';
        $config['max_size']      = 8000;
        $config['max_width']      = 3840;
        $config['max_height']      = 3840;
        /* test can it get the file
        if(isset($_FILES['user_file'])){
            echo "I got your file";
        } else {
            echo "I did not get your file";
        }
        */
        
        $this->load->library('upload', $config);
        if(! $this->upload->do_upload('user_file')) {
            echo "Upload Fail";
            
        } else {
            echo "Upload Successful";
        }
    }

    public function upload_screenshot(){
        $data['message'] = "Nothing happen";
    
        // get screen shot and save it under dealers, named email.png
        $img_data = $_POST['image'];
        $file_name = "/var/www/html/dealers/email.png";
        
        $img_png = explode(",", $img_data);
        $img_png = str_replace(' ','+',$img_png);
        $file = fopen($file_name, "wb");
        fwrite($file, base64_decode($img_png[1]));
        fclose($file);
        
    }


    // Create a HTML content email
    public function create_email(){
        $message = "Nothing";
        $dealer_id = $_POST['dealer_id'];
        $serial = $_POST['serial'];
        $model_id = $_POST['model_id'];
        $email_type = $_POST['email_type'];  // string, add to the start of the subject (new or updated)

        // get the dealer / sale / boat information
        $data['dealer']=$this->dealer_model->get_dealer_id($dealer_id);
        $data['sale']=$this->sale_model->get_sale_id($data['dealer']['SALE_ID']);
        $data['boat']=$this->boat_model->get_boat_serial($serial);
        $data['boat_model']=$this->boatmodel_model->get_model_id($model_id);
        $data['check_list']=$this->list_model->get_item($data['boat']['BOAT_ID']);
        $data['transporter']=$this->transporter_model->get_transporter_id($data['boat']['TP_ID']);
        $dealer_name = str_replace(' ', '_',$data['dealer']['DEALER_NAME']);
        $attach_path = '/var/www/html/dealers/'.$dealer_name.'/'.$serial.'/';

        //$message = $data['dealer']['DEALER_NAME']."--".$data['sale']['SALE_EMAIL']."--".$data['boat_model']['MODEL'];
        // send email with this information
        
        $email_content = '<!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <style>
                table {
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                tr.OPT {
                    background-color: #ebebeb;
                }
            </style>
        </head>
        <body>';
        $email_content = $email_content.'<a href="'.base_Url().'index.php/review/specific/'.$data['boat']['BOAT_ID'].'">Review Page</a>';
        $email_content = $email_content.'<h2>Dealer: '.$data['dealer']['DEALER_NAME'].'</h2>';
        $email_content = $email_content.'<h2>Serial: '.$serial.'</h2>';
        $email_content = $email_content.'<h2>Model: '.$data['boat_model']['MODEL'].'</h2>';
        $email_content = $email_content.'<h2>Transporter: '.$data['transporter']['TP_NAME'].'</h2>';

        // Check list table
        $email_content = $email_content.'<table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Included</th>
            </tr> 
        </thead>
        <tbody>';

        foreach($data['check_list'] as $item){
            if($item['TYPE'] == 'OPT') {
                $email_content = $email_content.'<tr class="OPT">';
            } else {
                $email_content = $email_content.'<tr>';
            }
            $email_content = $email_content.'<td>'.$item['CL_DES'].'</td>';
                if($item['CHECKED']>0){
                    $email_content = $email_content.'<td>YES</td>';
                } else {
                    $email_content = $email_content.'<td>NO</td>';
                }
                
            
                $email_content = $email_content.'</tr>';
	}

        $email_content = $email_content.'</tbody></table>';
        $email_content = $email_content.'<h3>Missing Items: '.$data['boat']['MISSED'].'</h3>';
        $email_content = $email_content.'<h3>Additional Items: '.$data['boat']['ADDITIONAL'].'</h3>';
            
        $email_content = $email_content.'</body></html>';
        
        
        /**
         * Development config
         */
        /*
        $config['smtp_host'] = 'smtp.google.com';
        $config['smtp_user'] = 'kunhuilearners1@gmail.com';
        $config['smtp_pass'] = 'diligence';
        $config['smtp_port'] = '587';
        */

        /**
         * Production config
         */
        
        $config['smtp_host'] = 'Relay.focuscloud.email';
        $config['smtp_user'] = 'dispatch-website@stabicraft.com';
        $config['smtp_pass'] = 'b0atS)Nline';
	    $config['smtp_port'] = '587';
        

        $config['smtp_crypto'] = 'tls';
        $config['mailtype'] = 'html';

        $this->email->initialize($config);


        // development
        // $this->email->from('kunhuilearners1@gmail.com', 'Carl Lee');

        // Production
         $this->email->from('Dispatch-website@stabicraft.com', 'Dispatch-website');
        
        $this->email->to($data['sale']['SALE_EMAIL']);

        // to multiple cc
        $data['ccs'] = $this->cc_model->get_cc();
        $receivers = array();
        foreach ($data['ccs'] as $cc){
            array_push($receivers, $cc['CC_EMAIL']); 
        }
        $this->email->cc($receivers);
        
        $this->email->subject($email_type.' Checklist for '.$serial);
        $this->email->message($email_content);

        // get all pictures as attachments
        
        // Only attach the first picture
        $attaches = directory_map($attach_path);

        // sort the attaches by DateTimeOriginal
        $mapLength = count($attaches);
                
                
        $tempName = "";
        for($i=1; $i<$mapLength; $i++){
            for($j=0; $j<$mapLength-$i;$j++){
                $pathOne = $attach_path.$attaches[$j];
                $pathTwo = $attach_path.$attaches[$j+1];

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
                    $temp = $attaches[$j];
                    $attaches[$j] = $attaches[$j+1];
                    $attaches[$j+1] = $temp;
                    
                }
            } // inner loop
        } // outer loop

        //foreach($attaches as $item){
        //    $this->email->attach($attach_path.$item);
	    //}
        $this->email->attach($attach_path.$attaches[0]);
        
        if($this->email->send()){
            $message = "Email sent successfully";
        } else {
            $message = "Email sent failed";
        }

        echo $message;
    }

}
