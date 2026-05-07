## ADR-001: Theme Options Plugin — Custom Code Fields

**Date:** 2026-05-06
**Decision:** ACF options page created via ACF UI (ACF PRO 6.x native feature).
Plugin registers Custom Code field group programmatically via acf_add_local_field_group()
so it is version-controlled without relying on ACF JSON sync for this specific group.
**Reason:** Options page data must persist across theme switches. Plugin owns the
output hooks (wp_head, wp_footer) independently of the active theme.
**Trade-off:** Plugin must be active for Custom Code fields to appear.