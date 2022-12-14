<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
?>
<div class="tagspopular tagscloud">
<?php
if (!count($list)) : ?>
	<div class="alert alert-warning"><?php echo Text::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php else :
	foreach ($list as $item) :?>
		<a class="tag-name" href="<?php echo Route::_(TagsHelperRoute::getTagRoute($item->tag_id . ':' . $item->alias)); ?>">
			<?php echo htmlspecialchars($item->title); ?>
			<?php if ($display_count) : ?>
				<span><?php echo $item->count; ?></span>
			<?php endif; ?>
		</a>	
	<?php endforeach; ?>
<?php endif; ?>


</div>
