<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$canEdit = $displayData['params']->get('access-edit');
$articleId = $displayData['item']->id;
?>

<?php if (JVERSION >= 4) : ?>
	<?php if($canEdit) : ?>
		<div class="icons">
			<div class="float-end">
				<div>
					<?php echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params']); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php else: ?>
	<div class="icons">
		<?php if (empty($displayData['print'])) : ?>
			<?php if ($canEdit || ($displayData['params']->get('show_print_icon')) || $displayData['params']->get('show_email_icon')) : ?>
				<div class="btn-group pull-right">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						<span class="icon-cog" aria-hidden="true"></span>
						<span class="caret" aria-hidden="true"></span>
					</button>
					<?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
					<ul class="dropdown-menu">
						<?php if ($displayData['params']->get('show_print_icon')) : ?>
							<li class="print-icon dropdown-item"> <?php echo HTMLHelper::_('icon.print_popup', $displayData['item'], $displayData['params']); ?> </li>
						<?php endif; ?>
						<?php if ($displayData['params']->get('show_email_icon')) : ?>
							<li class="email-icon dropdown-item"> <?php echo HTMLHelper::_('icon.email', $displayData['item'], $displayData['params']); ?> </li>
						<?php endif; ?>
						<?php if ($canEdit) : ?>
							<li class="edit-icon dropdown-item"> <?php echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params']); ?> </li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="pull-right">
				<?php echo HTMLHelper::_('icon.print_screen', $displayData['item'], $displayData['params']); ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
