<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_start();

class Node extends CI_Controller {

    public $xauth;
    public $show_name;

    public function __construct(){
        parent::__construct();

        $this->load->helper(array('form', 'url', 'html', 'directory', 'cookie'));
        $this->load->library(array('form_validation', 'security', 'pagination', 'session', 'cart'));
        

        $this->perPage = 20;
        $this->form_validation->set_message('valid_email', 'Invalid email entered');
        $this->form_validation->set_message('alpha_space', 'Invalid name entered');
        //$this->form_validation->set_message('max_length', 'The field "%s" is too long, cant\'t proceed!');
        $this->form_validation->set_message('regex_match[/^[0-9]{6,11}$/]', 'Phone must contain numbers and a maximum of 11 digits!');
        $this->load->model('sql_models');
        @date_default_timezone_set('Africa/Lagos');

            //load our Nativesession library
        $this->load->library( 'nativesession' );

        function time_ago($date){
            $periods=array("sec","min","hr","day","week","month","year","decade");
            $lengths=array("60","60","24","7","4.35","12","10");
            $now=time();
            @$mydate=strtotime($date);
            if($now>$mydate){
                $difference=$now-$mydate;
                $tense="ago";
            }else{
                $difference=$mydate-$now;
                $tense="from now";
            }
            for($j=0; $difference>=$lengths[$j] && $j<count($lengths)-1; $j++){
                $difference/=$lengths[$j];
            }
            $difference=intval($difference);
                //$difference=round($difference,PHP_ROUND_HALF_DOWN);
            if($difference!=1){
                $periods[$j].='s';
            }
            return "$difference $periods[$j] {$tense}";
        }


        function convertTime($difference){
                //Calculate how many days are within $difference
            $days = intval($difference / 86400); 
                //$days = round($difference / 86400); 
                //Keep the remainder
            $difference = $difference % 86400;
                //Calculate how many hours are within $difference 
            $hours = intval($difference / 3600)+($days*24); 
                //Keep the remainder
            $difference = $difference % 3600;
                //Calculate how many minutes are within $difference 
            $minutes = intval($difference / 60); 
                //Keep the remainder
            $difference = $difference % 60;
                //Calculate how many seconds are within $difference 
            $seconds = intval($difference); 
                //return "Days: ".$days."<br> Hours: ".$hours."<br> Minutes: ".$minutes."<br> Seconds: ".$seconds."<br>";
                //return $hours." hours, ".$minutes." mins more";
                //return ($days."days ".$hours." hrs");
            $check_zero = $days;
            if($check_zero<=0)
                return ("<font style='font-size:14px;'>".$hours."hrs</font>");
            else
                return ($days." days");
        }


        function convertTime1($difference){
            $days = intval($difference / 86400); 
            $difference = $difference % 86400;
            $hours = intval($difference / 3600)+($days*24); 
            $difference = $difference % 3600;
            $minutes = intval($difference / 60); 
            $difference = $difference % 60;
            $seconds = intval($difference); 
            $check_zero = $days;
            if($check_zero<=0)
                return ("$hours hrs, $minutes mins time");
            else
                return ("$days days time");
        }


        function makeLinks2($str) {
            $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
            if(preg_match($reg_exUrl, $str, $url)) {                    
                if(strpos( $url[0], ":" ) === false){
                    $link = 'http://'.$url[0];
                }else{
                    $link = $url[0];
                }
                $str = preg_replace($reg_exUrl, '<span href="javascript:;" style="color:#09C; display:inline !important">link removed</span>', $str);
            }
            return $str;
        }


        function makeLinks3($str) {
            $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
            $star_sign = "/\*(.*?)\*/";
            $underscores = "/\_(.*?)\_/";
            if(preg_match($reg_exUrl, $str, $url)) {                    
                if(strpos( $url[0], ":" ) === false){
                    $link = 'http://'.$url[0];
                }else{
                    $link = $url[0];
                }
                $str = preg_replace($reg_exUrl, '<a href="'.$link.'" target="_blank" style="color:#09C; display:inline !important">'.$link.'</a>', $str);
                
            }
            $str = preg_replace(array($star_sign, $underscores), array('<b style="font-size:15px; color:#06C">$1</b>', '<u style="">$1</u>'), $str);
            return $str;
        }
        

}

