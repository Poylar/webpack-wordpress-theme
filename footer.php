<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme
 */

?>

<div class="sprites" style="display:none;">
  <?php require_once(dirname(__FILE__) . '/dist/sprite.svg'); ?>
</div>

<?php wp_footer(); ?>


</body>


</html>