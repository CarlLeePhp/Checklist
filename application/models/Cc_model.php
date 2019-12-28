<?php
class Cc_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    // get all cc
    public function get_cc(){
        
        $query = $this->db->get('CC');
        return $query->result_array();
    }

    public function get_cc_id($cc_id){
        $this->db->where('CC_ID', $cc_id);
        $query = $this->db->get('CC');
        
        return $query->row_array();
    }

    /**
     * Insert functions
     */
    // Insert a check list item
    public function add_cc($cc_name, $cc_email) {
        $data = array(
            'CC_NAME' => $cc_name,
            'CC_EMAIL' => $cc_email
        );
        $this->db->insert('CC', $data);
    }
    

    /**
     * Update Functions
     */

    public function update_cc($cc_id, $cc_name, $cc_email){
        $data = array(
            'CC_NAME' => $cc_name,
            'CC_EMAIL' => $cc_email
        );
        $this->db->where('CC_ID', $cc_id);
        $this->db->update('CC', $data);
    }

    /**
     * Delete Functions
     */

    public function remove_cc($cc_id){
        $data = array(
            'CC_ID' => $cc_id
        );
        $this->db->delete('CC', $data);
    }
}
