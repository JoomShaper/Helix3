<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('bootstrap.tooltip');

$usersConfig = ComponentHelper::getParams('com_users');

?>
<form action="<?php echo Route::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form">
	<?php if ($params->get('pretext')) : ?>
		<div class="form-group pretext">
			<p><?php echo $params->get('pretext'); ?></p>
		</div>
	<?php endif; ?>
	
	<div id="form-login-username" class="form-group mb-3">
		<?php if (!$params->get('usetext')) : ?>
			<div class="input-group">
				<span class="input-group-text input-group-addon">
					<i class="icon-user hasTooltip" title="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME') ?>"></i>
				</span>
				<input id="modlgn-username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
			</div>
		<?php else: ?>
			<input id="modlgn-username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
		<?php endif; ?>
	</div>

	<div id="form-login-password" class="form-group mb-3">
		<div class="controls">
			<?php if (!$params->get('usetext')) : ?>
				<div class="input-group">
					<span class="input-group-text input-group-addon">
						<i class="icon-lock hasTooltip" title="<?php echo Text::_('JGLOBAL_PASSWORD') ?>"></i>
					</span>
					<input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD') ?>" />
				</div>
			<?php else: ?>
				<input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD') ?>" />
			<?php endif; ?>
		</div>
	</div>
	
	<?php if (version_compare(JVERSION, '4.2.0', '<')) : ?>
		<?php if (count($twofactormethods) > 1): ?>
		<div id="form-login-secretkey" class="form-group mb-3">
			<?php if (!$params->get('usetext')) : ?>
				<div class="input-group">
					<span class="input-group-text input-group-addon hasTooltip" title="<?php echo Text::_('JGLOBAL_SECRETKEY_HELP'); ?>">
						<i class="icon-help"></i>
					</span>
					<input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY') ?>" />
				</div>
			<?php else: ?>
				<div class="input-group">
					<input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY') ?>" />
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
	<div id="form-login-remember" class="form-check form-group mb-3">
		<label for="modlgn-remember"><input id="modlgn-remember" type="checkbox" name="remember" class="form-check-input" value="yes"><?php echo Text::_('MOD_LOGIN_REMEMBER_ME') ?></label>
	</div>
	<?php endif; ?>

	<div id="form-login-submit" class="form-group mb-3">
		<button type="submit" tabindex="0" name="Submit" class="btn btn-primary"><?php echo Text::_('JLOGIN') ?></button>
		<?php if ($usersConfig->get('allowUserRegistration')) : ?>
			<a class="btn btn-success" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>"><?php echo Text::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span></a>
		<?php endif; ?>
	</div>

	<ul class="form-links">
		<li>
			<a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		<li>
			<a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
	</ul>
	
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo HTMLHelper::_('form.token'); ?>

	<?php if ($params->get('posttext')) : ?>
		<div class="posttext form-group">
			<p><?php echo $params->get('posttext'); ?></p>
		</div>
	<?php endif; ?>
</form>
