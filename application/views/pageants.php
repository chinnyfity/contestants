
        

    <?php
    $title2 = ucwords($contestants[0]['overall_title']);
    $main_date = $contestants[0]['dates'];
    $main_date = date("jS F, Y", $main_date);
    if($title2=="")
    $title2 = "No Contestants Yet";
    ?>
    <section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col wow_ _fadeInDown ash_color" style="background:#333 !important; border-top:2px solid #888;">
        <div class="icon-default icon-default4">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?=base_url();?>images/scroll-white.png" alt=""></a>
        </div>

        
        <p class="pageant_title pageant_title1 for_mobile"><img src="<?=base_url();?>images/contestants.png" style="width:30px;">
         &nbsp;
         <font class="cat_title cat_title1"><?=$title2;?></font><br>
         <font style="font-size:15px; color:#CC3; display:block; margin:0px 0 5px 0">(<?=$main_date;?>)</font>
        </p>
        <div class="container shft_top shft_top_pageant">
            <div class="row mobiles">

                <div class="col-md-3 col-sm-5 _col-xs-12 right_menu pagent_botm">
                    <div class="blog-left-section blog_left_section" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="blog-left-section1">
                            <div class="blog-left-search blog-common-wide">
                                <form method="post" autocomplete="off" action="javascript:;">
                                    <input type="text" id="txt_srch_pageant" placeholder="Search">
                                    <input type="button" name="button" class="cmd_searchs" vals="pagents" value="&#xf002;">
                                </form>
                            </div>
                            <div class="blog-left-categories blog-common-wide">
                                <h5>Pageant Activities</h5>
                                <ul class="list pageant_lists pageantlists pageantlists2">
                                <?php
                                $act_titles = $this->sql_models->fetchActTitles();
                                if($act_titles){
                                    foreach ($act_titles as $rs) {
                                        $id3 = $rs['session1'];
                                        $overall_title = ucwords($rs['overall_title']);
                                        $overall_title = str_replace("'", "&rsquo;", $overall_title);
                                        $dates = $rs['dates'];
                                        $dates = date("jS F, Y", $dates);
                                        echo "<li><a href='javascript:;' class='open_title' ids='$id3' date1='$dates' titls='$overall_title'>$overall_title</a></li>";
                                    }
                                }else{
                                    echo "<li><a href='javascript:;'>No activities yet!</a></li>";
                                }
                                ?>
                                </ul>
                            </div>
                        </div>    
                    </div>
                </div>      


                <p class="pageant_1"></p>
                <div class="col-md-9 col-sm-7 col-xs-12 left_pics">
                    <p class="pageant_title for_desktop"><img src="<?=base_url();?>images/contestants.png" style="width:30px"> 
                    &nbsp;<font class="cat_title"><?=$title2;?></font><br>
                    <font style="font-size:15px; color:#CC3; display:block; margin:-3px 0 -1px 0">(<spans class="date_java"><?=$main_date;?></spans>)</font>
                    </p>
                    <p class="copyrgt copyrgt_pagent">All our contestant pictures here belong to us and may be subject to copyright</p>
                    
                    <div class="fetchCategoriesConts">
                        <?php
                        if($contestants){
                        ?>
                            <div class="blog-right-section">
                                <div class="row page-wrap group load_contestns">

                                    <?php
                                        foreach ($contestants as $rs) {
                                            $sw_id = $rs['sw_id'];
                                            //$pa_id = $rs['idd'];
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
                                            $mydates = date("jS F, Y", $mydate); //18th November, 2018
                                            $mylikes = $this->sql_models->fetchMemLikes($memid);
                                            $mylikes = @number_format($mylikes);
                                            $my_photo_cnts = $this->sql_models->fetchPhotoCounts($memid);

                                            $gen_num1=time();
                                            $gen_num1=substr($gen_num1,6);
                                            $names3 = strtolower($names);
                                            $names3 = str_replace(" ", "-", $names3);
                                            $url1 = base_url()."viewprofile/$memid$gen_num1/$names3/";
                                            $tweets = "Hi dear, I'm $names at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";
                                            $title_whatsapp = "Hi dear, I'm *$names* at *OurFavCelebs*, I would like to plead for your support by voting for me, thank you in advance.";
                                            $sTitle_whatsapp = ucwords($title_whatsapp)."%0A%0A$url1";
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
                                                        <p style="color:#990; font-size:14px; margin-bottom:2px;" class="pageant_name"><b><?=$overall_title;?></b></p>
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
                            echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No contestants on this activity selected!</p>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>

    </section>
    
        
        