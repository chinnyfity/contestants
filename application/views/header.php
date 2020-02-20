<?php 
//echo time()+1728000; // 7 days
//exit;

$idd="";$fname="";$lname="";$ful_name="";$emails="";$phones="";$picx="";$citys="";$states="";$countrys="";$yes_file=0;$work="";$gender="";$bm_type="";
$imgs1 = base_url()."img/no_passport.jpg"; $relationshp_status1="";
$hobbies=""; $likes=""; $dislikes=""; $bios=""; $kind_of_partner=""; $occupatn="";

$cookie_fund_name = $this->input->cookie('cookie_fund_name', TRUE);
$cookie_fund_phone = $this->input->cookie('cookie_fund_phone', TRUE);
$voter_ip = $this->input->cookie('voter_ip', TRUE);
$ipaddr = $_SERVER['REMOTE_ADDR'];

if($validate_mem){
    $fname = ucfirst($profile_details['fname']);
    $lname = ucfirst($profile_details['lname']);
    $ful_name = ucwords("$fname $lname");
}

//echo $page_name;
if($page_name == "viewprofile"){
    if($contests_no_expire){
        $overall_title1 = $contests_no_expire[0]['overall_title'];
        $file1i = $contests_no_expire[0]['file1'];
        $pic_pathi = base_url()."activity_photos/$file1i";
        $fname1 = $contests_no_expire[0]['fname1'];
        $lname1 = $contests_no_expire[0]['lname1'];
        $ful_names = ucwords(" $fname1 $lname1");

        if($file1i==""){
            $pics = $this->sql_models->profilePics1($mem_id);
            $pic_pathi = base_url()."celebs_uploads/$pics";
        }
        
    }else{

        $overall_title1 = $contestants[0]['overall_title'];
        $file1i = $contestants[0]['file1'];
        $pic_pathi = base_url()."activity_photos/$file1i";
        $fname1 = $contestants[0]['fname1'];
        $lname1 = $contestants[0]['lname1'];
        $ful_names = ucwords(" $fname1 $lname1");

        if($file1i==""){
            $pics = $this->sql_models->profilePics1($mem_id);
            $pic_pathi = base_url()."celebs_uploads/$pics";
        }
    }

    if($ful_names!="") $ful_names1 = "$ful_names/"; else $ful_names1 = "";
    $ful_names1i = str_replace(" ", "-", $ful_names1);
    $ful_names1i = strtolower($ful_names1i);
    $url2 = base_url()."viewprofile/$mem_id/$ful_names1i/";
    $tweets1 = "Hi dear, I'm $ful_names1 at OurFavCelebs, I would like to plead for your support by voting for me, thank you in advance.";

}

