<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;

?>


<ol>
<?php
	foreach ($this->link_items as &$item) :
?>
	<li>
		<a href="<?php echo Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language) : Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language)); ?>">
			<?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>


</ol>
