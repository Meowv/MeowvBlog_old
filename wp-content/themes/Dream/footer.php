<script src="<?php bloginfo('template_directory'); ?>/js/posfixed.js"></script><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fancybox/fancybox.css" />  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/fancybox/fancybox.js"></script>    <script type="text/javascript">      $(document).ready(function() {          $(".fancybox").fancybox();      });  </script> </section><style type="text/css"><!--.STYLE1 {color: #006699}.footer-inner .copyright.pull-left p {	color: 2fa2d4;	font-weight:100;	font-size:15px;	overflow: hidden;    white-space: nowrap;    text-overflow: ellipsis;}.footer-inner .copyright.pull-left p {	color: #06945d;}.footer-inner .copyright.pull-left p {	color: #00FFCF;}.s {	color: #000;}.a {	font-weight: bold;}--></style><div class="dandelion">    <span class="smalldan"></span>    <span class="bigdan"></span></div> <style type="text/css">@media screen and (max-width:600px){.dandelion{display: none !important;}}    .dandelion .smalldan {width: 36px;height: 60px;left: 21px;background-position: 0 -90px;border: 0px solid red;}.dandelion span {-webkit-animation: ball-x 3s linear 2s infinite;  -moz-animation: ball-x 3s linear 2s infinite;  animation: ball-x 3s linear 2s infinite;-webkit-transform-origin: bottom center;  -moz-transform-origin: bottom center;  transform-origin: bottom center;}.dandelion span {display: block;position: fixed;z-index:9999999999;bottom: 0px;background-image: url(http://meowv.com/wp-content/themes/Dream/img/pgy.png);background-repeat: no-repeat;_background: none;}.dandelion .bigdan {width: 64px;height: 115px;left: 47px;background-position: -86px -36px;border: 0px solid red;}@keyframes ball-x {    0% { transform:rotate(0deg);}   20% { transform:rotate(5deg); }   40% { transform:rotate(0deg);}   60% { transform:rotate(-5deg);}   80% { transform:rotate(0deg);}   100% { transform:rotate(0deg);}}@-webkit-keyframes ball-x {    0% { -webkit-transform:rotate(0deg);}   20% { -webkit-transform:rotate(5deg); }   40% { -webkit-transform:rotate(0deg);}   60% { -webkit-transform:rotate(-5deg);}   80% { -webkit-transform:rotate(0deg);}   100% { -webkit-transform:rotate(0deg);}}@-moz-keyframes ball-x {    0% { -moz-transform:rotate(0deg);}   20% { -moz-transform:rotate(5deg); }   40% { -moz-transform:rotate(0deg);}   60% { -moz-transform:rotate(-5deg);}   80% { -moz-transform:rotate(0deg);}   100% { -moz-transform:rotate(0deg);}}</style><footer class="footer"><div class="footer-inner">        <div class="copyright pull-left">                    <p>Copyright <span class="s">©</span> 2015 - 2017 <a>&nbsp;&nbsp;<a href="<?php site_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>		  <?php if (!_is_mobile() ): ?>		  <a>&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" rel="external nofollow" target="_blank"> &nbsp网站备案：<?php echo get_option( 'zh_cn_l10n_icp_num' );?> <a>&nbsp;&nbsp;Theme By <a href="http://meowv.com" target="_blank"><img src="http://meowv.com/wp-content/themes/Dream/img/footer2.png" />
</a></a>          响应时间：<?php timer_stop(1); ?>ms<div id="TimeShow">
<p><span class="a">站点统计</span>：共有<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?>  篇文章     <?php $count_pages = wp_count_posts('page'); echo $page_posts = $count_pages->publish; ?>  个页面     <?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?>条评论  <?php echo $count_tags = wp_count_terms('post_tag'); ?> 个标签 <?php echo $count_categories = wp_count_terms('category'); ?>个分类 最后更新时间：<?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-n-j', strtotime($last[0]->MAX_m));echo $last; ?>.&nbsp;<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255774534'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1255774534%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>.
<a href="http://meowv.com"><img src="http://meowv.com/wp-content/themes/Dream/img/footer1.png"></a>
</p>
<!-- <p style="text-align: center;">
<a href="mailto:123@meowv.com"><img src="http://meowv.com/wp-content/themes/Dream/icon/email.svg"></a>
<a href="https://www.zhihu.com/people/meowv"><img src="http://meowv.com/wp-content/themes/Dream/icon/zhihu.svg"></a>
<a href="tencent://Message/?Uin=494910887&Menu=yes"><img src="http://meowv.com/wp-content/themes/Dream/icon/QQ.svg"></a>
<a><img src="http://meowv.com/wp-content/themes/Dream/icon/weixin.svg"></a>
<a href="http://weibo.com/Tencentgou"><img src="http://meowv.com/wp-content/themes/Dream/icon/weibo.svg"></a>
<a><img src="http://meowv.com/wp-content/themes/Dream/icon/alipay.svg"></a>
<a href="https://github.com/Meowv"><img src="http://meowv.com/wp-content/themes/Dream/icon/github.svg"></a></p> -->
</div></div><?php endif ;?>        <div class="trackcode pull-right">          <?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>      </div>    </div></footer><?php wp_footer(); global $dHasShare; if($dHasShare == true){ 	echo'<script>with(document)0[(getElementsByTagName("head")[0]||body).appendChild(createElement("script")).src="http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion="+~(-new Date()/36e5)];</script>';}  if( dopt('d_footcode_b') ) echo dopt('d_footcode'); ?>
</body></html>