$sw_ids="";
$get_mems_id="";
$names1_v="";
$fname1_v="";
$lname1_v="";
$names_v="";
if($page_name == ""){
    $get_mems_id = $this->sql_models->getMemID();
    if($get_mems_id){
        $sw_ids = $contestants[0]['sw_id'];
        $names_v = $this->sql_models->contestantName($get_mems_id);
        $names1_v = explode(' ', $names_v);
        $fname1_v = $names1_v[0];
        $lname1_v = $names1_v[1];
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#510051">
    <title class="page_titl"><?=$page_title;?></title>

    <?php if($page_name == "viewprofile"){ ?>
        <meta property="og:title" content="<?php echo "Contestant $ful_names1 at OurFavCelebs"; ?>" />
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?php echo $url2; ?>" />
        <meta property="og:image" content="<?php echo $pic_pathi; ?>" />
        <meta property="og:site_name" content="OurFavCelebs"/>
        <meta property="og:description" content="<?php echo ucwords($tweets1); ?>" />
    <?php }else{ ?>
        <meta name="keywords" content="pageant, beauty, fashion, business, chinny, anthony, chinny anthony, advertise, free adverts, models, contestant, games, winner, winner is, celebrity, celebs, lagos, beauty, miss lagos, votes, opportunity, talents, creativity, enter now, awards, contestant form, nationwide, business exposure" />
        <meta name="description" content="OurFavCelebs introduces fun and entertainment activities of Pageant Contest as a medium to promote environmental awareness and opportunities for everyone to engage in one or more of the OurFavCelebs pageant activities." />
        <meta name="image" content="<?=base_url();?>image/logo1.png" />
    <?php } ?>

    <link href="../image/icon.ico" type="image/ico" rel="icon" />

    <link href="<?=base_url();?>plugin/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/font-awesome/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/form-field/jquery.formstyler.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/revolution-plugin/extralayers.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/revolution-plugin/settings.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/owl-carousel/owl.theme.default.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/slick-slider/slick-theme.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/magnific/magnific-popup.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="<?=base_url();?>plugin/animation/animate.min.css" rel="stylesheet">
    <link href="<?=base_url();?>css/theme.css" rel="stylesheet">
    <link href="<?=base_url();?>css/styles_profile.css" rel="stylesheet">
    
    <link href="<?=base_url();?>css/responsive.css" rel="stylesheet">
    <link href="<?=base_url();?>css/custom-bootstrap-margin-padding.css" rel="stylesheet">

    
<?php $checkWallet = $this->sql_models->checkWallet(); ?>

</head>

<body class="hide-overlay">
<input type="hidden" value="<?=base_url();?>" id="txtsite_url">
<input type="text" value="<?=$page_name;?>" id="page_names" style="display:none;">
<input type="hidden" class="open_dv" value="0">

<input type="hidden" class="txtfullnames" value="<?=$ful_name;?>">
<input type="hidden" class="txtfirstnames" value="<?=$fname;?>">
<input type="hidden" class="txtlastnames" value="<?=$lname;?>">

<input id="txtvote_ip" value="<?=$ipaddr?>" type="hidden">
<input id="txtwalletamt" value="<?=$checkWallet?>" type="hidden">

    <div id="pre-loader">
        <div class="loader-holder">
            <div class="frame">
                <img src="<?=base_url();?>images/loader.gif" alt="" />
            </div>
            <label>OurFavCelebs Pageant</label>
        </div>
    </div>

    <input type="text" id="what_div" style="display:none;">

    <div class="vote_me" style="display:none;">
        <div class="closeme1"></div>
        <div class="pics_img"></div>
        <div class="inner_dvs">
            <p class="p_name p_name1"></p>
            <p class="p_litle">Please help this contestant to be the first winner</p>
            
            <input id="conte_id" type="hidden">
            <input id="acti_id" type="hidden">
            <input id="con_name" class="p_name" type="hidden">
            <!-- <input id="txtcompanybank" value="Diamond Bank" type="hidden">
            <input id="txtcompanyacct" value="1234567890" type="hidden"> -->

            <div class="div_cover" style="margin-top:10px;">
                <div class="div_left vote1" style="display:nones">
                    <label>1 Vote</label>
                </div>

                <div class="div_right vote1" style="display:nones">
                    <span style="font-weight:normal !important; background:#990; opacity:0.5;" class="cmdvotefree3">....</span>
                    <span style="font-weight:normal !important; background:#990; display:none;" class="cmdvotefree">Vote Free</span>
                    <span style="font-weight:normal !important; background:#990; opacity:0.5; display:none;" class="cmdvotefree1">Voted</span>
                </div>

                <div class="confirm_vote vote_1" style="display:nones">
                    <form id="enter_reg" class="form reg_form" method="post" autocomplete="off" name="contact-form">
                        <p class="vote_titl">Proceed to vote for this contestant</p>

                        <div class="div_btns" style="display:none_">
                            <span style="font-weight:normal !important; background:#990;" class="cmdyes cmdyesi">Yes, Vote</span>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdno">No</span>

                            <p style="color:#888;font-size:13px;margin:8px 0 5px 0 !important" class="err_mail"></p>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders" style="display:none; margin-left:-50px;" alt="" />
                        </div>

                        <!-- <div class="div_entermail" style="display:none">
                            <input id="txtvote_email" placeholder="Type your email" type="email" class="txt2 txt22" style="background:#ddd !important; margin:-5px 0 10px 0 !important;">
                            <p style="color:#888; font-size:13px; margin:8px 0 5px 0 !important" class="err_mail"></p>
                            <span style="font-weight:normal !important; background:#990;" class="cmd_submitmail cmd_submitmail1">Submit</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote">Back</span>
                        </div> 

                        <div class="div_entercode" style="display:none">
                            <p style="color:#888; font-size:13px; margin-bottom:2px;">Type the code sent to your email</p>
                            <input id="txtvote_code" placeholder="Type code" type="number" class="txt2 txt22" style="background:#ddd !important; margin-bottom:10px !important;">
                            <p style="color:#888; font-size:13px; margin:8px 0 5px 0 !important" class="err_mail1"></p>
                            <span style="font-weight:normal !important; background:#990;" class="cmd_votenow cmd_votenowi">Vote</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote">Back</span>
                        </div> -->

                        <div class="div_vote_success" style="display:none">
                            <p style="font-size:17px; margin-bottom:2px; color:#093">Thank you for your vote</p>
                            <p style="font-size:15px; margin-bottom:8px; color:#666; line-height:21px;">You have successfully voted for <font class="p_name2" style="text-transform: capitalize;"></font></p>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote1">Done</span>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            if($checkWallet > 0){
                $checkWallet1 = "&#8358;".@number_format($checkWallet);
                $wallet_amt = "You have <font style='color:#093'>$checkWallet1</font> in your wallet,<br> <a href='javascript:;' class='open_fund' style='color: #093'>top more?</a>";
            }else{
                $wallet_amt = 'No money in your wallet, please <a href="javascript:;" class="open_fund" style="color: #093">fund wallet</a>';
            }
            ?>


            <div class="div_cover">
                <div class="div_left vote2">
                    <label>5 Votes</label>
                </div>
                <div class="div_right vote2">
                    <span class="cmdpay100">&#8358;50</span>
                </div>
                
                <div class="confirm_vote vote_2" style="display:none">
                    <form id="enter_reg" class="form reg_form" method="post" autocomplete="off" name="contact-form">

                        <div class="div_btns1" style="display:nones">
                            <p>Proceed to vote for this contestant</p>
                            <span style="font-weight:normal !important; background:#990;" class="cmd_pay100">Pay &#8358;50</span>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdno">No</span>
                        </div>
                        
                        <div class="div_enterdetails" style="display:none">
                            <p>Proceed to vote for this contestant</p>
                            <p style="font-size:14.5px; color:#444; margin:0 0 15px 0; line-height: 22px;">Easy voting system. <?=$wallet_amt?>
                            </p>
                            
                            <!-- <input id="txtvote_acctname" placeholder="Type your account name" type="text" class="txt2 txt22" style="background:#ddd !important; text-transform:capitalize; margin:-5px 0 10px 0 !important;">
                            <select name="txtbank" class="txt2 txt22" id="txtbank" style="background:#ddd !important;">
                                <option value="" selected>* -Select Your Bank-</option>
                                <?php
                                    foreach($ussd_codes as $post):
                                    $banks = $post['banks'];
                                    $ussd2ussd = $post['ussd2ussd'];
                                    $ussd2other = $post['ussd2other'];
                                    echo "<option value='$banks' ussd2ussd='$ussd2ussd' ussd2other='$ussd2other'>$banks</option>";
                                    ?>
                                <?php endforeach; ?>
                            </select> -->

                            <input id="txtvote_name" value="<?=$cookie_fund_name?>" placeholder="Type your full names" type="text" class="txt2 txt22" style="background:#ddd !important; text-transform: capitalize;">

                            <input id="txtvote_phone" value="<?=$cookie_fund_phone?>" placeholder="Type your phone number" type="number" class="txt2 txt22" style="background:#ddd !important; margin:-23px 0 2em 0 !important;">

                            <p style="color:#888; font-size:13px; margin:-18px 0 5px 0 !important" class="err_details"></p>

                            <p style="color:#FF1A1A; font-size:13px; margin:-18px 0 15px 0 !important">Note that if you click on the continue button, &#8358;50 will be deducted from your wallet</p>

                            <span style="font-weight:normal !important; background:#990;" class="cmd_submit_details cmd_submit_detailsi">Continue</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders1" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote2">Back</span>

                            <p style="color:#777; font-size:13px; margin:0px 0 12px 0 !important">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>
                        </div>

                        <!-- <div class="div_entercode1" style="display:none">
                            <p style="color:#888; font-size:13px; margin-bottom:2px;">Type the code sent to your email</p>
                            <input id="txtvote_code1" placeholder="Type code" type="number" class="txt2 txt22" style="background:#ddd !important; margin-bottom:10px !important;">
                            <p style="color:#888; font-size:13px; margin:8px 0 5px 0 !important" class="err_details"></p>
                            <span style="font-weight:normal !important; background:#990;" id="cmd_votenow1">Vote</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders1" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote2">Back</span>
                        </div> -->

                        <div class="div_vote_success1" style="display:none">
                            <p style="font-size:17px; margin-bottom:2px; color:#093">Thank you for your vote</p>
                            <p style="font-size:15px; margin-bottom:8px; color:#444; line-height:21px;">
                                5 votes have been added to your contestant <font class="p_name2" style="text-transform: capitalize;"></font>. Your new amount in your wallet is &#8358;<font class="new_amt"></font></p>
                                <p style="color:#666; font-size:14px; margin:0px 0 12px 0 !important; line-height:23px;">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote2">Done</span>
                        </div>
                    </form>
                </div>
            </div>



            <div class="div_cover">
                <div class="div_left vote3">
                    <label>10 Votes</label>
                </div>
                <div class="div_right vote3">
                    <span class="cmdpay200">&#8358;100</span>
                </div>
                
                <div class="confirm_vote vote_3" style="display:none">
                    <form id="enter_reg" class="form reg_form" method="post" autocomplete="off" name="contact-form">

                        <div class="div_btns2" style="display:nones">
                            <span style="font-weight:normal !important; background:#990;" class="cmd_pay200">Pay &#8358;100</span>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdno">No</span>
                        </div>
                        
                        <!-- <div class="div_enterdetails1" style="display:none">
                            <p style="font-size:14px; color:#666; margin:0 0 12px 0"> Once your payment is confirmed, your votes will be added.
                            Enter the account name you used in your bank for easy approval after payment confirmation.</p>
                            <input id="txtvote_acctname1" placeholder="Type your account name" type="text" class="txt2 txt22" style="background:#ddd !important; text-transform:capitalize; margin:-5px 0 10px 0 !important;">
                            <select name="txtbank1" class="txt2 txt22" id="txtbank1" style="background:#ddd !important;">
                                <option value="" selected>* -Select Your Bank-</option>
                                <?php
                                    foreach($ussd_codes as $post):
                                    $banks = $post['banks'];
                                    $ussd2ussd = $post['ussd2ussd'];
                                    $ussd2other = $post['ussd2other'];
                                    echo "<option value='$banks' ussd2ussd='$ussd2ussd' ussd2other='$ussd2other'>$banks</option>";
                                    ?>
                                <?php endforeach; ?>
                            </select>
                            <input id="txtvote_phone1" placeholder="Type your phone number" type="number" class="txt2 txt22" style="background:#ddd !important; margin:-24px 0 12px 0 !important;">
                            <input id="txtvote_mail2" placeholder="Type your email address" type="email" class="txt2 txt22" style="background:#ddd !important; margin:0px 0 2em 0 !important;">

                            <p style="color:#888; font-size:13px; margin:-18px 0 5px 0 !important" class="err_details1"></p>

                            <span style="font-weight:normal !important; background:#990;" class="cmd_submit_details1 cmd_submit_details1i">Continue</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders2" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote3">Back</span>

                            <p style="color:#777; font-size:13px; margin:0px 0 12px 0 !important">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>
                        </div>

                        <div class="div_entercode2" style="display:none">
                            <p style="color:#888; font-size:13px; margin-bottom:2px;">Type the code sent to your email</p>
                            <input id="txtvote_code2" placeholder="Type code" type="number" class="txt2 txt22" style="background:#ddd !important; margin-bottom:10px !important;">
                            <p style="color:#888; font-size:13px; margin:8px 0 5px 0 !important" class="err_details1"></p>
                            <span style="font-weight:normal !important; background:#990;" id="cmd_votenow2">Vote</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders2" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote3">Back</span>
                        </div>

                        <div class="div_vote_success2" style="display:none">
                            <p style="font-size:17px; margin-bottom:2px; color:#093">Thank you for your vote</p>
                            <p style="font-size:15px; margin-bottom:8px; color:#666; line-height:21px;">
                                As soon as we receive your payment of &#8358;100 we will activate 10 votes to your contestant
                                <font class="p_name2"></font>.</p>
                                <p style="color:#777; font-size:14px; margin:0px 0 12px 0 !important; line-height:23px;">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote3">Done</span>
                        </div> -->




                        <div class="div_enterdetails1" style="display:none">
                            <p>Proceed to vote for this contestant</p>
                            <p style="font-size:14.5px; color:#444; margin:0 0 15px 0">Easy voting system. 
                                <?=$wallet_amt?>
                            </p>

                            <input id="txtvote_name1" value="<?=$cookie_fund_name?>" placeholder="Type your full names" type="text" class="txt2 txt22" style="background:#ddd !important; text-transform: capitalize;">

                            <input id="txtvote_phone1" value="<?=$cookie_fund_phone?>" placeholder="Type your phone number" type="number" class="txt2 txt22" style="background:#ddd !important; margin:-23px 0 2em 0 !important;">

                            <p style="color:#888; font-size:13px; margin:-18px 0 5px 0 !important" class="err_details1"></p>

                            <p style="color:#FF1A1A; font-size:13px; margin:-18px 0 15px 0 !important">Note that if you click on the continue button, &#8358;100 will be deducted from your wallet</p>

                            <span style="font-weight:normal !important; background:#990;" class="cmd_submit_details100 cmd_submit_details100i">Continue</span>
                            <img src="<?=base_url();?>images/loader.gif" class="loaders1" style="display:none; margin-left:-50px;" alt="" />
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote3">Back</span>

                            <p style="color:#777; font-size:13px; margin:0px 0 12px 0 !important">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>
                        </div>


                        <div class="div_vote_success2" style="display:none">
                            <p style="font-size:17px; margin-bottom:2px; color:#093">Thank you for your vote</p>
                            <p style="font-size:15px; margin-bottom:8px; color:#444; line-height:21px;">
                                10 votes have been added to your contestant <font class="p_name2" style="text-transform: capitalize;"></font>. Your new amount in your wallet is &#8358;<font class="new_amt"></font></p>
                                <p style="color:#666; font-size:14px; margin:0px 0 12px 0 !important; line-height:23px;">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>
                            <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmdbackvote3">Done</span>
                        </div>
                    </form>
                </div>
            </div>

            <?php $expirys = $this->sql_models->current_vote_campaign(); ?>
            <p class="expirys">This campaign expires in <b><?=$expirys;?></b></p>
        </div>
    </div>



    <div class="my_profile" style="display:none;">
        <div class="overlay">
            <div class="closeme2"></div>
            <div class="pics_img2"></div>
            <div class="inner_dvs2 overlay-content">
                <p class="p_name"></p>
                <p class="p_litle">Please help this contestant to be the first winner</p>

                <p style="color:#999; text-align:center; position:relative; top:3em;" class="gal_loading">Loading gallery...</p>
                
                <div class="bring_conts_pics">
                    
                </div>


                <div class="container_prof">
                    <ul class="tabs portfolioFilter_">
                        <li class="tab-link current" data-tab="tab-1">Profile</li>
                        <li class="tab-link gallere" data-tab="tab-2">Gallery</li>
                        <li class="tab-link" data-tab="tab-3">Other Info</li>
                    </ul>

                    <div class="my_biography">
                    </div>

                
                    <div id="tab-2" class="tab-content current_" style="visibilitys:hidden; positions:relative; lefts:-9999px">
                        <section class="special-menu bg-skeen home-icon3" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="container_ gallery_top">
                                <div class="menu-wrapper">

                                    <div class="portfolioFilter">
                                        <p class="see_gallery" style="font-size:17px;"><font class="view_profiles_home" activityid="<?=$sw_ids;?>" memid="<?=$get_mems_id;?>" fulnames="<?=$names_v;?>" fname="<?=$fname1_v;?>" lname="<?=$lname1_v;?>">Click here to view photos</font></p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>


                    <div id="tab-3" class="tab-content">
                        <p style="margin:2em 0 2em 0;">We will think of what content will be here or we remove it.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>



    <div class="show_awards" id="showaward" style="display:none">
        <div class="overlay overlay3">
            <div class="closeme_gift"></div>
            <div class="inner_dvs3 overlay-content1">
                <h5>Winner Awards</h5>
                <p>Be Our Celebrity, Be Our Chioce</p>

                <?php
                $prize1 = @number_format($contestants[0]['prize1']);
                $prize2 = @number_format($contestants[0]['prize2']);
                $prize3 = @number_format($contestants[0]['prize3']);
                $gift1 = $contestants[0]['gift1'];
                $gift2 = $contestants[0]['gift2'];
                $gift3 = $contestants[0]['gift3'];

                if($gift1=="" || $gift2==""){
                    $nxtgame = $this->sql_models->check_next_activity();
                    if($nxtgame){
                        $prize1 = @number_format($nxtgame['prize1']);
                        $prize2 = @number_format($nxtgame['prize2']);
                        $prize3 = @number_format($nxtgame['prize3']);
                        $gift1 = $nxtgame['gift1'];
                        $gift2 = $nxtgame['gift2'];
                        $gift3 = $nxtgame['gift3'];
                    }
                }
                ?>

                <div class="awards1" id="enternow">
                    <?php if($gift1!="" || $gift2!=""){ ?>
                        <div class="container">
                            <div class="row awards2">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="prizes">1<sup>ST</sup> PRIZE</div>
                                    <div class="rope_gift"><img src="<?=base_url();?>images/rope_gift.png"></div>
                                    <div class="circle_gift">
                                        <div class="circle_gift1">
                                            <img src="<?=base_url();?>gifts/<?=$gift1;?>">
                                        </div>
                                    </div>
                                    <div class="prize_attached"><sup>with</sup> <cash>&#8358;<?=$prize1;?> cash</cash></div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="prizes">2<sup>ND</sup> PRIZE</div>
                                    <div class="rope_gift"><img src="<?=base_url();?>images/rope_gift.png"></div>
                                    <div class="circle_gift">
                                        <div class="circle_gift1">
                                            <img src="<?=base_url();?>gifts/<?=$gift2;?>">
                                        </div>
                                    </div>
                                    <div class="prize_attached"><sup>with</sup> <cash>&#8358;<?=$prize2;?> cash</cash></div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="prizes">3<sup>RD</sup> PRIZE</div>
                                    <div class="rope_gift"><img src="<?=base_url();?>images/rope_gift.png"></div>
                                    <div class="circle_gift">
                                        <div class="circle_gift1">
                                            <img src="<?=base_url();?>gifts/<?=$gift3;?>">
                                        </div>
                                    </div>
                                    <div class="prize_attached"><sup>with</sup> <cash>&#8358;<?=$prize3;?> cash</cash></div>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <p style="font-size:22px; color:#ccc; text-align:center;"><b>No Gifts Entered Yet.</b></p>
                        <p style="font-size:16px; color:#999; line-height:22px; text-align:center;">Gifts will be seen in the next game activities, please stay tuned and kindly get intouch with us, thank you!</p>
                    <?php } ?>
                </div>

            </div>
            <div class="img_awards"><span class="goback_awards">&laquo; CLOSE &raquo;</span></div>
        </div>
    </div>




    <div class="show_activities" id="showaward" style="display:none">
        <div class="overlay overlay3">
            <div class="closeme_acts"></div>
            <div class="inner_dvs3 inner_acts overlay-content1">
                <div class="show_activities1">
                    <h5 style="color:#FF6; opacity:0.8;">OurFavCelebes Activities</h5>
                    
                    <div class="background_imgs"><img src="<?=base_url();?>images/game_title2.jpg"></div>

                    <p style="">Every activity of OurFavCelebes which is taken place on the <b>"participate page"</b>, is a week contest which includes 3 activities each week and are detailed below:</p>
                    <ul style="position:relative; z-index:99;">
                        <li>Every first activity of the week is always Picture Contest Game PCG (either pictures of your outfits, your business, talents, couples, and so on.)</li>
                        <li>Second activity is games. Play different game activities online organised by the admins with limited countdown time and scores will be recorded by the judges.</li>
                        <li>Another fun Picture (personal outdoor photoshoots, home activities, and lots more) or Games Contest, all done online.</li>
                    </ul>

                    <p style="margin:1.8em 0 3.5em; 0;">The winners (first, second and third) will be shortlisted at the end of the week and geven prizes, social media recognition and other benefits.</p>
                </div>

                <div class="how_to_reg1" style="display: none;">
                    <ul style="position:relative; z-index:99;">
                        <h5 style="color:#FF6; opacity:0.9; font-size: 28px !important;">How It Works</h5>
                        <li>All Applicants must be 18yrs and above to register. Individuals below the age of 18 must have a <b>Legal Guardian</b> present during payment, registration and outdoor photo-shoot sessions.</li>
                        <li>Must meet our criteria as set forth by the Miss OurFavCelebs.</li>
                        <li>Must be able to meet the time commitment and job responsibilities as set forth by the competition(s) in which you compete.</li>
                        <li>Must be an active member of OurFavCelebs.</li>
                        <li>Your contestant account will be approved if we receive your payment of <b>&#8358;1,000</b></li>
                        <li>Please read our <a href="<?php echo base_url(); ?>pages/#policy">privacy and policy</a> before registering and for more inquiries, please send us a message via our <a href="<?php echo base_url(); ?>pages/#contact">contact page</a>.</li>
                    </ul>

                    <div class="awards1s" style="">
                        <h5>Awards/Activities</h5>
                          <p style="margin-top:5px; text-align: center !important;"><a href="#awards" class="open_awards">&laquo; Click to see RunnerUp Awards &raquo;</a></p>

                          <p style="margin:-18px 0 6em 0; text-align: center !important;"><a href="#activities" class="open_actv">&laquo; Click to see Our Activities &raquo;</a></p>
                    </div>
                </div>

            </div>
            <div class="img_awards"><span class="goback_awards1">&laquo; CLOSE &raquo;</span></div>
        </div>
    </div>



    <div class="fund_wallet" id="showaward" style="display:none">
        <div class="overlay overlay3">
            <div class="closeme_acts_fund"></div>
            <div class="inner_dvs3 inner_dvs3_fund inner_acts overlay-content1">
                <div class="show_activities1">
                    
                    <div class="row mt-xs-30">
                        <div class="col-lg-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                            <form id="enter_reg" class="form reg_form" method="post" autocomplete="off" name="contact-form">
                            
                                <div class="div_fund" style="display:none_">
                                    <h5 style="color:#FF6; opacity:0.8; margin-top: 0px;" class="mt-md-20">Fund Your Wallet</h5>
                                    <p>Fund your wallet to enable faster voting</p>
                                    <input id="txtfund_name" value="<?=$cookie_fund_name?>" placeholder="Type your full names" type="text" class="txt2 txt22" style="background:#ddd !important; text-transform: capitalize;">

                                    <input id="txtfund_phone" value="<?=$cookie_fund_phone?>" placeholder="Type your phone number" type="number" class="txt2 txt22" style="background:#ddd !important; margin:-24px 0 12px 0 !important;">

                                    <select name="txtfund_amt" class="txt2 txt22" id="txtfund_amt" style="background:#ddd !important; margin:0px 0 -15px 0 !important">
                                        <option value="200" selected>NGN200</option>
                                        <option value="500">NGN500</option>
                                        <option value="1000">NGN1,000</option>
                                        <option value="2000">NGN2,000</option>
                                    </select>

                                    <span style="font-weight:normal !important; background:#990;" class="style_btn cmdfund_wallet cmdfund_wallet1">Fund Wallet</span>

                                    <img src="<?=base_url();?>images/loader.gif" class="loaders1" style="display:none; margin-left:-50px;" alt="" />

                                    <span style="font-weight:normal !important; background:rgba(220, 20, 20, 0.8);" class="cmd_exit_fund style_btn">Back</span>

                                    <p style="color:#888; font-size:13px; margin:-15px 0 2em 0 !important" class="err_details_fund"></p>

                                    <p style="color:#999; text-align: center !important; font-size:14px; margin:0px 0 12px 0 !important">For any difficulties or inquiries, kindly call us on <a href="tel:+2349038455799">09038455799</a></p>
                                </div>


                                <div class="div_fund_success" style="display:none">
                                    <p style="font-size:22px; opacity: 0.7; line-height:27px !important; margin:8px 0 20px 0; color:#FF6">Your Fund Amount Has Been Submitted.</p>

                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                      <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="7" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                      <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="7" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                    </svg>

                                    <p style="font-size:16.5px; color:#ccc; line-height:23px; margin-top:10px;">
                                        As soon as we receive your payment of <font class="amts_paid"></font> we will fund your wallet immediately.
                                    </p>
                                    <p style="color:#ccc; font-size:15.4px; line-height:23px; margin: -20px 0 -10px 0; text-align: center;" class="mt-sm-0">For any difficulties or inquiries, kindly call us on <a style="color:#06C" href="tel:+2349038455799">09038455799</a></p>

                                    <span style="font-weight:normal !important; background:#666;" class="cmd_exit_fund style_btn">&nbsp;&nbsp;&nbsp;&nbsp; Done &nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </div>
                        
                            </form>
                        </div>
                    </div>
                </div>                

            </div>
            <div class="img_awards img_awards_fund"><span class="goback_awards_fund">&laquo; CLOSE &raquo;</span></div>
        </div>
    </div>



<?php
$pages_check = array('','viewprofile', 'events', 'viewevents', 'winners', 'not_sub', 'donation', 'adverts', 'judges', 'gallery', 'privacy_terms');
?>

    <div class="wrapper background-content main_div" style="display:nones">
        <header class="header_for_others">
            <div class="header-part header-reduce sticky">
                
                <div class="header-bottom">
                    <div class="container">
                        <div class="header-info alignleft">
                            <div class="header-info-inner">

                            <?php if(in_array($page_name, $pages_check)){ ?>
                                <div class="book-table header-collect book-md">
                                    <a href="<?=base_url();?>pages/#about">About Us<span>&nbsp;&bull;</span></a>
                                </div>
                                <div class="shop-cart header-collect">
                                    <a href="<?=base_url();?>pages/#contact">Contact Us<span>&nbsp;&bull;</span></a>
                                </div>
                            <?php }else{ ?>

                                <div class="book-table header-collect book-md">
                                    <a href="javascript:;" class="about_us">About Us<span>&nbsp;&bull;</span></a>
                                </div>
                                <div class="shop-cart header-collect">
                                    <a href="javascript:;" class="contact_us">Contact Us<span>&nbsp;&bull;</span></a>
                                </div>
                            <?php } ?>

                                <div class="search-part">
                                    <a href="#"></a>
                                    <div class="search-box">
                                        <input type="text" name="txt" placeholder="Search">
                                        <input type="submit" name="submit" value=" ">
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="menu-icon">
                            <a href="#" class="hambarger">
                                <span class="bar-1"></span>
                                <span class="bar-2"></span>
                                <span class="bar-3"></span>
                            </a>
                        </div>
                        <div class="book-table header-collect book-sm">
                        </div>
                        <div class="menu-main">

                            <?php
                            $url1 = base_url();
                            $tweets = "OurFavCelebs introduces online fun and entertainment activities of Pageantry Contest as a medium to promote environmental awareness and opportunities for everyone to engage in... Please click to visit and see more...";
                            $sTitle_whatsapp = "*OurFavCelebs Pageants*%0A%0AOurFavCelebs introduces online fun and entertainment activities of *Pageantry Contest* as a medium to promote environmental awareness and opportunities for everyone to engage in one or more of the OurFavCelebs pageant activities. Please click to visit and see more...%0A%0A$url1";
                            ?>

                            <div class="social_header for_mobile">
                                <p class="social-facebook"><a class="hitLink" href="javascript:;" href1="https://www.facebook.com/sharer/sharer.php?u=<?=$url1; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></p>
                                <p class="social-tweeter"><a class="hitLink" href="javascript:;" href1="https://twitter.com/share?text=<?=ucwords($tweets); ?>&url=<?=$url1;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></p>
                                <p class="social-whatsapp mobiles_view"><a class="hitLink" href="javascript:;" href1="whatsapp://send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></p>
                                <p class="social-whatsapp not_mobiles_view"><a class="hitLink" href="javascript:;" href1="https://web.whatsapp.com/send?text=<?php echo $sTitle_whatsapp; ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></p>
                            </div>

                            <ul>
                                <li class="has-child">
                                    <?php
                                    if($page_name=="")
                                        echo '<a href="#home">Home</a>';
                                    else
                                        echo '<a href="'.base_url().'">Home</a>';
                                    ?>
                                    <ul class="drop-nav">

                                        <?php
                                        if(in_array($page_name, $pages_check)){ ?>
                                            <li><a href="<?=base_url();?>pages/#judges">Meet Our Judges</a></li>
                                            <li><a href="<?=base_url();?>pages/#adverts" style="line-height:20px;">Advertise Your Business/Brands</a></li>
                                            <li><a href="<?=base_url();?>pages/#donation">Donation</a></li>
                                        <?php
                                        }else{
                                        ?>
                                            <li><a href="javascript:;" class="judges">Meet Our Judges</a></li>
                                            <li><a href="javascript:;" class="adverts" style="line-height:20px;">Advertise Your Business/Brands</a></li>
                                            <li><a href="javascript:;" class="donation">Donation</a></li>
                                        <?php } ?>

                                    </ul>
                                </li>

                                
                                <li class="has-child">
                                    <a href="javascript:;">Enter Now</a>
                                    <ul class="drop-nav">
                                        <li><a href="javascript:;" class="open_awards">Awards</a></li>
                                        <li><a href="javascript:;" class="open_actv">Our Activities</a></li>
                                        <?php
                                        if(in_array($page_name, $pages_check)){ ?>
                                            <li><a href="javascript:;" class="how_it_works">How It Works</a></li>
                                            <li><a href="javascript:;" class="regs">Registration</a></li>

                                        <?php
                                        }else{
                                        ?>
                                            <!-- <li><a href="<?=base_url();?>" class="how_it_works">How It Works</a></li> -->
                                            <li><a href="javascript:;" class="how_it_works">How It Works</a></li>
                                            <li><a href="<?=base_url();?>" class="regs">Registration</a></li>
                                        <?php } ?>

                                        <?php
                                        $fname = $profile_details['fname'];

                                        ?>

                                        <?php if(in_array($page_name, $pages_check)){ ?>
                                            <li><a href="<?=base_url();?>pages/#dashboard" style="display:none" class="java_show">Dashboard</a></li>
                                            <li><a href="javascript:;" style="display:none" class="logmeout1 java_show"><?=$fname;?> [Logout]</a></li>
                                            <?php if($validate_mem){ ?>
                                            <li><a href="<?=base_url();?>pages/#dashboard">Dashboard</a></li>
                                            <li><a href="javascript:;" class="logmeout1"><?=$fname;?> [Logout]</a></li>
                                            <?php } ?>

                                        <?php }else{ ?>

                                            <li><a href="javascript:;" style="display:none" class="java_show mydashboard">Dashboard</a></li>
                                            <li><a href="javascript:;" style="display:none" class="java_show mydashboard logmeout"><?=$fname;?> [Logout]</a></li>
                                            <?php if($validate_mem){ ?>
                                            <li><a href="javascript:;" class="mydashboard">Dashboard</a></li>
                                            <li><a href="javascript:;" class="mydashboard logmeout"><?=$fname;?> [Logout]</a></li>
                                            <?php } ?>

                                        <?php } ?>
                                    </ul>
                                </li>

                                <li class="has-child">
                                    <a href="javascript:;">PageantsHQ</a>
                                    <ul class="drop-nav">

                                        <li>
                                            <?php if(in_array($page_name, $pages_check)){ ?>
                                                <a href="<?=base_url();?>pages/#participants">Participate</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" class="participants">Participate</a>
                                            <?php } ?>
                                        </li>

                                        <li>
                                            <?php if(in_array($page_name, $pages_check)){ ?>
                                                <a href="<?=base_url();?>pages/#contestants">Contestants</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" class="past_contestants">Contestants</a>
                                            <?php } ?>
                                        </li>

                                        <li>
                                            <?php if(in_array($page_name, $pages_check)){ ?>
                                                <a href="<?=base_url();?>pages/#winner-is">The Winner Is</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" class="winner_is">The Winner Is</a>
                                            <?php } ?>
                                        </li>

                                        <li>
                                            <?php if(in_array($page_name, $pages_check)){ ?>
                                                <a href="<?=base_url();?>pages/#forum">Forum</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" class="forum">Forum</a>
                                            <?php } ?>
                                        </li>

                                        <li class="drop-has-child">
                                        <a href="javascript:;">Gallery</a>
                                            <ul class="drop-nav">
                                                <?php if(in_array($page_name, $pages_check)){ ?>
                                                    <li><a href="pages/#photos">Photos</a></li>
                                                    <li><a href="pages/#videos">Videos</a></li>
                                                <?php }else{ ?>
                                                    <li><a href="javascript:;" class="photos">Photos</a></li>
                                                    <li><a href="javascript:;" class="videos">Videos</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php if(in_array($page_name, $pages_check)){ ?>
                                            <li><a href="<?=base_url();?>pages/#events">Events</a></li>
                                        <?php }else{ ?>
                                            <li><a href="javascript:;" class="events">Events</a></li>
                                        <?php } ?>

                                    </ul>
                                </li>
                                <?php if(in_array($page_name, $pages_check)){ ?>
                                    <li class="for_mobile"><a href="<?=base_url();?>pages/#about">About Us</a></li>
                                    <li class="for_mobile"><a href="<?=base_url();?>pages/#contact">Contact Us</a></li>
                                <?php }else{ ?>
                                    <li class="for_mobile"><a href="javascript:;" class="about_us">About Us</a></li>
                                    <li class="for_mobile"><a href="javascript:;" class="contact_us">Contact Us</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="logo">
                            <a href="<?=base_url();?>#home"><img src="<?=base_url();?>images/logo1.png" alt=""></a>
                        </div>
                    </div>
                </div>
                
                <?php
                if($page_name!=""){
                    $page_refreshed = $this->input->cookie('page_refreshed', TRUE);
                    if($page_refreshed==1)
                        echo '<div class="prev_pages bckbtn"><span class="gobacktoprev1">&lArr;Back</span></div>';
                    else
                        echo '<div class="prev_pages bckbtn"><span class="gobacktoprev1">&lArr;Back</span></div>';
                }
                ?>
                <div class="prev_pages2 bckbtn" style="display:none"><span class="gobacktoprev">&lArr;Back</span></div>
            </div>
        </header>



        <header class="header_for_dashboard" style="display:none">
            <div class="header-part header-reduce sticky">

                <div class="header-bottom">
                    <div class="container">
                        <div class="menu-icon">
                            <a href="#" class="hambarger">
                                <span class="bar-1"></span>
                                <span class="bar-2"></span>
                                <span class="bar-3"></span>
                            </a>
                        </div>
                        <div class="book-table header-collect book-sm">
                        </div>

                        <?php
                        $store_memid_c = $this->input->cookie('store_memid', TRUE);
                        $fulnames_c = $this->input->cookie('fulnames', TRUE);
                        $fname_c = $this->input->cookie('fname', TRUE);
                        $lname_c = $this->input->cookie('lname', TRUE);
                        $activityid_c = $this->input->cookie('activityid', TRUE);
                        ?>

                        <div class="menu-main menu-main2">
                            <ul>
                                <li class="">
                                    <a href="javascript:;">&nbsp;</a>
                                </li>

                                <li class="for_mobile">
                                    <a href="javascript:;" class="view_profiles" activityid="<?=$activityid_c;?>" memid="<?=$store_memid_c;?>" fulnames="<?=$fulnames_c;?>" fname="<?=$fname_c;?>" lname="<?=$lname_c;?>">Back</a>
                                </li>

                                <li class="for_mobile">
                                    <a href="javascript:;" class="mydashboard">Dashboard</a>
                                </li>

                                <li class="for_mobile">
                                    <a href="javascript:;" class="edit_profile">Edit Profile</a>
                                </li>
                                <li class="for_mobile">
                                    <a href="javascript:;" class="change_passwd1">Change Password</a>
                                </li>
                                <li class="for_mobile">
                                    <a href="javascript:;" class="">Logout</a>
                                </li>
                                
                            </ul>
                        </div>

                        <div class="logo">
                            <a href="<?=base_url();?>#home"><img src="<?=base_url();?>images/logo1.png" alt=""></a>
                        </div>
                    </div>
                </div>

                <?php
                if($page_name!=""){
                    $page_refreshed = $this->input->cookie('page_refreshed', TRUE);
                    if($page_refreshed==1)
                        echo '<div class="prev_pages"><span class="gobacktoprev1">&lArr; Back</span></div>';
                    else
                        echo '<div class="prev_pages"><span class="gobacktoprev1">&lArr; Back</span></div>';
                }
                ?>
                <div class="prev_pages2" style="display:none"><span class="gobacktoprev">&lArr; Back</span></div>
                
            </div>
        </header>

        <div class="scrltotop"></div>
        <main>

                <?php if($page_name == ""){ ?>
                    <div class="main-part">

                    <div class="indexs1" style="display:nones">
                        <section class="home-slider">
                            <div class="tp-banner-container">
                                <div class="tp-banner">
                                    
                                    <div class="section-bg-overlay infinite-background above-bg" style="display:none;"></div>
                                    <div class="big_banner">
                                        <div class="tp-caption_ very_large_text" style="position:relative; z-index:99;">We're <span>OurFavCelebs</span> <font>Pageants</font></div>
                                        <div class="medium_text" style="position:relative; z-index:99;">A unique opportunity to show your <font>talents, intelligence, outfits, creativity, etc</font></div>

                                        <div class="date_of_contest">
                                            <p><b style="font-size:15px; color:#FFB7FF">Who's Next?</b></p>
                                            <?php
                                            $start_date = $contestants[0]['dates']; 
                                            if($start_date!=""){
                                                $start_date1 = @date("jS F, Y", $start_date);
                                                $start_date1 = str_replace(array("th","nd","rd","st"),  array("<sup>th</sup>","<sup>nd</sup>","<sup>rd</sup>","<sup>st</sup>"), $start_date1);
                                            }else{
                                                $start_date1 = "Coming Soon...";
                                            }
                                            ?>
                                            <p style="color:#FFFF91; font-size:18px; opacity:0.8;"><b><?=$start_date1;?></b></p>
                                        </div>

                                        <div class="btn2_ for_btns1" style="position:relative; z-index:99;"><a href="#awards" class="button-white1 open_awards">CLICK TO SEE AWARDS</a></div>
                                        <div class="btn2 for_btns" style="position:relative; z-index:99;"><a href="javascript:;" class="button-white scroll_enter">Enter Now</a></div>
                                        <div class="web_views">Visits: <?=$visits;?></div>

                                    </div>

                                    <!-- <div class="date_of_contest">
                                        <p><b style="font-size:15px; color:#FFB7FF">Who's Next?</b></p>
                                        <?php
                                        $start_date = $contestants[0]['dates']; 
                                        if($start_date!=""){
                                            $start_date1 = @date("jS F, Y", $start_date);
                                            $start_date1 = str_replace(array("th","nd","rd","st"),  array("<sup>th</sup>","<sup>nd</sup>","<sup>rd</sup>","<sup>st</sup>"), $start_date1);
                                        }else{
                                            $start_date1 = "Coming Soon...";
                                        }
                                        ?>
                                        
                                    </div> -->

                                </div>
                            </div>
                        </section>
                    </div>

                <?php }else{ ?>
                    <div class="main-part ash_color">

                    <div class="div_all_pages">
                        <section class="home-slider home-slider1">
                            <div class="tp-banner-container">
                                <div class="tp-banner">
                                    <div class="big_banner_all">
                                        <div class="very_large_text1"><?=$page_header;?></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </section>
                    </div>

                <?php } ?>
                <div class="topics_2"></div>