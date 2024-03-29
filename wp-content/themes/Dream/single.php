<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
<?php if( dopt('d_singleMenu_b') ) echo '<div class="breadcrumbs">'.deel_breadcrumbs().'</div>'; ?>

		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><?php the_title(); ?></a></h1>
			<div class="meta">
			<?php if (!_is_mobile() ): ?>
				<?php  
					$category = get_the_category();
			        if($category[0]){
			            echo '<span id="mute-category" class="muted"><i class="fa fa-list-alt"></i><a href="'.get_category_link($category[0]->term_id ).'"> '.$category[0]->cat_name.'</a></span>';
			        }
				?>
				<?php endif ;?>
				<?php if (!_is_mobile() ): ?><span class="muted"><i class="fa fa-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?><?php endif ;?></a></span>
				<time class="muted"><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) )?></time>
				<span class="muted"><i class="fa fa-eye"></i> <?php deel_views('℃'); ?></span>
				<?php if (!_is_mobile() ): ?><span class="muted"><i class="fa fa-flag"></i> <?php baidu_record(); ?></span><?php endif ;?>
				<?php if ( comments_open() ) echo '<span class="muted"><i class="fa fa-comments-o"></i> <a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a></span>'; ?>
				<?php edit_post_link('[编辑]'); ?>
			</div>
		</header>
<?php if( dopt('d_adpost_01_b') ) echo '<div class="banner banner-post">'.dopt('d_adpost_01').'</div>'; ?>
<?php if (wp_is_mobile() ): ?><?php if( dopt('Mobiled_adpost_01_b') ) echo '<div class="banner-post">'.dopt('Mobiled_adpost_01').'</div>'; ?><?php endif ;?>
		<article class="article-content">
			<?php the_content(); ?>


<?php wp_link_pages(array('before' => '<div class="fenye">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span>上一页</span>', 'nextpagelink' => "")); ?>   <?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>   <?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => "<span>下一页</span>")); ?>

<div class="article-social">
			<a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" id="Addlike" class="action<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' actived';?>"><i class="fa fa-heart-o"></i>喜欢 (<span class="count"><?php if( get_post_meta($post->ID,'bigfa_ding',true) ){ echo get_post_meta($post->ID,'bigfa_ding',true); } else {echo '0';}?></span>)</a><?php if( dopt('d_bdshare_b') ) echo'<span class="or">or</span>';  deel_share(); ?>	
</div>
	</article>	
		<?php endwhile;  ?>
		<footer class="article-footer">
			<?php the_tags('<div class="article-tags"><i class="fa fa-tags"></i>','','</div>'); ?>
</footer>
	<nav class="article-nav">
			<span class="article-nav-prev"><?php previous_post_link('<i class="fa fa-angle-double-left"></i> %link'); ?></span>
			<span class="article-nav-next"><?php next_post_link('%link  <i class="fa fa-angle-double-right"></i>'); ?></span>
		</nav>

		<div class="related_top">
			<?php include( 'modules/related.php' ); ?>
		</div>
		<?php if (wp_is_mobile() ): ?><?php if( dopt('Mobiled_adpost_02_b') )echo '<div id="comment-ad" class="banner-related">'.dopt('Mobiled_adpost_02').'</div>'; ?><?php endif ;?>
		<?php if( dopt('d_adpost_02_b') ) echo '<div id="comment-ad" class="banner banner-related">'.dopt('d_adpost_02').'</div>'; ?>
		<?php comments_template('', true); ?>
		<?php if( dopt('d_adpost_03_b') ) echo '<div class="banner banner-comment">'.dopt('d_adpost_03').'</div>'; ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>