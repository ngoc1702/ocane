<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_reasons_title', 'Lý do lựa chọn OcaNew nut');
$description = oca_home_text('oca_reasons_description', 'Cùng OcaNew nut tìm hiểu những giá trị mà chúng tôi hướng đến trong hành trình đồng hành cùng gia đình bạn.');
$image = absint(oca_home_field('oca_reasons_image'));
$product = absint(oca_home_field('oca_hero_image'));
$default_icons = oca_home_reasons();
?>
<section id="ly-do-lua-chon" class="oca-reasons" aria-label="<?php echo esc_attr($title ?: 'Lý do lựa chọn OcaNew nut'); ?>">
    <div class="oca-container oca-reasons__inner">
        <div class="oca-reasons__visual<?php echo $image ? '' : ' oca-reasons__visual--product'; ?>">
            <?php if ($image || $product) {
                echo wp_get_attachment_image($image ?: $product, 'full', false, array('class' => 'oca-reasons__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, (max-width: 1100px) 40vw, 520px'));
            } ?>
        </div>
        <div class="oca-reasons__copy">
            <?php if ($title) : ?><h2 class="oca-reasons__title"><?php echo nl2br(esc_html($title)); ?></h2><?php endif; ?>
            <?php if ($description) : ?><p class="oca-reasons__description"><?php echo nl2br(esc_html($description)); ?></p><?php endif; ?>
            <ul class="oca-reasons__list">
                <?php foreach (oca_home_reason_items() as $index => $reason) :
                    if (empty($reason['description'])) {
                        continue;
                    }
                    $icon = !empty($reason['icon']) ? absint($reason['icon']) : 0;
                    ?>
                    <li class="oca-reasons__item">
                        <span class="oca-reasons__icon" aria-hidden="true">
                            <?php if ($icon) : ?>
                                <?php echo wp_get_attachment_image($icon, 'full', false, array('class' => 'oca-reasons__icon-image', 'alt' => '', 'loading' => 'lazy', 'sizes' => '64px')); ?>
                            <?php else : ?>
                                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr($default_icons[$index % count($default_icons)]['path']); ?>"/></svg>
                            <?php endif; ?>
                        </span>
                        <p><?php echo nl2br(esc_html($reason['description'])); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
