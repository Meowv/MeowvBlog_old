<?php
defined('ABSPATH') or die('This file can not be loaded directly.');

global $comment_ids; $comment_ids = array();
foreach ( $comments as $comment ) {
	if (get_comment_type() == "comment") {
		$comment_ids[get_comment_id()] = ++$comment_i;
	}
} 

if ( !comments_open() ) return;

$my_email = get_bloginfo ( 'admin_email' );
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
$count_t = $post->comment_count;

date_default_timezone_set(PRC);
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>
<div id="respond" class="no_webshot">
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) { ?>
	<h3 class="queryinfo">
		<?php printf('您必须 <a href="%s">登录</a> 才能发表评论！', wp_login_url( get_permalink() ) );?>
	</h3>
	<?php }elseif( get_option('close_comments_for_old_posts') && $closeTimer > get_option('close_comments_days_old') ) { ?>
	<h3 class="queryinfo">
		文章评论已关闭！
	</h3>
	<?php }else{ ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		
		<div class="comt-title">
			<div class="comt-avatar pull-left">
				<?php 
					global $current_user;
					get_currentuserinfo();
					if ( is_user_logged_in() ) 
						echo get_avatar( $current_user->user_email, $size = '54' , deel_avatar_default() );
					elseif( !is_user_logged_in() && get_option('require_name_email') && $comment_author_email=='' ) 
						echo get_avatar( $current_user->user_email, $size = '54' , deel_avatar_default() );
					elseif( !is_user_logged_in() && get_option('require_name_email') && $comment_author_email!=='' )  
						echo get_avatar( $comment->comment_author_email, $size = '54' , deel_avatar_default() );
					else
						echo get_avatar( $comment->comment_author_email, $size = '54' , deel_avatar_default() );
				?>
			</div>
			<div class="comt-author pull-left">
			<?php 
				if ( is_user_logged_in() ) {
					printf($user_identity.'<span>发表我的评论</span>');
				}else{
					if( get_option('require_name_email') && !empty($comment_author_email) ){
						printf($comment_author.' <span>发表我的评论</span> &nbsp; <a class="switch-author" href="javascript:;" data-type="switch-author" style="font-size:12px;">换个身份</a>');
					}else{
						printf('发表我的评论');
					}
				}
			?>
			</div>
			<a id="cancel-comment-reply-link" class="pull-right" href="javascript:;">取消评论</a>
		</div>
		
		<div class="comt">
			<div class="comt-box">
				<textarea placeholder="评论一下又不会怀孕..." class="input-block-level comt-area" name="comment" id="comment" cols="100%" rows="3" tabindex="1" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
				<div class="comt-ctrl">
					<button class="btn btn-primary pull-right" type="submit" name="submit" id="submit" tabindex="5"><i class="fa fa-check-square-o"></i> 提交评论（Ctrl+Enter）</button>
					<div class="comt-tips pull-right"><?php comment_id_fields(); do_action('comment_form', $post->ID); ?></div>
					<span  style="color:#999999" data-type="comment-insert-smilie" class="muted comt-smilie" data-no-instant><i class="fa fa-smile-o"></i> 表情</span>
					<?php if (!_is_mobile() ): ?>
					<span class="muted ml5 comt-code"><i class="fa fa-code"></i><a href="javascript:SIMPALED.Editor.code()" style="color:#999999"> 代码</a></span>
					<span class="muted ml5 comt-img"><i class="fa fa-picture-o"></i><a href="javascript:SIMPALED.Editor.img()" style="color:#999999"> 贴图</a></span>
					<span class="muted ml5 comt-strong"><i class="fa fa-bold"></i><a href="javascript:SIMPALED.Editor.strong()" style="color:#999999"> 加粗</a></span>
					<span class="muted ml5 comt-ahref"><i class="fa fa-globe"></i><a href="javascript:SIMPALED.Editor.ahref()" style="color:#999999"> 链接</a></span>
					<span class="muted ml5 comt-private"><i class="fa fa-volume-up"></i><a href="javascript:SIMPALED.Editor.private()" style="color:#999999"> 私信</a></span>
					<span class="muted ml5 comt-del"><i class="icon-remove icon12"></i><a href="javascript:SIMPALED.Editor.del()" style="color:#999999"> 删除线</a></span>
					<span class="muted ml5 comt-sign"><i class="fa fa-gift"></i><a href="javascript:SIMPALED.Editor.daka()" style="color:#999999"> 签到</a></span>
					<?php endif ;?>
					<span class="muted comt-mailme"><?php deel_add_checkbox() ?></span>
				</div>
			</div>

			<?php if ( !is_user_logged_in() ) { ?>
				<?php if( get_option('require_name_email') ){ ?>
					<div class="comt-comterinfo" id="comment-author-info" <?php if ( !empty($comment_author) ) echo 'style="display:none"'; ?>>
						<h4>Hi，请填写昵称和邮箱！</h4>
						<ul>
							<li class="form-inline"><label class="hide" for="author">昵称</label><input class="ipt" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="2" placeholder="昵称"><span class="help-inline">昵称 (必填)</span></li>
							<li class="form-inline"><label class="hide" for="email">邮箱</label><input class="ipt" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="3" placeholder="邮箱"><span class="help-inline">邮箱 (必填)</span></li>
							<li class="form-inline"><label class="hide" for="url">网址</label><input class="ipt" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="4" placeholder="网址"><span class="help-inline">网址</span></li>
						</ul>
					</div>
				<?php } ?>
			<?php } ?>
		</div>

		
	</form>
	<?php } ?>
</div>
<?php  

if ( have_comments() ) { 
?>
<div id="postcomments">
	<div id="comments">
		<i class="fa fa-comments-o"></i> <b><?php echo ' ('.$count_t.')'; ?></b>条精彩评论。
	</div>
	<ol class="commentlist" data-no-instant>
		<?php wp_list_comments('type=comment&callback=deel_comment_list') ?>
	</ol>
	<div class="commentnav"	>
		<?php paginate_comments_links('prev_text=«&next_text=»');?>
	</div>
</div>
<?php 
} 
?>