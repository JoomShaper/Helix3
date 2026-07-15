# Helix3

[![Join the chat at https://gitter.im/JoomShaper/Helix3](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/JoomShaper/Helix3?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

**Helix3** is a user-friendly, modern, highly customizable and easy to integrate solution to build your custom Joomla 3+ website. For users installing Helix3 for the first time on a site, we have nice surprise all advanced template settings are already here. Helix3 isn’t just a template or a plugin, it’s a complete **Joomla 3+ template framework.**

#### Most Powerful Features:
- Modern Design  (2016 web trends inlcuded)
- Flexibility & Fully Responsive Template
- Font Awesome 4.6.3 ( over 675+ Icons) also for menu items
- MegaMenu Generator
- Off-Canvas Menu & MegaMenu
- Article Post Formats
- Desktop,  Mobile and Retina logo option
- Advanced Typography Options - Google Fonts with update button
- Layout Manager
- Custom Layout options in Layout Builder
- Bootstrap 3.3.7
- Cross-Browser Support
and much more.

> As one of our customer Puskás Attila Barna said "Helix3 and Menu Builder with SP Page Builder is one powerfull tools pack for the Joomla CMS Developers!

See more at: http://www.joomshaper.com/joomla-templates/helix3

---

## Joomla 3 EOL Security Release Process

For backporting critical security fixes to the Joomla 3 EOL line of Helix3:

1. **Security Branch**: All development and security patches for Joomla 3 must be committed to the `security/helix3-j3-eol-patch` branch. This branch is dedicated to all Joomla 3 EOL security releases.
2. **Release Tags**: Releases are triggered by tagging a commit on this branch with a tag matching the pattern `j3-security-v*` (e.g., `j3-security-v1.0.0`).
3. **Automated Publishing**:
   - The GitHub Actions workflow in `.github/workflows/release.yml` triggers automatically on pushing tags matching `j3-security-v*`.
   - It automatically runs Gulp packaging and NPM build scripts, creates a GitHub Release, and uploads all generated ZIP packages (both component files and the patch package) as assets to the release.
4. **Update Server**: The update server manifest is located at `pkg_helix3_j3_security_patch/helix3j3securitypatch_update.xml` and is referenced by extensions to receive the latest EOL security patches.

