<?php
$page_name2 = str_replace('_', " ", $page_title);
?>


<!-- <div class="breadcrumbs">
    <div class="col-sm-6">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>
                    <ol class="breadcrumb text-right">
                        <li class="active" style="font-weight:bold; color:#FF6820;">
                        <?php
                        // if($page_name == "")
                        //     echo $show_name;
                        // else
                        //     echo $page_name2;
                        ?></li>
                    </ol>
                </h1>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="page-header float-right">
            <div class="page-title ">
                <h1><b><? //=$easer_type; ?> Dashboard</b></h1>
            </div>
        </div>
    </div>
</div> -->

<div id="page-wrapper" class="page-wrapper1">
    <div class="col-sm-12 float_left" style="padding:0 0 0 8px">
        <h1 class="page-header">
        <?php
        if($page_name == "")
            echo "Administrator";
        else
            echo $page_name2;
        ?>
        </h1>
    </div>

    <!-- <div class="col-sm-6 float_right" style="padding:0">
        <h1 class="page-header">
            
        </h1>
    </div> -->
</div>


<p style="text-align:center; font-size:16px;">
    <?php 
        $url_seg = $this->uri->segment(3);
        if($url_seg=="current")
            echo "Viewing current cart between interval of 5 days.";
        else if($url_seg=="unapproved")
            echo "Viewing Unapproved Products";
    ?>
</p>


<div class="modal fade" id="delete_dv" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>

            <div class="modal-body">
                <input type="hidden" id="txtall_id">
                <div class="alert alert-danger" style="font-size:15px;"><span class="fa fa-warning"></span> Are you sure you want to delete this <font class="capt1"></font>?</div>
            </div>

            <input type="hidden" id="txt_dbase_table" value="<?=$page_name;?>">

            <div class="modal-footer ">
                <button type="button" class="btn btn-success cmd_remove_adm" ><span class="fa fa-trash-o"></span>&nbsp;Yes</button>
                <button type="button" class="btn btn-success cmd_remove_adm1" style="opacity:0.4; display:none;"><span class="fa fa-trash-o"></span>&nbsp;Yes</button>
                <button type="button" class="btn btn-default cmd_close_del" data-dismiss="modal"><span class="fa fa-times"></span>&nbsp;No</button>
            </div>
        </div>
    </div>
</div>


<?php 
if($page_name == ""){ 
?>

<div id="page-wrapper" class="small_box">

    <div class="row">
        <!--quick info section -->
        <div class="col-lg-3 boxes">
            <div class="alert alert-danger text-center">
                <i class="fa fa-user fa-3x"></i>&nbsp;Total of <b><?=@number_format($totalcontestant);?></b> Contestants
            </div>
        </div>

        <div class="col-lg-3 boxes">
            <div class="alert alert-success text-center">
                <i class="fa  fa-tachometer fa-3x"></i>&nbsp;<b><?=@number_format($main_activities);?> </b> Activities
            </div>
        </div>

        <div class="col-lg-3 boxes">
            <div class="alert alert-info text-center">
                <i class="fa fa-money fa-3x"></i><b><?=@number_format($total_voters);?></b> Voters

            </div>
        </div>
        
        <div class="col-lg-3 boxes">
            <div class="alert alert-warning text-center">
                <i class="fa fa-eye fa-3x"></i>Website Views <b><?=@number_format($webviews);?></b>
            </div>
        </div>
        <!--end quick info section -->
    </div>

    <div class="row">
        <div class="col-lg-8">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-user fa-fw"></i> Contestants (Last 5 contestants)
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12_">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tbl_color">
                                    <thead>
                                        <tr>
                                            <th>Names</th>
                                            <th>Approved</th>
                                            <th>Phone</th>
                                            <th>State</th>
                                            <th>Gender</th>
                                            <th>Date Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $j=1;
                                        if(!empty($fetchMembers)): foreach($fetchMembers as $post): ?>
                                        <?php
                                            $fname = $post['fname'];
                                            $lname = $post['lname'];
                                            $ful_name = ucwords("$fname $lname");
                                            $approved = $post['approved'];
                                            $phones = $post['phones'];
                                            $statee = $post['statee'];
                                            $gender = $post['gender'];
                                            $dates = $post['dates'];
                                            $dates = date("D jS M Y h:ia", strtotime($dates));

                                            if($gender=="m") $gender="Male"; else $gender="Female";
                                            if($approved == 1)
                                                $approved = "<font style='color:#093;'><b>Approved</b></font>";
                                            else
                                                $approved = "<font style='color:red;'><b>Pending Approval...</b></font>";                                
                                        ?>
                                        <tr>
                                            <td><?=$ful_name;?></td>
                                            <td><?=$approved;?></td>
                                            <td><?=$phones;?></td>
                                            <td><?=$statee;?></td>
                                            <td><?=$gender;?></td>
                                            <td><?=$dates;?></td>
                                        </tr>
                                    <?php $j++; endforeach; else: ?>
                                    <tr><td colspan="6" style="text-align:center;">No contestants yet!</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="txtaction">
                                        <option value="" selected>-Select-</option>
                                        <option value="all">View All</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-briefcase fa-fw"></i> Activities
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12_">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tbl_color">
                                    <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Title</th>
                                            <th>Approved</th>
                                            <th>Status</th>
                                            <th>Done</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $j=1;
                                        if(!empty($fetch_main_activities)): foreach($fetch_main_activities as $post): ?>
                                        <?php
                                            $overall_title = ucwords($post['overall_title']);
                                            $approved = $post['approved'];
                                            $has_done = $post['has_done'];
                                            $dates = $post['dates'];
                                            $one_week_timings = $post['one_week_timings'];

                                            if($dates=="") $dates="Not specified";
                                            $dates = date("D jS M Y h:ia", $dates);

                                            if($has_done==0) 
                                                $has_done1 = "<font style='color:red; font-weight:bold;'>Not Done</font>";
                                            else
                                                $has_done1 = "<font style='color:#093; font-weight:bold;'>Game Done</font>";
                                            
                                            if($approved == 1){
                                                $approved_1 = "<font style='color:#090; font-size:15px;'><b>Approved</b></font>";
                                            }else{
                                                $approved_1 = "<font style='color:red; font-size:14px;'><b>Not Approved</b></font>";
                                            }

                                            $seven_weeks1="<label style='color:red'>Expired</label>";
                                
                                            if($one_week_timings>0){
                                                $seven_weeks1 = date("jS F, Y h:ia", $one_week_timings);
                                            }
                                
                                            $seven_weeks1 = "Will Expire on <br><b>$seven_weeks1</b>";
                                            
                                        ?>
                                        <tr>
                                            <td><?=$j;?></td>
                                            <td><?=$overall_title;?></td>
                                            <td><?=$approved_1;?></td>
                                            <td><?=$seven_weeks1;?></td>
                                            <td><?=$has_done1;?></td>
                                            <td><?=$dates;?></td>
                                        </tr>
                                    <?php $j++; endforeach; else: ?>
                                    <tr><td colspan="6" style="text-align:center;">No activities yet!</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="txtaction1">
                                        <option value="" selected>-Select-</option>
                                        <option value="all">View All</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            

        </div>

        <div class="col-lg-4">
            <div class="panel panel-primary text-center no-boder">
                <div class="panel-body red">
                    <i class="fa fa-money fa-3x"></i>
                    <h3><?php echo @number_format($total_donatns);?> </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">Number of Donations
                    </span>
                </div>
            </div>

            <div class="panel panel-primary text-center no-boder">
                <div class="panel-body green">
                    <i class="fa fa-truck fa-3x"></i>
                    <h3><?php echo @number_format($total_riders);?> </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">xxxxxx
                    </span>
                </div>
            </div>

            
            <!-- <div class="panel panel-primary text-center no-boder">
                <div class="panel-body red">
                    <i class="fa fa-thumbs-up fa-3x"></i>
                    <h3>2,700 </h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-eyecandy-title">New User Registered
                    </span>
                </div>
            </div> -->


        </div>

    </div>

<br><br>
</div>


<?php } ?>






