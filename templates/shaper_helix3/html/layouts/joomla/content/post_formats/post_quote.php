<?php
    /**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2026 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

    defined('JPATH_BASE') or die;

    $attribs = $displayData['item']->attribs ?? null;
    $attribs = is_string($attribs) ? json_decode($attribs) : $attribs;

    $quote_text = $displayData['params']->get('quote_text');
    if (empty($quote_text)) {
        $quote_text = $attribs->quote_text ?? '';
    }

    $quote_author = $displayData['params']->get('quote_author');
    if (empty($quote_author)) {
        $quote_author = $attribs->quote_author ?? '';
    }
?>

<?php if (!empty($quote_text)): ?>
	<div class="entry-quote">
		<blockquote>
			<p><?php echo $quote_text; ?></p>
			<?php if (!empty($quote_author)): ?>
				<small><?php echo $quote_author; ?></small>
			<?php endif; ?>
		</blockquote>
	</div>
<?php endif; ?>