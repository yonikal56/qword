<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model {
    public function get_by_tag($tag, $page = 1, $per_page = 15)
    {
        $start = $per_page*($page-1);
        $this->db->like('Question', "%{$tag}%");
        $this->db->or_like('Question', "{$tag}%");
        $this->db->or_like('Question', "%{$tag}");
        $this->db->or_like('Question', "{$tag}");
        $query = $this->db->get('questions', $per_page, $start);
        return $query->result_array();
    }
    
    public function get_all_categories($start = 0, $per_page = 10000)
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `Title` <> 'ROOT' ORDER BY `ParentCatId`,`OrderId` ASC LIMIT {$start}, {$per_page}");
        return $query->result_array();
    }
    
    public function get_last_ans($limit = 10)
    {
        $query = $this->db->query("SELECT * FROM answers ORDER BY `AnsId` DESC");
        $results = array();
        $x = 0;
        foreach($query->result_array() as $ans)
        {
            if($x < $limit)
            {
                $ques = $this->get_question_by_answer($ans['AnsId']);
                if(isset($ques[0]))
                {
                    $bool = true;
                    foreach($results as $result)
                    {
                        if($result['qId'] == $ques[0]['qId'])
                        {
                            $bool = false;
                            break;
                        }
                    }
                    if($bool)
                    {
                        $results[] = $ques[0];
                        $x++;
                    }
                }
            }
        }
        return $results;
    }
    
    public function get_last_ask($limit = 10)
    {
        $query = $this->db->query("SELECT * FROM questions WHERE `AnsID` = '0' ORDER BY `qId` DESC LIMIT {$limit}");
        return $query->result_array();
    }
    
    public function get_random_from_cat($id, $limit = 6, $nId)
    {
        $query = $this->db->query("SELECT * FROM questions WHERE (`SubCatId` = {$id} OR `CatId` = {$id}) AND (`qId` <> {$nId}) ORDER BY RAND() LIMIT 100");
        $results = $query->result_array();
        $res = array();
        foreach ($results as $key => $value)
        {
            if($value['AnsId'] == 0)
            {
                
            }
            else
            {
                $ansers = explode('|', $value['AnsId']);
                foreach($ansers as $as)
                {
                    if($this->if_answer_exists($as))
                    {
                        $an = $this->get_answer($as)[0];
                        if(!empty($an['ImgUrl']))
                        {
                            $value['QuesImg'] = $an['ImgUrl'];
                        }
                    }
                }
                if(!isset($value['QuesImg']))
                {
                    
                }
                else
                {
                    if(count($res) < $limit)
                    {
                        $res[] = $value;
                    }
                }
            }
        }
        return $res;
    }
    
    public function get_random_questions($limit = 8)
    {
        $query = $this->db->query("SELECT * FROM questions ORDER BY RAND() LIMIT 100");
        $results = $query->result_array();
        $res = array();
        foreach ($results as $key => $value)
        {
            if($value['AnsId'] == 0)
            {
                
            }
            else
            {
                $ansers = explode('|', $value['AnsId']);
                foreach($ansers as $as)
                {
                    if($this->if_answer_exists($as))
                    {
                        $an = $this->get_answer($as)[0];
                        if(!empty($an['ImgUrl']))
                        {
                            $value['QuesImg'] = $an['ImgUrl'];
                        }
                    }
                }
                if(!isset($value['QuesImg']))
                {
                    
                }
                else
                {
                    if(count($res) < $limit)
                    {
                        $res[] = $value;
                    }
                }
            }
        }
        return $res;
    }
    
    public function if_answer_exists($id)
    {
        $query = $this->db->get_where("answers", array('AnsId' => $id));
        return count($query->result_array()) >= 1;
    }
    
    public function if_question_exists($id)
    {
        $query = $this->db->get_where("questions", array('qId' => $id));
        return count($query->result_array()) >= 1;
    }
    
    public function add_answer($image, $content, $quest_id)
    {
        $user = $this->get_users_username($_COOKIE['username'])[0];
        $question = $this->get_question($quest_id)[0];
        $time = time();
        $data = array(
            'UserId' => $user['UserId'],
            'Answer' => $content,
            'ImgUrl' => '',
            'CreateDate' => date('Y-m-d G:i:s')
        );
        
        if(!empty($image))
        {
            $data_ = file_get_contents($image);
            file_put_contents(FCPATH.'images/uploads/'.$question['qId'].'_'.$time.'.jpg', $data_);
            $data['ImgUrl'] = $question['qId'].'_'.$time.'.jpg';
        }
        
        $this->db->insert('answers', $data);
        
        $insert_id = $this->db->insert_id();
        
        $new_ans = ($question['AnsId'] == 0) ? $insert_id : $question['AnsId'] . "|" . $insert_id;
        
        $this->update_question($quest_id, $question['Question'], $new_ans);
        
        return $insert_id;
    }
    
    public function update_ques_views($id)
    {
        $this->db->set('Views', 'Views+1', FALSE);
        $this->db->where('qId', $id);
        $this->db->update('questions');
    }
    
    public function get_question_by_answer($id)
    {
        $query = $this->db->query("SELECT * FROM `questions` WHERE `AnsId` = ".$id." OR `AnsId` LIKE '%|".$id."' OR `AnsId` LIKE '".$id."|' OR `AnsId` LIKE '%|".$id."|%'");
        return $query->result_array();
    }
    
    public function remove_answer($id)
    {
        $question = $this->get_question_by_answer($id);
        $this->db->delete('answers', array('AnsId' => $id));
        return $question[0]['qId'];
    }
    
    public function remove_question($id)
    {
        $this->db->delete('questions', array('qId' => $id)); 
    }
    
    public function is_subcat($id)
    {
        $cat = $this->get_category($id)[0];
        if($cat['ParentCatId'] == "0")
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function add_question($title, $sub_cat)
    {
        $user = $this->get_users_username($_COOKIE['username'])[0];
        $data = array(
            'CreateDate' => date('Y-m-d G:i:s'),
            'Question' => $title,
            'AnsId' => 0,
            'Views' => 0,
            'isApproved' => 1,
            'UserId' => $user['UserId']
        );
        
        $isSubCat = $this->is_subcat($sub_cat);
        $data['CatId'] = $isSubCat ? $this->get_category($sub_cat)[0]['ParentCatId'] : $sub_cat;
        $data['SubCatId'] = $isSubCat ? $sub_cat : '0';
        
        $this->db->insert('questions', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    
    public function update_answer($id, $answer, $image)
    {
        $time = time();
        $data = array(
            'Answer' => $answer,
            'ImgUrl' => $image
        );
        
        $answer = $this->get_answer($id)[0];
        if(!empty($image))
        {
            if(strpos($image, "://"))
            {
                $data_ = file_get_contents($image);
                file_put_contents(FCPATH.'images/uploads/'.$id.'_'.$time.'.jpg', $data_);
                $data['ImgUrl'] = $id.'_'.$time.'.jpg';
            }
        }
        
        $this->db->where('AnsId', $id);
        $this->db->update('answers', $data);
    }
    
    public function update_question($id, $title, $ans)
    {
        $data = array(
            'Question' => $title,
            'AnsId' => $ans
         );
        $this->db->where('qId', $id);
        $this->db->update('questions', $data); 
    }
    
    public function get_question($id)
    {
        $query = $this->db->get_where("questions", array('qId' => $id));
        return $query->result_array();
    }
    
    public function get_answer($id)
    {
        $query = $this->db->get_where("answers", array('AnsId' => $id));
        return $query->result_array();
    }

    public function get_questions_by_category($id, $answered = true)
    {
        $ans_id = $answered ? "<> 0" : "= 0";
        $query = $this->db->query("SELECT * FROM `questions` WHERE ((`CatId` = {$id} AND `SubCatId` = 0) OR (`SubCatId` = {$id})) AND (`Question` <> '') AND (`AnsId` {$ans_id} )");
        return $query->result_array();
    }
    
    public function remove_category($id)
    {
        $this->db->delete('categories', array('CatId' => $id)); 
    }
    
    public function edit_category($id, $title, $order, $image, $parent, $isAdults, $desc)
    {   
        $time = time();
        $data_ = file_get_contents($image);
        $data = array(
            'Title' => $title,
            'OrderId' => $order,
            'IconFilename' => $image,
            'ParentCatId' => $parent,
            'isAdults' => $isAdults,
            'Desc' => $desc
        );
        
        $category = $this->get_category($id)[0];
        if($category['IconFilename'] != $image && !empty($image))
        {
            file_put_contents(FCPATH.'images/uploads/'.$title.'_'.$time.'.jpg', $data_);
            unlink(FCPATH . 'images/uploads/'.$category['IconFilename']);
            $data['IconFilename'] = $title.'_'.$time.'.jpg';
        }
        
        $this->db->where('CatId', $id);
        $this->db->update('categories', $data); 
    }
    
    public function add_category($title, $order, $image, $parent, $isAdults, $desc)
    {   
        $time = time();
        $data_ = file_get_contents($image);
        $data = array(
            'Title' => $title,
            'OrderId' => $order,
            'IconFilename' => "",
            'ParentCatId' => $parent,
            'isAdults' => $isAdults,
            'Desc' => $desc
        );
        
        if(!empty($image))
        {
            file_put_contents(FCPATH.'images/uploads/'.$title.'_'.$time.'.jpg', $data_);
            $data['IconFilename'] = $title.'_'.$time.'.jpg';
        }
        
        $this->db->insert('categories', $data);
    }
    
    public function get_parent_categories()
    {
        $this->db->order_by("OrderId", "ASC");
        $query = $this->db->get_where("categories", array('ParentCatId' => '0'));
        return $query->result_array();
    }
    
    public function get_category($id)
    {
        $query = $this->db->get_where("categories", array('CatId' => $id));
        return $query->result_array();
    }
    
    public function get_category_parent($id)
    {
        $category = $this->get_category($id);
        if(isset($category[0]))
        {
            return $this->get_category($category[0]['ParentCatId']);
        }
        return null;
    }
    
    public function get_category_childrens($parent_id = 0)
    {
        $this->db->order_by("OrderId", "ASC");
        $query = $this->db->get_where("categories", array('ParentCatId' => $parent_id));
        return $query->result_array();
    }
    
    public function get_all_questions()
    {
        $query = $this->db->query("SELECT * FROM `questions`");
        return $query->result_array();
    }
    
    public function get_new_questions()
    {
        $query = $this->db->query("SELECT * FROM `questions` ORDER BY `qId` DESC");
        return $query->result_array();
    }
    
    public function get_common_questions()
    {
        $query = $this->db->query("SELECT * FROM `questions` ORDER BY `Views` DESC");
        return $query->result_array();
    }
    
    public function get_category_questions($category_id = 0)
    {
        $query = $this->db->get_where("questions", array('SubCatId' => $category_id));
        return $query->result_array();
    }
    
    public function get_all_answers()
    {
        $query = $this->db->query("SELECT * FROM `answers`");
        return $query->result_array();
    }
    
    public function get_all_qwords()
    {
        $query = $this->db->query("SELECT * FROM `qwords`");
        return $query->result_array();
    }
    
    public function get_all_users()
    {
        $query = $this->db->query("SELECT * FROM `users`");
        return $query->result_array();
    }
    
    public function get_users_by_id($user_id)
    {
        $query = $this->db->get_where("users", array('UserId' => $user_id));
        return $query->result_array();
    }
    
    public function get_users_username($user_name)
    {
        $query = $this->db->get_where("users", array('Username' => $user_name));
        return $query->result_array();
    }
    
    public function if_category_exists($id)
    {
        $query = $this->db->get_where("categories", array('CatId' => $id));
        return count($query->result_array()) >= 1;
    }
    
    public function if_user_exists($username)
    {
        $query = $this->db->get_where("users", array('Username' => $username));
        return count($query->result_array()) >= 1;
    }
    
    public function if_user_exists_id($id)
    {
        $query = $this->db->get_where("users", array('UserId' => $id));
        return count($query->result_array()) >= 1;
    }
    
    public function check_pass($username, $pass)
    {
        $user_d = $this->get_users_username($username);
        if(isset($user_d[0]))
        {
            $value = $user_d[0];
            if($value['Password'] == pass($pass, $value['PasswordSalt']))
            {
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function update_activity_time($username)
    {
        $data = array(
            'lastActivityCalc' => date('Y-m-d G:i:s')
         );
        $this->db->where('Username', $username);
        $this->db->update('users', $data); 
    }
    
    public function check_details_login($username, $password)
    {
        $query = $this->db->get_where("users", array('Username' => $username, 'Password' => $password));
        return count($query->result_array()) >= 1;
    }
    
    public function log_in($username, $password)
    {
        if($this->check_pass($username, $password))
        {
            $user_details = $this->get_users_username($username)[0];
            setcookie("username", $user_details['Username'], time() + (60 * 60 * 24 * 365), '/');
            setcookie("pass", $user_details['Password'], time() + (60 * 60 * 24 * 365), '/');
            return true;
        }
        return false;
    }
    
    public function log_out($reffer = NULL)
    {
        if($reffer == NULL)
        {
            $reffer = base_url();
        }
        setcookie("username", "", time() - 1, '/');
        setcookie("pass", "", time() - 1, '/');
        redirect($reffer);
    }
    
    public function if_connected()
    {
        if(isset($_COOKIE['username']) && $_COOKIE['pass'])
        {
            if($this->check_details_login($_COOKIE['username'], $_COOKIE['pass']))
            {
                return true;
            }
            else
            {
                $this->log_out();
            }
            return false;
        }
        return false;
    }
    
    public function register($username, $password, $email, $mailList, $fname, $lname, $gender, $age, $city, $address, $phone)
    {
        $salt = random_salt();
        $data = array(
            'Username' => $username,
            'Password' => pass($password, $salt),
            'PasswordSalt' => $salt,
            'Email' => $email,
            'isMailingList' => $mailList,
            'JoinDate' => date('Y-m-d G:i:s'),
            'JoinIp' => $_SERVER['REMOTE_ADDR'],
            'isAdmin' => '0',
            'fbUserId' => '0',
            'lastActivityCalc' => date('Y-m-d G:i:s'),
            'isExtraData' => '0',
            'fName' => $fname,
            'lName' => $lname,
            'Gender' => $gender,
            'Age' => $age,
            'City' => $city,
            'Address' => $address,
            'Phone' => $phone
        );
        
        $this->db->insert('users', $data); 
    }
    
    public function forgot_pass($username)
    {
        $salt = random_salt();
        $random_pass = random_pass();
        $hashed_pass = pass($random_pass, $salt);
        $data = array(
            'Password' => $hashed_pass,
            'PasswordSalt' => $salt
         );

        $this->db->where('Username', $username);
        $this->db->update('users', $data);
        
        $user_d = $this->get_users_username($username)[0];
        
        $to = $user_d['Email'];

        $text = "קיוורד - שכחתי סיסמא";
        
        $subject = mb_encode_mimeheader($text, "UTF-8");

        $headers = "From: svodbitran@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        $message = "<div dir='rtl'>שלום {$username}, סיסמתך החדשה היא: {$random_pass}.</div>";
        
        mail($to, $subject, $message, $headers);
    }
    
    public function is_admin($username)
    {
        $user_d = $this->get_users_username($username);
        if(isset($user_d[0]))
        {
            $value = $user_d[0];
            if($value['isAdmin'] == "1")
            {
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function change_details($username, $new_pass, $email, $fname, $lname, $gender, $age, $city, $address, $phone)
    {
        $user_details = $this->get_users_username($username)[0];
        $salt = $user_details['PasswordSalt'];
        $password = $user_details['Password'];
        if(!empty($new_pass))
        {
            $salt = random_salt();
            $password = pass($new_pass, $salt);
        }
        $data = array(
            'Password' => $password,
            'PasswordSalt' => $salt,
            'Email' => $email,
            'fName' => $fname,
            'lName' => $lname,
            'Gender' => $gender,
            'Age' => $age,
            'City' => $city,
            'Address' => $address,
            'Phone' => $phone
         );

        $this->db->where('Username', $username);
        $this->db->update('users', $data);
        
        setcookie("username", $user_details['Username'], time() + (60 * 60 * 24 * 365), '/');
        setcookie("pass", $password, time() + (60 * 60 * 24 * 365), '/');
    }
}