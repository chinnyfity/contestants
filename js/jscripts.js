
var page_names = $('#page_names').val();
site_urls = $('#txtsite_url').val();
var head_titles = " | OurFavCelebs Pageant";
var fullnames; var firstnames; var lastnames;


$(document).ready(function(){

  // if page refresh, pprevent it from scrolling to the div id
  create_cookie('txt_srch', '');
  create_cookie('pageNum', 0);
  create_cookie('scrolls', '');
  create_cookie('cats_f', '');
  create_cookie('ids', '');
  //////////////

  $(window).on('scroll',function(){
    

  });

  create_cookie('page_refreshed', 1);
  
  setTimeout(function(){
    $('.dz-message').html('Drop images/videos here to upload');
  },800);
  

  
  $('.hide-overlay').on('contextmenu', function(e) { // class under body, use this
    // if (e.target.tagName.toUpperCase() !== "INPUT" && e.target.tagName.toUpperCase() !== "TEXTAREA") {
    //     e.preventDefault();
    //     return false;
    // }
  });


  $('body').on('contextmenu', '.forumBox3', function(e) {
    e.stopPropagation();
    var ids = $(this).attr('ids');
    $('.copy_text').hide();
    $('#copy_text'+ids).fadeIn('fast');
    $('#cover_contents'+ids).fadeIn('fast');
    return false;
  });


  $('body').on('contextmenu', '.forumBox5', function(e) { // events
    e.stopPropagation();
    var ids = $(this).attr('ids');
    $('.copy_text').hide();
    $('#copy_text'+ids).fadeIn('fast');
    $('#cover_contents1'+ids).fadeIn('fast');
    return false;
  });

  
  $('#tags').on('click', 'span', function() {
    if(confirm("Remove email "+ $(this).text() +"?")) $(this).remove();
  });


  $('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})



  $(".uploadimage2").on('submit',(function(e) {
    e.preventDefault();
    $(".err_div4").hide();
    $('.cmddones_basic').hide();
    $('.cmddones_basic1').show();

    $.ajax({
      type : "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      url : site_urls+"node/reset_session1",
      success : function(data){
        if($.isNumeric(data)){
          setTimeout(function(){
            $('.second_create_form').hide();
            $('.third_create_form').show();
            $(".uploadimage2")[0].reset();
            $("#create_evts")[0].reset();
            Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
          },200);
          $('.cmddones_basic').show();
          $('.cmddones_basic1').hide();
        }else{
          $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
          $('.cmddones_basic').show();
          $('.cmddones_basic1').hide();
        }
      },error : function(data){
        $('.cmddones_basic').show();
        $('.cmddones_basic1').hide();
        alert('Connection Error!');
      }
    });

  }));




  $(".uploadimage2_members_home").on('submit',(function(e) {
    e.preventDefault();
    var txtmember = $('#txtmember').val();
    
    $(".err_div1").hide();
    $('.submit_form1_1').hide();
    $('.submit_form1_2').show();

    $.ajax({
        type : "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        url : site_urls+"node/reg_members_2",
        success : function(data){
            var data1, data2;
            data2 = data.substring(0, 6);

            if(data2 == 'done_2' || data == "done_2"){
              $('.submit_form1_1').show();
              $('.submit_form1_2').hide();
              $('.java_show').show();

              $('.secs_form').hide();
              $('.participate').fadeIn('fast');
              $('.notpaid1').hide();
              $('.java_nopaid1').show();

            }else{
              $(".err_div1").show().html('<div class="Errormsg Errormsgi">'+data+'</div>');
              $('.submit_form1_1').show();
              $('.submit_form1_2').hide();
              setTimeout(function(){
                  $(".err_div1").fadeOut('fast');
              },5000);
            }
        },error : function(data){
          //alert(data)
          $('.submit_form1_1').show();
          $('.submit_form1_2').hide();
          $(".err_div1").show().html('<div class="Errormsg Errormsgi">Poor Network Connection!</div>');
          setTimeout(function(){
              $(".err_div1").fadeOut('fast');
          },5000);
        }
    });
    
  }));




  $("#create_game_form").on('submit',(function(e) {
    e.preventDefault();
    $("#Errormsg7").hide();

    if($("#txtact_id").val() == '' ){
    $("#Errormsg7").fadeIn('fast').html('<div class="Errormsg">Error! Session is empty, please go back and start again</div>');

    }else if($("#txtquestions").val() == '' ){
    $("#Errormsg7").fadeIn('fast').html('<div class="Errormsg">Please type a trivia question!</div>');
    
    }else if($("#txtop1").val() == '' ){
    $("#Errormsg7").fadeIn('fast').html('<div class="Errormsg">This option is a compulsory field</div>');

    }else if($("#txtop2").val() == '' ){
    $("#Errormsg7").fadeIn('fast').html('<div class="Errormsg">This option is a compulsory field</div>');

    }else if($("#txtans").val() == '' ){
    $("#Errormsg7").fadeIn('fast').html('<div class="Errormsg">This answer box is a compulsory field</div>');

    }else{
    
      $('#cmd_submit_quiz').hide();
      $('#cmd_submit_quiz1').show();
      
      $("#Errormsg7").hide();
      
      $.ajax({
        url : site_urls+"node/submit_my_questions",
        type: "POST",
        data: new FormData(this),
        contentType: false, 
        cache: false,
        processData:false,
        success: function(data){
          var datas = data.substring(0,8);
          var newfile = data.substring(9);
          var newfile1 = newfile.split(".")[1];
          
          if(data=='inserted'){
            $("#Errormsg7").fadeIn().html('<div style="color:#093; font-size:15px;" class="successmsg">Your question has been saved!</div>');
            
            setTimeout(function(){
              $("#Errormsg7").fadeOut('fast');
            },3000);

            setTimeout(function(){
              $("html, body").animate({ scrollTop: 140 }, "fast");
            },1000);

            $('#create_game_form .second_create_game .form-control, #create_game_form select').val('');
            $(".update_imgs").html("<img src='"+site_urls+"images/no_passport.jpg' src1='"+site_urls+"images/no_passport.jpg' id='im10'>");
            $("#file_quiz").val('');

          }else if(data=='errors'){
            alert('Error! Session is empty, please go back and start again');

          }else if(datas=='updated2'){
            $("#Errormsg7").fadeIn().html('<div style="color:#093" class="successmsg">Your question has been updated!</div>');
            setTimeout(function(){
              $("#Errormsg7").fadeOut('fast');
            },3000);

            if(newfile1!="")
            $(".update_imgs").html("<img src='"+site_urls+"quizes/"+newfile+"' id='im10'>");

            setTimeout(function(){
              $("html, body").animate({ scrollTop: 140 }, "fast");
            },1000);

          }else{
            
            $("#Errormsg7").fadeIn().html(data);
          }

          $('#cmd_submit_quiz').show();
          $('#cmd_submit_quiz1').hide();
        
        },error : function(data){
          alert('Error! Network Connection Failed!');
          $('#cmd_submit_quiz').show();
          $('#cmd_submit_quiz1').hide();
        }
      });
      
    }
  }));



  $("#create_main_activity").on('submit',(function(e) {
    e.preventDefault();
    $(".err_div4").hide();
    $('#cmd_create_activity').hide();
    $('#cmd_create_activity1').show();
    var txttitle = $('#txttitle').val();
    $(".err_div4").hide();
    
    $.ajax({
      url : site_urls+"node/create_activity_final",
      type: "POST",
      data: new FormData(this),
      contentType: false, 
      cache: false,
      processData:false,
      success: function(data){
        
        if(data=="createds"){
          $('#cmd_create_activity1').hide();
          $('#cmd_create_activity').show();
          $('.main_actvs1').html(txttitle);

          $('.first_create_form').hide();
          $('.second_create_form').slideDown('fast');

          setTimeout(function(){
            $(".err_div4").hide();
          },2500);
        }else{
          $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
        }

        $('#cmd_create_activity').show();
        $('#cmd_create_activity1').hide();
      
      },error : function(data){
        alert('Error! Network Connection Failed!');
        $('#cmd_create_activity').show();
        $('#cmd_create_activity1').hide();
      }
    });
    
  }));



  $("#upload_medias").on('submit',(function(e) {
    e.preventDefault();
    $(".err_div4").hide();
    $('#cmd_upload_media_').hide();
    $('#cmd_upload_media_1').show();
    $(".err_div4").hide();
    var actid = $("#actid").val();
    
    $.ajax({
      url : site_urls+"node/create_media_final",
      type: "POST",
      data: new FormData(this),
      contentType: false, 
      cache: false,
      processData:false,
      success: function(data){
        var datas = data.substring(0,8);
        var newfile = data.substring(9);
        if(datas=="uploaded"){
          $('#cmd_upload_media_1').hide();
          $('#cmd_upload_media_').show();
          $(".update_imgs1").html("<img src='"+site_urls+"gallery/"+newfile+"' id='im10'>");
          $("#former_file_ph").val('');
          if(actid="")
            $("#upload_medias")[0].reset();
          
          $('.for_vids').hide();
          $('.for_photos').show();

          $('.first_upload_form').hide();
          $('.sec_upload_form').slideDown('fast');

          setTimeout(function(){
            $(".err_div4").hide();
          },2500);
        }else{
          $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
        }

        $('#cmd_upload_media_').show();
        $('#cmd_upload_media_1').hide();
      
      },error : function(data){
        alert('Error! Network Connection Failed!');
        $('#cmd_upload_media_').show();
        $('#cmd_upload_media_1').hide();
      }
    });
    
  }));




  
  




  
});


//$('#post_content').live("mousedown",function(){
// $('#cmd_paste').live('click', function(e) {
//   document.querySelector('body').addEventListener('contextmenu', function( event ) {
//     // prevent the normal context menu from popping up
//     event.preventDefault();
//     // copy current selection
//     document.execCommand('paste');
// });
// });





function copyToClipboard(element) {
  var $temp = $("<textarea>");
  $("body").append($temp);
  var x = $(element).html().trim().replace(/<br>/g, '\n').replace(/<\/?[^>]+>/g, '');
  $temp.val(x).select();
  document.execCommand("copy");
  $temp.remove();
}


$('.copy_text').live("click",function(){
  var ids = $(this).attr('ids');
  copyToClipboard(document.getElementById("copyTarget"+ids));
  $('.copy_text').fadeOut(30);
  $('#cover_contents1'+ids).fadeOut('fast');
});


$('.copy_texts').live("click",function(){
  var ids = $(this).attr('ids');
  copyToClipboard(document.getElementById("copyTarget"+ids));
  $('.copy_texts').fadeOut(30);
  $('#cover_contents1'+ids).fadeOut('fast');
});


$('.read_mores').live("mousedown",function(){
  $('.start_about').slideUp('fast');
  $('.contd_about').slideDown('fast');
});

$('.read_lesss').live("mousedown",function(){
  $('.contd_about').slideUp('fast');
  $('.start_about').slideDown('fast');
});



$('.open_title').live("mousedown",function(){
  var ids = $(this).attr('ids');
  var titls = $(this).attr('titls');
  var date1 = $(this).attr('date1');
  
  create_cookie('ids', ids); // session
  create_cookie('tils', titls);

  $('.cat_title').html(titls);
  $('.date_java').html(date1);
  
  $('#txt_srch').val('');
  var datastring='ids='+ids;
  //+'&titls='+titls;
  $(".fetchCategoriesConts").show().html('<div style="padding:2em 10px; text-align:center;"><img src="'+site_urls+'images/loader.gif"> Loading page...</div>');

  if($(window).width()<760)
  $("html, body").animate({scrollTop:$('.pageant_1').offset().top-90}, "fast");
  else
  $("html, body").animate({scrollTop:$('.pageant_1').offset().top-150}, "fast");

  $.ajax({
    type : "POST",
    url : site_urls+"node/fetch_categories",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".fetchCategoriesConts").html(data);
    },error : function(data){
    }
  });
});



$('.open_cats li a').live("mousedown",function(){
  var ids = $(this).attr('ids');
  var titls = $(this).attr('titls');
  var page = retrieve_cookie('page_load');
  create_cookie('cats_f', ids);
  if(page=="" || page=="undefined") var page = 0;

  if(ids==2) $('.job_info').show(); else $('.job_info').hide();

  $('.forum_view').hide();
  $('.forum_div').show();
  $('.cat_title').html(titls);
  $('#txt_srch').val('');
  $('#txtcats1').val(ids);
  
  $('.topics1').html(titls);
  var txtparams = $('#txtparams').val();
  var txtmemsid = $('#txtmemsid').val();
  var directs1 = $(this).attr('directs1');
  
  if(directs1!=""){
    window.location = site_urls+"pages/"+directs1;
  }else{

    if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.topics_2').offset().top-220}, "fast");
    else
    $("html, body").animate({scrollTop:$('.topics_2').offset().top-440}, "fast");

    var datastring='page='+page
    +'&txtparams='+txtparams
    +'&txtmemsid='+txtmemsid
    +'&txt_srch='
    +'&txtcats1='+ids;

    $(".loaders_").show().html("Loading category...<br><img src='"+site_urls+"images/loader.gif'>");
    $.ajax({
      type : "POST",
      url : site_urls+"node/getForums",
      data : datastring,
      success : function(data){
        var responseReturn = data.match(/Edit this post/g);
        if(responseReturn != null){
            $(".successm").val(data);
            if($(".successm").val().match(/^.*No saved.*$/)){
                $('.load_more_bt').hide();
            }else{
                $('#load_more_mba').data('val', ($('#load_more_mba').data('val')+1));
            }
        }else{
            $('#load_more_mba').hide();
            $('#load_more_mba1').show();
            $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more threads!</font>');
        }

        $("#ajax_table_forum").show().empty().html(data);
        
        $(".loaders_").hide();
      },error : function(data){
      }
    });
  }
});


$('.open_year').live("mousedown",function(){
  var ids = $(this).attr('ids');
  var titls = $(this).attr('titls');
  var directs1 = $(this).attr('directs1');
  var param1 = $(this).attr('param1');
  
  $('.cat_title').html(titls+" Events");
  
  if(directs1!=""){
    window.location = site_urls+"pages/"+directs1;
  }else{
    var hash = location.hash.substring(1);
    create_cookie('urls_prev', hash);
    window.history.pushState('forward', null, './#events');
    create_cookie('urls', site_urls+"pages/#events");

    $('#txt_srch').val('');
    var datastring='ids='+ids
    +'&param1='+param1;
    $(".fetchCategoriesConts").show().html('<div style="padding:2em 10px; text-align:center;"><img src="'+site_urls+'images/loader.gif"> Loading year...</div>');
    $(".show_back_title").show();

    $.ajax({
      type : "POST",
      url : site_urls+"node/fetch_years",
      data : datastring,
      //cache : false,
      success : function(data){
        $(".fetchCategoriesConts").html(data);
      },error : function(data){
      }
    });
  }
});



$('.cmd_searchs').live("mousedown",function(){
  var vals = $(this).attr('vals');
  
  if(vals=="events"){
    var ids = $(this).attr('ids');
    var titls = $(this).attr('titls');
    
    var hash = location.hash.substring(1);
    create_cookie('urls_prev', hash);
    window.history.pushState('forward', null, './#events');
    create_cookie('urls', site_urls+"pages/#events");
  
    $(".show_back_title").show();
    var urls = site_urls+"node/fetch_years";
    var txt_srch = $('#txt_srch_events').val();
    var cat_titles = "Our Events";
  }

  if(vals=="pagents"){
    var urls = site_urls+"node/fetch_categories";
    var txt_srch = $('#txt_srch_pageant').val();
    var cat_titles = "Our Contestants";
  }

  if(vals=="forums"){
    var urls = site_urls+"node/getForums";
    var txt_srch = $('#txt_srch_forum').val();
    var cat_titles = "Our Forum";
  }

  if(vals=="videos"){
    var urls = site_urls+"node/fetch_searched_vids";
    var txt_srch = $('#txt_srch_vids').val();
    var cat_titles = "Our Videos";
  }

  if(vals=="photos"){
    var urls = site_urls+"node/fetch_searched_photos";
    var txt_srch = $('#txt_srch_phs').val();
    var cat_titles = "Our Photos";
  }


  if(txt_srch!=""){
    $('.cat_title').html("Searched for "+txt_srch);
    create_cookie('txt_srch', txt_srch);
  }else{
    $('.cat_title').html(cat_titles);
  }

  if(vals=="forums")
  $(".loaders_").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");
  else
  $(".fetchCategoriesConts").show().html('<div style="padding:2em 10px; text-align:center; clear:both;"><img src="'+site_urls+'images/loader.gif"> Loading filter...</div>');


  if($(window).width()<760)
  $("html, body").animate({scrollTop:$('.topics_2').offset().top-40}, "fast");
  else
  $("html, body").animate({scrollTop:$('.topics_2').offset().top-390}, "fast");

  var datastring='txt_srch='+txt_srch
  +'&page=0';
  $.ajax({
    type : "POST",
    url : urls,
    data : datastring,
    success : function(data){
      $(".loaders_").hide();
      if(vals=="forums")
        $("#ajax_table_forum").html(data);
      else
        $(".fetchCategoriesConts").html(data);
    },error : function(data){
    }
  });
});


$('.likes').live("mousedown",function(){
  var file1 = $(this).attr('file1');
  var ipaddr = $(this).attr('ipaddr');
  var mylikes = $(this).attr('mylikes');
  var con_id = $(this).attr('contestant_id');
  var like_type = $(this).attr('like_type');
  var swid = $(this).attr('swid');
  
  mylikes = parseInt(mylikes) + 1;
  var datastring='file1='+file1
  +'&dislike=0'
  +'&ipaddr='+ipaddr
  +'&swid='+swid
  +'&like_type='+like_type
  +'&con_id='+con_id;
  $("#likes"+file1).html("<fonts style='opacity:0.6'>Loading...</fonts>");

  $.ajax({
    type : "POST",
    url : site_urls+"node/add_likes",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".likes_btm1").html(data);
      
    },error : function(data){
    }
  });
});


$('.likes2').live("mousedown",function(){
  var file1 = $(this).attr('file1');
  var ipaddr = $(this).attr('ipaddr');
  var mylikes = $(this).attr('mylikes');
  var con_id = $(this).attr('contestant_id');
  var like_type = $(this).attr('like_type');
  var swid = $(this).attr('swid');

  mylikes = parseInt(mylikes) + 1;
  var datastring='file1='+file1
  +'&dislike=0'
  +'&con_id='+con_id
  +'&like_type='+like_type
  +'&ipaddr='+ipaddr;
  +'&swid='+swid
  $("#likes12"+file1).html("<fonts style='opacity:0.6'>Loading...</fonts>");
  $.ajax({
    type : "POST",
    url : site_urls+"node/add_likes",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".likes_btm2").html(data);
    },error : function(data){
    }
  });
});


$('.likes3').live("mousedown",function(){
  var file1 = $(this).attr('file1');
  var ipaddr = $(this).attr('ipaddr');
  var mylikes = $(this).attr('mylikes');
  var con_id = $(this).attr('contestant_id');
  var like_type = $(this).attr('like_type');
  var swid = $(this).attr('swid');

  mylikes = parseInt(mylikes) + 1;
  var datastring='file1='+file1
  +'&dislike=0'
  +'&con_id='+con_id
  +'&like_type='+like_type
  +'&ipaddr='+ipaddr;
  +'&swid='+swid
  $("#likes13"+file1).html("<fonts style='opacity:0.6'>Loading...</fonts>");
  $.ajax({
    type : "POST",
    url : site_urls+"node/add_likes",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".likes_btm3").html(data);
    },error : function(data){
    }
  });
});



$('.likes1').live("mousedown",function(){
  var file1 = $(this).attr('file1');
  var ipaddr = $(this).attr('ipaddr');
  var mylikes = $(this).attr('mylikes');
  var con_id = $(this).attr('contestant_id');
  var like_type = $(this).attr('like_type');
  var swid = $(this).attr('swid');

  var datastring='file1='+file1
  +'&dislike=1'
  +'&con_id='+con_id
  +'&like_type='+like_type
  +'&ipaddr='+ipaddr;
  +'&swid='+swid
  $("#likes1"+file1).html("<fonts style='opacity:0.6'>Loading...</fonts>");
  $.ajax({
    type : "POST",
    url : site_urls+"node/add_likes",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".likes_btm1").html(data);
    },error : function(data){
    }
  });
});


$('.likes12').live("mousedown",function(){
  var file1 = $(this).attr('file1');
  var ipaddr = $(this).attr('ipaddr');
  var mylikes = $(this).attr('mylikes');
  var con_id = $(this).attr('contestant_id');
  var like_type = $(this).attr('like_type');
  var swid = $(this).attr('swid');

  var datastring='file1='+file1
  +'&dislike=1'
  +'&con_id='+con_id
  +'&like_type='+like_type
  +'&ipaddr='+ipaddr;
  +'&swid='+swid
  $("#likes2"+file1).html("<fonts style='opacity:0.6'>Loading...</fonts>");
  $.ajax({
    type : "POST",
    url : site_urls+"node/add_likes",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".likes_btm2").html(data);
    },error : function(data){
    }
  });
});


$('.likes13').live("mousedown",function(){
  var file1 = $(this).attr('file1');
  var ipaddr = $(this).attr('ipaddr');
  var mylikes = $(this).attr('mylikes');
  var con_id = $(this).attr('contestant_id');
  var like_type = $(this).attr('like_type');
  var swid = $(this).attr('swid');

  var datastring='file1='+file1
  +'&dislike=1'
  +'&con_id='+con_id
  +'&like_type='+like_type
  +'&ipaddr='+ipaddr;
  +'&swid='+swid
  $("#likes3"+file1).html("<fonts style='opacity:0.6'>Loading...</fonts>");
  $.ajax({
    type : "POST",
    url : site_urls+"node/add_likes",
    data : datastring,
    //cache : false,
    success : function(data){
      $(".likes_btm3").html(data);
    },error : function(data){
    }
  });
});




$('#refreshMaths1').live("mousedown",function(){
  myMaths1();
});



$('.cmdok').live("click",function(){
  window.location = site_urls;
});



$('.send_messages').live("mousedown",function(){
  $(".errormessage").hide();
  $('.send_messages').hide();
  $('.send_messages1').show();
  
  $.ajax({
    type : "POST",
    url : site_urls+"node/send_contact_msg",
    data: $(".contact_form2").serialize(),
    success : function(data){
      if(data=="msg_sent"){
        $('.send_messages').show();
        $('.send_messages1').hide();
        $(".errormessage").show().html('<div class="successmsg" style="text-align:center; font-size:16px !important;">Your message has been sent. Thank you!</div>');
        $(".contact_form2")[0].reset();

        setTimeout(function(){
          $(".errormessage").hide();
        },3500);
      
      }else{
        $('.send_messages').show();
        $('.send_messages1').hide();
        $(".errormessage").show().html('<div class="Errormsg">'+data+'</div>');
      }

    },error : function(data){
        $('.send_messages').show();
        $('.send_messages1').hide();
        $(".errormessage").show().html('<div class="Errormsg">Poor Network Connection!</div>');
    }
  });
});




$('#cmd_update_pass_admin').live("click",function(e){
  e.preventDefault();
  $(".err_div4").hide();
  $('#cmd_update_pass_admin').hide();
  $('#cmd_update_pass_admin1').show();
  
  $.ajax({
    type : "POST",
    url : site_urls+"shield/update_my_pass",
    data: $("#edit_pass").serialize(),
    success : function(data){

      if(data=="pass1_updated"){
        $('#cmd_update_pass_admin').show();
        $('#cmd_update_pass_admin1').hide();
        
        $(".err_div4").show().html('<div class="successmsg" style="text-align:center">Your password has been updated!</div>');
        $("#edit_pass")[0].reset();
        
        setTimeout(function(){
          $(".err_div4").hide();
        },2500);
      
      }else{
        $('#cmd_update_pass_admin').show();
        $('#cmd_update_pass_admin1').hide();
        $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
      }

    },error : function(data){
        $('#cmd_update_pass_admin').show();
        $('#cmd_update_pass_admin1').hide();
        $(".err_div4").show().html('<div class="Errormsg">Poor Network Connection!</div>');
    }
  });
});



var elem = document.documentElement;
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}


$('.btn_delete').live("click",function(e){
  $('#delete_dv').show();
  var for_id = $(this).attr("for_id");
  var for_page = $(this).attr("for_page");
  $('#txtall_id').val(for_id);
  $('#txtall_page').val(for_page);
});




$('.cmd_close_del').live("click",function(){
  $('.modals').hide();
  $('#delete_dv').hide();
});




$('.modals').live("mousedown",function(){
  $('.modals').hide();
  $('#myPopup_1_faqs, #myPopup_1_cats, #myPopup_1').hide();
});



$('.cmd_close_del1, .close_edit').live("mousedown",function(){
  $('.modals').hide();
  $('#myPopup_1_faqs, #myPopup_1_cats, #myPopup_1').hide();
});



$('#cmd_done_profile').live("mousedown",function(){
  $('.sec_prof_form').hide();
  $('.first_prof_form').show();
});



$('#txtplan').live("change",function(){
  $('.compute_tax').hide();
  $('#txtpayments').get(0).selectedIndex = 0;  
});



$('.bank_trans').live("mousedown",function(e){
  e.stopPropagation();
  $txtpayment = $('.txtprice_hiden').val();
  $txtads = $('.txtprods').val();
  $memid = $('.memid').val();
  $refids = $('.refids').val();
  $('#txtmthd').val('manual');
  var txtmthd = $('#txtmthd').val();
  
  var datastring='memid='+$memid
  +'&refids='+$refids
  +'&txtads='+$txtads
  +'&transref=mp'
  +'&txtpayments='+$txtpayment;
  
  $(".err_div").hide();

  if(confirm("Proceed to use the Bank Transfer method?")){
    $('.bank_trans').hide();
    $('.bank_trans1').show();

    $.ajax({
      type: "POST",
      url : site_urls+"node/pay_to_company",
      data: datastring,
      cache: false,
      success: function(html){
        //alert(html)
        if(html.trim() == "submitteds1"){
          
          $('.payment_type').slideUp('fast');
          $('.pay_to_company').hide();
          $('.successinfo').fadeIn('fast');

          $('.php_pay').hide();
          $('.java_payto').show();

          $('.bank_trans').show();
          $('.bank_trans1').hide();
        }else{
          $('.payment_type').slideUp('fast');
          $('.err_div').show().html('<div class="Errormsg">'+html+'</div>');
          $('.bank_trans').show();
          $('.bank_trans1').hide();
          
        }
      },error : function(html){
        alert('Connection Error! Please check your connection.');
        $('.bank_trans').show();
        $('.bank_trans1').hide();
        $('.payment_type').slideUp('fast');
      }
    });
  }

});




$('.bank_trans_1').live("mousedown",function(e){
  e.stopPropagation();
  $txtpayment = $('.txtprice_hiden').val();
  $txtads = $('.txtprods').val();
  $memid = $('.memid').val();
  $refids = $('.refids').val();
  $('#txtmthd').val('manual');
  var txtmthd = $('#txtmthd').val();
  
  var datastring='memid='+$memid
  +'&refids='+$refids
  +'&txtads='+$txtads
  +'&transref=mp'
  +'&txtpayments='+$txtpayment;
  
  $(".err_div").hide();
  $('.bank_trans_1').hide();
  $('.bank_trans1').show();
  $.ajax({
    type: "POST",
    url : site_urls+"node/pay_to_company",
    data: datastring,
    cache: false,
    success: function(html){
      if(html.trim() == "submitteds1"){
        $('.payment_type').slideUp('fast');
        $('.pay_to_company').hide();
        $('.successinfo').fadeIn('fast');

        $('.php_pay').hide();
        $('.java_payto').show();

        $('.bank_trans_1').show();
        $('.bank_trans1').hide();
      }else{
        $('.payment_type').slideUp('fast');
        $('.err_div').show().html('<div class="Errormsg">'+html+'</div>');
        $('.bank_trans_1').show();
        $('.bank_trans1').hide();
        
      }
    },error : function(html){
      alert('Connection Error! Please check your connection.');
      $('.bank_trans_1').show();
      $('.bank_trans1').hide();
      $('.payment_type').slideUp('fast');
    }
  });

});



$('.closediv_quiz').live("mousedown",function(){
  $('.div_success_test').hide();
  $('.div_success_test_timeout').hide();
  $('.not_ready_activity').fadeIn('fast');
});



