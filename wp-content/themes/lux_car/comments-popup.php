<?php 
/* Don't remove these lines. */
add_filter('comment_text', 'popuplinks');
foreach ($posts as $post) { start_wp();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
     <title><?php echo get_settings('blogname'); ?> - Отзывы на <?php the_title(); ?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_settings('blog_charset'); ?>" />
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
		body { margin: 3px; }
	</style>

</head>
<body id="commentspopup">

<h1 id="header"><a href="" title="<?php echo get_settings('blogname'); ?>"><?php echo get_settings('blogname'); ?></a></h1>

<h2 id="comments">Отзывы</h2>

<p><a href="<?php echo get_settings('siteurl'); ?>/wp-commentsrss2.php?p=<?php echo $post->ID; ?>">RSS-лента комментариев.</a></p>

<?php if ('open' == $post->ping_status) { ?>
<p>Адрес для трекбека: <em><?php trackback_url() ?></em></p>
<?php } ?>

<?php
// this line is WordPress' motor, do not delete it.
$comment_author = (isset($_COOKIE['comment_author_' . COOKIEHASH])) ? trim($_COOKIE['comment_author_'. COOKIEHASH]) : '';
$comment_author_email = (isset($_COOKIE['comment_author_email_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_email_'. COOKIEHASH]) : '';
$comment_author_url = (isset($_COOKIE['comment_author_url_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_url_'. COOKIEHASH]) : '';
$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $id AND comment_approved = '1' ORDER BY comment_date");
$commentstatus = $wpdb->get_row("SELECT comment_status, post_password FROM $wpdb->posts WHERE ID = $id");
if (!empty($commentstatus->post_password) && $_COOKIE['wp-postpass_'. COOKIEHASH] != $commentstatus->post_password) {  // and it doesn't match the cookie
	echo(get_the_password_form());
} else { ?>

<?php if ($comments) { ?>
<ol id="commentlist">
<?php foreach ($comments as $comment) { ?>
	<li id="comment-<?php comment_ID() ?>">
	<?php comment_text() ?>
	<p><cite><?php comment_type('Отзыв', 'Трекбек', 'Пинг'); ?> от <?php comment_author_link() ?> &#8212; <?php comment_date() ?> в <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite></p>
	</li>

<?php } // end for each comment ?>
</ol>
<?php } else { // this is displayed if there are no comments so far ?>
	<p>Комментариев пока нет.</p>
<?php } ?>

<?php if ('open' == $commentstatus->comment_status) { ?>
<h2>Ваш отзыв</h2>
<p>Деление на параграфы происходит автоматически, адрес электронной почты никогда не будет опубликован, допустимый HTML: <code><?php echo allowed_tags(); ?></code></p>

<form action="<?php echo get_settings('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<p>
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
	   <label for="author">Имя</label>
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo wp_specialchars($_SERVER["REQUEST_URI"]); ?>" />
	</p>

	<p>
	  <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" />
	   <label for="email">Почта</label>
	</p>

	<p>
	  <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" />
	   <label for="url">Сайт</label>
	</p>

	<p>
	  <label for="comment">Ваш отзыв</label>
	<br />
	  <textarea name="comment" id="comment" cols="70" rows="4" tabindex="4"></textarea>
	</p>

	<p>
	  <input name="submit" type="submit" tabindex="5" value="Say It!" />
	</p>
	<?php do_action('comment_form', $post->ID); ?>
</form>
<?php } else { // comments are closed ?>
<p>Комментарии закрыты.</p>
<?php }
} // end password check
?>

<div><strong><a href="javascript:window.close()">Закрыть это окно.</a></strong></div>

<?php 
}
?>

<!-- // this is just the end of the motor - don't touch that line either :) -->
<?php //} ?> 
<p class="credit"><?php timer_stop(1); ?> <cite>Работает на <a href="http://wordpress.org" title="Powered by WordPress, state-of-the-art semantic personal publishing platform"><strong>Wordpress</strong></a></cite></p>
<?php  ?>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {	
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>
</body>
</html>
