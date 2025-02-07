<?php
  if (!is_user_logged_in()){
      wp_redirect(esc_url(site_url('/')));
      exit;
  }

  get_header();
  get_template_part('template-parts/banner');
?>

  <div class="container container--narrow page-section">
    <ul id="my-notes" class="min-list link-list">
        <!-- TODO: White space on textarea-->
        <?php
            $user_notes = new WP_Query([
              'post_type' => 'notebook',
              'posts_per_page' => -1,
              'author' => get_current_user_id()
            ]);
            
            while ($user_notes->have_posts()) {
                $user_notes->the_post(); ?>
                <li>
                    <input class="note-title-field" value="<?php echo esc_attr(get_the_title()) ?>"/>
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea class="note-body-field">
                      <?php echo esc_textarea(wp_strip_all_tags(get_the_content(), true)); ?>
                    </textarea>
                </li>
            <?php }
        ?>
    </ul>
  </div>
<?php get_footer(); ?>