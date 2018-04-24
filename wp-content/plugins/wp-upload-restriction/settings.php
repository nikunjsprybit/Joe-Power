<?php
    wp_enqueue_style('wp-upload-restrictions-styles');
   
    $roles = $wpUploadRestriction->getAllRoles();
?>
<div id="message" class="updated fade"><p><?php _e('Settings saved.', 'wp_upload_restriction') ?></p></div>
<div id="error_message" class="error fade"><p><?php _e('Settings could not be saved.', 'wp_upload_restriction') ?></p></div>
<div class="wrap">
    <div class="icon32" id="icon-options-general"><br></div>
    <h2>WP Upload Restriction</h2>  
    
    <div class="role-list">
        <div class="sub-title"><?php _e('Roles', 'wp_upload_restriction'); ?></div>
        <div class="wp-roles">
        <?php foreach($roles as $key => $role):?>
        <a href="<?php print $key; ?>"><?php print $role['name']; ?></a>
        <?php endforeach; ?>
        </div>
    </div>
    
    <div class="mime-list-section">
        <form action="" method="post" id="wp-upload-restriction-form">
            <h2 id="role-name"><?php _e('Role', 'wp_upload_restriction'); ?>: <span></span></h2>
            <div id="mime-list">
 
            </div>
            <input type="hidden" name="role" value="" id="current-role">
            <input type="hidden" name="action" value="save_selected_mimes_by_role">
            <?php wp_nonce_field( 'wp-upload-restrict', 'wpur_nonce' ) ?>
            <p class="submit"></span><input type="button" value="<?php  _e('Save Changes', 'wp_upload_restriction'); ?>"> <span class="submit-loading ajax-loading-img"></p>
        </form>
    </div>
</div>
