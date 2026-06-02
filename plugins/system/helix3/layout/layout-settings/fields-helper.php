<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

if (version_compare(JVERSION, '5.0', '>=')) {
    if (!class_exists('Joomla\\CMS\\Filesystem\\Folder') && class_exists('Joomla\\Filesystem\\Folder')) {
        class_alias('Joomla\\Filesystem\\Folder', 'Joomla\\CMS\\Filesystem\\Folder');
    }
}
use Joomla\CMS\Filesystem\Folder;
class FieldsHelper
{

	protected function __construct()
	{

		$types = Folder::files( dirname( __FILE__ ) . '/types', '\.php$', false, true);

		foreach ($types as $type) {
			require_once $type;
		}
	}

	protected static function getInputElements( $key, $attr )
	{
		return call_user_func(array( 'SpType' . ucfirst( $attr['type'] ), 'getInput'), $key, $attr );
	}

}
