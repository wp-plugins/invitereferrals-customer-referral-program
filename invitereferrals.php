<?php
/*
    Plugin Name: inviteReferrals Customer Referral Campaigns for Wordpress
    Plugin URI: http://www.invitereferrals.com
    Description: Design and launch Customer Referral campaigns within minutes. To get started: 1) Get your key by registering your site at <a href="http://www.invitereferrals.com">invitereferrals.com</a>, 2) Enter your key on the <a href='options-general.php?page=invitereferrals-plugin'>Settings->inviteReferrals</a> menu, and 3) Click on the Activate link to the left of this description.
    Version: 1.0
    Author: inviteReferrals
    Author URI: http://www.invitereferrals.com
*/

// Version check
global $wp_version;
if(!version_compare($wp_version, '3.0', '>='))
{
    die("inviteReferrals requires WordPress 3.0 or above. <a href='http://codex.wordpress.org/Upgrading_WordPress'>Please update!</a>");
}
// END - Version check


//this is to avoid getting in trouble because of the
//wordpress bug http://core.trac.wordpress.org/ticket/16953
$invitereferrals_file = __FILE__; 

if ( isset( $mu_plugin ) ) { 
    $invitereferrals_file = $mu_plugin; 
} 
if ( isset( $network_plugin ) ) { 
    $invitereferrals_file = $network_plugin; 
} 
if ( isset( $plugin ) ) { 
    $invitereferrals_file = $plugin; 
} 

$GLOBALS['invitereferrals_file'] = $invitereferrals_file;


// Make sure class does not exist already.
if(!class_exists('InviteReferrals')) :

    class InviteReferralsWidget extends WP_Widget {
        function InviteReferralsWidget() {
            parent::WP_Widget(false, 'InviteReferrals Widget', array('description' => 'Description'));
        }

        function widget($args, $instance) {
            echo '<div id="invitereferrals_widget"></div>';
        }

        function update( $new_instance, $old_instance ) {
            // Save widget options
            return parent::update($new_instance, $old_instance);
        }

        function form( $instance ) {
            // Output admin widget options form
            return parent::form($instance);
        }
    }

    function invitereferrals_widget_register_widgets() {
        register_widget('InvitereferralsWidget');
    }

    // Declare and define the plugin class.
    class InviteReferrals
    {
        // will contain id of plugin
        private $plugin_id;
        // will contain option info
        private $options;

        /** function/method
        * Usage: defining the constructor
        * Arg(1): string(alphanumeric, underscore, hyphen)
        * Return: void
        */
        public function __construct($id)
        {
            // set id
            $this->plugin_id = $id;
            // create array of options
            $this->options = array();
            // set default options
            $this->options['secretkey'] = '';            
            $this->options['brandID'] = '';
            $this->options['enable_rewards'] = 'on';

            /*
            * Add Hooks
            */
            // register the script files into the footer section
            add_action('wp_footer', array(&$this, 'invitereferrals_scripts'));
            // initialize the plugin (saving default options)
            register_activation_hook(__FILE__, array(&$this, 'install'));
            // triggered when plugin is initialized (used for updating options)
            add_action('admin_init', array(&$this, 'init'));
            // register the menu under settings
            add_action('admin_menu', array(&$this, 'menu'));
            // Register sidebar widget
            add_action('widgets_init', 'invitereferrals_widget_register_widgets');
           
        }

        /** function/method
        * Usage: return plugin options
        * Arg(0): null
        * Return: array
        */
        private function get_options()
        {
            // return saved options
            $options = get_option($this->plugin_id);
            return $options;
        }
        /** function/method
        * Usage: update plugin options
        * Arg(0): null
        * Return: void
        */
        private function update_options($options=array())
        {
            // update options
            update_option($this->plugin_id, $options);
        }

        /** function/method
        * Usage: helper for loading invitereferrals.js
        * Arg(0): null
        * Return: void
        */
        public function invitereferrals_scripts()
        {
            if (!is_admin()) {
                $options = $this->get_options();
                $secretkey = trim($options['secretkey']);
                $brandID = trim($options['brandID']);
                //$xpos = trim($options['xpos']);
                //$ypos = trim($options['ypos']);
                //$name = isset($options['name']) ? $options['name'] : "Win Points";
                /*if (empty($name)) {
                    $name = "Win points";
                }*/
                if ($options['enable_rewards']) {
                    $this->show_invitereferrals_reward_js($secretkey,$brandID);
                }
            }
        }
        
        public function show_invitereferrals_reward_js($secretkey="",$brandID="")
        {        	
            $current_user = wp_get_current_user(); //display_name, user_email, ID
			$t = time(); 
			$bid = $brandID; 
			$secKey = $secretkey; 
			$setUserEmail = $current_user->data->user_email;// the user email id
			/* Optional parameters if passing email id as well */
			$fname = $current_user->data->display_name;//first name of customer		
			$md5SecretKey = strtoupper(md5($secKey.'|'.$bid.'|'.$t.'|'.$setUserEmail));

			echo "<div id='invtrflfloatbtn'></div>
			<script>	
			var invite_referrals = window.invite_referrals || {}; (function() { 
				invite_referrals.auth = { 
			  	bid_e : '".$md5SecretKey."',
				bid : '".$bid."', email : '".$setUserEmail."',
				t : '".$t."', userParams : {'fname' : '".$fname."'} };	
			var script = document.createElement('script');script.async = true;
                        script.src = (document.location.protocol == 'https:' ? '//d11yp7khhhspcr.cloudfront.net' : '//cdn.invitereferrals.com') + '/js/invite-referrals-1.0.js';
			var entry = document.getElementsByTagName('script')[0];entry.parentNode.insertBefore(script, entry); })();
			</script>";				
        }

        /** function/method
        * Usage: helper for hooking activation (creating the option fields)
        * Arg(0): null
        * Return: void
        */
        public function install()
        {
            $this->update_options($this->options);
        }
        
        /** function/method
        * Usage: helper for hooking (registering) options
        * Arg(0): null
        * Return: void
        */
        public function init()
        {
            register_setting($this->plugin_id.'_options', $this->plugin_id);
        }
                
        /** function/method
        * Usage: show options/settings form page
        * Arg(0): null
        * Return: void
        */
        public function options_page()
        {
            if (!current_user_can('manage_options'))
            {
                wp_die( __('You can manage options from the Settings->InviteReferrals Options menu.') );
            }

            // get saved options
            $options = $this->get_options();
            $updated = false;

            if (!isset($options['enable_rewards'])) {
                $options['enable_rewards'] = 1;
                $updated = true;
            }

            if ($updated) {
                $this->update_options($options);
            }
            include('invitereferrals_options_form.php');
        }
        /** function/method
        * Usage: helper for hooking (registering) the plugin menu under settings
        * Arg(0): null
        * Return: void
        */
        public function menu()
        {
            add_options_page('InviteReferrals Options', 'InviteReferrals', 'manage_options', $this->plugin_id.'-plugin', array(&$this, 'options_page'));
        }
    }

    // Instantiate the plugin
    $InviteReferrals = new InviteReferrals('invitereferrals');

// END - class exists
endif;
?>
