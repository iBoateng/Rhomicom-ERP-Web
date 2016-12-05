/*var App = function(){var t, e = !1, o = !1, a = !1, i = !1, n = [], l = "../assets/", s = "global/img/", r = "global/plugins/", c = "global/css/", d = {blue:"#89C4F4", red:"#F3565D", green:"#1bbc9b", purple:"#9b59b6", grey:"#95a5a6", yellow:"#F8CB00"}, p = function(){"rtl" === $("body").css("direction") && (e = !0), o = !!navigator.userAgent.match(/MSIE 8.0/), a = !!navigator.userAgent.match(/MSIE 9.0/), i = !!navigator.userAgent.match(/MSIE 10.0/), i && $("html").addClass("ie10"), (i || a || o) && $("html").addClass("ie")}, h = function(){for (var t = 0; t < n.length; t++){var e = n[t]; e.call()}}, u = function(){var t; if (o){var e; $(window).resize(function(){e != document.documentElement.clientHeight && (t && clearTimeout(t), t = setTimeout(function(){h()}, 50), e = document.documentElement.clientHeight)})} else $(window).resize(function(){t && clearTimeout(t), t = setTimeout(function(){h()}, 50)})}, f = function(){$("body").on("click", ".portlet > .portlet-title > .tools > a.remove", function(t){t.preventDefault(); var e = $(this).closest(".portlet"); $("body").hasClass("page-portlet-fullscreen") && $("body").removeClass("page-portlet-fullscreen"), e.find(".portlet-title .fullscreen").tooltip("destroy"), e.find(".portlet-title > .tools > .reload").tooltip("destroy"), e.find(".portlet-title > .tools > .remove").tooltip("destroy"), e.find(".portlet-title > .tools > .config").tooltip("destroy"), e.find(".portlet-title > .tools > .collapse, .portlet > .portlet-title > .tools > .expand").tooltip("destroy"), e.remove()}), $("body").on("click", ".portlet > .portlet-title .fullscreen", function(t){t.preventDefault(); var e = $(this).closest(".portlet"); if (e.hasClass("portlet-fullscreen"))$(this).removeClass("on"), e.removeClass("portlet-fullscreen"), $("body").removeClass("page-portlet-fullscreen"), e.children(".portlet-body").css("height", "auto"); else{var o = App.getViewPort().height - e.children(".portlet-title").outerHeight() - parseInt(e.children(".portlet-body").css("padding-top")) - parseInt(e.children(".portlet-body").css("padding-bottom")); $(this).addClass("on"), e.addClass("portlet-fullscreen"), $("body").addClass("page-portlet-fullscreen"), e.children(".portlet-body").css("height", o)}}), $("body").on("click", ".portlet > .portlet-title > .tools > a.reload", function(t){t.preventDefault(); var e = $(this).closest(".portlet").children(".portlet-body"), o = $(this).attr("data-url"), a = $(this).attr("data-error-display"); o?(App.blockUI({target:e, animate:!0, overlayColor:"none"}), $.ajax({type:"GET", cache:!1, url:o, dataType:"html", success:function(t){App.unblockUI(e), e.html(t), App.initAjax()}, error:function(t, o, i){App.unblockUI(e); var n = "Error on reloading the content. Please check your connection and try again."; "toastr" == a && toastr?toastr.error(n):"notific8" == a && $.notific8?($.notific8("zindex", 11500), $.notific8(n, {theme:"ruby", life:3e3})):alert(n)}})):(App.blockUI({target:e, animate:!0, overlayColor:"none"}), window.setTimeout(function(){App.unblockUI(e)}, 1e3))}), $('.portlet .portlet-title a.reload[data-load="true"]').click(), $("body").on("click", ".portlet > .portlet-title > .tools > .collapse, .portlet .portlet-title > .tools > .expand", function(t){t.preventDefault(); var e = $(this).closest(".portlet").children(".portlet-body"); $(this).hasClass("collapse")?($(this).removeClass("collapse").addClass("expand"), e.slideUp(200)):($(this).removeClass("expand").addClass("collapse"), e.slideDown(200))})}, b = function(){if ($("body").on("click", ".md-checkbox > label, .md-radio > label", function(){var t = $(this), e = $(this).children("span:first-child"); e.addClass("inc"); var o = e.clone(!0); e.before(o), $("." + e.attr("class") + ":last", t).remove()}), $("body").hasClass("page-md")){var t, e, o, a, i; $("body").on("click", "a.btn, button.btn, input.btn, label.btn", function(n){t = $(this), 0 == t.find(".md-click-circle").length && t.prepend("<span class='md-click-circle'></span>"), e = t.find(".md-click-circle"), e.removeClass("md-click-animate"), e.height() || e.width() || (o = Math.max(t.outerWidth(), t.outerHeight()), e.css({height:o, width:o})), a = n.pageX - t.offset().left - e.width() / 2, i = n.pageY - t.offset().top - e.height() / 2, e.css({top:i + "px", left:a + "px"}).addClass("md-click-animate"), setTimeout(function(){e.remove()}, 1e3)})}var n = function(t){"" != t.val()?t.addClass("edited"):t.removeClass("edited")}; $("body").on("keydown", ".form-md-floating-label .form-control", function(t){n($(this))}), $("body").on("blur", ".form-md-floating-label .form-control", function(t){n($(this))}), $(".form-md-floating-label .form-control").each(function(){$(this).val().length > 0 && $(this).addClass("edited")})}, g = function(){$().iCheck && $(".icheck").each(function(){var t = $(this).attr("data-checkbox")?$(this).attr("data-checkbox"):"icheckbox_minimal-grey", e = $(this).attr("data-radio")?$(this).attr("data-radio"):"iradio_minimal-grey"; t.indexOf("_line") > - 1 || e.indexOf("_line") > - 1?$(this).iCheck({checkboxClass:t, radioClass:e, insert:'<div class="icheck_line-icon"></div>' + $(this).attr("data-label")}):$(this).iCheck({checkboxClass:t, radioClass:e})})}, m = function(){$().bootstrapSwitch && $(".make-switch").bootstrapSwitch()}, v = function(){$().confirmation && $("[data-toggle=confirmation]").confirmation({btnOkClass:"btn btn-sm btn-success", btnCancelClass:"btn btn-sm btn-danger"})}, y = function(){$("body").on("shown.bs.collapse", ".accordion.scrollable", function(t){App.scrollTo($(t.target))})}, C = function(){if (location.hash){var t = encodeURI(location.hash.substr(1)); $('a[href="#' + t + '"]').parents(".tab-pane:hidden").each(function(){var t = $(this).attr("id"); $('a[href="#' + t + '"]').click()}), $('a[href="#' + t + '"]').click()}$().tabdrop && $(".tabbable-tabdrop .nav-pills, .tabbable-tabdrop .nav-tabs").tabdrop({text:'<i class="fa fa-ellipsis-v"></i>&nbsp;<i class="fa fa-angle-down"></i>'})}, x = function(){$("body").on("hide.bs.modal", function(){$(".modal:visible").size() > 1 && $("html").hasClass("modal-open") === !1?$("html").addClass("modal-open"):$(".modal:visible").size() <= 1 && $("html").removeClass("modal-open")}), $("body").on("show.bs.modal", ".modal", function(){$(this).hasClass("modal-scroll") && $("body").addClass("modal-open-noscroll")}), $("body").on("hidden.bs.modal", ".modal", function(){$("body").removeClass("modal-open-noscroll")}), $("body").on("hidden.bs.modal", ".modal:not(.modal-cached)", function(){$(this).removeData("bs.modal")})}, w = function(){$(".tooltips").tooltip(), $(".portlet > .portlet-title .fullscreen").tooltip({trigger:"hover", container:"body", title:"Fullscreen"}), $(".portlet > .portlet-title > .tools > .reload").tooltip({trigger:"hover", container:"body", title:"Reload"}), $(".portlet > .portlet-title > .tools > .remove").tooltip({trigger:"hover", container:"body", title:"Remove"}), $(".portlet > .portlet-title > .tools > .config").tooltip({trigger:"hover", container:"body", title:"Settings"}), $(".portlet > .portlet-title > .tools > .collapse, .portlet > .portlet-title > .tools > .expand").tooltip({trigger:"hover", container:"body", title:"Collapse/Expand"})}, k = function(){$("body").on("click", ".dropdown-menu.hold-on-click", function(t){t.stopPropagation()})}, I = function(){$("body").on("click", '[data-close="alert"]', function(t){$(this).parent(".alert").hide(), $(this).closest(".note").hide(), t.preventDefault()}), $("body").on("click", '[data-close="note"]', function(t){$(this).closest(".note").hide(), t.preventDefault()}), $("body").on("click", '[data-remove="note"]', function(t){$(this).closest(".note").remove(), t.preventDefault()})}, A = function(){$('[data-hover="dropdown"]').not(".hover-initialized").each(function(){$(this).dropdownHover(), $(this).addClass("hover-initialized")})}, z = function(){"function" == typeof autosize && autosize(document.querySelector("textarea.autosizeme"))}, S = function(){$(".popovers").popover(), $(document).on("click.bs.popover.data-api", function(e){t && t.popover("hide")})}, P = function(){App.initSlimScroll(".scroller")}, T = function(){jQuery.fancybox && $(".fancybox-button").size() > 0 && $(".fancybox-button").fancybox({groupAttr:"data-rel", prevEffect:"none", nextEffect:"none", closeBtn:!0, helpers:{title:{type:"inside"}}})}, D = function(){$().counterUp && $("[data-counter='counterup']").counterUp({delay:10, time:1e3})}, U = function(){(o || a) && $("input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)").each(function(){var t = $(this); "" === t.val() && "" !== t.attr("placeholder") && t.addClass("placeholder").val(t.attr("placeholder")), t.focus(function(){t.val() == t.attr("placeholder") && t.val("")}), t.blur(function(){"" !== t.val() && t.val() != t.attr("placeholder") || t.val(t.attr("placeholder"))})})}, E = function(){$().select2 && ($.fn.select2.defaults.set("theme", "bootstrap"), $(".select2me").select2({placeholder:"Select", width:"auto", allowClear:!0}))}, G = function(){$("[data-auto-height]").each(function(){var t = $(this), e = $("[data-height]", t), o = 0, a = t.attr("data-mode"), i = parseInt(t.attr("data-offset")?t.attr("data-offset"):0); e.each(function(){"height" == $(this).attr("data-height")?$(this).css("height", ""):$(this).css("min-height", ""); var t = "base-height" == a?$(this).outerHeight():$(this).outerHeight(!0); t > o && (o = t)}), o += i, e.each(function(){"height" == $(this).attr("data-height")?$(this).css("height", o):$(this).css("min-height", o)}), t.attr("data-related") && $(t.attr("data-related")).css("height", t.height())})}; return{init:function(){p(), u(), b(), g(), m(), P(), T(), E(), f(), I(), k(), C(), w(), S(), y(), x(), v(), z(), D(), this.addResizeHandler(G), U()}, initAjax:function(){g(), m(), A(), P(), E(), T(), k(), w(), S(), y(), v()}, initComponents:function(){this.initAjax()}, setLastPopedPopover:function(e){t = e}, addResizeHandler:function(t){n.push(t)}, runResizeHandlers:function(){h()}, scrollTo:function(t, e){var o = t && t.size() > 0?t.offset().top:0; t && ($("body").hasClass("page-header-fixed")?o -= $(".page-header").height():$("body").hasClass("page-header-top-fixed")?o -= $(".page-header-top").height():$("body").hasClass("page-header-menu-fixed") && (o -= $(".page-header-menu").height()), o += e?e: - 1 * t.height()), $("html,body").animate({scrollTop:o}, "slow")}, initSlimScroll:function(t){$().slimScroll && $(t).each(function(){if (!$(this).attr("data-initialized")){var t; t = $(this).attr("data-height")?$(this).attr("data-height"):$(this).css("height"), $(this).slimScroll({allowPageScroll:!0, size:"7px", color:$(this).attr("data-handle-color")?$(this).attr("data-handle-color"):"#bbb", wrapperClass:$(this).attr("data-wrapper-class")?$(this).attr("data-wrapper-class"):"slimScrollDiv", railColor:$(this).attr("data-rail-color")?$(this).attr("data-rail-color"):"#eaeaea", position:e?"left":"right", height:t, alwaysVisible:"1" == $(this).attr("data-always-visible"), railVisible:"1" == $(this).attr("data-rail-visible"), disableFadeOut:!0}), $(this).attr("data-initialized", "1")}})}, destroySlimScroll:function(t){$().slimScroll && $(t).each(function(){if ("1" === $(this).attr("data-initialized")){$(this).removeAttr("data-initialized"), $(this).removeAttr("style"); var t = {}; $(this).attr("data-handle-color") && (t["data-handle-color"] = $(this).attr("data-handle-color")), $(this).attr("data-wrapper-class") && (t["data-wrapper-class"] = $(this).attr("data-wrapper-class")), $(this).attr("data-rail-color") && (t["data-rail-color"] = $(this).attr("data-rail-color")), $(this).attr("data-always-visible") && (t["data-always-visible"] = $(this).attr("data-always-visible")), $(this).attr("data-rail-visible") && (t["data-rail-visible"] = $(this).attr("data-rail-visible")), $(this).slimScroll({wrapperClass:$(this).attr("data-wrapper-class")?$(this).attr("data-wrapper-class"):"slimScrollDiv", destroy:!0}); var e = $(this); $.each(t, function(t, o){e.attr(t, o)})}})}, scrollTop:function(){App.scrollTo()}, blockUI:function(t){t = $.extend(!0, {}, t); var e = ""; if (e = t.animate?'<div class="loading-message ' + (t.boxed?"loading-message-boxed":"") + '"><div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>':t.iconOnly?'<div class="loading-message ' + (t.boxed?"loading-message-boxed":"") + '"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif" align=""></div>':t.textOnly?'<div class="loading-message ' + (t.boxed?"loading-message-boxed":"") + '"><span>&nbsp;&nbsp;' + (t.message?t.message:"LOADING...") + "</span></div>":'<div class="loading-message ' + (t.boxed?"loading-message-boxed":"") + '"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;' + (t.message?t.message:"LOADING...") + "</span></div>", t.target){var o = $(t.target); o.height() <= $(window).height() && (t.cenrerY = !0), o.block({message:e, baseZ:t.zIndex?t.zIndex:1e3, centerY:void 0 !== t.cenrerY?t.cenrerY:!1, css:{top:"10%", border:"0", padding:"0", backgroundColor:"none"}, overlayCSS:{backgroundColor:t.overlayColor?t.overlayColor:"#555", opacity:t.boxed?.05:.1, cursor:"wait"}})} else $.blockUI({message:e, baseZ:t.zIndex?t.zIndex:1e3, css:{border:"0", padding:"0", backgroundColor:"none"}, overlayCSS:{backgroundColor:t.overlayColor?t.overlayColor:"#555", opacity:t.boxed?.05:.1, cursor:"wait"}})}, unblockUI:function(t){t?$(t).unblock({onUnblock:function(){$(t).css("position", ""), $(t).css("zoom", "")}}):$.unblockUI()}, startPageLoading:function(t){t && t.animate?($(".page-spinner-bar").remove(), $("body").append('<div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>')):($(".page-loading").remove(), $("body").append('<div class="page-loading"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + (t && t.message?t.message:"Loading...") + "</span></div>"))}, stopPageLoading:function(){$(".page-loading, .page-spinner-bar").remove()}, alert:function(t){t = $.extend(!0, {container:"", place:"append", type:"success", message:"", close:!0, reset:!0, focus:!0, closeInSeconds:0, icon:""}, t); var e = App.getUniqueID("App_alert"), o = '<div id="' + e + '" class="custom-alerts alert alert-' + t.type + ' fade in">' + (t.close?'<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>':"") + ("" !== t.icon?'<i class="fa-lg fa fa-' + t.icon + '"></i>  ':"") + t.message + "</div>"; return t.reset && $(".custom-alerts").remove(), t.container?"append" == t.place?$(t.container).append(o):$(t.container).prepend(o):1 === $(".page-fixed-main-content").size()?$(".page-fixed-main-content").prepend(o):($("body").hasClass("page-container-bg-solid") || $("body").hasClass("page-content-white")) && 0 === $(".page-head").size()?$(".page-title").after(o):$(".page-bar").size() > 0?$(".page-bar").after(o):$(".page-breadcrumb, .breadcrumbs").after(o), t.focus && App.scrollTo($("#" + e)), t.closeInSeconds > 0 && setTimeout(function(){$("#" + e).remove()}, 1e3 * t.closeInSeconds), e}, initFancybox:function(){T()}, getActualVal:function(t){return t = $(t), t.val() === t.attr("placeholder")?"":t.val()}, getURLParameter:function(t){var e, o, a = window.location.search.substring(1), i = a.split("&"); for (e = 0; e < i.length; e++)if (o = i[e].split("="), o[0] == t)return unescape(o[1]); return null}, isTouchDevice:function(){try{return document.createEvent("TouchEvent"), !0} catch (t){return!1}}, getViewPort:function(){var t = window, e = "inner"; return"innerWidth"in window || (e = "client", t = document.documentElement || document.body), {width:t[e + "Width"], height:t[e + "Height"]}}, getUniqueID:function(t){return"prefix_" + Math.floor(Math.random() * (new Date).getTime())}, isIE8:function(){return o}, isIE9:function(){return a}, isRTL:function(){return e}, isAngularJsApp:function(){return"undefined" != typeof angular}, getAssetsPath:function(){return l}, setAssetsPath:function(t){l = t}, setGlobalImgPath:function(t){s = t}, getGlobalImgPath:function(){return l + s}, setGlobalPluginsPath:function(t){r = t}, getGlobalPluginsPath:function(){return l + r}, getGlobalCssPath:function(){return l + c}, getBrandColor:function(t){return d[t]?d[t]:""}, getResponsiveBreakpoint:function(t){var e = {xs:480, sm:768, md:992, lg:1200}; return e[t]?e[t]:0}}}(); jQuery(document).ready(function(){App.init()});
 var Layout = function(){var e = "layouts/layout4/img/", a = "layouts/layout4/css/", s = App.getResponsiveBreakpoint("md"), i = function(){var e, a = $(".page-content"), i = $(".page-sidebar"), t = $("body"); if (t.hasClass("page-footer-fixed") === !0 && t.hasClass("page-sidebar-fixed") === !1){var o = App.getViewPort().height - $(".page-footer").outerHeight(!0) - $(".page-header").outerHeight(!0); a.height() < o && a.attr("style", "min-height:" + o + "px")} else{if (t.hasClass("page-sidebar-fixed"))e = n() - 10, t.hasClass("page-footer-fixed") === !1 && (e -= $(".page-footer").outerHeight(!0)); else{var r = $(".page-header").outerHeight(!0), p = $(".page-footer").outerHeight(!0); e = App.getViewPort().width < s?App.getViewPort().height - r - p:i.height() - 10, e + r + p <= App.getViewPort().height && (e = App.getViewPort().height - r - p - 45)}a.attr("style", "min-height:" + e + "px")}}, t = function(e, a){var i = location.hash.toLowerCase(), t = $(".page-sidebar-menu"); if ("click" === e || "set" === e?a = $(a):"match" === e && t.find("li > a").each(function(){var e = $(this).attr("href").toLowerCase(); return e.length > 1 && i.substr(1, e.length - 1) == e.substr(1)?void(a = $(this)):void 0}), a && 0 != a.size() && "javascript:;" !== a.attr("href").toLowerCase() && "#" !== a.attr("href").toLowerCase()){parseInt(t.data("slide-speed")), t.data("keep-expanded"); t.hasClass("page-sidebar-menu-hover-submenu") === !1?t.find("li.nav-item.open").each(function(){var e = !1; $(this).find("li").each(function(){return $(this).find(" > a").attr("href") === a.attr("href")?void(e = !0):void 0}), e !== !0 && ($(this).removeClass("open"), $(this).find("> a > .arrow.open").removeClass("open"), $(this).find("> .sub-menu").slideUp())}):t.find("li.open").removeClass("open"), t.find("li.active").removeClass("active"), t.find("li > a > .selected").remove(), a.parents("li").each(function(){$(this).addClass("active"), $(this).find("> a > span.arrow").addClass("open"), 1 === $(this).parent("ul.page-sidebar-menu").size() && $(this).find("> a").append('<span class="selected"></span>'), 1 === $(this).children("ul.sub-menu").size() && $(this).addClass("open")}), "click" === e && App.getViewPort().width < s && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click()}}, o = function(){$(".page-sidebar").on("click", "li > a", function(e){if (!(App.getViewPort().width >= s && 1 === $(this).parents(".page-sidebar-menu-hover-submenu").size())){if ($(this).next().hasClass("sub-menu") === !1)return void(App.getViewPort().width < s && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click()); var a = $(this).parent().parent(), t = $(this), o = $(".page-sidebar-menu"), n = $(this).next(), r = o.data("auto-scroll"), p = parseInt(o.data("slide-speed")), d = o.data("keep-expanded"); d !== !0 && (a.children("li.open").children("a").children(".arrow").removeClass("open"), a.children("li.open").children(".sub-menu:not(.always-open)").slideUp(p), a.children("li.open").removeClass("open")); var l = - 200; n.is(":visible")?($(".arrow", $(this)).removeClass("open"), $(this).parent().removeClass("open"), n.slideUp(p, function(){r === !0 && $("body").hasClass("page-sidebar-closed") === !1 && ($("body").hasClass("page-sidebar-fixed")?o.slimScroll({scrollTo:t.position().top}):App.scrollTo(t, l)), i()})):($(".arrow", $(this)).addClass("open"), $(this).parent().addClass("open"), n.slideDown(p, function(){r === !0 && $("body").hasClass("page-sidebar-closed") === !1 && ($("body").hasClass("page-sidebar-fixed")?o.slimScroll({scrollTo:t.position().top}):App.scrollTo(t, l)), i()})), e.preventDefault()}}), App.isAngularJsApp() && $(".page-sidebar-menu li > a").on("click", function(e){App.getViewPort().width < s && $(this).next().hasClass("sub-menu") === !1 && $(".page-header .responsive-toggler").click()}), $(".page-sidebar").on("click", " li > a.ajaxify", function(e){e.preventDefault(), App.scrollTop(); var a = $(this).attr("href"), i = $(".page-sidebar ul"), t = ($(".page-content"), $(".page-content .page-content-body")); i.children("li.active").removeClass("active"), i.children("arrow.open").removeClass("open"), $(this).parents("li").each(function(){$(this).addClass("active"), $(this).children("a > span.arrow").addClass("open")}), $(this).parents("li").addClass("active"), App.getViewPort().width < s && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click(), App.startPageLoading(); var o = $(this); $.ajax({type:"GET", cache:!1, url:a, dataType:"html", success:function(e){0 === o.parents("li.open").size() && $(".page-sidebar-menu > li.open > a").click(), App.stopPageLoading(), t.html(e), Layout.fixContentHeight(), App.initAjax()}, error:function(e, a, s){App.stopPageLoading(), t.html("<h4>Could not load the requested content.</h4>")}})}), $(".page-content").on("click", ".ajaxify", function(e){e.preventDefault(), App.scrollTop(); var a = $(this).attr("href"), i = ($(".page-content"), $(".page-content .page-content-body")); App.startPageLoading(), App.getViewPort().width < s && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click(), $.ajax({type:"GET", cache:!1, url:a, dataType:"html", success:function(e){App.stopPageLoading(), i.html(e), Layout.fixContentHeight(), App.initAjax()}, error:function(e, a, s){i.html("<h4>Could not load the requested content.</h4>"), App.stopPageLoading()}})}), $(document).on("click", ".page-header-fixed-mobile .responsive-toggler", function(){App.scrollTop()})}, n = function(){var e = App.getViewPort().height - $(".page-header").outerHeight(!0) - 40; return $("body").hasClass("page-footer-fixed") && (e -= $(".page-footer").outerHeight()), e}, r = function(){var e = $(".page-sidebar-menu"); return App.destroySlimScroll(e), 0 === $(".page-sidebar-fixed").size()?void i():void(App.getViewPort().width >= s && (e.attr("data-height", n()), App.initSlimScroll(e), i()))}, p = function(){var e = $("body"); e.hasClass("page-sidebar-fixed") && $(".page-sidebar").on("mouseenter", function(){e.hasClass("page-sidebar-closed") && $(this).find(".page-sidebar-menu").removeClass("page-sidebar-menu-closed")}).on("mouseleave", function(){e.hasClass("page-sidebar-closed") && $(this).find(".page-sidebar-menu").addClass("page-sidebar-menu-closed")})}, d = function(){var e = $("body"); $.cookie && "1" === $.cookie("sidebar_closed") && App.getViewPort().width >= s && ($("body").addClass("page-sidebar-closed"), $(".page-sidebar-menu").addClass("page-sidebar-menu-closed")), $("body").on("click", ".sidebar-toggler", function(a){var s = $(".page-sidebar"), i = $(".page-sidebar-menu"); $(".sidebar-search", s).removeClass("open"), e.hasClass("page-sidebar-closed")?(e.removeClass("page-sidebar-closed"), i.removeClass("page-sidebar-menu-closed"), $.cookie && $.cookie("sidebar_closed", "0")):(e.addClass("page-sidebar-closed"), i.addClass("page-sidebar-menu-closed"), e.hasClass("page-sidebar-fixed") && i.trigger("mouseleave"), $.cookie && $.cookie("sidebar_closed", "1")), $(window).trigger("resize")}), p(), $(".page-sidebar").on("click", ".sidebar-search .remove", function(e){e.preventDefault(), $(".sidebar-search").removeClass("open")}), $(".page-sidebar .sidebar-search").on("keypress", "input.form-control", function(e){return 13 == e.which?($(".sidebar-search").submit(), !1):void 0}), $(".sidebar-search .submit").on("click", function(e){e.preventDefault(), $("body").hasClass("page-sidebar-closed") && $(".sidebar-search").hasClass("open") === !1?(1 === $(".page-sidebar-fixed").size() && $(".page-sidebar .sidebar-toggler").click(), $(".sidebar-search").addClass("open")):$(".sidebar-search").submit()}), 0 !== $(".sidebar-search").size() && ($(".sidebar-search .input-group").on("click", function(e){e.stopPropagation()}), $("body").on("click", function(){$(".sidebar-search").hasClass("open") && $(".sidebar-search").removeClass("open")}))}, l = function(){$(".page-header").on("click", ".search-form", function(e){$(this).addClass("open"), $(this).find(".form-control").focus(), $(".page-header .search-form .form-control").on("blur", function(e){$(this).closest(".search-form").removeClass("open"), $(this).unbind("blur")})}), $(".page-header").on("keypress", ".hor-menu .search-form .form-control", function(e){return 13 == e.which?($(this).closest(".search-form").submit(), !1):void 0}), $(".page-header").on("mousedown", ".search-form.open .submit", function(e){e.preventDefault(), e.stopPropagation(), $(this).closest(".search-form").submit()})}, c = function(){var e = 300, a = 500; navigator.userAgent.match(/iPhone|iPad|iPod/i)?$(window).bind("touchend touchcancel touchleave", function(s){$(this).scrollTop() > e?$(".scroll-to-top").fadeIn(a):$(".scroll-to-top").fadeOut(a)}):$(window).scroll(function(){$(this).scrollTop() > e?$(".scroll-to-top").fadeIn(a):$(".scroll-to-top").fadeOut(a)}), $(".scroll-to-top").click(function(e){return e.preventDefault(), $("html, body").animate({scrollTop:0}, a), !1})}; return{initHeader:function(){l()}, setSidebarMenuActiveLink:function(e, a){t(e, a)}, initSidebar:function(){r(), o(), d(), App.isAngularJsApp() && t("match"), App.addResizeHandler(r)}, initContent:function(){}, initFooter:function(){c()}, init:function(){this.initHeader(), this.initSidebar(), this.initContent(), this.initFooter()}, fixContentHeight:function(){}, initFixedSidebarHoverEffect:function(){p()}, initFixedSidebar:function(){r()}, getLayoutImgPath:function(){return App.getAssetsPath() + e}, getLayoutCssPath:function(){return App.getAssetsPath() + a}}}(); App.isAngularJsApp() === !1 && jQuery(document).ready(function(){Layout.init()});*/

