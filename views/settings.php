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
?>
<h1><?php echo __('Ace settings');?></h1>
<form action="<?php echo get_url('plugin/ace/save'); ?>" method="post">
    <fieldset>
      <legend style="margin-left: 1em;"><strong><?php echo __('Look and feel'); ?></strong></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label><?php echo __('Theme'); ?> </label></td>
                <td class="field">
                  <select name="aceTheme" id="aceTheme">
                    <?php foreach ($themes as $id => $value): ?>
                    <option value="<?php echo $value['id'] ?>"<?php echo (isset($settings['Theme'])&&($settings['Theme']==$value['id'])) ? 'selected="selected"' : ''; ?>><?php echo $value['label'] ?></option>
                    <?php endforeach; ?>
                  </select>
                
                </td>
                <td class="help"><?php echo __('You can obtain other themes at.'); ?></td>
            </tr>
            <tr>
                <td class="label"><label><?php echo __('Mode'); ?> </label></td>
                <td class="field">
                  <select name="aceMode" id="aceMode">
                    <?php foreach ($modes as $id => $value): ?>
                    <option value="<?php echo $value['id'] ?>"<?php echo (isset($settings['Mode'])&&($settings['Mode']==$value['id'])) ? 'selected="selected"' : ''; ?>><?php echo $value['label'] ?></option>
                    <?php endforeach; ?>
                  </select>
                
                </td>
                <td class="help"><?php echo __('Select default syntax highlighting mode'); ?></td>
            </tr>
            <tr>
                <td class="label"><label><?php echo __('Font size'); ?> </label></td>
                <td class="field">
                  <input type="number" id="aceFontSize" name="aceFontSize" min="7" max="18" step="1" value="<?php echo isset($settings['FontSize']) ? $settings['FontSize'] : AceController::DEFAULT_FONT_SIZE; ?>"> <?php echo __('px'); ?>
                </td>
                <td class="help"><?php echo __('Editor font size in pixels.'); ?></td>
            </tr>
            <tr>
                <td class="label"><label><?php echo __('Mouse scroll speed'); ?> </label></td>
                <td class="field">
                  <input type="number" id="aceScrollSpeed" name="aceScrollSpeed" min="1" max="10" step="1" value="<?php echo isset($settings['ScrollSpeed']) ? $settings['ScrollSpeed'] : AceController::DEFAULT_SCROLL_SPEED; ?>"> <?php echo __('lines'); ?>
                </td>
                <td class="help"><?php echo __('How fast should your mousewheel scroll the editor'); ?></td>
            </tr>
            <tr>
                <td class="label"><label><?php echo __('Editor height'); ?> </label></td>
                <td class="field">
                  <input type="number" id="aceEditorHeight" name="aceEditorHeight" min="100" max="1000" step="10" value="<?php echo isset($settings['EditorHeight']) ? $settings['EditorHeight'] : AceController::DEFAULT_EDITOR_HEIGHT; ?>"> <?php echo __('px'); ?>
                </td>
                <td class="help"><?php echo __('Default editor box height in pixels'); ?></td>
            </tr>
            <tr>
                <td class="label"><label><?php echo __('Highlight active line'); ?> </label></td>
                <td class="field">
                  <select name="aceHighlightActiveLine" id="aceHighlightActiveLine">
                    <option value="true" <?php echo (isset($settings['HighlightActiveLine'])&&($settings['HighlightActiveLine']=='true')) ? 'selected="selected"' : ''; ?>><?php echo __('Yes');?></option>
                    <option value="false" <?php echo (isset($settings['HighlightActiveLine'])&&($settings['HighlightActiveLine']=='false')) ? 'selected="selected"' : ''; ?>><?php echo __('No');?></option>
                  </select>
                </td>
                <td class="help"></td>
            </tr>
            <tr>
                <td class="label"><label><?php echo __('Wrap lines'); ?> </label></td>
                <td class="field">
                  <select name="aceWrapLines" id="aceWrapLines">
                    <option value="true" <?php echo (isset($settings['WrapLines'])&&($settings['WrapLines']=='true')) ? 'selected="selected"' : ''; ?>><?php echo __('Yes');?></option>
                    <option value="false" <?php echo (isset($settings['WrapLines'])&&($settings['WrapLines']=='false')) ? 'selected="selected"' : ''; ?>><?php echo __('No');?></option>
                  </select> <?php echo __('at'); ?> 
                  <input type="number" id="aceWrapRange" name="aceWrapRange" min="20" max="200" step="4" value="<?php echo isset($settings['WrapRange']) ? $settings['WrapRange'] : AceController::DEFAULT_WRAP_RANGE; ?>"> <?php echo __('columns'); ?>
                </td>
                <td class="help"><?php echo __('Wrap long lines'); ?></td>
            </tr>
            <tr>
                <td class="field" colspan="3">
