// app.js

$(function() {
	var RecordModel = Backbone.Model.extend({
		defaults: {
			full_name: 'Test Name',
			id: 0
		}
	});

	//var record = new RecordModel({});

	var RecordCollection = Backbone.Collection.extend({
		url: '/record/index'
	});
	var records = new RecordCollection({model:RecordModel});

	var RecordFormView = Backbone.View.extend({
		events: {
			'click #submit-record' : 'submitRecordForm'
		},

		initialize: function() {
			// nothing to see, move along
		},

		submitRecordForm: function(evt) {
			evt.preventDefault(); // prevent the form submit

			var recordId = $('input[name=record_id]').val();
			if (recordId > 0) {
				// PUT request - find the record
				var record = this.collection.where({id:recordId});

				record[0].set({
					full_name: $('input[name=full_name]').val()
				});

				record[0].save();

			} else {
				// POST request
				records.create({
					full_name: $('input[name=full_name]').val()
				});
			}

			$('#record-form :input').val('');

			// refresh the list view too
			this.options.list.refreshList();
		}
	});

	var RecordListView = Backbone.View.extend({
		template: _.template('<a class="record-link" href="<%= id %>"><%= full_name %></a><br/>'),

		events: {
			'click .record-link' : 'loadRecord'
		},

		initialize: function() {
			this.collection.bind('reset',this.render,this);
		},
		render: function() {
			var self = this;
			this.collection.each(function(record){
				self.$el.append(self.template( record.toJSON() ));
			});
			return this;
		},
		loadRecord: function(evt) {
			evt.preventDefault();

			// find the record and populate the form with it
			var recordId = $(evt.currentTarget).attr('href');
			var record 	 = this.collection.where({id:recordId});

			// set the form values
			$('input[name=record_id]').val(record[0].get('id'));
			$('input[name=full_name]').val(record[0].get('full_name'));
		},
		refreshList: function() {
			this.$el.html('');
			this.collection.fetch();
		}
	});

	// display the latest records in the sidebar
	var listView = new RecordListView({
		el: $('#latest-records'),
		collection: records
	});

	// set up form handling
	var formView = new RecordFormView({
		el: $('#record-form'),
		collection: records,
		list: listView
	});

	records.fetch();

// end onReady
});
