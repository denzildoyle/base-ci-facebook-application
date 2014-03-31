<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class FacebookApiModel extends CI_Model{


    public function __construct(){
        parent::__construct();

        $CI = & get_instance();
        $CI->config->load("facebook",TRUE);
        $config = $CI->config->item('facebook');
        $this->load->library('facebook', $config);
    }

	//check if user liked the page
	public function likeGate(){

		$signed_request = $this->facebook->getSignedRequest();
		
		$likeStatus = empty($signed_request["page"]["liked"]) ? false : (bool)$signed_request["page"]["liked"];
		
		return $likeStatus;
	}
	
	//check if user has accepted the application permissions
	public function hasPermission(){		

		//get the users facebook application id
        $facebookID = $this->facebook->getUser();

		if ($facebookID == 0){
			return false;
		} else{
			return true;
		}
	}

	//get facebook user id
	public function getUserID(){
		return $this->facebook->getUser();
	}

	//get the username of the current user
	public function getUsername(){
		
		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;

		//get the users facebook application id
        $facebookID = $this->facebook->getUser();

		if($facebookID) {
			try {
        		$user_profile = $this->facebook->api('/'.$facebookID);
        		return $user_profile['name'];

	      	} catch(FacebookApiException $e) {
				return $e->getMessage();
	      	}   
    	} else {
			return "No name returned";
		}
	}

	//get a list of all facebook friends
	public function getFriends(){
		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;

		//get the users facebook application id
        $facebookID = $this->facebook->getUser();

		if($facebookID) {
			try {
				
        		$user_friends = $this->facebook->api('me?fields=friends,about');
        		return $user_friends['friends']['data'];

	      	} catch(FacebookApiException $e) {
				return $e->getMessage();
	      	}   
    	} else {
			return "No name returned";
		}
	}

	//make post to your timeline
	public function post(){
		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;

		//get the users facebook application id
        $facebookID = $this->facebook->getUser();
        
        if($facebookID) {
          	try {       	
	        	$ret_obj = $this->facebook->api('/'. $facebookID. '/feed', 'POST',
	                                    	array(
	                                      			'message' => 'Hello @[627237246:kenycia Doyle]! Thdsfdsfis is a test posted from the facebook SDK1'
	                                 			));
       		
       			echo '<pre>Post ID: ' . $ret_obj['id'] . '</pre>';

            } catch(FacebookException $e) {
		        error_log($e->getType());
		        error_log($e->getMessage());
          	}   
        } else {

        } 
	}

} //end facebookapimodel model	