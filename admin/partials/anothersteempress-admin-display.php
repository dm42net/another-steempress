<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://steemit.com/@howo
 * @since      1.0.0
 *
 * @package    Sp
 * @subpackage Sp/admin/partials
 */

    function anothersteempress_selected_if($curval,$testval) {
       if ($curval == $testval) {echo "checked"; return true;}
       return false;
     }
?>

<div class="wrap">

    <?php
    //Grab all options
    $options = get_option($this->plugin_name);

    // avoid undefined errors when running it for the first time :
    if (!isset($options["username"]))
        $options["username"] = "";
    if (!isset($options["posting-key"]))
        $options["posting-key"] = "";
    if (!isset($options["use-testnet"]))
        $options["use-testnet"] = "no";
    if (!isset($options["testnet-username"]))
        $options["username"] = "";
    if (!isset($options["testnet-posting-key"]))
        $options["posting-key"] = "";
    if (!isset($options["reward"]))
        $options["reward"] = "100";
    if (!isset($options["tags"]))
        $options["tags"] = "";
    if (!isset($options["category"]))
        $options["category"] = "";
    if (!isset($options["seo"]))
        $options["seo"] = "on";
    if (!isset($options["vote"]))
        $options["vote"] = "on";
    if (!isset($options['template']))
        $options['template'] = "{{content}}";

    ?>

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" name="cleanup_options" action="options.php">
        <?php settings_fields($this->plugin_name); ?>
        <!-- remove some meta and generators from the <head> -->
<div>
<div style="margin:auto;min-width:400px;max-width:50%;padding:'7px';float:left;position:relative;">
        <H1>Live Blockchain Posting Keys</H1>
        <p>Steem Username : </p>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-username" name="<?php echo $this->plugin_name; ?>[username]" value="<?php echo htmlspecialchars($options["username"], ENT_QUOTES); ?>"/>
        <br />
        <?php
        if ($options["posting-key"] == "" || $options['username'] == "")
            echo "Don't have a steem account ? Sign up <a href='https://steemit.com/pick_account'> here</a>"
        ?>
        <p>Private Posting key : </p>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-posting-key" name="<?php echo $this->plugin_name; ?>[posting-key]" value="<?php echo htmlspecialchars($options["posting-key"], ENT_QUOTES); ?>"/>
        <br />
</div>
<div style="margin:auto;min-width:400px;max-width:50%;padding:'7px';float:left;position:relative;">
        <H1>Testnet Posting Keys</H1>
        <p>Testnet Username : </p>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-testnet-username" name="<?php echo $this->plugin_name; ?>[testnet-username]" value="<?php echo htmlspecialchars($options["testnet-username"], ENT_QUOTES); ?>"/>
        <br />
        <p>Private Posting key : </p>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-testnet-posting-key" name="<?php echo $this->plugin_name; ?>[testnet-posting-key]" value="<?php echo htmlspecialchars($options["testnet-posting-key"], ENT_QUOTES); ?>"/>
        <p>NOTE: You must create a username/password for the testnet separately.</p><p><a href="https://steemit.com/steemdev/@almost-digital/introducing-the-first-ever-public-steem-testnet">Click here</a> for details about the testnet.</p>
