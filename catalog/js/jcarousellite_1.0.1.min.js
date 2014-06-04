/**
 * jCarouselLite - jQuery plugin to navigate images/any content in a carousel style widget.
 * @requires jQuery v1.2 or above
 *
 * http://gmarwaha.com/jquery/jcarousellite/
 *
 * Copyright (c) 2007 Ganeshji Marwaha (gmarwaha.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 1.0.1
 * Note: Requires jquery 1.2 or above from version 1.0.1
 */
 
 /**
  *
  * Library modified for pause on mouse hover
  * @author Saikat Biswas/saikatbiswas82@gmail.com
  *
 */
 
var hasMouseEntered=false;var intervalId=null;(function(a){function b(b,c){return parseInt(a.css(b[0],c))||0}function c(a){return a[0].offsetWidth+b(a,"marginLeft")+b(a,"marginRight")}function d(a){return a[0].offsetHeight+b(a,"marginTop")+b(a,"marginBottom")}a.fn.jCarouselLite=function(b){b=a.extend({btnPrev:null,btnNext:null,btnGo:null,mouseWheel:false,auto:null,pauseOnMouseOver:false,speed:200,easing:null,vertical:false,circular:true,visible:3,start:0,scroll:1,beforeStart:null,afterEnd:null},b||{});a(this).mouseenter(function(){hasMouseEntered=true});a(this).mouseleave(function(){hasMouseEntered=false});return this.each(function(){function t(){return m.slice(p).slice(0,l)}function u(c){if(!e&&b.pauseOnMouseOver&&!hasMouseEntered){if(b.beforeStart)b.beforeStart.call(this,t());if(b.circular){if(c<=b.start-l-1){i.css(f,-((n-l*2)*q)+"px");p=c==b.start-l-1?n-l*2-1:n-l*2-b.scroll}else if(c>=n-l+1){i.css(f,-(l*q)+"px");p=c==n-l+1?l+1:l+b.scroll}else p=c}else{if(c<0||c>n-l)return;else p=c}e=true;i.animate(f=="left"?{left:-(p*q)}:{top:-(p*q)},b.speed,b.easing,function(){if(b.afterEnd)b.afterEnd.call(this,t());e=false});if(!b.circular){a(b.btnPrev+","+b.btnNext).removeClass("disabled");a(p-b.scroll<0&&b.btnPrev||p+b.scroll>n-l&&b.btnNext||[]).addClass("disabled")}}return false}var e=false,f=b.vertical?"top":"left",g=b.vertical?"height":"width";var h=a(this),i=a("ul",h),j=a("li",i),k=j.size(),l=b.visible;if(b.circular){i.prepend(j.slice(k-l-1+1).clone()).append(j.slice(0,l).clone());b.start+=l}var m=a("li",i),n=m.size(),p=b.start;h.css("visibility","visible");m.css({overflow:"hidden","float":b.vertical?"none":"left"});i.css({margin:"0",padding:"0",position:"relative","list-style-type":"none","z-index":"1"});h.css({overflow:"hidden",position:"relative","z-index":"2",left:"0px"});var q=b.vertical?d(m):c(m);var r=q*n;var s=q*l;m.css({width:m.width(),height:m.height()});i.css(g,r+"px").css(f,-(p*q));h.css(g,s+"px");if(b.btnPrev)a(b.btnPrev).click(function(){return u(p-b.scroll)});if(b.btnNext)a(b.btnNext).click(function(){return u(p+b.scroll)});if(b.btnGo)a.each(b.btnGo,function(c,d){a(d).click(function(){return u(b.circular?b.visible+c:c)})});if(b.mouseWheel&&h.mousewheel)h.mousewheel(function(a,c){return c>0?u(p-b.scroll):u(p+b.scroll)});if(b.auto){intervalId=setInterval(function(){u(p+b.scroll)},b.auto+b.speed)}})};})(jQuery)