$('#cmdsubmit_plan').live("mousedown",function(){
  $txtpayment = $('#txtpayments').val();
  $txtplan = $('#txtplan').val();
  $txtads = $('#txtads').val();
  
  $memid = $('.memid').val();
  $('.err_divs').hide();
  if($txtads == ""){
    $('.err_div').show().html('<div class="Errormsg">Please select your Ad</div>');
    setTimeout(function(){
      $(".err_div").hide();
    },3500);
    return false;
  }

  if($txtplan == ""){
    $('.err_div').show().html('<div class="Errormsg">Please choose a plan</div>');
    $("#form_feature")[0].reset();
    setTimeout(function(){
      $(".err_div").hide();
    },3500);
    return false;
  }

  if($txtpayment == ""){
    $('.err_div').show().html('<div class="Errormsg">Please select your prefered mode of payment</div>');
    setTimeout(function(){
      $(".err_div").hide();
    },3500);
    return false;
  }

  var datastring='txtplan='+$txtplan
  +'&memid='+$memid
  +'&txtads='+$txtads
  +'&txtpayments='+$txtpayment;
  //alert(datastring)
  
  if(confirm("Proceed to submit this to the Admins")){
    $('#cmdsubmit_plan').hide();
    $('#cmdsubmit_plan1').show();

    $.ajax({
      type: "POST",
      url : site_urls+"node/submit_ad",
      data: datastring,
      cache: false,
      success: function(html){
        if(html.trim() == "submitted"){
          $('.form_fill').slideUp('fast');
          $('.form_suces').slideDown('fast');
          $("#form_feature")[0].reset();
          $('.compute_tax').hide();
          $('#cmdsubmit_plan').show();
          $('#cmdsubmit_plan1').hide();
        }else{
          $('.err_div').show().html('<div class="Errormsg">'+html+'</div>');
          $('#cmdsubmit_plan').show();
          $('#cmdsubmit_plan1').hide();
          setTimeout(function(){
            $(".err_div").hide();
          },3500);
        }
      },error : function(html){
        alert('Connection Error! Please check your connection.');
        $('#cmdsubmit_plan').show();
        $('#cmdsubmit_plan1').hide();
      }
    });
  }

});




$('.registers').live("mousedown",function(e){
  e.stopPropagation();
  $('.frm_log_buyer').hide();
  $('.frm_reg_buyer').slideToggle('fast');
});


$('.logins').live("mousedown",function(e){
  e.stopPropagation();
  $('.frm_reg_buyer').hide();
  $('.frm_log_buyer').slideToggle('fast');
});



$('.helps').live("mousedown",function(e){
  $('.refer_info').fadeToggle('fast');
});


$('.refer_info').live("mousedown",function(e){
  $('.refer_info').fadeOut('fast');
});


$('#cmddone_fea').live("mousedown",function(e){
  $('.form_suces').slideUp('fast');
  $('.form_fill').slideDown('fast');
  $('#cmdsubmit_plan').show();
});


$('#cmddone_contacts').live("mousedown",function(e){
  $('.form_suces_contact').slideUp('fast');
  $('.form_contact').slideDown('fast');
});


$('#cmddone_email').live("mousedown",function(e){
  $('.form_suces_msg').slideUp('fast');
  $('.form_msg').slideDown('fast');
});


$('#cmddone_vid').live("mousedown",function(e){
  $('.form_suces_uploads').slideUp('fast');
  $('.upload_testi_vid').slideDown('fast');
});



$('#cmdgonext_begin').live("mousedown",function(e){
  $('.form_rules').slideUp('fast');
  $('.form_fill_reg').slideDown('fast');
});


$('#cmddone_fea_online').live("mousedown",function(e){
  $('.form_suces_online').slideUp('fast');
  $('.form_fill').slideDown('fast');
  $('#cmdsubmit_plan').show();
});



$('.pay_to_company').live("mousedown",function(e){
  $('.payment_type').slideDown('fast');
});


$('.cancels').live("mousedown",function(e){
  $('.payment_type').slideUp('fast');
});


$('.sm').live("mousedown",function(e){
  $('.sm').css({'color':'red', 'font-weight':'bold'});
  $('.fm').css({'color':'#06C', 'font-weight':'normal'});
  $('.private_emails').show();
  $('.public_emails').hide();
});


$('.fm').live("mousedown",function(e){
  $('.fm').css({'color':'red', 'font-weight':'bold'});
  $('.sm').css({'color':'#06C', 'font-weight':'normal'});
  $('.public_emails').show();
  $('.private_emails').hide();
});



$('#txtnew_old, #txtsend_cat, #txtcountries, #txtbm_type, #featuredads, #txtsubj, #txtsms').live("change",function(e){
  $('.fetching_mem').show();
  $('.send_msgs1').hide();
});



$('#cmdsend_msgs_count').live("click",function(e){
  
  $('#cmdsend_msgs_count').hide();
  $('#cmdsend_msgs_count1').show();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/send_messages_count",
      data: $("#form_sendmsg").serialize(),
      //cache : false,
      success : function(data){
        $('#cmdsend_msgs_count1').hide();
        $('#cmdsend_msgs_count').show();

        if(data<=0){
          $('.fetching_mem').show();
          $('.send_msgs1').hide();
        }else{
          $('.fetching_mem').hide();
          $('.send_msgs1').show();
        }

        $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');

      },error : function(data){
          $('#cmdsend_msgs_count1').hide();
          $('#cmdsend_msgs_count').show();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('#cmdsend_msgs').live("click",function(e){
  e.preventDefault();

    $(".err_div").hide();
    $('#cmdsend_msgs').hide();
    $('#cmdsend_msgs1').show();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/send_messages",
      data: $("#form_sendmsg").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="sents"){
        $('#cmdsend_msgs').show();
        $('#cmdsend_msgs1').hide();

        $('.form_msg').slideUp('fast');
        $('.form_suces_msg').slideDown('fast');
        $("#form_sendmsg")[0].reset();
        $("html, body").animate({ scrollTop: 400 }, "fast");

        $('.fetching_mem').show();
        $('.send_msgs1').hide();

        setTimeout(function(){
          $(".err_div").hide();
        },2500);

        }else{
        $('#cmdsend_msgs').show();
        $('#cmdsend_msgs1').hide();
        $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
        //alert(data)
          $('#cmdsend_msgs').show();
          $('#cmdsend_msgs1').hide();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });

});


function autocomplet() {
  
	var min_length = 0;
	var keyword = $('#txtemails').val();
  //var page = $(this).data('val');
  var datastring='keyword='+keyword;
  
    if (keyword != "") {
		$.ajax({
      url : site_urls+"node/getSearches",
			type: 'POST',
      data: datastring,
			success:function(data){
        //alert(data);
        if(data != ""){
          $('#country_list_id').show();
          $('#country_list_id').html(data);
        }else{
          $('#country_list_id').hide();
          $('#country_list_id').html('');
        }
			},error : function(data){
        
      }
		});
	} else {
		$('#country_list_id').hide();
	}
}


function set_item(item) {
	$('#txtemails').val(item);
	$('#country_list_id').hide();
}



$('.musltiple_emails-ul').live("click",function(e){
  $('.musltiple_emails-ul').hide();  
});


$('#current_emailsBS').live("click, mousemove",function(e){
  $defaults = $('#current_emailsBS').html();
  if($defaults!="All emails" && $defaults!="[]")
  $('.musltiple_emails-ul').show();  
});




$('.back2').live("click",function(){
  $('.ist_form').fadeIn('fast');
  $('.secs_form').hide();
});

$('.back_activity').live("mousedown",function(){
  $('.first_activity').fadeIn('fast');
  $('.second_activity').hide();
  $('#txtfirst_form').val('first');
});


$('.cmd_done_activity').live("mousedown",function(){
  $('.second_activity').hide();
  $('.third_activity').hide();
  $('.first_activity').hide();
  $('.not_ready_activity').show();
  $('#txtfirst_form').val('first');
  $(".uploadimage_activity")[0].reset();
  $('.file_pics').val('');
  var srcs = site_urls+"images/no_photo.jpg";
  $('#im1_file').attr('src', srcs);
  $('#im1_file2').attr('src', srcs);
  $('#im1_file3').attr('src', srcs);
});


// $('.enterTime').live("mousedown",function(){
//   var reqVal = $('#request').val();
//   var parAmt = parseInt(reqVal);
//   if (timeloop) {
//       clearTimeout(timeloop);
//   }
//   totalAmount = parAmt * 60;
//   $('#request').val(" ");
//   timeSet();
// });


$('.cmd_proceed_activity').live("mousedown",function(){
  $('.cmd_proceed_activity').hide();
  $('.cmd_proceed_activity1').show();

  var qid = $('#qid_intro').val();
  var studid = $(this).attr('studid');
  
  setTimeout(function(){
    $('.cmd_proceed_activity1').hide();
    $('.cmd_proceed_activity').show();
    $('.div_quiz').hide();
    $('.div_quiz2').fadeIn('fast');
    
    totalAmount = 0;
    clearTimeout(timeloop);
    localStorage.removeItem('countDown');

    $('.div_start_test').fadeOut('fast');
    var datastring='qid='+qid
    +'&studid='+studid;

    $.ajax({
      type: "POST",
      url : site_urls+"node/save_stud_test_start",
      data: datastring,
      success : function(data){
        var reqVal = $('#request').val();
        var parAmt = parseInt(reqVal);
        if (timeloop) {
            clearTimeout(timeloop);
        }
        totalAmount = parAmt * 60;
        $('#request').val(" ");
        timeSet();
      }
    });

  },2000);
});


$('.header-bottom a').live("mousedown",function(){
  create_cookie('page_refreshed', 0);
  $('.prev_pages').hide();
  
  if(page_names != ""){
    $('.prev_pages2').show();
  }
});



$('#cmd_upload_media').live("mousedown",function(){
  $('#cmd_upload_media').hide();
  $('#cmd_upload_media1').show();
  var actid = $(this).attr('actid');

  var txttitle = $('#txttitle').val();
  var txtdescrip = $('#txtdescrip').val();
  $(".err_div4").hide();

  var datastring='txttitle='+txttitle
  +'&txtdescrip='+txtdescrip
  +'&actid='+actid;

  $.ajax({
    type: "POST",
    url : site_urls+"node/upload_medias",
    data: datastring,
    success : function(data){
      if(data=="createds"){
        $('#cmd_upload_media1').hide();
        $('#cmd_upload_media').show();
        $('.first_create_form').hide();
        $('.second_create_form').slideDown('fast');

        if(actid!=""){
          var datastring9='update_id='+actid;
          $.ajax({
            type : "POST",
            url : site_urls+"node/fetch_pics_for_this_id",
            data: datastring9,
            success : function(data){
              if(data != "")
                $('.former_uploads').show().html(data);
              else
                $('.former_uploads').hide();
            },error : function(data){
            }
          });
        }

        setTimeout(function(){
          $(".err_div4").hide();
        },2500);

        }else{
          $('#cmd_upload_media1').hide();
          $('#cmd_upload_media').show();
        $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
      }
    }
  });
});



$('#cmd_new').live("mousedown",function(){
  var ids = $(this).attr("id1");
  window.location = site_urls+"shield/edit_activity/"+ids+"/new/";
});


$('#cmd_next_act').live("mousedown",function(){
  $('.first_create_form').hide();
  $('.second_create_form').slideDown('fast');
});


$('#cmd_next_act1').live("mousedown",function(){
  $('.second_create_form').hide();
  $('.third_create_form').slideDown('fast');
});


$('#cmd_next_evt').live("mousedown",function(){
  $('.first_create_form').hide();
  $('.second_create_form').slideDown('fast');
  var actid = $(this).attr('actid');
  var datastring9='update_id='+actid;
  $.ajax({
    type : "POST",
    url : site_urls+"node/fetch_pics_for_this_id",
    data: datastring9,
    success : function(data){
      if(data != "")
        $('.former_uploads').show().html(data);
      else
        $('.former_uploads').hide();
    },error : function(data){
    }
  });
});


$('#cmd_prev_act').live("mousedown",function(){
  $('.second_create_game').hide();
  $('.first_create_game').fadeIn('fast');
  $('#cmd_next1_act').show();
  $("#Errormsg7").hide();
});


$('#cmd_next1_act').live("mousedown",function(){
  $(".err_div4").hide();
  $txtsel_act = $("#txtsel_act").val();
  $txtquiz_time = $("#txtquiz_time").val();
  $txtsel_day = $("#txtsel_day").val();
  
  if($txtsel_act == '' ){
    $(".err_div4").fadeIn('fast').html('<div class="Errormsg">Please select activity for this game</div>');

  }else if($txtsel_day == '' ){
    $(".err_div4").fadeIn('fast').html('<div class="Errormsg">Select day activity!</div>');
    
  }else if($txtquiz_time == '' ){
    $(".err_div4").fadeIn('fast').html('<div class="Errormsg">Write the duration of this trivia game!</div>');

  }else{
    $('.first_create_game').hide();
    $('.second_create_game').fadeIn('fast');
  }
});



$('#cmd_create_sec_activity').live("click",function(){
  $('#cmd_create_sec_activity').hide();
  $('#cmd_create_sec_activity1').show();
  var actid = $(this).attr('actid');
  var qrys = $(this).attr('qrys');

  var txtday = $('#txtday').val();
  var txtgametype = $('#txtgametype').val();
  var txtins = $('#txtins').val();
  var txttime = $('#txttime').val();
  var txtstart = $('#txtstart').val();
  var txtgtitle = $('#txtgtitle').val();
  $(".err_div4").hide();

  var datastring='txtday='+txtday
  +'&txtgametype='+txtgametype
  +'&txtins='+txtins
  +'&txttime='+txttime
  +'&actid='+actid
  +'&qrys='+qrys
  +'&txtgtitle='+txtgtitle
  +'&txtstart='+txtstart;

  $.ajax({
    type: "POST",
    url : site_urls+"node/create_activity_last_step",
    data: datastring,
    success : function(data){
      if(data=="created_last"){
        $('#cmd_create_sec_activity1').hide();
        $('#cmd_create_sec_activity').show();

        $('.second_create_form').hide();
        $('.third_create_form').slideDown('fast');

        setTimeout(function(){
          $(".err_div4").hide();
        },2500);

        }else{
          $('#cmd_create_sec_activity1').hide();
          $('#cmd_create_sec_activity').show();
        $(".err_div4").show().html('<div class="Errormsg">'+data+'</div>');
      }
    }
  });

});





$('#cmd_goto_viewacts').live("click",function(){
  window.location = site_urls+"shield/view_activities/";
});



$('#contd_quiz').live("click",function(){

  $('.cmd_proceed_activity').hide();
  $('.cmd_proceed_activity1').show();

  var qid = $('#qid_intro').val();
  var studid = $(this).attr('studid');
  
  setTimeout(function(){
    $('.cmd_proceed_activity1').hide();
    $('.cmd_proceed_activity').show();
    $('.div_quiz').hide();
    $('.div_quiz2').fadeIn('fast');
    
    $('.div_start_test').fadeOut('fast');

  },500);

});



$('.quiz_options li input').live("click",function(){
  var class1 = $(this).attr("class");
  $('#txtans1').val(class1);
});


$('.use_prev_questn').live("click",function(e){
  e.stopPropagation();
  $('.write_quest_div').slideToggle('fast');
  $('.prev_quest_div').slideToggle('fast');
  
});


$('.prev_quest_div').live("click",function(e){
  e.stopPropagation();
  $('.prev_quest_div').show();
});



$('.use_this_questns').live("click",function(){  
  var sess = $(this).attr('sess');
  var txtsessions = $('#txtsessions').val();
  var txtact_id = $('#txtact_id').val();
  var txtquizid = $('#txtquizid').val();

  if(confirm("Using this question for this current activity will erase the previous one\r\nProceed to use it anyway?")){
    var datastring='sess='+sess
    +'&txtsessions='+txtsessions
    +'&txtact_id='+txtact_id;

    $.ajax({
      type : "POST",
      url : site_urls+"node/use_quiz_questions",
      data: datastring,
      success : function(data){
        //alert(data)
        if(data=="updateds"){
          $('.second_create_game').hide();
          $('.third_create_form').slideDown('fast');
        }else{
          alert('Error!');
        }
      },error : function(data){
      }
    });
  }
});



$('#cmdsend_msgs_pri').live("click",function(e){
  e.preventDefault();

    $(".err_div").hide();
    $('#cmdsend_msgs_pri').hide();
    $('#cmdsend_msgs_pri1').show();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/send_messages_pri",
      data: $("#form_sendmsg").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="sents"){
        $('#cmdsend_msgs_pri').show();
        $('#cmdsend_msgs_pri1').hide();

        $('.form_msg').slideUp('fast');
        $('.form_suces_msg').slideDown('fast');
        $("#form_sendmsg")[0].reset();

        setTimeout(function(){
          $(".err_div").hide();
        },2500);

        }else{
        $('#cmdsend_msgs_pri').show();
        $('#cmdsend_msgs_pri1').hide();
        $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
          $('#cmdsend_msgs_pri').show();
          $('#cmdsend_msgs_pri1').hide();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.basic_uploader').live("click",function(e){
  $('.basic_uploader').hide();
  $('#img_prev1_bma img').hide();
  $('#txt_bma_pic').val('');
  $('#txt_bma_pic').show();
  $('#hide_basic_uploader').show();
});


$('.basic_uploader_file').live("click",function(e){
  $('.basic_uploader_file').hide();
  $('#img_prev1_file').hide();
  $('#txtpics1').show();
  $('#txtpics1').val('');
  $("#img_prev1_file span").click();
  $('#hide_basic_uploader_file').show();
});


$('.basic_uploader_file2').live("click",function(e){
  $('.basic_uploader_file2').hide();
  $('#img_prev1_file2').hide();
  $('#txtpics2').show();
  $('#txtpics2').val('');
  $("#img_prev1_file2 span").click();
  $('#hide_basic_uploader_file2').show();
});


$('.basic_uploader_file3').live("click",function(e){
  $('.basic_uploader_file3').hide();
  $('#img_prev1_file3').hide();
  $('#txtpics3').show();
  $('#txtpics3').val('');
  $("#img_prev1_file3 span").click();
  $('#hide_basic_uploader_file3').show();
});


$('#hide_basic_uploader').live("click",function(e){
  $('#hide_basic_uploader').hide();
  $('#img_prev1_bma img').show();
  $('#txt_bma_pic').hide();
  $('#txt_bma_pic').hide();
  $('.basic_uploader').show();
});


$('#hide_basic_uploader_file').live("click",function(e){
  $('#hide_basic_uploader_file').hide();
  $('#img_prev1_file').show();
  $('#txtpics1').hide();
  $('.basic_uploader_file').show();
});


$('#hide_basic_uploader_file2').live("click",function(e){
  $('#hide_basic_uploader_file2').hide();
  $('#img_prev1_file2').show();
  $('#txtpics2').hide();
  $('.basic_uploader_file2').show();
});


$('#hide_basic_uploader_file3').live("click",function(e){
  $('#hide_basic_uploader_file3').hide();
  $('#img_prev1_file3').show();
  $('#txtpics3').hide();
  $('.basic_uploader_file3').show();
});


$('.basic_uploader1').live("click",function(e){
  $('.java_uploader').hide();
  $('.basic_uploader1').hide();
  $('.big_uploader').show();
  $('.simple_uploader').show();
  $('.auto_uploader_div').hide();
  $('.basic_uploader_div').show();
});


$('.big_uploader').live("click",function(e){
  $('.java_uploader').show();
  $('.simple_uploader').hide();
  $('.basic_uploader1').show();
  $('.big_uploader').hide();
  $('.auto_uploader_div').show();
  $('.basic_uploader_div').hide();
});



$('.cmdabout').live("click",function(e){
  e.preventDefault();
    $(".errmsg_abt").hide();
    $('.cmdabout').attr("disabled", true);
    
    var txtabout = $('#txtabout').val();
    var datastring='txtabout='+txtabout;

    $.ajax({
      type : "POST",
      url : site_urls+"adminx/save_about",
      data: datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="confirmed"){
          $('.errmsg_abt').show().html('<font style="color:#090;">Successfully Updated!</font>');
          setTimeout(function(){
            $(".errmsg_abt").hide();
          },2500);
        }else{
        $(".errmsg_abt").show().html('<div class="Errormsg">'+data+'</div>');
        }
        $('.cmdabout').attr("disabled", false);
      },error : function(data){
          $('.cmdabout').attr("disabled", false);
          $(".errmsg_abt").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.close_inv_info').live("click",function(){
  $('.mask').hide();
  $('.open_invoice').hide();
  $('.err_store').hide();
});




$('#swipe_contacts').live("click",function(){
  var ids = $(this).attr('ids');
  $('#show_contacts'+ids).slideToggle('fast');
});

$('#swipe_contacts1').live("click",function(){
  var ids = $(this).attr('ids');
  $('#show_contacts'+ids).slideToggle('fast');
});

$('.show_contacts').live("click",function(){
  $('.show_contacts').slideUp('fast');
});




$('.click_to_open_invoice').live("click",function(){
//$( "#next_btn" ).load( "core/generate_suggestions/"+nextstart+"/" + movies_per_page );
  var each_id = $(this).attr('id');
  
  $.ajax({
    type : "POST",
    url : site_urls+"node/bring_invoice_details",
    //data: $("#form_search").serialize(),
    data: 'ids='+each_id,
    //cache : false,
    success : function(data){
      //alert(data)
      $('.mask').show();
      $('.open_invoice').fadeIn('fast').html(data);
      
    },error : function(data){
        //$('#cmd_subm').show();
        //$('#cmd_subm1').hide();
        $(".err_div").show().html('<div class="Errormsg">Poor Network Connection!</div>');
    }
  });
});


$('#more_details').live("click",function(){
  var ids = $(this).attr('ids');
  //$('#more_details'+ids).
  $("#drop_details"+ids).slideToggle('fast');

});



$('.mask').live("click",function(e){
  $('.mask').hide();
  $('.open_invoice').hide();
  $('.err_store').hide();
});



// $('.cover_video_first1').live("click",function(){
//   var ids = $('.videos1').attr('ids');
  
//   $('.cover_video_first1').hide();
//   pl = videojs('myVideo');
//   pl.play();
//   //alert('ssss');
//   var datastring='vid_id='+ids;
//   $.ajax({
//     type: "POST",
//     url : site_urls+"node/update_vid_views",
//     data: datastring,
//     cache: false,
//     success: function(html){
      
//     }
//   });
// });


function readURL(input, idf){
if(input.files && input.files[0]){
var reader = new FileReader();
reader.onload=function(e){
$(idf).attr('src',e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}


$("#im1").live("click",function(){
$("#files1").click();
});

$("#im1_up").live("click",function(){
$("#txtlogo_up").click();
});

$("#im1_bma").live("click",function(){
$("#txt_bma_pic").click();
});


$("#im1_file").live("click",function(){
$("#txtpics1").click();
});

$("#im1_file2").live("click",function(){
$("#txtpics2").click();
});

$("#im1_file3").live("click",function(){
$("#txtpics3").click();
});


$("#img_prev1 span").live("click",function(){
var srcs = $('#im1').attr('src1');
$("#files1").replaceWith('<input type="file" name="files1" id="files1" style="padding:4px; font-size:13px; display:none" />');
$("#img_prev1").html("<span>remove</span><img src='"+srcs+"' src1='"+srcs+"' id='im1'>");
$("#ad_logo_check1").val(0);
$(this).hide();
});


$("#img_prev1_up span").live("click",function(){
var srcs = $('#im1').attr('src1');
$("#txtlogo_up").replaceWith('<input type="file" name="txtlogo_up" id="txtlogo_up" style="padding:4px; font-size:13px; display:none" />');
$("#img_prev1_up").html("<span>remove</span><img src='"+srcs+"' src1='"+srcs+"' id='im1_up'>");
$("#ad_logo_check1_up").val(0);
$(this).hide();
});


$("#img_prev1_bma span").live("click",function(){
var srcs = $('#im1_bma').attr('src1');
$("#txtlogo_bma").replaceWith('<input type="file" name="txt_bma_pic" id="txt_bma_pic" style="padding:4px; font-size:13px; display:none" />');
$("#img_prev1_bma").html("<span>remove</span><img src='"+srcs+"' src1='"+srcs+"' id='im1_bma'>");
$("#ad_logo_check1_up_bma").val(0);
$(this).hide();
});


$("#img_prev1_file span").live("click",function(){
var srcs = $('#im1_file').attr('src1');
//$("#txtlogo_bma").replaceWith('<input type="file" name="txtpics1" id="txtpics1" style="display:none" />');
$("#img_prev1_file").html("<span>remove</span><div class='resize_picx'><img src='"+srcs+"' src1='"+srcs+"' id='im1_file'></div>");
//$("#ad_logo_check1_up_bma").val(0);
$(this).hide();
});

$("#img_prev1_file2 span").live("click",function(){
  var srcs = $('#im1_file2').attr('src1');
  //$("#txtlogo_bma").replaceWith('<input type="file" name="txtpics2" id="txtpics2" style="display:none" />');
  $("#img_prev1_file2").html("<span>remove</span><div class='resize_picx'><img src='"+srcs+"' src1='"+srcs+"' id='im1_file2'></div>");
  //$("#ad_logo_check1_up_bma").val(0);
  $(this).hide();
});

$("#img_prev1_file3 span").live("click",function(){
  var srcs = $('#im1_file3').attr('src1');
  //$("#txtlogo_bma").replaceWith('<input type="file" name="txtpics2" id="txtpics2" style="display:none" />');
  $("#img_prev1_file3").html("<span>remove</span><div class='resize_picx'><img src='"+srcs+"' src1='"+srcs+"' id='im1_file3'></div>");
  //$("#ad_logo_check1_up_bma").val(0);
  $(this).hide();
});


$("#img_prev_prod span").live("click",function(){
var srcs = $('#im1_prod').attr('src1');
$("#file").replaceWith('<input type="file" name="file" id="file" style="display:none" />');
$("#img_prev_prod").html("<span>remove</span><img src='"+srcs+"' src1='"+srcs+"' id='im1_prod'>");
$("#ad_logo_check1_prod").val(0);
$(this).hide();
$(".dz-message").show();
});


$("#im1_prod").live("click",function(){
$("#file").click();
});


$("#file").live("change",function(){
  var imgg = $("#im1_prod");
  var img_prev = $("#img_prev_prod");
  var fls = $("#file").val();
  var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
    alert("Formats allowed are : "+fileExtension.join(', '));
    $("#file").val('');
    return false;
    $(".dz-message").show();
  }
  if(fls!=""){
    $(img_prev).show();
    readURL(this, imgg);
    $("#img_prev_prod span").show();
    $("#ad_logo_check1_prod").val(1);
    $(".dz-message").hide();
  }else if(fls.length <= 1){
    $(imgg).hide();
    $(".dz-message").show();
  }
});



$("#txt_bma_pic").live("change",function(){
  var imgg = $("#im1_bma");
  var img_navigatn = $("#img_navigatn");
  var img_prev = $("#img_prev1_bma");
  var fls = $("#txt_bma_pic").val();

  var fileExtension = ['jpeg', 'jpg', 'png'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txt_bma_pic").val('');
  return false;
  }
  if(fls!=""){
    $(img_prev).show();
    readURL(this, imgg);
    readURL(this, img_navigatn);
    $("#ad_logo_check1_bma").val(1);
  }else if(fls.length <= 1){
    $(imgg).hide();
    $(img_navigatn).hide();
  }

  
});


$("#txtpics1").live("change",function(){
  var imgg = $("#im1_file");
  var img_prev = $("#img_prev1_file");
  var fls = $("#txtpics1").val();
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtpics1").val('');
  return false;
  }
  if(fls!=""){
  $(img_prev).show();
  readURL(this, imgg);
  //$("#img_prev1 span").show();
  $("#ad_logo_check1_bma").val(1);
  }else if(fls.length <= 1){
  $(imgg).hide();
  }
});


$("#txtpics2").live("change",function(){
  var imgg = $("#im1_file2");
  var img_prev = $("#img_prev1_file2");
  var fls = $("#txtpics2").val();
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtpics2").val('');
  return false;
  }
  if(fls!=""){
  $(img_prev).show();
  readURL(this, imgg);
  //$("#img_prev1 span").show();
  $("#ad_logo_check1_bma2").val(1);
  }else if(fls.length <= 1){
  $(imgg).hide();
  }
});


$("#txtpics3").live("change",function(){
  var imgg = $("#im1_file3");
  var img_prev = $("#img_prev1_file3");
  var fls = $("#txtpics3").val();
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtpics3").val('');
  return false;
  }
  if(fls!=""){
  $(img_prev).show();
  readURL(this, imgg);
  //$("#img_prev1 span").show();
  $("#ad_logo_check1_bma3").val(1);
  }else if(fls.length <= 1){
  $(imgg).hide();
  }
});


$("#txtlogo_up").live("change",function(){
  var imgg = $("#im1_up");
  var img_prev = $("#img_prev1_up");
  var fls = $("#txtlogo_up").val();
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtlogo_up").val('');
  return false;
  }
  if(fls!=""){
  $(img_prev).show();
  readURL(this, imgg);
  //$("#img_prev1 span").show();
  $("#ad_logo_check1_up").val(1);
  }else if(fls.length <= 1){
  $(imgg).hide();
  }
});



$("#files1").live("change",function(){
var imgg = $("#im1");
var img_prev = $("#img_prev1");
var fls = $("#files1").val();
var fileExtension = ['jpeg', 'jpg', 'png'];
if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
alert("Formats allowed are : "+fileExtension.join(', '));
$("#files1").val('');
return false;
}
if(fls!=""){
$(img_prev).show();
readURL(this, imgg);
//$("#img_prev1 span").show();
$("#ad_logo_check1").val(1);
}else if(fls.length <= 1){
$(imgg).hide();
}
});


