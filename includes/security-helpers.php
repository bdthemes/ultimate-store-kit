<?php
/**
 * Small helpers that guard widget-controlled and visitor-supplied input.
 *
 * Widget settings are saved verbatim by Elementor: a SELECT setting holds whatever
 * was sent to the save endpoint, and text saved by users without unfiltered_html only
 * goes through kses. Widget output is also part of the_content, so core runs
 * do_shortcode() on it afterwards. These helpers cover the places where such values
 * reach markup, a query, or the shortcode parser.
 *
 * Ultimate Store Kit Pro supports older versions of this plugin, so it ships its own
 * copies instead of relying on these.
 *
 * @package UltimateStoreKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- ultimate_store_kit_ is this plugin's established public prefix.

if ( ! function_exists( 'ultimate_store_kit_escape_shortcode_brackets' ) ) {
	/**
	 * Turn the square brackets in visitor-supplied text into HTML entities.
	 *
	 * Elementor output is part of the_content, and core runs do_shortcode() on it
	 * afterwards, including inside quoted attribute values. Text written by visitors
	 * or customers (a product review, its author name, an order note) that is printed
	 * into that output must therefore not keep a literal [ or ], or the writer can
	 * run any registered shortcode on the page. The entities display as the same
	 * characters, and esc_attr()/esc_html() leave them as they are.
	 *
	 * @param string $text Visitor-supplied text.
	 * @return string
	 */
	function ultimate_store_kit_escape_shortcode_brackets( $text ) {
		return str_replace( [ '[', ']' ], [ '&#91;', '&#93;' ], (string) $text );
	}
}

if ( ! function_exists( 'ultimate_store_kit_document_author_can' ) ) {
	/**
	 * Whether the author of the Elementor document being rendered has a capability.
	 *
	 * Widget settings are chosen by whoever edits the document, but rendered for
	 * whoever views it, so a setting that widens what a query returns is honoured
	 * only when the document's author could see that data anyway.
	 *
	 * @param string $capability Capability name.
	 * @return bool
	 */
	function ultimate_store_kit_document_author_can( $capability ) {
		if ( ! class_exists( '\Elementor\Plugin' ) || empty( \Elementor\Plugin::$instance->documents ) ) {
			return false;
		}

		$document = \Elementor\Plugin::$instance->documents->get_current();

		if ( ! $document ) {
			return false;
		}

		$post_id   = (int) $document->get_main_id();
		$author_id = $post_id ? (int) get_post_field( 'post_author', $post_id ) : 0;

		return $author_id > 0 && user_can( $author_id, $capability );
	}
}

if ( ! function_exists( 'ultimate_store_kit_review_query_status' ) ) {
	/**
	 * The comment status a product review widget may query.
	 *
	 * The widgets offer "Hold" and "All" next to "Approve", and the value is saved
	 * verbatim (any string WP_Comment_Query accepts, "spam" and "trash" included).
	 * Reviews that are not approved are the moderation queue: their text, author
	 * names and e-mail based avatars are not public. They are listed only when the
	 * viewer, or the author of the page, may moderate comments; everyone else gets
	 * the approved reviews.
	 *
	 * @param mixed $status Saved "Status" setting.
	 * @return string
	 */
	function ultimate_store_kit_review_query_status( $status ) {
		if ( in_array( $status, [ 'hold', 'all' ], true )
			&& ( current_user_can( 'moderate_comments' ) || ultimate_store_kit_document_author_can( 'moderate_comments' ) ) ) {
			return $status;
		}

		return 'approve';
	}
}
