# Prefix compliance — WordPress.org review response

Working notes for the "Generic function/class/define/namespace/option names" rejection
(Review ID `SVN ultimate-store-kit/bdthemes/13Aug26/T2 5Sep26/4.3A3`).

Two parts: **what changed in this release**, and **the reply text for the reviewer**
covering the buckets that are false positives.

---

## Part 1 — What was fixed

### Reserved `_` prefix (the rule's explicit ban) — all clear

| Old | New |
|---|---|
| `_is_usk_pro_installed()` | `ultimate_store_kit_is_pro_installed()` |
| `_is_usk_pro_activated()` | `ultimate_store_kit_is_pro_activated()` |
| `_is_dep_plugin_installed()` | `ultimate_store_kit_is_dependency_plugin_installed()` |

Count of global functions on a reserved `_` prefix is now **0**.

### The `usk → 15` bucket — now **0**

**Deleted as dead code (5).** Each had exactly one occurrence in the whole tree — its own
definition — and zero references in Pro: `usk_get_order_options()`, `usk_get_taxonomies()`,
`usk_get_compare_products_count()`, `usk_has_variation_swatches_support()` (it tested a class
name Pro never declares, so it could never return true), and `usk_ajax_variation_image_update()`
with its `wp_ajax_` / `wp_ajax_nopriv_usk_get_variation_image` registrations — an
unauthenticated AJAX endpoint with no client anywhere in the plugin's JavaScript.

**Renamed (10).** All now carry `ultimate_store_kit_`. Six of them are called by Ultimate
Store Kit Pro, so Pro is updated in the same release; see Part 4. No back-compat aliases
remain, and **zero global `usk_*` functions exist in either plugin.**

### `_rss` / `_rss_failed`

`includes/Admin/Feeds.php` built its transient key by concatenation
(`$this->settings['transient_key'] . '_rss'`), so no scanner could attribute the prefix.
Both keys are now written as full literals, `bdthemes_product_feeds_rss` and
`bdthemes_product_feeds_rss_failed`. **The resolved strings are byte-identical to before,
so no cached data is orphaned.**

### `bdt` (3 characters)

`bdt-product-feed` → `ultimate-store-kit-product-feed` (`includes/Admin/Biggopties.php`).
A private admin stylesheet handle with no external consumer. This was also a live 4-way
handle collision with sibling plugins.

### `ultimate_store_` (15 chars) residues → `ultimate_store_kit_`

`ultimate_store_template_id_` and `ultimate_store_template_sample_post_` are now
`ultimate_store_kit_template_id_` / `ultimate_store_kit_template_sample_post_`.

Fixed in the same edit: both `set_transient()` calls passed **no expiry**, so WordPress
stored them autoloaded and they never expired — one permanent `wp_options` row per user
who ever opened the builder, one of them holding a serialised `WP_Query`. They now carry
an explicit `HOUR_IN_SECONDS` lifetime.

Sites upgrading will keep the old rows until swept:

```sql
DELETE FROM wp_options WHERE option_name LIKE '\_transient\_ultimate\_store\_template\_%';
DELETE FROM wp_options WHERE option_name LIKE '\_transient\_timeout\_ultimate\_store\_template\_%';
```

### `_usk_template_*` options — reserved `_` prefix on **options**

`Meta::TEMPLATE_ID` was `'_usk_template_'` and is concatenated into `get_option()` /
`update_option()` / `delete_option()` keys. The leading-underscore convention marks
**protected post meta**; it carries no meaning for options, so this was a real hit on the
rule. Now `ultimate_store_kit_template_`.

These options record which builder template is assigned to each template type, so a bare
rename would silently un-assign every shop, single, cart, checkout, account and blog
template with no error. Reads therefore go through `Meta::get_template_option()`, which
falls back to the legacy key, copies it forward and deletes the old row on first read.
Two former call sites built the key **without** `strtolower()` while four used it, so a
legacy site can hold two rows for one template in different cases; both spellings are
tried. Writes and deletes go through `Meta::update_template_option()` /
`Meta::delete_template_option()`, which also clear the legacy rows.

Verified against the database: seeding `_usk_template_product|shop = 4242` and reading
through the accessor returns 4242, creates `ultimate_store_kit_template_product|shop`, and
removes the legacy row. The mixed-case variant resolves to the same value.

### Other issues from the same review email

