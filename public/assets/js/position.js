// position.js

require(['position/list','position/related','position/tagged']);

var PositionModel = Backbone.Model.extend({
	urlRoot: '/positions/index',
	defaults: {
		title         : null,
		location      : null,
		summary       : 'Default Summary',
		contact_name  : 'John Doe',
		contact_email : 'me@me.com',
		contact_phone : '214-555-1234',
		id            : 0,
		tags          : ''
	}
});

var PositionFormView = Backbone.View.extend({

	events: {
		'click #submit-position' : 'submitPositionForm'
	},

	submitPositionForm: function(evt) {
		evt.preventDefault();

		// remove any errors currently displayed
		$("span[id^='errmsg-']").each(function(k,v){
			$(v).remove();
		});

		var inputs = $('#position-form input');
		var values = {};
		jQuery.each(inputs,function(k,input){
			var input = $(input);
			var n 	  = input.attr('name');
			values[n] = input.val();
		});
		// get our summary too
		values['summary'] = $('#form_summary').val();

		// see if we have an ID
		var positionId = $('input[name=position_id]').val();
		console.log('position ID: '+positionId);

		if (positionId > 0) {
			// build the data into a new model instance - we're saving (PUT)
			var nPosition = new PositionModel({id:positionId});
			nPosition.fetch({
				success: function(m) {
					// on success, set the new values and save
					m.set(values);
					m.save(null,{
						error: function(model,response){ 
							jtUtility.errorHandler(model,response);
						}
					});
					jtUtility.alert('Information saved!','Record Saved!','success');
				},
				error: function(model,response) {
					jtUtility.errorHandler(model,response);
				}
			});

		} else {
			// make a new Position model (POST)
			values.id = null;
			var nPosition = new PositionModel(values);

			nPosition.save(null,{
				wait: true,
				success: function(model,response) {
					jtUtility.alert('Information saved!','Record Created!','success');

					// if there were no errors, clear the list
					//$('#position-form :input').val('');
				},
				error: function(model,response) {
					jtUtility.errorHandler(model,response);
				}
			});
		}
	}
});

//-------------
// click to edit button
$('#edit-btn').click(function(e){
	var target = $(e.currentTarget);
	window.location = '/positions/index/'+target.attr('name');
});
$('#delete-btn').click(function(e){
	var cnf = confirm('Are you sure you want to delete this position?');
	if (cnf == true) {
		// they want to remove it
		var target     = $(e.currentTarget);
		var positionId = target.attr('name');
		var nPosition  = new PositionModel({id:positionId});
		nPosition.destroy({
			success: function(model,response) {
				// forward them back to the list page
				window.location.href = '/positions/recent';
			},
			error: function(model,response) {
				console.log('There was an error removing the position!');
				console.log(response);
			}
		});
	}
});
