<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_about_title', 'Về OcaNew nut');
$subtitle = oca_home_text('oca_about_subtitle', "Dinh dưỡng từ thiên nhiên\nCho cuộc sống tốt đẹp hơn");
$description = oca_home_text('oca_about_description', 'OcaNew nut đồng hành cùng bạn trong việc tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho gia đình. Khám phá câu chuyện thương hiệu, thông tin sản phẩm và những giá trị mà OcaNew nut hướng đến.');
$image = absint(oca_home_field('oca_about_image'));
$product = absint(oca_home_field('oca_hero_image'));
$button = oca_home_text('oca_about_button', 'Tìm hiểu thêm');
$link = oca_home_field('oca_about_link', array());
$url = is_array($link) && !empty($link['url']) ? $link['url'] : '';
$new_tab = is_array($link) && isset($link['target']) && '_blank' === $link['target'];
?>
<section id="ve-chung-toi" class="oca-about" aria-label="<?php echo esc_attr($title ?: 'Giới thiệu OcaNew nut'); ?>">
    <div class="oca-container oca-about__inner">
        <div class="oca-about__copy">
            <?php if ($title) : ?><h2 class="oca-section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($subtitle) : ?><h3 class="oca-about__subtitle"><?php echo nl2br(esc_html($subtitle)); ?></h3><?php endif; ?>
            <?php if ($description) : ?><div class="oca-about__description"><?php echo wpautop(esc_html($description)); ?></div><?php endif; ?>
            <?php if ($button && $url) : ?>
                <a class="oca-button" href="<?php echo esc_url($url); ?>"<?php if ($new_tab) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html($button); ?><span class="oca-button__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></a>
            <?php endif; ?>
        </div>
        <?php if ($image || $product) : ?>
            <div class="oca-about__visual<?php echo $image ? '' : ' oca-about__visual--product'; ?>">
                <?php echo wp_get_attachment_image($image ?: $product, 'full', false, array('class' => 'oca-about__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, (max-width: 1320px) 56vw, 720px')); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
