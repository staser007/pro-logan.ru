<?php get_header(); ?>
	<div id="content">
<?php get_sidebar(); ?>
	<div class="post-container"> 
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<?php include (TEMPLATEPATH . '/navoptions.php'); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="posttop">
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Постоянная ссылка: <?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h2>
           <div class="postinfo">
			
            <div class="postinfodate">
			<?php the_time('d-m-Y') ?>
              
            </div>
              
			  </div>
         
        </div>
			<div class="entry">
				<?php the_content('<p class="serif">Читать полностью &raquo;</p>'); ?>	
				<?php link_pages('<p><strong>Страницы:</strong> ', '</p>', 'number'); ?>					
				<br />
			<?php comments_template(); ?>
			</div>
			<div class="postbottom">
            <div class="metainf">Рубрика:
              <?php the_category(', ') ?>
            </div>
           
          </div>
		</div>
		
	
	
	<?php endwhile; else: ?>
	<p>К сожалению, по вашему запросу ничего не найдено.</p>
	<?php endif; ?>
	</div>
		
		<? include 'side-ads.htm' ?>
	</div>


<?php get_footer(); ?>