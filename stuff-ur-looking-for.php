<?php

//load up jQuery
wp_enqueue_script("jquery");

include("Shortcode.php");

//Add shortcode
add_shortcode("mk-sp","mk_smart_player");

function mk_smart_player( $atts, $content )
{
    
    //for randomization
    $strAutoCode = mk_smart_player_random_code(rand(5,100));

    $div_player_id = "video-player-id-".$strAutoCode;
    $div_right_click_id = "right-click-id-".$strAutoCode;
    
    
    //get user details
    //shortcode_atts(array('textname'=> '','texttitlename'=> '','align'=> ''),$atts);
    $strVideoURL = $atts['videourl'];
    $strVideoImage = $atts['videoimage'];    
    $strVideoControlBar = $atts['videocontrolbar'];
    $strVideoAutoStart = $atts['videoautostart'];    
    $strVideoWidth = $atts['videowidth'];
    $strVideoHeight = $atts['videoheight'];
    
    //Player files
    $strPlayerJS = plugins_url( 'jwplayer.js', __FILE__ );
    $strPlayerSWFFile = plugins_url( 'player.swf', __FILE__ );
    

    $GetBaseURL = mk_smart_player_check($strVideoURL);
    
    //Display youtube player
    if ($GetBaseURL =="youtube.com" or $GetBaseURL =="youtu.be")
    {
        $GetYoutubeVideoID = mk_smart_player_get_youtube_id_from_url($strVideoURL);
       
        //Yes to auto start
        if ($strVideoAutoStart == "true")
        {
            $strVideoAutoStart = 1;
        }
        //No to auto start
        if ($strVideoAutoStart == "false")
        {
            $strVideoAutoStart = 0;
            
        }
        
        //No to control - play, pause and so on.
        if ($strVideoControlBar == "none")
        {
            $strVideoControlBar = 0;
            
        }
                
        // to control - play, pause and so on.
        if ($strVideoControlBar == "bottom")
        {
            $strVideoControlBar = 1;            
        }
        // to control - play, pause and so on.
        if ($strVideoControlBar == "over")
        {
            $strVideoControlBar = 1;            
        }
        
        $strIDStructure = '<iframe src="//www.youtube.com/embed/'.$GetYoutubeVideoID.'?modestbranding=1&amp;autoplay='.$strVideoAutoStart.'&amp;fs=0&amp;autohide=1&amp;rel=0&amp;controls='.$strVideoControlBar.'&amp;showinfo=0" height="'.$strVideoHeight.'" width="'.$strVideoWidth.'" allowfullscreen="" frameborder="0"></iframe>';
        return $strIDStructure;
    }
    //Display jwplayer
    else 
    {  
        $out .= "\n";
        $out .= '
                <div id="'.$div_right_click_id.'">
                    <div id="'.$div_player_id.'">
                        <center>Your browser does not support Flash or does not have it installed. 
                            <a href="http://www.adobe.com/products/flashplayer/" target="_blank">Click here download Flash Now</a>
                        </center>
                    </div>
                </div>            
                ';            
        $out .= "\n";
        
        $jqry .= '<script type="text/javascript" src="'.$strPlayerJS.'"></script>'; 
        $jqry .="   
                <script type=\"text/javascript\">
                    jwplayer('".$div_player_id."').setup(
                    {
                        'flashplayer': '".$strPlayerSWFFile."',
                        'id': 'playerID',
                        'file': '".$strVideoURL."',
                        'image' : '".$strVideoImage."',
                        'screencolor': '000000',
                        'stretching': 'exactfit',
                        'controlbar': '".$strVideoControlBar."',
                        'autostart': '".$strVideoAutoStart."',
                        'width': '".$strVideoWidth."',
                        'height': '".$strVideoHeight."'                    
                    });
                    var strButtonDivName = jQuery(\"#".$div_right_click_id."\");


                    strButtonDivName.bind(\"contextmenu\",function(e)
                    {
                       //e.preventDefault();
                        return false;
                    });
                </script>
                ";
        return $out.$jqry;
    }
}

function mk_smart_player_random_code($length) 
{
    //This function will get you a randon code. The length will be based on "$length" 
    $keys = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

    for($i=0; $i < $length; $i++) 
    {
        $key .= $keys[array_rand($keys)];

    }
    return $key;
}

function mk_smart_player_check($url) 
{ 
    //This function will take "http://google.com" and make it into "google.com"
    $input = trim($url, '/');
    if (!preg_match('#^http(s)?://#', $input)) 
    {
        $input = 'http://' . $input;
    }    
    $urlParts = parse_url($input);    
    // remove www
    $domain = preg_replace('/^www\./', '', $urlParts['host']);    
    return $domain;
} 
function mk_smart_player_get_youtube_id_from_url($url)
{
    if (stristr($url,'youtu.be/'))
        {preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); return $final_ID[4]; }
    else 
        {@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); return $IDD[5]; }
}
?>