<?php get_header(); ?>

	<div id="content">
<?php get_sidebar(); ?>
	<div class="post-container">
	<?php if (have_posts()) : ?>
	<h2 class="pagetitle">Результаты поиска</h2>
	

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
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
		<?php the_excerpt() ?>
		</div>
		<div class="postbottom">
            <div class="metainf">Рубрика:
              <?php the_category(', ') ?>
            </div>
            <div class="commentinf">
              <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?>
            </div>
          </div>
		</div>
		<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/navoptions.php'); ?>
	
	<?php else : ?>
	<div class="post">
		<div class="posttop">
		<h2>Не найдено</h2>
		</div>
		<div class="entry">
	
	<p class="center">К сожалению, по вашему запросу ничего не найдено.</p>
	<br /><br />
	</div>
	<div class="postbottom">
           
	</div>
	</div>
	
	<?php endif; ?>
	</div>
	<? include 'side-ads.htm' ?>
		
	</div>
	
<?php get_footer(); ?>