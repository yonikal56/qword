<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('die_r'))
{
	function die_r($var)
	{
		echo '<pre>';
		print_r($var);
		die();
	}	
}

if(!function_exists('random_salt'))
{
    function random_salt()
    {
        $text = "abcdefghijklmnopqrstvuwxyzABCDEFGHIJKLMNOPQRSTVUYXWZ1234567890!@#$%^&*()~abcdefghijklmnopqrstvuwxyzABCDEFGHIJKLMNOPQRSTVUYXWZ1234567890!@#$%^&*()~";
        $salt_length = rand(20, 30);
        $salt_full = str_shuffle($text);
        return substr($salt_full, 0, $salt_length);
    }
}

if(!function_exists('pass'))
{
    function pass($pass, $salt)
    {
        return md5("this!is_@Pass..WoRd--+55&MIxEr" . $pass . $salt);
    }
}

if(!function_exists('random_pass'))
{
    function random_pass() 
    {
        $text = "abcdefghijklmnopqrstvuwxyzABCDEFGHIJKLMNOPQRSTVUYXWZ1234567890!@#$%^&*()~abcdefghijklmnopqrstvuwxyzABCDEFGHIJKLMNOPQRSTVUYXWZ1234567890!@#$%^&*()~";
        return substr(str_shuffle($text), 0, 8);
    }
}

if(!function_exists('keyword_count_sort'))
{
    function keyword_count_sort($first, $sec)
    {
        return $sec[1] - $first[1];
    }
}

if(!function_exists('extractCommonWords'))
{
    function extractCommonWords($str, $minWordLen = 2, $minWordOccurrences = 1, $asArray = true, $max_words = 15, $numbers = true)
    {
        $str = str_replace(array('"', "'"), array(' ', ''), $str);
        $str = preg_replace('/[^א-תa-zA-Z'.($numbers ? '0-9' : '').' ]/', ' ', $str);
        $str = trim(preg_replace('/\s+/', ' ', $str));

        $words = explode(' ', $str);
        $keywords = array();
        while(($c_word = array_shift($words)) !== null)
        {
            if(strlen($c_word) < $minWordLen) continue;

            $c_word = strtolower($c_word);
            if(array_key_exists($c_word, $keywords)) {$keywords[$c_word][1]++;}
            else {$keywords[$c_word] = array($c_word, 1);}
        }
        usort($keywords, 'keyword_count_sort');

        $final_keywords = array();
        $stop_words = array('איזו', 'איך', 'מי', 'כיצד', 'מדוע', 'שאלה', 'תשובה', 'למה', 'איך', 'איפה', 'כמה', 'איזה', 'מכינים', 'מה', 'סוג', 'את', 'היכן', 'צייר', 'של', 'כי', 'היה', 'מושג');
        foreach($keywords as $keyword_det)
        {
            if(count($final_keywords) >= $max_words)
            {
                break;
            }
            if($keyword_det[1] < $minWordOccurrences) break;
            $bool = true;
            foreach($stop_words as $stop)
            {
                if(strpos($keyword_det[0], $stop) !== FALSE)
                {
                    $bool = false;
                    break;
                }
            }
            if($bool)
            {
                array_push($final_keywords, $keyword_det[0]);
            }
        }
        return $asArray ? $final_keywords : implode(', ', $final_keywords);
    }
}