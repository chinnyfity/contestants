
        
    
    
    <?php
    $contestants = $this->sql_models->fetchContestants('', 'noexp', '', '', '', ''); 
    $title2 = $contestants[0]['overall_title'];
    if($title2=="")
    $title2 = "No Events Yet";
    ?>

    <link href="<?php echo base_url(); ?>css/video-js.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>js/videojs-ie8.min.js"></script>
    <script src="<?php echo base_url(); ?>js/video.js"></script>
    
    <script>
        $('body').on('contextmenu', '.forumBox4', function(e) {
            e.stopPropagation();
            var ids = $(this).attr('ids');
            $('.copy_texts').hide();
            $('#copy_texts'+ids).fadeIn('fast');
            $('#cover_contents1'+ids).fadeIn('fast');
            return false;
        });

    </script>

	
    <section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col wow_ _fadeInDown ash_color" style="background:#333 !important; border-top:2px solid #888;">
        <div class="icon-default icon-default4">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-white.png" alt=""></a>
        </div>

        
        <div class="container shft_top containerx_">
            <div class="row mobiles">

                <div class="col-md-3 col-sm-5 _col-xs-12 right_menu for_desktop">
                    <div class="blog-left-section" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="blog-left-section1">
                            <div class="blog-left-search blog-common-wide">
                                <form method="post" autocomplete="off" action="javascript:;">
                                    <input type="text" id="txt_srch" placeholder="Search">
                                    <input type="button" name="button" class="cmd_searchs" vals="events" value="&#xf002;">
                                </form>
                            </div>
                            <div class="blog-left-categories blog-common-wide">
                                <h5>Our Events</h5>
                                <ul class="list pageant_lists pageantlists1">
                                <?php
                                if($param1!="pages"){
                                    $directs = base_url()."pages/#viewevents";
                                    $directs1 = "pages/#viewevents";
                                }else{
                                    $directs = "javascript:;";
                                    $directs1 = "";
                                }

                                $event_years = $this->sql_models->fetchEventsByYear();
                                if($event_years){
                                    foreach ($event_years as $rs) {
                                        $years = $rs['year'];
                                        echo "<li class='yrs1'><span class='open_year' directs1='$directs1' ids='$years' titls='$years'>$years Events</span>
                                            <ul class='inner_li'>";

                                            $event_titles = $this->sql_models->fetchEventsTitles($years);
                                            if($event_titles){
                                                foreach ($event_titles as $rs) {
                                                    $id = $rs['id'];
                                                    $titles = ucwords($rs['titles']);
                                                    $titles = str_replace("'", "&rsquo;", $titles);
                                                    echo "<li><a href='$directs' directs1='$directs1' class='open_event' evtid='$id' tils='$titles'>$titles</a></li>";
                                                }
                                            }else{
                                                echo "<li><a href='javascript:;'>No events here yet!</a></li>";
                                            }
                                            echo "</ul>
                                        </li>";
                                    }
                                }else{
                                    echo "<li><a href='javascript:;'>No events yet!</a></li>";
                                }
                                ?>
                                </ul>
                            </div>
                        </div>    
                    </div>
                </div>      


                <div class="col-md-9 col-sm-7 _col-xs-12 left_pics single_blog single_blog1 scrols">
                    <div class="fetchCategoriesConts events1">
                        <?php
                        if($fetch_event){
                            $id = $fetch_event['id'];
                            $titles = strtolower($fetch_event['titles']);
                            $titles_1 = $titles;
                            $titles_1 = str_replace(" ", "-", $titles_1);
                            $titles = ucwords($titles);
                            $titles1 = $titles;
                            $descrip = ucfirst($fetch_event['descrip']);
                            $descrip = nl2br($descrip);
                            $descripi=$descrip;
                            $views = $fetch_event['views'];
                            $dates = $fetch_event['dates'];
                            $mydates = date("jS F, Y", strtotime($dates));
                            $views = @number_format($views);
                            $files = $this->sql_models->getPics($id);
                            if($files)
                                //$pic_path = base_url()."watermark.php?image=".base_url()."events_fols/$files&watermark=".base_url()."images/watermrk.png";
                                $pic_path = base_url()."events_fols/$files";
                            $cmts_counts = $this->sql_models->fetchCommentCounts($id);
                        ?>

                            <?php
                            $gen_num1=time();
                            $gen_num1=substr($gen_num1,6);
                            $url1 = base_url()."viewevents/$id$gen_num1/$titles_1/";
                            $url1_tw = base_url()."viewevents/$id$gen_num1/";
                            $titles = str_replace("#", "", $titles);
                            $tweets = ucwords($titles);
                            $sTitle_whatsapp = ucwords($titles)."%0A%0A$url1";
                            ?>
                                                    
                            <div class="col-md-12 col-sm-12 col-xs-12 expand_width expand_width2 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="blog-right-section">
                                    <div class="blog-right-listing wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                        <div class="other_inner_info forumBox4 nofadediv fadediv<?=$id;?>" ids="<?=$id;?>">
                                            <h5><?=$titles;?></h5>
                                        </div>

                                        <div class="feature-img feature_img feature_img1 event_big_img">
                                            <?php 
                                            if($files)
                                            echo "<img src='$pic_path' alt='' srcs='$pic_path'>";
                                            else
                                            echo "<div style='background:#999; color:#eee; padding:1.3em 10px 4em 10px; text-align:center'>No Media</div>";
                                            ?>

                                            <video id='my_video_1' style='width:100%; cursor: pointer; background-color:#FFF; display:none' class='video-js vjs-default-skin myVideo1 videos2 vidss' controls controlsList='nodownload' preload='auto' data-setup='{ 'asdf': true }' poster='<?php echo base_url(); ?>"images/beauty_contest.jpg' oncontextmenu='return false;'>
                                                <source src='' type='video/mp4'>
                                                <source src='' type='video/webm'>
                                            </video>
                                        </div>
                                        
                                        <p class="event_date event_date1"><label><?=$mydates;?></label></p>
                                        <div class="other_inner_info forumBox4 nofadediv fadediv<?=$id;?>" ids="<?=$id;?>">
                                            <p><?=makeLinks3(ucfirst($descrip));?></p>
                                        </div>

                                        <label id='copyTarget<?=$id;?>' style='display:none'><?=$titles1;?><br><br><?=ucfirst($descripi)."<br><br>".$url1;?></label>
                                        <div class="cover_contents" id="cover_contents1<?=$id;?>"></div>
                                        <div class="copy_texts copy_text_event" ids='<?=$id;?>' id="copy_texts<?=$id;?>"><spans>Copy Text</spans></div>

                                        <?php
                                        $files1 = $this->sql_models->getMorePics($id, $files);
                                        if($files1){
                                            foreach ($files1 as $rows) {
                                                $files_in = $rows['files'];
                                                $pic_path1 = base_url()."events_fols/$files_in";
                                                $exts = substr($pic_path1,-3);
                                                if($files_in)
                                                //$pic_path = base_url()."watermark.php?image=".base_url()."events_fols/$files_in&watermark=".base_url()."images/watermrk.png";

                                                $pic_path = base_url()."events_fols/$files_in";
                                            
                                                echo "<div class='col-md-6 col-sm-12 bottoms expand_width'>
                                                    <div class='item'>";

                                                        if($exts=="mp4" || $exts=="wmv"){
                                                            echo "<a href='javascript:;' class='change_img' srcs='$pic_path1' exts='$exts'>
                                                                    <video id='my_video_1' style='width:100%; cursor: pointer; background-color:#FFF;' class='video-js vjs-default-skin myVideo1 videos2 vidss' controls controlsList='nodownload' preload='auto' data-setup='{ 'asdf': true }' poster='".base_url()."images/beauty_contest.jpg' oncontextmenu='return false;'>
                                                                        <source src='$pic_path1' type='video/mp4'>
                                                                        <source src='$pic_path1' type='video/webm'>
                                                                    </video>
                                                                </a>";
                                                        }else{
                                                            echo "<div class='other_imgs'>";
                                                            if($files_in){
                                                                echo "<a href='javascript:;' class='change_img' srcs='$pic_path'>
                                                                    <img src='$pic_path' srcs='$pic_path' alt=''>
                                                                </a></div>";
                                                            }
                                                        }

                                                    echo "</div>
                                                </div>";
                                            }
                                        }
                                        ?>
                                        <div style="clear:both"></div>

                                        <div class="feature-info_ bottoms1">
                                            <div class="share-tag">
                                                <div class="row">

                                                    <div class="col-md-6 col-sm-6 col-xs-12 bottoms">
                                                        <div class="tag-wrap">
                                                            <span><i class="icon-comment-5"></i> <font class="cmt_counts"><?=$cmts_counts;?> Comments</font></span> &nbsp;
                                                            <span><i class="icon-eye-6"></i> <?=$views;?> Views</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <div class="social-wrap">
                                                            <h5>SHARE</h5>
                                                            <ul class="social">
                                                                <li class="social-facebook"><a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                                <li class="social-tweeter"><a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1_tw;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                                <li class="social-whatsapp mobiles_view"><a class="hitLink" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                                                <li class="social-whatsapp not_mobiles_view"><a class="hitLink" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="comment-blog">
                                            <h3 class="cmt_counts"><?=$cmts_counts;?> Comments</h3>

                                            
                                            <?php $mydates2 = date("jS F, Y h:i A", time()); ?>
                                            <input type="hidden" value="<?=$mydates2;?>" class="auto_dates">
                                            <input type="hidden" value="<?=$cmts_counts;?>" class="txtcmts_cnt">

                                            <div class="java_comment_show_real">
                                                <?php
                                                $fectch_cmts = $this->sql_models->fetchEventComment($id);
                                                if($fectch_cmts){
                                                    foreach ($fectch_cmts as $rs) {
                                                        $names = $rs['names'];
                                                        $replies = $rs['replies'];
                                                        $dates = $rs['dates'];
                                                        $mydates3 = date("jS F, Y h:i A", strtotime($dates));
                                                        ?>
                                                        <div class="comment-inner-list">
                                                            <div class="comment-img">
                                                                <img src="<?php echo base_url(); ?>images/no_passport.jpg" alt="">
                                                            </div>
                                                            <div class="comment-info">
                                                                <h5><?=$names;?></h5>
                                                                <span class="comment-date"><?=$mydates3;?></span>
                                                                <p><?=$replies;?></p>
                                                            </div>
                                                        </div>
                                                        <?php

                                                    }
                                                }else{
                                                    echo "No Comments Yet";
                                                }

                                                ?>
                                                
                                            </div>

                                            <div class="comment-inner-list java_comment_show" style="display:none">
                                                <div class="comment-img">
                                                    <img src="<?php echo base_url(); ?>images/no_passport.jpg" alt="">
                                                </div>
                                                <div class="comment-info">
                                                    <h5 class="user_names">xxxxxxx</h5>
                                                    <span class="comment-date user_dates">xxxxxxx</span>
                                                    <p class="user_comments">xxxxxx</p>
                                                </div>
                                            </div>

                                            <div style="clear:both"></div>

                                            <br>
                                            <div class="comment_section">
                                                <h3>Comment on this event</h3>
                                                <form class="form" id="form_comments" method="post" name="form" autocomplete="off">
                                                    <input type="hidden" value="<?=$id;?>" name="txtevent_id"> 
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <textarea placeholder="Comment" id="txtcmts" name="txtcmts"></textarea>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" name="txtnms" id="txtnms" style="text-transform:capitalize" placeholder="Your Name">
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="email" name="txtmails" id="txtmails" style="text-transform:lowercase" placeholder="Your Email">
                                                            <p style="margin:-2em 0 10px 8px; text-align:center; font-size:14px; color:#999;">Your email will never be visible to the public</p>
                                                        </div>
                                                        <div style="clear:both"></div>
                                                        
                                                        <div class="err_login"></div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="button" name="submit" id="cmd_post_cmt" value="POST COMMENT" class="btn-black center-block">
                                                            <input type="button" name="submit" id="cmd_post_cmt1" value="POSTTING..." class="btn-black center-block btn-blacks" style="display:none; opacity:0.5;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>

                        <?php
                        }else{
                            echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No events on this title selected!</p>";
                        }
                        ?>
                    </div>
                </div>
                <div style="clear:both"></div>

            </div>
        </div>

    </section>
    
        
        