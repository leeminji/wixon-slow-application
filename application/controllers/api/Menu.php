<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->model("setting/menu_m");
    }
       
    /**
     * Get All Data from this method.
     * //api/menu
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->menu_m->get_item($id);
        }else{
            $data = $this->menu_m->get_all_items();
        }
        $this->response($data, parent::HTTP_OK);
	}
      
    /**
     * Get All Data from this method.
     * //api/menu -post
     * @return Response
    */
    public function index_post()
    {
        $data = array(
            "m_name" => $this->input->post("name"),
            "m_dep" => $this->input->post("dep"),
            "m_link" => $this->input->post("link"),
            "m_pidx" => !$this->input->post("pidx") ? 0 : $this->input->post("pidx"),
        );

        if($this->menu_m->insert_item($data)){
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
        $put = $this->put();
        $data = array(
            "m_name" => $put['name'],
            "m_dep" => $put['dep'],
            "m_link" => $put['link'],
            "m_pidx" => !$put['pidx'] ? 0 : $put['pidx'],
        );
        $this->menu_m->update_item($id, $data);
        $this->response(['Item updated successfully.'], parent::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
       if($this->menu_m->delete_item($id)){
            $this->response(['Item deleted successfully.'], parent::HTTP_OK);
       }else{
            $this->response(['하위메뉴가 있는경우 삭제할수 없습니다.'], parent::HTTP_OK);
       }
    }
}