function isMyScriptLoaded(url) {
    var scripts = document.getElementsByTagName('script');
    for (var i = scripts.length; i--; ) {
        var cururl = scripts[i].src;
        if (cururl.indexOf(url) >= 0)
        {
            return true;
        }
    }
    return false;
}

function isMyCssLoaded(url) {
    var scripts = document.getElementsByTagName('link');
    for (var i = scripts.length; i--; ) {
        var cururl = scripts[i].href;
        if (cururl.indexOf(url) >= 0)
        {
            return true;
        }
    }
    return false;
}

function loadScript(url, callback) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    if (script.readyState) {
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function () {
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

function loadCss(url, callback) {
    var script = document.createElement("link");
    script.type = "text/css";
    script.rel = "stylesheet";
    if (script.readyState) {
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function () {
            callback();
        };
    }
    script.href = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

function showRoles()
{
    openATab('#profile', 'grp=40&typ=4');
}

function getLovsPage(elementID, titleElementID, modalBodyID, lovNm, criteriaID,
        criteriaID2, criteriaID3, chkOrRadio, mustSelSth,
        selVals, valueElmntID, descElemntID, actionText, colNoForChkBxCmprsn, addtnlWhere)
{
    $body = $("body");
    $body.addClass("mdlloadingDiag");
    if (criteriaID == '')
    {
        criteriaID = "RhoUndefined";
    }
    if (criteriaID2 == '')
    {
        criteriaID2 = "RhoUndefined";
    }
    if (criteriaID3 == '')
    {
        criteriaID3 = "RhoUndefined";
    }
    var srchFor = typeof $("#lovSrchFor").val() === 'undefined' ? '%' : $("#lovSrchFor").val();
    var srchIn = typeof $("#lovSrchIn").val() === 'undefined' ? 'Both' : $("#lovSrchIn").val();
    var pageNo = typeof $("#lovPageNo").val() === 'undefined' ? 1 : $("#lovPageNo").val();
    var limitSze = typeof $("#lovDsplySze").val() === 'undefined' ? 10 : $("#lovDsplySze").val();

    var criteriaIDVal = typeof $("#" + criteriaID).val() === 'undefined' ? -1 : $("#" + criteriaID).val();
    var criteriaID2Val = typeof $("#" + criteriaID2).val() === 'undefined' ? '' : $("#" + criteriaID2).val();
    var criteriaID3Val = typeof $("#" + criteriaID3).val() === 'undefined' ? '' : $("#" + criteriaID3).val();
    if (colNoForChkBxCmprsn == 1)
    {
        selVals = typeof $("#" + descElemntID).val() === 'undefined' ? selVals : $("#" + descElemntID).val();
    } else if (colNoForChkBxCmprsn == 0)
    {
        selVals = typeof $("#" + valueElmntID).val() === 'undefined' ? selVals : $("#" + valueElmntID).val();
    }
    if (actionText == 'clear')
    {
        srchFor = "%";
        pageNo = 1;
    } else if (actionText == 'next')
    {
        pageNo = parseInt(pageNo) + 1;
    } else if (actionText == 'previous')
    {
        pageNo = parseInt(pageNo) - 1;
    }
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        /*code for IE7+, Firefox, Chrome, Opera, Safari*/
        xmlhttp = new XMLHttpRequest();
    } else
    {
        /*code for IE6, IE5*/
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            $('#' + titleElementID).html(lovNm);

            $('#' + modalBodyID).html(xmlhttp.responseText);
            /*$('.modal-content').resizable({
             //alsoResize: ".modal-dialog",
             minHeight: 600,
             minWidth: 300
             });*/
            $('.modal-dialog').draggable();

            $('#' + elementID).on('show.bs.modal', function (e) {
                $(this).find('.modal-body').css({
                    'max-height': '100%'
                });
            });
            $body.removeClass("mdlloadingDiag");
            $('#' + elementID).modal('show');
            $(document).ready(function () {
                $("#lovForm").submit(function (e) {
                    e.preventDefault();
                    return false;
                });
                var cntr = 0;
                var table = $('#lovTblRO').DataTable({
                    retrieve: true,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                    "bFilter": false,
                    "scrollX": false
                });
                $('#lovTblRO').wrap('<div class="dataTables_scroll"/>');
                /*var intrvlID = setInterval(function () {
                 cntr = cntr + 1;
                 table = $('#lovTblRO').DataTable({
                 retrieve: true,
                 "paging": false,
                 "ordering": true,
                 "info": false,
                 "bFilter": false,
                 "scrollX": true
                 });
                 if (cntr >= 2)
                 {
                 clearInterval(intrvlID);
                 }
                 }, 300);*/
                $('#lovTblRO tbody').on('dblclick', 'tr', function () {

                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                    $checkedBoxes = $(this).find('input[type=checkbox]');
                    $checkedBoxes.each(function (i, checkbox) {
                        checkbox.checked = true;
                    });
                    $radioBoxes = $(this).find('input[type=radio]');
                    $radioBoxes.each(function (i, radio) {
                        radio.checked = true;
                    });
                    applySlctdLov(elementID, 'lovForm', valueElmntID, descElemntID);
                });

                $('#lovTblRO tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                        $checkedBoxes = $(this).find('input[type=checkbox]');
                        $checkedBoxes.each(function (i, checkbox) {
                            checkbox.checked = false;
                        });
                        $radioBoxes = $(this).find('input[type=radio]');
                        $radioBoxes.each(function (i, radio) {
                            radio.checked = false;
                        });
                    } else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');

                        $checkedBoxes = $(this).find('input[type=checkbox]');
                        $checkedBoxes.each(function (i, checkbox) {
                            checkbox.checked = true;
                        });
                        $radioBoxes = $(this).find('input[type=radio]');
                        $radioBoxes.each(function (i, radio) {
                            radio.checked = true;
                        });
                    }
                });
                $('#lovTblRO tbody')
                        .on('mouseenter', 'tr', function () {
                            if ($(this).hasClass('highlight')) {
                                $(this).removeClass('highlight');
                            } else {
                                table.$('tr.highlight').removeClass('highlight');
                                $(this).addClass('highlight');
                            }
                        });
            });
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //alert(criteriaIDVal);
    xmlhttp.send("grp=2&typ=1&lovNm=" + lovNm +
            "&criteriaID=" + criteriaID + "&criteriaID2=" + criteriaID2 +
            "&criteriaID3=" + criteriaID3 + "&criteriaIDVal=" + criteriaIDVal + "&criteriaID2Val=" + criteriaID2Val +
            "&criteriaID3Val=" + criteriaID3Val + "&chkOrRadio=" + chkOrRadio +
            "&mustSelSth=" + mustSelSth + "&selvals=" + selVals +
            "&valElmntID=" + valueElmntID + "&descElmntID=" + descElemntID +
            "&modalElementID=" + elementID + "&lovModalBody=" + modalBodyID +
            "&lovModalTitle=" + titleElementID + "&searchfor=" + srchFor + "&searchin=" + srchIn +
            "&pageNo=" + pageNo + "&limitSze=" + limitSze + "&colNoForChkBxCmprsn=" + colNoForChkBxCmprsn + "&addtnlWhere=" + addtnlWhere + "");
}

