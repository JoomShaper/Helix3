<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('JPATH_BASE') or die;

$url  	=  Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getArticleRoute($displayData->id . ':' . $displayData->alias, $displayData->catid, $displayData->language) : Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($displayData->id . ':' . $displayData->alias, $displayData->catid, $displayData->language));
$root 	= Uri::base();
$root 	= new Uri($root);
$url  	= $root->getScheme() . '://' . $root->getHost() . $url;

$params = Factory::getApplication()->getTemplate(true)->params;

if ($params->get('social_share')) : ?>
	<div class="helix-social-share">
		<div class="helix-social-share-icon">
			<ul>
				<li>
					<div class="facebook" data-toggle="tooltip" data-placement="top" title="<?php echo Text::_('HELIX_SHARE_FACEBOOK'); ?>">
						<a class="facebook" onClick="window.open('https://www.facebook.com/sharer.php?u=<?php echo $url; ?>','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo $url; ?>">
							<i class="fa fa-facebook"></i>
						</a>
					</div>
				</li>

				<li>
					<div class="twitter"  data-toggle="tooltip" data-placement="top" title="<?php echo Text::_('HELIX_SHARE_TWITTER'); ?>">
						<a class="twitter" onClick="window.open('https://twitter.com/share?url=<?php echo $url; ?>&amp;text=<?php echo str_replace(" ", "%20", $displayData->title); ?>','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://twitter.com/share?url=<?php echo $url; ?>&amp;text=<?php echo str_replace(" ", "%20", $displayData->title); ?>">
							<i class="fa fa-twitter"></i>
						</a>
					</div>
				</li>
				
				<li>
					<div class="linkedin">
						<a class="linkedin" data-toggle="tooltip" data-placement="top" title="<?php echo Text::_('HELIX_SHARE_LINKEDIN'); ?>" onClick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>','Linkedin','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>" >
							<i class="fa fa-linkedin-square"></i>
						</a>
					</div>
				</li>
			</ul>
		</div>		
	</div>
<?php endif; ?>