<div id="wowslider-container1">
<div class="yx-rotaion" >
<ul class="rotaion_list">
<?php
$i=0;
$d_sticky_count=dopt('d_sticky_count')?dopt('d_sticky_count'):4;
$sticky = get_option('sticky_posts'); rsort( $sticky );
query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1, 'showposts' => 20 ) );
while (have_posts()) : the_post();
$str_src=get_post_thumbnail_url('full');
if (!empty($str_src)&&!strstr($str_src,'/img/pic/')) {
 
echo '<li><a target="_blank" href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.get_bloginfo("template_url").'/timthumb.php?src='.$str_src.'&h=360&w=856&q=90&zc=1&ct=1" title="'.get_the_title().'" alt="'.get_the_title().'" /></a></li>';
$i++;
if ($i>=$d_sticky_count) break;
}
endwhile;
wp_reset_query();
?>
</ul>
</div>
</div> <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.yx_rotaion.js"></script> <script type="text/javascript"> $(".yx-rotaion").yx_rotaion({auto:true}); </script>