function enterKeyFuncLov(e, elementID, titleElementID, modalBodyID, lovNm, criteriaID,
        criteriaID2, criteriaID3, chkOrRadio, mustSelSth,
        selVals, valueElmntID, descElemntID, actionText, colNoForChkBxCmprsn, addtnlWhere)
{
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if (charCode == 13) {
        getLovsPage(elementID, titleElementID, modalBodyID, lovNm, criteriaID,
                criteriaID2, criteriaID3, chkOrRadio, mustSelSth,
                selVals, valueElmntID, descElemntID, actionText, colNoForChkBxCmprsn, addtnlWhere);
    }
}

function applySlctdLov(modalElementID, formElmntID, valueElmntID, descElemntID) {
    var form = document.getElementById(formElmntID);
    var cbResults = '';
    var radioResults = '';
    var fnl_res = '';
    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type === 'checkbox') {
            if (form.elements[i].checked === true) {
                cbResults += form.elements[i].value + '|';
            }
        }
        if (form.elements[i].type === 'radio') {
            if (form.elements[i].checked === true) {
                radioResults += form.elements[i].value + '|';
            }
        }
    }
    if (cbResults.length > 1)
    {
        fnl_res = cbResults.slice(0, -1);
    }
    if (radioResults.length > 1)
    {
        fnl_res = radioResults.slice(0, -1);
    }
    var bigArry = [];
    var tempArry = [];
    bigArry = fnl_res.split("|");
    var i = 0;
    for (i = 0; i < bigArry.length; i++) {
        tempArry = bigArry[i].split(";");
        if (tempArry.length > 1)
        {
            if (typeof ($('#' + descElemntID).val()) !== 'undefined')
            {
                document.getElementById(descElemntID).value = tempArry[2];
            }
            if (typeof ($('#' + valueElmntID).val()) !== 'undefined')
            {
                document.getElementById(valueElmntID).value = tempArry[1];
            }
        }
    }
    $('#' + modalElementID).modal('hide');
}

