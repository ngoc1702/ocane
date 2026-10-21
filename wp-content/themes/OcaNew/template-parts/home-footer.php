<?php
if (!defined('ABSPATH')) {
    exit;
}
$background = absint(oca_home_field('oca_footer_background'));
$accent = absint(oca_home_field('oca_footer_accent')) ?: absint(oca_home_field('oca_hero_image'));
$accent_left = absint(oca_home_field('oca_footer_accent_left')) ?: (absint(oca_home_field('oca_improvement_new_image')) ?: absint(oca_home_field('oca_hero_image')));
$logo = absint(oca_home_field('oca_footer_logo')) ?: absint(oca_home_field('oca_home_logo'));
$show_accent = function_exists('get_field') ? get_field('oca_footer_show_accent') : null;
$show_accent = null === $show_accent ? true : (bool) $show_accent;
$overlay = function_exists('get_field') ? get_field('oca_footer_overlay') : null;
$overlay = is_numeric($overlay) ? min(100, max(0, (int) $overlay)) : 80;
$company = oca_home_text('oca_footer_company', 'OcaNew nut');
$info = oca_home_text('oca_footer_company_info', 'OcaNew nut đồng hành cùng bạn trong hành trình lựa chọn dinh dưỡng cho gia đình.');
$address = oca_home_text('oca_footer_address');
$contact_items = array();
foreach (array('support', 'email', 'document') as $key) {
    $default = oca_home_top_items()[$key];
    $item = oca_home_field('oca_top_' . $key, $default);
    $item = is_array($item) ? wp_parse_args($item, $default) : $default;
    if ('' !== trim((string) $item['label'])) {
        $contact_items[$key] = array('item' => $item, 'default' => $default);
    }
}
$links_title = oca_home_text('oca_footer_links_title', 'Liên kết nhanh');
$connect_title = oca_home_text('oca_footer_connect_title', 'Kết nối cùng OcaNew');
$social_items = oca_home_field('oca_footer_social_items', array());
$social_items = is_array($social_items) ? $social_items : array();
$badge = absint(oca_home_field('oca_footer_badge'));
$badge_link = oca_home_text('oca_footer_badge_link');
$copyright = oca_home_text('oca_footer_copyright', 'OcaNew nut. All rights reserved.');
?>
<footer id="oca-footer" class="oca-footer<?php echo $show_accent && ($accent || $accent_left) ? ' oca-footer--with-accent' : ''; ?>" style="--oca-footer-overlay: <?php echo esc_attr($overlay / 100); ?>;">
    <?php if ($background) {
        echo wp_get_attachment_image($background, 'full', false, array('class' => 'oca-footer__background', 'alt' => '', 'aria-hidden' => 'true', 'loading' => 'lazy', 'sizes' => '100vw'));
    } ?>
    <?php if ($show_accent && $accent) : ?>
        <div class="oca-footer__accent oca-footer__accent--right" aria-hidden="true"><?php echo wp_get_attachment_image($accent, 'medium_large', false, array('alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100px, 150px')); ?></div>
    <?php endif; ?>
    <?php if ($show_accent && $accent_left) : ?>
        <div class="oca-footer__accent oca-footer__accent--left" aria-hidden="true"><?php echo wp_get_attachment_image($accent_left, 'medium_large', false, array('alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100px, 150px')); ?></div>
    <?php endif; ?>
    <div class="oca-container oca-footer__columns">
        <div class="oca-footer__column oca-footer__company">
            <a class="oca-footer__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(($company ?: 'OcaNew nut') . ' — Trang chủ'); ?>">
                <?php if ($logo) {
                    echo wp_get_attachment_image($logo, 'full', false, array('class' => 'oca-footer__logo-image', 'alt' => $company ?: 'OcaNew nut', 'loading' => 'lazy', 'sizes' => '200px'));
                } else { ?><span class="oca-logo__word">OcaNew</span><span class="oca-logo__nut">nut</span><?php } ?>
            </a>
            <?php if ($info) : ?><div class="oca-footer__info"><?php echo wpautop(esc_html($info)); ?></div><?php endif; ?>
            <?php if ($address || $contact_items) : ?>
                <address class="oca-footer__contact">
                    <?php if ($address) : ?><p>Địa chỉ: <?php echo nl2br(esc_html($address)); ?></p><?php endif; ?>
                    <?php foreach ($contact_items as $key => $contact) :
                        $item = $contact['item']; ?>
                        <p class="oca-footer__contact-row" data-contact="<?php echo esc_attr($key); ?>">
                            <?php echo oca_home_top_icon($key, $item, $contact['default'], 'oca-footer__contact-icon'); ?>
                            <?php if (!empty($item['url'])) : ?>
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                            <?php else : ?>
                                <span><?php echo esc_html($item['label']); ?></span>
                            <?php endif; ?>
                        </p>
                    <?php endforeach; ?>
                </address>
            <?php endif; ?>
        </div>
        <nav class="oca-footer__column oca-footer__links" aria-label="<?php echo esc_attr($links_title ?: 'Liên kết chân trang'); ?>">
            <?php if ($links_title) : ?><h2 class="oca-footer__title"><?php echo esc_html($links_title); ?></h2><?php endif; ?>
            <?php wp_nav_menu(array('theme_location' => 'oca_landing', 'container' => false, 'menu_class' => 'oca-footer__menu', 'depth' => 2, 'fallback_cb' => 'oca_home_default_menu')); ?>
        </nav>
        <div class="oca-footer__column oca-footer__connect">
            <?php if ($connect_title) : ?><h2 class="oca-footer__title"><?php echo esc_html($connect_title); ?></h2><?php endif; ?>
            <?php if ($social_items) : ?><div class="oca-footer__socials">
                <?php foreach ($social_items as $social) :
                    $image = absint($social['image'] ?? 0);
                    $image_html = $image ? wp_get_attachment_image($image, 'thumbnail', false, array('alt' => sanitize_text_field($social['label'] ?? '') ?: (get_post_meta($image, '_wp_attachment_image_alt', true) ?: 'Liên kết OcaNew'), 'loading' => 'lazy', 'sizes' => '32px')) : '';
                    if (!$image_html) { continue; }
                    $url = esc_url($social['url'] ?? '');
                    $tag = $url ? 'a' : 'span';
                    ?>
                    <<?php echo $tag; ?> class="oca-footer__social"<?php if ($url) : ?> href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo $image_html; ?></<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div><?php endif; ?>
            <?php if ($badge) : ?>
                <div class="oca-footer__badge">
                    <?php if ($badge_link) : ?><a href="<?php echo esc_url($badge_link); ?>" aria-label="Xem thông tin Bộ Công Thương" target="_blank" rel="noopener noreferrer"><?php endif; ?>
                    <?php echo wp_get_attachment_image($badge, 'medium', false, array('alt' => get_post_meta($badge, '_wp_attachment_image_alt', true) ?: 'Logo Bộ Công Thương', 'loading' => 'lazy', 'sizes' => '160px')); ?>
                    <?php if ($badge_link) : ?></a><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="oca-footer__bottom">
        <img class="oca-footer__milk" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/banner-footer.png'); ?>" alt="" aria-hidden="true" width="1920" height="247" loading="lazy">
        <?php if ($copyright) : ?><p class="oca-container oca-footer__copyright">&copy; <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html($copyright); ?></p><?php endif; ?>
    </div>
</footer>
