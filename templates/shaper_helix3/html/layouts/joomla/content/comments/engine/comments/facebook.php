<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

//no direct access
defined('_JEXEC') or die('Restricted Access');

if ($displayData['params']->get('fb_appID') != '') : ?>
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo $displayData['params']->get('fb_appID'); ?>&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="fb-comments" data-href="<?php echo $displayData['url']; ?>" data-numposts="<?php echo $displayData['params']->get('fb_cpp'); ?>" data-width="<?php echo $displayData['params']->get('fb_width'); ?>" data-colorscheme="light"></div>
<?php endif; ?>