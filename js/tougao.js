﻿+(function(c){var d={init:function(){var a=this;a._title=c("#tougao-title");a._url=c("#tougao-url");a._content=c("#tougao-content");a._submit=c("#tougao-submit");a._check=[,0,0];c("#tougao").on("shown",function(){a._title.focus()});a._title.blur(function(){a.check_title(c(this))});a._url.blur(function(){a.check_url(c(this))});a._content.blur(function(){a.check_content(c(this))});a._submit.bind("click",function(){if(!a.is_check()){a.check_title(a._title);a.check_url(a._url);a.check_content(a._content);return}var b=a._submit.prev();c.ajax({type:"POST",url:_deel.url+"/ajax/tougao.php",data:"title="+c.trim(a._title.val())+"&url="+c.trim(a._url.val())+"&content="+c.trim(a._content.val()),success:function(f){if(f==="sofast"){b.show().html("服务器忙，请稍候重试！");setTimeout(function(){b.fadeOut(1000)},5000)}if(f==="success"){b.show().addClass("text-success").html("投稿成功，审核通过后将正式发布！");setTimeout(function(){c("#tougao").modal("hide");a._title.val("");a._url.val("");a._content.val("");b.hide();a._title.focus()},4000)}if(f==="fail"){b.show().html("投稿失败，请稍候重试！");setTimeout(function(){b.fadeOut(1000)},5000)}if(f==="title"){b.show().html("标题不能为空，且不能大于40个字符！")}if(f==="url"){b.show().html("网址不能为空，且不能大于100个字符！")}if(f==="content"){b.show().html("内容不能为空，且介于200-5000个字符之间！")}}})})},is_check:function(){return this._check.join("")==="111"?true:false},check_title:function(a){if(!a.val()||a.val().length<8){this.tip(a,"标题太短，不得少于8字！",0)}else{if(a.val().length>30){this.tip(a,"标题太长，不得超过30字！",0)}else{this.tip_hide(a,0)}}},check_url:function(a){if(!a.val()||!a.val().match(/^(http|https):\/\/([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}/)){this.tip(a,"格式错误！",1)}else{this.tip_hide(a,1)}},check_content:function(a){if(!a.val()||a.val().length<200){this.tip(a,"内容太短，不得少于200字",2)}else{if(a.val().length>5000){this.tip(a,"内容太长，不得超过5000字",2)}else{this.tip_hide(a,2)}}},tip:function(b,g,a){b.next(".text-error").html(g).slideDown(300);this._check[a]=0},tip_hide:function(b,a){b.next(".text-error").slideUp(300);this._check[a]=1}};d.init()})(window.jQuery);