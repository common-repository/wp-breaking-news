<?php

function wpbreakingnews_list_page()
	{
			
	  global $wpdb;
	  global $wpbreakingnews_table_name;
	  
?>
<div class="wrap">

<script type="text/javascript">
	function delete_message(idmessage, title)
	{
		if (confirm("Are you sure you want to delete the message " +  title + "?"))
		{
			document.forms["wpbreakingnews_listform"].wpbreakingnews_messagetodelete.value = idmessage;
			document.forms["wpbreakingnews_listform"].wpbreakingnews_action.value = "delete";
			document.forms["wpbreakingnews_listform"].submit();
		}
	}
</script>
<?php 
	if ( $_POST["wpbreakingnews_action"] == "delete" )
	{
		$wpdb->query("DELETE FROM " . $wpdb->prefix .  $wpbreakingnews_table_name .
					 " WHERE id_message = " . $_POST["wpbreakingnews_messagetodelete"] );	
	}
	
?>
<h2>WordPress News Slider</h2>
<form name="wpbreakingnews_listform" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>"
	  method="post" >
	<input type="hidden" name="wpbreakingnews_messagetodelete" value="">
	<input type="hidden" name="wpbreakingnews_action" value="">
				   
	<p class="submit">
		<input type="button" value="Add New Message" 
			   onclick="document.location='options-general.php?page=wpbreakingnews&wpbreakingnews_addnew=ok'">
		<br>
	</p>
</form>		
<br>
<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead">
	<th scope="col" class="manage-column column-name" style="">News Message</th>
	<th scope="col" class="manage-column column-email" style="">&nbsp;</th>
	<th scope="col" class="manage-column column-email" style="">&nbsp;</th>
</tr>
</thead>

<tbody id="users" class="list:user user-list">
<?php
	
	$query = " SELECT *  FROM " .
			  $wpdb->prefix . $wpbreakingnews_table_name;
			  
	$myMessages = $wpdb->get_results($query);
	
	foreach ($myMessages as $message)
	{
 ?>
        <tr id='user-1' class="alternate">
			<td class="username column-username">
				<?php echo substr($message->message_text,0,100) . "..."; ?>
		    </td>
		   
		   <td class="username column-username">
				<a href="options-general.php?page=wpbreakingnews&wpbreakingnews_id_message=<?php echo $message->id_message; ?>">
				Edit Message</a>
		   </td>
		   <td class="username column-username">
				<a href="javascript:delete_message(<?php echo $message->id_message ?>,'');">
				Delete Message</a>
		   </td>		
		</tr>
        
        <?
    }

?>
	
    </tbody>
</table>
<?php 
	}

?>