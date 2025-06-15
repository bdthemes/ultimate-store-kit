<?php

namespace UltimateStoreKit;

use Elementor\Plugin;

final class usk_Modal {
    public function __construct() {
        add_action('wp_footer', [$this, 'usk_render_data']);
    }
    public function usk_get_kit_setting($setting_id) {
        global $usk_modal_settings;
        $return = '';
        if (!isset($usk_modal_settings['kit_settings'])) {
            $active_kit_id = Plugin::$instance->kits_manager->get_active_id();
            $kit = Plugin::$instance->documents->get($active_kit_id, false);

            // Check if kit exists and is a valid object before getting settings
            if ($kit && !is_wp_error($kit)) {
                $usk_modal_settings['kit_settings'] = $kit->get_settings();
            } else {
                // Fallback if kit is not available
                $usk_modal_settings['kit_settings'] = [];
            }
        }

        if (isset($usk_modal_settings['kit_settings'][$setting_id])) {
            $return = $usk_modal_settings['kit_settings'][$setting_id];
        }

        return apply_filters('usk_modal_settings' . $setting_id, $return);
    }
    public function usk_render_data() {
        $modal_width_desktop = $this->usk_get_kit_setting('modal_width');
        $modal_height = $this->usk_get_kit_setting('modal_height');
        $animation = $this->usk_get_kit_setting('modal_animation');
        $close_btn = $this->usk_get_kit_setting('show_close_btn');
        $btn_style = $this->usk_get_kit_setting('button_style');
        $btn_place = $this->usk_get_kit_setting('btn_place');
        $button_text = $this->usk_get_kit_setting('button_text');
        $modal_background = $this->usk_get_kit_setting('modal_background');
        $modal_overlay = $this->usk_get_kit_setting('modal_overlay');
?>
        <div class="product-quick-view" id="quick-view-id" data-modal-overlay="<?php echo esc_attr($modal_overlay); ?>" data-modal-bg="<?php echo esc_attr($modal_background); ?>" data-sm-init="true" data-modal-width="<?php echo esc_attr(is_array($modal_width_desktop) && isset($modal_width_desktop['size']) ? $modal_width_desktop['size'] : ''); ?>" data-modal-height="<?php echo esc_attr(is_array($modal_height) && isset($modal_height['size']) ? $modal_height['size'] : ''); ?>" data-btn-text="<?php echo esc_attr($button_text); ?>" data-btn-place="<?php echo esc_attr($btn_place); ?>" data-btn-style="<?php echo esc_attr($btn_style); ?>" data-close-btn="<?php echo esc_attr($close_btn); ?>" data-animation="<?php echo esc_attr($animation); ?>">
        </div>
<?php
    }
}
new usk_Modal();
