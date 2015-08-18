<?php


if ( function_exists('register_sidebar') )
   register_sidebars(1, array(
         'before_widget' => '<div style="clear:both;"></div>',
        'after_widget' => '<div class="bottom_sidebar"></div>',
        'after_title' => '</h2>',
       ));
?>