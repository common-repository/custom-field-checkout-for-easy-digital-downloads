jQuery( document ).ready(function() {
	jQuery(".addnewfielcfqjma").click(function(){
		jQuery(".showpopmaina").show();
	  return false;
	});	
	jQuery(".editfield_pop").click(function(){
		jQuery(".showpopmaina").show();
	  return false;
	});	
	jQuery(".closeicond").click(function(){
		jQuery(".showpopmaina").hide();
	  return false;
	});	
	jQuery(".field_type_cfcedd").change(function(){
		
		var field_type_cfcedd = jQuery(this).val();
		if (field_type_cfcedd=='select') {
			jQuery(".cfcedd_option").show();
		}else{
			jQuery(".cfcedd_option").hide();
		}
	  return false;
	});			
});