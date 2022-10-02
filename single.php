<?php get_header() ?>


<main class="main catalog">
  <section class="catalog-header" style="background-image:url('<?php the_post_thumbnail_url('large') ?>');">
    <h1 class="page-title">
      <?php the_title() ?>
    </h1>
  </section>
  <section class="catalog-content container-fluid content">
    <div class="container">
      <div class="breadcrumbs">
        <?php
        if (function_exists('bcn_display')) {
          bcn_display();
        }
        ?>
      </div>

    </div>
    <div class="container page-content">
      <?php the_content() ?>
    </div>
  </section>

</main>

<?php get_footer() ?>