<?php

$dname = 'Dream';


add_action( 'after_setup_theme', 'deel_setup' );

include('admin/Dream.php');
include('widgets/index.php');
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
add_filter('widget_text', 'php_text', 99);
function php_text($text) {
if (strpos($text, '<' . '?') !== false) {
ob_start();
eval('?' . '>' . $text);
$text = ob_get_contents();
ob_end_clean();
}
return $text;
}

function deel_setup(){
  
	//去除头部冗余代码
	remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head',   'wp_generator' ); 
	//
	add_filter('xmlrpc_enabled', '__return_false');
	add_theme_support( 'custom-background' );

	//关键字
	add_action('wp_head','deel_keywords');   

	//页面描述 
	add_action('wp_head','deel_description');   

	//阻止站内PingBack
	if( dopt('d_pingback_b') ){
		add_action('pre_ping','deel_noself_ping');   
	}   

	//评论回复邮件通知
	add_action('comment_post','comment_mail_notify'); 

	//自动勾选评论回复邮件通知，不勾选则注释掉 
	add_action('comment_form','deel_add_checkbox');

	//评论表情改造，如需更换表情，img/smilies/下替换
	add_filter('smilies_src','deel_smilies_src',1,10); 

	//移除自动保存和修订版本
	if( dopt('d_autosave_b') ){
		add_action('wp_print_scripts','deel_disable_autosave' );
		remove_action('pre_post_update','wp_save_post_revision' );
	}

	//去除自带js
	wp_deregister_script( 'l10n' ); 

	//修改默认发信地址
	add_filter('wp_mail_from', 'deel_res_from_email');
	add_filter('wp_mail_from_name', 'deel_res_from_name');

	//缩略图设置
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(300, 180, true); 

	add_editor_style('editor-style.css');

	//头像缓存  
	if( dopt('d_avatar_b') ){
		add_filter('get_avatar','deel_avatar');  
	}

	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'nav' => __('网站导航'),
			'pagemenu' => __('页面导航')
		));
	}

}

if (function_exists('register_sidebar')){
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2>',
		'after_title'   => '</h2></div>'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2>',
		'after_title'   => '</h2></div>'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2>',
		'after_title'   => '</h2></div>'
	));
	register_sidebar(array(
		'name'          => '文章页侧栏',
		'id'            => 'widget_postsidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2>',
		'after_title'   => '</h2></div>'
	));
	register_sidebar(array(
		'name'          => '页面侧栏',
		'id'            => 'widget_pagesidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2>',
		'after_title'   => '</h2></div>'
	));
}

function deel_breadcrumbs(){
    if( !is_single() ) return false;
    $categorys = get_the_category();
    $category = $categorys[0];
    
    return '<a title="返回首页" href="'.get_bloginfo('url').'"><i class="fa fa-home"></i></a> <small>></small> '.get_category_parents($category->term_id, true, ' <small>></small> ').'<span class="muted">'.get_the_title().'</span>';
}


// 取消原有jQuery
function footerScript() {
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
 	wp_register_script( 'jquery','//libs.baidu.com/jquery/1.8.3/jquery.min.js', false,'1.0');
	wp_enqueue_script( 'jquery' );
        wp_register_script( 'default', get_template_directory_uri() . '/js/jquery.js', false, '1.0', dopt('d_jquerybom_b') ? true : false );   
        wp_enqueue_script( 'default' );   
	wp_register_style( 'style', get_template_directory_uri() . '/style.css',false,'1.0' );
	wp_enqueue_style( 'style' ); 
    }  
}  
add_action( 'wp_enqueue_scripts', 'footerScript' );


if ( ! function_exists( 'deel_paging' ) ) :
function deel_paging() {
    $p = 4;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';

    if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
    if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
    // echo '<li><span>共 '.$max_page.' 页</span></li>';
    echo '</ul></div>';
}
function p_link( $i, $title = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
}
endif;

function deel_strimwidth($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}

function dopt($e){
		return stripslashes(get_option($e));
	}

if ( ! function_exists( 'deel_views' ) ) :
function deel_record_visitors(){
	if (is_singular()) 
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'deel_record_visitors');  

function deel_views($after=''){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  echo $views, $after;
}
endif;
//baidu分享
$dHasShare = false;
function deel_share(){
	if( !dopt('d_bdshare_b') ) return false;
  echo '<span class="action action-share bdsharebuttonbox"><i class="fa fa-share-alt"></i>分享 (<span class="bds_count" data-cmd="count" title="累计分享0次">0</span>)<div class="action-popover"><div class="popover top in"><div class="arrow"></div><div class="popover-content"><a href="#" class="sinaweibo fa fa-weibo" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_qzone fa fa-star" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="tencentweibo fa fa-tencent-weibo" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="qq fa fa-qq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_renren fa fa-renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin fa fa-weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_more fa fa-ellipsis-h" data-cmd="more"></a></div></div></div></span>';
  global $dHasShare;
  $dHasShare = true;
}

function deel_avatar_default(){ 
 
}

add_filter( 'avatar_defaults', 'default_avatar' );
function default_avatar ( $avatar_defaults ) {
    $myavatar = get_bloginfo('template_url'). '/img/defaultr.jpg';    //默认图片路径
    $avatar_defaults[$myavatar] = "默认头像";    //后台显示名称
    return $avatar_defaults;
}
//关键字
function deel_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
	if ( get_the_tags( $post->ID ) ) {
	  foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
	}
	foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
	$keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () )    { $keywords = dopt('d_keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
	echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}

//网站描述
function deel_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
	if( !empty( $post->post_excerpt ) ) {
	  $text = $post->post_excerpt;
	} else {
	  $text = $post->post_content;
	}
	$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
	if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = dopt('d_description'); // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { $description = trim(strip_tags(category_description()));
  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' );
  echo "<meta name=\"description\" content=\"$description\">\n";
}

