<?php get_header(); ?>
<div  id="content">
<?php get_sidebar(); ?>
	<div class="post-container">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<div class="posttop">

			<div>

			<h2><?php the_title(); ?></h2>
			</div>
			</div>

			<div class="entry">
			<?php the_content('<p class="serif">Читать полностью &raquo;</p>'); ?>
			<?php link_pages('<p><strong>Страницы:</strong> ', '</p>', 'number'); ?>
			</div>
			<div class="postbottom">

	</div>
		</div>

		<?php endwhile; endif; ?>
		<?php edit_post_link('Править', '<p>', '</p>'); ?>
	</div>

<? include 'side-ads.htm' ?>
	</div>


<?php get_footer(); ?>