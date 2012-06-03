// app.js

$(function() {
	
	// nothing to see, move along
	jtUtility = {
		loadRecord: function(record) {
			// set the form values
			console.log(record);

			$('input[name=record_id]').val(record.get('id'));
			$('input[name=full_name]').val(record.get('full_name'));
		},
		alert: function(msg,title,type) {
			var a = new alertView({
				type:type,msg:msg,title:title,
				el: $('#messages')
			});
		}
	}

	alertView = Backbone.View.extend({

		events: {
			'click .close' : 'closeAlert'
		},
		initialize: function() {
			var alertType = 'alert-'+this.options.type.toLowerCase();

			$('#messages').append(' \
				<div class="alert '+alertType+'"> \
  				<a class="close" data-dismiss="alert" href="#">×</a> \
  				<h4 class="alert-heading">'+this.options.title+'</h4> \
  				'+this.options.msg+'</div>');

			// scroll to top
			window.scrollTo(0, 0);
		},
		closeAlert: function() {
			$('#messages').html('');
		}
	});

	// disable the main form
	jQuery.each($('#record-form input'),function(k,input){
		$(input).attr('disabled','disabled');
	});

// end onReady
});
