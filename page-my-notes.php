<?php
  if (!is_user_logged_in()){
      wp_redirect(esc_url(site_url('/')));
      exit;
  }

  get_header();
  get_template_part('template-parts/banner');
?>

  <div class="container container--narrow page-section">
    Custom notes
  </div>
<?php get_footer(); ?>