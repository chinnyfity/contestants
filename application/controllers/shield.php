<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_start();

class shield extends CI_Controller {

        public $xauth;
        public $showname;

        public function __construct(){
            parent::__construct();

            $this->load->helper(array('form', 'url', 'html', 'directory', 'cookie', 'file'));
            $this->load->library(array('form_validation', 'security', 'pagination', 'session'));
            $this->perPage = 25;
            $this->load->model('sql_models');
            @date_default_timezone_set('Africa/Lagos');

            if($this->sql_models->validate_adminx()){
                $this->xauth = 1;
            }else{
                $this->xauth = 0;
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
                return ($days);
            }
            
        }



    public function login(){
        $data['page_name'] = "login";
        $data['page_title'] = "Login";
        $this->load->view("shield/login", $data);
    }


    function logout(){
        $cookie = array(
            'name'   => 'adm_password_celebs',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );

        $cookie1 = array(
            'name'   => 'adm_username_celebs',
            'value'  => '',
            'expire' => '0',
            'secure' => FALSE
        );

        delete_cookie($cookie);
        delete_cookie($cookie1);
        redirect('shield/login');
    }



       // Show view Page
    public function index(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $data['page_name'] = "";
            $data['page_title'] = "Administrator";
            $data['webviews'] = $this->sql_models->totalCounts('visitors');
            $data['totalcontestant'] = $this->sql_models->totalCounts('contestants');
            $data['main_activities'] = $this->sql_models->totalCounts('set_weekly_activity');
            $data['total_voters'] = $this->sql_models->totalCounts('all_votes');
            $data['total_donatns'] = $this->sql_models->totalCounts('donation');
            $data['fetchMembers'] = $this->sql_models->fetchRecords('contestants');
            $data['fetch_main_activities'] = $this->sql_models->fetchRecords('set_weekly_activity');
            $data['url_id'] = "";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }



