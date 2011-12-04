<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script type="text/javascript">
   
    $(document).ready(function() {
   		
		$("#digitalNZ_message").keyup(function() {
			
			$('#digitalNZ_search_pane').load('http://localhost:8888/test2.html');
						//'http://api.digitalnz.org/records/v1.xml?search_text=social+welfare&num_results=1&api_key=Ks2dxBpsU2yTa9Ckhm0p');
				
   		});
 	});
</script>

<?php 
// add plugin hooks
add_plugin_hook('config', 'digitalNZ_config');
add_plugin_hook('config_form', 'digitalNZ_config_form');
 
// save plugin configuration page
function digitalNZ_config()
{
    // save the message as a plugin option
    set_option('digitalNZ_message', trim($_POST['digitalNZ_message']));
}
 
// show plugin configuration page
function digitalNZ_config_form()
{
    // create a form inputs to collect the user's message
    echo '<div id="digitalNZ_config_form">';
    echo '<label for="digitalNZ_message">DigitalNZ content :</label>';             
    echo text(array('name'=>'digitalNZ_message'), get_option('digitalNZ_message'), null);
	echo '</div>';
	
	echo '<div id="digitalNZ_search_pane">';
	echo '<p>hello</p>';
	echo '</div>';
	
}
?>


