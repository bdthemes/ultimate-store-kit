# Ultimate Store Kit Builder Migration Notes

## Overview
Merged Ultimate Store Kit builder with Element Pack builder to use shared post type and compatible data structures.

## Changes Made

### 1. Post Type Migration
- **Old**: `usk-template-builder`
- **New**: `bdt-template-builder` (shared with Element Pack)
- Migration runs automatically on plugin init

### 2. Database Schema Changes

#### Post Meta Keys
- **USK meta**: `_ultimate_store_kit_template_type` (kept for backward compatibility)
- **EP meta**: `_bdthemes_builder_template_type` (now also set on USK templates)
- Both keys are maintained for cross-plugin compatibility

#### Options (Template Activation)
- **Old USK format**: `_usk_template_{type}` = `{post_id}` (single active per type)
- **New EP format**: `_bdthemes_builder_{type}__{post_id}` = `{post_id}` (multiple active per type)
- Migration converts old format to new format
- New templates created use EP format

### 3. Migration Process (`builder-integration.php`)

The migration runs once on `init` and includes:

1. **Post Type Migration**: Updates all `usk-template-builder` posts to `bdt-template-builder`

2. **Options Migration**: Converts all `_usk_template_{type}` options to `_bdthemes_builder_{type}__{post_id}` format

3. **Meta Migration**: Adds `_bdthemes_builder_template_type` meta to all USK templates that only have USK meta

4. **Migration Flag**: Sets `usk_builder_migration_v2_completed` option to prevent re-running

### 4. Template Creation (`builder-cpt.php`)

Updated `create_builder_template()` to:
- Use Element Pack option format: `_bdthemes_builder_{type}__{post_id}`
- Set both USK and EP meta keys for compatibility
- Maintain backward compatibility with existing code

### 5. Template Deletion (`builder-cpt.php`)

Updated `trashed_or_delete_post()` to:
- Check both USK and EP meta keys
- Delete both old and new option formats
- Ensure clean removal regardless of which plugin created the template

### 6. Admin Display (`builder-cpt.php`)

Updated `set_custom_column_value()` to:
- Display Element Pack templates with blue "EP" badge
- Check EP meta and options when USK meta is missing
- Show proper status for both plugin types
- Handle missing/invalid template types gracefully

## Compatibility

### When Both Plugins Installed
- Ultimate Store Kit admin shows both USK and EP templates
- Element Pack templates display with "EP" badge in USK admin
- Both plugins can activate/deactivate their own templates
- Template types and statuses display correctly for both

### When Only USK Installed
- All functionality works normally
- EP format is used for future compatibility
- Old USK templates are migrated automatically

### Backward Compatibility
- Old USK meta keys are preserved
- Old USK option format is kept (commented out deletion)
- Existing templates continue to work
- No data loss during migration

## Testing Checklist

- [ ] Old `usk-template-builder` posts migrate to `bdt-template-builder`
- [ ] Old `_usk_template_{type}` options convert to `_bdthemes_builder_{type}__{post_id}`
- [ ] USK templates show correct type and status in admin
- [ ] EP templates show with "EP" badge in USK admin
- [ ] New templates created use EP format
- [ ] Template activation/deactivation works for both types
- [ ] Template deletion cleans up all options
- [ ] Migration only runs once
- [ ] No errors in PHP error log

## Database Queries for Manual Verification

```sql
-- Check post types
SELECT post_type, COUNT(*) FROM wp_posts 
WHERE post_type IN ('usk-template-builder', 'bdt-template-builder') 
GROUP BY post_type;

-- Check template meta
SELECT post_id, meta_key, meta_value FROM wp_postmeta 
WHERE meta_key IN ('_ultimate_store_kit_template_type', '_bdthemes_builder_template_type')
ORDER BY post_id;

-- Check template options (old format)
SELECT option_name, option_value FROM wp_options 
WHERE option_name LIKE '_usk_template_%';

-- Check template options (new format)
SELECT option_name, option_value FROM wp_options 
WHERE option_name LIKE '_bdthemes_builder_%';

-- Check migration flag
SELECT option_value FROM wp_options 
WHERE option_name = 'usk_builder_migration_v2_completed';
```

## Rollback Plan

If issues occur, you can manually rollback:

1. Delete migration flag: `DELETE FROM wp_options WHERE option_name = 'usk_builder_migration_v2_completed';`
2. Revert post types: `UPDATE wp_posts SET post_type = 'usk-template-builder' WHERE post_type = 'bdt-template-builder' AND ID IN (SELECT post_id FROM wp_postmeta WHERE meta_key = '_ultimate_store_kit_template_type');`
3. Clear new options: `DELETE FROM wp_options WHERE option_name LIKE '_bdthemes_builder_%';`
4. Restore old code from version control

## Future Cleanup (After 1 Year)

Once confident all sites are migrated:
- Remove old USK meta key checks
- Delete old `_usk_template_` options
- Remove migration code
- Remove backward compatibility checks
