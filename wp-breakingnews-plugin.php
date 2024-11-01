<?php
/*
Plugin Name: WP Breaking News
Plugin URI:  http://www.grupomayanfriends.com/wp-breaking-news/
Description: Puts a marquee on the top of your wordpress blog showing messages you want.
Author: Angeline Strauss
Version: 1.0
Author URI: http://www.grupomayanfriends.com/
*/


// *********** SETUP *********** //

register_activation_hook(__FILE__,'wpbreakingnews_install');

$wpbreakingnews_table_name = "breakingnews";

function wpbreakingnews_install () {
   global $wpdb;
   $wpbreakingnews_table_name = "breakingnews";
   
   $table_name = $wpdb->prefix . $wpbreakingnews_table_name;
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id_message mediumint(9) NOT NULL AUTO_INCREMENT,
	  message_text TEXT NOT NULL,
	  UNIQUE KEY id_message (id_message)
	);";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
	
    // **** Insert two messages **** 
    $siteurl = get_option("siteurl"); 
    $query = "INSERT INTO " . $table_name  . "( message_text)  " . 
		" VALUES ('This is a breaking news !! ') "; 
    $wpdb->query($query);
    
    $query = "INSERT INTO " . $table_name  . "( message_text)  " . 
		" VALUES ('The lastest breaking news have been installed !! ') "; 
    $wpdb->query($query);
			   		 
   }
}




include ("wp-breakingnews-list.php");
include ("wp-breakingnews-addedit.php");
function wpbreakingnews_add_pages() {
    
	// Add a new submenu under Options:
	 if ($_REQUEST["wpbreakingnews_id_message"] || $_REQUEST["wpbreakingnews_addnew"] )
   		add_options_page('WP Breaking News', 'WP Breaking News', 8, 'wpbreakingnews', 'wpbreakingnews_edit_page');
     else
		add_options_page('WP Breaking News', 'WP Breaking News', 8, 'wpbreakingnews', 'wpbreakingnews_list_page');
}


function wpbreakingnews_setscripts()
{
	?>
	
	<script type="text/javascript">

		var speed = 6; 
 
 		function populatescroller()
		{
			var windowwidth = iecompattest().clientWidth;
		
			document.getElementById("alertit").style.width  = windowwidth;
			document.getElementById("alertit").scrollAmount = speed;
			document.getElementById("alertit").scrollDelay  = 20;
		}

		function iecompattest()
		{
			return (document.compatMode!="BackCompat") ? document.documentElement : document.body;
		}
		
		window.onload   = populatescroller;
		window.onresize = populatescroller;
	</script>
	
	<?php
	
}


function wpbreakingnews_setmarquee()
{
	?>
	<div>
		<marquee id="alertit" style="position:absolute;left:0px;top:0;background-color:#FFFFE6" 
				   onMouseover="this.scrollAmount=1" 
				   onMouseout="this.scrollAmount=speed" width="100%" height="28px">
	<?php
			global $wpdb;
			global $wpbreakingnews_table_name;
			$table = $wpdb->prefix . $wpbreakingnews_table_name; 
			$messages = $wpdb->get_results("SELECT * FROM $table ORDER BY id_message");
			
			foreach ($messages as $message) {
	?>				   
				   <span style="font:italic 22px Arial;color:red;margin-right:100px;">
							<?php echo $message->message_text ?>
				   </span>
	
	<?php } ?>
			<br><font style="font-size:6px;">Created by 
								<a href="http://www.grupomayanguides.com/" target="_TOP" title="grupo mayan">grupo mayan</a>
			</font>
		 </marquee>
	 </div>
	<?php
}

add_action("wp_footer",  "wpbreakingnews_setscripts");
add_action("wp_head",    "wpbreakingnews_setmarquee");
add_action('admin_menu', "wpbreakingnews_add_pages");

?>