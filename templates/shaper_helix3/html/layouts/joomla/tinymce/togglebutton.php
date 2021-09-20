<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2020 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$name = $displayData;

?>
<div class="toggle-editor btn-toolbar pull-right clearfix">
	<a class="btn btn-default" href="#"
		onclick="tinyMCE.execCommand('mceToggleEditor', false, '<?php echo $name; ?>');return false;"
		title="<?php echo JText::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>"
	>
		<i class="fa fa-eye"></i> <?php echo JText::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>
	</a>
</div>