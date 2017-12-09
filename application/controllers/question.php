<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function edit($id = null, $qid = null)
    {
        if($this->site_model->if_connected())
        {
            if($this->site_model->is_admin($_COOKIE['username']))
            {
                if($id != null && $qid != null)
                {
                    if($this->site_model->if_answer_exists($id) && $this->site_model->if_question_exists($qid))
                    {
                        $this->form_validation->set_rules('image', 'תמונה', '');
                        if($this->form_validation->run() == FALSE)
                        {
                            $data = array(
                                'title' => 'עריכת תשובה',
                                'view' => 'admin/edit_answer',
                                'data' => array(
                                    'message' => validation_errors(),
                                    'message_class' => 'error',
                                    'answer' => $this->site_model->get_answer($id),
                                    'ID' => $id,
                                    'qId' => $qid
                                )
                            );
                            $this->load->view('templates/main', $data);
                        }
                        else
                        {
                            $this->site_model->update_answer($id, $_POST['content'], $_POST['image']);
                            redirect(base_url().'question/'.$qid);
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
                $this->site_model->remove_answer($id);
                redirect(base_url().'question/'.$qid);
            }
        }
        redirect(base_url());
    }
    
    public function ques($id = null)
    {
        $this->index($id);
    }
    
    public function index($id = null)
    {
        if($id == null)
        {
            redirect(base_url());
        }
        if(!$this->site_model->if_question_exists($id))
        {
            redirect(base_url());
        }
        $question = $this->site_model->get_question($id);
        $answers = array();
        $answers_id = ($question[0]['AnsId'] == 0) ? array() : explode("|", $question[0]['AnsId']);
        foreach($answers_id as $ans_id)
        {
            if($this->site_model->if_answer_exists($ans_id))
            {
                $answers[] = $this->site_model->get_answer($ans_id)[0];
            }
        }
        $description_for_meta = 'שאלה - '.$question[0]['Question'];
        $foreach_number = 1;
        foreach($answers as $key => $value)
        {
            $description_for_meta .= "תשובה {$foreach_number} - ".htmlspecialchars($value['Answer']);
            $value['AnsID'] = $value['AnsId'];
            $value['UserAns'] = $this->site_model->get_users_by_id($value['UserId'])[0]['Username'];
            $value['imgAns'] = !empty($value['ImgUrl']) ? '<img style="margin: 0 auto; display: block; text-align: center;" width="300" height="250" src="'.base_url().'images/uploads/'.$value['ImgUrl'].'" />' : '';
            if($value['VideoUrl'] != "" && $value['VideoHost'] == 'youtube')
            {
                $value['Answer'] .= '<iframe width="560" height="315" src='.$value['VideoUrl'].' frameborder="0" allowfullscreen></iframe><br>';
            }
            if($value['SourceUrl1'] != "" && $value['SourceTitle1'] != "")
            {
                $value['Answer'] .= "<a href='{$value['SourceUrl1']}'>{$value['SourceTitle1']}</a><br>";
            }
            if($value['SourceUrl2'] != "" && $value['SourceTitle2'] != "")
            {
                $value['Answer'] .= "<a href='{$value['SourceUrl2']}'>{$value['SourceTitle2']}</a><br>";
            }
            $answers[$key] = $value;
            $foreach_number++;
        }
        $usd = $this->site_model->get_users_by_id($question[0]['UserId']);
        $question[0]['QuesImg'] = $this->site_model->get_category($question[0]['CatId'])[0]['IconFilename'];
        $question[0]['UserName'] = isset($usd[0]) ? $usd[0]['Username'] : '';
        $question[0]['q_cat'] = ($question[0]['SubCatId'] == 0) ? $question[0]['CatId'] : $question[0]['SubCatId'];
        $this->site_model->update_ques_views($id);
        $keywords = array();
        foreach($answers as $anss)
        {
            if(count($keywords) == 0)
            {
                $keywords = extractCommonWords($anss['Answer'], 2, 2, true, 15);
            }
        }
        if(count($keywords) == 0)
        {
            $keywords = extractCommonWords(str_replace(array('"', "'"), array("", ""), $question[0]['Question']));
        }
        if(count($keywords) == 0)
        {
            $keywords = array('קיוורד','qword','מידע','מאגר מידע','שאלות תשובות');
        }
        $tags_for_quest2 = extractCommonWords(str_replace(array('"', "'", '&quot;'), array("", "", ""), $question[0]['Question']), 2, 1, true, 5, false);
        $tags_for_quest = array();
        foreach ($tags_for_quest2 as $tag_fq)
        {
            $tags_for_quest[]['tag_name'] = $tag_fq;
        }
        $random_cat = $this->site_model->get_random_from_cat($question[0]['q_cat'], 6, $question[0]['qId']);
        $data = array(
            'title' => 'קיוורד שאלות תשובות | '.$question[0]['Question'],
            'view' => 'question',
            'description' => $description_for_meta,
            'keywords' => implode(',', $keywords),
            'data' => array(
                'question' => $question,
                'answers' => $answers,
                'random_cat' => $random_cat,
                'more_cat_text' => (count($random_cat) >= 1) ? 'עוד בנושא '.$this->site_model->get_category($question[0]['q_cat'])[0]['Title'] : '',
                'tags' => $tags_for_quest
            )
        );
        $this->load->view('templates/main', $data);
    }
    
    public function add($id = null)
    {
        if($id == null)
        {
            redirect(base_url());
        }
        if(!isset($_POST['content']) || !isset($_POST['image']))
        {
            redirect(base_url().'question/ques/'.$id);
        }
        $insert_id = $this->site_model->add_answer($_POST['image'], $_POST['content'], $id);
        redirect(base_url().'question/ques/'.$id.'#answer_'.$insert_id);
    }
}