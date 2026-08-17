<?php
    /**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2026 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

    defined('JPATH_BASE') or die;

    $video_src = '';
    $video = $displayData['params']->get('video');
    if (empty($video)) {
        $attribs = $displayData['item']->attribs ?? null;
        $attribs = is_string($attribs) ? json_decode($attribs) : $attribs;
        $video = $attribs->video ?? '';
    }

    if (!empty($video)) {
        $video = parse_url($video);
        $host  = $video['host'] ?? '';
        $path  = $video['path'] ?? '';

        switch ($host) {
            case 'youtu.be':
                $video_id  = trim($path, '/');
                $video_src = '//www.youtube.com/embed/' . $video_id;
                break;

            case 'www.youtube.com':
            case 'youtube.com':
                $video_id = '';

                if (preg_match('#^/(?:embed|v)/([A-Za-z0-9_-]{11})#', $path, $matches)) {
                    $video_id = $matches[1];
                }
                elseif (!empty($video['query'])) {
                    parse_str($video['query'], $query);
                    $video_id = $query['v'] ?? '';
                }

                $video_src = !empty($video_id) ? '//www.youtube.com/embed/' . $video_id : '';
                break;

            case 'vimeo.com':
            case 'www.vimeo.com':
                $video_id  = trim($path, '/');
                $video_src = "//player.vimeo.com/video/" . $video_id;
        }
    }
?>

<?php if ($video_src): ?>
	<div class="entry-video ratio ratio-16x9">
		<object class="embed-responsive-item" style="width:100%;height:100%;" data="<?php echo $video_src; ?>">
			<param name="movie" value="<?php echo $video_src; ?>">
			<param name="wmode" value="transparent" />
			<param name="allowFullScreen" value="true">
			<param name="allowScriptAccess" value="always"></param>
			<embed src="<?php echo $video_src; ?>" type="application/x-shockwave-flash" allowscriptaccess="always"></embed>
		</object>
	</div>
<?php endif; ?>