<?php if($page_name == "view_activities"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="myactivities" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Approved</th>
                            <th>Status</th>
                            <th>Timing</th>
                            <th>Done</th>
                            <th class="none">Instruction</th>
                            <th class="none">Disqualification</th>
                            <th class="none">Date to enable Registration button</th>
                            <th class="none">Date to close Registration button</th>
                            <th class="none">&nbsp;</th>
                            <th>Date Of Activity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>

        
    </div>

<?php } ?>


<?php 
if($page_name == "viewtrivia"){
    $url_task1 = $this->uri->segment(3);
    $usequiz1 = $this->sql_models->isUseQuests('quizes_intro', $url_task1);
?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <p style="text-align:center; font-size:16px;" class="add_questns"><span sess="<?=$usequiz1;?>">Add Another Question</span></p>
                    <table id="mytrivia" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Questions</th>
                            <th class="none">Image</th>
                            <th>Option1</th>
                            <th>Option2</th>
                            <th>Option3</th>
                            <th>Option4</th>
                            <th>Option5</th>
                            <th>Answer</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>

        
    </div>

<?php } ?>


<?php if($page_name == "contestants"){ ?>
    
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="contestants" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Names</th>
                            <th>Approved</th>
                            <th>Paid</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>State</th>
                            <th>Gender</th>
                            <th>Occupation</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                            <th class="none">Picture</th>
                            <th class="none">Relationship Status</th>
                            <th class="none">Hobbies</th>
                            <th class="none">Likes</th>
                            <th class="none">Dislikes</th>
                            <th class="none">Kind of Partner</th>
                            <th class="none">Biography</th>
                            <th class="none">How Did You Hear About Us</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>

        
    </div>

<?php } ?>


<?php if($page_name == "voters"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_voters" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Voters Contact</th>
                            <th>Paid</th>
                            <th>Contestant</th>
                            <th>Activity</th>
                            <th>Account Name</th>
                            <th>Bank Name</th>
                            <th>Amount Paid</th>
                            <!-- <th>Action</th> -->
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>

        
    </div>

<?php } ?>




<?php if($page_name == "wallets"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_wallets" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Voters</th>
                            <th>Paid</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Date Submitted</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
<?php } ?>



<?php if($page_name == "campaigns"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_voters" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Contestant</th>
                            <th>Votes</th>
                            <th>Voters</th>
                            <th>Activity</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>

<?php } ?>


<?php if($page_name == "viewgames"){ ?>
    
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_games" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>Approved</th>
                            <th>Completed</th>
                            <th>Time Set</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>

        
    </div>

<?php } ?>


<?php if($page_name == "viewmedia"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_medias" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Views</th>
                            <th>Date</th>
                            <th class="none">Media</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>

<?php } ?>



<?php if($page_name == "viewevents"){ ?>

    <link href="<?php echo base_url(); ?>css/video-js.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>js/videojs-ie8.min.js"></script>
    <script src="<?php echo base_url(); ?>js/video.js"></script>
    
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="all_events" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Views</th>
                            <th>Date</th>
                            <th class="none">Description</th>
                            <th class="none">Media</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>

<?php } ?>



<?php if($page_name == "paidusers"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <p style="font-size:16px;">These are the contestants that have paid so far for activities.</p>
                    <table id="all_paids" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Contestants</th>
                            <th>Activity</th>
                            <th>Amount</th>
                            <th>Dates</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>

<?php } ?>


<?php if($page_name == "forum"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <!-- <p style="font-size:16px;">These are the contestants that have paid so far for activities.</p> -->
                    <table id="forum1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Users</th>
                            <th>Topic</th>
                            <th>Replies</th>
                            <th>Views</th>
                            <th>Dates</th>
                            <th>Action</th>
                            <th class="none">Message</th>
                            <th class="none">Files</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>

<?php } ?>


<?php if($page_name == "forumreply"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <!-- <p style="font-size:16px;">These are the contestants that have paid so far for activities.</p> -->
                    <table id="forum_rep1" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Replies</th>
                            <th>Users</th>
                            <th>Replied To</th>
                            <th>Dates</th>
                            <th>Action</th>
                            <th class="none">Post</th>
                            <th class="none">Replies</th>
                            <th class="none">Files</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>

<?php } ?>


<?php if($page_name == "customers1"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables tbl_mer_cus">
                    <table id="yourcus_mer" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <!-- <th>Location</th> -->
                            <th>Address</th>
                            <!-- <th>Date Ordered</th> -->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
 
                        </tbody>

                    </table>
                </div>

            </div>
            <br><br><br><br>
        </div>

        
    </div>

<?php } ?>




