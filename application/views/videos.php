
<section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col wow_ _fadeInDown ash_color" style="background:#333 !important; border-top:2px solid #888;">
    <div class="icon-default icon-default4">
        <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-white.png" alt=""></a>
    </div>
    
    <p class="pageant_title pageant_title1 for_mobile"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px">
     &nbsp;<font class="cat_title">Our Videos</font></p>
    <div class="container shft_top shft_top_vids">
        <div class="row mobiles">

            <div class="col-md-12 col-sm-12 left_pics">

                <div class="events1">
                    <p class="pageant_title for_desktop show_back_title"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px"> 
                    &nbsp;<font class="cat_title">Our Videos</font></p>

                    <p class="copyrgt copyrgt1">All our videos here belong to us and may be subject to copyright</p>
                    <div style="clear:both"></div>

                    <div class="col-md-offset-2 col-md-8 for_srchs">
                        <div class="blog-left-search blog-common-wide">
                            <form method="post" autocomplete="off" action="javascript:;">
                                <input type="text" id="txt_srch_vids" placeholder="Search">
                                <input type="button" name="button" class="cmd_searchs" vals="videos" value="&#xf002;">
                            </form>
                        </div>
                    </div>
                    <br>

                    <div class="fetchCategoriesConts">
                        <?php
                        if($photos){
                        ?>
                            <div class="blog-right-section">
                                <div class="row page-wrap group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 expand_width expand_width_video">
                                        <div class="blog-right-section">
                                            <div class="row_ load_gallerys">
                                                <?php
                                                foreach ($photos as $rs) {
                                                    $titles = strtolower($rs['titles']);
                                                    $titles = ucwords($titles);
                                                    $views = $rs['views'];
                                                    $viewsi = $views;
                                                    $id2 = $rs['id'];
                                                    $files = $rs['files'];
                                                    $views = @number_format($views);
                                                    if(strlen($titles)>70)
                                                        $titles = substr($titles, 0, 70)."...";
                                                ?>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 pl-xs-20 pr-xs-25 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                        <div class="blog-right-listing blog_right_listing_vid listings">
                                                            <div class="gallery-megic-blog youtubevid" ids="<?=$id2;?>">

                                                                <iframe src="https://www.youtube.com/embed/<?=$files;?>" class="youtubevid2" ids="<?=$id2;?>" frameborder="0" allowfullscreen></iframe>
                                                                <div class="gallery-megic-detail_ vid_titles">
                                                                    <p><?=$titles;?></p>
                                                                    <font class="statss">
                                                                        <input type="hidden" value="<?=$viewsi;?>" id="vid_views<?=$id2;?>">
                                                                        <?php
                                                                        if($viewsi>0)
                                                                        echo "<span><i class='icon-eye-6'></i> <spans class='vd_views".$id2."'>$views</spans> Views</span>";
                                                                        else
                                                                        echo "<span style='opacity:0.7;'><i class='icon-eye-6'></i> <spans class='vd_views".$id2."'>No</spans> Views</span>";
                                                                        ?>
                                                                    </font>
                                                                </div>
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
                            echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No videos on this title selected!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

    
    