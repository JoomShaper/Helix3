<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

$buttons = $displayData;

if (version_compare(JVERSION, '4.0.0', '<'))
{
	// Load modal popup behavior
	HTMLHelper::_('behavior.modal', 'a.modal-button');
}

?>
<div id="editor-xtd-buttons" class="float-start">
	<?php if ($buttons) : ?>
		<?php foreach ($buttons as $button) : ?>
			<?php echo LayoutHelper::render('joomla.editors.buttons.button', $button); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>