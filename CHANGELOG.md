# Changelog

All notable changes to the Helix3 framework in this repository are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

### Security — Helix3 Ajax plugin (`plugins/ajax/helix3`)

#### Authentication and authorization
- Require administrator privileges (`core.admin` or `core.manage` on `com_templates`) and a valid CSRF token for all admin AJAX actions: layout remove/save/load, menu layout reset, template settings import, Google font update, and font variant lookup.
- Require administrator privileges and a CSRF token for `upload_image` and `remove_image` endpoints.
- Require a valid CSRF token for the public `voting` action.
- Reject unknown `data.action` values with HTTP 403 before any handler runs (deny-by-default allowlist via `$adminActions` and `$publicActions`).
- Return structured JSON error responses for authorization and token failures via `sendJsonError()`.

#### Path traversal and file operations
- Sanitize layout file names with `sanitizeLayoutName()` (alphanumeric, hyphen, underscore only).
- Resolve layout file paths with `getLayoutFilePath()` using `realpath()` to prevent directory traversal.
- Constrain image deletion to the `images/` directory with `getSafeMediaImagePath()`, blocking `..`, null bytes, and paths outside the media root.
- Replace raw `unlink()` / `fopen()` layout operations with Joomla `File` and `Folder` APIs.

#### Input handling
- Read AJAX payload data through `$input->post->get('data', [], 'array')` instead of raw `$_POST`.
- Validate layout save payloads: 1 MB maximum size, valid JSON, and expected row/column structure via `isValidLayoutPayload()`.
- Validate template settings import: integer `template_id`, 1 MB maximum payload, JSON round-trip, and verification against `#__template_styles`.
- Cast menu IDs to integers for `resetLayout`.

#### Image upload and deletion
- Allow-list image extensions: `jpg`, `jpeg`, `png`, `gif`, `webp`.
- Validate uploads with `File::makeSafe()`, extension checks, and `@getimagesize()`.
- Enforce Joomla media and PHP upload size limits.
- Require `core.create` on `com_media` for uploads and `core.delete` on `com_media` for deletions.
- Remove hard-coded Google Fonts API key fallback; require the key from template parameters.

#### Cross-site scripting (XSS)
- Escape dynamic HTML output with `escape()` (`htmlspecialchars`) in layout builder, menu layout reset, font variant options, font update messages, and image upload responses.
- Sanitize layout setting attribute names in `getSettings()` before rendering `data-*` attributes.

#### Article voting
- Refactor voting into `processVote()` with layered abuse prevention:
  - One vote per article per session (`helix3.voted_articles`).
  - Rate limiting: maximum 5 votes per 60 seconds per session.
  - Verify the target article exists and is published before accepting a vote.
  - Use proxy-aware client IP detection via `Joomla\Utilities\IpHelper` with input fallback.
  - Block repeat votes from the same IP when a rating row already exists.
- Use parameterized database queries with integer casting and quoted IP values.

#### Error handling and stability
- Guard missing menu items with `getMenuItemTitle()` to avoid null reference errors when rendering menu layout HTML.
- Verify the active template style exists before running layout and import handlers.

### Changed — Helix3 Ajax image helper (`plugins/ajax/helix3/classes/image.php`)
- Add WebP support in thumbnail generation when the PHP GD extension provides WebP functions.

### Added — Tests
- Add `tests/helix3_hardening_test.php` to verify security controls are present in the Ajax plugin and image helper, including allowlists, auth guards, path constraints, payload validation, voting hardening, and output escaping.
