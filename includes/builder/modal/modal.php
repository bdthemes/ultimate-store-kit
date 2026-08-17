<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="usk-modal-overlay" id="ultimate-builder-kit-builder-modal" style="display: none">
	<div id="ultimate-builder-kit-builder-modal-wrapper">
		<div class="usk-template-modal-header">
			<div class="usk-modal-logo-wrap">
				<img class="usk-modal-logo" src="<?php echo esc_attr( BDTUSK_ADM_ASSETS_URL . '/images/logo.svg' ) ?>"
					alt="">
				<span class="usk-logo-text"><?php esc_html_e( 'New Template', 'ultimate-store-kit' ); ?></span>
			</div>
			<div class="usk-modal-close-button">
				<a href="javascript:void(0)">
					<span class="dashicons dashicons-no-alt"></span>
				</a>
			</div>
		</div>
		<div class="usk-template-modal-main-wrap">
			<div class="usk-modal-content-wrap">
				<h3 class="usk-modal-title">
					<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- usk_ / BDTUSK_ / ultimate-store-kit- are this plugin's established public prefixes. Ultimate Store Kit Pro calls into these names, as does third-party integration code, so renaming them is a breaking change. Plugin Check only recognises prefixes derived verbatim from the slug and so reports them as unprefixed.

					echo wp_kses(
						sprintf(
							/* translators: 1: Opening span tag, 2: Closing span tag. */
							__( 'Templates Help You %1$sWork Efficiently%2$s', 'ultimate-store-kit' ),
							'<span>',
							'</span>'
						),
						[
							'span' => [],
						]
					);
					?>
				</h3>
				<div class="usk-modal-desc">
					<?php esc_html_e( 'Use templates to create the different pieces of your site, and reuse them with one click whenever needed.', 'ultimate-store-kit' ); ?>
				</div>
			</div>
			<div class="usk-modal-form-wrap">
				<form class="usk-modal-form" method="post">
					<input type="hidden" name="template_id" value="" class="template_id" />
					<input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('usk-builder')); ?>" />
					<div class="usk-form-title"><?php esc_html_e( 'Choose Template Type', 'ultimate-store-kit' ); ?></div>
					<label for="template_type"><?php esc_html_e( 'Select the type of template you want to work on', 'ultimate-store-kit' ); ?></label>
					<select name="template_type" id="template_type">
						<option value=""><?php esc_html_e( 'select', 'ultimate-store-kit' ); ?></option>
						<?php

						$templates = \UltimateStoreKit\Includes\Builder\Builder_Template_Helper::templateForSelectDropdown();
						$separator = \UltimateStoreKit\Includes\Builder\Builder_Template_Helper::separator();

						// It is single
						if ( count( $templates ) == 1 ) {
							$templateKey = array_key_last( $templates );
							$template    = $templates[ $templateKey ];
							foreach ( $template as $key => $item ) :
								$selectValue = "{$templateKey}{$separator}{$key}";
								?>
								<option value="<?php echo esc_attr( $selectValue ) ?>"><?php echo esc_attr( $item ) ?></option>
								<?php
							endforeach;
						}

						if ( count( $templates ) > 1 ) {
							foreach ( $templates as $keys => $items ) :
								$label = ucwords( str_replace( [ '-', '_' ], [ ' ' ], $keys ) );
								if ( is_array( $items ) ) {
									?>
									<optgroup label="<?php echo esc_attr( $label ) ?>"><?php
									   foreach ( $items as $key => $item ) :
										   $itemValue = "{$keys}{$separator}{$key}"
										   	?>
											<option value="<?php echo esc_attr( $itemValue ) ?>"><?php echo esc_attr( $item ) ?></option>
											<?php
									   endforeach;
									   ?>
									</optgroup>
									<?php
								}
							endforeach;
						}
						?>
					</select>
					<label for="fname"><?php esc_html_e( 'Name your template', 'ultimate-store-kit' ); ?></label>
					<input type="text" name="template_name" id="template_name" placeholder="<?php echo esc_attr__( 'Enter template name', 'ultimate-store-kit' ); ?>">
					<div class="usk-template-status-switcher-wrap">
						<input type="hidden" name="template_status" id="usk_template_status" value="1">
						<div class="usk-template-status-switcher usk-active" id="usk_template_status_switcher" role="switch" aria-checked="true" tabindex="0">
							<span class="usk-switcher-slider"></span>
						</div>
						<span class="usk-switcher-status-text"><?php esc_html_e( 'Active', 'ultimate-store-kit' ); ?></span>
					</div>
					<input class="usk-modal-submit-btn" type="submit" value="<?php echo esc_attr__( 'Create Template', 'ultimate-store-kit' ); ?>">
				</form>
			</div>
		</div>
	</div>
</div>

<style>
	.input-error {
		border: 1px solid red !important;
	}
</style>
