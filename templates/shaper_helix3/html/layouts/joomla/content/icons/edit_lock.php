<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$tooltip = $displayData['tooltip'];
?>
<span class="hasTooltip icon-lock" title="<?php echo HTMLHelper::tooltipText($tooltip . '', 0); ?>"></span>
<?php echo Text::_('JLIB_HTML_CHECKED_OUT'); ?>