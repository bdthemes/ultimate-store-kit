<?php

namespace UltimateStoreKit\Admin;

use UltimateStoreKit\Base\Singleton;

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Class Feeds
 */
class Feeds {
	use Singleton;
	private $settings;

	/**
	 * Max seconds to wait for a remote feed. Kept short so a slow or dead
	 * endpoint can never stall the admin dashboard into a gateway timeout.
	 */
	const REQUEST_TIMEOUT = 5;

	/**
	 * How long to skip remote requests after a failure.
	 */
	const FAILURE_BACKOFF = HOUR_IN_SECONDS;

	/**
	 * Static variable to track if the feed has been displayed
	 */
	private static $feed_displayed = false;

	/**
	 * Feeds constructor.
	 */
	public function __construct($settings = null) {
		$this->settings = $settings ?: [
			'feed_title'       => 'BdThemes News & Updates',
			'transient_key'    => 'bdthemes_product_feeds',
			'feed_link'        => 'https://bdthemes.com/feed',
			'remote_feed_link' => 'https://dashboard.bdthemes.io/wp-json/bdthemes/v1/product-feed/?product_category=element-pack',
			'text_domain'      => 'ultimate-store-kit',
			'footer_links'     => [
				[
					'url'   => 'https://bdthemes.com/blog/',
					'title' => 'Blog',
				],
				[
					'url'   => 'https://bdthemes.com/knowledge-base/',
					'title' => 'Docs',
				],
				[
					'url'   => 'https://store.bdthemes.com/',
					'title' => 'Get Pro',
				],
				[
					'url'   => 'https://feedback.elementpack.pro/announcements/',
					'title' => 'Changelog',
				],
			],
		];
		add_action('wp_dashboard_setup', [$this, 'register_rss_feeds']);
	}

	/**
	 * Register RSS Feeds for Element Pack
	 */
	public function register_rss_feeds() {
		if (self::$feed_displayed) {
			/**
			 * If the feed has already been displayed, do not add it again
			 */
			return;
		}

		wp_add_dashboard_widget(
			'bdt-dashboard-overview',
			esc_html($this->settings['feed_title']),
			[$this, 'display_rss_feeds_content'],
			null,
			null,
			'column4',
			'core'
		);

		/**
		 * Mark the feed as displayed
		 */
		self::$feed_displayed = true;
	}

	/**
	 * Display RSS Feeds Content
	 */
	public function display_rss_feeds_content() {
		$feeds = $this->get_remote_feeds_data();
		if (is_array($feeds)) {
			foreach ($feeds as $feed) {
				if (! is_object($feed)) {
					continue;
				}

				$demo_link = isset($feed->demo_link) ? $feed->demo_link : '';
				$image     = isset($feed->image) ? $feed->image : '';
				$content   = isset($feed->content) ? $feed->content : '';
?>
				<div class="activity-block">
					<a href="<?php echo esc_url($demo_link); ?>" target="_blank" style="margin-bottom:10px; display: inline-block;">
						<img src="<?php echo esc_url($image); ?>" style="width:100%;min-height:240px;">
					</a>
					<p>
						<?php echo wp_kses_post(wp_trim_words(wp_strip_all_tags($content), 50)); ?>
						<a href="<?php echo esc_url($demo_link); ?>" target="_blank">
							<?php esc_html_e('Learn more...', 'ultimate-store-kit'); ?>
						</a>
					</p>
				</div>
		<?php
			}
		}
		echo wp_kses_post($this->get_rss_posts_data());
	}

	/**
	 * Get Remote Feeds Data
	 *
	 * @return array|mixed
	 */
	private function get_remote_feeds_data() {
		$transient_key = $this->settings['transient_key'];
		$cached_data   = get_transient($transient_key);

		if (! empty($cached_data)) {
			$decoded = json_decode($cached_data);
			return is_array($decoded) ? $decoded : [];
		}

		/**
		 * A recent request already failed, so don't block the dashboard again.
		 * Serve the last known good response until the backoff expires.
		 */
		if (get_transient($transient_key . '_failed')) {
			return $this->get_fallback_feeds_data();
		}

		$response = wp_remote_get(
			$this->settings['remote_feed_link'],
			array(
				'timeout' => self::REQUEST_TIMEOUT,
				'headers' => array(
					'Accept' => 'application/json',
				),
			)
		);

		if (is_wp_error($response) || 200 !== (int) wp_remote_retrieve_response_code($response)) {
			set_transient($transient_key . '_failed', 1, self::FAILURE_BACKOFF);
			return $this->get_fallback_feeds_data();
		}

		$response_body = wp_remote_retrieve_body($response);
		$decoded       = json_decode($response_body);

		if (! is_array($decoded)) {
			set_transient($transient_key . '_failed', 1, self::FAILURE_BACKOFF);
			return $this->get_fallback_feeds_data();
		}

		set_transient($transient_key, $response_body, 6 * HOUR_IN_SECONDS);

		/**
		 * Keep a copy outside the transient so the widget still has something
		 * to show while the remote endpoint is unreachable.
		 */
		update_option($transient_key . '_fallback', $response_body, false);

		return $decoded;
	}

