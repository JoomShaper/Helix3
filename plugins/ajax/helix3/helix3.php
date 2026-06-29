<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2026 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

// No direct access.
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Http\Http;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Menu\SiteMenu;
use Joomla\Registry\Registry;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\MediaHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Utilities\IpHelper;

if (version_compare(JVERSION, '5.0', '>=')) {
    if (!class_exists('Joomla\\CMS\\Filesystem\\File') && class_exists('Joomla\\Filesystem\\File')) {
        class_alias('Joomla\\Filesystem\\File', 'Joomla\\CMS\\Filesystem\\File');
    }

    if (!class_exists('Joomla\\CMS\\Filesystem\\Folder') && class_exists('Joomla\\Filesystem\\Folder')) {
        class_alias('Joomla\\Filesystem\\Folder', 'Joomla\\CMS\\Filesystem\\Folder');
    }
}

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;

require_once __DIR__ . '/classes/image.php';

class plgAjaxHelix3 extends CMSPlugin
{
  private static $adminActions = array(
    'remove',
    'save',
    'load',
    'resetLayout',
    'import',
    'updateFonts',
    'fontVariants',
  );

  private static $publicActions = array(
    'voting',
  );

  private static $allowedImageExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

  private static $maxImportSettingsBytes = 1048576;

  private static $maxLayoutContentBytes = 1048576;

  private static $maxVotesPerWindow = 5;

  private static $voteRateLimitSeconds = 60;

