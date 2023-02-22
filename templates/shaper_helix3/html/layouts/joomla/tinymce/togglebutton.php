<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$name = $displayData;
?>
<div class="toggle-editor btn-toolbar float-end clearfix mt-3">
	<div class="btn-group">
		<?php if (JVERSION < 4) : ?>
			<button type="button" class="btn btn-secondary" onclick="tinyMCE.execCommand('mceToggleEditor', false, '<?php echo $name; ?>');return false;" title="<?php echo Text::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>">
		<?php else : ?>
			<button type="button" disabled class="btn btn-secondary js-tiny-toggler-button">
		<?php endif; ?>
			<span class="icon-eye" aria-hidden="true"></span>
			<?php echo Text::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>
		</button>
	</div>
</div>