function hide_admin_bar($flag) {
	return false;
}

//最新发布加new 单位'小时'
function deel_post_new($timer='48'){
  $t=( strtotime( date("Y-m-d H:i:s") )-strtotime( $post->post_date ) )/3600; 
  if( $t < $timer ) echo "<i>new</i>";
}

//修改评论表情调用路径
function deel_smilies_src ($img_src, $img, $siteurl){
	return get_bloginfo('template_directory').'/img/smilies/'.$img;
}

    //图片添加alt属性
    function image_alt( $imgalt ){
            global $post;
            $title = $post->post_title;
            $imgUrl = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>";
            if(preg_match_all("/$imgUrl/siU",$imgalt,$matches,PREG_SET_ORDER)){
                    if( !empty($matches) ){
                            for ($i=0; $i < count($matches); $i++){
                                    $tag = $url = $matches[$i][0];
                                    $judge = '/alt=/';
                                    preg_match($judge,$tag,$match,PREG_OFFSET_CAPTURE);
                                    if( count($match) < 1 )
                                    $altURL = ' alt="'.$title.'" ';
                                    $url = rtrim($url,'>');
                                    $url .= $altURL.'>';
                                    $imgalt = str_replace($tag,$url,$imgalt);
                            }
                    }
            }
            return $imgalt;
    }
    add_filter( 'the_content','image_alt');



//阻止站内文章Pingback 
function deel_noself_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}

//移除自动保存
function deel_disable_autosave() {
  wp_deregister_script('autosave');
}

//修改默认发信地址
function deel_res_from_email($email) {
	$wp_from_email = get_option('admin_email');
	return $wp_from_email;
}
function deel_res_from_name($email){
	$wp_from_name = get_option('blogname');
	return $wp_from_name;
}
//评论回应邮件通知
function comment_mail_notify($comment_id) {
    $admin_email = get_bloginfo ('admin_email'); 
    $comment = get_comment($comment_id);
    $comment_author_email = trim($comment->comment_author_email);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email)) {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了新回复';
    $message = '
    <div style="background-color:#fff; border:1px solid #666666; color:#111; -moz-border-radius:8px; -webkit-border-radius:8px; -khtml-border-radius:8px; border-radius:8px; font-size:12px; width:702px; margin:0 auto; margin-top:10px;">
    <div style="background:#666666; width:100%; height:60px; color:white; -moz-border-radius:6px 6px 0 0; -webkit-border-radius:6px 6px 0 0; -khtml-border-radius:6px 6px 0 0; border-radius:6px 6px 0 0; ">
    <span style="height:60px; line-height:60px; margin-left:30px; font-size:12px;"> 您在<a style="text-decoration:none; color:#ff0;font-weight:600;"> [' . get_option("blogname") . '] </a>上的留言有回复啦！</span></div>
    <div style="width:90%; margin:0 auto">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />
      <p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">'. trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给你的回复:<br />
      <p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">'. trim($comment->comment_content) . '</p>
      <p>你可以点击<a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看完整内容</a></p>
      <p>欢迎再度光临<a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件由系统自动发出, 请勿回复。)</p>
    </div></div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    }
  }
  add_action('comment_post', 'comment_mail_notify');
//自动勾选 
function deel_add_checkbox() {
}
//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 7 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day) return;
  echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}

