<?php
	// lets confirm the user has a valid API key stored
	if( $this->is_user_mc_api_valid_form( false ) == 'valid' ) {
		/// Check for a transient, if not - set one up for one hour
		if ( false === ( $list_data = get_transient( 'yikes-easy-mailchimp-list-data' ) ) ) {
			// initialize MailChimp Class
			$MailChimp = new MailChimp( get_option( 'yikes-mc-api-key' , '' ) );
			// retreive our list data
			$list_data = $MailChimp->call( 'lists/list' , array( 'apikey' => get_option( 'yikes-mc-api-key' , '' ) ) );
			// set our transient
			set_transient( 'yikes-easy-mailchimp-list-data', $list_data, 1 * HOUR_IN_SECONDS );
		}
	} else {
		wp_die( __( 'It looks like you need to re-validate your MailChimp API key before you can continue.' , $this->text_domain ) , 500 );
	}
	
	// print_r($list_data);
	
	wp_register_script( 'yikes-easy-mc-manage-forms-script', YIKES_MC_URL . 'admin/js/yikes-inc-easy-mailchimp-manage-forms.js', array( 'jquery' ), $this->version, false );
	$localized_data = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( "create_mailchimp_form" ),
		'success_redirect' => admin_url( 'admin.php?page=yikes-mailchimp-edit-form' ),
	);
	wp_localize_script( 'yikes-easy-mc-manage-forms-script', 'object', $localized_data );
	wp_enqueue_script( 'yikes-easy-mc-manage-forms-script' );
?>

<div class="wrap">

	<!-- Freddie Logo -->
	<img src="<?php echo YIKES_MC_URL . 'includes/images/MailChimp_Assets/Freddie_60px.png'; ?>" alt="Freddie - MailChimp Mascot" style="float:left;margin-right:10px;" />
		
	<h2>Easy MailChimp by Yikes Inc. | <?php _e( 'Manage Lists' , $this->text_domain ) ?></h2>				
		
	<!-- Settings Page Description -->
	<p class="yikes-easy-mc-about-text about-text"><?php _e( 'Make edits to your MailChimp lists on the following page. Select a list to make edits to it.' , $this->text_domain ); ?></p>
		
	<!-- entire body content -->
		<div id="poststuff">
	
			<div id="post-body" class="metabox-holder columns-2">
			
				<!-- main content -->
				<div id="post-body-content">
					
					<div class="meta-box-sortables ui-sortable">
						
						<div class="postbox yikes-easy-mc-postbox">
														
								<table class="wp-list-table widefat fixed posts" cellspacing="0" id="yikes-easy-mc-manage-forms-table">
		
									<!-- TABLE HEAD -->
									<thead>
										<tr>
											<th id="cb" class="manage-column column-cb check-column" scope="col"><input type="checkbox" /></th>
											<th id="columnname" class="manage-column column-columnname" scope="col"><?php _e( 'List Name' , $this->text_domain ); ?></th>
											<th id="columnname" class="manage-column column-columnname num" scope="col"><?php _e( 'Subscriber Count' , $this->text_domain ); ?></th>
										</tr>
									</thead>
									<!-- end header -->
									
									<!-- FOOTER -->
									<tfoot>
										<tr>
											<th class="manage-column column-cb check-column" scope="col"><input type="checkbox" /></th>
											<th class="manage-column column-columnname" scope="col"><?php _e( 'Form Name' , $this->text_domain ); ?></th>
											<th class="manage-column column-columnname num" scope="col"><?php _e( 'Subscriber Count' , $this->text_domain ); ?></th>
										</tr>
									</tfoot>
									<!-- end footer -->
									
									<!-- TABLE BODY -->
									<tbody>
										<?php if( count( $list_data['total'] ) > 0 ) { 
												$i = 1;
												foreach( $list_data['data'] as $list ) { 
										?>
											<tr class="<?php if( $i % 2 == 0 ) { echo 'alternate'; } ?>">
												<th class="check-column" scope="row"><input type="checkbox" /></th>
												<td class="column-columnname"><?php echo stripslashes( $list['name'] ); ?>
													<div class="row-actions">
														<span><a href="<?php echo add_query_arg( array( 'list-id' => $list['id'] ) , admin_url( 'admin.php?page=yikes-mailchimp-view-list' ) ); ?>"><?php _e( "View" , $this->text_domain ); ?></a> |</span>
														<span><a href="<?php echo add_query_arg( array( 'list-id' => $list['id'] ) , admin_url( 'admin.php?page=yikes-mailchimp-edit-list' ) ); ?>"><?php _e( "Edit Fields" , $this->text_domain ); ?></a> |</span>
														<span><a href="<?php echo add_query_arg( array( 'action' => '', 'mailchimp-list' => $list['id'] , 'nonce' => wp_create_nonce( 'duplicate-mailchimp-form-'.$list['id'] ) ) , admin_url( 'admin.php?page=yikes-inc-easy-mailchimp' ) ); ?>"><?php _e( "Delete" , $this->text_domain ); ?></a> |</span>
														<span><a href="#" class="view-yikes-mc-list-info"><?php _e( "List Info." , $this->text_domain ); ?></a></span>														
													</div>
												</td>
												<td class="column-columnname num"><?php echo $list['stats']['member_count']; ?></td>
											</tr>
										<?php 	
												$i++;
												}
											} else { ?>
											<tr class="no-items">
												<td class="colspanchange" colspan="3" style="padding:25px 0 25px 25px;"><em><?php _e( 'No MailChimp lists found. Head over to' , $this->text_domain ); ?></em></td>
											</tr>
										<?php } ?>
									</tbody>
								</table> 
								<!-- end table -->
														
						</div> <!-- .postbox -->
						
					</div> <!-- .meta-box-sortables .ui-sortable -->
					
				</div> <!-- post-body-content -->
				
				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">
										
					<div class="meta-box-sortables">
						
						<?php 
							// display, show some love container
							$this->generate_show_some_love_container(); 
						?>
						
					</div> <!-- .meta-box-sortables -->
					
				</div> <!-- #postbox-container-1 .postbox-container -->
				
			</div> <!-- #post-body .metabox-holder .columns-2 -->
			
			<br class="clear">
		</div> <!-- #poststuff -->

</div>