    function compress($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }


    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        // First get the platform?
        if (preg_match('/android/i', $u_agent)) {
          $platform = 'android';
        }else if (preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
        }
    
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
        } elseif(preg_match('/Firefox/i',$u_agent)) {
          $bname = 'Mozilla Firefox';
          $ub = "Firefox";
        } elseif(preg_match('/Chrome/i',$u_agent)) {
          $bname = 'Google Chrome';
          $ub = "Chrome";
        } elseif(preg_match('/Safari/i',$u_agent)) {
          $bname = 'Apple Safari';
          $ub = "Safari";
        } elseif(preg_match('/Opr|Opera/i',$u_agent) || preg_match('/Opera/i',$u_agent)) {
          $bname = 'Opera';
          $ub = "Opera";
        } elseif(preg_match('/Netscape/i',$u_agent)) {
          $bname = 'Netscape';
          $ub = "Netscape";
        }
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
          // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
          //we will have two since we are not using 'other' argument yet
          //see if version is before or after the name
          if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
          } else {
            $version= $matches['version'][1];
          }
        } else {
          $version= $matches['version'][0];
        }
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
      return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
        );
    }


    function is_mobile() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
        $mobile_agents = Array(
            "240x320",
            "acer",
            "acoon",
            "acs-",
            "abacho",
            "ahong",
            "airness",
            "alcatel",
            "amoi",	
            "android",
            "anywhereyougo.com",
            "applewebkit/525",
            "applewebkit/532",
            "asus",
            "audio",
            "au-mic",
            "avantogo",
            "becker",
            "benq",
            "bilbo",
            "bird",
            "blackberry",
            "blazer",
            "bleu",
            "cdm-",
            "compal",
            "coolpad",
            "danger",
            "dbtel",
            "dopod",
            "elaine",
            "eric",
            "etouch",
            "fly " ,
            "fly_",
            "fly-",
            "go.web",
            "goodaccess",
            "gradiente",
            "grundig",
            "haier",
            "hedy",
            "hitachi",
            "htc",
            "huawei",
            "hutchison",
            "inno",
            "ipad",
            "ipaq",
            "ipod",
            "jbrowser",
            "kddi",
            "kgt",
            "kwc",
            "lenovo",
            "lg ",
            "lg2",
            "lg3",
            "lg4",
            "lg5",
            "lg7",
            "lg8",
            "lg9",
            "lg-",
            "lge-",
            "lge9",
            "longcos",
            "maemo",
            "mercator",
            "meridian",
            "micromax",
            "midp",
            "mini",
            "mitsu",
            "mmm",
            "mmp",
            "mobi",
            "mot-",
            "moto",
            "nec-",
            "netfront",
            "newgen",
            "nexian",
            "nf-browser",
            "nintendo",
            "nitro",
            "nokia",
            "nook",
            "novarra",
            "obigo",
            "palm",
            "panasonic",
            "pantech",
            "philips",
            "phone",
            "pg-",
            "playstation",
            "pocket",
            "pt-",
            "qc-",
            "qtek",
            "rover",
            "sagem",
            "sama",
            "samu",
            "sanyo",
            "samsung",
            "sch-",
            "scooter",
            "sec-",
            "sendo",
            "sgh-",
            "sharp",
            "siemens",
            "sie-",
            "softbank",
            "sony",
            "spice",
            "sprint",
            "spv",
            "symbian",
            "tablet",
            "talkabout",
            "tcl-",
            "teleca",
            "telit",
            "tianyu",
            "tim-",
            "toshiba",
            "tsm",
            "up.browser",
            "utec",
            "utstar",
            "verykool",
            "virgin",
            "vk-",
            "voda",
            "voxtel",
            "vx",
            "wap",
            "wellco",
            "wig browser",
            "wii",
            "windows ce",
            "wireless",
            "xda",
            "xde",
            "zte"
        );
    
        $is_mobile = false;
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = true;
                break;
            }
        }
        return $is_mobile;
    }


    public function compatibility(){
        $data['page_title'] = "Not Subscribed";
        $data['page_name'] = "compatibility";
        $data['page_header'] = "Not Subscribed";
        $data['validate_mem'] = "";
        $this->load->view("error", $data);
    }
    

    public function index(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
        
            $data['page_title'] = "A New Face Of Opportunity And Entertainments";
            $data['page_name'] = "";
            $data['page_header'] = "";
            $ipaddrs = $_SERVER['REMOTE_ADDR'];
            $this->sql_models->record_visitors($ipaddrs);

            $this->sql_models->reminderViaEmailAdmin();
            $this->sql_models->reminderViaEmailMembers();

            $this->sql_models->check_expired_game();
            $data['is_new_game'] = $this->sql_models->check_new_game();
            $this->sql_models->check_daily_expired_game();
            $gen_num1=substr(time(),6);

            $get_mems_id = $this->sql_models->getMemID();
            $data['get_mems_id'] = $get_mems_id;
            $data['visits'] = @number_format($this->sql_models->websiteVisits());
            $data['check_game_complete'] = $this->sql_models->check_expired_trivia_game();
            $data['show_name1'] = $this->sql_models->show_memb_name('');
            $data['contestants'] = $this->sql_models->fetchContestants('', '', '', '', '', '');
            $data['contests_no_expire'] = $this->sql_models->fetchContestants($get_mems_id.$gen_num1, 'noexpiry', '', '', '', '');
            $data['no_of_contest'] = $this->sql_models->countContestants('');
            $data['validate_mem'] = $this->sql_models->validate_member();
            $data['profile_details'] = $this->sql_models->fetchMemProfile('');
            $data['validate_mem_paid'] = $this->sql_models->validate_member_paid();
            $data['countries'] = $this->sql_models->fetchStates();
            $data['ussd_codes'] = $this->sql_models->fetchUSSDs();
            $this->load->view("header", $data);
            $this->load->view("index", $data);
            $this->load->view('footer', $data);
        }
    }


    public function pages(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "OurFavCelebs";
            $data['page_name'] = "OurFavCelebs";
            $data['page_header'] = "";
            $ipaddrs = $_SERVER['REMOTE_ADDR'];
            $this->sql_models->record_visitors($ipaddrs);
            $data['ussd_codes'] = $this->sql_models->fetchUSSDs();
            $this->sql_models->reminderViaEmailAdmin();
            $this->sql_models->reminderViaEmailMembers();

            $this->sql_models->check_expired_game();
            $this->sql_models->check_daily_expired_game();

            $data['check_game_complete'] = $this->sql_models->check_expired_trivia_game();
            $data['show_name1'] = $this->sql_models->show_memb_name('');
            $data['validate_mem'] = $this->sql_models->validate_member();
            $data['profile_details'] = $this->sql_models->fetchMemProfile('');
            $data['validate_mem_paid'] = $this->sql_models->validate_member_paid();
            $data['contestants'] = $this->sql_models->fetchContestants('', '', '', '', '', '');
            $this->load->view("header", $data);
            $this->load->view("all_pages", $data);
            $this->load->view('footer', $data);
        }
    }


    public function viewprofile(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $mem_url_id = $this->uri->segment(2);
            $data['mem_id'] = $mem_url_id;
            $memid_i = substr($mem_url_id, 0, -4);
            $data['get_mems_id'] = $this->sql_models->getMemID();
            $data['profile_details'] = $this->sql_models->fetch_A_MemProfile($mem_url_id, 'reformats');
            $data['validate_mem'] = $this->sql_models->validate_member();
            $data['show_name1'] = $this->sql_models->show_memb_name($mem_url_id);
            $data['contestants'] = $this->sql_models->fetchContestants($mem_url_id, '', '', '', '', '');
            $data['contests_no_expire'] = $this->sql_models->fetchContestants($mem_url_id, 'noexpiry', '', '', '', '');
            
            $data['con_id1'] = $this->sql_models->fetchContestants_id_no_expiry($memid_i);
            $pagnt_id = $data['con_id1'][0]['id'];
            
            $data['all_pics'] = $this->sql_models->fetchAllContestantsPics($memid_i);
            $data['winneris'] = $this->sql_models->fetchTheWinnerIs($memid_i, '');
            $data['no_of_winner'] = $this->sql_models->countWinners($memid_i);
            $sw_id = $data['contestants'][0]['sw_id'];
            $data['myvotes'] = $this->sql_models->countVotes($mem_url_id, $sw_id, 'reformats');
            $data['page_name'] = "viewprofile";

            $this->sql_models->updateViews($pagnt_id, 'pageant_activities', '');

            if($this->sql_models->fetch_A_MemProfile($mem_url_id, 'reformats')){
                $fnames = $data['show_name1']['fname'];
                $lnames = $data['show_name1']['lname'];
                $data['page_header'] = "<span>$fnames</span> <font>$lnames</font>";
                $data['page_title'] = ucwords("$fnames $lnames | OurFavCelebs Pageant");
            }else{
                $data['page_title'] = "Anonymous";
                $data['page_header'] = "Anonymous";
            }
            $this->load->view("header", $data);
            $this->load->view("viewprofile", $data);
            $this->load->view('footer', $data);
        }
    }



    public function error(){
        $data['page_title'] = "Not Subscribed | OurFavCelebs";
        $data['page_name'] = "not_sub";
        $data['page_header'] = "Not Subscribed";
        $data['validate_mem'] = "";
        $data['show_name1'] = $this->sql_models->show_memb_name('');
        $this->load->view("header", $data);
        $this->load->view("error", $data);
        $this->load->view('footer', $data);
    }


    public function about(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "About Us | OurFavCelebs";
            $data['page_name'] = "about";
            $data['page_header'] = "About Us";
            $data['validate_mem'] = "";
            $data['show_name1'] = $this->sql_models->show_memb_name('');
            $this->load->view("header", $data);
            $this->load->view("about", $data);
            $this->load->view('footer', $data);
        }
    }


    public function contact(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Contact Us | OurFavCelebs";
            $data['page_name'] = "contact";
            $data['page_header'] = "Contact Us";
            $data['validate_mem'] = "";
            $data['show_name1'] = $this->sql_models->show_memb_name('');
            $this->load->view("header", $data);
            $this->load->view("contactus", $data);
            $this->load->view('footer', $data);
        }
    }



    public function pageants(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Our Contestants";
            $data['page_name'] = "contestants";
            $data['page_header'] = "Our Contestants";
            $data['validate_mem'] = "";

            $data['param1'] = "pages";
            $record=0;
            $recordPerPage = 28;
            if($record != 0){
                $record = ($record-1) * $recordPerPage;
            }      	
            $recordCount = $this->sql_models->countContestants('');
            $empRecord = $this->sql_models->fetchContestants('', '', $record, $recordPerPage, '', '');
            if(!$empRecord)
            $empRecord = $this->sql_models->fetchContestants('', 'noexpiry', $record, $recordPerPage, '', '');

            $config['base_url'] = base_url().'node/contestant';
            
            ////////////////////
                $config["total_rows"] = $recordCount;
                $config["per_page"] = $recordPerPage;
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] = 5;
                
                $config['full_tag_open'] = '<div class="gallery-pagination conts_pagn"><div class="gallery-pagination-inner"><ul>';
                $config['full_tag_close'] = '</ul></div></div>';
    
                $config['first_link'] = FALSE;
                $config['first_tag_open'] = FALSE;
                $config['first_tag_close'] = FALSE;
                
                $config['last_link'] = FALSE;
                $config['last_tag_open'] = FALSE;
                $config['last_tag_close'] = FALSE;
    
                $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
                $config['cur_tag_close'] = '</a></li>';
                
                $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
    
                $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';
                
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
    
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            ////////////////////
            
            $data['contestants'] = $empRecord;

            $this->load->view("header", $data);
            $this->load->view("pageants", $data);
            $this->load->view('footer', $data);
        }
    }


    public function events(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Events | OurFavCelebs";
            $data['page_name'] = "events";
            $data['page_header'] = "OurFavCelebs Events";
            $data['validate_mem'] = "";
            $data['contestants'] = $this->sql_models->fetchContestants('', '', '', '', '', '');
            $data['param1'] = "";

            $record=0;
            $recordPerPage = 12;
            if($record != 0){
                $record = ($record-1) * $recordPerPage;
            }      	
            $recordCount = $this->sql_models->fetchEventsCount();

            $config['base_url'] = base_url().'node/media';
            $config['use_page_numbers'] = TRUE;
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Previous';
            $config['total_rows'] = $recordCount;
            $config['per_page'] = $recordPerPage;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['events1'] = $this->sql_models->fetchEvents('', '', $record, $recordPerPage);
            $this->load->view("header", $data);
            $this->load->view("events", $data);
            $this->load->view('footer', $data);
        }
    }


    public function viewevents(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Events | OurFavCelebs";
            $data['page_name'] = "viewevents";
            $data['page_header'] = "OurFavCelebs Events";
            $data['validate_mem'] = "";
            $event_id = $this->uri->segment(2);
            $data['param1'] = $this->uri->segment(1);
            $data['fetch_event'] = $this->sql_models->fetchAnEvent1($event_id);
            $this->load->view("header", $data);
            $this->load->view("events_single", $data);
            $this->load->view('footer', $data);
        }
    }


    public function replies(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Forum | OurFavCelebs";
            $data['page_name'] = "viewreplies";
            $data['page_header'] = "OurFavCelebs Forum";
            $data['validate_mem'] = "";
            $event_id = $this->uri->segment(2);
            $data['param1'] = $this->uri->segment(1);
            $data['profile_details'] = $this->sql_models->fetchMemProfile('');

            $id_s = substr($event_id, 0, -4);
            $data['frids'] = $id_s;

            $data['forums'] = $this->sql_models->fetchARecord($event_id, 'forums', 'phps');
            $data['fetch_views'] = $this->sql_models->updateViews($event_id, 'forums', 'phps');
            $data['validate_mem'] = $this->sql_models->validate_member();
            $get_mems_id = $this->sql_models->getMemID();
            $data['get_mems_id'] = $get_mems_id;
            $this->load->view("header", $data);
            $this->load->view("forum_reply", $data);
            $this->load->view('footer', $data);
        }
    }


    public function donation(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Donation | OurFavCelebs";
            $data['page_name'] = "donation";
            $data['page_header'] = "OurFavCelebs Donation";
            $data['countries'] = $this->sql_models->fetchStates();
            $this->load->view("header", $data);
            $this->load->view("donations", $data);
            $this->load->view('footer', $data);
        }
    }


    public function adverts(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Adverts | OurFavCelebs";
            $data['page_name'] = "adverts";
            $data['page_header'] = "Adverts";
            $this->load->view("header", $data);
            $this->load->view("adverts", $data);
            $this->load->view('footer', $data);
        }
    }


    public function judges(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Judges | OurFavCelebs";
            $data['page_name'] = "judges";
            $data['page_header'] = "Judges";
            $this->load->view("header", $data);
            $this->load->view("judges", $data);
            $this->load->view('footer', $data);
        }
    }


    public function gallery(){
        $ua = $this->getBrowser();
        if($this->is_mobile()) $devices = "mobile"; else $devices = "not_mobile";
        $brow_name = strtolower($ua['name']); $brow_version = $ua['version'];

        if(($devices=="mobile" && $brow_name=="opera" && ($brow_version=="Mini" || $brow_version<4)) || ($devices=="not_mobile" && $brow_version<15) ){
            redirect('compatibility');
        }else{
            $data['page_title'] = "Gallery | OurFavCelebs";
            $data['page_name'] = "gallery";
            $data['page_header'] = "Gallery";
            $data['gallery'] = $this->sql_models->fetchGallery();
            $this->load->view("header", $data);
            $this->load->view("photos", $data);
            $this->load->view('footer', $data);
        }
    }




    public function pageants_loads(){
        $data['param1'] = "pages";
        $record = $this->input->post('record');
        $txt_srch = $this->input->post('txt_srch');
        $sess2 = $this->input->post('ids_tl'); // title session
        $recordPerPage = 20;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	

        $recordCount = $this->sql_models->countContestants('noexpiry');
        $empRecord = $this->sql_models->fetchContestants('', '', $record, $recordPerPage, $txt_srch, $sess2);
        $sw_id = $empRecord[0]['sw_id']; // current activity
        
        if(!$empRecord)
            $empRecord = $this->sql_models->fetchContestants('', 'noexpiry', $record, $recordPerPage, $txt_srch, $sess2);
        $config['base_url'] = base_url().'node/contestant';
        
        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination conts_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
        ////////////////////
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['contestants'] = $empRecord;

        $data['recordCount'] = $recordCount;
        $data['recordPerPage'] = $recordPerPage;
        $data['c_g_id'] = $this->sql_models->current_main_game_id();
        $this->load->view('pageants', $data);
    }



    public function privacy_loads(){
        $data['page_name'] = "policy";
        $this->load->view('privacy_terms', $data);
    }


    public function contestant($record=0){
        $param1 = "pages";
        //$record=0;
        $recordPerPage = 20;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $recordCount = $this->sql_models->countContestants('noexpiry');
        $empRecord = $this->sql_models->fetchContestants('', 'noexpiry', $record, $recordPerPage, '', '');
        $config['base_url'] = base_url().'node/contestant';
        
        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination conts_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        ////////////////////

        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        if($empRecord){
            foreach ($empRecord as $rs) {
                $sw_id = $rs['sw_id'];
                $file1 = $rs['file1'];
                $file2 = $rs['file2'];
                $file3 = $rs['file3'];
                $memid = $rs['memid'];
                $mydate = $rs['dates'];
                $views = $rs['views'];
                $views2="";
                if($views>0) $views2 = "(".@number_format($views).")";
                $overall_title = ucwords($rs['overall_title']);
                $names = $this->sql_models->contestantName($memid);
                $myvotes = $this->sql_models->countVotes($memid, $sw_id, '');
                $mystates = $this->sql_models->contestantState($memid);
                $myvotes = @number_format($myvotes);
                $names1 = explode(' ', $names);
                $fname1 = $names1[0];
                $lname1 = $names1[1];

                //$my_pics = array($file1, $file2, $file3);
                //$pics = $my_pics[array_rand($my_pics, 1)];
                $pics = $file1;
                $pic_pathi = base_url()."activity_photos/$pics";
                //$pic_path = base_url()."watermark.php?image=".base_url()."activity_photos/$pics&watermark=".base_url()."images/watermrk.png";
                $pic_path = base_url()."activity_photos/$pics";

                if($pics==""){
                    $pics = $this->sql_models->profilePics($memid);
                    $pic_pathi = base_url()."celebs_uploads/$pics";
                    //$pic_path = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";
                    $pic_path = base_url()."celebs_uploads/$pics";
                }
                $mydates = date("jS F, Y", $mydate);
                $mylikes = $this->sql_models->fetchMemLikes($memid);
                $mylikes = @number_format($mylikes);
                $my_photo_cnts = $this->sql_models->fetchPhotoCounts($memid);

                $gen_num1=time();
                $gen_num1=substr($gen_num1,6);
                $names3 = str_replace(" ", "-", $names);
                $url1 = base_url()."viewprofile/$memid$gen_num1/$names3/";
                $tweets = "Hi dear, I'm $names at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";
                $title_whatsapp = "Hi dear, I'm *$names* at *OurFavCelebs*, I would like to plead for your support by voting for me, thank you in advance.";
                $sTitle_whatsapp = ucwords($title_whatsapp)."%0A%0A$url1";
                $data['c_g_id'] = $this->sql_models->current_main_game_id();
                ?>

                    <div class="col-md-3 col-sm-6 wow_ _fadeInDown scroll_to_mem<?=$memid;?>" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="feature-img">
                            <div class="photos1"><?=$my_photo_cnts;?> photos</div>
                            <div class="height_img">
                                <a href="javascript:;" class="view_profiles" activityid="<?=$sw_id;?>" memid="<?=$memid;?>" fulnames="<?=$names;?>" fname="<?=$fname1;?>" lname="<?=$lname1;?>">
                                    <img src="<?=$pic_path;?>" alt="">
                                </a>
                            </div>

                            <div class="date-feature my_names">
                                <?=$names;?>
                                <p class="states_1">
                                    <?php if($mystates!="FCT Abuja") echo "$mystates State"; ?>
                                </p>
                            </div>

                        </div>
                        <div class="feature-info group">
                            <p style="color:#333;"><b><font class="vote_counts<?=$memid;?>"><?=$myvotes;?></font> Votes | <?=$mylikes;?> Likes</b></p>
                            <p style="color:#990; font-size:14px; margin-bottom:2px;" class="pageant_name"><b><?=ucwords($overall_title);?></b></p>
                            <p style="font-size:14px; color:#666;"><?=$mydates;?></p>

                            <div class="socials socials_pageant">
                                <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook"></i></a>
                                <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><i class="fa fa-twitter"></i></a>
                                <a class="hitLink mobiles_view" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
                                <a class="hitLink not_mobiles_view" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
                            </div>
                            
                            <p class="view_pro">
                                <?php if($c_g_id==$sw_id){ ?>
                                    <a href="javascript:;" class="voteme" id="voteme" swid="<?=$sw_id;?>" names="<?=$names;?>" myvotes="<?=$myvotes;?>" memids="<?=$memid;?>" pics1="<?=$pic_pathi;?>" >Vote Me</a>
                                <?php }else{ ?>
                                    <a href="javascript:;" class="novoteme" id="novoteme" style="opacity:0.5;">Vote Me</a>
                                <?php } ?>
                                <a href="javascript:;" class="view_profiles" activityid="<?=$sw_id;?>" memid="<?=$memid;?>" fulnames="<?=$names;?>" fname="<?=$fname1;?>" lname="<?=$lname1;?>" >View <?=$views2;?></a>
                            </p>
                        </div>
                    </div>
                <?php 
            }
        }else{
            echo "<p style='text-align:center; font-size:16px;'>No contestant found!</p>";
        }
        ?>

        <div style="clear:both"></div>
        
        <?=$pagination;?>

        <?php

    }


    public function media($record=0){
        $param1 = "pages";
        //$record=0;
        $recordPerPage = 16;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $recordCount = $this->sql_models->fetchEventsCount();
        $empRecord = $this->sql_models->fetchEvents('', '', $record, $recordPerPage);

        /////////////////////////
            $config['base_url'] = base_url().'node/media';
            $config['use_page_numbers'] = TRUE;
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Previous';
            $config['total_rows'] = $recordCount;
            $config['per_page'] = $recordPerPage;

            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination event_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            //$config['next_link'] = '<a href="javascript:;" class="pagination-next"><span>Next page</span> <i class="icon-right-4"></i></a>';
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            //$config['prev_link'] = '<a href="javascript:;" class="pagination-prev"><i class="icon-left-4"></i> <span>PREV page</span></a>';
            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
        /////////////////////////

        if($empRecord){
        foreach ($empRecord as $rs) {
            $id = $rs['id'];
            $titles = strtolower($rs['titles']);
            $titles = ucwords($titles);
            $titles1 = $titles;
            $descrip = ucfirst($rs['descrip']);
            $views = $rs['views'];
            $dates = $rs['dates'];
            $mydates = date("jS F, Y", strtotime($dates));
            $views = @number_format($views);
            $files = $this->sql_models->getPics($id);
            $cmts_counts = $this->sql_models->fetchCommentCounts($id);
            if(strlen($descrip)>110)
                $descrip = substr($descrip, 0, 110)."...";

            if(strlen($titles)>70)
                $titles = substr($titles, 0, 70)."...";

            //$pic_path = base_url()."watermark.php?image=".base_url()."events_fols/$files&watermark=".base_url()."images/watermrk.png";

            $pic_path = base_url()."events_fols/$files";

            if($param1!="pages"){
                $directs = base_url()."pages/#viewevents";
                $directs1 = "pages/#viewevents";
            }else{
                $directs = "javascript:;";
                $directs1 = "";
            }
        ?>
            <div class="col-md-6 col-sm-12 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="blog-right-listing blog-right-listing2">
                    <font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer; position:relative; z-index:99">
                        <div class="feature-img feature-img1">
                            <img src="<?=$pic_path;?>" alt="Image loading...">
                        </div>
                    </font>
                    <div class="event_date"><label><?=$mydates;?></label></div>
                    <div class="feature-info feature-info1">
                        <h5><font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer;"><?=$titles;?></font></h5>
                        <p><?=$descrip;?> <a href="<?=$directs;?>" class="open_event" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="font-weight:normal; color:#0CF;">read more<i class="icon-right-4"></i></a></p>
                        <p class="statss">
                        <?php
                        if($cmts_counts>0)
                        echo "<span><i class='icon-comment-5'></i> $cmts_counts Comments</span>";
                        else
                        echo "<span style='opacity:0.7;'><i class='icon-comment-5'></i> No Comments</span>";

                        if($views>0)
                        echo "<span><i class='icon-eye-6'></i> $views Views</span>";
                        else
                        echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                        ?>

                        </p>
                        <!-- <a href="blog_single.html" class="button-default">View More <i class="icon-right-4"></i></a> -->
                    </div>
                </div>
            </div>

        <?php 
        }
        }else{
            echo "<p style='text-align:center; font-size:16px;'>No media found!</p>";
        }
        ?>
        <div style="clear:both"></div>
        
        <?=$pagination;?>

        <?php

    }


    public function events_loads(){
        $data['param1'] = "pages";
        $record=0;
        $recordPerPage = 16;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $recordCount = $this->sql_models->fetchEventsCount();
        $empRecord = $this->sql_models->fetchEvents('', '', $record, $recordPerPage);
        $config['base_url'] = base_url().'node/media';


        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination event_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            //$config['next_link'] = '<a href="javascript:;" class="pagination-next"><span>Next page</span> <i class="icon-right-4"></i></a>';
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            //$config['prev_link'] = '<a href="javascript:;" class="pagination-prev"><i class="icon-left-4"></i> <span>PREV page</span></a>';
            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        ///////////////////

        $data['events1'] = $empRecord;

        $this->load->view('events', $data);
    }




    public function donation_loads(){
        $data['countries'] = $this->sql_models->fetchStates();
        $this->load->view('donations', $data);
    }


    public function adverts_loads(){
        $this->load->view('adverts');
    }


    public function judges_loads(){
        $this->load->view('judges');
    }


    public function photos_loads(){
        $data['param1'] = "pages";
        $record=0;
        $recordPerPage = 24;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $recordCount = $this->sql_models->countMedias('pic');
        $empRecord = $this->sql_models->fetchMedias('pic', $record, $recordPerPage, '');
        $config['base_url'] = base_url().'node/photos';
        
        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination photos_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        ////////////////////
        
        $data['photos'] = $empRecord;
        //$data['pg_name'] = "photo";
        $this->load->view('photos', $data);
    }


    public function videos_loads(){
        $data['param1'] = "pages";
        $record=0;
        $recordPerPage = 24;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $recordCount = $this->sql_models->countMedias('vid');
        $empRecord = $this->sql_models->fetchMedias('vid', $record, $recordPerPage, '');
        $config['base_url'] = base_url().'node/videos';
        
        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination videos_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        ////////////////////
        
        $data['photos'] = $empRecord;
        $this->load->view('videos', $data);
    }


    public function forum_loads(){
        $data['page_f'] = $this->input->cookie('page_load', TRUE);
        $data['txtcats1_f'] = $this->input->cookie('cats_f', TRUE);
        $data['param1'] = "pages";
        $data['validate_mem'] = $this->sql_models->validate_member();
        $data['get_mems_id'] = $this->sql_models->getMemID();
        $this->load->view('forum', $data);
    }


    public function photos($record=0){
        $param1 = "pages";
        $recordPerPage = 24;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }
        $recordCount = $this->sql_models->countMedias('pic');
        $empRecord = $this->sql_models->fetchMedias('pic', $record, $recordPerPage, '');
        $config['base_url'] = base_url().'node/photos';
        
        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination photos_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        ////////////////////

        //$data['pg_name'] = "photo";
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        if($empRecord){
        foreach ($empRecord as $rs) {
            $titles = strtolower($rs['titles']);
            $titles = ucwords($titles);
            $views = $rs['views'];
            $media_type = $rs['media_type'];
            $dates = $rs['dates'];
            $files = $rs['files'];
            $mydates = date("jS F, Y", strtotime($dates));
            $views = @number_format($views);
            if(strlen($titles)>70)
                $titles = substr($titles, 0, 70)."...";

            $pic_path1 = base_url()."gallery/$files";
            //$pic_path = base_url()."watermark.php?image=".base_url()."gallery/$files&watermark=".base_url()."images/watermrk.png";

            $pic_path = base_url()."gallery/$files";
        ?>
            <div class="col-md-3 col-sm-6 col-xs-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="blog-right-listing blog-right-listing3">
                    <div class="gallery-megic-blog">
                        <a href="javascript:;" src1="<?=$pic_path1;?>" src="<?=$pic_path1;?>" class="magnific-popup enlarge_img">
                            <img src="<?=$pic_path1;?>" alt="" class="">
                            <div class="gallery-megic-inner">
                                <div class="gallery-megic-out">
                                    <div class="gallery-megic-detail">
                                        <!-- <h2>Cheese Pasta</h2> -->
                                        <span><?=$titles;?></span>
                                        <font class="statss_">
                                            <?php
                                            if($views>0)
                                            echo "<span><i class='icon-eye-6'></i> $views Views</span>";
                                            else
                                            echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                                            ?>
                                        </font>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    
                </div>
            </div>

        <?php 
        }
        }else{
            echo "<p style='text-align:center; font-size:16px;'>No photos found!</p>";
        }
        ?>

        <div style="clear:both"></div>
        <?=$pagination;?>
        
        <?php
        //sleep(2);

    }


    public function videos($record=0){
        $param1 = "pages";
        $recordPerPage = 24;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }
        //echo $record."ddd";
        $recordCount = $this->sql_models->countMedias('vid');
        $empRecord = $this->sql_models->fetchMedias('vid', $record, $recordPerPage, '');
        $config['base_url'] = base_url().'node/videos';
        
        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination videos_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            //$data['pg_name'] = "video";
            $data['pagination'] = $this->pagination->create_links();
        ////////////////////

        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        if($empRecord){
        foreach ($empRecord as $rs) {
            $titles = strtolower($rs['titles']);
            $titles = ucwords($titles);
            $views = $rs['views'];
            $media_type = $rs['media_type'];
            $dates = $rs['dates'];
            $files = $rs['files'];
            $mydates = date("jS F, Y", strtotime($dates));
            $views = @number_format($views);
            if(strlen($titles)>70)
                $titles = substr($titles, 0, 70)."...";
        ?>
            <div class="col-md-4 col-sm-12 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="blog-right-listing blog-right-listing3 listings">
                    <div class="gallery-megic-blog">

                        <!-- <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="560" height="200" type="text/html" src="https://www.youtube.com/embed/<?=$files;?>?autoplay=0&fs=0&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0&origin=https://youtubeembedcode.com">
                            <div>
                                <small><a href="https://youtubeembedcode.com/en">youtubeembedcode.com/en/</a></small>
                            </div>
                        </iframe> -->
                        <iframe src="http://www.youtube.com/embed/<?=$files;?>" class="youtubevid" frameborder="0" allowfullscreen></iframe>   
                        <div class="gallery-megic-detail_ vid_titles">
                            <p><?=$titles;?></p>
                            <font class="statss">
                                <?php
                                if($views>0)
                                echo "<span><i class='icon-eye-6'></i> $views Views</span>";
                                else
                                echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                                ?>
                            </font>
                        </div>
                    </div>
                </div>
            </div>

        <?php 
        }
        }else{
            echo "<p style='text-align:center; font-size:16px;'>No videos found!</p>";
        }
        ?>

        <div style="clear:both"></div>
        <?=$pagination;?>
        
        <?php

    }


    public function winneris_loads(){
        $data['winneris'] = $this->sql_models->fetchTheWinnerIs('', '');
        $data['winneris_limit'] = $this->sql_models->fetchTheWinnerIs('', 'limits');
        $this->load->view('winner_is', $data);
    }



    public function participants_loads(){
        $data['validate_mem'] = $this->sql_models->validate_member();
        $gameid = $this->sql_models->current_day_game_id();
        $data['gameid'] = $gameid;
        $data['profile_details'] = $this->sql_models->fetchMemProfile('');
        $data['my_main_acts'] = $this->sql_models->fetchMainActivity();

        $data['game_title'] = $this->sql_models->current_game_title($gameid);
        $data['my_acts'] = $this->sql_models->fetchActivity_row();
        $data['my_acts_arr'] = $this->sql_models->fetchActivity_arr();
        $data['count_day_acts'] = $this->sql_models->countDays();
        $data['totalquiz'] = $this->sql_models->countQuiz();
        $data['quiz_intro'] = $this->sql_models->quizIntro();

        $quizid_taken = $this->session->userdata('quizid');
        if(empty($quizid_taken))
            $data['quiz_quests'] = $this->sql_models->quizQuestions('');
        else
            $data['quiz_quests'] = $this->sql_models->quizQuestions($quizid_taken);

        $get_mems_id = $this->sql_models->getMemID();
        $data['get_mems_id'] = $get_mems_id;
        $what_day = $data['game_title']['for_days'];
        $data['check_act_complete'] = $this->sql_models->checkActivityComplete($get_mems_id, $gameid, $what_day);
        $data['check_game_complete'] = $this->sql_models->check_expired_trivia_game();
        if(!$this->sql_models->check_uncomplete_profile()){
            if($this->sql_models->validate_member_paid()){
                $this->load->view('participate', $data);
            }else
                echo "logged_out";
        }else{
            echo "not_complete";
            $this->load->view('participate', $data);
        }
    }


    public function profile_loads(){
        $memids = $this->input->post('memids');
        $sw_id = $this->input->post('activityid');
        $data['con_id'] = $this->sql_models->fetchContestants_id($memids);
        $data['con_id1'] = $this->sql_models->fetchContestants_id_no_expiry($memids);
        $pagnt_id = $data['con_id1'][0]['id'];
        //echo $pagnt_id."ssss";
        //echo "<br><br><br><br><br><br><br>"; exit;
        $gen_num1=time();
        $gen_num1=substr($gen_num1,6);
        $data['all_pics'] = $this->sql_models->fetchAllContestantsPics($memids);
        //print_r($data); echo "<br><br><br><br><br><br><br>"; exit;
        $data['myvotes'] = $this->sql_models->countVotes($memids, $sw_id, '');
        //$data['contestants'] = $this->sql_models->fetchContestants($memids.$gen_num1, '', '', '', '', '');
        //$data['contests_no_expire'] = $this->sql_models->fetchContestants($memids.$gen_num1, 'noexpiry', '', '', '', '');
        $data['winneris'] = $this->sql_models->fetchTheWinnerIs($memids, '');
        $data['no_of_winner'] = $this->sql_models->countWinners($memids);
        $data['validate_mem'] = $this->sql_models->validate_member();
        $data['profile_details'] = $this->sql_models->fetchMemProfile($memids);
        $this->sql_models->updateViews($pagnt_id, 'pageant_activities', '');
        $this->load->view('viewprofile', $data);
    }


    public function event_view_loads(){
        $evtid = $this->input->post('evtid');
        $data['fetch_event'] = $this->sql_models->fetchARecord($evtid, 'events', '');
        $data['fetch_views'] = $this->sql_models->updateViews($evtid, 'events', '');
        $data['param1'] = "pages";
        $this->load->view('events_single', $data);
    }


    public function forum_view_loads(){
        $frid = $this->input->post('frid');
        $data['forums'] = $this->sql_models->fetchARecord($frid, 'forums', '');
        $data['fetch_views'] = $this->sql_models->updateViews($frid, 'forums', '');
        $data['validate_mem'] = $this->sql_models->validate_member();
        $data['get_mems_id'] = $this->sql_models->getMemID();
        $data['page_name'] = "replyloads";
        $data['frids'] = $frid;
        $data['param1'] = "pages";
        $this->load->view('forum_reply', $data);
    }

    
    public function save_donate_vals(){
        $this->form_validation->set_rules('txtd_fname', 'full names', 'required|trim|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('txtd_phone', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
        $this->form_validation->set_rules('txtd_email', 'email', 'required|trim|valid_email');
        $this->form_validation->set_rules('txtd_state', 'state', 'required|trim');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            echo "validateds";
        }
    }


    public function save_donate_vals1(){
        $txtd_fname = $this->input->post('txtd_fname');
        $txtd_phone = $this->input->post('txtd_phone');
        $txtd_email = $this->input->post('txtd_email');
        $txtd_state = $this->input->post('txtd_state');
        $txtamts = $this->input->post('txtamts');

        $newdata3 = array(
            'names'         => $txtd_fname,
            'phones'        => $txtd_phone,
            'emails'        => $txtd_email,
            'states'        => $txtd_state,
            'amts'          => $txtamts,
            'payment_type'  => 'mp',
            'dates'         => @date("Y-m-d g:i a", time())
        );
        
        $this->session->set_userdata($newdata3);
        $insert_donatn = $this->sql_models->insert_donatn($newdata3);
        if($insert_donatn){
            // $headers = 'MIME-Version: 1.0'."\r\n";
            // $headers .= 'From: OurFavCelebs Donations <info@ourfavcelebs.com>'. "\r\n";
            // $headers .= 'Content-Type: text/html; charset=iso-8859-1'. "\r\n";
            // $headers .= 'X-Mailer: PHP';
            // $email_subject = "OurFavCelebs Donations";

            $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
            $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello $txtd_fname,</b></p>";
            $message_contents .= "<p style='font-size:14px; margin-top:10px'>
            Thank you for your kindness, we really appreciate your donation. We will place a call on you between now and 30 minutes time.
            </p>";

            $message_contents .= "<p style='font-size:14px; margin-top:10px'>
            Kindly make your donation to the company's account details below.
            </p>";

            $message_contents .= "<p style='font-size:13px; line-height:1.4em;'>
            <font style='color:#333;'>Account Name:</font>&nbsp;<font style='color:#990'><b>Brand Envoy Africa Limited</b></font><br>
            <font style='color:#333;'>Bank Name:</font>&nbsp;<font style='color:#990'><b>Zenith Bank PLC</b></font><br>
            <font style='color:#333;'>Account Number:</font>&nbsp;<font style='color:#990; letter-spacing:0.5px'><b>1014456878</b></font><br>
            <font style='color:#333;'>Donation Amount:</font>&nbsp;<font color='#0099FF' style='font-size:14px'><b>NGN$txtamts</b></font><br>
            </p>";

            $message_contents .= "<p style='font-size:14px; margin:10px 0 20px 0'>Thank you!</p>";
            $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
            $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

            $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
            $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'from' => "OurFavCelebs Donations <info@ourfavcelebs.com>",
                'to' => $txtd_email,
                'subject' => "OurFavCelebs Donations",
                'html' => $message_contents
            ));
            $result = curl_exec($ch);
            curl_close($ch);

            //$mailme = @mail($txtd_email, $email_subject, $message_contents, $headers);
            echo "inserted";
        }else{
            echo "Error! Poor network connection";
        }
    }


    public function post_comment(){
        $this->form_validation->set_rules('txtcmts', 'comment', 'required|trim');
        $this->form_validation->set_rules('txtnms', 'names', 'required|trim|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('txtmails', 'email', 'required|trim|valid_email');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtcmts = ucfirst($this->input->post('txtcmts'));
            $txtnms = ucwords($this->input->post('txtnms'));
            $txtmails = $this->input->post('txtmails');
            $txtevent_id = $this->input->post('txtevent_id');
            $date1 = @date("jS F, Y h:i A", time());

            $newdata3 = array(
                'event_id'  => $txtevent_id,
                'names'     => $txtnms,
                'emails'    => $txtmails,
                'replies'   => $txtcmts,
                'dates'     => @date("Y-m-d g:i a", time())
            );
            
            $this->session->set_userdata($newdata3);
            $insert_cmts = $this->sql_models->insert_cmts($newdata3);
            if($insert_cmts){
                echo "inserted";
                echo "<div class='comment-inner-list'>
                <div class='comment-img'>
                    <img src='".base_url()."images/no_passport.jpg' alt=''>
                </div>
                <div class='comment-info'>
                    <h5>$txtnms</h5>
                    <span class='comment-date'>$date1</span>
                    <p>$txtcmts</p>
                </div>
                </div>";
            }else{
                echo "Error! Poor network connection";
            }

        }
    }


    public function dashboard_loads(){
        $data['validate_mem'] = $this->sql_models->validate_member();
        $data['profile_details'] = $this->sql_models->fetchMemProfile('');
        $data['countries'] = $this->sql_models->fetchStates();
        if($this->sql_models->validate_member())
            $this->load->view('dashboard', $data);
        else
            echo "logged_out";
    }


    function login_scrolldown(){
        $now = 2147483647 - time();
        $cookie = array(
            'name'   => 'mylogins1',
            'value'  => 'down_to_login',
            'expire' => $now,
            'secure' => FALSE
        );
        set_cookie($cookie);
    }


    function login_scrolldown1(){
        $now = 2147483647 - time();
        $cookie = array(
            'name'   => 'mylogins1',
            'value'  => '',
            'expire' => $now,
            'secure' => FALSE
        );
        set_cookie($cookie);
    }



    function update_my_prof_pass(){
        $this->form_validation->set_rules('txtpass1', 'Old password', 'required|trim');
        $this->form_validation->set_rules('txtpass2', 'New password', 'required|trim|matches[txtpass3]');
        $this->form_validation->set_rules('txtpass3', 'confirm Password', 'required|trim');

        if(!$this->sql_models->validate_member()){
            echo "logged_out";
        }else{
            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{
                $query = $this->sql_models->checkOldPass(sha1($this->input->post('txtpass1')));
                if($query){
                    $updated = $this->sql_models->update_user_pass1(sha1($this->input->post('txtpass3')), $this->input->post('txtpass1'));
                    if($updated){
                        $now = 2147483647 - time();

                        $cookie = array(
                            'name'   => 'my_passwords',
                            'value'  => sha1($this->input->post('txtpass3')),
                            'expire' => $now,
                            'secure' => FALSE
                        );
                        set_cookie($cookie);
                        echo "success_updated_pass1";
                    }else{
                        echo "Update failed to submit!";
                    }
                }else{
                    echo "This is not your old password!";
                }

            }
        }
    }


    function store_my_ansa(){
        if(!$this->sql_models->validate_member_paid()){
            echo "logged_out";
        }else{
            
            $txtans1 = trim($this->input->post('txtans1'));
            $txtrandom_quiz = trim($this->input->post('txtrandom_quiz'));

            $my_answers = $this->session->userdata('my_answers');
            $quizid = $this->session->userdata('quizid');
            
            if(isset($my_answers) && $my_answers!=""){
                $txtans2 = $my_answers;
                $txtrandom_quiz2 = $quizid;
            }else{
                $txtans2 = "";
                $txtrandom_quiz2 = "";
            }
            
            $txtans2 .= $txtans1."||";
            $txtrandom_quiz2 .= "$txtrandom_quiz,";
            
            $newdata3 = array(
                'my_answers' => $txtans2,
                'quizid'     => $txtrandom_quiz2,
            );
            $this->session->set_userdata($newdata3);

            $results = "";
            $quizid_taken = $this->session->userdata('quizid');
            $quiz_quests = $this->sql_models->quizQuestions($quizid_taken);

            if($quiz_quests){
                $qid = $quiz_quests['ids'];
                $questions = ucfirst($quiz_quests['questions']);
                $files = $quiz_quests['files'];
                $op1 = $quiz_quests['op1'];
                $op2 = $quiz_quests['op2'];
                $op3 = $quiz_quests['op3'];
                $op4 = $quiz_quests['op4'];
                $op5 = $quiz_quests['op5'];
                $ans1 = $quiz_quests['ans1'];
                $sessions1 = $quiz_quests['sessions1'];
                $op1_1=$op1; $op1_2=$op2; $op1_3=$op3; $op1_4=$op4; $op1_5=$op5;
            
                $all_options = array($op1, $op2, $op3, $op4, $op5);
                if($op1!="" && $op2!="" && $op3=="" && $op4=="" && $op5=="") $all_options = array($op1, $op2);
                if($op1!="" && $op2!="" && $op3!="" && $op4=="" && $op5=="") $all_options = array($op1, $op2, $op3);
                if($op1!="" && $op2!="" && $op3!="" && $op4!="" && $op5=="") $all_options = array($op1, $op2, $op3, $op4);
                shuffle($all_options);
        
                $files1="";
                if($files!=""){
                    $paths = base_url()."quizes/$files";
                    $files1 = "<div style='margin-bottom:15px' class='quiz_img'><img src='$paths' style='width:100%'></div>";
                }
                    
                $results .= "<input type='text' name='txtrandom_quiz' id='txtrandom_quiz' value='$qid'>";
                $results .= "<ul class='quiz_question'>
                    <li style='font-size:16px; line-height:22px; color:#ccc;'><font id='txtpage_number_h'>1.</font> $questions</li>
                </ul>";

                $results .= "<ul class='quiz_options' ids='$qid'>";
                $results .= $files1;
                $k=1;
                foreach($all_options as $keys){
                    if($k == 1) $m="<b>A)</b>";
                    else if($k == 2) $m="<b>B)</b>";
                    else if($k == 3) $m="<b>C)</b>";
                    else if($k == 4) $m="<b>D)</b>";
                    else $m="<b>E)</b>";
                    $keys1 = ucfirst($keys);
                    $results .= "<li><label for='options$keys'>$m <input type='radio' name='options1' value='$op1_1' class='$keys' id='options$keys' ids='$qid'> $keys1</label></li>";
                    $k++;
                }
                $results .= "</ul>";

                echo $results;
            //}else{
                //echo "<p style='color:#ccc; text-align:center;'>No more questions!</p>";
            }
        }
    }



    function submit_my_questions(){
        $txtsessions = $this->input->post('txtsessions');
        $txtact_id = $this->input->post('txtact_id');
        $quiz_ids = $this->input->post('quiz_ids');
        $former_file = $this->input->post('former_file');
        $txtquestions = $this->input->post('txtquestions');
        $txtop1 = $this->input->post('txtop1');
        $txtop2 = $this->input->post('txtop2');
        $txtop3 = $this->input->post('txtop3');
        $txtop4 = $this->input->post('txtop4');
        $txtop5 = $this->input->post('txtop5');
        $txtans = $this->input->post('txtans');
        $txtquizid = $this->input->post('txtquizid');
        //$txturl1 = $this->input->post('txturl1');

        if($txtact_id!=""){

            if($txtans=="A") $txtans=$txtop1;
            else if($txtans=="B") $txtans=$txtop2;
            else if($txtans=="C") $txtans=$txtop3;
            else if($txtans=="D") $txtans=$txtop4;
            else $txtans=$txtop5;
                    
            $path4 = @$_FILES['file_quiz']['name'];
            $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
            $img_ext_chk1 = array('jpg','png','jpeg');

            if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['file_quiz']['name']) && @$_FILES['file_quiz']['name'] != "")
                echo "Please select a valid image of the formats jpg, jpeg or png<br>";
            else if(isset($_FILES['file_quiz']['name']) && @$_FILES['file_quiz']['size'] > 2097152)
                echo "Your profile photo has exceeded 2MB<br>";
            else{
                $randm = time();
                $rename_file = "$randm.$ext4";
                
                $url_source = "fake_fols/".$rename_file;
                $url_dest = "quizes/".$rename_file;
                
                $new_name4 = $rename_file;
                if(isset($_FILES['file_quiz']['name']) && @$_FILES['file_quiz']['name'] != ''){
                    $file_tmp = @$_FILES["file_quiz"]["tmp_name"];
                    if(is_uploaded_file($file_tmp) && isset($_FILES['file_quiz']['name']) ){
                        if($quiz_ids != "")
                            $this->sql_models->delete_quiz_pics($former_file);

                        move_uploaded_file($file_tmp, $url_source);
                        $d = $this->compress($url_source, $url_dest, 40);
                    }

                    $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                    if(is_readable($in_folder1)) @unlink($in_folder1);

                    if($quiz_ids==""){
                        $newdata3 = array(
                            'sessions1'       => $txtsessions,
                            'activity_id'     => $txtact_id,
                            'questions'       => $txtquestions,
                            'files'           => $new_name4,
                            'op1'             => $txtop1,
                            'op2'             => $txtop2,
                            'op3'             => $txtop3,
                            'op4'             => $txtop4,
                            'op5'             => $txtop5,
                            'ans1'            => $txtans
                        );

                    }else{
                        $newdata3 = array(
                            'questions'       => $txtquestions,
                            'files'           => $new_name4,
                            'op1'             => $txtop1,
                            'op2'             => $txtop2,
                            'op3'             => $txtop3,
                            'op4'             => $txtop4,
                            'op5'             => $txtop5,
                            'ans1'            => $txtans
                        );

                    }

                }else{ // image not set
                    if($quiz_ids==""){
                        $newdata3 = array(
                            'sessions1'       => $txtsessions,
                            'activity_id'     => $txtact_id,
                            'questions'       => $txtquestions,
                            'op1'             => $txtop1,
                            'op2'             => $txtop2,
                            'op3'             => $txtop3,
                            'op4'             => $txtop4,
                            'op5'             => $txtop5,
                            'ans1'            => $txtans
                        );

                    }else{
                        $newdata3 = array(
                            'questions'       => $txtquestions,
                            'op1'             => $txtop1,
                            'op2'             => $txtop2,
                            'op3'             => $txtop3,
                            'op4'             => $txtop4,
                            'op5'             => $txtop5,
                            'ans1'            => $txtans
                        );
                    }
                }

                $newdata3 = $this->security->xss_clean($newdata3);
                $querys1 = $this->sql_models->update_inserts_quizes($newdata3, $quiz_ids, $new_name4, $txtquizid);
                echo $querys1;
                // if($querys1){
                //     echo "inserted";
                // }else{
                //     echo "Network Error";
                // }
            }
        }else{
            echo "errors";
        }
    }



    function post_comments(){
        $this->form_validation->set_rules('txtcats', 'category', 'required|trim');
        $this->form_validation->set_rules('post_content', 'comment', 'required|trim');
    
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txtmemsid = $this->input->post('txtmemsid');
            $txtcats = $this->input->post('txtcats');
            $post_content = $this->input->post('post_content');
            $former_file = $this->input->post('former_file1');
            $edit_ids = $this->input->post('edit_ids');
            
            if($txtmemsid!=""){ // if member id is not empty
                        
                $path4 = @$_FILES['file4']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');

                if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['file4']['name']) && @$_FILES['file4']['name'] != "")
                    echo "Please select a valid image of the formats jpg, jpeg or png<br>";
                else if(isset($_FILES['file4']['name']) && @$_FILES['file4']['size'] > 4194304)
                    echo "Your profile photo has exceeded 4MB<br>";
                else{
                    $randm = time();
                    $rename_file = "$randm.$ext4";
                    
                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "forum_files/".$rename_file;
                    
                    $new_name4 = $rename_file;
                    if(isset($_FILES['file4']['name']) && @$_FILES['file4']['name'] != ''){
                        $file_tmp = @$_FILES["file4"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file4']['name']) ){
                            if($edit_ids != "")
                                $this->sql_models->delete_forum_pics($former_file);

                            move_uploaded_file($file_tmp, $url_source);
                            $d = $this->compress($url_source, $url_dest, 40);
                        }

                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);


                        if($edit_ids==""){
                            $newdata3 = array(
                                'memid'      => $txtmemsid,
                                'topics'     => $txtcats,
                                'messages'   => $post_content,
                                'files'      => $new_name4,
                                'views'      => 0,
                                'dates'      => @date("Y-m-d g:i a", time())
                            );

                        }else{
                            $newdata3 = array(
                                'topics'     => $txtcats,
                                'messages'   => $post_content,
                                'files'      => $new_name4,
                            );

                        }

                    }else{ // image not set
                        if($edit_ids==""){
                            $newdata3 = array(
                                'memid'      => $txtmemsid,
                                'topics'     => $txtcats,
                                'messages'   => $post_content,
                                'views'      => 0,
                                'dates'      => @date("Y-m-d g:i a", time())
                            );

                        }else{
                            $newdata3 = array(
                                'memid'      => $txtmemsid,
                                'topics'     => $txtcats,
                                'messages'   => $post_content
                            );
                        }
                    }

                    $newdata3 = $this->security->xss_clean($newdata3);
                    $querys1 = $this->sql_models->update_insert_forum($newdata3, $edit_ids);
                    echo $querys1;
                    // if($querys1){
                    //     echo "inserted";
                    // }else{
                    //     echo "Network Error";
                    // }
                }
            }else{
                echo "Posting comment has failed, please login.";
            }
        }
    }


    
    function post_comments_rep(){
        $this->form_validation->set_rules('post_content_rep', 'reply', 'required|trim');
    
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txtmemsid = $this->input->post('memid_rep');
            $post_content = $this->input->post('post_content_rep');
            //$former_file = $this->input->post('former_file1');
            $edit_ids = $this->input->post('fr_ids');
            
            if($txtmemsid!=""){ // if member id is not empty
                        
                $path4 = @$_FILES['file4_rep']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');

                if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['file4_rep']['name']) && @$_FILES['file4_rep']['name'] != "")
                    echo "Please select a valid image of the formats jpg, jpeg or png<br>";
                else if(isset($_FILES['file4_rep']['name']) && @$_FILES['file4_rep']['size'] > 4194304)
                    echo "Your profile photo has exceeded 4MB<br>";
                else{
                    $randm = time();
                    $rename_file = "$randm.$ext4";
                    
                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "forum_files/".$rename_file;
                    
                    $new_name4 = $rename_file;
                    if(isset($_FILES['file4_rep']['name']) && @$_FILES['file4_rep']['name'] != ''){
                        $file_tmp = @$_FILES["file4_rep"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file4_rep']['name']) ){
                            //if($edit_ids != "")
                                //$this->sql_models->delete_forum_pics($former_file);

                            move_uploaded_file($file_tmp, $url_source);
                            $d = $this->compress($url_source, $url_dest, 40);
                        }

                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        $newdata3 = array(
                            'memid'      => $txtmemsid,
                            'forum_id'   => $edit_ids,
                            'replies'    => $post_content,
                            'files'      => $new_name4,
                            'dates'      => @date("Y-m-d g:i a", time())
                        );

                    }else{ // image not set
                        $newdata3 = array(
                            'memid'      => $txtmemsid,
                            'forum_id'   => $edit_ids,
                            'replies'    => $post_content,
                            'files'      => "",
                            'dates'      => @date("Y-m-d g:i a", time())
                        );
                    }

                    $newdata3 = $this->security->xss_clean($newdata3);
                    $querys1 = $this->sql_models->update_insert_forum_reply($newdata3, $edit_ids);
                    echo $querys1;
                }
            }else{
                echo "Posting comment has failed, please login.";
            }
        }
    }

    
    
    function reg_members_2(){
        $txtmember = $this->input->post('txtmember');

        //if(!$this->sql_models->validate_member_paid() && $txtmember!=""){
        if(!$this->sql_models->validate_member() && $txtmember!=""){
            echo "logged_out";
        }else{

            if($txtmember != ""){ // if updating
                $this->form_validation->set_rules('txtfname', 'first name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
                $this->form_validation->set_rules('txtlname', 'last name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
                $this->form_validation->set_rules('phone1', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
                $this->form_validation->set_rules('email1', 'email', 'required|trim|valid_email');
                $this->form_validation->set_rules('txtstate', 'state', 'required|trim');
                $this->form_validation->set_rules('txtgender', 'gender', 'required|trim');
                $this->form_validation->set_rules('txthoby', 'hobbie', 'required|trim');
                $this->form_validation->set_rules('txtlikes1', 'likes', 'required|trim');
                $this->form_validation->set_rules('txtdislikes1', 'dislikes', 'required|trim');
                $this->form_validation->set_rules('txtkindpart', 'kind of partner', 'required|trim');
                $this->form_validation->set_rules('txtbios', 'biography', 'required|trim');
                $this->form_validation->set_rules('txt_relatn', 'relationship status', 'required|trim');
            }else{
                $this->form_validation->set_rules('txtcodes', 'verification code', 'required|trim');
            }

            $this->form_validation->set_rules('txtoccu', 'occupation', 'required|trim');
            

            $txtcodes = $this->input->post('txtcodes');
            $txtf0 = $this->input->post('txtf0');
            $txtfname = $this->input->post('txtfname');
            $txtlname = $this->input->post('txtlname');
            $phone1 = $this->input->post('phone1');
            $email1 = $this->input->post('email1');
            $txtpass1 = $this->input->post('txtpass1');
            $txtpass2 = $this->input->post('txtpass2');
            $txtstate = $this->input->post('txtstate');
            $txtgender = $this->input->post('txtgender');
            $txtoccu = $this->input->post('txtoccu');
            $txthear = $this->input->post('txthear');
            $txthoby = $this->input->post('txthoby');
            $txtlikes1 = $this->input->post('txtlikes1');
            $txtdislikes1 = $this->input->post('txtdislikes1');
            $txtkindpart = $this->input->post('txtkindpart');
            $txtbios = $this->input->post('txtbios');
            $txt_relatn = $this->input->post('txt_relatn');
            $txt_yes_file_bma = $this->input->post('txt_yes_file_bma');
            
            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{

                if($txtcodes!="")
                    $valid_code = $this->sql_models->check_valid_code($txtcodes, $email1);
                else
                    $valid_code = true;

                if($valid_code==true){
                    $path4 = @$_FILES['txt_bma_pic']['name'];
                    $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                    $img_ext_chk1 = array('jpg','png','jpeg');

                    if(@$_FILES['txt_bma_pic']['name'] == "" && $txt_yes_file_bma==0)
                        echo "Please upload your profile photo and continue<br>";
                    else if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != "")
                        echo "Please select a valid image for profile photo<br>";
                    else if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['size'] > 4194304)
                        echo "Your profile photo has exceeded 4MB<br>";
                    else{
                        $type = explode('.', @$_FILES["txt_bma_pic"]["name"]);
                        $type = $type[count($type)-1];
                        $randm = time();
                        $rename_file = "$randm.$ext4";
                        
                        $url_source = "fake_fols/".$rename_file;
                        $url_dest = "celebs_uploads/".$rename_file;
                        
                        $new_name4 = $rename_file;
                        if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != ''){
                            $file_tmp = @$_FILES["txt_bma_pic"]["tmp_name"];
                            if(is_uploaded_file($file_tmp) && isset($_FILES['txt_bma_pic']['name']) ){
                                if($txtmember != "")
                                    $this->sql_models->delete_memb_pics($txtf0);

                                move_uploaded_file($file_tmp, $url_source);
                                $d = $this->compress($url_source, $url_dest, 35);
                            }

                            $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                            if(is_readable($in_folder1)) @unlink($in_folder1);

                            if($txtmember==""){
                                $newdata3 = array(
                                    'approved'           => 0,
                                    'fname'              => $txtfname,
                                    'lname'              => $txtlname,
                                    'emails'             => $email1,
                                    'phones'             => $phone1,
                                    'statee'             => $txtstate,
                                    'gender'             => $txtgender,
                                    'pass'               => sha1($txtpass1),
                                    'occupatn'           => $txtoccu,
                                    'hear_about'         => $txthear,
                                    'relationshp_status' => "",
                                    'hobbies'            => "",
                                    'likes'              => "",
                                    'dislikes'           => "",
                                    'bios'               => "",
                                    'kind_of_partner'    => "",
                                    'pics'               => $new_name4,
                                    'paid'               => 0,
                                    'sent_pay_mail'      => 1,
                                    'dates'              => @date("Y-m-d g:i a", time())
                                );

                            }else{
                                $newdata3 = array(
                                    'fname'              => $txtfname,
                                    'lname'              => $txtlname,
                                    'emails'             => $email1,
                                    'phones'             => $phone1,
                                    'statee'             => $txtstate,
                                    'gender'             => $txtgender,
                                    'occupatn'           => $txtoccu,
                                    'hear_about'         => $txthear,
                                    'relationshp_status' => $txt_relatn,
                                    'hobbies'            => $txthoby,
                                    'likes'              => $txtlikes1,
                                    'dislikes'           => $txtdislikes1,
                                    'bios'               => $txtbios,
                                    'kind_of_partner'    => $txtkindpart,
                                    'pics'               => $new_name4
                                );

                            }

                        }else{ // image not set
                            if($txtmember==""){
                                $newdata3 = array(
                                    'approved'           => 0,
                                    'fname'              => $txtfname,
                                    'lname'              => $txtlname,
                                    'emails'             => $email1,
                                    'phones'             => $phone1,
                                    'statee'             => $txtstate,
                                    'gender'             => $txtgender,
                                    'pass'               => sha1($txtpass1),
                                    'occupatn'           => $txtoccu,
                                    'hear_about'         => $txthear,
                                    'relationshp_status' => "",
                                    'hobbies'            => "",
                                    'likes'              => "",
                                    'dislikes'           => "",
                                    'bios'               => "",
                                    'kind_of_partner'    => "",
                                    'paid'               => 0,
                                    'sent_pay_mail'      => 1,
                                    'dates'              => @date("Y-m-d g:i a", time())
                                );

                            }else{
                                $newdata3 = array(
                                    'fname'              => $txtfname,
                                    'lname'              => $txtlname,
                                    'emails'             => $email1,
                                    'phones'             => $phone1,
                                    'statee'             => $txtstate,
                                    'gender'             => $txtgender,
                                    'occupatn'           => $txtoccu,
                                    'hear_about'         => $txthear,
                                    'relationshp_status' => $txt_relatn,
                                    'hobbies'            => $txthoby,
                                    'likes'              => $txtlikes1,
                                    'dislikes'           => $txtdislikes1,
                                    'bios'               => $txtbios,
                                    'kind_of_partner'    => $txtkindpart
                                    //'pics'               => $new_name4
                                );

                            }
                        }

                        $newdata3 = $this->security->xss_clean($newdata3);
                        $now = 2147483647 - time();
                        if($txtmember==""){
                            $querys0 = $this->sql_models->check_mem_details($email1, $phone1);

                            if($querys0){
                                $querys1 = $this->sql_models->update_inserts_members($newdata3, $email1, $phone1, '');
                                if(!$querys1)
                                    echo "Error in network connection!";
                                else{
                                    $cookie = array(
                                        'name'   => 'my_usernames',
                                        'value'  => sha1($email1),
                                        'expire' => $now,
                                        'secure' => FALSE
                                    );

                                    $cookie1 = array(
                                        'name'   => 'my_passwords',
                                        'value'  => sha1($txtpass1),
                                        'expire' => $now,
                                        'secure' => FALSE
                                    );
                                    @set_cookie($cookie);
                                    @set_cookie($cookie1);

                                    // $headers = 'MIME-Version: 1.0'."\r\n";
                                    // $headers .= 'From: OurFavCelebs Successful Registration <info@ourfavcelebs.com>'. "\r\n";
                                    // $headers .= 'Content-Type: text/html; charset=iso-8859-1'. "\r\n";
                                    // $headers .= 'X-Mailer: PHP';
                                    //$email_subject = "OurFavCelebs Successful Registration";

                                    $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                                    $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello $txtfname,</b></p>";
                                    $message_contents .= "<p style='font-size:14px; margin-top:10px'>
                                    Thank you for being part of OurFavCelebs Pageant Competition, we hope you will enjoy all the benefits,
                                    fun games, activities and prizes of the platform. Kindly be active and participate on the activities
                                    for you to be among our celebrities on the platform and our social media handles.
                                    </p>";

                                    $message_contents .= "<p style='font-size:14px; margin-top:10px'>
                                    Kindly make your payments to the company's account details below to complete your registration
                                    </p>";

                                    $message_contents .= "<p style='font-size:13px; line-height:1.4em;'>
                                    <font style='color:#333;'>Account Name:</font>&nbsp;<font style='color:#990'><b>Brand Envoy Africa Limited</b></font><br>
                                    <font style='color:#333;'>Bank Name:</font>&nbsp;<font style='color:#990'><b>Zenith Bank PLC</b></font><br>
                                    <font style='color:#333;'>Account Number:</font>&nbsp;<font style='color:#990; letter-spacing:0.5px'><b>1014456878</b></font><br>
                                    <font style='color:#333;'>Amount to be paid:</font>&nbsp;<font color='#0099FF' style='font-size:14px'><b>NGN1,000.00</b></font><br>
                                    </p>";
                    
                                    $message_contents .= "<p style='font-size:14px; margin:20px 0 20px 0'>Thank you!</p>";
                                    $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                                    $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";
                                    

                                    $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
                                    $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                    curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                    curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                                        'from' => "OurFavCelebs Successful Registration <info@ourfavcelebs.com>",
                                        'to' => $email1,
                                        'subject' => "OurFavCelebs Successful Registration",
                                        'html' => $message_contents
                                    ));
                                    $result = curl_exec($ch);
                                    curl_close($ch);

                                    //$mailme = @mail($email1, $email_subject, $message_contents, $headers);

                                    $this->sql_models->update_codes($txtcodes, $email1);
                                    echo "done_2$new_name4";
                                }
                            }else{
                                echo "Email or phone number already exists";
                            }
                        }else{ // update
                            $querys1 = $this->sql_models->update_inserts_members($newdata3, $email1, $phone1, $txtmember);

                            if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != '')
                                echo "done_2$new_name4";
                            else
                                echo "done_2";
                        }
                        //echo "done_2";
                    }
                }else{
                    echo "The verification code is not correct!";
                }
            }
        }
    }



    function submit_activities(){
        if(!$this->sql_models->validate_member_paid()){
            echo "logged_out";
        }else{

            $txttitle1 = $this->input->post('txttitle1');
            $txtdesc1 = $this->input->post('txtdesc1');
            $txttitle2 = $this->input->post('txttitle2');
            $txtdesc2 = $this->input->post('txtdesc2');
            $txttitle3 = $this->input->post('txttitle3');
            $txtdesc3 = $this->input->post('txtdesc3');
            $txtexpr = $this->input->post('txtexpr');
            $for_days = $this->input->post('for_days');
            $txtgameid = $this->input->post('txtgameid');
            
            $path1 = @$_FILES['txtpics1']['name'];
            $path2 = @$_FILES['txtpics2']['name'];
            $path3 = @$_FILES['txtpics3']['name'];
            $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
            $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
            $ext3 = pathinfo($path3, PATHINFO_EXTENSION);
            $img_ext_chk1 = array('jpg','png','jpeg');

            $randm1 = time();
            $randm2 = time() + mt_rand(111111111, 999999999);
            $randm3 = time() + mt_rand(222222222, 888888888);

            $rename_file1 = "$randm1.$ext1";
            $rename_file2 = "$randm2.$ext2";
            $rename_file3 = "$randm3.$ext3";
            
            $url_source1 = "fake_fols/".$rename_file1;
            $url_source2 = "fake_fols/".$rename_file2;
            $url_source3 = "fake_fols/".$rename_file3;

            $url_dest1 = "activity_photos/".$rename_file1;
            $url_dest2 = "activity_photos/".$rename_file2;
            $url_dest3 = "activity_photos/".$rename_file3;

            $file_tmp1 = @$_FILES["txtpics1"]["tmp_name"];
            $file_tmp2 = @$_FILES["txtpics2"]["tmp_name"];
            $file_tmp3 = @$_FILES["txtpics3"]["tmp_name"];

            if(is_uploaded_file($file_tmp1) && isset($_FILES['txtpics1']['name']) ){
                move_uploaded_file($file_tmp1, $url_source1);
                $d = $this->compress($url_source1, $url_dest1, 35);
            }
            
            if(is_uploaded_file($file_tmp2) && isset($_FILES['txtpics2']['name']) ){
                move_uploaded_file($file_tmp2, $url_source2);
                $d = $this->compress($url_source2, $url_dest2, 35);
            }

            if(is_uploaded_file($file_tmp3) && isset($_FILES['txtpics3']['name']) ){
                move_uploaded_file($file_tmp3, $url_source3);
                $d = $this->compress($url_source3, $url_dest3, 35);
            }

            $in_folder1="fake_fols/".$rename_file1; // delete the image in the fake folder
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $in_folder2="fake_fols/".$rename_file2;
            if(is_readable($in_folder2)) @unlink($in_folder2);

            $in_folder3="fake_fols/".$rename_file3;
            if(is_readable($in_folder3)) @unlink($in_folder3);
            $get_mems_id = $this->sql_models->getMemID();

            $act_ids = $this->sql_models->get_activityID2();
            $activity_ids = $act_ids['ids'];
            $what_day = $act_ids['for_days'];

            $newdata3 = array(
                'memid'           => $get_mems_id,
                'activity_id'     => $activity_ids,
                'expired'         => 0,
                'what_day'        => $what_day,
                'title1'          => $txttitle1,
                'title2'          => $txttitle2,
                'title3'          => $txttitle3,
                'descrip1'        => $txtdesc1,
                'descrip2'        => $txtdesc2,
                'descrip3'        => $txtdesc3,
                'file1'           => $rename_file1,
                'file2'           => $rename_file2,
                'file3'           => $rename_file3,
                'brief_expr'      => $txtexpr,
                'scores'          => 0,
                'scores2'         => 0,
                'scores3'         => 0,
                'winner_computed' => 0,
                'dates'           => @date("Y-m-d g:i a", time())
            );
            $newdata3 = $this->security->xss_clean($newdata3);
            $querys1 = $this->sql_models->insert_activities($newdata3);
            if(!$querys1)
                echo "Error in network connection!";
            else{
                echo "done_submitted";
            }
            
            
        }
    }

    
    function compute_winners(){
        echo $this->sql_models->compute_the_winners();
    }

    function approve_winners1(){
        $query = $this->sql_models->approve_the_winners();
        if($query) echo "approved"; else echo "notapproved";
    }
    


    function update_scores(){
        $txtids = $this->input->post('txtids');
        $judges = $this->input->post('judges');
        $txtscores = $this->input->post('txtscores');

        $this->form_validation->set_rules('txtscores', 'score', 'required|trim|numeric|regex_match[/^[0-9]{1,3}$/]');        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            if($judges=="Judge 1")
                $this->db->set('scores', $txtscores, FALSE);
            else if($judges=="Judge 2")
                $this->db->set('scores2', $txtscores, FALSE);
            else if($judges=="Judge 3")
                $this->db->set('scores3', $txtscores, FALSE);

            $this->db->where('id', $txtids);
            $querys = $this->db->update('pageant_activities');
            if($querys) echo "updated"; else echo "Error in saving scores";
        }
    }



    function submit_activities_f(){

        if(!$this->sql_models->validate_member_paid()){
            echo "logged_out";
        }else{

            $this->form_validation->set_rules('txttitle1', 'first photo title', 'required|trim|max_length[30]');
            $this->form_validation->set_rules('txtdesc1', 'first description', 'required|trim|max_length[300]');
            $this->form_validation->set_rules('txttitle2', 'second photo title', 'required|trim|max_length[30]');
            $this->form_validation->set_rules('txtdesc2', 'second description', 'required|trim|max_length[300]');
            $this->form_validation->set_rules('txttitle3', 'third photo title', 'required|trim|max_length[30]');
            $this->form_validation->set_rules('txtdesc3', 'third description', 'required|trim|max_length[300]');
            $this->form_validation->set_rules('txtexpr', 'brief expression', 'trim');

            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{
                
                $path1 = @$_FILES['txtpics1']['name'];
                $path2 = @$_FILES['txtpics2']['name'];
                $path3 = @$_FILES['txtpics3']['name'];
                $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
                $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
                $ext3 = pathinfo($path3, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');

                if(@$_FILES['txtpics1']['name'] == "")
                    echo "Please upload your first activity photo to continue<br>";
                else if(!in_array($ext1,$img_ext_chk1) && isset($_FILES['txtpics1']['name']) && @$_FILES['txtpics1']['name'] != "")
                    echo "Please select a valid image for your first activity photo<br>";
                else if(isset($_FILES['txtpics1']['name']) && @$_FILES['txtpics1']['size'] > 4194304)
                    echo "Your first activity photo has exceeded 4MB<br>";

                else if(@$_FILES['txtpics2']['name'] == "")
                    echo "Please upload your second activity photo to continue<br>";
                else if(!in_array($ext2,$img_ext_chk1) && isset($_FILES['txtpics2']['name']) && @$_FILES['txtpics2']['name'] != "")
                    echo "Please select a valid image for your second activity photo<br>";
                else if(isset($_FILES['txtpics2']['name']) && @$_FILES['txtpics2']['size'] > 4194304)
                    echo "Your second activity photo has exceeded 4MB<br>";

                else if(@$_FILES['txtpics3']['name'] == "")
                    echo "Please upload your third activity photo to continue<br>";
                else if(!in_array($ext3,$img_ext_chk1) && isset($_FILES['txtpics3']['name']) && @$_FILES['txtpics3']['name'] != "")
                    echo "Please select a valid image for your third activity photo<br>";
                else if(isset($_FILES['txtpics3']['name']) && @$_FILES['txtpics3']['size'] > 4194304)
                    echo "Your third activity photo has exceeded 4MB<br>";

                else{
                    echo "done_confirm";
                }
            }
        }
    }



    function upload_medias(){
        $this->form_validation->set_rules('txttitle', 'activity title', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('txtdescrip', 'content', 'required|trim');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txttitle = $this->input->post('txttitle');
            $txtdescrip = $this->input->post('txtdescrip');
            $actid = $this->input->post('actid');
            $years = date("Y", time());

            if($actid!=""){ // for edit
                $data = array(
                    'titles'       => $txttitle,
                    'descrip'      => $txtdescrip
                    //'year'         => $years
                );
            }else{
                $data = array(
                    'titles'       => $txttitle,
                    'descrip'      => $txtdescrip,
                    'views'        => 0,
                    'year'         => $years,
                    'dates'        => date("Y-m-d g:i a", time())
                );
            }
            $id5 = $this->sql_models->upload_mymedia($data, $actid);
            if($id5){
                $this->nativesession->set('mediaid', $id5);
                echo "createds";
            }else{
                echo "Error!";
            }
        }
    }



    function reset_session1(){
        $filesCount = count($_FILES['txt_bma_pic1']['name']);
        $gen_num1=time();
        $gen_num1=substr($gen_num1,5);

        $msg = 0;
        $url_source = "fake_fols/";
        $target_dir = "events_fols/";
        $mediaid = $_SESSION['mediaid'];

        for($i = 0; $i < $filesCount; $i++){
            $_FILES['userFile']['name'] = $_FILES['txt_bma_pic1']['name'][$i];
            $_FILES['userFile']['type'] = $_FILES['txt_bma_pic1']['type'][$i];
            $_FILES['userFile']['tmp_name'] = $_FILES['txt_bma_pic1']['tmp_name'][$i];
            $_FILES['userFile']['error'] = $_FILES['txt_bma_pic1']['error'][$i];
            $_FILES['userFile']['size'] = $_FILES['txt_bma_pic1']['size'][$i];

            $ext = pathinfo($_FILES['txt_bma_pic1']['name'][$i], PATHINFO_EXTENSION);
            $img_ext_chk = array('jpg','png','jpeg','gif','mp4','3gp');
            $ext = strtolower($ext);

            if($ext=="jpg" || $ext=="png" || $ext=="gif" || $ext=="jpeg")
                $url_source1 = "fake_fols/";
            else
                $url_source1 = "events_fols/"; // for videos

            if(!in_array($ext,$img_ext_chk)){
                echo "Please select a photo for this event<br>";
                exit;
            }else if(isset($_FILES['txt_bma_pic1']['size'][$i]) && $_FILES['txt_bma_pic1']['size'][$i] > 3145728){
                echo "The photo(s) have exceeded 3mb<br>";
                exit;
            }else{

                $type = explode('.', $_FILES["txt_bma_pic1"]["name"][$i]);
                $type = $type[count($type)-1];
                $newFileName = time()."$i.$ext";
                
                $file_tmp = $_FILES["txt_bma_pic1"]["tmp_name"][$i];
                if(is_uploaded_file($file_tmp)){
                    if(move_uploaded_file($file_tmp=$_FILES["txt_bma_pic1"]["tmp_name"][$i],$url_source1.$newFileName)  && ($mediaid != "" || $mediaid > 0)) {
                        if($ext=="jpg" || $ext=="png" || $ext=="gif" || $ext=="jpeg"){
                            $d = $this->compress($url_source.$newFileName, $target_dir.$newFileName, 70);
                        }
                        $datas = array(
                            'event_id'  => $mediaid,
                            'files'     => $newFileName,
                            'myfolder'  => ""
                        );
                        $insert = $this->db->insert('events_media', $datas);
                        $msg = $gen_num1;
                    }
                    $in_folder1="fake_fols/".$newFileName; // delete the image in the fake folder
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                }
            }
        }
        echo $msg;
    }



    function fundmywallet(){
        $this->form_validation->set_rules('txtfund_name', 'Full Names', 'required|trim|alpha_space|min_length[4]|max_length[20]');
        
        $this->form_validation->set_rules('txtfund_phone', 'Phone Number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');

        $this->form_validation->set_rules('txtfund_amt', 'Amount', 'required|trim');

        $txtfund_name = $this->input->post('txtfund_name');
        $txtfund_phone = $this->input->post('txtfund_phone');
        $txtfund_amt = $this->input->post('txtfund_amt');
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $data = array(
                'names'          => $txtfund_name,
                'ipaddrs'        => $ipaddr,
                'phone'          => $txtfund_phone,
                'amts'           => $txtfund_amt,
                'date_created'   => date("Y-m-d g:i a", time())
            );

            $querys = $this->sql_models->create_funds($data);

            if($querys){
                $now = 2147483647 - time();
                $cookie = array(
                    'name'   => 'cookie_fund_name',
                    'value'  => $txtfund_name,
                    'expire' => $now,
                    'secure' => FALSE
                );
                $cookie1 = array(
                    'name'   => 'cookie_fund_phone',
                    'value'  => $txtfund_phone,
                    'expire' => $now,
                    'secure' => FALSE
                );
                $cookie2 = array(
                    'name'   => 'voter_ip',
                    'value'  => $ipaddr,
                    'expire' => $now,
                    'secure' => FALSE
                );
                set_cookie($cookie);
                set_cookie($cookie1);
                set_cookie($cookie2);

                echo "fund_submitted";
            }else{
                echo "Cannot submit, please try again";
            }
        }
    }



    function create_activity_last_step(){
        $this->form_validation->set_rules('txtday', 'day', 'required|trim');
        $this->form_validation->set_rules('txtgametype', 'game type', 'required|trim');
        $this->form_validation->set_rules('txtgtitle', 'title', 'required|trim');
        $this->form_validation->set_rules('txtins', 'day instruction', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('txttime', 'time duration', 'required|trim');
        $this->form_validation->set_rules('txtstart', 'start time', 'required|trim');

        $txtday = $this->input->post('txtday');
        $txtgametype = $this->input->post('txtgametype');
        $txtins = $this->input->post('txtins');
        $txtgtitle = $this->input->post('txtgtitle');
        $txttime = $this->input->post('txttime');
        $txtstart = $this->input->post('txtstart');
        $actid = $this->input->post('actid');
        $qrys = $this->input->post('qrys');
        if($actid!="")
            $activity_sess = $this->sql_models->getSession($actid);
        else
            $activity_sess = $this->input->cookie('activity_sess', TRUE);
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            if($qrys=="new"){
                //$activity_sess = $this->sql_models->getSession($actid);
                $data = array(
                    'session1'          => $activity_sess,
                    'timings'           => 0,
                    'quiz_intro_id'     => 0,
                    'has_done'          => 0,
                    'for_days'          => $txtday,
                    'day_instructns'    => $txtins,
                    'time_duratn'       => $txttime,
                    'titles'            => $txtgtitle,
                    'starting_from'     => $txtstart,
                    'starting_from1'     => 0,
                    'game_type'         => $txtgametype,
                    'dates'             => ""
                );

            }else if($qrys!="new" && $qrys!=""){ // for edit second id params

                $data = array(
                    'for_days'          => $txtday,
                    'day_instructns'    => $txtins,
                    'time_duratn'       => $txttime,
                    'titles'            => $txtgtitle,
                    'starting_from'     => $txtstart,
                    'game_type'         => $txtgametype,
                );

            }else{

                if($actid!=""){ // for edit
                    $data = array(
                        'for_days'          => $txtday,
                        'day_instructns'    => $txtins,
                        'time_duratn'       => $txttime,
                        'titles'            => $txtgtitle,
                        'starting_from'     => $txtstart,
                        'game_type'         => $txtgametype,
                    );
                }else{
                    $data = array(
                        'session1'          => $activity_sess,
                        'timings'           => 0,
                        'quiz_intro_id'     => 0,
                        'has_done'          => 0,
                        'for_days'          => $txtday,
                        'day_instructns'    => $txtins,
                        'time_duratn'       => $txttime,
                        'titles'            => $txtgtitle,
                        'starting_from'     => $txtstart,
                        'starting_from1'    => 0,
                        'game_type'         => $txtgametype,
                        'dates'             => ""
                    );
                }

            }

            if($qrys=="new" && $qrys!=""){
                $this->sql_models->create_actv2($data, $activity_sess, 'new');
            }else if($qrys!="new" && $qrys!=""){ // for edit second id params
                $this->sql_models->create_actv2($data, $qrys, 'edits');
            }else{
                if($actid!="")
                $this->sql_models->create_actv2($data, $activity_sess, '');
                else
                $this->sql_models->create_actv2($data, '', '');
            }
            
            $cookie = array(
                'name'   => 'activity_sess',
                'value'  => "",
                'expire' => 0,
                'secure' => FALSE
            );
            delete_cookie($cookie);
            echo "created_last";
        }
    }


    

    function create_activity_final(){
        $this->form_validation->set_rules('txttitle', 'activity title', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('txtinstruc', 'activity instruction', 'required|trim');
        $this->form_validation->set_rules('txtdis', 'activity disqualification', 'required|trim');
        $this->form_validation->set_rules('txtfrom', 'starting registration', 'required|trim');
        $this->form_validation->set_rules('txtto', 'ending registration', 'required|trim');
        $this->form_validation->set_rules('inputdate2', 'date of starting activity', 'required|trim');
        $this->form_validation->set_rules('txtfprize', 'first prize', 'required|trim|numeric|regex_match[/^[0-9]{4,6}$/]');
        $this->form_validation->set_rules('txtsprize', 'second prize', 'required|trim|numeric|regex_match[/^[0-9]{4,6}$/]');
        $this->form_validation->set_rules('txttprize', 'third prize', 'required|trim|numeric|regex_match[/^[0-9]{4,6}$/]');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txttitle = $this->input->post('txttitle');
            $txtinstruc = $this->input->post('txtinstruc');
            $txtdis = $this->input->post('txtdis');
            $txtfrom = strtotime($this->input->post('txtfrom')); // present
            $txtto = strtotime($this->input->post('txtto')); // furture
            $inputdate2 = strtotime($this->input->post('inputdate2'));

            $txtfprize = $this->input->post('txtfprize');
            $txtsprize = $this->input->post('txtsprize');
            $txttprize = $this->input->post('txttprize');
            
            $actid = $this->input->post('actid');

            $former_file1 = $this->input->post('former_file1');
            $former_file2 = $this->input->post('former_file2');
            $former_file3 = $this->input->post('former_file3');
            $former_file4 = $this->input->post('former_file4');

            $path1 = @$_FILES['file_gift1']['name'];
            $path2 = @$_FILES['file_gift2']['name'];
            $path3 = @$_FILES['file_gift3']['name'];
            $path4 = @$_FILES['file_banner']['name'];
            
            $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
            $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
            $ext3 = pathinfo($path3, PATHINFO_EXTENSION);
            $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
            $img_ext_chk1 = array('jpg','png','jpeg');

            $randm1 = time();
            $randm2 = time() + mt_rand(111111111, 999999999);
            $randm3 = time() + mt_rand(222222222, 888888888);
            $randm4 = time() + mt_rand(333333333, 777777777);

            $rename_file1 = "$randm1.$ext1";
            $rename_file2 = "$randm2.$ext2";
            $rename_file3 = "$randm3.$ext3";
            $rename_file4 = "$randm4.$ext4";
            
            $url_source1 = "fake_fols/".$rename_file1;
            $url_source2 = "fake_fols/".$rename_file2;
            $url_source3 = "fake_fols/".$rename_file3;
            $url_source4 = "fake_fols/".$rename_file4;

            $url_dest1 = "gifts/".$rename_file1;
            $url_dest2 = "gifts/".$rename_file2;
            $url_dest3 = "gifts/".$rename_file3;
            $url_dest4 = "events_fols/".$rename_file4;

            $file_tmp1 = @$_FILES["file_gift1"]["tmp_name"];
            $file_tmp2 = @$_FILES["file_gift2"]["tmp_name"];
            $file_tmp3 = @$_FILES["file_gift3"]["tmp_name"];
            $file_tmp4 = @$_FILES["file_banner"]["tmp_name"];

            if($txtfrom > $txtto){
                echo "The <b><u>Starting Date of Registration</u></b> should not be ahead of <b><u>Ending Date of Registration</u></b>";

            }else if($txtfrom == $txtto){
                echo "The <b><u>Starting Date of Activity</u></b> should not be the same as the <b><u>Ending Date of Registration</u></b>";

            }else if($inputdate2 <= $txtto){
                echo "The <b><u>Starting Date of Activity</u></b> should be ahead of the <b><u>Ending Date of Registration</u></b>";

            }else if(!in_array($ext1,$img_ext_chk1) && $former_file1==""){
                echo "Please upload a gift for the first prize";

            }else if(!in_array($ext2,$img_ext_chk1) && $former_file2==""){
                echo "Please upload a gift for the second prize";

            }else if(!in_array($ext3,$img_ext_chk1) && $former_file3==""){
                echo "Please upload a gift for the third prize";

            }else{

                if(is_uploaded_file($file_tmp1) && isset($_FILES['file_gift1']['name']) ){

                    if($actid != "")
                        $this->sql_models->delete_gift_pics($former_file1);
                    move_uploaded_file($file_tmp1, $url_source1);
                    $d = $this->compress($url_source1, $url_dest1, 35);

                }
                
                if(is_uploaded_file($file_tmp2) && isset($_FILES['file_gift2']['name']) ){
                    if($actid != "")
                        $this->sql_models->delete_gift_pics($former_file2);
                    move_uploaded_file($file_tmp2, $url_source2);
                    $d = $this->compress($url_source2, $url_dest2, 35);
                }

                if(is_uploaded_file($file_tmp3) && isset($_FILES['file_gift3']['name']) ){
                    if($actid != "")
                        $this->sql_models->delete_gift_pics($former_file3);
                    move_uploaded_file($file_tmp3, $url_source3);
                    $d = $this->compress($url_source3, $url_dest3, 35);
                }

                if(is_uploaded_file($file_tmp4) && isset($_FILES['file_banner']['name']) ){
                    if($actid != "")
                        $this->sql_models->delete_events_pics($former_file4);
                    move_uploaded_file($file_tmp4, $url_source4);
                    $d = $this->compress($url_source4, $url_dest4, 40);
                }

                $in_folder1="fake_fols/".$rename_file1; // delete the image in the fake folder
                if(is_readable($in_folder1)) @unlink($in_folder1);

                $in_folder2="fake_fols/".$rename_file2;
                if(is_readable($in_folder2)) @unlink($in_folder2);

                $in_folder3="fake_fols/".$rename_file3;
                if(is_readable($in_folder3)) @unlink($in_folder3);

                $in_folder4="fake_fols/".$rename_file4;
                if(is_readable($in_folder4)) @unlink($in_folder4);

                $get_mems_id = $this->sql_models->getMemID();

                if($ext4=="") $rename_file4="";


                if($actid!=""){ // for edit
                    $data1 = array();
                    $data2 = array();
                    $data3 = array();
                    $data4 = array();

                    if(isset($path1) && @$path1 != ''){
                        $data1 = array(
                            'gift1'    => $rename_file1
                        );
                    }

                    if(isset($path2) && @$path2 != ''){
                        $data2 = array(
                            'gift2'    => $rename_file2
                        );
                    }

                    if(isset($path3) && @$path3 != ''){
                        $data3 = array(
                            'gift3'    => $rename_file3
                        );
                    }

                    if(isset($path4) && @$path4 != ''){
                        $data4 = array(
                            'banners'    => $rename_file4
                        );
                    }

                    $data5 = array(
                        'overall_title'     => $txttitle,
                        'instructn'         => $txtinstruc,
                        'disqualificatn'    => $txtdis,
                        'enable_reg'        => $txtfrom,
                        'disable_reg'       => $txtto,
                        'dates'             => $inputdate2,
                        'prize1'            => $txtfprize,
                        'prize2'            => $txtsprize,
                        'prize3'            => $txttprize
                    );
                    $data3i = array_merge($data1, $data2, $data3, $data4, $data5);

                }else{

                    $data3i = array(
                        'approved'              => 0,
                        'session1'              => time(),
                        'has_done'              => 0,
                        'one_week_timings'      => 0,
                        'close_prev_contestant' => 0,
                        'overall_title'         => $txttitle,
                        'banners'               => $rename_file4,
                        'instructn'             => $txtinstruc,
                        'disqualificatn'        => $txtdis,
                        'enable_reg'            => $txtfrom,
                        'disable_reg'           => $txtto,
                        'dates'                 => $inputdate2,
                        'prize1'                => $txtfprize,
                        'prize2'                => $txtsprize,
                        'prize3'                => $txttprize,
                        'gift1'                 => $rename_file1,
                        'gift2'                 => $rename_file2,
                        'gift3'                 => $rename_file3,
                    );
                }
                if($this->sql_models->create_actv($data3i, $actid)){
                    
                    $session2 = $this->sql_models->getInputs($txttitle, $txtinstruc, $txtdis);
                    $now = 2147483647 - time();

                    $cookie = array(
                        'name'   => 'activity_sess',
                        'value'  => $session2,
                        'expire' => $now,
                        'secure' => FALSE
                    );
                    set_cookie($cookie);
                    echo "createds";
                    //}
                }else{
                    echo "This title already exists!";
                }
            }
        }
    }



    function create_media_final(){
        $this->form_validation->set_rules('txttitle', 'photo title', 'required|trim|max_length[100]');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $txttitle = $this->input->post('txttitle');
            $txtmedia = $this->input->post('txtmedia');
            $txtutube = $this->input->post('txtutube');
            $actid = $this->input->post('actid');
            $former_file_ph = $this->input->post('former_file_ph');

            $path1 = @$_FILES['file_photo']['name'];
            $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
            $img_ext_chk1 = array('jpg','png','jpeg');

            $randm1 = time();
            $rename_file1 = "$randm1.$ext1";
            $url_source1 = "fake_fols/".$rename_file1;
            $url_dest1 = "gallery/".$rename_file1;
            
            $file_tmp1 = @$_FILES["file_photo"]["tmp_name"];

            if(!in_array($ext1,$img_ext_chk1) && isset($_FILES['file_photo']['name']) && @$_FILES['file_photo']['name'] != "" && $txtmedia=="pic")
                echo "Please select a valid photo of the formats jpg, jpeg or png<br>";
                
            else if(isset($_FILES['file_photo']['name']) && @$_FILES['file_photo']['size'] > 4194304)
                echo "The photo has exceeded 4MB<br>";

            else if($txtmedia=="vid" && $txtutube=="")
                echo "Please enter or paste the youtube code for the video";

            else{

                if(is_uploaded_file($file_tmp1) && isset($_FILES['file_photo']['name']) && $txtmedia=="pic" ){
                    if($actid != "")
                        $this->sql_models->delete_gal_pics($former_file_ph);
                    move_uploaded_file($file_tmp1, $url_source1);
                    $d = $this->compress($url_source1, $url_dest1, 35);
                }

                if($txtmedia=="pic"){
                    $in_folder1="fake_fols/".$rename_file1; // delete the image in the fake folder
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                }

                if($ext1=="") $rename_file1="";

                if($actid!=""){ // for edit
                    $data1 = array();
                    if($txtmedia=="pic"){
                        if(isset($path1) && @$path1 != ''){
                            $data1 = array(
                                'files'    => $rename_file1
                            );
                        }
                    }else{
                        $data1 = array(
                            'files'    => $txtutube
                        );
                    }

                    $data2 = array(
                        'titles'        => $txttitle,
                        'media_type'    => $txtmedia,
                        'dates'        => date("Y-m-d g:i a", time())
                    );
                    $data3 = array_merge($data1, $data2);

                }else{
                    if($txtmedia=="pic"){
                        $filenames = $rename_file1;
                    }else{
                        $filenames = $txtutube;
                    }
                    $data3 = array(
                        'titles'        => $txttitle,
                        'media_type'    => $txtmedia,
                        'files'         => $filenames,
                        'dates'        => date("Y-m-d g:i a", time())
                    );
                }
                if($this->sql_models->upload_md($data3, $actid)){
                    if($txtmedia=="pic")
                    echo "uploaded_$rename_file1";
                    else
                    echo "uploaded";
                }else{
                    echo "Error in uploading, try again.";
                }
            }
        }
    }



    function next_quiz(){
        $txtsessions = $this->input->post('txtsessions');
        $next_question = $this->sql_models->get_next_question($txtsessions);
    }


    function fetch_con_search(){
        $txtsc = $this->input->post('txtsc');
        $contestants = $this->sql_models->fetchContestants_src($txtsc);
        //echo '<div class="slider slider_contest multiple-items_">
        echo '<div class="owl-carousel owl-theme owl-theme3" data-items="3" data-laptop="3" data-tablet="2" data-mobile="1" data-nav="true" data-dots="true" data-autoplay="true" data-speed="500" data-autotime="3000">';
        if($contestants){
            foreach ($contestants as $rs) {
                $sw_id = $rs['sw_id'];
                $file1 = $rs['file1'];
                $file2 = $rs['file2'];
                $file3 = $rs['file3'];
                $memid = $rs['memid'];
                $names = $this->sql_models->contestantName($memid);
                $mystates = $this->sql_models->contestantState($memid);
                $myvotes = $this->sql_models->countVotes($memid, $sw_id, '');
                $myvotes = @number_format($myvotes);

                //$my_pics = array($file1, $file2, $file3);
                //$pics = $my_pics[array_rand($my_pics, 1)];
                $pics = $file1;
                $pic_pathi = base_url()."activity_photos/$pics";
                //$pic_path = base_url()."watermark.php?image=".base_url()."activity_photos/$pics&watermark=".base_url()."images/watermrk.png";
                $pic_path = base_url()."activity_photos/$pics";

                if($pics==""){
                    $pics = $this->sql_models->profilePics($memid);
                    $pic_pathi = base_url()."celebs_uploads/$pics";
                    //$pic_path = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";
                    $pic_path = base_url()."celebs_uploads/$pics";
                }

                $gen_num1=time();
                $gen_num1=substr($gen_num1,6);
                $names3 = str_replace(" ", "-", $names);
                $url1 = base_url()."viewprofile/$memid$gen_num1/$names3/";
                $tweets = "Hi dear, I'm $names at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";
                $title_whatsapp = "Hi dear, I'm *$names* at *OurFavCelebs*, I would like to plead for your support by voting for me, thank you in advance.";
                $sTitle_whatsapp = ucwords($title_whatsapp)."%0A%0A$url1";
            ?>
                <div class="product-blog item cover_img1">
                        <div class="cover_img">
                            <a href="<?=$pic_path;?>" class="magnific-popup">
                                <img src="<?=$pic_path;?>" alt="">
                            </a>
                        </div>
                    <h3><?=$names;?></h3>
                    <p class="states">
                        <?php
                        if($mystates!="FCT Abuja")
                        echo "$mystates State";
                        ?>
                    </p>
                    <p>
                        <span class="voteme" id="voteme" swid="<?=$sw_id;?>" names="<?=$names;?>" myvotes="<?=$myvotes;?>" memids="<?=$memid;?>" pics1="<?=$pic_pathi;?>">Vote Me</span>
                        <span class="viewprofile" swid="<?=$sw_id;?>" names="<?=$names;?>" memids="<?=$memid;?>" myvotes="<?=$myvotes;?>" pics1="<?=$pic_pathi;?>">View Profile</span>
                    </p>
                    <strong class="txt-default">Votes: <font class="vote_counts<?=$memid;?>"><?=$myvotes;?></font></strong>
                    <div class="socials">
                        <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><img src="<?=base_url();?>images/facebook.png" alt=""></a>
                        <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><img src="<?=base_url();?>images/twitter1.png" alt=""></a>
                        <a class="hitLink mobiles_view" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><img src="<?=base_url();?>images/whatsapp.png" alt=""></a>
                        <a class="hitLink not_mobiles_view" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><img src="<?=base_url();?>images/whatsapp.png" alt=""></a>
                    </div>
                </div>
            <?php
            }
        }else{
            echo "<p style='font-size:16px; text-align:center; color:#999; margin:8px 0 2em 0'>$txtsc was not found</p>";
        }
        //echo "</div></div>";
        echo "</div>";

        // echo "<script src='".base_url()."js/jquery.min.js'></script>";
        // echo "<script src='".base_url()."plugin/owl-carousel/owl.carousel.min.js'></script>";

        // echo "<script src='".base_url()."js/app.js'></script>";
        // echo "<script src='".base_url()."js/script.js'></script>";
    }



    
    function logme(){
        $this->form_validation->set_rules('txtuser', 'username', 'required|trim');
        $this->form_validation->set_rules('txtpasswd', 'password', 'required|trim');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $data = array(
                'emails' => $this->input->post('txtuser'),
                'phones' => $this->input->post('txtuser'),
                'pass' => $this->input->post('txtpasswd')
            );
            $is_correct_id = $this->sql_models->get_user_logins($data);

            if($is_correct_id){
                $check_for_approved = $this->sql_models->check_approved($is_correct_id);
                if($check_for_approved){
                    $now = 2147483647 - time();
                    $cookie = array(
                        'name'   => 'my_passwords',
                        'value'  => sha1($this->input->post('txtpasswd')),
                        'expire' => $now,
                        'secure' => FALSE
                    );
                    $cookie1 = array(
                        'name'   => 'my_usernames',
                        'value'  => sha1($this->input->post('txtuser')),
                        'expire' => $now,
                        'secure' => FALSE
                    );
                    @set_cookie($cookie);
                    @set_cookie($cookie1);

                    echo "successor2";
                }else{
                    echo "Your login credentials have not yet been approved!";
                }
            }else{
                echo "Invalid details entered!";
            }
        }
    }


    function reg_members(){
        $this->form_validation->set_rules('txtfname', 'first name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
        $this->form_validation->set_rules('txtlname', 'last name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
        $this->form_validation->set_rules('phone1', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
        $this->form_validation->set_rules('email1', 'email', 'required|trim|valid_email');
        $this->form_validation->set_rules('txtstate', 'state', 'required|trim');
        $this->form_validation->set_rules('txtgender', 'gender', 'required|trim');
        $this->form_validation->set_rules('txtpass1', 'password', 'required|trim|matches[txtpass2]|min_length[5]');
        $this->form_validation->set_rules('txtpass2', 'confirm password', 'required|trim');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtfname = $this->input->post('txtfname');
            $email1 = $this->input->post('email1');

            $gen_num1=time();
            $gen_num1=substr($gen_num1,4);
            $data = array(
                'emails' => $email1,
                'codes' => $gen_num1,
                'status' => 0
            );

            $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
            $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello $txtfname,</b></p>";
            $message_contents .= "<p style='font-size:16px; margin-top:10px'>
            Your OurFavCelebs verification code as a contestant is <b>$gen_num1</b>, please copy it.
            </p>";

            $message_contents .= "<p style='font-size:14px; margin:10px 0 20px 0'>Thank you!</p>";
            $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
            $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

            $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
            $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'from' => "info@ourfavcelebs.com",
                'to' => $email1,
                'subject' => "Verification Code | OurFavCelebs",
                'html' => $message_contents
            ));

            $result = curl_exec($ch);
            curl_close($ch);

            $store_codes = $this->sql_models->store_codes($data);
            if($store_codes){
                echo "proceed1";
            }else{
                echo "error";
            }
        }
    }



    public function logme_paid(){
        $this->form_validation->set_rules('txtuser', 'username', 'required|trim');
        $this->form_validation->set_rules('txtpasswd', 'password', 'required|trim');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $data = array(
                'emails' => $this->input->post('txtuser'),
                'phones' => $this->input->post('txtuser'),
                'pass' => $this->input->post('txtpasswd')
            );
            $is_correct_id = $this->sql_models->get_user_logins_paid($data);
            if($is_correct_id){
                echo "yes_paid";
            }else{
                echo "not_paids";
            }
        }
    }




