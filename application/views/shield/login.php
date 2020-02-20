<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login Your Details | OurFavCelebs</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <link href="<?php echo base_url(); ?>img/favicon.ico"  type="image/ico" rel="icon" />
  <link href="<?php echo base_url(); ?>lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/style_adm.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/style_adm1.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/popup_div.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
  <script src="<?php echo base_url(); ?>js/jscripts.js"></script>


</head>

<body>
<input type="hidden" value="<?php echo base_url(); ?>" id="txtsite_url">

  <header id="header1" style="transition:none !important; height:45px !important;">
    <div class="container">

      <div id="logo" class="pull-left_" style="text-align:center">
        <h1><a href="<?php echo base_url(); ?>" class="scrollto"><img src="<?php echo base_url(); ?>images/logo1.png" style="width:80px !important; margin-top:-7px;"></a></h1>
      </div>

      <nav id="nav-menu-container" style="margin-top:-8px;">
        <ul class="nav-menu">
          <li class="menu-active"><a href="<?php echo base_url(); ?>" style="font-size:18px;"><b>Home</b></a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->


  <br><br><br>
  <main id="main">


    <section id="business_">
      <div class="container">

		<div class="xcover">
			<div class="row">
			
				<div class="col-md-3">
					
				</div>

				<div class="col-md-6 col-sm-12_">
					<div class="board boards" style="border:1px solid #999; background:#ddd;">
            <h3 style="margin-top:0px; text-align:center;">Admin account</h3>
						<hr style="margin:-5px 0 25px 0; color:#666 !important;">
						<p style="text-align:center; margin-top:-10px; color:#333; font-size:15px;">Enter your login details and continue</p>
						
            <div id="lnk_register_" class="well_">
              <div class="container form">
                <form action="" method="post" id="form_logins" autocomplete="off">

                  <div class="form-group_">
                    <input type="text" name="txtuname" placeholder="Username *" required="" class="form-control" style="border:1px solid #999 !important; text-transform:lowercase">
                  </div>
                  <br>

                  <div class="form-group">
                    <input type="password" name="txtpass" placeholder="Password *" required="" class="form-control" style="border:1px solid #999 !important; text-transform:lowercase">
                  </div>

                  <div class="form-group">
                    <div class="text-center"><button type="button"  class="strs strs1 cmd_signin_adms">Sign In</button></div>
                    <div class="text-center"><button type="button" style="opacity:0.5; display:none;" class="strs cmd_signin_adms1">Signing In...</button></div>
                    <div class="err_login" style="margin-top:-10px;"></div>
                  </div>
                  <br>
                </form>
              </div>
            </div>

					</div>
				</div>

				<div class="col-md-3">
					
				</div>
			</div>
		</div>
		

      </div>

    </section><!-- #features -->
   

  </main>

  <br>
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 text-lg-left text-center">
          <div class="copyright">
            &copy; Copyright © 2019 <strong>OurFavCelebs</strong>. All Rights Reserved
          </div>
          <div class="credits" style="color:#999;">
            Designed by <a style="color:#ccc;" href="mailto:donchibobo@gmail.com">CAnthony</a>
          </div>
        </div>
      </div>
    </div>
  </footer><!-- #footer -->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

</body>
</html>


