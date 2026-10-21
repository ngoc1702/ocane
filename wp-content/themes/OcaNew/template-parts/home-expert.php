<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_expert_title', 'Hỏi chuyên gia');
$description = oca_home_text('oca_expert_description', 'Để lại câu hỏi và thông tin liên hệ để OcaNew nut hỗ trợ bạn.');
$image = absint(oca_home_field('oca_expert_image'));
$product = absint(oca_home_field('oca_hero_image'));
$background = absint(oca_home_field('oca_expert_background'));
$form_id = absint(oca_home_field('oca_expert_form_id')) ?: absint(get_option('oca_expert_form_id'));
$has_form = false;
if ($form_id && shortcode_exists('fluentform') && class_exists('\FluentForm\App\Models\Form')) {
    $expert_form = \FluentForm\App\Models\Form::find($form_id);
    $has_form = $expert_form && 'published' === $expert_form->status;
}
?>
<section id="hoi-chuyen-gia" class="oca-expert<?php echo $background ? ' oca-expert--with-background' : ''; ?>" aria-label="<?php echo esc_attr($title ?: 'Hỏi chuyên gia'); ?>">
    <?php if ($background) {
        echo wp_get_attachment_image($background, 'full', false, array('class' => 'oca-expert__background', 'alt' => '', 'aria-hidden' => 'true', 'loading' => 'lazy', 'sizes' => '100vw'));
    } ?>
    <div class="oca-container oca-expert__inner<?php echo $image || $product ? '' : ' oca-expert__inner--text-only'; ?>">
        <?php if ($image || $product) : ?>
            <div class="oca-expert__visual<?php echo $image ? '' : ' oca-expert__visual--product'; ?>">
                <?php echo wp_get_attachment_image($image ?: $product, 'full', false, array('class' => 'oca-expert__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, (max-width: 1100px) 40vw, 50vw')); ?>
            </div>
        <?php endif; ?>
        <div class="oca-expert__copy">
            <?php if ($title) : ?><h2 class="oca-section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($description) : ?><p class="oca-expert__description"><?php echo nl2br(esc_html($description)); ?></p><?php endif; ?>
            <?php if ($has_form) : ?>
                <div class="oca-expert__form"><?php
                    $add_button_icon = static function ($html) {
                        $icon = '<span class="oca-button__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span>';
                        return preg_replace('/<\/button>/i', $icon . '</button>', $html, 1);
                    };
                    add_filter('fluentform/rendering_field_html_button', $add_button_icon);
                    try {
                        echo do_shortcode('[fluentform id="' . $form_id . '"]');
                    } finally {
                        remove_filter('fluentform/rendering_field_html_button', $add_button_icon);
                    }
                ?></div>
            <?php else : ?>
                <p class="oca-expert__notice">Biểu mẫu hiện chưa sẵn sàng. Vui lòng liên hệ OcaNew nut qua kênh hỗ trợ chính thức.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
