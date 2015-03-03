<?php
/**
* @author    JoomShaper http://www.joomshaper.com
* @copyright Copyright (C) 2010 - 2015 JoomShaper
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2
*/

//no direct access
defined('_JEXEC') or die('Restricted Access');

?>
<li><a href="//twitter.com/share" class="twitter-share-button" data-url="<?php echo $displayData['url']; ?>" data-text="<?php echo $displayData['item']->title; ?>" data-lang="en">tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>