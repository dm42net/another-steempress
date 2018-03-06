<?php

/**
 * Additional fields to add to the USER PROFILE
 *
 * @link       https://www.dm42.net/anothersteempress
 * @since      1.0.0
 *
 * @package    another-steempress
 * @subpackage another-steempress/admin/partials
 */

    function anothersteempress_selected_if($curval,$testval) {
       if ($curval == $testval) {echo "checked"; return true;}
       return false;
     }
?>

    <?php
    //Grab all options
    $options = get_user_meta(get_current_user_id(),$this->plugin_name);
    if (is_array($options)) {$options = $options[0];}

    // avoid undefined errors when running it for the first time :
    if (!isset($options["username"]))
        $options["username"] = "";
    if (!isset($options["posting-key"]))
        $options["posting-key"] = "";
    if (!isset($options["testnet-username"]))
        $options["testnet-username"] = "";
    if (!isset($options["testnet-posting-key"]))
        $options["testnet-posting-key"] = "";
    if (!isset($options["tags"]))
        $options["tags"] = "";
    if (!isset($options["category"]))
        $options["category"] = "";
    if (!isset($options["vote"]))
        $options["vote"] = "on";
    if (!isset($options['template']))
        $options['template'] = "{{content}}";
    //$testnetuser = $options["testnet-username"];
    //$testnetwif = $options["testnet-posting-key"];
    //$testnetdata = array("body" => array("testnet" => "yes","author" => $testnetuser,"wif"=>$testnetwif));

    //$steemuser = $options["username"];
    //$steemwif = $options["posting-key"];
    //$steemdata = array("body" => array("testnet" => "no","author" => $steemuser,"wif"=>$steemwif));
    //$testnetresult = wp_remote_post("https://steempress.dm42.net/spress/testuser", $testnetdata);
    //$steemresult = wp_remote_post("https://steempress.dm42.net/spress/testuser", $steemdata);
    ?>

<tr>
  <td colspan=2><b>Live STEEM Credentials: 
<?php
    if (isset($options["live-authvalid"]) && $options["live-authvalid"]=="yes") {
      echo "<b style='color: darkgreen'>Ok</b> - Your username and posting key have been verified.";
     } else {
      echo "<b style='color: darkred'>FAILED:</b> - Unable to verify your username and posting key. ERROR: ";
      if (isset($steemresults["error"])) {
       echo $steemresults["error"];
      }
    }
 ?>
</td>
</tr>
<tr>
<td colspan=2><label>Live Steem ID:</label>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-username" name="<?php echo $this->plugin_name; ?>[username]" value="<?php echo htmlspecialchars($options["username"], ENT_QUOTES); ?>"/>
</td>
</tr>
<tr>
<td colspan=2><label>Live Steem Posting Key:</label>

        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-posting-key" name="<?php echo $this->plugin_name; ?>[posting-key]" value="<?php echo htmlspecialchars($options["posting-key"], ENT_QUOTES); ?>"/>
</td>
</tr>
<tr>
  <td colspan=2><b>TestNet Credentials: 
    <?php
      if (isset($options["testnet-authvalid"]) && $options["testnet-authvalid"]=="yes") {
          echo "<b style='color: darkgreen'>Ok</b> - Your username and posting key have been verified.";
      } else {
          echo "<b style='color: darkred'>FAILED:</b> - Unable to verify your username and posting key. ERROR: ";
          if (isset($testnetresults["error"])) {
            echo $testnetresults["error"];
          }
      }
     ?>

</tr>
<tr>
<td colspan=2><label>TestNet Steem ID:</label>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-testnet-username" name="<?php echo $this->plugin_name; ?>[testnet-username]" value="<?php echo htmlspecialchars($options["testnet-username"], ENT_QUOTES); ?>"/>
</td>
</tr>
<tr>
<td colspan=2><label>TestNet Steem Posting Key:</label>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-testnet-posting-key" name="<?php echo $this->plugin_name; ?>[testnet-posting-key]" value="<?php echo htmlspecialchars($options["testnet-posting-key"], ENT_QUOTES); ?>"/>
</td>
</tr>
<tr>
<td colspan=2><label> Reward Split:</label><select name="<?php echo $this->plugin_name; ?>[reward]" id="<?php echo $this->plugin_name; ?>-reward">
            <option value="50" <?php echo ($options["reward"] == "50" ?  'selected="selected"' : '');?>>50% Steem power 50% Steem Dollars</option>
            <option value="100" <?php echo ($options["reward"] == "100" ?  'selected="selected"' : '');?>>100% Steem Power</option>
        </select>
</td></tr>
<tr><td colspan=2><label>Default Primary Tag / Category</label><input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-category" name="<?php echo $this->plugin_name; ?>[category]" value="<?php echo htmlspecialchars(($options["category"] == "" ? "dm42-steempress" : $options["category"]), ENT_QUOTES); ?>"/>
</td></tr>
<tr><td colspan=2><label>Default additional tags (max 4):</label><input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-tags" name="<?php echo $this->plugin_name; ?>[tags]" value="<?php echo htmlspecialchars(($options["tags"] == "" ? "steempress steem" : $options["tags"]), ENT_QUOTES); ?>"/>
</td></tr>
<tr><td colspan=2><label>STEEM Posting Template</label><BR>
        <div style="max-width:600px;">
           <p><b>Steem Template</b> (<a href="https://steemit.com/steemit/@snug/steemit-s-html-whitelist">Available HTML tags</a>)</p>
           <?php
             $test=$options['template']; if (!preg_match('/\{\{content\}\}/',$test)) {?>
           <p><em>NOTE:</em> <span style="font-color:#d22">{{content}}</span> must appear in your template, or your post content will not be sent to the Steem blockchain.</p>
           <?php } ?>
           <textarea style="width:100%;height:300px;" name="<?php echo $this->plugin_name; ?>[template]"><?php echo htmlentities($options['template']);?></textarea>
        </div>
</tr></td>
<tr><td colspan=2>
        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-vote" name="<?php echo $this->plugin_name; ?>[vote]"  <?php echo $options['vote'] == "off" ? '' : 'checked="checked"' ?>> Allow Voting<br>
        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-seo" name="<?php echo $this->plugin_name; ?>[seo]"  <?php echo $options['seo'] == "off" ? '' : 'checked="checked"' ?>> Add original link to the steem article.<br>
</td></tr>
<tr><td colspan=2>
        <?php submit_button('Save changes', 'primary','submit', TRUE); ?>
</td></tr>
