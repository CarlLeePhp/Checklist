<?php
class Checklist_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    public function get_item($model_id){
        $sql = "SELECT CLTP_ID, CLTP_DES, BOAT_MODEL, TYPE FROM CLTP WHERE BOAT_MODEL = ".$model_id;
        $sql = $sql." ORDER BY TYPE DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // Get item by id
    public function get_item_id($cltp_id){
        $this->db->where('CLTP_ID', $cltp_id);
        $query = $this->db->get('CLTP');
        
        return $query->row_array();
    }

    public function get_dealer() {
        $query = $this->db->get('DEALER');
        return $query->result_array();
    }

    /**
     * Insert functions
     */
    // Insert a check list item to temple
    public function add_item($model_id, $item, $type) {
        $data = array(
            'BOAT_MODEL' => $model_id,
            'CLTP_DES' => $item,
            'TYPE' => $type
        );
        $this->db->insert('CLTP', $data);
    }
    

    /**
     * Update Functions
     */

    public function update_item($cltp_id, $item, $item_type) {
        $data = array(
            'CLTP_DES' => $item,
            'TYPE' => $item_type
        );
        $this->db->where('CLTP_ID', $cltp_id);
        $this->db->update('CLTP', $data);
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
