<?php include(dirname(__FILE__).'/functions.js'); ?>

<?php 
	require('../../../../wp-blog-header.php'); 
	$settings = get_option("wpAppbox");
?>


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
                
                <?php if($settings['wpAppbox_enabled_appstore'] == '1') { ?>
					m.add({title : '(Mac) App Store', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_appstore_button())
					}});
				<?php } ?>
     
     			<?php if($settings['wpAppbox_enabled_googleplay'] == '1') { ?>	
			         m.add({title : 'Google Play', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_googleplay_button())
			         }});
			   	<?php } ?>
			         
			  	<?php if($settings['wpAppbox_enabled_windowsstore'] == '1') { ?>	
			         m.add({title : 'Windows Store', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_windowsstore_button())
			         }});
	   			<?php } ?>
	
				<?php if($settings['wpAppbox_enabled_windowsphone'] == '1') { ?>
			         m.add({title : 'Windows Phone Store', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_windowsphonestore_button())
			         }});
		 		 <?php } ?>
		
				<?php if($settings['wpAppbox_enabled_androidpit'] == '1') { ?>
			         m.add({title : 'AndroidPit', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_androidpit_button())
			         }});
	  			<?php } ?>
	
				<?php if($settings['wpAppbox_enabled_blackberryworld'] == '1') { ?>
			         m.add({title : 'BlackBerry World', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_blackberryworld_button())
			         }});
		   		<?php } ?>
			        
				<?php if($settings['wpAppbox_enabled_firefoxmarketplace'] == '1') { ?>  
			         m.add({title : 'Firefox Marketplace', onclick : function() {
			         	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_firefoxmarketplace_button())
			         }});
	  			<?php } ?>
			   
			   	<?php if($settings['wpAppbox_enabled_chromewebstore'] == '1') { ?>      
			         m.add({title : 'Chrome Web Store', onclick : function() {
			         	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_chromewebstore_button())
			         }});
	 			<?php } ?>
			         
                });
                return c;
            }
            return null;
        }
    });
    tinymce.PluginManager.add('wpAppbox', tinymce.plugins.wpAppbox_CombinedButton);
})();