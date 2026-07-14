<?php
/**
 * @package     Joomla.Helix3SecurityPatch
 * @author      JoomShaper Development Team
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Installer\Installer;

class helix3j3securitypatchInstallerScript
{
    /**
     * Replacement logic runs during preflight
     */
    public function preflight($type, $parent)
    {
        // Get the "files" directory path from the installation package
        $sourcePath = realpath($parent->getParent()->getPath('source') . '/files');

        // Define the root path of the Joomla installation
        $rootPath = JPATH_ROOT;

        if (!Folder::exists($sourcePath)) {
            return true;
        }

        // Retrieve all the files from the "files" directory and its subdirectories
        $files = Folder::files($sourcePath, '.', true, true);

        if (empty($files)) {
            return true;
        }

        foreach ($files as $file) {
            // Calculate the relative path from the "files" directory
            $relativePath = str_replace($sourcePath, '', $file);

            // Determine the destination path in the root directory
            $destPath = $rootPath . '/' . $relativePath;

            // Check if the target file exists in the destination path
            // (we only patch existing installations of Helix3 and shaper_helix3)
            if (File::exists($destPath)) {
                if (!File::copy($file, $destPath, '', false)) {
                    Factory::getApplication()->enqueueMessage("Failed to replace $relativePath", 'error');
                } else {
                    // Log success message
                    Factory::getApplication()->enqueueMessage("Patched: $relativePath", 'message');
                }
            } else {
                // If the file doesn't exist, we skip it or raise a warning
                Factory::getApplication()->enqueueMessage("Target file not found (skipped): $relativePath", 'notice');
            }
        }

        return true;
    }

    /**
     * Post-installation cleanup and messaging
     */
    public function postflight($type, $parent)
    {
        // Clear LESS cache to avoid php serialization mismatch on next load
        $cachePath = JPATH_CACHE . '/com_templates';
        if (Folder::exists($cachePath)) {
            Folder::delete($cachePath);
            Factory::getApplication()->enqueueMessage("Cleared template Less/CSS cache.", 'message');
        }

        // Success message
        Factory::getApplication()->enqueueMessage("<h2>Helix3 and Shaper_Helix3 Joomla 3 Security Patch Applied successfully!</h2><p>All critical vulnerabilities have been successfully patched. The installer package will now self-uninstall.</p>", 'message');

        // Self-uninstall to leave no database traces
        $this->uninstallPlugin();
    }

    /**
     * Cleanup: Removes the extension entry from the database
     */
    private function uninstallPlugin()
    {
        $plugins = $this->findThisPlugin();
        foreach ($plugins as $plugin) {
            if (Installer::getInstance()->uninstall($plugin->type, $plugin->extension_id)) {
                Factory::getApplication()->enqueueMessage("Installer plugin " . $plugin->name . " successfully removed.", 'message');
            } else {
                Factory::getApplication()->enqueueMessage("Installer plugin " . $plugin->name . " could not be removed automatically. Please uninstall it manually.", 'warning');
            }
        }
    }

    /**
     * Finds the extension IDs for self-removal
     */
    private function findThisPlugin()
    {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select(array('extension_id', 'type', 'name'))
            ->from('#__extensions')
            ->where($db->quoteName('element') . ' = ' . $db->quote('helix3j3securitypatch'))
            ->where($db->quoteName('type') . ' = ' . $db->quote('file'));
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}