$("#txtteampic").live("change",function(){
var ids = $(this).attr("ids");
var imgg = $(".im1_team"+ids);
var img_prev = $(".img_prev1"+ids);
var fls = $(".txtteampic"+ids).val();
//var filepix = path.split('\\').pop();
//$("#txtformer_pix"+ids).val(gggg);
var fileExtension = ['jpeg', 'jpg', 'png'];
if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
alert("Formats allowed are : "+fileExtension.join(', '));
$(".txtteampic"+ids).val('');
return false;
}
if(fls!=""){
$(img_prev).show();
readURL(this, imgg);
//$("#img_prev1 span").show();
$("#ad_logo_check1"+ids).val(1);
}else if(fls.length <= 1){
$(imgg).hide();
}
});



$("#txtlogo").live("change",function(){
var ids = $(this).attr("ids");
var imgg = $(".im1_team_"+ids);
var img_prev = $(".img_prev1_"+ids);
var fls = $(".txtlogo"+ids).val();
var fileExtension = ['jpeg', 'jpg', 'png'];
if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
alert("Formats allowed are : "+fileExtension.join(', '));
$(".txtlogo"+ids).val('');
return false;
}
if(fls!=""){
$(img_prev).show();
readURL(this, imgg);
$("#ad_logo_check1_"+ids).val(1);
}else if(fls.length <= 1){
$(imgg).hide();
}
});


var fileExtension = ['jpeg', 'jpg', 'png'];

$("#txt_img").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txt_img").val('');
  return false;
  }
});

var fileExtension = ['jpeg', 'jpg', 'png', 'doc', 'docx', 'pdf', 'txt', 'ppt', 'pptx'];

$("#txtm_cv").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtm_cv").val('');
  return false;
  }
});


$("#txtcompany_prof").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtcompany_prof").val('');
  return false;
  }
});

$("#txtmemo").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtmemo").val('');
  return false;
  }
});

$("#txtm_cac2").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtm_cac2").val('');
  return false;
  }
});

$("#txtm_cac7").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtm_cac7").val('');
  return false;
  }
});

$("#txtcopy_invoice").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtcopy_invoice").val('');
  return false;
  }
});

$("#txtcert_note").live("change",function(){
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  alert("Formats allowed are : "+fileExtension.join(', '));
  $("#txtcert_note").val('');
  return false;
  }
});






$('#sendmsg').live("click",function(e){
  e.preventDefault();
    $('#sendmsg').hide();
    $('#sendmsg1').show();
    $(".err_div_cnt").hide();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/send_all_mail",
      data: $("#form_fill_contact").serialize(),
      //cache : false,
      success : function(data){
        if(data=="email_sent_success"){
          $('#sendmsg').show();
          $('#sendmsg1').hide();
          $("#form_fill_contact")[0].reset();
          
          $(".form_contact").slideUp('fast');
          $(".form_suces_contact").slideDown('fast');
        
        }else{
          $('#sendmsg').show();
          $('#sendmsg1').hide();
          $(".err_div_cnt").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
        $('#sendmsg').show();
        $('#sendmsg1').hide();
        $(".err_div_cnt").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
    
});



$('.icon_question_alt').live("click",function(){
  $('.delivery_info').fadeToggle('fast');
});


$('.delivery_info').live("click",function(){
  $('.delivery_info').hide();
});


$('.credit_card').live("click",function(){
  $('.paystacks').slideDown('fast');
  $('.wire_transfer').slideUp('fast');
});


$('.click_transfers').live("click",function(){
  $('.paystacks').slideUp('fast');
  $('.wire_transfer').slideDown('fast');
});



$('.click_paystack1s').live("click",function(){
    $total_charge1 = $('#total_charge1').val();
    $email2 = $('#usr_email').val();
    $amt_entered = $('#amt_entered').val();
    $business_name = $('#business_name').val();
    $mobiles = $('#mobiles').val();

    $('.click_paystack1s').hide();
    $('.click_paystack1s1').show();

    

    var handler = PaystackPop.setup({
      key: 'pk_test_fae6cda6c4e45b8e0fe24e7740d6b39462c14a5f',
      email: $email2,
      amount: $total_charge1,
      ref: ''+Math.floor((Math.random() * 1000000000) + 1),
      firstname: $business_name,
      metadata: {
          custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: $mobiles
            }
          ]
      },
      callback: function(response){
        var datastring='transref='+response.reference
        +'&amounts='+$amt_entered;
        $.ajax({
          type: "POST",
          url : site_urls+"node/save_cart",
          data: datastring,
          cache: false,
          success: function(html){
            
            if(html.trim() == "cart_inserted"){
              window.location = site_urls+"success/";
            }else{
              alert(html);
            }
            $('.click_paystack1s').show();
            $('.click_paystack1s1').hide();
          },error : function(html){
            $('.click_paystack1s').show();
            $('.click_paystack1s1').hide();
            alert('Connection Error! Please check your connection.')
          }
        });
      },
      onClose: function(){
          $('.click_paystack1s').show();
          $('.click_paystack1s1').hide();
      }
    });
    handler.openIframe();
});




$('.link_success').live("click",function(){
  if(confirm("Clicking this button will assume a manual payment (either by transfer or cash on delivery) will be made.\r\nProceed to confirm your cart?")){
  $('.link_success').hide();
  $('.link_success1').show();
  
  var datastring='transref=mp';
  $.ajax({
    type: "POST",
    url : site_urls+"node/save_cart",
    data: datastring,
    cache: false,
    success: function(html){
      //alert(html);
      if(html.trim() == "cart_inserted"){
        //window.location = site_urls+"node/success/";
        window.location = site_urls+"success/";
      }else{
        alert(html);
      }
      $('.link_success').show();
      $('.link_success1').hide();
    }
  });
  }
});



$('.cmd_signin_adms').live("click",function(){
  $(".err_login").hide();
  $('.cmd_signin_adms').hide();
  $('.cmd_signin_adms1').show();
  var site_urls = $('#txtsite_url').val();
  //alert(site_urls);
  $.ajax({
    type : "POST",
    url : site_urls+"node/logme_adms",
    data: $("#form_logins").serialize(),
    //cache : false,
    success : function(data){
      //alert(data)
      if(data=="successor1"){
      $('.cmd_signin_adms').show();
      $('.cmd_signin_adms1').hide();
      setTimeout(function(){
        $(".err_login").fadeOut('slow');
      },2500);

      window.location = site_urls+"shield/";

      }else{
      $('.cmd_signin_adms').show();
      $('.cmd_signin_adms1').hide();
      $(".err_login").show().html('<div class="Errormsg">'+data+'</div>');
      }

    },error : function(data){
        $('.cmd_signin_adms').show();
        $('.cmd_signin_adms1').hide();
        $(".err_login").show().html('<div class="Errormsg">'+data+'</div>');
    }
  });
});



$('.cmd_checkout').live("click",function(){

    $('.cmd_checkout').hide();
    $('.cmd_checkout1').show();
    //$(".err_div_confirm").hide();
    
    //alert(site_urls)
    $.ajax({
      type : "POST",
      url : site_urls+"node/confirm_orders",
      data: $("#form_confirm").serialize(),
      //cache : false,
      success : function(data){

        if(data=="success4"){
          window.location = site_urls+"checkout/";
          $("#form_confirm")[0].reset();
          
        }else{
          
          $(".err_masks").show();
          setTimeout(function(){
            $(".err_div_confirm").fadeIn('fast').html('<div class="Errormsg"><p class="boldp" style="font-size:15px !important">Please take note of the following</p>'+data+'</div>');
          },300);
        }
        $('.cmd_checkout').show();
        $('.cmd_checkout1').hide();

      },error : function(data){
        $('.cmd_checkout').show();
        $('.cmd_checkout1').hide();
        $(".err_masks").show();
        setTimeout(function(){
          $(".err_div_confirm").fadeIn('fast').html('<div class="Errormsg">Poor Network Connection!</div>');
        },300);
      }
    });
});



$('.err_masks, .err_div_confirm').live("click",function(){
  $('.err_masks').hide();
  $('.err_div_confirm').hide();
});



$('#cmd_condt').live("click",function(){
  $('.s_prod').slideUp('fast');
  setTimeout(function(){
    $('.f_prod').slideDown('fast');
  },200);
});


$('.menu_icon img').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('#menu_menu1'+ids).slideToggle('fast');
});


$('.menu_icon1_view img').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('#menu_menu_cmt'+ids).slideToggle('fast');
});


$('.menu_icon_ img').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('.menu_menu1_'+ids).slideToggle('fast');
});



$('.s1').live("click",function(){
    $('.div_text_only').hide();
    $('.div_img_text').show();
    $('#txtimg_text').val(0);
    $('.show_big_text_input').val(1);
});


$('.s2').live("click",function(){
    $('.div_text_only').show();
    $('.div_img_text').hide();
    $('#txtimg_text').val(1);
    $('.show_big_text_input').val(1);
    $('.dz-message').html('Drop images/videos here to upload');
});


$('.s3').live("click",function(){
    $('.div_text_only').show();
    $('.div_img_text').hide();
    $('#txtimg_text').val(1);
    $('.show_big_text_input').val(1);
    $('.dz-message').html('Drop images/videos here to upload');
});


$('#txtopen1').live("click",function(){
    var txtful_url = $('#txtful_url').val();
    $('.masks').show();
    $('.big_text_input').show();
    $('#update_id').val(0);
    window.location = "#uploadad";
    $('.show_big_text_input').val(1);
    $('#txtopen1').focus();
});


$('#txtopen2').live("click",function(){
    $('.masks2').show();
    $('.big_text_input').show();
    $('#update_id').val(0);
    window.location = "#uploadad";
    $('.show_big_text_input').val(1);
    $('#txtopen2').focus();
});



$('.masks2').live("click",function(){
$('.big_text_input').hide();
setTimeout(function(){
  $('.masks').hide();
  $('.masks2').hide();
  $('#txtsell').val('');
  $('#txtprice').val('');
  $('.txtdescrip').val('');
  $('#txtcitys').get(0).selectedIndex = 0;
  $('#txtcatt1').get(0).selectedIndex = 0;
  Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
},200);
window.location = "#";
$('.show_big_text_input').val(0);
});


$('.masks').live("click",function(){
$('.big_text_input').hide();
setTimeout(function(){
  $('.masks').hide();
  $('.masks2').hide();
  $('#txtsell').val('');
  $('#txtprice').val('');
  $('.txtdescrip').val('');
  $('#txtcitys').get(0).selectedIndex = 0;
  $('#txtcatt1').get(0).selectedIndex = 0;
  Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
},200);
window.location = "#";
$('.show_big_text_input').val(0);
});


$('.err_div').live("click",function(){
  $('.err_div').hide();
});


$('#approve_expired').live("click",function(){
  alert('Campaign has expired');
});



$('#cmd_done_upload').live("click",function(){
  $('.second_create_form').hide();
  $('.third_create_form').fadeIn('fast');
  $("#create_evts")[0].reset();
  Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
});



$('.close_me').live("click",function(){
  var update_id = $('#update_id').val();
  
  var datastring='update_id='+update_id;
  $.ajax({
    type : "POST",
    url : site_urls+"node/cancel_post",
    data: datastring,
    //cache : false,
    success : function(html){
      //alert(html);
    }
  });
  $('.big_text_input').hide();
  setTimeout(function(){
    $('.masks').hide();
    $('.masks2').hide();
    $('.img_form').hide();
    $('.txt_form').show();
    $(".reg_form")[0].reset();
    $('#txtcatt1').get(0).selectedIndex = 0;
    Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
  },200);

});



// function copyToClipboard(element) {
//   var $temp = $("<input>");
//   $("body").append($temp);
//   $temp.val($(element).text()).select();
//   document.execCommand("copy");
//   $temp.remove();
// }


// $('#copyButton').live("click",function(){
//   $('.info_copied').hide();
//   copyToClipboard(document.getElementById("copyTarget"));
//   $('.info_copied').fadeIn('fast');
//   setTimeout(function(){
//     $('.info_copied').fadeOut('fast');
//   },2000);
// });



$('#chatss').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('.chatme_box'+ids).fadeToggle('fast');
});


$('#chatss_sec').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('.chatme_box_sec'+ids).fadeToggle('fast');
  $('.menu_menu').slideUp('fast');
  $('.menu_menu_txt').slideUp('fast');
});




$('.share_btns').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('.social_shares'+ids).slideToggle('fast');
});


$('.share_btns_adm').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('.social_shares_adm').slideToggle('fast');
});


$('.share_btns1').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('#social_shares1'+ids).slideToggle('fast');
});


$('#share_btns1_').live("click",function(e){
  var ids = $(this).attr("ids");
  e.stopPropagation();
  $('.social_shares1_'+ids).slideToggle('fast');
});






$('.close_me1').live("click",function(){
  var update_id = $('#update_id').val();
  
  var datastring='update_id='+update_id;
  $.ajax({
    type : "POST",
    url : site_urls+"node/cancel_post",
    data: datastring,
    //cache : false,
    success : function(html){
      //alert(html);
    }
  });
  $('.big_text_input').hide();
  setTimeout(function(){
    $('.masks2').hide();
    $('.masks').hide();
    $('.img_form').hide();
    $('.txt_form').show();
    //$('#txtcountries').get(0).selectedIndex = 0;
    //$('#txtstates1').get(0).selectedIndex = 0;
    $('#txtcitys').get(0).selectedIndex = 0;
    $(".reg_form")[0].reset();
    Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
  },200);

});



$('.manual_tran').live("click",function(){
  $('.online_div').slideUp('fast');
  setTimeout(function(){
    $('.manual_div').slideToggle('fast');
  },100);
});

$('.online_pay').live("click",function(){
  $('.manual_div').slideUp('fast');
  setTimeout(function(){
    $('.online_div').slideToggle('fast');
  },100);
});



$('.cmd_donate').live("click",function(){
  var txtamts = $('#txtamts').val();
  $(".alert_error").hide();
  if(txtamts==""){
    $(".alert_error").show().html('<div class="Errormsg" style="margin:-20px 0 10px 0; clear:both;">Please select the amount you wish to donate.</div>');
  }else{
    $(".div_donate1").hide();
    $(".div_donate2").fadeIn('fast');
    $(".history_amt").html(addCommas(txtamts));
  }
});



$('#remove_pic').live("click",function(){
  var ids = $(this).attr("ids");
  var datastring='prodid='+ids;
  $('.remove_pic'+ids).html('Removing...');
    $.ajax({
      type : "POST",
      url : site_urls+"node/remove_pics",
      data: datastring,
      success : function(data){
        if(data=="deleted"){
          $('.house_rem'+ids).hide();
        }
      },error : function(data){
        $(".err_div").show().html('<div class="Errormsg">Poor Network Connection, Try again later!</div>');
      }
    });
});



$('.cmddones').live("click",function(){
  
  var datastring='sessions=resets';
  $('.cmddones').hide();
  $('.cmddones1').show();

  setTimeout(function(){
    $('.cmddones').show();
    $('.cmddones1').hide();
    $('.big_text_input').hide();
    $('.masks').hide();
    $('.masks2').hide();
    $('.img_form').hide();
    $('.txt_form').show();
    $('#txtcitys').get(0).selectedIndex = 0;
    $(".reg_form")[0].reset();
    Dropzone.forElement("#myAwesomeDropzone").removeAllFiles(true);
    //bringProducts();
  },500);

  $.ajax({
    type : "POST",
    url : site_urls+"node/reset_session",
    data: datastring,
    //cache : false,
    success : function(html){
      $('.cmddones').show();
      $('.cmddones1').hide();
    },error : function(html){
      alert('Connection Error!');
      $('.cmddones').show();
      $('.cmddones1').hide();
    }
  });  
});



$('.cmd_donate_s').live("click",function(){
  $('.cmd_donate_s').hide();
  $('.cmd_donate_s1').show();

  $(".alert_error").hide();
  $.ajax({
    type : "POST",
    url : site_urls+"node/save_donate_vals",
    data: $(".donate_form").serialize(),
    //cache : false,
    success : function(data){
      if(data=="validateds"){
        $('.cmd_donate_s').show();
        $('.cmd_donate_s1').hide();
        $('.div_donate2').hide();
        $('.div_donate3').fadeIn('fast');
        
      }else{
        $('.cmd_donate_s').show();
        $('.cmd_donate_s1').hide();
        $(".alert_error").show().html('<div class="Errormsg" style="margin:-20px 0 10px 0; clear:both;">'+data+'</div>');
        setTimeout(function(){
          $('.alert_error').hide();
        },3000);
      }

      },error : function(data){
      $('.cmd_donate_s').show();
      $('.cmd_donate_s1').hide();
      //$(".alert_error").show().html('<div class="Errormsg">Poor Network Connection or you have entered or pasted some invalid characters!<br>Try again.</div>');
      setTimeout(function(){
        $('.alert_error').hide();
      },3000);
    }
  });
});


$('.cmd_pay_manual').live("click",function(){
  if(confirm('Proceed to continue?')){
    $('.cmd_pay_manual').hide();
    $('.cmd_pay_manual1').show();
    $(".alert_error").hide();
    $.ajax({
      type : "POST",
      url : site_urls+"node/save_donate_vals1",
      data: $(".donate_form").serialize(),
      //cache : false,
      success : function(data){
        if(data=="inserted"){
          $('.cmd_pay_manual').show();
          $('.cmd_pay_manual1').hide();
          $('.writeup').hide();
          $('.div_donate3').hide();
          $('.div_donate4').fadeIn('fast');
          $(".donate_form")[0].reset();
          
        }else{
          $('.cmd_pay_manual').show();
          $('.cmd_pay_manual1').hide();
          $(".alert_error").show().html('<div class="Errormsg" style="margin:-20px 0 10px 0; clear:both;">'+data+'</div>');
          setTimeout(function(){
            $('.alert_error').hide();
          },3000);
        }

        },error : function(data){
        $('.cmd_pay_manual').show();
        $('.cmd_pay_manual1').hide();
        //$(".alert_error").show().html('<div class="Errormsg">Poor Network Connection or you have entered or pasted some invalid characters!<br>Try again.</div>');
        setTimeout(function(){
          $('.alert_error').hide();
        },3000);
      }
    });
  }
});


$('.cmd_pay_online').live("click",function(){
  alert('Under Construction, will soon be available. Please use the manual transfer method.');
});


$('.close_pay_div').live("click",function(){
  $('.div_donate4').hide();
  $('.writeup').fadeIn('fast');
  $('.div_donate1').fadeIn('fast');
});



