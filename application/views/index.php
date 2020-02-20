

    <script>
        setTimeout(function(){
            $('.page_titl').html('A New Face Of Opportunity And Entertainments | OurFavCelebs Pageant');
        },1500);
    </script>


    <div class="indexs1" style="display:nones">
        <section id="reach-to" class="welcome-part home-icon">
            <div class="icon-default icon-default1i">
                <a href="#reach-to" class="scroll scrls"><img src="images/scroll-arrow.png" alt=""></a>
            </div>
            <div class="container">
                <div class="build-title up_title">
                    <h2>
                    Welcome To OurFav<span style="color:#C4C400;">Celebs</span> 
                    <span style="color:#C4C400;">Pageant</span>
                    </h2>
                    <h6 style="font-family:'Quicksand', sans-serif !important; color:#333;">A new face of opportunity, entertainments, game shows and logistics...</h6>
                </div>



                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 wow_ _fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms" style="text-align:center;">
                        <p class="home_about">
                        OurFavCelebs introduces online fun and entertainment activities of Pageantry Contest as a medium to promote environmental awareness and 
                        opportunities for everyone to engage in one or more of <b>OurFavCelebs pageant activities.</b>
                        Apart from a strong emphasis on entertainments and games playing, Miss OurFavCelebs also aims to promote and showcare your talents,
                        creativities and intelligence to the world via the platform and most of the various social medias.
                        </p>
                    </div>
                </div>
            </div>
            
        </section>
        
        <section class="dishes banner-bg invert invert-black home-icon wow_ _fadeInDown" data-background="images/banner1.jpg">
            <div class="icon-default icon-default1 icon-black">
                <img src="images/contestants.png" alt="">
            </div>
            
            <div class="container containerx" id="gotohere">
                <div class="build-title contestants">
                    <h2>
                        
                        <?php
                        if($contestants[0]['overall_title']!="")
                            echo ucwords($contestants[0]['overall_title']);
                        ?>
                    </h2>
                    <?php
                    if($no_of_contest > 0)
                        echo "<h6>Our $no_of_contest Contestants</h6>";
                    else
                        echo "<h6>No Contestants Yet!</h6>";
                    $expirys = $this->sql_models->current_vote_campaign();

                    if($expirys!="")
                        echo "<p class='expirys1'>This campaign expires in <b style='color:#A6A600;'>$expirys</b></p>";
                    ?>
                    
                    
                </div>

                <?php
                //$imgs1 = base_url()."watermark.php?image=".base_url()."images/model2.jpg&watermark=".base_url()."images/watermrk.png";
                $imgs1 = base_url()."images/model2.jpg";
                ?>

                
                <?php if($contestants){ ?>
                    
                    <div class="searchpart1">
                        <a href="#"></a>
                        <div class="search-box_ search-box3">
                            <!-- <input type="text" name="txtsc" id="txtsc" placeholder="Search Contestants">
                            <input type="submit" name="submit" value=" " class="find_member_"> -->
                            <div id="txtsc"><span class="past_contestants_home">View All Contestants <i class="fa fa-caret-down"></i></span> </div>
                        </div>
                    </div>

                    
                    <div class="slider slider_contest multiple-items_">
                        <div class="owl-carousel owl-theme owl-theme3" data-items="3" data-laptop="3" data-tablet="2" data-mobile="1" data-nav="true" data-dots="true" data-autoplay="true" data-speed="500" data-autotime="3000">

                        <!-- <div class="slider_container"> -->
                            <?php
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
                                    $names3 = strtolower($names);
                                    $names3 = str_replace(" ", "-", $names3);
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
                                        <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><img src="<?php echo base_url(); ?>images/facebook.png" alt=""></a>
                                        <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><img src="<?php echo base_url(); ?>images/twitter1.png" alt=""></a>
                                        <a class="hitLink mobiles_view" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><img src="<?php echo base_url(); ?>images/whatsapp.png" alt=""></a>
                                        <a class="hitLink not_mobiles_view" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><img src="<?php echo base_url(); ?>images/whatsapp.png" alt=""></a>
                                    </div>
                                </div>
                        
                            <?php
                                }

                        //echo "</div>";

                            $no_of_contest1 = 3 - $no_of_contest; // 3-2=1
                            for($xx=1; $xx<=5; $xx++){
                                $yy = $xx;
                                $pic_path = base_url()."images/users.jpg";
                                ?>
                                <div class="product-blog item cover_img1">
                                        <div class="cover_img">
                                            <a href="<?=$pic_path;?>" class="magnific-popup">
                                                <img src="<?=$pic_path;?>" alt="">
                                            </a>
                                        </div>
                                    <h3>Contestant <?=$yy;?></h3>
                                    <p class="states">Contestant State</p>
                                    <p>
                                        <span onclick="javascript:alert('Error, no contestant here!');">Vote Me</span>
                                        <span onclick="javascript:alert('Error, no contestant here!');">View Profile</span>
                                    </p>
                                    <strong class="txt-default">Votes: <font class="">0</font></strong>
                                    <div class="socials">
                                        <a href="javascript:;" onclick="javascript:alert('Error, no contestant here!');"><img src="<?php echo base_url(); ?>images/facebook.png" alt=""></a>
                                        <a href="javascript:;" onclick="javascript:alert('Error, no contestant here!');"><img src="<?php echo base_url(); ?>images/twitter1.png" alt=""></a>
                                        <a href="javascript:;" onclick="javascript:alert('Error, no contestant here!');"><img src="<?php echo base_url(); ?>images/whatsapp.png" alt=""></a>
                                    </div>
                                </div>
                                
                            <?php 
                            }
                            ?>
                            
                        </div>    
                    </div>

                <?php 
                }else{
                    echo "<div style='text-align:center; margin:-15px 0 1.5em 0 !important; line-height:21px; color:#999; font-size:16px;'>Be the first to participate in the competition now.</div>";
                }

                if(!$expirys){
                    echo "<div style='text-align:center; margin:-1.5em 0 1.5em 0 !important; color:#999;'>The previous game activity has expired!</div>";
                    $nxtgame = $this->sql_models->check_next_activity();
                    if($nxtgame){
                        $overall_title = ucwords($nxtgame['overall_title']);
                        $banners = $nxtgame['banners'];
                        echo "<p style='font-size:20px; color:#ddd; text-align:center'>The NEXT on the line is</p>";
                        echo "<p style='font-size:1.7em; color:#FC3; font-weight:bold; line-height:1.2em; text-align:center; margin:-18px 0 1.4em 0;'>$overall_title</p>";
                        echo "<div class='next_actv'>
                            <img src='".base_url()."events_fols/$banners'>
                        </div>";
                    }
                }

                ?>     
                <!-- </div> -->
            </div>
        </section>
        

        
        <section class="food-hours home-icon home-icon2" data-stellar-offset-parent="true" data-stellar-background-ratio="0.9" 
            data-wow-duration="1000ms" data-wow-delay="300ms" 
            style="background:#1f5050;">
            <div class="icon-default icon-default1 icon-gold">
                <img src="images/icon11.png" alt="">
            </div>

            <div class="container">
                <div class="food-blog_">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 food-mxs contains1">
                            <div class="food-blog-inner how_to_use" style="float:none !important">

                                
                                <div style="clear:both"></div>
                                
                                <div class="how_to_reg wow_ _fadeInDown" style="display:nones">
                                    <ul style="position:relative; z-index:99;">
                                    <p class="h5s" style="position:relative; z-index:99;">How to Register</p>
                                        <li>All Applicants must be 18yrs and above to register. Individuals below the age of 18 must have a <b>Legal Guardian</b> present during payment, registration and outdoor photo-shoot sessions.</li>
                                        <li>Must meet our criteria as set forth by the Miss OurFavCelebs.</li>
                                        <li>Must be able to meet the time commitment and job responsibilities as set forth by the competition(s) in which you compete.</li>
                                        <li>Must be an active member of OurFavCelebs.</li>
                                        <li>Your contestant account will be approved if we receive your payment of <b>&#8358;1,000</b></li>
                                        <li>Please read our <a href="<?php echo base_url(); ?>pages/#policy">privacy and policy</a> before registering and for more inquiries, please send us a message via our <a href="<?php echo base_url(); ?>pages/#contact">contact page</a>.</li>
                                    </ul>

                                    <div class="awards1s">
                                        <h5>Awards/Activities</h5>
                                          <p style="margin-top:-4px;"><a href="#awards" class="open_awards">&laquo; Click to see RunnerUp Awards &raquo;</a></p>
                                          <p style="margin-top:-14px;"><a href="#activities" class="open_actv">&laquo; Click to see Our Activities &raquo;</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-12 food-mxs">
                        </div>
                        

                        <div class="col-md-5 col-sm-5 col-xs-12 wow_ _fadeInDown how_to_use mobile_shft_down" data-wow-duration="1000ms" data-wow-delay="300ms">
                            
                            <form id="enter_reg" class="form reg_form reg_form_home uploadimage2_members_home" method="post" autocomplete="off" name="contact-form">
                                <input type="hidden" name="txtmember" value="">
                                <div class="alert-container"></div>
                                <div class="girls"></div>
                                <div class="row house_form">

                                    <?php
                                    $now = time();
                                    $enable_reg = $is_new_game['enable_reg'];
                                    $disable_reg = $is_new_game['disable_reg'];

                                    if($validate_mem==true){
                                        if($validate_mem_paid==true && $enable_reg <= $now && $disable_reg > $now){
                                            $displays1 = "";
                                            $displays2 = "display:none";
                                        }else{
                                            $displays1 = "";
                                            $displays2 = "display:none";    
                                        }
                                    }else{ // not logged in
                                        //if($validate_mem_paid==true && $enable_reg <= $now && $disable_reg > $now){
                                            $displays1 = "display:none";
                                            $displays2 = "";
                                        /*}else{
                                            $displays1 = "";
                                            $displays2 = "display:none";
                                        }*/
                                    }

                                    $picx="images/no_photo.jpg"; $imgs1="images/no_photo.jpg";$yes_file="";
                                    ?>

                                    <div class="ist_form" id="regs1" style="<?=$displays2;?>">

                                        <?php
                                        if($enable_reg <= $now && $disable_reg > $now){
                                        ?>
                                            <div class="registeratn_on" style="display:nones">
                                                <h5 style="text-align:center;">Fill the form below</h5>
                                                <p style="color:#FF9; text-align:center; font-size:14px; margin:-14px 0 0px 0">All fields marked star(*) are compulsory</p>
                                                <p style="color:#FF9; text-align:center; font-size:14px; margin:-5px 0 22px 0">Please provide a valid email address</p>

                                                <div class="col-md-6 col-md-6i col-sm-6 col-xs-12 txt_1">
                                                    <input name="txtfname" placeholder="* Your first name" style="text-transform:capitalize;" type="text" class="txt1">
                                                </div>
                                                <div class="col-md-6 col-md-6i col-sm-6 col-xs-12 txt_2">
                                                    <input name="txtlname" placeholder="* Your last name" style="text-transform:capitalize;" type="text" class="txt2">
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12 txt_1">
                                                    <input name="phone1" placeholder="* Your Phone Number" type="number" class="txt1">
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12 txt_2">
                                                    <input name="email1" placeholder="* Your Email Address" type="email" class="txt2">
                                                </div>

                                                <div class="col-md-6 col-md-6i col-sm-6 col-xs-12 txt_1">
                                                    <select name="txtstate" class="txt1" id="txtstate" style="text-align:right !important;">
                                                        <option value="" selected>* -Select State-</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <?php
                                                            foreach($countries as $post):
                                                            $con_name = $post['names'];
                                                            echo "<option value='$con_name'>$con_name</option>";
                                                            ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-md-6i col-sm-6 col-xs-12 txt_2">
                                                    <select style="" name="txtgender" class="txt2" id="txtgender">
                                                        <option value="" selected>* -Select Gender-</option>
                                                        <option value="m">Male</option>
                                                        <option value="f">Female</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-md-6i col-sm-6 col-xs-12 txt_1">
                                                    <input name="txtpass1" placeholder="* Your password" type="password" class="txt1">
                                                </div>
                                                <div class="col-md-6 col-md-6i col-sm-6 col-xs-12 txt_2">
                                                    <input name="txtpass2" placeholder="* Your confirm password" type="password" class="txt2">
                                                </div>
                                                <div style="clear:both"></div>

                                                <p style="text-align:center; color:#eee; margin:8px 0 0px 0;"><span href="#login1" class="login_here">Already Registered? Login here</span></p>
                                                <div class="err_div"></div>
                                                
                                                <div class="" style="text-align:centers; margin-top:1em;">
                                                    <input name="submit" value="Submit" class="btn-black center-block submit_form" type="button">
                                                    <input name="submit" value="Submitting..." class="btn-black center-block submit_form1 opac_btn" type="button" style="display:none;">
                                                </div>
                                            </div>

                                        <?php }else{ ?>

                                            <div class="registeratn_closed" style="display:nones">
                                                <p class="reg_title">REGISTRATION IS CLOSED!!!</p>
                                                <?php
                                                $baners = $contestants[0]['banners'];
                                                if($baners!=""){
                                                    echo "<div class='next_actv next_actv1'>
                                                        <img src='".base_url()."events_fols/$baners'>
                                                    </div>";
                                                }

                                                $nxtgame = $this->sql_models->check_next_activity();
                                                if($nxtgame){
                                                    $dates = $nxtgame['dates'];
                                                    $enable_reg = $nxtgame['enable_reg'];
                                                    $disable_reg = $nxtgame['disable_reg'];
                                                    $dates = date("jS F, Y", $dates);
                                                    $enable_reg = date("jS F, Y h:i a", $enable_reg);
                                                    $disable_reg = date("jS F, Y h:i a", $disable_reg);

                                                    echo "<p>Contesting activities are going on at the moment. 
                                                    Please wait for the next show which will come up on 
                                                    <font style='color:#FFFF9D; font-size:15px;'>$dates.</font><br>
                                                    Next Registration starts
                                                    on <font style='color:#FFFF9D; font-size:15px;'>$enable_reg</font><br> and ends 
                                                    <font style='color:#FFFF9D; font-size:15px;'>$disable_reg.</font></p>
                                                    <p style='margin-top:-5px'>Kindly be patient with us, thank you.</p>";
                                                }else{
                                                    echo "<p>Please wait for the next show which will come up soon. Kindly be 
                                                    patient with us, thank you.
                                                    </p>";
                                                }

                                                ?>
                                                

                                                <div style="text-align:center; margin-top:2.3em;" class="parti_btn">
                                                    <span class="faded notpaid" onclick="javascript:alert('Registration is closed at the moment!');">CLOSED</span>
                                                </div>
                                                <p style="text-align:center; color:#FF9; margin:2em 0 0px 0;"><span href="#login1" class="login_here">Already Registered? Login here</span></p>
                                            </div>
                                            
                                        <?php } ?>

                                    </div>


                                    
                                    <div class="secs_form" style="display:none">
                                        <p style="color:#FF9; text-align:center; font-size:14px;" class="instrucs">All fields marked star(*) are compulsory</p>
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                            <input type="hidden" name="txtf0" value="<?=$picx;?>">
                                            <ul class="list-inline">
                                                <li id="img_prev1_bma" class="list-inline-item profile_pics3">
                                                    <span>remove</span>
                                                    <img src="<?php echo $imgs1; ?>" src1="<?php echo $imgs1; ?>" id="im1_bma">
                                                    <input id="ad_logo_check1_bma" value="0" style="display:none;" />
                                                    
                                                    <input type="file" name="txt_bma_pic" id="txt_bma_pic" style="padding:4px; font-size:13px; margin:8px 0 0px 0; border:1px solid #ccc; display:none" />
                                                    <p style="color:#eee; cursor:pointer; display:none; margin:4px 0 -17px 0;" id="hide_basic_uploader">Hide</p>
                                                    
                                                </li>
                                                <input name="txt_yes_file_bma" type="hidden" value="<?=$yes_file;?>">
                                            </ul>
                                            <p style="margin:-6px 0 2.5em 0; font-size:14px;">
                                                <span style="color:#eee; cursor:pointer;" class="basic_uploader"><b>Or <span style="color:#7BF">click here</span> to try the simple uploader</b></span>
                                            </p>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
                                            <input name="txtcodes" style="color:#39C; font-size:17px;" placeholder="* Write the code sent to your email" type="number" class="txt3">
                                            <p style="color:#FC6; margin:-2.7em 0 2.3em 0 !important; font-size:13px;">Please check your email, we just sent you a code now.</p>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
                                            <input name="txtoccu" style="text-transform:capitalize;" placeholder="* What's your Occupation?" type="text" class="txt3">
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 hear_about" style="text-align:center">
                                            <textarea name="txthear" class="txt3" placeholder="How did you hear about us?"></textarea>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="err_div1"></div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="text-align:center;">
                                            <input name="button" value="&laquo; Back" class="btn-black btn-black1 back2" type="button">
                                            <input name="submit" value="Submit" class="btn-black submit_form1_1" type="submit">
                                            <input name="submit" value="Submitting..." class="btn-black submit_form1_2 opac_btn" type="button" style="display:none;">
                                        </div>
                                    </div>



                                    <div class="login_form" id="login1" style="display:none">
                                        <h5 style="text-align:center;" class="instrucs1">Login Here</h5>
                                        <p style="color:#FF9; text-align:center; font-size:14px; margin-bottom:12px;">Enter your login details</p>
                                        <div class="colsd">
                                            <input name="txtuser" placeholder="Your email or phone number" type="text" class="txt3">
                                        </div>
                                        
                                        <div class="colsd" style="margin-top:-23px;">
                                            <input name="txtpasswd" placeholder="Enter your password" type="password" class="txt3">
                                        </div>
                                        <div style="clear:both;"></div>

                                        <div style="text-align:center; color:#eee; margin:-10px 0 0px 0;"><span href="#regs1" class="reg_here">Not Registered? Enter now</span></div>
                                        
                                        
                                        <div class="err_login"></div>

                                        <div class="" style="text-align:centers; margin-top:1em;">
                                            <input name="submit" value="Login" class="btn-black center-block cmd_signin" type="button">
                                            <input name="submit" value="Logging..." class="btn-black center-block cmd_signin1 opac_btn" type="button" style="display:none;">
                                        </div>
                                    </div>


                                    <div class="participate" id="login1" style="<?=$displays1;?>">
                                        <h5 style="text-align:center; margin-top:10px;">Click to Participate</h5>

                                        <?php
                                        //if(!$validate_mem_paid==true){
                                        if(!$validate_mem==true){
                                        ?>
                                            <p style="color:#ddd; text-align:center; font-size:15px; line-height:23px; margin:-7px 0 30px 0">
                                            Thank you for being part of OurFavCelebs contest activities. An email has been sent to you containing our company's
                                            account details to pay in the sum of <b>&#8358;1,000</b> entrance fee or click on this below to see
                                            the account details.
                                            </p>

                                        <?php } ?>


                                        <p style="color:#ddd; text-align:center; font-size:15px; line-height:23px; margin:10px 0 30px 0">
                                        Participate in OurFavCelebs activities. It's an excellent opportunity for you to 
                                        become a new trending face of OurFavCelebs, show your talents/creativity to the world, explore
                                        the great things we offer and win lots of prizes.
                                        </p>

                                        <p class="bank_detls" style="text-align:center; font-size:16px; cursor:pointer; line-height:22px; margin:-16px 0 25px 0">Click to See Account Details</p>
                                        <div class="acct_details" style="display:none; margin-bottom:20px;">
                                            <table class="table tbl_format">
                                                <tr>
                                                    <td>Bank Name:</td>
                                                    <td>Name of bank</td>
                                                </tr>
                                                <tr>
                                                    <td>Account Name:</td>
                                                    <td>OurFavCelebs LTD</td>
                                                </tr>
                                                <tr>
                                                    <td>Account No:</td>
                                                    <td style="letter-spacing:0.9px">1234567890</td>
                                                </tr>
                                            </table>
                                            <p style="color:#ddd; font-size:14px; margin:-16px 0 0px 0; text-align:center">For any inquiries, kindly reach us on <a href="tel:+2349038455799">(+234) 0903 845 5799</a>
                                        </div>

                                        <p style="text-align:center;"><img src="images/contestants.png"></p>
                                        <?php
                                        $nxtgame = $this->sql_models->check_next_activity();
                                        $newgame_id="";
                                        if($nxtgame){
                                            $newgame_id = ucwords($nxtgame['id']);
                                        }
                                        ?>

                                        <div style="text-align:center; margin-top:1em; display:nones" class="parti_btn parti_btn1">
                                            <?php
                                            if($validate_mem_paid==true){
                                                echo '<span class="participateme notpaid">Yes, Participate</span>';
                                            }else{
                                                if($validate_mem==true) // if i have registered
                                                    echo '<span class="faded notpaid" onclick="javascript:alert(\'You cannot participate without payment.\');">Yes, Participate</span>';
                                                else
                                                    echo '<span class="faded notpaid notpaid1">Yes, Participate</span>';
                                            }
                                            echo '<span class="faded notpaid java_nopaid1" style="display:none;" onclick="javascript:alert(\'You cannot participate without payment.\');">Yes, Participate</span>';
                                            echo '<span class="participateme havepaid" style="display:none;">Yes, Participate</span>';
                                            ?>                                            
                                        </div>
                                        <div class="parti_div" style="display:none; padding-top:5px;">
                                            <p>You cannot participate without payment on our new activity.<br>Pay <b>&#8358;1,000</b> to participate?</p>
                                            <div class="" style="text-align:centers; margin-top:-12px;">
                                                <input name="submit" value="YES" gameid1="<?=$newgame_id;?>" mems="<?=$get_mems_id;?>" class="btn-black btn-gold center-block cmd_add_payment" type="button">
                                                <input name="submit" value="YES" class="btn-black btn-gold center-block cmd_add_payment1 opac_btn" type="button" style="display:none;">

                                                <input name="submit" value="NO" class="btn-black btn-gold center-block cmd_nopay" type="button">
                                            </div>
                                        </div>

                                        <div class="pay_succ_div" style="display:none">
                                            <p style="color:#74E800; font-size:18px; margin-bottom:14px;"><b>Thank You!</b></p>
                                            <p>We are looking forward to get your payment notification so as to enable you to participate in this activity immediately.</p>
                                            <div class="" style="text-align:centers; margin-top:-12px;">
                                                <input name="submit" value="Done" class="btn-black btn-gold center-block cmd_done_pay" type="button">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        
        
        
        <section class="instagram-main home-icon" data-wow-duration="1000ms" data-wow-delay="300ms">
            <div class="icon-default icon-default1">
                <img src="images/icon37.png" alt="">
            </div>
            <div class="container partners1">
                <div class="build-title">
                    <h3>Meet Our Partners/Sponsors</h3>
                </div>
            </div>
            <div class="gallery-slider">
                <div class="owl-carousel owl-theme" data-items="6" data-laptop="5" data-tablet="4" data-mobile="2" data-nav="true" data-dots="false" data-autoplay="true" data-speed="2000" data-autotime="3000">
                    <div class="item">
                        <a href="https://edentekgroup.com/" target="_blank" class="magnific-popup_">
                            <img src="images/gallery/edentek_logo.jpg" alt="" class="animated">
                            <!-- <div class="gallery-overlay">
                                <div class="gallery-overlay-inner">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                            </div> -->
                        </a>
                    </div>
                    <div class="item">
                        <!-- <a href="images/gallery/gallery-big2.jpg" class="magnific-popup"> -->
                            <img src="images/gallery/brandlogo1.jpg" alt="" class="animated">
                            <!-- <div class="gallery-overlay">
                                <div class="gallery-overlay-inner">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                            </div> -->
                        <!-- </a> -->
                    </div>
                    <div class="item">
                        <!-- <a href="images/gallery/gallery-big3.jpg" class="magnific-popup"> -->
                            <img src="images/gallery/brandlogo2.jpg" alt="" class="animated">
                            <!-- <div class="gallery-overlay">
                                <div class="gallery-overlay-inner">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                            </div>
                        </a> -->
                    </div>
                    <div class="item">
                        <!-- <a href="images/gallery/gallery-big4.jpg" class="magnific-popup"> -->
                            <img src="images/gallery/brandlogo3.jpg" alt="" class="animated">
                            <!-- <div class="gallery-overlay">
                                <div class="gallery-overlay-inner">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                            </div>
                        </a> -->
                    </div>
                    <div class="item">
                        <!-- <a href="images/gallery/gallery-big5.jpg" class="magnific-popup"> -->
                            <img src="images/gallery/brandlogo4.jpg" alt="" class="animated">
                            <!-- <div class="gallery-overlay">
                                <div class="gallery-overlay-inner">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                            </div>
                        </a> -->
                    </div>
                    <div class="item">
                        <!-- <a href="images/gallery/gallery-big6.jpg" class="magnific-popup"> -->
                            <img src="images/gallery/brandlogo5.jpg" alt="" class="animated">
                            <!-- <div class="gallery-overlay">
                                <div class="gallery-overlay-inner">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                            </div>
                        </a> -->
                    </div>
                </div>
            </div>
        </section>

    </div>
        

    </div>
</main>
        
        