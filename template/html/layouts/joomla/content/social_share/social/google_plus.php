<?php
/**
* @author    JoomShaper http://www.joomshaper.com
* @copyright Copyright (C) 2010 - 2015 JoomShaper
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2
*/
//no direct access
defined('_JEXEC') or die('Restricted Access');
?>
<li><div class="g-plusone" data-size="medium" data-href="<?php $displayData['url']; ?>"></div>
	<script type='text/javascript'>
		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = '//apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
	</script>
</li>