- **Invalid URL.** The dead `github.com/ihor-basov/toolslide` credit line was removed. A
  full sweep of all 126 readme URLs then found two more 404s of the same class:
  `bdthemes.com/support-new/` (now `/support/`) and `storekit.pro/demo/wishlist-products/`
  (now `/demo/wishlist-product/`). All readme URLs now resolve; `codecanyon.net`,
  `npmjs.com` and the `api.qrserver.com` endpoint return 403/400 to automated clients but
  are valid in a browser.
- **Out-of-date libraries.** DataTables is 3.0.3 and Tippy.js is 6.3.7, both current.
  Tippy carries no version banner, so it was identified by content hash against the
  official 6.3.7 UMD build rather than assumed. `assets/` had not been rebuilt from `src/`:
  the shipped `assets/vendor/js/datatables.js` was **0 bytes**, so Product Table was broken
  at runtime, and the shipped tippy was still the old build. Both regenerated with
  `npm run build`. The readme's version list was still declaring 1.10.21 / 6.3.1 and now
  matches what ships.
- **DataTables debug globals.** Upstream 3.0.3 ships a `// TODO debug` block assigning
  `window.classes` and `window.properties` — maximally generic globals, on every page with
  a Product Table. Nothing reads them, so they are stripped. **Re-apply after any future
  DataTables upgrade.**

### Verification performed

Both plugins lint clean across every non-vendor PHP file. No dangling references to any deleted
or renamed symbol. On a Pro-active install every renamed function resolves, every removed name is
gone, the Kit-settings and option migrations were exercised against the live database, the preview
bypass is blocked in all three attack shapes, and the home, shop, cart, my-account and
single-product pages return HTTP 200 with no fatals and exactly one quantity-button pair.

---

## Part 2 — Reply text for the reviewer (the false-positive buckets)

> These buckets are names the plugin **consumes** from WordPress, WooCommerce or Elementor
> core, or names the analyzer truncated. The plugin defines no global symbol on them.

**`woocommerce → 5`** — the plugin defines zero `woocommerce*` globals. The five are:
`woocommerce_locate_template` (a **class method** on the Mini Cart module, named after the
core filter it is hooked to, unreachable as a global function);
`woocommerce_ship_to_destination` and `woocommerce_cart_redirect_after_add` (read-only
`get_option()` calls on WooCommerce core options, so our widgets honour the store's own
settings); and `woocommerce-cart` / `woocommerce-cart-nonce` (a nonce action and field name
**defined by WooCommerce core** — `WC_Form_Handler::update_cart_action()` verifies these exact
strings, so our cart widget must emit them verbatim or Update Cart stops working).

**`single_product → 2`** — exactly two literals exist, both WooCommerce core filters we
re-fire from our quick-view gallery: `single_product_large_thumbnail_size` and
`single_product_small_thumbnail_size`. Our gallery is a drop-in replacement for WooCommerce's
single-product image template, so it must fire the core filters; renaming them would break
every theme and plugin that resizes WooCommerce gallery images. The same reasoning covers the
other WooCommerce core hooks our cart / checkout / order-received template replacements re-fire.

