<?php
/*
 * The Page Content Loop
 */
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <article role="article" id="post_<?php the_ID()?>" <?php post_class("mb-5")?>>
    <header class="container pt-4">
      <h1 class="display-6 mb-4 h2 fw-bolder">
        <?php the_title()?>
      </h1>
    </header>
    <section class="container entry-content">
      <?php the_content()?>
      <?php wp_link_pages(); ?>
    </section>
  </article>

	<?php
	// This continues in the single post loop
	if ( comments_open() || get_comments_number() ) :

		//comments_template();
		comments_template('/loops/comments.php');

	endif;
	?>

<?php
  endwhile;
  else :
    get_template_part('loops/404');
  endif;
?>
