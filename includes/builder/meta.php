<?php

namespace UltimateStoreKit\Includes\Builder;

if (! defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

use UltimateStoreKit\Base\Singleton;

class Meta {

	use Singleton;

	const POST_TYPE = 'usk-template-builder';

	const EDIT_WITH = '_ultimate_store_kit_edit_with';

	const TEMPLATE_TYPE = '_ultimate_store_kit_template_type';

	/**
	 * Prefix for the wp_options keys that record which builder template is
	 * assigned to each template type.
	 *
	 * These are options, not post meta, so the leading-underscore "protected"
	 * convention does not apply and a reserved "_" prefix is not permitted.
	 */
	const TEMPLATE_ID = 'ultimate_store_kit_template_';

	/**
	 * The pre-3.1.2 prefix. Still read so existing sites keep their assigned
	 * templates; see Meta::get_template_option().
	 */
	const TEMPLATE_ID_LEGACY = '_usk_template_';

	/**
	 * Read a template-assignment option, migrating it forward from the legacy
	 * "_usk_template_" key the first time it is seen.
	 *
	 * Historically some call sites lowercased the key and others did not, so a
	 * legacy site can hold two rows for the same template in different cases.
	 * Both spellings are tried before giving up.
	 *
	 * @param string $suffix Template type, e.g. "product|shop".
	 * @return mixed Option value, or false when unset.
	 */
	public static function get_template_option($suffix) {
		$key   = strtolower(self::TEMPLATE_ID . $suffix);
		$value = get_option($key, null);

		if (null !== $value) {
			return $value;
		}

		foreach ([self::TEMPLATE_ID_LEGACY . $suffix, strtolower(self::TEMPLATE_ID_LEGACY . $suffix)] as $legacy_key) {
			$legacy = get_option($legacy_key, null);

			if (null !== $legacy) {
				update_option($key, $legacy);
				delete_option($legacy_key);
				return $legacy;
			}
		}

		return false;
	}

	/**
	 * Write a template-assignment option, clearing any legacy row.
	 *
	 * @param string $suffix Template type.
	 * @param mixed  $value  Template post ID.
	 * @return void
	 */
	public static function update_template_option($suffix, $value) {
		update_option(strtolower(self::TEMPLATE_ID . $suffix), $value);
		self::delete_legacy_template_option($suffix);
	}

	/**
	 * Delete a template-assignment option in both the current and legacy keys.
	 *
	 * @param string $suffix Template type.
	 * @return void
	 */
	public static function delete_template_option($suffix) {
		delete_option(strtolower(self::TEMPLATE_ID . $suffix));
		self::delete_legacy_template_option($suffix);
	}

	/**
	 * @param string $suffix Template type.
	 * @return void
	 */
	private static function delete_legacy_template_option($suffix) {
		delete_option(self::TEMPLATE_ID_LEGACY . $suffix);
		delete_option(strtolower(self::TEMPLATE_ID_LEGACY . $suffix));
	}
}
