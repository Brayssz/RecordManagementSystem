window.showLoader=function(){$("#global-loader").fadeIn("fast")};window.hideLoader=function(){$("#global-loader").fadeOut("slow")};window.messageAlert=function(s,n){Swal.fire({title:s,icon:"warning",text:n,confirmButtonColor:"#643bc6",confirmButtonText:"Ok",customClass:{popup:"text-center"}})};window.confirmAlert=function(s,n,r,u){Swal.fire({title:s,text:n,icon:"question",confirmButtonColor:"#643bc6",denyButtonColor:"#f44336",cancelButtonColor:"#999999",showCancelButton:!0,confirmButtonText:u,customClass:{popup:"rounded-lg"}}).then(m=>{m.isConfirmed&&r()})};$(document).ready(function(){var s=$(".main-wrapper"),n=$(".slimscroll");if($(".page-wrapper"),feather.replace(),$(window).resize(function(){if($(".page-wrapper").length>0){var e=$(window).height();$(".page-wrapper").css("min-height",e)}}),$("body").append('<div class="sidebar-overlay"></div>'),$(document).on("click","#mobile_btn",function(){return s.toggleClass("slide-nav"),$(".sidebar-overlay").toggleClass("opened"),$("html").addClass("menu-opened"),$("#task_window").removeClass("opened"),!1}),$(".sidebar-overlay").on("click",function(){$("html").removeClass("menu-opened"),$(this).removeClass("opened"),s.removeClass("slide-nav"),$(".sidebar-overlay").removeClass("opened"),$("#task_window").removeClass("opened")}),$(document).on("click",".hideset",function(){$(this).parent().parent().parent().hide()}),$(document).on("click",".delete-set",function(){$(this).parent().parent().hide()}),$(window).width()>767&&$(".theiaStickySidebar").length>0&&$(".theiaStickySidebar").theiaStickySidebar({additionalMarginTop:30}),$(".product-slide").length>0&&$(".product-slide").owlCarousel({items:1,margin:30,dots:!1,nav:!0,loop:!1,responsiveClass:!0,responsive:{0:{items:1},800:{items:1},1170:{items:1}}}),$(".notes-tog").on("click",function(){$(".section-bulk-widget").toggleClass("section-notes-dashboard")}),$(".notes-tog").on("click",function(){$(".budget-role-notes").toggleClass("budgeted-role-notes")}),$(".notes-tog").on("click",function(){$(".notes-page-wrapper").toggleClass("notes-tag-left")}),$(".notes-slider").length>0&&$(".notes-slider").owlCarousel({loop:!0,margin:24,dots:!1,nav:!0,smartSpeed:2e3,navText:['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],responsive:{0:{items:1},768:{items:2},1300:{items:3}}}),$(".owl-product").length>0){var r=$(".owl-product");r.owlCarousel({margin:10,dots:!1,nav:!0,loop:!1,touchDrag:!1,mouseDrag:!1,responsive:{0:{items:2},768:{items:4},1170:{items:8}}})}$(".datanew").length>0&&$(".datanew").DataTable({bFilter:!0,sDom:"fBtlpi",ordering:!0,language:{search:" ",sLengthMenu:"_MENU_",searchPlaceholder:"Search",info:"_START_ - _END_ of _TOTAL_ items",paginate:{next:' <i class=" fa fa-angle-right"></i>',previous:'<i class="fa fa-angle-left"></i> '}},initComplete:(e,t)=>{$(".dataTables_filter").appendTo("#tableSearch"),$(".dataTables_filter").appendTo(".search-input")}});function u(e){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(i){$("#blah").attr("src",i.target.result)},t.readAsDataURL(e.files[0])}}if($("#imgInp").change(function(){u(this)}),$(".datatable").length>0&&$(".datatable").DataTable({bFilter:!1}),setTimeout(function(){$("#global-loader"),setTimeout(function(){$("#global-loader").fadeOut("slow")},100)},5e3),$(".datetimepicker").length>0&&$(".datetimepicker").datetimepicker({format:"YYYY-MM-DD",icons:{up:"fas fa-angle-up",down:"fas fa-angle-down",next:"fas fa-angle-right",previous:"fas fa-angle-left"}}),$(".toggle-passworda").length>0&&$(document).on("click",".toggle-passworda",function(){$(this).toggleClass("fa-eye fa-eye-slash");var e=$(".pass-inputa");e.attr("type")=="password"?e.attr("type","text"):e.attr("type","password")}),$(".toggle-password").length>0&&$(document).on("click",".toggle-password",function(){$(this).toggleClass("fa-eye fa-eye-slash");var e=$(".pass-input");e.attr("type")=="password"?e.attr("type","text"):e.attr("type","password")}),$(".toggle-passwords").length>0&&$(document).on("click",".toggle-passwords",function(){$(this).toggleClass("fa-eye fa-eye-slash");var e=$(".pass-inputs");e.attr("type")=="password"?e.attr("type","text"):e.attr("type","password")}),$(".comming-soon-pg").length>0){let v=function(){let y=new Date("mar 27, 2024 16:00:00").getTime(),x=setInterval(function(){let S=new Date().getTime(),h=y-S,T=Math.floor(h/(1e3*60*60*24)),_=Math.floor(h%(1e3*60*60*24)/(1e3*60*60)),D=Math.floor(h%(1e3*60*60)/(1e3*60)),E=Math.floor(h%(1e3*60)/1e3);e.textContent=T,t.textContent=_,i.textContent=D,o.textContent=E,h<0&&(clearInterval(x),document.querySelector(".comming-soon-pg").innerHTML="<h1>EXPIRED</h1>")},1e3)};var F=v;let e=document.querySelector(".days"),t=document.querySelector(".hours"),i=document.querySelector(".minutes"),o=document.querySelector(".seconds");v()}if($(".select").length>0&&$(".select").select2({minimumResultsForSearch:-1,width:"100%"}),$(".counter").length>0&&$(".counter").counterUp({delay:20,time:2e3}),$("#timer-countdown").length>0&&$("#timer-countdown").countdown({from:180,to:0,movingUnit:1e3,timerEnd:void 0,outputPattern:"$day Day $hour : $minute : $second",autostart:!0}),$("#timer-countup").length>0&&$("#timer-countup").countdown({from:0,to:180}),$("#timer-countinbetween").length>0&&$("#timer-countinbetween").countdown({from:30,to:20}),$("#timer-countercallback").length>0&&$("#timer-countercallback").countdown({from:10,to:0,timerEnd:function(){this.css({"text-decoration":"line-through"}).animate({opacity:.5},500)}}),$("#timer-outputpattern").length>0&&$("#timer-outputpattern").countdown({outputPattern:"$day Days $hour Hour $minute Min $second Sec..",from:60*60*24*3}),$("#summernote").length>0&&$("#summernote").summernote({height:300,minHeight:null,maxHeight:null,focus:!1}),$("#summernote2").length>0&&$("#summernote2").summernote({height:300,minHeight:null,maxHeight:null,focus:!0}),$("#summernote3").length>0&&$("#summernote3").summernote({placeholder:"Type your message",height:300,minHeight:null,maxHeight:null,focus:!0}),$("#summernote4").length>0&&$("#summernote4").summernote({height:300,minHeight:null,maxHeight:null,focus:!0}),$("#summernote5").length>0&&$("#summernote5").summernote({height:300,minHeight:null,maxHeight:null,focus:!0}),n.length>0){n.slimScroll({height:"auto",width:"100%",position:"right",size:"7px",color:"#ccc",wheelStep:10,touchScrollStep:100});var m=$(window).height()-60;n.height(m),$(".sidebar .slimScrollDiv").height(m),$(window).resize(function(){var e=$(window).height()-60;n.height(e),$(".sidebar .slimScrollDiv").height(e)})}function w(){$(".sidebar-menu a").on("click",function(e){$(this).parent().hasClass("submenu")&&e.preventDefault(),$(this).hasClass("subdrop")?$(this).hasClass("subdrop")&&($(this).removeClass("subdrop"),$(this).next("ul").slideUp(350)):($("ul",$(this).parents("ul:first")).slideUp(250),$("a",$(this).parents("ul:first")).removeClass("subdrop"),$(this).next("ul").slideDown(350),$(this).addClass("subdrop"))}),$(".sidebar-menu ul li.submenu a.active").parents("li:last").children("a:first").addClass("active").trigger("click")}if(w(),$(document).on("mouseover",function(e){if(e.stopPropagation(),$("body").hasClass("mini-sidebar")&&$("#toggle_btn").is(":visible")){var t=$(e.target).closest(".sidebar, .header-left").length;return t?($("body").addClass("expand-menu"),$(".subdrop + ul").slideDown()):($("body").removeClass("expand-menu"),$(".subdrop + ul").slideUp()),!1}}),setTimeout(function(){$(document).ready(function(){$(".table").parent().addClass("table-responsive")})},1e3),$(".bookingrange").length>0){let e=function(t,i){$(".bookingrange span").html(t.format("M/D/YYYY")+" - "+i.format("M/D/YYYY"))};var M=e,a=moment().subtract(6,"days"),l=moment();$(".bookingrange").daterangepicker({startDate:a,endDate:l,ranges:{Today:[moment(),moment()],Yesterday:[moment().subtract(1,"days"),moment().subtract(1,"days")],"Last 7 Days":[moment().subtract(6,"days"),moment()],"Last 30 Days":[moment().subtract(29,"days"),moment()],"This Month":[moment().startOf("month"),moment().endOf("month")],"Last Month":[moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]}},e),e(a,l)}if($(document).on("click","#toggle_btn",function(){return $("body").hasClass("mini-sidebar")?($("body").removeClass("mini-sidebar"),$(this).addClass("active"),$(".subdrop + ul"),localStorage.setItem("screenModeNightTokenState","night"),setTimeout(function(){$("body").removeClass("mini-sidebar"),$(".header-left").addClass("active")},100)):($("body").addClass("mini-sidebar"),$(this).removeClass("active"),$(".subdrop + ul"),localStorage.removeItem("screenModeNightTokenState","night"),setTimeout(function(){$("body").addClass("mini-sidebar"),$(".header-left").removeClass("active")},100)),!1}),localStorage.getItem("screenModeNightTokenState")=="night"&&setTimeout(function(){$("body").removeClass("mini-sidebar"),$(".header-left").addClass("active")},100),document.querySelector(".sticky-sidebar-one"),$(".submenus").on("click",function(){$("body").addClass("sidebarrightmenu")}),$("#searchdiv").on("click",function(){$(".searchinputs").addClass("show")}),$(".search-addon span").on("click",function(){$(".searchinputs").removeClass("show")}),$(document).on("click","#filter_search",function(){$("#filter_inputs").slideToggle("slow")}),$(document).on("click","#filter_search1",function(){$("#filter_inputs1").slideToggle("slow")}),$(document).on("click","#filter_search2",function(){$("#filter_inputs2").slideToggle("slow")}),$(document).on("click","#filter_search3",function(){$("#filter_inputs3").slideToggle("slow")}),$(document).on("click","#filter_search",function(){$("#filter_search").toggleClass("setclose")}),$(document).on("click","#filter_search1",function(){$("#filter_search1").toggleClass("setclose")}),$(document).on("click",".productset",function(){$(this).toggleClass("active")}),$(document).on("click",".product-info",function(){$(this).toggleClass("active")}),$(document).on("click",".layout-box",function(){$(".layout-hide-box").toggleClass("layout-show-box")}),$(document).on("click",".select-option1",function(){$(".select-color-add").addClass("selected-color-add")}),$(".bank-box").on("click",function(){$(".bank-box").removeClass("active"),$(this).addClass("active")}),$(".theme-image").on("click",function(){$(".theme-image").removeClass("active"),$(this).addClass("active")}),$(".themecolorset").on("click",function(){$(".themecolorset").removeClass("active"),$(this).addClass("active")}),$(".inc.button").click(function(){var e=$(this),t=e.prev("input"),i=t.closest("div"),o=parseInt(t.val())+1;i.find(".inc").addClass("a"+o),t.val(o),o+=o}),$(".dec.button").click(function(){var e=$(this),t=e.next("input"),i=t.closest("div"),o=parseInt(t.val())-1;console.log(i),i.find(".inc").addClass("a"+o),t.val(o),o+=o}),$(".custom-file-container").length>0&&(new FileUploadWithPreview("myFirstImage"),new FileUploadWithPreview("mySecondImage")),$(".counters").each(function(){var e=$(this),t=e.attr("data-count");$({countNum:e.text()}).animate({countNum:t},{duration:2e3,easing:"linear",step:function(){e.text(Math.floor(this.countNum))},complete:function(){e.text(this.countNum)}})}),$(".select-color-add").length>0){const e=document.getElementById("colorSelect"),t=document.getElementById("inputBox"),i=document.getElementById("input-show"),o=document.getElementById("variant-table");e.addEventListener("change",function(){const v=e.value;i.style.display="block",o.style.display="block",t.value=v})}if($(".toggle-password").length>0&&$(document).on("click",".toggle-password",function(){$(this).toggleClass("fa-eye fa-eye");var e=$(".pass-input");e.attr("type")=="text"?e.attr("type","text"):e.attr("type","password")}),$(".win-maximize").length>0&&$(".win-maximize").on("click",function(e){document.fullscreenElement?document.exitFullscreen&&document.exitFullscreen():document.documentElement.requestFullscreen()}),$(document).on("click","#check_all",function(){return $(".checkmail").click(),!1}),$(".checkmail").length>0&&$(".checkmail").each(function(){$(this).on("click",function(){$(this).closest("tr").hasClass("checked")?$(this).closest("tr").removeClass("checked"):$(this).closest("tr").addClass("checked")})}),$(".popover-list").length>0){var d=[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));d.map(function(e){return new bootstrap.Popover(e)})}$(".clipboard").length>0&&new Clipboard(".btn");var c=$(".chat-window");(function(){$(window).width()>991&&c.removeClass("chat-slide"),$(document).on("click",".chat-window .chat-users-list a.media",function(){return $(window).width()<=991&&c.addClass("chat-slide"),!1}),$(document).on("click","#back_user_list",function(){return $(window).width()<=991&&c.removeClass("chat-slide"),!1})})(),$(document).on("click",".mail-important",function(){$(this).find("i.fa").toggleClass("fa-star").toggleClass("fa-star-o")});var p="#select-all",f=":checkbox";$(p).click(function(){this.checked?$(f).each(function(){this.checked=!0}):$(f).each(function(){this.checked=!1})});var p="#select-all2",f=":checkbox";if($(p).click(function(){this.checked?$(f).each(function(){this.checked=!0}):$(f).each(function(){this.checked=!1})}),$('[data-bs-toggle="tooltip"]').length>0){var C=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));C.map(function(e){return new bootstrap.Tooltip(e)})}var k='<div class="right-side-views d-none"><ul class="sticky-sidebar siderbar-view"><li class="sidebar-icons"><a class="toggle tipinfo open-layout open-siderbar" href="javascript:void(0);" data-toggle="tooltip" data-placement="left" data-bs-original-title="Tooltip on left"><div class="tooltip-five "><img src="assets/img/icons/siderbar-icon2.svg" class="feather-five" alt=""><span class="tooltiptext">Check Layout</span></div></a></li></ul></div><div class="sidebar-layout"><div class="sidebar-content"><div class="sidebar-top"><div class="container-fluid"><div class="row align-items-center"><div class="col-xl-6 col-sm-6 col-12"><div class="sidebar-logo"><a href="index" class="logo"><img src="assets/img/logo.png" alt="Logo" class="img-flex"></a></div></div><div class="col-xl-6 col-sm-6 col-12"><a class="btn-closed" href="javascript:void(0);"><img class="img-fliud" src="assets/img/icons/sidebar-delete-icon.svg" alt="demo"></a></div></div></div></div><div class="container-fluid"><div class="row align-items-center"><h5 class="sidebar-title">Choose layout</h5><div class="col-xl-12 col-sm-6 col-12"><div class="sidebar-image align-center"><img class="img-fliud" src="assets/img/demo-one.png" alt="demo"></div><div class="row"><div class="col-lg-6 layout"><h5 class="layout-title">Dark Mode</h5></div><div class="col-lg-6 layout dark-mode"><label class="toggle-switch" for="notification_switch3"><span><input type="checkbox" class="toggle-switch-input" id="notification_switch3"><span class="toggle-switch-label ms-auto">	<span class="toggle-switch-indicator"></span></span></span> </label></div></div></div></div></div></div></div>'+$("body").append(k);if($(".open-layout").on("click",function(e){e.preventDefault(),$(".sidebar-layout").addClass("show-layout"),$(".sidebar-settings").removeClass("show-settings")}),$(".btn-closed").on("click",function(e){e.preventDefault(),$(".sidebar-layout").removeClass("show-layout")}),$(".open-settings").on("click",function(e){e.preventDefault(),$(".sidebar-settings").addClass("show-settings"),$(".sidebar-layout").removeClass("show-layout")}),$(".btn-closed").on("click",function(e){e.preventDefault(),$(".sidebar-settings").removeClass("show-settings")}),$(".open-siderbar").on("click",function(e){e.preventDefault(),$(".siderbar-view").addClass("show-sidebar")}),$(".btn-closed").on("click",function(e){e.preventDefault(),$(".siderbar-view").removeClass("show-sidebar")}),$(".toggle-switch").length>0){let i=function(o){o.target.checked?(b.setAttribute("data-theme","dark"),localStorage.setItem("theme","dark")):(b.setAttribute("data-theme","light"),localStorage.setItem("theme","light"))};var L=i;const e=document.querySelector('.toggle-switch input[type="checkbox"]'),t=localStorage.getItem("theme");var b=document.getElementsByTagName("BODY")[0];t&&(b.setAttribute("data-theme",t),t==="dark"&&(e.checked=!0)),e.addEventListener("change",i,!1)}if(window.location.hash=="#LightMode"?localStorage.setItem("theme","dark"):window.location.hash=="#DarkMode"&&localStorage.setItem("theme","light"),$("ul.tabs li").click(function(){var e=$(this),t=$(this).attr("id");console.log(t),e.hasClass("active")||(e.closest(".tabs_wrapper").find("ul.tabs li, .tabs_container .tab_content").removeClass("active"),$('.tabs_container .tab_content[data-tab="'+t+'"], ul.tabs li[id="'+t+'"]').addClass("active"))}),$("body").append('<div class="sidebar-filter"></div>'),setTimeout(function(){$(".navigation-add").length>0&&$(".navigation-add").click(function(){$(".sidebar-filter").addClass("opened")})},1e3),setTimeout(function(){$(".sidebar-close").length>0&&$(".sidebar-close").click(function(){$(".sidebar-filter").removeClass("opened")})},1e3),setTimeout(function(){$(".sidebar-filter").length>0&&$(".sidebar-filter").click(function(){$(".sidebar-filter").removeClass("opened"),$(".sidebar-settings").removeClass("show-settings"),document.body.style.overflow="auto"})},1e3),$(".add-setting").on("click",function(e){e.preventDefault(),$(".preview-toggle.sidebar-settings").addClass("show-settings")}),$(".navigation-add").on("click",function(e){e.preventDefault(),$(".nav-toggle.sidebar-settings").addClass("show-settings"),document.body.style.overflow="hidden"}),$(".sidebar-close").on("click",function(){$(".nav-toggle.sidebar-settings").removeClass("show-settings"),document.body.style.overflow="auto"}),setTimeout(function(){$(".sidebar-close").click(function(e){$(".sidebar-settings").removeClass("show-settings"),document.body.style.overflow="auto"})},1e3),$("#dark-mode-toggle").length>0){$("#dark-mode-toggle").children(".light-mode").addClass("active");let e=localStorage.getItem("darkMode");const t=document.querySelector("#dark-mode-toggle"),i=()=>{document.body.setAttribute("data-theme","dark"),$("#dark-mode-toggle").children(".dark-mode").addClass("active"),$("#dark-mode-toggle").children(".light-mode").removeClass("active"),localStorage.setItem("darkMode","enabled")},o=()=>{document.body.removeAttribute("data-theme","dark"),$("#dark-mode-toggle").children(".dark-mode").removeClass("active"),$("#dark-mode-toggle").children(".light-mode").addClass("active"),localStorage.setItem("darkMode",null)};e==="enabled"&&i(),t.addEventListener("click",()=>{e=localStorage.getItem("darkMode"),e!=="enabled"?i():o()})}if($(".digit-group").find("input").each(function(){$(this).attr("maxlength",1),$(this).on("keyup",function(e){var t=$($(this).parent());if(e.keyCode===8||e.keyCode===37){var i=t.find("input#"+$(this).data("previous"));i.length&&$(i).select()}else if(e.keyCode>=48&&e.keyCode<=57||e.keyCode>=65&&e.keyCode<=90||e.keyCode>=96&&e.keyCode<=105||e.keyCode===39){var o=t.find("input#"+$(this).data("next"));o.length&&$(o).select()}})}),$(".digit-group input").on("keyup",function(){var e=$(this);e.val()!=""?e.addClass("active"):e.removeClass("active")}),$('input[name="datetimes"]').length>0&&$('input[name="datetimes"]').daterangepicker({timePicker:!0,startDate:moment().startOf("hour"),endDate:moment().startOf("hour").add(32,"hour"),locale:{format:"M/DD hh:mm A"}}),$(".top-online-contacts .swiper-container").length>0&&new Swiper(".top-online-contacts .swiper-container",{slidesPerView:5,spaceBetween:15}),$(".dream_profile_menu").on("click",function(){$(".right-side-contact").addClass("show-right-sidebar"),$(".right-side-contact").removeClass("hide-right-sidebar"),$(window).width()>991&&$(window).width()<1201&&($(".chat:not(.right-side-contact .chat)").css("margin-left",-chat_bar),$(".chat:not(.right_side_star .chat)").css("margin-left",-chat_bar)),$(window).width()<992&&($(".chat:not(.right-side-contact .chat)").addClass("hide-chatbar"),$(".chat:not(.right_side_star .chat)").addClass("hide-chatbar"))}),$(".close_profile").on("click",function(){$(".right-side-contact").addClass("hide-right-sidebar"),$(".right-side-contact").removeClass("show-right-sidebar"),$(window).width()>991&&$(window).width()<1201&&$(".chat").css("margin-left",0),$(window).width()<992&&$(".chat").removeClass("hide-chatbar")}),$(".emoj-action").length>0&&$(".emoj-action").on("click",function(){$(".emoj-group-list").toggle()}),$(".emoj-action-foot").length>0&&$(".emoj-action-foot").on("click",function(){$(".emoj-group-list-foot").toggle()}),$(".custom-input").length>0){const e=document.querySelector(".custom-input");e.addEventListener("input",function(){const t=(e.value-e.min)/(e.max-e.min)*100;e.style.background=`linear-gradient(to top, var(--md-sys-color-on-surface-variant) 0%, var(--md-sys-color-on-surface-variant) ${t}%, var(--md-sys-color-surface-variant) ${t}%, var(--md-sys-color-surface-variant) 100%)`})}$(".mute-video").length>0&&$(".mute-video").on("click",function(){$(this).hasClass("stop")?($(this).removeClass("stop"),$(".mute-video i").removeClass("bx-video-off"),$(".mute-video i").addClass("bx-video"),$(".join-call .join-video").removeClass("video-hide"),$(".video-avatar").removeClass("active"),$(this).attr("data-bs-original-title","Stop Camera"),$(".meeting .join-video.user-active").removeClass("video-hide"),$(".join-video.user-active .more-icon").removeClass("vid-view"),$(".action-info.vid-view li .mute-vid i").removeClass("feather-video-off"),$(".action-info.vid-view li .mute-vid i").addClass("feather-video")):($(this).addClass("stop"),$(".mute-video i").removeClass("bx-video"),$(".mute-video i").addClass("bx-video-off"),$(".join-call .join-video").addClass("video-hide"),$(".video-avatar").addClass("active"),$(this).attr("data-bs-original-title","Start Camera"),$(".meeting .join-video.user-active").addClass("video-hide"),$(".add-list .user-active .action-info").addClass("vid-view"),$(".action-info.vid-view li .mute-vid i").removeClass("feather-video"),$(".action-info.vid-view li .mute-vid i").addClass("feather-video-off"))}),$(".mute-bt").length>0&&$(".mute-bt").on("click",function(){$(this).hasClass("stop")?($(this).removeClass("stop"),$(".mute-bt i").removeClass("bx-microphone-off"),$(".mute-bt i").addClass("bx-microphone"),$(this).attr("data-bs-original-title","Mute Audio"),$(".join-video.user-active .more-icon").removeClass("mic-view"),$(".action-info.vid-view li .mute-mic i").removeClass("feather-mic-off"),$(".action-info.vid-view li .mute-mic i").addClass("feather-mic")):($(this).addClass("stop"),$(".mute-bt i").removeClass("bx-microphone"),$(".mute-bt i").addClass("bx-microphone-off"),$(this).attr("data-bs-original-title","Unmute Audio"),$(".join-video.user-active .more-icon").addClass("mic-view"),$(".add-list .user-active .action-info").addClass("vid-view"),$(".action-info.vid-view li .mute-mic i").removeClass("feather-mic"),$(".action-info.vid-view li .mute-mic i").addClass("feather-mic-off"))}),$(".other-mic-off").length>0&&$(".other-mic-off i").on("click",function(){$(this).parent().hasClass("stop")?($(this).parent().removeClass("stop"),$(this).removeClass("bx-microphone-off"),$(this).addClass("bx-microphone")):($(this).parent().addClass("stop"),$(this).removeClass("bx-microphone"),$(this).addClass("bx-microphone-off"))}),$(".other-video-off").length>0&&$(".other-video-off i").on("click",function(){$(this).parent().hasClass("stop")?($(this).parent().removeClass("stop"),$(this).removeClass("bx-video-off"),$(this).addClass("bx-video")):($(this).parent().addClass("stop"),$(this).removeClass("bx-video"),$(this).addClass("bx-video-off"))}),$(".video-slide").length>0&&$(".video-slide").owlCarousel({items:4,loop:!0,margin:24,nav:!0,dots:!1,autoplay:!1,smartSpeed:1e3,navText:['<i class="fa fa-angle-left" data-bs-toggle="tooltip" title="fa fa-angle-left"></i>','<i class="fa fa-angle-right" data-bs-toggle="tooltip" title="fa fa-angle-right"></i>'],responsive:{0:{items:1},500:{items:1},768:{items:3},991:{items:3},1200:{items:4},1401:{items:4}}}),$(".close_profile").on("click",function(){$(".right-user-side").removeClass("open-message"),$(".chat-center-blk .card-comman").addClass("chat-center-space")}),$(".profile-open").on("click",function(){$(".right-user-side").removeClass("add-setting"),$(".chat-center-blk .card-comman").removeClass("chat-center-space")}),$("#call-chat").on("click",function(){$(".right-user-side").addClass("open-message"),$(".video-screen-inner").addClass("video-space")}),$(".close_profile").on("click",function(){$(".right-user-side").removeClass("open-message"),$(".video-screen-inner").removeClass("video-space"),$(".right-side-party").removeClass("open-message"),$(".meeting-list").removeClass("add-meeting"),$("#chat-room").removeClass("open-chats"),$(".meeting-list").removeClass("add-meeting"),$(".call-user-side").addClass("add-setting")}),$("#add-partispant").on("click",function(){$(".right-side-party").addClass("open-message"),$("#chat-room").removeClass("open-chats"),$(".meeting-list").addClass("add-meeting")}),$("#show-message").on("click",function(){$("#chat-room").addClass("open-chats"),$(".right-side-party").removeClass("open-message"),$(".meeting-list").addClass("add-meeting")}),$(".chat-search-btn").on("click",function(){$(".chat-search").addClass("visible-chat")}),$(".close-btn-chat").on("click",function(){$(".chat-search").removeClass("visible-chat")}),$(".chat-search .form-control").on("keyup",function(){var e=$(this).val().toLowerCase();$(".chat .chat-body .messages .chats").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(e)>-1)})})});function I(s){s=s||document.documentElement,!document.fullscreenElement&&!document.mozFullScreenElement&&!document.webkitFullscreenElement&&!document.msFullscreenElement?s.requestFullscreen?s.requestFullscreen():s.msRequestFullscreen?s.msRequestFullscreen():s.mozRequestFullScreen?s.mozRequestFullScreen():s.webkitRequestFullscreen&&s.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT):document.exitFullscreen?document.exitFullscreen():document.msExitFullscreen?document.msExitFullscreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitExitFullscreen&&document.webkitExitFullscreen()}$(".quantity-btn").on("click",function(){var s=$(this),n=s.closest(".product-quantity").find("input.quntity-input").val();if(s.text()=="+")var r=parseFloat(n)+1;else if(n>0)var r=parseFloat(n)-1;else r=0;var u=s.closest(".product-quantity").find("input.quntity-input");u.val(r).trigger("input").trigger("change")});if($("#phone").length>0){var g=document.querySelector("#phone");window.intlTelInput(g,{utilsScript:"assets/plugins/intltelinput/js/utils.js"})}if($("#phone2").length>0){var g=document.querySelector("#phone2");window.intlTelInput(g,{utilsScript:"assets/plugins/intltelinput/js/utils.js"})}if($("#phone3").length>0){var g=document.querySelector("#phone3");window.intlTelInput(g,{utilsScript:"assets/plugins/intltelinput/js/utils.js"})}$(document).on("click",".remove-product",function(){$(this).parent().parent().hide()});$(".timepicker").length>0&&$(".timepicker").datetimepicker({format:"HH:mm A",icons:{up:"fas fa-angle-up",down:"fas fa-angle-down",next:"fas fa-angle-right",previous:"fas fa-angle-left"}});$(".add-extra").on("click",function(){var s='<div class="row"><div class="col-lg-4 col-sm-6 col-12"><div class="form-group add-product"><div class="add-newplus"><label>Category</label></div><select class="select"><option>Choose</option><option>Computers</option></select></div></div><div class="col-lg-4 col-sm-6 col-12"><div class="form-group add-product"><label>Choose Category</label><select class="select"><option>Choose</option><option>Computers</option></select></div></div><div class="col-lg-4 col-sm-6 col-12"><div class="d-flex align-items-center"><div class="form-group w-100 add-product"><label>Sub Category</label><select class="select"><option>Choose</option><option>Computers</option></select></div><div class="input-blocks"><a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a></div></div></div>';return setTimeout(function(){$(".select"),setTimeout(function(){$(".select").select2({minimumResultsForSearch:-1,width:"100%"})},100)},100),$(".addservice-info").append(s),!1});$(".add-extra-item-two").on("click",function(){var s='<div class="row"><div class="col-lg-4 col-sm-6 col-12"><div class="form-group add-product"><div class="add-newplus"><label>Brand</label></div><select class="select"><option>Choose</option><option>Computers</option></select></div></div><div class="col-lg-4 col-sm-6 col-12"><div class="form-group add-product"><label>Unit</label><select class="select"><option>Choose</option><option>Computers</option></select></div></div><div class="col-lg-4 col-sm-6 col-12"><div class="d-flex align-items-center"><div class="form-group w-100 add-product"><label>Selling Type</label><select class="select"><option>Choose</option><option>Computers</option></select></div><div class="input-blocks"><a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a></div></div></div>';return setTimeout(function(){$(".select"),setTimeout(function(){$(".select").select2({minimumResultsForSearch:-1,width:"100%"})},100)},100),$(".add-product-new").append(s),!1});$(document).on("click",".remove-color",function(){$(this).parent().parent().parent().hide()});$("#btnFullscreen").length>0&&document.getElementById("btnFullscreen").addEventListener("click",function(){I()});$(document).ready(function(){if($("#collapse-header").length>0&&(document.getElementById("collapse-header").onclick=function(){this.classList.toggle("active"),document.body.classList.toggle("header-collapse")}),$("#file-delete").length>0&&$("#file-delete").on("click",function(){$(".deleted-table").addClass("d-none"),$(".deleted-info").addClass("d-block")}),$(".pos-category").length>0&&$(".pos-category").owlCarousel({items:6,loop:!1,margin:8,nav:!0,dots:!1,autoplay:!1,smartSpeed:1e3,navText:['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],responsive:{0:{items:2},500:{items:3},768:{items:4},991:{items:5},1200:{items:6},1401:{items:6}}}),$(".folders-carousel").length>0&&$(".folders-carousel").owlCarousel({loop:!0,margin:15,items:2,nav:!0,dots:!1,navText:['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],responsive:{0:{items:1},768:{items:2},1400:{items:3}}}),$(".files-carousel").length>0&&$(".files-carousel").owlCarousel({items:3,loop:!0,margin:15,nav:!0,dots:!1,smartSpeed:1e3,navText:['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],responsive:{0:{items:1},768:{items:2},1200:{items:3}}}),$(".video-section").length>0){$(".video-section").owlCarousel({loop:!0,margin:15,items:3,nav:!0,dots:!1,navText:['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],responsive:{0:{items:1},768:{items:2},1200:{items:3}}});var s={controls:["play-large"],fullscreen:{enabled:!1},resetOnEnd:!0,hideControls:!0,clickToPlay:!0,keyboard:!1};const a=Plyr.setup(".js-player",s);a.forEach(function(l,d){l.on("play",function(){a.forEach(function(c,p){l!=c&&c.pause()})})}),$(".video-section").on("translated.owl.carousel",function(l){a.forEach(function(d,c){d.pause()})})}$(".video-section").length>0,$(".video-section, .files-carousel, .folders-carousel").each(function(){let a=$(this);a.on("show.bs.dropdown","[data-bs-toggle=dropdown]",function(){let l=bootstrap.Dropdown.getInstance(this);$(l._menu).insertAfter(a),$(this).next(".dropdown-menu").insertAfter(a)})}),$(".inc").on("click",function(){n(this,1)}),$(".dec").on("click",function(){n(this,-1)});function n(a,l){var d=$(a).parent().find("input"),c=parseInt(d.val(),10)+l;d.val(Math.max(c,0))}$(".popup-toggle").length>0&&($(".popup-toggle").click(function(){$(".toggle-sidebar").addClass("open-sidebar")}),$(".sidebar-closes").click(function(){$(".toggle-sidebar").removeClass("open-sidebar")})),setTimeout(function(){$("#upload-file").modal("hide")},4e3),setTimeout(function(){$("#upload-folder").modal("hide")},4e3),$(".upload-modal").on("hidden.bs.modal",function(){$(".upload-message").modal("show"),setTimeout(function(){$(".upload-message").modal("hide")},3e3)});let r=".card";document.querySelectorAll('[data-bs-toggle="card-fullscreen"]').forEach(a=>{a.addEventListener("click",function(l){let c=this.closest(r);return c.classList.toggle("card-fullscreen"),c.classList.remove("card-collapsed"),l.preventDefault(),!1})});let m=".card";document.querySelectorAll('[data-bs-toggle="card-remove"]').forEach(a=>{a.addEventListener("click",function(l){return l.preventDefault(),this.closest(m).remove(),!1})}),$(".more-menu").length>0&&($(".more-menu").hide(),$(".viewall-button").on("click",function(){$(this).text($(this).text()==="Less"?"Show More":"Less"),$(".more-menu").slideToggle(900)})),$(".more-menu-2").length>0&&($(".more-menu-2").hide(),$(".viewall-button-2").on("click",function(){$(this).text($(this).text()==="Less"?"Show More":"Less"),$(".more-menu-2").slideToggle(900)})),$(".more-menu-3").length>0&&($(".more-menu-3").hide(),$(".viewall-button-3").on("click",function(){$(this).text($(this).text()==="Less"?"Show More":"Less"),$(".more-menu-3").slideToggle(900)})),$(".channels-slider").length>0&&$(".channels-slider").owlCarousel({loop:!0,margin:24,dots:!1,nav:!0,smartSpeed:2e3,navContainer:".custom-nav",navText:['<i class="ti ti-arrow-narrow-left"></i>','<i class="ti ti-arrow-narrow-right"></i>'],responsive:{0:{items:3},768:{items:8},1300:{items:8}}}),$(".social-gallery-slider").length>0&&$(".social-gallery-slider").owlCarousel({loop:!0,margin:8,dots:!1,nav:!1,smartSpeed:2e3,responsive:{0:{items:2},768:{items:3},1300:{items:4}}}),$(".kanban-drag-wrap").length>0&&$(".kanban-drag-wrap").sortable({connectWith:".kanban-drag-wrap",handle:".kanban-card",placeholder:"drag-placeholder"})});
