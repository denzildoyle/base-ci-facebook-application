<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index(){
        
        //application has permissions to user get the users data
        if ($this->facebookApiModel->hasPermission() == True){

        } else {

            //set application permissions
            // redirect_url what page to go to when application permissions have been confermed?
            $permissions = array(
              'scope' => 'email,publish_stream,user_about_me,publish_actions', 
              'redirect_uri' => ''
            );

            echo "<script type='text/javascript'>top.location.href = '".$this->facebook->getLoginUrl($permissions)."';</script>";
        }
	}

	private function likegate(){
		if ($this->facebookApiModel->likeGate() == True){
    		//load welcome page
    		$this->load->view('welcome_view');
        } else{
        	//load like gate
           	$this->load->view('likegate_view');
        }
	}

    public function post(){
        $this->facebookApiModel->post();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */