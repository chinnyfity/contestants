  
        
    
    <?php if($page_name == "viewreplies"){ ?>
        <script type='text/javascript' src='<?=base_url(); ?>js/jquery-1.7.1.min.js'></script>
    <?php } ?>
    
    <script src="<?=base_url(); ?>js/jscripts1.js"></script>
    <script>
        var site_urls = $('#txtsite_url').val();
        $(".uploadimage1_forum_rep").on('submit',(function(e) {
            e.preventDefault();
            $(".errs_rep").hide();
            var selecteds1 = retrieve_cookie('selected_file1');
            var edit_ids = $('#edit_ids').val();
            var memid_rep = $('#memid_rep').val();
            var txtrep_cnts = $('#txtrep_cnts').val();
            var new_cnt = parseInt(txtrep_cnts)+1;
            
            if($('#post_content_rep').val() != '' || selecteds1 == 1){ // 1 means u uploaded a file
                $("#cmdPosts_rep").hide();
                $("#cmdPosts_rep1").show();
                $(".hide_txtbox_rep").fadeIn('fast');
                $.ajax({
                    url : site_urls+"node/post_comments_rep",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        if(data=="inserted" || data=="updateds"){
                            $('#txtrep_cnts').val(new_cnt);
                            $('.newcount').html(new_cnt);
                            $("#form3")[0].reset();
                            $("#cmdPosts_rep1").hide();
                            $("#cmdPosts_rep").show();
                            bringProducts_rep(memid_rep);
                            $('#selectedCaption1_rep').empty().html('No file selected');
                            setTimeout(function(){
                                $(".hide_txtbox_rep").fadeOut('fast');
                            },800);
                        }else{
                        
                            $("#cmdPosts_rep1").hide();
                            $("#cmdPosts_rep").show();
                            $(".errs_rep").fadeIn('fast').html('<div class="Errormsg" style="margin:10px 0 1em 0;">'+data+'</div>');
                            setTimeout(function(){
                            $(".hide_txtbox_rep").fadeOut('fast');
                            },500);
                        }
                    
                    },error : function(data){
                        $(".errs_rep").fadeIn('fast').html('<div class="Errormsg" style="margin:10px 0 1em 0;">Error! Network Connection Failed!</div>');
                        $("#cmdPosts_rep1").hide();
                        $("#cmdPosts_rep").show();
                        $(".hide_txtbox_rep").fadeOut('fast');
                    }
                });
            }else{
                $(".errs_rep").fadeIn('fast').html('<div class="Errormsg" style="margin:10px 0 1em 0;">Please reply on this or upload an image.</div>');
            }
        }));


        $('#load_more_mba_rep').live("click",function(){
            var page = $(this).data('val');
            var fr_ids = $('#fr_ids').val();
            var txtmemsid = $('#memid_rep').val();
            
            $('#load_more_mba_rep').hide();
            $('#load_more_mba_rep1').show();
            var datastring='page='+page
            +'&txtmemsid='+txtmemsid
            +'&fr_ids='+fr_ids;
            
            $.ajax({
                type : "POST",
                url : site_urls+"node/getForums_reps",
                data : datastring,
                cache : false,
                success : function(data){
                var responseReturn = data.match(/Edit this post/g);
                
                if(responseReturn != null){
                    $("#ajax_table_forum_rep").append(data);
                    $('.load_more_bt_rep').data('val', ($('.load_more_bt_rep').data('val')+1));
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                }else{
                    $('#load_more_mba_rep').hide();
                    $('#load_more_mba_rep1').show();
                    $('.load_more_bt_rep').html('<font style="color:#666 !important;">No more replies!</font>');
                }

                },error : function(data){
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                }
            });
        });


        $(document).ready(function(){
            var page = 0;
            var txtparams = $('#txtparams').val();
            var txtmemsid = $('#memid_rep').val();
            $('#load_more_mba_rep').hide();
            $('#load_more_mba_rep1').show();
            var fr_ids = $('#fr_ids').val();
            var datastring1='page='+page
            +'&fr_ids='+fr_ids
            +'&txtmemsid='+txtmemsid;
            $(".loaders_rep").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");
            $.ajax({
                type : "POST",
                url : site_urls+"node/getForums_reps",
                data : datastring1,
                cache : false,
                success : function(data){
                    var responseReturn = data.match(/Delete this/g);
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                    if(responseReturn != null){
                        if(data.match(/^.*No saved.*$/)){
                            $('.load_more_bt_rep').hide();
                        }else{
                            $('#load_more_mba_rep').data('val', ($('#load_more_mba_rep').data('val')+1));
                        }
                        $("#ajax_table_forum_rep").empty().append(data);
                        $(".loaders_rep").hide();
                    }else{
                        $('#load_more_mba_rep').hide();
                        $('#load_more_mba_rep1').show();
                        $('.load_more_bt_rep').html('<font style="color:#666 !important;">No more replies!</font>');
                        $("#ajax_table_forum_rep").empty().append(data);
                        $(".loaders_rep").hide();
                    }
                    
                },error : function(data){
                    $(".loaders_rep").hide();
                    $('#load_more_mba_rep').show();
                    $('#load_more_mba_rep1').hide();
                }
            });


            
            $('body').on('contextmenu', '.forumBox4', function(e) {
                e.stopPropagation();
                var ids = $(this).attr('ids');
                $('.copy_texts').hide();
                $('#copy_texts'+ids).fadeIn('fast');
                $('#cover_contents1'+ids).fadeIn('fast');
                return false;
            });


        });


    </script>

    <section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col ash_color2" style="background:#fff !important; border-top:2px solid #666;">
        <div class="icon-default icon-default2">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
        </div>

        
        <p class="for_mobile"></p>
        <div class="container shft_top">
            <div class="row mobiles">

                <div class="col-md-3 col-sm-3 col-xs-12 right_menu pagent_botm for_desktop">
                    <div class="blog-left-section blog-left-sectioni blog_left_section" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="blog-left-section1 blog-left-section1i">
                            <div class="blog-left-search blog-common-wide">
                                <form method="post" autocomplete="off" action="javascript:;">
                                    <input type="text" id="txt_srch_forum" placeholder="Search">
                                    <input type="button" name="button" class="cmd_searchs" vals="forums" value="&#xf002;">
                                </form>
                            </div>
                            <div class="blog-left-categories blog-common-wide">
                                <h5>Category</h5>
                                <?php
                                $directs = "javascript:;";
                                $directs1 = "";
                                ?>
                                <ul class="pageant_lists pageantlists2 open_cats">
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' class='forums' ids='0' titls='All Threads'>All Threads</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='1' titls='General Discussion'>General Discussion</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='2' titls='Job Posting'>Job Posting</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='3' titls='Entertainments'>Entertainments</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='4' titls='Talents'>Talents</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='5' titls='Sex & Relationships'>Sex & Relationships</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='6' titls='Kitchen'>Kitchen</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='7' titls='Games'>Games</a></li>
                                </ul>
                            </div>
                        </div>    
                    </div>
                </div>
                
				<input type="hidden" id="txtcats1" value="0">   


                <div class="col-md-8 col-sm-9 col-xs-12 left_pics txtcreate_topic">
                    <p class="for_desktop">&nbsp;</p>
                    
                    <?php
                    // function makeLinks2($str) {
                    //     $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
                    //     if(preg_match($reg_exUrl, $str, $url)) {                    
                    //         if(strpos( $url[0], ":" ) === false){
                    //             $link = 'http://'.$url[0];
                    //         }else{
                    //             $link = $url[0];
                    //         }
                    //         $str = preg_replace($reg_exUrl, '<span href="javascript:;" style="color:#09C; display:inline !important">link removed</span>', $str);
                    //     }
                    //     return $str;
                    // }

                    // function makeLinks3($str) {
                    //     $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
                    //     $star_sign = "/\*(.*?)\*/";
                    //     if(preg_match($reg_exUrl, $str, $url)) {                    
                    //         if(strpos( $url[0], ":" ) === false){
                    //             $link = 'http://'.$url[0];
                    //         }else{
                    //             $link = $url[0];
                    //         }
                    //         $str = preg_replace($reg_exUrl, '<a href="'.$link.'" target="_blank" style="color:#09C; display:inline !important">'.$link.'</a>', $str);
                    //     }
                    //     $str = preg_replace($star_sign, '<b style="font-size:15px; color:#06C">$1</b>', $str);
                    //     return $str;
                    // }
                    ?>

                    <div class="scrols1">
                        <?php
                        if($forums){
                            $id1 = $forums['id'];
                            $fname = $forums['fname'];
                            $lname = $forums['lname'];
                            $topics = $forums['topics'];
                            $messages = nl2br($forums['messages']);
                            $messagesi = $messages;
                            $files = $forums['files'];
                            $views = $forums['views'];
                            $pics = $forums['pics'];
                            $views = @number_format($views);
                            $dates = $forums['dates'];
                            $ful_name = ucwords("$fname $lname");
                            //$pic_path = base_url()."watermark.php?image=".base_url()."forum_files/$files&watermark=".base_url()."images/watermrk.png";

                            $pic_path = base_url()."forum_files/$files";

                            if($topics==1) $ttls = "General Discussion";
                            else if($topics==2) $ttls = "Job Posting";
                            else if($topics==3) $ttls = "Entertainments";
                            else if($topics==4) $ttls = "Talents";
                            else if($topics==5) $ttls = "Sex & Relationships";
                            else if($topics==6) $ttls = "Kitchen";
                            else if($topics==7) $ttls = "Games";
                            else $ttls = "All Threads";
                            //$path_pics = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";
                            $path_pics = base_url()."celebs_uploads/$pics";
                            $replies_cnt = $this->sql_models->replyCounts($id1);
                            $replies_cnti = $replies_cnt;
                            $replies_cnt = @number_format($replies_cnt);
                            ?>
                            <p></p>
                            <div id='forumBox2_' class="forumBox4" ids="<?=$id1;?>">
                                <div id="forumBox">
                                    <div class="first_sec nofadediv fadediv<?=$id1;?>">
                                        <div class="forum_img">
                                            <img src='<?=$path_pics;?>' alt='image' style='border-radius:30px; border:1px #999 solid; width:45px; height:45px;'>
                                        </div>

                                        <div class="forum_contents">
                                            <div class="for_dates">
                                                <p style="font-size:15px; color:#8A8A00"><b><a href="javascript:;" style="color:#8A8A00;"><?=$ful_name;?></a></b>
                                                    <font style="font-size:14px; margin-left:5px; color:#555"><?=time_ago($dates);?> <img src="<?=base_url()?>images/clock.gif" style="position:relative; top:-1px;"></font>
                                                </p>
                                                <p style="font-size:14px; color:#666; margin-top:-5px;">
                                                    <b>Category:</b> <font style="margin-left:4px;"><?=$ttls;?></font>
                                                </p>
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        $gen_num1=time();
                                        $gen_num1=substr($gen_num1,6);
                                        $url1 = base_url()."replies/$id1$gen_num1/";
                                        $messages = str_replace("#", "", $messages);
                                        $tweets = $messages;
                                    ?>

                                    <div class="row_contents row_contents1">
                                        <?php if($files!=""){ ?>
                                            <div class="cmt_img cmt_img1 col-md-12 col-sm-12 col-xs-12 nofadediv fadediv<?=$id1;?>">
                                                <span><img src='<?=$pic_path;?>' alt='image'></span>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 containerx nofadediv fadediv<?=$id1;?>">
                                                <span>
                                                    <?php
                                                    if($topics==2) // if its job, allow links
                                                        echo makeLinks3(ucfirst($messages));
                                                    else
                                                        echo makeLinks2(ucfirst($messages));
                                                    ?>
                                                </span>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12 containerx nofadediv fadediv<?=$id1;?>">
                                                <span>
                                                <?php
                                                if($topics==2) // if its job, allow links
                                                    echo makeLinks3(ucfirst($messages));
                                                else
                                                    echo makeLinks2(ucfirst($messages));
                                                ?>
                                                </span>
                                            </div>
                                        <?php } ?>
                                        
                                        <label id='copyTarget<?=$id1;?>' style='display:none'>
                                            <?php
                                            if($topics==2)
                                                echo makeLinks3(ucfirst($messagesi))."<br><br>".$url1;
                                            else
                                                echo makeLinks2(ucfirst($messagesi))."<br><br>".$url1;
                                            ?>
                                        </label>
                                        <div class="cover_contents" id="cover_contents1<?=$id1;?>"></div>
                                        <div class="copy_texts" ids='<?=$id1;?>' id="copy_texts<?=$id1;?>"><spans>Copy Text</spans></div>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 comment_stats nofadediv fadediv<?=$id1;?>">
                                        <div class="col-md-4 col-sm-4 col-xs-4 for_cmts">
                                            <input type="hidden" name="txtrep_cnts" id="txtrep_cnts" value="<?=$replies_cnti;?>">
                                            <i class="fa fa-comment fa_comment"></i> <spans class="newcount"><?=$replies_cnt;?></span>
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-4 col-xs-4" style="backgrounds:blue">
                                            <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><img src="<?=base_url()?>images/facebook.png"></a> &nbsp;&nbsp;
                                            <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><img src="<?=base_url()?>images/twitter1.png"></a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <?=$views;?> views
                                        </div>
                                    </div>
                                </div>

                                <div class="small_comments inputboxes">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="for_dates_">
                                            <form method="post" id="form3" class="uploadimage1_forum_rep" enctype="multipart/form-data" autocomplete="off">
                                                <input type="hidden" name="memid_rep" id="memid_rep" value="<?=$get_mems_id;?>">
                                                <input type="hidden" name="fr_ids" id="fr_ids" value="<?=$frids;?>">

                                                <div class="hide_txtbox_rep" style="display:none;">
                                                    <p style="margin-top:1.6em; font-size:0.9em; color:#444"><img src='<?=base_url()?>images/loader.gif' style='width:40px !important;' alt='Loading'/><br>Uploading...</p>
                                                </div>

                                                <p class="main_cmts reply_cmt reply_cmt1">
                                                    <textarea id="post_content_rep" name="post_content_rep" placeholder="Reply this..."></textarea>
                                                    <div id='imgpreview1_rep'></div>
                                                    <div style="clear:both"></div>
                                                    <div class="errs_rep"></div>
                                                    <div class="button_events buttonevent">
                                                        <?php
                                                        if($validate_mem)
                                                        echo '<input type="submit" id="cmdPosts_rep" value="Reply this" class="btn_">';
                                                        else
                                                        echo '<input type="button" id="cmdnoPosts" value="Reply this" style="opacity:0.5;">';
                                                        ?>
                                                        <input type="button" id="cmdPosts_rep1" value="Reply this" style="opacity:0.6; display:none">
                                                        <?php if($validate_mem){ ?>
                                                            <span id="uploadfiles1_rep"><img style="cursor:pointer;" src="<?=base_url();?>images/upload1.png"></span>
                                                        <?php }else{ ?>
                                                            <span id="cmdnoPosts"><img style="cursor:pointer;" src="<?=base_url();?>images/upload1.png"></span>
                                                        <?php } ?>
                                                        <span style="margin:5px 0 3px 7px; float:none;"><label style="font-size:14px; color:#555;" id="selectedCaption1_rep">(No file selected)</label></span>
                                                    </div>
                                                    <input type="file" id="file4_rep" name="file4_rep" style="font-size:0.9em; visibility:hiddens; display:none;">
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>

                            </div>
                            <div style="clear:both"></div>

                            <div class="loaders_rep" style="position:relative; text-align:center; color:#777; bottom:1em; margin:2em 0 -5em 0; z-index:9999; font-style:italic;"></div>
                            <div id="ajax_table_forum_rep">
                            </div>

                            <div style="clear:both"></div>
                            <a href="javascript:;" class="load_more_bt_rep wow fadeIn" id="load_more_mba_rep" data-val = "0" data-wow-delay="0.2s">Load more replies </a>
            		        <a href="javascript:;" class="load_more_bt_rep wow fadeIn" id="load_more_mba_rep1" style="color:#ccc; display:none;" data-wow-delay="0.2s"><i>Loading...</i> <img src="<?php echo str_replace('index.php','',base_url()) ?>images/loader.gif" width="18"> </a>

                            <?php
                            }else{
                                echo "<p style='font-size:15px; text-align:center; color:#555; padding-top:15px'>No posts found on your search, redefine your search to find what you are looking for.</p>";
                            }
                            ?>
                    </div>
					<input type="hidden" class="successm" style="display:nones;">
                </div>
            </div>
        </div>
    </section>
    
        
        