<?php if($page_name == "uploadevents" || $page_name == "edit_events"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">

        <div class="col-md-8" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                if($url_id!="")
                                echo '<h3 class="text-center ttl"><b>Update This Events</b></h3>';
                                else
                                echo '<h3 class="text-center"><b>Create A New Events</b></h3>';
                                ?>
                                <p>All events/media uploaded here will be seen on the event page
                                </p>
                            </div>
                            <hr>
                            <?php
                                //echo form_open('', array('autocomplete'=>'off', 'id'=>'create_main_activity'));
                                //$new1 = "";
                                if($url_id!=""){
                                    $id1 = md5($getId['id']);
                                    $titles = ucwords($getId['titles']);
                                    $descrip = $getId['descrip'];
                                    $captions1 = "Update Events";
                                    $captions2 = "Updating...";
                                    $captions1i = "Update Events";
                                    $captions2i = "Updating...";
                                }else{
                                    $id1="";$titles="";$descrip="";
                                    $captions1 = "Upload Events";
                                    $captions2 = "Uploading...";
                                    $captions1i = "Upload Events";
                                    $captions2i = "Uploading...";
                                }

                            ?>
                                
                                <div class="first_create_form" style="display:nones;">
                                    <?php echo form_open('', array('autocomplete'=>'off', 'id'=>'create_evts')); ?>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Title</label>
                                            <input type="text" value="<?=$titles;?>" placeholder="Enter title of event" name="txttitle" id="txttitle" class="form-control" style="text-transform:capitalize;">
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-name" class="control-label mb-1">Contents</label>
                                            <textarea id="txtdescrip" name="txtdescrip" style="height:20em !important;" placeholder="Write the contents of this this event" class="form-control"><?php echo ucfirst($descrip);?></textarea>
                                        </div>

                                        <input type="hidden" name="actid" value="<?php echo $id1; ?>" />


                                        <div class="col-md-offset-3 col-md-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1">
                                                <input type="button" value="<?=$captions1i;?>" actid="<?=$id1;?>" id="cmd_upload_media" class="btn btn-lg btn-info btn-block inlines_">
                                                <input type="button" value="<?=$captions2i;?>" id="cmd_upload_media1" class="btn btn-lg btn-info btn-block" style="opacity:0.4; display:none;">
                                                <?php 
                                                if($id1!="")
                                                echo '<input type="button" value="Go Next &raquo;" id="cmd_next_evt" actid="'.$id1.'" class="btn btn-lg btn-info btn-block inlines">';
                                                ?>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="err_div4"></div>
                                    <?php echo form_close(); ?>
                                </div>


                                <div class="second_create_form" style=" display:none;">
                                    
                                    <div class="java_uploader">
                                        <div class='content'>
                                            <form action="<?php echo base_url() ?>upload.php" class="dropzone" id="myAwesomeDropzone"> 
                                                <div class="former_uploads" style="display:none"></div>
                                            </form>
                                        </div>
                                    </div>

                                    <?php echo form_open_multipart('', array('class'=>'uploadimage2', 'autocomplete'=>'off')); ?>
                                        <div class="simple_uploader" style="display:none; border:2px solid #ccc; padding:20px 4px 20px 4px; margin-left:-4px;">
                                            <p style="color:#444; margin-left:6px;">Select multiple photos</p>
                                            <input type="file" name="txt_bma_pic1[]" multiple id="txt_bma_pic1" style="padding:4px; font-size:15px; margin-top:8px;" />
                                        </div>

                                        <p style="margin:10px 0 10px 0; font-size:17px; text-align:center">
                                            <span style="color:#09C; cursor:pointer;" class="basic_uploader1"><b>Try the simple uploader</b></span>
                                            <span style="color:#09C; cursor:pointer; display:none" class="big_uploader"><b>Try normal Uploader</b></span>
                                        </p>
                                        
                                        <div class="col-md-offset-3 col-md-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1" class="auto_uploader_div">
                                                <input type="button" value="Done" id="cmd_done_upload" class="btn btn-lg btn-info btn-block">
                                            </div>

                                            <div style="text-align:center; margin-top:1em; display:none;" id="buttons1" class="basic_uploader_div">
                                                <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" class="btn btn-lg btn-info btn-block cmddones_basic">
                                                <input type="button" value="<?=$captions2;?>" class="btn btn-lg btn-info btn-block cmddones_basic1" style="opacity:0.4; display:none;">
                                                <?php
                                                if($id1!="")
                                                echo '<input type="button" value="Go Next &raquo;" id="cmd_next_evt1" class="btn btn-lg btn-info btn-block inlines">';
                                                ?>
                                            </div>
                                        </div>

                                        <div style="clear:both"></div>
                                        <div class="err_div4"></div>
                                    <?php echo form_close(); ?>
                                </div>


                                <div class="third_create_form" style="display:none; text-align:center;">
                                    <p><img src="<?php echo base_url() ?>images/checkmark.png"></p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>This Event has been updated successfully</b></p>
                                        <p style="font-size:16px; color:#093;">
                                            It will be seen on the platform immediately on the events page
                                        </p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>An Event has been uploaded successfully</b></p>
                                        <p style="font-size:16px; color:#093;">
                                            It will be seen on the platform immediately on the events page
                                        </p>
                                    <?php } ?>

                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Done" id="cmd_goto_firstform" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>

                                <br><br>

                        </div>
                    </div>

                </div>
            </div> 

        </div>

        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>




