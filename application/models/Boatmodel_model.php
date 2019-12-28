<?php
class Boatmodel_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    // get models, available = yes
    public function get_model(){
        $this->db->where('AVAILABLE', 'yes');
        $this->db->order_by('MODEL', 'ASC');
        $query = $this->db->get('BM');
        return $query->result_array();
    }
    public function get_model_id($model_id){
        $this->db->where('MODEL_ID', $model_id);
        $query = $this->db->get('BM');
        
        return $query->row_array();
    }



    /**
     * Insert functions
     */
    // Insert a check list item
    public function add_model($new_model) {
        $data = array(
            'MODEL' => $new_model,
            'AVAILABLE' => 'yes'
        );
        $this->db->insert('BM', $data);
    }
    

    /**
     * Update Functions
     */

    public function update_model($model_id, $model){
        $data = array(
            'MODEL' => $model
        );
        $this->db->where('MODEL_ID', $model_id);
        $this->db->update('BM', $data);
    }

    public function remove_model($model_id){
        $data = array(
            'AVAILABLE' => 'no'
        );
        $this->db->where('MODEL_ID', $model_id);
        $this->db->update('BM', $data);
    }

}
