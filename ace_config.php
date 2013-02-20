<?php

define('IN_CMS', true);
require_once '../../../init.php';

$settings = Plugin::getAllSettings('ace');

header('Content-Type: text/javascript; charset=UTF-8');
header('Cache-Control: max-age=86400, must-revalidate, private');
header_remove('Expires');
header_remove('Pragma');

function boolstr($value) {
    return in_array($value, array('true', 'false')) ? $value : 'false';
}

?>
    var aceMode = "<?php echo htmlspecialchars($settings['Mode']) ?>";
    var aceTheme = "<?php echo htmlspecialchars($settings['Theme']) ?>";
    var aceFontSize = <?php echo intval($settings['FontSize']) ?>;
    var aceScrollSpeed = <?php echo intval($settings['FontSize']) ?>;
    var aceEditorHeight = <?php echo intval($settings['EditorHeight']) ?>;
    var aceHighlightActiveLine = <?php echo boolstr($settings['HighlightActiveLine']) ?>;
    var aceWrapLines = <?php echo boolstr($settings['WrapLines']) ?>;
    var aceWrapRange = <?php echo intval($settings['WrapRange']) ?>;
    var aceCookieLife = <?php echo intval($settings['CookieLife']) ?>;
    var aceLayoutIntegrate = <?php echo boolstr($settings['LayoutIntegrate']) ?>;
        