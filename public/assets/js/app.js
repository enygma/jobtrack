<!-- app.js -->

var RecordModel = Backbone.Model.extend({

});

var RecordCollection = Backbone.Collection.extend({
	model: RecordModel,
	url: '/record/index.json'
});

var RecordFormView = Backbone.View.extend({
	events: {
		'click #submit-record' : 'submitRecordForm'
	},

	submitRecordForm: function(evt) {
		evt.preventDefault(); // prevent the form submit

		console.log('submit form!');
	}
});

var records = new RecordCollection;
var formView = new RecordFormView({
	el: $('#record-form')
});

records.fetch();
