<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$tplParams 		= Factory::getApplication()->getTemplate(true)->params;
$params  		= $displayData->params;
$attribs 		= json_decode($displayData->attribs);
$images 		= json_decode($displayData->images);
$imgsize 		= $tplParams->get('blog_list_image', 'default');
$intro_image 	= '';
$image_alt_text = '';

if(isset($attribs->spfeatured_image) && $attribs->spfeatured_image != '')
{
	if($imgsize == 'default')
	{
		$intro_image = $attribs->spfeatured_image;
	}
	else
	{
		$intro_image = $attribs->spfeatured_image;
		$basename = basename($intro_image);
		$list_image = JPATH_ROOT . '/' . dirname($intro_image) . '/' . File::stripExt($basename) . '_'. $imgsize .'.' . File::getExt($basename);
		
		if(file_exists($list_image))
		{
			$intro_image = Uri::root(true) . '/' . dirname($intro_image) . '/' . File::stripExt($basename) . '_'. $imgsize .'.' . File::getExt($basename);
		}
	}

	if (isset($attribs->spfeatured_image_alt) && $attribs->spfeatured_image_alt)
	{
		$image_alt_text = $attribs->spfeatured_image_alt;
	}
}
elseif (isset($images->image_intro) && !empty($images->image_intro))
{
	$intro_image = $images->image_intro;
}

// if alt text is empty 
if (empty($image_alt_text))
{
	if (isset($images->image_intro_alt) && $images->image_intro_alt)
	{
		$image_alt_text = $images->image_intro_alt;
	}
	else
	{
		$image_alt_text = $displayData->title;
	}
}
?>

<?php if(!empty($intro_image) || (isset($images->image_intro) && !empty($images->image_intro))) : ?>
	<?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?> entry-image intro-image">
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			<a href="<?php echo Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language) : Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>">
		<?php endif; ?>
		<img
			<?php if (isset($images->image_intro_caption) && $images->image_intro_caption):
				echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
			endif; ?>
			src="<?php echo htmlspecialchars($intro_image); ?>" alt="<?php echo htmlspecialchars($image_alt_text); ?>" itemprop="thumbnailUrl"
		/>
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			</a>
		<?php endif; ?>
	</div>
<?php endif; ?>