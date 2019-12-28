<?php
class Sale_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    // get all sale, available = yes
    public function get_sale(){
        $this->db->where('AVAILABLE', 'yes');
        $this->db->order_by('SALE_NAME', 'ASC');
        $query = $this->db->get('SALE');
        return $query->result_array();
    }

    public function get_sale_id($sale_id){
        $this->db->where('SALE_ID', $sale_id);
        $query = $this->db->get('SALE');
        
        return $query->row_array();
    }

    /**
     * Insert functions
     */
    // Insert a check list item
    public function add_sale($sale_name, $sale_email) {
        $data = array(
            'SALE_NAME' => $sale_name,
            'SALE_EMAIL' => $sale_email,
            'AVAILABLE' => 'yes'
        );
        $this->db->insert('SALE', $data);
    }
    

    /**
     * Update Functions
     */

    public function update_sale($sale_id, $sale_name, $sale_email){
        $data = array(
            'SALE_NAME' => $sale_name,
            'SALE_EMAIL' => $sale_email
        );
        $this->db->where('SALE_ID', $sale_id);
        $this->db->update('SALE', $data);
    }

    public function remove_sale($sale_id){
        $data = array(
            'AVAILABLE' => 'no'
        );
        $this->db->where('SALE_ID', $sale_id);
        $this->db->update('SALE', $data);
    }
}
