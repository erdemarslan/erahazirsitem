<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Facebook_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
		# ayarlari getir
		$this->system_model->getSettings();
		
		$config = array(
                        'appId'  => $this->config->item('site_facebook_appid'),
                        'secret' => $this->config->item('site_facebook_secret'),
                        'fileUpload' => true, // Indicates if the CURL based @ syntax for file uploads is enabled.
                        );
 
        $this->load->library('Facebook', $config);
 
        $user = $this->facebook->getUser();
 
        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
        $profile = null;
        if($user)
        {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $profile = $this->facebook->api('/me?fields=id,name,email,birthday,gender,website,location');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }
 
        $fb_data = array(
                        'me' => $profile,
                        'uid' => $user,
                        'loginUrl' => $this->facebook->getLoginUrl(
                            array(
                                'scope' => 'email,user_birthday,user_location,user_website', // app permissions
                                'redirect_uri' => base_url('users/login/') // URL where you want to redirect your users after a successful login
                            )
                        ),
                        'logoutUrl' => $this->facebook->getLogoutUrl(),
                    );
 
        $this->session->set_userdata('fb_data', $fb_data);
    }
}