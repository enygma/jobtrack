$(function() {
	var RecordModel = Backbone.Model.extend({
		urlRoot  : '/record/index',
		defaults : {
			full_name: 'Test Name',
			id: 0,
			tags: ''
		}
	});

	//var record = new RecordModel({});

	var RecordCollection = Backbone.Collection.extend({
		url: '/record/index'
	});
	var records = new RecordCollection({model:RecordModel});

	var RecordFormView = Backbone.View.extend({
		events: {
			'click #submit-record' : 'submitRecordForm',
		},

		initialize: function() {
			// nothing to see, move along
		},

		submitRecordForm: function(evt) {
			evt.preventDefault(); // prevent the form submit

			// remove any errors currently displayed
			$("span[id^='errmsg-']").each(function(k,v){
				$(v).remove();
			});

			// get the values for all of our form inputs
			var inputs = $('#record-form input');
			var values = {};
			jQuery.each(inputs,function(k,input){
				var input = $(input);
				var n 	  = input.attr('name');
				values[n] = input.val();
			});

			var recordId = $('input[name=record_id]').val();
			console.log('record ID: '+recordId);

			if (recordId > 0) {
				// build the data into a new model instance - we're saving
				var nRecord = new RecordModel({id:recordId});
				nRecord.fetch({
					success: function(m) {
						console.log('success1');
						// on success, set the new values and save
						m.set(values);
						m.save();
						jtUtility.alert('Information saved!','Record Saved!','success');
					},
					error: function(model,response) {
						console.log('error1');
						jtUtility.errorHandler(model,response);
					}
				});

			} else {
				// PUT request
				console.log('PUT');
				var nRecord = new RecordModel(values);
				nRecord.save(null,{
					wait: true,
					error: function(model,response){
						console.log('error2');
						jtUtility.errorHandler(model,response);
					},
					success: function(msg) {
						console.log('success2');
						jtUtility.alert('Information saved!','Record Created!','success');

						// if there were no errors, clear the list
						$('#record-form :input').val('');
					}
				});
			}

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
			jtUtility.enableForm();

			// find the record and populate the form with it
			var recordId = $(evt.currentTarget).attr('href');
			console.log(recordId);

			//var record 	 = this.collection.where({id:recordId});
			var record = new RecordModel({id:recordId});
			record.fetch({
				success: function(model,response) {
					jtUtility.loadRecord(model);
				}
			});
		},
		refreshList: function() {
			this.$el.html('');
			this.collection.fetch();
		},
		searchRecords: function() {
			var searchQuery = $('#form_query').val();
			return this;
		}
	});

	// display the latest records in the sidebar
	var listView = new RecordListView({
		el: $('#latest-records'),
		collection: records,
		searchBtn: $('#search-btn')
	});

	// set up form handling
	var formView = new RecordFormView({
		el: $('#record-form'),
		collection: records,
		list: listView
	});

	records.fetch();
});