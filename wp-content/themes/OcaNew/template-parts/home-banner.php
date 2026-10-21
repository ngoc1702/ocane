<?php
if (!defined('ABSPATH')) {
    exit;
}
$background = absint(oca_home_field('oca_home_banner'));
$product = absint(oca_home_field('oca_hero_image'));
$button_url = oca_home_field('oca_home_banner_link');
// Preserve intentionally blank text fields; defaults apply only to unsaved fields.
$text = function ($name, $fallback) {
    if (function_exists('get_field')) {
        $value = get_field($name);
        if (is_string($value)) {
            return $value;
        }
    }
    return $fallback;
};
$eyebrow = $text('oca_hero_eyebrow', 'OCANEW NUT');
$title = $text('oca_hero_title', 'Dinh dưỡng mỗi ngày,');
$highlight = $text('oca_hero_highlight', 'trọn vẹn yêu thương.');
$description = $text('oca_hero_description', 'Cùng OcaNew nut tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho bạn và gia đình.');
$button = $text('oca_hero_button', 'Khám phá sản phẩm');
?>
<section id="trang-chu" class="oca-hero oca-hero--with-background<?php echo $background ? '' : ' oca-hero--brand-background'; ?>" aria-labelledby="oca-hero-title">
    <?php if ($background) : ?>
        <?php echo wp_get_attachment_image($background, 'full', false, array('class' => 'oca-hero__background', 'alt' => '', 'aria-hidden' => 'true', 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '100vw')); ?>
    <?php else : ?>
        <img class="oca-hero__background" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/banner/oca-hero-warm-kitchen-v2.webp'); ?>" width="2171" height="724" alt="" aria-hidden="true" loading="eager" fetchpriority="high">
    <?php endif; ?>
    <div class="oca-hero__milk" aria-hidden="true"></div>
    <div class="oca-container oca-hero__inner<?php echo $product ? '' : ' oca-hero__inner--text-only'; ?>">
        <div class="oca-hero__copy">
            <?php if ($eyebrow) : ?><p class="oca-hero__eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
            <h1 id="oca-hero-title" class="oca-hero__title">
                <?php echo esc_html($title ?: ($highlight ? '' : get_the_title())); ?>
                <?php if ($highlight) : ?><span><?php echo esc_html($highlight); ?></span><?php endif; ?>
            </h1>
            <?php if ($description) : ?><p class="oca-hero__description"><?php echo nl2br(esc_html($description)); ?></p><?php endif; ?>
            <?php if ($button && $button_url) : ?>
                <a class="oca-button" href="<?php echo esc_url($button_url); ?>"><?php echo esc_html($button); ?><span class="oca-button__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></a>
            <?php endif; ?>
        </div>
        <?php if ($product) : ?>
            <div class="oca-hero__visual">
                <?php echo wp_get_attachment_image($product, 'full', false, array('class' => 'oca-hero__product', 'loading' => 'eager', 'fetchpriority' => $background ? 'auto' : 'high', 'sizes' => '(max-width: 760px) 90vw, (max-width: 1320px) 48vw, 620px')); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