function forgot_bma(){
    $this->form_validation->set_rules('txtpass1', 'password', 'required|trim|min_length[5]|matches[txtpass2]|sha1');
    $this->form_validation->set_rules('txtpass2', 'confirm password', 'required|trim|sha1');
    $this->form_validation->set_rules('txtcode', 'code', 'required|trim');

    $codes = $this->input->post('txtcode');

    if($this->form_validation->run() == FALSE){
        echo validation_errors();
    }else{

        $data = array(
            'codes' => $this->input->post('txtcode'),
            'pass1' => $this->input->post('txtpass2')
        );

        $data = $this->security->xss_clean($data);
        $user_pass = $this->input->post('txtpass2');
        $check_code = $this->sql_models->check_code($codes, $user_pass);

            if($check_code){ // this will return my email

                $now = 2147483647 - time();
                $cookie = array(
                    'name'   => 'store_easer_pas1',
                    'value'  => $user_pass,
                    'expire' => $now,
                    'secure' => FALSE
                );
                $cookie1 = array(
                    'name'   => 'store_easer_usrs',
                    'value'  => $check_code,
                    'expire' => $now,
                    'secure' => FALSE
                );
                set_cookie($cookie);
                set_cookie($cookie1);

                $config = Array(
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1',
                    'crlf' => "\r\n",
                    'newline' => "\r\n",
                    'wordwrap' => TRUE
                );

                /////////////////////////////
                $to_email = $check_code;
                $to_email = strtolower($to_email);
                $message_contents = "<div style='margin-top:0px'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                $message_contents .= "<p style='font-size:13px; margin-top:5px'>Your password was successfully updated! Thanks for using faseaser...</p>";
                $message_contents .= "<p style='margin-top:2px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

                $email3="Undisclosed Recipient <info@ourfavcelebs.com>";
                $this->load->library('email');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $this->email->from($email3, 'Password Reset');
                $this->email->to($to_email);
                $this->email->subject("Your Password Was Updated Successfully");
                $this->email->message($message_contents);
                $this->email->send();
                /////////////////////////////
                echo "success_updated1";
            }else{
                echo "The code is invalid";
            }
        }
    }






    function remove_this_ad(){
        $prodid = $this->input->post('prodid');
        $txt_bma_id = $this->input->post('txt_bma_id');
        $deletes = $this->sql_models->removeAds($prodid, $txt_bma_id);
        if($deletes)
            echo "ad_removed";
        else
            echo "<div class='Errormsg' style='border:none !important; background:none !important; font-size:1.2em !important;'>Error in removing ads, please try again.</div>";
    }


    function update_video_views(){
        $ids = $this->input->post('ids');
        $this->sql_models->updateViews($ids, 'gallery_vid', '');
    }


    function delete_comment(){
        $cmtid = $this->input->post('cmtid');
        $this->db->where('id', $cmtid);
        $query = $this->db->delete('comments');
        if($query)
            echo "deletss";
        else
            echo "<div class='Errormsg' style='border:none !important; background:none !important; font-size:1.2em !important;'>Error in deleting comment, please try again.</div>";
    }


    function delete_comment_adm(){
        $cmtid = $this->input->post('cmtid');
        $this->db->where('id', $cmtid);
        $query = $this->db->delete('adm_video_cmts');
        //$query=true;
        if($query)
            echo "deletss";
        else
            echo "<div class='Errormsg' style='border:none !important; background:none !important; font-size:1.2em !important;'>Error in deleting comment, please try again.</div>";
            //sleep(2);
    }



    function delete_this_ad(){
        $prodid = $this->input->post('prodid');
        $txt_bma_id = $this->input->post('txt_bma_id');
        $memid = $this->input->post('memid');
        $deletes = $this->sql_models->deleteAds($prodid, $txt_bma_id, $memid);
        if($deletes)
            echo "ad_deleted";
        else
            echo "<div class='Errormsg' style='border:none !important; background:none !important; font-size:1.2em !important;'>Error in deleting, please try again.</div>";
    }


    function turnoff_this_ad(){
        $prodid = $this->input->post('prodid');
        $turnoff = $this->sql_models->turnAdOff_On($prodid);
        if($turnoff == 1)
            echo 1;
        else
            echo 0;
    }



    function fetch_contestant_info(){
        $memid = $this->input->post('memids');
        $con_id = $this->sql_models->fetchContestants_id($memid);
        if($con_id){
        ?>
            <script src="<?=base_url();?>js/jssor.slider-25.4.2.min.js" type="text/javascript"></script>
            <script type="text/javascript">
                jssor_1_slider_init = function() {

                    var jssor_1_SlideshowTransitions = [
                    {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
                    ];

                    var jssor_1_options = {
                    $AutoPlay: 0,
                    $SlideshowOptions: {
                        $Class: $JssorSlideshowRunner$,
                        $Transitions: jssor_1_SlideshowTransitions,
                        $TransitionsOrder: 1
                    },
                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$
                    },
                    $ThumbnailNavigatorOptions: {
                        $Class: $JssorThumbnailNavigator$,
                        $Cols: 5,
                        $SpacingX: 5,
                        $SpacingY: 5,
                        $Align: 390
                    }
                    };

                    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

                    /*#region responsive code begin*/

                    var MAX_WIDTH = 980;

                    function ScaleSlider() {
                        var containerElement = jssor_1_slider.$Elmt.parentNode;
                        var containerWidth = containerElement.clientWidth;

                        if (containerWidth) {

                            var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                            jssor_1_slider.$ScaleWidth(expectedWidth);
                        }
                        else {
                            window.setTimeout(ScaleSlider, 30);
                        }
                    }

                    ScaleSlider();

                    $Jssor$.$AddEvent(window, "load", ScaleSlider);
                    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                    /*#endregion responsive code end*/
                };
            </script>

            <?php
                echo '<div id="jssor_1" class="jssor_2" style="position:relative;margin:0 auto;top:0px;left:0px;overflows:hidden;visibility:hidden;">

                <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                    <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="'.base_url().'images/loader.gif" />
                </div>
                
                <div data-u="slides" class="slides_imgs" style="cursor:default;position:relative;top:0px;left:0px;;">';

                    foreach ($con_id as $rs) {
                        $id2 = $rs['id'];
                        $con_pics = $this->sql_models->fetchContestants_pics($id2);
                        $swid = $con_pics['id'];
                        $cmemid = $con_pics['memid'];
                        $file1 = $con_pics['file1'];
                        $file2 = $con_pics['file2'];
                        $file3 = $con_pics['file3'];
                        $file1i = $file1; $file1i = str_replace(".", "", $file1i);
                        $file2i = $file2; $file2i = str_replace(".", "", $file2i);
                        $file3i = $file3; $file3i = str_replace(".", "", $file3i);
                        $title1 = ucwords($con_pics['title1']);
                        $title2 = ucwords($con_pics['title2']);
                        $title3 = ucwords($con_pics['title3']);
                        $descrip1 = ucfirst($con_pics['descrip1']);
                        $descrip2 = ucfirst($con_pics['descrip2']);
                        $descrip3 = ucfirst($con_pics['descrip3']);
                        $ipaddr = $_SERVER['REMOTE_ADDR'];
                        
                        $pic_likes1 = $this->sql_models->fetchLikes($file1i, $ipaddr);
                        $pic_likes2 = $this->sql_models->fetchLikes($file2i, $ipaddr);
                        $pic_likes3 = $this->sql_models->fetchLikes($file3i, $ipaddr);

                        if($file1!=""){
                            //$file1 = base_url()."activity_photos/$file1";
                            //$file1 = base_url()."watermark.php?image=".base_url()."activity_photos/$file1&watermark=".base_url()."images/watermrk.png";
                            $file1 = base_url()."activity_photos/$file1";
                            echo "<div>
                                <p class='house_img'>
                                    <img data-u='image' src='$file1' />
                                
                                    <div class='like_info' style='padding:10px;'>
                                        <span class='pic_ttl'>$title1</span>
                                        <span class='for_desktop'>$descrip1</span>
                                        <span class='likes_btm likes_btm1'>";
                                            if(!$this->sql_models->fetchLikes($file1i, $ipaddr))
                                                echo "<strong class='likes' id='likes$file1i' swid='$swid' like_type='1' contestant_id='$cmemid' file1='$file1i' mylikes='$pic_likes1' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file1i'>$pic_likes1</fonts> Likes</strong>";
                                            else
                                                echo "<strong class='likes1' id='likes1$file1i' swid='$swid' like_type='1' contestant_id='$cmemid' mylikes='$pic_likes1' style='opacity:0.4;' file1='$file1i' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file1i'>$pic_likes1</fonts> Likes</strong>";
                                        echo "</span>
                                        <p style='color:#999; padding-top:6px'>(Total of 50 Likes on all your photos will be a bonus of one vote)</p>
                                    </div>
                                </p>
                            </div>";
                        }

                        
                        if($file2!=""){
                            //$file2 = base_url()."activity_photos/$file2";
                            //$file2 = base_url()."watermark.php?image=".base_url()."activity_photos/$file2&watermark=".base_url()."images/watermrk.png";
                            $file2 = base_url()."activity_photos/$file2";
                            echo "<div>
                                <p class='house_img'>
                                    <img data-u='image' src='$file2' />
                                
                                    <div class='like_info' style='padding:10px;'>
                                        <span class='pic_ttl'>$title2</span>
                                        <span class='for_desktop'>$descrip2</span>
                                        <span class='likes_btm likes_btm2'>";
                                            if(!$this->sql_models->fetchLikes($file2i, $ipaddr))
                                                echo "<strong class='likes2' id='likes2$file2i' swid='$swid' like_type='2' contestant_id='$cmemid' file1='$file2i' mylikes='$pic_likes2' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file2i'>$pic_likes2</fonts> Likes</strong>";
                                            else
                                                echo "<strong class='likes12' id='likes12$file2i' swid='$swid' like_type='2' contestant_id='$cmemid' mylikes='$pic_likes2' style='opacity:0.4;' file1='$file2i' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file2i'>$pic_likes2</fonts> Likes</strong>";
                                        echo "</span>
                                        <p style='color:#999; padding-top:6px'>(Total of 50 Likes on all your photos will be a bonus of one vote)</p>
                                    </div>
                                </p>
                            </div>";
                        }

                        if($file3!=""){
                            //$file3 = base_url()."activity_photos/$file3";
                            //$file3 = base_url()."watermark.php?image=".base_url()."activity_photos/$file3&watermark=".base_url()."images/watermrk.png";
                            $file3 = base_url()."activity_photos/$file3";
                            echo "<div>
                                <p class='house_img'>
                                    <img data-u='image' src='$file3' />
                                </p>
                                    <div class='like_info' style='padding:10px;'>
                                        <span class='pic_ttl'>$title3</span>
                                        <span class='for_desktop'>$descrip3</span>
                                        <span class='likes_btm likes_btm3'>";
                                            if(!$this->sql_models->fetchLikes($file3i, $ipaddr))
                                                echo "<strong class='likes3' id='likes3$file3i' swid='$swid' like_type='3' contestant_id='$cmemid' file1='$file3i' mylikes='$pic_likes3' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file3i'>$pic_likes3</fonts> Likes</strong>";
                                            else
                                                echo "<strong class='likes13' id='likes13$file3i' swid='$swid' like_type='3' contestant_id='$cmemid' mylikes='$pic_likes3' style='opacity:0.4;' file1='$file3i' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file3i'>$pic_likes3</fonts> Likes</strong>";
                                        echo "</span>
                                        <p style='color:#999; padding-top:6px'>(Total of 50 Likes on all your photos will be a bonus of one vote)</p>
                                    </div>
                                </p>
                            </div>";
                        }
                    }

                echo '</div>
                
                        <div data-u="thumbnavigator" class="jssort101" style="position:absolute;left:0px;bottom:0px;width:980px;height:100px;background-color:#000;" data-autocenter="1" data-scale-bottom="0.75">
                            <div data-u="slides">
                                <div data-u="prototype" class="p" style="width:190px;height:90px;">
                                    <div data-u="thumbnailtemplate" class="t"></div>
                                    <svg viewbox="0 0 16000 16000" class="cv">
                                        <circle class="a" cx="8000" cy="8000" r="3238.1"></circle>
                                        <line class="a" x1="6190.5" y1="8000" x2="9809.5" y2="8000"></line>
                                        <line class="a" x1="8000" y1="9809.5" x2="8000" y2="6190.5"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                
                        <div data-u="arrowleft" class="jssora106 jssora107" style="width:55px;height:55px;top:162px;left:30px;" data-scale="0.75">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <circle class="c" cx="8000" cy="8000" r="6260.9"></circle>
                                <polyline class="a" points="7930.4,5495.7 5426.1,8000 7930.4,10504.3 "></polyline>
                                <line class="a" x1="10573.9" y1="8000" x2="5426.1" y2="8000"></line>
                            </svg>
                        </div>
                        <div data-u="arrowright" class="jssora106 jssora108" style="width:55px;height:55px;top:162px;right:30px;" data-scale="0.75">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <circle class="c" cx="8000" cy="8000" r="6260.9"></circle>
                                <polyline class="a" points="8069.6,5495.7 10573.9,8000 8069.6,10504.3 "></polyline>
                                <line class="a" x1="5426.1" y1="8000" x2="10573.9" y2="8000"></line>
                            </svg>
                        </div>
                    </div>';
            
            ?>

        <script type="text/javascript">jssor_1_slider_init();</script>
    
    <?php
        }else{
            echo "<p style='padding:2em 1em; text-align:center; color:#ccc;'>No Gallery Yet!</p>";
        }

    }


    function delete_records(){
        $txtall_id = $this->input->post('txtall_id');
        $txt_dbase_table = $this->input->post('txt_dbase_table');
        $profile_details = $this->sql_models->deleteTblRecords($txt_dbase_table, $txtall_id);
        if($profile_details) echo "deleted"; else echo "error";
    }



    function load_mem_details(){
        $memid = $this->input->post('memids');
        $sw_id = $this->input->post('swid');
        $myvotes = $this->input->post('myvotes');
        $pic_path = $this->input->post('pics1');
        
        $profile_details = $this->sql_models->fetch_A_MemProfile($memid, '');
        $id = $profile_details['id'];
        $fname = ucfirst($profile_details['fname']);
        $lname = ucfirst($profile_details['lname']);
        $phones = $profile_details['phones'];
        $emails = $profile_details['emails'];
        //$picx = $profile_details['pics'];
        $states = $profile_details['statee'];
        $gender = $profile_details['gender'];
        $occupatn = ucwords($profile_details['occupatn']);
        $hear_about = $profile_details['hear_about'];
        $relationshp_status = $profile_details['relationshp_status'];
        $hobbies = $profile_details['hobbies'];
        $likes = $profile_details['likes'];
        $dislikes = $profile_details['dislikes'];
        $bios = nl2br($profile_details['bios']);
        $kind_of_partner = $profile_details['kind_of_partner'];
        $ful_name = ucwords("$fname $lname");
        if($gender=="m") $gender1="Male"; else $gender1="Female";

        if($relationshp_status=="s") $relationshp_status = "Single";
        else if($relationshp_status=="e") $relationshp_status = "Engaged";
        else if($relationshp_status=="m") $relationshp_status = "Married";
        else if($relationshp_status=="d") $relationshp_status = "Divorced";

        if($relationshp_status=="") $relationshp_status="<label style='color:#888; font-size:14px;'>Not Specified</label>";
        if($hobbies=="") $hobbies="<label style='color:#888; font-size:14px;'>Not Specified</label>";
        if($likes=="") $likes="<label style='color:#888; font-size:14px;'>Not Specified</label>";
        if($dislikes=="") $dislikes="<label style='color:#888; font-size:14px;'>Not Specified</label>";
        if($bios=="") $bios="<label style='color:#888; font-size:14px;'>Not Specified</label>";
        if($kind_of_partner=="") $kind_of_partner="<label style='color:#888; font-size:14px;'>Not Specified</label>";
        if($occupatn=="") $occupatn="<label style='color:#888; font-size:14px;'>Not Specified</label>";

        $gen_num1=time();
        $gen_num1=substr($gen_num1,6);
        $ful_name1 = str_replace(" ", "-", $ful_name);
        $url1 = base_url()."viewprofile/$memid$gen_num1/$ful_name1/";

        $tweets = "Hi dear, I'm $ful_name at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";
        $title_whatsapp = "Hi dear, I'm *$ful_name* at *OurFavCelebs*, I would like to plead for your support by voting for me, thank you in advance.";
        $sTitle_whatsapp = ucwords($title_whatsapp)."%0A%0A$url1";
        ?>

        <div id="tab-1" class="tab-content current">
            <p class="inside_vote"><strong class="vt_counts">0 Votes</strong></p>
            <p><span class="voteme voteme_inside" id="voteme" swid="<?=$sw_id;?>" names="<?=$ful_name;?>" myvotes="<?=$myvotes;?>" memids="<?=$memid;?>" pics1="<?=$pic_path;?>">Vote Me</span></p>

            <div class="socials_profile">
                <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><img src="<?=base_url();?>images/facebook.png" alt=""></a>
                <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><img src="<?=base_url();?>images/twitter1.png" alt=""></a>
                <a class="hitLink mobiles_view" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><img src="<?=base_url();?>images/whatsapp.png" alt=""></a>
                <a class="hitLink not_mobiles_view" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><img src="<?=base_url();?>images/whatsapp.png" alt=""></a>
            </div>

            <div class="biographys">
                <table>
                    <tr>
                    <td><b>Name</b></td>
                    <td><?=$ful_name;?></td>
                    </tr>

                    <tr>
                    <td><b>From</b></td>
                    <td><?=$states;?></td>
                    </tr>

                    <tr>
                    <td><b>Gender</b></td>
                    <td><?=$gender1;?></td>
                    </tr>

                    <tr>
                    <td><b style="font-sizes:13px;">Relationship Status</b></td>
                    <td><?=$relationshp_status;?></td>
                    </tr>

                    <tr>
                    <td><b>Occupation</b></td>
                    <td><?=$occupatn;?></td>
                    </tr>

                    <tr>
                    <td><b>Hobbies</b></td>
                    <td><?=$hobbies;?></td>
                    </tr>

                    <tr>
                    <td><b>Likes</b></td>
                    <td><?=$likes;?></td>
                    </tr>

                    <tr>
                    <td><b>Dislikes</b></td>
                    <td><?=$dislikes;?></td>
                    </tr>

                    <tr>
                    <td><b>Your kind of partner</b></td>
                    <td><?=$kind_of_partner;?></td>
                    </tr>

                    <tr style="border:none !important">
                    <td><b>Biography</b></td>
                    <td><?=$bios;?></td>
                    </tr>

                </table>
            </div>
        </div>

    <?php
    }



    function save_stud_test_start(){
        $qid = $this->input->post('qid');
        $studid = $this->input->post('studid');
        $newdata3 = array(
            'memid'         => $studid,
            'quiz_intro_id' => $qid,
            'started_test'  => 1
        );
        $this->db->insert('stud_start_test', $newdata3);
        return true;
    }



    function use_quiz_questions(){
        $sess = $this->input->post('sess'); // prev sess 
        $txtsessions = $this->input->post('txtsessions'); // new ses
        $txtact_id = $this->input->post('txtact_id');
        $querys = $this->sql_models->updateSessions($sess, $txtsessions, $txtact_id);
        if($querys) echo "updateds"; else "error!";
    }



    function renew_payment(){
        $mems = $this->input->post('mems');
        $gameid1 = $this->input->post('gameid1');
        $get_mems_names = $this->sql_models->getMemberID($mems);
        $paidusers = $this->sql_models->isSentMail($mems);
        if($paidusers){
            $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
            $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Admin,</b></p>";
            $message_contents .= "<p style='font-size:14px; margin-top:10px'>A contestant $get_mems_names has requested to be
            part of the new activity again and will soon make their payment, kindly be alert to approve the payment.</p>";
            $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
            $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

            $admin_emails = "info@ourfavcelebs.com, donchibobo@gmail.com";
            $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
            $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'from' => "$get_mems_names @ Activity Payments Alert <info@ourfavcelebs.com>",
                'to' => $admin_emails,
                'subject' => "Payment Notification Alert From $get_mems_names",
                'html' => $message_contents
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            echo "inserted"; 
        }else{
            echo "duplicates";
        }
    }
    


    function save_my_ansas(){
        $txtgameid = $this->input->post('txtgameid');
        $txtses = $this->input->post('txtses');
        $txtmember = $this->input->post('txtmember');
        $txt_time_finished = $this->input->post('txt_time_finished');
        $for_days = $this->input->post('for_days');
        $my_answers = $this->session->userdata('my_answers');
        $quizid = $this->session->userdata('quizid');
        $my_answers=substr($my_answers, 0, -2);
        $quizid=substr($quizid, 0, -1);

        $answers = explode('||', $my_answers);
        $ids = explode(',', $quizid);

        $sums=0;
        foreach($ids as $index=>$ids1){
            $mem_ans = $answers[$index];
            if($this->sql_models->computeScores($ids1, $mem_ans)){
                $sums+=1;
            }
        }

        //$total_question = count($answers); // 2
        $total_question = $this->sql_models->totlQuestions($txtses);
        $total_score = $sums/$total_question; // 1/2 
        $total_score1 = $total_score*100; // 0.5*100 = 50
        $total_score1 = round($total_score1);

        $newdata3 = array(
            'memid'             => $txtmember,
            'gameid'            => $txtgameid,
            'sess1'             => $txtses,
            'answers'           => $my_answers,
            'ids'               => $quizid,
            'time_finished'     => $txt_time_finished,
            'scores'            => $total_score1
        );

        $newdata4 = array(
            'memid'           => $txtmember,
            'activity_id'     => $txtgameid,
            'expired'         => 0, // until the time of the day expire and not when u r tru
            'what_day'        => $for_days,
            'scores'          => 0,
            'scores2'         => 0,
            'scores3'         => 0,
            'winner_computed' => 0,
            'dates'           => @date("Y-m-d g:i a", time())
        );
        $this->sql_models->insert_scores($newdata3);
        $querys1 = $this->sql_models->insert_activities($newdata4);

        $newdata5 = array(
            'my_answers' => "",
            'quizid'     => "",
        );
        $this->session->set_userdata($newdata5);
        echo "recorded";
    }



    public function getSearches(){
        $keyword = $this->input->post('keyword');
        if(isset($keyword) && $keyword!=""){
            $result = $this->sql_models->searchStr($keyword);
            foreach ($result as $rs) {
                //$fnames = strtolower($rs['fname']);
                $fnames = $rs['fname'];
                $lnames = $rs['lname'];
                $emails = $rs['emails'];
                $fnames = "$fnames $lnames (at) $emails";
                $returnStr = str_replace($this->input->post('keyword'), '<b style="color:#960">'.$this->input->post('keyword').'</b>', ucwords($rs['fname']).' '.$fnames);
                echo '<li class="set_item" onclick="set_item(\''.str_replace(array("'"), "\'", $fnames).'\')">'.$returnStr.'</li>';
            }
        }   
    }
    



    function reset_session(){
        $this->nativesession->set( 'last_prodid', '');
        $this->nativesession->set( 'txtmemid_bma', '');
    }




    function make_admins(){
        $memid = $this->input->post('memid');
        $txtchoose = $this->input->post('txtchoose');
        //$check_if_admin = $this->sql_models->isAdmin2($memid);
        $querys1 = $this->sql_models->update_set_admin($memid, $txtchoose);
        echo "made_admin";
    }


    function check_if_voteds(){
        $memids = $this->input->post('memids');
        $swid = $this->input->post('swid');
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        $vote_phone = $this->input->cookie('vote_phone', TRUE);
        if($vote_phone) $vote_phone="";
        $querys1 = $this->sql_models->check_if_voted($memids, $swid, $ipaddr, $vote_phone);
        echo $querys1;
    }


    function check_if_voted_free(){
        $memids = $this->input->post('memids');
        $swid = $this->input->post('swid');
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        $vote_phone = $this->input->cookie('vote_phone', TRUE);
        if($vote_phone) $vote_phone="";
        $querys1 = $this->sql_models->check_if_voted_free_m($memids, $swid, $ipaddr, $vote_phone);
        echo $querys1;
    }



    function update_ph_views(){
        $media_id = $this->input->post('media_id');
        //$media = $this->input->post('media');
        $this->db->select('views')->from('gallery_vid')->where('id', $media_id);
        $query = $this->db->get();
        $views1 = $query->row('views');
        if($views1==null || $views1=="") $views1=0;
        $this->db->set('views', $views1+1, FALSE);
        $this->db->where('id', $media_id);
        $this->db->update('gallery_vid');
    }


    public function set_upload_options($file_path) {
        // upload an image options
        $config = array();
        $config ['upload_path'] = $file_path;
        $config['allowed_types'] = "*";
        $config['max_size'] = '3072'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = FALSE;
        return $this->load->library('upload', $config);
        //return $config;
    }

    


    function fetch_pics_for_this_id(){
        $update_id = $this->input->post('update_id');
        if(isset($update_id) && !empty($update_id)){
            $this->nativesession->set( 'last_prodid', $update_id );
            $records = $this->sql_models->bringPics($update_id);

            $output = '';
            if($records){
                foreach($records as $row){
                    $idd = $row['id'];
                    $files = $row['files'];
                    $exts = pathinfo($files, PATHINFO_EXTENSION);
                    $img_ext_chk1 = array('jpg','png','jpeg');
                    $files = str_replace(" ", "_", $files);
                    if(in_array($exts,$img_ext_chk1)){
                        $output .= "<font class='house_rem$idd'><img src='".base_url()."events_fols/$files'>";
                        $output .= "<span ids='".$idd."' id='remove_pic' class='remove_pic$idd'>Remove</span></font>";
                    }else{
                        $output .= "<font class='house_rem$idd'><img src='".base_url()."events_fols/$files'>
                        <a href='#' class='icon-post-format plays'><i class='fa fa-play'></i></a>";
                        $output .= "<span ids='".$idd."' id='remove_pic' class='remove_pic$idd'>Remove</span></font>";
                    }
                }
            }
            echo $output;
        }
    }




    function remove_pics(){
        $prodid = $this->input->post('prodid');
        $querys1 = $this->sql_models->deleteEachFile($prodid);
        echo "deleted";
    }


    function delete_post(){
        $post_id = $this->input->post('post_id');
        $type1 = $this->input->post('type1');
        $this->sql_models->deleteFrmPost($post_id, $type1);
        echo "deleted";
    }


    // public function login(){
    //     $data['page_title'] = "User Login - faseaser";
    //     $data['page_name'] = "login";
    //     $data['show_name'] = $this->sql_models->show_my_name();
    //     $this->load->view("login", $data);
    // }


    function signout(){
        $cookie = array(
            'name'   => 'my_usernames',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );
        $cookie1 = array(
            'name'   => 'my_passwords',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );
        delete_cookie($cookie);
        delete_cookie($cookie1);
    }


    


    function store_voters(){
        // $this->form_validation->set_rules('txtvote_email', 'email', 'required|trim|valid_email');
        // if($this->form_validation->run() == FALSE){
        //     echo validation_errors();
        // }else{
            $conte_id = $this->input->post('conte_id');
            $acti_id = $this->input->post('acti_id');
            $ipaddr = $_SERVER['REMOTE_ADDR'];
            $cookie_fund_name = $this->input->cookie('cookie_fund_name', TRUE);
            $cookie_fund_phone = $this->input->cookie('cookie_fund_phone', TRUE);
            
            $data = array(
                'activity_id'   => $acti_id,
                'voters_names'  => $cookie_fund_name,
                'phones'        => $cookie_fund_phone,
                'ip_addrs'      => $ipaddr,
                'votes'         => 1,
                'amt_paid'      => 0,
                'contestant_id' => $conte_id
            );

            // $chk_valid = $this->sql_models->check_email_validity1($data);
            // if($chk_valid){
            //     echo "Email already exists, please check your mail and get the code.";
            // }else{

                if($this->sql_models->already_voted($data)){
                    echo "You have already voted for this contestant";
                }else{
                    $this->db->insert('all_votes', $data);
                    echo "valids";

                    /*$now = 2147483647 - time();
                    $cookie = array(
                        'name'   => 'voters_email',
                        'value'  => $txtvote_email,
                        'expire' => $now,
                        'secure' => FALSE
                        );
                    set_cookie($cookie);

                    ///////////////////////////////
                        $txtvote_email = strtolower($txtvote_email);
                        // $headers = 'MIME-Version: 1.0'."\r\n";
                        // $headers .= 'From: OurFavCelebs Code Activation <info@ourfavcelebs.com>'. "\r\n";
                        // $headers .= 'Content-Type: text/html; charset=iso-8859-1'. "\r\n";
                        // $headers .= 'X-Mailer: PHP';
                        // $email_subject = "OurFavCelebs Contestants Votes";

                        $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                        $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Voter,</b></p>";
                        $message_contents .= "<p style='font-size:14px; margin-top:10px'>
                        One more step to complete this vote, please copy the code below and paste in the voters box on the website.
                        </p>";

                        $message_contents .= "<p style='font-size:18px; margin-top:10px'>Code: $gen_num2</p>";
                        $message_contents .= "<p style='font-size:14px; margin:10px 0 20px 0'>Thank you!</p>";
                        $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                        $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

                        $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
                        $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                            'from' => "OurFavCelebs Code Activation <info@ourfavcelebs.com>",
                            'to' => $txtvote_email,
                            'subject' => "OurFavCelebs Contestants Votes",
                            'html' => $message_contents
                        ));
                        $result = curl_exec($ch);
                        curl_close($ch);
                        
                        //$mailme = @mail($txtvote_email, $email_subject, $message_contents, $headers);
                        echo "valids";
                    ///////////////////////////////*/
                }
            //}
        //}
    }


    // function store_voters_premium(){
    //     echo "valids";
    // }


    function store_voters_premium(){
        $this->form_validation->set_rules('txtvote_name', 'Full Names', 'required|trim|alpha_space|min_length[4]');
        $this->form_validation->set_rules('txtvote_phone', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $txtvote_name = $this->input->post('txtvote_name');
            $txtvote_phone = $this->input->post('txtvote_phone');
            $txtvote_ip = $this->input->post('txtvote_ip');
            $conte_id = $this->input->post('conte_id');
            $acti_id = $this->input->post('acti_id');
            $amts = $this->input->post('amts');

            if($amts==50)
                $votes_cnt = 5;
            else if($amts==100)
                $votes_cnt = 10;
            else
                $votes_cnt = 1;

            //$gen_num2=substr(time(), 4);
            $ipaddr = $_SERVER['REMOTE_ADDR'];

            $data = array(
                'activity_id'   => $acti_id,
                'voters_names'  => $txtvote_name,
                'ip_addrs'      => $ipaddr,
                'votes'         => $votes_cnt,
                'contestant_id' => $conte_id,
                'phones'        => $txtvote_phone,
                'amt_paid'      => $amts
            );

            $already_voted1 = $this->sql_models->already_voted1($data);
            if($already_voted1){
                echo "You have already voted for this contestant.";
            }else{
                $chk_pending = $this->sql_models->check_pending_payment($ipaddr, $txtvote_phone, $amts);
                if($chk_pending){ // check pending payments
                    echo 'The amount in your wallet is low, please <a href="javascript:;" class="open_fund" style="color: #093">fund wallet</a>';
                }else{

                    $inserted = $this->db->insert('all_votes', $data);
                    if($inserted){
                        $this->db->set('amts', "amts-$amts", FALSE);
                        $inserted = $this->db->where('ipaddrs', $txtvote_ip)->where('phone', $txtvote_phone)->where('amts >', $amts)->update('fund_wallet');
                        echo "valids";
                    }else{
                        echo "Voting Error!";
                    }
                    
                    /*///////////////////////////////
                        $txtvote_email = strtolower($txtvote_mail);
                        // $headers = 'MIME-Version: 1.0'."\r\n";
                        // $headers .= 'From: OurFavCelebs Code Activation <info@ourfavcelebs.com>'. "\r\n";
                        // $headers .= 'Content-Type: text/html; charset=iso-8859-1'. "\r\n";
                        // $headers .= 'X-Mailer: PHP';
                        // $email_subject = "OurFavCelebs Contestants Votes";

                        $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                        $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Voter,</b></p>";
                        $message_contents .= "<p style='font-size:14px; margin-top:10px'>
                        One more step to complete the 5 vote addition to your contestant, please copy the code below and paste in the voters box on the website.
                        </p>";

                        $message_contents .= "<p style='font-size:18px; margin-top:10px'>Code: $gen_num2</p>";
                        $message_contents .= "<p style='font-size:14px; margin:10px 0 20px 0'>Thank you!</p>";
                        $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                        $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

                        $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
                        $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                            'from' => "OurFavCelebs Code Activation <info@ourfavcelebs.com>",
                            'to' => $txtvote_email,
                            'subject' => "OurFavCelebs Contestants Votes",
                            'html' => $message_contents
                        ));
                        $result = curl_exec($ch);
                        curl_close($ch);
                        
                        //$mailme = @mail($txtvote_email, $email_subject, $message_contents, $headers);
                    ///////////////////////////////*/
                    
                }
            }
        }
    }



    function store_voters_premium1(){
        $txtvote_acctname = $this->input->post('txtvote_acctname');
        $txtbank = $this->input->post('txtbank');
        $txtvote_phone = $this->input->post('txtvote_phone');
        $conte_id = $this->input->post('conte_id');
        $acti_id = $this->input->post('acti_id');
        $amts = $this->input->post('amts');
        $txtvote_mail = $this->input->post('txtvote_mail1');
        $txtvote_code = $this->input->post('txtvote_code1');

        if(!$this->sql_models->check_code_validity($txtvote_code, $txtvote_mail, $acti_id)){
            echo "Invalid Code Entered";
        }else{

            $gen_num2=substr(time(), 4);
            $ipaddr = $_SERVER['REMOTE_ADDR'];
                
            $this->db->set('activated', 1);
            $this->db->set('email_code', 0);
            $inserted = $this->db->where('email_code', $txtvote_code)->where('voters_email', $txtvote_mail)->where('activity_id', $acti_id)->update('all_votes');

            if($inserted){
                // $now = 2147483647 - time();
                // $cookie = array(
                //     'name'   => 'vote_phone',
                //     'value'  => $txtvote_phone,
                //     'expire' => $now,
                //     'secure' => FALSE
                //     );
                // set_cookie($cookie);
                echo "valids2";
            }else{
                echo "Error in saving your details, please try again.";
            }
        }
    }




    function store_update_voters(){
        $txtvote_email = $this->input->post('txtvote_email');
        $txtvote_code = $this->input->post('txtvote_code');
        $acti_id = $this->input->post('acti_id');

        if(!$this->sql_models->check_code_validity($txtvote_code, $txtvote_email, $acti_id)){
            echo "Invalid";
        }else{

            $votes = $this->sql_models->update_voters($txtvote_code, $txtvote_email, $acti_id);
            $cookie = array(
                'name'   => 'voters_email',
                'value'  => '',
                'expire' => '0',
                'secure' => FALSE
            );
            delete_cookie($cookie);
            echo $votes;
        }
    }



    function logme_adms(){
        $this->form_validation->set_rules('txtuname', 'username', 'required|trim');
        $this->form_validation->set_rules('txtpass', 'password', 'required|trim');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $is_correct_id = $this->sql_models->auth_details(strtolower($this->input->post('txtuname')), strtolower($this->input->post('txtpass')));

            if($is_correct_id){
                echo "successor1";
            }else{
                echo "Invalid details entered!";
            }
        }
    }



    function reset_pass(){
        $this->form_validation->set_rules('txtuname_f', 'email', 'required|trim|valid_email');
        if($this->form_validation->run() == FALSE){

            echo validation_errors();
        }else{

            $txtresetmail = $this->input->post('txtuname_f');
            $ago_time=date("Y-m-d g:i a");
            $gen_num1=time();
            $gen_num1=substr($gen_num1,5);
            
            $data = array(
                'emails' => $txtresetmail,
                'codes' => $gen_num1,
                'date_reset' => $ago_time
            );

            $my_name = $this->sql_models->check_email_validity1($data);
            if($my_name){ // if valid, save in database and send me a code to my mail

                ///////////////////////////////
                $txtresetmail = strtolower($txtresetmail);
                $my_name = ucwords($my_name);

                $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello $my_name,</b></p>";
                $message_contents .= "<p style='font-size:14px; margin-top:10px'>Your password reset was successful, 
                please copy this reset code and click on the link below to finally reset your password. 
                Make sure it opened in the same browser you used to reset your password.</p>";
                $message_contents .= "<p style='font-size:14px; margin:5px 0 20px 0'>Your password Reset Code: $gen_num1</p>";

                $message_contents .= "<p style='font-weight:normal;'><a href='http://www.ourfavcelebs.com/resetpassword/' 
                style='color:#0066FF' target='_blank'>Click here to reset your password</a></p>";
                $message_contents .= "<p style='font-weight:normal; margin-top:10px'>If you did not request password reset, please 
                disregard this message and nothing will change.</p><br><br>";

                $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

                $api_key= "2927c79e9f3e624977ac0d5b0c977504-c1fe131e-c11cad41";/* Api Key got from https://mailgun.com/cp/my_account */
                $domain = "righturngroup.com";/* Domain Name you given to Mailgun */
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'from' => "BrandMarket Password Reset <info@ourfavcelebs.com>",
                    'to' => $txtresetmail,
                    'subject' => "Password Reset",
                    'html' => $message_contents
                ));

                $result = curl_exec($ch);
                curl_close($ch);
                echo "email_sent_success_1";
                ///////////////////////////////

            }else{
                echo "The email you entered does not match with your registered one.";
            }
        }
    }


    
    function send_contact_msg(){
        $this->form_validation->set_rules('txtname', 'full names', 'required|trim|alpha_space|max_length[30]');
        $this->form_validation->set_rules('txtphs', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
        $this->form_validation->set_rules('txtemail', 'email', 'required|trim|valid_email');
        $this->form_validation->set_rules('txtsubject', 'subject', 'required|trim');
        $this->form_validation->set_rules('txtmessage', 'message', 'required|trim');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            
            $txtname = $this->input->post('txtname');
            $txtphs = $this->input->post('txtphs');
            $txtemail = $this->input->post('txtemail');
            $txtsubject = $this->input->post('txtsubject');
            $txtmessage = $this->input->post('txtmessage');

            ///////////////////////////////
                $txtemail = strtolower($txtemail);
                $my_name = ucwords($txtname);

                $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Admin,</b></p>";
                $message_contents .= "<p style='font-size:14px; margin-top:10px'>You have a message from $my_name sent at OurFavCelebs contact page. </p>";
                $message_contents .= "<p style='font-size:14px; margin:15px 0 5px 0'><b>Name: </b>$my_name</p>";
                $message_contents .= "<p style='font-size:14px; margin:5px 0 5px 0'><b>Phone:</b>$my_name</p>";
                $message_contents .= "<p style='font-size:14px; margin:5px 0 5px 0'><b>Subject:</b>$txtsubject</p>";
                $message_contents .= "<p style='font-size:14px; margin:0px 0 20px 0'><b>Message</b><br>$txtmessage</p><br><br>";

                $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                $message_contents .= "<a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";

                $api_key= "1324a12a8b8cb5fa8c37eae2d32d60a9-7bce17e5-035cbea7";
                $domain = "sandboxdf3e8fd879774184a8074162b4896960.mailgun.org";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'from' => "$my_name @ Contact Page <info@ourfavcelebs.com>",
                    'to' => "info@ourfavcelebs.com",
                    'bcc' => "donchibobo@gmail.com",
                    'subject' => "You Have A New Message From $my_name",
                    'html' => $message_contents
                ));
                $result = curl_exec($ch);
                curl_close($ch);

                echo "msg_sent";
            ///////////////////////////////
        }
    }
    



    function add_likes(){
        $dislike = $this->input->post('dislike');
        $con_id = $this->input->post('con_id');
        $file1i = $this->input->post('file1');
        $ipaddr = $this->input->post('ipaddr');
        $like_type = $this->input->post('like_type');
        $swid = $this->input->post('swid');

        $data = array(
            'activity_id'   => $swid,
            'contestant_id' => $con_id,
            'pics'          => $file1i,
            'ip_addrs'      => $ipaddr,
            'likes'         => 1
        );
        $this->sql_models->insert_update_likes($data, $dislike);
        $pic_likes1 = $this->sql_models->fetchLikes($file1i, $ipaddr);

        if($like_type>1) $like_type1=$like_type; else $like_type1="";
        
        if(!$this->sql_models->fetchLikes($file1i, $ipaddr))
            echo "<strong class='likes$like_type1' id='likes$file1i' swid='$swid' contestant_id='$con_id' file1='$file1i' mylikes='$pic_likes1' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file1i'>$pic_likes1</fonts> Likes</strong>";
        else
            echo "<strong class='likes1$like_type1' id='likes1$file1i' swid='$swid' contestant_id='$con_id' mylikes='$pic_likes1' style='opacity:0.4;' file1='$file1i' ipaddr='$ipaddr'><font class='fa fa-thumbs-o-up thumbs'></font> &nbsp;<fonts class='incr_lks$file1i'>$pic_likes1</fonts> Likes</strong>";
    }

    

    function fetch_categories(){
        $sessions = $this->input->post('ids');
        $txt_srch = $this->input->post('txt_srch');

        $data['param1'] = "pages";
        $record=0;
        $recordPerPage = 28;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $recordCount = $this->sql_models->countContestantsCats();
        $empRecord = $this->sql_models->fetchContestantsCats($sessions, $txt_srch, $record, $recordPerPage);
        $config['base_url'] = base_url().'node/contestant';

        ////////////////////
            $config["total_rows"] = $recordCount;
            $config["per_page"] = $recordPerPage;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="gallery-pagination photos_pagn"><div class="gallery-pagination-inner"><ul>';
            $config['full_tag_close'] = '</ul></div></div>';

            $config['first_link'] = FALSE;
            $config['first_tag_open'] = FALSE;
            $config['first_tag_close'] = FALSE;
            
            $config['last_link'] = FALSE;
            $config['last_tag_open'] = FALSE;
            $config['last_tag_close'] = FALSE;

            $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
            $config['cur_tag_close'] = '</a></li>';
            
            $config['next_link'] = '<span>Next page</span> <i class="icon-right-4"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="icon-left-4"></i> <span>PREV page</span>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        ////////////////////

        //$data['pg_name'] = "photo";
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        
        //$contestants = $this->sql_models->fetchContestantsCats($sessions, $txt_srch);
        if($empRecord){
        ?>
            <div class="blog-right-section">
                <div class="row page-wrap group load_contestns">

                    <?php
                        foreach ($empRecord as $rs) {
                            $sw_id = $rs['sw_id'];
                            $file1 = $rs['file1'];
                            $file2 = $rs['file2'];
                            $file3 = $rs['file3'];
                            $memid = $rs['memid'];
                            $mydate = $rs['dates'];
                            $views = $rs['views'];
                            $views2="";
                            if($views>0) $views2 = "(".@number_format($views).")";
                            $overall_title = ucwords($rs['overall_title']);
                            $mystates = $this->sql_models->contestantState($memid);
                            $names = $this->sql_models->contestantName($memid);
                            $myvotes = $this->sql_models->countVotes($memid, $sw_id, '');
                            $myvotes = @number_format($myvotes);
                            $names1 = explode(' ', $names);
                            $fname1 = $names1[0];
                            $lname1 = $names1[1];

                            //$my_pics = array($file1, $file2, $file3);
                            //$pics = $my_pics[array_rand($my_pics, 1)];
                            $pics = $file1;
                            $pic_pathi = base_url()."activity_photos/$pics";
                            //$pic_path = base_url()."watermark.php?image=".base_url()."activity_photos/$pics&watermark=".base_url()."images/watermrk.png";
                            $pic_path = base_url()."activity_photos/$pics";

                            if($pics==""){
                                $pics = $this->sql_models->profilePics($memid);
                                $pic_pathi = base_url()."celebs_uploads/$pics";
                                //$pic_path = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";
                                $pic_path = base_url()."celebs_uploads/$pics";
                            }
                            $mydates = date("jS F, Y", $mydate);
                            $mylikes = $this->sql_models->fetchMemLikes($memid);
                            $mylikes = @number_format($mylikes);
                            $my_photo_cnts = $this->sql_models->fetchPhotoCounts($memid);

                            $gen_num1=substr(time(),6);
                            $names1 = str_replace(" ", "-", $names);
                            $url1 = base_url()."viewprofile/$memid$gen_num1/$names1/";
                            $tweets = "Hi dear, I'm $names at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";
                            $title_whatsapp = "Hi dear, I'm *$names* at *OurFavCelebs*, I would like to plead for your support by voting for me, thank you in advance.";
                            $sTitle_whatsapp = ucwords($title_whatsapp)."%0A%0A$url1";
                            $c_g_id = $this->sql_models->current_main_game_id();
                            ?>

                                <div class="col-md-3 col-sm-6 wow_ _fadeInDown scroll_to_mem<?=$memid;?>" data-wow-duration="1000ms" data-wow-delay="300ms">
                                    <div class="feature-img">
                                        <div class="photos1"><?=$my_photo_cnts;?> photos</div>
                                        <div class="height_img">
                                            <a href="javascript:;" class="view_profiles" activityid="<?=$sw_id;?>" memid="<?=$memid;?>" fulnames="<?=$names;?>" fname="<?=$fname1;?>" lname="<?=$lname1;?>">
                                                <img src="<?=$pic_path;?>" alt="">
                                            </a>
                                        </div>

                                        <div class="date-feature my_names">
                                            <?=$names;?>
                                            <p class="states_1">
                                                <?php if($mystates!="FCT Abuja") echo "$mystates State"; ?>
                                            </p>
                                        </div>

                                    </div>
                                    <div class="feature-info group">
                                        <p style="color:#333;"><b><font class="vote_counts<?=$memid;?>"><?=$myvotes;?></font> Votes | <?=$mylikes;?> Likes</b></p>
                                        <p style="color:#990; font-size:14px; margin-bottom:2px;" class="pageant_name"><b><?=ucwords($overall_title);?></b></p>
                                        <p style="font-size:14px; color:#666;"><?=$mydates;?></p>

                                        <div class="socials socials_pageant">
                                            <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook"></i></a>
                                            <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><i class="fa fa-twitter"></i></a>
                                            <a class="hitLink mobiles_view" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
                                            <a class="hitLink not_mobiles_view" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
                                        </div>
                                        
                                        <p class="view_pro">
                                            <?php if($c_g_id==$sw_id){ ?>
                                                <a href="javascript:;" class="voteme" id="voteme" swid="<?=$sw_id;?>" names="<?=$names;?>" myvotes="<?=$myvotes;?>" memids="<?=$memid;?>" pics1="<?=$pic_pathi;?>" >Vote Me</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" class="novoteme" id="novoteme" style="opacity:0.5;">Vote Me</a>
                                            <?php } ?>
                                            <a href="javascript:;" class="view_profiles" activityid="<?=$sw_id;?>" memid="<?=$memid;?>" fulnames="<?=$names;?>" fname="<?=$fname1;?>" lname="<?=$lname1;?>" >View <font><?=$views2;?></font></a>
                                        </p>
                                    </div>
                                </div>
                            <?php 
                        }
                    ?>
                    
                    <div style="clear:both"></div>
                    <?=$pagination;?>

                </div>
            </div>
        <?php
        }else{
            echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No contestants on the selected activity!</p>";
        }
    }



    function fetch_searched_vids(){
        $txt_srch = $this->input->post('txt_srch');
        
        $empRecord = $this->sql_models->fetchMedias('vid', '', '', $txt_srch);
        if($empRecord){
            foreach ($empRecord as $rs) {
                $titles = strtolower($rs['titles']);
                $titles = ucwords($titles);
                $views = $rs['views'];
                $media_type = $rs['media_type'];
                $dates = $rs['dates'];
                $files = $rs['files'];
                $mydates = date("jS F, Y", strtotime($dates));
                $views = @number_format($views);
                if(strlen($titles)>70)
                    $titles = substr($titles, 0, 70)."...";
            ?>
                <div class="col-md-4 col-sm-12 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="blog-right-listing blog-right-listing3 listings">
                        <div class="gallery-megic-blog">
    
                            <!-- <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="560" height="200" type="text/html" src="https://www.youtube.com/embed/<?=$files;?>?autoplay=0&fs=0&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0&origin=https://youtubeembedcode.com">
                                <div>
                                    <small><a href="https://youtubeembedcode.com/en">youtubeembedcode.com/en/</a></small>
                                </div>
                            </iframe> -->
                            <iframe src="http://www.youtube.com/embed/<?=$files;?>" class="youtubevid" frameborder="0" allowfullscreen></iframe>   
                            <div class="gallery-megic-detail_ vid_titles">
                                <p><?=$titles;?></p>
                                <font class="statss">
                                    <?php
                                    if($views>0)
                                    echo "<span><i class='icon-eye-6'></i> $views Views</span>";
                                    else
                                    echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                                    ?>
                                </font>
                            </div>
                        </div>
                    </div>
                </div>
    
            <?php 
            }
        }else{
            echo "<div style='clear:both'></div><p style='text-align:center; font-size:16px;'>No videos found!</p>";
        }
    }



    function fetch_searched_photos(){
        $txt_srch = $this->input->post('txt_srch');
        
        $empRecord = $this->sql_models->fetchMedias('pic', '', '', $txt_srch);
        if($empRecord){
            foreach ($empRecord as $rs) {
                $titles = strtolower($rs['titles']);
                $titles = ucwords($titles);
                $views = $rs['views'];
                $media_type = $rs['media_type'];
                $dates = $rs['dates'];
                $files = $rs['files'];
                $mydates = date("jS F, Y", strtotime($dates));
                $views = @number_format($views);
                if(strlen($titles)>70)
                    $titles = substr($titles, 0, 70)."...";

                $pic_path1 = base_url()."gallery/$files";
                //$pic_path = base_url()."watermark.php?image=".base_url()."gallery/$files&watermark=".base_url()."images/watermrk.png";

                $pic_path = base_url()."gallery/$files";
            ?>
                <div class="col-md-3 col-sm-6 col-xs-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="blog-right-listing blog-right-listing3">
                        <div class="gallery-megic-blog">
                            <a href="javascript:;" src1="<?=$pic_path1;?>" src="<?=$pic_path1;?>" class="magnific-popup enlarge_img">
                                <img src="<?=$pic_path1;?>" alt="" class="">
                                <div class="gallery-megic-inner">
                                    <div class="gallery-megic-out">
                                        <div class="gallery-megic-detail">
                                            <!-- <h2>Cheese Pasta</h2> -->
                                            <span><?=$titles;?></span>
                                            <font class="statss_">
                                                <?php
                                                if($views>0)
                                                echo "<span><i class='icon-eye-6'></i> $views Views</span>";
                                                else
                                                echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                                                ?>
                                            </font>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
            }
        }else{
            echo "<div style='clear:both'></div><p style='text-align:center; font-size:16px;'>No photos found!</p>";
        }
    }



    function fetch_years(){
        $sessions = $this->input->post('ids');
        $txt_srch = $this->input->post('txt_srch');
        $param1 = $this->input->post('param1');

        $evnt = $this->sql_models->fetchEventsByYear(); 
        $title2 = $evnt[0]['year'];
        if($title2=="") $title2 = "No Events Yet"; else $title2 = "$title2 Events";
        ?>
        
        <p class="pageant_title for_desktop show_back_title"><img src="<?=base_url();?>images/contestants.png" style="width:30px"> 
        &nbsp;<font class="cat_title"><?=$title2;?></font></p>

        <p class="copyrgt">All our contestant pictures here belong to us and may be subject to copyright</p>
        <div style="clear:both"></div>
                        
        <?php
        $record=0;
        $recordPerPage = 16;
        if($record != 0){
            $record = ($record-1) * $recordPerPage;
        }      	
        $events1 = $this->sql_models->fetchEvents($sessions, $txt_srch, $record, $recordPerPage);
        //$data['events1'] = $this->sql_models->fetchEvents('', '', $record, $recordPerPage);
        if($events1){
        ?>
            <!-- <div class="blog-right-section">
                <div class="row page-wrap group"> -->
                <div class="blog-right-section">
                    <div class="row page-wrap group">
                        <div class="col-md-12 col-sm-12 col-xs-12 expand_width">
                            <div class="blog-right-section">
                                <div class="row">
                                    <?php
                                    //echo $txt_srch."ssss";
                                        foreach ($events1 as $rs) {
                                            $id = $rs['id'];
                                            $titles = strtolower($rs['titles']);
                                            $titles = ucwords($titles);
                                            $titles1 = $titles;
                                            $descrip = ucfirst($rs['descrip']);
                                            $views = $rs['views'];
                                            $dates = $rs['dates'];
                                            $mydates = date("jS F, Y", strtotime($dates));
                                            $views = @number_format($views);
                                            $files = $this->sql_models->getPics($id);
                                            if(strlen($descrip)>130)
                                                $descrip = substr($descrip, 0, 130)."...";

                                            if(strlen($titles)>70)
                                                $titles = substr($titles, 0, 70)."...";

                                            //$pic_path = base_url()."watermark.php?image=".base_url()."events_fols/$files&watermark=".base_url()."images/watermrk.png";
                                            $pic_path = base_url()."events_fols/$files";

                                            if($param1!="pages"){
                                                $directs = base_url()."pages/#viewevents";
                                                $directs1 = "pages/#viewevents";
                                            }else{
                                                $directs = "javascript:;";
                                                $directs1 = "";
                                            }
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                <div class="blog-right-listing blog-right-listing2">
                                                    <font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer; position:relative; z-index:99">
                                                        <div class="feature-img feature-img1">
                                                            <img src="<?=$pic_path;?>" alt="Image loading...">
                                                        </div>
                                                    </font>
                                                    <div class="event_date"><label><?=$mydates;?></label></div>
                                                    <div class="feature-info feature-info1">
                                                        <h5><font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer;"><?=$titles;?></font></h5>
                                                        <p><?=$descrip;?> <a href="#" style="font-weight:normal; color:#0CF;">read more<i class="icon-right-4"></i></a></p>
                                                        <p class="statss">
                                                        <span><i class="icon-comment-5"></i> <?//=$pic_path;?> Comments</span>
                                                        <span><i class="icon-eye-6"></i> <?=$views;?> Views</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>

                    </div>
                </div>
        <?php
        }else{
            echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No events on the selected year!</p>";
        }
    }



    public function getForums(){
        $page = $this->input->post('page');
        $txtcats1 = $this->input->post('txtcats1');
        $txtsrch = $this->input->post('txt_srch');
        $param1 = $this->input->post('txtparams');
        $txtmemsid = $this->input->post('txtmemsid');
        
        $forums = $this->sql_models->fetchForum($page, $txtsrch, $txtcats1);
        if($forums){
            //echo '<div class="cover_contents"></div>';
            foreach ($forums as $rs) {
                $id1 = $rs['idf'];
                $conid = $rs['conid'];
                $fname = $rs['fname'];
                $lname = $rs['lname'];
                $topics = $rs['topics'];
                $pics = $rs['pics'];
                $messages = nl2br($rs['messages']);
                $messagesi = $messages;
                $files = $rs['files'];
                $views = $rs['views'];
                $views = @number_format($views);
                $dates = $rs['dates'];
                $ful_name = ucwords("$fname $lname");
                //$pic_path = base_url()."watermark.php?image=".base_url()."forum_files/$files&watermark=".base_url()."images/watermrk.png";
                $pic_path = base_url()."forum_files/$files";
                //$mydates = date("jS F, Y h:i a", strtotime($dates));
                if(strlen($messages)>300)
                    $messages = substr($messages, 0, 300)."...<span style='font-weight:normal; color:#69C;'>read more</span>";

                if($topics==1) $ttls = "General Discussion";
                else if($topics==2) $ttls = "Job Posting";
                else if($topics==3) $ttls = "Entertainments";
                else if($topics==4) $ttls = "Talents";
                else if($topics==5) $ttls = "Sex & Relationships";
                else if($topics==6) $ttls = "Kitchen";
                else if($topics==7) $ttls = "Games";
                else $ttls = "All Threads";

                if($param1!="pages"){
                    $directs = base_url()."pages/#viewreplies";
                    $directs1 = "pages/#viewreplies";
                }else{
                    $directs = "javascript:;";
                    $directs1 = "";
                }
                //$path_pics = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";
                $path_pics = base_url()."celebs_uploads/$pics";
                $replies_cnt = @number_format($this->sql_models->replyCounts($id1));
            ?>
                <div id='forumBox2' class="forumBox3 forumBox_scroll<?=$id1;?>" ids="<?=$id1;?>">
                    <div id="forumBox">
                        <div class="first_sec">
                            <div class="forum_img">
                                <img src='<?=$path_pics;?>' alt='Loading...' style='border-radius:30px; border:1px #999 solid;'>
                            </div>

                            <div class="forum_contents">
                                <div class="for_dates">
                                    <p style="font-size:15px; color:#8A8A00"><b><a href="javascript:;" style="color:#8A8A00;"><?=$ful_name;?></a></b>
                                        <font style="font-size:14px; margin-left:4px; color:#555"><?=time_ago($dates);?> <img src="<?=base_url()?>images/clock.gif" style="position:relative; top:-2px;"></font>
                                    </p>
                                    <p style="font-size:14px; color:#666; margin-top:-5px;">
                                        <b>Category:</b> <font style="margin-left:4px;"><?=$ttls;?></font>
                                    </p>
                                    <?php if($conid==$txtmemsid){ ?>
                                        <p class="menu_icn" id="menu_icn" ids="<?=$id1;?>"><img src="<?=base_url()?>images/menu_icon1.png" style="position:relative; top:15px;"></p>
                                    <?php }else{ ?>
                                        <p class="menu_icn">&nbsp;</p>
                                    <?php } ?>
                                </div>

                                <?php if($conid==$txtmemsid){ ?>
                                <div class="edit_div" id="edit_div<?=$id1;?>">
                                    <span id='editpost' counters="<?=$id1;?>" messages1="<?=strip_tags(ucfirst($messagesi));?>" topics="<?=$topics;?>" ids="<?=$id1;?>" files="<?=$files;?>" style='cursor:pointer'><a href='javascript:;'>Edit this post &raquo;</a></span>
                                    <span style='border:none; color:red; cursor:pointer' id='delpost' ids="<?=$id1;?>"><a href='javascript:;' style='color:red;'>Delete this post &raquo;</a></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <?php
                            $gen_num1=time();
                            $gen_num1=substr($gen_num1,6);
                            $url1 = base_url()."replies/$id1$gen_num1/";
                            $tweets = $messages;
                        ?>

                        <div class="row_contents">
                            <?php if($files!=""){ ?>
                                <div class="cmt_img col-md-3 col-sm-12 col-xs-12 img_forum" style="backgrounds:blue">
                                    <span class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>"><img src='<?=$pic_path;?>' alt='image'></span>
                                </div>
                                <div class="cmt_note_ col-md-9 col-sm-12 col-xs-12 containerx" style="backgrounds:red; line-height:20px;">
                                    <span class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>">
                                        <?php
                                        if($topics==2) // if its job, allow links
                                            echo makeLinks3(ucfirst($messages));
                                        else
                                            echo makeLinks2(ucfirst($messages));
                                        ?>
                                    </span>
                                </div>
                            <?php }else{ ?>
                                <div class="cmt_note_ col-md-12 col-sm-12 col-xs-12 containerx pt-5 pb-5 pt-sm-10 pb-sm-10" style="line-height:20px;">
                                    <span class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>">
                                        <?php
                                        if($topics==2) // if its job, allow links
                                            echo makeLinks3(ucfirst($messages));
                                        else
                                            echo makeLinks2(ucfirst($messages));
                                        ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <label id='copyTarget<?=$id1;?>' style='display:none'>
                                <?php
                                if($topics==2)
                                    echo makeLinks3(ucfirst($messagesi))."<br><br>".$url1;
                                else
                                    echo makeLinks2(ucfirst($messagesi))."<br><br>".$url1;
                                ?>
                            </label>
                            <div class="cover_contents" id="cover_contents<?=$id1;?>"></div>
                            <div class="copy_text" ids='<?=$id1;?>' id="copy_text<?=$id1;?>"><spans>Copy Text</spans></div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 comment_stats" style="backgrounds:blue">
                            <div class="col-md-4 col-sm-4 col-xs-4 for_cmts" style="backgrounds:blue">
                                <a href="javascript:;" class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>"><i class="fa fa-comment fa_comment"></i> <?=$replies_cnt;?></a>
                            </div>

                            
                            <div class="col-md-4 col-sm-4 col-xs-4" style="backgrounds:blue">
                            <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><img src="<?=base_url()?>images/facebook.png" style="width:29 !important"></a>&nbsp;
                            <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><img src="<?=base_url()?>images/twitter1.png" style="width:29 !important"></a>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4" style="backgrounds:blue">
                                <?=$views;?> views
                            </div>
                        </div>
                    </div>

                    <?php
                    $forums_rp = $this->sql_models->fetchForumRep1($id1);
                    if($forums_rp){
                        $id1i = $forums_rp['id'];
                        $conid = $forums_rp['conid'];
                        $fnamei = $forums_rp['fname'];
                        $lnamei = $forums_rp['lname'];
                        $replies = nl2br($forums_rp['replies']);
                        $repliesi = $replies;
                        $filesi = $forums_rp['files'];
                        $picsi = $forums_rp['pics'];
                        $datesi = $forums_rp['dates'];
                        if(strlen($replies)>90)
                            $replies = substr($replies, 0, 90)."...read more";
                        $ful_namei = ucwords("$fnamei $lnamei");

                        $mydatesi= date("jS F, Y h:i a", strtotime($datesi));
                        //$path_picsi = base_url()."watermark.php?image=".base_url()."celebs_uploads/$picsi&watermark=".base_url()."images/watermrk.png";  
                        $path_picsi = base_url()."celebs_uploads/$picsi";
                        ?>
                            <div class="small_comments">
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <img src='<?=$path_picsi;?>' alt='image' style='border-radius:30px; border:1px #999 solid;'>
                                </div>

                                <div class="col-md-10 col-sm-11 col-xs-11">
                                    <div class="for_dates_">
                                        <p style="font-size:14px; text-align:left; color:#8A8A00"><b><a href="javascript:;" style="color:#8A8A00;"><?=$ful_namei;?></a></b></p>
                                        <p class="main_cmts">
                                            <span class="open_comment" style="cursor:pointer" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>"><?=makeLinks2(ucfirst($replies)); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        <?php
                    }else{
                        echo "<p style='margin-bottom:-10px;'>&nbsp;</p>";
                    }
                    ?>

                </div>
                <div style="clear:both"></div>

            <?php
            }
            ?>
        
        <?php
        }else{
            echo "<p style='font-size:15px; text-align:center; color:#555; padding:15px 8px 0 5px; margin-bottom:3.5em; line-height:20px;'>No posts found on your search, redefine your search to find what you are looking for.</p>";
        }
    }



    public function getForums_reps(){
        $page = $this->input->post('page');
        $fr_ids = $this->input->post('fr_ids');
        $txtmemsid = $this->input->post('txtmemsid');
        $forums = $this->sql_models->fetchForumRep($page, $fr_ids);
        if($forums){
            $j=1;
            foreach ($forums as $row) {
                $id1i = $row['id'];
                $conid = $row['conid'];
                $fnamei = $row['fname'];
                $lnamei = $row['lname'];
                $replies = nl2br($row['replies']);
                $repliesi=$replies;
                $filesi = $row['files'];
                $picsi = $row['pics'];
                $datesi = $row['dates'];
                $ful_namei = ucwords("$fnamei $lnamei");
                //$pic_pathi = base_url()."watermark.php?image=".base_url()."forum_files/$filesi&watermark=".base_url()."images/watermrk.png";
                //$path_picsi = base_url()."watermark.php?image=".base_url()."celebs_uploads/$picsi&watermark=".base_url()."images/watermrk.png";  

                $pic_pathi = base_url()."forum_files/$filesi";
                $path_picsi = base_url()."celebs_uploads/$picsi";
            ?>
                <div class="small_comments small_comments1 forumBox3 forum_rep<?=$id1i.$j;?>" ids="<?=$id1i.$j;?>">
                    <div class="col-md-1 col-sm-2 col-xs-2 forum_img">
                        <img src='<?=$path_picsi;?>' alt='image' style='border-radius:30px; border:1px #999 solid;'>
                    </div>

                    <div class="col-md-11 col-sm-10 col-xs-10" style="line-height:20px;">
                        <div class="for_dates_1">
                            <p class="pss nofadediv fadediv<?=$id1i.$j;?>" style="font-size:14px; text-align:left; color:#009900; margin:-3px 0 3px 7px !important">
                                <b><a href="javascript:;" style="color:#009900;"><?=$ful_namei;?></a></b>
                                <font style="color:#555; font-size:13px;">@ <?=time_ago($datesi);?></font>
                            </p>
                            
                            <?php if($conid==$txtmemsid){ ?>
                                <p class="menu_icn1" id="menu_icn1" style="margin:0 0 3px 0 !important" ids="<?=$id1i.$j;?>"><img src="<?=base_url()?>images/menu_icon1.png" style="position:relative; top:2px;"></p>
                            <?php }else{ ?>
                                <p class="menu_icn1" style="margin:0 0 3px 0 !important">&nbsp;</p>
                            <?php } ?>

                            <?php if($conid==$txtmemsid){ ?>
                                <div class="edit_div edit_divi" id="edit_div1<?=$id1i.$j;?>">
                                    <span style='border:none; color:red; cursor:pointer' id='delpost2' ids="<?=$id1i.$j;?>"><a href='javascript:;' style='color:red;'>Delete this post &raquo;</a></span>
                                </div>
                            <?php } ?>

                            <div style="clear:both"></div>

                            <div class="img_descr">
                                <?php if($filesi!=""){ ?>
                                    <div class="cmt_img cmt_desc1 col-md-3 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1i.$j;?>">
                                        <span class="open_comment_"><img src='<?=$pic_pathi;?>' alt='image'></span>
                                    </div>

                                    <div class="cmt_desc col-md-9 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1i.$j;?>">
                                        <span><?=makeLinks2(ucfirst($replies));?></span>
                                    </div>
                                <?php }else{ ?>

                                    <div class="cmt_desc col-md-9 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1i.$j;?>">
                                        <span><?=makeLinks2(ucfirst($replies));?></span>
                                    </div>
                                <?php } ?>
                                <label id='copyTarget<?=$id1i.$j;?>' style='display:none'><?=makeLinks2(ucfirst($repliesi));?></label>
                                <div class="cover_contents" id="cover_contents<?=$id1i.$j;?>"></div>
                                <div class="copy_text" ids='<?=$id1i.$j;?>' id="copy_text<?=$id1i.$j;?>"><spans>Copy Text</spans></div>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div style="clear:both"></div>

            <?php
            $j++;
            }
            ?>
        
        <?php
        }else{
            echo "<p style='font-size:16px; text-align:center; color:#333; padding-top:15px'>No reply found on this post.</p>";
        }
    }

    

    function bring_second_activity(){
        $session1 = $this->input->post('session1');
        if($session1!=""){
            $getQuizTitles = $this->sql_models->getQuizTitles($session1);
            if(!empty($getQuizTitles)): foreach($getQuizTitles as $post): 
                $id = $post['id'];
                $titles = $post['titles'];
                $has_done = $post['has_done'];
                $for_days = $post['for_days'];
                if($has_done == 1)
                $expires = " (Has Been Done)";
                else
                $expires = "";
            ?>
                <option value="<?php echo $id; ?>" <?php if($has_done==0) echo "selected"; ?>><?php echo ucwords($titles)."$expires"; ?></option>
            <?php endforeach; endif;
        }else{
            echo "";
        }
    }



    function save_quiz_settings(){
        $this->form_validation->set_rules('txtquiz_time', 'timing', 'required|trim|numeric');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $qid = $this->input->post('qid');
            $gen_num1=time();
            $gen_num1=substr($gen_num1,4);

            if($qid==""){
                $data = array(
                    'sessions1'     => $gen_num1,
                    'activity_id'   => $this->input->post('txtsel_day'),
                    'aprvd'         => 0,
                    'completeds'    => 0,
                    'set_time'      => $this->input->post('txtquiz_time'),
                    'timings'       => 0,
                    'dates'         => date("Y-m-d g:i a", time())
                );
            }else{
                $data = array(
                    'activity_id' => $this->input->post('txtsel_day'),
                    'set_time' => $this->input->post('txtquiz_time')
                );
            }
            $entered1 = $this->sql_models->create_quiz_intro($data, $qid);
            echo $entered1;
        }
    }



    function sent_comments(){
        $this->form_validation->set_rules('tcomment', 'Comment', 'required|trim');
        $this->form_validation->set_rules('tauthor', 'Names', 'required|trim|alpha_space');
        $this->form_validation->set_rules('tcode', 'maths', 'required|trim|matches[txtsum1]');
        $this->form_validation->set_rules('txtsum1', 'sum', '');
        $this->form_validation->set_rules('temail', 'Email', 'required|trim|valid_email');
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{

            $data = array(
                'message' => $this->input->post('tcomment'),
                'names' => $this->input->post('tauthor'),
                'emails' => $this->input->post('temail'),
                'cmt_id' => $this->input->post('txt_id'),
                'date_entered' => date("Y-m-d g:i a", time())
            );
            $data = $this->security->xss_clean($data);

            $entered1 = $this->sql_models->submit_my_comment($data);
            if($entered1){
                echo "<div id='div-comment-1' class='comment-body'>
                <footer class='comment-meta'>
                <div class='comment-author'>
                <img src='".base_url()."images/no_passport.jpg' alt='image' />
                </div>
                </footer>

                <div class='comment-content'>
                <p class='posts_cmts'>".$this->input->post("tcomment")."</p>
                <b class='fn'><span>Posted by</span> <font style='color:#990; cursor:default'>".ucwords($this->input->post("tauthor"))."</font></b>
                <p class='timedate'>".date('Y-m-d g:i a', time())."</p>
                </div>
                </div>";
            }else{
                echo "Error!";
            }
        }
    }



















}