**`ultimate_store → 135`** — this is our own compliant prefix truncated at its second word.
The plugin's prefix is `ultimate_store_kit_` (19 characters), with 46 global functions on it,
alongside 117 files declaring the `UltimateStoreKit\` namespace and 42 Elementor widget
classes. We have not been able to reconcile the bucket to exactly 135 elements from the
information in the report; if the tool can list them we will address any genuine member.
The two names in this family that were genuinely short of our own prefix
(`ultimate_store_template_id_`, `ultimate_store_template_sample_post_`) have been renamed.

**`ultimatestorekit/wc → 1` and `ultimatestorekit/edd → 1`** — these are two filter tags,
`ultimatestorekit/wc_widget/{$widget_id}` and `ultimatestorekit/edd_widget/{$widget_id}`,
in `includes/ultimate-store-kit-filters.php`. The full tags carry the 16-character
`ultimatestorekit` prefix; only the reported fragment is short.

**`bdt / bdtusk → 27`** — `BDTUSK` is six characters and satisfies the rule. These are the
plugin's own constants (`BDTUSK_VER`, `BDTUSK_PATH`, `BDTUSK_ASSETS_URL`, and so on). The one
genuine three-character `bdt` member, the `bdt-product-feed` style handle, has been renamed.

**`_rss` / `_rss_failed`** — these were never whole names. They are the suffix fragments of
`bdthemes_product_feeds_rss`, which the code previously assembled by concatenation. Now
written as full literals so the prefix is visible to static analysis.

---

## Part 3 — Deliberately unchanged, and why

**`bdt_biggopti_dismissals` (option) and the `bdt-admin-biggopti-` key prefix.** Shared
intentionally across the BdThemes plugin family so dismissing a notice in one plugin
dismisses it everywhere. Every plugin writes the identical value shape. Renaming would
resurrect notices users already dismissed. Documented rather than changed.

**Elementor widget names (42, all `usk-*`) and the `usk-template-builder` post type.**
Persisted inside every page's `_elementor_data` as `widgetType`, and used as Elementor's
JS hook namespace. Renaming silently blanks every widget a customer has already placed.

**Cookie and user-meta keys** `_ultimate_store_kit_wishlist` and
`_ultimate_store_kit_compare_products`. A leading underscore on **post meta** is the
WordPress convention for protected meta, not a reserved plugin prefix; the names carry the
full plugin prefix after it. Renaming discards every customer's saved wishlist.

---

## Part 4 — Completed in the coordinated free + Pro release

Everything previously listed as outstanding is now done. **Both plugins must ship together.**

- **Deprecated `usk_*` aliases removed.** Pro now calls `ultimate_store_kit_license_validation()` and
  `ultimate_store_kit_get_compare_products()`. Zero global `usk_*` functions remain in either plugin.
- **Quantity-button duplication resolved.** Pro declared its own copies of four helpers and registered
  them by string. Pro's copies are deleted; the single implementation lives in free and Pro keeps only
  the `template_redirect` registration that applies the buttons site-wide. The existence check had to
  move to runtime: Pro loads *before* free, so a file-scope `function_exists()` would always have been
  false and the registration would have silently vanished. Verified: exactly one button pair renders.
  Free's `remove_all_actions()` was also replaced with targeted `remove_action()` calls — it had been
  stripping WooCommerce core's own handlers, including `woocommerce_output_all_notices`.
- **68 Elementor Kit control ids prefixed**, with a one-time migration of the Kit's stored settings.
  A read-side fallback alone was not enough: only nine of these are read in PHP, the rest are style
  controls whose CSS Elementor generates from the stored array. The migration matches by prefix so it
  also moves group-control derived keys (`_typography_font_size`) and responsive suffixes
  (`_tablet`, `_mobile`), then clears Elementor's CSS cache. Verified against the live Kit.
- **`preview_nonce` / `usk_template_id` renamed**, and the `'verified'` magic-string demo bypass
  **removed entirely** — this was the HIGH security finding. Preview now requires the real per-post
  nonce *and* `current_user_can('edit_post')`. Verified: the original attack, the attack with the new
  parameter names, and even a genuine nonce presented anonymously are all blocked. Pro's six account
  widgets keyed their demo content off the same attacker-suppliable URL parameter; they now use an
  explicit `ultimate_store_kit_pro/account/demo_mode` filter that only the demo site sets.
- **`bdt_usk_compare_products_page_id`** → `ultimate_store_kit_compare_products_page_id` via a shared
  accessor with migrate-on-read (Pro writes it, both read it). Transient `bdt_usk_biggopties_api`
  renamed outright. Pro's `bdt_usk_settings_section` and `bdt_usk_compare_products` ids prefixed.
- **Generic script/style handles prefixed** — `datatables`, `micromodal`, `popper`, `tippyjs`,
  `tippy`, `slick-modal`, `toolslide-js/css` all became `ultimate-store-kit-*` across both plugins
  (Pro consumed `micromodal` and the `slick-modal` style). Activation order no longer decides which
  DataTables build runs. **Bug fixed in passing:** Product Table declared `datatables` as a *style*
  dependency, but the plugin only ever registered it as a *script* — the widget was silently relying on
  Element Pack registering that stylesheet. The shipped `datatables.css` is now registered properly.

### Still deliberately unchanged

`bdt_biggopti_dismissals` and the `bdt-admin-biggopti-` key prefix stay as they are: they are shared
on purpose across the BdThemes family so dismissing a notice in one plugin dismisses it everywhere, and
every plugin writes the same value shape. Renaming would resurrect notices users already dismissed.
`usk-*` script handles and the 42 `usk-*` Elementor widget names also stay — widget names are
persisted as `widgetType` in every page's `_elementor_data`, so renaming blanks existing content.
