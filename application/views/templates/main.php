<?php
$logined = $this->site_model->if_connected();
$this->site_model->update_activity_time(isset($_COOKIE['username']) ? $_COOKIE['username'] : '');
$tabs = $logined ? array(
    ['tab_url' => 'user/logout', 'tab_text' => 'התנתק ['.$_COOKIE['username'].']'],
    ['tab_url' => 'user/change', 'tab_text' => 'שינוי פרטים'],
    ['tab_url' => 'profile/me', 'tab_text' => 'פרופיל']
) : array(
    ['tab_url' => 'user/login', 'tab_text' => 'התחבר']
);
$header_data = array(
    'base_url' => base_url(),
    'title' => isset($title) ? $title : 'קיוורד - שאלה אחת,אלף תשובות',
    'description' => isset($description) ? $description : 'קיוורד הינו מאגר מידע רחב במגוון תחומים שונים.המאגר מסודר על פי שאלות ותשובות ופועל על ידי הגולשים אשר יכולים לשתף את הידע שלהם/לשאול שאלות שמעניינות אותם',
    'keywords' => isset($keywords) ? $keywords : 'קיוורד,qword,מידע,מאגר מידע,שאלות תשובות',
    'tabs' => $tabs,
    'categories' => $this->site_model->get_all_categories(),
    'random' => $this->site_model->get_random_questions(8)
);
$footer_data = array(
    
);
$data = isset($data) ? $data : array();
$data['base_url'] = base_url();
$this->parser->parse('templates/header', $header_data);
$this->parser->parse($view, $data);
$this->parser->parse('templates/footer', $footer_data);