function doAjax(linkArgs, elementID, actionAfter, titleMsg, titleElementID, modalBodyID)
{
    $body = $("body");
    $body.addClass("mdlloading");
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            /*$(elementID).html("<p><img style=\"width:80px;height:25px;display:inline;float:left;margin-right:5px;clear: left;\" src='cmn_images/animated_loading.gif'/>Loading...Please Wait...</p>");*/
            if (actionAfter == 'OverwritePage')
            {
                $body.removeClass("mdlloading");
                var newDoc = document.open("text/html", "replace");
                newDoc.write(xmlhttp.responseText);
                newDoc.close();
            } else if (actionAfter == 'Redirect')
            {
                $body.removeClass("mdlloading");
                window.open(xmlhttp.responseText, '_blank');
            } else if (actionAfter == 'ShowDialog')
            {
                $body.removeClass("mdlloading");
                $('#' + titleElementID).html(titleMsg);
                $('#' + modalBodyID).html(xmlhttp.responseText);
                $('#' + elementID).on('show.bs.modal', function (e) {
                    console.debug('modal shown!');
                });
                $('#' + elementID).modal('show');
            } else
            {
                document.getElementById(elementID).innerHTML = xmlhttp.responseText;
                $body.removeClass("mdlloading");
            }
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(linkArgs.trim());
}

