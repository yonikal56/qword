<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->me();
    }
    
    public function me()
    {
        if(!$this->site_model->if_connected())
        {
            redirect(base_url());
        }
        else
        {
            $this->show_user_details($this->site_model->get_users_username($_COOKIE['username'])[0]);
        }
    }
    
    public function id($id = null)
    {
        if($id == null)
        {
            $this->me();
        }
        if($this->site_model->if_user_exists_id($id))
        {
            $this->show_user_details($this->site_model->get_users_by_id($id)[0]);
        }
        else
        {
            $this->me();
        }
    }
    
    public function username($username = null)
    {
        if($username == null)
        {
            $this->me();
        }
        else
        {
            if($this->site_model->if_user_exists($username))
            {
                $this->show_user_details($this->site_model->get_users_username($username)[0]);
            }
            else
            {
                $this->me();
            }
        }
    }
    
    public function show_user_details($user_data)
    {
        $genders = ["לא מוגדר", "זכר", "נקבה", "אחר"];
        $user_data['fName'] = !empty($user_data['fName']) ? $user_data['fName'] : 'לא מוגדר';
        $user_data['lName'] = !empty($user_data['lName']) ? $user_data['lName'] : 'לא מוגדר';
        $user_data['Age'] = !empty($user_data['Age']) ? $user_data['Age'] : 'לא מוגדר';
        $user_data['Gender'] = !empty($user_data['Gender']) ? $genders[$user_data['Gender']] : 'לא מוגדר';
        $data = array(
            'title' => 'פרופיל - '.$user_data['Username'],
            'view' => 'profile',
            'description' => 'פרופיל - '.$user_data['Username'],
            'data' => array(
                'user' => array($user_data)
            )
        );
        $this->load->view('templates/main', $data);
    }
}