<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

//no direct access
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$params 	= Factory::getApplication()->getTemplate(true)->params;

if (($params->get('commenting_engine') != 'disabled') && ($params->get('comments_count'))) :
	$url        =  Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getArticleRoute($displayData['item']->id . ':' . $displayData['item']->alias, $displayData['item']->catid, $displayData['item']->language) : Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($displayData['item']->id . ':' . $displayData['item']->alias, $displayData['item']->catid, $displayData['item']->language));
	$root       = Uri::base();
	$root       = new Uri($root);
	$url        = $root->getScheme() . '://' . $root->getHost() . $url;
?>
	<dd class="comment">
		<i class="fa fa-comments-o" area-hidden="true"></i>
		<?php echo LayoutHelper::render('joomla.content.comments.engine.count.' . $params->get('commenting_engine'), array( 'item' => $displayData, 'params' => $params, 'url' => $url)); ?>
	</dd>
<?php endif; ?>