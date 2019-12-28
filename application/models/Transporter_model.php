<?php
class Transporter_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    // get all sale
    public function get_transporter(){
        $this->db->where('AVAILABLE', 'yes');
        $this->db->order_by('TP_NAME', 'ASC');
        $query = $this->db->get('TRANSPORTER');
        return $query->result_array();
    }

    public function get_transporter_id($id){
        $this->db->where('TP_ID', $id);
        $query = $this->db->get('TRANSPORTER');
        
        return $query->row_array();
    }

    /**
     * Insert functions
     */
    // Insert a check list item
    public function add_transporter($name) {
        $data = array(
            'TP_NAME' => $name,
            'AVAILABLE' => 'yes'
        );
        $this->db->insert('TRANSPORTER', $data);
    }
    

    /**
     * Update Functions
     */

    public function update_transporter($id, $name){
        $data = array(
            'TP_NAME' => $name
        );
        $this->db->where('TP_ID', $id);
        $this->db->update('TRANSPORTER', $data);
    }

    public function remove_transporter($id){
        $data = array(
            'AVAILABLE' => 'no'
        );
        $this->db->where('TP_ID', $id);
        $this->db->update('TRANSPORTER', $data);
    }
}
