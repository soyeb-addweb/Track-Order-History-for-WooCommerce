jQuery(document).ready(function($) {
	$('button[name="pastOrderCount"]').click(function(e){
		e.preventDefault();
		var uid = $(this).data('uid'); 
		var ordrid = $(this).data('ordrid');

		$.ajax({
			url: admin_ajax_call.ajax_url,
			type: 'post',
			data : {
				'action' : 'get_all_order_details',   
				user_id	 : uid,
				cur_ordrid : ordrid
			},
			success: function (response) {
				$(".wp-list-table").append(response['data']);
				$("#myModal_"+ordrid).css("display","block");
			},
			error: function (response) {
				console.log('error');
			}
		});

	});
	$(document).on("click","#closeMyModal",function() {
		$(".model-order-close").css("display", "none");
		$(".model-order-close").remove();
	});
});