<?php if($page_name == "enter_activity" || $page_name == "edit_activity"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">

        <div class="col-md-8" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                if($url_id1=="new")
                                echo '<h3 class="text-center"><b>Create A New Game Title For This Activity</b></h3>';
                                else{
                                    if($url_id!="")
                                    echo '<h3 class="text-center ttl"><b>Update This Activity</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Create A New Game Title For This Activity</b></h3>';
                                }

                                ?>
                                <p>Note that all activities that will be created is only for one week (7 days). As soon as you create an activity
                                    it will be seen unless you approve it. On approval, a one-week will be saved and start counting.
                                </p>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'create_main_activity'));
                                $new1 = "";
                                if($url_id!=""){
                                    $id1 = md5($getId['id']);
                                    $overall_title = $getId['overall_title'];
                                    $overall_title1 = ucwords($overall_title);
                                    $instructn = $getId['instructn'];
                                    $disqualificatn = $getId['disqualificatn'];
                                    $for_days = $getId['for_days'];
                                    $game_type = $getId['game_type'];
                                    $starting_from = $getId['starting_from'];
                                    $day_instructns = $getId['day_instructns'];
                                    $titles = $getId['titles'];
                                    $time_duratn = $getId['time_duratn'];
                                    $timings = $getId['timings'];

                                    $prize1 = $getId['prize1'];
                                    $prize2 = $getId['prize2'];
                                    $prize3 = $getId['prize3'];
                                    $gift1 = $getId['gift1'];
                                    $gift2 = $getId['gift2'];
                                    $gift3 = $getId['gift3'];
                                    $banners = $getId['banners'];

                                    $enable_reg = $getId['enable_reg'];
                                    $disable_reg = $getId['disable_reg'];
                                    $enable_reg = date("Y-m-d", $enable_reg);
                                    $disable_reg = date("Y-m-d", $disable_reg);

                                    $datesx = $getId['dates'];
                                    $datesx = date("Y-m-d", $datesx);
                                    $captions1 = "Update Activity";
                                    $captions2 = "Updating...";
                                    $captions1i = $captions1;
                                    $captions2i = $captions2;

                                }else{
                                    $id1="";$overall_title="";$overall_title1="";$instructn="";$disqualificatn="";$for_days="";$game_type="";$starting_from="";
                                    $day_instructns="";$time_duratn="";$timings="";$titles=""; $dates="";$d_year="";$d_month="";$d_day1="";
                                    $captions1 = "Create Activity";
                                    $captions2 = "Creating...";
                                    $captions1i = "Create Activity";
                                    $captions2i = "Creating...";
                                    $prize1 = "";$prize2 = "";$prize3 = "";$gift1 = "";$gift2 = "";$gift3 = "";$banners="";
                                    $enable_reg = "";
                                    $disable_reg = "";
                                    $datesx = "";
                                }

                                if($url_id1==""){
                                    $disply1 = "display:nones;";
                                    $disply2 = "display:none;";
                                }else{
                                    $disply1 = "display:none;";
                                    $disply2 = "display:nones;";
                                }

                                if($url_id1=="new"){
                                    $captions1 = "Create Activity";
                                    $captions2 = "Creating...";
                                    $captions1i = "Create Activity";
                                    $captions2i = "Creating...";
                                    $new1 = "new";
                                    $overall_title="";$instructn="";$disqualificatn="";$for_days="";$game_type="";$starting_from="";
                                    $day_instructns="";$time_duratn="";$timings="";$titles=""; $prize1 = "";$prize2 = "";$prize3 = "";$gift1 = "";$gift2 = "";$gift3 = "";
                                }else if($url_id1!="new" && $url_id1!=""){
                                    $new1 = $url_id1;
                                }


                            ?>
                                
                                <div class="first_create_form" style="<?=$disply1;?> display:nones;">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Title</label>
                                        <input type="text" value="<?=$overall_title;?>" placeholder="Enter title of activity" name="txttitle" id="txttitle" class="form-control" style="text-transform:capitalize;">
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-name" class="control-label mb-1">Instruction</label>
                                        <textarea id="txtinstruc" name="txtinstruc" placeholder="Write the instructions of this activity" class="form-control"><?php echo ucfirst($instructn);?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Disqualification</label>
                                        <textarea id="txtdis" name="txtdis" placeholder="Write the disqualification of this activity" class="form-control"><?php echo ucfirst($disqualificatn);?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input id="former_file4" name="former_file4" value="<?php echo $banners; ?>" class="form-control" style="display:none;" />
                                        <label for="cc-number" class="control-label mb-1">Upload Banner For this Activity</label>
                                        <input type="file" name="file_banner" id="file_banner" style="padding:4px; font-size:16px; display:nones" />

                                        <?php
                                        if($url_id!=""){
                                            echo "<font class='update_imgs1'>";
                                            if($gift1=='')
                                            echo "";
                                            else
                                            echo "<img src='".base_url()."events_fols/$banners' src1='".base_url()."images/celebs_awards.png' id='im10'>";
                                            echo "</font>";
                                        }
                                        ?>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Choose Date Of Registration</label>
                                        <p style="font-size:14px;">The date specified below will enable the registration button and disable it when the specified date is over</p>
                                        <p style="font-size:16px;"><b>FROM / TO</b> (month / day / year)</p>
                                        <?php
                                        $cur_date = date("Y-m-d", time()); 
                                        if($enable_reg=="") $cur_date1 = $cur_date; else $cur_date1 = $enable_reg;
                                        ?>
                                        <input type="date" name="txtfrom" id="txtfrom" value="<?=$cur_date1;?>" class="form-control inputdate1" />
                                        <input type="date" name="txtto" id="txtto" value="<?=$disable_reg;?>" class="form-control inputdate1" />

                                    </div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Choose Date Of Starting Activity <span style="font-weight:normal">(month / day / year)</span></label>
                                        <input type="date" name="inputdate2" value="<?=$datesx;?>" id="inputdate2" class="form-control" />
                                        <?php /* ?><div class="row">
                                            <div class="col-md-4">
                                                <select id="txtdays" name="txtdays">
                                                    <option value="" <?php //if($for_days=="") echo "selected"; ?> >-Select Day-</option>
                                                    <?php 
                                                    for($i=1; $i<=31; $i++){ 
                                                        if(strlen($i)<=1) $j = "0$i"; else $j = $i;
                                                        ?>
                                                        <option value="<?=$i;?>" <?php if($d_day1==$i) echo "selected"; ?>><?=$j;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <select id="txtmonths" name="txtmonths">
                                                    <option value="" <?php //if($for_days=="") echo "selected"; ?> >-Select Month-</option>
                                                    <?php
                                                    $cur_mon = date("m", time());
                                                    for($i=1; $i<=12; $i++){ 
                                                        if(strlen($i)<=1) $j = "0$i"; else $j = $i;
                                                        if($j=="01") $k="January";
                                                        else if($j=="02") $k="Febuary";
                                                        else if($j=="03") $k="March";
                                                        else if($j=="04") $k="April";
                                                        else if($j=="05") $k="May";
                                                        else if($j=="06") $k="June";
                                                        else if($j=="07") $k="July";
                                                        else if($j=="08") $k="August";
                                                        else if($j=="09") $k="September";
                                                        else if($j=="10") $k="October";
                                                        else if($j=="11") $k="November";
                                                        else $k="December";
                                                        ?>
                                                        <option value="<?=$i;?>" <?php if($cur_mon==$i && $d_month=="") echo "selected"; else if($d_month==$i) echo "selected"; ?>><?=$k;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <select id="txtyears" name="txtyears">
                                                    <option value="" <?php //if($for_days=="") echo "selected"; ?> >-Select Year-</option>
                                                    <?php 
                                                    $cur_year = date("Y", time());
                                                    for($i=$cur_year; $i<=$cur_year+2; $i++){
                                                        ?>
                                                        <option value="<?=$i;?>" <?php if($cur_year==$i && $d_year=="") echo "selected"; else if($d_year==$i) echo "selected"; ?>><?=$i;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div><?php */ ?>
                                    </div>
                                    <div style="clear:both"></div>



                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">First Prize (Amount &#8358;)</label>
                                        <input type="number" name="txtfprize" value="<?php echo $prize1; ?>" placeholder="Enter First Prize" class="form-control" />

                                        <?php
                                        if($url_id!=""){
                                            echo "<font class='update_imgs1'>";
                                            if($gift1=='')
                                            echo "";
                                            else
                                            echo "<img src='".base_url()."gifts/$gift1' src1='".base_url()."images/celebs_awards.png' id='im10'>";
                                            echo "</font>";
                                        }
                                        ?>
                                        <input id="former_file1" name="former_file1" value="<?php echo $gift1; ?>" class="form-control" style="display:none;" />
                                        <p style="margin:10px 0 0px 0; font-size:15px; color:#333;"><b>Upload Picture of Gift</b></p>
                                        <input type="file" name="file_gift1" id="file_gift1" style="padding:4px; font-size:16px; display:nones" />
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Second Prize (Amount &#8358;)</label>
                                        <input type="number" name="txtsprize" value="<?php echo $prize2; ?>" placeholder="Enter Second Prize" class="form-control" />

                                        <?php
                                        if($url_id!=""){
                                            echo "<font class='update_imgs1'>";
                                            if($gift2=='')
                                            echo "";
                                            else
                                            echo "<img src='".base_url()."gifts/$gift2' src1='".base_url()."images/celebs_awards.png' id='im10'>";
                                            echo "</font>";
                                        }
                                        ?>
                                        <input id="former_file2" name="former_file2" value="<?php echo $gift2; ?>" class="form-control" style="display:none;" />
                                        <p style="margin:10px 0 0px 0; font-size:15px; color:#333;"><b>Upload Picture of Gift</b></p>
                                        <input type="file" name="file_gift2" id="file_gift2" style="padding:4px; font-size:16px; display:nones" />
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Third Prize (Amount &#8358;)</label>
                                        <input type="number" name="txttprize" value="<?php echo $prize3; ?>" placeholder="Enter Third Prize" class="form-control" />

                                        <?php
                                        if($url_id!=""){
                                            echo "<font class='update_imgs1'>";
                                            if($gift3=='')
                                            echo "";
                                            else
                                            echo "<img src='".base_url()."gifts/$gift3' src1='".base_url()."images/celebs_awards.png' id='im10'>";
                                            echo "</font>";
                                        }
                                        ?>
                                        <input id="former_file3" name="former_file3" value="<?php echo $gift3; ?>" class="form-control" style="display:none;" />
                                        <p style="margin:10px 0 0px 0; font-size:15px; color:#333;"><b>Upload Picture of Gift</b></p>
                                        <input type="file" name="file_gift3" id="file_gift3" style="padding:4px; font-size:16px; display:nones" />
                                    </div>

                                    <input type="hidden" name="actid" value="<?php echo $id1; ?>" />
                                    <input type="hidden" name="qrys" value="<?php echo $new1; ?>" />


                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_create_activity" class="btn btn-lg btn-info btn-block inlines_">
                                            <input type="button" value="<?=$captions2;?>" id="cmd_create_activity1" class="btn btn-lg btn-info btn-block" style="opacity:0.4; display:none;">
                                            <?php 
                                            if($id1!="")
                                            echo '<input type="button" value="Go Next &raquo;" id="cmd_next_act" class="btn btn-lg btn-info btn-block inlines">';
                                            ?>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="err_div4"></div>
                                </div>


                                <div class="second_create_form" style="<?=$disply2;?> display:nones;">
                                    <p style="font-size:17px; text-align:center; color:#09C;"><b>Main Activity: <font class="main_actvs1" style="text-transform:capitalize;"><?=$overall_title1;?></font></b></p>
                                    <p style="font-size:15px; margin-bottom:17px; text-align:center;"><b>A picture game is advised to be chosen first so that the contestant pictures will be on the home page.</b></p>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Select Day</label>
                                        <select id="txtday" name="txtday">
                                            <option value="" <?php if($for_days=="") echo "selected"; ?> >-Select Day-</option>
                                            <option value="mon" <?php if($for_days=="mon") echo "selected"; ?>>Monday</option>
                                            <option value="tue" <?php if($for_days=="tue") echo "selected"; ?>>Tuesday</option>
                                            <option value="wed" <?php if($for_days=="wed") echo "selected"; ?>>Wednesday</option>
                                            <option value="thu" <?php if($for_days=="thu") echo "selected"; ?>>Thursday</option>
                                            <option value="fri" <?php if($for_days=="fri") echo "selected"; ?>>Friday</option>
                                            <option value="sat" <?php if($for_days=="sat") echo "selected"; ?>>Saturday</option>
                                            <option value="sun" <?php if($for_days=="sun") echo "selected"; ?>>Sunday</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-name" class="control-label mb-1">Game Type</label>
                                        <select id="txtgametype" name="txtgametype">
                                            <option value="" <?php if($game_type=="") echo "selected"; ?> >-Select Game Type-</option>
                                            <option value="pic" <?php if($game_type=="pic") echo "selected"; ?> >Upload Picture Game</option>
                                            <option value="qz" <?php if($game_type=="qz") echo "selected"; ?> >Trivia Games</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Game Title</label>
                                        <textarea id="txtgtitle" name="txtgtitle" placeholder="Write the title of the game" class="form-control" style="height:90px !important;"><?php echo $titles;?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Selected Day's Instruction</label>
                                        <textarea id="txtins" name="txtins" placeholder="Write the Instruction of the selected day's activity" class="form-control" style="height:110px !important;"><?php echo $day_instructns;?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Time Duration</label><br>
                                        <font>The time duration when this day's activity will be carried out</font>
                                        <select id="txttime" name="txttime">
                                            <option value="">-Select Time-</option>
                                            <option value="3" <?php if($time_duratn==3) echo "selected"; ?>>3 hours</option>
                                            <option value="5" <?php if($time_duratn==5 || $time_duratn=="") echo "selected"; ?>>5 hours</option>
                                            <option value="8" <?php if($time_duratn==8) echo "selected"; ?>>8 hours</option>
                                            <option value="10" <?php if($time_duratn==10) echo "selected"; ?>>10 hours</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Starting From</label>
                                        <select id="txtstart" name="txtstart">
                                            <option value="" selected>-Starting Time-</option>
                                            <?php 
                                            for($i=1; $i<=8; $i++){ ?>
                                                <option value="<?=$i;?>" <?php if($starting_from==$i) echo "selected"; ?>><?=$i;?> PM</option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="<?=$captions1;?>" actid="<?=$id1;?>" qrys="<?=$new1;?>" id="cmd_create_sec_activity" class="btn btn-lg btn-info btn-block">
                                            <input type="button" value="<?=$captions2;?>" id="cmd_create_sec_activity1" class="btn btn-lg btn-info btn-block" style="opacity:0.4; display:none;">
                                            <?php
                                            if($id1!="")
                                            echo '<input type="button" value="Go Next &raquo;" id="cmd_next_act1" class="btn btn-lg btn-info btn-block inlines">';
                                            ?>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="err_div4"></div>
                                </div>


                                <div class="third_create_form" style="display:none; text-align:center;">
                                    <p><img src="<?php echo base_url() ?>images/checkmark.png"></p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>This Activity has been updated successfully</b></p>
                                        <p style="font-size:16px; color:#093;">It will be updated as well. If you have selected <b>Trivia Games</b> please input the 
                                            trivia games first by clicking on <a href="<?=base_url();?>shield/creategames/"><b>Create Trivia Game</b></a> before you approve this activity.
                                        </p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>An Activity has been created successfully</b></p>
                                        <p style="font-size:16px; color:#093;">It will be active and be seen on the platform when you go to 
                                            view activities and approve it.<br>If you have selected <b>Trivia Games</b> please input the 
                                            trivia games first by clicking on <a href="<?=base_url();?>shield/creategames/">"Create Trivia Game"</a> before you approve this activity.
                                        </p>
                                    <?php } ?>

                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Done" id="cmd_goto_viewacts" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>

                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 

        </div>

        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>


<?php if($page_name == "uploadmedia" || $page_name == "editmedia"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">

        <div class="col-md-8" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                    if($url_id!="")
                                    echo '<h3 class="text-center ttl"><b>Update This Media</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Upload A Media</b></h3>';
                                ?>
                                <p>Any media uploaded here will be shown on the gallery pages
                                </p>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'upload_medias'));
                                $new1 = "";
                                if($url_id!=""){
                                    $id1 = md5($getId['id']);
                                    $titles = ucwords($getId['titles']);
                                    $files = $getId['files'];
                                    $media_type = $getId['media_type'];
                                    $captions1 = "Update Media";
                                    $captions2 = "Updating...";
                                    

                                }else{
                                    $id1="";$titles="";$files="";$media_type="";
                                    $captions1 = "Upload Media";
                                    $captions2 = "Uploading...";
                                    
                                }

                                if($media_type=="pic"){
                                    $displays1 = "";
                                    $displays2 = "display:none";
                                }else{
                                    $displays1 = "display:none";
                                    $displays2 = "";
                                }

                            ?>
                                
                                <div class="first_upload_form" style="display:nones;">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Select Media Type</label>
                                        <select id="txtmedia" name="txtmedia">
                                            <option value="pic" <?php if($media_type=="pic" || $media_type=="") echo "selected"; ?>>Photos</option>
                                            <option value="vid" <?php if($media_type=="vid") echo "selected"; ?>>Videos</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Title</label>
                                        <input type="text" value="<?=$titles;?>" placeholder="Enter title of media" name="txttitle" id="txttitle" class="form-control" style="text-transform:capitalize;">
                                    </div>

                                    <div class="form-group for_photos" style="<?=$displays1;?>">
                                        <input id="former_file_ph" name="former_file_ph" value="<?php echo $files; ?>" class="form-control" style="display:none;" />
                                        <?php
                                        if($url_id!=""){
                                            echo "<font class='update_imgs1'>";
                                            if($files=='')
                                            echo "";
                                            else
                                            echo "<img src='".base_url()."gallery/$files' src1='".base_url()."images/celebs_awards.png' id='im10'>";
                                            echo "</font><br>";
                                        }
                                        ?>
                                        <label for="cc-number" class="control-label mb-1">Upload Photo</label>
                                        <input type="file" name="file_photo" id="file_photo" style="padding:4px; font-size:16px; display:nones" />
                                    </div>

                                    <div class="form-group for_vids" style="<?=$displays2;?>">
                                        <label for="cc-number" class="control-label mb-1">Write/Paste YouTube Code</label>
                                        <input type="text" value="<?=$files;?>" placeholder="Write/Paste YouTube Code" name="txtutube" id="txtutube" class="form-control">
                                    </div>

                                    <div style="clear:both"></div>
                                    <input type="hidden" name="actid" id="actid" value="<?php echo $id1; ?>" />


                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="submit" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_upload_media_" class="btn btn-lg btn-info btn-block inlines_">
                                            <input type="button" value="<?=$captions2;?>" id="cmd_upload_media_1" class="btn btn-lg btn-info btn-block" style="opacity:0.4; display:none;">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="err_div4"></div>
                                </div>


                                <div class="sec_upload_form" style="display:none; text-align:center;">
                                    <p><img src="<?php echo base_url() ?>images/checkmark.png"></p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>This Media has been updated successfully</b></p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>An Media has been uploaded successfully</b></p>
                                    <?php } ?>

                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Done" id="cmd_goto_first" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>

                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 

        </div>

        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>


