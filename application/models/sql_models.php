<?php

class Sql_models extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }



    function fetchStates(){
        $this->db->select('names');
        $this->db->from('statess');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchUSSDs(){
        $this->db->select('banks, ussd2ussd, ussd2other');
        $this->db->from('bank_ussd');
        $this->db->order_by('banks', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    


    function deleteFile($get_id, $rand_nos, $tbl, $rows){    
        $query = $this->db->get_where($tbl, array('rands' => $rand_nos, 'memid' => $get_id));
        $file1 = $query->row($rows);
        $file1 = str_replace(" ", "_", $file1);
        $file1 = str_replace("__", "_", $file1);
        $in_folder1="upload_files/".$file1;
        if(is_readable($in_folder1)) @unlink($in_folder1);
    }
    

    function deleteEachFile($id){
        $this->db->select('files')->from('events_media')->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $files = $query->row('files');
        $files = str_replace(" ", "_", $files);

        $in_folder1="events_fols/$files";
        if(is_readable($in_folder1)) @unlink($in_folder1);

        $this->db->where('id', $id);
        $query = $this->db->delete('events_media');
    }


    function deleteFrmPost($id, $type1){
        $this->db->select('files')->from($type1)->where('id', $id);
        $query = $this->db->get();
        $files = $query->row('files');
        $in_folder1="forum_files/$files";
        if(is_readable($in_folder1)) @unlink($in_folder1);

        $this->db->select('files')->from('forum_reply')->where('forum_id', $id);
        $query = $this->db->get();
        $files = $query->row('files');
        $in_folder1="forum_files/$files";
        if(is_readable($in_folder1)) @unlink($in_folder1);

        $this->db->where('forum_id', $id);
        $query = $this->db->delete('forum_reply');

        $this->db->where('id', $id);
        $query = $this->db->delete($type1);
    }


    function fetchLikes($file, $ips){
        $this->db->select('likes')->from('picture_likes')->where('pics', $file)->where('ip_addrs', $ips);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('likes');
        else
            return 0;
    }


    function fetchActTitles(){
        $this->db->select('session1, overall_title, dates')->from('set_weekly_activity');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }


    function fetchEventsTitles($years){
        $this->db->select('id, titles')->from('events');
        $this->db->where('year', $years);
        $this->db->order_by('id', 'desc');
        $this->db->limit(30);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    function get_Events($id){
        $this->db->select('id, titles, descrip')->from('events');
        $this->db->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    function get_An_Events($id){
        $this->db->select('id, titles, descrip')->from('events');
        $this->db->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }


    function fetchEventsByYear(){
        $this->db->select('year')->from('events');
        $this->db->order_by('id', 'desc');
        $this->db->group_by('year');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    
    function getPics($id){
        $this->db->select('files')->from('events_media');
        $this->db->where('event_id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row("files");
        else
            return false;
    }


    function getMorePics($id, $files){
        $this->db->select('files')->from('events_media');
        $this->db->where('event_id', $id)->where('files !=', $files);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    public function fetchEvents($sessions, $txt_srch, $rowno, $rowperpage) {
        if($sessions!=""){
            $this->db->select('*')->from('events');
            $this->db->where('year', $sessions);
            if($txt_srch!=""){
                $srchs = "(titles like '%$txt_srch%' OR year like '%$txt_srch%')";
                $this->db->where("$srchs");
            }
        }else{
            $this->db->select('*');
            $this->db->from('events');
            if($txt_srch!=""){
                $srchs = "(titles like '%$txt_srch%' OR year like '%$txt_srch%')";
                $this->db->where("$srchs");
            }
        }
        if($rowperpage!="" || $rowno!="")
            $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }
    
	public function fetchEventsCount() {
    	$this->db->select('count(*) as allcount');
      	$this->db->from('events');
      	$query = $this->db->get();
      	$result = $query->result_array();      
      	return $result[0]['allcount'];
    }


    public function getrepliesCount($id) {
    	$this->db->select('count(*) as allcount');
        $this->db->from('forum_reply');
        $this->db->where('forum_id', $id);
      	$query = $this->db->get();
      	$result = $query->result_array();      
      	return $result[0]['allcount'];
    }

    
    function fetchMedias($types, $rowno, $rowperpage, $txt_srch){
        $this->db->select('id, titles, views, files, media_type, dates')->from('gallery_vid');
        $this->db->where('media_type', $types);
        if($txt_srch!=""){
            $srchs = "(titles like '%$txt_srch%')";
            $this->db->where("$srchs");
        }
        $this->db->order_by('id', 'desc');
        if($rowperpage!="" || $rowno!="")
            $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    function fetchForum($page, $txt_srch, $txtcats1){
        $offset = 30*$page;
        $limit = 30;
        $this->db->select('frm.id AS idf, cons.id AS conid, cons.fname, cons.lname, cons.pics, frm.topics, frm.messages, frm.files, frm.views, frm.dates')->from('forums frm');
        $this->db->join('contestants cons', 'cons.id = frm.memid');
        if($txt_srch!=""){
            $srchs = "(cons.fname like '%$txt_srch%' OR cons.lname like '%$txt_srch%' OR frm.messages like '%$txt_srch%')";
            $this->db->where("$srchs");
        }
        if($txtcats1 > 0){
            $this->db->where('topics', $txtcats1);
        }
        $this->db->order_by('frm.id', 'desc');
        if($page!="")
            $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }



    function fetchForumRep($page, $fr_ids){
        $offset = 30*$page;
        $limit = 30;
        $this->db->select('reps.id, cons.id AS conid, cons.fname, cons.lname, cons.pics, reps.replies, reps.files, reps.dates')->from('forum_reply reps');
        $this->db->join('contestants cons', 'cons.id = reps.memid');
        $this->db->join('forums frm', 'frm.id = reps.forum_id');
        $this->db->where('reps.forum_id', $fr_ids);
        $this->db->order_by('reps.id', 'desc');
        if($page!="")
            $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    function fetchForumRep1($fr_ids){
        $this->db->select('reps.id, cons.id AS conid, cons.fname, cons.lname, cons.pics, reps.replies, reps.files, reps.dates')->from('forum_reply reps');
        $this->db->join('contestants cons', 'cons.id = reps.memid');
        $this->db->join('forums frm', 'frm.id = reps.forum_id');
        $this->db->where('reps.forum_id', $fr_ids);
        $this->db->order_by('reps.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }


    function reminderViaEmailAdmin(){
        $nows = time();
        $this->db->select('overall_title')->from('set_weekly_activity');
        $this->db->where('dates <=', $nows);
        $this->db->where('email_reminder', 0);
        $this->db->where('has_done', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $overall_title1 = ucwords($query->row('overall_title'));
            
            //// send emails to admins /////
                $emails = "donchibobo@gmail.com, info@ourfavcelebs.com";
                $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Admins,</b></p>";
                $message_contents .= "<p style='font-size:14px; margin-top:10px'>Reminder of the activity you set at \"$overall_title1\"
                please go now and approve the activity for contestants to start participating.</p>";

                $message_contents .= "<p style='font-weight:normal;'><a href='http://www.ourfavcelebs.com/shield/view_activities/' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com/shield/view_activities/</a></p>";
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
                    'from' => "Activity Reminder <info@ourfavcelebs.com>",
                    'to' => $emails,
                    'subject' => "Activity Reminder Approval Pending",
                    'html' => $message_contents
                ));
                $result = curl_exec($ch);
                curl_close($ch);
            //// send emails to admins /////

            $this->db->where('dates <=', $nows)->where('email_reminder', 0)->where('has_done', 0);
            $this->db->set('email_reminder', 1);
            $this->db->update('set_weekly_activity');
        }
    }


    function reminderViaEmailMembers(){
        $nows = time();
        $one_hr_diff = $nows - 3600; // in 1 hrs time
        $this->db->select('asa2.id')->from('admin_set_activity2 asa2');
        $this->db->where('asa2.starting_from1 >', 0)->where('asa2.starting_from1 <=', $one_hr_diff);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $mem_emails = $this->getMembersEmails();

            $this->db->select('sw.id, asa2.id AS id1')->from('set_weekly_activity sw')->where('sw.has_done', 0);
            $this->db->where('asa2.starting_from1 <=', $one_hr_diff)->where('rems.sent_mail', 0);
            $this->db->join('admin_set_activity2 asa2', 'asa2.session1 = sw.session1');
            $this->db->join('email_reminder_member rems', 'rems.main_act_id = sw.id');
            $query1 = $this->db->get();
            if($query1->num_rows() > 0){
                $id = $query1->row('id');
                $id1 = $query1->row('id1');

                //// send emails to members /////
                    $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                    $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Contestant,</b></p>";
                    $message_contents .= "<p style='font-size:14px; margin-top:10px'>Your OurFavCelebs activity will start in one hour's time,
                    please click on the link below to go to the platform and be ready for it.<br>When it's time, you are advised to refresh the page
                    on the website and start, thank you!</p>";

                    $message_contents .= "<p style='font-weight:normal;'><a href='http://www.ourfavcelebs.com/pages/#participants' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com/pages/#participants</a></p>";
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
                        'from' => "OurFavCelebs Activities <info@ourfavcelebs.com>",
                        'to' => 'Undisclosed Recipient <info@ourfavcelebs.com>',
                        'bcc' => $mem_emails,
                        'subject' => "It's About Time For The Competition.",
                        'html' => $message_contents
                    ));
                    $result = curl_exec($ch);
                    curl_close($ch);
                //// send emails to members /////
                
                $entries = [];
                $get_mem_id = $this->getMembersIDs();
                if($get_mem_id){
                    foreach($get_mem_id as $mem_ids){
                        $entries[] = array(
                            'memid'         => $mem_ids['id'],
                            'main_act_id'   => $id,
                            'daily_act_id'  => $id1,
                            'sent_mail'     => 1
                        );
                    }
                    $this->db->insert_batch('email_reminder_member', $entries); 
                    if($this->db->affected_rows() > 0){
                        return true;
                        //return 4;
                    }else{
                        return false;
                        //return 5;
                    }
                }
                //return 6;
            }else{
                //return 3;
                return false;
            }
        }
    }


    function fetchARecord($id, $nodes1, $phps){
        if($phps=="phps")
            $id = substr($id, 0, -4);
        if($nodes1=="events"){
            $this->db->select('*')->from($nodes1);
            $this->db->where('id', $id);
        }else{
            $this->db->select('frm.id, cons.fname, cons.lname, cons.pics, frm.topics, frm.messages, frm.files, frm.views, frm.dates')->from('forums frm');
            $this->db->join('contestants cons', 'cons.id = frm.memid');
            $this->db->where('frm.id', $id);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }



    function fetchAnEvent1($id){
        $id = substr($id, 0, -4);
        $this->db->select('*')->from('events');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }


    function fetchMemLikes($memid){
        $this->db->select('count(id) as allcount')->from('picture_likes')->where('contestant_id', $memid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function fetchPhotoCounts($memid){
        $this->db->select('file1,file2,file3')->from('pageant_activities')->where('memid', $memid);
        $query = $this->db->get();
        $sums = 1;
        if($query->num_rows() > 0){
            $query2 = $query->result_array();
            foreach ($query2 as $row) {
                $file1 = $row['file1'];
                $file2 = $row['file2'];
                $file3 = $row['file3'];
                if($file1!="") $sums+=1;
                if($file2!="") $sums+=1;
                if($file3!="") $sums+=1;
            }
        }
        return $sums;
    }



    function validate_adminx(){
        $adm_uname = $this->input->cookie('adm_username_celebs', TRUE);
        $adm_pass = $this->input->cookie('adm_password_celebs', TRUE);
        if(isset($adm_pass) && $adm_pass!=''){
            $this->db->select('id')->from('admin_tbls')->where('pass1', $adm_pass)->where('sha1(uname)', $adm_uname);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }



    function check_mem_details($emails, $phones){
        $this->db->select('id')->from('contestants');
        $this->db->where('emails', $emails);
        $this->db->or_where('phones', $phones);
        $query = $this->db->get();
        if($query->num_rows() <= 0){ // if not exists
            return true;
        }else{
            return false;
        }
    }




    function get_user_logins($data){
        $emails = $data['emails'];
        $pass = $data['pass'];
        $this->db->select('id')->from('contestants')->where("(emails='$emails' or phones='$emails')")->where('pass', sha1($pass));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return false;
        }
        //return $query->row('id');
    }



    function get_user_logins_paid($data){
        $emails = $data['emails'];
        $pass = $data['pass'];
        $this->db->select('id')->from('contestants')->where("(emails='$emails' or phones='$emails')")->where('pass', sha1($pass))->where('paid', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }



    function check_approved($id){
        $this->db->select('id')->from('contestants')->where('id', $id)->where('approved', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }


    function check_if_voted($memids, $swid, $ipaddr, $vote_phone){
        $this->db->select('id')->from('all_votes')->where('ip_addrs', $ipaddr)->where('activity_id', $swid);
        $this->db->where('contestant_id', $memids);
        if($vote_phone!="")
            $this->db->where('phones', $vote_phone);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return 1;
        else
            return 0;
    }


    function check_if_voted_free_m($memids, $swid, $ipaddr, $vote_phone){
        $this->db->select('id')->from('all_votes')->where('ip_addrs', $ipaddr)->where('activity_id', $swid);
        $this->db->where('contestant_id', $memids)->where('amt_paid', 0);
        if($vote_phone!="")
            $this->db->where('phones', $vote_phone);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return 1;
        else
            return 0;
    }


    function auth_details($users, $pass1){
        $this->db->select('id')->from('admin_tbls')->where('pass1', sha1($pass1))->where('uname', $users);
        $now = 865000;
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $cookie = array(
                'name'   => 'adm_username_celebs',
                'value'  => sha1($users),
                'expire' => $now,
                'secure' => FALSE
            );
            $cookie1 = array(
                'name'   => 'adm_password_celebs',
                'value'  => sha1($pass1),
                'expire' => $now,
                'secure' => FALSE
            );
            set_cookie($cookie);
            set_cookie($cookie1);    
            return true;
        }else{
            return false;
        }
    }




    function fetchMemProfile($memids){
        if($memids==""){
            $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
            $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);
            $this->db->select('*')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1);
        }else{
            $this->db->select('*')->from('contestants')->where('id', $memids);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    function fetch_A_MemProfile($memid, $params){
        if($params == "reformats")
            $memid = substr($memid, 0, -4);
        $this->db->select('*')->from('contestants')->where('id', $memid);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    function current_game_id(){ // no need for timing and has_done bcos the main program hasnt expired yet
        $nows = time();
        $this->db->select('asa2.id')->from('admin_set_activity2 asa2')->where('asa2.approved', 1);
        //$this->db->where('timings >=', $nows);
        //$this->db->where('asa2.has_done', 0);
        $this->db->join('set_weekly_activity asa', 'asa2.session1 = asa.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return false;
        }
    }


    function current_vote_campaign(){
        $nows = time();
        $this->db->select('sw.one_week_timings')->from('admin_set_activity2 asa2')->where('asa2.approved', 1);
        $this->db->where('sw.one_week_timings >=', $nows);
        $this->db->where('sw.has_done', 0)->where('sw.close_prev_contestant', 0);
        $this->db->join('set_weekly_activity sw', 'asa2.session1 = sw.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $timings = $query->row('one_week_timings');
            $currentTime = time();
            $difference = $timings - $currentTime;
            return convertTime1($difference);
        }else{
            return false;
        }
    }


    function current_day_game_id(){
        $nows = time();
        $this->db->select('asa2.id')->from('admin_set_activity2 asa2')->where('asa2.approved', 1);
        $this->db->where('asa2.timings >=', $nows);
        $this->db->where('asa2.has_done', 0);
        $this->db->join('set_weekly_activity asa', 'asa2.session1 = asa.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return 0;
        }
    }


    function current_game_title($id){
        $this->db->select('for_days, titles, game_type')->from('admin_set_activity2')->where('approved', 1)->where('id', $id);
        $this->db->where('has_done', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            //return $query->row('titles');
            return $query->row_array();
        }else{
            return false;
        }
    }


    function current_main_game_id(){
        $nows = time();
        $this->db->select('id')->from('set_weekly_activity')->where('approved', 1)->where('close_prev_contestant', 0)->where('has_done', 0);
        $this->db->where('one_week_timings >=', $nows);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('id');
        }else{
            return false;
        }
    }


    function quizIntro(){
        $nows = time();
        $this->db->select('qi.set_time')->from('quizes_intro qi')->where('qi.aprvd', 1);
        $this->db->where('qi.timings >=', $nows)->where('qi.completeds', 0);
        $this->db->join('quizes qq', 'qq.sessions1 = qi.sessions1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    function quizQuestions($quizid_taken){
        $nows = time();
        $this->db->select('qq.id AS ids, qi.id, qq.questions, qq.sessions1, qq.files, qq.op1, qq.op2, qq.op3, qq.op4, qq.op5, qq.ans1')->from('quizes qq')->where('qi.aprvd', 1);
        if($quizid_taken!=""){
            $quizid_taken = substr($quizid_taken, 0, -1);
            $quizid_taken = explode(',', $quizid_taken);
            $this->db->where_not_in('qq.id', $quizid_taken);
        }
        $this->db->where('qi.timings >=', $nows)->where('qi.completeds', 0);
        $this->db->join('quizes_intro qi', 'qq.sessions1 = qi.sessions1');
        $this->db->order_by('rand()');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }



    function already_started($get_mems_id, $qid_intro){
        $this->db->select('id')->from('stud_start_test');
        $this->db->where('quiz_intro_id', $qid_intro)->where('memid', $get_mems_id)->where('started_test', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    
    function fetchActivity_row(){
        $nows = time();
        $this->db->select('*, asa2.id AS id2, asa.session1 AS session2')->from('set_weekly_activity asa'); // approved is not supposed to be here
        $this->db->where('asa.one_week_timings >=', $nows);
        $this->db->where('asa.has_done', 0);
        $this->db->join('admin_set_activity2 asa2', 'asa2.session1 = asa.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    function fetchActivity_arr(){
        $nows = time();
        $this->db->select('*, asa2.dates AS dates2, asa2.id AS id2, asa.session1 AS session2')->from('admin_set_activity2 asa2')->where('asa2.approved', 1);
        $this->db->where('asa.has_done', 0);
        $this->db->join('set_weekly_activity asa', 'asa2.session1 = asa.session1');
        //$this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchMainActivity(){
        $nows = time();
        $this->db->select('overall_title, instructn, disqualificatn, dates')->from('set_weekly_activity');
        $this->db->where('one_week_timings >=', $nows);
        $this->db->where('has_done', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    

    function countDays(){
        $this->db->select('count(asa.id) as allcount')->from('admin_set_activity2 asa2')->where('asa2.approved', 1);
        $this->db->where('asa.has_done', 0);
        $this->db->join('set_weekly_activity asa', 'asa2.session1 = asa.session1');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    
    function websiteVisits(){
        $this->db->select('count(id) as allcount')->from('visitors');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }



    function countQuiz(){
        $nows = time();
        $this->db->select('count(qi.id) as allcount')->from('quizes qu')->where('qi.aprvd', 1);
        $this->db->where('qi.timings >=', $nows)->where('qi.completeds', 0);
        $this->db->join('quizes_intro qi', 'qi.sessions1 = qu.sessions1');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }




    function getMainActivity(){
        $nows = time();
        $this->db->select('id, overall_title')->from('set_weekly_activity');
        $this->db->where('one_week_timings >', 0);
        $this->db->where('one_week_timings >', $nows);
        //$this->db->where('has_done', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    

    function delete_memb_pics($file1){
        $in_folder1 = "celebs_uploads/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }


    function delete_quiz_pics($file1){
        $in_folder1 = "quizes/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }


    function delete_forum_pics($file1){
        $in_folder1 = "forum_files/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }


    function delete_gift_pics($file1){
        $in_folder1 = "gifts/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }

    function delete_gal_pics($file1){
        $in_folder1 = "gallery/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }

    function delete_events_pics($file1){
        $in_folder1 = "events_fols/".$file1;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }
    }


    function delete_product_pix($prod_pix){
        $in_folder1 = "products/".$prod_pix;
        if(is_readable($in_folder1)){
            @unlink($in_folder1);
            return true;
        }else{
            return false;
        }   
    }




    /*function getBMA_Email(){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);

        if($store_easer_usrs=="" || $store_easer_pas1==""){
            $store_easer_usrs = $this->input->cookie('bma_customer_email_ref', TRUE);
            $store_easer_pas1 = $this->input->cookie('bma_customer_pas1_ref', TRUE);
        }
        $this->db->select('emails')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1)->where('approved', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            return $query->row('emails');
        }else{
            return false;
        }
    }


    function getBMA_EmailID($id){
        $this->db->select('emails')->from('contestants')->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            return $query->row('emails');
        }else{
            return false;
        }
    }*/


    function getContryByName($id){
        $this->db->select('name')->from('countries')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row('name');
        else
            return false;
    }

    function getStateByName($id){
        $this->db->select('name')->from('states')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row('name');
        else
            return false;
    }

    function getCityByName($id){
        $this->db->select('name')->from('cities')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row('name');
        else
            return false;
    }


    
    function check_code($codes, $user_pass){
        $this->db->select('emails')->from('forgot_pass')->where('codes', $codes)->where('codes !=', 0);
        $query = $this->db->get();
        $ago_time=date("Y-m-d g:i a");

        if($query->num_rows() > 0){ // check if record is in database
            $email = $query->row('emails');

            $this->db->where('emails', $email);
            $this->db->set('codes', 0);
            $this->db->set('date_reset', $ago_time);
            $this->db->update('forgot_pass');

            $this->db->where('emails', $email);
            $this->db->set('pass', $user_pass);
            $this->db->update('contestants');
            return $email;
            
        }else{
            return false;
        }
    }



    function isSentMail($mems){
        $this->db->select('id')->from('contestants')->where('id', $mems)->where('paid', 0)->where('sent_pay_mail', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return false;
        }else{
            $this->db->where('id', $mems);
            $this->db->where('paid', 0);
            $this->db->set('sent_pay_mail', 1);
            $this->db->update('contestants');
            return true;
        }
    }


    function approvePaids($id, $emails, $fname, $tbl){
        $fname1 = ucfirst($fname);
        $this->db->where('id', $id);
        $this->db->set('paid', 1);
        $this->db->update($tbl);
        
        $this->db->select('sw.id')->from('set_weekly_activity sw');
        $this->db->where('close_prev_contestant', 0)->where('has_done', 0)->where('sw.one_week_timings >', 0)->where('approved', 1);
        $query = $this->db->get();
        $act_id = 0;
        if($query->num_rows() > 0){
            $act_id = $query->row('id');
        }
        $data = array(
            'memid'         => $id,
            'activity_id'   => $act_id,
            'dates'         => @date("Y-m-d g:i a", time())
        );
        $this->db->insert('paid_users', $data);

        //// send emails to members /////
            $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
            $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello $fname1,</b></p>";
            $message_contents .= "<p style='font-size:14px; margin-top:10px'>Your payment of <b>NGN1,000</b> has been verified and your
            OurFavCelebs account is now active. Please login to the website to see our activities and feel free to contact us via our
            phone numbers or email if need be.<br><b>Thank you for your patronage.</p>";

            $message_contents .= "<p style='font-weight:normal;'><a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";
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
                'from' => "OurFavCelebs Administrators <info@ourfavcelebs.com>",
                'to' => $emails,
                'subject' => "Your Payment Has Been Verified.",
                'html' => $message_contents
            ));
            $result = curl_exec($ch);
            curl_close($ch);
        //// send emails to members /////
    }



    function approvePaidsVotes($id, $fname1, $emails, $amts, $tbl){
        $this->db->select('votes')->from($tbl)->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $amts1=0;
            if($amts==50) $amts1=5;
            if($amts==100) $amts1=10;
            $votes1 = $query->row('votes');
            if($votes1==null || $votes1=="") $votes1=0;
            $this->db->set('votes', $votes1+$amts1);
            $this->db->set('paid', 1);
            $this->db->where('id', $id)->update($tbl);
        }
        return $votes1+$amts1;

        //// send emails to members /////
            $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
            $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Voter,</b></p>";
            $message_contents .= "<p style='font-size:14px; margin-top:10px'>The payment of &#8358;$amts you made has been verified and 
            $amts1 votes have been added to your contestant $fname1, thank you for your votes.<br>We always hope that your contestant
            be the lucky winner.</p>";

            $message_contents .= "<p style='font-weight:normal;'><a href='http://www.ourfavcelebs.com' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com</a></p>";
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
                'from' => "Voting Campaign <info@ourfavcelebs.com>",
                'to' => $emails,
                'subject' => "Your Payment Has Been Verified.",
                'html' => $message_contents
            ));
            $result = curl_exec($ch);
            curl_close($ch);
        //// send emails to members /////
    }



    function approvePaidsFunds($id, $fname1, $phone, $amts, $tbl){
        $this->db->select('paid')->from($tbl)->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $paid1 = $query->row('paid');
            if($paid1==null || $paid1=="") $paid1=0;
            $this->db->set('paid', 1);
            $this->db->where('id', $id)->update($tbl);
            $dates = date("Y-m-d g:i a", time());
            $ipaddr = $_SERVER['REMOTE_ADDR'];

            $this->db->select('id')->from('fund_wallet')->where('names', $fname1)->where('phone', $phone);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $this->db->where('names', $fname1)->where('phone', $phone);
                $this->db->set('amts', "amts+$amts", FALSE);
                $this->db->set('date_created', $dates);
                $this->db->update('fund_wallet');
            }else{
                $data = array(
                    'names'          => $fname1,
                    'ipaddrs'        => $ipaddr,
                    'phone'          => $phone,
                    'amts'           => $amts,
                    'date_created'   => date("Y-m-d g:i a", time())
                );
                $query = $this->db->insert('fund_wallet', $data);
            }
        }
        return true;
    }

    

    function checkWallet(){
        $cookie_fund_phone = $this->input->cookie('cookie_fund_phone', TRUE);
        $voter_ip = $this->input->cookie('voter_ip', TRUE);
        $this->db->select('amts')->from('fund_wallet')->where('ipaddrs', $voter_ip)->where('phone', $cookie_fund_phone);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('amts');
        else
            return 0;
    }



    function show_memb_name($memid){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);
        if($memid!=""){
            $memid = substr($memid, 0, -4);
            $this->db->select('fname,lname,phones,emails')->from('contestants')->where('id', $memid);
        }else
            $this->db->select('fname,lname,phones,emails')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1)->where('approved', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }



    function check_expired_trivia_game(){
        $nows = time();
        $this->db->set('timings', 0);
        $this->db->set('completeds', 1);
        $this->db->where('timings >', 0)->where('timings <', $nows)->where('completeds',0)->where('aprvd', 1)->update('quizes_intro');
        
        $this->db->select('qi.id')->from('quizes_intro qi');
        $this->db->join('admin_set_activity2 asa2', 'qi.activity_id = asa2.id');
        //$this->db->where('qi.aprvd', 1)->where('qi.completeds', 1)->where('asa2.timings >', 0)->where('asa2.timings <', $nows);
        $this->db->where('qi.aprvd', 1)->where('qi.completeds', 1)->where('asa2.timings >', 0)->where('qi.timings <', $nows)->where('asa2.timings <', $nows);
        $query = $this->db->get();
        if($query->num_rows() > 0){ // has completed
            return true;
            //return 1;
        }else{
            return false;
            //return 2;
        }
    }



    function checkActivityComplete($memid, $activity_id, $what_day){
        if($activity_id > 0){
            $nows = time();
            $this->db->select('asa2.id')->from('admin_set_activity2 asa2');
            $this->db->where('asa2.timings >', 0)->where('asa2.timings <', $nows)->where('asa2.has_done', 0);
            $this->db->where('sw.close_prev_contestant', 0)->where('sw.has_done', 0);
            $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
            $query = $this->db->get();
            if($query->num_rows() > 0){ // first check if the time given has expired
                return true; // true is has expired or timing is 0
                //return 1;
            }else{ 
                // false it hasnt expired
                $this->db->select('pa.id')->from('pageant_activities pa'); // if you have done the activity or it has expired
                //$this->db->where('pa.memid', $memid)->where('pa.activity_id', $activity_id)->where('pa.what_day', $what_day);
                //$this->db->where('asa2.timings >', 0)->where('asa2.timings <', $nows);
                $this->db->where("(asa2.timings > 0 or asa2.timings < $nows) and pa.memid='$memid' and pa.activity_id='$activity_id' and pa.what_day='$what_day'");
                $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
                $query = $this->db->get();
                if($query->num_rows() > 0){ // check if you have done the activity
                    return true;
                    //return 2;
                }else{ // i havent done it so show me game
                    // now check if the time is ready for me to start the quiz
                    $this->db->select('asa2.id')->from('admin_set_activity2 asa2');
                    $this->db->where('asa2.starting_from1 >', 0)->where('asa2.starting_from1 <=', $nows)->where('asa2.has_done', 0);
                    $this->db->where('asa2.approved', 1)->where('sw.close_prev_contestant', 0)->where('sw.has_done', 0);
                    $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
                    $query = $this->db->get();
                    if($query->num_rows() > 0)
                        return false; // show me
                        //return 3;
                    else
                        return true;
                        //return 4;
                }
            }
        }else{
            return true;
            //return 5;
        }
    }


    function validate_member(){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);
        $this->db->select('id')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    function validate_member_paid(){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);
        $this->db->select('id')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1)->where('approved', 1)->where('paid', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    
    function check_uncomplete_profile(){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);
        $this->db->select('id')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1)->where('approved', 1);
        $this->db->where("(relationshp_status='' or occupatn='' or likes='' or dislikes='' or bios='' or kind_of_partner='' or pics='')");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    

    function update_user_pass1($new_pass, $oldpass){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $this->db->where("sha1(emails)='$store_easer_usrs'")->where('pass', sha1($oldpass));
        $this->db->set('pass', $new_pass);
        $query1 = $this->db->update('contestants');
        if($query1) return true; else return false;
    }


    function update_adm_password($new_pass, $oldpass){
        $this->db->where('pass1', sha1($oldpass));
        $this->db->set('pass1', $new_pass);
        $query1 = $this->db->update('admin_tbls');
        if($query1) return true; else return false;
    }
    

    function checkOldPass($oldpass){
        $this->db->where('pass', $oldpass);
        $query = $this->db->get('contestants');
        if($query->num_rows() > 0)
            return 1;
        else
            return 0;
    }

    
    function inSetAct2($sess){
        $this->db->where('session1', $sess);
        $query = $this->db->get('admin_set_activity2');
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }


    function getCurrency($name){
        $this->db->select('sortname')->from('countries')->where('name', $name);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('sortname');
        else
            return "NG";
    }


    function getAdminType($memids){
        $this->db->select('user_type')->from('contestants')->where('id', $memids);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('user_type');
        else
            return false;
    }



    

    function getCatName($id){
        $this->db->select('cat')->from('categories')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('cat');
        }else
            return false;
    }


    function getMemberID($id){
        $this->db->select('fname, lname')->from('contestants')->where('id', $id);
        $query = $this->db->get();
            $fnames = $query->row('fname');
            $lnames = $query->row('lname');
        if($query->num_rows() > 0){
            $ful1 = "$fnames $lnames";
            return ucwords($ful1);
        }else
            return false;
    }


    function getInputs($txttitle, $txtinstruc, $txtdis){
        $this->db->select('session1')->from('set_weekly_activity')->where('overall_title', $txttitle)->where('instructn', $txtinstruc)->where('disqualificatn', $txtdis);
        $query = $this->db->get();  
        if($query->num_rows() > 0)
            return $query->row('session1');
        else
            return false;
    }


    function get_activityID($id, $id1, $params){
        $this->db->select('sw.id, sw.session1, sw.approved, sw.enable_reg, sw.disable_reg, sw.overall_title, sw.close_prev_contestant, sw.one_week_timings, sw.has_done, sw.instructn,
        sw.disqualificatn, sw.dates, sw.prize1, sw.prize2, sw.prize3, sw.gift1, sw.gift2, sw.gift3, sw.banners, asa2.for_days, asa2.day_instructns, asa2.time_duratn, asa2.starting_from, asa2.game_type, 
        asa2.dates AS date_asa, asa2.has_done AS has_done_asa, asa2.titles, asa2.id AS ids, asa2.timings, asa2.approved AS approved1');
        $this->db->from('set_weekly_activity sw');
        if($id1==""){
            $this->db->where('md5(sw.id)', $id);
        }else{
            $this->db->where('md5(sw.id)', $id);
            $this->db->where('md5(asa2.id)', $id1);
        }
        $this->db->join('admin_set_activity2 asa2', 'asa2.session1 = sw.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            if($params=="rows")
                return $query->row_array();
            else
                return $query->result_array();
        }else{
            return false;
        }
    }


    // function get_activityIDSess($tbl, $sess){
    //     $this->db->select('activity_id');
    //     $this->db->from($tbl);
    //     $this->db->where('use_session', $sess);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0){
    //         return $query->row('activity_id');
    //     }else{
    //         return 0;
    //     }
    // }



    function get_mediaID($id){
        $this->db->select('id, titles, files, media_type');
        $this->db->from('gallery_vid');
        $this->db->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }



    function updateSessions($sess, $txtsessions, $txtact_id){
        $this->db->select('id');
        $this->db->from('quizes_intro')->where('sessions1', $sess);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $ids = $query->row('id'); // 3

            $this->db->set('sessions1', $sess, FALSE);
            $this->db->where('sessions1', $txtsessions);
            $this->db->where('activity_id', $txtact_id);
            $this->db->update('quizes_intro');

            $this->db->where('id', $ids);
            $this->db->delete('quizes_intro');
            return true;
        }else{
            return false;    
        }
    }

    

    function get_Activities(){
        $this->db->select('sw.session1, sw.overall_title, sw.one_week_timings');
        $this->db->from('set_weekly_activity sw')->where('sw.approved', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    
    function getQuizTitles($session1){
        $this->db->select('id, session1, titles, has_done, for_days');
        $this->db->from('admin_set_activity2')->where('session1', $session1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    
    function fetchQuests($session1){
        // $this->db->select('id, session1, titles, has_done, for_days');
        // $this->db->from('admin_set_activity2')->where('session1', $session1);
        // $query = $this->db->get();
        // if($query->num_rows() > 0){
        //     return $query->result_array();
        // }else{
        //     return false;
        // }
    }


    function get_QuizID(){
        $this->db->select('qi.id AS ids, qi.set_time, qi.aprvd, qi.completeds, qi.timings, qi.dates, sw.session1 AS session2, sw.overall_title');
        $this->db->from('quizes_intro qi')->where('asa2.game_type', 'qz');
        $this->db->join('set_weekly_activity sw', 'sw.id = qi.activity_id');
        $this->db->join('admin_set_activity2 asa2', 'asa2.session1 = sw.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function getMainSess($id){
        $this->db->select('activity_id');
        $this->db->from('quizes_intro')->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $activity_id = $query->row('activity_id');
            $this->db->select('session1');
            $this->db->from('admin_set_activity2 asa2')->where('id', $activity_id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->row('session1');
            }else{
                return false;    
            }
        }else{
            return false;
        }
    }


    
    function getQuizes($id){
        $this->db->select('qi.id AS ids, qq.id AS id3, qi.set_time, qi.sessions1, qi.aprvd, qi.activity_id, qq.questions, qq.files, qq.op1, qq.op2, qq.op3, qq.op4, qq.op5, qq.ans1');
        $this->db->from('quizes qq')->where('md5(qq.id)', $id);
        $this->db->join('quizes_intro qi', 'qq.sessions1 = qi.sessions1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }


    function deleteTblRecords($txt_dbase_table, $txtall_id){
        if($txt_dbase_table == "view_activities"){

            $this->db->select('id')->from('admin_set_activity2')->where('session1', $txtall_id);
            $query = $this->db->get();
            $id1 = $query->row('id');
            if($id1){
                $this->db->select('sessions1, id')->from('quizes_intro')->where('activity_id', $id1);
                $query = $this->db->get();
                $quiz_intro_id = $query->row('id');
                
                $this->db->select('files')->from('quizes')->where('activity_id', $id1);
                $query = $this->db->get();
                if($query->num_rows() > 0){
                    $query1 = $query->result_array();
                    foreach ($query1 as $row) {
                        $files = $row['files'];
                        $in_folder1="quizes/$files";
                        if(is_readable($in_folder1)) @unlink($in_folder1);
                    }
                }

                $this->db->select('file1,file2,file3')->from('pageant_activities')->where('activity_id', $id1);
                $query = $this->db->get();
                if($query->num_rows() > 0){
                    $query1 = $query->result_array();
                    foreach ($query1 as $row) {
                        $file1 = $row['file1'];
                        $file2 = $row['file2'];
                        $file3 = $row['file3'];
                        $in_folder1="activity_photos/$file1";
                        $in_folder2="activity_photos/$file2";
                        $in_folder3="activity_photos/$file3";
                        if(is_readable($in_folder1)) @unlink($in_folder1);
                        if(is_readable($in_folder2)) @unlink($in_folder2);
                        if(is_readable($in_folder3)) @unlink($in_folder3);
                    }
                }

                $this->db->where('activity_id', $id1);
                $query = $this->db->delete('pageant_activities');

                $this->db->where('activity_id', $id1);
                $query = $this->db->delete('all_votes');

                $this->db->where('activity_id', $id1);
                $query = $this->db->delete('winneris');

                if($quiz_intro_id){
                    $this->db->where('quiz_intro_id', $quiz_intro_id);
                    $query = $this->db->delete('stud_start_test');
                }

                $this->db->where('activity_id', $id1);
                $query = $this->db->delete('quizes_intro');

            }

            $this->db->select('overall_title,instructn,banners,gift1,gift2,gift3')->from('set_weekly_activity')->where('session1', $txtall_id);
            $query = $this->db->get();
            $title_ev = $query->row('overall_title');
            $instructn_ev = $query->row('instructn');
            $banners_ev = $query->row('banners');

            if($query->num_rows() > 0){
                $query1 = $query->result_array();
                foreach ($query1 as $row) {
                    $banners = $row['banners'];
                    $gift1 = $row['gift1'];
                    $gift2 = $row['gift2'];
                    $gift3 = $row['gift3'];
                    $in_folder1="gifts/$gift1";
                    $in_folder2="gifts/$gift2";
                    $in_folder3="gifts/$gift3";
                    $in_folder4="events_fols/$banners";
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                    if(is_readable($in_folder2)) @unlink($in_folder2);
                    if(is_readable($in_folder3)) @unlink($in_folder3);
                    if(is_readable($in_folder4)) @unlink($in_folder4);
                }
            }

            $this->db->where('titles', $title_ev)->where('descrip', $instructn_ev);
            $query = $this->db->delete('events');

            $this->db->where('files', $banners_ev)->where('myfolder', 'actv');
            $query = $this->db->delete('events_media');


            $this->db->where('session1', $txtall_id);
            $query = $this->db->delete('admin_set_activity2');
    
            $this->db->where('session1', $txtall_id);
            $query = $this->db->delete('set_weekly_activity');

            if($query) return true; else return false;
        }

        if($txt_dbase_table == "contestants"){
            $this->db->select('pics')->from('contestants')->where('id', $txtall_id);
            $query = $this->db->get();
            $files = $query->row('pics');
            $in_folder1="celebs_uploads/$files";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->select('files')->from('forums')->where('memid', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');
            $in_folder1="forum_files/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->select('files')->from('forum_reply')->where('memid', $txtall_id);
            $query2 = $this->db->get();
            if($query2->num_rows() > 0){
                $query1 = $query2->result_array();
                foreach ($query1 as $row) {
                    $files2 = $row['files'];
                    $in_folder2="forum_files/$files2";
                    if(is_readable($in_folder2)) @unlink($in_folder2);
                }
            }
            $this->db->where('memid', $txtall_id);
            $this->db->delete('forums');

            $this->db->where('memid', $txtall_id);
            $this->db->delete('forum_reply');

            $this->db->select('file1,file2,file3')->from('pageant_activities')->where('memid', $txtall_id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $query1 = $query->result_array();
                foreach ($query1 as $row) {
                    $file1 = $row['file1'];
                    $file2 = $row['file2'];
                    $file3 = $row['file3'];
                    $in_folder1="activity_photos/$file1";
                    $in_folder2="activity_photos/$file2";
                    $in_folder3="activity_photos/$file3";
                    if(is_readable($in_folder1)) @unlink($in_folder1);
                    if(is_readable($in_folder2)) @unlink($in_folder2);
                    if(is_readable($in_folder3)) @unlink($in_folder3);
                }
            }

            $this->db->where('memid', $txtall_id);
            $query = $this->db->delete('pageant_activities');

            $this->db->where('contestant_id', $txtall_id);
            $query = $this->db->delete('picture_likes');

            $this->db->where('memid', $txtall_id);
            $query = $this->db->delete('stud_ans');

            $this->db->where('memid', $txtall_id);
            $query = $this->db->delete('stud_start_test');

            $this->db->where('memid', $txtall_id);
            $query = $this->db->delete('winneris');
            /////////////////////////////////////////

            $this->db->where('id', $txtall_id);
            $query = $this->db->delete('contestants');
        }

        if($txt_dbase_table == "forum"){
            $this->db->select('files')->from('forums')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');

            $in_folder1="forum_files/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->select('files')->from('forum_reply')->where('forum_id', $txtall_id);
            $query2 = $this->db->get();
            if($query2->num_rows() > 0){
                $query1 = $query2->result_array();
                foreach ($query1 as $row) {
                    $files2 = $row['files'];
                    $in_folder2="forum_files/$files2";
                    if(is_readable($in_folder2)) @unlink($in_folder2);
                }
            }

            $this->db->where('id', $txtall_id);
            $this->db->delete('forums');

            $this->db->where('forum_id', $txtall_id);
            $this->db->delete('forum_reply');
        }

        if($txt_dbase_table == "forumreply"){
            $this->db->select('files')->from('forum_reply')->where('id', $txtall_id);
            $query1 = $this->db->get();
            $files1 = $query1->row('files');

            $in_folder1="forum_files/$files1";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('id', $txtall_id);
            $this->db->delete('forum_reply');
        }
        

        if($txt_dbase_table == "voters"){
            $this->db->where('id', $txtall_id);
            $query = $this->db->delete('all_votes');
        }

        if($txt_dbase_table == "viewgames"){
            $this->db->select('sessions1')->from('quizes_intro')->where('id', $txtall_id);
            $query = $this->db->get();
            $sessions1 = $query->row('sessions1');

            $this->db->select('files')->from('quizes')->where('sessions1', $sessions1);
            $query = $this->db->get();
            $files = $query->row('files');

            $in_folder1="quizes/$files";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('sessions1', $sessions1);
            $query = $this->db->delete('quizes');

            $this->db->where('id', $txtall_id);
            $query = $this->db->delete('quizes_intro');
        }

        if($txt_dbase_table == "viewmedia"){
            $this->db->select('files')->from('gallery_vid')->where('id', $txtall_id);
            $query = $this->db->get();
            $files = $query->row('files');

            $in_folder1="gallery/$files";
            if(is_readable($in_folder1)) @unlink($in_folder1);

            $this->db->where('id', $txtall_id);
            $query = $this->db->delete('gallery_vid');
        }

        if($txt_dbase_table == "viewtrivia"){
            $this->db->where('id', $txtall_id);
            $query = $this->db->delete('quizes');
        }
    }


    function getQuizesID($id){
        $this->db->select('id AS id3, activity_id AS ids, questions, files, op1, op2, op3, op4, op5, ans1');
        $this->db->from('quizes')->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }


    
    function get_next_question($session1){
        $this->db->select('qi.id AS ids, qq.id AS id3, qi.set_time, qi.sessions1, qi.aprvd, qi.activity_id, qq.questions, qq.files, qq.op1, qq.op2, qq.op3, qq.op4, qq.op5, qq.ans1');
        $this->db->from('quizes_intro qi')->where('md5(qi.id)', $id);
        $this->db->join('quizes qq', 'qq.sessions1 = qi.sessions1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;    
        }
    }


    function get_activityID2(){
        $this->db->select('sw.id, sw.session1, sw.approved, sw.overall_title, sw.close_prev_contestant, sw.one_week_timings, sw.has_done, sw.instructn,
        sw.disqualificatn, sw.dates, asa2.for_days, asa2.day_instructns, asa2.time_duratn, asa2.starting_from, asa2.game_type, 
        asa2.dates AS date_asa, asa2.has_done AS has_done_asa, asa2.id AS ids, asa2.timings');
        $this->db->from('set_weekly_activity sw')->where('asa2.timings >', 0)->where('asa2.has_done', 0)->where('sw.has_done', 0)->where('sw.approved', 1)->where('sw.close_prev_contestant', 0);
        $this->db->join('admin_set_activity2 asa2', 'asa2.session1 = sw.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }


    public function existing_prod_id($prodid, $txt_bma_id){
        $query = $this->db->get_where('saved_ads', array('prod_id' => $prodid, 'memid' => $txt_bma_id));
        if($query->num_rows() > 0) // the id already exixst
            return true;
        else
            return false;
    }



    function computeScores($ids1, $mem_ans){
        $this->db->select('id')->from('quizes');
        $this->db->where('id', $ids1)->where('ans1', $mem_ans);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }


    
    function create_actv($data, $actid){
        $txttitle = $data['overall_title'];
        $txtdescrip = $data['instructn'];
        $newFileName = "";
        if(isset($data['banners']) && $data['banners'] != ''){
            $newFileName = $data['banners'];
        }
        $years = date("Y", time());

        if($actid!=""){
            $data1 = array(
                'titles'       => $txttitle,
                'descrip'      => $txtdescrip
            );
        }else{
            $data1 = array(
                'titles'       => $txttitle,
                'descrip'      => $txtdescrip,
                'views'        => 0,
                'year'         => $years,
                'dates'        => date("Y-m-d g:i a", time())
            );
        }

        if($actid!=""){
            $this->db->where('md5(id)', $actid)->update('set_weekly_activity', $data);
            $qry = $this->db->where('md5(id)', $actid)->update('events', $data1);
            
            if(strlen($newFileName)>12){ // if theres image
                if($qry){
                    $this->db->select('id')->from('events')->where('md5(id)', $actid);
                    $query = $this->db->get();
                    $ids = $query->row('id');

                    $datas = array(
                        'event_id'  => $ids,
                        'files'     => $newFileName
                    );
                    $this->db->update('events_media', $datas);
                }
            }
            return true;

        }else{
            $overall_title = $data['overall_title'];
            $this->db->select('id')->from('set_weekly_activity')->where('overall_title', $overall_title);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return false;
            }else{
                $this->db->insert('set_weekly_activity', $data);
                $qry = $this->db->insert('events', $data1);
                if($qry){
                    $this->db->select('id')->from('events')->where('titles', $txttitle)->where('descrip', $txtdescrip);
                    $query = $this->db->get();
                    $ids = $query->row('id');

                    if(strlen($newFileName)>12){
                        $datas = array(
                            'event_id'  => $ids,
                            'files'     => $newFileName,
                            'myfolder'  => "actv"
                        );
                    }else{
                        $datas = array(
                            'event_id'  => $ids,
                            'myfolder'  => "actv"
                        );
                    }
                    $this->db->insert('events_media', $datas);
                }
                return true;
            }
        }
    }


    function upload_md($data, $actid){
        if($actid!=""){
            $query = $this->db->where('md5(id)', $actid)->update('gallery_vid', $data);
        }else{
            $query = $this->db->insert('gallery_vid', $data);
        }
        if($query) return true; else return false;
    }



    function create_funds($data){
        $names = $data['names'];
        $phones = $data['phone'];
        $amts1 = $data['amts'];
        
        $this->db->select('id')->from('fund_wallet_logs')->where('phone', $phones)->where('paid', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){ // if votes hasnt paid, update amount
            $this->db->where('phone', $phones)->where('paid', 0);
            $this->db->set('amts', "amts+$amts1", FALSE);
            $this->db->update('fund_wallet_logs');
        }else{
            $query = $this->db->insert('fund_wallet_logs', $data); // admin records
        }

        if($query) return true; else return false;
    }



    function upload_mymedia($data, $actid){
        if($actid!=""){
            $qry = $this->db->where('md5(id)', $actid)->update('events', $data);
        }else{
            $qry = $this->db->insert('events', $data);
        }

        if($qry){
            $titles = $data['titles'];
            $descrip = $data['descrip'];

            $this->db->select('id')->from('events')->where('titles', $titles)->where('descrip', $descrip);
            $query = $this->db->get();
            return $query->row('id');
        }else{
            return false;
        }
    }


    function create_actv_2($data, $activity_sess){
        $this->db->where('session1', $activity_sess)->update('set_weekly_activity', $data);
        return true;
    }


    function create_actv2($data, $activity_sess, $params){
        if($params == "new"){
            $this->db->insert('admin_set_activity2', $data);

        }else if($params == "edits"){
            $this->db->where('md5(id)', $activity_sess)->update('admin_set_activity2', $data);

        }else{
            if($activity_sess!=""){
                $this->db->where('session1', $activity_sess)->update('admin_set_activity2', $data);
            }else{
                $this->db->insert('admin_set_activity2', $data);
            }
        }
        return true;
    }


    
    function create_quiz_intro($data, $qid){
        $set_time = $data['set_time'];
        $activity_id = $data['activity_id'];

        $this->db->select('id')->from('quizes_intro')->where('set_time', $set_time)->where('activity_id', $activity_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $this->db->where('set_time', $set_time)->where('activity_id', $activity_id);
            $this->db->set('set_time', $set_time);
            $this->db->set('activity_id', $activity_id);
            $this->db->update('quizes_intro');
        }else{
            if($qid!=""){
                $this->db->where('id', $qid)->update('quizes_intro', $data);
            }else{
                $this->db->insert('quizes_intro', $data);
            }
        }

        $this->db->select('id, sessions1')->from('quizes_intro')->where('set_time', $set_time)->where('activity_id', $activity_id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        $id2 = $query->row('id');
        
        $this->db->where('id', $activity_id)->where('game_type', 'qz');
        $this->db->set('quiz_intro_id', $id2);
        $this->db->update('admin_set_activity2');

        return $query->row('sessions1');
    }



    function insert_scores($data){
        $query1 = $this->db->insert('stud_ans', $data);
        if($query1)
            return true;
        else
            return false;
    }


    function store_codes($data){
        $query1 = $this->db->insert('email_verificatn', $data);
        if($query1)
            return true;
        else
            return false;
    }


    function insert_cmts($data){
        $query1 = $this->db->insert('comments', $data);
        if($query1)
            return true;
        else
            return false;
    }
    
    

    function record_visitors($ipaddr){
        $this->db->select('ipaddrs')->from('visitors')->where('ipaddrs', $ipaddr);
        $query = $this->db->get();
        if($query->num_rows() <= 0){
            $data = array(
                'ipaddrs'  => $ipaddr
            );
            $this->db->insert('visitors', $data);
        }
        return true;
    }



    function insert_donatn($data){
        $query1 = $this->db->insert('donation', $data);
        if($query1)
            return true;
        else
            return false;
    }


    
    function get_pending_contestants(){
        $this->db->select('id')->from('pageant_activities');
        $this->db->where('winner_computed', 0)->where('expired', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    
    function compute_the_winners(){
        $nows = time();
        $this->db->select('asa2.id AS id2, sw.id AS id3')->from('set_weekly_activity sw');
        //$this->db->where('sw.one_week_timings >', 0);
        $this->db->where('sw.one_week_timings <', $nows);
        $this->db->where('sw.has_done', 1);
        $this->db->join('admin_set_activity2 asa2', 'sw.session1 = asa2.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){ // yes expired
            $id1 = $query->row('id2');
            $id2 = $query->row('id3');

            $this->db->select('id, memid, scores, scores2, scores3')->from('pageant_activities');
            //$this->db->where('activity_id', $id1);
            $this->db->where('winner_computed', 0);
            $query1 = $this->db->get();
            if($query1->num_rows() > 0){
                $query1 = $query1->result_array();
                $all_scores="";
                foreach ($query1 as $row) {
                    $scores = $row['scores'];
                    $scores2 = $row['scores2'];
                    $scores3 = $row['scores3'];
                    $all_scores .= "$scores, $scores2, $scores3, ";
                }
                $all_scores = substr($all_scores, 0, -2);
                $all_scores1 = explode(', ', $all_scores);
                if(!in_array(0, $all_scores1)){  
                    foreach ($query1 as $row) {
                        $memids = $row['memid'];
                        $all_lks = $this->count_lks($id1, $memids); // 230/50  // for every 50 likes is equal to 1 vote
                        $all_lks1 = $all_lks/50;

                        $all_vots = $this->count_vts($id1, $memids); // 560
                        $all_vots1 = $all_vots + $all_lks1;
                        $all_vots1 = round($all_vots1); // 560

                        $all_jscore = $this->count_judge_score($id1, $memids); // 56/100
                        $all_gscore = $this->count_trivia_score($id1, $memids); // 80/100
                        $overrall = $all_vots1 + $all_gscore + $all_jscore; // 560+56+80 = 696
                        $positions = "";

                        $newdata3 = array(
                            'approved'      => 0,
                            'activity_id'   => $id2, // the main activity
                            'memid'         => $memids,
                            'votes'         => $all_vots,
                            'likes'         => $all_lks,
                            'g_score'       => $all_gscore,
                            'j_score'       => $all_jscore,
                            'over_all'      => round($overrall),
                            'positns'       => $positions,
                            'dates'         => @date("Y-m-d g:i a", time())
                        );
                        $this->db->select('memid')->from('winneris');
                        $this->db->where('memid', $memids)->where('activity_id', $id2)->where('approved', 0);
                        $query = $this->db->get();
                        if($query->num_rows() <= 0)
                            $qrys = $this->db->insert('winneris', $newdata3);
                    }

                    // set the positions
                    $this->db->select('id')->from('winneris')->where('approved', 0)->where('activity_id', $id2)->where('positns', 0);
                    $this->db->order_by('over_all', 'desc');
                    $query1 = $this->db->get();
                    $query = $query1->result_array();
                    
                    $i=1;
                    foreach ($query as $row) {
                        $id1 = $row['id'];
                        $this->db->set('positns', $i);
                        $this->db->where('id', $id1);
                        $this->db->update('winneris');
                        $i++;
                    }

                    $this->db->set('winner_computed', 1);
                    $this->db->where('expired', 1)->where('winner_computed', 0)->update('pageant_activities');
                    return 1; // yes has entered scores
                }else{
                    return 2; // scores not entered
                }

            }else{
                return 4; // nothing to compute
            }
        }else{
            return 3; // means hasnt expired
        }
    }


    function approve_the_winners(){
        $this->db->set('approved', 1);
        $query = $this->db->where('approved', 0)->update('winneris');
        if($query) return true; else return false;
    }
    

    function count_vts($id1, $memids){
        $this->db->select('votes')->from('all_votes');
        $this->db->where('activity_id', $id1)->where('contestant_id', $memids);
        $query = $this->db->get();
        $votes1 = 0;
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $votes = $row->votes;
                $votes1 += $votes;
            }
            return $votes1;
        }
        return 0;
    }


    function count_lks($id1, $memids){
        $this->db->select('likes')->from('picture_likes');
        $this->db->where('contestant_id', $memids)->where('activity_id', $id1);
        $query = $this->db->get();
        $likes1 = 0;
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $likes = $row->likes;
                $likes1 += $likes;
            }
            return $likes1;
        }
        return 0;
    }

    function count_trivia_score($id1, $memids){
        $this->db->select('scores')->from('stud_ans');
        $this->db->where('memid', $memids)->where('gameid', $id1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $scores = $query->row('scores');
            //$percentages = (10/100) * $scores; // judges take up to 10%
            return $scores;
        }else{
            return 0;
        }
    }

    function count_judge_score($id1, $memids){
        $this->db->select('scores, scores2, scores3')->from('pageant_activities');
        $this->db->where('memid', $memids)->where('activity_id', $id1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $query = $query->result_array();
            $sums = 0;
            //$cnts = 0;
            foreach ($query as $row) {
                $scores = $row['scores']; // 100
                $scores2 = $row['scores2']; // 100
                $scores3 = $row['scores3']; // 100
                $total_scores = $scores + $scores2 + $scores3; // 300
                $all_my_scores1 = round($total_scores);
                $sums+=$all_my_scores1; // 600 in 2 rows not 3 rows, bcos one row is always for quiz
                //$cnts++;
            }
            $total_columns = 2*3; // picture game must be 2 times
            $get_total = $sums/$total_columns; // 600/6 = 100
            //$percentages = (15/100) * $get_total; // judges take up to 15%
            return round($get_total);
        }else{
            return 0;
        }
    }


    function fetchMemViews($memids){
        $this->db->select('views')->from('pageant_activities');
        $this->db->where('memid', $memids);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $query = $query->result_array();
            $sums = 0;
            foreach ($query as $row) {
                $myviews = $row['views'];
                $sums+=$myviews;
            }
            return @number_format($sums);
        }else{
            return 0;
        }
    }



    function check_valid_fields($id){
        $this->db->select('id')->from('contestants');
        $this->db->where('phone_visible', 1)->where('approved', 1)->where('picx IS NOT NULL');
        $this->db->where('countrys IS NOT NULL')->where('states IS NOT NULL')->where('citys IS NOT NULL');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }



    function check_expired_game(){
        $nows = time();
        $this->db->select('sw.id, asa2.id as id2, sw.session1, asa2.quiz_intro_id')->from('set_weekly_activity sw');
        //$this->db->where('sw.one_week_timings >', 0);
        $this->db->where('sw.one_week_timings <', $nows);
        $this->db->where('sw.has_done', 0);
        $this->db->join('admin_set_activity2 asa2', 'sw.session1 = asa2.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $session1 = $query->row('session1'); //  set_weekly_activity
            $ids = $query->row('id');
            $activity_id = $query->row('id2');
            $quiz_intro_id = $query->row('quiz_intro_id');

            if($quiz_intro_id>0){
                $this->db->set('timings', 0);
                $this->db->set('completeds', 1);
                $this->db->where('activity_id',$activity_id)->update('quizes_intro');
            }

            $this->db->set('expired', 1);
            $this->db->where('activity_id',$activity_id)->update('pageant_activities');

            $this->db->set('paid', 0);
            $this->db->where('paid', 1)->update('contestants');
            ////// let it update paid to 0 to make them to pay for another activity ///////

            $this->db->set('timings', 0);
            $this->db->set('has_done', 1);
            $this->db->where('session1',$session1)->where('has_done',0)->update('admin_set_activity2');

            $this->db->set('one_week_timings', 0);
            $this->db->set('has_done', 1);
            $this->db->where('one_week_timings >', 0)->where('one_week_timings <', $nows)->update('set_weekly_activity');
            return 1;

        }else{
            return 2;
        }
    }


    function check_new_game(){
        $nows = time();
        $this->db->select('enable_reg, disable_reg')->from('set_weekly_activity');
        //$this->db->where('one_week_timings', 0);
        $this->db->where('enable_reg >', 0);
        $this->db->where('has_done', 0);
        $this->db->where('close_prev_contestant', 0);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return 0; // not yet  
        }
    }
    

    function check_daily_expired_game(){
        $nows = time();
        $this->db->select('asa2.id')->from('admin_set_activity2 asa2');
        $this->db->where('asa2.timings >', 0);
        $this->db->where('asa2.timings <', $nows);
        $this->db->where('asa2.has_done', 0);
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        $query = $this->db->get();
        if($query->num_rows() > 0){    
            $this->db->set('timings', 0);
            $this->db->set('has_done', 1);
            $this->db->where('timings >', 0)->where('timings <', $nows)->where('has_done',0)->update('admin_set_activity2');
            return true;
        }else{
            return false;
        }
    }


    


    function fetchContestants($memid, $params, $rowno, $rowperpage, $str, $sessions){
        $this->db->select('cons.id, cons.fname AS fname1, cons.lname AS lname1, pa.views, sw.dates, sw.banners, sw.id AS sw_id, pa.file1, pa.file2, pa.file3, pa.memid, pa.id AS idd, sw.overall_title, sw.prize1, sw.prize2, sw.prize3, sw.gift1, sw.gift2, sw.gift3, sw.banners, sw.dates')->from('pageant_activities pa');
        if($params!="noexpiry")
            $this->db->where('asa2.approved', 1)->where('pa.expired', 0)->where('sw.has_done', 0)->where('sw.close_prev_contestant', 0);

        if($sessions!="")
            $this->db->where('sw.session1', $sessions);

        if($memid != ""){
            $memids = substr($memid, 0, -4);
            $this->db->where('pa.memid', $memids);
        }
        if($str!=""){
            $srchs = "(cons.fname like '%$str%' OR cons.lname like '%$str%')";
            $this->db->where("$srchs");
        }
        if($rowperpage!="" || $rowno!="")
            $this->db->limit($rowperpage, $rowno);
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        $this->db->join('contestants cons', 'cons.id = pa.memid');
        $this->db->order_by('pa.id', 'desc');
        $this->db->group_by('pa.memid');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    

    function fetchAllContestantsPics($memid){
        $this->db->select('pa.title1, pa.title2, pa.title3, pa.file1, pa.file2, pa.file3, sw.overall_title')->from('pageant_activities pa');
        $this->db->where('pa.memid', $memid);
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        $this->db->order_by('pa.id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchContestants_src($names){
        $this->db->select('cons.id, cons.fname AS fname1, cons.lname AS lname1, sw.dates, sw.id AS sw_id, pa.file1, pa.file2, pa.file3, pa.memid, sw.overall_title, sw.prize1, sw.prize2, sw.prize3, sw.gift1, sw.gift2, sw.gift3, sw.banners, sw.dates')->from('pageant_activities pa');
        if($names!=""){
            $srchs = "(cons.fname like '%$names%' OR cons.lname like '%$names%')";
            $this->db->where("$srchs");
        }
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        $this->db->join('contestants cons', 'cons.id = pa.memid');
        $this->db->order_by('pa.id', 'desc');
        $this->db->group_by('pa.memid');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    
    function fetchEventComment($id){
        $this->db->select('names, replies, dates')->from('comments');
        $this->db->where('event_id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    
    function check_next_activity(){
        $this->db->select('id, banners, overall_title, prize1, prize2, prize3, gift1, gift2, gift3, dates, enable_reg, disable_reg')->from('set_weekly_activity');
        //$this->db->where('approved', 0)->where('has_done', 0)->where('close_prev_contestant', 0)->where('overall_title !=', '')->where('banners !=', '');
        $this->db->where('has_done', 0)->where('close_prev_contestant', 0)->where('overall_title !=', '')->where('banners !=', '');
        $this->db->limit(1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return "";
        }
    }

    
    function fetchTheWinnerIs($memid, $limits){
        $this->db->select('wis.id, sw.id AS sw_id, sw.overall_title, pa.file1, cons.pics, cons.statee, wis.memid, wis.votes, wis.likes, wis.g_score, wis.j_score, wis.over_all, sw.overall_title, wis.positns, sw.dates, wis.dates AS date1')->from('winneris wis');
        if($limits!="")
            $this->db->limit(1000, 3);
        if($memid!="")
            $this->db->where('wis.memid', $memid);
        $this->db->where('wis.approved', 1);
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = wis.activity_id');
        $this->db->join('pageant_activities pa', 'pa.activity_id = asa2.id');
        $this->db->join('set_weekly_activity sw', 'sw.id = wis.activity_id');
        $this->db->join('contestants cons', 'cons.id = wis.memid');
        $this->db->order_by('wis.over_all', 'asc');
        $this->db->group_by('wis.memid');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function countWinners($memid){
        $this->db->select('count(wis.id) as allcount')->from('winneris wis');
        $this->db->where('pa.memid', $memid);
        $this->db->where('wis.approved', 1);
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = wis.activity_id');
        $this->db->join('pageant_activities pa', 'pa.activity_id = asa2.id');
        $this->db->join('set_weekly_activity sw', 'sw.id = wis.activity_id');
        $this->db->join('contestants cons', 'cons.id = wis.memid');
        $this->db->order_by('wis.over_all', 'desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }


    
    function totlQuestions($sess){
        $this->db->select('count(qu.id) as allcount')->from('quizes qu');
        $this->db->where('qu.sessions1', $sess);
        $this->db->where('qi.aprvd', 1);
        $this->db->join('quizes_intro qi', 'qi.sessions1 = qu.sessions1');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }



    function countContestantsCats(){
        //$this->db->select('count(cons.id) as allcount')->from('pageant_activities pa');
        $this->db->select('count(DISTINCT(pa.memid)) as allcount')->from('pageant_activities pa');
        $this->db->where('asa2.approved', 1);
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        $this->db->join('contestants cons', 'cons.id = pa.memid');
        //$this->db->group_by('pa.memid');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }


    function fetchContestantsCats($sessions, $txt_srch, $rowno, $rowperpage){
        $this->db->select('cons.id, sw.dates, sw.id AS sw_id, pa.views, pa.file1, pa.file2, pa.file3, pa.memid, sw.overall_title')->from('pageant_activities pa');
        $this->db->where('asa2.approved', 1);
        if($sessions!=""){
            $this->db->where('sw.session1', $sessions);
        }else{
            if($txt_srch!=""){
                $srchs = "(cons.fname like '%$txt_srch%' OR cons.lname like '%$txt_srch%')";
                $this->db->where("$srchs");
            }
        }
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        $this->db->join('contestants cons', 'cons.id = pa.memid');
        if($rowperpage!="" || $rowno!="")
            $this->db->limit($rowperpage, $rowno);
        $this->db->group_by('pa.memid');
        $this->db->order_by('sw.has_done', 'asc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchContestants_id($memid){
        $this->db->select('pa.id')->from('pageant_activities pa');
        $this->db->where('asa2.approved', 1)->where('pa.expired', 0)->where('sw.has_done', 0)->where('sw.close_prev_contestant', 0);
        $this->db->where('pa.memid', $memid)->where('pa.file1 !=', '');
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        //$this->db->group_by('pa.memid');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchContestants_id_no_expiry($memid){
        $this->db->select('pa.id')->from('pageant_activities pa');
        //$this->db->where('asa2.approved', 1)->where('pa.expired', 0)->where('sw.has_done', 0)->where('sw.close_prev_contestant', 0);
        $this->db->where('pa.memid', $memid)->where('pa.file1 !=', '');
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        //$this->db->group_by('pa.memid');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function fetchContestants_pics($id){
        $this->db->select('sw.id, pa.memid, pa.file1, pa.file2, pa.file3, pa.title1, pa.title2, pa.title3, pa.descrip1, pa.descrip2, pa.descrip3')->from('pageant_activities pa');
        $this->db->where('asa2.approved', 1)->where('pa.expired', 0)->where('sw.has_done', 0)->where('sw.close_prev_contestant', 0);
        $this->db->where('pa.id', $id);
        $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        //$this->db->group_by('pa.memid');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    

    
    function contestantName($id){
        $this->db->select('fname, lname')->from('contestants')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $fnames = $query->row('fname');
            $lnames = $query->row('lname');
            $ful1 = "$fnames $lnames";
            return ucwords($ful1);
        }else
            return "";
    }


    function contestantState($id){
        $this->db->select('statee')->from('contestants')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $statee = $query->row('statee');
            return ucwords($statee);
        }else
            return "";
    }

    
    function profilePics($id){
        $this->db->select('pics')->from('contestants')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $pics = $query->row('pics');
            return $pics;
        }else
            return "";
    }

    function profilePics1($id){
        $memid = substr($id, 0, -4);
        $this->db->select('pics')->from('contestants')->where('id', $memid);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $pics = $query->row('pics');
            return $pics;
        }else
            return "";
    }
    


    function getMemID(){
        $store_easer_usrs = $this->input->cookie('my_usernames', TRUE);
        $store_easer_pas1 = $this->input->cookie('my_passwords', TRUE);
        $this->db->select('id')->from('contestants')->where("(sha1(emails)='$store_easer_usrs' or sha1(phones)='$store_easer_usrs')")->where('pass', $store_easer_pas1)->where('approved', 1);
        $this->db->limit(1);
        $query = $this->db->get();
            $id = $query->row('id');
        if($query->num_rows() > 0)
            return $id;
        else
            return false;
    }



    function getCommenterPics($id){
        $this->db->select('picx')->from('contestants')->where('id', $id);
        //$this->db->limit(1);
        $query = $this->db->get();
            $picx = $query->row('picx');
        if($query->num_rows() > 0)
            return $picx;
        else
            return false;
    }



    function getCountries(){
        $this->db->select('*');
        $this->db->from('countries');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function getStates($ids){
        $this->db->select('*');
        $this->db->from('states')->where('country_id', $ids);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function getCities($ids){
        $this->db->select('*');
        $this->db->from('cities')->where('state_id', $ids);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function check_link_id($url){
        $this->db->select('id')->from('admin_set_activity2')->where('md5(id)', $url);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function check_link_id1($url){
        $this->db->select('id')->from('set_weekly_activity')->where('md5(id)', $url);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    function getSession($id){
        $this->db->select('session1')->from('set_weekly_activity')->where('md5(id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('session1');
        }else{
            return "";
        }
    }


    function getCountryID($names){
        $query = $this->db->get_where('countries', array('name'=>$names));
        if ($query->num_rows() > 0)
            return $query->row('id');
       else
           return false;
    }

    function getStateID($names){
        $query = $this->db->get_where('states', array('name'=>$names));
        if ($query->num_rows() > 0)
            return $query->row('id');
       else
           return false;
    }

    function getCityID($names){
        $query = $this->db->get_where('cities', array('name'=>$names));
        if ($query->num_rows() > 0)
            return $query->row('id');
       else
           return false;
    }



    function bringPics($id){
        $this->db->select('id, files');
        $this->db->from('events_media')->where('md5(event_id)', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function replyCounts($id){
        $this->db->select('count(id) as allcount')->from('forum_reply');
        $this->db->where('forum_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function totalCounts($tbl){
        $this->db->select('count(id) as allcount')->from($tbl);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function fetchCommentCounts($id){
        $this->db->select('count(id) as allcount')->from('comments');
        $this->db->where('event_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }



    
    function fetchRecords($tbls){
        if($tbls == "contestants")
            $this->db->select('fname, lname, approved, phones, statee, gender, dates');
        if($tbls == "set_weekly_activity")
            $this->db->select('overall_title, approved, one_week_timings, has_done, dates');
        $this->db->from($tbls);
        $this->db->order_by('id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }



    function updateViews($id, $nodes1, $params){
        $this->db->select('views')->from($nodes1)->where('id', $id);
        $query = $this->db->get();
        $views1 = $query->row('views');
        if($views1==null || $views1=="") $views1=0;
        $this->db->set('views', $views1+1);
        $query1 = $this->db->where('id',$id)->update($nodes1);
        return true;
    }




    function fetchCmtCounts($prod_id){
        $this->db->select('count(comments.id) as allcount')->from('comments');
        $this->db->where('post_id', $prod_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function fetchCmtCounts_adm($id){
        $this->db->select('count(avc.id) as allcount')->from('adm_video_cmts avc');
        $this->db->where('avc.vid_id', $id);
        //$this->db->join('adm_videos av', 'av.id = avc.vid_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function getLogsCount($id, $user_types){
        $this->db->select('count(logs.id) as allcount')->from('logs');
        $this->db->where('user_types', $user_types)->where('sha1(memid)', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }


    function isUseQuests($tbl, $url_task){
        $this->db->select('sessions1')->from($tbl)->where('sessions1', $url_task);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row('sessions1');
        }
    }


    
    var $order_column = array(null, "*");


    function make_datatables($tbls, $params, $params2){
        $this->fetchUsers($tbls, $params, $params2);
        if($_POST["length"] != -1){
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }
    

    public function get_filtered_data($tbls, $params){
        $this->fetchUsers($tbls, '', '');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data($tbls){
        $this->db->select("*");
        $this->db->from($tbls);
        return $this->db->count_all_results();
    }


    function fetchUsers($tbls, $params, $params2){
        $nowtime = time();
        $txtsrchs = $_POST['search']['value'];

        if($tbls=="set_weekly_activity"){
            $this->db->select('sw.id, sw.session1, sw.approved, sw.overall_title, sw.close_prev_contestant, sw.one_week_timings, sw.has_done, sw.instructn,
            sw.disqualificatn, sw.dates, sw.prize1, sw.prize2, sw.prize3, sw.gift1, sw.gift2, sw.gift3, sw.banners, sw.enable_reg, sw.disable_reg');
            $this->db->from('set_weekly_activity sw');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(overall_title like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }
        
        if($tbls=="contestants"){
            $this->db->select('*');
            $this->db->from($tbls);
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(fname like '%$txtsrchs%' OR lname like '%$txtsrchs%' OR phones like '%$txtsrchs%' OR statee like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }

        if($tbls=="events"){
            $this->db->select('*');
            $this->db->from($tbls);
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(titles like '%$txtsrchs%' OR year like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }

        if($tbls=="paid_users"){
            $this->db->select('pu.id AS ids, sw.overall_title, con.fname, con.lname, pu.dates');
            $this->db->from("paid_users pu");
            $this->db->join('set_weekly_activity sw', 'sw.id = pu.activity_id');
            $this->db->join('contestants con', 'con.id = pu.memid');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.fname like '%$txtsrchs%' OR con.lname like '%$txtsrchs%' OR sw.overall_title like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('pu.id', 'desc');
        }

        if($tbls=="forums"){
            $this->db->select('frm.id AS ids, frm.topics, frm.messages, frm.files, frm.views, con.fname, con.lname, frm.dates');
            $this->db->from("forums frm");
            $this->db->join('contestants con', 'con.id = frm.memid');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.fname like '%$txtsrchs%' OR con.lname like '%$txtsrchs%' OR frm.messages like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('frm.id', 'desc');
        }

        if($tbls=="forum_reply"){
            $this->db->select('frs.id AS ids, frm.memid AS memid1, frm.messages, frs.replies, frs.files, con.fname, con.lname, frs.dates');
            $this->db->from("forum_reply frs");
            $this->db->join('contestants con', 'con.id = frs.memid');
            $this->db->join('forums frm', 'frm.id = frs.forum_id');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.fname like '%$txtsrchs%' OR con.lname like '%$txtsrchs%' OR frs.replies like '%$txtsrchs%' OR frm.messages like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('frs.id', 'desc');
        }

        if($tbls=="winneris"){
            $this->db->select('ww.id AS ids, con.fname, con.lname, sw.overall_title, ww.positns, ww.approved, ww.votes, ww.likes, ww.g_score, ww.j_score, ww.over_all, ww.dates');
            $this->db->from("winneris ww");
            if($params=="")
            $this->db->where('sw.close_prev_contestant', 0);
            $this->db->join('set_weekly_activity sw', 'sw.id = ww.activity_id');
            $this->db->join('contestants con', 'con.id = ww.memid');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.fname like '%$txtsrchs%' OR con.lname like '%$txtsrchs%' OR sw.overall_title like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            //$this->db->group_by('vts.contestant_id');
            $this->db->order_by('ww.over_all', 'desc');
        }


        if($tbls=="fund_wallet_logs"){
            $this->db->select('*');
            $this->db->from("fund_wallet_logs");
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(names like '%$txtsrchs%' OR phone like '%$txtsrchs%' OR amts like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }


        if($tbls=="quizes"){
            $this->db->select('id, questions, files, op1, op2, op3, op4, op5, ans1');
            $this->db->from($tbls);
            if($params2 > 0)
                $this->db->where('sessions1', $params2);
            else
                $this->db->where('sessions1', $params);
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(questions like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }


        if($tbls=="gallery_vid"){
            $this->db->select('id, titles, views, files, media_type, dates');
            $this->db->from($tbls);
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(titles like '%$txtsrchs%' OR media_type like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('id', 'desc');
        }


        if($tbls=="quizes_intro"){
            $this->db->select('qi.id AS ids, asa2.titles, qi.sessions1, qi.aprvd, qi.completeds, qi.set_time, qi.timings, qi.dates');
            $this->db->from("quizes_intro qi");
            $this->db->join('admin_set_activity2 asa2', 'asa2.id = qi.activity_id');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(asa2.titles like '%$txtsrchs%' OR asa2.for_days like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('qi.id', 'desc');
        }


        if($tbls=="pageant_activities"){
            $this->db->select('pa.id as ids, sw.overall_title, con.fname, con.lname, con.gender, pa.activity_id AS act_id, asa2.day_instructns, pa.file1, pa.file2, pa.file3, pa.title1, pa.title2, pa.title3, pa.descrip1, pa.descrip2, pa.descrip3, pa.what_day, pa.brief_expr, pa.scores, pa.scores2, pa.scores3');
            $this->db->from("pageant_activities pa")->where('con.approved', 1);
            $this->db->join('contestants con', 'con.id = pa.memid');
            $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
            $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(con.fname like '%$txtsrchs%' OR con.lname like '%$txtsrchs%' OR sw.overall_title like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('pa.id', 'desc');
        }


        if($tbls=="all_votes"){
            $this->db->select('vts.id AS ids, st.id AS stid, vts.contestant_id, vts.phones AS phn, vts.amt_paid, con.fname, con.lname, st.overall_title');
            $this->db->from('all_votes vts')->where('con.approved', 1);
            $this->db->join('contestants con', 'con.id = vts.contestant_id');
            $this->db->join('set_weekly_activity st', 'st.id = vts.activity_id');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(voters_email like '%$txtsrchs%' OR overall_title like '%$txtsrchs%' OR fname like '%$txtsrchs%' OR lname like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->order_by('vts.id', 'desc');
        }

        if($tbls=="all_votes1"){
            $this->db->select('vts.id AS ids, st.id AS stid, vts.contestant_id, con.fname, con.lname, st.overall_title');
            $this->db->from('all_votes vts')->where('con.approved', 1);
            $this->db->join('contestants con', 'con.id = vts.contestant_id');
            $this->db->join('set_weekly_activity st', 'st.id = vts.activity_id');
            if(isset($txtsrchs) && $txtsrchs!=""){
                $srchs = "(overall_title like '%$txtsrchs%' OR fname like '%$txtsrchs%' OR lname like '%$txtsrchs%')";
                $this->db->where("$srchs");
            }
            $this->db->group_by('vts.contestant_id');
            $this->db->order_by('vts.id', 'desc');
        }
    }



    
    function approveActi($session1, $params, $game_type, $tbl){
        if($tbl == "set_weekly_activity"){
            $query = $this->db->get_where($tbl, array('session1' => $session1));
            if ($query->num_rows() > 0){
                $approved = $query->row()->approved;
                if($approved == 0){
                    
                    if($this->check_expired_game()){
                        $seven_weeks = time()+604800; // 7 days

                        $this->db->set('has_done', 1); // this 3 lines of code is to set everything to done and closed b4 setting new one
                        $this->db->set('close_prev_contestant', 1);
                        $this->db->update($tbl);

                        $this->db->where('session1',$session1);
                        $this->db->set('approved', 1);
                        $this->db->set('has_done', 0);
                        $this->db->set('close_prev_contestant', 0);
                        $this->db->set('one_week_timings', $seven_weeks);
                        $this->db->update($tbl);

                        ///////////////////////////////////////////////
                        $this->db->select('time_duratn')->from('admin_set_activity2')->where('session1',$session1);
                        $query = $this->db->get();
                        $time_duratn = $query->row('time_duratn');

                        $this->db->select('overall_title')->from('set_weekly_activity')->where('session1',$session1);
                        $query = $this->db->get();
                        $titles = ucwords($query->row('overall_title'));

                        $hours_set = time() + (60*60*$time_duratn); // 7 days
                        $this->db->where('session1',$session1);
                        //$this->db->set('approved', 1); // i removed this bcos the admins will approve it manually in the day to day activities
                        $this->db->set('has_done', 0);
                        $this->db->set('dates', @date("Y-m-d g:i a", time()));
                        $this->db->update("admin_set_activity2");
                        ///////////////////////////////////////////////

                        //// send emails to members /////
                            $mem_emails = $this->getMembersEmails();
                            $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='http://www.ourfavcelebs.com/images/logo1.png'></div>";
                            $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello Contestant,</b></p>";
                            $message_contents .= "<p style='font-size:14px; margin-top:10px'>OurFavCelebs activity \"$titles\" is
                            now opened for you to pertake. This is the opportunity you have been waiting for. Go to the platform now
                            and win a chance to be part of the amazing competition and you could be one of the lucky winners. </p>";
            
                            $message_contents .= "<p style='font-weight:normal;'><a href='http://www.ourfavcelebs.com/pages/#participants' style='color:#0066FF' target='_blank'>www.ourfavcelebs.com/pages/#participants</a></p>";
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
                                'from' => "OurFavCelebs Activities <info@ourfavcelebs.com>",
                                'to' => 'Undisclosed Recipient <info@ourfavcelebs.com>',
                                'bcc' => $mem_emails,
                                'subject' => "OurFavCelebs Game Activity Is Now Opened",
                                'html' => $message_contents
                            ));
                            $result = curl_exec($ch);
                            curl_close($ch);
                        //// send emails to members /////

                        return 1;
                    }else{
                        return 2; // nt expired
                    }

                }else{

                    $this->db->where('session1',$session1);
                    $this->db->set('approved', 0);
                    $this->db->set('one_week_timings', 0);
                    $this->db->update($tbl);
                    ///////////////////////////////////////////////

                    $this->db->where('session1',$session1);
                    $this->db->set('approved', 0);
                    $this->db->set('timings', 0);
                    $this->db->update("admin_set_activity2");
                    ///////////////////////////////////////////////
                    return 0;
                }
                
            }
        }

        if($tbl == "admin_set_activity2"){
            $this->db->select('id')->from("set_weekly_activity")->where('session1',$params)->where('approved', 1); //approved
            $query = $this->db->get();
            if($query->num_rows() <= 0){ // the main activity is approved
                return 2; // main one not approved
            }else{

                if($game_type=="qz"){ // if its quiz game, check if quiz is ready
                    $this->db->select('id')->from($tbl)->where('session1',$params);
                    $this->db->where('quiz_intro_id >', 0); //approved
                    $query = $this->db->get();
                    if($query->num_rows() > 0){

                        $query = $this->db->get_where($tbl, array('id' => $session1));
                        if ($query->num_rows() > 0){
                            $this->db->select('quiz_intro_id, time_duratn, starting_from')->from($tbl)->where('id',$session1);
                            $query = $this->db->get();
                            $time_duratns = $query->row('time_duratn');
                            $starting_from = $query->row('starting_from');
                            $quiz_intro_id1 = $query->row('quiz_intro_id');

                            $this->db->select('set_time')->from("quizes_intro")->where('id', $quiz_intro_id1);
                            $query1 = $this->db->get();
                            $set_times = $query1->row('set_time');

                            $timestamp = strtotime($starting_from.':00:00 pm');
                            $minutes_set = strtotime("+$set_times minute", $timestamp);
                            
                            $this->db->where('id', $quiz_intro_id1);
                            $this->db->set('aprvd', 1);
                            $this->db->set('timings', $minutes_set);
                            $this->db->update("quizes_intro");

                            $timestamp1 = strtotime($starting_from.':00:00 pm');
                            $hours_set1 = strtotime("+$time_duratns hour", $timestamp1);

                            $this->db->where('id',$session1);
                            $this->db->set('approved', 1);
                            $this->db->set('timings', $hours_set1);
                            $this->db->set('starting_from1', $timestamp1);
                            //$this->db->set('dates', @date("Y-m-d g:i a", time()));
                            $this->db->set('dates', time());
                            $this->db->update($tbl);
                            ///////////////////////////////////////////////

                            $timestamp = strtotime($starting_from.':00:00 pm');
                            $hours_set1 = strtotime("+$time_duratns hour", $timestamp);
                            $hours_set2 = date("h:i a", $hours_set1);

                            return $hours_set2;
                        }else{
                            return 0;
                        }
                    }else{
                        return 5; // quiz not ready
                    }

                }else{ // not a quiz game
                    
                    $this->db->select('time_duratn, starting_from')->from('admin_set_activity2')->where('id', $session1);
                    $query = $this->db->get();
                    if($query->num_rows() > 0){
                        //$this->db->select('time_duratn, starting_from')->from('admin_set_activity2')->where('id', $session1);    
                        $time_duratns = $query->row('time_duratn');
                        $starting_from = $query->row('starting_from');

                        $timestamp1 = strtotime($starting_from.':00:00 pm');
                        $hours_set1 = strtotime("+$time_duratns hour", $timestamp1);

                        $this->db->where('id',$session1);
                        $this->db->set('approved', 1);
                        $this->db->set('timings', $hours_set1);
                        $this->db->set('starting_from1', $timestamp1);
                        $this->db->set('dates', time());
                        $this->db->update($tbl);
                        ///////////////////////////////////////////////

                        $timestamp = strtotime($starting_from.':00:00 pm');
                        $hours_set1 = strtotime("+$time_duratns hour", $timestamp);
                        $hours_set2 = date("h:i a", $hours_set1);

                        return $hours_set2;
                    }else{
                        return 0;
                    }
                }
            }
        }

        
        if($tbl == "contestants"){
            $query = $this->db->get_where($tbl, array('id' => $session1));
            if ($query->num_rows() > 0){
                $approved = $query->row()->approved;
                if($approved == 0){
                    $this->db->where('id', $session1)->update($tbl, array('approved' => 1, 'paid' => 1));

                    $this->db->select('sw.id')->from('set_weekly_activity sw');
                    $this->db->where('close_prev_contestant', 0)->where('has_done', 0)->where('sw.one_week_timings >', 0)->where('approved', 1);
                    $query = $this->db->get();
                    $act_id = 0;
                    if($query->num_rows() > 0){
                        $act_id = $query->row('id');
                    }
                    $data = array(
                        'memid'         => $session1,
                        'activity_id'   => $act_id,
                        'dates'         => @date("Y-m-d g:i a", time())
                    );
                    $this->db->insert('paid_users', $data);
                    return 1;
                }else{
                    $this->db->where('id', $session1)->update($tbl, array('approved' => 0));
                    return 0;
                }
            }
        }

    }


    function getMembersEmails(){
        $this->db->select('ba.emails');
        $this->db->from('pageant_activities pa');
        $this->db->where('ba.paid', 1)->where('ba.approved', 1);
        $this->db->join('contestants ba', 'ba.id = pa.memid');
        $this->db->group_by('pa.memid');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $all_mails = "";
            $query2 = $query->result_array();
            foreach ($query2 as $row) {
                $emails = $row['emails'];
                $all_mails .= "'$emails', ";
            }
            $all_mails1 = substr($all_mails, 0, -2);
            return $all_mails1;
        }else{
            return false;
        }
    }


    function closeActi($session1, $tbl){
        $this->db->where('session1',$session1);
        $this->db->set('has_done', 1);
        $this->db->set('close_prev_contestant', 1);
        $this->db->update($tbl);
        ///////////////////////////////////////////////

        $this->db->where('session1',$session1);
        $this->db->set('has_done', 0);
        $this->db->set('timings', 0);
        $this->db->update("admin_set_activity2");
        ///////////////////////////////////////////////
        return true;
    }





    public function getMembersDetails($emailx, $txtadmin_id){
        $this->db->select('id, fname, lname');
        $this->db->from('contestants');
        $this->db->where('emails', trim($emailx));
        $this->db->where('id !=', $txtadmin_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }



    public function getMembersID($txtadmin_id){
        $this->db->select('id');
        $this->db->from('contestants');
        //$this->db->where('approved', 1);
        $this->db->where('id !=', $txtadmin_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('id');
        else
            return false;
    }


    public function getMembersIDs(){
        $this->db->select('id');
        $this->db->from('contestants');
        $this->db->where('approved', 1)->where('paid', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    
    public function getPrevQuestions(){
        $this->db->select('sw.overall_title, qi.dates, qi.sessions1');
        $this->db->from('quizes_intro qi');
        //$this->db->where('approved', 1)->where('paid', 1);
        $this->db->join('quizes qz', 'qz.sessions1 = qi.sessions1');
        $this->db->join('admin_set_activity2 asa', 'asa.id = qi.activity_id');
        $this->db->join('set_weekly_activity sw', 'sw.session1 = asa.session1');
        $this->db->group_by('sw.overall_title');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    public function getEventPics($tbl, $id){
        $this->db->select('files');
        $this->db->from($tbl);
        $this->db->where('event_id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    public function searchStr($keyword) {
        $this->db->select('fname, lname, emails');
        $this->db->order_by('id', 'DESC');
        $this->db->like('fname', $keyword);
        $this->db->or_like('lname', $keyword, 'both');
        $this->db->or_like("emails", $keyword, 'both');
        $this->db->or_like("countrys", $keyword, 'both');
        return $this->db->get_where('contestants', array('approved'=>1))->result_array();
    }


    // public function checkRequested($id){
    //     $this->db->select('id');
    //     $this->db->from('submit_payments');
    //     $this->db->where('requested_payme', 1);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0)
    //         return true;
    //     else
    //         return false;
    // }


    public function getMembersID_selected($txtadmin_id){
        $this->db->select('id, emails, fname, lname');
        $this->db->from('contestants');
        //$this->db->where('approved', 1);
        $this->db->where('id', $txtadmin_id);
        $this->db->where("ba.session1", 10991);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }


    
    // public function auth_session_ids($sess_ids){
    //     $this->db->where('session1', $sess_ids);
    //     //$this->db->or_where('session1', 10991);
    //     $q = $this->db->get('contestants');
    //     if($q->num_rows()>0){   
    //         $this->db->where('session1',$sess_ids);
    //         $this->db->set('session1', 10991);
    //         $this->db->update('contestants');
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }




    public function getOneComment($id){
        $this->db->select('ba.id AS id, ba.id, cmt.cmts, ba.fname, ba.lname, ba.picx');
        $this->db->from('comments cmt');
        $this->db->where('cmt.post_id', $id);
        $this->db->join('contestants ba', 'ba.id = cmt.memid');
        $this->db->order_by('cmt.id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }


    

    // function check_email_validity1($data){
    //     $email = $data['voters_email'];
    //     $acti_id = $data['activity_id'];
    //     $cont_id = $data['contestant_id'];
    //     $this->db->select('id')->from('all_votes')->where('voters_email', $email)->where('activity_id', $acti_id)->where('contestant_id', $cont_id)->where('email_code >', 0);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    

    function already_voted1($data){
        $acti_id = $data['activity_id'];
        $cont_id = $data['contestant_id'];
        $phones = $data['phones'];
        $amt_paid = $data['amt_paid'];
        $ipaddrs = $_SERVER['REMOTE_ADDR'];
        $this->db->select('id')->from('all_votes')->where('activity_id',$acti_id)->where('contestant_id',$cont_id);
        $this->db->where('ip_addrs', $ipaddrs)->where('phones', $phones)->where('amt_paid', $amt_paid);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    function check_pending_payment($ipaddr, $phone, $amts){
        // $acti_id = $data['activity_id'];
        // $cont_id = $data['contestant_id'];
        // $phones = $data['phones'];
        // $amt_paid = $data['amt_paid'];
        // $this->db->select('id')->from('all_votes')->where('activity_id', $acti_id)->where('contestant_id', $cont_id);
        // $this->db->where('phones', $phones)->where('amt_paid', $amt_paid)->where('activated', 0)->where('paid', 0);
        // $query = $this->db->get();
        // if($query->num_rows() > 0){
        //     return true;
        // }else{
        //     return false;
        // }

        $this->db->select('id')->from('fund_wallet')->where('phone', $phone)->where('ipaddrs', $ipaddr);
        $this->db->where('amts <', $amts);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    
    function already_voted($data){
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        $acti_id = $data['activity_id'];
        $conte_id = $data['contestant_id'];
        //$this->db->select('id')->from('all_votes')->where('voters_email', $email)->where('activity_id', $acti_id)->where('contestant_id', $conte_id);
        $this->db->select('id')->from('all_votes')->where('ip_addrs', $ipaddr)->where('activity_id', $acti_id)->where('contestant_id', $conte_id)->where('amt_paid', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    // function already_voted1($data){
    //     $email = $data['voters_email'];
    //     $acti_id = $data['activity_id'];
    //     $conte_id = $data['contestant_id'];
    //     $this->db->select('id')->from('all_votes')->where('voters_email', $email)->where('activity_id', $acti_id)->where('contestant_id', $conte_id)->where('paid', 1);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // function check_already_voted($data){
    //     $email = $data['voters_email'];
    //     $acti_id = $data['activity_id'];
    //     $conte_id = $data['contestant_id'];
    //     $this->db->select('id')->from('all_votes')->where('voters_email', $email)->where('activity_id', $acti_id)->where('contestant_id', $conte_id)->where('paid', 0)->where('activated', 1);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    function check_code_validity($txtvote_code, $txtvote_email, $acti_id){
        $this->db->select('id')->from('all_votes')->where('voters_email', $txtvote_email)->where('activity_id', $acti_id)->where('email_code >', 0)->where('email_code', $txtvote_code);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    function check_valid_code($codes, $mails){
        $this->db->select('id')->from('email_verificatn')->where('emails', $mails)->where('codes', $codes)->where('codes >', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    function update_codes($codes, $mails){
        $this->db->set('status', 1);
        $this->db->set('codes', 0);
        $this->db->where('codes', $codes)->where('codes >', 0)->where('emails', $mails)->update('email_verificatn');
    }


    function update_voters($txtvote_code, $txtvote_email, $acti_id){
        $this->db->select('votes')->from('all_votes')->where('email_code >', 0)->where('email_code', $txtvote_code)->where('voters_email', $txtvote_email)->where('activity_id', $acti_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $votes1 = $query->row('votes');
            if($votes1==null || $votes1=="") $votes1=0;
            $this->db->set('votes', $votes1+1);
            //$this->db->set('(activated)', 1);
            $this->db->set('activated', 1);
            $this->db->set('paid', 1);
            $this->db->set('email_code', 0);
            $this->db->where('email_code', $txtvote_code)->where('voters_email', $txtvote_email)->where('activity_id', $acti_id)->update('all_votes');
        }
        return $votes1+1;
    }

    

    public function joinBM($id){
        $this->db->select('dates');
        $this->db->from('contestants');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return time_ago($query->row('dates'));
        else
            return false;
    }




    function update_inserts_members($data, $email, $phone, $txtmember){
        if($txtmember != "")
            $query1 = $this->db->where('emails',$email)->where('phones', $phone)->update('contestants', $data);
        else
            $query1 = $this->db->insert('contestants', $data);
        if($query1) return true; else return false;
    }


    function update_inserts_quizes($data, $quiz_ids, $new_name4, $txtquizid){
        if($quiz_ids != ""){
            $query1 = $this->db->where('id', $txtquizid)->update('quizes', $data);
            if($query1)
            return "updated2_".$new_name4;
            else
            return 2;
        }else{
            $query1 = $this->db->insert('quizes', $data);
            return "inserted";
        }
    }


    function update_insert_forum($data, $edit_ids){
        $topics = $data['topics'];
        $messages = $data['messages'];
        $memid = $data['memid'];
        if($edit_ids != ""){
            $query1 = $this->db->where('id', $edit_ids)->update('forums', $data);
            if($query1)
                return "updateds";
            else
                return false;
        }else{
            $this->db->select('id');
            $this->db->from('forums');
            $this->db->where('topics', $topics)->where('memid', $memid)->where('messages', $messages);
            $query = $this->db->get();
            if($query->num_rows() <= 0)
                $query1 = $this->db->insert('forums', $data);
            return "inserted";
        }
    }


    function update_insert_forum_reply($data, $edit_ids){
        $replies = $data['replies'];
        $memid = $data['memid'];
        $this->db->select('id');
        $this->db->from('forum_reply');
        $this->db->where('memid', $memid)->where('replies', $replies);
        $query = $this->db->get();
        if($query->num_rows() <= 0)
            $query1 = $this->db->insert('forum_reply', $data);
        return "inserted";
    }

    
    function insert_activities($data){
        $query1 = $this->db->insert('pageant_activities', $data);
        if($query1) return true; else return false;
    }



    function insert_comments($data){
        $prod_id = $data['post_id'];
        $query1 = $this->db->insert('comments', $data);

        $this->db->select('ba.id AS id, ba.id, cmt.dates, cmt.cmts, ba.fname, ba.lname, ba.picx');
        $this->db->from('comments cmt');
        $this->db->where('cmt.id', $prod_id);

        $this->db->join('contestants ba', 'ba.id = cmt.memid');
        $this->db->order_by('cmt.id','desc');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }



    
    function countVotes($memid, $sw_id, $params){
        if($params == "reformats")
            $memid = substr($memid, 0, -4);
        $this->db->select('vts.votes');
        $this->db->from('all_votes vts');
        $this->db->where('vts.activity_id', $sw_id)->where('vts.contestant_id', $memid);
        $this->db->join('contestants cons', 'cons.id = vts.contestant_id');
        $this->db->join('set_weekly_activity sw', 'sw.id = vts.activity_id');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $sums = 0;
            $query2 = $query->result_array();
            foreach ($query2 as $row) {
                $votes = $row['votes'];
                $sums+=$votes;
            }
            return $sums;
        }else{
            return 0;
        }
    }


    function countVoters($memid, $sw_id){
        $this->db->select('count(vts.contestant_id) as allcount')->from('all_votes vts');
        $this->db->where('vts.activity_id', $sw_id)->where('vts.contestant_id', $memid);
        $this->db->join('contestants cons', 'cons.id = vts.contestant_id');
        $this->db->join('set_weekly_activity sw', 'sw.id = vts.activity_id');
        //$this->db->group_by('pa.memid');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }


    function countContestants($param){
        $this->db->select('count(DISTINCT(pa.memid)) as allcount')->from('pageant_activities pa');
        if($param!="noexpiry"){ // no expiry
            $this->db->where('asa2.approved', 1)->where('pa.expired', 0)->where('sw.has_done', 0)->where('sw.close_prev_contestant', 0);
            $this->db->join('admin_set_activity2 asa2', 'asa2.id = pa.activity_id');
            $this->db->join('set_weekly_activity sw', 'sw.session1 = asa2.session1');
        }
        $this->db->join('contestants cons', 'cons.id = pa.memid', 'left');
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }


    function countMedias($media){
        $this->db->select('count(id) as allcount')->from('gallery_vid');
        $this->db->where('media_type', $media);
        $query = $this->db->get();
        $result = $query->result_array();
        return ($result ? $result[0]['allcount'] : 0);
    }



    function insert_update_likes($data, $dislike){
        $pics = $data['pics'];
        $ip_addrs = $data['ip_addrs'];
        $contestant_id = $data['contestant_id'];

        $this->db->select('likes')->from('picture_likes')->where('pics', $pics)->where('ip_addrs', $ip_addrs);
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $likes1 = $query->row('likes');
            if($likes1==null || $likes1=="") $likes1=0;
            if($dislike == 1)
                $this->db->set('likes', $likes1-1);
            else
                $this->db->set('likes', $likes1+1);
            $query1 = $this->db->where('pics', $pics)->where('contestant_id', $contestant_id)->update('picture_likes');

        }else{
            $query1 = $this->db->insert('picture_likes', $data);
        }

        $this->db->select('likes')->from('picture_likes')->where('pics', $pics)->where('ip_addrs', $ip_addrs)->where('contestant_id', $contestant_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row('likes');
        else
            return 0;
        //return ($query1 ? true : false);
    }


    
    function upload_cats1($data, $id){
        $this->db->where('id', $id);
        $q = $this->db->get('categorys');
        if ( $q->num_rows() > 0 ){
            $query1 = $this->db->where('id',$id)->update('categorys', $data);
        } else {
            $query1 = $this->db->set('id', $id)->insert('categorys', $data);
        }
        return $query1;
    }


    

}

?>