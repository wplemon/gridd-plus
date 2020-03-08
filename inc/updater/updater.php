<?php
/**
 * The plugin updater.
 *
 * @package Gridd Plus
 * @since 1.0
 */

if ( ! defined( 'WPLEMON_STORE_URL' ) ) {
	define( 'WPLEMON_STORE_URL', 'https://wplemon.com' );
}

if ( ! defined( 'GRIDD_PLUS_PLUGIN_LICENSE_PAGE' ) ) {
	define( 'GRIDD_PLUS_PLUGIN_LICENSE_PAGE', 'gridd-plus-license' );
}

if ( ! defined( 'GRIDD_PLUS_PLUGIN_DB_PREFIX' ) ) {
	define( 'GRIDD_PLUS_PLUGIN_DB_PREFIX', 'gridd_plus_license' );
}

if ( ! defined( 'GRIDD_PLUS_ITEM_NAME' ) ) {
	define( 'GRIDD_PLUS_ITEM_NAME', 'Gridd Plus' );
}

if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	include __DIR__ . '/EDD_SL_Plugin_Updater.php';
}

add_action(
	'admin_init',
	/**
	 * Run the updater.
	 *
	 * @since 1.0
	 * @return void
	 */
	function() {

		// Setup the updater.
		$edd_updater = new EDD_SL_Plugin_Updater(
			WPLEMON_STORE_URL,
			GRIDD_PLUS_PLUGIN_FILE,
			[
				'version' => GRIDD_PLUS_VERSION,
				'license' => trim( get_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' ) ),
				'item_id' => 3438,
				'author'  => 'Ari Stathopoulos',
				'beta'    => false,
			]
		);
	},
	0
);

add_action(
	'admin_menu',
	/**
	 * Adds the plugin page.
	 *
	 * @since 1.0
	 * @return void
	 */
	function() {
		add_plugins_page(
			esc_html__( 'Gridd Plus License', 'gridd-plus' ),
			esc_html__( 'Gridd Plus License', 'gridd-plus' ),
			'manage_options',
			GRIDD_PLUS_PLUGIN_LICENSE_PAGE,
			/**
			 * Callback for the page content.
			 *
			 * @since 1.0
			 * @return void
			 */
			function() {
				$license = get_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' );
				$status  = get_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_status' );
				?>
				<div class="wrap">
					<h2><?php esc_html_e( 'Gridd Plus License', 'gridd-plus' ); ?></h2>
					<form method="post" action="options.php">
						<?php settings_fields( GRIDD_PLUS_PLUGIN_DB_PREFIX ); ?>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row" valign="top">
										<?php esc_html_e( 'License Key', 'gridd-plus' ); ?>
									</th>
									<td>
										<input
											id="<?php echo esc_attr( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' ); ?>"
											name="<?php echo esc_attr( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' ); ?>"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr( $license ); ?>"
										/>
										<label class="description" for="<?php echo esc_attr( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' ); ?>">
											<?php esc_html_e( 'Enter your license key', 'gridd-plus' ); ?>
										</label>
									</td>
								</tr>
								<?php if ( false !== $license ) : ?>
									<tr valign="top">
										<th scope="row" valign="top">
											<?php esc_html_e( 'Activate License', 'gridd-plus' ); ?>
										</th>
										<td>
											<?php if ( false !== $status && 'valid' === $status ) : ?>
												<span style="color:green;"><?php esc_html_e( 'active', 'gridd-plus' ); ?></span>
												<?php wp_nonce_field( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce', GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce' ); ?>
												<input type="submit" class="button-secondary" name="gridd_plus_license_deactivate" value="<?php esc_html_e( 'Deactivate License', 'gridd-plus' ); ?>"/>
											<?php else : ?>
												<?php wp_nonce_field( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce', GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce' ); ?>
												<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php esc_html_e( 'Activate License', 'gridd-plus' ); ?>"/>
											<?php endif; ?>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<?php submit_button(); ?>
					</form>
				<?php
			}
		);
	}
);

add_action(
	'admin_init',
	/**
	 * Create the settings in the options table.
	 *
	 * @since 1.0
	 * @return void
	 */
	function() {
		register_setting(
			GRIDD_PLUS_PLUGIN_DB_PREFIX,
			GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key',
			/**
			 * Sanitization callback.
			 *
			 * @since 1.0
			 * @param string $new The license key.
			 * @return string
			 */
			function( $new ) {
				$old = get_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' );
				if ( $old && $old !== $new ) { // New license has been entered, so must reactivate.
					delete_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_status' );
				}
				return trim( $new );
			}
		);
	}
);

add_action(
	'admin_init',
	/**
	 * Handles license actions.
	 *
	 * @since 1.0
	 * @return void
	 */
	function() {

		/**
		 * Activates the license.
		 * Listen for our activate button to be clicked.
		 *
		 * @since 1.0
		 */
		if ( isset( $_POST['edd_license_activate'] ) ) {

			// Run a quick security check.
			if ( ! check_admin_referer( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce', GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce' ) ) {
				return; // Get out if we didn't click the Activate button.
			}

			// Retrieve the license from the database.
			$license = trim( get_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' ) );

			// Data to send in our API request.
			$api_params = [
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_name'  => urlencode( GRIDD_PLUS_ITEM_NAME ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
				'url'        => home_url(),
			];

			// Call the custom API.
			$response = wp_remote_post(
				WPLEMON_STORE_URL,
				[
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				]
			);

			// Make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				$message = esc_html__( 'An error occurred, please try again.', 'gridd-plus' );
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				}
			} else {

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( false === $license_data->success ) {

					switch ( $license_data->error ) {

						case 'expired':
							$message = sprintf(
								/* translators: Date. */
								esc_html__( 'Your license key expired on %s.', 'gridd-plus' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;

						case 'disabled':
						case 'revoked':
							$message = esc_html__( 'Your license key has been disabled.', 'gridd-plus' );
							break;

						case 'missing':
							$message = esc_html__( 'Invalid license.', 'gridd-plus' );
							break;

						case 'invalid':
						case 'site_inactive':
							$message = esc_html__( 'Your license is not active for this URL.', 'gridd-plus' );
							break;

						case 'item_name_mismatch':
							/* translators: The item name. */
							$message = sprintf( esc_html__( 'This appears to be an invalid license key for %s.', 'gridd-plus' ), GRIDD_PLUS_ITEM_NAME );
							break;

						case 'no_activations_left':
							$message = esc_html__( 'Your license key has reached its activation limit.', 'gridd-plus' );
							break;

						default:
							$message = esc_html__( 'An error occurred, please try again.', 'gridd-plus' );
							break;
					}
				}
			}

			// Check if anything passed on a message constituting a failure.
			if ( ! empty( $message ) ) {
				$base_url = admin_url( 'plugins.php?page=' . GRIDD_PLUS_PLUGIN_LICENSE_PAGE );
				$redirect = add_query_arg(
					[
						'sl_activation' => 'false',
						'message'       => urlencode( $message ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
					],
					$base_url
				);

				wp_safe_redirect( $redirect );
				exit();
			}

			// $license_data->license will be either "valid" or "invalid"
			update_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_status', $license_data->license );
			wp_safe_redirect( admin_url( 'plugins.php?page=' . GRIDD_PLUS_PLUGIN_LICENSE_PAGE ) );
			exit();
		}

		/**
		 * Deactivate a license.
		 * Listen for our deactivate button to be clicked.
		 *
		 * @since 1.0
		 */
		if ( isset( $_POST['gridd_plus_license_deactivate'] ) ) {

			// Run a quick security check.
			if ( ! check_admin_referer( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce', GRIDD_PLUS_PLUGIN_DB_PREFIX . '_nonce' ) ) {
				return; // Get out if we didn't click the deactivate button.
			}

			// Retrieve the license from the database.
			$license = trim( get_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_key' ) );

			// Data to send in our API request.
			$api_params = [
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_name'  => urlencode( GRIDD_PLUS_ITEM_NAME ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
				'url'        => home_url(),
			];

			// Call the custom API.
			$response = wp_remote_post(
				WPLEMON_STORE_URL,
				[
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				]
			);

			// Make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				$message = esc_html__( 'An error occurred, please try again.', 'gridd-plus' );
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				}

				$base_url = admin_url( 'plugins.php?page=' . GRIDD_PLUS_PLUGIN_LICENSE_PAGE );
				$redirect = add_query_arg(
					[
						'sl_activation' => 'false',
						'message'       => urlencode( $message ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
					],
					$base_url
				);

				wp_safe_redirect( $redirect );
				exit();
			}

			// Decode the license data.
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed".
			if ( 'deactivated' === $license_data->license ) {
				delete_option( GRIDD_PLUS_PLUGIN_DB_PREFIX . '_status' );
			}

			wp_safe_redirect( admin_url( 'plugins.php?page=' . GRIDD_PLUS_PLUGIN_LICENSE_PAGE ) );
			exit();

		}
	}
);

add_action(
	'admin_notices',
	/**
	 * Shows any errors that might have occured.
	 *
	 * @since 1.0
	 * @return void
	 */
	function() {
		if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			switch ( $_GET['sl_activation'] ) { // phpcs:ignore WordPress.Security.NonceVerification
				case 'false':
					$message = urldecode( wp_unslash( $_GET['message'] ) ); // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput
					echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
					break;

				case 'true':
				default:
					break;
			}
		}
	}
);
