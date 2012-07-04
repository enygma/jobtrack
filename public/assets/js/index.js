
var RecentPositionListView = Backbone.View.extend({
	template: _.template('<a href="/positions/view/<%=id %>"><%=title %></a><br/>'),

	initialize: function() {
		this.collection.bind('reset',this.resetBase,this);
	},
	resetBase: function() {
		var self = this;

		// get the first model from the collection, this has our data
		var m = this.collection.models[0].get('positions');
		$.each(m,function(k,record){
			self.$el.append(self.template(record));
		});
	}
});

var RecentApplicantListView = Backbone.View.extend({
	template: _.template('<a href=""><%=full_name %></a><br/>'),

	initialize: function() {
		this.collection.bind('reset',this.resetBase,this);
	},
	resetBase: function() {
		var self = this;

		// get the first model from the collection, this has our data
		var m = this.collection.models[0].get('applicants');
		$.each(m,function(k,record){
			self.$el.append(self.template(record));
		});
	}
});

// get the list, split it out into the two types of models
var RecentCollection = Backbone.Collection.extend({
	url: '/index/recent'
});

rcollection = new RecentCollection();

var recentPosView = new RecentPositionListView({
	el: $('#recentPositions'),
	collection: rcollection
});
var recentAppView = new RecentApplicantListView({
	el: $('#recentApplicants'),
	collection: rcollection
});

rcollection.fetch();