    function fetch_user(){
        $mid = "";
        $fetch_data = $this->sql_models->make_datatables('membership', '', $mid);
        $data = array();
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $fname = $row->fname;
            $lname = $row->lname;
            $fulls = "$fname $lname";
            $fulls = ucwords($fulls);
            if($row->gender == "m") $gender1 = "Male"; else $gender1 = "Female";
            $sub_array[] = $fulls;
            $sub_array[] = '<a href="tel:'.$row->phone.'" style="color:#069; word-wrap:break-word;">'.$row->phone.'</a>';
            $sub_array[] = $gender1;
            $sub_array[] = $row->statee;
            $sub_array[] = '<a href="mailto:'.$row->emails.'" style="color:#069; word-wrap:break-word;">'.$row->emails.'</a>';
            $sub_array[] = $row->date_reg;
            $sub_array[] = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$row->id.'" for_page="">
            <span class="glyphicon glyphicon-trash"></span></button>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('membership'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('membership', '', $mid, '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }




    public function fetch_contestants(){
        $fetch_data = $this->sql_models->make_datatables('contestants', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id;
            $approved = $row->approved;
            $approvedi = $approved;
            $fname = $row->fname;
            $lname = $row->lname;
            $emails = $row->emails;
            $phones = $row->phones;
            $statee = $row->statee;
            $gender = $row->gender;
            $occupatn = $row->occupatn;
            $hear_about = $row->hear_about;
            $relationshp_status = $row->relationshp_status;
            $hobbies = ucwords($row->hobbies);
            $likes = ucwords($row->likes);
            $dislikes = ucwords($row->dislikes);
            $bios = ucfirst($row->bios);
            $kind_of_partner = ucfirst($row->kind_of_partner);
            $pics = $row->pics;
            $paid = $row->paid;
            $dates = $row->dates;
            $names = ucwords("$fname $lname");
            if($gender=="m") $gender="Male"; else $gender="Female";
            if($relationshp_status=="s") $relationshp_status = "Single";
            else if($relationshp_status=="e") $relationshp_status = "Engaged";
            else if($relationshp_status=="m") $relationshp_status = "Married";
            else if($relationshp_status=="d") $relationshp_status = "Divorced";
            if($hear_about=="") $hear_about = "Not Specified";

            if($approved == 1)
                $approved = "<font caps='Approved' id='approvecontestant' class='approvecontestant$ids' ids='".$ids."' style='color:#093; cursor:pointer'><b>Approved</b></font>";
            else
                $approved = "<font caps='Blocked' id='approvecontestant' class='approvecontestant$ids' ids='".$ids."' style='color:red; cursor:pointer'><b>Pending Approval...</b></font>";

            if($paid == 1)
                $paid = "<font caps='Yes' class='approve_paid$ids' emails='$emails' fname='$fname' style='color:#093; cursor:pointer'><b>Yes</b></font>";
            else
                $paid = "<font caps='Not Paid' id='approve_paid' emails='$emails' fname='$fname' aprvds='$approvedi' class='approve_paid$ids' ids='".$ids."' style='color:red; cursor:pointer'><b>Not Paid</b></font>";

            
            if($pics != ""){
                $path_file1 = base_url()."celebs_uploads/".$pics;
                $logo1 = "<p style='margin-top:5px;'><a href='$path_file1' target='_blank'><img src='$path_file1' class='img_sizes2'></a></p>";
            }else{
                $logo1 = "";
            }

            $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="contestants">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = $approved;
            $sub_array[] = $paid;
            $sub_array[] = "<a style='color:#09C;' href='tel:$phones'>$phones</a>";
            $sub_array[] = "<a style='color:#09C;' href='mailto:$emails'>$emails</a>";
            $sub_array[] = $statee;
            $sub_array[] = $gender;
            $sub_array[] = $occupatn;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;

            $sub_array[] = $logo1;
            $sub_array[] = $relationshp_status;
            $sub_array[] = $hobbies;
            $sub_array[] = $likes;
            $sub_array[] = $dislikes;
            $sub_array[] = $kind_of_partner;
            $sub_array[] = $bios;
            $sub_array[] = $hear_about;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('contestants'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('contestants', '', '', 'all_products', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
        //echo "ssssss";
    }



    public function fetch_scores(){
        $fetch_data = $this->sql_models->make_datatables('pageant_activities', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            //$ids = md5($row->ids);
            $ids = $row->ids;
            $overall_title = $row->overall_title;
            $fname = $row->fname;
            $lname = $row->lname;
            $act_id = $row->act_id;
            $brief_expr = $row->brief_expr;
            $day_instructns = $row->day_instructns;
            $what_day = $row->what_day;
            $scores = $row->scores;
            $scores2 = $row->scores2;
            $scores3 = $row->scores3;
            $gender = $row->gender;
            $file1 = $row->file1;
            $file2 = $row->file2;
            $file3 = $row->file3;
            $title1 = $row->title1;
            $title2 = $row->title2;
            $title3 = $row->title3;
            $descrip1 = $row->descrip1;
            $descrip2 = $row->descrip2;
            $descrip3 = $row->descrip3;
            $names = ucwords("$fname $lname");
            if($gender=="m") $gender1="Male"; else $gender1="Female";
            $what_day=str_replace(array("mon", "tue", "wed", "thu", "fri", "sat", "sun"), array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"), $what_day);
            
            if($file1 != ""){
                $file1 = base_url()."activity_photos/".$file1;
                $file1 = "<div style='margin-top:5px;'><a href='$file1' target='_blank'><img src='$file1' class='img_sizes2'></a><p style='margin-top:10px'><b>Title</b><br>$title1</p><p><b>Description</b><br>$descrip1</p></div>";
            }else{
                $file1 = "";
            }

            if($file2 != ""){
                $file2 = base_url()."activity_photos/".$file2;
                $file2 = "<div style='margin-top:5px;'><a href='$file2' target='_blank'><img src='$file2' class='img_sizes2'></a><p style='margin-top:10px'><b>Title</b><br>$title2</p><p><b>Description</b><br>$descrip2</p></div>";
            }else{
                $file2 = "";
            }

            if($file3 != ""){
                $file3 = base_url()."activity_photos/".$file3;
                $file3 = "<div style='margin-top:5px;'><a href='$file3' target='_blank'><img src='$file3' class='img_sizes2'></a><p style='margin-top:10px'><b>Title</b><br>$title3</p><p><b>Description</b><br>$descrip3</p></div>";
            }else{
                $file3 = "";
            }

            $all_pics = "<div class='all_pcs'>$file1 $file2 $file3</div><div style='clear:both'></div>";

            $btns1 = '
            <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="pageant_activities">
            <span class="fa fa-trash-o"></span></button>';

            
            if($scores<=0)
            $scores1="";
            else
            $scores1=$scores;

            if($scores2<=0)
            $scores12="";
            else
            $scores12=$scores2;

            if($scores3<=0)
            $scores13="";
            else
            $scores13=$scores3;

            $inputbox = "<div class='input_ss'>";
            
            $inputbox .= "<p>Judge 1 (Chinny Anthony)</p>";
            if($scores<=0){
                $inputbox .= "<p class='enterscore scores1' id='scores1$ids$conts' judge='Judge 1' contestant='$names' ids='$ids' conts='$conts'><span>Enter Score</span></p>";
                $inputbox .= "<p class='enterscore scores1$ids$conts' onclick='javascript:alert(\"Error! Cannot be changed.\")' style='opacity:0.6; display:none'><span>Enter Score (<font class='myscore1$ids$conts'></font>%)</span></p>";
            }else{
                $inputbox .= "<p class='enterscore' onclick='javascript:alert(\"Error! Cannot be changed.\")' style='opacity:0.6;'><span>Enter Score ($scores%)</span></p>";
            }

            $inputbox .= "<p>Judge 2 (Chi'D Sunshine)</p>";
            if($scores2<=0){
                $inputbox .= "<p class='enterscore scores2' id='scores2$ids$conts' judge='Judge 2' contestant='$names' ids='$ids' conts='$conts'><span>Enter Score</span></p>";
                $inputbox .= "<p class='enterscore scores2$ids$conts' onclick='javascript:alert(\"Error! Cannot be changed.\")' style='opacity:0.6; display:none'><span>Enter Score (<font class='myscore2$ids$conts'></font>%)</span></p>";
            }else{
                $inputbox .= "<p class='enterscore' onclick='javascript:alert(\"Error! Cannot be changed.\")' style='opacity:0.6;'><span>Enter Score ($scores2%)</span></p>";
            }

            $inputbox .= "<p>Judge 3 (Anonymous)</p>";
            if($scores3<=0){
                $inputbox .= "<p class='enterscore scores3' id='scores3$ids$conts' judge='Judge 3' contestant='$names' ids='$ids' conts='$conts'><span>Enter Score</span></p>";
                $inputbox .= "<p class='enterscore scores3$ids$conts' onclick='javascript:alert(\"Error! Cannot be changed.\")' style='opacity:0.6; display:none'><span>Enter Score (<font class='myscore3$ids$conts'></font>%)</span></p>";
            }else{
                $inputbox .= "<p class='enterscore' onclick='javascript:alert(\"Error! Cannot be changed.\")' style='opacity:0.6;'><span>Enter Score ($scores3%)</span></p>";
            }
            $inputbox .= "</div>";

            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = $gender1;
            $sub_array[] = ucwords($overall_title);
            $sub_array[] = $what_day;
            $sub_array[] = $day_instructns;
            $sub_array[] = $brief_expr;
            $sub_array[] = $all_pics;
            $sub_array[] = $inputbox;
            //$sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('pageant_activities'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('pageant_activities', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
        //echo "ssssss";
    }


    public function fetch_computatn(){
        $winr = $this->uri->segment(3);
        $fetch_data = $this->sql_models->make_datatables('winneris', $winr, '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->ids;
            $overall_title = $row->overall_title;
            $fname = $row->fname;
            $lname = $row->lname;
            $approved = $row->approved;
            $votes = $row->votes;
            $likes = $row->likes;
            $g_score = $row->g_score;
            $j_score = $row->j_score;
            $over_all = $row->over_all;
            $positns = $row->positns;
            $dates = $row->dates;
            $names = ucwords("$fname $lname");

            $positns1 = substr($positns,-1);
            if($positns1==1) $positns1=$positns."st";
            else if($positns1==2) $positns1=$positns."nd";
            else if($positns1==3) $positns1=$positns."rd";
            else $positns1=$positns."th";

            if($approved == 1)
                $approved = "<font style='color:#093;'><b>Approved</b></font>";
            else
                $approved = "<font style='color:red;'><b>Not Approved</b></font>";

            if($likes < 50)
            $likes = "$likes <p style='font-size:12px; line-height:16px !important;'>(Not up to 50 likes. 50 Likes make 1 vote)</p>";

            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = $approved;
            $sub_array[] = ucwords($overall_title);
            $sub_array[] = $votes;
            $sub_array[] = $likes;
            $sub_array[] = $g_score;
            $sub_array[] = $j_score;
            $sub_array[] = "<b style='font-size:16px;'>$over_all</b>";
            $sub_array[] = $positns1;
            $sub_array[] = $dates;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('winneris'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('winneris', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
        //echo "ssssss";
    }



    public function fetch_wallets(){
        $fetch_data = $this->sql_models->make_datatables('fund_wallet_logs', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->id;
            $names = ucwords($row->names);
            $phone = $row->phone;
            $amts = $row->amts;
            $paid = $row->paid;
            $date_created = $row->date_created;

            $phone1 = "<a style='color:#06F' href='tel:$phone'>$phone</a>";
            
            if($paid == 1)
                $paid = "<font caps='Approved' style='color:#093;'><b>Paid</b></font>";
            else{
                $paid = "<font caps='Blocked' id='approve_paid_fund' class='approve_paid_fund$ids' fname='$names' amts='$amts' phone='".$phone."' ids='".$ids."' style='color:red; cursor:pointer'><b>Pending...</b></font>";
            }
            
            $sub_array[] = $conts;
            $sub_array[] = $names;
            $sub_array[] = $paid;
            $sub_array[] = $phone1;
            $sub_array[] =  "<b>&#8358;".number_format($amts)."</b>";
            $sub_array[] = $date_created;
            //$sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('fund_wallet_logs'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('fund_wallet_logs', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_campaigns(){
        $fetch_data = $this->sql_models->make_datatables('all_votes1', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $ids = $row->ids;
            $sw_id = $row->stid;
            $cont_id = $row->contestant_id;
            $fname = $row->fname;
            $lname = $row->lname;
            $overall_title = ucwords($row->overall_title);
            $names = ucwords("$fname $lname");

            $myvotes = $this->sql_models->countVotes($cont_id, $sw_id, '');
            $myvotes = @number_format($myvotes);

            $myvoters = $this->sql_models->countVoters($cont_id, $sw_id);
            $myvoters = @number_format($myvoters);
            
            $game_ids = $this->sql_models->current_main_game_id();
            if($game_ids==$sw_id) $curs = " <font style='color:#009F28; font-size:13px;'><b>(Current)</b></font>"; else $curs = " <font style='color:#888; font-size:13px;'>(Past)</font>";
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_ads_ edit_products_adm" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.sha1($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;

            <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="voters">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $names.$curs;
            $sub_array[] = $myvotes;
            $sub_array[] = $myvoters;
            $sub_array[] = $overall_title.$curs;
            //$sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('all_votes'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('all_votes', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    public function fetch_games(){
        $fetch_data = $this->sql_models->make_datatables('quizes_intro', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $approved = $row->aprvd;
            $titles = ucwords($row->titles);
            $sessions1 = $row->sessions1;
            $completeds = $row->completeds;
            $set_time = $row->set_time;
            $timings = $row->timings;
            $dates = $row->dates;
            
            if($approved == 1)
                $approved = "<font style='color:#093;'><b>Approved</b></font>";
            else
                $approved = "<font style='color:red;'><b>Not Approved</b></font>";

            if($timings>0)
                $timings = date("Y-m-d g:i a", $timings);
            else{
                if($completeds == 1)
                $timings = "<label style='color:red'>Expired</label>";
                else
                $timings = "<b>.....</b>";
            }

            if($completeds == 1)
                $completeds = "<font style='color:#093;'><b>Yes</b></font>";
            else
                $completeds = "<font style='color:red;'><b>Not Completed</b></font>";
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_games edit_products_adm_" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;
            

            <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="quizes_intro">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = "$titles <br><a href='".base_url()."shield/viewtrivia/$sessions1/' style='color:#09C'>(View this)</a>";
            $sub_array[] = $timings;
            $sub_array[] = $approved;
            $sub_array[] = $completeds;
            $sub_array[] = $set_time;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('quizes_intro'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('quizes_intro', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    public function fetch_all_media(){
        $fetch_data = $this->sql_models->make_datatables('gallery_vid', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->id;
            $titles = ucwords($row->titles);
            $views = $row->views;
            $files = $row->files;
            $media_type = $row->media_type;
            $dates = $row->dates;
            
            if($files!=""){
                if($media_type=="pic")
                $files1 = "<img src='".base_url()."gallery/$files' id='im10'>";
                else
                $files1 = $files;
            }else{
                $files1 = "";
            }

            if($media_type=="pic") $media_type="Photo"; else $media_type="Video";
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_media1" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;

            <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="gallery_vid">
            <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = $titles;
            $sub_array[] = $media_type;
            $sub_array[] = $views;
            $sub_array[] = $dates;
            $sub_array[] = $files1;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('gallery_vid'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('gallery_vid', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    public function fetch_all_events(){
        $fetch_data = $this->sql_models->make_datatables('events', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->id;
            $titles = ucwords($row->titles);
            $descrip = $row->descrip;
            $views = $row->views;
            $dates = $row->dates;
            $files = $this->sql_models->getEventPics('events_media', $ids);

            $myphotos="<div class='evnt_pics'>";
            foreach($files as $rws)
            {
                $files1 = $rws['files'];
                $exts = pathinfo($files1, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');
                if(in_array($exts,$img_ext_chk1)){
                    $myphotos .= "<img src='".base_url()."events_fols/$files1' id='im10'>";
                }else{
                    $myphotos .= "
                    <video style='cursor: pointer; opacity:1 !important' class='video-js vjs-default-skin' controls controlsList='nodownload' preload='auto' data-setup='{ 'asdf': true }' oncontextmenu='return false;'>
                        <source src='".base_url()."events_fols/$files1' type='video/mp4'>
                        <source src='".base_url()."events_fols/$files1' type='video/webm'>
                    </video>
                    ";
                }
            }
            $myphotos .= "</div>";
            
            $btns1 = '<button class="btn btn-primary btn-xs edit_events" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;

            <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="events">
            <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = $titles;
            $sub_array[] = $views;
            $sub_array[] = $dates;
            $sub_array[] = $descrip;
            $sub_array[] = $myphotos;
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('events'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('events', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_all_forum(){
        $fetch_data = $this->sql_models->make_datatables('forums', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $fname = $row->fname;
            $lname = $row->lname;
            $fulls = ucwords("$fname $lname");
            $topics = $row->topics;
            $messages = nl2br($row->messages);
            $views = $row->views;
            $files = $row->files;
            $dates = $row->dates;
            $repliesCount = $this->sql_models->getrepliesCount($ids);

            if($topics==1) $ttls = "General Discussion";
            else if($topics==2) $ttls = "Job Posting";
            else if($topics==3) $ttls = "Entertainments";
            else if($topics==4) $ttls = "Talents";
            else if($topics==5) $ttls = "Sex & Relationships";
            else if($topics==6) $ttls = "Kitchen";
            else if($topics==7) $ttls = "Games";
            else $ttls = "All Threads";
            
            if($files!=""){
                $files1 = "<img src='".base_url()."forum_files/$files' id='im10'>";
            }else{
                $files1 = "";
            }

            $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="forums">
            <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = $fulls;
            $sub_array[] = $ttls;
            $sub_array[] = $repliesCount;
            $sub_array[] = $views;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $sub_array[] = $messages;
            $sub_array[] = $files1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('forums'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('forums', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    public function fetch_all_forum_rep(){
        $fetch_data = $this->sql_models->make_datatables('forum_reply', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $fname = $row->fname;
            $lname = $row->lname;
            $fulls = ucwords("$fname $lname");
            $messages = nl2br($row->messages);
            $replies = $row->replies;
            $replies1 = $replies;
            $files = $row->files;
            $dates = $row->dates;
            $memid1 = $row->memid1;
            if(strlen($replies) > 120){
                $replies=substr($replies,0,120);
                $replies=$replies.'..';
            }
            $replies = nl2br($replies);
            $repliedto = $this->sql_models->getMemberID($memid1);
            
            if($files!=""){
                $files1 = "<img src='".base_url()."forum_files/$files' id='im10'>";
            }else{
                $files1 = "";
            }

            $btns1 = '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$ids.'" for_page="forum_reply">
            <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = ucfirst($replies);
            $sub_array[] = $fulls;
            $sub_array[] = $repliedto;
            $sub_array[] = $dates;
            $sub_array[] = $btns1;
            $sub_array[] = ucfirst($messages);
            $sub_array[] = ucfirst($replies1);
            $sub_array[] = $files1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('forums'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('forums', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    public function fetch_all_paids(){
        $fetch_data = $this->sql_models->make_datatables('paid_users', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {   
            $sub_array = array();
            $ids = $row->ids;
            $titles = ucwords($row->overall_title);
            $fname = $row->fname;
            $lname = $row->lname;
            $fulls = ucwords("$fname $lname");
            $dates = $row->dates;
            
            // $btns1 = '<button class="btn btn-primary btn-xs edit_media1" captn="0" data-title="Edit" data-toggle="modal" 
            // data-target="#myPopup_" id="'.md5($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;

            // <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            // data-target="#delete_dv" for_id="'.$ids.'" for_page="gallery_vid">
            // <span class="fa fa-trash-o"></span></button>';
            
            $sub_array[] = $conts;
            $sub_array[] = $fulls;
            $sub_array[] = $titles;
            $sub_array[] = "NGN1,000";
            $sub_array[] = $dates;
            //$sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('paid_users'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('paid_users', '', '', '', '', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }



    public function fetch_trivia(){
        $url_task = $this->uri->segment(3);
        $usequiz = $this->sql_models->isUseQuests('quizes_intro', $url_task);
        $fetch_data = $this->sql_models->make_datatables('quizes', $url_task, $usequiz);
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id4 = $row->id;
            $questions = ucfirst($row->questions);
            $files = $row->files;
            $op1 = ucwords($row->op1);
            $op2 = ucwords($row->op2);
            $op3 = ucwords($row->op3);
            $op4 = ucwords($row->op4);
            $op5 = ucwords($row->op5);
            $ans1 = ucwords($row->ans1);

            if($files!="")
            $files1 = "<img src='".base_url()."quizes/$files' id='im10'>";
            else
            $files1 = "";

            $btns1 = '<button class="btn btn-primary btn-xs edit_quiz" captn="0" data-title="Edit" data-toggle="modal" 
            data-target="#myPopup_" id="'.md5($id4).'"><span class="fa fa-pencil"></span> </button> &nbsp;

            <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$id4.'" for_page="trivia">
            <span class="fa fa-trash-o"></span></button>';

            $sub_array[] = $conts;
            $sub_array[] = $btns1;
            $sub_array[] = $questions;
            $sub_array[] = $files1;
            $sub_array[] = $op1;
            $sub_array[] = $op2;
            $sub_array[] = $op3;
            $sub_array[] = $op4;
            $sub_array[] = $op5;
            $sub_array[] = $ans1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('quizes'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('quizes', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }


    
    public function settings(){
        $user_types = $this->input->cookie('user_types', TRUE);
        $data['user_types'] = $this->input->cookie('user_types', TRUE);
        if($this->sql_models->validate_adminx()){
            //if($user_types == "for_merchant"){
                $data['show_name'] = "Admin";
                //$data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types, '');
                //$data['profile_details'] = $this->sql_models->fetchProfile(sha1($this->IDs), $user_types);
                $data['page_name'] = "settings";
                $data['page_title'] = "Admin Settings";
                $data['easer_type'] = "";
                $this->load->view("shield/header", $data);
                $this->load->view("shield/index", $data);
            // }else{
            //     redirect('');
            // }
        }else{
            redirect('shield/login');
        }
    }


    public function view_activities(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $data['show_name'] = "Admin";
            $data['page_name'] = "view_activities";
            $data['page_title'] = "View Activities";
            $data['easer_type'] = "";
            $data['url_id'] = "";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function enter_activity(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "enter_activity";
            $data['page_title'] = "Enter Activities";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function uploadmedia(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "uploadmedia";
            $data['page_title'] = "Upload Media";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function uploadevents(){
        //$url_id = $this->uri->segment(3);
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            //$data['getId'] = $this->sql_models->get_Events($url_id);
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "uploadevents";
            $data['page_title'] = "Upload Events";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function edit_events(){
        $url_id = $this->uri->segment(3);
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            if($this->sql_models->get_An_Events($url_id)){
                $data['getId'] = $this->sql_models->get_An_Events($url_id);
                $data['url_id'] = $url_id;
                $data['url_id1'] = "";
                $data['show_name'] = "Admin";
                $data['page_name'] = "edit_events";
                $data['page_title'] = "Edit Events";
                $this->load->view("shield/header", $data);
                $this->load->view("shield/index", $data);
            }else{
                redirect('shield/viewevents/');
            }
        }else{
            redirect('shield/login');
        }
    }


    public function enter_score(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "enter_score";
            $data['page_title'] = "Enter Score";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function compute_winner(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "compute_winner";
            $data['page_title'] = "Compute Winners";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function view_winner(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $data['url_id'] = "";
            $data['url_id1'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "view_winner";
            $data['page_title'] = "View Winners";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function contestants(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "contestants";
            $data['page_title'] = "Contestants";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function voters(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "voters";
            $data['page_title'] = "Voters";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }

    
    public function wallets(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "wallets";
            $data['page_title'] = "Wallet";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function campaigns(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "campaigns";
            $data['page_title'] = "Campaigns";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function viewgames(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewgames";
            $data['page_title'] = "View Games";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function viewmedia(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewmedia";
            $data['page_title'] = "View Media";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function viewevents(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewevents";
            $data['page_title'] = "View Events";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function paidusers(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "paidusers";
            $data['page_title'] = "View Paid Users";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function forum(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "forum";
            $data['page_title'] = "View Forum";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function forumreply(){
        if($this->sql_models->validate_adminx()){
            $data['url_id'] = "";
            $data['show_name'] = "Admin";
            $data['page_name'] = "forumreply";
            $data['page_title'] = "View Forum Reply";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function viewtrivia(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $data['url_id'] = $url_id;
            $data['show_name'] = "Admin";
            $data['page_name'] = "viewtrivia";
            $data['page_title'] = "View Trivia";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }


    public function creategames(){
        if($this->sql_models->validate_adminx()){
            $data['getId'] = $this->sql_models->get_QuizID();
            $url_id = $this->uri->segment(3);
            $url_id1 = $this->uri->segment(4);
            //$act_sess = $this->sql_models->get_activityIDSess('quizes_intro', $url_id);

            //$data['url_id'] = $url_id;
            $data['getMainSess'] = "";
            $data['fetchQuests'] = "";
            $data['url_id'] = "";
            $data['url_idx'] = $url_id;
            //$data['act_sess'] = $act_sess;
            $data['url_id1'] = $url_id1;
            $data['show_name'] = "Admin";
            $data['page_name'] = "creategames";
            $data['page_title'] = "Create Games";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }

    

    public function editgames(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $url_id1 = $this->uri->segment(4);
            $data['getMainSess'] = $this->sql_models->getMainSess($url_id);
            $data['getQuizes'] = $this->sql_models->getQuizes($url_id);
            $data['getQuizesID'] = $this->sql_models->getQuizesID($url_id);
            //print_r($data); exit;
            $data['url_id'] = $url_id;
            $data['url_id1'] = $url_id1;
            $data['show_name'] = "Admin";
            $data['page_name'] = "editgames";
            $data['page_title'] = "Edit Games";
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }

    
    public function edit_activity(){
        if($this->sql_models->validate_adminx()){
            $this->sql_models->check_daily_expired_game();
            $url_id = $this->uri->segment(3);
            if($this->sql_models->check_link_id1($url_id)){
                $url_id1 = $this->uri->segment(4);
                if($url_id1!= "" && $url_id1!= "new"){ // if its not empty and not new, means edit
                    if($this->sql_models->check_link_id($url_id1)){
                        $data['show_name'] = "Admin";
                        $data['page_name'] = "edit_activity";
                        $data['page_title'] = "Edit Activities";
                        $data['url_id'] = $url_id;
                        $data['url_id1'] = $url_id1;
                        $data['getId'] = $this->sql_models->get_activityID($url_id, $url_id1, 'rows');
                        //print_r($data); exit;
                        $this->load->view("shield/header", $data);
                        $this->load->view("shield/index", $data);
                    }else{
                        redirect('shield/view_activities');    
                    }
                }else{ // if its empty and new, means new game activity
                    $data['show_name'] = "Admin";
                    $data['page_name'] = "edit_activity";
                    $data['page_title'] = "Edit Activities";
                    $data['url_id'] = $url_id;
                    $data['url_id1'] = $url_id1;
                    $data['getId'] = $this->sql_models->get_activityID($url_id, '', 'rows');
                    $this->load->view("shield/header", $data);
                    $this->load->view("shield/index", $data);
                }
            }else{
                redirect('shield/view_activities');    
            }
        }else{
            redirect('shield/login');
        }
    }


    public function editmedia(){
        if($this->sql_models->validate_adminx()){
            $url_id = $this->uri->segment(3);
            $data['show_name'] = "Admin";
            $data['page_name'] = "editmedia";
            $data['page_title'] = "Edit Media";
            $data['url_id'] = $url_id;
            $data['getId'] = $this->sql_models->get_mediaID($url_id);
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
        }else{
            redirect('shield/login');
        }
    }



    public function update_password(){
        if($this->sql_models->validate_adminx()){
            $data['page_name'] = "changepasswords";
            $data['page_title'] = "Change Password";
            //$data['myusers'] = $this->sql_models->fetchComments_admin();
            $this->load->view("shield/header", $data);
            $this->load->view("shield/index", $data);
            //$this->load->view("shield/footer");
        }else{
            redirect('shield/login');
        }
    }


    function update_my_pass(){
        $this->form_validation->set_rules('txtpass1', 'old password', 'required|trim|sha1');
        $this->form_validation->set_rules('txtpass2', 'new password', 'required|trim');
        $this->form_validation->set_rules('txtpass3', 'confirm password', 'required|trim|matches[txtpass2]');
        $oldpass = $this->input->post('txtpass1');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        }else{
            $new_pass = sha1($this->input->post('txtpass3'));
            $updated = $this->sql_models->update_adm_password($new_pass, $oldpass);
            if($updated){
                $now = 865000;
                $cookie = array(
                    'name'              => 'adm_password_celebs',
                    'value'             => sha1($this->input->post('txtpass3')),
                    'expire'            => $now,
                    'secure'            => FALSE,
                    'logged_in_ider'    => TRUE
                );
                set_cookie($cookie);
                echo "pass1_updated";
            }else{
                echo "Invalid old password!";
            }
        }
    }





    function fetch_activities(){
        $mid = "";
        $fetch_data = $this->sql_models->make_datatables('set_weekly_activity', '', '');
        $data = array();
        $conts = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $id4 = $row->id;
            $session1 = $row->session1;
            $in_set_act2 = $this->sql_models->inSetAct2($session1);
            $approved = $row->approved;
            $overall_title = ucwords($row->overall_title)."<p style='font-size:14px;'><span style='color:#09C; cursor:pointer;' class='view_more_tbl' sessions='$session1'>View More</p>";
            $close_cons = $row->close_prev_contestant;
            $one_week_timings = $row->one_week_timings;
            $has_done = $row->has_done;
            $instructn = $row->instructn;
            $disqualificatn = $row->disqualificatn;
            $prize1 = @number_format($row->prize1);
            $prize2 = @number_format($row->prize2);
            $prize3 = @number_format($row->prize3);
            $gift1 = $row->gift1;
            $gift2 = $row->gift2;
            $gift3 = $row->gift3;
            $dates = $row->dates;
            $enable_reg = $row->enable_reg;
            $disable_reg = $row->disable_reg;
            if($enable_reg!="") $enable_reg = date("D jS M, Y h:ia", $enable_reg);
            if($disable_reg!="") $disable_reg = date("D jS M, Y h:ia", $disable_reg);

            $gift1 = base_url()."gifts/".$gift1;
            $gift2 = base_url()."gifts/".$gift2;
            $gift3 = base_url()."gifts/".$gift3;

            $all_prizes = "<div class='img_prizes'>
            <p><b>First Prize: &#8358;$prize1</b><br><img src='$gift1'></p>
            <p><b>Second Prize: &#8358;$prize2</b><br><img src='$gift2'></p>
            <p><b>Third Prize: &#8358;$prize3</b><br><img src='$gift3'></p>
            </div>";
            
            if($dates=="") $dates="Not specified";

            if($has_done==0) 
                $has_done1 = "<font style='color:red; font-weight:bold;'>Not Done</font>";
            else
                $has_done1 = "<font style='color:#093; font-weight:bold;'>Game Done</font>";
            
            $mydates="Not specified";
            $seven_weeks1="Expired";
            $hours_set1=0;

            if($one_week_timings>0){
                $mydates = date("Y-m-d g:i a", time());
                $seven_weeks1 = date("jS F, Y h:ia", $one_week_timings);
            }
            $dates = date("D jS M Y h:ia", $dates);

            if($approved == 1){
                $approved_1 = "<font id='approve_acti' caps='Approved' timings='0' dates='' class='approve_acti$session1' session1='".$session1."' style='color:#090; font-size:15px; cursor:pointer'><b>Approved</b></font>";
            }else{
                if($in_set_act2)
                    $approved_1 = "<font id='approve_acti' caps='Not Approved' timings='$seven_weeks1' dates='$mydates' class='approve_acti$session1' session1='".$session1."' style='color:red; font-size:14px; cursor:pointer'><b>Not Approved</b></font>";
                else
                    $approved_1 = "<font style='color:red; font-size:14px; cursor:pointer; opacity:0.5;' onclick='javascript:alert(\"No Activity set here, please delete this!\");'><b>Not Approved</b></font>";
            }

            if($close_cons == 0)
                $close_cons_1 = "<font id='approve_status' caps='Open' class='approve_status$session1' session1='".$session1."' style='color:#063; font-size:15px; cursor:pointer'><b>Open</b></font>";
            else
                $close_cons_1 = "<font id='approve_status' caps='Closed' class='approve_status$session1' session1='".$session1."' style='color:red; font-size:15px; cursor:pointer'><b>Closed</b></font>";


            if($in_set_act2){
                $btns1 = '<button class="btn btn-primary btn-xs edit_actis" captn="0" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.md5($id4).'"><span class="fa fa-pencil"></span> </button> &nbsp;';
            }else{
                $btns1 = '<button class="btn btn-primary btn-xs" style="opacity:0.5;" onclick="javascript:alert(\'No Activity set here, please delete this!\');"><span class="fa fa-pencil"></span> </button> &nbsp;';
            }
            $btns1 .= '<button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
            data-target="#delete_dv" for_id="'.$session1.'" for_page="enter_activity">
            <span class="fa fa-trash-o"></span></button>';
                
            

            $other_info = "";
            $other_info .= "
            <div class='other_infos' id='other_infos$session1' style='display:none;'>
            <table>
            <tr>
                <th>Action</th>
                <th>Game Type</th>
                <th>Approve</th>
                <th>Day</th>
                <th>Instruction</th>
                <th>From</th>
                <th>Duration</th>
                <th>Expire</th>
                <th>Status</th>
            </tr>";

            $fetch_data1 = $this->sql_models->get_activityID(md5($id4), '', '');
            if($fetch_data1){
                foreach($fetch_data1 as $row)
                {
                    $for_days = $row['for_days'];
                    $ids1 = $row['ids'];
                    $day_instructns = $row['day_instructns'];
                    $time_duratns = $row['time_duratn'];
                    $starting_from = $row['starting_from'];
                    $game_type = $row['game_type'];
                    $approved1 = $row['approved1'];
                    $has_done_asa = $row['has_done_asa'];
                    $timings = $row['timings'];

                    $for_days=str_replace(array("mon", "tue", "wed", "thu", "fri", "sat", "sun"), array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"), $for_days);
                    if($game_type=="pic") $game_type1 = "Upload Picture Game"; else $game_type1 = "Trivia Games";

                    if($has_done_asa==0) 
                        $has_done_asa1 = "<font style='color:#FBB; font-size:13px; font-weight:bold;'>Not Done</font>";
                    else
                        $has_done_asa1 = "<font style='color:#0F6; font-size:13px; font-weight:bold;'>Expired</font>";

                    if($approved1 == 1){
                        $approved1_1 = "<font id='approve_acti_inner_1' caps='Approved' first_act='$one_week_timings' mydays='0' class='approve_acti_inner$ids1' ids1='".$ids1."' session1='".$session1."' style='color:#0F6; font-size:14px; cursor:pointer'><b>Approved</b></font>";
                    }else{
                        $approved1_1 = "<font id='approve_acti_inner' game_type='$game_type' caps='Not Approved' first_act='$one_week_timings' mydays='$hours_set1' class='approve_acti_inner$ids1' ids1='".$ids1."' session1='".$session1."' style='color:#FFA8A8; font-size:13px; cursor:pointer'><b>Not Approved</b></font>";
                    }

                    if($timings){
                        $timestamp = strtotime($starting_from.':00:00 pm');
                        $hours_set1 = strtotime("+$time_duratns hour", $timestamp);
                        $hours_set1 = date("h:i a", $hours_set1);
                    }

                    $btns2 = '<button class="btn btn-primary btn-xs edit_actis1" captn="0" data-title="Edit" data-toggle="modal" 
                    data-target="#myPopup_" id="'.md5($id4).'" id2="'.md5($ids1).'"><span class="fa fa-pencil"></span> </button>';

                    $other_info .= "<tr>
                        <td>$btns2</td>
                        <td>$game_type1</td>
                        <td>$approved1_1</td>
                        <td>$for_days</td>
                        <td style='font-size:13px;'>$day_instructns</td>
                        <td>$starting_from PM</td>
                        <td>$time_duratns hrs</td>
                        <td class='expirs'>$hours_set1</td>
                        <td class='dones'>$has_done_asa1</td>
                    </tr>";
                }
            }

            $other_info .= "<tr><td colspan='9'><input type='button' value='New +' id='cmd_new' id1='".md5($id4)."' class='btn btn-lg btn-info btn-block inlines'></td></tr>
            </table>
            </div>";
            
            $sub_array[] = $conts;
            $sub_array[] = $overall_title.$other_info;
            $sub_array[] = $approved_1;
            $sub_array[] = $close_cons_1;
            $sub_array[] = "<font class='java7days'>Will Expire on <br><b>$seven_weeks1</b></font>";
            $sub_array[] = $has_done1;
            $sub_array[] = $instructn;
            $sub_array[] = $disqualificatn;
            $sub_array[] = $enable_reg;
            $sub_array[] = $disable_reg;
            $sub_array[] = $all_prizes;
            $sub_array[] = "<font class='javadates'>$dates</font>";
            $sub_array[] = $btns1;
            $data[] = $sub_array;
            $conts++;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $this->sql_models->get_all_data('set_weekly_activity'),
            "recordsFiltered"   =>  $this->sql_models->get_filtered_data('set_weekly_activity', ''),
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    



    function upload_cats(){
        $this->form_validation->set_rules('txt_cats', 'image title', 'required|trim');        
        $txtid = $this->input->post('txtedit_cat_id1');
        $txt_cats = $this->input->post('txt_cats');

        if($this->form_validation->run() == FALSE){
            echo validation_errors();
            
        }else{
            $data = array('cats' => $txt_cats);
            $data = $this->security->xss_clean($data);
            $uploads1 = $this->sql_models->upload_cats1($data, $txtid);

            if($uploads1){
            echo "catdone2";
            }else{
            echo "Failed to save!";
            }
        }
    }



    

    public function delete_rows(){
        $txtall_id = $this->input->post('txtall_id');
        $txt_dbase_table = $this->input->post('txt_dbase_table');
        $is_deleted = $this->sql_models->do_delete($txtall_id, $txt_dbase_table);

        if($is_deleted){
            echo "deleted";
        }else{
            echo "Failed! Network connection error!";
        }
    }




    public function delete_records(){
        $txtall_id = $this->input->post('txtall_id');
        $txt_dbase_table = $this->input->post('txt_dbase_table');
        $is_deleted = $this->sql_models->do_delete($txtall_id, $txt_dbase_table);
         if($is_deleted)
            echo 1;
         else
            echo 0;
    }
    





}