  public function onAjaxHelix3()
  {
    $app = Factory::getApplication();
    $input = $app->input;
    $action = $input->post->get('action', '', 'STRING');

    if($action === 'upload_image') {
      $this->requireAuthorisedAdminRequest();
      $this->upload_image();
      return;
    } else if($action === 'remove_image') {
      $this->requireAuthorisedAdminRequest();
      $this->remove_image();
      return;
    }

    $data = $input->post->get('data', [], 'array');

    if (empty($data) || !is_array($data)) {
      return;
    }

    if (!is_array($data) || empty($data['action'])) {
      return;
    }

    $action = (string) $data['action'];

    if (!$this->isAllowedDataAction($action)) {
      $this->sendJsonError(Text::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 403);
    }

    if (in_array($action, self::$adminActions, true)) {
      $this->requireAuthorisedAdminRequest();
    } elseif ($action === 'voting') {
      $this->requireValidToken();
    }

    $layoutName = '';

    if (isset($data['layoutName'])) {
      $layoutName = $data['layoutName'];
    }

    $report = array();
    $report['action'] = 'none';
    $report['status'] = 'false';

    $templateStyle = self::getTemplate();

    if (!$templateStyle || empty($templateStyle->template)) {
      return json_encode($report);
    }

    $template  = $templateStyle->template;
    $layoutPath = JPATH_SITE.'/templates/'.$template.'/layout/';

    switch ($action) {
        case 'remove':
        $filepath = $this->getLayoutFilePath($layoutPath, $layoutName);

        if ($filepath && file_exists($filepath)) {
          File::delete($filepath);
          $report['action'] = 'remove';
          $report['status'] = 'true';
        }
        $report['layout'] = Folder::files($layoutPath, '.json');
        break;

        case 'save':
        $content = isset($data['content']) && is_string($data['content']) ? $data['content'] : '';
        $filepath = $this->getLayoutFilePath($layoutPath, $layoutName);

        if ($content !== '' && strlen($content) <= self::$maxLayoutContentBytes) {
          $layoutPayload = json_decode($content);

          if (json_last_error() === JSON_ERROR_NONE && $this->isValidLayoutPayload($layoutPayload) && $filepath) {
            File::write($filepath, $content);
            $report['action'] = 'save';
            $report['status'] = 'true';
          }
        }
        $report['layout'] = Folder::files($layoutPath, '.json');
        break;

        case 'load':
        $filepath = $this->getLayoutFilePath($layoutPath, $layoutName);

        if ($filepath && file_exists($filepath)) {
          $content = file_get_contents($filepath);
        }

        if (isset($content) && $content) {
          $layoutData = json_decode($content);

          if (json_last_error() === JSON_ERROR_NONE) {
            echo self::loadNewLayout($layoutData);
          }
        }
        die();
        break;

        case 'resetLayout':
        $menuId = (int) $layoutName;

        if ($menuId > 0) {
          echo self::resetMenuLayout($menuId);
        }
        die();
        break;

        default:
        break;

        case 'voting':
        return $this->processVote($data, $report);
        break;

        //Font variant
        case 'fontVariants':

        $template_path = JPATH_SITE . '/templates/' . self::getTemplate()->template . '/webfonts/webfonts.json';
        $plugin_path   = JPATH_PLUGINS . '/system/helix3/assets/webfonts/webfonts.json';

        if(File::exists( $template_path )) {
          $json = file_get_contents($template_path);
        } else {
          $json = file_get_contents($plugin_path);
        }

        $webfonts   = json_decode($json);
        $items      = $webfonts->items;

        $output = array();
        $fontVariants = '';
        $fontSubsets = '';
        foreach ($items as $item) {
          if($item->family==$layoutName) {

            //Variants
            foreach ($item->variants as $variant) {
              $fontVariants .= '<option value="'. self::escape($variant) .'">' . self::escape($variant) . '</option>';
            }

            //Subsets
            foreach ($item->subsets as $subset) {
              $fontSubsets .= '<option value="'. self::escape($subset) .'">' . self::escape($subset) . '</option>';
            }
          }
        }

        $output['variants'] = $fontVariants;
        $output['subsets']  = $fontSubsets;

        return json_encode($output);

        break;

        //Font variant
        case 'updateFonts':

        $template_path = JPATH_SITE . '/templates/' . self::getTemplate()->template . '/webfonts';

        if (!Folder::exists( $template_path ))
        {
          Folder::create( $template_path, 0755 );
        }

        $tplRegistry = new Registry();
        $tplParams = $tplRegistry->loadString($templateStyle->params);
        $gfont_api = trim((string) $tplParams->get('gfont_api', ''));

        if ($gfont_api === '') {
          echo "<p class='font-update-failed'>Google Webfonts API key is missing.</p>";
          die();
        }

        $url  = 'https://www.googleapis.com/webfonts/v1/webfonts?key='. rawurlencode($gfont_api);
        $http = new Http();
        $str  = $http->get($url);

        if($str->code == 200) {
          // if successfully updated
          if ( File::write( $template_path . '/webfonts.json', $str->body )) {
            echo "<p class='font-update-success'>Google Webfonts list successfully updated! Please refresh your browser.</p>";
          } else {
            echo "<p class='font-update-failed'>Google Webfonts update failed. Please make sure that your template folder is writable.</p>";
          }
        } elseif($str->code == 403) {
          // If got error
          $decode_msg = json_decode($str->body);
          if(isset($decode_msg->error->message) && $get_msg = $decode_msg->error->message) {
            echo "<p class='font-update-failed'>". self::escape($get_msg) ."</p>";
          }
        }

        die();

        break;

        //Template setting import
        case 'import':

        $template_id = filter_var($data['template_id'] ?? null, FILTER_VALIDATE_INT);
        $settings = $data['settings'] ?? '';

        if (!$template_id || !is_string($settings) || $settings === '') {
          break;
        }

        if (strlen($settings) > self::$maxImportSettingsBytes) {
          break;
        }

        $decodedSettings = json_decode($settings);

        if (json_last_error() !== JSON_ERROR_NONE || !is_object($decodedSettings)) {
          break;
        }

        $settings = json_encode($decodedSettings);

        if ($settings === false) {
          break;
        }

        $db = Factory::getDbo();

        $verifyQuery = $db->getQuery(true)
          ->select('COUNT(*)')
          ->from($db->quoteName('#__template_styles'))
          ->where($db->quoteName('id') . ' = ' . (int) $template_id)
          ->where($db->quoteName('client_id') . ' = 0');

        $db->setQuery($verifyQuery);

        if ((int) $db->loadResult() === 0) {
          break;
        }

        $query = $db->getQuery(true);

        $fields = array(
          $db->quoteName('params') . ' = ' . $db->quote($settings)
        );

        $conditions = array(
          $db->quoteName('id') . ' = ' . (int) $template_id,
          $db->quoteName('client_id') . ' = 0'
        );

        $query->update($db->quoteName('#__template_styles'))->set($fields)->where($conditions);

        $db->setQuery($query);

        try {
          $db->execute();
          $report['action'] = 'import';
          $report['status'] = 'true';
        } catch (RuntimeException $e) {
          break;
        }

        break;

      }

    return json_encode($report);
  }

