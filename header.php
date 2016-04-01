<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php wp_title('-', true, 'right'); echo get_option('blogname'); if (is_home ()) echo ' — ' ,get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<!--[if IE]>
<div class="browseupgrade">当前网页 <strong>不支持</strong> 您正在使用的浏览器。为了体验更好的访问效果， 请 <a href="http://browsehappy.com/" target="_blank">升级你的浏览器</a>.</div>
<![endif]-->

<?php if (is_archive() && ($paged > 1) && ($paged < $wp_query->max_num_pages)) { ?>
<link rel="prefetch" href="<?php echo get_next_posts_page_link(); ?>">
<link rel="prerender" href="<?php echo get_next_posts_page_link(); ?>">
<?php } elseif (is_singular()) { ?>
<link rel="prefetch" href="<?php bloginfo('home'); ?>">
<link rel="prerender" href="<?php bloginfo('home'); ?>">
<?php } ?>

<?php if (is_archive() && ($paged > 1) && ($paged < $wp_query->max_num_pages)) { ?>
<link rel="prefetch" href="<?php echo get_next_posts_page_link(); ?>">
<link rel="prerender" href="<?php echo get_next_posts_page_link(); ?>">
<?php } elseif (is_singular()) { ?>
<link rel="prefetch" href="<?php bloginfo('home'); ?>">
<link rel="prerender" href="<?php bloginfo('home'); ?>">
<?php } ?>
<?php
$sr_1 = 0; $sr_2 = 0; $commenton = 0; 
if( dopt('d_sideroll_b') ){ 
    $sr_1 = dopt('d_sideroll_1');
    $sr_2 = dopt('d_sideroll_2');
}
if( is_singular() ){ 
    if( comments_open() ) $commenton = 1;
}
?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.titleQIPAO.js"></script>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/shake.css" />  

<script>
window._deel = {name: '<?php bloginfo('name') ?>',url: '<?php echo get_bloginfo("template_url") ?>', ajaxpager: '<?php echo dopt('d_ajaxpager_b') ?>', commenton: <?php echo $commenton ?>, roll: [<?php echo $sr_1 ?>,<?php echo $sr_2 ?>]}
</script>
<script type="text/javascript">eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('g(0).h(e(){e d(){0.9=0[b]?" (｡･ω･｡)你好,我是阿星！":a}f b,c,a=0.9;"2"!=4 0.8?(b="8",c="k"):"2"!=4 0.5?(b="5",c="j"):"2"!=4 0.6&&(b="6",c="l"),("2"!=4 0.7||"2"!=4 0[b])&&0.7(c,d,!1)});',22,22,'document||undefined||typeof|mozHidden|webkitHidden|addEventListener|hidden|title|||||function|var|jQuery|ready|Hi|mozvisibilitychange|visibilitychange|webkitvisibilitychange'.split('|'),0,{}))</script>
<?php 
wp_head(); 
if( dopt('d_headcode_b') ) echo dopt('d_headcode'); ?>
<!--[if lt IE 9]><script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script><![endif]--> 
<link href='http://api.youziku.com/webfont/CSS/567ce880f629d808a486e2c0' rel='stylesheet' type='text/css' />
<link href='http://api.youziku.com/webfont/CSS/567ce916f629d808a486e2c7' rel='stylesheet' type='text/css' />
</head>
<body <?php body_class(); ?>>
<header style="background: url('<?php bloginfo('template_url'); ?>/img/header.jpg') center 0px repeat-x;background-size: cover;" id="header" class="header">
<div class="container-inner">
 <div class="yusi-logo">
                    <a href="/">
                        <h1 class="shake shake-opacity">
                                                        <span style="font-family:STXingkai7d157f2a447d;" class="yusi-mono"><?php bloginfo('name'); ?></span>
                                                        <span style="font-family:lixukemaobixs7d17c747447d;" class="yusi-bloger"><?php bloginfo('description'); ?></span>
                                                    </h1>
                    </a>
    </div>
</div>

	<div id="nav-header" class="navbar">
		<ul class="nav">
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
<li style="float:right;">
                    <div class="toggle-search"><i class="fa fa-search"></i></div>
<div class="search-expand" style="display: none;"><div class="search-expand-inner"><form method="get" class="searchform themeform" onsubmit="location.href='<?php echo home_url('/search/'); ?>' + encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;" action="/"><div> <input type="ext" class="search" name="s" onblur="if(this.value=='')this.value='喵呜一下，你就知道';" onfocus="if(this.value=='喵呜一下，你就知道')this.value='';" value=""></div></form></div></div>
</li>
		</ul>
	</div>
	</div>
</header>
<section class="container"><div class="speedbar">
		<?php 
		if( dopt('d_sign_b') ){ 
			global $current_user; 
			get_currentuserinfo();
			$uid = $current_user->ID;
			$u_name = get_user_meta($uid,'nickname',true);
		?>
			<div class="pull-right">
				<?php if(is_user_logged_in()){echo '<i class="fa fa-user"></i> '.$u_name.' &nbsp; '; echo ' &nbsp; &nbsp; <i class="fa fa-power-off"></i> ';}else{echo '<i class="fa fa-user"></i> ';}; wp_loginout(); ?>
			</div>
		<?php } ?>
		<div class="toptip"><strong class="text-success"><i class="fa fa-volume-up"></i> </strong> <?php echo dopt('d_tui'); ?></div>
	</div>
	<?php if( dopt('d_adsite_01_b') ) echo '<div class="banner banner-site">'.dopt('d_adsite_01').'</div>'; ?>

<script>  
	try{  
		if(window.console&&window.console.log){  
			console.log('%c我想求职，如果你看上我了，记得联系我，万分感谢！！！', 'background-image:-webkit-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );color:transparent;-webkit-background-clip: text;font-size:2em;');
			console.log('%cTel:13477996338', 'font-size:2em;');
			console.log('%cEmail:Hackxing@foxmail.com', 'font-size:2em;');
		}  
	}
	catch(e){};
</script>

<!--<script>
jQuery(document).ready(function($) {
$("html,body").click(function(e){
var n=Math.round(Math.random()*100);//随机数
var $i=$("<b></b>").text("+"+n);//添加到页面的元素
var x=e.pageX,y=e.pageY;//鼠标点击的位置
$i.css({
"z-index":99999,
"top":y-20,
"left":x,
"position":"absolute",
"color":"#E94F06"
});
$("body").append($i);
$i.animate(
{"top":y-180,"opacity":0},
1500,
function(){$i.remove();}
);
e.stopPropagation();
});
});
</script>-->