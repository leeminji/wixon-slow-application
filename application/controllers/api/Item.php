<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->db->get_where("items", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("items")->result();
        }
     
        $this->response($data, parent::HTTP_OK);
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $data = array(
            "title" => $this->input->post("title"),
            "description" => $this->input->post("description"),
        );
        
        //$post = $_POST;

        if($this->db->insert('items', $data)){
            $this->response(['Item created successfully.'], parent::HTTP_OK);
        }else{
            $this->response(['Item insert failed.'], parent::HTTP_FAILED_DEPENDENCY);
        }
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('items', $input, array('id'=>$id));
     
        $this->response(['Item updated successfully.'], parent::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('items', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], parent::HTTP_OK);
    }
    	
}