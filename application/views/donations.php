
        
        
        <section id="reach-to" class="dishes1 welcome-part home-icon ash_color" style="background:#fff;">
            <div class="icon-default icon-default2">
                <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
            </div>
            
            <div class="container contents1" id="gotohere">
                <div class="title text-center">
                    <h2 class="text-coffee" style="text-align:center; color:#222; margin-bottom:10px;">Donate To</h2>
                    <h5 class="text-coffee" style="color:#848400;">OurFavCelebs</h5>
                </div>

                

                <div class="row contactus_div contactus_div1">

                    <div class="col-md-5 col-sm-5 col-xs-12 comp_contacts_ div_donatn">
                        <img src="<?php echo base_url()?>images/children.jpg">
                    </div>

                    <div class="col-md-7 col-sm-7 col-xs-12 comp_contacts1 p-sm-15 pt-sm-20">
                        <p style="color:#333; margin-top:0px; font-size:15px; line-height:22px;" class="writeup">
                            The purpose of donation is to enable us to fight against hunger, unemployment and insecurity in our society
                            and to provide the less privileged with school books, bags, uniforms, food and water, help their education, etc...</p>

                            <p style="color:#333; margin-top:-17px; font-size:15px; line-height:22px;" class="writeup">
                            We need your help to reach more children and families who are in desperate need.<br>
                            Together we can help the country.
                        </p>

                        <form class="form reg_form donate_form" method="post" autocomplete="off" name="contact-form">
                            <div class="row pr-sm-20 pl-sm-20">
                                
                                <div class="div_donate1" style="display:nones;">
                                    <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12" style="margin-bottom:-10px;">
                                        <select id="txtamts" name="txtamts" style="text-align:center !important;">
                                            <option value="">-Select Your Donation-</option>
                                            <option value="1000">N1,000</option>
                                            <option value="2000">N2,000</option>
                                            <option value="5000">N5,000</option>
                                            <option value="10000">N10,000</option>
                                            <option value="15000">N15,000</option>
                                            <option value="20000">N20,000</option>
                                            <option value="50000">N50,000</option>
                                            <option value="100000">N100,000</option>
                                        </select>
                                    </div>
                                    <div style="clear:both !important;"></div>
                                    <div class="alert_error"></div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-10" style="clear:both">
                                        <input name="button" value="HELP DONATE" class="btn-black center-block cmd_donate" type="button">
                                    </div>
                                </div>


                                <div class="div_donate2" style="display:none;">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pb-10">
                                        <p style="font-size:16px; color:#333;"><b>Your Donation:</b> <b style="font-size:23px; color:#06F;">NGN<font class="history_amt">0.00</font><b style="font-size:15px;">.00</b></b></p>
                                    </div>
                                    <div style="clear:both; margin-top:1em;"></div>

                                    <div class="col-md-6 col-sm-6 col-xs-12" style="">
                                        <input name="txtd_fname" type="text" placeholder="Full Names*" style="text-transform:capitalize;" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="txtd_phone" type="number" placeholder="Your Phone Number*" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="txtd_email" type="email" placeholder="Your Email Address*" style="text-transform:lowercase;" class="txt3" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="txtd_state" class="txt3" id="txtstate">
                                            <option value="" selected>* -Select State-</option>
                                            <option value="Ghana">Ghana</option>
                                            <?php
                                                foreach($countries as $post):
                                                $con_name = $post['names'];
                                                echo "<option value='$con_name'>$con_name</option>";
                                                ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div style="clear:both; margin-top:1em;"></div>
                                    <div class="alert_error"></div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 pt-20">
                                        <input name="button" value="HELP DONATE" class="btn-black center-block cmd_donate_s" type="button">
                                        <input name="button" value="HELP DONATE..." class="btn-black btn-blacks center-block cmd_donate_s1" type="button" style="display:none; opacity:0.7; color:#777;">
                                    </div>
                                </div>


                                <div class="div_donate3" style="display:none;">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <p style="font-size:16px; color:#333;"><b>Your Donation:</b> <b style="font-size:23px; color:#06F;">NGN<font class="history_amt">0.00</font><b style="font-size:15px;">.00</b></b></p>
                                    </div><br><br>

                                    <p class="manual_tran payment_div">Manual Transfer &raquo;<p>
                                    <div class="manual_div" style="display:none; padding-bottom:1.2em !important;">
                                        <table class="table tbl_format1">
                                            <tr>
                                                <td class="noborder">Bank Name:</td>
                                                <td class="noborder">Name of bank</td>
                                            </tr>
                                            <tr>
                                                <td>Account Name:</td>
                                                <td>OurFavCelebs LTD</td>
                                            </tr>
                                            <tr>
                                                <td>Account No:</td>
                                                <td style="letter-spacing:0.9px">1234567890</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p style="line-height:19px !important; margin-bottom:12px !important;">Please click on the submit button to complete your donation</p>
                                                    <input name="button" value="SUBMIT DONATION" class="btn-black center-block cmd_pay_manual" type="button" style="padding:10px 2em !important; font-size:15px;">
                                                    <input name="button" value="SUBMITTING..." class="btn-black btn-blacks center-block cmd_pay_manual1" type="button" style="padding:10px 2em !important; font-size:15px; display:none; opacity:0.7; color:#777;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                        
                                    <p class="online_pay payment_div">Use Debit Card &raquo;<p>
                                    <div class="online_div" style="display:none; padding-bottom:1.4em !important;">
                                        <p>Please click to pay online</p>
                                        <input name="button" value="PAY ONLINE" class="btn-black center-block cmd_pay_online" type="button" style="padding:10px 2em !important; font-size:15px;">
                                        <input name="button" value="PAYING..." class="btn-black btn-blacks center-block cmd_pay_online1" type="button" style="padding:10px 2em !important; font-size:15px; display:none; opacity:0.7; color:#777;">
                                    </div>
                                </div>


                                <div class="div_donate4" style="display:none; text-align:center;">
                                    <p style="margin:15px 0 10px 0;"><img src="<?php echo base_url(); ?>images/checkmark.png"></p>
                                    <p style="font-size:25px; color:#093;"><b>Submitted Successfully</b></p>
                                    <p style="margin:-5px 0 0 0; color:#333; line-height:21px; padding:0 9px;">Thank you for your kindness, we really appreciate your donation. We will place a call on you between now and 30 minutes time.</p>
                                    <p style="border-bottom:1px #555 dotted; margin:20px 0 20px 0;"></p>

                                    <div class="col-md-12 col-sm-12 col-xs-12 btns_2" style="margin-top:5px !important;">
                                        <input value="DONE" class="btn-black center-block close_pay_div" type="button">
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            
            </div>

            

            <br>
        </section>
        
        
    </div>
</main>