function timeago( $ptime ) { 
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

//评论样式
function deel_comment_list($comment, $args, $depth) {
  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

  //头像
  echo '<div class="c-avatar">';
  echo str_replace(' src=', ' data-original=', get_avatar( $comment->comment_author_email, $size = '54' , deel_avatar_default())); 
  //内容
  echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';  
	echo str_replace(' src=', ' data-original=', convert_smilies(get_comment_text()));
	if($comment->user_id == '1') 
		echo '<img src="'.get_bloginfo('template_directory').'/img/master.png">';
	if (!_is_mobile() ): 
	echo get_author_class($comment->comment_author_email,$comment->user_id); 
	endif ;
	if ($comment->comment_approved == '0'){
	  echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
	}
//信息
	echo '<div class="c-meta">';
		echo '<span class="c-author">'.get_comment_author_link().'</span>';
	 echo get_comment_time('Y年-m月-d日发表'); echo time_ago(); 
		if ($comment->comment_approved !== '0'){ 
			echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
		echo edit_comment_link(__('(编辑)'),' - ','');
		 if (!_is_mobile() ): 
		echo get_useragent($comment->comment_agent);
	   endif ;
	  }
	echo '</div>';
  echo '</div>';
}
//获取访客VIP样式  
function get_author_class($comment_author_email,$user_id){  
global $wpdb;  
$author_count = count($wpdb->get_results(  
"SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));  
$adminEmail = get_option('admin_email');if($comment_author_email ==$adminEmail) return;  
if($author_count>=1 && $author_count<3)  
echo '<a class="vip1" title="评论达人 LV.1"></a>';  
else if($author_count>=3 && $author_count<5)   
echo '<a class="vip2" title="评论达人 LV.2"></a>';  
else if($author_count>=5 && $author_count<10)  
echo '<a class="vip3" title="评论达人 LV.3"></a>';   
else if($author_count>=10 && $author_count<20)   
echo '<a class="vip4" title="评论达人 LV.4"></a>';   
else if($author_count>=20 &&$author_count<50)   
echo '<a class="vip5" title="评论达人 LV.5"></a>';   
else if($author_count>=50 && $author_count<100)   
echo '<a class="vip6" title="评论达人 LV.6"></a>';   
else if($author_count>=100)   
echo '<a class="vip7" title="评论达人 LV.7"></a>';   
} 
//remove google fonts
if (!function_exists('remove_wp_open_sans')) :
    function remove_wp_open_sans() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
    }
     add_action('admin_enqueue_scripts', 'remove_wp_open_sans');
     add_action('login_init', 'remove_wp_open_sans');
endif;
//Dream@添加钮Download
function DownloadUrl($atts, $content = null) {
	extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-cloud-download"></i>'.$content.'</a>';
	}
add_shortcode("dl", "DownloadUrl");
//Gravatar缓存头像
function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="http://cn.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');
//Dream@添加钮git
function GithubUrl($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-github-alt"></i>'.$content.'</a>';
}
add_shortcode('gt' , 'GithubUrl' );
//Dream@添加钮Demo
function DemoUrl($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-external-link"></i>'.$content.'</a>';
}
add_shortcode('dm' , 'DemoUrl' );

//Dream@添加编辑器快捷按钮
add_action('admin_print_scripts', 'my_quicktags');
function my_quicktags() {
    wp_enqueue_script(
        'my_quicktags',
        get_stylesheet_directory_uri().'/js/my_quicktags.js',
        array('quicktags')
    );
    }; 

//评论过滤  
function refused_spam_comments( $comment_data ) {  
$pattern = '/[一-龥]/u';  
$jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';
if(!preg_match($pattern,$comment_data['comment_content'])) {  
err('写点汉字吧，博主外语很捉急！You should type some Chinese word!');  
} 
if(preg_match($jpattern, $comment_data['comment_content'])){
err('日文滚粗！Japanese Get out！日本語出て行け！ You should type some Chinese word！');  
}
return( $comment_data );  
}  
if( dopt('d_spamComments_b') ){
add_filter('preprocess_comment','refused_spam_comments');
	}   

//添加文章版权信息
function copyright($content) {
if(is_single()||is_feed()) {
$content.='<div class="open-message"  style="border:#00a67c 1px solid;border-radius:5px 5px 5px 5px;"><i class="fa fa-bullhorn"></i> 
本站文章如未注明，均为原创丨本网站采用<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" rel="nofollow" target="_blank" title="BY-NC-SA授权协议">BY-NC-SA</a>协议进行授权，转载请注明转自：<a href="'.get_permalink().'" title="'.get_the_title().'">'.get_permalink().'</a></div>';
}
return $content;
}
add_filter ('the_content', 'copyright');

//点赞
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $bigfa_raters = get_post_meta($id,'bigfa_ding',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_ding', 1);
    } 
    else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
   
    echo get_post_meta($id,'bigfa_ding',true);
    
    } 
    
    die;
}
//最热排行
function hot_posts_list($days=7, $nums=10) { 
    global $wpdb;
    $today = date("Y-m-d H:i:s");
    $daysago = date( "Y-m-d H:i:s", strtotime($today) - ($days * 24 * 60 * 60) );  
    $result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date FROM $wpdb->posts WHERE post_date BETWEEN '$daysago' AND '$today' ORDER BY comment_count DESC LIMIT 0 , $nums");
    $output = '';
    if(empty($result)) {
        $output = '<li>None data.</li>';
    } else {
        $i = 1;
        foreach ($result as $topten) {
            $postid = $topten->ID;
            $title = $topten->post_title;
            $commentcount = $topten->comment_count;
            if ($commentcount != 0) {
              $output .= '<li><p><span class="post-comments">评论 ('.$commentcount.')</span><span class="muted"><a href="javascript:;" data-action="ding" data-id="'.$postid.'" id="Addlike" class="action';
	if(isset($_COOKIE['bigfa_ding_'.$postid])) $output .=' actived';
	$output .='"><i class="fa fa-heart-o"></i><span class="count">';
	if( get_post_meta($postid,'bigfa_ding',true) ){ 
		$output .=get_post_meta($postid,'bigfa_ding',true);
 	} else {$output .='0';}
	$output .='</span>喜欢</a></span></p><span class="label label-'.$i.'">'.$i.'</span><a href="'.get_permalink($postid).'" title="'.$title.'">'.$title.'</a></li>';
                $i++;
			
            }
        }
    }
    echo $output;
}
//在 WordPress 编辑器添加“下一页”按钮
add_filter('mce_buttons','add_next_page_button');
function add_next_page_button($mce_buttons) {
	$pos = array_search('wp_more',$mce_buttons,true);
	if ($pos !== false) {
		$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
		$tmp_buttons[] = 'wp_page';
		$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
	}
	return $mce_buttons;
}

//判断手机广告
function _is_mobile() {
    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        return false;
    } elseif ( ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false  && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') === false) // many mobile devices (all iPh, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            return true;
    } else {
        return false;
    }
}

