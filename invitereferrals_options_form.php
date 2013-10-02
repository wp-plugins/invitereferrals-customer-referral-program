<?php
// LAYOUT FOR THE SETTINGS/OPTIONS PAGE
?>

<style>
button {
 background: #8dc63f;
   background: -moz-linear-gradient(top,  #8dc63f 0%, #8dc63f 50%, #7fb239 51%, #7fb239 100%);
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8dc63f), color-stop(50%,#8dc63f), color-stop(51%,#7fb239), color-stop(100%,#7fb239));
   background: -webkit-linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   background: -o-linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   background: -ms-linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   background: linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   margin: auto;
   cursor:pointer;
   color: #fff;
   text-shadow: 1px 0px 0 rgba(0,0,0,.4);
   border-radius: 5px;
   border: none;
   font-family: cabin,sans-serif;
   display: block;
   font-weight: bold;
   padding: 5px 15px;
}
</style>

<div class="wrap">
    <?php screen_icon(); ?>
    <form action="options.php" method="post" id=<?php echo $this->plugin_id; ?>"_options_form" name=<?php echo $this->plugin_id; ?>"_options_form">
    <?php settings_fields($this->plugin_id.'_options'); ?>
    <h2>InviteReferrals &raquo; Options</h2>
    <table width="550" border="0" cellpadding="5" cellspacing="5">    
    
    <tr>
        <td width="144" height="26" align="right" style="padding:0 30px 0 0;vertical-align: top;"><label style="font-weight:600" for="<?php echo $this->plugin_id; ?>[brandID]">brandID:</label> </td>
        <td id="key-holder" width="366" style="padding:5px;"><input placeholder="Got a InviteReferrals brandid? Enter it here." id="invitereferrals_brandid" name="<?php echo $this->plugin_id; ?>[brandID]" type="text" value="<?php echo $options['brandID']; ?>" size="40" /></td>
    </tr>
    <tr>
        <td width="144" height="16" align="right"></td>
        <td width="366" style="border-bottom: 1px solid #CCC;padding:0 0 10px 0;"><p style="margin-top:3px;font-size:10px;">You can find brandid in invitereferrals admin panel -> "website Integration"</p></td>
    </tr>       
          
          
    <tr>
        <td width="144" height="26" align="right" style="padding:0 30px 0 0;vertical-align: top;"><label style="font-weight:600" for="<?php echo $this->plugin_id; ?>[secretkey]">Secret Key:</label> </td>
        <td id="key-holder" width="366" style="padding:5px;"><input placeholder="Got a InviteReferrals Secret key? Enter it here." id="invitereferrals_key" name="<?php echo $this->plugin_id; ?>[secretkey]" type="text" value="<?php echo $options['secretkey']; ?>" size="40" /></td>
    </tr>
    <tr>
        <td width="144" height="16" align="right"></td>
        <td width="366" style="border-bottom: 1px solid #CCC;padding:0 0 10px 0;"><p style="margin-top:3px;font-size:10px;">You can find Secret key in invitereferrals admin panel -> "website Integration". You may Click <a href="http://www.invitereferrals.com/campaign/brand/">here</a> to sign up on InviteReferrals.</p></td>
    </tr>          
          
          
    <tr>
        <td width="144" height="26" align="right" style="margin-top:20px;padding:0 30px 0 0;vertical-align: top;"><label style="font-weight:600" for="<?php echo $this->plugin_id; ?>[enable_rewards]">Enable rewards:</label> </td>
        <td width="366"><input type="hidden" name="<?php echo $this->plugin_id; ?>[enable_rewards]" value="0" /><input name="<?php echo $this->plugin_id; ?>[enable_rewards]" type="checkbox" <?php echo ($options['enable_rewards'] || !isset($options['enable_rewards']))?'checked="checked"':''; ?> /></td>
    </tr>	

    <tr>
        <td width="144" height="26" align="right"> </td>
        <td width="366"><input type="submit" name="submit" value="Save Options" class="button-primary" /><div>By installing InviteReferrals you agree to the <a href="http://www.invitereferrals.com/campaign/site/policy">Customer Agreement</a></div></td>
    </tr>
    </table>
    </form>
</div>
