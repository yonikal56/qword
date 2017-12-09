<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managecategories extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->site_model->if_connected())
        {
            redirect(base_url());
        }
        if(!$this->site_model->is_admin($_COOKIE['username']))
        {
            redirect(base_url());
        }
        $this->form_validation->set_message('required', 'חובה למלא את השדה "%s".');
    }
    
    public function index($page = 1)
    {
        $per_page = 20;
        $all_start = $per_page*($page - 1);
        $all_categories = $this->site_model->get_all_categories($all_start, $per_page);
        foreach($all_categories as $key => $value)
        {
            $value['parent'] = $this->site_model->get_category($value['ParentCatId'])[0]['Title'];
            $value['parent'] = ($value['parent'] == 'ROOT') ? "אין" : $value['parent'];
            $value['isAdults'] = ($value['isAdults'] == 0) ? 'לא' : 'כן';
            $all_categories[$key] = $value;
        }
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'managecategories/index/';
        $config['total_rows'] = count($this->site_model->get_all_categories());
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config); 
        
        $data = array(
            'title' => 'ניהול קטגוריות',
            'view' => 'admin/categories',
            'data' => array(
                'categories' => $all_categories,
                'pages' => $this->pagination->create_links()
            )
        );
        $this->load->view('templates/main', $data);
    }
    
    public function remove($id = 0)
    {
        $this->site_model->remove_category($id);
        redirect(base_url().'managecategories');
    }
    
    public function edit($id = null)
    {
        if($id == null)
        {
            redirect(base_url().'managecategories');
        }
        if(!$this->site_model->if_category_exists($id))
        {
            redirect(base_url().'managecategories');
        }
        $this->form_validation->set_rules('title', 'שם קטגוריה', 'trim|required|xss_clean|htmlspecialchars');
        $this->title = isset($_POST['title']) ? $_POST['title'] : false;
        $this->order = isset($_POST['order']) ? $_POST['order'] : false;
        $this->image = isset($_POST['image']) ? $_POST['image'] : false;
        $this->parent = isset($_POST['parent']) ? $_POST['parent'] : false;
        $this->isAdults = isset($_POST['isAdults']);
        $this->desc = isset($_POST['desc']) ? $_POST['desc'] : false;
        if($this->form_validation->run() == FALSE)
        {
            $data = array(
                'title' => 'עריכת קטגוריה',
                'view' => 'admin/edit_category',
                'data' => array(
                    'message' => validation_errors(),
                    'message_class' => 'error',
                    'categories' => $this->site_model->get_all_categories(),
                    'category' => $this->site_model->get_category($id)
                )
            );
            $this->load->view('templates/main', $data);
        }
        else
        {
            $this->site_model->edit_category($id, $this->title, $this->order, $this->image, $this->parent, $this->isAdults, $this->desc);
            redirect(base_url().'managecategories');
        }
    }
    
    public function add()
    {
        $this->form_validation->set_rules('title', 'שם קטגוריה', 'trim|required|xss_clean|htmlspecialchars');
        $this->title = isset($_POST['title']) ? $_POST['title'] : false;
        $this->order = isset($_POST['order']) ? $_POST['order'] : false;
        $this->image = isset($_POST['image']) ? $_POST['image'] : false;
        $this->parent = isset($_POST['parent']) ? $_POST['parent'] : false;
        $this->isAdults = isset($_POST['isAdults']);
        $this->desc = isset($_POST['desc']) ? $_POST['desc'] : false;
        if($this->form_validation->run() == FALSE)
        {
            $data = array(
                'title' => 'הוספת קטגוריה',
                'view' => 'admin/add_category',
                'data' => array(
                    'message' => validation_errors(),
                    'message_class' => 'error',
                    'categories' => $this->site_model->get_all_categories()
                )
            );
            $this->load->view('templates/main', $data);
        }
        else
        {
            $this->site_model->add_category($this->title, $this->order, $this->image, $this->parent, $this->isAdults, $this->desc);
            redirect(base_url().'managecategories');
        }
    }
}