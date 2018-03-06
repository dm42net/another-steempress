<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://steemit.com/@howo
 * @since      1.0.0
 *
 * @package    AnotherSteempress
 * @subpackage AnotherSteempress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AnotherSteempress
 * @subpackage AnotherSteempress/admin
 */
class AnotherSteempress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AnotherSteempress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AnotherSteempress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/anothersteempress-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AnotherSteempress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AnotherSteempress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/anothersteempress-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {
        add_options_page( 'AnotherSteempress Options', 'AnotherSteempress', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        include_once('partials/anothersteempress-admin-display.php');
    }

    public function validate($input) {
        // All checkboxes inputs
        //return $input;
        $valid = array();
        $valid['reward'] = (isset($input['reward']) && !empty($input['reward'] ) && ($input['reward'] == "50" || $input['reward'] == "100")) ? $input['reward'] : "50";
        $valid['posting-key'] = (isset($input['posting-key']) && !empty($input['posting-key'])) ? htmlspecialchars($input['posting-key'], ENT_QUOTES) : "";
        $valid['tags'] = (isset($input['tags']) && !empty($input['tags'])) ? htmlspecialchars($input['tags'], ENT_QUOTES) : "";
        $valid['username'] = (isset($input['username']) && !empty($input['username'])) ? htmlspecialchars($input['username'], ENT_QUOTES) : "";
        $valid['seo'] = ((isset($input['seo']) && !empty($input['seo'])) && $input['seo'] == 'on') ? 'on' : "off";
        $valid['use-testnet'] = ((isset($input['use-testnet']) && !empty($input['use-testnet'])) && $input['use-testnet'] == 'yes') ? 'yes' : "no";
        $valid['vote'] = ((isset($input['vote']) && !empty($input['vote'])) && $input['vote'] == 'on') ? 'on' : "off";
        $valid['testnet-posting-key'] = (isset($input['testnet-posting-key']) && !empty($input['testnet-posting-key'])) ? htmlspecialchars($input['testnet-posting-key'], ENT_QUOTES) : "";
        $valid['testnet-username'] = (isset($input['testnet-username']) && !empty($input['testnet-username'])) ? htmlspecialchars($input['testnet-username'], ENT_QUOTES) : "";
        $valid['category'] = (isset($input['category']) && !empty($input['category'])) ? htmlspecialchars($input['category'], ENT_QUOTES) : "";

            if ($valid['tags'] == "" || $valid['username'] == "" || $valid['posting-key'] == "" || $valid['category'] != "") {
                $this->AnotherSteempress_addnotice("error","Required fields missing.  Please check your configuration.");
            }
        $valid['template'] = html_entity_decode($input["template"]);
        $valid['testnet-authvalid'] = (isset($input['testnet-authvalid']) && $input['testnet-authvalid'] == 'yes') ? 'yes' : 'no';
        $valid['live-authvalid'] = (isset($input['live-authvalid']) && $input['live-authvalid'] == 'yes') ? 'yes' : 'no';
        if (extension_loaded('tidy')) {
          $templatehtml=$valid['template'];
          $tidy = new tidy();
          $tidy->parseString($templatehtml,Array('indent'=>true));
          $templatehtml=trim($tidy->body());
          $templatehtml = preg_replace('/(<body>)/','',$templatehtml);
          $templatehtml = preg_replace('/(<\/body>)/','',$templatehtml);
          $valid['template']=$templatehtml;
        }

        return $valid;
    }

    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    public function update_user_profile() {
      $userid=get_current_user_id();
      $options = $this->validate($_POST[$this->plugin_name]);

      $testnetdata = array("body" => array("testnet" => "yes","author" => $options["testnet-username"],"wif"=>$options["testnet-posting-key"]));
      $steemdata = array("body" => array("testnet" => "no","author" => $options["username"],"wif"=>$options["posting-key"]));
      $testnetresult = wp_remote_post("https://steempress.dm42.net/spress/testuser", $testnetdata);
      $steemresult = wp_remote_post("https://steempress.dm42.net/spress/testuser", $steemdata);

      $options["live-authvalid"]="no";
      if (is_array($steemresult) or ($steemresult instanceof Traversable)) {
          $steemresults = json_decode($steemresult["body"],true);
          if (isset($steemresults["result"]) && $steemresults["result"] == "success") {
            $options["live-authvalid"]="yes"; 
          }
      }
      $options["testnet-authvalid"]="no";
      if (is_array($testnetresult) or ($testnetresult instanceof Traversable)) {
          $testnetresults = json_decode($testnetresult["body"],true);
          if (isset($testnetresults["result"]) && $testnetresults["result"] == "success") {
            $options["testnet-authvalid"]="yes"; 
          }
      }

      update_user_meta($userid,$this->plugin_name,$options);
    }