function openATab(slctr, linkArgs)
{
    getMsgAsync('grp=1&typ=11&q=Check Session', function () {
        $body = $("body");
        var $this = $(slctr + 'tab');
        var targ = slctr;
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        } else
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                if (linkArgs.indexOf("grp=40&typ=2") !== -1)
                {
                    loadScript("app/cmncde/myinbox.js", function () {
                        $this.tab('show');
                        prepareInbox(linkArgs, $body, targ, xmlhttp.responseText);
                    });
                } else if (linkArgs.indexOf("grp=8&typ=1") !== -1)
                {
                    /*$.fn.datepicker.defaults.format = "dd-M-yyyy";*/
                    loadScript("app/prs/prsn.js?v=29", function () {
                        $this.tab('show');
                        prepareProfile(linkArgs, $body, targ, xmlhttp.responseText);
                    });

                } else
                {
                    $(targ).html(xmlhttp.responseText);
                    $this.tab('show');
                    $body.removeClass("mdlloading");
                }
            }
        };
        xmlhttp.open("POST", "index.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(linkArgs.trim());
    });
}

function logOutFunc()
{
//glyphicon glyphicon-menu-left  modal-sm  modal-dialog
    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        type: BootstrapDialog.TYPE_DEFAULT,
        title: 'System Alert!',
        message: 'Are you sure you want to Logout?',
        animate: true,
        //draggable: true,
        //cssClass:"modal-dialog modal-sm",
        onshow: function (dialog) {
            /*var id = setInterval(function () {
             $("div.modal-dialog").addClass("modal-sm");
             clearInterval(id);
             }, 300);
             $("div.modal-dialog").addClass("modal-sm");*/
        },
        buttons: [{
                label: 'Cancel',
                icon: 'glyphicon glyphicon-ban-circle',
                action: function (dialogItself) {
                    //$("div.modal-dialog").addClass("modal-sm");
                    dialogItself.close();
                }
            }, {
                label: 'Logout',
                icon: 'glyphicon glyphicon-menu-left',
                cssClass: 'btn-primary',
                action: function (dialogItself) {
                    $.ajax({
                        method: "POST",
                        url: "index.php",
                        data: {q: 'logout'},
                        success: function (result) {
                            //$("#div1").html(result);
                            window.location = "index.php";
                            /* var newDoc = document.open("text/html", "replace");
                             newDoc.write(result);
                             newDoc.close();*/
                        }});
                }
            }]
    });
}

