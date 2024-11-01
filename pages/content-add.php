<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'content-add-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$gtabber_errors = array();
$gtabber_success = '';
$gtabber_error_found = FALSE;

// Preset the form fields
$form = array(
	'gtabber_text' => '',
	'gtabber_link' => '',
	'gtabber_group' => '',
	'gtabber_group' => '',
	'gtabber_id' => ''
);

// Form submitted, check the data
if (isset($_POST['gtabber_form_submit']) && $_POST['gtabber_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('gtabber_form_add');
	
	$form['gtabber_text'] = isset($_POST['gtabber_text']) ? sanitize_text_field($_POST['gtabber_text']) : '';
	if ($form['gtabber_text'] == '')
	{
		$gtabber_errors[] = __('Please enter tabber text.', 'wp-tabber-widget');
		$gtabber_error_found = TRUE;
	}	
	$form['gtabber_link'] = isset($_POST['gtabber_link']) ? sanitize_text_field($_POST['gtabber_link']) : '';
	$form['gtabber_link'] = esc_url_raw( $form['gtabber_link'] );
	$form['gtabber_group'] = isset($_POST['gtabber_group']) ? sanitize_text_field($_POST['gtabber_group']) : '';
	if ($form['gtabber_group'] == '')
	{
		$gtabber_errors[] = __('Please select existing group (or) enter new tabber group.', 'wp-tabber-widget');
		$gtabber_error_found = TRUE;
	}
	$form['gtabber_target'] = isset($_POST['gtabber_target']) ? sanitize_text_field($_POST['gtabber_target']) : '';

	//	No errors found, we can add this Group to the table
	if ($gtabber_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".GTabberTable."`
			(`gtabber_text`, `gtabber_link`, `gtabber_group`, `gtabber_target`)
			VALUES(%s, %s, %s, %s)",
			array($form['gtabber_text'], $form['gtabber_link'], $form['gtabber_group'], $form['gtabber_target'])
		);
		$wpdb->query($sql);
		
		$gtabber_success = __('New details was successfully added.', 'wp-tabber-widget');
		
		// Reset the form fields
		$form = array(
			'gtabber_text' => '',
			'gtabber_link' => '',
			'gtabber_group' => '',
			'gtabber_target' => '',
			'gtabber_id' => ''
		);
	}
}

if ($gtabber_error_found == TRUE && isset($gtabber_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $gtabber_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($gtabber_error_found == FALSE && strlen($gtabber_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $gtabber_success; ?> 
		<a href="<?php echo WP_gtabber_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'wp-tabber-widget'); ?></a></strong></p>
	</div>
	<?php
}
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Wp tabber widget', 'wp-tabber-widget'); ?></h2>
	<form name="gtabber_form" method="post" action="#" onsubmit="return gtabber_submit()"  >
      <h3><?php _e('Add details', 'wp-tabber-widget'); ?></h3>
      
		<label for="tag-title"><?php _e('Tabber group', 'wp-tabber-widget'); ?></label>
		<select style="width:190px;" name="gtabber_group_drop" id="gtabber_group_drop" onchange="gtabber_group_load(this.value)">
		<option value=''><?php _e('Please select (or) enter new', 'wp-tabber-widget'); ?></option>
		<?php
		$data = $wpdb->get_results("SELECT distinct gtabber_group FROM ".GTabberTable);
		if ( !empty($data) ) 
        {
			foreach ( $data as $data ) 
			{
				?>
				<option value="<?php echo stripslashes($data->gtabber_group); ?>"><?php echo stripslashes($data->gtabber_group); ?></option>
				<?php
			}
		}
		?>
		</select>
		<input name="gtabber_group" type="text" id="gtabber_group" value="" maxlength="25" size="30" /></td>
		<p><?php _e('Select existing group (or) enter new tabber group', 'wp-tabber-widget'); ?></p>
		
		<label for="tag-title"><?php _e('Tabber text', 'wp-tabber-widget'); ?></label>
		<input name="gtabber_text" type="text" id="gtabber_text" value="" maxlength="250" size="90" />
		<p><?php _e('Please enter your tabber content.', 'wp-tabber-widget'); ?></p>
		
		<label for="tag-title"><?php _e('Link', 'wp-tabber-widget'); ?></label>
		<input name="gtabber_link" type="text" id="gtabber_link" value="" size="90" />
		<p><?php _e('When someone clicks on the message, where do you want to send them.', 'wp-tabber-widget'); ?></p>
		
		<label for="tag-title"><?php _e('Target', 'wp-tabber-widget'); ?></label>
		<select name="gtabber_target" id="gtabber_target">
            <option value='_blank'>_blank</option>
            <option value='_parent'>_parent</option>
            <option value='_self'>_self</option>
            <option value='_top'>_top</option>
          </select>
		 <p><?php _e('Do you want to open link in new window?', 'wp-tabber-widget'); ?></p>
	  	  
      <input name="gtabber_id" id="gtabber_id" type="hidden" value="">
      <input type="hidden" name="gtabber_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'wp-tabber-widget'); ?>" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="gtabber_redirect()" value="<?php _e('Cancel', 'wp-tabber-widget'); ?>" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="gtabber_help()" value="<?php _e('Help', 'wp-tabber-widget'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('gtabber_form_add'); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'content-add-nonce' ); ?>"/>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'wp-tabber-widget'); ?>
	<a target="_blank" href="<?php echo WP_gtabber_FAV; ?>"><?php _e('click here', 'wp-tabber-widget'); ?></a>
</p>
</div>