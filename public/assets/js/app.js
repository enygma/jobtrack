// app.js

$(function() {
	
	// nothing to see, move along
	jtUtility = {
		loadRecord: function(record) {
			// set the form values
			console.log(record);

			$('input[name=record_id]').val(record.get('id'));
			$('input[name=full_name]').val(record.get('full_name'));
			$('input[name=email]').val(record.get('email'));
			$('input[name=location]').val(record.get('location'));

			// if we have tags, stick 'em together
			var tagList = new Array();
			jQuery.each(record.get('tags'),function(k,v){
				tagList.push(v.tag);
			});
			$('input[name=tags]').val(tagList.join(', '));
		},
		alert: function(msg,title,type) {
			var a = new alertView({
				type:type,msg:msg,title:title,
				el: $('#messages')
			});
		},
		disableForm: function() {
			// disable the main form
			jQuery.each($('#record-form input'),function(k,input){
				$(input).attr('disabled','disabled');
			});
		},
		enableForm: function() {
			jQuery.each($('#record-form input'),function(k,input){
				$(input).removeAttr('disabled');
			});
		},
		errorHandler: function(model,response) {
			// show the errors in the messsage block
			// TODO - ick, i feel dirty for even using eval
			var obj    = eval('('+response.responseText+')');
			var errors = '';

			// for each of out errors, get the message and try to highlight the field
			jQuery.each(obj.errors,function(k,msg){
				errors += msg+'<br/>';

				// add a message letting them know there was a problem
				var f = $('input[name='+k+']');
				f.after('&nbsp;&nbsp;<span class="form-error" id="errmsg-'+k+'">error on field!</span>');
			});

			jtUtility.alert(errors,"Oops! There's a problem!",'error');
		}
	}

	alertView = Backbone.View.extend({

		events: {
			'click .close' : 'closeAlert'
		},
		initialize: function() {
			this.closeAlert();

			//TODO it needs to append but somehow know when the last message was there
			// timer on the messages to remove them after a while? (delay)

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

	jtUtility.disableForm();

// end onReady
});
