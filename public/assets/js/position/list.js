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