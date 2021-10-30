<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;
$params  = $displayData->params;
$attribs 		= json_decode($displayData->attribs);
$images 		= json_decode($displayData->images);
$full_image 	= '';

if (isset($attribs->spfeatured_image) && $attribs->spfeatured_image != '')
{
	$full_image = $attribs->spfeatured_image;
}
elseif(isset($images->image_fulltext) && !empty($images->image_fulltext))
{
	$full_image = $images->image_fulltext;
}
?>

<?php if(!empty($full_image) || (isset($images->image_fulltext) && !empty($images->image_fulltext))) : ?>
	<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> entry-image full-image">
		<img
		<?php if ($images->image_fulltext_caption):
		echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_fulltext_caption) . '"';
		endif; ?>
		src="<?php echo htmlspecialchars($full_image); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" itemprop="image" />
	</div>
<?php endif; ?>
