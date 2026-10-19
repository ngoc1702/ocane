<?php
if (!defined('ABSPATH')) {
    exit;
}
$background = absint(oca_home_field('oca_preparation_background'));
$eyebrow = oca_home_text('oca_preparation_eyebrow', 'Quy trình pha OcaNew');
$title = oca_home_text('oca_preparation_title', '4 bước đơn giản cho ly dinh dưỡng thơm ngon');
$overlay = function_exists('get_field') ? get_field('oca_preparation_overlay') : null;
$overlay = is_numeric($overlay) ? min(100, max(0, (int) $overlay)) : 75;
?>
<section id="cach-pha" class="oca-preparation" aria-label="<?php echo esc_attr($title ?: 'Quy trình pha OcaNew'); ?>" style="--oca-preparation-overlay: <?php echo esc_attr($overlay / 100); ?>;">
    <?php if ($background) : ?>
        <?php echo wp_get_attachment_image($background, 'full', false, array('class' => 'oca-preparation__background', 'alt' => '', 'aria-hidden' => 'true', 'loading' => 'lazy', 'sizes' => '100vw')); ?>
    <?php endif; ?>
    <div class="oca-container oca-preparation__inner">
        <div class="oca-preparation__heading">
            <?php if ($eyebrow) : ?><p class="oca-preparation__eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
            <?php if ($title) : ?><h2 class="oca-preparation__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        </div>
        <ol class="oca-preparation__steps">
            <?php foreach (oca_home_preparation_steps() as $index => $defaults) :
                $value = oca_home_field('oca_preparation_step_' . ($index + 1), array());
                $step = is_array($value) ? wp_parse_args($value, $defaults) : $defaults;
                $image = !empty($step['image']) ? absint($step['image']) : 0;
                ?>
                <li class="oca-preparation__step">
                    <div class="oca-preparation__media<?php echo $image ? '' : ' oca-preparation__media--empty'; ?>"<?php if (!$image) : ?> aria-hidden="true"<?php endif; ?>>
                        <?php if ($image) {
                            echo wp_get_attachment_image($image, 'full', false, array('class' => 'oca-preparation__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, (max-width: 1100px) 50vw, 300px'));
                        } ?>
                    </div>
                    <div class="oca-preparation__detail">
                        <span class="oca-preparation__number" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <div class="oca-preparation__copy">
                            <?php if (!empty($step['title'])) : ?><h3><?php echo esc_html($step['title']); ?></h3><?php endif; ?>
                            <?php if (!empty($step['description'])) : ?><p><?php echo nl2br(esc_html($step['description'])); ?></p><?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
