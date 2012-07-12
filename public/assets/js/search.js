$(function(){

	var SearchModel = Backbone.Model.extend({
		defaults: {
			full_name: 'Test Name',
			id: 0
		}
	});

	var SearchCollection = Backbone.Collection.extend({
		url: '/record/search'
	});

	var search = new SearchCollection({model:SearchModel});

	var SearchResultsView = Backbone.View.extend({
		template: _.template('<a class="record-link" href="<%= id %>"><%= full_name %></a><br/>'),
		events: {
			'click .clear-results' : 'clearResults',
			'click .record-link'   : 'loadRecord'
		},

		render: function() {
			var self = this;

			// fetch the search results and fill in the suggestions box
			this.$el.css({'display':'block'});
			this.$el.html('<h3>Search Results</h3>');

			if (this.collection.length > 0) {
				this.collection.each(function(record){
					self.$el.append(self.template( record.toJSON() ));
				});
			} else {
				this.$el.append('<b>No results found</b><br/>');
			}

			this.$el.append('<a class="clear-results" href="#">Clear Results</a><br/>');
			return this;
		},
		clearResults: function() {
			$('#form_query').val('');
			this.$el.css('display','none');
			this.$el.html('');
		},

		loadRecord: function(evt) {
			evt.preventDefault();

			// find the record and populate the form with it
			var recordId = $(evt.currentTarget).attr('href');
			var record 	 = this.collection.where({id:recordId});

			jtUtility.loadRecord(record[0]);
		}
	});

	var SearchView = Backbone.View.extend({
		
		events: {
			'click #search-btn' : 'searchRecords'
		},

		initialize: function() {
			console.log('init search view');
		},
		searchRecords: function(event) {
		
			var self = this;	
			var searchQuery = $('#form_query').val();

			this.collection.fetch({
				data:{query:searchQuery},
				success: function() {
					self.options.resultsView.render();
				}
			});
		},
		clearResults: function() {
			// nothing to see, move along
		}
	});

	var rview = new SearchResultsView({
		el: $('#search-results'),
		collection: search
	});
	var sview = new SearchView({
		el: $('.form-search'),
		collection: search,
		resultsView: rview
	});

// end onReady
});