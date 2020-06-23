<?php
class TokenCache_m extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }   
     
    public function storeTokens($accessToken, $user) {
        $this->session->set_userdata('tokenCache', [
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires(),
            'userName' => $user->getDisplayName(),
            'userEmail' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName()
        ]);
    }

    public function clearTokens() {
        $this->session->unset_userdata('tokenCache');      
    }

    public function getAccessToken() {
        // Check if tokens exist
        if (empty($this->session->userdata('tokenCache')['accessToken']) ||
            empty($this->session->userdata('tokenCache')['refreshToken']) ||
            empty($this->session->userdata('tokenCache')['tokenExpires'])) {
            return '';
        }
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        $tokenCache = $this->session->userdata('tokenCache');
        if ($tokenCache['tokenExpires'] <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh

            // Initialize the OAuth client
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => OAUTH_APP_ID,
                'clientSecret'            => OAUTH_APP_PASSWORD,
                'redirectUri'             => OAUTH_REDIRECT_URI,
                'urlAuthorize'            => OAUTH_AUTHORITY.OAUTH_AUTHORIZE_ENDPOINT,
                'urlAccessToken'          => OAUTH_AUTHORITY.OAUTH_TOKEN_ENDPOINT,
                'urlResourceOwnerDetails' => '',
                'scopes'                  => OAUTH_SCOPES   
            ]);

            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => $tokenCache['refreshToken']
                ]);

                // Store the new values
                $this->updateTokens($newToken);

                return $newToken->getToken();
            }
            catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return '';
            }
        }

        // Token is still valid, just return it
        return $tokenCache['accessToken'];
    }

    public function updateTokens($accessToken) {
        $this->session->set_userdata('tokenCache["accessToken"]', $accessToken->getToken());
        $this->session->set_userdata('tokenCache["refreshToken"]', $accessToken->getRefreshToken());
        $this->session->set_userdata('tokenCache["tokenExpires"]', $accessToken->getExpires());
    } 
}
?>