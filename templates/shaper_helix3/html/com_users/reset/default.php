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
		<div class="reset<?php echo $this->pageclass_sfx?>">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<h1>
					<?php echo $this->escape($this->params->get('page_heading')); ?>
				</h1>
			<?php endif; ?>

			<form id="user-registration" action="<?php echo Route::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate">
				<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
					<p><?php echo Text::_($fieldset->label); ?></p>
					<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
						<div class="mb-3">
							<?php echo $field->label; ?>
							<?php echo $field->input; ?>
						</div>
					<?php endforeach; ?>
				<?php endforeach; ?>

				<div class="form-group">
					<button type="submit" class="btn btn-primary validate"><?php echo Text::_('JSUBMIT'); ?></button>
				</div>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
