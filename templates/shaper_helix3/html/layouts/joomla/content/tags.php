<?php
    /**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2026 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

    defined('JPATH_BASE') or die;

    use Joomla\CMS\Access\Access;
    use Joomla\CMS\Factory;
    use Joomla\CMS\Language\Text;
    use Joomla\CMS\Router\Route;
    use Joomla\Registry\Registry;

    JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
?>

<?php if (! empty($displayData)): ?>
	<div class="tags">
	<span><?php echo Text::_('HELIX_TAGS'); ?>: </span>
		<?php foreach ($displayData as $i => $tag): ?>
			<?php if (in_array($tag->access, Access::getAuthorisedViewLevels(Factory::getUser()->get('id')))): ?>
				<?php $tagParams  = new Registry($tag->params); ?>
				<?php $link_class = htmlspecialchars($tagParams->get('tag_link_class', ''), ENT_QUOTES, 'UTF-8'); ?>
				<a href="<?php echo htmlspecialchars(Route::_(TagsHelperRoute::getTagRoute($tag->tag_id . '-' . $tag->alias)), ENT_QUOTES, 'UTF-8') ?>" class="<?php echo $link_class; ?>" rel="tag"><?php echo $this->escape($tag->title); ?></a><?php if ($i != (count($displayData) - 1)) {
            echo ',';
        }
    ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
