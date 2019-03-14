CKEDITOR.plugins.add('imagebrowser', {
    "init": function (editor) {
        if (typeof(editor.config.imageBrowser_listUrl) === 'undefined' || editor.config.imageBrowser_listUrl === null) {
            return;
        }
        editor.config.filebrowserImageBrowseUrl = editor.config.imageBrowser_pluginPath + "/js/ckeditor/imagebrowser/browser/browser.html?listUrl=" + encodeURIComponent(editor.config.imageBrowser_listUrl);
    }
});
