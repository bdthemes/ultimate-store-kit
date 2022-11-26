<?php
if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

return [
    'title'              => esc_html__('QR Code', 'ultimate-store-kit'),
    'required'           => true,
    'default_activation' => true,
    'has_style'          => false,
    'has_script'         => false,
];