<?php if($page_name == "enter_score"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <p style="font-size:16px;">Entering scores here means you have accessed their pictures, the daily instruction and their sentence constructions.<br>Each score is recorded as 100%</p>

                    <div class="div_enter_score">
                        <p>Enter Score</p>
                        <p class="score_info"></p>
                        <input type='hidden' id='txtids'>
                        <input type='hidden' id='judges'>
                        <input type='hidden' id='txtconts1'>

                        <input type='text' placeholder='Enter Score (100%)' id='txtscores'>
                        <input type='button' value='Save Score' id='cmd_save_score'>
                        <input type='button' value='Save Score' onclick='javascript:alert(\"Error! Cannot be changed.\")' id='cmd_save_score1' style='opacity:0.6; display:none;'>
                        
                        <div class="err_div"></div>

                        <p style="margin-top:1.4em; font-size:17px; color:#0CF !important; cursor:pointer;" class="close_score_dv">[CLOSE]</P>
                    </div>

                    <table id="enter_scores" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Contestants</th>
                            <th>Gender</th>
                            <th>Activity</th>
                            <th>Day</th>
                            <th class="none">Daily Activities:</th>
                            <th class="none">Brief Expression:</th>
                            <th class="none">Pictures</th>
                            <th class="none">Enter Score</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    
    </div>
    

<?php } ?>


