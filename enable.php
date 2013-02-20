<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 * 
 * Ace filter for Wolf CMS
 * Code editor and syntax highlighter based on Ajax.org Cloud9 Editor.
 *  
 * @package Plugins
 * @subpackage ace
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2012
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 * @license Ace http://opensource.org/licenses/BSD-3-Clause BSD
 * 
 */
/* Security measure */
defined('IN_CMS') or exit;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'AceController.php';

$settings = array(
    'Mode' => AceController::DEFAULT_MODE,
    'Theme' => AceController::DEFAULT_THEME,
    'FontSize' => AceController::DEFAULT_FONT_SIZE,
    'ScrollSpeed' => AceController::DEFAULT_SCROLL_SPEED,
    'EditorHeight' => AceController::DEFAULT_EDITOR_HEIGHT,
    'HighlightActiveLine' => AceController::DEFAULT_HIGHLIGHT_ACTIVE_LINE,
    'WrapLines' => AceController::DEFAULT_WRAP_LINES,
    'WrapRange' => AceController::DEFAULT_WRAP_RANGE,
    'CookieLife' => AceController::DEFAULT_COOKIE_LIFE,  // in days, -1 defaults to Session cookie
    'LayoutIntegrate' => AceController::DEFAULT_LAYOUT_INTEGRATE,
);

// Store settings.
if (Plugin::setAllSettings($settings, 'ace'))
    Flash::set('success', __('Ace - plugin settings initialized.'));
else
    Flash::set('error', __('Ace - unable to store plugin settings!'));