$('.cmdnexts').live("click",function(){
  var txtcitys = $('#txtcitys').val();
  var txtprice = $('#txtprice').val();
  var txtcomm = $('#txtcomm').val();

  if(txtprice <= 0 && (txtcomm > 0 || txtcomm!="")){
    $(".err_div").show().html('<div class="Errormsg">If price is Free, no commission should be entered.</div>');
    $('#txtcomm').val('');
    $('#txtcomm').focus();
  
  }else if(txtcitys == null || txtcitys == ""){
    if(confirm('City is not selected, click OK to continue?')){
      $('.cmdnexts').hide();
      $('.cmdnexts1').show();
      $(".err_div").hide();
      
      var txtimg_text = $('#txtimg_text').val();
      var txtcitys = $('#txtcitys').val();
      $('.txt_form :input').css('opacitys','0.5');
      $('.txt_form :input').css('background','#eee');
      $.ajax({
        type : "POST",
        url : site_urls+"node/save_bma_items",
        data: $(".reg_form").serialize(),
        //cache : false,
        success : function(data){
          //alert(data)
          if(data=="inserted"){
            $('.cmdnexts').show();
            $('.cmdnexts1').hide();
            $('.txt_form').hide();
            $('.img_form').show();
            $('.txt_form :input').css('opacity','1');
            $('.txt_form :input').css('background','#fff');
            $('.cmdnexts, .cmdnexts1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
            
          }else{
            $('.cmdnexts').show();
            $('.cmdnexts1').hide();
            $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
            $('.txt_form :input').css('opacity','1');
            $('.txt_form :input').css('background','#fff');
            $('.cmdnexts, .cmdnexts1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
            setTimeout(function(){
              $('.err_div').hide();
            },3000);
          }

        },error : function(data){
          $('.cmdnexts').show();
          $('.cmdnexts1').hide();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection or you have entered or pasted some invalid characters!<br>Try again.</div>');
          $('.txt_form :input').css('opacity','1');
          $('.txt_form :input').css('background','#fff');
          $('.cmdnexts, .cmdnexts1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
          setTimeout(function(){
            $('.err_div').hide();
          },3000);
        }
      });
    }

  
  }else{ // if not null

    $('.cmdnexts').hide();
    $('.cmdnexts1').show();
    $(".err_div").hide();
    
    var txtimg_text = $('#txtimg_text').val();
    var txtcitys = $('#txtcitys').val();
    $('.txt_form :input').css('opacity','0.5');
    $('.txt_form :input').css('background','#eee');

    $.ajax({
      type : "POST",
      url : site_urls+"node/save_bma_items",
      data: $(".reg_form").serialize(),
      //cache : false,
      success : function(data){
        if(data=="inserted"){
          $('.cmdnexts').show();
          $('.cmdnexts1').hide();
          $('.txt_form').hide();
          $('.img_form').show();
          $('.txt_form :input').css('opacity','1');
          $('.txt_form :input').css('background','#fff');
          $('.cmdnexts, .cmdnexts1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
        }else{
          $('.cmdnexts').show();
          $('.cmdnexts1').hide();
          $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
          $('.txt_form :input').css('opacity','1');
          $('.txt_form :input').css('background','#fff');
          $('.cmdnexts, .cmdnexts1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
          setTimeout(function(){
            $('.err_div').hide();
          },3000);
        }

        },error : function(data){
        $('.cmdnexts').show();
        $('.cmdnexts1').hide();
        $(".err_div").show().html('<div class="Errormsg">Poor Network Connection or you have entered or pasted some invalid characters!<br>Try again.</div>');
        $('.txt_form :input').css('opacity','1');
        $('.txt_form :input').css('background','#fff');
        $('.cmdnexts, .cmdnexts1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
        setTimeout(function(){
          $('.err_div').hide();
        },3000);
      }
    });
  }
});




$('.cmdnexts_inner').live("click",function(){
  var txtcitys = $('#txtcitys').val();
  
    if(txtcitys == null || txtcitys == ""){
      if(confirm('City is not selected, click OK to continue?')){
        $('.cmdnexts_inner').hide();
        $('.cmdnexts_inner1').show();
        $(".err_div").hide();
        
        var txtimg_text = $('#txtimg_text').val();
        var txtcitys = $('#txtcitys').val();
        $('.txt_form :input').css('opacity','0.5');
        $('.txt_form :input').css('background','#eee');
        $.ajax({
          type : "POST",
          url : site_urls+"node/save_bma_items",
          data: $(".reg_form").serialize(),
          //cache : false,
          success : function(data){
            //alert(data)
            if(data=="inserted"){
              $('.cmdnexts_inner').show();
              $('.cmdnexts_inner1').hide();
              $('.txt_form').hide();
              $('.img_form').show();
              $('.txt_form :input').css('opacity','1');
              $('.txt_form :input').css('background','#fff');
              $('.cmdnexts_inner, .cmdnexts_inner1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
              
            }else{
              $('.cmdnexts_inner').show();
              $('.cmdnexts_inner1').hide();
              $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
              $('.txt_form :input').css('opacity','1');
              $('.txt_form :input').css('background','#fff');
              $('.cmdnexts_inner, .cmdnexts_inner1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
              setTimeout(function(){
                $('.err_div').hide();
              },3000);
            }

          },error : function(data){
            $('.cmdnexts_inner').show();
            $('.cmdnexts_inner1').hide();
            $(".err_div").show().html('<div class="Errormsg">Poor Network Connection or you have entered or pasted some invalid characters!<br>Try again.</div>');
            $('.txt_form :input').css('opacity','1');
            $('.txt_form :input').css('background','#fff');
            $('.cmdnexts_inner, .cmdnexts_inner1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
            setTimeout(function(){
              $('.err_div').hide();
            },3000);
          }
        });
      }

    
    }else{ // if not null

      $('.cmdnexts_inner').hide();
      $('.cmdnexts_inner1').show();
      $(".err_div").hide();
      
      var txtimg_text = $('#txtimg_text').val();
      var txtcitys = $('#txtcitys').val();
      $('.txt_form :input').css('opacity','0.5');
      $('.txt_form :input').css('background','#eee');

      $.ajax({
        type : "POST",
        url : site_urls+"node/save_bma_items",
        data: $(".reg_form").serialize(),
        //cache : false,
        success : function(data){
          if(data=="inserted"){
            $('.cmdnexts_inner').show();
            $('.cmdnexts_inner1').hide();
            $('.txt_form').hide();
            $('.img_form').show();
            $('.txt_form :input').css('opacity','1');
            $('.txt_form :input').css('background','#fff');
            $('.cmdnexts_inner, .cmdnexts_inner1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
          }else{
            $('.cmdnexts_inner').show();
            $('.cmdnexts_inner1').hide();
            $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
            $('.txt_form :input').css('opacity','1');
            $('.txt_form :input').css('background','#fff');
            $('.cmdnexts_inner, .cmdnexts_inner1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
            setTimeout(function(){
              $('.err_div').hide();
            },3000);
          }

          },error : function(data){
          $('.cmdnexts_inner').show();
          $('.cmdnexts_inner1').hide();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection or you have entered or pasted some invalid characters!<br>Try again.</div>');
          $('.txt_form :input').css('opacity','1');
          $('.txt_form :input').css('background','#fff');
          $('.cmdnexts_inner, .cmdnexts_inner1').css('background','linear-gradient(rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7))');
          setTimeout(function(){
            $('.err_div').hide();
          },3000);
        }
      });
    }
});



$('.getithere').live("click",function(){
  $('.acct_details').slideToggle('fast');
});

$('.acct_details').live("click",function(){
  $('.acct_details').slideToggle('fast');
});


$('#cmd_goto_firstform').live("click",function(){
  $('.third_create_form').hide();
  $('.first_create_form').fadeIn('fast');
});


$('#comms').live("click",function(){
  var ids = $(this).attr("ids");
  $('.open_refer_info'+ids).fadeToggle('fast');
});


$('#open_refer_info').live("click",function(e){
  var ids = $(this).attr("ids");
  //e.stopPropagation();
  $('.open_refer_info'+ids).fadeToggle('fast');
});


$('#comms1, .comms').live("click",function(){
  var ids = $(this).attr("ids");
  $('.open_refer_info1'+ids).fadeToggle('fast');
});

$('#open_refer_info1').live("click",function(e){
  var ids = $(this).attr("ids");
  //e.stopPropagation();
  $('.open_refer_info1'+ids).fadeToggle('fast');
});



$('.close_score_dv').live("click",function(e){
  $('#txtscores').val('');
  $('.div_enter_score').fadeOut('fast');
});


$('.scores1').live("click",function(e){
  var ids = $(this).attr("ids");
  var conts = $(this).attr("conts");
  var judge = $(this).attr("judge");
  var contestant = $(this).attr("contestant");
  $('.div_enter_score').fadeIn('fast');
  $('.score_info').html("You are about to enter a score as "+judge+" for "+contestant);
  $('#txtids').val(ids);
  $('#judges').val(judge);
  $('#txtconts1').val(conts);
});

$('.scores2').live("click",function(e){
  var ids = $(this).attr("ids");
  var conts = $(this).attr("conts");
  var judge = $(this).attr("judge");
  var contestant = $(this).attr("contestant");
  $('.div_enter_score').fadeIn('fast');
  $('.score_info').html("You are about to enter a score as "+judge+" for "+contestant);
  $('#txtids').val(ids);
  $('#judges').val(judge);
  $('#txtconts1').val(conts);
});

$('.scores3').live("click",function(e){
  var ids = $(this).attr("ids");
  var conts = $(this).attr("conts");
  var judge = $(this).attr("judge");
  var contestant = $(this).attr("contestant");
  $('.div_enter_score').fadeIn('fast');
  $('.score_info').html("You are about to enter a score as "+judge+" for "+contestant);
  $('#txtids').val(ids);
  $('#judges').val(judge);
  $('#txtconts1').val(conts);
});



$('#cmd_goto_first').live("click",function(){
  $('.sec_upload_form').hide();
  $('.first_upload_form').show();
});



$('#cmd_save_score').live("click",function(){
  var txtscores = $('#txtscores').val();
  var txtids = $('#txtids').val();
  var conts = $('#txtconts1').val();
  var judges = $('#judges').val();
  var incr = 0;
  if(judges=="Judge 1") var incr = 1;
  if(judges=="Judge 2") var incr = 2;
  if(judges=="Judge 3") var incr = 3;
  
  if(txtscores=="")
    alert('Please enter a score');

  else if(txtscores>100)
    alert('Please enter a score between 1 and 100');

  else if(!$.isNumeric(txtscores))
    alert('Please enter a number between 1 and 100');

  else{
      if(confirm('Entering scores cannot later be changed, continue?')){
      $('#cmd_save_score').hide();
      $('#cmd_save_score1').show();

      var datastring='txtscores='+txtscores
      +'&judges='+judges
      +'&txtids='+txtids;

      $.ajax({
          type : "POST",
          url : site_urls+"node/update_scores",
          data: datastring,
          // data: {
          //     ssd: "yes",
          //     data: $(".form_enter_scr").serialize()+datastring
          // },
          //cache : false,
          success : function(data){
          if(data=="updated"){
            $('#cmd_save_score1').show();
            $('#cmd_save_score').hide();
            $(".err_div").show().html('<div class="successmsg" style="margin:-5px; 0 -10px 0;">Successfully Saved!</div>');
            $("#scores"+incr+txtids+conts).hide();
            $(".scores"+incr+txtids+conts).show();
            $(".myscore"+incr+txtids+conts).html(txtscores);
            $('#txtscores').val('');

            setTimeout(function(){
              $('.err_div').fadeOut('fast');
              $('.div_enter_score').fadeOut('fast');
            },2300);

          }else{
            $('#cmd_save_score').show();
            $('#cmd_save_score1').hide();
            //alert(data);
            $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
          }
          },error : function(data){
          $('#cmd_save_score').show();
          $('#cmd_save_score1').hide();
          }
      });
      }
  }
  });


  
  $('#txtmedia').live("change",function(){
    var txtmedia = $(this).val();
    if(txtmedia=="pic"){
      $('.for_vids').hide();
      $('.for_photos').show();
      $('#file_photo').val('');
    }else{
      $('#txtutube').val('');
      $('.for_vids').show();
      $('.for_photos').hide();
    }
  });


  
  $('#cmd_computes').live("click",function(){
    if(confirm('Computing the winners might take a while, do you wish to continue?')){
      $('#cmd_computes').hide();
      $('#cmd_computes1').show();

      $.ajax({
          type : "POST",
          url : site_urls+"node/compute_winners",
          //data: datastring,
          //cache : false,
          success : function(data){
            //alert(data)
            if(data==1){
              $('#cmd_computes2').show();
              $('#cmd_computes').hide();
              $('#cmd_computes1').hide();
              $('.show_info').show();
              dataTable.clear().draw();
              dataTable.rows.add(NewlyCreatedData);
              dataTable.columns.adjust().draw();

            }else if(data==2){
              $('#cmd_computes').show();
              $('#cmd_computes1').hide();
              alert('One of the judges hasn\'t entered thier scores');

            }else if(data==4){
              $('#cmd_computes').show();
              $('#cmd_computes1').hide();
              alert('Nothing to compute!');

            }else{
              $('#cmd_computes').show();
              $('#cmd_computes1').hide();
              alert('This activity hasn\'t expired yet, please wait till it expires.');
            }
          },error : function(data){
          $('#cmd_computes').show();
          $('#cmd_computes1').hide();
          //alert(data);
          }
      });
      }
  });

  
  $('.navbar_toggle').live("click",function(){
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });


  $('.approve_winners').live("click",function(){
    if(confirm('Approving all the current winners might take a while, do you wish to continue?')){
      $('.approve_winners').hide();
      $('.approve_winners1').show();
      $.ajax({
          type : "POST",
          url : site_urls+"node/approve_winners1",
          //cache : false,
          success : function(data){
            if(data=="approved"){
              $('.approve_winners').show();
              $('.approve_winners1').hide();
              $('#cmd_computes2').show();
              $('#cmd_computes1').hide();
              $('#cmd_computes').hide();

              $('.show_info').hide();
              dataTable.clear().draw();
              dataTable.rows.add(NewlyCreatedData);
              dataTable.columns.adjust().draw();

            }else{
              $('.approve_winners').show();
              $('.approve_winners1').hide();
              alert('Not Approved');
            }
          },error : function(data){
          $('.approve_winners').show();
          $('.approve_winners1').hide();
          }
      });
      }
  });



$('.submit_form').live("click",function(){
    $('.submit_form').hide();
    $('.submit_form1').show();
    $(".err_div").hide();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/reg_members",
      data: $(".reg_form").serialize(),
      //cache : false,
      success : function(data){
        if(data=="proceed1"){
          $('.submit_form').show();
          $('.submit_form1').hide();
          $('.ist_form').hide();
          $('.secs_form').fadeIn('fast');

        }else{
          $('.submit_form').show();
          $('.submit_form1').hide();
          $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
        }
      },error : function(data){
        $('.submit_form').show();
        $('.submit_form1').hide();
        $(".err_div").show().html('<div class="Errormsg">Poor Network Connection, Try again later!</div>');
      }
    });
    setTimeout(function(){
      $('.err_div').fadeOut('fast');
    },4000);
});


$('.clicksearch').live("click",function(){
  $('.bring_search').fadeToggle('fast');
  $('.navs2 .hide_lnks').hide();
  $('.txtsrchs1').focus();
});



$('.view_formats').live("click",function(){
  $('.bold_info1').fadeToggle('fast');
});


$('#post_content').live("click",function(){
  $('.bold_info1').slideUp('fast');
});


$('.close-search').live("click",function(){
  $('.bring_search').fadeToggle('fast');
  $('.navs2 .hide_lnks').show();
});


$('.featured-area, .penci_sidebar, .navigation1, .big_text_input, .header_titles1').live("click",function(){
  $('.bring_search').hide();
  $('.navs2 .hide_lnks').show();
});




$('#load_more_mba').live("click",function(){
	var page = $(this).data('val');
  var tasks = $(".tasks").val();
	var unread = $(".unread").val();
  var txt_bma_id1 = $('#txt_bma_id').val();
  create_cookie('page_load', page);

  var txt_srch = retrieve_cookie('txt_srch');
  if(txt_srch=="" || txt_srch=="undefined") var txt_srch = "";

  $('#load_more_mba').hide();
  $('#load_more_mba1').show();
	var datastring='page='+page
  +'&tasks='+tasks
  +'&txt_srch='+txt_srch
	+'&unread='+unread
  +'&txt_bma_id1='+txt_bma_id1;
  //alert(datastring);
  
	$.ajax({
		type : "POST",
		url : site_urls+"node/getProducts",
		data : datastring,
		//cache : false,
		success : function(data){
      var responseReturn = data.match(/Save Ad/g);
      if(responseReturn != null){
        $("#ajax_table_bma").append(data);
        //$("#loader").hide();
        $('.load_more_bt').data('val', ($('.load_more_bt').data('val')+1));
        $('#load_more_mba').show();
        $('#load_more_mba1').hide();
      }else{
        $('#load_more_mba').hide();
        $('#load_more_mba1').show();
        $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more threads!</font>');
      }

		},error : function(data){
		  $('#load_more_mba').show();
      $('#load_more_mba1').hide();
		}
	});
  });
  


  function refrest_cmts(){
    //var datastring1='fst_cmt='+$fst_cmt;
    $.ajax({
      type : "POST",
      url : site_urls+"node/get_refresh_cmts",
      data : datastring1,
      //cache : false,
      success : function(data){
        //alert(data)
        $('.fetch_cmts_all').html(data);
      }
      
    });
  }




$(document).ready(function(){

  
});


  $('.menu_icon1 img, .menu_icon1_txt img, .menu_icon1_view img, .menu_icon1_view_comment img').live("click",function(e){
    var ids = $(this).attr("ids");
    e.stopPropagation();
    $('#menu_menu'+ids).slideToggle('fast');
    $('#menu_menu_cmt'+ids).slideToggle('fast');
    $('#menu_menu_txt'+ids).slideToggle('fast');
    $('.chatme_box_sec'+ids).slideUp('fast');
  });

  


  $(".cmd_remove_adm").live("click",function(){
    var txtall_id = $("#txtall_id").val();
    var txt_dbase_table = $("#txt_dbase_table").val();

    if(txt_dbase_table == "view_activities"){
    
      if(confirm('Deleting this main activity will delete all its associated contents and cannot be undone, continue?')){
        $(".cmd_remove_adm").hide();
        $(".cmd_remove_adm1").show();
        
        var datastring='txtall_id='+txtall_id
        +'&txt_dbase_table='+txt_dbase_table;
        $.ajax({
          type: "POST",
          url : site_urls+"node/delete_records",
          data: datastring,
          cache: false,
          success: function(html){
            if(html=="deleted"){
              $(".cmd_remove_adm").show();
              $(".cmd_remove_adm1").hide();
              $('.cmd_close_del').click();
              
              dataTable.clear().draw();
              dataTable.rows.add(NewlyCreatedData);
              dataTable.columns.adjust().draw();
            }else{
              alert('Error in deleting data!');
              $(".cmd_remove_adm").show();
              $(".cmd_remove_adm1").hide();
            }
          
          },error : function(html){
            alert('Error! Network Connection Failed!');
            $(".cmd_remove_adm").show();
            $(".cmd_remove_adm1").hide();
          }
        });
      }
    }else{
      
        $(".cmd_remove_adm").hide();
        $(".cmd_remove_adm1").show();
        
        var datastring='txtall_id='+txtall_id
        +'&txt_dbase_table='+txt_dbase_table;

        $.ajax({
          type: "POST",
          url : site_urls+"node/delete_records",
          data: datastring,
          cache: false,
          success: function(html){
            $(".cmd_remove_adm").show();
            $(".cmd_remove_adm1").hide();
            $('.cmd_close_del').click();
            
            dataTable.clear().draw();
            dataTable.rows.add(NewlyCreatedData);
            dataTable.columns.adjust().draw();
          
          },error : function(html){
            alert('Error! Network Connection Failed!');
            $(".cmd_remove_adm").show();
            $(".cmd_remove_adm1").hide();
          }
        });
      //}
    }
  });
    
  
  

  



  $('.menu_menu, .menu_menu_cmt, .menu_menu_txt, .menus_, .social2, .social_shares1, .share_header, .chatme_box1, #chatme_box_sec2, #chatme_box_sec1, #chatme_box_sec, .chatme_boxx, .pay_to_company, .accts, .frm_reg_buyer, .frm_log_buyer, .hidden_ref_info, #country_list_id').live("click",function(e){
      e.stopPropagation();
  });
  

  $(document).on("click", function () {
    $('.menu_menu').hide();
    $('.menu_menu_cmt').hide();
    $('.menu_menu_txt').hide();
    $('.menus_').hide();
    $('.payment_type').slideUp('fast');
    $('.frm_reg_buyer').slideUp('fast');
    $('.frm_log_buyer').slideUp('fast');
    $('.social2').hide();
    //$('.musltiple_emails-ul').hide();
    $('.social_shares1').hide();
    $('.share_header').hide();
    $('#chatme_box_sec2').hide();
    $('#chatme_box_sec1').hide();
    $('#chatme_box_sec').hide();
    $('.chatme_box1').hide();
    $('.chatme_boxx').hide();
    $('.menu_menu1_head').hide();
    $('.submenus').slideUp('fast');
    $('.hidden_ref_info').slideUp('fast');
    $('#country_list_id').hide();
    if($(window).width()<760)
      $(".mobile_cats").animate({height:'65'});

    $('.edit_div').slideUp('fast');
    $('.edit_div1').slideUp('fast');

    $('.prev_quest_div').slideUp('fast');
    $('.write_quest_div').slideDown('fast');
    
    $('.copy_text').hide();
    $('.copy_texts').hide();
    $('.cover_contents').fadeOut('fast');
    $('.cover_contents1').fadeOut('fast');
  });



$('#cmd_submit_mail').live("click",function(e){
  e.preventDefault();

    $('#cmd_submit_mail').hide();
    $('#cmd_submit_mail1').show();
    $(".err_div").hide();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/submit_mail",
      data: $(".newsletter").serialize(),
      //cache : false,
      success : function(data){

        if(data=="successor_email"){
          $('#cmd_submit_mail').show();
          $('#cmd_submit_mail1').hide();
          
          $(".err_div").show().html('<div class="successmsg">Message Successfully Sent!</div>');
          $("#txtnewsmail").val('');
          
          setTimeout(function(){
          $(".err_div").hide();
          },2500);
        
        }else{
          $('#cmd_submit_mail').show();
          $('#cmd_submit_mail1').hide();
          $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
        $('#cmd_submit_mail').show();
        $('#cmd_submit_mail1').hide();
        $(".err_div").show().html('<div class="Errormsg">Poor Network Connection, Try again later!</div>');
      }
    });
});



$('.editcmts').live("click",function(e){
  e.stopPropagation();
  var cmtid = $(this).attr('ids');
  //alert(cmtid)
  $('#menu_menu_cmt'+cmtid).slideUp('fast');
  $('#edit_section'+cmtid).slideDown('fast');
});


$('#cmd_edit_cmt_').live("click",function(e){
  e.stopPropagation();
  var cmtid = $(this).attr('ids');
  //$('#menu_menu_cmt'+cmtid).slideDown('fast');
  $('#edit_section'+cmtid).slideUp('fast');
});



$('#cmd_edit_cmt').live("click",function(e){
    e.stopPropagation();
    var cmtid = $(this).attr("ids");
    $txtcmt_edit = $('.txtcmt_edit'+cmtid).val();
    if($txtcmt_edit != ""){
      $('.cmd_edit_cmt'+cmtid).hide();
      $('.cmd_edit_cmt1'+cmtid).show();
      
      var datastring='cmtid='+cmtid
      +'&txtcmt_edit='+$txtcmt_edit;

      $.ajax({
        type : "POST",
        url : site_urls+"node/edit_comment",
        data: datastring,
        //cache : false,
        success : function(data){
          //alert(data)
          if(data=="updated"){
            $('.cmd_edit_cmt'+cmtid).show();
            $('.cmd_edit_cmt1'+cmtid).hide();
            $('#chats1'+cmtid).html($txtcmt_edit);
            $('#edit_section'+cmtid).slideUp('fast');
            
          }else{
            $('.cmd_edit_cmt'+cmtid).show();
            $('.cmd_edit_cmt1'+cmtid).hide();
            alert('Error in updating comment, please try again!');
          }

        },error : function(data){
          $('.cmd_edit_cmt'+cmtid).show();
          $('.cmd_edit_cmt1'+cmtid).hide();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection, Try again later!</div>');
        }
      });
    }
});



$('.txt_srch_forums').live("click",function(e){
  e.stopPropagation();
  if($(window).width()<760)
  $(".mobile_cats").animate({height:'270'})
});

$('.mini_div').live("click",function(e){
  e.stopPropagation();
  if($(window).width()<760)
  $(".mobile_cats").animate({height:'65'});
});



$('.deletecmts').live("click",function(e){
    e.stopPropagation();
    var cmtid = $(this).attr("ids1");
    var admcode = $(this).attr("admcode");
    if(admcode=="002")
      $parseQuery = "delete_comment_adm";
    else
      $parseQuery = "delete_comment";

  if(confirm('Proceed to delete this comment?')){
    $('#deletecmts'+cmtid).hide();
    $('.deletecmts1'+cmtid).show();
    
    var datastring='cmtid='+cmtid;

    $.ajax({
      type : "POST",
      url : site_urls+"node/"+$parseQuery,
      data: datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="deletss"){
          $('#deletecmts'+cmtid).show();
          $('.deletecmts1'+cmtid).hide();
          $('.commenters1'+cmtid).slideUp('fast');
          
        }else{
          $('#deletecmts'+cmtid).show();
          $('.deletecmts1'+cmtid).hide();
          alert('Error in deleting comment, please try again!');
        }

      },error : function(data){
        $('#deletecmts'+cmtid).show();
        $('.deletecmts1'+cmtid).hide();
        $(".err_div").show().html('<div class="Errormsg">Poor Network Connection, Try again later!</div>');
      }
    });
    
  }

});



$('#cmd_subm_business').live("click",function(e){
  e.preventDefault();

    $(".err_div").hide();
    $('#cmd_subm_business').hide();
    $('#cmd_subm_business1').show();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/business1",
      data: $("#form_business").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="confirmed_business"){
        $('#cmd_subm_business').show();
        $('#cmd_subm_business1').hide();

        window.location = site_urls+"node/continue_registration/";
        

        setTimeout(function(){
          $(".err_div").hide();
        },2500);

        }else{
        $('#cmd_subm_business').show();
        $('#cmd_subm_business1').hide();
        $(".err_div").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
          $('#cmd_subm_business').show();
          $('#cmd_subm_business1').hide();
          $(".err_div").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.link_shop').live("click",function(){
   $('.srch_info').html('Enter any store and select from the pop out lists of stores.');
   $('.search-query').attr("placeholder", "Browse for stores near you...");
   //$(".link_shop").css('border','6px solid #0C3');
   $('.link_shop').css({'border':'5px solid #0C3', 'opacity':'1', 'height':'125px', 'width':'125px', 'margin-top':'-5px'});
   $('.link_address').css({'border':'3px solid #333', 'opacity':'0.8', 'height':'115px', 'width':'115px', 'margin-top':'0px'});
   $('.search_type').val('shop');
});

$('.link_address').live("click",function(){
   $('.srch_info').html('Enter address to find possible stores near you...');
   $('.search-query').attr("placeholder", "Search by location...");
   $('.link_address').css({'border':'5px solid #0C3', 'opacity':'1', 'height':'125px', 'width':'125px', 'margin-top':'-5px'});
   $('.link_shop').css({'border':'3px solid #333', 'opacity':'0.8', 'height':'115px', 'width':'115px', 'margin-top':'0px'});
   $('.search_type').val('addr');
});



$('.lists1 .link_shop').live("click",function(){
   $('.lists1 .lists1 .srch_info').html('Enter any store and select from the pop out lists of stores.');
   $('.lists1 .lists1 .search-query').attr("placeholder", "Browse for stores near you...");
   $('.lists1 .link_shop').css({'border':'4px solid #0C3', 'opacity':'1', 'height':'65px', 'width':'65px', 'margin-top':'0px'});
   $('.lists1 .link_address').css({'border':'2px solid #333', 'opacity':'0.8', 'height':'55px', 'width':'55px', 'margin-top':'0px'});
   $('.search_type').val('shop');
});

$('.lists1 .link_address').live("click",function(){
   $('.lists1 .srch_info').html('Enter address to find possible stores near you...');
   $('.lists1 .search-query').attr("placeholder", "Search by location...");
   $('.lists1 .link_address').css({'border':'4px solid #0C3', 'opacity':'1', 'height':'65px', 'width':'65px', 'margin-top':'0px'});
   $('.lists1 .link_shop').css({'border':'2px solid #333', 'opacity':'0.8', 'height':'55px', 'width':'55px', 'margin-top':'0px'});
   $('.search_type').val('addr');
});



$('.remove_item').live("click",function(){
  var names = $(this).attr("names");
  if(confirm('Proceed to remove '+names+' from your list')){
  //if(confirm('Proceed to remove this product from your list')){
    var ids = $(this).attr("ids");
    var pagename = $(this).attr("pagename");

    
    var datastring='rowids='+ids
    +'&pagename='+pagename;
    
    $('.refresh_table').css('opacity', '0.4');
    $('.loadings').show().html("<p style='text-align:center'><img src='"+site_urls+"img/loaderq.gif'></p>");
    $.ajax({
      type : "POST",
      url : site_urls+"node/remove_from_cart",
      data: datastring,
      //cache : false,
      success : function(html){

        setTimeout(function(){
          $('.refresh_table').css('opacity', '1');
          $('.loadings').hide();
          $('.refresh_table').empty().html(html);
        },300);

      },error : function(html){
        alert('Connection Error!');
      }
    });
  }
});



$('.add_to_basket').live("click",function(){
    var ids = $(this).attr("ids");
    $('.add_to_basket').hide();
    $('#add_to_basket1'+ids).show();
    
    
    $txtpid = $(this).attr("txtpid");
    $pagename = $(this).attr("pagename");
    $txtpname = $(this).attr("txtpname");
    $cats = $(this).attr("cats");
    $subcat = $(this).attr("subcat");
    $memid = $(this).attr("memid");
    $txtpprice = $(this).attr("txtpprice");
    $txtsqty = $('#txtsqty'+ids).val();
    // $mycolors = $('.mycolors'+ids).val();
    // $mysize = $('.mysize'+ids).val();

    $mycolors = $("input[name='mycolors"+ids+"']:checked").map(function(){
      return $(this).val();
    }).get();

    $mysize = $("input[name='mysize"+ids+"']:checked").map(function(){
      return $(this).val();
    }).get();
    //$mysize = $('.mysize'+ids).val();
    
    $('.refresh_table').css('opacity', '0.4');
    $('.loadings').show().html("<p style='text-align:center'><img src='"+site_urls+"img/loaderq.gif'></p>");

    var datastring='txtpid='+$txtpid
    +'&txtpname='+$txtpname
    +'&pagename='+$pagename
    +'&cats='+$cats
    +'&subcat='+$subcat
    +'&memid='+$memid
    +'&txtpprice='+$txtpprice
    +'&txtsqty='+$txtsqty
    +'&mycolors='+$mycolors
    +'&mysize='+$mysize;

    ///alert(datastring);

    $.ajax({
      type : "POST",
      url : site_urls+"node/add_to_cart",
      data: datastring,
      //cache : false,
      success : function(html){
        //alert(html)

        //if(html=="Cannot order for your item!")
          //alert(html)

        //else 
        if(html=="Error in adding items to cart!")
          alert(html)
        
        else{
          //setTimeout(function(){
            $('.refresh_table').css('opacity', '1');
            $('.loadings').hide();
            $('.refresh_table').empty().html(html);
          //},500);
        }

          $('.add_to_basket').show();
          $('#add_to_basket1'+ids).hide();

          $('#toggle_up'+ids).hide();
          $('#toggle_drop'+ids).show();
          $('#drop_down'+ids).toggle('fast');

          $('.refresh_table').css('opacity', '1');
          $('.loadings').hide();

          $('.colors_1').hide();
          $('.sizes_1').hide();

      },error : function(html){
          $('.add_to_basket').show();
          $('#add_to_basket1'+ids).hide();
          $('.colors_1').hide();
          $('.sizes_1').hide();
      }
      
    });
  
});


$('.toggle_up').live("click",function(){
var ids = $(this).attr("ids");
$('#toggle_up'+ids).hide();
$('#toggle_drop'+ids).show();
$('#drop_down'+ids).toggle('fast');
});


$('.toggle_drop').live("click",function(){
var ids = $(this).attr("ids");
$('.toggle_up').hide();
$('.toggle_drop').show();
$('.drop_down').hide();
$('#toggle_drop'+ids).hide();
$('#toggle_up'+ids).show();
$('#drop_down'+ids).toggle('fast');
});








$('#cmdSubmitStore1').live("click",function(e){
    e.preventDefault();

    $(".err_store").hide();
    $('#cmdSubmitStore1').hide();
    $('#cmdSubmitStore2').show();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/steps1",
      data: $(".frmreg_store").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="confirmeds_step1"){

        setTimeout(function(){
          window.location = site_urls+"node/step2/";
          $(".err_store").hide();
          $('#cmdSubmitStore1').show();
          $('#cmdSubmitStore2').hide();
        },200);

        }else{
        $('#cmdSubmitStore1').show();
        $('#cmdSubmitStore2').hide();
        $(".err_store").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
          $('#cmdSubmitStore1').show();
          $('#cmdSubmitStore2').hide();
          $(".err_store").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('#cmd_step3_1').live("click",function(e){
    e.preventDefault();

    $(".err_store1").hide();
    $('#cmd_step3_1').hide();
    $('#cmd_step3_2').show();
    
    var txtmerchantID = $('#txtmerchantID').val();
    
    if(txtmerchantID=="")
      var directions = site_urls+"node/steps2";
    else
      var directions = site_urls+"dashboard/steps2";
    
    $.ajax({
      type : "POST",
      url : directions,
      data: $(".form_step3").serialize(),
      //cache : false,
      success : function(data){

        if(data=="successs2"){
          $(".err_store1").hide();
          if(txtmerchantID==""){
            $('.step3').slideUp('fast');
            $("html, body").animate({ scrollTop: 10 }, "fast");
          }
          if(txtmerchantID==""){
            setTimeout(function(){
              $('.step4').slideDown('fast');
            },300);
          }else{
            $(".err_store1").show().html('<div class="successmsg">Updated Successfully!</div>');
            setTimeout(function(){
              $(".err_store1").hide();
            },3500);
          }
        }else{
          $(".err_store1").show().html('<div class="Errormsg">'+data+'</div>');
        }
        $('#cmd_step3_1').show();
        $('#cmd_step3_2').hide();

      },error : function(data){
          $('#cmd_step3_1').show();
          $('#cmd_step3_2').hide();
          $(".err_store1").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('#cmd_signup_bus_th1').live("click",function(e){
  e.preventDefault();

    $(".err_div2").hide();
    $('#cmd_signup_bus_th1').hide();
    $('#cmd_signup_bus_th2').show();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/business4",
      data: $("#form_busi3").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="confirmed_step3"){
        $('#cmd_signup_bus_th1').show();
        $('#cmd_signup_bus_th2').hide();

        //window.location = site_urls+"node/continue_registration/";
        $('.nav-tabs li').addClass('blurs');
        $('.nav-tabs li').removeClass('active');
        $('.nav-tabs li:nth-child(5)').addClass('active').removeClass('blurs');
        $('#messages').removeClass('in active');
        $('#doner').addClass('in active');

        setTimeout(function(){
          $(".err_div2").hide();
        },2500);

        }else{
        $('#cmd_signup_bus_th1').show();
        $('#cmd_signup_bus_th2').hide();
        $(".err_div2").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
          $('#cmd_signup_bus_th1').show();
          $('#cmd_signup_bus_th2').hide();
          $(".err_div2").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});




$('#cmd_goback2').live("click",function(){
  $('.nav-tabs li').addClass('blurs');
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li:nth-child(2)').addClass('active').removeClass('blurs');
  $('#profile').removeClass('in active');
  $('#home').addClass('in active');
});


$('#cmd_goback3').live("click",function(){
  $('.nav-tabs li').addClass('blurs');
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li:nth-child(3)').addClass('active').removeClass('blurs');
  $('#messages').removeClass('in active');
  $('#profile').addClass('in active');
});


$('#cmd_goback4').live("click",function(){
  $('.nav-tabs li').addClass('blurs');
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li:nth-child(4)').addClass('active').removeClass('blurs');
  $('#doner').removeClass('in active');
  $('#messages').addClass('in active');
});


$('#cmd_done1').live("click",function(){
    
    window.location = site_urls+"dashboard/view_invoice/";
});

$('#cmd_done1_investors').live("click",function(){
    
    window.location = site_urls+"dashboard/";
});


$('#cmd_done2').live("click",function(){
    
    window.location = site_urls+"node/login/";
});


$('#txtyouramount').live("keyup",function(){
  $your_amount = $('#txtyouramount').val();
  if($your_amount != "")
    $('#payment-button-amount').html('Pay &#8358;'+addCommas($your_amount));
  else
    $('#payment-button-amount').html('Pay Now');
});


//$("#quantity").keypress(function (e) {
$('#txtyouramount').live("keypress",function(e){
  //if the letter is not digit then display error and don't type anything
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    $("#errmsg").html("Enter Digits Only").show().fadeOut("slow");
    return false;
  }
});



$(".payonline").live("click",function(){
$(".payonline").hide();
$(".paybank").show('fast');
$(".paybank_div").hide();
$(".payonline_div").slideDown('fast');
//$("#txtemail_s").val('');
//$("#cmd_submit_email1").hide();
//$("#cmd_submit_email").show();
//$(".entermail").slideDown('fast');
//$(".md-modal").css('margin-top','1em');
});



$("#cmd_back_to_input").live("click",function(){
$(".enter_amt").show();
$(".stage_2").hide();
});



$(".paybank").live("click",function(){
$(".paybank").hide();
$(".payonline").show();
$(".payonline_div").hide();
//$(".entermail").hide();
$(".paybank_div").slideDown('fast');
//$(".md-modal").css('margin-top','-2.5em');
});



$('#cmd_reload').live("click",function(){
  
  $('#cmd_reload').html("<img src='"+site_urls+"images/bx_loader.gif' style='width:24px;'>");
  $('#click_paystack1s').click();
});



$('.cmdnexts1').live("click",function(){
  $('.nav-tabs li').addClass('blurs');
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li:nth-child(4)').addClass('active').removeClass('blurs');
  $('#profile').removeClass('in active');
  $('#messages').addClass('in active');
});

$('.cmdnexts2').live("click",function(){
  $('.nav-tabs li').addClass('blurs');
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li:nth-child(5)').addClass('active').removeClass('blurs');
  $('#messages').removeClass('in active');
  $('#doner').addClass('in active');
});

$('.cmdnexts3').live("click",function(){
  $('.div_main_forms').hide();
  $('.div_success_page').show();
});



$('.bank_detls').live("click",function(){
  $('.acct_details').slideToggle('fast');
});


$('.participateme').live("click",function(){
  window.location = site_urls+"pages/#participants";
});

$('#notification').live("click",function(){
  $('.logs').toggle();
});



$('#approveit').live("click",function(){
  var ids = $(this).attr("ids");
  $('.approveit'+ids).html('Approving...');
  
  var datastring='ids='+ids;
  //+'&email2='+$email2;
  
  $.ajax({
    type : "POST",
    url : site_urls+"dashboard/approve_action",
    data: datastring,
    //cache : false,
    success : function(data){
      $('.approveit'+ids).html('<font style="color:#090;" id="approveit" class="approveit'+ids+'" ids="'+ids+'" style="color:#090; cursor:pointer">Approved</font>').show();
      $('.show_java1').show().html('<font style="color:#090;">Approved</font>');
    },error : function(data){
    }
  });
  
  
});



$('.view_more_tbl').live("click",function(){
  var session1 = $(this).attr("sessions");
  $('#other_infos'+session1).slideToggle('fast');
});


$('.other_infos').live("click",function(){
  $('.other_infos').slideUp('fast');
});


$('#approve_acti').live("click",function(){
  var session1 = $(this).attr("session1");
  var caps = $(this).attr("caps");
  var timings = $(this).attr("timings");
  var dates = $(this).attr("dates");

  $('.approve_acti'+session1).html('<b>.......</b>');
  
  if(caps!="Approved")
    var caps1="Approving this activity will be enabled to the contestants.\r\nClick on the link \"View More\" to approve the daily activity\r\nProceed?";
  else
    var caps1="Disapproving this add will mark this activity as Activity Done, proceed?";

  if(confirm(caps1)){
    var datastring='session1='+session1;
    //+'&getAct_id='+getAct_id;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_activities",
      data: datastring,
      //cache : false,
      success : function(data){
        if(data==2){
          alert('Cannot Approve. The previous activity has not expired.');
          if(caps=="Approved")
          $('.approve_acti'+session1).html('<font caps="Approved" style="color:#090; color:#090; cursor:pointer; font-weight:bold;" timings="0" dates="" id="approve_acti" class="approve_acti'+session1+'" session1="'+session1+'"><b>Approved</b></font>').show();
          else
          $('.approve_acti'+session1).html('<font caps="Not Approved" style="color:red !important; color:#090; font-size:14px; cursor:pointer" timings="'+timings+'" dates="'+dates+'" id="approve_acti" class="approve_acti'+session1+'" session1="'+session1+'"><b>Not Approved</b></font>');
        }else{
          dataTable.clear().draw();
          dataTable.rows.add(NewlyCreatedData);
          dataTable.columns.adjust().draw();
        }
        
      },error : function(data){
      }
    });
    return false;
  }
  if(caps=="Approved")
  $('.approve_acti'+session1).html('<font caps="Approved" style="color:#090; color:#090; cursor:pointer; font-weight:bold;" timings="0" dates="" id="approve_acti" class="approve_acti'+session1+'" session1="'+session1+'"><b>Approved</b></font>').show();
  else
  $('.approve_acti'+session1).html('<font caps="Not Approved" style="color:red !important; color:#090; font-size:14px; cursor:pointer" timings="'+timings+'" dates="'+dates+'" id="approve_acti" class="approve_acti'+session1+'" session1="'+session1+'"><b>Not Approved</b></font>');

  return false;
});



$('#approvecontestant').live("click",function(){
  var ids = $(this).attr("ids");
  var caps = $(this).attr("caps");
  
  if(caps=="Blocked")
    var caps1="Approving this contestant will also mark him/her as paid, continue?";
  else
    var caps1="Blocking this contestant will not make him/her to participate in any activity again, continue?";

  if(confirm(caps1)){
    var datastring='ids='+ids;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_contestants",
      data: datastring,
      //cache : false,
      success : function(data){
        dataTable.clear().draw();
        dataTable.rows.add(NewlyCreatedData);
        dataTable.columns.adjust().draw();
        
      },error : function(data){
      }
    });
  }
});


$('#approve_paid').live("click",function(){
  var ids = $(this).attr("ids");
  var emails = $(this).attr("emails");
  var fname = $(this).attr("fname");
  var aprvds = $(this).attr("aprvds");
  if(aprvds==0){
    alert('Please approve the contestant first!');
    return false;
  }
  
  if(confirm('Marking this contestant as paid cannot be undone, continue?')){
    var datastring='ids='+ids
    +'&emails='+emails
    +'&fname='+fname;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_paids",
      data: datastring,
      //cache : false,
      success : function(data){
        dataTable.clear().draw();
        dataTable.rows.add(NewlyCreatedData);
        dataTable.columns.adjust().draw();
        
      },error : function(data){
      }
    });
  }
});



$('#approve_paid_vote').live("click",function(){
  var ids = $(this).attr("ids");
  var emails = $(this).attr("emails");
  var amts = $(this).attr("amts");
  var fname = $(this).attr("fname");
  
  if(confirm('Marking this vote as paid cannot be undone, continue?')){
    var datastring='ids='+ids
    +'&emails='+emails
    +'&fname='+fname
    +'&amts='+amts;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_paid_votes",
      data: datastring,
      //cache : false,
      success : function(data){
        dataTable.clear().draw();
        dataTable.rows.add(NewlyCreatedData);
        dataTable.columns.adjust().draw();
        
      },error : function(data){
      }
    });
  }
});



$('#approve_paid_fund').live("click",function(){
  var ids = $(this).attr("ids");
  var amts = $(this).attr("amts");
  var fname = $(this).attr("fname");
  var phone = $(this).attr("phone");
  
  if(confirm('Marking this voter as paid cannot be undone, continue?')){
    var datastring='ids='+ids
    +'&fname='+fname
    +'&phone='+phone
    +'&amts='+amts;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_paid_funds",
      data: datastring,
      //cache : false,
      success : function(data){
        dataTable.clear().draw();
        dataTable.rows.add(NewlyCreatedData);
        dataTable.columns.adjust().draw();
        
      },error : function(data){
      }
    });
  }
});



$('#cmd_create_game').live("click",function(){
  $(".err_div4").hide();
  $txtsel_act = $("#txtsel_act").val();
  $txtquiz_time = $("#txtquiz_time").val();
  $txtsel_day = $("#txtsel_day").val();
  $qid = "";
  
  if($txtsel_act == '' ){
    $(".err_div4").fadeIn('fast').html('<div class="Errormsg">Please select activity for this game</div>');

  }else if($txtsel_day == '' ){
    $(".err_div4").fadeIn('fast').html('<div class="Errormsg">Select day activity!</div>');
    
  }else if($txtquiz_time == '' ){
    $(".err_div4").fadeIn('fast').html('<div class="Errormsg">Write the duration of this trivia game!</div>');

  }else{

    $("#cmd_create_game").hide();
    $("#cmd_create_game1").show();

    var datastring1='txtsel_act='+$txtsel_act
    +'&txtquiz_time='+$txtquiz_time
    +'&txtsel_day='+$txtsel_day
    +'&qid='+$qid;

    $.ajax({
      type : "POST",
      url : site_urls+"node/save_quiz_settings",
      data : datastring1,
      //cache : false,
      success : function(data){
        //alert(data)
        
        if($.isNumeric(data)){
          $(".first_create_game").hide();
          $(".second_create_game").fadeIn('fast');
          $("#txtsessions").val(data);
          $("#txtact_id").val($txtsel_day);
          $("#cmd_create_game").show();
          $("#cmd_create_game1").hide();
          setTimeout(function(){
            $("html, body").animate({ scrollTop: 140 }, "fast");
          },300);
        }else{
          $(".err_div4").show().html('<div class="Errormsg" style="margin:0; line-height:18px;">'+data+'</div><br>');
          $("#cmd_create_game").show();
          $("#cmd_create_game1").hide();
        }

      },error : function(data){
      $("#cmd_create_game").show();
      $("#cmd_create_game1").hide();
      }
    });

  }
});



$('#approve_acti_inner_1').live("click",function(){
  alert('Error! Disapproving this cannot be done!');
});



$('#approve_acti_inner').live("click",function(){
  var ids1 = $(this).attr("ids1");
  var caps = $(this).attr("caps");
  var session1 = $(this).attr("session1");
  var mydays = $(this).attr("mydays");
  var first_act = $(this).attr("first_act");
  var game_type = $(this).attr("game_type");
  
  if(first_act<=0)
  alert('Please close this and approve this activity first!');
  else{
  
    if(confirm("If you approve this day's activity, it will be visible to the contestants and cannot be undone, proceed?")){
      $('.approve_acti_inner'+ids1).html('<b>.......</b>');
      var datastring='ids1='+ids1
      +'&game_type='+game_type
      +'&session1='+session1;
      //alert(datastring)

      $.ajax({
        type : "POST",
        url : site_urls+"dashboard/approve_activities_inner",
        data: datastring,
        //cache : false,
        success : function(data){
          //alert(data);
          if(data==2){
            alert('Please close this and approve this activity first!');
            if(caps=="Approved")
            $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner_1' caps='Approved' mydays='0' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#0F6; font-size:14px; cursor:pointer'><b>Approved</b></font>");
            else
            $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner' game_type='"+game_type+"' caps='Not Approved' mydays='"+mydays+"' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#FFA8A8; font-size:13px; cursor:pointer'><b>Not Approved</b></font>");
          
          }else if(data==5){
            alert('Trivia Games not ready, please close this and set Trivia Game to be ready');
            if(caps=="Approved")
            $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner_1' caps='Approved' mydays='0' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#0F6; font-size:14px; cursor:pointer'><b>Approved</b></font>");
            else
            $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner' game_type='"+game_type+"' caps='Not Approved' mydays='"+mydays+"' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#FFA8A8; font-size:13px; cursor:pointer'><b>Not Approved</b></font>");

          }else if(data==0){
            $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner' game_type='"+game_type+"' caps='Not Approved' mydays='"+mydays+"' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#FFA8A8; font-size:13px; cursor:pointer'><b>Not Approved</b></font>");

          }else{
            $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner_1' caps='Approved' mydays='0' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#0F6; font-size:14px; cursor:pointer'><b>Approved</b></font>");
            $('.expirs').html(data);
            $('.dones').html("Not Done");
          }
          
        },error : function(data){
        }
      });
      //return false;
    }
    if(caps=="Approved")
    $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner_1' caps='Approved' mydays='0' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#0F6; font-size:15px; cursor:pointer'><b>Approved</b></font>");
    else
    $('.approve_acti_inner'+ids1).html("<font id='approve_acti_inner' game_type='"+game_type+"' caps='Not Approved' mydays='"+hours_set1+"' class='approve_acti_inner'"+ids1+"' ids1='"+ids1+"' session1='"+session1+"' style='color:#FFA8A8; font-size:13px; cursor:pointer'><b>Not Approved</b></font>");
  }

  //return false;
});



$('#txtsel_act').live("change",function(){
  var session1 = $(this).val();
  var datastring='session1='+session1;
  //alert(datastring);
  $.ajax({
    type : "POST",
    url : site_urls+"node/bring_second_activity",
    data: datastring,
    //cache : false,
    success : function(data){
      //alert(data);
      $('#txtsel_day').html(data);
    },error : function(data){
    }
  });
});



$('.change_img').live("click",function(){
  var srcs = $(this).attr("srcs");
  var exts = $(this).attr("exts");
  
  var srcs_big = $('.event_big_img img').attr("src");

  $("html, body").animate({ scrollTop: 140 }, "fast");
  setTimeout(function(){
    if(exts=="mp4" || exts=="wmv"){
      $('.event_big_img video').show();
      $('.event_big_img img').hide();
      $('.event_big_img video source').attr('src', srcs);
    }else{
      $('.event_big_img video').hide();
      $('.event_big_img img').show();
      $('.event_big_img img').attr('src', srcs);
      $('.change_img img').attr('src', srcs_big);
      $('.change_img').attr('srcs', srcs_big);
    }
  },500);
  
});



$('.menu_icn').live("click",function(e){
  e.stopPropagation();
  var ids = $(this).attr("ids");
  $('#edit_div'+ids).slideToggle('fast');
});

$('.menu_icn1').live("click",function(e){
  e.stopPropagation();
  var ids = $(this).attr("ids");
  $('#edit_div1'+ids).slideToggle('fast');
});

$('#editpost').live("click",function(){
  var ids = $(this).attr("ids");
  var messages1 = $(this).attr("messages1");
  var files = $(this).attr("files");
  var topics = $(this).attr("topics");
  var counters = $(this).attr("counters");
  create_cookie('counters', counters);
  //alert(topics)
  $('#edit_div'+ids).slideToggle('fast');
  $('#selectedCaption1').html(files);
  $('#edit_ids').val(ids);
  $('#former_file1').val(files);
  $('#post_content').val(messages1);
  $("#txtcats").val(topics);
  $("#cmdPosts").val("Edit Comment");
  
  $("html, body").animate({scrollTop: $('.txtcreate_topic').offset().top-50 }, "fast");
  
  setTimeout(function(){
    $('.clickforum').click();
  },500);
});


$('#delpost').live("click",function(){
  var ids = $(this).attr("ids");
  if(confirm("Proceed to delete this post?")){
    $('.forumBox_scroll'+ids).slideUp('fast');
    var datastring='post_id='+ids
    +'&type1=forums';
    $.ajax({
      type : "POST",
      url : site_urls+"node/delete_post",
      data: datastring,
      //cache : false,
      success : function(data){
      },error : function(data){
      }
    });
    return false;
  }
});


$('#delpost2').live("click",function(){
  var ids = $(this).attr("ids");
  $('.forum_rep'+ids).slideUp('fast');
  
  var txtrep_cnts = $('#txtrep_cnts').val();
  var new_cnt = parseInt(txtrep_cnts)-1;

  $('#txtrep_cnts').val(new_cnt);
  $('.newcount').html(new_cnt);

  var datastring='post_id='+ids
  +'&type1=forum_reply';
  $.ajax({
    type : "POST",
    url : site_urls+"node/delete_post",
    data: datastring,
    //cache : false,
    success : function(data){

    },error : function(data){
    }
  });
  return false;
});


$('.noclickforum, #cmdnoPosts').live("click",function(){
  if(confirm("You cannot use this feature, please login and continue.\r\nDo you want to login or register?")){
    window.location = site_urls;
  }
  return false;
});


$('#uploadfiles1').live("mousedown",function(){
  $("#imgpreview1").html('');
  $('#file4').click();
});

$('#uploadfiles1_rep').live("mousedown",function(){
  $("#imgpreview1_rep").html('');
  $('#file4_rep').click();
});


create_cookie('selected_file1', 0);

$('#file4').live('change', function(){
  //crib_notifys(); // to refresh myCrib link to check if new post is there
  var myfile = $('#file4').val();
  var extn = myfile.slice(-7);
  
  if(myfile.length > 16){
  var myfile1 = myfile.substring(0,16);
  var combined_one1 = myfile1+'...'+extn;
  }else{
  var combined_one1 = myfile;
  }
  
  if(myfile1 == ''){
    $('#selectedCaption1').html('No file selected');
    create_cookie('selected_file1', 0);
  }else{
    $('#selectedCaption1').html('<b style="color:#996600; font-size:0.9em;">Selected:</b> '+combined_one1);
    create_cookie('selected_file1', 1);
  }
  
  $("#imgpreview1").html('').show();
  //this code below is for the uploading to stay right beside the box
  $("#form2").ajaxForm({
    target: '#imgpreview1'
  }).submit()
  //to bring all the chats from a function
  setTimeout(function(){
  $("#imgpreview1").html('');
  $("#imgpreview1").hide();
  $('#selectedCaption1').empty().html('No file selected');
  },1300);
});


$('#file4_rep').live('change', function(){
  var myfile = $('#file4_rep').val();
  var extn = myfile.slice(-7);
  
  if(myfile.length > 16){
  var myfile1 = myfile.substring(0,16);
  var combined_one1 = myfile1+'...'+extn;
  }else{
  var combined_one1 = myfile;
  }
  
  if(myfile1 == ''){
    $('#selectedCaption1_rep').html('No file selected');
    create_cookie('selected_file1', 0);
  }else{
    $('#selectedCaption1_rep').html('<b style="color:#996600; font-size:0.9em;">Selected:</b> '+combined_one1);
    create_cookie('selected_file1', 1);
  }
  
  $("#imgpreview1_rep").html('').show();
  //this code below is for the uploading to stay right beside the box
  $("#form2").ajaxForm({
    target: '#imgpreview1_rep'
  }).submit()
  //to bring all the chats from a function
  setTimeout(function(){
  $("#imgpreview1_rep").html('');
  $("#imgpreview1_rep").hide();
  $('#selectedCaption1_rep').empty().html('No file selected');
  },1300);
});


$('.clickforum').live("click",function(){
  $('.txtselectcat').fadeIn('fast');
  $('.textareas').slideDown('fast');
  $('.clickforum').hide();
  $('#txt_srch_forum1').show();
});


$('.cancel_posts').live("click",function(){
  $("#form2")[0].reset();
  $('.txtselectcat').fadeOut('fast');
  $('.textareas').slideUp('fast');
  $('#txt_srch_forum1').hide();
  $('.clickforum').show();
  $('#selectedCaption1').empty().html('No file selected');
  $(".errs").hide();
  $('.bold_info1').hide();
});



$('#approve_status').live("click",function(){
  var session1 = $(this).attr("session1");
  var caps = $(this).attr("caps");
  $('.approve_status'+session1).html('<b>.......</b>');
  
  if(confirm("Closing this activity will not allow contestants to participate again.\r\nAnd it means you want the computer to compute the winners\r\nAnd this cannot be undone, proceed?")){
    var datastring='session1='+session1;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/close_activities",
      data: datastring,
      //cache : false,
      success : function(data){
        dataTable.clear().draw();
        dataTable.rows.add(NewlyCreatedData);
        dataTable.columns.adjust().draw();
      },error : function(data){
      }
    });
    return false;
  }
  if(caps=="Open")
  $('.approve_status'+session1).html('<font caps="Open"  style="color:#333; font-size:15px; cursor:pointer" id="approve_status" class="approve_status'+session1+'" session1="'+session1+'"><b>Open</b></font>').show();
  else
  $('.approve_status'+session1).html('<font caps="Closed"  style="color:red; font-size:15px; cursor:pointer" id="approve_status" class="approve_status'+session1+'" session1="'+session1+'"><b>Close</b></font>');

  return false;
});