<?php if($page_name == "compute_winner"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <p style="font-size:16px;">You only click this button when the activity has expired for the computer to compute the winners.</p>

                    <div class="compute_winers">
                        <?php
                        if($this->sql_models->get_pending_contestants()){ // true
                            echo "<input type='button' value='COMPUTE WINNERS' id='cmd_computes'>";
                        }else{
                            echo "<input type='button' value='COMPUTE WINNERS' id='cmd_computes1' style='opacity:0.4;' onclick='javascript:alert(\"Nothing to compute.\")'>";
                        }
                        ?>
                        <input type='button' value='COMPUTING...' id='cmd_computes1' style="opacity:0.4; display:none;">
                        <input type='button' value='COMPUTE WINNERS' id='cmd_computes2' style='opacity:0.4; display:none;' onclick='javascript:alert("Nothing to compute.")'>
                    </div>
                    <p class="show_info" style="display:none; margin:10px 0 15px 0; font-size:15px;">When the winners are being computed, it will not be visible
                        to them until you approve it. Meanwhile, its better to design the first, second and third winners' pictures to be
                        shared on social media immediately after approving it. 
                        <span class="approve_winners">Approve All</span>
                        <span class="approve_winners1">Approving...</span>
                    </p>

                    <?php
                    if(!$this->sql_models->get_pending_contestants()){ // true
                        echo '<p class="show_info" style="margin:10px 0 15px 0; font-size:15px;">When the winners are being computed, it will not be visible
                        to them until you approve it. Meanwhile, its better to design the first, second and third winners\' pictures to be
                        shared on social media immediately after approving it. <span class="approve_winners">Approve All</span>
                    </p>';
                    }

                    ?>

                    <table id="computescores" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Contestants</th>
                            <th>Approved</th>
                            <th>Activity</th>
                            <th>Total Votes</th>
                            <th>Picture Likes</th>
                            <th>Trivia Score</th>
                            <th>Judges Scores</th>
                            <th>Overall Score</th>
                            <th>Position</th>
                            <th>Dates</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    
    </div>
    

<?php } ?>


<?php if($page_name == "view_winner"){ ?>
    <div class="content mt-3" id="page-wrapper" style="">
        <div class="col-lg-12 container containerx house_tbl_">
            <div class="card hide_overflow_ _hide_overflow1" style="overflow:hiddens;">
                <div class="card-body all_tables">
                    <table id="viewwinners" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Contestants</th>
                            <th>Approved</th>
                            <th>Activity</th>
                            <th>Votes</th>
                            <th>Likes</th>
                            <th>Trivia Score</th>
                            <th>Judges Scores</th>
                            <th>Overall Score</th>
                            <th>Dates</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    
    </div>
<?php } ?>



