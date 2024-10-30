<?php
/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class CFCEDD_Frontend {
	
	public function __construct () {
		add_action( 'edd_purchase_form_user_info_fields', array( $this, 'cfce_edd_display_checkout_fields' ) );
		add_filter( 'edd_payment_meta', array( $this, 'cfce_edd_store_custom_fields' ));
		add_action( 'edd_payment_personal_details_list', array( $this, 'cfce_edd_view_order_details' ), 10, 2 );
		add_action( 'wp_footer', array( $this, 'footerload' ) );
	}
	function cfce_edd_display_checkout_fields() {
		$args = array(
					    'post_type' => 'cfcedd',
						'post_status' => 'publish',
						'posts_per_page' => -1
					);
		$postslist = get_posts( $args );
		if (!empty($postslist)) {
			foreach ($postslist as $postslistk => $postslistv) {
				$post_id = $postslistv->ID;
				$c_type = get_post_meta( $post_id, 'field_type_cfcedd', true );
				$c_key = 'field_cfcedd'.$post_id;
				?>
				  <p id="edd-<?php echo $c_key; ?>-wrap">
	        		<label class="edd-label" for="edd-<?php echo $c_key; ?>"><?php echo $postslistv->post_title; ?></label>
				<?php
				if ($c_type=='select') {
					$field_option_cfcedd = get_post_meta( $post_id, 'field_option_cfcedd', true );
					$field_option_cfceddar = explode("\n", $field_option_cfcedd);
					$field_option_cfceddarr = array();
					?>
					<select  class="edd-input custom_select_edd"  >
						<option value="">Select</option>
					<?php
					foreach ($field_option_cfceddar as $keya => $valuea) {
						echo '<option>'.$valuea.'</option>';
					}
					?>
					</select>
					<input class="edd-input" type="hidden" name="edd_<?php echo $c_key; ?>" id="edd-<?php echo $c_key; ?>" placeholder="<?php echo $postslistv->post_title; ?>" />
					<?php
				}else{
					?>
					<input class="edd-input" type="text" name="edd_<?php echo $c_key; ?>" id="edd-<?php echo $c_key; ?>" placeholder="<?php echo $postslistv->post_title; ?>" />
					<?php
				}
	?>
	  
	        
	    </p>
	    <?php
	    	}
		}
	}
	function footerload(){
		?>
		<Script>
			jQuery( document ).ready(function() {
			    jQuery(".custom_select_edd").change(function(){
				  jQuery(this).next("input").val(jQuery(this).val());
				});
			});
		</Script>
		<?php
	}

	function cfce_edd_store_custom_fields( $payment_meta ) {

		if( did_action( 'edd_purchase' ) ) {
			$args = array(
					    'post_type' => 'cfcedd',
						'post_status' => 'publish',
						'posts_per_page' => -1
					);
			$postslist = get_posts( $args );
			if (!empty($postslist)) {
				foreach ($postslist as $postslistk => $postslistv) {
					$post_id = $postslistv->ID;
					$c_type = get_post_meta( $post_id, 'field_type_cfcedd', true );
					$c_key = 'field_cfcedd'.$post_id;
					$payment_meta[$c_key] = isset( $_POST['edd_'.$c_key] ) ? sanitize_text_field( $_POST['edd_'.$c_key] ) : '';
				}
			}
			
		}

		return $payment_meta;
	}
	
	function cfce_edd_view_order_details( $payment_meta, $user_info ) {
		$args = array(
					    'post_type' => 'cfcedd',
						'post_status' => 'publish',
						'posts_per_page' => -1
					);
		$postslist = get_posts( $args );
		
	?>
	    <div class="column-container">
	    	<?php
	    	if (!empty($postslist)) {
				foreach ($postslist as $postslistk => $postslistv) {
					$post_id = $postslistv->ID;
					$c_type = get_post_meta( $post_id, 'field_type_cfcedd', true );
					$c_key = 'field_cfcedd'.$post_id;
					$valca = isset( $payment_meta[$c_key] ) ? $payment_meta[$c_key] : 'none';
					?>
					<div class="column">
			    		<strong><?php echo $postslistv->post_title;?>: </strong>
			    		 <?php echo $valca; ?>
			    	</div>
					<?php
				}
			}
	    	?>
	    	
	    </div>
	<?php
	}
	
}