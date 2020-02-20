
    
    <script src="<?php echo base_url(); ?>js/jscripts1.js"></script>

    <script>
    $(".uploadimage_activity").on('submit',(function(e) {
        e.preventDefault();
        $(".err_div3").hide();
        $('.submit_activity_f').hide();
        $('.submit_activity_f1').show();
        var txtfirst_form = $('#txtfirst_form').val();
        
        if(txtfirst_form == "first"){

            $.ajax({
                type : "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                url : site_urls+"node/submit_activities_f",
                success : function(data){
                    if(data == 'done_confirm'){
                        $('.submit_activity_f').show();
                        $('.submit_activity_f1').hide();
                        $('.first_activity').hide();
                        $('.second_activity').show();
                        $(".err_div3").hide();
                        $('#txtfirst_form').val('second');
                        $("html, body").animate({ scrollTop: 200 }, "slow");

                    }else if(data == 'logged_out'){
                        $(".dashboard_div").hide();
                        $(".expireds").show();
                        $('.page_titl').html('Expired Session'+head_titles);

                    }else{
                        $(".err_div3").show().html('<div class="Errormsg Errormsgi">'+data+'</div>');
                        $('.submit_activity_f').show();
                        $('.submit_activity_f1').hide();
                        setTimeout(function(){
                            $(".err_div3").fadeOut('fast');
                        },5000);
                    }
                },error : function(data){
                    $('.submit_activity_f').show();
                    $('.submit_activity_f1').hide();
                    $(".err_div3").show().html('<div class="Errormsg Errormsgi">Poor Network Connection!</div>');
                    setTimeout(function(){
                        $(".err_div3").fadeOut('fast');
                    },5000);
                }
            });

        }

        if(txtfirst_form == "second"){
            $.ajax({
                type : "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                url : site_urls+"node/submit_activities",
                success : function(data){
                    $('.submit_activity_f').show();
                    $('.submit_activity_f1').hide();

                    if(data == 'done_submitted'){
                        $('.submit_activity').show();
                        $('.submit_activity1').hide();

                        $('.third_activity').show();
                        $('.second_activity').hide();
                        $(".err_div1").hide();
                        $('#txtfirst_form').val('first');

                    }else if(data == 'logged_out'){
                        $(".dashboard_div").hide();
                        $(".expireds").show();
                        $('.page_titl').html('Expired Session'+head_titles);

                    }else{
                        $(".err_div1").show().html('<div class="Errormsg Errormsgi">'+data+'</div>');
                        $('.submit_activity').show();
                        $('.submit_activity1').hide();
                        setTimeout(function(){
                            $(".err_div1").fadeOut('fast');
                        },5000);
                    }
                },error : function(data){
                    $('.submit_activity').show();
                    $('.submit_activity1').hide();
                    $('.submit_activity_f').show();
                    $('.submit_activity_f1').hide();
                    $(".err_div1").show().html('<div class="Errormsg Errormsgi">Poor Network Connection!</div>');
                    setTimeout(function(){
                        $(".err_div1").fadeOut('fast');
                    },5000);
                }
            });

        }
        
    }));
    </script>

    <?php 
    $fname="";$lname="";
    if($validate_mem){
        $fname = ucfirst($profile_details['fname']);
        $instructn = nl2br(ucfirst($my_main_acts['instructn']));
        $disqualificatn = nl2br(ucfirst($my_main_acts['disqualificatn']));
        $overall_title = ucwords($my_main_acts['overall_title']);
        $main_date1 = $my_main_acts['dates'];
        if($main_date1>0)
            $main_date = date("D jS M Y h:i a", $main_date1);
        else
            $main_date = "";

        $game_type = $game_title['game_type'];
        $for_days = $game_title['for_days'];
        $for_days_1 = $for_days;
        $set_time = $quiz_intro['set_time'];
        
        $qid = $quiz_quests['ids'];
        $qid_intro = $quiz_quests['id'];
        $questions = ucfirst($quiz_quests['questions']);
        $files = $quiz_quests['files'];
        $op1 = $quiz_quests['op1'];
        $op2 = $quiz_quests['op2'];
        $op3 = $quiz_quests['op3'];
        $op4 = $quiz_quests['op4'];
        $op5 = $quiz_quests['op5'];
        $ans1 = $quiz_quests['ans1'];
        $sessions1 = $quiz_quests['sessions1'];
        $op1_1=$op1;
        $op1_2=$op2;
        $op1_3=$op3;
        $op1_4=$op4;
        $op1_5=$op5;

        $already_started = $this->sql_models->already_started($get_mems_id, $qid_intro);

        $all_options = array($op1, $op2, $op3, $op4, $op5);
        if($op1!="" && $op2!="" && $op3=="" && $op4=="" && $op5=="") $all_options = array($op1, $op2);
        if($op1!="" && $op2!="" && $op3!="" && $op4=="" && $op5=="") $all_options = array($op1, $op2, $op3);
        if($op1!="" && $op2!="" && $op3!="" && $op4!="" && $op5=="") $all_options = array($op1, $op2, $op3, $op4);
        shuffle($all_options);

        $files1i="";
        if($files!=""){
            $paths = base_url()."quizes/$files";
            $files1i = "<div style='margin-bottom:15px' class='quiz_img'><img src='$paths' style='width:100%'></div>";
        }

        $addfont="";
        if(strlen($overall_title)<=20) $addfont = "incr_font";
    }
    ?>

