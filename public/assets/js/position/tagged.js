var PositionTaggedView = Backbone.View.extend({
	template: _.template('<tr><td><a href="/positions/view/<%= id %>"><%= title %></a></td> \
		<td><%= location %></td><td><%= create_date %></td><td><%= tags %></td></tr>'),

	initialize: function() {
		console.log('init view');
	},
	initialize: function() {
		this.collection.bind('reset',this.render,this);
	},

	render: function() {
		var self = this;

		this.collection.each(function(record){
			//console.log(record);
			var tagList = [];
			var tags    = record.get('tags');
 
			$.each(tags,function(k,tag) {
				tagList.push(tag.tag);
			});
			record.set('tags',tagList.join(','));

			var dt = new Date(record.get('created_at')*1000);
			record.set('create_date',dt.getMonth()+'.'+dt.getDate()+'.'+dt.getFullYear()+' @ '+dt.getHours()+':'+dt.getMinutes()+':'+dt.getSeconds());

			self.$el.append(self.template( record.toJSON() ));
		});
	}
});
var PositionTaggedList = Backbone.Collection.extend({
	url: '/positions/tagged',

	getByTag: function(tag) {
		this.url = '/positions/tagged/'+tag;
		this.fetch();
	}
});

var positionTagList = new PositionTaggedList({
	model: PositionModel
});
var positionTagView = new PositionTaggedView({
	el: $('#taggedWith'),
	collection: positionTagList
});
positionTagList.getByTag($('#form_tagList').val());