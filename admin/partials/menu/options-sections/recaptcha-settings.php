<?php
/**
 * Options page for storing our reCAPTCHA options
 *
 * Page template that houses our reCAPTCHA API keys.
 *
 * @since 6.0.0
 *
 * @package WordPress
 * @subpackage Component
*/

?>

<h3><span><?php _e( 'reCAPTCHA Settings' , $this->text_domain ); ?></span></h3>

<div class="inside">
	
	<p>
		<?php _e( 'reCAPTCHA is a free CAPTCHA service, from Google, that helps protect your site against spam, malicious registrations and other forms of attacks where computers try to disguise themselves as a human. reCAPTCHA will help prevent spammers and bots from submitting data through your MailChimp forms.' , $this->text_domain ); ?>
	</p>
	
	<p>
		<?php echo '<a href="https://www.google.com/recaptcha/admin" target="_blank" title="' . __( 'Get your reCAPTCHA API Key' , $this->text_domain ) . '">' . __( 'Get Your reCAPTCHA API Key' , $this->text_domain ) . '</a>'; ?>
	</p>
	
	<!-- Settings Form -->
	<form action='options.php' method='post'>		
		
		<?php settings_fields( 'yikes_inc_easy_mc_recaptcha_settings_page' ); ?>
		
			<label for="yikes-mailchimp-recaptcha-status" style="display:block;margin-bottom:1em;"><strong><?php _e( 'Enable reCAPTCHA Protection' , $this->text_domain ); ?></strong>
				<input type="checkbox" name="yikes-mailchimp-recaptcha-status" value="1" style="display:block;margin-top:.5em;" <?php checked( get_option( 'yikes-mailchimp-recaptcha-status' , '' ) , '1' ); ?>>
			</label>
			
			<label for="yikes-mailchimp-recaptcha-site-key" style="display:block;margin-bottom:1em;"><strong><?php _e( 'reCAPTCHA Site Key' , $this->text_domain ); ?></strong>
				<input type="text" class="widefat" name="yikes-mailchimp-recaptcha-site-key" id="" value="<?php echo esc_attr( get_option( 'yikes-mailchimp-recaptcha-site-key' , '' ) ); ?>" style="display:block;margin-top:.5em;">
			</label>
			
			<label for="yikes-mailchimp-recaptcha-secret-key"><strong><?php _e( 'reCAPTCHA Secret Key' , $this->text_domain ); ?></strong>
				<input type="text" class="widefat" name="yikes-mailchimp-recaptcha-secret-key" id="" value="<?php echo esc_attr( get_option( 'yikes-mailchimp-recaptcha-secret-key' , '' ) ); ?>" style="display:block;margin-top:.5em;">
			</label>
			
			<a href="#" onclick="jQuery(this).next().slideToggle();" style="display:block;margin-top:.5em;"><?php _e( 'View reCAPTCHA Preview' , $this->text_domain ); ?></a>
				<span style="display: block; width: 100%; display:none; margin:1em 0;">
					<img src="https://developers.google.com/recaptcha/images/newCaptchaAnchor.gif" alt="<?php _e( 'reCAPTCHA Preview' , $this->text_domain ); ?>" style="width:345px;">
				</span>
			
			
		<?php submit_button(); ?>
									
	</form>
	
</div> <!-- .inside -->