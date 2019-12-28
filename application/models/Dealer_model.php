<?php
class Dealer_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    // get all dealers join with sale, available = yes
    public function get_dealer(){
        $sql = "SELECT DEALER_ID, DEALER_NAME, SALE_NAME, SALE_EMAIL FROM DEALER LEFT JOIN SALE ON DEALER.SALE_ID = SALE.SALE_ID WHERE DEALER.AVAILABLE = 'yes' ORDER BY DEALER_NAME";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_dealer_id($dealer_id){
        // $this->db->where('SALE_ID', $sale_id);
        // $query = $this->db->get('SALE');
        $sql = "SELECT DEALER_ID, DEALER_NAME, SALE_NAME, SALE_EMAIL, DEALER.SALE_ID FROM DEALER LEFT JOIN SALE ON DEALER.SALE_ID = SALE.SALE_ID WHERE DEALER.AVAILABLE = 'yes'";
        $sql = $sql." AND DEALER_ID=".$dealer_id;
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    /**
     * Insert functions
     */
    // Insert a check list item
    public function add_dealer($dealer, $sale_id) {
        $data = array(
            'DEALER_NAME' => $dealer,
            'SALE_ID' => $sale_id,
            'AVAILABLE' => 'yes'
        );
        $this->db->insert('DEALER', $data);

        //$sql = "SELECT MAX(DEALER_ID) AS MAX_ID FROM DEALER";
        //$query = $this->db->query($sql);
        //$result = $query->row_array();
        
        $dealer = str_replace(' ', '_', $dealer);
        $dealer = trim($dealer);
        // create a folder, named as DEALER_NAME
        $my_path = '/var/www/html/dealers/'.$dealer;
        mkdir($my_path);
    }

    /**
     * Update Functions
     */


    public function update_dealer($dealer_id, $dealer, $sale_id, $dealer_old){
        
        $data = array(
            'DEALER_NAME' => $dealer,
            'SALE_ID' => $sale_id
        );
        $this->db->where('DEALER_ID', $dealer_id);
        $this->db->update('DEALER', $data);
        // change the name of the folder
        $dealer = str_replace(' ', '_', $dealer);
        $my_path = '/var/www/html/dealers/'.$dealer;
        $old_path = '/var/www/html/dealers/'.$dealer_old;
        rename($old_path, $my_path);
    }

    public function remove_dealer($dealer_id){
        $data = array(
            'AVAILABLE' => 'no'
        );
        $this->db->where('DEALER_ID', $dealer_id);
        $this->db->update('DEALER', $data);
    }
}
