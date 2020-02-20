
var site_urls = $('#txtsite_url').val();
var head_titles = " | OurFavCelebs Pageant";
var txtwhatpg = $('#txtwhatpg').val();

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

function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
                     'expires=' + expires + ';' +
                     'path=' + path + ';';
}



function bringProducts(edit_ids){
    var site_urls = $('#txtsite_url').val();
    var txtsrch = $('#txt_srch_forum').val();
    var txtcats1 = $('#txtcats1').val();
    var txtmemsid = $('#txtmemsid').val();
    var page = 0;
    var datastring1='page='+page
    +'&txtcats1='+txtcats1
    +'&txtmemsid='+txtmemsid
    +'&txtsrch='+txtsrch;
    $('.srch_captn').show();
    $(".loadersmall").show();
    $(".loaders_").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");

    if($(window).width()<760){
        if(edit_ids!="")
            $("html, body").animate({ scrollTop: 300 }, "fast");
        else
            $("html, body").animate({ scrollTop: 270 }, "fast");

    }else{

        if(edit_ids!="")
            $("html, body").animate({ scrollTop: 200 }, "fast");
        else
            $("html, body").animate({ scrollTop: 200 }, "fast");
    }

    $.ajax({
      type : "POST",
      url : site_urls+"node/getForums",
      data : datastring1,
      cache : false,
      success : function(data){
        
        $("#ajax_table_forum").empty().append(data);
        $('#load_more_mba').data('val', ($('#load_more_mba').data('val')));
        $(".loaders_").hide();

      },error : function(data){
        $(".loaders_").hide();
      }
      
    });
}


function bringProducts_rep(memid_rep){
    var site_urls = $('#txtsite_url').val();
    var fr_ids = $('#fr_ids').val();
    var page = 0;
    var datastring1='page='+page
    +'&fr_ids='+fr_ids
    +'&txtmemsid='+memid_rep;

    $('.srch_captn').show();
    $(".loaders_rep").show().html("Loading...<br><img src='"+site_urls+"images/loader.gif'>");
    $("html, body").animate({ scrollTop: 400 }, "fast");
    $.ajax({
        type : "POST",
        url : site_urls+"node/getForums_reps",
        data : datastring1,
        cache : false,
        success : function(data){
            $("#ajax_table_forum_rep").empty().append(data);
            $('#load_more_mba_rep').data('val', ($('#load_more_mba_rep').data('val')));
            $(".loaders_rep").hide();
        },error : function(data){
            $(".loaders_rep").hide();
        }
    });
} 


  $('#cmd_sub_answers').live("click",function(){
    var txtgameid = $("#txtgameid").val();
    var txtses = $("#txtses").val();
    var txtmember = $("#txtmember").val();
    var txt_time_finished = $("#txt_time_finished").val();
    var for_days = $("#for_days").val();
    var tminus = $("#tminus").val();

    totalAmount = 0;
    clearTimeout(timeloop);
    localStorage.removeItem('countDown');

    var datastring2='txtgameid='+txtgameid
    +'&txtses='+txtses
    +'&txtmember='+txtmember
    +'&for_days='+for_days
    +'&txt_time_finished='+txt_time_finished;

    $.ajax({
        type: "POST",
        url : site_urls+"node/save_my_ansas",
        data: datastring2,
        success : function(data){
            $('.cmd_next_activity').show();
            $('.cmd_next_activity1').hide();
            $('.cmd_next_activity2').hide();
            $('.div_quiz2').hide();
            if(tminus=="0:00")
                $('.div_success_test_timeout').show();
            else
                $('.div_success_test').show();
            $(".form_quizes")[0].reset();
            $("html, body").animate({scrollTop:$('.scroll_stop').offset().top-100},1500);
        }
    });

  });
  


  $('.cmd_next_activity').live("click",function(){
    var txtans1 = $("#txtans1").val();
    var txtrandom_quiz = $("#txtrandom_quiz").val();
    var txttotalquiz = $("#txttotalquiz").val();
    var txtpage_number = $("#txtpage_number").val();
    
    if(txtans1=="")
    $(".err_msg").show().html('<div class="Errormsg" style="font-size:14px;">Please select an answer!</div>');
    else{
        $('.cmd_next_activity').hide();
        $('.cmd_next_activity1').show();

        var datastring='txtans1='+txtans1
        +'&txtrandom_quiz='+txtrandom_quiz;

        $.ajax({
            type: "POST",
            url : site_urls+"node/store_my_ansa",
            data: datastring,
            success : function(data){

            if(txtpage_number < txttotalquiz){
                txtpage_number1 = parseInt(txtpage_number) + 1;
                $("#txtpage_number").val(txtpage_number1);
                $('.cmd_next_activity').show();
                $('.cmd_next_activity1').hide();
                $('.fade_questions').show();

            }else{ // if the total question is equal to the page number, show done and submit to database
                $('.cmd_next_activity').hide();
                $('.cmd_next_activity1').show();
                $('.cmd_next_activity2').show();
                $("#cmd_sub_answers").click();
            }
            
            $('#txtans1').val('');
            setTimeout(function(){
                $('.fade_questions').fadeOut('fast');
                $('.scroll_inner_quiz').fadeIn('fast').html(data);
                $("#txtpage_number_h").html(txtpage_number1+".");
            },1000);
        
            },error : function(data){
                $('.cmd_next_activity').show();
                $('.cmd_next_activity1').hide();
                $(".err_msg").show().html('<div class="Errormsg">Poor Network Connection!</div>');
            }
        });
    }

  });



  $('#cmd_submit_answers_timeout').live("click",function(e){
    $('.cmd_next_activity').hide();
    $('.cmd_next_activity1').show();
    $('.cmd_next_activity2').show();
    $("#cmd_sub_answers").click();
  });
  

 