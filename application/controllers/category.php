<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->form_validation->set_message('required', 'חובה למלא את השדה "%s".');
	}
    
    public function edit($id = null)
    {
        if($this->site_model->if_connected())
        {
            if($this->site_model->is_admin($_COOKIE['username']))
            {
                if($id != null)
                {
                    if($this->site_model->if_question_exists($id))
                    {
                        $this->form_validation->set_rules('title', 'שאלה', 'trim|required|xss_clean|htmlspecialchars');
                        if($this->form_validation->run() == FALSE)
                        {
                            $data = array(
                                'title' => 'עריכת שאלה',
                                'view' => 'admin/edit_question',
                                'data' => array(
                                    'message' => validation_errors(),
                                    'message_class' => 'error',
                                    'question' => $this->site_model->get_question($id),
                                    'ID' => $id
                                )
                            );
                            $this->load->view('templates/main', $data);
                        }
                        else
                        {
                            $question = $this->site_model->get_question($id);
                            $this->site_model->update_question($id, $_POST['title'], $question[0]['AnsId']);
                            redirect(base_url().'question/'.$id);
                        }
                    }
                    else
                    {
                        redirect(base_url());
                    }
                }
                else
                {
                    redirect(base_url());
                }
            }
            else
            {
                redirect(base_url());
            }
        }
        else
        {
            redirect(base_url());
        }
    }
    
    public function remove($id = null, $qid = null)
    {
        if($this->site_model->if_connected())
        {
            if($this->site_model->is_admin($_COOKIE['username']))
            {
                $this->site_model->remove_question($id);
                redirect(base_url().'category/'.$qid);
            }
        }
        redirect(base_url());
    }
    
    public function add($id = null)
    {
        if(isset($_POST['category']))
        {
            $id = $_POST['category'];
        }
        if($id == null)
        {
            redirect(base_url());
        }
        if($this->site_model->if_category_exists($id) && $id != 0)
        {
            if(isset($_POST['title']))
            {
                if(!empty($_POST['title']))
                {
                    $insert_id = $this->site_model->add_question($_POST['title'], $id);
                    redirect(base_url().'question/'.$insert_id);
                }
                else
                {
                    redirect(base_url());
                }
            }
            else
            {
                redirect(base_url());
            }
        }
        else
        {
            redirect(base_url());
        }
    }
    
    public function index() {
        redirect(base_url());
    }
    
    public function cat($id = null)
    {
        if($id == null)
        {
            $this->index();
        }
        else 
        {
            if($this->site_model->if_category_exists($id) && $id != 0)
            {
                $category = $this->site_model->get_category($id);
                $sub_categories = $this->site_model->get_category_childrens($id);
                $aquestions = $this->site_model->get_questions_by_category($id);                
                $nquestions = $this->site_model->get_questions_by_category($id, false);
                $data = array(
                    'title' => "מידע מעניין בנושא ".$category[0]['Title'],
                    'view' => 'category',
                    'description' => "קטגוריה - ".$category[0]['Title'] . '. '.$category[0]['Desc'],
                    'data' => array(
                        'nquestions' => $nquestions,
                        'categories' => isset($sub_categories[0]) ? $sub_categories : $category,
                        'aquestions' => $aquestions,
                        'CIC' => $id,
                        'Desc' => $category[0]['Desc']
                    )
                );
                $this->load->view('templates/main', $data);
            }
            else
            {
                $this->index();
            }
        }
    }
}