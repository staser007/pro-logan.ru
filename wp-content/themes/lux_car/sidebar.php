
	<div id="sidebar">
	<ul>
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>

	<li><h2>Архивы</h2>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
	<li><h2>Рубрики</h2>
		<ul>
		<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
		</ul>
	</li>
	
	<?php /* If this is a page */ if ( is_home() || is_page() ) { ?>				
		<?php get_links_list(); ?>
		<li><h2>Прочее</h2>
			<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			
			<?php wp_meta(); ?>
			</ul>
		</li>
	<?php } ?>

	<?php endif; ?>	
	</ul>
	</div>