</div>
</div>
<div style='clear:both;'></div>
        <p> Reward Split: </p>
        <select name="<?php echo $this->plugin_name; ?>[reward]" id="<?php echo $this->plugin_name; ?>-reward">
            <option value="50" <?php echo ($options["reward"] == "50" ?  'selected="selected"' : '');?>>50% Steem power 50% Steem Dollars</option>
            <option value="100" <?php echo ($options["reward"] == "100" ?  'selected="selected"' : '');?>>100% Steem Power</option>
        </select>

        <p> Category : <br> Main category to file posts under.  Best to be related somehow to your blog - perhaps your blog name. </p>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-category" name="<?php echo $this->plugin_name; ?>[category]" value="<?php echo htmlspecialchars(($options["category"] == "" ? "dm42-steempress" : $options["category"]), ENT_QUOTES); ?>"/>


        <p> Default tags : <br> separate each tag by a space, 5 max <br> Will be used if you don't specify tags when publishing. </p>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-tags" name="<?php echo $this->plugin_name; ?>[tags]" value="<?php echo htmlspecialchars(($options["tags"] == "" ? "steempress steem" : $options["tags"]), ENT_QUOTES); ?>"/>
        <br />
        <br />

        <div style="max-width:600px;">
           <p><b>Steem Template</b> (<a href="https://steemit.com/steemit/@snug/steemit-s-html-whitelist">Available HTML tags</a>)</p>
           <?php 
             $test=$options['template']; if (!preg_match('/\{\{content\}\}/',$test)) {?>
           <p><em>NOTE:</em> <span style="font-color:#d22">{{content}}</span> must appear in your template, or your post content will not be sent to the Steem blockchain.</p>
           <?php } ?>
           <textarea style="width:100%;height:300px;" name="<?php echo $this->plugin_name; ?>[template]"><?php echo htmlentities($options['template']);?></textarea>
        </div>

        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-vote" name="<?php echo $this->plugin_name; ?>[vote]"  <?php echo $options['vote'] == "off" ? '' : 'checked="checked"' ?>> Allow Voting<br>
        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-seo" name="<?php echo $this->plugin_name; ?>[seo]"  <?php echo $options['seo'] == "off" ? '' : 'checked="checked"' ?>> Add original link to the steem article.<br>


        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>


    <?php
        //echo "<p>Connectivity and username/password tests:</p><ul>";
        $options = get_option($this->plugin_name);
        //echo "OPTIONS:<pre>";
        //print_r($options);
        //echo "</pre>";
        $livevalid = isset($options['live-authvalid']) ? $options['live-authvalid'] : '';
        $testvalid = isset($options['testnet-authvalid']) ? $options['testnet-authvalid'] : '';
        //echo "<b>TESTNET AUTH PREVIOUS VALUE: $testvalid | LIVE AUTH PREVIOUS VALUE: $livevalid";
        $steemuser = isset($options["username"]) ? $options["username"] : '';
        $steemwif = isset($options["posting-key"]) ? $options["posting-key"] : '';
        $testnetuser = isset($options["testnet-username"]) ? $options["testnet-username"] : '';
        $testnetwif = isset($options["testnet-posting-key"]) ? $options["testnet-posting-key"] : '';
        $testnetdata = array("body" => array("testnet" => "yes","author" => $testnetuser,"wif"=>$testnetwif));
        $steemdata = array("body" => array("testnet" => "no","author" => $steemuser,"wif"=>$steemwif));
        // Test the user and api which will publish on blockchain.
        //$result = wp_remote_post("https://steemgifts.com/test", $data);
        //$result = wp_remote_post("http://127.0.0.1:4287/spress", $data);
        $testnetresult = wp_remote_post("http://127.0.0.1:4287/spress/testuser", $testnetdata);
        $steemresult = wp_remote_post("http://127.0.0.1:4287/spress/testuser", $steemdata);
        echo "<li>Live STEEM blockchain: ";
        $options["live-authvalid"]="no";
        if (is_array($steemresult) or ($steemresult instanceof Traversable)) {
            $steemresults = json_decode($steemresult["body"],true);
            if (isset($steemresults["result"]) && $steemresults["result"] == "success") {
              $options["live-authvalid"]="yes";
              echo "<b style='color: darkgreen'>Ok</b>";
             } else {
              echo "<b style='color: darkred'>FAILED:</b>";
              if (isset($steemresults["error"])) {
               echo $steemresults["error"];
              }
            }
        } else {
            echo "<b style='color: red'>Connection error</b> <br /> Most likely your host isn't letting the plugin reach our steem server.";
        }
        echo "</li>";
        echo "<li>Testnet blockchain: ";
        $options["testnet-authvalid"]="no";
        if (is_array($testnetresult) or ($testnetresult instanceof Traversable)) {
            $testnetresults = json_decode($testnetresult["body"],true);
            if (isset($testnetresults["result"]) && $testnetresults["result"] == "success") {
                echo "<b style='color: darkgreen'>Ok</b>";
                $options["testnet-authvalid"]="yes";
            } else {
                echo "<b style='color: darkred'>FAILED:</b>";
                if (isset($testnetresults["error"])) {
                   echo $testnetresults["error"];
                }
            }
        } else {
            echo "<b style='color: red'>Connection error</b> <br /> Most likely your host isn't letting the plugin reach our steem server.";
        }
        $options=$this->validate($options);
        update_option($this->plugin_name,$options);
        //$options=get_option($this->plugin_name);
        //echo "\n\n<pre>".print_r($options,true)."</pre>";
        ?></li> </ul></p>

</div>
