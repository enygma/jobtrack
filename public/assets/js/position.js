// position.js

var PositionModel = Backbone.Model.extend({
	urlRoot: '/positions/index',
	defaults: {
		title         : null,
		location      : null,
		summary       : 'Default Summary',
		contact_name  : 'John Doe',
		contact_email : 'me@me.com',
		contact_phone : '214-555-1234',
		id            : 0
	}
});

var PositionFormView = Backbone.View.extend({

	events: {
		'click #submit-position' : 'submitPositionForm',
	},

	submitPositionForm: function(evt) {
		evt.preventDefault();

		var inputs = $('#position-form input');
		var values = {};
		jQuery.each(inputs,function(k,input){
			var input = $(input);
			var n 	  = input.attr('name');
			values[n] = input.val();
		});
		// get our summary too
		values['summary'] = $('#form_summary').val();

		// make a new Position model (PUT)
		var nPosition = new PositionModel(values);
		nPosition.save(null,{
			wait: true,
			success: function(model,response) {
				jtUtility.alert('Information saved!','Record Created!','success');

				// if there were no errors, clear the list
				//$('#position-form :input').val('');
			},
			error: function(model,response) {
				console.log('error!');
				jtUtility.errorHandler(model,response);
			}
		});
	}
});


var PositionListView = Backbone.View.extend({

	template: _.template('<tr> \
		<td><a href="/positions/view/<%= id %>"><%= title %></a></td> \
		<td><%= location %></td> \
		<td><%= created_at %></td> \
		</tr>'),

	initialize: function() {
		this.collection.bind('reset',this.render,this);
	},

	render: function() {
		var self = this;

		this.collection.each(function(record){
			self.$el.append(self.template( record.toJSON() ));
		});
	}
});
var PositionList = Backbone.Collection.extend({
	url: '/positions/index'
});

var positionView = new PositionFormView({
	el: $('#position-form')
});

var positionList = new PositionList({
	model: PositionModel
});

var positionListView = new PositionListView({
	collection: positionList,
	el: $('#positionListBody')
});
positionList.fetch();

// click to edit button
$('#edit-btn').click(function(e){
	var target = $(e.currentTarget);
	console.log(target);
	window.location = '/positions/index/'+target.attr('name');
});

