		<?php if (!_is_mobile() ): ?>
		<?php if( dopt('d_adindex_02_b') ) printf('<div class="banner banner-sticky">'.dopt('d_adindex_02').'</div>'); ?>
<?php if(is_home()&& dopt('hot_list_check') ){ ?>
		<div><div class="left-ad" style="clear: both;background-color: #fff; width: 30%;float: left;margin-right:2%;"></div><div class="hot-posts">
			<h2 class="title"><?php echo dopt('hot_list_title') ?></h2>
			<ul><?php hot_posts_list($days=dopt('hot_list_date'), $nums=dopt('hot_list_number')); ?></ul>
		</div></div>
		<?php } ?>
		<?php endif ;?>

<!-- 最新文章开始 -->
<div class="relates"><h2><small>&nbsp;&nbsp;最新文章</small></h2>
<ul style="padding: 5px 0px 15px 20px;">
<?php
 $recent_posts = wp_get_recent_posts();
 foreach( $recent_posts as $recent ){
 echo '<li><i class="fa fa-minus"></i><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' . $recent["post_title"].'</a> ' . $recent["post_date"].'</li></a> ';
 }
?>
</ul>
</div>
<!-- 最新文章结束 -->
        <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_1') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_1') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_1') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>
        <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_2') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_2') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
			<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_2') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>
        <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_3') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_3') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_3') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>
        <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_4') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_4') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_4') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>
        <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_5') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_5') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_5') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>
        <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_6') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_6') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_6') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>
		 <div class="widget-title">
			<h2 class="title-cms"><small>&nbsp;&nbsp;&nbsp;<i class="fa fa-star-o"></i>&nbsp;&nbsp;<?php echo get_cat_name(dopt('d_cat_7') );?></small><span class="more" style="float:right;"><a style="left: 0px;" href="<?php echo get_category_link(dopt('d_cat_7') );?>" title="阅读更多" target="_blank"><small>阅读更多&nbsp;&nbsp;&nbsp;</small></a></span></h2>
<div class="related_posts">
			<?php query_posts( array( 'showposts' => 4, 'cat' => dopt('d_cat_7') ) ); ?>
            <?php while (have_posts()) : the_post(); ?>
				<ul class="related_img" style="display:inline" ><li class="related_box" ><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php if( dopt('d_qiniucdn_b') ){ echo '<img src="';echo post_thumbnail_src();echo '?imageView2/1/w/200/h/130/q/85" alt="'.get_the_title().'" />'; }else{ echo '<img src="'.get_bloginfo("template_url").'/timthumb.php?src=';echo post_thumbnail_src();echo '&h=130&w=200&q=90&zc=1&ct=1" alt="'.get_the_title().'" />';}?><br><span class="r_title"><?php the_title();?></span></a></li></ul>
            <?php endwhile; ?>
		</div></div>