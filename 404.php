	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
      <div class="main <?php echo bigcloudcms_main_class(); ?>" role="main">
<div class="alert">
  <?php _e('Sorry, but the page you were trying to view does not exist.', 'bigcloudcms'); ?>
</div>

<p><?php _e('It looks like this was the result of either:', 'bigcloudcms'); ?></p>
<ul>
  <li><?php _e('a mistyped address', 'bigcloudcms'); ?></li>
  <li><?php _e('an out-of-date link', 'bigcloudcms'); ?></li>
</ul>

<?php get_search_form(); ?>
</div>