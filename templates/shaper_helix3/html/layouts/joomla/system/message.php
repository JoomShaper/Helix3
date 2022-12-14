<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$msgList = $displayData['msgList'];

$find = array('error', 'notice', 'message');
$replace = array('danger', 'warning', 'success');

?>
<div id="system-message-container">
	<?php if (is_array($msgList) && !empty($msgList)) : ?>
		<div id="system-message">
			<?php foreach ($msgList as $type => $msgs) : ?>
				<div class="alert alert-<?php echo str_replace($find, $replace, $type); ?> alert-dismissible fade show">
					<?php // This requires JS so we should add it trough JS. Progressive enhancement and stuff. ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo Text::_('JClose'); ?>"></button>

					<?php if (!empty($msgs)) : ?>
						<h4 class="alert-heading"><?php echo Text::_($type); ?></h4>
						<div>
							<?php foreach ($msgs as $msg) : ?>
								<p><?php echo $msg; ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
