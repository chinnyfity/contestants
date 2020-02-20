


        
        <?php
        if($page_name=="compatibility"){
        ?>

        <!DOCTYPE html>
        <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="theme-color" content="#510051">
                <title class="page_titl">Compatibility Issues | OurFavCelebs</title>

                <link href="../image/icon.ico" type="image/ico" rel="icon" />
                <link href="<?php echo base_url(); ?>plugin/font-awesome/font-awesome.css" rel="stylesheet">
                <link href="<?php echo base_url(); ?>css/theme.css" rel="stylesheet">

                <style>
                    .broswer1{width:30%; margin:0 auto; backgrounds:blue;}
                    .broswer1 img{width:130px !important;}
                    .broswer1 p{display:inline-block; width:40%;}
                    .header0{background:#505; text-align:center; padding-top:3px; margin-bottom:14px;}
                    .header0 img{width:100px !important;}
                    .other_contents{padding:5px 1em;}
                    .broswer1 span{display:block;}


                    @media(max-width: 767px) {
                        .broswer1{width:100%;}
                        .broswer1 img{width:110px !important;}
                        .header0 img{width:80px !important;}
                    }

                </style>
            </head>

            <body class="hide-overlay">
                <div class="containerxx" id="gotohere">
                    <div class="header0"><img src="<?=base_url()?>images/logo1.png"></div>
                    <p style="text-align:center; font-size:1.7em; color:#333; line-height:28px !important;"><b>Your browser is not supported.</b></p>

                    <div class="other_contents">
                        <p style="text-align:center; margin-top:-10px; color:#555; font-weight:normal; font-size:16px; line-height:22px;">
                            Unfortunately this browser does not support the web technology that powers the extended features of OurFavCelebs.com.<br>
                            You'll need to try another browser. We recommend Chrome Browser or Mozilla Firefox.
                        </p>
                        
                        <div style="text-align:center; margin-top:1.4em;" class="broswer1">
                            <p><img src="<?=base_url()?>images/chromes.jpg"><span>Google Chrome</span></p>
                            <p><img src="<?=base_url()?>images/firefoxs.jpg"><span>Mozilla Firefox</span></p>
                        </div>
                    </div>
                </div>
                <br>
            </body>
        </html>


        <?php }else{ ?>

            <section id="reach-to" class="dishes1 welcome-part home-icon ash_color2">
                <div class="icon-default icon-default3">
                    <a hrefs="#reach-to" href="javascript:;" class="scroll"><img src="<?php echo base_url(); ?>images/scroll-arrow.png" alt=""></a>
                </div>
                
                <div class="container" id="gotohere">

                    <p style="text-align:center;" class="error_page">Error Page</p>

                    <p style="text-align:center; margin-top:1em; font-weight:normal; font-size:15px; line-height:23px;">You have not been subscribed to participate in the contestant competition, please click on the button below to go
                    back to home page or make payments for the participant page to be enabled, thank you!</p>
                    
                    <div style="text-align:center; margin-top:3em;" class="parti_btn">
                        <span onclick="javascript:window.location='../'">Go Back</span>
                    </div>            
                </div>
                <br><br><br><br><br>

            </section>

        <?php } ?>

        
    </div>
</main>

      