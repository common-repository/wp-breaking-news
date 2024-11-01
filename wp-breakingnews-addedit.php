<?php

function wpbreakingnews_edit_page() {
	global $wpdb;
	global $wpbreakingnews_table_name;
  
	// *** Post-It Info
	$id_message      	 = $_REQUEST["wpbreakingnews_id_message"];
	$message_text		 = "";
	$message_link 	 	 = "";
	$message_date    	 = date("Y-m-d");
			
	// *******  SAVE POST-IT ********
	if ( !($_POST["wpbreakingnews_submit"] == "ok") )
	{
		if ($id_message)
		{   $query = "SELECT * FROM " . $wpdb->prefix . $wpbreakingnews_table_name .  
							 			     " WHERE id_message = $id_message ";
			
		    $messageInfo = $wpdb->get_results($query);
			
			$message_text		 = $messageInfo[0]->message_text;
			
		}
	}
	else
	{
		   // *** Postits Data
		   $message_text        = str_replace("\'"," ",$_POST["wpbreakingnews_message_text"]);
		   
		   if ($id_message)
		   {
			    	 $query = " UPDATE " . $wpdb->prefix . $wpbreakingnews_table_name .  
				   				  " SET message_text   		= '$message_text' " . 
			    	 		 " WHERE id_message = $id_message ";
			    	 
			    	 $wpdb->query($query);
		   }
		   else
		   {
				    $query = "INSERT INTO " . $wpdb->prefix . $wpbreakingnews_table_name  .  
				   					 "( message_text )  " . 
				   				"VALUES ('$message_text') "; 
			    			     
			   		 $wpdb->query($query);
			    	 $lastID = $wpdb->get_results("SELECT MAX(id_message) as lastid_message ");
			    	 $id_message = $lastID[0]->lastid_message;
		  }
			    
	}
	 

?>
<div class="wrap">
<script type="text/javascript">
	function validateInfo(forma)
	{
		if (forma.wpbreakingnews_message_text.value == "")
		{
			alert("You must enter a text for the message");
			forma.wpbreakingnews_message_text.focus();
			return false;
		}
		
	return true;
}
</script>

<form name="wpbreakingnews_form" method="post" onsubmit="return validateInfo(this);" 
	  action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	  

<?php
    // Now display the options editing screen

    // header
	if ($id_message)
    	echo "<h2>" . __( 'Edit Message',    'mt_trans_domain' ) . "</h2>";
    else
       	echo "<h2>" . __( 'Add New Message', 'mt_trans_domain' ) . "</h2>";

    // options form
    
 ?>
    <?php if ( $_POST["wpbreakingnews_submit"] == "ok" ) { ?>
    <div class="updated"><p><strong><?php _e('Message information saved.', 'mt_trans_domain' ); ?></strong></p></div><br>	
    <? }; ?>

 	
 	<span class="stuffbox" >
 		
	     News Message<br>
		 <span class="inside">	
		 	<textarea id="wpbreakingnews_message_text" name="wpbreakingnews_message_text" 
		 	           rows="6" cols="60"><?php echo $message_text ?></textarea>
	     </span>
	     
	     <br>
	     
	     
	     
 	</span>
 

<p class="submit">
	<input type="hidden" name="wpbreakingnews_submit" value="ok">
	<input type="hidden" name="wpbreakingnews_id_message" value="<?php echo $id_message ?>">
	<input type="submit" name="Submit" value="<?php _e('Save Message Information', 'mt_trans_domain' ) ?>" />&nbsp;
	<input type="button" name="Return" value="<?php _e('Return to Message List', 'mt_trans_domain' ) ?>"
		   onclick="document.location='options-general.php?page=wpbreakingnews' " />
</p>

</form>

</div> <!-- **** DIV WRAPPER *** -->

<?php } ?>