function getMsgAsync(linkArgs, callback) {
    $body = $("body");
    $body.addClass("mdlloading");
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            var sessionvld = xmlhttp.responseText;
            //alert(sessionvld);
            if (sessionvld != 1
                    || sessionvld == ''
                    || (typeof sessionvld === 'undefined'))
            {
                sessionvld = "<div><h3 style=\"text-align:center; color:red;\">INVALID SESSION!!!</h3>" +
                        "<p style=\"text-align:center; color:red;\"><span style=\"font-weight:bold;font-style:italic;\"> " +
                        "Sorry, your session has become Invalid. <br/> Click <a href=\"javascript: window.location='index.php';\" " +
                        "style=\"text-decoraction:underline;color:blue;\"> here to login again!</a></span></p></div>";
            }

            if (sessionvld != 1)
            {
                $body.removeClass("mdlloading");
                BootstrapDialog.show({
                    size: BootstrapDialog.SIZE_SMALL,
                    type: BootstrapDialog.TYPE_DEFAULT,
                    title: 'Session Expired!',
                    message: sessionvld,
                    animate: true,
                    buttons: [{
                            label: 'OK',
                            icon: 'glyphicon glyphicon-menu-left',
                            cssClass: 'btn-primary',
                            action: function (dialogItself) {
                                $.ajax({
                                    method: "POST",
                                    url: "index.php",
                                    data: {q: 'logout'},
                                    success: function (result) {
                                        //$("#div1").html(result);
                                        window.location = "index.php";
                                        /* var newDoc = document.open("text/html", "replace");
                                         newDoc.write(result);
                                         newDoc.close();*/
                                    }});
                            }
                        }]
                });
            } else {
                callback();
            }
        } else
        {

        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(linkArgs.trim());
}

