  
    <script src="<?php echo base_url(); ?>js/jscripts1.js"></script>
    <script>
        $(".uploadimage1_forum").on('submit',(function(e) {
            e.preventDefault();
            $(".errs").hide();
            var counters = retrieve_cookie('counters');
            var selecteds1 = retrieve_cookie('selected_file1');
            var edit_ids = $('#edit_ids').val();
            if($('#post_content').val() != '' || selecteds1 == 1){
                $("#cmdPosts").hide();
                $("#cmdPosts1").show();
                $(".hide_txtbox").fadeIn('fast');
                $.ajax({
                    url : site_urls+"node/post_comments",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        if(data=="inserted" || data=="updateds"){
                            bringProducts(edit_ids);

                            setTimeout(function(){
                                $("#form2")[0].reset();
                                $('.txtselectcat').fadeOut('fast');
                                $('.textareas').slideUp('fast');
                                $('#txt_srch_forum1').hide();
                                $('.clickforum').show();

                                $("#cmdPosts1").hide();
                                $("#cmdPosts").show();
                            },200);

                            create_cookie('selected_file1', 0);
                            $('#selectedCaption1').empty().html('No file selected');
                            setTimeout(function(){
                                $(".hide_txtbox").fadeOut('fast');
                                
                            },300);
                        }else{
                        
                            $("#cmdPosts1").hide();
                            $("#cmdPosts").show();
                            $(".errs").fadeIn('fast').html('<div class="Errormsg" style="margin:-20px 0 30px 0;">'+data+'</div>');
                            setTimeout(function(){
                            $(".hide_txtbox").fadeOut('fast');
                            },800);
                        }
                    
                    },error : function(data){
                        $(".errs").fadeIn('fast').html('<div class="Errormsg" style="margin:-20px 0 30px 0;">Error! Network Connection Failed!</div>');
                        $("#cmdPosts1").hide();
                        $("#cmdPosts").show();
                        $(".hide_txtbox").fadeOut('fast');
                    }
                });
            }else{
                $(".errs").fadeIn('fast').html('<div class="Errormsg" style="margin:-20px 0 30px 0;">Please write a comment or upload an image.</div>');
            }
        }));


        $('.cancel_posts').live("click",function(){
            $("#form2")[0].reset();
            $('.txtselectcat').fadeOut('fast');
            $('.textareas').slideUp('fast');
            $('#txt_srch_forum1').hide();
            $('.clickforum').show();
            $('#selectedCaption1').empty().html('No file selected');
            $(".errs").hide();
        });


        $('#load_more_mba').live("click",function(){
            var page = $(this).data('val');
            var txtcats1 = $('#txtcats1').val();
            var txtparams = $('#txtparams').val();
            var txtmemsid = $('#txtmemsid').val();
            var txt_srch = retrieve_cookie('txt_srch');
            if(txt_srch=="" || txt_srch=="undefined") var txt_srch = "";

            if(txtcats1=="")
            var txtcats1 = retrieve_cookie('cats_f');

            $('#load_more_mba').hide();
            $('#load_more_mba1').show();
            var datastring='page='+page
            +'&txtparams='+txtparams
            +'&txt_srch='+txt_srch
            +'&txtmemsid='+txtmemsid
            +'&txtcats1='+txtcats1;
        
            $.ajax({
                type : "POST",
                url : site_urls+"node/getForums",
                data : datastring,
                cache : false,
                success : function(data){
                var responseReturn = data.match(/Edit this post/g);
                if(responseReturn != null){
                    $("#ajax_table_forum").append(data);
                    $('.load_more_bt').data('val', ($('.load_more_bt').data('val')+1));
                    $('#load_more_mba').show();
                    $('#load_more_mba1').hide();
                }else{
                    $('#load_more_mba').hide();
                    $('#load_more_mba1').show();
                    $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more posts!</font>');
                }

                },error : function(data){
                    $('#load_more_mba').show();
                    $('#load_more_mba1').hide();
                }
            });
        });



        //var page = 0;
        var txtparams = $('#txtparams').val();
        $('#load_more_mba').hide();
        $('#load_more_mba1').show();
        var txtcats1 = retrieve_cookie('cats_f');
        var txtmemsid = $('#txtmemsid').val();
        var page = retrieve_cookie('page_load');
        if(txtcats1=="") var txtcats1 = $('#txtcats1').val();
        if(page=="" || page=="undefined") var page = 0;
        
        var datastring1='page='+page
        +'&txtparams='+txtparams
        +'&txtmemsid='+txtmemsid
        +'&txtcats1='+txtcats1;
        $(".loaders_").show().html("Loading forum...<br><img src='"+site_urls+"images/loader.gif'>");
        $.ajax({
            type : "POST",
            url : site_urls+"node/getForums",
            data : datastring1,
            cache : false,
            success : function(data){
                var responseReturn = data.match(/Edit this post/g);
                $('#load_more_mba').show();
                $('#load_more_mba1').hide();
                if(responseReturn != null){
                    $(".successm").val(data);
                    if($(".successm").val().match(/^.*No saved.*$/)){
                        $('.load_more_bt').hide();
                    }else{
                        $('#load_more_mba').data('val', ($('#load_more_mba').data('val')+1));
                    }
                    $("#ajax_table_forum").empty().append(data);
                }else{
                    $('#load_more_mba').hide();
                    $('#load_more_mba1').show();
                    $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more posts!</font>');
                    $("#ajax_table_forum").empty().append(data);
                }
                $(".loaders_").hide();
            },error : function(data){
                $(".loaders_").hide();
                $('#load_more_mba').show();
                $('#load_more_mba1').hide();
            }
        });
    </script>

    <section id="reach-to" class="dishes1 home-icon blog-main-section text-center_ blog-main-2col ash_color2" style="background:#fff !important; border-top:2px solid #666;">
        <div class="icon-default icon-default2">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
        </div>

        
        <p class="for_mobile"></p>
        <div class="container shft_top shft_top_forum">
            <div class="row mobiles">

                <div class="col-md-3 col-sm-3 col-xs-12 right_menu pagent_botm mobile_cats">
                    <div class="blog-left-section blog-left-sectioni blog_left_section" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="blog-left-section1 blog-left-section1i">
                            <div class="blog-left-search blog-common-wide">
                                <form method="post" autocomplete="off" action="javascript:;">
                                    <input type="text" id="txt_srch_forum" class="txt_srch_forums" placeholder="Click to search forum">
                                    <input type="button" name="button" class="cmd_searchs" vals="forums" value="&#xf002;">
                                </form>
                            </div>
                            <div class="blog-left-categories blog-common-wide">
								<h5>Category <label class="mini_div">(Minimize this)</label></h5>
								<?php
                                    $directs = "javascript:;";
                                    $directs1 = "";
								?>
								
                                <ul class="pageant_lists pageantlists2 open_cats">
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='0' titls='All Threads'>All Threads</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='1' titls='General Discussion'>General Discussion</a></li>
									<li><a href='<?=$directs;?>' directs1='<?=$directs1;?>' ids='2' titls='Jobs & Vacancies'>Job Posting</a></li>
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
				<input type="hidden" id="txtparams" value="<?=$param1;?>">

                <div class="col-md-8 col-sm-9 col-xs-12 left_pics txtcreate_topic txtcreate_topic1">
                    <p class="for_desktop scrols">&nbsp;</p>

					<div class="blog-left-search blog-common-wide btn_house" style="position:relative; z-index:999;">
						<form method="post" id="form2" class="uploadimage1_forum" enctype="multipart/form-data" autocomplete="off">
							<input type="hidden" name="txtmemsid" id="txtmemsid" value="<?=$get_mems_id;?>">
							<input type="hidden" name="former_file1" id="former_file1">
							<input type="hidden" name="edit_ids" id="edit_ids">
							<?php
							echo '<span id="txt_srch_forum" class="clickforum" style="display:nones;">Click here to start a new topic <fonts>Post Comment</fonts></span>';
							?>
							<span id="txt_srch_forum1" style="display:none;">
                            <?php if($validate_mem){ ?>
                                <span id="uploadfiles1"><img src="<?=base_url();?>images/upload1.png"> Upload image</span>
                            <?php }else{ ?>
                                <span id="cmdnoPosts"><img src="<?=base_url();?>images/upload1.png"> Upload image</span>
                            <?php } ?>
								<span style="margin:5px 0 3px 7px; float:none;"><label style="font-size:14px; color:#555;" id="selectedCaption1">(No file selected)</label></span>
							</span>

							<select class="txtselectcat" name="txtcats" id="txtcats" style="display:none; background:#fff;">
								<option value="">Select Topic</option>
								<option value="1">General Discussion</option>
								<option value="2">Job Posting</option>
								<option value="3">Entertainments</option>
								<option value="4">Talents</option>
								<option value="5">Sex & Relationships</option>
								<option value="6">Kitchen</option>
								<option value="7">Games</option>
							</select>

                            

							<div class="textareas" style="display:none">
                                <p class="bold_info" style="font-size:15px;">
                                    Apply bold text by surrounding what to bold with * sign, <font class="view_formats">view more of this</font>
                                </p>
                                <p class="bold_info1" style="display:none;">
                                    Example: This platform is *awesome*<br>
                                    Gives you "This platform is <b style="color:#000">awesome</b>"<br>
                                    Example: This platform is _awesome_<br>
                                    Gives you "This platform is <bs style="color:#000"><u>awesome</u></bs>"<br>
                                </p>
								<textarea id="post_content" name="post_content" placeholder="Write a comment..."></textarea>
								<?php
									if(!$validate_mem)
									echo "<div class='user_login'>Please login to comment!</div>";
								?>
								<div class="errs"></div>
								<div class="button_events button_forum">
									<?php
									if($validate_mem)
									echo '<input type="submit" id="cmdPosts" value="Post Comment" class="btn_">';
									else
									echo '<input type="button" id="cmdnoPosts" value="Post Comment" style="opacity:0.5;">';
									?>
									<input type="button" id="cmdPosts1" value="Post Comment" style="opacity:0.6; display:none">
									<a href="javascript:;" class="cancel_posts"><span class="btn-cancel"><span class="fa fa-close"></span> Cancel</span></a>
								</div>
							</div>
							<input type="file" id="file4" name="file4" style="font-size:0.9em; visibility:hiddens; display:none;">
						</form>
					</div>
                    <p class="topics1">All Threads</p>
                    <p class="job_info" style="display:none;">
                        Any fake jobs posted here will warrant a permanent termination of your account with us!
                    </p>

					<div class="hide_txtbox" style="display:none;">
						<p style="margin-top:1.6em; font-size:0.9em; color:#444"><img src='<?=base_url()?>images/loader.gif' alt='Loading'/><br>Uploading...</p>
					</div>

					<div id='imgpreview1'></div>
					
					<div class="loaders_" style="position:relative; text-align:center; color:#777; bottom:1em; margin:2em 0 -5em 0; z-index:9999; font-style:italic;"></div>
					<div id="ajax_table_forum">
                        <p style="padding:5px;">&nbsp;</p>

                        <?php
                        $page = 0;
                        $txtsrch = "";
                        $txtcats1 = 0;
                        $txtmemsid = $get_mems_id;
                        
                        $forums = $this->sql_models->fetchForum($page, $txtsrch, $txtcats1);
                        if($forums){
                            foreach ($forums as $rs) {
                                $id1 = $rs['idf'];
                                $conid = $rs['conid'];
                                $fname = $rs['fname'];
                                $lname = $rs['lname'];
                                $topics = $rs['topics'];
                                $pics = $rs['pics'];
                                $messages = nl2br($rs['messages']);
                                $messagesi = $messages;
                                $messages2 = $messages;
                                $files = $rs['files'];
                                $views = $rs['views'];
                                $views = @number_format($views);
                                $dates = $rs['dates'];
                                $ful_name = ucwords("$fname $lname");
                                //$pic_path = base_url()."watermark.php?image=".base_url()."forum_files/$files&watermark=".base_url()."images/watermrk.png";
                                $pic_path = base_url()."forum_files/$files";
                                if(strlen($messages)>300)
                                    $messages = substr($messages, 0, 300)."...<span style='font-weight:normal; color:#69C;'>read more</span>";

                                if(strlen($messages2)>150)
                                    $messages2 = substr($messages2, 0, 150)."...";

                                if($topics==1) $ttls = "General Discussion";
                                else if($topics==2) $ttls = "Job Posting";
                                else if($topics==3) $ttls = "Entertainments";
                                else if($topics==4) $ttls = "Talents";
                                else if($topics==5) $ttls = "Sex & Relationships";
                                else if($topics==6) $ttls = "Kitchen";
                                else if($topics==7) $ttls = "Games";
                                else $ttls = "All Threads";

                                if($param1!="pages"){
                                    $directs = base_url()."pages/#viewreplies";
                                    $directs1 = "pages/#viewreplies";
                                }else{
                                    $directs = "javascript:;";
                                    $directs1 = "";
                                }
                                //$path_pics = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";

                                $path_pics = base_url()."celebs_uploads/$pics";

                                $replies_cnt = @number_format($this->sql_models->replyCounts($id1));
                            ?>
                                <div id='forumBox2' class="forumBox3 forumBox_scroll<?=$id1;?>" ids="<?=$id1;?>">
                                    <div id="forumBox">
                                        <div class="first_sec">
                                            <div class="forum_img">
                                                <img src='<?=$path_pics;?>' alt='Loading...' style='border-radius:30px; border:1px #999 solid;'>
                                            </div>

                                            <div class="forum_contents">
                                                <div class="for_dates">
                                                    <p style="font-size:15px; color:#8A8A00"><b><a href="javascript:;" style="color:#8A8A00;"><?=$ful_name;?></a></b>
                                                        <font style="font-size:14px; margin-left:4px; color:#555"><?=time_ago($dates);?> <img src="<?=base_url()?>images/clock.gif" style="position:relative; top:-2px;"></font>
                                                    </p>
                                                    <p style="font-size:14px; color:#666; margin-top:-5px;">
                                                        <b>Category:</b> <font style="margin-left:4px;"><?=$ttls;?></font>
                                                    </p>
                                                    <?php if($conid==$txtmemsid){ ?>
                                                        <p class="menu_icn" id="menu_icn" ids="<?=$id1;?>"><img src="<?=base_url()?>images/menu_icon1.png"></p>
                                                    <?php }else{ ?>
                                                        <p class="menu_icn">&nbsp;</p>
                                                    <?php } ?>
                                                </div>

                                                <?php if($conid==$txtmemsid){ ?>
                                                <div class="edit_div" id="edit_div<?=$id1;?>">
                                                    <span id='editpost' counters="<?=$id1;?>" messages1="<?=strip_tags(ucfirst($messagesi));?>" topics="<?=$topics;?>" ids="<?=$id1;?>" files="<?=$files;?>" style='cursor:pointer'><a href='javascript:;'>Edit this post &raquo;</a></span>
                                                    <span style='border:none; color:red; cursor:pointer' id='delpost' ids="<?=$id1;?>"><a href='javascript:;' style='color:red;'>Delete this post &raquo;</a></span>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <?php
                                            $gen_num1=time();
                                            $gen_num1=substr($gen_num1,6);
                                            $url1 = base_url()."replies/$id1$gen_num1/";
                                            $messages2 = str_replace("#", "", $messages2);
                                            $tweets = $messages2;
                                        ?>

                                        <div class="row_contents">
                                            <?php if($files!=""){ ?>
                                                <div class="cmt_img col-md-3 col-sm-12 col-xs-12 img_forum" style="backgrounds:blue">
                                                    <span class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>"><img src='<?=$pic_path;?>' alt='image'></span>
                                                </div>
                                                <div class="cmt_note_ col-md-9 col-sm-12 col-xs-12 containerx" style="backgrounds:red; line-height:20px;">
                                                    <span class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>">
                                                        <label>
                                                        <?php
                                                        if($topics==2) // if its job, allow links
                                                            echo makeLinks3(ucfirst($messages));
                                                        else
                                                            echo makeLinks2(ucfirst($messages));
                                                        ?>
                                                        </label>
                                                    </span>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="cmt_note_ col-md-12 col-sm-12 col-xs-12 containerx" style="line-height:20px;">
                                                    <span class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>">
                                                        <label>
                                                        <?php
                                                        if($topics==2) // if its job, allow links
                                                            echo makeLinks3(ucfirst($messages));
                                                        else
                                                            echo makeLinks2(ucfirst($messages));
                                                        ?>
                                                        </label>
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

                                            <div class="cover_contents" id="cover_contents<?=$id1;?>"></div>
                                            <div class="copy_text" ids='<?=$id1;?>' id="copy_text<?=$id1;?>"><spans>Copy Text</spans></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 comment_stats" style="backgrounds:blue">
                                            <div class="col-md-4 col-sm-4 col-xs-4 for_cmts" style="backgrounds:blue">
                                                <a href="javascript:;" class="open_comment" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>"><i class="fa fa-comment fa_comment"></i> <?=$replies_cnt;?></a>
                                            </div>

                                            
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="backgrounds:blue">
                                                <a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><img src="<?=base_url()?>images/facebook.png" style="width:29 !important"></a>&nbsp;
                                                <a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><img src="<?=base_url()?>images/twitter1.png" style="width:29 !important"></a>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4" style="backgrounds:blue">
                                                <?=$views;?> views
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $forums_rp = $this->sql_models->fetchForumRep1($id1);
                                    if($forums_rp){
                                        $id1i = $forums_rp['id'];
                                        $conid = $forums_rp['conid'];
                                        $fnamei = $forums_rp['fname'];
                                        $lnamei = $forums_rp['lname'];
                                        $replies = nl2br($forums_rp['replies']);
                                        $filesi = $forums_rp['files'];
                                        $picsi = $forums_rp['pics'];
                                        $datesi = $forums_rp['dates'];
                                        if(strlen($replies)>90)
                                            $replies = substr($replies, 0, 90)."...read more";
                                        $ful_namei = ucwords("$fnamei $lnamei");

                                        $mydatesi= date("jS F, Y h:i a", strtotime($datesi));
                                        //$path_picsi = base_url()."watermark.php?image=".base_url()."celebs_uploads/$picsi&watermark=".base_url()."images/watermrk.png";  

                                        $path_picsi = base_url()."celebs_uploads/$picsi";
                                        ?>
                                            <div class="small_comments">
                                                <div class="col-md-1 col-sm-1 col-xs-1">
                                                    <img src='<?=$path_picsi;?>' alt='image' style='border-radius:30px; border:1px #999 solid;'>
                                                </div>

                                                <div class="col-md-10 col-sm-11 col-xs-11">
                                                    <div class="for_dates_">
                                                        <p style="font-size:14px; text-align:left; color:#8A8A00"><b><a href="javascript:;" style="color:#8A8A00;"><?=$ful_namei;?></a></b></p>
                                                        <p class="main_cmts">
                                                            <span class="open_comment" style="cursor:pointer" directs1="<?=$directs1;?>" frid="<?=$id1;?>" tils="<?=$ttls;?>"><?=makeLinks2(ucfirst($replies)); ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                    }else{
                                        echo "<p style='margin-bottom:-10px;'>&nbsp;</p>";
                                    }
                                    ?>

                                </div>
                                <div style="clear:both"></div>

                            <?php
                            }
                            ?>
                        
                        <?php
                        }else{
                            echo "<p style='font-size:15px; text-align:center; color:#555; padding:15px 8px 0 5px; margin-bottom:3.5em; line-height:20px;'>No posts found on your search, redefine your search to find what you are looking for.</p>";
                        }
                        ?>
                        
					</div>

					<a href="javascript:;" class="load_more_bt wow fadeIn" id="load_more_mba" data-val = "0" data-wow-delay="0.2s">Load more posts </a>
            		<a href="javascript:;" class="load_more_bt wow fadeIn" id="load_more_mba1" style="color:#ccc; display:none;" data-wow-delay="0.2s"><i>Loading...</i> <img src="<?php echo str_replace('index.php','',base_url()) ?>images/loader.gif" width="18"> </a>
					<input type="hidden" class="successm" style="display:nones;">						
					
                </div>
            </div>
        </div>
    </section>
        