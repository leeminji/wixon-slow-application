<?php

    class LoadData{

        protected $CI;
        private $viewData = null;

        public function __construct()
        {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
            //var_dump($this->CI->session);
        }
        
        public function get()
        {
            //var_dump($this->session);
            // Check for flash errors
    
            if ($this->CI->session->userdata('error')) {
                $this->viewData = [];
                
                $this->viewData['error'] = $this->CI->session->userdata('error');
                $this->viewData['errorDetail'] = $this->CI->session->userdata('errorDetail');
            }
        
            // Check for logged on user
            if ($this->CI->session->userdata('tokenCache'))
            {
                $this->viewData = [];

                $this->viewData['userName'] = $this->CI->session->userdata('tokenCache')["userName"];
                $this->viewData['userEmail'] = $this->CI->session->userdata('tokenCache')["userEmail"];
            }
        
            return $this->viewData;
        }
    }
?>