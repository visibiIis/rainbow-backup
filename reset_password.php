<?php
/*
Template Name: Reset Password Page
*/

get_header(); ?>
<div class="account_page reset_password">
<div class="wrapper">
  <?php
	echo '<h1>'.get_the_title().'</h1>';
  $content_page = apply_filters('the_content', $post->post_content);
  echo '<div class="user-forms">';
  echo $content_page;
  echo '</div>';
  ?>
</div>
</div>
<?php get_footer(); ?>