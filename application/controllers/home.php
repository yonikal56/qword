<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
    
    public function index() {
        $nquestions = $this->site_model->get_last_ask();
        $aquestions = $this->site_model->get_last_ans();
        $data = array(
            'title' => 'קיוורד - שאלה אחת אלף תשובות',
            'view' => 'categories',
            'data' => array(
                'categories' => $this->site_model->get_parent_categories(),
                'aquestions' => $aquestions,
                'nquestions' => $nquestions
            )
        );
        $this->load->view('templates/main', $data);
    }
}