function dwnldAjxCall(linkArgs, elemtnID) {
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            document.getElementById(elemtnID).innerHTML = "&nbsp;";
            window.open(xmlhttp.responseText, '_blank');
        } else
        {
            document.getElementById(elemtnID).innerHTML = "<p><img style=\"width:80px;height:25px;display:inline;float:left;margin-right:5px;clear: left;\" src='cmn_images/animated_loading.gif'/>Loading...Please Wait...</p>";
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(linkArgs.trim());
}

function dwnldAjxCall1(linkArgs) {
    var msgDetailsWindowID1 = new Ext.Window({
        title: ' Document Download ',
        layout: 'fit',
        width: 300,
        autoScroll: true,
        maximizable: true,
        height: 150,
        modal: true,
        border: true,
        bodyBorder: true,
        padding: '10 20 10 20',
        style: 'background-color:#e6e6e6 !important;',
        bodyStyle: 'border:1px solid #ccc !important;background:#ffffff; padding:10px;',
        html: "<div id=\"docDwnloadsWindowID1\"><p><img style=\"width:80px;height:25px;display:inline;float:left;margin-right:5px;clear: left;\" src='cmn_images/animated_loading.gif'/>Loading...Please Wait...</p></div>",
        buttons: [{
                text: 'Close',
                handler: function () {
                    Ext.getBody().unmask();
                    document.getElementsByTagName('body')[0].style.overflow = "auto";
                    msgDetailsWindowID1.close();
                }
            }]
    });
    msgDetailsWindowID1.on('afterrender', function (win) {
        document.getElementsByTagName('body')[0].style.overflow = 'hidden';
        document.getElementsByClassName('x-mask')[0].style.background = 'black';
    });
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            document.getElementById("docDwnloadsWindowID1").innerHTML = "&nbsp;";
            msgDetailsWindowID1.close();
            window.open(xmlhttp.responseText, '_blank');
        } else
        {
//document.getElementById("docDwnloadsWindowID1").innerHTML = "<p><img style=\"width:80px;height:25px;display:inline;float:left;margin-right:5px;clear: left;\" src='cmn_images/animated_loading.gif'/>Loading...Please Wait...</p>";
        }
    };
    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(linkArgs.trim());
    msgDetailsWindowID1.show();
}

