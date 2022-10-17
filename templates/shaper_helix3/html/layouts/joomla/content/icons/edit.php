<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$article = $displayData['article'];

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($article->publish_up > $currentDate)
	|| ($article->publish_down < $currentDate && $article->publish_down !== Factory::getDbo()->getNullDate());

$icon = $article->state ? 'edit' : 'eye-close';

if ($isUnpublished)
{
	$icon = 'eye-close';
}
?>
<span class="icon-<?php echo $icon; ?>" aria-hidden="true"></span>
<?php echo Text::_('JGLOBAL_EDIT'); ?>