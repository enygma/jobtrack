// position.js
$(function() {

var PositionModel = Backbone.Model.extend({
	urlRoot: '/positions/index',
	defaults: {
		title         : null,
		location      : null,
		summary       : 'Default Summary',
		contact_name  : 'John Doe',
		contact_email : 'me@me.com',
		contact_phone : '214-555-1234',
		id            : 0,
		tags          : ''
	}
});

var PositionFormView = Backbone.View.extend({

	events: {
		'click #submit-position' : 'submitPositionForm',
	},

	submitPositionForm: function(evt) {
		evt.preventDefault();

		// remove any errors currently displayed
		$("span[id^='errmsg-']").each(function(k,v){
			$(v).remove();
		});

		var inputs = $('#position-form input');
		var values = {};
		jQuery.each(inputs,function(k,input){
			var input = $(input);
			var n 	  = input.attr('name');
			values[n] = input.val();
		});
		// get our summary too
		values['summary'] = $('#form_summary').val();

		// see if we have an ID
		var positionId = $('input[name=position_id]').val();
		console.log('position ID: '+positionId);

		if (positionId > 0) {
			// build the data into a new model instance - we're saving (PUT)
			var nPosition = new PositionModel({id:positionId});
			nPosition.fetch({
				success: function(m) {
					// on success, set the new values and save
					m.set(values);
					m.save(null,{
						error: function(model,response){ 
							jtUtility.errorHandler(model,response);
						}
					});
					jtUtility.alert('Information saved!','Record Saved!','success');
				},
				error: function(model,response) {
					jtUtility.errorHandler(model,response);
				}
			});

		} else {
			// make a new Position model (POST)
			values.id = null;
			var nPosition = new PositionModel(values);

			nPosition.save(null,{
				wait: true,
				success: function(model,response) {
					jtUtility.alert('Information saved!','Record Created!','success');

					// if there were no errors, clear the list
					//$('#position-form :input').val('');
				},
				error: function(model,response) {
					jtUtility.errorHandler(model,response);
				}
			});
		}
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

//----------------
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

//-------------
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
			record.set('create_date',dt.getMonth()+'.'+dt.getDate()+'.'+dt.getFullYear()
				+' @ '+dt.getHours()+':'+dt.getMinutes()+':'+dt.getSeconds());

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


// click to edit button
$('#edit-btn').click(function(e){
	var target = $(e.currentTarget);
	console.log(target);
	window.location = '/positions/index/'+target.attr('name');
});

});
