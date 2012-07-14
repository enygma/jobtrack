var RelatedApplicantsView = Backbone.View.extend({
	template: _.template('<a href="/applicants/edit/<%= id %>"><%= full_name %></a> (<%= tags %>)'),

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
			self.$el.append(self.template( record.toJSON() ));
		});
	}
});
var RelatedApplicantsList = Backbone.Collection.extend({
	url: '/record/tagged',

	getByTag: function(tag) {
		this.url = '/record/tagged/'+tag;
		this.fetch();
	}
});
var ApplicantModel = Backbone.Model.extend({
	urlRoot: '/record/index',
	defaults: {
		full_name: 'John Doe',
		tags: ''
	}
});

var relatedAppList = new RelatedApplicantsList({
	model: ApplicantModel	
});
var relatedAppView = new RelatedApplicantsView({
	collection: relatedAppList,
	el: $('#relatedApplicants')
});
relatedAppList.getByTag($('#form_positionTags').val());