
        

        
    <?php
    $evnt = $this->sql_models->fetchEventsByYear(); 
    $title2 = $evnt[0]['year'];
    if($title2=="") $title2 = "No Events Yet"; else $title2 = "$title2 Events";
    ?>

    
    <section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col wow_ _fadeInDown ash_color" style="background:#333 !important; border-top:2px solid #888;">
        <div class="icon-default icon-default4">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-white.png" alt=""></a>
        </div>

        
        <p class="pageant_title pageant_title1 for_mobile"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px">
         &nbsp;<font class="cat_title"><?=$title2;?></font></p>
         
        <div class="container shft_top">
            <div class="row mobiles">

                <div class="col-md-3 col-sm-5 _col-xs-12 right_menu">
                    <div class="blog-left-section blog_left_section" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="blog-left-section1">
                            <div class="blog-left-search blog-common-wide">
                                <form method="post" autocomplete="off" action="javascript:;">
                                    <input type="text" id="txt_srch_events" placeholder="Search">
                                    <input type="button" name="button" class="cmd_searchs" vals="events" value="&#xf002;">
                                </form>
                            </div>
                            <div class="blog-left-categories blog-common-wide">
                                <h5>Our Events</h5>
                                <ul class="list pageant_lists pageantlists1">
                                <?php
                                if($param1!="pages"){
                                    $directs = base_url()."pages/#events";
                                    $directs1 = "pages/#events";
                                }else{
                                    $directs = "javascript:;";
                                    $directs1 = "";
                                }

                                $event_years = $this->sql_models->fetchEventsByYear();
                                if($event_years){
                                    foreach ($event_years as $rs) {
                                        $years = $rs['year'];
                                        echo "<li class='yrs1'><span class='open_year' param1='$param1' directs1='$directs1' ids='$years' titls='$years'>$years Events</span>
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


                <div class="col-md-9 col-sm-7 _col-xs-12 left_pics">

                    <div class="fetchCategoriesConts events1">
                        <p class="pageant_title for_desktop show_back_title"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px"> 
                        &nbsp;<font class="cat_title"><?=$title2;?></font></p>

                        <p class="copyrgt">All our photos here belong to us and may be subject to copyright</p>
                        <div style="clear:both"></div>

                        <?php
                        if($events1){
                        ?>
                            <div class="blog-right-section event_paginatn">
                                <div class="row page-wrap group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 expand_width expand_width_events">
                                        <div class="blog-right-section">
                                            <div class="row load_contents">

                                                <?php
                                                foreach ($events1 as $rs) {
                                                    $id = $rs['id'];
                                                    $titles = strtolower($rs['titles']);
                                                    $titles_1 = $titles;
                                                    $titles_1 = str_replace(" ", "-", $titles_1);
                                                    $titles = ucwords($titles);
                                                    $titles1 = $titles;
                                                    $descrip = ucfirst($rs['descrip']);
                                                    $descripi=$descrip;
                                                    $views = $rs['views'];
                                                    $dates = $rs['dates'];
                                                    $mydates = date("jS F, Y", strtotime($dates));
                                                    $views = @number_format($views);
                                                    $files = $this->sql_models->getPics($id);
                                                    $cmts_counts = $this->sql_models->fetchCommentCounts($id);
                                                    if(strlen($descrip)>150)
                                                        $descrip = substr($descrip, 0, 150)."...";

                                                    if(strlen($titles)>37)
                                                        $titles = substr($titles, 0, 37)."...";

                                                    //$pic_path = base_url()."watermark.php?image=".base_url()."events_fols/$files&watermark=".base_url()."images/watermrk.png";

                                                    $pic_path = base_url()."events_fols/$files";

                                                    if($param1!="pages"){
                                                        $directs = base_url()."pages/#viewevents";
                                                        $directs1 = "pages/#viewevents";
                                                    }else{
                                                        $directs = "javascript:;";
                                                        $directs1 = "";
                                                    }

                                                    $gen_num1=substr(time(),6);
                                                    $url1 = base_url()."viewevents/$id$gen_num1/$titles_1/";
                                                ?>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 wow fadeInDown scroll_to_mem<?=$id;?>" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                        <div class="blog-right-listing blog-right-listing2">
                                                            <font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer; position:relative; z-index:99">
                                                                <div class="feature-img feature-img1">
                                                                    <?php
                                                                    if($files!="")
                                                                    echo "<img src='$pic_path' alt='Image loading...'>";
                                                                    else
                                                                    echo "<p style='padding:2.3em 10px; font-size:2em; text-align:center; color:#999;'><b>No Media</b></p>";
                                                                    ?>
                                                                </div>
                                                            </font>
                                                            <div class="event_date"><label><?=$mydates;?></label></div>
                                                            <div class="feature-info feature-info1 feature_info_evnt">
                                                                <div class="forumBox5 nofadediv fadediv<?=$id;?>" ids="<?=$id;?>">
                                                                    <h5><font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer;"><?=$titles;?></font></h5>
                                                                    <p>
                                                                        <font class="open_event" directs1="<?=$directs1;?>" evtid="<?=$id;?>" tils="<?=$titles1;?>" style="cursor:pointer;">
                                                                            <?=makeLinks3(ucfirst($descrip));?>
                                                                            <br><a href="javascript:;" style="font-weight:normal; color:#69C;">read more<i class="icon-right-4"></i></a>
                                                                        </font>
                                                                    </p>
                                                                </div>
                                                                
                                                                <label id='copyTarget<?=$id;?>' style='display:none'><?=$titles1;?><br><br><?=ucfirst($descripi)."<br><br>".$url1;?></label>
                                                                <div class="cover_contents" id="cover_contents1<?=$id;?>"></div>
                                                                <div class="copy_text" ids='<?=$id;?>' id="copy_text<?=$id;?>"><spans>Copy Text</spans></div>

                                                                <p class="statss">
                                                                <?php
                                                                if($cmts_counts>0)
                                                                echo "<span class='open_event' directs1='$directs1' evtid='$id' tils='$titles1' style='cursor:pointer; opacity:0.9;'><i class='icon-comment-5'></i> $cmts_counts Comments</span>";
                                                                else
                                                                echo "<span style='opacity:0.7;'><i class='icon-comment-5'></i> No Comments</span>";

                                                                if($views>0)
                                                                echo "<span class='open_event' directs1='$directs1' evtid='$id' tils='$titles1' style='cursor:pointer; opacity:0.9;'><i class='icon-eye-6'></i> $views Views</span>";
                                                                else
                                                                echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> No Views</span>";
                                                                ?>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php 
                                                }
                                                ?>

                                                <div style="clear:both"></div>

                                                
                                                <?=$pagination;?>

                                            </div>
                                        </div>
                                    </div>


                                    <div style="clear:both"></div>

                                </div>
                            </div>
                        <?php
                        }else{
                            echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No events on the title selected!</p>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>

    </section>
    
        
        