		public function display_user_profile_opts() {
			include "partials/anothersteempress-useropts-display.php";
		}

    public function AnotherSteempress_addnotice($type,$notice) {
      global $AnotherSteempress_notices;
      if (!is_array($AnotherSteempress_notices)) {
         $AnotherSteempress_notices = Array();
      }
      $newnotice=Array('type'=>$type,'notice'=>$notice);
      array_push($AnotherSteempress_notices,$newnotice);

    }

    public function AnotherSteempress_displaynotices() {
      global $AnotherSteempress_notices;
      $content = '';
      if (!is_array($AnotherSteempress_notices)) return;
      foreach ($AnotherSteempress_notices as $notice) {
        $content .= '<div class="notice notice-'.$notice['type'].' is-dismissible">';
        $content .= '<p>'.$notice['notice'].'</p>';
        $content .= '</div>';
        $content .= "\n";
      }
    }

    public function AnotherSteempress_post($new_status, $old_status, $post)
    {
        return;
    }

    public function AnotherSteempress_dopost($userinfo,$post) {

	$steemusers = $this->AnotherSteempress_get_steemusers();
	//preg_match('/([^:]*):(.*)/',$userinfo,$matchinfo);
        $matchinfo = explode (':',$userinfo);
	$livetest=$matchinfo[0];
	$username=$matchinfo[1];
	$postkey=$steemusers[$userinfo];

        if ($matchinfo[2]=='blog') {
            $options = get_option($this->plugin_name);
        } else {
            $options=get_user_meta(get_current_user_id(),$this->plugin_name);
            $options=isset($options[0]) ? $options[0] : Array();
        }

            // Avoid undefined errors
            if (!isset($options["username"]))
                $options["username"] = "";
            if (!isset($options["posting-key"]))
                $options["posting-key"] = "";
            if (!isset($options["testnet-username"]))
                $options["testnet-username"] = "";
            if (!isset($options["testnet-posting-key"]))
                $options["testnet-posting-key"] = "";
            if (!isset($options["reward"]))
                $options["reward"] = "100";
	$options["reward"]=$options["reward"]*100;
            if (!isset($options["category"]))
                $options["category"] = "";
            if (!isset($options["tags"]))
                $options["tags"] = "";

            if (!isset($options["seo"]))
                $options["seo"] = "on";
            if (!isset($options["vote"]))
                $options["vote"] = "on";

            if (!isset($options["template"]))
                $options["template"] = "{{content}}";


            $wp_tags = wp_get_post_tags($post->ID);

            if (sizeof($wp_tags) != 0) {

                $tags = [];

                foreach ($wp_tags as $tag) {
                    $tags[] = $tag->name;
                }

                $tags = implode(" ", $tags);
            }
            else
                $tags = $options["tags"];


            $postcontent = $post->post_content;
            $postcontent = apply_filters('the_content', $postcontent);
            $postcontent = str_replace(']]>', ']]&gt;', $postcontent);
						$postcontent = preg_replace("/{{content}}/",$postcontent,$options['template']);

            if ($options['seo'] == "on") {
              //$link = strtolower($post->post_title);
	      //$link = preg_replace('/\s+/','-',$link);
	      //$link = preg_replace('/[^a-z0-9\-]/','',$link);
	      //$link = preg_replace('/[\-]+/','-',$link);
              $link = get_permalink($post->ID);
            } else {
                $link = "";
						}

            if ($livetest=="live") {
              $options["use-testnet"] = "no";
            } else {
              $options["use-testnet"] = "yes";
            }


    				$data = array("body" => array("title" => $post->post_title, "content" => $postcontent, "category" => $options["category"], "tags" => $tags, "author" => $username, "wif" => $postkey, "original_link" => $link, "reward" => $options['reward'], "vote"=> $options["vote"], "use-testnet" => $options["use-testnet"]));

            // A few local verifications as to not overload the server with useless txs

            $test = $data['body'];
            // Last minute checks before sending it to the server
            if ($test['tags'] != "" && $test['author'] != "" && $test['wif'] != "" && $test['category'] != "") {
                // Post to the api who will publish it on the steem blockchain.
                //wp_remote_post("https://steemgifts.com", $data);
                wp_remote_post("https://steempress.dm42.net/post", $data);
            } else {
                $this->AnotherSteempress_addnotice("error","Required fields not configured.  Please configure the AnotherSteempress plugin.");
            }

        return;
    }

