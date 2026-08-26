<?php
    /**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2026 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

    defined('JPATH_BASE') or die;

    $attribs = $displayData['item']->attribs ?? null;
    $attribs = is_string($attribs) ? json_decode($attribs) : $attribs;

    $link_url = $displayData['params']->get('link_url');
    if (empty($link_url)) {
        $link_url = $attribs->link_url ?? '';
    }

    $link_title = $displayData['params']->get('link_title');
    if (empty($link_title)) {
        $link_title = $attribs->link_title ?? '';
    }
    $link_title = !empty($link_title) ? $link_title : $link_url;
?>

<?php if (!empty($link_url)): ?>
	<div class="entry-link">
		<a target="_blank" href="<?php echo $link_url; ?>"><h4><?php echo $link_title; ?></h4></a>
	</div>
<?php endif; ?>