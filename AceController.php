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

defined('IN_CMS') or exit;

class AceController extends PluginController {
    const DEFAULT_MODE = 'php';
    const DEFAULT_THEME = 'monokai';
    const DEFAULT_FONT_SIZE = 12;
    const DEFAULT_SCROLL_SPEED = 6;
    const DEFAULT_EDITOR_HEIGHT = 400;
    const DEFAULT_WRAP_LINES = 'true';
    const DEFAULT_WRAP_RANGE = 80;
    const DEFAULT_LAYOUT_INTEGRATE = 'true';
    const DEFAULT_HIGHLIGHT_ACTIVE_LINE = 'true';
    const DEFAULT_COOKIE_LIFE = '365';  // in days, -1 defaults to Session cookie

    public function __construct() {
        AuthUser::load();
        if ( ! AuthUser::isLoggedIn()) {
            redirect(get_url('login'));
        }
        
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/ace/views/sidebar'));
    }

    public function index() {
        $this->settings();
    }    
    
    function settings() {
        $settings = Plugin::getAllSettings('ace');

        if (!$settings) {
            Flash::set('error', 'Ace - '.__('unable to retrieve plugin settings.'));
            redirect(get_url('setting'));

        }

        $this->display('ace/views/settings', array(
                                'settings'  => $settings,
                                'themes'    => $this->getThemes(),
                                'modes'    => $this->getModes(),
                                ));
    }
    
    public function save() {
        $modes = $this->getModes();
        $themes = $this->getThemes();
        
        $settings = array();
        $settings['Mode'] = isset($_POST['aceMode']) &&
            isset($modes['mode-' . $_POST['aceMode'] . '.js']) ?
            $_POST['aceMode'] : self::DEFAULT_MODE; 
        $settings['Theme'] = isset($_POST['aceTheme']) &&
            isset($themes['theme-' . $_POST['aceTheme'] . '.js']) ?
            $_POST['aceTheme'] : self::DEFAULT_THEME;
        $settings['FontSize'] = $this->checkInt('aceFontSize', self::DEFAULT_FONT_SIZE); 
        $settings['ScrollSpeed'] = $this->checkInt('aceScrollSpeed', self::DEFAULT_SCROLL_SPEED);
        $settings['EditorHeight'] = $this->checkInt('aceEditorHeight', self::DEFAULT_EDITOR_HEIGHT);
        $settings['HighlightActiveLine'] = $this->checkBool('aceHighlightActiveLine', self::DEFAULT_HIGHLIGHT_ACTIVE_LINE);
        $settings['WrapLines'] = $this->checkBool('aceWrapLines', self::DEFAULT_WRAP_LINES);
        $settings['WrapRange'] = $this->checkInt('aceWrapRange', self::DEFAULT_WRAP_RANGE);
        $settings['CookieLife'] = $this->checkInt('aceCookieLife', self::DEFAULT_COOKIE_LIFE);
        $settings['LayoutIntegrate'] = $this->checkBool('aceLayoutIntegrate', self::DEFAULT_LAYOUT_INTEGRATE);
        
        if (Plugin::setAllSettings($settings, 'ace')) {
            Flash::set('success', __('Ace - settings saved!'));
        } else {
            Flash::set('error', __('Ace - unable to store settings in database!'));
        }
        redirect(get_url('plugin/ace/settings'));        
    }	    	

    private function checkInt($value, $default)
    {
        return isset($_POST[$value]) && intval($_POST[$value]) ?
            intval($_POST[$value]) : $default;
    }

    private function checkBool($value, $default)
    {
        return isset($_POST[$value]) && in_array($_POST[$value], array('true', 'false')) ? 
            $_POST[$value] : $default;
    }
    
    protected function getThemes()
    {
        $themes = array();
        foreach (glob(ACEDIR . '/build/src-min/theme-*.js') as $path)
        {
            $file = basename($path);
            $name = substr(basename($path, '.js'), 6);
            $themes[$file]['id'] = $name;
            $themes[$file]['label'] = Inflector::humanize($name);
        }
        return $themes;    
    }    

    protected function getModes()
    {
        $modes = array();
        foreach(glob(ACEDIR . '/build/src-min/mode-*.js') as $path)
        {
            $file = basename($path);
            $name = substr(basename($path, '.js'), 5);
            $modes[$file]['id'] = $name;
            $modes[$file]['label'] = Inflector::humanize($name);
    		}
        return $modes;    
    }    
}