$('#activate_vid').live("click",function(){
  
  var ids = $(this).attr("ids");
  var caps = $(this).attr("caps");
  $('.activate_vid'+ids).html('.........');
  
  if(caps=="Deactivate")
    var caps1="Deactivvating this Ad will not be visible on the home page, continue?";
  else
    var caps1="Proceed to activate this Ad";

  if(confirm(caps1)){
    var datastring='ids='+ids;
    //alert(datastring)
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_vds",
      data: datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        //$('#activate_vid').html('<b caps="Activate" id="activate_vid" class="activate_vid'+ids+'" ids="'+ids+'" style="color:#090 !important; cursor:pointer">Activate</b>');

        if(data == 1){
          $('.activate_vid'+ids).html('<b caps="Deactivate" id="activate_vid" class="activate_vid'+ids+'" ids="'+ids+'" style="color:red !important; cursor:pointer">Deactivate</b>').show();
        }else{
          $('.activate_vid'+ids).html('<b caps="Activate" id="activate_vid" class="activate_vid'+ids+'" ids="'+ids+'" style="color:#090 !important; cursor:pointer">Activate</b>');
        }
        //$('#activate_vid').hide();
        //$('#activate_vid').show().html('<b caps="Activate" id="activate_vid" class="activate_vid'+ids+'" ids="'+ids+'" style="color:#090 !important; cursor:pointer">Activate</b>');
        
      },error : function(data){
      }
    });
    return false;
  }
  $('.activate_vid'+ids).html(caps);
  return false;
});




$('.edit_actis').live("click",function(){
  var ids = $(this).attr("id");
  window.location = site_urls+"shield/edit_activity/"+ids+"/";
});

$('.edit_quiz').live("click",function(){
  var ids = $(this).attr("id");
  window.location = site_urls+"shield/editgames/"+ids+"/1838747/";
});


$('.add_questns span').live("click",function(){
  var ids = $(this).attr("sess");
  window.location = site_urls+"shield/creategames/"+ids+"/new/";
});



$('.edit_games').live("click",function(){
  var ids = $(this).attr("id");
  window.location = site_urls+"shield/editgames/"+ids+"/";
});

$('.edit_media1').live("click",function(){
  var ids = $(this).attr("id");
  window.location = site_urls+"shield/editmedia/"+ids+"/";
});

$('.edit_events').live("click",function(){
  var ids = $(this).attr("id");
  window.location = site_urls+"shield/edit_events/"+ids+"/";
});

$('.edit_actis1').live("click",function(){
  var ids = $(this).attr("id");
  var ids1 = $(this).attr("id2");
  window.location = site_urls+"shield/edit_activity/"+ids+"/"+ids1+"/";
});


$('#approveuser_agent').live("click",function(){
  
  var ids = $(this).attr("ids");
  var caps = $(this).attr("caps");
  $('.approveuser_agent'+ids).html('.........');
  //alert(caps);
  if(caps=="Approve this agent")
    var caps1="Proceed to approve this agent";
  else
    var caps1="Proceed to block this agent";

  if(confirm(caps1)){
    var datastring='ids='+ids;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_agent",
      data: datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        if(data == 1){
          $('.approveuser_agent'+ids).html('<font caps="Block this agent" style="color:#090;" id="approveuser_agent" class="approveuser_agent'+ids+'" ids="'+ids+'" style="color:#090; cursor:pointer">Block this agent</font>').show();
        }else{
          $('.approveuser_agent'+ids).html('<font caps="Approve this agent" style="color:red;" id="approveuser_agent" class="approveuser_agent'+ids+'" ids="'+ids+'" style="color:#090; cursor:pointer">Approve this agent</font>');
        }
        
      },error : function(data){
      }
    });
    return false;
  }
  $('.approveuser_agent'+ids).html(caps);
  return false;
});



$('#delete_member').live("click",function(){
  
  var ids = $(this).attr("ids");
  
  var caps1="If you choose to delete this member, every of his/her\r\nactivity here on BM will permanently be deleted as well\r\nDelete this member?";

  if(confirm(caps1)){
    $('.delete_member'+ids).html('.........');
    $('#mem_div'+ids).css({'opacity':'0.5'});
    
    var datastring='ids='+ids;
    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/delete_member",
      data: datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        if(data == "deleted"){
          $('#mem_div'+ids).slideUp('fast');
        }else{
          alert('Error in deleting!');
        }
        
      },error : function(data){
      }
    });
    return false;
  }
  $('.delete_member'+ids).html(caps);
  return false;
});



$('#more_infos').live("click",function(e){
  e.stopPropagation();
  var ids = $(this).attr("ids");
  $('#hidden_ref_info'+ids).slideToggle('fast');
});

$('.hidden_ref_info').live("click",function(e){
  e.stopPropagation();
  var ids = $(this).attr("ids");
  $('#hidden_ref_info'+ids).slideToggle('fast');
});




$('#paiduser').live("click",function(){
  
  var ids = $(this).attr("ids");
  var caps = $(this).attr("caps");
  var txtplan1 = $(this).attr("txtplan1");
  var bp_id = $(this).attr("bp_id");
  var mem_name = $(this).attr("mem_name");
  var mem_email = $(this).attr("mem_email");
  
  $('.paiduser'+ids).html('.........');

  if(confirm('Marking this Ad as paid cannot be undone, proceed?')){
    //var datastring='ids='+ids;
    var datastring='ids='+ids
    +'&txtplan1='+txtplan1
    +'&mem_name='+mem_name
    +'&mem_email='+mem_email
    +'&bp_id='+bp_id;

    $.ajax({
      type : "POST",
      url : site_urls+"dashboard/approve_user_paid",
      data: datastring,
      //cache : false,
      success : function(data){
        if(data == 1){
          $('.paiduser'+ids).hide();
          $('.show_java1_paid'+ids).show().html("<font caps='Yes' style='color:#090; cursor:default' onclick='alert(\"Cannot be undone!\"); return false;'><b>Yes</b></font>");
          $('.feat_no'+ids).html("<font style='color:#090'>Yes</font>");
        }
        
      },error : function(data){
      }
    });
    return false;
  }
  $('.paiduser'+ids).html(caps);
  return false;
});



$('.cmd_signin').live("click",function(){
    $(".err_login").hide();
    $('.cmd_signin').hide();
    $('.cmd_signin1').show();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/logme",
      data: $(".reg_form_home").serialize(),
      //cache : false,
      success : function(data){
        if(data=="successor2"){
          $('.cmd_signin').show();
          $('.cmd_signin1').hide();
          $('.java_show').show();

          setTimeout(function(){
            $(".err_login").hide();
          },2500);
          $('.login_form').hide();
          $('.participate').slideDown('fast');

          $.ajax({
            type : "POST",
            url : site_urls+"node/logme_paid",
            data: $(".reg_form_home").serialize(),
            //cache : false,
            success : function(data){
              if(data=="yes_paid"){
                $('.havepaid').show();
                $('.notpaid').hide();
              }else{
                $('.havepaid').hide();
                $('.notpaid').show();
              }
            }
          });

        }else{
        $('.cmd_signin').show();
        $('.cmd_signin1').hide();
        $(".err_login").show().html('<div class="Errormsg">'+data+'</div>');
        }

      },error : function(data){
          $('.cmd_signin').show();
          $('.cmd_signin1').hide();
          $(".err_login").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.notpaid1').live("click",function(){
  $('.parti_btn1').hide();
  $('.parti_div').slideDown('fast');
});


$('.cmd_nopay, .cmd_done_pay').live("click",function(){
  $('.parti_div').hide();
  $('.pay_succ_div').hide();
  $('.parti_btn1').fadeIn('fast');
});



$('.cmd_add_payment').live("click",function(){
  $('.cmd_add_payment').hide();
  $('.cmd_add_payment1').show();
  var gameid1 = $(this).attr('gameid1');
  var mems = $(this).attr('mems');
  var datastring='gameid1='+gameid1
  +'&mems='+mems;
  alert(datastring)
  $.ajax({
    type : "POST",
    url : site_urls+"node/renew_payment_",
    data: datastring,
    success : function(data){
      if(data=="inserted"){
          $('.cmd_add_payment1').hide();
          $('.cmd_add_payment').show();
          $('.parti_div').hide();
          $('.pay_succ_div').fadeIn('fast');
      }else{
          $('.cmd_add_payment1').hide();
          $('.cmd_add_payment').show();
          alert("You previously made a payment request which is under processing...");
      }
    },error : function(data){
        $('.cmd_add_payment1').hide();
        $('.cmd_add_payment').show();
    }
  });
});



$('#cmd_post_cmt').live("click",function(){
  $(".err_login").hide();
  $('#cmd_post_cmt').hide();
  $('#cmd_post_cmt1').show();

  $txtcmts = $('#txtcmts').val();
  $txtnms = $('#txtnms').val();
  $txtmails = $('#txtmails').val();
  $auto_dates = $('#auto_dates').val();
  $txtcmts_cnt = $('.txtcmts_cnt').val();
  $txtcmts_cnt1 = parseInt($txtcmts_cnt)+1;

  if($txtcmts == ""){
    $(".err_login").show().html('<div class="Errormsg">Please write a comment about this event!</div>');
    $('#cmd_post_cmt1').hide();
    $('#cmd_post_cmt').show();

  }else if($txtnms == ""){
    $(".err_login").show().html('<div class="Errormsg">Write your names!</div>');
    $('#cmd_post_cmt1').hide();
    $('#cmd_post_cmt').show();

  }else if($txtmails == ""){
    $(".err_login").show().html('<div class="Errormsg">Write your email address!</div>');
    $('#cmd_post_cmt1').hide();
    $('#cmd_post_cmt').show();

  }else{
  
    $('.user_names').html($txtnms);
    $('.user_dates').html($auto_dates);
    $('.user_comments').html($txtcmts);
    $('.cmt_counts').html($txtcmts_cnt1+" Comments");
    $('.txtcmts_cnt').html($txtcmts_cnt1);
    
    $('.java_comment_show').show().css('opacity', '0.4');
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/post_comment",
      data: $("#form_comments").serialize(),
      //cache : false,
      success : function(data){
        var datas = data.substring(0,8);
        var newdata = data.substring(8);
        if(datas=="inserted"){
          $('#cmd_post_cmt1').hide();
          $('#cmd_post_cmt').show();
          $('.java_comment_show').show().css('opacity', '1');
          $('.java_comment_show').hide();
          $('.java_comment_show_real').append(newdata);
          $("#form_comments")[0].reset();

          setTimeout(function(){
            $("html, body").animate({scrollTop:$('.comment_section').offset().top-150}, "fast");
          },500);

        }else{
          $('#cmd_post_cmt1').hide();
          $('#cmd_post_cmt').show();
          $(".err_login").show().html('<div class="Errormsg">'+newdata+'</div>');
        }

      },error : function(data){
          $('#cmd_post_cmt1').hide();
          $('#cmd_post_cmt').show();
      }
    });
  }
});



$('.youtubevid, .youtubevid2').live("click",function(){
  var ids = $(this).attr('ids');
  var vid_views = $('#vid_views'+ids).val();
  var new_views = parseInt(vid_views) + 1;

  $('#vid_views'+ids).val(new_views);
  $('.vd_views'+ids).html(new_views);

  var datastring9='ids='+ids;
  $.ajax({
    type : "POST",
    url : site_urls+"node/update_video_views",
    data: datastring9,
    success : function(data){
    },error : function(data){
    }
  });
});



