<?php
  get_header(); 
  b5st_mainbody_before();
?>

<main id="site-main" class="my-3">
  <?php
    b5st_mainbody_start();
    get_template_part('loops/index-loop');
    b5st_mainbody_end();
  ?>

</main>

<?php 
  b5st_mainbody_after();
  get_footer(); 
?>
