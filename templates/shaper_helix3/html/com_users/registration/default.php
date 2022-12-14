<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
?>
<div class="row justify-content-center">
	<div class="col-lg-4">
		<div class="registration<?php echo $this->pageclass_sfx?>">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
			<?php endif; ?>

			<form id="member-registration" action="<?php echo Route::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">

				<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
					<?php $fields = $this->form->getFieldset($fieldset->name);?>
					<?php if (count($fields)):?>
						<?php foreach ($fields as $field) :// Iterate through the fields in the set and display them.?>
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
								<div class="mb-3">
									<?php echo $field->label; ?>
									<?php if (!$field->required && $field->type != 'Spacer') : ?>
										<span class="optional"><?php echo Text::_('COM_USERS_OPTIONAL');?></span>
									<?php endif; ?>
									
									<?php echo $field->input; ?>
								</div>
							<?php endif;?>
						<?php endforeach;?>
					<?php endif;?>
				<?php endforeach;?>

				<div class="form-group">
					<button type="submit" class="btn btn-primary validate"><?php echo Text::_('JREGISTER');?></button>
					<a class="btn btn-danger" href="<?php echo Route::_('');?>" title="<?php echo Text::_('JCANCEL');?>"><?php echo Text::_('JCANCEL');?></a>
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="registration.register" />
				</div>
				<?php echo HTMLHelper::_('form.token');?>
			</form>
		</div>
	</div>
</div>