<div id="acecontainer" style="position: relative; display:block; height: 100px; width: 100%; border: 1px solid #888;">
                                                        <div id="previewAce" style="width:100%; height: 100px">
                                                        </div></div>
<textarea id="previewTextarea" style="display: none">
<?php echo file_get_contents(realpath(PLUGINS_ROOT).'/ace/AceController.php'); ?>
</textarea>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
      <legend style="margin-left: 1em;"><strong><?php echo __('Cookies'); ?></strong></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label><?php echo __('How long to store scroll and mode settings?'); ?> </label></td>
                <td class="field">
                  <select name="aceCookieLife" id="aceCookieLife">
                    <option value="-1" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='-1')) ? 'selected="selected"' : ''; ?>><?php echo __('Session-long'); ?></option>
                    <option value="1" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='1')) ? 'selected="selected"' : ''; ?>><?php echo __('1 Day'); ?></option>
                    <option value="2" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='2')) ? 'selected="selected"' : ''; ?>><?php echo __('2 Days'); ?></option>
                    <option value="7" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='7')) ? 'selected="selected"' : ''; ?>><?php echo __('1 Week'); ?></option>
                    <option value="14" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='14')) ? 'selected="selected"' : ''; ?>><?php echo __('2 Weeks'); ?></option>
                    <option value="28" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='28')) ? 'selected="selected"' : ''; ?>><?php echo __('1 Month'); ?></option>
                    <option value="365" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='365')) ? 'selected="selected"' : ''; ?>><?php echo __('1 Year'); ?></option>
                    <option value="3650" <?php echo (isset($settings['CookieLife'])&&($settings['CookieLife']=='3650')) ? 'selected="selected"' : ''; ?>><?php echo __('10 Years'); ?></option>
                  </select>
                </td>
                <td class="help"><?php echo __('Individual settings for page parts, layouts and snippets - scroll position and syntax mode will be stored in cookie of your browser. Choose the default lifetime of such cookie.'); ?></td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
      <legend style="margin-left: 1em;"><strong><?php echo __('Integration'); ?></strong></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label><?php echo __('Integrate Ace with Layout editing?'); ?> </label></td>
                <td class="field">
                  <select name="aceLayoutIntegrate" id="aceLayoutIntegrate">
                    <option value="true" <?php echo (isset($settings['LayoutIntegrate'])&&($settings['LayoutIntegrate']=='true')) ? 'selected="selected"' : ''; ?>><?php echo __('Yes'); ?></option>
                    <option value="false" <?php echo (isset($settings['LayoutIntegrate'])&&($settings['LayoutIntegrate']=='false')) ? 'selected="selected"' : ''; ?>><?php echo __('No'); ?></option>
                  </select>
                </td>
                <td class="help"><?php echo __('Note that Ace won`t take precedence of other plugins being integrated with Layout (eg. Codemirror).'); ?></td>
            </tr>
        </table>
    </fieldset>
    <p>
        <?php echo __("<b>Note:</b> it may be neccesary to <b>hit F5</b> in editing pages in order to apply the new settings") ?>
    </p>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
    </p>
</form>
<script>
var textarea = $('#previewTextarea');
var editor = ace.edit('previewAce');

function updatePreview() {
        $('#acecontainer').css('height',$('#aceEditorHeight').val()+'px');
        $('#previewAce').css('height',$('#aceEditorHeight').val()+'px');
        editor.setTheme('ace/theme/'+$('#aceTheme').val());
        editor.setBehavioursEnabled(true);
        editor.setScrollSpeed($('#aceScrollSpeed').val());
        editor.setFontSize($('#aceFontSize').val()+'px');
        
        editor.setPrintMarginColumn($('#aceWrapRange').val());
        doHighlight = ($('#aceHighlightActiveLine').val()=='true') ? true : false;
        editor.setHighlightActiveLine(doHighlight);
        editor.setHighlightSelectedWord(true);
        editor.getSession().setWrapLimitRange($('#aceWrapRange').val(),$('#aceWrapRange').val());
        doWrap = ($('#aceWrapLines').val()=='true') ? true : false;
        editor.getSession().setUseWrapMode(doWrap);
        editor.getSession().setMode('ace/mode/'+$('#aceMode').val());
}

$(document).ready(function(){
        updatePreview();
        editor.getSession().setValue(textarea.val());
        editor.focus();
});
$('input, select').live('change', function(){
        updatePreview();
});
</script>
