<?php
class Pages_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    /**
     * Select Functions
    */
    public function get_dealer() {
        $query = $this->db->get('DEALER');
        return $query->result_array();
    }

    public function get_sale(){
        $query = $this->db->get('SALE');
        return $query->result_array();
    }

    public function get_model(){
        $query = $this->db->get('BM');
        return $query->result_array();
    }

    public function get_boat($dealerID) {
        $sql = "SELECT BOAT_ID, BOAT_SERIAL, MODEL ";
        $sql = $sql."FROM BOAT ";
        $sql = $sql."LEFT JOIN BM ON BOAT.BOAT_MODEL = BM.MODEL_ID ";
        $sql = $sql."WHERE DEALER_ID = ".$dealerID;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Insert functions
     */

     // Insert Dealer
     public function add_dealer($dealerName, $sale_id) {
         $data = array(
             'DEALER_Name' => $dealerName,
            'SALE_ID' => $sale_id
         );
         $this->db->insert('DEALER', $data);

        // get the id and create a folder
        $query = $this->db->get_where('DEALER', array('DEALER_NAME' => $dealerName));
        foreach ($query->result() as $row) {
            $dealer_id = $row->DEALER_ID;
            mkdir("/var/www/html/dealers/".$dealer_id);
            chmod("/var/www/html/dealers/".$dealer_id, 0777);
        }
     }

    // Insert a new Boat
    public function add_boat($dealer, $boat_model) {
        $data = array(
            'DEALER_ID' => $dealer,
            'BOAT_MODEL' => $boat_model
        );
        $this->db->insert('BOAT', $data);
    }

    // Insert a new Sale

    public function add_sale($name, $email) {
        $data = array(
            'SALE_NAME' => $name,
            'SALE_EMAIL' => $email
        );
        $this->db->insert('SALE', $data);

        
    }

    // Insert a new boat model
    public function add_model($model) {
        $data = array(
            'MODEL' => $model
        );
        $this->db->insert('BM', $data);
    }

    /**
     * Update Functions
     */

    public function update_serial($boat_id, $serial) {
        $data = array(
            'BOAT_SERIAL' => $serial
        );
        $this->db->where('BOAT_ID', $boat_id);
        $this->db->update('BOAT', $data);
    }
}