/*$('.editad').live("click",function(){
    var ids = $(this).attr('ids');
    var stitl = $(this).attr('stitl');
    var pric = $(this).attr('pric');
    var contry = $(this).attr('contry');
    var stat1 = $(this).attr('stat1');
    var cits = $(this).attr('cits');
    var catt = $(this).attr('catt');
    var coms = $(this).attr('coms');
    var descc = $(this).attr('descc');
    var vals = $(this).attr('vals');
    //alert(ids)
    $('#txtimg_text').val(1);
    $('#txtsell').val(stitl);
    $('#txtprice').val(pric);
    $('#txtcountries').val(contry);
    $('#txtstates1').val(stat1);
    $('#txtcitys').val(cits);
    $('#txtcatt1').val(catt);
    $('#txtcomm').val(coms);
    $('#update_id').val(ids);
    $('.txtdescrip').val(descc);

    if(vals == 1){
      $('.div_text_only').show();
      $('.div_img_text').hide();
      $('#txtimg_text').val(1);
    }else{
      $('.div_text_only').hide();
      $('.div_img_text').show();
      $('#txtimg_text').val(0);
      //$('#update_id').val(0);
    }

    var update_id = $('#update_id').val();
    
    if(update_id!=""){ // then fetch the uploaded pics for this id
      var datastring9='update_id='+update_id;
      //alert(update_id);  
      $.ajax({
        type : "POST",
        url : site_urls+"node/fetch_pics_for_this_id",
        data: datastring9,
        //cache : false,
        success : function(data){
          //alert(data)
          if(data != "")
            $('.former_uploads').show().html(data);
          else
            $('.former_uploads').hide();
        },error : function(data){
          //alert(data)
        }
      });
    }
    $('.masks').show();
    $('.big_text_input').show();
    $("html, body").animate({ scrollTop: 0 }, "fast");

});*/



$('.accts').live("hover, click",function(){
  $('.submenus').slideDown('fast');
});


// $('.featured-area, .navigation1').live("mousemove",function(){
//   $('.submenus').slideUp('fast');
// });


$('.make_admin').live("click",function(){
    
    var memid = $(this).attr('memid');
    var txtchoose = $('#txtchoose'+memid).val();

    var datastring='memid='+memid
    +'&txtchoose='+txtchoose;
    //alert(datastring)

    if(txtchoose == null || txtchoose == ""){
      if(confirm('Proceed to remove this member as admin or moderator and change to a member?')){
          $.ajax({
            type : "POST",
            url : site_urls+"node/make_admins",
            data : datastring,
            //cache : false,
            success : function(data){
              //alert(data)
              if(data=="made_admin"){
              $('.suc_msg'+memid).show();
              }
              setTimeout(function(){
                $(".suc_msg"+memid).hide();
              },2500);

            },error : function(data){
            }
          });
      }
    }else{
      $.ajax({
            type : "POST",
            url : site_urls+"node/make_admins",
            data : datastring,
            //cache : false,
            success : function(data){
              //alert(data)
              if(data=="made_admin"){
              $('.suc_msg').show();
              }
              setTimeout(function(){
                $(".suc_msg").hide();
              },2500);

            },error : function(data){
            }
          });
    }
});




