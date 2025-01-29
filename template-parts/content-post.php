<div class="post-item">
    <h2 class="headline headline--medium headline--post-title">
        <a href="<?php the_permalink() ?>">
            <?php the_title() ?>
        </a>
    </h2>
    <div class="metabox">
        <p>
            Posted by
            <?php the_author_posts_link()?>
            on
            <?php the_modified_date()?>
            at
            <?php the_modified_date( 'g:i a' ) ?>
            in
            <?php the_category(', ') ?>
        </p>
    </div>
    <div class="generic-content">
        <p><?php the_excerpt() ?></p>
        <p>
            <a class="btn btn--blue" href="<?php the_permalink() ?>">Continue Reading &raquo;</a>
        </p>
    </div>
</div>