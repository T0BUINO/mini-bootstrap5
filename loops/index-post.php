<?php
/*
 * The Index Post (or excerpt)
 * ===========================
 * Used by index.php, category.php and author.php
 */
?>


<article role="article" id="post_<?php the_ID()?>" <?php post_class("wrap-md entry-content pt-5"); ?> >
  <header>
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
    <h2 class="h2 mb-3 fw-bolder">
      <a href="<?php the_permalink(); ?>">
        <?php the_title()?>
      </a>
    </h2>
  </header>

  <section class="post-meta">
    <?php if ( has_excerpt( $post->ID ) ) {
    the_excerpt();
    ?>
  	<?php } else {
  	  the_content( __('Continue reading →', 'mini-bootstrap5' ) );
	  } ?>

      <div class="index-post-category my-1 text-muted">
          <i class="bi bi-bookmark"></i>
          <span class="text-uppercase"><?php the_category(', '); ?></span>
      </div>
    <div class="text-muted mb-3">
        <i class="bi bi-calendar3"></i> <a href="<?php comments_link(); ?>"><?php b5st_post_date(); ?></a>
        <i class="bi bi-chat-text"></i> <a href="<?php comments_link(); ?>"><?php printf( _nx( '1 条评论', '没有评论', get_comments_number(), '', 'mini-bootstrap5' ), number_format_i18n( get_comments_number() ) ); ?></a>
    </div>
  </section>
</article>
