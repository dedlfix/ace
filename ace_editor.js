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

function insertModeChange(elem, id) {
    if ($('#aceoptions' + id).length == 0) {
        elem.after(
            '<span id="aceoptions' + id + '" class="ace_options">'+
            '<label for="acemode_select_' + id + '" ' +
                'id="acemode_label_' + id + '">' + aceStrMode + '</label>' +
            '<select id="acemode_select_' + id + '">' +
            '<option value="text">Plain text</option>' +
            '<option value="css">CSS</option>' +
            '<option value="html">HTML</option>' +
            '<option value="javascript">Javascript</option>' +
            '<option value="json">JSON</option>' +
            '<option value="markdown">Markdown</option>' +
            '<option value="php">PHP</option>' +
            '<option value="textile">Textile</option>' +
            '<option value="xml">XML</option>' +
            '</select> ' +
            '<a href="../../plugin/ace/settings" target="_blank">[' + aceStrConfig + ']</a>' +
            '</span>');
    }
}

function setupEditor(id, modeElement, textareaElement) {
    var mode = $.cookie('aceM' + id);
    if (mode == null) mode = aceMode;  
    
    insertModeChange(modeElement, id);
    
    $(textareaElement).after('<div id="aceeditor' + id + '" style="height: ' + aceEditorHeight + 'px"></div>');
    var ed = ace.edit('aceeditor' + id);
    
    ed.setTheme('ace/theme/' + aceTheme);
    ed.setBehavioursEnabled(true);
    ed.setScrollSpeed(aceScrollSpeed);
    ed.setFontSize(aceFontSize + 'px');
    ed.setPrintMarginColumn(aceWrapRange);
    ed.setHighlightActiveLine(aceHighlightActiveLine);
    ed.setHighlightSelectedWord(true);
    var textarea = $(textareaElement);
    textarea.hide();
    ed.getSession().setValue(textarea.val());
    
    ed.getSession().setWrapLimitRange(aceWrapRange, aceWrapRange);
    ed.getSession().setUseWrapMode(aceWrapLines);

    $('#acemode_select_' + id).val(mode);
    ed.getSession().setMode('ace/mode/' + mode);

    var curPos = ($.cookie('aceCur' + id) != null) ? $.cookie('aceCur' + id).split('-') : null;
    if (curPos != null) {
        ed.gotoLine(parseInt(curPos[0]) + 1, parseInt(curPos[1]));
    }
    var topScroll = $.cookie('aceScr' + id);
    if (topScroll != null) {
        ed.getSession().setScrollTop(topScroll);
    }

    ed.getSession().on('change', function() {
        textarea.val(ed.getSession().getValue());
        setConfirmUnload(true);
    });
    
    ed.getSession().on('changeScrollTop', function(num) {
        if (typeof(num) == 'number') {
            $.cookie('aceScr' + id, num);
        } else {
            $.removeCookie('aceScr' + id);
        }
    });

    ed.getSession().selection.on('changeCursor', function(num) {
        var cursor = ed.getSession().selection.getCursor();
        $.cookie('aceCur' + id, cursor.row + '-' + cursor.column);
    });

    $('#acemode_select_' + id).live('change', function() {
        ed.getSession().setMode('ace/mode/' + $(this).val());
        $.cookie('aceM' + id, $(this).val());
    });

    ed.focus();

    return ed;
}

function insertPageAce(elem)  {
    var partId = elem.attr('id').slice(5, -8);
    var pId = 'P' + window.location.pathname.split("/").pop() + '-' + partId;

    var ed = setupEditor(pId, $('#part_' + partId + '_filter_id'), $('#part_' + partId + '_content'));

    if ($('#page_title').val().trim().length > 0)
        ed.focus();
}

function removePageAce(partId) {
    var pId = 'P' + window.location.pathname.split("/").pop() + '-' + partId;
    $('#aceeditor' + pId).remove();
    $('#aceoptions' + pId).remove();
}

function insertSnippetAce() {
    var sId = 'S' + window.location.pathname.split("/").pop();
    setupEditor(sId, $('#snippet_filter_id'), $('#snippet_content'));
}

function removeSnippetAce() {
    var sId = 'S' + window.location.pathname.split("/").pop();
    $('#aceeditor' + sId).remove();
    $('#aceoptions' + sId).remove();
}

function insertLayoutAce() {
    var lId = 'L' + window.location.pathname.split("/").pop();
    setupEditor(lId, $('#layout_content').prev(), $('#layout_content'));
}

$(document).ready(function() {

    if (aceCookieLife != -1) {
        $.cookie.defaults = {
            expires: aceCookieLife
        };
    }

    // the filter select changes from some state
    $('.filter-selector').live('wolfSwitchFilterOut', function(event, filtername, elem) {
        if (filtername == 'ace') {
            $('#' + elem.attr('id')).show();
            if ($('#body_page_edit').length > 0) { // we are in PAGE
                removePageAce(elem.attr('id').slice(5, -8));
            }
            if ($('#body_snippet_edit').length > 0) { // we are in SNIPPET
                removeSnippetAce();
            }
        }
    });

    // the filter select changes to some state
    $('.filter-selector').live('wolfSwitchFilterIn', function(event, filtername, elem) {
        if (filtername == 'ace') {
            if ($('#body_page_edit').length > 0) { // we are in PAGE
                insertPageAce(elem);
            }
            if ($('#body_snippet_edit').length > 0) { // we are in SNIPPET
                insertSnippetAce();
            }
        }
    });

    if (($("#body_layout_edit").length > 0) && (typeof(setCM) == 'undefined') && aceLayoutIntegrate) {
        insertLayoutAce();
    }

});
