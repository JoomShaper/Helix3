<?php

/**
 * @package Helix 3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

$app    = Factory::getApplication();
$params = ComponentHelper::getParams('com_media');
$input  = $app->getInput();
$user   = $app->getIdentity();

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useStyle('com_media.mediamanager')
    ->useScript('com_media.mediamanager')
    ->useStyle('webcomponent.joomla-alert')
    ->useScript('messages');

// Populate the language
$this->loadTemplate('texts');

$tmpl = $input->getCmd('tmpl');

$mediaTypes = '&mediatypes=' . $input->getString('mediatypes', '0,1,2,3');

// Populate the media config
$config = [
    'apiBaseUrl'          => Uri::base() . 'index.php?option=com_media&format=json' . $mediaTypes,
    'csrfToken'           => Session::getFormToken(),
    'filePath'            => $params->get('file_path', 'images'),
    'fileBaseUrl'         => Uri::root() . $params->get('file_path', 'images'),
    'fileBaseRelativeUrl' => $params->get('file_path', 'images'),
    'editViewUrl'         => Uri::base() . 'index.php?option=com_media&view=file' . ($tmpl ? '&tmpl=' . $tmpl : '')  . $mediaTypes,
    'imagesExtensions'    => array_map('trim', explode(',', $params->get('image_extensions', 'bmp,gif,jpg,jpeg,png,webp'))),
    'audioExtensions'     => array_map('trim', explode(',', $params->get('audio_extensions', 'mp3,m4a,mp4a,ogg'))),
    'videoExtensions'     => array_map('trim', explode(',', $params->get('video_extensions', 'mp4,mp4v,mpeg,mov,webm'))),
    'documentExtensions'  => array_map('trim', explode(',', $params->get('doc_extensions', 'doc,odg,odp,ods,odt,pdf,ppt,txt,xcf,xls,csv'))),
    'maxUploadSizeMb'     => $params->get('upload_maxsize', 10),
    'providers'           => (array) $this->providers,
    'currentPath'         => $this->currentPath,
    'isModal'             => $tmpl === 'component',
    'canCreate'           => $user->authorise('core.create', 'com_media'),
    'canEdit'             => $user->authorise('core.edit', 'com_media'),
    'canDelete'           => $user->authorise('core.delete', 'com_media'),
];
$this->document->addScriptOptions('com_media', $config);
?>
<?php if ($tmpl === 'component') : ?>
<div class="subhead noshadow mb-3">
    <?php echo $this->document->getToolbar('toolbar')->render(); ?>
</div>
<?php endif; 
$this->document->addScriptDeclaration(
	"
		jQuery(function($) {
			let element = '<div id=\"system-message-container\" aria-live=\"polite\"></div>';
			$( document ).ready(function() {
				$('body.com-media').prepend(element);
			});
		});
	"
);
?>
<div id="com-media"></div>
