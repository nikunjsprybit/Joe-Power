$wcfm_products_table='';function initiateTip(){jQuery('.img_tip, .text_tip').each(function(){jQuery(this).qtip({content:jQuery(this).attr('data-tip'),position:{my:'top center',at:'bottom center',viewport:jQuery(window)},show:{event:'mouseover',solo:true,},hide:{inactive:6000,fixed:true},style:{classes:'qtip-dark qtip-shadow qtip-rounded qtip-wcfm-css qtip-wcfm-core-css'}});});}
function GetURLParameter(sParam){var sPageURL=window.location.search.substring(1);var sURLVariables=sPageURL.split('&');for(var i=0;i<sURLVariables.length;i++){var sParameterName=sURLVariables[i].split('=');if(sParameterName[0]==sParam){return sParameterName[1];}}}
jQuery(document).ready(function($){initiateTip();$('.wcfm_delete_product').each(function(){$(this).click(function(event){event.preventDefault();var rconfirm=confirm("Are you sure and want to delete this 'Product'?\nYou can't undo this action ...");if(rconfirm)deleteWCFMProduct($(this));return false;});});function deleteWCFMProduct(item){jQuery('.products').block({message:null,overlayCSS:{background:'#fff',opacity:0.6}});var data={action:'delete_wcfm_product',proid:item.data('proid')}
jQuery.ajax({type:'POST',url:woocommerce_params.ajax_url,data:data,success:function(response){window.location=wcfm_messages.shop_url;}});}});
;!function(a,b){"use strict";function c(){if(!e){e=!0;var a,c,d,f,g=-1!==navigator.appVersion.indexOf("MSIE 10"),h=!!navigator.userAgent.match(/Trident.*rv:11\./),i=b.querySelectorAll("iframe.wp-embedded-content");for(c=0;c<i.length;c++){if(d=i[c],!d.getAttribute("data-secret"))f=Math.random().toString(36).substr(2,10),d.src+="#?secret="+f,d.setAttribute("data-secret",f);if(g||h)a=d.cloneNode(!0),a.removeAttribute("security"),d.parentNode.replaceChild(a,d)}}}var d=!1,e=!1;if(b.querySelector)if(a.addEventListener)d=!0;if(a.wp=a.wp||{},!a.wp.receiveEmbedMessage)if(a.wp.receiveEmbedMessage=function(c){var d=c.data;if(d.secret||d.message||d.value)if(!/[^a-zA-Z0-9]/.test(d.secret)){var e,f,g,h,i,j=b.querySelectorAll('iframe[data-secret="'+d.secret+'"]'),k=b.querySelectorAll('blockquote[data-secret="'+d.secret+'"]');for(e=0;e<k.length;e++)k[e].style.display="none";for(e=0;e<j.length;e++)if(f=j[e],c.source===f.contentWindow){if(f.removeAttribute("style"),"height"===d.message){if(g=parseInt(d.value,10),g>1e3)g=1e3;else if(~~g<200)g=200;f.height=g}if("link"===d.message)if(h=b.createElement("a"),i=b.createElement("a"),h.href=f.getAttribute("src"),i.href=d.value,i.host===h.host)if(b.activeElement===f)a.top.location.href=d.value}else;}},d)a.addEventListener("message",a.wp.receiveEmbedMessage,!1),b.addEventListener("DOMContentLoaded",c,!1),a.addEventListener("load",c,!1)}(window,document);
;jQuery(document).ready(function($){jQuery('.menu_tip').each(function(){jQuery(this).qtip({content:jQuery(this).attr('data-tip'),position:{my:'center right',at:'center left',viewport:jQuery(window)},show:{event:'mouseover',solo:true},hide:{inactive:6000,fixed:true},style:{classes:'qtip-dark qtip-shadow qtip-rounded qtip-wcfm-menu-css'}});});$('#wcfm_menu .wcfm_menu_item').each(function(){$(this).mouseover(function(){var hideTime;$hover_block=$(this).find('.wcfm_sub_menu_items');clearTimeout(hideTime);$hover_block.show('slow',function(){hideTime=setTimeout(function(){$('.wcfm_sub_menu_items').hide('slow');$hover_block.removeClass('moz_class');},30000);});});});});