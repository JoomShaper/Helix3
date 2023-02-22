<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
?>
<div class="search">
	<form action="<?php echo Route::_('index.php');?>" method="post">
		<input name="searchword" id="mod-search-searchword" maxlength="<?php echo $maxlength; ?>"  class="form-control search-query" type="text" size="<?php echo $width; ?>" placeholder="<?php echo $text; ?>" />
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="option" value="com_search" />
		<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
	</form>
</div>
