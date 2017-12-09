<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
        $this->form_validation->set_message('required', 'חובה למלא את השדה "%s".');
	}
    
    public function index()
    {
        $is_logined = $this->site_model->if_connected();
        $function = $is_logined ? 'change' : 'login';
        $this->$function();
    }
    
    public function forgot_pass()
    {
        if($this->site_model->if_connected())
        {
            redirect(base_url());
        }
        $this->form_validation->set_rules('username', 'שם משתמש', 'trim|required|xss_clean|htmlspecialchars|callback_forgotValidation');
        $this->username = isset($_POST['username']) ? $_POST['username'] : false;
        if($this->form_validation->run() == FALSE)
        {
            $data = array(
                'title' => 'שכחתי סיסמא',
                'view' => 'forgot_pass',
                'data' => array(
                    'message' => validation_errors(),
                    'message_class' => 'error'
                )
            );
            $this->load->view('templates/main', $data);
        }
        else 
        {
            $data = array(
                'title' => 'שכחתי סיסמא',
                'view' => 'forgot_pass',
                'data' => array(
                    'message' => 'סיסמא חדשה נשלחה למייל המשתמש',
                    'message_class' => 'success'
                )
            );
            $this->load->view('templates/main', $data);
            $this->site_model->forgot_pass($this->username);
        }
    }
    
    public function register()
    {
        if($this->site_model->if_connected())
        {
            redirect(base_url());
        }
        $this->form_validation->set_rules('username', 'שם משתמש', 'trim|required|xss_clean|htmlspecialchars|callback_userExists');
        $this->form_validation->set_rules('password', 'סיסמא', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('email', 'אימייל', 'trim|required|xss_clean|htmlspecialchars');
        $this->username = isset($_POST['username']) ? $_POST['username'] : false;
        $this->password = isset($_POST['password']) ? $_POST['password'] : false;
        $this->email = isset($_POST['email']) ? $_POST['email'] : false;
        $this->fname = isset($_POST['fname']) ? $_POST['fname'] : false;
        $this->lname = isset($_POST['lname']) ? $_POST['lname'] : false;
        $this->gender = isset($_POST['gender']) ? $_POST['gender'] : false;
        $this->age = isset($_POST['age']) ? $_POST['age'] : false;
        $this->city = isset($_POST['city']) ? $_POST['city'] : false;
        $this->address = isset($_POST['address']) ? $_POST['address'] : false;
        $this->phone = isset($_POST['phone']) ? $_POST['phone'] : false;
        $this->mailList = isset($_POST['mailList']);
        if($this->form_validation->run() == FALSE)
        {
            $data = array(
                'title' => 'הרשמה',
                'view' => 'register',
                'data' => array(
                    'message' => validation_errors(),
                    'message_class' => 'error'
                )
            );
            $this->load->view('templates/main', $data);
        }
        else 
        {
            $this->site_model->register($this->username, $this->password, $this->email, $this->mailList, $this->fname, $this->lname, $this->gender, $this->age, $this->city, $this->address, $this->phone);
            redirect(base_url() . 'user/login');
        }
    }
    
    public function change()
    {
        if(!$this->site_model->if_connected())
        {
            redirect(base_url());
        }
        $this->form_validation->set_rules('password', 'סיסמא', 'trim|required|xss_clean|htmlspecialchars|callback_changeValidation');
        $this->form_validation->set_rules('email', 'אימייל', 'trim|required|xss_clean|htmlspecialchars');
        $this->username = $_COOKIE['username'];
        $this->password = isset($_POST['password']) ? $_POST['password'] : false;
        $this->new_password = isset($_POST['new_password']) ? $_POST['new_password'] : false;
        $this->email = isset($_POST['email']) ? $_POST['email'] : false;
        $this->fname = isset($_POST['fname']) ? $_POST['fname'] : false;
        $this->lname = isset($_POST['lname']) ? $_POST['lname'] : false;
        $this->gender = isset($_POST['gender']) ? $_POST['gender'] : false;
        $this->age = isset($_POST['age']) ? $_POST['age'] : false;
        $this->city = isset($_POST['city']) ? $_POST['city'] : false;
        $this->address = isset($_POST['address']) ? $_POST['address'] : false;
        $this->phone = isset($_POST['phone']) ? $_POST['phone'] : false;
        if($this->form_validation->run() == FALSE)
        {
            $data = array(
                'title' => 'שינוי פרטים',
                'view' => 'change_details',
                'data' => array(
                    'message' => validation_errors(),
                    'message_class' => 'error',
                    'user' => $this->site_model->get_users_username($_COOKIE['username'])
                )
            );
            $this->load->view('templates/main', $data);
        }
        else 
        {
            $this->site_model->change_details($this->username, $this->new_password, $this->email, $this->fname, $this->lname, $this->gender, $this->age, $this->city, $this->address, $this->phone);
            redirect(base_url());
        }
    }
    
    public function login()
    {
        if($this->site_model->if_connected())
        {
            redirect(base_url());
        }
        $this->form_validation->set_rules('username', 'שם משתמש', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('password', 'סיסמא', 'trim|required|xss_clean|htmlspecialchars|callback_loginValidation');
        $this->username = isset($_POST['username']) ? $_POST['username'] : false;
        $this->password = isset($_POST['password']) ? $_POST['password'] : false;
        if($this->form_validation->run() == FALSE)
        {
            $data = array(
                'title' => 'התחברות',
                'view' => 'login',
                'data' => array(
                    'message' => validation_errors(),
                    'message_class' => 'error'
                )
            );
            $this->load->view('templates/main', $data);
        }
        else 
        {
            redirect(base_url());
        }
    }
    
    public function logout()
    {
        $this->site_model->log_out();
    }
    
    public function loginValidation()
	{
		if(!$this->site_model->log_in($this->username, $this->password))
		{
			$message = 'שם משתמש או סיסמא לא נכונים';
			$this->form_validation->set_message('loginValidation', $message);
			return false;
		}
		else 
		{
			return true;	
		}
	}
    
    public function changeValidation()
    {
        if(!$this->site_model->log_in($this->username, $this->password))
        {
            $message = 'סיסמא לא נכונה';
			$this->form_validation->set_message('changeValidation', $message);
			return false;
        }
        return true;
    }
    
    public function forgotValidation()
    {
        if(!$this->site_model->if_user_exists($this->username))
		{
			$message = 'משתמש לא קיים';
			$this->form_validation->set_message('forgotValidation', $message);
			return false;
		}
        return true;	
    }
    
    public function userExists()
    {
        if($this->site_model->if_user_exists($this->username))
        {
            $message = 'שם משתמש תפוס';
			$this->form_validation->set_message('userExists', $message);
			return false;
        }
        return true;
    }
}