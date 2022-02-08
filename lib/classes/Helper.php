<?php

 class Helper
 {
     // Check Input & Sanitize input data
     public function sanitize_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    // Error Or Success Message Alert
    public function message($type, $message){
        $output='<div class="alert alert-'.$type.' alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong class="text-center">'.$message.'</strong>
                 </div>';

        return $output;
    }

    // Display Time InAgo Formate
    public function timeAgo($timestamp)
    {
        date_default_timezone_set('Asia/Dhaka');

        $timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;

        $time = time() - $timestamp;

        switch ($time) {
            //second
            case $time <= 60:
                return 'Just Now!';
            // minute
            case $time >=60 && $time <3600:
                return (round($time/60) == 1) ? 'a minute ago' : round($time/60).' minutes ago';
            // hours
            case $time >=3600 && $time < 86400:
                return (round($time/3600) == 1) ? 'an hours ago' : round($time/3600).' hours ago';
            // Days
            case $time >=86400 && $time < 604800:
                return (round($time/86400) == 1) ? 'a days ago' : round($time/86400).' days ago';
            // Weeks
            case $time >=604800 && $time < 2600640:
                return (round($time/604800) == 1) ? 'a week ago' : round($time/604800).' weeks ago';
            // Months
            case $time >=2600640 && $time < 31207680:
                return (round($time/2600640) == 1) ? 'a month ago' : round($time/2600640).' months ago';
            // years
            case $time >=31207680:
                return (round($time/31207680) == 1) ? 'a year ago' : round($time/31207680).' years ago';
            default:
                // code...
                break;
        }

    }

    // Genarate Slug
    public function genarate_slug($string){
        $slug = strip_tags($string);
        $slug = preg_replace('/[^a-z0-9-]+/','-',trim(strtolower($string)));
        return $slug;
    }
 }
