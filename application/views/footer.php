
<?php $pages_check = array('','viewprofile', 'events', 'viewevents', 'winners', 'not_sub', 'donation', 'adverts', 'judges', 'gallery', 'privacy_terms'); ?>


<?php if($page_name != "not_sub"){ ?>
    <footer class="for_desktop_ for_desktop2">
        <div class="footer-part mt-sm-50">
            <div class="icon-default icon-default1 icon-dark">
                <img src="<?=base_url();?>images/logo1.png" alt="">
            </div>
            <div class="container">
                <div class="footer-inner">
                    <div class="footer-info">
                        <h3>OurFavCelebs Pageant</h3>
                        <p><a href="tel:+2349038455799">(+234) 0903 845 5799</a></p>
                        <p><a href="mailto:info@ourfavcelebs.com">info@OurFavCelebs.com</a></p>
                    </div>
                </div>
                <div class="copy-right">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 copyright-before">
                            <span>Copyright © 2020 <a href="mailto:donchibobo@gmail.com">CATech</a>. All rights reserved</span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 copyright-after">
                            <div class="social-round">
                                <p style="margin:0 0 5px 0">Follow us on:</p>
                                <ul>
                                    <li class="soc1"><a href="https://www.facebook.com/OurfavCelebs-Pageants-2163269583793459/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li class="soc2"><a href="https://www.instagram.com/our_fav_celebs/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                    <li class="soc3"><a href="javascript:;" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="icon-find">
                <!-- <a href="javascript:;" class="terms">Terms and Condition</a> |  -->
                <?php if(in_array($page_name, $pages_check)){ ?>
                    <a href="<?=base_url();?>pages/#policy">Privacy and Policy</a>
                <?php }else{ ?>
                    <a href="javascript:;" class="policy">Privacy and Policy</a>
                <?php } ?>
            </div>
            
            <!-- <div class="location-footer-map">
                <div class="footer-map-outer">
                    <div id="footer-map"></div>
                </div>
            </div> -->
        </div>
    </footer>
<?php } ?>
    

    
</div>


<a href="#" class="top-arrow"></a>

</body>
</html>

<script src="<?=base_url();?>js/jquery.min.js"></script>

<?php if($page_name==""){ ?>
    <script src="<?=base_url();?>plugin/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url();?>plugin/bootstrap/bootstrap-datepicker.js"></script>
    <script src="<?=base_url();?>plugin/form-field/jquery.formstyler.min.js"></script>
    <script src="<?=base_url();?>plugin/revolution-plugin/jquery.themepunch.plugins.min.js"></script>
    <script src="<?=base_url();?>plugin/revolution-plugin/jquery.themepunch.revolution.min.js"></script>
    <script src="<?=base_url();?>plugin/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?=base_url();?>plugin/slick-slider/slick.min.js"></script>
    <script src="<?=base_url();?>plugin/isotop/isotop.js"></script>
    <script src="<?=base_url();?>plugin/isotop/packery-mode.pkgd.min.js"></script>
    <script src="<?=base_url();?>plugin/magnific/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url();?>plugin/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?=base_url();?>plugin/animation/wow.min.js"></script>
    <script src="<?=base_url();?>plugin/parallax/jquery.stellar.js"></script>
    

<?php }else{ ?>
    <script src="<?=base_url();?>plugin/revolution-plugin/jquery.themepunch.revolution.min.js"></script> <!--for the loading of the banners-->
    <script src="<?=base_url();?>plugin/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script> <!--this is loader for mobile ver-->

<?php } ?>

<script src="<?=base_url();?>js/app.js"></script>
<script src="<?=base_url();?>js/script.js"></script>

<script type='text/javascript' src='<?=base_url();?>js/jquery-1.7.1.min.js'></script>
<script src="<?=base_url();?>js/jscripts.js"></script>



<script>
var mylogin = retrieve_cookie('mylogins1');
if(mylogin == "down_to_login"){
setTimeout(function(){
  if($(window).width()<760)
    $("html, body").animate({scrollTop:$('#enter_reg').offset().top-40},1500);
  else
    $("html, body").animate({scrollTop:$('#enter_reg').offset().top-165},1500);
},2000);

$.ajax({
    type : "POST",
    url : site_urls+"node/login_scrolldown1", // delete it
    cache : false,
    success : function(data){
    }
});
}

</script>