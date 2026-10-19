<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<header class="oca-header">
    <div class="oca-topbar">
        <div class="oca-container oca-topbar__inner">
            <?php foreach (oca_home_top_items() as $key => $default) :
                $item = oca_home_field('oca_top_' . $key, $default);
                $item = is_array($item) ? wp_parse_args($item, $default) : $default;
                if ('' === trim((string) $item['label'])) {
                    continue;
                }
                $tag = empty($item['url']) ? 'span' : 'a';
                ?>
                <<?php echo $tag; ?> class="oca-topbar__item oca-topbar__item--<?php echo esc_attr($key); ?>"<?php if ('a' === $tag) : ?> href="<?php echo esc_url($item['url']); ?>"<?php endif; ?>>
                    <?php if (!empty($item['icon'])) : ?>
                        <?php echo wp_get_attachment_image(absint($item['icon']), 'full', false, array('class' => 'oca-topbar__icon', 'alt' => '', 'aria-hidden' => 'true')); ?>
                    <?php else : ?>
                        <svg class="oca-topbar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="<?php echo esc_attr($default['path']); ?>"/></svg>
                    <?php endif; ?>
                    <span><?php echo esc_html($item['label']); ?></span>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="oca-container oca-header__inner">
        <a class="oca-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="OcaNew nut — Trang chủ">
            <?php $logo = absint(oca_home_field('oca_home_logo'));
            if ($logo) {
                echo wp_get_attachment_image($logo, 'full', false, array('loading' => 'eager', 'alt' => 'OcaNew nut', 'class' => 'oca-logo__image'));
            } else { ?>
                <span class="oca-logo__word">OcaNew</span><span class="oca-logo__nut">nut</span>
            <?php } ?>
        </a>
        <button class="oca-menu-toggle" type="button" aria-controls="oca-navigation" aria-expanded="false" aria-label="Mở menu" hidden><span></span><span></span><span></span></button>
        <nav id="oca-navigation" class="oca-navigation" aria-label="Điều hướng chính">
            <?php wp_nav_menu(array('theme_location' => 'oca_landing', 'container' => false, 'menu_class' => 'oca-menu', 'fallback_cb' => 'oca_home_default_menu', 'depth' => 2)); ?>
        </nav>
    </div>
</header>