//Dream@搜索结果排除所有页面
function search_filter_page($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','search_filter_page');
// 更改后台字体
function Bing_admin_lettering(){
    echo'<style type="text/css">
        * { font-family: "Microsoft YaHei" !important; }
        i, .ab-icon, .mce-close, i.mce-i-aligncenter, i.mce-i-alignjustify, i.mce-i-alignleft, i.mce-i-alignright, i.mce-i-blockquote, i.mce-i-bold, i.mce-i-bullist, i.mce-i-charmap, i.mce-i-forecolor, i.mce-i-fullscreen, i.mce-i-help, i.mce-i-hr, i.mce-i-indent, i.mce-i-italic, i.mce-i-link, i.mce-i-ltr, i.mce-i-numlist, i.mce-i-outdent, i.mce-i-pastetext, i.mce-i-pasteword, i.mce-i-redo, i.mce-i-removeformat, i.mce-i-spellchecker, i.mce-i-strikethrough, i.mce-i-underline, i.mce-i-undo, i.mce-i-unlink, i.mce-i-wp-media-library, i.mce-i-wp_adv, i.mce-i-wp_fullscreen, i.mce-i-wp_help, i.mce-i-wp_more, i.mce-i-wp_page, .qt-fullscreen, .star-rating .star { font-family: dashicons !important; }
        .mce-ico { font-family: tinymce, Arial !important; }
        .fa { font-family: FontAwesome !important; }
        .genericon { font-family: "Genericons" !important; }
        .appearance_page_scte-theme-editor #wpbody *, .ace_editor * { font-family: Monaco, Menlo, "Ubuntu Mono", Consolas, source-code-pro, monospace !important; }
        </style>';
}
add_action('admin_head', 'Bing_admin_lettering');
//Dream@添加相关文章图片文章
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails');
 
//输出缩略图地址
function post_thumbnail_src(){
    global $post;
	if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
    } else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$post_thumbnail_src = $matches [1] [0];   //获取该图片 src
		if(empty($post_thumbnail_src)){	//如果日志中没有图片，则显示随机图片
			$random = mt_rand(1, 10);
			echo get_bloginfo('template_url');
			echo '/img/pic/'.$random.'.jpg';
			//如果日志中没有图片，则显示默认图片
			//echo '/img/thumbnail.png';
		}
	};
	echo $post_thumbnail_src;
}


//去除谷歌字体
function coolwp_remove_open_sans_from_wp_core() {
wp_deregister_style( 'open-sans' );   
wp_register_style( 'open-sans', false );   
wp_enqueue_style('open-sans','');}
add_action( 'init', 'coolwp_remove_open_sans_from_wp_core' );

function ODD_title($char) {
         $title = get_the_title($post->ID);
         $title = substr($title,0,$char);
         echo $title;
}

//输出WordPress表情
function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    foreach($wpsmilies as $alt => $src_path){
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img class="wp-smiley" src="'.get_bloginfo('template_directory').'/img/smilies/'.rtrim($src_path, "gif").'gif" /></a>';
    }
    return $output;
}

add_action('media_buttons_context', 'fa_smilies_custom_button');
function fa_smilies_custom_button($context) {
    $context .= '<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 375px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id="insert-media-button" style="position:relative" class="button insert-smilies add_smilies" title="添加表情" data-editor="content" href="javascript:;">添加表情</a><div class="smilies-wrap">'. fa_get_wpsmiliestrans() .'</div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".insert-smilies",function() { if(jQuery(".smilies-wrap").hasClass("is-active")){jQuery(".smilies-wrap").removeClass("is-active");}else{jQuery(".smilies-wrap").addClass("is-active");}});jQuery(document).on("click", ".add-smily",function() { send_to_editor(" " + jQuery(this).data("smilies") + " ");jQuery(".smilies-wrap").removeClass("is-active");return false;});});</script>';
    return $context;
}

//使用短代码添加回复后可见内容开始
function reply_to_read($atts, $content=null){
	extract(shortcode_atts(array("notice" => '<blockquote><p class="reply-to-read" style="color: blue;">注意：本段内容须成功“<a href="'. get_permalink().'#respond" title="回复本文">回复本文</a>”后“<a href="javascript:window.location.reload();" title="刷新本页">刷新本页</a>”方可查看！</p></blockquote>'), $atts));
	if(is_super_admin()){
		return $content;	//如果用户是管理员则直接显示内容
	}
	$email = null;
	$user_ID = (int)wp_get_current_user()->ID;
	if($user_ID > 0){
		$email = get_userdata($user_ID)->user_email;	//如果用户已经登入则从用户信息中取得邮箱
	}else if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])){
		$email = str_replace('%40', '@', $_COOKIE['comment_author_email_'.COOKIEHASH]);		//如果用户尚未登入但COOKIE内储存有邮箱信息
	}else{
		return $notice;		//如无法获取邮箱则返回提示信息
	}
	if(empty($email)){
		return $notice;		//如邮箱为空则返回提示信息
	}
	global $wpdb;
	$post_id = get_the_ID();	//获取文章的ID
	$query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
	if($wpdb->get_results($query)){
		return $content;		//查询到对应的评论即正常显示内容
	}else{
		return $notice;			//否则返回提示信息
	}
}
add_shortcode('reply', 'reply_to_read');

//编辑器添加框架按钮
function GenerateIframe( $atts ) {
    extract( shortcode_atts( array(
        'href' => '',
        'height' => '650px',
        'width' => '700px',
    ), $atts ) );

    return '<iframe src="'.$href.'" width="'.$width.'" height="'.$height.'"> <p>您的浏览器不支持框架</p></iframe>';
}
add_shortcode('iframe', 'GenerateIframe');
//后台图标LOGO链接
function custom_loginlogo_url($url) {
return '<?php site_url(); ?>';
}