$('#savead').live("click",function(){
    
    var txt_bma_id = $('#txt_bma_id').val();
    var ids = $(this).attr('ids');
    var prodid = $(this).attr('prodid');
    $('.savead'+prodid).hide();
    $('.savead1'+prodid).show();
    
    var datastring='txt_bma_id='+txt_bma_id
    +'&prodid='+prodid;
    $.ajax({
      type : "POST",
      url : site_urls+"node/save_this_ad",
      data : datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="adsaved"){
          $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
          $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Saved Successfully</div>");
          $('.savead'+prodid).show();
          $('.savead1'+prodid).hide();
          $('.menu_menu1_'+ids).slideUp('fast');
          $('#menu_menu'+ids).slideUp('fast');
          $('#menu_menu_txt'+ids).slideUp('fast');
        }else{
          $('.msgbox1').css({'border':'1px solid #FF7575', 'border-bottom':'1px solid #FF7575'});
          $('.msgbox1').fadeIn('fast').html(data);
          $('.savead'+prodid).show();
          $('.savead1'+prodid).hide();
          $('.menu_menu1_'+ids).slideUp('fast');
          $('#menu_menu'+ids).slideUp('fast');
          $('#menu_menu_txt'+ids).slideUp('fast');
        }
        //$('#menu_menu'+ids).slideToggle('fast');
        setTimeout(function(){
          $(".msgbox1").hide();
        },2500);

      },error : function(data){
        $('.savead'+prodid).show();
        $('.savead1'+prodid).hide();
        //$('.msgbox1').css({'border':'1px solid #FF7575', 'border-bottom':'1px solid #FF7575'});
        $(".msgbox1").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('#savead_rem').live("click",function(){
    
    var txt_bma_id = $('#txt_bma_id').val();
    var ids = $(this).attr('ids');
    var prodid = $(this).attr('prodid');
    $('.savead_rem'+prodid).hide();
    $('.savead1_rem'+prodid).show();
    
    var datastring='txt_bma_id='+txt_bma_id
    +'&prodid='+prodid;
    $.ajax({
      type : "POST",
      url : site_urls+"node/remove_this_ad",
      data : datastring,
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="ad_removed"){
          $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
          $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Removed Successfully</div>");
          $('.savead_rem'+prodid).show();
          $('.savead1_rem'+prodid).hide();
          $('.menu_menu1_'+ids).slideUp('fast');
          $('#menu_menu'+ids).slideUp('fast');
          $('#menu_menu_txt'+ids).slideUp('fast');

          $('.eachlist_'+prodid).slideUp('fast');
            
        }else{
          $('.msgbox1').css({'border':'1px solid #FF7575', 'border-bottom':'1px solid #FF7575'});
          $('.msgbox1').fadeIn('fast').html(data);
          $('.savead_rem'+prodid).show();
          $('.savead1_rem'+prodid).hide();
          $('.menu_menu1_'+ids).slideUp('fast');
          $('#menu_menu'+ids).slideUp('fast');
          $('#menu_menu_txt'+ids).slideUp('fast');
        }
        setTimeout(function(){
          $(".msgbox1").hide();
        },2500);

      },error : function(data){
        $('.savead_rem'+prodid).show();
        $('.savead1_rem'+prodid).hide();
        $(".msgbox1").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.turnoff').live("click",function(){
    
    var txt_bma_id = $('#txt_bma_id').val();
    var prodid = $(this).attr('prodid');
    var ids = $(this).attr('ids');
    var stitle = $(this).attr('stitle');
    var cmtcount = $(this).attr('cmtcount');
    var txtturnoff = $('.txtturnoff'+prodid).val();
    var descrip = $(this).attr('descrip');
    
    //var txt_bma_id = $('#txt_bma_id').val();
    if(txtturnoff==0)
      var turns = "off";
    else
      var turns = "on";

    if(confirm("Proceed to turn this Ad "+turns+"?")){
      var datastring='prodid='+prodid;
      //+'&prodid='+prodid;
      $.ajax({
        type : "POST",
        url : site_urls+"node/turnoff_this_ad",
        data : datastring,
        //cache : false,
        success : function(data){
          //alert(data)
          //if(data=="ad_turnedoff_on"){
            if(data == 0){
              $('#turnoff'+prodid).html('Turn off further clicking of Ads');
              $('.txtturnoff'+prodid).val(1);
              $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
              $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>This Ad has been turned on</div>");

              $('.for_comments'+prodid).append('<div style="padding:10px; text-align:center; font-size:Arial; color:#666; font-size:13px; font-weight:bold; letter-spacing:0px;">Comments are now turned on</div>');
              $('.for_comments1'+prodid).html("<a href='"+prodid+"/"+stitle+"/' class='continue_reading' style='color:#999'>"+cmtcount+" Comments</a>");
              //$('.for_comments1'+prodid).html('<a href="" class='continue_reading' style='color:#999'>"+ids+"</a>");
              $('.for_comments2'+prodid).show().html(descrip);
              $('.for_comments2_'+prodid).hide();
              $('.real_comment'+prodid).hide();

              setTimeout(function(){
                $(".msgbox1").hide();
              },2500);
            
          }else{

            $('#turnoff'+prodid).html('Turn on further clicking of Ads');
            $('.txtturnoff'+prodid).val(0);
            $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
            $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>This Ad has been turned off</div>");

            $('.for_comments'+prodid).append('<div style="padding:10px; text-align:center; font-size:Arial; color:#666; font-size:13px; font-weight:bold; letter-spacing:0px;">Comments are turned off</div>');
            $('.for_comments1'+prodid).html('<label style="font-size:Arial; color:#999; font-size:12px; font-weight:bold;">Turned off</label>');
            $('.for_comments2'+prodid).show();
            //$('.for_comments2'+prodid).show().html(descrip);
              $('.for_comments2_'+prodid).show();
            $('.real_comment'+prodid).hide();

            setTimeout(function(){
              $(".msgbox1").hide();
            },2500);


          }
          $('#menu_menu'+ids).slideToggle('fast');
          $('#menu_menu_txt'+ids).slideToggle('fast');

        },error : function(data){
          //alert(data)
        }
      });
    }
});


$('.member_failure').live("click",function(){
  
  if(confirm("Please proceed to login or create account to post Ads for free?"))
  window.location = site_urls+"signin/";
});


$('.member_failure_feature').live("click",function(){
  
  if(confirm("Please proceed to login or create account to feature your Ads?"))
  window.location = site_urls+"signin/";
});



$('.deletead').live("click",function(){
    
    var txt_bma_id = $('#txt_bma_id').val();
    var prodid = $(this).attr('prodid');
    var ids = $(this).attr('ids');
    var ids_1 = ids-1;
    //alert(ids_1);
    
    if(confirm("Proceed to delete this Ad?")){
      var datastring='txt_bma_id='+txt_bma_id
      +'&prodid='+prodid;

      $('#deletead'+prodid).hide();
      $('.deletead1'+prodid).show();

      $.ajax({
        type : "POST",
        url : site_urls+"node/delete_this_ad",
        data : datastring,
        //cache : false,
        success : function(data){
          //alert(data)
          if(data=="ad_deleted"){
            $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
            $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Ad Deleted</div>");
            $('.eachlist'+prodid).slideUp('fast');

            $('#deletead'+prodid).show();
            $('.deletead1'+prodid).hide();

              var owl = $('.owl-carousel');
              owl.trigger('remove.owl.carousel',ids_1)
                .trigger('refresh.owl.carousel');
                
              $('.eachlist_'+prodid).slideUp('fast');

            setTimeout(function(){
              $(".msgbox1").hide();
            },2500);
            
          }else{
            $('.msgbox1').css({'border':'1px solid #FF7575', 'border-bottom':'1px solid #FF7575'});
            $('.msgbox1').fadeIn('fast').html(data);
            setTimeout(function(){
              $(".msgbox1").hide();
            },2500);
            $('#deletead'+prodid).show();
            $('.deletead1'+prodid).hide();
          }
          $('#menu_menu'+ids).slideToggle('fast');
          $('#menu_menu_txt'+ids).slideToggle('fast');

        },error : function(data){
          $('#deletead'+prodid).show();
          $('.deletead1'+prodid).hide();
        }
      });
    }
});


$('.deleted_block').live("click",function(){
    
    var prodid = $(this).attr('prodid');
    var memid = $(this).attr('memid');
    var ids = $(this).attr('ids');
    var ids_1 = ids-1;
    
    if(confirm("Proceed to delete this Ad and block the member?")){

      $('#deleted_block'+prodid).hide();
      $('.deleted_block1'+prodid).show();

      var datastring='txt_bma_id='+txt_bma_id
      +'&prodid='+prodid
      +'&mem_id='+memid;
      $.ajax({
        type : "POST",
        url : site_urls+"node/delete_this_ad",
        data : datastring,
        //cache : false,
        success : function(data){
          //alert(data)
          if(data=="ad_deleted"){
            $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
            $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Ad Deleted, Member blocked!</div>");
            $('.eachlist'+prodid).slideUp('fast');

            $('#deleted_block'+prodid).show();
            $('.deleted_block1'+prodid).hide();

              var owl = $('.owl-carousel');
              owl.trigger('remove.owl.carousel',ids_1)
                .trigger('refresh.owl.carousel');

            setTimeout(function(){
              $(".msgbox1").hide();
            },2500);
            
          }else{
            $('.msgbox1').css({'border':'1px solid #FF7575', 'border-bottom':'1px solid #FF7575'});
            $('.msgbox1').fadeIn('fast').html(data);
            setTimeout(function(){
              $(".msgbox1").hide();
            },2500);
            $('#deleted_block'+prodid).show();
            $('.deleted_block1'+prodid).hide();
          }
          $('#menu_menu'+ids).slideToggle('fast');
          $('#menu_menu_txt'+ids).slideToggle('fast');

        },error : function(data){
          $('#deleted_block'+prodid).show();
          $('.deleted_block1'+prodid).hide();
        }
      });
    }
});




$('#txtchatme').live("keyup",function(){
  var ids = $(this).attr('ids');
  var txtchatme = $(this).val();
  $('.txtchatme_general').val(txtchatme);
});





$('#cmdsendchat').live("click",function(){
    var ids = $(this).attr('ids');
    var memid1 = $(this).attr('memid1');
    
    var txt_bma_id = $('#txt_bma_id').val();
    var txtchatme = $('.txtchatme_general').val();

    if(txtchatme == ""){
      alert('Please type a message!');
      return false;
    }else{

      if(txt_bma_id == "" || txt_bma_id <= 0){
        alert('Please login to send message');
        $('.txtchatme'+ids).val('');
      }else{

        if(txtchatme != ""){
          var datastring='txt_bma_id='+txt_bma_id
          +'&txtchatme='+txtchatme
          +'&memid1='+memid1
          +'&prodid='+ids;

          $('.txtchatme'+ids).attr("disabled", true);
          $('.txtchatme'+ids).css({'background':'#ddd'});
          $('.cmdsendchat'+ids).hide();
          $('.cmdsendchat1'+ids).show();

          
          setTimeout(function(){
            $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
            $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Message Sent!</div>");
            $('.txtchatme'+ids).attr("disabled", false);
            $('.txtchatme'+ids).css({'background':'#fff'});
            $('.cmdsendchat'+ids).show();
            $('.cmdsendchat1'+ids).hide();
            $('.chatme_box'+ids).hide();
            $('.txtchatme'+ids).val('');
          },2000);

          
          $.ajax({
            type : "POST",
            url : site_urls+"node/send_chats",
            data : datastring,
            //cache : false,
            success : function(data){
              //alert(data)
              if(data=="chat_sent"){
              // no statements
    
              }else{
                alert('Error in sending message!');
                $('.txtchatme'+ids).attr("disabled", false);
                $('.txtchatme'+ids).css({'background':'#fff'});
                $('.cmdsendchat'+ids).show();
                $('.cmdsendchat1'+ids).hide();
                $('.chatme_box'+ids).hide();
                $('.txtchatme'+ids).val('');
              }

              setTimeout(function(){
                $(".msgbox1").hide();
              },4500);

            },error : function(data){
            }
          });
        }
      }
    }
});


$('#cmdsendchat_sec').live("click",function(){
    var ids = $(this).attr('ids');
    var memid1 = $(this).attr('memid1');
    
    var txt_bma_id = $('#txt_bma_id').val();
    var txtchatme = $('.txtchatme_sec'+ids).val();

    if(txtchatme == ""){
      alert('Please type a message!');
      //return false;
    }else{

      if(txt_bma_id == "" || txt_bma_id <= 0){
        alert('Please login to send message');
        $('.txtchatme_sec'+ids).val('');
      }else{

        if(txtchatme != ""){
          var datastring='txt_bma_id='+txt_bma_id
          +'&txtchatme='+txtchatme
          +'&memid1='+memid1
          +'&prodid='+ids;
          
          $('.txtchatme_sec'+ids).attr("disabled", true);
          $('.txtchatme_sec'+ids).css({'background':'#ddd'});
          $('.cmdsendchat_sec'+ids).hide();
          $('.cmdsendchat_sec1'+ids).show();

          setTimeout(function(){
            $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
            $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Message Sent!</div>");
            $('.txtchatme_sec'+ids).attr("disabled", false);
            $('.txtchatme_sec'+ids).css({'background':'#fff'});
            $('.cmdsendchat_sec'+ids).show();
            $('.cmdsendchat_sec1'+ids).hide();
            $('.chatme_box_sec'+ids).hide();
            $('.txtchatme_sec'+ids).val('');
          },2000);
          
          $.ajax({
            type : "POST",
            url : site_urls+"node/send_chats",
            data : datastring,
            //cache : false,
            success : function(data){
              //alert(data)
              if(data=="chat_sent"){
                // $('.msgbox1').css({'border-top':'1px solid #0C6', 'border-bottom':'1px solid #0C6'});
                // $('.msgbox1').fadeIn('fast').html("<div class='successmsg' style='border:none !important; background:none !important; font-size:1.4em !important;'>Message Sent!</div>");
                // $('.txtchatme_sec'+ids).attr("disabled", false);
                // $('.txtchatme_sec'+ids).css({'background':'#fff'});
                // $('.cmdsendchat_sec'+ids).show();
                //$('.cmdsendchat_sec1'+ids).hide();

              }else{
                alert('Error in sending message!');
                $('.txtchatme_sec'+ids).attr("disabled", false);
                $('.txtchatme_sec'+ids).css({'background':'#fff'});
                $('.cmdsendchat_sec'+ids).show();
                $('.cmdsendchat_sec1'+ids).hide();
                $('.chatme_box_sec'+ids).hide();
                $('.txtchatme_sec'+ids).val('');
              }

              setTimeout(function(){
                $(".msgbox1").hide();
              },4500);

            },error : function(data){
            }
          });
        }

      }
    }
});



$('.msgbox1').live("click",function(){
  $('.msgbox1').hide();
});


$('.forgot_pass').live("click",function(){
  $('.register_div').hide();
    $('.forgot_pass_div').slideDown('fast');
});


// $('.login_here').live("click",function(){
//   $('.forgot_pass_div').hide();
//     $('.register_div').slideDown('fast');
// });


$('.cmd_done_reset').live("click",function(){
  $('.suc_form').hide();
    $('.register_div').slideDown('fast');
});


$('.view_earning').live("mousedown",function(){
  $('.main_form_ref').hide();
  $('.view_earning').hide();
  $('.back_earning').show();
  $('.view_your_earnings').slideDown('fast');
});



// $('.scrls, .hambarger').live("mousedown",function(){
//   if($(window).width()<760) openFullscreen();
// });


$('.open_awards').live("mousedown",function(){
  //if($(window).width()<760) openFullscreen();
  $('body').css('overflow', 'hidden');
  window.history.pushState('forward', null, './#awards');
  $('.show_awards').show();
  $('#what_div').val('gifts');
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $(".inner_dvs3").scrollTop($(".inner_dvs3")[0]);
});


$('.open_actv').live("mousedown",function(){
  //if($(window).width()<760) openFullscreen();
  $('body').css('overflow', 'hidden');
  //window.history.pushState('forward', null, './#activities');
  $('.show_activities').show();
  $('.show_activities1').show();
  $('.how_to_reg1').hide();
  setTimeout(function(){
    $(".inner_acts").scrollTop($(".inner_acts")[0]);
  },200);
  $('#what_div').val('gifts');
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $(".inner_dvs3").scrollTop($(".inner_dvs3")[0]);
});



$('.how_it_works').live("mousedown",function(){
  $('.show_awards').hide();
  $('.show_activities').show();
  $('.show_activities1').hide();
  $('.how_to_reg1').show();

  setTimeout(function(){
    $(".inner_acts").scrollTop($(".inner_acts")[0]);
  },200);

  $('body').css('overflow-y', 'scroll');
  setTimeout(function(){
    $('.how_to_reg').fadeIn('fast');
  },200);
  if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.how_to_reg').offset().top-34},1500);
  else
    $("html, body").animate({scrollTop:$('.how_to_reg').offset().top-165},1500);
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
});



$('.cmd_exit_fund').live("mousedown",function(){
  $('.fund_wallet').fadeOut('fast');
});


$('.open_fund').live("mousedown",function(){
  $('.show_awards').hide();
  $('.fund_wallet').show();

  $('.div_fund').show();
  $('.div_fund_success').hide();

  setTimeout(function(){
    $(".inner_acts").scrollTop($(".inner_acts")[0]);
  },200);
  $('body').css('overflow-y', 'scroll');
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
});


$('.regs').live("mousedown",function(){
  $('.show_awards').hide();
  $('.show_activities').hide();
  $('body').css('overflow-y', 'scroll');
  setTimeout(function(){
    $('.how_to_reg').fadeIn('fast');
  },200);
  if($(window).width()<760)
    $("html, body").animate({scrollTop:$('#enter_reg').offset().top-40},1500);
  else
    $("html, body").animate({scrollTop:$('#enter_reg').offset().top-165},1500);
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
});


$('.goback_awards, .closeme_gift').live("mousedown",function(e){
  window.history.pushState('forward', null, './#home');
  hide_all2(e);
});


$('.goback_awards1, .closeme_acts').live("mousedown",function(e){
  //window.history.pushState('forward', null, './#home');
  hide_all2(e);
});

$('.closeme_acts_fund, .goback_awards_fund').live("mousedown",function(e){
  $('.fund_wallet').fadeOut('fast');
});


$('.closeme1').live("mousedown",function(){
  if(page_names == "")
  window.history.pushState('forward', null, './#home');
  else
  window.history.pushState('forward', null, './#contestants');
  $('.vote_me').fadeOut('fast');
  $('.open_dv').val(0);
  $('.confirm_vote').hide();
  $('.div_left').fadeIn('fast');
  $('.div_right').fadeIn('fast');
});


$('.edit_profile').live("click",function(){
  $('.header_caption').html('Edit Profile');
  $('.biographys').hide();
  $('.update_pass_div').hide();
  $('.edit_profile_div').fadeIn('fast');
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('body').css('overflow-y', 'scroll');
  if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.gotohere').offset().top+5});
  else
    $("html, body").animate({scrollTop:$('.gotohere').offset().top-95});
});



$('.change_passwd1').live("click",function(){
  $('.header_caption').html('Change Password');
  $('.biographys').hide();
  $('.edit_profile_div').hide();
  $('.update_pass_div').fadeIn('fast');
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('body').css('overflow-y', 'scroll');
  if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.gotohere').offset().top+5});
  else
    $("html, body").animate({scrollTop:$('.gotohere').offset().top-95});
});



$('.closeme2').live("click",function(){
  
    window.history.pushState('forward', null, './#home');
    $('.my_profile').fadeOut('fast');
    $('body').css('overflow-y', 'scroll');

    $('.main_div').show();
    $('.open_dv').val(0);

    if($(window).width()<760)
      $("html, body").animate({scrollTop:$('#gotohere').offset().top+15},1);
    else
      $("html, body").animate({scrollTop:$('#gotohere').offset().top-95},1);
});


$(document).keydown(function(e){
  var code = (e.keyCode ? e.keyCode : e.which);
  hide_all(code, e);
  var txt_srch = $('#txt_srch').val();

  if(code == 13 && (txt_srch!=undefined && txt_srch!="")){ // enter
    if(txt_srch!=undefined && txt_srch!=""){
      //$('.cmd_searchs').click();
      $('.cmd_searchs').trigger('mousedown');
    }
  }
});


function hide_all(code, e){
  var open_div = $('.open_dv').val();
  if(open_div == 1){
    //if(code == 8 || code == 27){   // esc
    if(code == 27){   // esc
      //e.stopPropagation();
      hide_all2(e);
    }
  }
}


function hide_all2(e){
  e.stopPropagation();
  var what_div = $('#what_div').val();
  $('.vote_me').hide();
  $('.my_profile').hide();
  $('body').css('overflow-y', 'scroll');
  $('.show_awards').hide();
  $('.show_activities').hide();
  $('.main_div').show();
  $('.open_dv').val(0);
  $('.gal_loading').show();
  //$('.cmdbackvote').click();
  //$('.cmdno').click();
  $('.cmdbackvote').trigger('mousedown');
  $('.cmdno').trigger('mousedown');

  $('.sliderss').css('visibility','hidden');
  if(what_div != "gifts"){
      if($(window).width()<760)
        $("html, body").animate({scrollTop:$('#gotohere').offset().top+15},1);
      else
        $("html, body").animate({scrollTop:$('#gotohere').offset().top-95},1);
  } 
  setTimeout(function(){
    $('#what_div').val('');
  },200);
}


function hide_all_no_e(){
  $('.vote_me').hide();
  $('.my_profile').hide();
  $('body').css('overflow-y', 'scroll');
  $('.show_awards').hide();
  $('.show_activities').hide();
  $(".expireds").hide();
  $('.main_div').show();
  $('.open_dv').val(0);
  $('.gal_loading').show();
  //$('.cmdbackvote').click();
  $('.cmdbackvote').trigger('mousedown');
  //$('.cmdno').click();
  $('.cmdno').trigger('mousedown');
  $('.contactus').hide();
  $('.uncomplete_profile1').hide();
  $('.pageants').hide();
  $('.photos_div').hide();
  $('.videos_div').hide();
  $('.forum_div').hide();
  $('.events_div').hide();
  $('.policy_div').hide();
  $('.donation_div').hide();
  $('.adverts_div').hide();
  $('.judges_div').hide();
  $('.profile_div').hide();
  $('.events_view').hide();
  $('.forum_view').hide();
  $('.thewinneris').hide();
  $('.participants_div').hide();
  $('.dashboard_div').hide();
  $('.header_for_others').show();
  $('.header_for_dashboard').hide();
  $('.aboutus1').hide();
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.div_all_pages').show();
}



$('.voteme1, .voteme2, .voteme3, .voteme4').live("mousedown",function(){
  window.history.pushState('forward', null, './#vote');
  $('.vote_me').fadeIn('fast');
  $('.open_dv').val(1);
  $(".inner_dvs").scrollTop($(".inner_dvs")[0]);
});


/*$('.owl-carousel').owlCarousel({
  animateOut: 'fadeOut',
  autoplay: true,
  autoplayHoverPause: false,
  autoplaySpeed: 10,
  dots: false,
  lazyLoad: true,
  loop: true,
  mouseDrag: false,
  pullDrag: false,
  touchDrag: false,
  nav: true,
  navText: [
      "&lsaquo;",
      "&rsaquo;"
  ]
});*/


$('.item').each(function(){
  $(this).attr('data-search-term', $(this).text().toLowerCase());
});
  
$('#txtsc').on('keyup', function(){
  $('.owl-carousel').trigger('stop.owl.autoplay');
});


$('.novoteme').live("click",function(){
  alert('Cannot vote! This campaign has expired!');
});


$('.voteme').live("mousedown",function(){
  var names = $(this).attr('names');
  var memids = $(this).attr('memids');
  var pics1 = $(this).attr('pics1');
  var myvotes = $(this).attr('myvotes');
  var swid = $(this).attr('swid');

  $('#conte_id').val(memids);
  $('#acti_id').val(swid);
  $('#con_name').val(names);

  window.history.pushState('forward', null, './#vote');
  $('.vote_me').fadeIn('fast');
  $('.open_dv').val(1);
  $(".inner_dvs").scrollTop($(".inner_dvs")[0]);

  var datastring='memids='+memids
  +'&swid='+swid;
  $.ajax({
    type : "POST",
    url : site_urls+"node/check_if_voted_free",
    data: datastring,
    //cache : false,
    success : function(data){
      $('.cmdvotefree3').hide();
      if(data==1){
        $('.cmdvotefree1').show();
        $('.cmdvotefree').hide();
      }else{
        $('.cmdvotefree').show();
        $('.cmdvotefree1').hide();
      }
    }
});



$('.pics_img').html("<img src='"+pics1+"' />");
$('.p_name1').html(names+" has "+myvotes+" votes");

});



$('.cmdfund_wallet').live("mousedown",function(){
  var txtfund_name = $('#txtfund_name').val();
  var txtfund_phone = $('#txtfund_phone').val();
  var txtfund_amt = $('#txtfund_amt').val();
  $('.cmdfund_wallet').removeClass('cmdfund_wallet').addClass('faded');
  $('.loaders1').show();
  $(".err_details_fund").hide();
  
  var datastring='txtfund_name='+txtfund_name
  +'&txtfund_phone='+txtfund_phone
  +'&txtfund_amt='+txtfund_amt;
  $.ajax({
    type : "POST",
    url : site_urls+"node/fundmywallet",
    data: datastring,
    success : function(data){
      if(data == "fund_submitted"){
        $('.cmdfund_wallet1').addClass('cmdfund_wallet').removeClass('faded');
        $('.loaders1').hide();
        $('.div_fund').hide();
        $('.div_fund_success').fadeIn('fast');
        $('.amts_paid').html('&#8358;'+txtfund_amt);
      }else{
        $('.cmdfund_wallet1').addClass('cmdfund_wallet').removeClass('faded');
        $(".err_details_fund").show().html('<div class="Errormsg">'+data+'</div>');  
        $('.loaders1').hide();
      }
      
    },error : function(data){
      $('.cmdfund_wallet1').addClass('cmdfund_wallet').removeClass('faded');
      $(".err_details_fund").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      $('.loaders1').hide();
    }
  });
});



$('.gobacktoprev').live("mousedown",function(){
  var retrieve_cookies = retrieve_cookie('urls_prev');
  
  //if($(window).width()<760) openFullscreen();

  // var store_memid = retrieve_cookie('store_memid');
  // var fulnames = retrieve_cookie('fulnames');
  // var fname = retrieve_cookie('fname');
  // var lname = retrieve_cookie('lname');
  // var activityid = retrieve_cookie('activityid');
  //hide_all_no_e();
  if(retrieve_cookies=="about") about_us();
  if(retrieve_cookies=="contact") contact_us();
  if(retrieve_cookies=="contestants" || retrieve_cookies=="vote") past_contestants();
  if(retrieve_cookies=="vote") {window.history.pushState('forward', null, './#contestants')};
  if(retrieve_cookies=="events") myevents();
  if(retrieve_cookies=="donation") mydonation();
  if(retrieve_cookies=="adverts") myadverts();
  if(retrieve_cookies=="judges") myjudges();
  if(retrieve_cookies=="photos") myphotos();
  if(retrieve_cookies=="videos") myvideos();
  if(retrieve_cookies=="forum"){
    myforum();
    var frid = retrieve_cookie('frid');
    setTimeout(function(){
      $("html, body").animate({scrollTop:$('.forumBox_scroll'+frid).offset().top-100}, 10);
    },500);
  }
  if(retrieve_cookies=="participants") participants();
  if(retrieve_cookies=="dashboard") mydashboard();
  if(retrieve_cookies=="profiles") view_profiles();
  if(retrieve_cookies=="winner-is") winner_is();  
});


$('.gobacktoprev1').live("mousedown",function(){
  window.history.go(-2);
  //if($(window).width()<760) openFullscreen();

  var frid = retrieve_cookie('frid');
  if(frid!=""){
    setTimeout(function(){
      $("html, body").animate({scrollTop:$('.forumBox_scroll'+frid).offset().top-100}, 10);
    },500);
  }

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");
});


$('.viewprofile').live("mousedown",function(){
  var names = $(this).attr('names');
  var memids = $(this).attr('memids');
  var pics1 = $(this).attr('pics1');
  var myvotes = $(this).attr('myvotes');
  var swid = $(this).attr('swid');
  var myvotes = $(this).attr('myvotes');

  create_cookie('memids1', memids);
  create_cookie('names1', names);
  
  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  $('.p_name').html(names+"'s Profile");
  $('.main_div').hide();
  $('.my_profile').show();
  $('body').css('overflow', 'hidden');
  $('.open_dv').val(1);
  window.history.pushState('forward', null, './#profiles');

  var datastring='memids='+memids
  +'&swid='+swid
  +'&pics1='+pics1
  +'&myvotes='+myvotes;

  $('.pics_img2').html("<img src='"+pics1+"' />");

  $.ajax({
    type : "POST",
    url : site_urls+"node/fetch_contestant_info",
    data: datastring,
    //cache : false,
    success : function(data){
      $('.inner_dvs2').scrollTop(0);
      $('.gal_loading').hide();
      $('.bring_conts_pics').show().html(data);
    }
  });

  $.ajax({
    type : "POST",
    url : site_urls+"node/load_mem_details",
    data: datastring,
    //cache : false,
    success : function(data){
      $('.my_biography').show().html(data);
      $('.vt_counts').html(myvotes+" Votes");
    }
  });
  
});





$('.cmdno').live("mousedown",function(){
  $('.confirm_vote').hide();
  $('.div_left').fadeIn('fast');
  $('.div_right').fadeIn('fast');
  $('.div_entercode1').hide();
  $('.div_entercode2').hide();
  $('.div_entercode3').hide();  
});


$('.cmdbackvote, .cmdbackvote1').live("mousedown",function(){
  $('#txtvote_email').val('');
  $('#txtvote_code').val('');
  $('.div_entermail').hide();
  $('.vote_titl').show();
  $('.err_mail').hide();
  $('.err_mail1').hide();
  $('.div_entercode').hide();
  $('.div_vote_success').hide();
  $('.div_btns').fadeIn('fast');
});


$('.cmdbackvote1').live("mousedown",function(){
  //$('.cmdno').click();
  $('.cmdno').trigger('mousedown');
  $('.cmdvotefree').hide();
  $('.cmdvotefree1').show();
});


$('.cmdbackvote2').live("mousedown",function(){
  //$('.cmdno').click();
  $('.cmdno').trigger('mousedown');
  $('.div_vote_success1').hide();
  $('.div_enterdetails').hide();
  $('.div_btns1').fadeIn('fast');
  //$('#txtvote_acctname').val('');
  //$('#txtbank').val('');
  //$('#txtvote_phone').val('');
  //$('#txtvote_mail1').val('');
  //$('#txtvote_code1').val('');
});


$('.cmdbackvote3').live("mousedown",function(){
  $('.cmdno').trigger('mousedown');
  $('.div_vote_success2').hide();
  $('.div_enterdetails1').hide();
  $('.div_btns2').fadeIn('fast');
  $('#txtvote_name1').val('');
  $('#txtvote_phone1').val('');
});


// $('.cmdyes').live("mousedown",function(){
//   $('.div_btns').hide();
//   $('.div_entermail').fadeIn('fast');
// });



$('.cmdyes').live("click",function(){
    var txtvote_email = $('#txtvote_email').val();
    var conte_id = $('#conte_id').val();
    var acti_id = $('#acti_id').val();
    var con_name = $('#con_name').val();

    var datastring='txtvote_email='+txtvote_email
    +'&conte_id='+conte_id
    +'&acti_id='+acti_id;

    $(".err_mail").hide();
    $('.cmdyes').removeClass('cmdyes').addClass('faded');

    $('.loaders').show();
  
    $.ajax({
      type : "POST",
      url : site_urls+"node/store_voters",
      data: datastring,
      //cache : false,
      success : function(data){
        if(data=="valids"){
          $('.loaders').hide();
          $('.cmdyesi').addClass('cmdyes').removeClass('faded');
          $(".err_mail").hide();
          $('.div_btns').hide();
          //$('.div_entercode').fadeIn('fast');
          $('.div_vote_success').fadeIn('fast');
          $('.p_name2').html(con_name);

        }else{
          $('.loaders').hide();
          $('.cmdyesi').addClass('cmdyes').removeClass('faded');
          $(".err_mail").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; !important; line-height:18px;">'+data+'</div><br>');
        }

      },error : function(data){
        $('.loaders').hide();
        $('.cmdyesi').addClass('cmdyes').removeClass('faded');
        $(".err_mail").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; line-height:19px;">Poor Network Connection!</div>');
      }
    });
});



$('.cmd_pay100').live("mousedown",function(){
  $('.div_btns1').hide();
  $('.div_enterdetails').fadeIn('fast');
});

$('.cmd_pay200').live("mousedown",function(){
  $('.div_btns2').hide();
  $('.div_enterdetails1').fadeIn('fast');
  setTimeout(function(){
    $(".inner_dvs").scrollTop($(".inner_dvs")[0].scrollHeight);
  },100);
});


$('.cmdvotefree').live("mousedown",function(){
  $id1 = 1;
  //$('.cmdno').click();
  $('.cmdno').trigger('mousedown');
  //$('.vote'+$id1).hide();
  $('.div_left').show();
  $('.div_right').show();
  $('.vote_'+$id1).fadeIn('fast');
});


$('.cmdpay100').live("mousedown",function(){
  $id2 = 2;
  $('.vote'+$id2).hide();
  $('.confirm_vote').hide();
  $('.div_left').show();
  $('.div_right').show();
  $('.vote_'+$id2).fadeIn('fast');
});


$('.cmdpay200').live("mousedown",function(){
  $id2 = 3;
  $('.vote'+$id2).hide();
  $('.confirm_vote').hide();
  $('.div_left').show();
  $('.div_right').show();
  $('.vote_'+$id2).fadeIn('fast');
});


$('.cmd_signin_bma').live("click",function(){
    $(".err_div1").hide();
    $('.cmd_signin_bma').hide();
    $('.cmd_signin_bma1').show();
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/logme_bma",
      data: $(".form_logins1").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        if(data=="successor1"){
        $('.cmd_signin_bma').show();
        $('.cmd_signin_bma1').hide();
        setTimeout(function(){
          $(".err_div1").hide();
        },2500);

        window.location = site_urls;

        }else{
        $('.cmd_signin_bma').show();
        $('.cmd_signin_bma1').hide();
        $(".err_div1").show().html('<div class="Errormsg">'+data+'</div><br>');
        }

      },error : function(data){
          $('.cmd_signin_bma').show();
          $('.cmd_signin_bma1').hide();
          $(".err_div1").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.cmd_submitmail').live("click",function(){
    var txtvote_email = $('#txtvote_email').val();
    var conte_id = $('#conte_id').val();
    var acti_id = $('#acti_id').val();
    var datastring='txtvote_email='+txtvote_email
    +'&conte_id='+conte_id
    +'&acti_id='+acti_id;

    $(".err_mail").hide();
    $('.cmd_submitmail').removeClass('cmd_submitmail').addClass('faded');

    $('.loaders').show();
  
    $.ajax({
      type : "POST",
      url : site_urls+"node/store_voters",
      data: datastring,
      //cache : false,
      success : function(data){
        if(data=="valids"){
          $('.loaders').hide();
          
          $('.cmd_submitmail1').addClass('cmd_submitmail').removeClass('faded');

          $(".err_mail").hide();
          $('.div_entermail').hide();
          $('.div_entercode').fadeIn('fast');
        }else{
          $('.loaders').hide();
          $('.cmd_submitmail1').addClass('cmd_submitmail').removeClass('faded');
          $(".err_mail").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; !important; line-height:18px;">'+data+'</div><br>');
        }

      },error : function(data){
        $('.loaders').hide();
        $('.cmd_submitmail1').addClass('cmd_submitmail').removeClass('faded');
        $(".err_mail").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; line-height:19px;">Poor Network Connection!</div>');
      }
    });

});



$('.cmd_submit_details').live("click",function(){
  var txtvote_name = $('#txtvote_name').val();
  var txtvote_phone = $('#txtvote_phone').val();
  var txtvote_ip = $('#txtvote_ip').val();
  var txtwalletamt = $('#txtwalletamt').val();
  var conte_id = $('#conte_id').val();
  var acti_id = $('#acti_id').val();
  var con_amt = 50;
  //var names = $('.voteme').attr('names');
  var new_amt = parseInt(txtwalletamt) - parseInt(con_amt);

  if(txtwalletamt < con_amt){
    alert('You have insufficient amount in your wallet!');
    return false;
  }

  var datastring='txtvote_name='+txtvote_name
  +'&txtvote_phone='+txtvote_phone
  +'&conte_id='+conte_id
  +'&txtvote_ip='+txtvote_ip
  +'&amts='+con_amt
  +'&acti_id='+acti_id;

  $(".err_details").hide();
  $('.cmd_submit_details').removeClass('cmd_submit_details').addClass('faded');
  $('.loaders').show();

  $.ajax({
    type : "POST",
    url : site_urls+"node/store_voters_premium",
    data: datastring,
    //cache : false,
    success : function(data){
      if(data=="valids"){
        $('.loaders').hide();
        $('.cmd_submit_detailsi').addClass('cmd_submit_details').removeClass('faded');
        $(".err_details").hide();
        $('.div_enterdetails').hide();
        $('.div_vote_success1').fadeIn('fast');
        $('.p_name2').html(txtvote_name);
        $('.new_amt').html(new_amt);
        $('#txtwalletamt').val(new_amt);
        
        setTimeout(function(){
          $(".inner_dvs").scrollTop($(".inner_dvs")[0].scrollHeight);
        },200);
      }else{
        $('.loaders').hide();
        $('.cmd_submit_detailsi').addClass('cmd_submit_details').removeClass('faded');
        $(".err_details").show().html('<div class="Errormsg" style="margin:-10px 0 -2px 0; !important; line-height:18px;">'+data+'</div><br>');
      }

    },error : function(data){
      $('.loaders').hide();
      $('.cmd_submit_detailsi').addClass('cmd_submit_details').removeClass('faded');
      $(".err_details").show().html('<div class="Errormsg" style="margin:-10px 0 -2px 0; line-height:19px;">Poor Network Connection!</div>');
    }
  });
});



$('.cmd_submit_details100').live("click",function(){
  var txtvote_name = $('#txtvote_name').val();
  var txtvote_phone = $('#txtvote_phone').val();
  var txtvote_ip = $('#txtvote_ip').val();
  var txtwalletamt = $('#txtwalletamt').val();
  var conte_id = $('#conte_id').val();
  var acti_id = $('#acti_id').val();
  var con_amt = 100;
  //var names = $('.voteme').attr('names');
  var new_amt = parseInt(txtwalletamt) - parseInt(con_amt);

  if(txtwalletamt < con_amt){
    alert('You have insufficient amount in your wallet!');
    return false;
  }

  var datastring='txtvote_name='+txtvote_name
  +'&txtvote_phone='+txtvote_phone
  +'&conte_id='+conte_id
  +'&txtvote_ip='+txtvote_ip
  +'&amts='+con_amt
  +'&acti_id='+acti_id;

  $(".err_details1").hide();
  $('.cmd_submit_details100').removeClass('cmd_submit_details100').addClass('faded');
  $('.loaders').show();

  $.ajax({
    type : "POST",
    url : site_urls+"node/store_voters_premium",
    data: datastring,
    //cache : false,
    success : function(data){
      if(data=="valids"){
        $('.loaders').hide();
        $('.cmd_submit_details100i').addClass('cmd_submit_details100').removeClass('faded');
        $(".err_details1").hide();
        $('.div_enterdetails1').hide();
        $('.div_vote_success2').fadeIn('fast');
        
        $('.p_name2').html(txtvote_name);
        $('.new_amt').html(new_amt);
        $('#txtwalletamt').val(new_amt);
        
        setTimeout(function(){
          $(".inner_dvs").scrollTop($(".inner_dvs")[0].scrollHeight);
        },200);
      }else{
        $('.loaders').hide();
        $('.cmd_submit_details100i').addClass('cmd_submit_details100').removeClass('faded');
        $(".err_details1").show().html('<div class="Errormsg" style="margin:-10px 0 -2px 0; !important; line-height:18px;">'+data+'</div><br>');
      }

    },error : function(data){
      $('.loaders').hide();
      $('.cmd_submit_details100i').addClass('cmd_submit_details100').removeClass('faded');
      $(".err_details1").show().html('<div class="Errormsg" style="margin:-10px 0 -2px 0; line-height:19px;">Poor Network Connection!</div>');
    }
  });
});



$('#cmd_votenow1').live("click",function(){
  var txtvote_acctname = $('#txtvote_acctname').val();
  var txtbank = $('#txtbank').val();
  var ussd2ussd = $('#txtbank').find('option:selected').attr('ussd2ussd');
  var ussd2other = $('#txtbank').find('option:selected').attr('ussd2other');

  var txtvote_phone = $('#txtvote_phone').val();
  var txtvote_mail1 = $('#txtvote_mail1').val();
  var txtcompanybank = $('#txtcompanybank').val();
  var companyacct = $('#txtcompanyacct').val();
  var txtvote_code1 = $('#txtvote_code1').val();

  if(txtbank=="Ecobank" || txtbank=="UBA Bank"){
    var ussd_posn = "";
  }else{
    if(txtbank=="Fidelity Bank" || txtbank=="Wema Bank" || txtbank=="Diamond Bank" || txtbank=="Unity Bank" || txtbank=="Heritage Bank"){
      var ussd_posn = companyacct+"*50#";
    }else{
      var ussd_posn = "50*"+companyacct+"#";
    }
  }

  if(txtbank == txtcompanybank) // if its bank to bank (same bank)
    var hrefs = "tel:"+ussd2ussd+ussd_posn;
  else{
    if(ussd2other!="")
      var hrefs = "tel:"+ussd2other+ussd_posn;
    else
      var hrefs = "tel:"+ussd2ussd+ussd_posn;
  }

  // alert(hrefs);
  // return false;
  
  var conte_id = $('#conte_id').val();
  var acti_id = $('#acti_id').val();

  if(confirm("USSD codes for all banks have been saved here and will pop up with the USSD code and\r\nOurFavCelebs company's account number as you click on the OK button.\r\n\r\nProceed to submit your details and continue?")){

    var datastring='txtvote_acctname='+txtvote_acctname
    +'&txtbank='+txtbank
    +'&txtvote_phone='+txtvote_phone
    +'&txtvote_mail1='+txtvote_mail1
    +'&txtvote_code1='+txtvote_code1
    +'&conte_id='+conte_id
    +'&amts=50'
    +'&acti_id='+acti_id;

    $(".err_details").hide();
    $('.cmd_submit_details').removeClass('cmd_submit_details').addClass('faded');

    $('.loaders1').show();

    $.ajax({
      type : "POST",
      url : site_urls+"node/store_voters_premium1",
      data: datastring,
      //cache : false,
      success : function(data){
        if(data=="valids2"){
          window.location.href=hrefs;
          $('.loaders1').hide();
          $('.cmd_submit_details1').addClass('cmd_submit_details').removeClass('faded');
          $(".err_details").hide();
          $('#txtvote_code1').val('');
          $('.div_entercode1').hide();
          $('.div_vote_success1').fadeIn('fast');
          $('.p_name2').html(names);
        }else{
          $('.loaders1').hide();
          $('.cmd_submit_details1').addClass('cmd_submit_details').removeClass('faded');
          $(".err_details").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; !important; line-height:18px;">'+data+'</div><br>');
        }

      },error : function(data){
        $('.loaders1').hide();
        $('.cmd_submit_details1').addClass('cmd_submit_details').removeClass('faded');
        $(".err_details").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; line-height:19px;">Poor Network Connection!</div><br>');
      }
    });
  }
});



/*$('.cmd_submit_details1').live("click",function(){
  var txtvote_acctname = $('#txtvote_acctname1').val();
  var txtbank = $('#txtbank1').val();
  var ussd2ussd = $('#txtbank1').find('option:selected').attr('ussd2ussd');
  var ussd2other = $('#txtbank1').find('option:selected').attr('ussd2other');

  var txtvote_phone = $('#txtvote_phone1').val();
  var txtvote_mail1 = $('#txtvote_mail2').val();
  var txtcompanybank = $('#txtcompanybank').val();
  var companyacct = $('#txtcompanyacct').val();
  
  var conte_id = $('#conte_id').val();
  var acti_id = $('#acti_id').val();

  var datastring='txtvote_acctname='+txtvote_acctname
  +'&txtbank='+txtbank
  +'&txtvote_phone='+txtvote_phone
  +'&txtvote_mail1='+txtvote_mail1
  +'&conte_id='+conte_id
  +'&amts=100'
  +'&acti_id='+acti_id;

  $(".err_details").hide();
  $('.cmd_submit_details1').removeClass('cmd_submit_details1').addClass('faded');
  $('.loaders').show();

  $.ajax({
    type : "POST",
    url : site_urls+"node/store_voters_premium",
    data: datastring,
    //cache : false,
    success : function(data){
      if(data=="valids"){
        //window.location.href=hrefs;
        $('.loaders').hide();
        $('.cmd_submit_details1i').addClass('cmd_submit_details1').removeClass('faded');
        $(".err_details").hide();
        $('.div_enterdetails1').hide();
        $('.div_entercode2').fadeIn('fast');

        setTimeout(function(){
          $(".inner_dvs").scrollTop($(".inner_dvs")[0].scrollHeight);
        },200);
        
      }else{
        $('.loaders').hide();
        $('.cmd_submit_details1i').addClass('cmd_submit_details1').removeClass('faded');
        $(".err_details").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; !important; line-height:18px;">'+data+'</div><br>');
      }

    },error : function(data){
      $('.loaders').hide();
      $('.cmd_submit_details1i').addClass('cmd_submit_details1').removeClass('faded');
      $(".err_details").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; line-height:19px;">Poor Network Connection!</div>');
    }
  });
  
});*/



$('#cmd_votenow2').live("click",function(){
  var txtvote_acctname = $('#txtvote_acctname1').val();
  var txtbank = $('#txtbank1').val();
  var ussd2ussd = $('#txtbank1').find('option:selected').attr('ussd2ussd');
  var ussd2other = $('#txtbank1').find('option:selected').attr('ussd2other');
  
  var txtvote_phone = $('#txtvote_phone1').val();
  var txtvote_mail1 = $('#txtvote_mail2').val();
  var txtcompanybank = $('#txtcompanybank').val();
  var companyacct = $('#txtcompanyacct').val();
  var txtvote_code1 = $('#txtvote_code2').val();

  if(txtvote_code1=="")
    alert("Please type the code from your email");

  else{

    if(txtbank=="Ecobank" || txtbank=="UBA Bank"){
      var ussd_posn = "";
    }else{
      if(txtbank=="Fidelity Bank" || txtbank=="Wema Bank" || txtbank=="Diamond Bank" || txtbank=="Unity Bank" || txtbank=="Heritage Bank"){
        var ussd_posn = companyacct+"*50";
      }else{
        var ussd_posn = "50*"+companyacct;
      }
    }

    if(txtbank == txtcompanybank) // if its bank to bank (same bank)
      var hrefs = "tel:"+ussd2ussd+ussd_posn+"#";
    else{
      if(ussd2other!="")
        var hrefs = "tel:"+ussd2other+ussd_posn+"#";
      else
        var hrefs = "tel:"+ussd2ussd+ussd_posn+"#";
    }
    
    var conte_id = $('#conte_id').val();
    var acti_id = $('#acti_id').val();

    if(confirm("USSD codes for all banks have been saved here and will pop up with the USSD code and\r\nOurFavCelebs company's account number as you click on the OK button.\r\n\r\nProceed to submit your details and continue?")){

      var datastring='txtvote_acctname='+txtvote_acctname
      +'&txtbank='+txtbank
      +'&txtvote_phone='+txtvote_phone
      +'&txtvote_mail1='+txtvote_mail1
      +'&txtvote_code1='+txtvote_code1
      +'&conte_id='+conte_id
      +'&amts=50'
      +'&acti_id='+acti_id;

      $(".err_details1").hide();
      $('.cmd_submit_details').removeClass('cmd_submit_details').addClass('faded');
      $('.loaders2').show();

      $.ajax({
        type : "POST",
        url : site_urls+"node/store_voters_premium1",
        data: datastring,
        //cache : false,
        success : function(data){
          //alert(data);
          if(data=="valids2"){
            window.location.href=hrefs;
            $('.loaders2').hide();
            $('.cmd_submit_details1').addClass('cmd_submit_details').removeClass('faded');
            $(".err_details1").hide();
            $('#txtvote_code1').val('');
            $('.div_entercode2').hide();
            $('.div_vote_success2').fadeIn('fast');
            $('.p_name2').html(names);
          }else{
            $('.loaders2').hide();
            $('.cmd_submit_details1').addClass('cmd_submit_details').removeClass('faded');
            $(".err_details1").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; !important; line-height:18px;">'+data+'</div><br>');
            //$(".err_details").show().html('<div class="Errormsg" style=margin:-10px 0 5px 0; line-height:19px;">Invalid code entered!</div><br>');
          }

        },error : function(data){
          $('.loaders2').hide();
          $('.cmd_submit_details1').addClass('cmd_submit_details').removeClass('faded');
          $(".err_details1").show().html('<div class="Errormsg" style="margin:-10px 0 -10px 0; line-height:19px;">Poor Network Connection!</div><br>');
        }
      });
    }
  }
});



$('.hitLink').live("mousedown",function(){
  var href1 = $(this).attr('href1');
  window.open(href1);
  return false;
});




$('.cmd_votenow').live("click",function(){
  var txtvote_email = $('#txtvote_email').val();
  var txtvote_code = $('#txtvote_code').val();
  var acti_id = $('#acti_id').val();
  var names = $('.voteme').attr('names');
  var memids = $('.voteme').attr('memids');
  
  var datastring='txtvote_email='+txtvote_email
  +'&txtvote_code='+txtvote_code
  +'&acti_id='+acti_id;

  $(".err_mail1").hide();
  $('.cmd_votenow').removeClass('cmd_votenow').addClass('faded');
  $('.loaders1').show();

  $.ajax({
    type : "POST",
    url : site_urls+"node/store_update_voters",
    data: datastring,
    //cache : false,
    success : function(data){
      if(data=="Invalid"){
        $('.loaders1').hide();
        $('.cmd_votenowi').addClass('cmd_votenow').removeClass('faded');
        $(".err_mail1").show().html('<div class="Errormsg" style=margin:-10px 0 5px 0; line-height:19px;">Invalid code entered!</div><br>');
      }else{
        $('.loaders1').hide();
        $('.cmd_votenowi').addClass('cmd_votenow').removeClass('faded');
        $(".err_mail1").hide();
        $('.div_entercode').hide();
        $('.vote_titl').hide();
        $('.div_vote_success').fadeIn('fast');
        $('.p_name1').html(names+" has "+data+" votes");
        $('.p_name2').html(names);
        $('.vote_counts'+memids).html(data);
      }

    },error : function(data){
      $('.loaders1').hide();
      $('.cmd_votenowi').addClass('cmd_votenow').removeClass('faded');
      $(".err_mail1").show().html('<div class="Errormsg" style="margin:-10px 0 5px 0; line-height:19px;">Poor Network Connection!</div>');
    }
  });

});




$('.cmd_signin_bma_buyer').live("click",function(){
    $(".err_div1").hide();
    $('.cmd_signin_bma_buyer').hide();
    $('.cmd_signin_bma_buyer1').show();
    
    
    $.ajax({
      type : "POST",
      url : site_urls+"node/logme_bma_buyer",
      data: $(".form_logins1").serialize(),
      //cache : false,
      success : function(data){
        //alert(data)
        
        if($.isNumeric(data)){
          $('.cmd_signin_bma_buyer').show();
          $('.cmd_signin_bma_buyer1').hide();
          $('.frm_log_buyer').slideUp('fast');
          //$('.err_div').slideUp('fast');
          $('.memid').val(data);

          if(txtmthd == "online")
            //$('.online_pays').click();
            $('.online_pays').trigger('mousedown');
          else
            //$('.bank_trans_1').click();
            $('.bank_trans_1').trigger('mousedown');

        }else{
        $('.cmd_signin_bma_buyer').show();
        $('.cmd_signin_bma_buyer1').hide();
        $(".err_div1").show().html('<div class="Errormsg">'+data+'</div><br>');
        }

      },error : function(data){
          $('.cmd_signin_bma_buyer').show();
          $('.cmd_signin_bma_buyer1').hide();
          $(".err_div1").show().html('<div class="Errormsg">Poor Network Connection!</div>');
      }
    });
});



$('.cmd_forgot_bma').live("click",function(){
  $(".err_div1_f").hide();
  $('.cmd_forgot_bma').hide();
  $('.cmd_forgot_bma1').show();
  
  $.ajax({
    type : "POST",
    url : site_urls+"node/reset_pass",
    data: $(".form_forgot").serialize(),
    //cache : false,
    success : function(data){
      //alert(data)
      if(data=="email_sent_success_1"){
      $('.cmd_forgot_bma').show();
      $('.cmd_forgot_bma1').hide();
      
      $('.forgot_pass_div').hide();
      $('.suc_form').slideDown('fast');

      }else{
      $('.cmd_forgot_bma').show();
      $('.cmd_forgot_bma1').hide();
      $(".err_div1_f").show().html('<div class="Errormsg">'+data+'</div>');
      }

    },error : function(data){
        $('.cmd_forgot_bma').show();
        $('.cmd_forgot_bma1').hide();
        $(".err_div1_f").show().html('<div class="Errormsg">Poor Network Connection!</div>');
    }
  });
});



$('.cmd_resetpass').live("click",function(){
  //e.preventDefault();
  $(".err_div1").hide();
  $('.cmd_resetpass').hide();
  $('.cmd_resetpass1').show();
  $.ajax({
    type : "POST",
    url : site_urls+"node/reset_new_pass",
    data: $(".reset_pass1").serialize(),
    //cache : false,
    success : function(data){
      //alert(data)
        if(data=="success_updated2"){
        $('.cmd_resetpass').show();
        $('.cmd_resetpass1').hide();
        
        $(".reset_pass1")[0].reset();
        $(".err_div1").show().html('<div class="successmsg">Your password has been updated successfully!</div>');
        
        setTimeout(function(){
          $(".err_div1").show().html('<div class="successmsg">Redirecting, please wait...</div>');
        },1500);

        setTimeout(function(){
        $(".err_div1").fadeOut('slow');
        window.location = site_urls;
        },4000);
        
        }else{
        $('.cmd_resetpass').show();
        $('.cmd_resetpass1').hide();
        $(".err_div1").show().html('<div class="Errormsg">'+data+'</div>');
        }

    },error : function(data){
        $('.cmd_resetpass').show();
        $('.cmd_resetpass1').hide();
        $(".err_div1").show().html('<div class="Errormsg">'+data+'</div>');
    }
  });
});



function precise_round(num, decimals) {
   var t = Math.pow(10, decimals);   
   return (Math.round((num * t) + (decimals>0?1:0)*(Math.sign(num) * (10 / Math.pow(100, decimals)))) / t).toFixed(decimals);
}



$('#cmd_log_adm').live("click",function(){
  $.ajax({
    type : "POST",
    url : site_urls+"adminx/logme_adm",
    data: $("#form_login1").serialize(),
    //cache : false,
    success : function(data){
      if(data == 'success1'){
        window.location = site_urls+"adminx/";
      }else{
        $("#buttons_reg").show();
        $("#Errormsg6").show().html(data);
      }
    },error : function(data){
      $(".buttons_reg").show();
      $("#Errormsg6").show().html(data);
    }
  });
});




$('#txtinvoice_amt').live("keyup",function(){
  $('#cmd_calc').click();
});

$('#txtinvoice_amt').live("change",function(){
  $('#cmd_calc').click();
});

$('#txttenures').live("click",function(){
  $('#cmd_calc').click();
});

$('#txttenures').live("change",function(){
  $('#cmd_calc').click();
});




$('.contact_us').live("mousedown",function(){
  contact_us();
});


function contact_us(){
  hide_all_no_e();
  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  window.history.pushState('forward', null, './#contact');
  create_cookie('urls', site_urls+"pages/#contact");
  $('.page_titl').html('Contact Us'+head_titles);
  $('.very_large_text1').html('<span>Contact</span> <font>Us</font>');
  $('.contactus').show();
}


$('.about_us').live("mousedown",function(){
  about_us();
});


function about_us(){
  hide_all_no_e();
  var hash = location.hash.substring(1);
  create_cookie('urls_prev', hash);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  window.history.pushState('forward', null, './#about');
  create_cookie('urls', site_urls+"pages/#about");
  $('.page_titl').html('About Us'+head_titles);
  $('.very_large_text1').html('<span>About</span> <font>Us</font>');
  $('.aboutus1').show();
}


$('.events').live("mousedown",function(){
  myevents();
});


$('.donation').live("mousedown",function(){
  mydonation();
});


$('.adverts').live("mousedown",function(){
  myadverts();
});


$('.judges').live("mousedown",function(){
  myjudges();
});


$('.photos').live("mousedown",function(){
  myphotos();
});


$('.videos').live("mousedown",function(){
  myvideos();
});

$('.forum').live("mousedown",function(){
  myforum();
});


$('.policy').live("mousedown",function(){
  mypolicy();
});


function mypolicy(){
  hide_all_no_e();
  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".policy_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading policy...</div>');
  window.history.pushState('forward', null, './#policy');
  create_cookie('urls', site_urls+"pages/#policy");
  
  $('.page_titl').html('Privacy & Policy'+head_titles);
  $('.very_large_text1').html('<span>Privacy &</span> <font>Policy</font>');
  $.ajax({
    type : "POST",
    url : site_urls+"node/privacy_loads/",
    //cache : false,
    success : function(data){
      //alert(data)
      $('.policy_div').show().html(data);
    },error : function(data){
    }
  });
}


function myevents(){
  hide_all_no_e();
  
  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);
  create_cookie('scrolls', '');
  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".events_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading events...</div>');
  window.history.pushState('forward', null, './#events');
  create_cookie('urls', site_urls+"pages/#events");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  
  $('.page_titl').html('Events'+head_titles);
  $('.very_large_text1').html('<span>Our</span> <font>Events</font>');
  var pageNum = retrieve_cookie('pageNum');
  if(pageNum=="" || pageNum=="undefined")
    var pageNum = 0;
  var scrolls = retrieve_cookie('scrolls');
  $.ajax({
    type : "POST",
    url : site_urls+"node/events_loads/"+pageNum,
    //cache : false,

    success : function(data){
      $('.events_div').show().html(data);
      if(scrolls!=""){
        setTimeout(function(){
          $("html, body").animate({scrollTop:$('.scroll_to_mem'+scrolls).offset().top-20}, 10);
        },50);
      }
    },error : function(data){
    }
  });
}


function createPagination(pageNum){
    $(".events_div").html('<div class="load_inners"><img src="'+site_urls+'images/loader.gif"> Loading next page...</div>');
    var scrolls = retrieve_cookie('scrolls');
		$.ajax({
			url : site_urls+'node/events_loads/'+pageNum,
			type: 'get',
			//dataType: 'json',
			success: function(responseData){
        $('.events_div').html(responseData);
        if(scrolls!=""){
          setTimeout(function(){
            $("html, body").animate({scrollTop:$('.scroll_to_mem'+scrolls).offset().top-20}, 10);
          },50);
        }
			},error: function(responseData){
			}
		});
  }


function mydonation(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".donation_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading donation...</div>');
  window.history.pushState('forward', null, './#donation');
  create_cookie('urls', site_urls+"pages/#donation");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Donation'+head_titles);
  $('.very_large_text1').html('<span>Our</span> <font>Donation</font>');

  $.ajax({
    type : "POST",
    url : site_urls+"node/donation_loads",
    //cache : false,
    success : function(data){
      $('.donation_div').show().html(data);
    },error : function(data){
    }
  });
}


function myadverts(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".adverts_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading adverts...</div>');
  window.history.pushState('forward', null, './#adverts');
  create_cookie('urls', site_urls+"pages/#adverts");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Adverts'+head_titles);
  $('.very_large_text1').html('<span>Advertisements</span>');

  $.ajax({
    type : "POST",
    url : site_urls+"node/adverts_loads",
    //cache : false,
    success : function(data){
      $('.adverts_div').show().html(data);
    },error : function(data){
    }
  });
}


function myjudges(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");
    
  create_cookie('urls_prev', hash);
  $(".judges_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading judges...</div>');
  window.history.pushState('forward', null, './#judges');
  create_cookie('urls', site_urls+"pages/#judges");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Meet Our Judges'+head_titles);
  $('.very_large_text1').html('<span>Meet Our Judges</span>');
  $.ajax({
    type : "POST",
    url : site_urls+"node/judges_loads",
    //cache : false,
    success : function(data){
      $('.judges_div').show().html(data);
    },error : function(data){
    }
  });
}


function myphotos(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".videos_div").hide();
  $(".photos_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading photos...</div>');
  window.history.pushState('forward', null, './#photos');
  create_cookie('urls', site_urls+"pages/#photos");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Photos'+head_titles);
  $('.very_large_text1').html('<span>Our</span> <font>Photos</font>');
  $.ajax({
    type : "POST",
    url : site_urls+"node/photos_loads",
    //cache : false,
    success : function(data){
      $('.photos_div').show().html(data);
    },error : function(data){
    }
  });
}


function myvideos(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".photos_div").hide();
  $(".videos_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading videos...</div>');
  window.history.pushState('forward', null, './#videos');
  create_cookie('urls', site_urls+"pages/#videos");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Videos'+head_titles);
  $('.very_large_text1').html('<span>Our</span> <font>Videos</font>');
  $.ajax({
    type : "POST",
    url : site_urls+"node/videos_loads",
    //cache : false,
    success : function(data){
      $('.videos_div').show().html(data);
    },error : function(data){
    }
  });
}


function myforum(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);
  create_cookie('cats_f', '');
  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".forum_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading forum...</div>');
  window.history.pushState('forward', null, './#forum');
  create_cookie('urls', site_urls+"pages/#forum");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Forum'+head_titles);
  $('.very_large_text1').html('<span>Our</span> <font>Forum</font>');
  $.ajax({
    type : "POST",
    url : site_urls+"node/forum_loads",
    cache : false,
    success : function(data){
      //alert(data)
      $('.forum_div').show().html(data);
    },error : function(data){
      //alert(data)
    }
  });
}



/*$('.refresh_page').live("click",function(){
  var memids = $(this).attr('memids');
  var datastring='page='
  +'&txtparams='
  +'&txtmemsid='+memids
  +'&txtcats1=0';
  //alert('datastring')

  $(".loaders_").show().html("Loading category...<br><img src='"+site_urls+"images/loader.gif'>");
  $.ajax({
    type : "POST",
    url : site_urls+"node/getForums",
    data : datastring,
    //cache : false,
    success : function(data){
      ///alert(data)
      var responseReturn = data.match(/Edit this post/g);
      if(responseReturn != null){
          $(".successm").val(data);
          if($(".successm").val().match(/^.*No saved.*$/)){
              $('.load_more_bt').hide();
          }else{
              $('#load_more_mba').data('val', ($('#load_more_mba').data('val')+1));
          }
      }else{
          $('#load_more_mba').hide();
          $('#load_more_mba1').show();
          $('.load_more_bt, .load_more_bma1').html('<font style="color:#999 !important;">No more threads!</font>');
      }
      $("#ajax_table_forum").show().empty().html(data);
      $(".loaders_").hide();
    },error : function(data){
    }
  });
  
});*/


$('.Errormsg').live("click",function(){
  $('.Errormsg').fadeOut('fast');
});


$('.past_contestants').live("click",function(){
  past_contestants();
});


$('.past_contestants_home').live("mousedown",function(){
  $(this).html('Loading Contestants...');
  window.location = site_urls+"pages/#contestants";
});


function past_contestants(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  create_cookie('urls_prev', hash);
  $(".pageants").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading contestants...</div>');
  window.history.pushState('forward', null, './#contestants');
  create_cookie('urls', site_urls+"pages/#contestants");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('Our Contestants'+head_titles);
  $('.very_large_text1').html('<span>Our</span> <font>Contestants</font>');
  var scrolls = retrieve_cookie('scrolls');
  var txt_srch = retrieve_cookie('txt_srch');
  var page = retrieve_cookie('pageNum');

  var ids_tl = retrieve_cookie('ids');
  var tils_tl = retrieve_cookie('tils');

  if(scrolls!=""){
    setTimeout(function(){
      $("html, body").animate({scrollTop:$('.scroll_to_mem'+scrolls).offset().top-20}, 10);
    },50);
  }else{
    if($(window).width() < 760)
    $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
    else
    $("html, body").animate({scrollTop:$('.scrltotop').offset().top+140}, "fast");
  }
  
  if(txt_srch=="" || txt_srch=="undefined") var txt_srch = "";
  if(page=="" || page=="undefined") var page = 0;

  var datastring='txt_srch='+txt_srch
  +'&ids_tl='+ids_tl // session
  +'&record='+page;

  $.ajax({
    type : "POST",
    url : site_urls+"node/pageants_loads",
    data : datastring,
    success : function(data){
      $('.pageants').show().html(data);
    },error : function(data){
    }
  });
}



$('.winner_is').live("mousedown",function(){
  winner_is();
});



function winner_is(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();
  
  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".thewinneris").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading winner-is...</div>');
  window.history.pushState('forward', null, './#winner-is');
  create_cookie('urls', site_urls+"pages/#winner-is");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $('.page_titl').html('And Winners Is'+head_titles);
  $('.very_large_text1').html('<font>And The</font> <span>Winners Is?</span>');
  $.ajax({
    type : "POST",
    url : site_urls+"node/winneris_loads",
    //data : datastring,
    //cache : false,
    success : function(data){
      $('.thewinneris').show().html(data);
    },error : function(data){
    }
  });
}


$('.participants').live("mousedown",function(){
  participants();
});


function participants(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);

  if($(window).width() < 760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

  create_cookie('urls_prev', hash);
  $(".participants_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading participants...</div>');
  window.history.pushState('forward', null, './#participants');
  create_cookie('urls', site_urls+"pages/#participants");
  $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
  $.ajax({
    type : "POST",
    url : site_urls+"node/participants_loads",
    //cache : false,
    success : function(data){
      
      var data1 = data.substring(0, 12);
      $('.page_titl').html('Pageant Activities'+head_titles);
      $('.very_large_text1').html('<span>Pageant</span> <font>Activities</font>');

      if(data1=="not_complete"){
        $('.uncomplete_profile').show();
        $(".participants_div").hide();

      }else if(data=="logged_out"){
        $(".dashboard_div").hide();
        $(".participants_div").hide();
        $(".expireds").show();
        $('.page_titl').html('Expired Session'+head_titles);

      }else{

        $('.uncomplete_profile').hide();
        $('.participants_div').show().html(data);
      
    }

    },error : function(data){
    }
  });
}



$('.cmd_done_update').live("mousedown",function(){
  $('.success1_div').hide();
  $('.biographys').fadeIn('fast');
  mydashboard();
});



$('.mydashboard, .compl_profile').live("mousedown",function(){
  mydashboard();
});



function mydashboard(){
    hide_all_no_e();

    if($(window).width() < 760)
      $('.for_desktop2').hide();
    else
      $('.for_desktop2').show();

    var hash = location.hash.substring(1);

    if($(window).width() < 760)
    $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
    else
    $("html, body").animate({scrollTop:$('.scrltotop').offset().top+40}, "fast");

    create_cookie('urls_prev', hash);
    fullnames = $('.txtfullnames').val();
    $('.header_for_others').hide();
    $('.header_for_dashboard').show();
    $('.header_caption').html(fullnames+' Profile');
    $('.edit_profile_div').hide();
    $('.update_pass_div').hide();
    $(".menu-icon a").removeClass('open');$('.menu-main').removeClass('open');
    
    $(".dashboard_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading dashboard...</div>');
    window.history.pushState('forward', null, './#dashboard');
    create_cookie('urls', site_urls+"pages/#dashboard");
    $.ajax({
      type : "POST",
      url : site_urls+"node/dashboard_loads",
      //cache : false,
      success : function(data){
        $('body').css('overflow-y', 'scroll');
        $('.very_large_text1').html('<span>My</span> <font>Account</font>');
        if(data=="logged_out"){
          $(".dashboard_div").hide();
          $(".expireds").show();
          $('.page_titl').html('Expired Session'+head_titles);
        }else{
          $('.biographys').show();
          $('.page_titl').html(fullnames+head_titles);
          $('.dashboard_div').show().html(data);
  
          if($(window).width()<760)
            $("html, body").animate({scrollTop:$('.gotohere').offset().top+5});
          else
            $("html, body").animate({scrollTop:$('.gotohere').offset().top-95});
        }
      },error : function(data){
      }
    });
}



function view_profiles(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);
  create_cookie('urls_prev', hash);
  create_cookie('scrolls', memids);

  var memids = retrieve_cookie('store_memid');
  var fulnames = retrieve_cookie('fulnames');
  var fname = retrieve_cookie('fname');
  var lname = retrieve_cookie('lname');
  var activityid = retrieve_cookie('activityid');

  $(".profile_div").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading profile...</div>');
  window.history.pushState('forward', null, './#profiles');
  create_cookie('urls', site_urls+"pages/#profiles");
  
  var datastring='memids='+memids
  +'&activityid='+activityid;
  
  $.ajax({
    type : "POST",
    url : site_urls+"node/profile_loads",
    data : datastring,
    //cache : false,
    success : function(data){

      if(data == 'logged_out'){
        $(".dashboard_div").hide();
        $(".expireds").show();
        $('.page_titl').html('Expired Session'+head_titles);
      }else{

        if(fname!="undefined"){
          $('.page_titl').html(fulnames+head_titles);
          $('.very_large_text1').html('<span>'+fname+'</span> <font>'+lname+'</font>');
        }else{
          $('.page_titl').html("Error Page"+head_titles);
          $('.very_large_text1').html('<span>Error</span> <font>Page</font>');
        }

        $('.profile_div').show().html(data);

        setTimeout(function(){
          $(".show_my_profile").hide();
        },100);

        setTimeout(function(){
          if($(window).width()<760)
            $("html, body").animate({ scrollTop: 100 }, "fast");
          else
            $("html, body").animate({ scrollTop: 140 }, "fast");
        },500);
      }
      
    },error : function(data){
    }
  });
}


$('.view_profiles').live("mousedown",function(){
  var memids = $(this).attr('memid');
  var fulnames = $(this).attr('fulnames');
  var fname = $(this).attr('fname');
  var lname = $(this).attr('lname');
  var activityid = $(this).attr('activityid');
  
  create_cookie('store_memid', memids);
  create_cookie('fulnames', fulnames);
  create_cookie('fname', fname);
  create_cookie('lname', lname);
  create_cookie('activityid', activityid);

  //view_profiles(memids, fulnames, fname, lname, activityid);
  view_profiles();
});


$('.view_profiles_home').live("mousedown",function(){
  var memids = retrieve_cookie('memids1');
  var names1 = retrieve_cookie('names1');
  names1 = names1.split(" ").join("-").toLowerCase();
  window.location = site_urls+"viewprofile/"+memids+"8947/"+names1+"/";
});




$('.open_event').live("click",function(){
  var evtid = $(this).attr('evtid');
  var tils = $(this).attr('tils');
  var directs1 = $(this).attr('directs1');
  create_cookie('evtid', evtid);
  create_cookie('tils', tils);
  open_event();
});



  $('.event_pagn a').live("mousedown",function(e){
		e.preventDefault(); // this will prevent it from refreshing
    var pageNum = $(this).attr('data-ci-pagination-page');
    create_cookie('pageNum', pageNum);
    $(".load_contents").html('<div class="load_inners"><img src="'+site_urls+'images/loader.gif"> Loading next page...</div>');
    $.ajax({
      url: site_urls+'node/media/'+pageNum,
			type: 'post',
			success: function(responseData){
        $('.load_contents').html(responseData);
			},error: function(responseData){
			}
		});
  });


  $('.photos_pagn a').live("mousedown",function(e){
		e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    create_cookie('pageNum', pageNum);
    $(".load_gallerys").html('<div class="load_inners"><img src="'+site_urls+'images/loader.gif"> Loading next page...</div>');
    $.ajax({
      url: site_urls+'node/photos/'+pageNum,
			type: 'post',
			success: function(responseData){
				$('.load_gallerys').html(responseData);
			},error: function(responseData){
			}
		});
  });


  $('.videos_pagn a').live("mousedown",function(e){
		e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    create_cookie('pageNum', pageNum);
    $(".load_gallerys").html('<div class="load_inners"><img src="'+site_urls+'images/loader.gif"> Loading next page...</div>');
    $.ajax({
      url: site_urls+'node/videos/'+pageNum,
			type: 'post',
			success: function(responseData){
				$('.load_gallerys').html(responseData);
			},error: function(responseData){
			}
		});
  });


  $('.conts_pagn a').live("mousedown",function(e){
		e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    create_cookie('pageNum', pageNum);
    $(".load_contestns").html('<div class="load_inners"><img src="'+site_urls+'images/loader.gif"> Loading next page...</div>');
    $.ajax({
      url: site_urls+'node/contestant/'+pageNum,
			type: 'post',
			success: function(responseData){
        $('.load_contestns').html(responseData);
			},error: function(responseData){
			}
		});
  });
  
	

function open_event(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);
  create_cookie('urls_prev', hash);
  create_cookie('scrolls', evtid);

  var evtid = retrieve_cookie('evtid');
  var tils = retrieve_cookie('tils');

  if($(window).width()<760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+120}, "fast");

  $(".events_view").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading events...</div>');
  window.history.pushState('forward', null, './#viewevents');
  create_cookie('urls', site_urls+"pages/#viewevents");

  if(tils!="undefined"){
    $('.page_titl').html(tils+head_titles);
    $('.very_large_text1').html('<span>Events</span>');
  }else{
    $('.page_titl').html("Error Page"+head_titles);
    $('.very_large_text1').html('<span>Error</span> <font>Page</font>');
  }
  var datastring='evtid='+evtid;
  //+'&activityid='+activityid;
  $.ajax({
    type : "POST",
    url : site_urls+"node/event_view_loads",
    data : datastring,
    //cache : false,
    success : function(data){
      $('.events_view').show().html(data);
    },error : function(data){
    }
  });
}


$('.open_comment').live("click",function(){
  var frid = $(this).attr('frid');
  var tils = $(this).attr('tils');
  var directs1 = $(this).attr('directs1');
  create_cookie('frid', frid);
  create_cookie('tils', tils);
  if(directs1!=""){
    window.location = site_urls+directs1;
  }else{
    open_comment();
  }
});


function open_comment(){
  hide_all_no_e();

  if($(window).width() < 760)
    $('.for_desktop2').hide();
  else
    $('.for_desktop2').show();

  var hash = location.hash.substring(1);
  var frid = retrieve_cookie('frid');
  var tils = retrieve_cookie('tils');

  if($(window).width()<760)
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top}, "fast");
  else
  $("html, body").animate({scrollTop:$('.scrltotop').offset().top+120}, "fast");

  create_cookie('urls_prev', hash);
  create_cookie('frid', frid);
  $(".forum_view").show().html('<div class="load_values"><img src="'+site_urls+'images/loader.gif"> Loading replies...</div>');
  window.history.pushState('forward', null, './#viewreplies');
  create_cookie('urls', site_urls+"pages/#viewreplies");

  if(tils!="undefined"){
    $('.page_titl').html(tils+head_titles);
    $('.very_large_text1').html('<span>Forum</span>');
  }else{
    $('.page_titl').html("Error Page"+head_titles);
    $('.very_large_text1').html('<span>Error</span> <font>Page</font>');
  }
  var datastring='frid='+frid;
  //+'&activityid='+activityid;
  //alert(datastring)
  $.ajax({
    type : "POST",
    url : site_urls+"node/forum_view_loads",
    data : datastring,
    //cache : false,
    success : function(data){
      $('.forum_view').show().html(data);
      setTimeout(function(){
        $('#fr_ids').val(frid);
      },100);
    },error : function(data){
    }
  });
}


