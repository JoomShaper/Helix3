<?php
/**
* @author    JoomShaper http://www.joomshaper.com
* @copyright Copyright (C) 2010 - 2015 JoomShaper
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2
*/

//no direct access
defined('_JEXEC') or die('Restricted Access');

?>
<span class="twitter-share">
	<a class="twitter-share-button" href="<?php echo $displayData['url']; ?>" data-text="<?php echo $displayData['item']->title; ?>" data-url="<?php echo $displayData['url']; ?>">Tweet</a>
	<script>
	window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
	</script>
</span>	