    public function AnotherSteempress_get_steemusers() {

      $steemusers=Array();

			$options = get_option($this->plugin_name);
			$steemusers=Array();
      if ($options["live-authvalid"] == 'yes') {
				$steemusers["live:".$options["username"].':blog']=$options["posting-key"];
      }
      if ($options["testnet-authvalid"] == 'yes') {
				$steemusers["test:".$options["testnet-username"].':blog']=$options["testnet-posting-key"];
      }
			$useropts=get_user_meta(get_current_user_id(),$this->plugin_name);
			$useropts=$useropts[0];
			if ($useropts["live-authvalid"] == 'yes') {
				$steemusers["live:".$useropts["username"].':user']=$useropts["posting-key"];
      }
      if ($useropts["testnet-authvalid"] == 'yes') {
				$steemusers["test:".$useropts["testnet-username"].':user']=$useropts["testnet-posting-key"];
      }
			ksort($steemusers);

			return $steemusers;
		}

    public function AnotherSteempress_submitbox_misc_actions($post){
      $options = get_option($this->plugin_name);
      if ($post->post_status == 'publish') {
    ?>
      <div class="misc-pub-section steemit-post-options">
            <label for="steempress-post-action">Steem Posting</label><br />
            <select id="steempress-post-action" name="anothersteempress_post_action">
                        <option value="NONE">Do not post to Steem</option>
    <?php
		  $steemusers = $this->AnotherSteempress_get_steemusers();
			$usercount=0;
			foreach ($steemusers as $userinfo=>$postkey) {
				//preg_match('/([^:]*):(.*)/',$userinfo,$matchinfo);
                                $matchinfo = explode (':',$userinfo);
				$chain='';

				if($matchinfo[0]=='test') {$chain='Test'; $user=$matchinfo[1];}
				if($matchinfo[0]=='live') {$chain='Live'; $user=$matchinfo[1];}
				if ($chain!='') {
					$usercount++;
				  echo '<option value="'.$userinfo.'">Post to '.$chain.' blockchain with user '.$user.' ('.$matchinfo[2].')</option>';
				}
			}
    ?>
            </select>
      <?php
      if ($usercount < 1)  {
        ?>
        <br><b style='color: red'>Warning: No valid STEEM blockchains.</b>
        <br>Please check your STEEM username and key.</a> </b> <?php
      } ?>
      </div>
      <?php
      }
    }

    function AnotherSteempress_submitbox_save ($postid) {
      $post_type = get_post_type($postid);
      $post = get_post($postid);

      if ("post" != $post_type && "page" != $post_type)  return;
      if ("post" == $post_type && !user_can(get_current_user_id(),'publish_posts')) return;
      if ("page" == $post_type && !user_can(get_current_user_id(),'publish_pages')) return;

      $steemusers = $this->AnotherSteempress_get_steemusers();

      $postas = $_POST['anothersteempress_post_action'];
      if (!isset($steemusers[$postas])) return;

      $this->AnotherSteempress_dopost($postas,$post);

      return;
    }


}
