<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HELPER COMMENT START
 * 
 * This class is used to bring your plugin to life. 
 * All the other registered classed bring features which are
 * controlled and managed by this class.
 * 
 * Within the add_hooks() function, you can register all of 
 * your WordPress related actions and filters as followed:
 * 
 * add_action( 'my_action_hook_to_call', array( $this, 'the_action_hook_callback', 10, 1 ) );
 * or
 * add_filter( 'my_filter_hook_to_call', array( $this, 'the_filter_hook_callback', 10, 1 ) );
 * or
 * add_shortcode( 'my_shortcode_tag', array( $this, 'the_shortcode_callback', 10 ) );
 * 
 * Once added, you can create the callback function, within this class, as followed: 
 * 
 * public function the_action_hook_callback( $some_variable ){}
 * or
 * public function the_filter_hook_callback( $some_variable ){}
 * or
 * public function the_shortcode_callback( $attributes = array(), $content = '' ){}
 * 
 * 
 * HELPER COMMENT END
 */

/**
 * Class Demo_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		DEMO
 * @subpackage	Classes/Demo_Run
 * @author		Đức Nguyễn Năng
 * @since		1.0.0
 */
class Demo_Run{

	/**
	 * Our Demo_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'plugin_action_links_' . DEMO_PLUGIN_BASE, array( $this, 'add_plugin_action_link' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_menu_items' ), 100, 1 );
		add_filter( 'edd_settings_sections_extensions', array( $this, 'add_edd_settings_section' ), 20 );
		add_filter( 'edd_settings_extensions', array( $this, 'add_edd_settings_section_content' ), 20 );
		add_filter( 'wpwhpro/webhooks/get_webhooks_triggers', array( $this, 'add_webhook_triggers_content' ), 10 );
		add_action( 'plugins_loaded', array( $this, 'add_webhook_triggers' ), 10 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	* Adds action links to the plugin list table
	*
	* @access	public
	* @since	1.0.0
	*
	* @param	array	$links An array of plugin action links.
	*
	* @return	array	An array of plugin action links.
	*/
	public function add_plugin_action_link( $links ) {

		$links['our_shop'] = sprintf( '<a href="%s" title="Custom Link" style="font-weight:700;">%s</a>', 'https://test.test', __( 'Custom Link', 'demo' ) );

		return $links;
	}

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {
		wp_enqueue_style( 'demo-backend-styles', DEMO_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), DEMO_VERSION, 'all' );
		wp_enqueue_script( 'demo-backend-scripts', DEMO_PLUGIN_URL . 'core/includes/assets/js/backend-scripts.js', array(), DEMO_VERSION, false );
		wp_localize_script( 'demo-backend-scripts', 'demo', array(
			'plugin_name'   	=> __( DEMO_NAME, 'demo' ),
		));
	}

	/**
	 * Add a new menu item to the WordPress topbar
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	object $admin_bar The WP_Admin_Bar object
	 *
	 * @return	void
	 */
	public function add_admin_bar_menu_items( $admin_bar ) {

		$admin_bar->add_menu( array(
			'id'		=> 'demo-id', // The ID of the node.
			'title'		=> __( 'Demo Menu Item', 'demo' ), // The text that will be visible in the Toolbar. Including html tags is allowed.
			'parent'	=> false, // The ID of the parent node.
			'href'		=> '#', // The ‘href’ attribute for the link. If ‘href’ is not set the node will be a text node.
			'group'		=> false, // This will make the node a group (node) if set to ‘true’. Group nodes are not visible in the Toolbar, but nodes added to it are.
			'meta'		=> array(
				'title'		=> __( 'Demo Menu Item', 'demo' ), // The title attribute. Will be set to the link or to a div containing a text node.
				'target'	=> '_blank', // The target attribute for the link. This will only be set if the ‘href’ argument is present.
				'class'		=> 'demo-class', // The class attribute for the list item containing the link or text node.
				'html'		=> false, // The html used for the node.
				'rel'		=> false, // The rel attribute.
				'onclick'	=> false, // The onclick attribute for the link. This will only be set if the ‘href’ argument is present.
				'tabindex'	=> false, // The tabindex attribute. Will be set to the link or to a div containing a text node.
			),
		));

		$admin_bar->add_menu( array(
			'id'		=> 'demo-sub-id',
			'title'		=> __( 'My sub menu title', 'demo' ),
			'parent'	=> 'demo-id',
			'href'		=> '#',
			'group'		=> false,
			'meta'		=> array(
				'title'		=> __( 'My sub menu title', 'demo' ),
				'target'	=> '_blank',
				'class'		=> 'demo-sub-class',
				'html'		=> false,    
				'rel'		=> false,
				'onclick'	=> false,
				'tabindex'	=> false,
			),
		));

	}

	/**
	 * Add the custom settings section under
	 * Downloads -> Settings -> Extensions
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	array	$sections	The currently registered EDD settings sections
	 *
	 * @return	void
	 */
	public function add_edd_settings_section( $sections ) {
		
		$sections['demo'] = __( DEMO()->settings->get_plugin_name(), 'demo' );

		return $sections;
	}

	/**
	 * Add the custom settings section content
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	array	$settings	The currently registered EDD settings for all registered extensions
	 *
	 * @return	array	The extended settings 
	 */
	public function add_edd_settings_section_content( $settings ) {
		
		// Your settings reamain registered as they were in EDD Pre-2.5
		$custom_settings = array(
			array(
				'id'   => 'my_header',
				'name' => '<strong>' . __( DEMO()->settings->get_plugin_name() . 'Settings', 'demo' ) . '</strong>',
				'desc' => '',
				'type' => 'header',
				'size' => 'regular'
			),
			array(
				'id'    => 'my_example_setting',
				'name'  => __( 'Example checkbox', 'demo' ),
				'desc'  => __( 'Check this to turn on a setting', 'demo' ),
				'type'  => 'checkbox'
			),
			array(
				'id'    => 'my_example_text',
				'name'  => __( 'Example text', 'demo' ),
				'desc'  => __( 'A Text setting', 'demo' ),
				'type'  => 'text',
				'std'   => __( 'Example default text', 'demo' )
			),
		);

		// If EDD is at version 2.5 or later...
		if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
			$custom_settings = array( 'demo' => $custom_settings );
		}

		return array_merge( $settings, $custom_settings );
	}

	/**
	 * ####################
	 * ### WP Webhooks 
	 * ####################
	 */

	/*
	 * Register all available webhook triggers
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	array	$triggers	An array containing all available triggers
	 *
	 * @return	array	$triggers
	 */
	public function add_webhook_triggers_content( $triggers ){

		$triggers[] = $this->trigger_create_user_content();

		return $triggers;
	}

	/*
	 * Add the specified webhook triggers logic.
	 * We also add the demo functionality here
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function add_webhook_triggers() {

		if( ! empty( WPWHPRO()->webhook->get_hooks( 'trigger', 'demo_create_user' ) ) ){
			add_action( 'user_register', array( $this, 'ironikus_trigger_user_register' ), 10, 1 );
			add_filter( 'ironikus_demo_test_user_create', array( $this, 'ironikus_send_demo_user_create' ), 10, 3 );
		}

	}

	/*
	 * The definition of the custom trigger
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	array	An array containing all details about this trigger
	 */
	public function trigger_create_user_content(){

		$parameter = array(
			'user_object' => array( 'short_description' => WPWHPRO()->helpers->translate( 'The request will send the full user object as an array. Please see https://codex.wordpress.org/Class_Reference/WP_User for more details.', 'trigger-demo_create_user-content' ) ),
			'user_meta' => array( 'short_description' => WPWHPRO()->helpers->translate( 'The user meta is also pushed to the user object. You will find it on the first layer of the object as well. ', 'trigger-demo_create_user-content' ) ),
		);

		ob_start();
		?>
		<p><?php echo WPWHPRO()->helpers->translate( "Please copy your Webhooks Pro webhook URL into the provided input field. After that you can test your data via the Send demo button.", "trigger-demo_create_user-content" ); ?></p>
		<p><?php echo WPWHPRO()->helpers->translate( 'You will recieve a full response of the user object, as well as the user meta, so everything you need will be there.', 'trigger-demo_create_user-content' ); ?></p>
		<p><?php echo WPWHPRO()->helpers->translate( 'You can also filter the demo request by using a custom WordPress filter.', 'trigger-demo_create_user-content' ); ?></p>
		<p><?php echo WPWHPRO()->helpers->translate( 'To check the webhook response on a demo request, just open your browser console and you will see the object.', 'trigger-demo_create_user-content' ); ?></p>
		<?php
		$description = ob_get_clean();

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_post_create_user_on_certain_id_demo' => array(
					'id'          => 'wpwhpro_post_create_user_on_certain_id_demo',
					'type'        => 'select',
					'multiple'    => true,
					'choices'      => array(
						'name_1' => 'Label 1',
						'name_2' => 'Label 2',
					),
					'label'       => WPWHPRO()->helpers->translate('This is the settings label', 'trigger-demo_create_user-content'),
					'placeholder' => '',
					'required'    => false,
					'description' => WPWHPRO()->helpers->translate('Include the description for your single settings item here.', 'trigger-demo_create_user-content-tip')
				),
			)
		);

		return array(
			'trigger' => 'demo_create_user',
			'name'  => WPWHPRO()->helpers->translate( 'Demo Send Data On Register', 'trigger-demo_create_user-content' ),
			'parameter' => $parameter,
			'settings'          => $settings,
			'returns_code'      => WPWHPRO()->helpers->display_var( $this->ironikus_send_demo_user_create( array(), '', '' ) ), //Display some response code within the frontend
			'short_description' => WPWHPRO()->helpers->translate( 'This webhook fires as soon as a user registered.', 'trigger-demo_create_user-content' ),
			'description' => $description,
			'callback' => 'test_user_create'
		);

	}

	/*
	 * The core logic to execute the triggers
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	int	$user_id	The given user id from the user_register callback
	 *
	 * @return	void
	 */
	public function ironikus_trigger_user_register( $user_id ){
		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'demo_create_user' );
		$user_data = (array) get_user_by( 'id', $user_id );
		$user_data['user_meta'] = get_user_meta( $user_id );

		foreach( $webhooks as $webhook ){

			$is_valid = true;

			if( isset( $webhook['settings'] ) ){
				foreach( $webhook['settings'] as $settings_name => $settings_data ){

					if( $settings_name === 'wpwhpro_post_create_user_on_certain_id_demo' && ! empty( $settings_data ) ){
						if( ! in_array( 'name_1', $settings_data ) ){ //Test against the custom settings you defined earlier
							$is_valid = false;
						}
					}

				}
			}

			if( $is_valid ) {
				$response_data = WPWHPRO()->webhook->post_to_webhook( $webhook, $user_data );
			}
			
		}

		do_action( 'wpwhpro/webhooks/trigger_user_register', $user_id, $user_data );
	}

	/*
	 * The demo data response
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	mixed	$data	The data that will be returned
	 * @param	array	$webhook	The available webhook
	 * @param	string	$webhook_group	The current webhook group
	 *
	 * @return	array	$data	The demo data
	 */
	public function ironikus_send_demo_user_create( $data, $webhook, $webhook_group ){

		$data = array (
			'data' =>
				array (
					'ID' => '1',
					'user_login' => 'admin',
					'user_pass' => '$P$BVbptZxEcZV2yeLyYeN.O4ZeG8225d.',
					'user_nicename' => 'admin',
					'user_email' => 'admin@ironikus.dev',
					'user_url' => '',
					'user_registered' => '2018-11-06 14:19:18',
					'user_activation_key' => '',
					'user_status' => '0',
					'display_name' => 'admin',
				),
			);

		return $data;
	}

}