  private function sendJsonError($message, $httpCode = 403)
  {
    $app = Factory::getApplication();
    $app->setHeader('Status', (string) $httpCode, true);
    echo json_encode(array(
      'action' => 'none',
      'status' => 'false',
      'message' => $message,
    ));
    $app->close();
  }

  private function requireAuthorisedAdminRequest()
  {
    $user = Factory::getApplication()->getIdentity();

    if ($user->guest || (!$user->authorise('core.admin') && !$user->authorise('core.manage', 'com_templates'))) {
      $this->sendJsonError(Text::_('JERROR_ALERTNOAUTHOR'), 403);
    }

    if (!Session::checkToken('request')) {
      $this->sendJsonError(Text::_('JINVALID_TOKEN'), 403);
    }
  }

  private function requireValidToken()
  {
    if (!Session::checkToken('request')) {
      $this->sendJsonError(Text::_('JINVALID_TOKEN'), 403);
    }
  }

  private static function getAllowedDataActions()
  {
    return array_merge(self::$adminActions, self::$publicActions);
  }

  private function isAllowedDataAction($action)
  {
    return in_array((string) $action, self::getAllowedDataActions(), true);
  }

  private static function getClientIp()
  {
    if (class_exists('Joomla\\Utilities\\IpHelper')) {
      return IpHelper::getIp();
    }

    return Factory::getApplication()->input->server->get('REMOTE_ADDR', '', 'string');
  }

  private function isValidLayoutPayload($payload)
  {
    if (!is_array($payload)) {
      return false;
    }

    foreach ($payload as $row) {
      if (!is_object($row) || !isset($row->attr) || !is_array($row->attr)) {
        return false;
      }

      foreach ($row->attr as $column) {
        if (!is_object($column)) {
          return false;
        }
      }
    }

    return true;
  }

  private function articleExistsForRating($pk)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select('COUNT(*)')
      ->from($db->quoteName('#__content'))
      ->where($db->quoteName('id') . ' = ' . (int) $pk)
      ->where($db->quoteName('state') . ' = 1');

    $db->setQuery($query);

