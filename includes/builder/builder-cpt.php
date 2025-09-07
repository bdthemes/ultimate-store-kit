<?php

namespace UltimateStoreKit\Includes\Builder;

use UltimateStoreKit\Base\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Builder_Cpt {

	use Singleton;

	public function init_hooks() {
		$builderCpt = Meta::POST_TYPE;

		add_action( 'init', [ $this, 'registered_post_type' ] );
		add_action( 'admin_footer', [ $this, 'add_modal_html' ], 1 );
		add_action( 'delete_post', [ $this, 'trashed_or_delete_post' ], 10, 2 );
		add_action( 'trashed_post', [ $this, 'trashed_or_delete_post' ], 10, 1 );

		add_action( 'wp_ajax_ultimate_store_kit_builder_create_template', [ $this, 'create_builder_template' ] );
		add_action( 'wp_ajax_ultimate_store_kit_builder_get_edit_template', [ $this, 'get_builder_template_action' ] );
		add_filter( "manage_{$builderCpt}_posts_columns", [ $this, 'set_post_columns' ] );
		add_action( "manage_{$builderCpt}_posts_custom_column", [ $this, 'set_custom_column_value' ], 10, 2 );
		add_filter( 'post_row_actions', [ $this, 'post_row_actions_filter' ], 20, 2 );

		// Simple WPML fix
		if (function_exists('icl_object_id')) {
			add_filter('elementor/editor/before_enqueue_scripts', [$this, 'fix_wpml_elementor_data'], 1);
		}

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ], 1 );
			add_action( 'admin_menu', [ $this, 'add_admin_menu' ], 202 );
			add_action( 'restrict_manage_posts', [ $this, 'add_filter' ] );
			add_filter( 'parse_query', [ $this, 'parse_query_filter' ] );
		}

		//        $this->resetTemplateCache();
	}

	public function resetTemplateCache() {
		global $wpdb;

		$postType = Meta::POST_TYPE;

		$query = $wpdb->get_results( "SELECT {$wpdb->posts}.ID,{$wpdb->posts}.post_type, {$wpdb->posts}.post_status, {$wpdb->postmeta}.meta_value as template_type
FROM $wpdb->posts
    LEFT JOIN $wpdb->postmeta
        ON {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID
WHERE 1=1
AND {$wpdb->posts}.post_type ='{$postType}'
AND {$wpdb->postmeta}.meta_key ='_ultimate_store_kit_template_type'
ORDER BY {$wpdb->posts}.post_date DESC" );

		foreach ( $query as $q ) {
			if ( ! $q->template_type ) {
				continue;
			}

			$optionKey = Meta::TEMPLATE_ID . $q->template_type;

			if ( $q->post_status == 'publish' ) {
				update_option( $optionKey, $q->ID );
			} else {
				delete_option( $optionKey, $q->ID );
			}
		}
	}

	public function trashed_or_delete_post( $postId ) {
		if ( get_post_type( $postId ) != Meta::POST_TYPE ) {
			return;
		}

		if ( $template = get_post_meta( $postId, Meta::TEMPLATE_TYPE, true ) ) {
			delete_option( Meta::TEMPLATE_ID . $template );
		}
	}

	public function post_row_actions_filter( $actions, $post ) {

		global $typenow;

		if ( $typenow !== Meta::POST_TYPE ) {
			return $actions;
		}

		if ( isset( $actions['edit_with_elementor'] ) ) {
			unset( $actions['edit_with_elementor'] );
		}

		if ( get_post_meta( $post->ID, Meta::EDIT_WITH, true ) == 'gutenberg' ) {
			$actions['usk_edit_with_gutenberg'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				add_query_arg( [ 'post' => $post->ID, 'action' => 'edit' ], admin_url( 'post.php' ) ),
				esc_html__( 'Edit with Gutenberg', 'ultimate-store-kit' )
			);

		}

		if ( get_post_meta( $post->ID, Meta::EDIT_WITH, true ) == 'elementor' ) {
			$actions['usk_edit_with_elementor'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				add_query_arg( 
					[ 
						'post' => $post->ID, 
						'action' => 'elementor', 
						'usk-template' => 1
					], 
					admin_url( 'post.php' ) 
				),
				esc_html__( 'Edit with Elementor', 'ultimate-store-kit' )
			);
		} else {
			// Always offer Elementor edit option regardless of stored preference
			$actions['usk_edit_with_elementor'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				add_query_arg( 
					[ 
						'post' => $post->ID, 
						'action' => 'elementor', 
						'usk-template' => 1 
					], 
					admin_url( 'post.php' ) 
				),
				esc_html__( 'Edit with Elementor', 'ultimate-store-kit' )
			);

		}

		$editActionLink = sprintf(
			'<a href="%1$s" data-id="%2$s" >%3$s</a>',
			'javascript:void(0)',
			$post->ID,
			esc_html__( 'Edit', 'ultimate-store-kit' )
		);

		if ( isset( $actions['edit'] ) && apply_filters( 'ultimate_store_kit_remove_action_edit_link', __return_true() ) ) {
			unset( $actions['edit'] );
		}

		return array_slice( $actions, 0, 1, true ) + [ 'usk-edit-action' => $editActionLink ] + array_slice( $actions, 1, null, true );
	}

	public function set_post_columns( $columns ) {
		return array_slice( $columns, 0, 2, true ) + [ 'template_type' => 'Type', 'is_enabled' => 'Status' ] + array_slice( $columns, 2, null, true );
	}

	public function set_custom_column_value( $column, $post_id ) {
		$templateType = get_post_meta(
			$post_id,
			Meta::TEMPLATE_TYPE,
			true
		);

		switch ( $column ) {
			case 'template_type':
				$postType = Builder_Template_Helper::getTemplatePostTypeByIndex( $templateType );
				$postTypeLabel = isset( $postType->name ) ? ' <strong>-- ' . ucwords( $postType->name ) . '</strong>' : '';
				echo Builder_Template_Helper::getTemplateByIndex( $templateType ) . $postTypeLabel;
				break;
			case 'is_enabled':
				echo ( Builder_Template_Helper::getTemplateId( $templateType ) == $post_id ? 'Active' : 'Inactive' );
				break;
		}
	}

	public function add_filter() {
		global $typenow;

		if ( $typenow !== Meta::POST_TYPE ) {
			return;
		}

		$selected = isset( $_GET['type'] ) ? sanitize_key( $_GET['type'] ) : '';
		?>
		<select name="type" id="type">
			<option value="all" <?php
			selected( 'all', $selected ); ?>><?php
			  esc_html_e(
			  	'Template Type ',
			  	'ultimate-store-kit'
			  ); ?></option>
			<?php
			$templates = Builder_Template_Helper::templateForSelectDropdown();
			// It is single
			if ( count( $templates ) == 1 ) {
				$templateKey = array_key_last( $templates );
				$template    = $templates[ $templateKey ];
				foreach ( $template as $key => $item ) :
					$selectValue = "{$templateKey}_$key";
					?>
					<option value="<?php
					echo esc_attr( $selectValue ) ?>"><?php
					  echo wp_kses_post( $item ) ?></option>
					<?php
				endforeach;
			}

			if ( count( $templates ) > 1 ) {
				foreach ( $templates as $keys => $items ) :
					$label = ucwords( str_replace(
						[ '-', '_' ],
						[ ' ' ],
						$keys
					) );
					if ( is_array( $items ) ) {
						?>
						<optgroup label="<?php
						echo esc_attr( $label ) ?>"><?php
						  foreach ( $items as $key => $item ) :
							  $itemValue = "{$keys}_$key"
							  	?>
								<option value="<?php
								echo esc_attr( $itemValue ) ?>" <?php
								  selected( $key, $selected ); ?>><?php
									echo wp_kses_post( $item ) ?></option>
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
		<?php
	}

	public function parse_query_filter( $query ) {
		global $pagenow, $typenow;

		if ( $typenow !== Meta::POST_TYPE ) {
			return;
		}

		if (
			'edit.php' == $pagenow
			&& isset( $_GET['type'] )
			&& $_GET['type'] != ''
			&& $_GET['type'] != 'all'
		) {
			$query->query_vars['meta_key']     = Meta::TEMPLATE_TYPE;
			$query->query_vars['meta_value']   = sanitize_key( $_GET['type'] );
			$query->query_vars['meta_compare'] = '=';
		}
	}


	public function create_builder_template() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'success' => false, 'errors_arr' => [ 'permission' => 'Permission denied' ] ], 403 );
		}

		parse_str( $_POST['data'], $data );

		if ( ! wp_verify_nonce( $data['nonce'], 'usk-builder' ) ) {
			wp_send_json_error( [ 'success' => false, 'errors_arr' => [ 'nonce' => 'Invalid nonce' ] ], 403 );
		}

		$templateId = isset( $data['template_id'] ) ? trim( $data['template_id'] ) : '';
		$name       = isset( $data['template_name'] ) ? trim( $data['template_name'] ) : '';
		$type       = isset( $data['template_type'] ) ? trim( $data['template_type'] ) : '';
		$editWith   = isset( $data['edit_with'] ) ? trim( $data['edit_with'] ) : 'elementor'; //gutenberg
		$isEnabled  = ( isset( $data['template_status'] ) && $data['template_status'] ) == 1 ? 1 : 0;

		$errors = [];

		if ( empty( $name ) ) {
			$errors['template_name'] = 'Field is required';
		}

		if ( empty( $type ) ) {
			$errors['template_type'] = 'Field is required';
		} else {
			if ( ! Builder_Template_Helper::getTemplateByIndex( $type ) ) {
				$errors['template_type'] = 'Invalid section';
			}
		}


		if ( count( $errors ) > 0 ) {
			wp_send_json_error( [ 'success' => false, 'errors_arr' => $errors ], 422 );
		}

		$page_data = [ 
			'post_status'    => 'publish',
			'post_type'      => Meta::POST_TYPE,
			'post_author'    => get_current_user_id(),
			'post_title'     => $name,
			'comment_status' => 'closed',
			'meta_input'     => [ 
				Meta::EDIT_WITH     => $editWith,
				Meta::TEMPLATE_TYPE => $type,
			],
		];

		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		$wp_rewrite->init();

		if ( $templateId ) {
			$page_data['ID'] = $templateId;
		}

		$post_id = wp_insert_post( $page_data );

		$enabledTemplate = strtolower( Meta::TEMPLATE_ID . $type );
		if ( $isEnabled == 1 ) {
			update_option( $enabledTemplate, $post_id );
		} else {
			if ( get_option( $enabledTemplate ) == $post_id ) {
				delete_option( $enabledTemplate );
			}
		}


		if ( $editWith == 'elementor' ) {
			if ( ! get_post_meta( $post_id, '_elementor_data' ) ) {
				update_post_meta( $post_id, '_elementor_data', [] );
			}

			if ( ! $templateId ) {
				update_post_meta( $post_id, '_elementor_data', [] );
			}
			update_post_meta( $post_id, '_wp_page_template', 'elementor_header_footer' );
			update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
			update_post_meta( $post_id, '_elementor_version', '3.7.1' );
		}

		if ( $templateId ) {
			$url = add_query_arg(
				[ 'post_type' => Meta::POST_TYPE ],
				admin_url( 'edit.php' )
			);
		} else {
			$url = add_query_arg( [ 
				'post'   => $post_id,
				'action' => $editWith,
			], admin_url( 'post.php' ) );
		}

		wp_send_json_success( [ 'success' => true, 'redirect' => $url ] );
	}

	public function get_builder_template_action() {
		if ( isset( $_REQUEST['template_id'] ) && ! empty( $_REQUEST['template_id'] ) ) {
			$templateId   = $_REQUEST['template_id'];
			$templateData = get_post( $templateId );

			if ( $templateData ) {
				$meta = get_post_meta( $templateData->ID );


				$templateType    = isset( $meta[ Meta::TEMPLATE_TYPE ][0] ) ? $meta[ Meta::TEMPLATE_TYPE ][0] : '';
				$enabledTemplate = strtolower( Meta::TEMPLATE_ID . $templateType );
				$enabledTemplate = get_option( $enabledTemplate );

				wp_send_json_success( [ 
					'id'     => $templateData->ID,
					'name'   => $templateData->post_title,
					'type'   => $templateType,
					'status' => is_numeric( $enabledTemplate ) ? 1 : 0,
				] );
			}
		}
	}

	public function add_modal_html( $hook_suffix ) {
		require_once 'modal/modal.php';
	}

	public function enqueue_scripts( $hook_suffix ) {
		if ( in_array( $hook_suffix, [ 'edit.php', 'post-new.php' ] ) ) {
			$screen = get_current_screen();

			if ( is_object( $screen ) && Meta::POST_TYPE == $screen->post_type ) {
				wp_enqueue_style( 'ultimate-store-kit-builder', BDTUSK_ADM_ASSETS_URL . 'css/usk-ultimate-builder.css', [], BDTUSK_VER );
				wp_enqueue_script( 'ultimate-store-kit-builder', BDTUSK_ADM_ASSETS_URL . 'js/ultimate-builder.min.js', [ 'jquery' ], BDTUSK_VER );
			}
		}
	}


	public function add_admin_menu() {
		add_submenu_page(
			'ultimate_store_kit_options',
			esc_html__( 'Template Builder', 'ultimate-store-kit' ),
			esc_html__( 'Template Builder', 'ultimate-store-kit' ),
			'manage_options',
			'edit.php?post_type=' . Meta::POST_TYPE
		);
	}

	public function registered_post_type() {
		$labels = [ 
			'name'               => _x( 'Template Items', 'post type general name', 'ultimate-store-kit' ),
			'singular_name'      => _x( 'Template Item', 'post type singular name', 'ultimate-store-kit' ),
			'menu_name'          => _x( 'Template Manager', 'admin menu', 'ultimate-store-kit' ),
			'name_admin_bar'     => _x( 'Template Manager', 'add new on admin bar', 'ultimate-store-kit' ),
			'add_new'            => _x( 'Add New', 'template_manager', 'ultimate-store-kit' ),
			'add_new_item'       => __( 'Add New Template', 'ultimate-store-kit' ),
			'new_item'           => __( 'New Template', 'ultimate-store-kit' ),
			'edit_item'          => __( 'Edit Template', 'ultimate-store-kit' ),
			'view_item'          => __( 'View Template', 'ultimate-store-kit' ),
			'all_items'          => __( 'All Templates', 'ultimate-store-kit' ),
			'search_items'       => __( 'Search Templates', 'ultimate-store-kit' ),
			'parent_item_colon'  => __( 'Parent Template:', 'ultimate-store-kit' ),
			'not_found'          => __( 'No Template found.', 'ultimate-store-kit' ),
			'not_found_in_trash' => __( 'No Template found in Trash.', 'ultimate-store-kit' ),
		];

		$args = [ 
			'labels'              => $labels,
			'description'         => __( 'Description.', 'ultimate-store-kit' ),
			'taxonomies'          => [],
			'hierarchical'        => false,
			'public'              => true,
			'show_in_menu'        => false,
			'show_ui'             => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'publicly_queryable'  => true,
			'supports'            => [ 'title', 'editor', 'elementor' ],
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => false,
			'show_in_nav_menus'   => false,
			'capability_type'     => 'post',
			//                'rest_base'            => $this->getPostType(),
			//			'register_meta_box_cb' => [ $this, 'register_meta_box_cb' ],
		];

		register_post_type( Meta::POST_TYPE, $args );

		// Fix WPML integration with Elementor
		if (function_exists('icl_object_id')) {
			add_filter('wpml_pb_elementor_get_data', [$this, 'fix_wpml_elementor_data'], 10, 2);
		}
	}

	/**
	 * Simple fix for WPML and Elementor integration
	 */
	public function fix_wpml_elementor_data() {
		if (isset($_REQUEST['post']) && get_post_type($_REQUEST['post']) === Meta::POST_TYPE) {
			$post_id = (int) $_REQUEST['post'];
			$meta_data = get_post_meta($post_id, '_elementor_data', true);
			
			// If metadata exists but is in array format, convert it to JSON string
			if (is_array($meta_data)) {
				update_post_meta($post_id, '_elementor_data', wp_json_encode($meta_data));
			}
		}
	}
}

Builder_Cpt::instance()->init_hooks();