<?php if($page_name == "creategames" || $page_name == "editgames"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">

        <div class="col-md-8" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <?php
                                if($url_id1 == "new"){
                                    echo '<h3 class="text-center"><b>Add Questions</b></h3>';
                                    echo '<p>This will add questions to the selected trivia game.</p>';
                                }else{
                                    if($url_id!="")
                                    echo '<h3 class="text-center"><b>Update This Activity</b></h3>';
                                    else
                                    echo '<h3 class="text-center"><b>Create Trivia Game For This Activity</b></h3>';
                                    echo '<p>Note that this game activity only expires when the time you selected has expired</p>';
                                }
                                    ?>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'create_game_form'));
                                if($url_id!=""){
                                    if(empty($getQuizes)){
                                        $getQuizes = $getQuizesID;
                                        $set_time1="";
                                        $sessionsx="";
                                    }else{
                                        $set_time1=$getQuizes['set_time'];
                                        $sessionsx=$getQuizes['sessions1'];
                                        
                                    }
                                    
                                    $id1 = $getQuizes['ids'];
                                    $questions=ucfirst($getQuizes['questions']);
                                    $files=$getQuizes['files'];
                                    $id3=$getQuizes['id3'];
                                    $op1=ucwords($getQuizes['op1']);
                                    $op2=ucwords($getQuizes['op2']);
                                    $op3=ucwords($getQuizes['op3']);
                                    $op4=ucwords($getQuizes['op4']);
                                    $op5=ucwords($getQuizes['op5']);
                                    $ans1=ucwords($getQuizes['ans1']);
                                    $captions1 = " Update This Game ";
                                    $captions2 = " Updating... ";
                                    $Submits1 = " Update This Game ";
                                    $Submits2 = " Updating... ";
                                    echo "<input type='hidden' value='$url_id' name='quiz_ids'>";
                            
                                }else{
                                    $questions="";
                                    $files="";
                                    $sessionsx="";
                                    $set_time1="";
                                    $op1="";
                                    $op2="";
                                    $op3="";
                                    $op4="";
                                    $op5="";
                                    $ans1="";
                                    $Submits1 = " Proceed &raquo; ";
                                    $Submits2 = " Submitting... ";
                                    $captions1 = "Proceed &raquo;";
                                    $captions2 = "Submitting...";
                                    $id1 = "";
                                    $id3 = "";
                                    echo "<input type='hidden' value='' name='quiz_ids'>";
                                }


                                if($url_id1 == "1838747" || $url_id1 == "new"){
                                    $none_dis = "display:nones";
                                    $none_dis1 = "display:none";

                                    //$sessionsx = $url_idx;
                                    //$id1 = $act_sess;

                                }else{
                                    $none_dis = "display:none";
                                    $none_dis1 = "display:nones";
                                    //$sessionsx="";
                                    //$id1="";
                                }
                            ?>
                                
                                <div class="first_create_game" style="displays:none; <?=$none_dis1;?>">

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Select Activity</label>
                                        <select name="txtsel_act" id="txtsel_act" class="form-control" style="color:#666;">
                                        <option value="" <?php if($getMainSess=="") echo "selected"; ?> >-Select Activity-</option>
                                            <?php
                                            $get_titls = $this->sql_models->get_Activities();
                                            if(!empty($get_titls)): foreach($get_titls as $post): 
                                                $session1 = $post['session1'];
                                                $overall_title = $post['overall_title'];
                                                $one_week_timings = $post['one_week_timings'];
                                                if($one_week_timings < time())
                                                $expires = " (Expired)";
                                                else
                                                $expires = "";
                                            ?>
                                                <option value="<?php echo $session1; ?>" <?php if($getMainSess==$session1 && $getMainSess!="") echo "selected"; ?>><?php echo ucwords($overall_title)."$expires"; ?></option>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">Please create an activity for this trivia game first</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Select Day Activity</label>

                                        <?php if($url_id == ""){ ?>
                                        <select name="txtsel_day" id="txtsel_day" class="form-control" style="color:#666;">
                                            <option value="">-Select One-</option>
                                        </select>
                                        <?php }else{ ?>

                                            <select name="txtsel_day" id="txtsel_day" class="form-control" style="color:#666;">
                                                <?php
                                                if($getMainSess!=""){
                                                    $getQuizTitles = $this->sql_models->getQuizTitles($getMainSess);
                                                    if(!empty($getQuizTitles)): foreach($getQuizTitles as $post): 
                                                        $id = $post['id'];
                                                        $titles = $post['titles'];
                                                        $has_done = $post['has_done'];
                                                        $for_days = $post['for_days'];
                                                        if($has_done == 1)
                                                        $expires = " (Has Been Done)";
                                                        else
                                                        $expires = "";
                                                    ?>
                                                        <option value="<?php echo $id; ?>" <?php if($has_done==0 || $has_done==1) echo "selected"; ?>><?php echo ucwords($titles)."$expires"; ?></option>
                                                    <?php 
                                                    endforeach; endif; 
                                                }
                                                ?>
                                            </select>

                                            <?php } ?>

                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="input-firstname">Timing <span style="color:#888; font-size:14px; font-weight:normal">(Note that the timing will all be in minutes)</span></label><br>			
                                        <input type="number" class="form-control" name="txtquiz_time" value="<?php echo $set_time1; ?>" id="txtquiz_time" placeholder="Duration of trivia game (Example 40 which means 40 minutes)" />
                                    </div>

                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="<?=$captions1;?>" actid="<?=$id1;?>" id="cmd_create_game" class="btn btn-lg btn-info btn-block">
                                            <input type="button" value="<?=$captions2;?>" id="cmd_create_game1" class="btn btn-lg btn-info btn-block" style="opacity:0.4; display:none;">
                                            <input type="button" value="Next &raquo;" id="cmd_next1_act" class="btn btn-lg btn-info btn-block inlines" style="display:none !important">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="err_div4"></div>
                                </div>


                                <div class="second_create_game" style="<?=$none_dis;?>">
                                    <?php
                                    if($url_id==""){
                                        if($url_id1==""){
                                    ?>
                                    <p style="color:#09C; font-size:16px; margin-bottom:20px; font-weight:bold; cursor:pointer;">
                                        <span class="use_prev_questn">Use previous questions instead? Click here</span>
                                    </p>
                                    <?php }} ?>

                                    <div class="prev_quest_div" style="display:none">
                                        <p style="color:#333; font-size:15px; margin-bottom:10px;"><b>You don't have to type questions again when you select any of these previous questions below</b></p>
                                        <?php
                                        $use_prev_ques = $this->sql_models->getPrevQuestions();
                                        if($use_prev_ques){
                                            $conts=1;
                                            foreach ($use_prev_ques as $rs) {
                                                $overall_title_1 = ucwords($rs['overall_title']);
                                                $dates_1 = $rs['dates'];
                                                $sessions1 = $rs['sessions1'];
                                                $mydates = date("jS F, Y", strtotime($dates_1));
                                                echo "<p><span class='use_this_questns' sess='$sessions1'>$conts. Use questions for \"$overall_title_1\" dated $mydates?</span></p>";
                                                $conts++;
                                            }
                                        }   

                                        ?>
                                    </div>


                                    <div class="write_quest_div">
                                        <div class="form-group">
                                            <input type="text" id="txtsessions" name="txtsessions" value="<?=$sessionsx;?>" />
                                            <input type="text" id="txtact_id" name="txtact_id" value="<?=$id1;?>" />
                                            <input type="text" id="txtquizid" name="txtquizid" value="<?=$id3;?>" />
                                            
                                            <label for="cc-payment" class="control-label mb-1">Question</label>
                                            <textarea name="txtquestions" id="txtquestions" placeholder="Write trivia question here" class="form-control" style="height:110px !important;"><?php echo $questions;?></textarea>
                                            <p style="font-size:15px; margin-top:14px;"><b>Upload Picture (Optional)</b></p>
                                            <p style="font-size:14px !important; margin-top:-5px; color:#993">Picture size <b style="font-size:14px;">2MB</b> of jpg, jpeg and png only!</p>

                                            <?php
                                            if($url_id!=""){
                                                echo "<font class='update_imgs'>";
                                                if($files=='')
                                                echo "<img src='".base_url()."images/no_passport.jpg' src1='".base_url()."images/no_passport.jpg' id='im10'>";
                                                else
                                                echo "<img src='".base_url()."quizes/$files' src1='".base_url()."images/no_passport.jpg' id='im10'>";
                                                echo "</font>";
                                            }
                                            ?>

                                                <input id="former_file" name="former_file" value="<?php echo $files; ?>" class="form-control" style="display:none;" />
                                                <input type="file" name="file_quiz" id="file_quiz" style="padding:4px; font-size:15px; display:nones" />
                                        </div>

                                        <div class="form-group col-md-6 colmd6">
                                            <label for="cc-name" class="control-label mb-1">Option A</label>
                                            <input type="text" name="txtop1" id="txtop1" value="<?php echo $op1; ?>" placeholder="Write Option A" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 colmd6">
                                            <label for="cc-name" class="control-label mb-1">Option B</label>
                                            <input type="text" name="txtop2" id="txtop2" value="<?php echo $op2; ?>" placeholder="Write Option B" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 colmd6">
                                            <label for="cc-name" class="control-label mb-1">Option C</label>
                                            <input type="text" name="txtop3" id="txtop3" value="<?php echo $op3; ?>" placeholder="Write Option C" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 colmd6">
                                            <label for="cc-name" class="control-label mb-1">Option D</label>
                                            <input type="text" name="txtop4" id="txtop4" value="<?php echo $op4; ?>" placeholder="Write Option D" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 colmd6">
                                            <label for="cc-name" class="control-label mb-1">Option E</label>
                                            <input type="text" name="txtop5" id="txtop5" value="<?php echo $op5; ?>" placeholder="Write Option E" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6 colmd6">
                                            <label for="cc-number" class="control-label mb-1">Specify the answer</label><br>
                                            <select name="txtans" id="txtans">
                                                <option value="" selected>-Select-</option>
                                                <option value="A" <?php if($ans1==$op1 && $op1!="") echo "selected"; ?> >A</option>
                                                <option value="B" <?php if($ans1==$op2 && $op2!="") echo "selected"; ?>>B</option>
                                                <option value="C" <?php if($ans1==$op3 && $op3!="") echo "selected"; ?>>C</option>
                                                <option value="D" <?php if($ans1==$op4 && $op4!="") echo "selected"; ?>>D</option>
                                                <option value="E" <?php if($ans1==$op5 && $op5!="") echo "selected"; ?>>E</option>
                                            </select>
                                        </div>

                                        <div style="clear:both"></div>
                                        <div id="Errormsg7"></div>

                                        <div class="col-md-offset-3 col-md-6">
                                            <div style="text-align:center; margin-top:1em;" id="buttons1">
                                                <input type="submit" value="<?=$Submits1;?>" actid="<?=$id1;?>" id="cmd_submit_quiz" class="btn btn-lg btn-info btn-block">
                                                <input type="button" value="<?=$Submits2;?>" id="cmd_submit_quiz1" class="btn btn-lg btn-info btn-block" style="opacity:0.4; display:none;">

                                                <?php
                                                    if($url_id1=="")
                                                    echo '<input type="button" value="&laquo; Back" id="cmd_prev_act" class="btn btn-lg btn-info btn-block inlines">';
                                                ?>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>



                                <div class="third_create_form" style="display:none; text-align:center;">
                                    <p><img src="<?php echo base_url() ?>images/checkmark.png"></p>
                                    <?php if($url_id!=""){ ?>
                                        <p style="font-size:20px; color:#093;"><b>This Activity has been updated successfully</b></p>
                                        <p style="font-size:16px; color:#093;">It will be updated as well. If you have selected <b>Trivia Games</b> please input the 
                                            trivia games first before you approve this activity.
                                        </p>
                                    <?php }else{ ?>
                                        <p style="font-size:20px; color:#093;"><b>An Activity has been created successfully</b></p>
                                        <p style="font-size:16px; color:#093;">It will be active and be seen on the platform when you go to 
                                            view activities and approve it.<br>If you have selected <b>Trivia Games</b> please input the 
                                            trivia games first before you approve this activity.
                                        </p>
                                    <?php } ?>

                                    <div class="col-md-offset-3 col-md-6">
                                        <div style="text-align:center; margin-top:1em;" id="buttons1">
                                            <input type="button" value="Done" id="cmd_goto_viewacts" class="btn btn-lg btn-info btn-block">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>

                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 

        </div>

        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>