$('.click_to_login').live("mousedown",function(){
  create_cookie('urls', "");
  $.ajax({
    type : "POST",
    url : site_urls+"node/login_scrolldown",
    //cache : false,
    success : function(data){
      window.location = site_urls;
    }
  });
});



$('.logmeout').live("mousedown",function(){
  $.ajax({
    type : "POST",
    url : site_urls+"node/signout",
    //cache : false,
    success : function(data){
    }
  });
  $(".dashboard_div").hide();
  $(".expireds").fadeIn('fast');
  $('.page_titl').html('Expired Session'+head_titles);
});


$('.logmeout1').live("mousedown",function(){
  $.ajax({
    type : "POST",
    url : site_urls+"node/signout",
    //cache : false,
    success : function(data){
      window.location = site_urls;
    }
  });
});


$('.login_here').live("click",function(){
  $('.ist_form').hide();
  $('.login_form').fadeIn('fast');

  if($(window).width()<760)
    $("html, body").animate({scrollTop:$('.reg_form_home').offset().top-54},1500);
  else
    $("html, body").animate({scrollTop:$('.reg_form_home').offset().top-54},1500);
});


$('.reg_here').live("mousedown",function(){
  $('.ist_form').slideDown('fast');
  $('.login_form').hide();
});



$('.scroll_enter').live("click",function(){
    if($(window).width()<760){
      //openFullscreen();
      $("html, body").animate({scrollTop:$('.how_to_reg').offset().top-24},1500);
    }else
      $("html, body").animate({scrollTop:$('.how_to_reg').offset().top-120},1500);
});



$('.enlarge_img').live("click",function(){
  $('.big_img_div').fadeIn('slow');
  var srcs = $(this).attr('src');
  $('.big_img_div img').attr('src', srcs);
  $('body').css('overflow', 'hidden');
  var ids = $(this).attr('ids');
  
  var datastring='media_id='+ids;
  //+'&media=pic';
  $.ajax({
    type: "POST",
    url : site_urls+"node/update_ph_views",
    data: datastring,
    cache: false,
    success: function(html){
    }
  });
});


$('.big_img_div, .close_img').live("mousedown",function(){
  $('.big_img_div').fadeOut('fast');
  $('body').css('overflow-y', 'scroll');
});


$('#txtsell').live("keyup",function(){
  if(parseInt($('#txtinvoice_amt').val()) == ""){
    alert('Please enter the invoice amount');
    clearAll();
    $('#txtinvoice_amt').focus();

  }else if( parseInt($('#txtsell').val()) >= parseInt($('#txtinvoice_amt').val()) ){
    alert('This amount cannot be greater or equal to the invoice amount');
    clearAll();
  }else{
  $('#cmd_calc').click();
  }
});


function clearAll(){
    $('#txtsell').val('');
    $('#txtinterest').val('0');
    $('#txtraise').val('0');
    $('.interest_rate').html('0');
    $('.number_amt_to_raise').html('0');
}

function addCommas(nStr){
nStr += '';
x = nStr.split('.');
x1 = x[0];
x2 = x.length > 1 ? '.' + x[1] : '';
var rgx = /(\d+)(\d{3})/;
while (rgx.test(x1)) {
	x1 = x1.replace(rgx, '$1' + ',' + '$2');
}
return x1 + x2;
}



  
$(document).ready(function() { // to disable the browser back button
  
  var txt_srch = "";
  var page = 0;

  $('.vote_me').hide();
  var retrieve_cookies = retrieve_cookie('urls');
  var hash1 = location.hash.substring(1);
  
  hide_all_no_e();
  if(hash1=="about") about_us();
  if(hash1=="contact") contact_us();
  if(hash1=="contestants" || hash1=="vote") past_contestants();
  if(hash1=="vote") {window.history.pushState('forward', null, './#contestants')};
  if(hash1=="events") myevents();
  if(hash1=="donation") mydonation();
  if(hash1=="adverts") myadverts();
  if(hash1=="judges") myjudges();
  if(hash1=="photos") myphotos();
  if(hash1=="videos") myvideos();
  if(hash1=="forum") myforum();
  if(hash1=="policy") mypolicy();
  if(hash1=="viewevents") open_event();
  if(hash1=="viewreplies") open_comment();
  if(hash1=="participants") participants();
  if(hash1=="dashboard") mydashboard();
  if(hash1=="profiles") view_profiles();
  if(hash1=="winner-is") winner_is();

  if(page_names == ""){
    window.history.pushState('forward', null, './#home');
    create_cookie('urls', "");
  //}else{
    //window.history.pushState('forward', null, retrieve_cookies);
  }



  $(window).on('hashchange',function(e) {
    var hash = location.hash.substring(1);
    //alert(hash);
    if(hash=="home"){
      hide_all2(e);
    }

    var store_memid = retrieve_cookie('store_memid');
    hide_all_no_e();
    if(hash=="about") about_us();
    if(hash=="contact") contact_us();
    if(hash=="contestants" || hash=="vote") past_contestants();
    //if(hash=="vote") {window.history.pushState('forward', null, './#contestants')};
    if(hash=="events") myevents();
    if(hash=="donation") mydonation();
    if(hash=="adverts") myadverts();
    if(hash=="judges") myjudges();
    if(hash=="photos") myphotos();
    if(hash=="videos") myvideos();
    if(hash=="forum"){
      myforum();
      var frid = retrieve_cookie('frid');
      if(frid!=""){
        setTimeout(function(){
          $("html, body").animate({scrollTop:$('.forumBox_scroll'+frid).offset().top-100}, 10);
        },500);
      }
    }
    if(hash=="policy") mypolicy();
    if(hash=="viewevents") open_event();
    if(hash=="viewreplies") open_comment();
    if(hash=="participants") participants();
    if(hash=="dashboard") mydashboard();
    if(hash=="profiles") view_profiles();
    if(hash=="winner-is") winner_is();
  });


  
});



function create_cookie(name, value, days2expire, path) {
  var date = new Date();
  date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
  var expires = date.toUTCString();
  document.cookie = name + '=' + value + ';' +
                   'expires=' + expires + ';' +
                   'path=' + path + ';';
}


function retrieve_cookie(name) {
  var cookie_value = "",
    current_cookie = "",
    name_expr = name + "=",
    all_cookies = document.cookie.split(';'),
    n = all_cookies.length;
 
  for(var i = 0; i < n; i++) {
    current_cookie = all_cookies[i].trim();
    if(current_cookie.indexOf(name_expr) == 0) {
      cookie_value = current_cookie.substring(name_expr.length, current_cookie.length);
      break;
    }
  }
  return cookie_value;
}




var totalAmount = localStorage.getItem('countDown') || 0,
timeloop;

if (totalAmount) {
  timeSet()
}

function timeSet () {
  totalAmount--;
  // Refresh value in localStorage
  localStorage.setItem('countDown', totalAmount);

  // If countdown is over, then remove value from storage and clear timeout
  if (totalAmount < 0 ) {
      localStorage.removeItem('countDown');
      totalAmount = 0;
      clearTimeout(timeloop);

      $('#txt_time_finished').val(0);
      $('#cmd_submit_answers_timeout').trigger('click');
      return;
  }
  $('#txt_time_finished').val(totalAmount);

  var minutes = parseInt(totalAmount/60);
  var seconds = parseInt(totalAmount%60);

  if(seconds < 10)
      seconds = "0"+seconds;

  if(minutes <= 0 && seconds <= 40){
    $('#tminus_1').css('color', 'red');
  }else{
    $('#tminus_1').css('color', '#E800E8');
  }

  $('#tminus').val(minutes + ":" + seconds);
  $('#tminus_1').html(minutes + "mins, " + seconds+"secs");

  timeloop = setTimeout(timeSet, 1000);
}


$('#resets').live("click",function(){
  totalAmount = 0;
  clearTimeout(timeloop);
  localStorage.removeItem('countDown');
})