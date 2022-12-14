<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_mailto
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Router;
use Joomla\CMS\Uri\Uri;


HTMLHelper::_('behavior.core');
HTMLHelper::_('behavior.keepalive');

$data	= $this->get('data');

Factory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(pressbutton)
	{
		var form = document.getElementById('mailtoForm');

		// do field validation
		if (form.mailto.value == '' || form.from.value == '')
		{
			alert('" . Text::_('COM_MAILTO_EMAIL_ERR_NOINFO') . "');
			return false;
		}
		form.submit();
	}
");

?>

<div id="mailto-window" class="p-4">
	<h2>
		<?php echo Text::_('COM_MAILTO_EMAIL_TO_A_FRIEND'); ?>
	</h2>
	
	<?php if(version_compare(JVERSION, '3.8.8', 'ge')) { ?>
	<form action="<?php echo Router::_('index.php?option=com_mailto&task=send'); ?>" method="post" class="form-validate">
		<fieldset>
			<?php foreach ($this->form->getFieldset('') as $field) : ?>
				<?php if (!$field->hidden) : ?>
					<?php echo $field->renderField(); ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="control-group mb-3">
				<button type="submit" class="btn btn-success validate">
					<?php echo Text::_('COM_MAILTO_SEND'); ?>
				</button>
				<button type="button" class="btn btn-danger" onclick="window.close();return false;">
					<?php echo Text::_('COM_MAILTO_CANCEL'); ?>
				</button>
			</div>
		</fieldset>
		<input type="hidden" name="layout" value="<?php echo htmlspecialchars($this->getLayout(), ENT_COMPAT, 'UTF-8'); ?>" />
		<input type="hidden" name="option" value="com_mailto" />
		<input type="hidden" name="task" value="send" />
		<input type="hidden" name="tmpl" value="component" />
		<input type="hidden" name="link" value="<?php echo $this->link; ?>" />
		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
	<?php } else {?>
		<form action="<?php echo Uri::base() ?>index.php" id="mailtoForm" method="post">

			<div class="control-group mb-3">
				<label for="mailto_field" class="control-label"><?php echo Text::_('COM_MAILTO_SENDER'); ?></label>
				<input type="text" id="mailto_field" class="form-control" name="mailto" value="<?php echo $this->escape($data->mailto); ?>">
			</div>

			<div class="control-group mb-3">
				<label for="sender_field" class="control-label"><?php echo Text::_('COM_MAILTO_EMAIL_TO'); ?></label>
				<input type="text" id="sender_field" class="form-control" name="sender" value="<?php echo $this->escape($data->sender); ?>">
			</div>

			<div class="control-group mb-3">
				<label for="from_field" class="control-label"><?php echo Text::_('COM_MAILTO_YOUR_EMAIL'); ?></label>
				<input type="text" id="from_field" class="form-control" name="from" value="<?php echo $this->escape($data->from); ?>">
			</div>

			<div class="control-group mb-3">
				<label for="subject_field" class="control-label"><?php echo Text::_('COM_MAILTO_SUBJECT'); ?></label>
				<input type="text" id="subject_field" class="form-control" name="subject" value="<?php echo $this->escape($data->subject); ?>">
			</div>

			<div class="control-group mb-3">
				<button class="btn btn-success" onclick="return Joomla.submitbutton('send');">
					<?php echo Text::_('COM_MAILTO_SEND'); ?>
				</button>
				<button class="btn btn-danger" onclick="window.close();return false;">
					<?php echo Text::_('COM_MAILTO_CANCEL'); ?>
				</button>
			</div>

			<input type="hidden" name="layout" value="<?php echo $this->getLayout();?>" />
			<input type="hidden" name="option" value="com_mailto" />
			<input type="hidden" name="task" value="send" />
			<input type="hidden" name="tmpl" value="component" />
			<input type="hidden" name="link" value="<?php echo $data->link; ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</form>
	<?php } ?>
</div>