<?php if($page_name == "settings"){ ?>
    <div class="content mt-3 container" id="page-wrapper" style="">
    

        <div class="col-md-5" style="border:1px #ccc solid;">
            <div class="card">
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">Update your password</h3>
                            </div>
                            <hr>
                            <?php
                                echo form_open('', array('autocomplete'=>'off', 'id'=>'edit_pass'));
                            ?>
                                
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                    <input id="cc-pament" name="txtpass1" type="password" class="form-control" placeholder="Enter your old password">
                                </div>
                                <div class="form-group">
                                    <label for="cc-name" class="control-label mb-1">New Password</label>
                                    <input id="cc-name" name="txtpass2" type="password" class="form-control cc-name" placeholder="Enter your new password">
                                </div>
                                <div class="form-group">
                                    <label for="cc-number" class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-number" name="txtpass3" type="password" class="form-control cc-number" placeholder="Confirm your new password">
                                </div>
                                <div>
                                    <div style="text-align:center; margin-top:2em;" id="buttons1">
                                        <input type="button" value="Update Password" id="cmd_update_pass_admin" class="btn btn-lg btn-info btn-block">
                                        <input type="button" value="Updating..." id="cmd_update_pass_admin1" class="btn btn-lg btn-info btn-block" style="background:#666 !important; opacity:0.8; display:none;">
                                    </div>
                                </div>
                                <div class="err_div4"></div>
                                <br><br>
                            <?php echo form_close(); ?>

                        </div>
                    </div>

                </div>
            </div> 

        </div>


        <div style="clear:both;"></div>
        <br><br><br><br>
    </div>
    

<?php } ?>

    </div><!-- /#right-panel -->
    <input type="hidden" id="txturl1" name="txturl1" value="<?=$url_id;?>" />

    

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <!-- <script src="<?php echo base_url(); ?>assets/plugins/morris/raphael-2.1.0.min.js"></script> -->
    
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fnReloadAjax.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/responsive.bootstrap.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url(); ?>assets/js/vendor/jquery-2.1.4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>


    <script>
        var site_urls = $('#txtsite_url').val();
        var txt_pagename = $('#txt_pagename').val();
        var txt_pagename1 = $('#txt_pagename1').val();
        var txtqry = $('#txtqry').val();
        var txturl1 = $('#txturl1').val();
        // alert(txt_pagename);
        // alert(txt_pagename1);
        // alert(txturl1);

        if(txt_pagename == "view_activities"){
            if(txtqry=="")
                var urls = site_urls+"shield/fetch_activities";
            else
                var urls = site_urls+"shield/fetch_products/"+txtqry+"/";

        }else if(txt_pagename == "contestants")
            var urls = site_urls+"shield/fetch_contestants";

        else if(txt_pagename == "enter_score")
            var urls = site_urls+"shield/fetch_scores";

        else if(txt_pagename == "compute_winner")
            var urls = site_urls+"shield/fetch_computatn/";

        else if(txt_pagename == "view_winner")
            var urls = site_urls+"shield/fetch_computatn/all/";

        else if(txt_pagename == "voters")
            var urls = site_urls+"shield/fetch_voters";

        else if(txt_pagename == "campaigns")
            var urls = site_urls+"shield/fetch_campaigns";

        else if(txt_pagename == "viewgames")
            var urls = site_urls+"shield/fetch_games";

        else if(txt_pagename == "viewmedia")
            var urls = site_urls+"shield/fetch_all_media";

        else if(txt_pagename == "viewevents")
            var urls = site_urls+"shield/fetch_all_events";

        else if(txt_pagename == "paidusers")
            var urls = site_urls+"shield/fetch_all_paids";

        else if(txt_pagename == "forum")
            var urls = site_urls+"shield/fetch_all_forum";

        else if(txt_pagename == "forumreply")
            var urls = site_urls+"shield/fetch_all_forum_rep";

        else if(txt_pagename == "viewtrivia")
            var urls = site_urls+"shield/fetch_trivia/"+txturl1+"/";
        
        //else if(txt_pagename == "view_riders")
            //var urls = site_urls+"shield/fetch_riders2";

        else if(txt_pagename == "customers1")
            var urls = site_urls+"shield/fetch_yourcus";

        else if(txt_pagename == "wallets")
            var urls = site_urls+"shield/fetch_wallets";

            //alert(txt_pagename);

        var dataTable = $('#myactivities, #mytrivia, #all_events, #all_paids, #forum1, #forum_rep1, #all_voters, #yourcus_mer, #yourcus2, #contestants, #enter_scores, #viewwinners, #computescores, #all_medias, #all_games, #tbl_riders, #all_errands, #all_pickups, #all_wallets').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "order":[],
            "ajax":{
                url : urls,
                type: "post"
            },
            "columnDefs":[
            {
                "target":[0,3,4],
                "orderable": false
            }
            ]
        });


        var urls = site_urls+"shield/fetch_riders";
        var dataTable1 = $('#all_riders').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "order":[],
            "ajax":{
                url : urls,
                type: "post"
            },
            "columnDefs":[
            {
                "target":[0,3,4],
                "orderable": false
            }
            ]
        });
    </script>


</body>

</html>
