

    <script>
        var site_urls = $('#txtsite_url').val();
        $(".uploadimage2_members").on('submit',(function(e) {
            e.preventDefault();
            var txtmember = $('#txtmember').val();
            $(".err_div1").hide();
            $('.update_profile1').hide();
            $('.update_profile2').show();

            $.ajax({
                type : "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                url : site_urls+"node/reg_members_2",
                success : function(data){
                    var data1, data2;
                    var lens = data.length;
                    data2 = data.substring(0, 6);
                    data1 = data.substring(6);

                    if(data2 == 'done_2'){
                    $('.update_profile1').show();
                    $('.update_profile2').hide();

                    if(lens>=7)
                        $('#txtf0').val(data1);
                        $('.edit_profile_div').hide();
                        $('.success1_div').fadeIn('fast');
                        $(".err_div1").hide();
                        $("html, body").animate({ scrollTop: 110 }, "fast");

                    }else if(data2 == 'logged_out'){
                        $(".dashboard_div").hide();
                        $(".expireds").show();
                        $('.page_titl').html('Expired Session'+head_titles);

                    }else{
                        $(".err_div1").show().html('<div class="Errormsg Errormsgi">'+data+'</div>');
                        $('.update_profile1').show();
                        $('.update_profile2').hide();
                        setTimeout(function(){
                            $(".err_div1").fadeOut('fast');
                        },5000);
                    }
                },error : function(data){
                    $('.update_profile1').show();
                    $('.update_profile2').hide();
                    $(".err_div1").show().html('<div class="Errormsg Errormsgi">Poor Network Connection!</div>');
                    setTimeout(function(){
                        $(".err_div1").fadeOut('fast');
                    },5000);
                }
            });

        }));


        $('.cmd_update_pass').live("click",function(){
            $(".err_div4").hide();
            $('.cmd_update_pass').hide();
            $('.cmd_update_pass1').show();
            
            $.ajax({
                type : "POST",
                url : site_urls+"node/update_my_prof_pass",
                data: $("#edit_pass1").serialize(),
                success : function(data){
            
                    if(data=="success_updated_pass1"){
                    $('.cmd_update_pass').show();
                    $('.cmd_update_pass1').hide();
                    
                    $(".err_div4").show().html('<div class="successmsg" style="text-align:center">Your password has been updated!</div>');
                    $("#edit_pass1")[0].reset();
                    
                    setTimeout(function(){
                        $(".err_div4").hide();
                    },2500);
            
                    }else if(data == 'logged_out'){
                        $(".dashboard_div").hide();
                        $(".expireds").show();
                        $('.page_titl').html('Expired Session'+head_titles);
                    
                    }else{
                    $('.cmd_update_pass').show();
                    $('.cmd_update_pass1').hide();
                    $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
                    }
            
                },error : function(data){
                    $('.cmd_update_pass').show();
                    $('.cmd_update_pass1').hide();
                    $(".err_div4").show().html('<div class="Errormsg">Poor Network Connection!</div>');
                }
            });
        });

    </script>
            
    <section style="background:#fff !important;" id="reach-to" class="gotohere dishes1 home-icon shop-single pad-bottom-remove blog-main-section text-center_ blog-main-2col ash_color">
        <div class="icon-default icon-default2" id="page-wrap">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
        </div>

        <?php 
            $idd="";$fname="";$lname="";$emails="";$phones="";$picx="";$citys="";$states="";$countrys="";$yes_file=0;$work="";$gender="";$bm_type="";
            $imgs1 = base_url()."img/no_passport.jpg"; $relationshp_status1="";
            $hobbies=""; $likes=""; $dislikes=""; $bios=""; $kind_of_partner=""; $occupatn="";

            if($validate_mem){
                $id = $profile_details['id'];
                $fname = ucfirst($profile_details['fname']);
                $lname = ucfirst($profile_details['lname']);
                $phones = $profile_details['phones'];
                $emails = $profile_details['emails'];
                $picx = $profile_details['pics'];
                $states = $profile_details['statee'];
                $gender = $profile_details['gender'];
                $occupatn = ucwords($profile_details['occupatn']);
                $hear_about = $profile_details['hear_about'];
                $relationshp_status = $profile_details['relationshp_status'];
                $hobbies = ucwords($profile_details['hobbies']);
                $likes = ucwords($profile_details['likes']);
                $dislikes = ucwords($profile_details['dislikes']);
                $bios = ucfirst(nl2br($profile_details['bios']));
                $kind_of_partner = ucwords($profile_details['kind_of_partner']);
                $ful_name = ucwords("$fname $lname");
                if($gender=="m") $gender1="Male"; else $gender1="Female";

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


        <div class="container shft_top shft_tops">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-12">

                    <h4 class="text-coffee1 for_mobile mobiles mobiles1"><?=$ful_name;?> Profile</h4>
                    <div class="seperators for_mobile"><img alt="" src="<?php echo base_url(); ?>images/saprator.png"></div>

                    <div class="for_desktop desktop_menus">
                        <p>NAVIGATION</p>
                        <p class="profile_pics3j"><img src="<?php echo $imgs1; ?>" id="img_navigatn"></p>
                        <ul>
                            <li class=""><a href="javascript:;" class="past_winners">Back</a></li>
                            <li class=""><a href="javascript:;" class="mydashboard">Dashboard</a></li>
                            <li class=""><a href="javascript:;" class="edit_profile">Edit Profile</a></li>
                            <li class=""><a href="javascript:;" class="change_passwd1">Change Password</a></li>
                            <li class=""><a href="javascript:;" class="logmeout">Logout</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-md-9 col-sm-9 col-xs-12 left_profile_div">
                    <h4 class="text-coffee1 for_desktop header_caption"><?=$ful_name;?> Profile</h4>
                    <div class="seperators for_desktop"><img alt="" src="<?php echo base_url(); ?>images/saprator.png"></div>

                    <div class="biographys" style="margin-top:1.8em; display:nones">
                        <p style="padding:0 5px; text-align:center; color:#993; margin:-15px 0 1.5em 0" class="for_mobile"><b>Click on the Menu up to edit your profile</b></p>
                        <table>
                            <tr>
                            <td><b>Name</b></td>
                            <td><?=$ful_name;?></td>
                            </tr>

                            <tr>
                            <td><b>Phone</b></td>
                            <td><?=$phones;?></td>
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
                    if($validate_mem){
                        $hear_about = ucwords($profile_details['hear_about']);
                        $relationshp_status = $profile_details['relationshp_status'];
                        $hobbies = ucwords($profile_details['hobbies']);
                        $likes = ucwords($profile_details['likes']);
                        $dislikes = ucwords($profile_details['dislikes']);
                        $bios = ucfirst($profile_details['bios']);
                        $kind_of_partner = ucwords($profile_details['kind_of_partner']);
                    }
                    ?>

                    <div class="edit_profile_div" style="margin-top:1.8em; display:none">
                        <?php echo form_open_multipart('', array('id'=>'form_step2_up', 'class'=>'form reg_form contact_form uploadimage2_members', 'autocomplete'=>'off')); ?>
                            <input type="hidden" name="txtmember" value="<?=$id;?>">
                            <div class="containerx">
                                <div class="row">
                                    <div class="alert-container"></div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                        <input type="hidden" name="txtf0" id="txtf0" value="<?=$picx;?>">
                                        <ul class="list-inline">
                                            <li id="img_prev1_bma" class="list-inline-item profile_pics3 profile_pics3i">
                                                <span>remove</span>
                                                <img src="<?php echo $imgs1; ?>" src1="<?php echo $imgs1; ?>" id="im1_bma">
                                                <input id="ad_logo_check1_bma" value="0" style="display:none;" />
                                                
                                                <input type="file" name="txt_bma_pic" id="txt_bma_pic" style="padding:4px; font-size:13px; margin:8px 0 0px 0; border:1px solid #ccc; display:none" />
                                                <p style="color:#808000; cursor:pointer; display:none; margin:4px 0 -17px 0;" id="hide_basic_uploader">Hide</p>
                                                
                                            </li>
                                            <input name="txt_yes_file_bma" type="hidden" value="<?=$yes_file;?>">
                                        </ul>
                                        <p style="margin:6px 0 3.5em 0; font-size:14px;">
                                            <span style="color:#555; cursor:pointer;" class="basic_uploader"><b>Or <span style="color:#7BF">click here</span> to try the simple uploader</b></span>
                                        </p>
                                    </div>

                                    <input type="hidden" name="txtcodes" value="">
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="txtfname" type="text" value="<?=$fname;?>" placeholder="First Name*" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="txtlname" type="text" value="<?=$lname;?>" placeholder="Last Name*" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="phone1" type="tel" value="<?=$phones;?>" placeholder="Your Phone Number*" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="email1" type="email" value="<?=$emails;?>" placeholder="Your Email Address*" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select style="" name="txtgender" class="txt3" id="txtgender">
                                            <option value="" selected>* -Select Gender-</option>
                                            <option value="m" <?php if($gender=="m") echo "selected"; ?>>Male</option>
                                            <option value="f" <?php if($gender=="f") echo "selected"; ?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select style="" name="txt_relatn" class="txt3" id="txt_relatn">
                                            <option value="" selected>* -Select Relationship-</option>
                                            <option value="s" <?php if($relationshp_status=="s") echo "selected"; ?>>Single</option>
                                            <option value="e" <?php if($relationshp_status=="e") echo "selected"; ?>>Engaged</option>
                                            <option value="m" <?php if($relationshp_status=="m") echo "selected"; ?>>Married</option>
                                            <option value="d" <?php if($relationshp_status=="d") echo "selected"; ?>>Divorced</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select style="" name="txtstate" class="txt3" id="txtstate">
                                            <option value="" selected>* -Select State-</option>
                                            <option value="Ghana">Ghana</option>
                                            <?php
                                                $selecd="";
                                                foreach($countries as $post):
                                                $con_name = $post['names'];
                                                ?>
                                                <option value='<?=$con_name;?>' <?php if($states==$con_name) echo "selected"; ?>><?=$con_name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12 txts">
                                        <input name="txtoccu" value="<?=$occupatn;?>" style="text-transform:capitalize;" placeholder="* What's your Occupation?" type="text" class="txt3">
                                    </div>

                                    <div style="clear:both"></div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 txts">
                                        <textarea name="txthoby" placeholder="What Are Your Hobbies" class="txt3 txtareas" style="height:4em !important; line-height:19px !important;"><?=$hobbies;?></textarea>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 txts">
                                        <textarea name="txtlikes1" placeholder="Your Likes In People" class="txt3 txtareas" style="height:4em !important; line-height:19px !important;"><?=$likes;?></textarea>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 txts">
                                        <textarea name="txtdislikes1" placeholder="Your Dislikes In People" class="txt3 txtareas" style="height:4em !important; line-height:19px !important;"><?=$dislikes;?></textarea>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 txts">
                                        <textarea name="txtkindpart" placeholder="Your Kind of Partner" class="txt3 txtareas" style="height:4em !important; line-height:19px !important;"><?=$kind_of_partner;?></textarea>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 txts">
                                        <textarea name="txtbios" placeholder="Your Biography" class="txt3 txtareas" style="height:10em !important; line-height:19px !important;"><?=$bios;?></textarea>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="err_div1"></div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input name="submit" value="UPDATE PROFILE" class="btn-black center-block update_profile1" type="submit">
                                        <input name="button" value="UPDATING PROFILE..." class="btn-black center-block update_profile2 opac_btn_" type="button" style="display:none; opacity:0.7; color:#777;">
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>



                    <div class="success1_div" style="margin-top:1.8em; display:none">
                        <div class="containerx">
                            <div class="row">
                                <div style="text-align:center; margin-top:20px;">
                                    <img src="<?php echo base_url(); ?>images/checkmark.png">
                                    <h3 class="inner" style="margin:10px 0 -10px 0">Updated Successfully!</h3>
                                    <div id="confirm">
                                        <p style="font-size:14px; line-height:22px; padding:0 10px">
                                            Your profile has been updated and saved with us, thank you for being part of us.
                                        </p>
                                    </div>
                                </div>
                                <div style="clear:both"></div>

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
                                    <input name="submit" value="DONE" class="btn-black center-block cmd_done_update" type="button">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="update_pass_div" style="margin-top:1.8em; display:none">
                        <form class="form reg_form contact_form" id="edit_pass1" method="post" autocomplete="off" name="contact-form">
                            <div class="containerx">
                                <div class="row">
                                    <div class="alert-container"></div>
                                    <div class="col-md-9 col-sm-9 col-xs-12 txts">
                                        <input name="txtpass1" type="password" placeholder="Old Password*" class="txt3" required>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12 txts">
                                        <input name="txtpass2" type="password" placeholder="New Password*" class="txt3" required>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12 txts">
                                        <input name="txtpass3" type="password" placeholder="Confirm Password*" class="txt3" required>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="err_div4"></div>
                                    
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="margin-top:1em;">
                                        <input name="button" value="UPDATE PASSWORD" class="btn-black pull-left cmd_update_pass" type="button">
                                        <input name="button" value="UPDATING PASSWORD..." class="btn-black pull-right cmd_update_pass1" type="button" style="display:none; opacity:0.7; color:#777;">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
                
            </div>
        </div>
        <div style="clear:both"></div>
        <br><br><br>
        
    </section>

        
            
    
        