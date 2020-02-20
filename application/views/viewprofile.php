
        
    <script>
        setTimeout(function(){
            $(".show_my_profile").hide();
        },2000);
    </script>

    <?php if($profile_details){ ?>
        <section style="background:#fff !important; border-top:2px solid #eee;" id="reach-to" class="dishes1 home-icon shop-single pad-bottom-remove blog-main-section text-center_ blog-main-2col ash_color viewpro_dv">
            <div class="icon-default icon-default2" id="page-wrap">
                <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
            </div>

            <?php 
            $idd="";$fname="";$lname="";$emails="";$phones="";$picx="";$citys="";$states="";$countrys="";$yes_file=0;$work="";$gender="";$bm_type="";
            $imgs1 = base_url()."img/no_passport.jpg"; $relationshp_status1="";
            $hobbies=""; $likes=""; $dislikes=""; $bios=""; $kind_of_partner=""; $occupatn="";

            if($profile_details){
                $id = $profile_details['id'];
                $fname = ucfirst($profile_details['fname']);
                $lname = ucfirst($profile_details['lname']);
                $phones = $profile_details['phones'];
                $emails = $profile_details['emails'];
                $picx = $profile_details['pics'];
                $states = $profile_details['statee'];
                $gender = $profile_details['gender'];
                $occupatn = ucwords($profile_details['occupatn']);
                $hear_about = ucfirst($profile_details['hear_about']);
                $relationshp_status = $profile_details['relationshp_status'];
                $hobbies = ucwords($profile_details['hobbies']);
                $likes = ucwords($profile_details['likes']);
                $dislikes = ucwords($profile_details['dislikes']);
                $bios = nl2br($profile_details['bios']);
                $bios = ucfirst($bios);
                $kind_of_partner = ucfirst($profile_details['kind_of_partner']);
                $ful_name = ucwords("$fname $lname");
                if($gender=="m") $gender1="Male"; else $gender1="Female";
                $mylikes = $this->sql_models->fetchMemLikes($id);
                $myviews = $this->sql_models->fetchMemViews($id);
                $mylikes = @number_format($mylikes);
                $myvotes = @number_format($myvotes);
                

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

                if($picx!=''){
                    //$imgs1 = base_url()."watermark.php?image=".base_url()."celebs_uploads/$picx&watermark=".base_url()."images/watermrk.png";
                    $imgs1 = base_url()."celebs_uploads/$picx";
                    $yes_file=1;
                }else{
                    $imgs1 = base_url()."images/no_photo.jpg";
                }
            }
            
            ?>

            <div class="container shft_top shft_top_profile">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">

                        <h4 class="text-coffee1 for_mobile mobiles mobiles1 view_profis"><?=$ful_name;?> Profile</h4>
                        <div class="seperators for_mobile"><img alt="" src="<?php echo base_url(); ?>images/saprator.png"></div>

                        <div class="show_my_profile">Loading Gallery...</div>

                        <div class="slider slider-nav slick-shop-thumb">
                            <div><img src="<?=$imgs1;?>" alt=""></div>
                            <?php
                            if($all_pics){
                                foreach ($all_pics as $rs) {
                                    $file1 = $rs['file1'];
                                    $file2 = $rs['file2'];
                                    $file3 = $rs['file3'];
                                    
                                    if($file1!=""){
                                        //$file1 = base_url()."watermark.php?image=".base_url()."activity_photos/$file1&watermark=".base_url()."images/watermrk.png";
                                        $file1 = base_url()."activity_photos/$file1";

                                        echo "<div><img src='$file1'></div>";
                                    }

                                    if($file2!=""){
                                        //$file2 = base_url()."watermark.php?image=".base_url()."activity_photos/$file2&watermark=".base_url()."images/watermrk.png";
                                        $file2 = base_url()."activity_photos/$file2";
                                        echo "<div><img src='$file2'></div>";
                                    }

                                    if($file3!=""){
                                        //$file3 = base_url()."watermark.php?image=".base_url()."activity_photos/$file3&watermark=".base_url()."images/watermrk.png";
                                        $file3 = base_url()."activity_photos/$file3";
                                        echo "<div><img src='$file3'></div>";
                                    }
                                }
                            }
                            ?>
                        </div>

                        
                        <div class="slider slider-for slick-shop">
                            <div>
                                <img src="<?=$imgs1;?>" alt="">
                            </div>

                            <?php
                            if($all_pics){
                                foreach ($all_pics as $rs) {
                                    $file1 = $rs['file1'];
                                    $file2 = $rs['file2'];
                                    $file3 = $rs['file3'];
                                    $title1 = ucfirst($rs['title1']);
                                    $title2 = ucfirst($rs['title2']);
                                    $title3 = ucfirst($rs['title3']);
                                    $overall_title = ucfirst($rs['overall_title']);
                                    $custom_title1 = "<p class='ctm_div'><b>Activity:</b><br>$overall_title<br><b class='bls'>Picture Title:</b>$title1</p>";
                                    $custom_title2 = "<p class='ctm_div'><b>Activity:</b><br>$overall_title<br><b class='bls'>Picture Title:</b>$title2</p>";
                                    $custom_title3 = "<p class='ctm_div'><b>Activity:</b><br>$overall_title<br><b class='bls'>Picture Title:</b>$title3</p>";
                                    //echo $file1;

                                    if($file1!=""){
                                        //$file1 = base_url()."watermark.php?image=".base_url()."activity_photos/$file1&watermark=".base_url()."images/watermrk.png";
                                        $file1 = base_url()."activity_photos/$file1";
                                        echo "<div><img src='$file1'>$custom_title1</div>";
                                    }

                                    if($file2!=""){
                                        //$file2 = base_url()."watermark.php?image=".base_url()."activity_photos/$file2&watermark=".base_url()."images/watermrk.png";
                                        $file2 = base_url()."activity_photos/$file2";
                                        echo "<div><img src='$file2'>$custom_title2</div>";
                                    }

                                    if($file3!=""){
                                        //$file3 = base_url()."watermark.php?image=".base_url()."activity_photos/$file3&watermark=".base_url()."images/watermrk.png";
                                        $file3 = base_url()."activity_photos/$file3";
                                        echo "<div><img src='$file3'>$custom_title3</div>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        
                    </div>

                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <h4 class="text-coffee1 for_desktop"><?=$ful_name;?> Profile</h4>
                        <div class="seperators for_desktop"><img alt="" src="<?php echo base_url(); ?>images/saprator.png"></div>
                        <div class="star-review-collect">
                            <span class="review-text"><?=$myvotes;?> Votes</span>&nbsp; |
                            &nbsp;<span class="review-text"><?=$myviews;?> Profile Views</span>&nbsp; |
                            &nbsp;<span class="review-text"><?=$mylikes;?> Total Likes</span>
                        </div>

                        <div class="biographys" style="margin-top:2.2em;">
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
                                <td><b style="font-size:13px;">Relationship Status</b></td>
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

                        <?php
                        $gen_num1=time();
                        $gen_num1=substr($gen_num1,6);
                        $ful_name1 = str_replace(" ", "-", $ful_name);
                        $ful_name1 = strtolower($ful_name1);
                        $url1 = base_url()."viewprofile/$id$gen_num1/$ful_name1/";
                        $tweets = "Hi dear, I'm $ful_name at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";
                        $title_whatsapp = "Hi dear, I'm *$ful_name* at *OurFavCelebs*, I would like to plead for your support by voting for me, thank you in advance.";
                        $sTitle_whatsapp = ucwords($title_whatsapp)."%0A%0A$url1";
                        ?>
                        
                        
                        <div class="share-tag">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="social-wrap">
                                        <h5 style="color:#222 !important;">SHARE</h5>
                                        <ul class="social">
                                            <li class="social-facebook"><a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li class="social-tweeter"><a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li class="social-whatsapp mobiles_view"><a class="hitLink" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                            <li class="social-whatsapp not_mobiles_view"><a class="hitLink" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </section>


        <hr class="hrs">
        
        
        <section class="related-product related-product2">
            <div class="container">
                <div class="build-title">
                    <h3 style="font-size:23px;" class="pageant_title widthit"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px"> &nbsp;Awards won so far by <?=$fname;?>  &nbsp;<img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px"></h3>
                </div>
                <?php if($winneris){ ?>

                    <div class="owl-carousel owl-theme small_items" data-items="5" data-laptop="4" data-tablet="3" data-mobile="2" data-nav="false" data-dots="true" data-autoplay="true" data-speed="1800" data-autotime="5000">
                        <?php
                        foreach ($winneris as $rs) {
                            $id = $rs['id'];
                            $sw_id = $rs['sw_id'];
                            $memid = $rs['memid'];
                            $pics = $rs['file1'];
                            $positns = $rs['positns'];
                            $overall_title = ucwords($rs['overall_title']);
                            $dates = $rs['dates']; //August, 2018
                            $mydates = date("F, Y", $dates);

                            $positns1 = substr($positns,-1);
                            if($positns1==1) $positns1=$positns."st";
                            else if($positns1==2) $positns1=$positns."nd";
                            else if($positns1==3) $positns1=$positns."rd";
                            else $positns1=$positns."th";

                            $names = $this->sql_models->contestantName($memid);
                            $names1 = explode(' ', $names);
                            $fname1 = $names1[0];
                            $lname1 = $names1[1];

                            //$file1 = base_url()."watermark.php?image=".base_url()."activity_photos/$pics&watermark=".base_url()."images/watermrk.png";
                            $file1 = base_url()."activity_photos/$pics";
                            ?>

                            <div class="item">
                                <a href="javascript:;" class="view_profiles" activityid="<?=$sw_id;?>" memid="<?=$memid;?>" fulnames="<?=$names;?>" fname="<?=$fname1;?>" lname="<?=$lname1;?>">
                                    <div class="related-img">
                                        <img src="<?=$file1;?>" alt="">
                                    </div>
                                    <div class="related-info">
                                        <h6><?php echo "$positns1 winner of $overall_title";?></h6>
                                        <p><?=$mydates;?></p>
                                    </div>
                                </a>
                            </div>

                        <?php
                        }
                        

                            $no_of_winner1 = 5 - $no_of_winner; // 3-2=1
                            for($xx=1; $xx<=4; $xx++){
                                $yy = $xx;
                                $pic_path = base_url()."images/users.jpg";
                                ?>
                                <div class="item">
                                    <a href="javascript:;">
                                        <div class="related-img">
                                            <img src="<?=$pic_path;?>" alt="">
                                        </div>
                                        <div class="related-info">
                                            <h6>No title</h6>
                                            <p>No Date</p>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        ?>
                        
                    </div>

                <?php }else{ ?>
                    <div style="text-align:center;" class="notwon">You have not won any awards yet!</div>
                <?php } ?>

            </div>
        </section>

    <?php }else{ ?>

        
        <section style="background:#fff !important; border-top:2px solid #eee;" id="reach-to" class="dishes1 home-icon shop-single pad-bottom-remove blog-main-section text-center_ blog-main-2col ash_color">
            <div class="icon-default icon-default2" id="page-wrap">
                <a href="#reach-to" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
            </div>

            <div class="container shft_top">
                <div class="row">
                    

                <div style="padding:0em 15px 6em 15px; text-align:center; font-size:1.2em; line-height:23px; color:red;">
                    <p style="font-size:1.8em"><b>Error!</b></p>
                    This page is invalid, please go to the home page
                </div>

                </div>
            </div>
            
        </section>

    <?php } ?>

        

        

    <a href="#" class="top-arrow"></a>

    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>plugin/revolution-plugin/jquery.themepunch.revolution.min.js"></script>
    <script src="<?php echo base_url(); ?>plugin/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>plugin/slick-slider/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>js/app.js"></script>
