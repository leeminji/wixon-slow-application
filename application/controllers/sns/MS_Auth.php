<?php

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class MS_Auth extends CI_Controller {
    private $auth_config;

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('tokenCache_m');
        $this->auth_config = array(
            'clientId'                => OAUTH_APP_ID,
            'clientSecret'            => OAUTH_APP_PASSWORD,
            'redirectUri'             => OAUTH_REDIRECT_URI,
            'urlAuthorize'            => OAUTH_AUTHORITY.OAUTH_AUTHORIZE_ENDPOINT,
            'urlAccessToken'          => OAUTH_AUTHORITY.OAUTH_TOKEN_ENDPOINT,
            'urlResourceOwnerDetails' => '',
            'scopes'                  => OAUTH_SCOPES           
        );

        $this->load->library("loaddata");
    }

	public function index()
	{
        //var_dump($this->loadViewData());
        //var_dump($this->session);
        //echo ENVIRONMENT;

        $data['page'] = '/auth/main_v';
        
        $loadData = $this->loaddata->get();
        if( $loadData != null ){
            $data = array_merge($data, $loadData);
        }

        $data['data'] = $data;
        $this->load->view("/layout/layout_v", $data);
    }
    
    //로그인
    public function signin()
    {
        //var_dump($this->auth_config);
        $oauthClient = new GenericProvider($this->auth_config);
        $authUrl = $oauthClient->getAuthorizationUrl();

        $this->session->set_userdata("oauthState", $oauthClient->getState());
        
        redirect($authUrl);
    }

    public function callback()
    {
        //validate state
        $expectedState = $this->session->userdata('oauthState');
        $this->session->unset_userdata('oauthState');
        $providedState = $this->input->get("state");

        if (!isset($expectedState)) {
            // If there is no expected state in the session,
            // do nothing and redirect to the home page.
            redirect('/sns/ms_auth');
        }
        if (!isset($providedState) || $expectedState != $providedState) {
            $this->session->set_userdata('error', "Invalid auth state");
            $this->session->set_userdata('errorDetail', "The provided auth state did not match the expected value");
            
            redirect('/sns/ms_auth');
        }

        $authCode = $this->input->get('code');
        if(isset($authCode)){
            $oauthClient = new GenericProvider($this->auth_config);

            try{
                $accessToken = $oauthClient->getAccessToken('authorization_code', [
                    'code' => $authCode
                ]);

                $graph = new Graph();
                $graph->setAccessToken($accessToken->getToken());
                $user = $graph->createRequest('GET', '/me')
                ->setReturnType(Model\User::class)
                ->execute();
                
                $this->tokenCache_m->storeTokens($accessToken, $user);
                
                //제대로 로그인 성공했을경우
                redirect("/MsOneDrive");

            }catch(IdentityProviderException $e){
                $this->session->set_userdata('error', "Error requesting access token");
                $this->session->set_userdata('errorDetail', $e->getMessage());

                redirect("/sns/ms_auth");
            }
            $this->session->set_userdata('error', $this->input->get('error'));
            $this->session->set_userdata('errorDetail', $this->input->get('error_description'));

            redirect("/sns/ms_auth");
        }

        $data['page'] = '/auth/main_v';
        $this->load->view("/layout/layout_v", $data);
    }

    public function signout()
    {
        $this->tokenCache_m->clearTokens();
        redirect("/sns/ms_auth");
    }
}
