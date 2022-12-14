<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('bootstrap.tooltip');

$lang = Factory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();

?>
<form id="searchForm" action="<?php echo Route::_('index.php?option=com_search'); ?>" method="post">
	<div class="input-group mb-3">
		<input type="text" name="searchword" title="<?php echo Text::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" placeholder="<?php echo Text::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="form-control" />
		<button name="Search" onclick="this.form.submit()" class="btn btn-primary" title="<?php echo HTMLHelper::_('tooltipText', 'COM_SEARCH_SEARCH');?>">
			<span class="icon-search"></span>
			<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>
		</button>
	</div>

	<input type="hidden" name="task" value="search" />

	<div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
		<?php if (!empty($this->searchword)) : ?>
			<p>
				<?php echo Text::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', '<span class="badge badge-info">' . $this->total . '</span>'); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php if ($this->params->get('search_phrases', 1) || $this->params->get('search_areas', 1)) : ?>
		<div class="mb-3">
			<div class="row">
				<?php if($this->params->get('search_phrases', 1)) : ?>
					<div class="col-lg-5">
						<div class="phrases-box d-flex">
							<strong class="me-3"><?php echo Text::_('COM_SEARCH_FOR'); ?></strong>
							<?php echo $this->lists['searchphrase']; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($this->params->get('search_areas', 1)) : ?>
					<div class="col-lg-7">
						<div class="phrases-box d-flex">
							<strong class="me-3"><?php echo Text::_('COM_SEARCH_SEARCH_ONLY'); ?></strong>
							<div>
								<?php foreach ($this->searchareas['search'] as $val => $txt) : ?>
									<?php $checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : ''; ?>
									<label for="area-<?php echo $val; ?>" class="checkbox">
										<input type="checkbox" name="areas[]" value="<?php echo $val; ?>" id="area-<?php echo $val; ?>" <?php echo $checked; ?> />
										<?php echo Text::_($txt); ?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if($this->params->get('search_phrases', 1) || $this->total > 0) : ?>
		<div class="mb-3">
			<div class="row">
				<?php if($this->params->get('search_phrases', 1)) : ?>
					<div class="col-lg-5">
						<?php echo $this->lists['ordering']; ?>
					</div>
				<?php endif; ?>

				<?php if ($this->total > 0) : ?>
					<div class="col-lg-3">
						<?php echo $this->pagination->getLimitBox(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</form>
