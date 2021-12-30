<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$buttons = $displayData;

// Load modal popup behavior
JHtml::_('behavior.modal', 'a.modal-button');
?>
<div id="editor-xtd-buttons" class="float-start">
	<?php if ($buttons) : ?>
		<?php foreach ($buttons as $button) : ?>
			<?php echo JLayoutHelper::render('joomla.editors.buttons.button', $button); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>