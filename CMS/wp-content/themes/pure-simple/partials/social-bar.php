<?php
/**
 * Social bar group 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<?php if( get_theme_mod( 'hide_social' ) == '') { ?>
	<div id="socialbar">
		<?php $options = get_theme_mods();						
		echo '<div id="social-icons">';										
		if (!empty($options['twitter_uid'])) echo '<a title="Twitter" href="' . $options['twitter_uid'] . '" target="_blank"><div id="twitter" class="socialicon fa-twitter"></div></a>';
		if (!empty($options['facebook_uid'])) echo '<a title="Facebook" href="' . $options['facebook_uid'] . '" target="_blank"><div id="facebook" class="socialicon fa-facebook"></div></a>';
		if (!empty($options['google_uid'])) echo '<a title="Google+" href="' . $options['google_uid'] . '" rel="publisher" target="_blank"><div id="google" class="socialicon fa-google-plus"></div></a>';			
		if (!empty($options['linkedin_uid'])) echo '<a title="Linkedin" href="' . $options['linkedin_uid'] . '" target="_blank"><div id="linkedin" class="socialicon fa-linkedin"></div></a>';
		if (!empty($options['pinterest_uid'])) echo '<a title="Pinterest" href="' . $options['pinterest_uid'] . '" target="_blank"><div id="pinterest" class="socialicon fa-pinterest"></div></a>';
		if (!empty($options['flickr_uid'])) echo '<a title="Flickr" href="' . $options['flickr_uid'] . '" target="_blank"><div id="flickr" class="socialicon fa-flickr"></div></a>';
		if (!empty($options['youtube_uid'])) echo '<a title="Youtube" href="' . $options['youtube_uid'] . '" target="_blank"><div id="youtube" class="socialicon fa-youtube"></div></a>';
		if (!empty($options['vimeo_uid'])) echo '<a title="Vimeo" href="' . $options['vimeo_uid'] . '" target="_blank"><div id="vimeo" class="socialicon fa-vimeo-square"></div></a>';		
		if (!empty($options['instagram_uid'])) echo '<a title="Instagram" href="' . $options['instagram_uid'] . '" target="_blank"><div id="instagram" class="socialicon fa-instagram"></div></a>';		
		if (!empty($options['reddit_uid'])) echo '<a title="Reddit" href="' . $options['reddit_uid'] . '" target="_blank"><div id="reddit" class="socialicon fa-reddit"></div></a>';
		//if (!empty($options['picassa_uid'])) echo '<a title="picassa" href="' . $options['picasa_uid'] . '" target="_blank"><div id="picasa" class="socialicon fa-picasa"></div></a>';
		if (!empty($options['stumbleupon_uid'])) echo '<a title="stumbleupon" href="' . $options['stumbleupon_uid'] . '" target="_blank"><div id="stumbleupon" class="socialicon fa-stumbleupon"></div></a>';	
		if (!empty($options['wp_uid'])) echo '<a title="WordPress" href="' . $options['wp_uid'] . '" target="_blank"><div id="wordpress" class="socialicon fa-wordpress"></div></a>';	
		if (!empty($options['github_uid'])) echo '<a title="Github" href="' . $options['github_uid'] . '" target="_blank"><div id="github" class="socialicon fa-github"></div></a>';
		if (!empty($options['dribbble_uid'])) echo '<a title="Dribbble" href="' . $options['dribbble_uid'] . '" target="_blank"><div id="dribbble" class="socialicon fa-dribbble"></div></a>';
		if (!empty($options['tumblr_uid'])) echo '<a title="Tumblr" href="' . $options['tumblr_uid'] . '" target="_blank"><div id="tumblr" class="socialicon fa-tumblr"></div></a>';		
		if (!empty($options['rss_uid'])) echo '<a title="rss" href="' . $options['rss_uid'] . '" target="_blank"><div id="rss" class="socialicon fa-rss"></div></a>';	
				 
		echo '</div>'		
		?>	
       
	</div>
<?php } ?>