//后台日志阅读统计
add_filter('manage_posts_columns', 'postviews_admin_add_column');
function postviews_admin_add_column($columns){
$columns['views'] = __('阅读');
return $columns;
}
add_action('manage_posts_custom_column','postviews_admin_show',10,2);
function postviews_admin_show($column_name,$id){
if ($column_name != 'views')
return;
$post_views = get_post_meta($id, "views",true);
echo $post_views;
}
/*短代码信息框 开始*/
/*绿色提醒框*/
function toz($atts, $content=null){
    return '<div id="sc_notice">'.$content.'</div>';
}
add_shortcode('v_notice','toz');
/*红色提醒框*/
function toa($atts, $content=null){
    return '<div id="sc_error">'.$content.'</div>';
}
add_shortcode('v_error','toa');
/*黄色提醒框*/
function toc($atts, $content=null){
    return '<div id="sc_warn">'.$content.'</div>';
}
add_shortcode('v_warn','toc');
/*灰色提醒框*/
function tob($atts, $content=null){
    return '<div id="sc_tips">'.$content.'</div>';
}
add_shortcode('v_tips','tob');
/*蓝色提醒框*/
function tod($atts, $content=null){
    return '<div id="sc_blue">'.$content.'</div>';
}
add_shortcode('v_blue','tod');
/*蓝边文本框*/
function toe($atts, $content=null){
    return '<div  class="sc_act">'.$content.'</div>';
}
add_shortcode('v_act','toe');
/*橙色文本框*/
function tof($atts, $content=null){
    return '<div id="sc_organge">'.$content.'</div>';
}
add_shortcode('v_organge','tof');
/*青色文本框*/
function tog($atts, $content=null){
    return '<div id="sc_qing">'.$content.'</div>';
}
add_shortcode('v_qing','tog');
/*粉色文本框*/
function toh($atts, $content=null){
    return '<div id="sc_pink">'.$content.'</div>';
}
add_shortcode('v_pink','toh');
/*绿色按钮*/
function toi($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="greenbtn" href="'.$href.'" target="_blank" rel="nofollow">'.$content.'</a>';
}
add_shortcode('gb' , 'toi' );
/*蓝色按钮*/
function toj($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="bluebtn" href="'.$href.'" target="_blank" rel="nofollow">'.$content.'</a>';
}
add_shortcode('bb' , 'toj' );
/*黄色按钮*/
function tok($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="yellowbtn" href="'.$href.'" target="_blank" rel="nofollow">'.$content.'</a>';
}
add_shortcode('yb' , 'tok' );
/*添加音乐按钮*/
function tol($atts, $content=null){
    return '<audio style="width:100%;max-height:40px;" src="'.$content.'" controls preload loop>您的浏览器不支持HTML5的 audio 标签，无法为您播放！</audio>';
}
add_shortcode('music','tol');
/* 短代码信息框 完毕*/
//为WordPress添加展开收缩功能
function xcollapse($atts, $content = null){
	extract(shortcode_atts(array("title"=>""),$atts));
	return '<div style="margin: 0.5em 0;">
		<div class="xControl">
			<span class="xTitle">'.$title.'</span>
			<a href="javascript:void(0)" class="collapseButton xButton">展开/收缩▼</a>
			<div style="clear: both;"></div>
		</div>
		<div class="xContent" style="display: none;">'.$content.'</div>
	</div>';
}
add_shortcode('collapse', 'xcollapse');


// add youku using iframe
function wp_iframe_handler_youku( $matches, $attr, $url, $rawattr ) {
    // If the user supplied a fixed width AND height, use it
    if ( !empty($rawattr['width']) && !empty($rawattr['height']) ) {
        $width  = (int) $rawattr['width'];
        $height = (int) $rawattr['height'];
    } else {
        list( $width, $height ) = wp_expand_dimensions( 480, 400, $attr['width'], $attr['height'] );
    }
    $iframe = '<iframe width='. esc_attr($width) .' height='. esc_attr($height) .' src="http://player.youku.com/embed/'. esc_attr($matches[1]) .'" frameborder=0 allowfullscreen></iframe>';
    return apply_filters( 'iframe_youku', $iframe, $matches, $attr, $url, $ramattr );
}
wp_embed_register_handler( 'youku_iframe', '#http://v.youku.com/v_show/id_(.*?).html#i', 'wp_iframe_handler_youku' );
// add tudou using iframe
function wp_iframe_handler_tudou( $matches, $attr, $url, $rawattr ) {
    // If the user supplied a fixed width AND height, use it
    if ( !empty($rawattr['width']) && !empty($rawattr['height']) ) {
        $width  = (int) $rawattr['width'];
        $height = (int) $rawattr['height'];
    } else {
        list( $width, $height ) = wp_expand_dimensions( 480, 400, $attr['width'], $attr['height'] );
    }
    $iframe = '<iframe width='. esc_attr($width) .' height='. esc_attr($height) .' src="http://www.tudou.com/programs/view/html5embed.action?code='. esc_attr($matches[1]) .'" frameborder=0 allowfullscreen></iframe>';
    return apply_filters( 'iframe_tudou', $iframe, $matches, $attr, $url, $ramattr );
}
wp_embed_register_handler( 'tudou_iframe', '#http://www.tudou.com/programs/view/(.*?)/#i', 'wp_iframe_handler_tudou' );
wp_embed_unregister_handler('youku');
wp_embed_unregister_handler('tudou');

