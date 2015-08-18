<?php 
$max_num_pages = $wp_query->max_num_pages;
if($max_num_pages > 1) { 
?>
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo; Предыдущие записи ') ?></div>
		<div class="alignright"><?php previous_posts_link('Следующие записи &raquo;') ?></div>
	</div>
<?php }else{ return; } ?>
