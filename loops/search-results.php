<?php
/*
 * The Search Results (Main Header and) Loop
 */
?>

<header class="container-lg pt-4">
  <h1 class="display-5 my-5 fw-bolder">
      "<?php the_search_query(); echo '"'; echo " 的搜索结果"; ?>
  </h1>
</header>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <article role="article" id="post_<?php the_ID()?>" <?php post_class("wrap-md pb-5")?>>
    <header class="entry-header">
      <h2><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
    </header>
    <section class="entry-content">
      <?php the_excerpt(); ?>
    </section>
  </article>
<?php endwhile; else: ?>
  <div class="wrap-md pb-5 entry-content">
    <article class="alert alert-warning px-3">
      <i class="bi bi-exclamation-triangle"></i> <?php _e('Sorry, your search yielded no results.', 'mini-bootstrap5'); ?>
    </article>
  </div>
<?php endif; ?>
