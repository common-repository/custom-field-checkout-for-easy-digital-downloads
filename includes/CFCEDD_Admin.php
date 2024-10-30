<?php
/**
* This class is loaded on the back-end since its main job is
* to display the Admin to box.
*/
class CFCEDD_Admin {
	
	public function __construct () {
		add_action( 'init', array( $this, 'CFCEDD_init' ) );
		add_action( 'admin_menu', array( $this, 'CFCEDD_admin_menu' ) );
		add_action('admin_enqueue_scripts', array( $this, 'CFCEDD_admin_script' ));
		if ( is_admin() ) {
			return;
		}
		
	}
	public function CFCEDD_admin_script () {
		wp_enqueue_style('cfcedd_admin_css', CFCEDD_PLUGINURL.'css/admin-style.css');
		wp_enqueue_script('cfcedd_admin_js', CFCEDD_PLUGINURL.'js/admin-script.js');
	}
	public function CFCEDD_init () {
		$args = array(
				'label'               => __( 'cfcedd', 'cfcedd' ),
				'show_ui'             => false,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				);
	
		// Registering your Custom Post Type
		register_post_type( 'cfcedd', $args );
		if( current_user_can('administrator') ) {
			if($_REQUEST['action'] == 'add_new_field_cfcedd'){
				if(!isset( $_REQUEST['cfcedd_nonce_field_add'] ) || !wp_verify_nonce( $_POST['cfcedd_nonce_field_add'], 'cfcedd_nonce_action_add' ) ){
	                print 'Sorry, your nonce did not verify.';
	                exit;
	            }else{
					$post_data = array(
										'post_title' => sanitize_text_field($_REQUEST['field_name_cfcedd']),
										'post_type' => 'cfcedd',
										'post_status' => 'publish'
										);
						$post_id = wp_insert_post( $post_data );
						update_post_meta( $post_id, 'field_type_cfcedd', sanitize_text_field($_REQUEST['field_type_cfcedd']) );
						$textToStore = htmlentities($_REQUEST['field_option_cfcedd'], ENT_QUOTES, 'UTF-8');
						update_post_meta( $post_id, 'field_option_cfcedd', $textToStore );
						wp_redirect( admin_url( 'admin.php?page=cfcedd-fields&msg=success') );
					exit;
				}
			}
			if($_REQUEST['action'] == 'update_new_field_cfcedd'){
				if(!isset( $_REQUEST['cfcedd_nonce_field_edit'] ) || !wp_verify_nonce( $_POST['cfcedd_nonce_field_edit'], 'cfcedd_nonce_action_edit' ) ){
	                print 'Sorry, your nonce did not verify.';
	                exit;
	            }else{
					$post_id = sanitize_text_field($_REQUEST['id']);
					$post_data = array(
										'ID'           => $post_id,
										'post_title' => sanitize_text_field($_REQUEST['field_name_cfcedd']),
										);
					wp_update_post( $post_data );
					update_post_meta( $post_id, 'field_type_cfcedd', sanitize_text_field($_REQUEST['field_type_cfcedd']) );
					$textToStore = htmlentities($_REQUEST['field_option_cfcedd'], ENT_QUOTES, 'UTF-8');
					update_post_meta( $post_id, 'field_option_cfcedd', $textToStore );
					wp_redirect( admin_url( 'admin.php?page=cfcedd-fields&msg=success') );
				}
				exit;
			}
			if($_REQUEST['action'] == 'delete_field_cfcedd'){
				$post_id = sanitize_text_field($_REQUEST['id']);
				$post_data = array(
									'ID'          => $post_id,
									'post_status' => 'trash'
									);
				wp_update_post( $post_data );
				wp_redirect( admin_url( 'admin.php?page=cfcedd-fields&msg=success') );
				exit;
			}
		}
	}
	public function CFCEDD_admin_menu () {
		add_menu_page('EDD Checkout Editor', 'EDD Checkout Editor', 'manage_options', 'cfcedd-fields', array( $this, 'CFCEDD_page' ));
		/*add_submenu_page( 'theme-options', 'Settings page title', 'Settings menu label', 'manage_options', 'theme-op-settings', 'wps_theme_func_settings');*/
		/*add_submenu_page( 'theme-options', 'FAQ page title', 'FAQ menu label', 'manage_options', 'theme-op-faq', 'wps_theme_func_faq');
		add_options_page('WP Job Google Location', 'WP Job Google Location', 'manage_options', 'CFCEDD', array( $this, 'CFCEDD_page' ));*/
	}
	public function CFCEDD_page() {
?>
<div class="wrap">
	<div class="headingmc">
		<h1 class="wp-heading-inline"><?php _e('EDD Checkout Editor', 'cfcedd'); ?></h1>
		<a href="#" class="page-title-action addnewfielcfqjma"><?php _e('Add New Field', 'cfcedd'); ?></a>
	</div>
	<hr class="wp-header-end">
	<?php if($_REQUEST['msg'] == 'success'){ ?>
        <div class="notice notice-success is-dismissible"> 
            <p><strong><?php _e('EDD Custom Field Table Updated', 'cfcedd'); ?></strong></p>
        </div>
    <?php } ?>
	<?php
	if($_REQUEST['action']=='edit-cfcedd-fields'){
		$id = sanitize_text_field($_REQUEST['id']);
		$postdata = get_post( $id );
		$field_type_cfcedd = get_post_meta( $id, 'field_type_cfcedd', true );
		$field_option_cfcedd = get_post_meta( $id, 'field_option_cfcedd', true );
		
		
		?>
		<div class="postbox">
				
				<div class="inside">
					<form action="#" method="post" id="edd_custom_form">
						<?php wp_nonce_field( 'cfcedd_nonce_action_edit', 'cfcedd_nonce_field_edit' ); ?>
						<h3><?php _e('EDD Checkout Field Edit', 'cfcedd'); ?></h3>
						<table class="form-table">
							<tr>
								<th scope="row"><label>Field Type</label></th>
								<td>
									<select name="field_type_cfcedd" class="field_type_cfcedd" >
										<option value="text" <?php echo (($field_type_cfcedd=='text')?'selected':'')?>>Text</option>
										<option value="select" <?php echo (($field_type_cfcedd=='select')?'selected':'')?>>Select</option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row"><label>Field Name</label></th>
								<td>
									<input type="text" required value="<?php echo $postdata->post_title;?>" class="regular-text" name="field_name_cfcedd">
								</td>
							</tr>
							<tr class="cfcedd_option" style="<?php echo (($field_type_cfcedd=='select')?'':'display: none;');?>">
								<th scope="row"><label>Field Option</label></th>
								<td>
									<textarea  class="regular-text textheighs" name="field_option_cfcedd" placeholder="Option 1&#10;Option 2"><?php echo $field_option_cfcedd;?></textarea>
									<p class="description">Per Line add one Option</p>
								</td>
							</tr>
						</table>
						
						<p class="submit">
							<input type="hidden" name="action" value="update_new_field_cfcedd">
							<input type="hidden" name="edit_id" value="<?php echo $id;?>" >
							<input type="submit" name="submit"  class="button button-primary" value="Save">
						</p>
					</form>
				</div>
			</div>
		<?php
	}else{
	?>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<th>Field Name</th>
				<th>Field Type</th>
				<th>Key Meta</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$args = array(
					'post_type' => 'cfcedd',
					'post_status' => 'publish',
					'posts_per_page' => -1
					);
			$the_query = new WP_Query( $args );
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$post_id = get_the_ID();
			?>
			<tr>
				<td><?php the_title(); ?></td>
				<td><?php echo get_post_meta( get_the_ID(), 'field_type_cfcedd', true ); ?></td>
				<td>_field_cfcedd<?php echo $post_id; ?></td>
				<td>
					<a class="button button-icon tips icon-edit" href="<?php echo admin_url( 'admin.php?page=cfcedd-fields&action=edit-cfcedd-fields&id='.get_the_ID());?>" ><?php _e('Edit', 'cfcedd'); ?></a>
					<a class="button button-icon tips icon-delete" href="<?php echo admin_url( 'admin.php?action=delete_field_cfcedd&id='.get_the_ID());?>" ><?php _e('Delete', 'cfcedd'); ?></a>
				</td>
			</tr>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</tbody>
	</table>
	
	</div>
	<?php
	}
	?>
</div>

<div class="showpopmain showpopmaina">
		<div class="popupinner">
			<div class="postbox">
				<a class="closeicond" href="#"><span class="dashicons dashicons-no"></span></a>
				<div class="inside">
					<form action="#" method="post" id="edd_custom_form">
						<?php wp_nonce_field( 'cfcedd_nonce_action_add', 'cfcedd_nonce_field_add' ); ?>
						<h3><?php _e('EDD Custom Field Add', 'cfcedd'); ?></h3>
						<table class="form-table">
							<tr>
								<th scope="row"><label>Field Type</label></th>
								<td>
									<select name="field_type_cfcedd" class="field_type_cfcedd">
										<option value="text">Text</option>
										<option value="select">Select</option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row"><label>Field Name</label></th>
								<td>
									<input type="text" required class="regular-text" name="field_name_cfcedd">
								</td>
							</tr>
							<tr class="cfcedd_option" style="display: none;">
								<th scope="row"><label>Field Option</label></th>
								<td>
									<textarea  class="regular-text textheighs" name="field_option_cfcedd" placeholder="Option 1&#10;Option 2"></textarea>
									<p class="description">Per Line add one Option</p>
								</td>
							</tr>
						</table>
						
						<p class="submit">
							<input type="hidden" name="action" value="add_new_field_cfcedd">
							<input type="submit" name="submit"  class="button button-primary" value="Save">
						</p>
					</form>
				</div>
			</div>
			
		</div>
<?php
}



}
?>