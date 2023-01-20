<?php
  get_header(); 
  b5st_mainbody_before();
?>

<main id="site-main" class="my-3">
  <?php b5st_mainbody_start(); ?>

  <header class="container-lg pt-4">
    <h2 class="container-lg display-10 h2 fw-bolder">
      <?php echo single_cat_title(); ?>
    </h2>
  </header>

  <?php
    get_template_part('loops/index-loop');
    b5st_mainbody_end();
  ?>
</main>

<?php 
  b5st_mainbody_after();
  get_footer(); 
?>