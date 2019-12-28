<?php
class List_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    public function get_item($boat_id){
        $this->db->where('BOAT_ID', $boat_id);
        $this->db->order_by('TYPE', 'DESC');
        $query = $this->db->get('CL');
        
        return $query->result_array();
    }


    /**
     * Insert functions
     */
    // Insert a check list item, when a boat is created
    public function add_item($boat_id, $item, $type) {
        $data = array(
            'BOAT_ID' => $boat_id,
            'CL_DES' => $item,
            'TYPE' => $type,
            'CHECKED' => false
        );
        $this->db->insert('CL', $data);
    }

    /**
     * Update Functions
     */


    // update the check status
    public function update_check($cl_id, $checked){
        $data = array(
            'CHECKED' => $checked
        );
        $this->db->where('CL_ID', $cl_id);
        $this->db->update('CL', $data);
    }

    /**
     * Remove Functions
     */
    public function remove_item($cltp_id){
        $data = array(
            'CLTP_ID' => $cltp_id
        );
        $this->db->delete('CLTP', $data);
    }

}