function myIP() {
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open("GET", "http://api.hostip.info/get_html.php", false);
    var res = "";
    var hostipInfo, ipAddress;
    var t = setTimeout(function () {
        xmlhttp.abort();
        xmlhttp = null;
        res = "Unknown";
    }, 3000);
    xmlhttp.send();
    if (res === "Unknown")
    {
        return res;
    } else if (xmlhttp.readyState === 4)
    {
        var i = 0;
        hostipInfo = xmlhttp.responseText.split("\n");
        for (i = 0; hostipInfo.length >= i; i++) {
            ipAddress = hostipInfo[i].split(":");
            if (ipAddress[0] === "IP")
            {
                return ipAddress[1];
            }
        }
    }
}

function myCountry() {
    var res = "";
    var xmlhttp;
    var hostipInfo, ipAddress;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    } else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open("GET", "http://api.hostip.info/get_html.php", false);
    var t = setTimeout(function () {
        xmlhttp.abort();
        xmlhttp = null;
        res = "Unknown";
    }, 3000);
    xmlhttp.send();
    if (res === "Unknown")
    {
        return res;
    } else if (xmlhttp.readyState === 4)
    {
        var i;
        hostipInfo = xmlhttp.responseText.split("\n");
        for (i = 0; hostipInfo.length >= i; i++) {
            ipAddress = hostipInfo[i].split(":");
            if (ipAddress[0] === "Country")
            {
                return ipAddress[1];
            }
        }
    }
}
