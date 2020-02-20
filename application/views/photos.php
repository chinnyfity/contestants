
<section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col wow_ _fadeInDown ash_color" style="background:#333 !important; border-top:2px solid #888;">
    <div class="icon-default icon-default4">
        <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-white.png" alt=""></a>
    </div>
    
    <p class="pageant_title pageant_title1 for_mobile"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px">
     &nbsp;<font class="cat_title">Our Photos</font></p>
     
    <div class="container shft_top shft_top_photo">
        <div class="row mobiles">

            <div class="col-md-12 col-sm-12 left_pics">

                <div class="events1">
                    <p class="pageant_title for_desktop show_back_title"><img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px"> 
                    &nbsp;<font class="cat_title">Our Photos</font></p>

                    <p class="copyrgt copyrgt1 pb-sm-30">All our photos here belong to us and may be subject to copyright</p>
                    <div style="clear:both"></div>

                    <div class="big_img_div" title="Close" style="display:none;">
                        <div class="item_tblcell">
                            <div class="close_img" title="Close"><span class="fa-fa-user">X</span></div>
                            <img src="">
                        </div>
                    </div>

                    <div class="col-md-offset-2 col-md-8 for_srchs pb-sm-10">
                        <div class="blog-left-search blog-common-wide">
                            <form method="post" autocomplete="off" action="javascript:;">
                                <input type="text" id="txt_srch_phs" placeholder="Search Photos">
                                <input type="button" name="button" class="cmd_searchs" vals="photos" value="&#xf002;">
                            </form>
                        </div>
                    </div>

                    <div class="fetchCategoriesConts">
                    <?php
                    if($photos){
                    ?>
                        <div class="blog-right-section event_paginatn">
                            <div class="row page-wrap group">
                                <div class="col-md-12 col-sm-12 col-xs-12 expand_width">
                                    <div class="blog-right-section">
                                        <div class="row_ load_gallerys">
                                            <?php
                                            foreach ($photos as $rs) {
                                                $id = $rs['id'];
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
                                                <div class="col-md-3 col-sm-12 col-xs-12 mb-sm-20 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                    <div class="blog-right-listing blog-right-listing3">
                                                        <div class="gallery-megic-blog">
                                                            <a href="javascript:;" src1="<?=$pic_path1;?>" src="<?=$pic_path1;?>" ids="<?=$id;?>" class="magnific-popup enlarge_img">
                                                                <img src="<?=$pic_path1;?>" alt="Image Error" class="norightclicks">
                                                                <div class="gallery-megic-inner">
                                                                    <div class="gallery-megic-out">
                                                                        <div class="gallery-megic-detail">
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
                        echo "<p style='text-align:center; font-size:18px; padding:2em 10px;'>No events on this title selected!</p>";
                    }
                    ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

    
    