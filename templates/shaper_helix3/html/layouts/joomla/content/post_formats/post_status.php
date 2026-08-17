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

    $post_status = $displayData['params']->get('post_status');
    if (empty($post_status)) {
        $post_status = $attribs->post_status ?? '';
    }
?>

<?php if (!empty($post_status)): ?>
	<div class="entry-status">
		<?php echo $post_status; ?>
	</div>
<?php endif; ?>