	/**
	 * Get the last successfully fetched feeds, if any.
	 *
	 * @return array
	 */
	private function get_fallback_feeds_data() {
		$fallback = get_option($this->settings['transient_key'] . '_fallback');

		if (empty($fallback)) {
			return [];
		}

		$decoded = json_decode($fallback);

		return is_array($decoded) ? $decoded : [];
	}

	/**
	 * Get RSS Posts Data
	 *
	 * @return string
	 */
	private function get_rss_posts_data() {
		$transient_key = $this->settings['transient_key'] . '_rss';
		$cached_data   = get_transient($transient_key);

		if (! empty($cached_data)) {
			/**
			 * Decode as associative array
			 */
			$rss_items = json_decode($cached_data, true);

			if (! is_array($rss_items)) {
				$rss_items = [];
			}
		} elseif (get_transient($transient_key . '_failed')) {
			/**
			 * A recent fetch failed, so skip the blocking request entirely.
			 */
			$rss_items = [];
		} else {
			include_once ABSPATH . WPINC . '/feed.php';

			add_action('wp_feed_options', [$this, 'set_feed_timeout']);
			$rss = fetch_feed($this->settings['feed_link']);
			remove_action('wp_feed_options', [$this, 'set_feed_timeout']);

			if (is_wp_error($rss)) {
				set_transient($transient_key . '_failed', 1, self::FAILURE_BACKOFF);
				return '<li>' . esc_html__('Items Not Found', 'ultimate-store-kit') . '.</li>';
			}

			$maxitems  = $rss->get_item_quantity(5);
			$rss_items = $rss->get_items(0, $maxitems);

			/**
			 * Convert RSS items to a simpler array to avoid serialization issues
			 */
			$simplified_rss_items = array_map(function ($item) {
				return [
					'title'   => $item->get_title(),
					'link'    => $item->get_permalink(),
					'date'    => $item->get_date('U'),
					'content' => $item->get_content(),
				];
			}, $rss_items);

			set_transient($transient_key, json_encode($simplified_rss_items), 6 * HOUR_IN_SECONDS);
			$rss_items = $simplified_rss_items;
		}

		ob_start();
		?>
		<div class="bdt-widget">
			<ul>
				<?php if (empty($rss_items)) : ?>
					<li><?php esc_html_e('Items Not Found', $this->settings['text_domain']); ?>.</li>
				<?php else : ?>
					<?php foreach ($rss_items as $item) : ?>
						<li>
							<a target="_blank" href="<?php echo esc_url($item['link']); ?>"
								title="<?php echo esc_html($item['date']); ?>">
								<?php if ($this->is_feed_item_new($item['date'])) : ?>
									<span class="bdt-feed-badge bdt-feed-badge--new"><?php esc_html_e('New', $this->settings['text_domain']); ?></span>
								<?php endif; ?>
								<?php echo esc_html($item['title']); ?>
							</a>
							<span class="bdt-date" style="display: block; margin: 0;">
								<?php echo esc_html(human_time_diff($item['date'], current_time('timestamp')) . ' ' . __('ago', $this->settings['text_domain'])); ?>
							</span>
							<div class="bdt-summary">
								<?php echo esc_html(wp_html_excerpt($item['content'], 120) . ' [...]'); ?>
							</div>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<p class="community-events-footer" style="margin: 12px -12px 6px -12px; padding: 12px 12px 0px;">
			<?php
			foreach ($this->settings['footer_links'] as $link) {
				printf(
					'<a href="%s" target="_blank">%s <span class="screen-reader-text"> (opens in a new tab)</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>',
					esc_url($link['url']),
					esc_html($link['title'])
				);

				if (next($this->settings['footer_links'])) {
					echo ' | ';
				}
			}
			?>
		</p>
<?php
		return ob_get_clean();
	}

	/**
	 * Keep SimplePie's socket timeout in line with our own limit.
	 *
	 * @param object $feed SimplePie instance.
	 * @return void
	 */
	public function set_feed_timeout($feed) {
		$feed->set_timeout(self::REQUEST_TIMEOUT);
	}

	/**
	 * Check if a feed item is "new" (published within the last 7 days).
	 *
	 * @param int|string $date Unix timestamp.
	 * @return bool
	 */
	private function is_feed_item_new($date) {
		$timestamp = is_numeric($date) ? (int) $date : strtotime($date);
		if (! $timestamp) {
			return false;
		}
		$cutoff = time() - (7 * DAY_IN_SECONDS);
		return $timestamp >= $cutoff;
	}
}
