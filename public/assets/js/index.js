
var RecentPositionListView = Backbone.View.extend({
	template: _.template('<tr><td><a href="/positions/view/<%=id %>"><%=title %></a></td> \
		<td><%= create_date %></td> \
		<td><%= location %></td> \
		<td><%= summary_section %></td> \
		</tr>'),

	initialize: function() {
		this.collection.bind('reset',this.resetBase,this);
	},
	resetBase: function() {
		var self = this;

		// get the first model from the collection, this has our data
		var m = this.collection.models[0].get('positions');
		$.each(m,function(k,record){
			var dt = new Date(record.created_at*1000);
			record.create_date = dt.getMonth()+'.'+dt.getDate()+'.'+dt.getFullYear()
				+' @ '+dt.getHours()+':'+dt.getMinutes()+':'+dt.getSeconds();

			// split on the spaces and slice/append
			var p = record.summary.split(' ');
			record.summary_section = p.slice(0,5).join(' ')+'...';
			self.$el.append(self.template(record));
		});
	}
});

var RecentApplicantListView = Backbone.View.extend({
	template: _.template('<tr><td><a href="/applicants/edit/<%= id %>"><%=full_name %></a></td> \
		<td><%= email %></td> \
		<td><%= location %></td> \
		<td><%= create_date %></td> \
		</tr>'),

	initialize: function() {
		this.collection.bind('reset',this.resetBase,this);
	},
	resetBase: function() {
		var self = this;

		// get the first model from the collection, this has our data
		var m = this.collection.models[0].get('applicants');
		$.each(m,function(k,record){
			var dt = new Date(record.created_at*1000);
			record.create_date = dt.getMonth()+'.'+dt.getDate()+'.'+dt.getFullYear();
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