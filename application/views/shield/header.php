<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$page_title;?> | OurFavCelebs</title>
    <!-- Core CSS - Include with every page -->

    <link href="<?=base_url()?>assets/css2/dataTables.bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?php echo base_url() ?>css/bootstrap-3.min.css" rel="stylesheet"> <!--This is the main thing that causes the table to have good looking-->
    <link href='<?=base_url()?>assets/css2/responsive.bootstrap.min.css' rel='stylesheet' type='text/css'>
    
    <link href="<?=base_url()?>assets/css2/pe-icon-7-stroke.css" rel="stylesheet" />

    <link href="<?=base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/main-style.css" rel="stylesheet" />

    <link href="<?=base_url()?>css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>css/elegant_font/elegant_font.min.css" rel="stylesheet">

    <script src="<?=base_url()?>js/jquery-1.7.1.min.js"></script>
    <script src="<?=base_url()?>js/jscripts.js"></script>

    <link href="<?php echo base_url() ?>css/dropzone.css" rel="stylesheet">
    <link id="onyx-css" href="<?php echo base_url() ?>css/style_dropzone.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>js/dropzone.js"></script>


   </head>

<?php $url_seg = $this->uri->segment(3); ?>
<body style="background:#fff;">
<input type="hidden" value="<?=base_url()?>" id="txtsite_url">
<input type="hidden" value="<?php echo $page_name; ?>" id="txt_pagename">
<input type="hidden" value="<?php echo $page_title; ?>" id="txt_pagename1">
<input type="hidden" value="<?php echo $url_seg; ?>" id="txtqry">
    <!--  wrapper -->
    <div id="wrapper">

    
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle navbar_toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=base_url()?>">
                    <img src="<?=base_url()?>images/logo1.png" alt="" />
                </a>


                <ul class="nav_ navbar-top-links_ navbar-right_ user_acct">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-2x"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?=base_url()?>shield/settings/">Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=base_url()?>shield/logout/">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div>

        </nav>



        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <?php $pics1 = base_url()."images/girl.png"; ?>
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                                <img src="<?=$pics1;?>" alt="">
                            </div>
                            <div class="user-info">
                                <div>&nbsp;Admin</div>
                                <div class="user-text-online">
                                    <span class="user-circle-online "></span>&nbsp;
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    
                    <li <?php if($page_name=="") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                    <li <?php if($page_name=="enter_activity") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/enter_activity/"><i class="fa fa-edit fa-fw"></i> Enter Activity</a></li>
                    <li <?php if($page_name=="view_activities") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/view_activities/"><i class="fa fa-eye fa-fw"></i> View Activities</a></li>
                    <li <?php if($page_name=="contestants") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/contestants/"><i class="fa fa-eye fa-fw"></i> View Contestants</a></li>
                    <li <?php if($page_name=="enter_score") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/enter_score/"><i class="fa fa-check-circle fa-fw"></i> Score Contestants</a></li>
                    <li <?php if($page_name=="compute_winner") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/compute_winner/"><i class="fa fa-edit fa-fw"></i> Compute Winners</a></li>

                    <li <?php if($page_name=="wallets") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/wallets/"><i class="fa fa-money fa-fw"></i> Fund Wallet</a></li>

                    <li <?php if($page_name=="view_winner") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/view_winner/"><i class="fa fa-eye fa-fw"></i> View Winners</a></li>
                    <li <?php if($page_name=="voters") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/voters/"><i class="fa fa-eye fa-fw"></i> Voters</a></li>
                    <li <?php if($page_name=="campaigns") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/campaigns/"><i class="fa fa-eye fa-fw"></i> Campaigns</a></li>
                    <li <?php if($page_name=="creategames") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/creategames/"><i class="fa fa-edit fa-fw"></i> Create Trivia Game</a></li>
                    <li <?php if($page_name=="viewgames") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/viewgames/"><i class="fa fa-eye fa-fw"></i> View Trivia Game</a></li>
                    <li <?php if($page_name=="uploadevents") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/uploadevents/"><i class="fa fa-eye fa-fw"></i> Upload Events</a></li>
                    <li <?php if($page_name=="viewevents") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/viewevents/"><i class="fa fa-eye fa-fw"></i> View Events</a></li>
                    <li <?php if($page_name=="uploadmedia") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/uploadmedia/"><i class="fa fa-edit fa-fw"></i> Upload Media</a></li>
                    <li <?php if($page_name=="viewmedia") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/viewmedia/"><i class="fa fa-edit fa-fw"></i> View Media</a></li>
                    <li <?php if($page_name=="paidusers") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/paidusers/"><i class="fa fa-edit fa-fw"></i> Paid Users</a></li>
                    <li <?php if($page_name=="forum") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/forum/"><i class="fa fa-eye fa-fw"></i> Forum</a></li>
                    <li <?php if($page_name=="forumreply") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/forumreply/"><i class="fa fa-eye fa-fw"></i> Forum Replies</a></li>
                    <li <?php if($page_name=="settings") echo 'class="active"'; ?>><a href="<?=base_url()?>shield/settings/"><i class="fa fa-gears fa-fw"></i> Settings</a></li>
                    <li><a href="<?=base_url()?>shield/logout/"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>
                    <li>&nbsp;</li>
                    
                </ul>
            </div>
        </nav>
        <div style="clear:both;"></div>

    