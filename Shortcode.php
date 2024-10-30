<?php

//add a button to the content editor, next to the media button
//this button will show a popup that contains inline content
add_action('media_buttons_context', 'add_shortcode_custom_button');

//action to add a custom button to the content editor
function add_shortcode_custom_button($context) 
{  
  //path to my icon
  $img = plugins_url( 'wp-video-player-icon.png' , __FILE__ );
  
  //the id of the container I want to show in the popup
  $container_id = 'mk_smart_player_popup_container';
  
  //our popup's title
  $title = 'MK Smart Player - Click Here To Open';

  //append the icon
  $context .= "<a class='thickbox' title='{$title}' href='#TB_inline?width=100%&height=100%&inlineId={$container_id}'> <img src='{$img}' /></a>";
  //$context .= "<a class='thickbox' title='{$title}' href='#TB_inline?width=100&inlineId={$container_id}'> <button type='button'>MK Shortcodes</button></a>";
  
  return $context;
}

//add some content to the bottom of the page 
//This will be shown in the inline modal
add_action('admin_footer', 'mk_smart_player_add_shortcode_popup_content');

function mk_smart_player_add_shortcode_popup_content() 
{
    $ShortcodeWindowHeading = "MK - Smart Player";

?>
    <div id="mk_smart_player_popup_container" style="display:none;">
    <?/*-----<Shortcode Window Heading - Start>-----*/?>
      <h2><?echo $ShortcodeWindowHeading?></h2>
      <p><strong>Wanna see more plugins like these? Check out -  </strong><a href="http://MKPlugins.com" title="click here to check out the latest plugins" target="_blank">MKPlugins.com</a> </p>
    <?/*-----<Shortcode Window Heading - End>-----*/?>
   
    <script type="text/javascript">
    
    jQuery(document).ready(function() 
    {
       
        //For submit button
        jQuery("#mk_smart_player_insert_short_code").click(function() 
        {
            var strvideourl             = jQuery('#videourl');
            var strvideoimage           = jQuery('#videoimage');
            var strvideocontrolbar      = jQuery('#videocontrolbar');
            var strvideoautostart       = jQuery('#videoautostart');
            var strvideowidth           = jQuery('#videowidth');
            var strvideoheight          = jQuery('#videoheight');
            var shortcode               = 'mk-sp';
            
            if ((strvideourl.val() !=0)&(strvideourl.val()) !=null)
            {
                shortcode = shortcode + '  videourl=\''+strvideourl.val()+'\'';
            }
            if ((strvideoimage.val() !=0)&(strvideoimage.val()) !=null)
            {
                shortcode = shortcode + '  videoimage=\''+strvideoimage.val()+'\'';
            }
            if ((strvideocontrolbar.val() !=0)&(strvideocontrolbar.val()) !=null)
            {
                shortcode = shortcode + '  videocontrolbar='+strvideocontrolbar.val()+'';
            }                     
            if ((strvideoautostart.val() !=0)&(strvideoautostart.val()) !=null)
            {
                shortcode = shortcode + '  videoautostart='+strvideoautostart.val()+'';
            }
            if ((strvideowidth.val() !=0)&(strvideowidth.val()) !=null)
            {
                shortcode = shortcode + '  videowidth=\''+strvideowidth.val()+'\'';
            }                     
            if ((strvideoheight.val() !=0)&(strvideoheight.val()) !=null)
            {
                shortcode = shortcode + '  videoheight=\''+strvideoheight.val()+'\'';
            }   
                 
            var newsc = shortcode.replace(/  /g,' ');

            var strFinal = '['+newsc+']';
            window.send_to_editor(strFinal);
            
        });
        
        //For cancel button
        //This will close the window
        jQuery("#mk_smart_player_cancel_short_code").click(function() 
        {
            tb_remove(); 
            return false; 
        });
    }); 
    </script>

    <?/*-----<Short Code Form - Start>-----*/?>

  <table width="100%" border="0">
    <tr>
      <td>
      <?//----<Form Table Start>---\\?>
     
       <table width="100%" border="0">
    <tr>
      <td>
      <table width="100%" border="0" cellpadding="5" cellspacing="5">
      
        <tr>
          <td><strong>Video URL</strong></td>
        </tr>
        <tr>
          <td>
            <input name="videourl" type="text" id="videourl" size="60"></td>
        </tr>
        
        <tr>
          <td><strong>Video End Image URL</strong></td>
        </tr>
        <tr>
          <td>
            <input name="videoimage" type="text" id="videoimage" size="60"></td>
        </tr>        
        
        <tr>
          <td><strong>Video Control Bar</strong></td>
        </tr>
        <tr>
          <td>
            <select name="align" id="videocontrolbar"> 
                <option value="none">None</option>             
                <option value="bottom">Bottom</option>
                <option value="over">Over</option>
            </select>
          </td>
        </tr> 
        
        <tr>
          <td><strong>Video Auto Start</strong></td>
        </tr>
        <tr>
          <td>
            <select name="videoautostart" id="videoautostart">
              <option value="true">Yes</option>
              <option value="false">No</option>
            </select>
          </td>
        </tr> 
       
       <tr>
          <td><strong>Video Width</strong></td>
        </tr>
        <tr>
          <td>
            <input name="videowidth" type="text" id="videowidth" size="5" value="100%"> px</td>
        </tr> 
        
        <tr>
          <td><strong>Video Height</strong></td>
        </tr>
        <tr>
          <td>
            <input name="videoheight" type="text" id="videoheight" size="5" value="450"> px</td>
        </tr> 
              
      </table>
      
         <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td colspan="2">&nbsp;</td>
  </tr> 
    
</table>
      
      </td>

    </tr>
  </table> 
      <?//----<Form Table End>---\\?>
      
      </td>

    </tr>
  </table>
  <br><br><br>
  <div>
      <div style="float: left">
            <input class="button-primary" type="button" id="mk_smart_player_insert_short_code" name="mk_smart_player_insert_short_code" value="Insert Shortcode"/>
    </div>

        <div style="float: right">
            <input class="button"  type="button" id="mk_smart_player_cancel_short_code" name="mk_smart_player_cancel_short_code" value="Cancel"/>
        </div>
  </div>

  <?/*-----<Short Code Form - End>-----*/?>

    </div>
<?php
}
?>