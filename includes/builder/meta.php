<?php

namespace UltimateStoreKit\Includes\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

use UltimateStoreKit\Includes\Builder\Builder_Template_Helper;
use \UltimateStoreKit\Base\Singleton;

class Meta {

	use Singleton;

	const POST_TYPE = 'usk-template-builder';

	const EDIT_WITH = '_ultimate_store_kit_edit_with';

	const TEMPLATE_TYPE = '_ultimate_store_kit_template_type';

	const TEMPLATE_ID = '_usk_template_';

	const SAMPLE_POST_ID = 'sample_post_id';
}
