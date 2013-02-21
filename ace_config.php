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

function javascript_escape($value) {
	return strtr((string)$value, array(
			"'"     => '\\\'',
			'"'     => '\"',
			'\\'    => '\\\\',
			"\n"    => '\n',
			"\r"    => '\r',
			"\t"    => '\t',
			chr(12) => '\f',
			chr(11) => '\v',
			chr(8)  => '\b',
			'</'    => '\u003c\u002F',
	));
}

?>
    var aceMode = "<?php echo javascript_escape($settings['Mode']) ?>";
    var aceTheme = "<?php echo javascript_escape($settings['Theme']) ?>";
    var aceFontSize = <?php echo intval($settings['FontSize']) ?>;
    var aceScrollSpeed = <?php echo intval($settings['FontSize']) ?>;
    var aceEditorHeight = <?php echo intval($settings['EditorHeight']) ?>;
    var aceHighlightActiveLine = <?php echo boolstr($settings['HighlightActiveLine']) ?>;
    var aceWrapLines = <?php echo boolstr($settings['WrapLines']) ?>;
    var aceWrapRange = <?php echo intval($settings['WrapRange']) ?>;
    var aceCookieLife = <?php echo intval($settings['CookieLife']) ?>;
    var aceLayoutIntegrate = <?php echo boolstr($settings['LayoutIntegrate']) ?>;
    var aceStrConfig = "<?php echo javascript_escape(__('Ace settings')) ?>";
    var aceStrMode = "<?php echo javascript_escape(__('Mode')) ?>";
