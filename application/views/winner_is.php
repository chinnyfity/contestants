

<?php 
    $overall_title = $winneris[0]['overall_title'];
    $dates = $winneris[0]['date1'];
    $mydates1 = date("jS F, Y h:i a", strtotime($dates));
    if(strlen($overall_title)<=20) $addfont = "incr_font"; else $addfont = "incr_font1";
?>

    <script src="<?php echo base_url(); ?>js/jscripts1.js"></script>
    
    <section id="reach-to" class="dishes1 completed_profile welcome-part home-icon ash_color2" style="border-top:2px solid #eee; background:#111;">
        <div class="icon-default icon-default3_111">
            <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
        </div>
        
        <div class="container contents1 winneris_div" id="gotohere">
            <div class="row reg_form2">

                <div class="activity_title activity_title2 <?=$addfont;?>">
                    <img src="<?php echo base_url(); ?>images/contestants.png" style="width:30px"> &nbsp;
                    <?php if($overall_title=="") $overall_title = "No Activity Yet"; ?>
                    <b><?=ucwords($overall_title);?></b> &nbsp;
                    <p style="font-size:15px; margin:0 0 4px 0; color:#ccc">Dated: <?=$mydates1;?></p>
                </div>

                <?php
                if($winneris){
                    //$i=3;
                    foreach ($winneris as $rs) {
                        $id = $rs['id'];
                        $sw_id = $rs['sw_id'];
                        $memid = $rs['memid'];
                        $statee = $rs['statee'];
                        $pics = $rs['pics'];
                        $dates = $rs['dates'];
                        $votes = $rs['votes'];
                        $likes = $rs['likes'];
                        $positns = $rs['positns'];
                        $g_score = $rs['g_score'];
                        $j_score = $rs['j_score'];
                        $over_all = $rs['over_all'];
                        $mydates = date("F, Y", strtotime($dates));
                        $names = ucwords($this->sql_models->contestantName($memid));
                        $names1 = explode(' ', $names);
                        $fname1 = $names1[0];
                        $lname1 = $names1[1];
                        $posns="";
                        if($positns==3) $posns = "3rd";
                        if($positns==2) $posns = "2nd";
                        if($positns==1) $posns = "1st";
                        //$file1 = base_url()."watermark.php?image=".base_url()."celebs_uploads/$pics&watermark=".base_url()."images/watermrk.png";
                        $file1 = base_url()."celebs_uploads/$pics";

                        if($statee!="FCT Abuja")
                        $statee = "$statee State";
                        ?>

                            <div class="col-md-4 col-sm-6 col-xs-12 winneris">
                                <div class="winner_posn"><?=$posns;?> <span>Winner</span></div>
                                <div class="frame_winners">
                                    <img src="<?=$file1;?>">
                                    <div class="mynames"><?=$names;?></div>
                                </div>

                                <div class="mystates">
                                    Current Location: <font><?=$statee;?></font>
                                    <p><span class="view_p view_profiles" activityid="<?=$sw_id;?>" memid="<?=$memid;?>" fulnames="<?=$names;?>" fname="<?=$fname1;?>" lname="<?=$lname1;?>">View Profile</span></p>
                                </div>
                                <div class="statistics">
                                    <table>
                                        <tr>
                                            <td>Total Votes:</td>
                                            <td><span><?=$votes;?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Total Likes:</td>
                                            <td><span><?=$likes;?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Game Score:</td>
                                            <td><span><?=$g_score;?>/100</span></td>
                                        </tr>
                                        <tr>
                                            <td>Judges Score:</td>
                                            <td><span><?=$j_score;?>/100</span></td>
                                        </tr>
                                        <tr>
                                            <td>Overall Score:</td>
                                            <td><span><?=$over_all;?></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    <?php
                    //$i--;
                    }
                }else{
                    echo "<div style='text-align:center; font-size:20px; color:#ccc; margin:-1em 0 3em 0;'>No winners computed yet!</div>";
                }
                ?>

            </div>
            <div style="clear:both"></div>

            <?php if($winneris){ ?>
                <div class="other_contestants">
                    <p style="font-size:18px; margin:2em 0 8px 0; text-align:center">Other Contestants and their votes</p>

                    <table>
                        <tr>
                            <th>Contestants</th>
                            <th>State</th>
                            <th>Statistics</th>
                        </tr>

                        <?php
                        if($winneris_limit){
                            foreach ($winneris_limit as $rs) {
                                $memid = $rs['memid'];
                                $statee1 = $rs['statee'];
                                $votes = $rs['votes'];
                                $likes = $rs['likes'];
                                $g_score = $rs['g_score'];
                                $j_score = $rs['j_score'];
                                $over_all = $rs['over_all'];
                                $names = $this->sql_models->contestantName($memid);
                                if($statee1!="FCT Abuja")
                                $statee1 = "$statee1 State";

                                echo "<tr>
                                    <td>$names</td>
                                    <td>$statee1</td>
                                    <td>
                                        <p>Total Votes: <span>$votes</span></p>
                                        <p>Total Likes: <span>$likes</span></p>
                                        <p>Game Score: <span>$g_score/100</span></p>
                                        <p>Judges Score: <span>$j_score/100</span></p>
                                        <p>Overall Score: <span>$over_all%</span></p>
                                    </td>
                                </tr>";
                            }
                        }else{
                            echo "
                            <tr>
                                <th>No other winners</th>
                                <th>#######</th>
                                <th>#######</th>
                            </tr>";
                        }
                        ?>

                    </table>

                </div>
            <?php } ?>
        
        </div>

        <br>
    </section>
            