<!-- <form id="countdown">
    <input id="tminus" placeholder="0:00" style="display:none" />
    <input id="request" value="'.$set_time.'" placeholder="Enter Minutes here" style="display:none" />
    <a href="#" class="button enterTime" style="display:none">Submit Time</a>
    <input type="button" id="resets" value="Clear form" style="display:none" />
</form> -->

    <section id="reach-to" class="dishes1 completed_profile welcome-part home-icon ash_color2" style="border-top:2px solid #eee; background:#111;">
        <div class="icon-default icon-default3_111">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
        </div>
        
        <div class="container contents1" id="gotohere">
            <div class="title text-center">
                <h2 class="text-coffee partci">Participants</h2>
                <p style="margin:-9px 0 34px 0; color:#ccc; font-size:15px; line-height:21px;">Please read the instructions and the activities specified by the admin and upload your pictures.</p>
            </div>
            
            <div class="row reg_form2">

                <div class="col-md-5 col-sm-5 col-xs-12 instructs">

                    <div class="activity_title <?=$addfont;?>" style="text-align:center">
                        <img src="<?php echo base_url(); ?>images/contestants.png" style="width:26px">
                        <?php if($overall_title=="") $overall_title = "No Activity Yet"; ?>
                        <b style="text-align:left !important"><?=$overall_title;?></b> &nbsp;<br>
                        <b style="font-size:15px; color:#ccc;"><?=$main_date;?></b>

                    </div>

                    <h4>OurFavCelebs Activities</h4>
                    <p style="margin:0 0 14px 0; font-size:20px; color:#00C161;"><b>Good day <?=$fname;?></b></p>
                    <p style="margin:0 0 7px 0; font-size:18px; color:#00C161;"><b>Instruction</b></p>
                    <p style="color:#00C161; font-sizes:15px;"><?=$instructn;?></p>

                    <ul>
                    <?php
                    $count_day_acts1 = 3 - $count_day_acts;
                    $nows = time();
                    if($my_acts){
                        if($my_acts_arr){
                            foreach ($my_acts_arr as $rs) {
                                $for_days = strtolower($rs['for_days']);
                                $day_instructns = ucfirst($rs['day_instructns']);
                                $timings = $rs['timings'];
                                $time_duratn = $rs['time_duratn'];
                                $starting_from = $rs['starting_from'];
                                $dates = $rs['dates2'];
                                $daily_title = ucwords($rs['titles']);
                                $dates1 = date("D jS M Y h:i a", strtotime($dates));
                                $dates1 = "<font style='font-size:13px; color:#F90;'>$dates1</font>";
                                $for_days=str_replace(array("mon", "tue", "wed", "thu", "fri", "sat", "sun"), array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"), $for_days);
                                if($for_days!="") $for_days="<b>$for_days:</b> $day_instructns"; else $for_days="**********";
                                
                                if($timings < $nows) // if expired
                                echo "<li><font style='color:#F77;'>**Expired**</font> <font style='opacity:0.6;'>$for_days <br><b><font style='color:#AFAF5F'>(Game Title: $daily_title<br>Duration: $time_duratn hours</b>, starting from $starting_from PM<br>Date Approved: $dates1)</font></font></li>";
                                else
                                echo "<li style='color:#ccc; font-size:14px !important;'>$for_days <br><b><font style='color:#AFAF5F; line-height:22px;'>(Game Title: $daily_title<br>Duration: $time_duratn hours, starting from $starting_from PM<br>Date Approved: $dates1)</font></b></li>";
                            }

                            for($i=0; $i<$count_day_acts1; $i++){
                                echo "<li style='colors:#888; opacity:0.6; font-style:italic;'>Next Activity Loading...</li>";
                            }
                        }else{
                            echo "<div style='margin-left:-10px;'>No activity yet!</div>";
                        }

                    }else{
                        echo "<div style='margin-left:-10px;'>No activity yet!</div>";
                    }
                    ?>
                    </ul>
                    <p style="margin:25px 0 7px 0; font-size:15px; color:#00C161; opacity:0.8; line-height:20px;"><b>Note:</b> <?=$disqualificatn;?></p>
                    <p style="margin:15px 0 7px 0; font-size:15px; color:#00C161; opacity:0.8; line-height:20px;">Picture formats: jpg, jpeg, png and Maximum Size: 4MB </p>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-12 apply_boder">
                
                </div>



                <div class="col-md-offset-1_ col-md-7 col-sm-7 col-xs-12">
                    <?php echo form_open_multipart('', array('id'=>'countdown', 'class'=>'form reg_form reg_form3 uploadimage_activity form_quizes', 'autocomplete'=>'off')); ?>
                        <div class="row scroll_stop">

                            <input type="hidden" name="txtfirst_form" id="txtfirst_form" value="first">

                            <div class="not_ready_activity" style="display:none">
                                <h3><img src="<?php echo base_url();?>images/game_title.jpg"></h3>
                                <p>
                                    <font style="display:block; margin-bottom:15px">Either you have finished this game or it has expired or no game available yet!</font>
                                    Please wait for the next activity to be activated. This notice will disappear immediately 
                                    another activity is set to be carried out.<br>
                                    We humbly thank you for your patience and we hope you be an alert.
                                </p>
                            </div>

                            
                            <?php if($check_act_complete==true || $check_game_complete==true){ ?>
                                <div class="not_ready_activity1" style="display:nones">  <!--remove display:none for php load-->
                                    <h3><img src="<?php echo base_url();?>images/game_title.jpg"></h3>
                                    <p>
                                        <font style="display:block; margin-bottom:15px">Either you have finished this game or it has expired or no game available yet!</font>
                                        Please wait for the next activity to be activated. This notice will disappear immediately 
                                        another activity is set to be carried out.<br>
                                        We humbly thank you for your patience and we hope you be an alert.
                                    </p>
                                </div>
                            <?php }else{ ?>

                                <div class="first_activity" style="display:nones"> <!--Loaded by default-->

                                    <?php if($game_type == "qz"){ ?>

                                        <div class="div_quiz" style="display:nones; color:#ccc; text-align:center;"> <!--This is loaded by default-->
                                            <h3><img src="<?php echo base_url();?>images/game_title.jpg"></h3>
                                            <h3 style="text-align:center; color:#00C161; font-size:16px !important; margin-top:-10px;">OurFavCelebs introduces fun games as part of the contest activities.</h3>

                                            
                                            <p>Hi <?=$fname;?>, please read the following instructions and proceed to participate in this game.<br>
                                            This is a fun game and each carries equal scores unless specified by the admin
                                                which will clearly be stated in the game.</p>

                                            <p style="margin-top:-6px">The time given for this game is <b style="color:#00C161; font-size:17px !important;"><?=$set_time;?> minutes.</b> The games are very simple but logical, just follow 
                                                the game and answer the questions where necessary!</p>

                                            <p style="margin-top:-6px">Once the game is started, there will be no option for going back to edit or make changes. Thank you!</p>

                                            <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:5px !important;">

                                                <?php
                                                if($already_started){
                                                    echo '<input value="Continue" id="contd_quiz" class="btn-black center-block" studid="<?=$get_mems_id;?>" type="button">';
                                                }else{
                                                ?>

                                                <input value="PROCEED" class="btn-black center-block cmd_proceed_activity" studid="<?=$get_mems_id;?>" type="button">
                                                <input value="PROCEED..." class="btn-black btn-blacks center-block cmd_proceed_activity1" type="button" style="display:none; opacity:0.7; color:#777;">

                                                <?php } ?>
                                                
                                                <img src="<?php echo base_url(); ?>images/loader.gif" class="cmd_proceed_activity1" style="display:none; color:#777;">
                                            </div>
                                        </div>


                                        <div class="div_quiz2" style="display:none; color:#555; text-align:center;">
                                            <h3 style="text-align:center; color:#00C161; font-size:30px;">Games Activities</h3>
                                            <h3 style="text-align:center; color:#E800E8; font-size:19px !important; margin:-10px 0 20px 0;">Time Set <font id='tminus_1'><?php echo "$set_time minutes"; ?></font></h3>

                                            <div style="display:nones">
                                                <input id="tminus" placeholder="0:00" style="display:nones" />
                                                <input id="request" value="<?=$set_time;?>" placeholder="Enter Minutes here" style="display:nones" />
                                                <a href="javascript:;" class="button enterTime" style="display:nones">Submit Time</a>
                                                <input type="button" id="resets" value="Clear form" style="display:nones" />
                                            </div>

                                            <input type='text' id='txtgameid' name='txtgameid' value='<?=$gameid;?>'>
                                            <input type='hidden' id='for_days' name='for_days' value='<?=$for_days_1;?>'>
                                            <input type='hidden' id='txtses' name='txtses' value='<?=$sessions1;?>'>
                                            <input type='hidden' id='txtmember' name='txtmember' value='<?=$get_mems_id;?>'>
                                            <input type='text' id='txttotalquiz' name='txttotalquiz' value='<?=$totalquiz;?>'>
                                            <input type='text' id='qid_intro' name='qid_intro' value='<?=$qid_intro;?>'>
                                            
                                            <input type='hidden' id="txtpage_number" value='1'>

                                            <div class='fade_questions' style='display:none'></div>

                                            <?php
                                            if(!$quiz_quests)
                                                echo "<div class='fade_questions' style='display:nones'></div>";
                                            ?>

                                            <div class='scroll_inner_quiz' style='text-align:left'>
                                                <input type='text' name='txtrandom_quiz' id="txtrandom_quiz" value='<?=$qid;?>'>
                                                <ul class='quiz_question'>
                                                    <li style='font-size:16px; line-height:22px; color:#ccc;'><font id="txtpage_number_h">1.</font> <?=$questions;?></li>
                                                </ul>
                                                <?php
                                                echo "<ul class='quiz_options' ids='$qid'>";
                                                    echo $files1i;
                                                    $k=1;
                                                    foreach($all_options as $keys){
                                                        if($k == 1) $m="<b>A)</b>";
                                                        else if($k == 2) $m="<b>B)</b>";
                                                        else if($k == 3) $m="<b>C)</b>";
                                                        else if($k == 4) $m="<b>D)</b>";
                                                        else $m="<b>E)</b>";
                                                        $keys1 = ucfirst($keys);
                                                        echo "<li><label for='options$keys'>$m <input type='radio' name='options1' value='$op1_1' class='$keys' id='options$keys' ids='$qid'> $keys1</label></li>";
                                                        $k++;
                                                    }
                                                echo "</ul>";

                                            echo "</div>";

                                            echo "<input type='text' name='txtans1' id='txtans1' class='txtans1'>";
                                            ?>

                                            <input type='hidden' name='txt_time_finished' id='txt_time_finished'>
                                            
                                            <div class='err_msg'></div>
                                            
                                            <?php if($quiz_quests){ ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:5px !important;">
                                                    <input value="NEXT &raquo;" class="btn-black center-block cmd_next_activity" type="button">
                                                    <input value="NEXT &raquo;..." class="btn-black btn-blacks center-block cmd_next_activity1" type="button" style="display:none; opacity:0.7; color:#777;">
                                                    <img src="<?php echo base_url(); ?>images/loader.gif" class="cmd_next_activity2" style="display:none; color:#777;">

                                                    <!-- <button type="button" id="cmd_submit_answers_timeout" class="btn btn-primary" style="font-size:14px; display:none">Submit Game</button> -->
                                                    <input type="button" value="Submit Game" id="cmd_submit_answers_timeout" class="btn-black center-block" style="font-size:14px; display:none">
                                                </div>

                                            <?php
                                                }else{
                                                    echo '<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px !important; position:relative; z-index:999;">';
                                                        echo '<input type="button" value="Submit Game" id="cmd_sub_answers" class="btn-black center-block" style="font-size:14px;">';
                                                    echo '</div>';
                                                }
                                                // $newdata5 = array(
                                                //     'my_answers' => "",
                                                //     'quizid'     => "",
                                                // );
                                                // $this->session->set_userdata($newdata5);
                                            ?>
                                        </div>

                                        <input type="button" value="Submit Game" id="cmd_sub_answers" class="btn-black center-block" style="font-size:14px; display:none">


                                        <div class="div_success_test" style="display:none; text-align:center">
                                            <p style="margin:15px 0 10px 0;"><img src="<?php echo base_url(); ?>images/checkmark.png"></p>
                                            <p style="font-size:25px; color:#00C161;"><b>Game Activities Taken!</b></p>
                                            <p style="margin:0; color:#ccc; margin-top:-5px">Thank you for participating in the game for today. Your perfomance will soon be computed by the judges and showed to you, please stand by.</p>
                                            <p style="border-bottom:1px #666 dotted; margin:20px 0 20px 0;"></p>

                                            <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:5px !important;">
                                                <input value="DONE" class="btn-black center-block closediv_quiz" type="button">
                                            </div>
                                        </div>


                                        <div class="div_success_test_timeout" style="display:none; text-align:center">
                                            <p style="margin:15px 0 10px 0;"><img src="<?php echo base_url(); ?>images/errors.png"></p>
                                            <p style="font-size:25px; color:#C40000;"><b>Games Timeout And Submitted!</b></p>
                                            <p style="margin:0; color:#ccc; margin-top:-5px">Thank you for participating in the game for today. Your perfomance will soon be computed by the judges and showed to you, please stand by.</p>
                                            <p style="border-bottom:1px #666 dotted; margin:20px 0 20px 0;"></p>

                                            <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:5px !important;">
                                                <input value="DONE" class="btn-black center-block closediv_quiz" type="button">
                                            </div>
                                        </div>


                                    <?php }else{ // if its not quiz ?>

                                    <div class="div_main_uploads" style="display:nones"> <!--Loaded by default-->

                                        <?php
                                        $base_url = base_url();
                                        $picx=$base_url."images/no_photo.jpg"; $imgs1=$base_url."images/no_photo.jpg"; $yes_file="";
                                        ?>
                                                
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="hidden" name="txtf0" value="<?=$picx;?>">
                                            
                                            <p style="margin:0px 0 10px 0; font-size:15px; text-align:center">
                                                <span style="color:#AAD5FF; cursor:pointer;" class="basic_uploader_file">Try the simple uploader</span>
                                                <span style="color:#AAD5FF; cursor:pointer; display:none; margin:0" id="hide_basic_uploader_file">Hide</span>
                                            </p>
                                            <input type="file" name="txtpics1" id="txtpics1" class="file_pics" style="display:none" />

                                            <div id="img_prev1_file" class="list-inline-item profile_pics4">
                                                <span>remove</span>
                                                <div class="resize_picx">
                                                    <img src="<?php echo $imgs1; ?>" src1="<?php echo $imgs1; ?>" id="im1_file">
                                                </div>
                                                <input id="ad_logo_check1_bma" value="0" style="display:none;" />
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-7 col-sm-7 col-xs-12 zindex">
                                            <label>Photo Title * <span>Max of 30 characters</span></label>
                                            <input name="txttitle1" placeholder="Enter the title of the photo" type="text" class="txt3">
                                            <label>Little Description * <span>Max of 300 characters</span></label>
                                            <textarea name="txtdesc1" placeholder="Describe this picture in brief" class="txt3" style="height:9em !important; line-height:18px !important; font-size:14px;"></textarea>
                                        </div>


                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="hidden" name="txtf1" value="<?=$picx;?>">
                                            
                                            <p style="margin:0px 0 10px 0; font-size:15px; text-align:center">
                                                <span style="color:#AAD5FF; cursor:pointer;" class="basic_uploader_file2">Try the simple uploader</span>
                                                <span style="color:#AAD5FF; cursor:pointer; display:none; margin:0" id="hide_basic_uploader_file2">Hide</span>
                                            </p>
                                            <input type="file" name="txtpics2" id="txtpics2" class="file_pics" style="display:none" />

                                            <div id="img_prev1_file2" class="list-inline-item profile_pics4">
                                                <span>remove</span>
                                                <div class="resize_picx">
                                                    <img src="<?php echo $imgs1; ?>" src1="<?php echo $imgs1; ?>" id="im1_file2">
                                                </div>
                                                <input id="ad_logo_check1_bma2" value="0" style="display:none;" />
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-7 col-sm-7 col-xs-12 zindex">
                                            <label>Photo Title * <span>Max of 30 characters</span></label>
                                            <input name="txttitle2" placeholder="Enter the title of the photo" type="text" class="txt3">
                                            <label>Little Description * <span>Max of 300 characters</span></label>
                                            <textarea name="txtdesc2" placeholder="Describe this picture in brief" class="txt3" style="height:9em !important; line-height:18px !important; font-size:14px;"></textarea>
                                        </div>


                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="hidden" name="txtf2" value="<?=$picx;?>">
                                            
                                            <p style="margin:0px 0 10px 0; font-size:15px; text-align:center">
                                                <span style="color:#AAD5FF; cursor:pointer;" class="basic_uploader_file3">Try the simple uploader</span>
                                                <span style="color:#AAD5FF; cursor:pointer; display:none; margin:0" id="hide_basic_uploader_file3">Hide</span>
                                            </p>
                                            <input type="file" name="txtpics3" id="txtpics3" class="file_pics" style="display:none" />

                                            <div id="img_prev1_file3" class="list-inline-item profile_pics4">
                                                <span>remove</span>
                                                <div class="resize_picx">
                                                    <img src="<?php echo $imgs1; ?>" src1="<?php echo $imgs1; ?>" id="im1_file3">
                                                </div>
                                                <input id="ad_logo_check1_bma3" value="0" style="display:none;" />
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-7 col-sm-7 col-xs-12 zindex">
                                            <label>Photo Title * <span>Max of 30 characters</span></label>
                                            <input name="txttitle3" placeholder="Enter the title of the photo" type="text" class="txt3">
                                            <label>Little Description * <span>Max of 300 characters</span></label>
                                            <textarea name="txtdesc3" placeholder="Describe this picture in brief" class="txt3" style="height:9em !important; line-height:18px !important; font-size:14px;"></textarea>
                                        </div>



                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label style="display:block; margin-bottom:4px !important; color:#ccc; line-height:19px;">If you were to be the winner, what would you do and how would you feel? Also tell us what the prize can do for you.</label>
                                            <textarea name="txtexpr" placeholder="Write a brief expression here" class="txt3" style="height:12em !important; line-height:19px !important;"></textarea>
                                        </div>
                                        <p style="clear:both" style="padding:5px;"></p>

                                        <div class="err_div3" style="margin-top:-1.3em;"></div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px !important;">
                                            <input name="submit" value="SUBMIT" class="btn-black center-block submit_activity_f" type="submit">
                                            <input name="button" value="SUBMITTING..." class="btn-black btn-blacks center-block submit_activity_f1" type="button" style="display:none; opacity:0.7; color:#777;">
                                        </div>
                                    </div>

                                    <?php } ?>
                                    
                                </div>


                                <div class="second_activity" style="text-align:center; display:none; padding:0 10px;">
                                    <h3 style="color:#ddd;">Important Notice</h3>
                                    <p style="line-height:23px; color:#F77;">
                                        Submitting this will have no room for later editions, as you submit, the judges will
                                        process your activities immediately and compute the scores for today. If you want to make some changes, click
                                        on the <b>"Back"</b> button and make any necessary corrections.
                                    </p>

                                    <p style="line-height:23px; color:#ccc; margin-top:-5px;">
                                        A score of 100% from each judge will be given to you based on if your punctuality, quality pictures,
                                        instructions taken and other screening activities are perfect.
                                    </p>

                                    <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:12px !important;">
                                        <input name="submit" value="&laquo; Back" class="btn-black btn-black1 back_activity" type="button">
                                        <input name="submit" value="SUBMIT" class="btn-black center-block submit_activity" type="submit">
                                        <input name="button" value="SUBMITTING..." class="btn-black btn-blacks center-block submit_activity1" type="button" style="display:none; opacity:0.7; color:#777;">
                                    </div>

                                </div>


                                <div class="third_activity" style="text-align:center; display:none; padding:0 10px;">
                                    <h3 style="color:#00C161; font-size:30px;">Congratulations</h3>
                                    <p style="margin:15px 0 10px 0;"><img src="<?php echo base_url(); ?>images/checkmark.png"></p>
                                    <p style="line-height:23px; color:#00C161;">
                                        You have carried out your first activity of the week and we hope you followed the
                                        instructions given to you to earn more marks. The scores will be displayed as soon as possible.
                                    </p>

                                    <p style="line-height:23px; color:#ccc; margin-top:-10px;">
                                        Please be alert and come back for your 
                                        second activity of the week, be punctual at the time duration specified, thank you!
                                    </p>

                                    <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:8px !important;">
                                        <input value="DONE" class="btn-black center-block cmd_done_activity" type="button">
                                    </div>

                                </div>

                            <?php } ?>
                            
                        </div>
                    <?php echo form_close(); ?>
                </div>


            </div>
        
        </div>
        <br>
    </section>
        