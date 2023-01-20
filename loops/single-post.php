<?php
/*
 * The Single Post
 */
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <article role="article" id="post_<?php the_ID()?>" <?php post_class("entry-content")?>>
      <section class="container-md pt-3 mt-4">
          <?php the_post_thumbnail(); ?>
      </section>

    <header class="entry-header container">
      <h2 class="display-6 fw-bolder post-title h2"><?php the_title()?></h2>
      <div class="header-metas d-flex text-muted">

        <div class="pe-3">
          <i class="bi bi-calendar3"></i>
          <?php b5st_post_date(); ?>
        </div>

        <div class="post-meta">
          <i class="bi bi-chat-text"></i>
          <a href="#post-comments"><?php
            $comment_count = get_comments_number();
            printf(
              /* translators: 1: comment count number. */
              esc_html( _nx( '%1$s 条评论', '没有评论', $comment_count, 'mini-bootstrap5' ) ),
              number_format_i18n( $comment_count )
            );
          ?></a>
        </div>
      </div>
    </header>

    <?php wp_link_pages(); ?>

    <section class="my-5 long-read container">
      <?php the_content(); ?>
    </section>

    <?php wp_link_pages(); ?>
  </article>
    <section class="container post-meta">
        <div class="footer-metas text-muted">
            <i class="bi bi-bookmark"></i>
            <span class="text-uppercase"><?php the_category(', '); ?></span>
        </div>

      <?php if (has_tag()) { ?>
        <div class="footer-metas mb-5 mt-1 text-muted">
          <i class="bi bi-tag"></i>
          <?php the_tags('', ', '); ?>
        </div>
      <?php  }; ?>
    </section>

  <?php
    // This continues in the single post loop
    if ( comments_open() || get_comments_number() ) :

    //comments_template();
    comments_template('/loops/comments.php');

    endif;
  ?>

  <section class="container-xxl my-5">
    <div class="row g-2">
      <?php if (strlen(get_previous_post()->post_title) > 0) { ?>
      <div class="col-sm">
        <div class="border rounded bg-light d-flex align-items-center post-pagination-item">
          <i class="bi bi-chevron-compact-left fs-1"></i>
          <div class="my-2 post-pagination-text">
            上一篇文章<br>
            <?php previous_post_link( '%link', '%title' ) ?>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if (strlen(get_next_post()->post_title) > 0) { ?>
        <div class="col-sm">
          <div class="border rounded bg-light d-flex flex-row-reverse align-items-center post-pagination-item">
          <i class="bi bi-chevron-compact-right fs-1"></i>
          <div class="text-end my-2 post-pagination-text">
            下一篇文章<br>
            <?php next_post_link( '%link', '%title' ) ?>
          </div>
        </div>
      </div>
      <?php } ?>

      <!-- `<div class="col text-start">
        <?php previous_post_link('%link', '<i class="bi bi-arrow-left"></i> Previous post: '.'%title'); ?>
      </div>
      <div class="col text-end">
        <?php next_post_link('%link', 'Next post: '.'%title'.' <i class="bi bi-arrow-right"></i>'); ?>
      </div> -->
    </div>
  </section>




  <?php
  endwhile; else :
    get_template_part('loops/404');
  endif;
?>


