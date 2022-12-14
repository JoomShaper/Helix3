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
use Joomla\CMS\Language\Text;

if ($displayData['params']->get('fb_appID') != '')
{
	$doc = Factory::getDocument();

	if (!defined('HELIX_COMMENTS_FACEBOOK_COUNT'))
	{
		$doc->addScript('//connect.facebook.net/en-GB/all.js#xfbml=1&appId=' . $displayData['params']->get('fb_appID') . '&version=v2.0');
		define('HELIX_COMMENTS_FACEBOOK_COUNT', 1);
	}
	?>

	<span class="comments-anchor">
		<a href="<?php echo $displayData['url']; ?>#sp-comments"><?php echo Text::_('COMMENTS'); ?> <fb:comments-count href=<?php echo $displayData['url']; ?>></fb:comments-count></a>
	</span>
	<?php
}