//后台快捷键回复
add_action('admin_footer', 'hui_admin_comment_ctrlenter');
function hui_admin_comment_ctrlenter(){
    echo '<script type="text/javascript">
        jQuery(document).ready(function($){
            $("textarea").keypress(function(e){
                if(e.ctrlKey&&e.which==13||e.which==10){
                    $("#replybtn").click();
                }
            });
        });
    </script>';
};
//显示评论者浏览器和国家
function get_browsers($ua){
    $title = 'unknow';
    $icon = 'unknow';    
    if (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Internet Explorer '. $matches[1];
        if ( strpos($matches[1], '7') !== false || strpos($matches[1], '8') !== false)
            $icon = 'ie8';
        elseif ( strpos($matches[1], '9') !== false)
            $icon = 'ie9';
        elseif ( strpos($matches[1], '10') !== false)
            $icon = 'ie10';
        else
            $icon = 'ie';
    }elseif (preg_match('/rv:(11.0)/i', $ua, $matches)){
        $title = 'Internet Explorer '. $matches[1];
        $icon = 'ie11';
    }elseif (preg_match('#Firefox/([a-zA-Z0-9.]+)#i', $ua, $matches)){
        $title = 'Firefox '. $matches[1];
        $icon = 'firefox';
    }elseif (preg_match('#CriOS/([a-zA-Z0-9.]+)#i', $ua, $matches)){
        $title = 'Chrome for iOS '. $matches[1];
        $icon = 'crios';
    }elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Google Chrome '. $matches[1];
        $icon = 'chrome';
        if (preg_match('#OPR/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $title = 'Opera '. $matches[1];
            $icon = 'opera15';
            if (preg_match('#opera mini#i', $ua)) $title = 'Opera Mini'. $matches[1];
        }
    }elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Safari '. $matches[1];
        $icon = 'safari';
    }elseif (preg_match('#Opera.(.*)Version[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Opera '. $matches[2];
        $icon = 'opera';
        if (preg_match('#opera mini#i', $ua)) $title = 'Opera Mini'. $matches[2];        
    }elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i', $ua,$matches)) {
        $title = 'Maxthon '. $matches[2];
        $icon = 'maxthon';
    }elseif (preg_match('#360([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = '360 Browser '. $matches[1];
        $icon = '360se';
    }elseif (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'SouGou Browser 2'.$matches[1];
        $icon = 'sogou';
    }elseif (preg_match('#UCWEB([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'UCWEB '. $matches[1];
        $icon = 'ucweb';
    }elseif(preg_match('#wp-(iphone|android)/([a-zA-Z0-9.]+)#i', $ua, $matches)){ // 1.2 增加 wordpress 客户端的判断
        $title = 'wordpress '. $matches[2];
        $icon = 'wordpress';
    }
     
    return array(
        $title,
        $icon
    );
}
 
function get_os($ua){
    $title = 'unknow';
    $icon = 'unknow';
    if (preg_match('/win/i', $ua)
	|| preg_match('/WinNT/i', $ua)
	|| preg_match('/Win32/i', $ua)
	|| preg_match('/Windows/i', $ua))
 {
        if (preg_match('/Windows NT 6.1; Win64; x64/i', $ua)
	|| preg_match('/Windows NT 6.1; WOW64/i', $ua)) {
            $title = "Windows 7 x64";
            $icon = "windows_win7";
        }elseif (preg_match('/Windows NT 6.1/i', $ua)) {
            $title = "Windows 7";
            $icon = "windows_win7";
        }elseif (preg_match('/Windows NT 5.1/i', $ua)) {
            $title = "Windows XP";
            $icon = "windows";
        }elseif (preg_match('/Windows NT 6.2; Win64; x64/i', $ua)
	|| preg_match('/Windows NT 6.2; WOW64/i', $ua)) {
            $title = "Windows 8 x64";
            $icon = "windows_win8";
        }elseif (preg_match('/Windows NT 6.2/i', $ua)) {
            $title = "Windows 8";
            $icon = "windows_win8";
        }elseif (preg_match('/Windows NT 6.3; Win64; x64/i', $ua)
	|| preg_match('/Windows NT 6.3; WOW64/i', $ua)) {
            $title = "Windows 8.1 x64";
            $icon = "windows_win8";
        }elseif (preg_match('/Windows NT 6.3/i', $ua)) {
            $title = "Windows 8.1";
            $icon = "windows_win8";
        }elseif (preg_match('/Windows NT 6.4; Win64; x64/i', $ua)
	|| preg_match('/Windows NT 6.4; WOW64/i', $ua)) {
            $title = "Windows 10 x64";
            $icon = "windows_10";
        }elseif (preg_match('/Windows NT 6.4/i', $ua)) {
            $title = "Windows 10";
            $icon = "windows_10";
        }elseif (preg_match('/Windows NT 6.0/i', $ua)) {
            $title = "Windows Vista";
            $icon = "windows_vista";
        }elseif (preg_match('/Windows NT 5.2/i', $ua)) {
            if (preg_match('/Win64/i', $ua)) {
                $title = "Windows XP 64 bit";
            } else {
                $title = "Windows Server 2003";
            }
            $icon = 'windows';
        }elseif (preg_match('/Windows Phone/i', $ua)) {
            $matches = explode(';',$ua);
            $title = $matches[2];
            $icon = "windows_phone";
        }
    }elseif (preg_match('#iPod.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
        $title = "iPod ".$matches[1];
        $icon = "iphone";
    } elseif (preg_match('#iPhone OS ([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {// 1.2 修改成 iphone os 来判断 
        $title = "Iphone ".$matches[1];
        $icon = "iphone";
    } elseif (preg_match('#iPad.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
        $title = "iPad ".$matches[1];
        $icon = "ipad";
    } elseif (preg_match('/Mac OS X.([0-9. _]+)/i', $ua, $matches)) {
        if(count(explode(7,$matches[1]))>1) $matches[1] = 'Lion '.$matches[1];
        elseif(count(explode(8,$matches[1]))>1) $matches[1] = 'Mountain Lion '.$matches[1];
        $title = "Mac OSX ".$matches[1];
        $icon = "macos";
    } elseif (preg_match('/Macintosh/i', $ua)) {
        $title = "Mac OS";
        $icon = "macos";
    } elseif (preg_match('/CrOS/i', $ua)){
        $title = "Google Chrome OS";
        $icon = "chrome";
    }elseif (preg_match('/Linux/i', $ua)) {
        $title = 'Linux';
        $icon = 'linux';
        if (preg_match('/Android.([0-9. _]+)/i',$ua, $matches)) {
            $title= $matches[0];
            $icon = "android";
        }elseif (preg_match('#Ubuntu#i', $ua)) {
            $title = "Ubuntu Linux";
            $icon = "ubuntu";
        }elseif(preg_match('#Debian#i', $ua)) {
            $title = "Debian GNU/Linux";
            $icon = "debian";
        }elseif (preg_match('#Fedora#i', $ua)) {
            $title = "Fedora Linux";
            $icon = "fedora";
        }
    }
    return array(
        $title,
        $icon
    );
}

function get_useragent($ua){
    $url = get_bloginfo('template_directory') . '/images/browsers/';
    $browser = get_browsers($ua);
    $os = get_os($ua);
    echo '<span class="useragent tra">|<span class="fa fa-globe"></span> '.$browser[0].'|<span class="fa fa-desktop"></span> '.$os[0];
}
function keep_id_continuous(){
  global $wpdb;

  // 删掉自动草稿和修订版
  $wpdb->query("DELETE FROM `$wpdb->posts` WHERE `post_status` = 'auto-draft' OR `post_type` = 'revision'");

  // 自增值小于现有最大ID，MySQL会自动设置正确的自增值
  $wpdb->query("ALTER TABLE `$wpdb->posts` AUTO_INCREMENT = 1");  
}

add_filter( 'load-post-new.php', 'keep_id_continuous' );
add_filter( 'load-media-new.php', 'keep_id_continuous' );
add_filter( 'load-nav-menus.php', 'keep_id_continuous' );
function baidu_check($url){
    global $wpdb;
    $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
    $baidu_record = get_post_meta($post_id,'baidu_record',true);
    if( $baidu_record != 1){
    $url='http://www.baidu.com/s?wd='.$url;
    $curl=curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $rs=curl_exec($curl);
    curl_close($curl);
    if(!strpos($rs,'没有找到')){
    if( $baidu_record == 0){
    update_post_meta($post_id, 'baidu_record', 1);
    } else {
    add_post_meta($post_id, 'baidu_record', 1, true);
    }
    return 1;
    } else {
    if( $baidu_record == false){
    add_post_meta($post_id, 'baidu_record', 0, true);
    }
    return 0;
    }
    } else {
    return 1;
    }
    }
    function baidu_record() {
    if(baidu_check(get_permalink()) == 1) {
    echo '<a target="_blank" title="点击查看" rel="external nofollow" href="http://www.baidu.com/s?wd='.get_the_title().'">已收录</a>';
    } else {
    echo '<a style="color:blue;" rel="external nofollow" title="点击提交，谢谢您！" target="_blank" href="http://zhanzhang.baidu.com/sitesubmit/index?sitename='.get_permalink().'">未收录</a>';
    }
    }
	
function get_post_thumbnail_url($thumbnail = 'thumbnail', $post_id = ''){
global $post;
$post_id = (null === $post_id) ? get_the_ID() : $post_id;
$thumbnail_id = get_post_thumbnail_id($post -> ID);
$thumb_src = '';
if($thumbnail_id){
$thumb = wp_get_attachment_image_src($thumbnail_id, $thumbnail);
$thumb_src = $thumb[0];
if ($thumbnail != 'full' && empty($thumb_src)){
$thumb = wp_get_attachment_image_src($thumbnail_id, 'full');
$thumb_src = $thumb[0];
}
}
if (empty($thumb_src)){
$thumb_src = preg_match_all('/<img.*?src=[\'"](.*?)[\'"]/is', $post -> post_content, $matches) ? $matches[1][0]:'';
}
if (!empty($thumb_src)){
return $thumb_src;
}else{
$random = mt_rand(1, 10);
return get_bloginfo('template_url') . '/img/pic/' . $random . '.jpg';
}
}	
function show_category(){
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request .= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    foreach ($categorys as $category) { //调用菜单
        $output = '<span>'.$category->name."(<em>".$category->term_id.'</em>)</span>';
        echo $output;
    }
}
//禁止加载默认jq库
if ( !is_admin() ) { // 后台不禁止
function my_init_method() {
wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
}
add_action('init', 'my_init_method');
}
wp_deregister_script( 'l10n' );
function custom_headerurl( $url ) {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_headerurl' );

function custom_login_head(){
echo'<style type="text/css">body{background: url(//3.zhucetbid.sinaapp.com);width:100%;height:100%;background-image:url(//3.zhucetbid.sinaapp.com);-moz-background-size: 100% 100%;-o-background-size: 100% 100%;-webkit-background-size: 100% 100%;background-size: 100% 100%;-moz-border-image: url(//3.zhucetbid.sinaapp.com) 0;background-repeat:no-repeat\9;background-image:none\9;}</style>';
}
add_action('login_head', 'custom_login_head');
function custom_headertitle ( $title ) {
return __( '欢迎来到'.get_bloginfo( 'name' ).'' );
}
add_filter('login_headertitle','custom_headertitle');

//fancybox图片灯箱效果
add_filter('the_content', 'fancybox');
function fancybox ($content)
{ global $post;
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png|swf)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 rel="box" class="fancybox"$6>$7</a>';
$content = preg_replace($pattern, $replacement, $content);
return $content;
}
//添加碎语功能
function git_shuoshuo() {
    $labels = array(
        'name' => '说说',
        'singular_name' => '说说',
        'add_new' => '发表说说',
        'add_new_item' => '发表说说',
        'edit_item' => '编辑说说',
        'new_item' => '新说说',
        'view_item' => '查看说说',
        'search_items' => '搜索说说',
        'not_found' => '暂无说说',
        'not_found_in_trash' => '没有已遗弃的说说',
        'parent_item_colon' => '',
        'menu_name' => '说说'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 4 ,
        'supports' => array(
            'title',
            'editor',
            'author'
        )
    );
    register_post_type('shuoshuo', $args);
}
add_action('init', 'git_shuoshuo');
//
function git_shuoshuo_link($link, $post = 0) {
    if ($post->post_type == 'shuoshuo') {
        return home_url('shuoshuo-' . $post->ID . '.html');
    } else {
        return $link;
    }
}
add_action('init', 'custom_book_rewrites_init');
function custom_book_rewrites_init() {
    add_rewrite_rule('shuoshuo-([0-9]+)?.html$', 'index.php?post_type=shuoshuo&p=$matches[1]', 'top');
}
add_filter('post_type_link', 'git_shuoshuo_link', 1, 3);


  //修复4.2表情bug
function disable_emoji9s_tinymce($plugins) {
 if (is_array($plugins)) {
 return array_diff($plugins, array(
 'wpemoji'
 ));
 } else {
 return array();
 }
}
//取当前主题下img\smilies\下表情图片路径
function custom_gitsmilie_src($old, $img) {
 return get_stylesheet_directory_uri() . '/img/smilies/' . $img;
}
function init_gitsmilie() {
 global $wpsmiliestrans;
 //默认表情文本与表情图片的对应关系(可自定义修改)
 $wpsmiliestrans = array(
 ':mrgreen:' => 'icon_mrgreen.gif',
 ':neutral:' => 'icon_neutral.gif',
 ':twisted:' => 'icon_twisted.gif',
 ':arrow:' => 'icon_arrow.gif',
 ':shock:' => 'icon_eek.gif',
 ':smile:' => 'icon_smile.gif',
 ':???:' => 'icon_confused.gif',
 ':cool:' => 'icon_cool.gif',
 ':evil:' => 'icon_evil.gif',
 ':grin:' => 'icon_biggrin.gif',
 ':idea:' => 'icon_idea.gif',
 ':oops:' => 'icon_redface.gif',
 ':razz:' => 'icon_razz.gif',
 ':roll:' => 'icon_rolleyes.gif',
 ':wink:' => 'icon_wink.gif',
 ':cry:' => 'icon_cry.gif',
 ':eek:' => 'icon_surprised.gif',
 ':lol:' => 'icon_lol.gif',
 ':mad:' => 'icon_mad.gif',
 ':sad:' => 'icon_sad.gif',
 '8-)' => 'icon_cool.gif',
 '8-O' => 'icon_eek.gif',
 ':-(' => 'icon_sad.gif',
 ':-)' => 'icon_smile.gif',
 ':-?' => 'icon_confused.gif',
 ':-D' => 'icon_biggrin.gif',
 ':-P' => 'icon_razz.gif',
 ':-o' => 'icon_surprised.gif',
 ':-x' => 'icon_mad.gif',
 ':-|' => 'icon_neutral.gif',
 ';-)' => 'icon_wink.gif',
 '8O' => 'icon_eek.gif',
 ':(' => 'icon_sad.gif',
 ':)' => 'icon_smile.gif',
 ':?' => 'icon_confused.gif',
 ':D' => 'icon_biggrin.gif',
 ':P' => 'icon_razz.gif',
 ':o' => 'icon_surprised.gif',
 ':x' => 'icon_mad.gif',
 ':|' => 'icon_neutral.gif',
 ';)' => 'icon_wink.gif',
 ':!:' => 'icon_exclaim.gif',
 ':?:' => 'icon_question.gif',
 );
 //移除WordPress4.2版本更新所带来的Emoji钩子同时挂上主题自带的表情路径
 remove_action('wp_head', 'print_emoji_detection_script', 7);
 remove_action('admin_print_scripts', 'print_emoji_detection_script');
 remove_action('wp_print_styles', 'print_emoji_styles');
 remove_action('admin_print_styles', 'print_emoji_styles');
 remove_filter('the_content_feed', 'wp_staticize_emoji');
 remove_filter('comment_text_rss', 'wp_staticize_emoji');
 remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
 add_filter('tiny_mce_plugins', 'disable_emoji9s_tinymce');
 add_filter('smilies_src', 'custom_gitsmilie_src', 10, 2);
}

function Bing_random_admin_color(){
static $color;
if( isset( $color ) ) return $color;
$color = array_keys( $GLOBALS['_wp_admin_css_colors'] );
$color = $color[array_rand( $color )];
return $color;
}
add_filter( 'get_user_option_admin_color', 'Bing_random_admin_color' );

function random_postlite() {
 global $wpdb;
 $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
 if ( isset( $_GET['random_cat_id'] ) ) {
 $random_cat_id = (int) $_GET['random_cat_id'];
 $query = "SELECT DISTINCT ID FROM $wpdb->posts AS p INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id AND tr.term_taxonomy_id = $random_cat_id) INNER JOIN $wpdb->term_taxonomy AS tt ON(tr.term_taxonomy_id = tt.term_taxonomy_id AND taxonomy = 'category') WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
 }
 if ( isset( $_GET['random_post_type'] ) ) {
 $post_type = preg_replace( '|[^a-z]|i', '', $_GET['random_post_type'] );
 $query = "SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
 }
 $random_id = $wpdb->get_var( $query );
 wp_redirect( get_permalink( $random_id ) );
 exit;
}
if ( isset( $_GET['random'] ) )
add_action( 'template_redirect', 'random_postlite' );

//登录界面
function diy_login_page() {
  echo '<link rel="stylesheet" href="' . get_bloginfo( 'template_directory' ) . '/login.css" type="text/css" media="all" />' . "\n";
}
add_action( 'login_enqueue_scripts', 'diy_login_page' );

?>