    return (int) $db->loadResult() > 0;
  }

  private function getVotedArticlesFromSession()
  {
    $session = Factory::getApplication()->getSession();
    $voted = $session->get('helix3.voted_articles', array());

    return is_array($voted) ? $voted : array();
  }

  private function hasVotedForArticle($pk)
  {
    return in_array((int) $pk, array_map('intval', $this->getVotedArticlesFromSession()), true);
  }

  private function markArticleVoted($pk)
  {
    $session = Factory::getApplication()->getSession();
    $voted = $this->getVotedArticlesFromSession();
    $voted[] = (int) $pk;
    $session->set('helix3.voted_articles', array_values(array_unique(array_map('intval', $voted))));
  }

  private function isVoteRateLimited()
  {
    $session = Factory::getApplication()->getSession();
    $log = $session->get('helix3.vote_rate_log', array());

    if (!is_array($log)) {
      $log = array();
    }

    $now = time();
    $log = array_values(array_filter($log, function ($timestamp) use ($now) {
      return ($now - (int) $timestamp) < self::$voteRateLimitSeconds;
    }));

    $session->set('helix3.vote_rate_log', $log);

    return count($log) >= self::$maxVotesPerWindow;
  }

  private function recordVoteAttempt()
  {
    $session = Factory::getApplication()->getSession();
    $log = $session->get('helix3.vote_rate_log', array());

    if (!is_array($log)) {
      $log = array();
    }

    $log[] = time();
    $session->set('helix3.vote_rate_log', $log);
  }

  private function processVote(array $data, array $report)
  {
    $rate = isset($data['user_rating']) ? (int) $data['user_rating'] : -1;
    $pk = 0;

    if (isset($data['id'])) {
      $id = str_replace('post_vote_', '', (string) $data['id']);
      $pk = (int) $id;
    }

    if ($rate < 1 || $rate > 5 || $pk <= 0) {
      $report['action'] = 'failed';
      $report['status'] = 'false';
      return json_encode($report);
    }

    if (!$this->articleExistsForRating($pk)) {
      $report['action'] = 'failed';
      $report['status'] = 'false';
      return json_encode($report);
    }

    if ($this->hasVotedForArticle($pk)) {
      $report['status'] = 'invalid';
      return json_encode($report);
    }

    if ($this->isVoteRateLimited()) {
      $report['status'] = 'invalid';
      return json_encode($report);
    }

    $userIP = self::getClientIp();
    $db = Factory::getDbo();

    try {
      $query = $db->getQuery(true)
        ->select('*')
        ->from($db->quoteName('#__content_rating'))
        ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

      $db->setQuery($query);
      $rating = $db->loadObject();

      if (!$rating) {
        $query = $db->getQuery(true)
          ->insert($db->quoteName('#__content_rating'))
          ->columns(array(
            $db->quoteName('content_id'),
            $db->quoteName('lastip'),
            $db->quoteName('rating_sum'),
            $db->quoteName('rating_count'),
          ))
          ->values((int) $pk . ', ' . $db->quote($userIP) . ', ' . (int) $rate . ', 1');
      } else {
        if ($userIP === $rating->lastip) {
          $report['status'] = 'invalid';
          return json_encode($report);
        }

        $query = $db->getQuery(true)
          ->update($db->quoteName('#__content_rating'))
          ->set($db->quoteName('rating_count') . ' = rating_count + 1')
          ->set($db->quoteName('rating_sum') . ' = rating_sum + ' . (int) $rate)
          ->set($db->quoteName('lastip') . ' = ' . $db->quote($userIP))
          ->where($db->quoteName('content_id') . ' = ' . (int) $pk);
      }

      $db->setQuery($query);
      $db->execute();
    } catch (RuntimeException $e) {
      return json_encode($report);
    }

    $this->markArticleVoted($pk);
    $this->recordVoteAttempt();

    $ratingData = self::getItemRating($pk);

    if ($ratingData) {
      $report['action'] = $ratingData->rating;
      $report['status'] = 'true';
    }

    return json_encode($report);
  }

  private static function getMenuItemTitle(SiteMenu $menu, $id)
  {
    $item = $menu->getItem((int) $id);

    return $item ? (string) $item->title : '';
  }

  private static function escape($value)
  {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
  }

  private function isAllowedImageExtension($extension)
  {
    return in_array(strtolower((string) $extension), self::$allowedImageExtensions, true);
  }

  private function getSafeMediaImagePath($src)
  {
    $src = str_replace('\\', '/', (string) $src);
    $src = ltrim($src, '/');

    if ($src === '' || strpos($src, "\0") !== false || strpos($src, '..') !== false) {
      return null;
    }

    if (strpos($src, 'images/') !== 0) {
      return null;
    }

    $extension = File::getExt($src);

    if (!$this->isAllowedImageExtension($extension)) {
      return null;
    }

    $basePath = realpath(JPATH_ROOT . '/images');
    $path = JPATH_ROOT . '/' . $src;
    $realPath = realpath($path);

    if ($basePath === false || $realPath === false) {
      return null;
    }

    if (strpos($realPath, $basePath . DIRECTORY_SEPARATOR) !== 0) {
      return null;
    }

    return $realPath;
  }

  private function sanitizeLayoutName($layoutName)
  {
    $layoutName = strtolower(str_replace(' ', '-', (string) $layoutName));
    $layoutName = preg_replace('/\.json$/i', '', $layoutName);
    $layoutName = basename($layoutName);

    if ($layoutName === '' || !preg_match('/^[a-z0-9_-]+$/', $layoutName)) {
      return '';
    }

    return $layoutName;
  }

  private function getLayoutFilePath($layoutPath, $layoutName)
  {
    $safeName = $this->sanitizeLayoutName($layoutName);

    if ($safeName === '') {
      return null;
    }

    $layoutRealPath = realpath($layoutPath);

    if ($layoutRealPath === false) {
      return null;
    }

    $filepath = $layoutRealPath . DIRECTORY_SEPARATOR . $safeName . '.json';

    if (file_exists($filepath)) {
      $realFilePath = realpath($filepath);

      if ($realFilePath === false || strpos($realFilePath, $layoutRealPath . DIRECTORY_SEPARATOR) !== 0) {
        return null;
      }

      return $realFilePath;
    }

    return $filepath;
  }

  public static function getItemRating($pk = 0){
    $db    = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('ROUND(rating_sum / rating_count, 0) AS rating, rating_count')
    ->from($db->quoteName('#__content_rating'))
    ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

    $db->setQuery($query);
    $data = $db->loadObject();

    return $data;
  }

  public static function resetMenuLayout($current_menu_id = 0){

    if (!$current_menu_id) {
      return;
    }

    $items  = self::menuItems();
    $item   = array();

    if (isset($items[$current_menu_id]) && !empty($items[$current_menu_id])) {
      $item = $items[$current_menu_id];
    }

    $menuItems = new SiteMenu();

    $no_child = true;
    $count = 0;
    $x_key = 0;
    $y_key = 0;
    $check_child = 0;
    $item_array = array();

    foreach ($item as $key => $id){
      $status = 0;
      if (isset($items[$id]) && is_array($items[$id])){
        $no_child = false;
        $count = $count + 1;
        $check_child = $check_child+1;
        $status = 1;
      }

      if ($check_child === 2){
        $y_key = 0;
        $x_key = $x_key + 1;
        $check_child = 1;
      }

      $item_array[$x_key][$y_key] = array($id,$status);
      $y_key = $y_key + 1;
    }

    if ($no_child === true){
      $count = 1;
    }

    if($count > 4 && $count != 6){
      $count = 4;
    }

    ob_start();

    if($no_child === true)
    {
      echo '<div class="menu-section">';
      echo '<span class="row-move"><i class="fa fa-bars"></i></span>';
      echo '<div class="spmenu sp-row">';
      echo '<div class="column sp-col-md-12" data-column="12">';
      echo '<div class="column-items-wrap">';
      if (!empty($item)) {
        echo '<h4 style="display:none" data-current_child="'.(int) $current_menu_id.'" >'.self::escape(self::getMenuItemTitle($menuItems, $current_menu_id)).'</h4>';
        echo '<ul class="child-menu-items">';

        foreach ($item as $key => $id)
        {
          echo '<li>'.self::escape(self::getMenuItemTitle($menuItems, $id)).'</li>';
        }
        echo '</ul>';
      }
      echo '<div class="modules-container">';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
    else
    {
      echo '<div class="menu-section">';
      echo '<span class="row-move"><i class="fa fa-bars"></i></span>';
      echo '<div class="spmenu sp-row">';

      $columnNumber = 12 / $count;
      foreach ($item_array as $key => $item_array)
      {
        echo '<div class="column sp-col-md-'.(int) $columnNumber.'" data-column="'.(int) $columnNumber.'">';
        echo '<div class="column-items-wrap">';

        foreach ($item_array as $key => $item)
        {
          $id = $item[0];
          echo '<h4 data-current_child="'.(int) $id.'" >'.self::escape(self::getMenuItemTitle($menuItems, $id)).'</h4>';
          if ($item[1])
          {
            echo '<ul class="child-menu-items">';
            echo self::create_menu($id);
            echo '</ul>';
          }
        }
        echo '<div class="modules-container"></div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
      echo '</div>';
    }

    $output = ob_get_contents();
    ob_clean();

    return $output;
  }

  public static function create_menu($current_menu_id)
  {
    $items = self::menuItems();
    $menus = new SiteMenu();

    if (isset($items[$current_menu_id]))
    {
      $item = $items[$current_menu_id];
      foreach ($item as $key => $item_id)
      {
        echo '<li>';
        echo self::escape(self::getMenuItemTitle($menus, $item_id));
        echo '</li>';
      }
    }
  }

  public static function menuItems()
  {
    $menus = new SiteMenu();
    $menus = $menus->getMenu();
    $new = array();
    foreach ($menus as $item) {
      $new[$item->parent_id][] = $item->id;
    }
    return $new;
  }

  public static function loadNewLayout($layout_data = null){

    $lang = Factory::getLanguage();
    $lang->load('tpl_' . self::getTemplate()->template, JPATH_SITE, $lang->getName(), true);

    ob_start();

    $colGrid = array(
      '12'        => '12',
      '66'        => '6,6',
      '444'       => '4,4,4',
      '3333'      => '3,3,3,3',
      '48'        => '4,8',
      '39'        => '3,9',
      '363'       => '3,6,3',
      '264'       => '2,6,4',
      '210'       => '2,10',
      '57'        => '5,7',
      '237'       => '2,3,7',
      '255'       => '2,5,5',
      '282'       => '2,8,2',
      '2442'      => '2,4,4,2',
    );

    if ($layout_data) {
      foreach ($layout_data as $row) {
        $rowSettings = self::getSettings($row->settings);
        $name = Text::_('HELIX_SECTION_TITLE');

        if (isset($row->settings->name)) {
          $name = $row->settings->name;
        }
        ?>
        <div class="layoutbuilder-section" <?php echo $rowSettings; ?>>
          <div class="settings-section clearfix">
            <div class="settings-left pull-left">
              <a class="row-move" href="#"><i class="fa fa-arrows"></i></a>
          <strong class="section-title"><?php echo self::escape($name); ?></strong>
            </div>
            <div class="settings-right pull-right">
              <ul class="button-group">
                <li>
                  <a class="btn btn-default btn-small btn-sm add-columns" href="#"><i class="fa fa-columns"></i> <?php echo Text::_('HELIX_ADD_COLUMNS'); ?></a>
                  <ul class="column-list">
                    <?php
                    $_active = '';
                    foreach ($colGrid as $key => $grid){
                      if($key == $row->layout){
                        $_active = 'active';
                      }
                      echo '<li><a href="#" class="column-layout column-layout-' . self::escape($key) . ' '.self::escape($_active).'" data-layout="'.self::escape($grid).'"></a></li>';
                      $_active ='';
                    } ?>
                    <?php
                    $active = '';
                    $customLayout = '';
                    if (!isset($colGrid[$row->layout])) {
                      $active = 'active';
                      $split = str_split($row->layout);
                      $customLayout = implode(',',$split);
                    }
                    ?>
                    <li><a href="#" class="hasTooltip column-layout-custom column-layout custom <?php echo self::escape($active); ?>" data-layout="<?php echo self::escape($customLayout); ?>" data-type='custom' data-original-title="<strong>Custom Layout</strong>"></a></li>
                  </ul>
                </li>
                <li><a class="btn btn-small add-row" href="#"><i class="fa fa-bars"></i> <?php echo Text::_('HELIX_ADD_ROW'); ?></a></li>
                <li><a class="btn btn-small row-ops-set" href="#"><i class="fa fa-gears"></i> <?php echo Text::_('HELIX_SETTINGS'); ?></a></li>
                <li><a class="btn btn-danger btn-small remove-row" href="#"><i class="fa fa-times"></i> <?php echo Text::_('HELIX_REMOVE'); ?></a></li>
              </ul>
            </div>
          </div>
          <div class="row ui-sortable">
            <?php foreach ($row->attr as $column) { $colSettings = self::getSettings($column->settings); ?>
              <div class="<?php echo self::escape($column->className); ?>" <?php echo $colSettings; ?>>
                <div class="column">
                  <?php if (isset($column->settings->column_type) && $column->settings->column_type) {
                    echo '<h6 class="col-title pull-left">Component</h6>';
                  }else{
                    if (!isset($column->settings->name)) {
                      $column->settings->name = 'none';
                    }
                    echo '<h6 class="col-title pull-left">'.self::escape($column->settings->name).'</h6>';
                  }
                  ?>
                  <a class="col-ops-set pull-right" href="#" ><i class="fa fa-gears"></i></a>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php
        }
      }
      $items = ob_get_contents();
      ob_end_clean();

      return $items;

    }

  public static function getSettings($config = null)
	{
      $data = '';

      if (count((array) $config))
      {
        foreach ($config as $key => $value)
        {
          $key = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $key);

          if ($key === '') {
            continue;
          }

          $data .= ' data-'.$key.'="'.self::escape($value).'"';
        }
      }

      return $data;
    }

    //Get template name
  private static function getTemplate()
	{

      $db = Factory::getDbo();
      $query = $db->getQuery(true);
      $query->select($db->quoteName(array('id', 'template', 'params')));
      $query->from($db->quoteName('#__template_styles'));
      $query->where($db->quoteName('client_id') . ' = '. $db->quote(0));
      $query->where($db->quoteName('home') . ' = '. $db->quote(1));
      $db->setQuery($query);

      return $db->loadObject();
    }

    // Upload File
  private function upload_image()
	{
      $input = Factory::getApplication()->input;
      $image = $input->files->get('image');
      $imageonly = $input->post->get('imageonly', false, 'BOOLEAN');

      $tplRegistry = new Registry();
      $tplParams = $tplRegistry->loadString(self::getTemplate()->params);

      $report = array();

      // User is not authorised
      if (!Factory::getApplication()->getIdentity()->authorise('core.create', 'com_media'))
      {
        $report['status'] = false;
        $report['output'] = Text::_('You are not authorised to upload file.');
        echo json_encode($report);
        die;
      }

      if(is_array($image) && !empty($image))
      {

        if ($image['error'] == UPLOAD_ERR_OK) {

          $error = false;

          $params = ComponentHelper::getParams('com_media');

          // Total length of post back data in bytes.
          $contentLength = (int) $_SERVER['CONTENT_LENGTH'];

          // Instantiate the media helper
          $mediaHelper = new MediaHelper;

          // Maximum allowed size of post back data in MB.
          $postMaxSize = $mediaHelper->toBytes(ini_get('post_max_size'));

          // Maximum allowed size of script execution in MB.
          $memoryLimit = $mediaHelper->toBytes(ini_get('memory_limit'));

          // Check for the total size of post back data.
          if (($postMaxSize > 0 && $contentLength > $postMaxSize) || ($memoryLimit != -1 && $contentLength > $memoryLimit)) {
            $report['status'] = false;
            $report['output'] = Text::_('Total size of upload exceeds the limit.');
            $error = true;
            echo json_encode($report);
            die;
          }

          $uploadMaxSize = $params->get('upload_maxsize', 0) * 1024 * 1024;
          $uploadMaxFileSize = $mediaHelper->toBytes(ini_get('upload_max_filesize'));

          if (($image['error'] == 1) || ($uploadMaxSize > 0 && $image['size'] > $uploadMaxSize) || ($uploadMaxFileSize > 0 && $image['size'] > $uploadMaxFileSize))
          {
            $report['status'] = false;
            $report['output'] = Text::_('This file is too large to upload.');
            $error = true;
          }

          // Upload if no error found
          if(!$error) {
            // Organised folder structure
            $date = Factory::getDate();
            $folder = HTMLHelper::_('date', $date, 'Y') . '/' . HTMLHelper::_('date', $date, 'm') . '/' . HTMLHelper::_('date', $date, 'd');

            if(!file_exists( JPATH_ROOT . '/images/' . $folder )) {
              Folder::create(JPATH_ROOT . '/images/' . $folder, 0755);
            }

            $name = basename((string) $image['name']);
            $path = $image['tmp_name'];
            $safeName = File::makeSafe($name);
            $file = pathinfo($safeName);
            $ext = isset($file['extension']) ? strtolower($file['extension']) : '';
            $baseName = isset($file['filename']) ? $file['filename'] : '';
            $baseName = trim(preg_replace('/[^A-Za-z0-9_-]/', '-', $baseName), '-');

            if ($baseName === '' || !$this->isAllowedImageExtension($ext) || !is_file($path) || @getimagesize($path) === false) {
              $report['status'] = false;
              $report['output'] = Text::_('Invalid image file.');
              echo json_encode($report);
              die;
            }

            // Do no override existing file
            $i = 0;
            do {
              $base_name  = $baseName . ($i ? '-' . $i : '');
              $image_name = $base_name . "." . $ext;
              $i++;
              $dest = JPATH_ROOT . '/images/' . $folder . '/' . $image_name;
              $src = 'images/' . $folder . '/'  . $image_name;
              $data_src = 'images/' . $folder . '/'  . $image_name;
            } while(file_exists($dest));
            // End Do not override

            if(File::upload($path, $dest)) {

              $sizes = array();

              if($tplParams->get('image_small', 0)) {
                $sizes['small'] = explode('x', strtolower($tplParams->get('image_small_size', '100X100')));
              }

              if($tplParams->get('image_thumbnail', 1)) {
                $sizes['thumbnail'] = explode('x', strtolower($tplParams->get('image_thumbnail_size', '200X200')));
              }

              if($tplParams->get('image_medium', 0)) {
                $sizes['medium'] = explode('x', strtolower($tplParams->get('image_medium_size', '300X300')));
              }

              if($tplParams->get('image_large', 0)) {
                $sizes['large']  = explode('x', strtolower($tplParams->get('image_large_size', '600X600')));
              }

              $sources = Helix3Image::createThumbs($dest, $folder, $base_name, $ext, $sizes);

              if(file_exists(JPATH_ROOT . '/images/' . $folder . '/' . $base_name . '_thumbnail.' . $ext)) {
                $src = 'images/' . $folder . '/'  . $base_name . '_thumbnail.' . $ext;
              }

              $report['status'] = true;

              if($imageonly) {
                $report['output'] = '<img src="'. self::escape(Uri::root(true) . '/' . $src) . '" data-src="'. self::escape($data_src) .'" alt="">';
              } else {
                $report['output'] = '<li data-src="'. self::escape($data_src) .'"><a href="#" class="btn btn-mini btn-danger btn-remove-image">Delete</a><img src="'. self::escape(Uri::root(true) . '/' . $src) . '" alt=""></li>';
              }
            }
          }
        }
      } else {
        $report['status'] = false;
        $report['output'] = Text::_('Upload Failed!');
      }

      echo json_encode($report);

      die;
    }

    // Delete File
  private function remove_image()
	{
      $report = array();

      if (!Factory::getApplication()->getIdentity()->authorise('core.delete', 'com_media'))
      {
        $report['status'] = false;
        $report['output'] = Text::_('You are not authorised to delete file.');
        echo json_encode($report);
        die;
      }

      $input = Factory::getApplication()->input;
      $src = $input->post->get('src', '', 'STRING');

      $path = $this->getSafeMediaImagePath($src);

      if($path && file_exists($path)) {

        if(File::delete($path)) {

          $basename = basename($path);
          $directory = dirname($path);
          $small = $directory . '/' . File::stripExt($basename) . '_small.' . File::getExt($basename);
          $thumbnail = $directory . '/' . File::stripExt($basename) . '_thumbnail.' . File::getExt($basename);
          $medium = $directory . '/' . File::stripExt($basename) . '_medium.' . File::getExt($basename);
          $large = $directory . '/' . File::stripExt($basename) . '_large.' . File::getExt($basename);

          if(file_exists($small)) {
            File::delete($small);
          }

          if(file_exists($thumbnail)) {
            File::delete($thumbnail);
          }

          if(file_exists($medium)) {
            File::delete($medium);
          }

          if(file_exists($large)) {
            File::delete($large);
          }

          $report['status'] = true;
        } else {
          $report['status'] = false;
          $report['output'] = Text::_('Delete failed');
        }
      } else {
        $report['status'] = false;
        $report['output'] = Text::_('Invalid image path.');
      }

      echo json_encode($report);

      die;
    }
}
