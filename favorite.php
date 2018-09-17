<?php
/*
Template Name: Favorite Articles
*/
if(is_user_logged_in()){
get_header(); 
?>
<div class="favorite_page">
<div id="wpum-form-profile" class="wpum-profile-form-wrapper">
<div class="profile-menu">
  <div class="profile-menu-change-cat">
    <div class="profile-menu-trigger">
      <span>Профиль</span>
    </div>
    <div class="profile-category-menu">
      <?php wp_nav_menu( array('menu' => 'account' ));?>
    </div>
  </div>
  <p><a href="#" class="profile-menu-password"><?php echo TEXT_CHANGE_PASSWORD;?></a> </p>
	<?php echo '<div class="logout_link_wrapper"><a href="'.wp_logout_url(home_url()).'" class="logout_link">'.TEXT_LOGOUT.'</a></div>';?>
</div>
<form action="#" method="post" id="wpum-profile-new" class="wpum-profile-form" name="wpum-profile" enctype="multipart/form-data">
<div class="user_avatar_wrapper">
<div class="user_avatar">
	<div class="wpum-uploaded-files">
		<?php echo (get_user_meta(get_current_user_id(), 'current_user_avatar',true) ? '<a class="closeImg" href="#"><span>Удалить аватарку</span></a>' : '');?>
    <label for="user_avatar">
		<span id="empty_img"><img id="blah" src="<?php echo (get_user_meta(get_current_user_id(), 'current_user_avatar',true) ? get_user_meta(get_current_user_id(), 'current_user_avatar',true) : '');?>"></span>		<span class="profile-add-avatar"></span>
    </label>
    <input type="file" class="input-upload" name="user_avatar" id="user_avatar">
	</div>
	</div>
</div>
</form>
</div>
<?php
$cats = get_categories();
$posts_id = array();
/* foreach($cats as $categories){
	$posts_id = array_merge($posts_id, get_favorite_posts($categories->name));
} */
echo '<div class="news-and-blog"><div class="news-and-blog-articles">';
$posts_id = get_favorite_posts('blog');
if(!empty($posts_id)){
get_news(['posts_per_page' => 4, 'post__in' => array_filter($posts_id)]);
echo '<div id="posts"></div>';
$posts = get_posts( array(
        'numberposts' => -1,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'include'     => array_filter($posts_id),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_type'   => 'post',
        'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
      ) );
      $posts_number = count($posts); 
			 if ($posts_number > 4 ) :
				echo '<div id="true_loadmore" class="blog-menu-more-button"><span>Больше статей</span><div class="unactive"></div></div>';
       endif; 
echo '</div></div>';
?>
<script>
  jQuery(function($){
    $('.module-added').click(function(){
      $(this).addClass('module-add');
      $(this).removeClass('module-added');

      $(this).addClass('curr');
      $.ajax({
        url: '<?php echo admin_url("admin-ajax.php") ?>',
        type: 'POST',
        data: {
          action: 'del_from_fav',
          post_id: $('.curr').attr('id')
        },
        success: function( data ) {
          console.log(data);
        }
      });
      $(this).removeClass('curr');
    });
  });
</script>
<?php
}else{
	echo '<p class="empty_pages">'.TEXT_NO_FAVORITE_ARTICLES.'</p>';
}
?>
</div>
<div class="password-reset modal-win" style="display: none;">
    <div class="closeCross"></div>
    <form class="password-reset-form">
			<div class="change-password-messages"></div>
      <div class="password-reset-input">
        <label for="">
          <span><?php echo TEXT_CURRENT_PASSWORD;?></span>
          <input type="password" name="oldPassword" placeholder="" class="password0">
        </label>
      </div>
      <div class="password-reset-input">
        <label for="">
          <span><?php echo TEXT_NEW_PASSWORD;?></span>
          <input type="password" name="newPassword" placeholder="" class="password1">
        </label>
      </div>
      <div class="password-reset-input">
        <label for="">
          <span><?php echo TEXT_NEW_PASSWORD_CONFIRM;?></span>
          <input type="password" name="repeatPassword" placeholder="" class="password2">
        </label>
      </div>
      <div class="password-reset-button">
        <button class="btn-change-pass button"><?php echo TEXT_SAVE;?></button>
      </div>
    </form>
  </div>
	<script>
    jQuery(function($){
        jQuery(function($){
          $('.article-in-favorite').click(function(){
						var _this = $(this);
            _this.addClass('curr');
            $.ajax({
              url: '<?php echo admin_url("admin-ajax.php") ?>',
              type: 'POST',
              data: {
                action: 'del_from_fav',
                post_id: $('.curr').attr('id')
              },
              success: function( data ) {
                _this.parents('.news-and-blog-article').remove();
              }
            });
            $(this).removeClass('curr');
          });
        });
		})
  </script>
<?php get_footer();
}else{
wp_redirect(esc_url( home_url( '/' ) ));
}
 ?>