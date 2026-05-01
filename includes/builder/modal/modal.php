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
						$ultimate_store_kit_templates = \UltimateStoreKit\Includes\Builder\Builder_Template_Helper::templateForSelectDropdown();
						$ultimate_store_kit_separator = \UltimateStoreKit\Includes\Builder\Builder_Template_Helper::separator();

						// It is single
						if ( count( $ultimate_store_kit_templates ) == 1 ) {
							$ultimate_store_kit_template_key = array_key_last( $ultimate_store_kit_templates );
							$ultimate_store_kit_template     = $ultimate_store_kit_templates[ $ultimate_store_kit_template_key ];
							foreach ( $ultimate_store_kit_template as $ultimate_store_kit_key => $ultimate_store_kit_item ) :
								$ultimate_store_kit_select_value = "{$ultimate_store_kit_template_key}{$ultimate_store_kit_separator}{$ultimate_store_kit_key}";
								?>
								<option value="<?php echo esc_attr( $ultimate_store_kit_select_value ) ?>"><?php echo esc_attr( $ultimate_store_kit_item ) ?></option>
								<?php
							endforeach;
						}

						if ( count( $ultimate_store_kit_templates ) > 1 ) {
							foreach ( $ultimate_store_kit_templates as $ultimate_store_kit_keys => $ultimate_store_kit_items ) :
								$ultimate_store_kit_label = ucwords( str_replace( [ '-', '_' ], [ ' ' ], $ultimate_store_kit_keys ) );
								if ( is_array( $ultimate_store_kit_items ) ) {
									?>
									<optgroup label="<?php echo esc_attr( $ultimate_store_kit_label ) ?>"><?php
									   foreach ( $ultimate_store_kit_items as $ultimate_store_kit_key => $ultimate_store_kit_item ) :
										   $ultimate_store_kit_item_value = "{$ultimate_store_kit_keys}{$ultimate_store_kit_separator}{$ultimate_store_kit_key}"
										   	?>
											<option value="<?php echo esc_attr( $ultimate_store_kit_item_value ) ?>"><?php echo esc_attr( $ultimate_store_kit_item ) ?></option>
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
						<input type="hidden" name="template_status" id="template_status" value="1">
						<div class="usk-template-status-switcher usk-active" id="template_status_switcher" role="switch" aria-checked="true" tabindex="0">
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
