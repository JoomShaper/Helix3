<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;

$params 	= Factory::getApplication()->getTemplate(true)->params;
$format = $displayData;

if ($params->get('show_post_format')) : ?>
	<span class="post-format">
		<?php if ($format == 'audio') : ?>
			<i class="fa fa-music" area-hidden="true"></i>
		<?php elseif ($format == 'video') : ?>
			<i class="fa fa-video-camera" area-hidden="true"></i>
		<?php elseif ($format == 'gallery') : ?>
			<i class="fa fa-picture-o" area-hidden="true"></i>
		<?php elseif ($format == 'quote') : ?>
			<i class="fa fa-quote-left" area-hidden="true"></i>
		<?php elseif ($format == 'link') : ?>
			<i class="fa fa-link" area-hidden="true"></i>
		<?php elseif ($format == 'status') : ?>
			<i class="fa fa-comment-o" area-hidden="true"></i>
		<?php else : ?>
			<i class="fa fa-thumb-tack" area-hidden="true"></i>
		<?php endif; ?>
	</span>
<?php endif; ?>

