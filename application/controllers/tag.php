<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
    
    public function index($tag = null, $page = 1)
    {
        if($tag == null)
        {
            redirect(base_url());
        }
        $tag = urldecode($tag);
        $questions = $this->site_model->get_by_tag($tag, $page, 10000);
        $aquestions = array();
        $nquestions = array();
        foreach($questions as $question)
        {
            if(empty($question['AnsId']))
            {
                $nquestions[] = $question;
            }
            else
            {
                $aquestions[] = $question;
            }
        }
        $data = array(
            'title' => "מידע מעניין בנושא ".$tag,
            'view' => 'tag',
            'data' => array(
                'nquestions' => $nquestions,
                'aquestions' => $aquestions
            )
        );
        $this->load->view('templates/main', $data);
    }
}