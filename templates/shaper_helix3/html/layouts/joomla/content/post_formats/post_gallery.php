<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;
?>

<?php if ($displayData['params']->get('gallery')) : ?>
	<?php $images = json_decode( $displayData['params']->get('gallery') ); ?>
	<?php if( count( $images->gallery_images ) ) : ?>
		<div id="carousel-gallery-<?php echo $displayData['item']->id; ?>" class="entry-gallery carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php foreach ( $images->gallery_images as $key => $image ) : ?>
					<div class="carousel-item<?php echo ($key===0) ? ' active': ''; ?>">
						<img src="<?php echo $image; ?>" alt="">
					</div>
				<?php endforeach; ?>
			</div>

			<a class="carousel-control-prev carousel-left" href="#carousel-gallery-<?php echo $displayData['item']->id; ?>" role="button" data-bs-slide="prev">
				<span class="fa fa-angle-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next carousel-right" href="#carousel-gallery-<?php echo $displayData['item']->id; ?>" role="button" data-bs-slide="next">
				<span class="fa fa-angle-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	<?php endif; ?>
<?php endif; ?>
