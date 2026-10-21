<?php
/**
 * Template Name: OcaNew – Trang chủ LDP
 * Template Post Type: page
 */
if (!defined('ABSPATH')) {
    exit;
}

// This landing page has its own content flow, without the theme's share widget.
global $caia_social;
if (is_object($caia_social)) {
    $share_callback = array($caia_social, 'add_native_share_button_at_bottom');
    $share_priority = has_filter('the_content', $share_callback);
    if (false !== $share_priority) {
        remove_filter('the_content', $share_callback, $share_priority);
    }
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('oca-home-landing'); ?>>
<?php wp_body_open(); ?>
<a class="oca-skip" href="#oca-main">Đi đến nội dung</a>
<?php get_template_part('template-parts/home-header'); ?>
<main id="oca-main" class="oca-main" tabindex="-1">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/home-banner'); ?>
        <?php get_template_part('template-parts/home-about'); ?>
        <?php get_template_part('template-parts/home-reasons'); ?>
        <?php get_template_part('template-parts/home-ingredients'); ?>
        <?php get_template_part('template-parts/home-preparation'); ?>
        <?php get_template_part('template-parts/home-improvement'); ?>
        <?php get_template_part('template-parts/home-faq'); ?>
        <div class="oca-content oca-container"><?php the_content(); ?></div>
        <?php get_template_part('template-parts/home-expert'); ?>
    <?php endwhile; ?>
</main>
<?php get_template_part('template-parts/home-footer'); ?>
<?php wp_footer(); ?>
</body>
</html>
