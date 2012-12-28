<?php include(dirname(__FILE__).'/functions.js'); ?>


(function() {
    tinymce.create('tinymce.plugins.wpAppbox_CombinedButton', {

    	
        createControl: function(n, cm) {
            switch (n) {
                case 'wpAppbox_AppboxButton':
                var c = cm.createSplitButton('wpAppbox_AppboxButton', {
                    title : 'WP-Appbox',
                    image : '../wp-content/plugins/wp-appbox/buttons/appbox.btn.png',
                    onclick : function() {showMenu();}
                });
                c.onRenderMenu.add(function(c, m) {
                
					m.add({title : '(Mac) App Store', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_appstore_button())
					}});
     
			         m.add({title : 'Google Play', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_googleplay_button())
			         }});

			         m.add({title : 'Windows Store', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_windowsstore_button())
			         }});
	
			         m.add({title : 'Windows Phone Store', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_windowsphonestore_button())
			         }});
		
			         m.add({title : 'AndroidPit', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_androidpit_button())
			         }});
	
			         m.add({title : 'BlackBerry AppWorld', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_bbappworld_button())
			         }});
			         
                });
                return c;
            }
            return null;
        }
    });
    tinymce.PluginManager.add('buttons', tinymce.plugins.wpAppbox_CombinedButton);
})();