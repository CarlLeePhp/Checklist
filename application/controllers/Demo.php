<?php


class Demo extends CI_Controller {
    function __construct() {
		parent::__construct();
		
		// Load url helper
        $this->load->helper('url');
        $this->load->helper('directory');
        // Load Models
        $this->load->helper('form');
    }

    

    public function index(){
        $data['attaches']=directory_map('/var/www/html/dealers/Jump_N_Beef/123456789/');
        $data['theLength'] = count($data['attaches']);
        
        $data['messages'] = "";
        $tempName = "";
        for($i=1; $i<$data['theLength']; $i++){
            for($j=0; $j<$data['theLength']-$i;$j++){
                $pathOne = '/var/www/html/dealers/Jump_N_Beef/123456789/'.$data['attaches'][$j];
                $pathTwo = '/var/www/html/dealers/Jump_N_Beef/123456789/'.$data['attaches'][$j+1];
    
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
                    $temp = $data['attaches'][$j];
                    $data['attaches'][$j] = $data['attaches'][$j+1];
                    $data['attaches'][$j+1] = $temp;
                    $data['messages'] = $data['messages'].'big:';
                } else {
                    $data['messages'] = $data['messages'].'small:';
                }
            } // inner loop
        } // outer loop
        $temp = $data['attaches'][0];
        
        $this->load->view('templates/header', $data);
        $this->load->view('demo/file_demo', $data);
        $this->load->view('templates/footer', $data);
        
    }

    

    public function do_upload(){
        $config['upload_path'] = '/var/www/html/dealers/';
        $config['allowed_types'] = 'git|jpg|png|jpeg';
        $config['max_size'] = 2000;
        $config['max_width'] = 2000;
        $config['max_height'] = 1800;

        $this->load->library('upload', $config);

        if( ! $this->upload->do_upload('userfile')){
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('demo/upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('demo/success', $data);
        }
    }
}