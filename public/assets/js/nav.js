// nav.js

var NavView = Backbone.View.extend({

	template_item   : _.template('<li class="active" fn="<%= func %>"><a href="#"><%= name %></a></li>'),
	template_parent : _.template('<li class="active dropdown">'
		+'<a href="#" class="dropdown-toggle" data-toggle="dropdown"><%= name %><b class="caret"></b></a>'
		+'<ul class="dropdown-menu">'
		+'<%= items %></ul></li>'),
	template_child  : _.template('<li><a class="child" href="#" fn="<%= func %>"><%= name %></a></li>'),

	events: {
		'click a.child' : 'itemClicked'
	},

	initialize: function() {
		console.log('init nav!');
		this.render();
	},
	render: function() {
		var self = this;
		jQuery.each(this.options.navItems,function(k,item) {
			if (typeof item.menu == 'undefined') {
				item.func = (typeof item.fn !== 'undefined') ? item.fn : '';
				self.$el.append(self.template_item( item ));
			} else {
				// we have children!
				var items = '';
				jQuery.each(item.menu,function(k,item){
					item.func = (typeof item.fn !== 'undefined') ? item.fn : '';
					items += self.template_child(item);
				});

				var func = (typeof item.fn !== 'undefined') ? item.fn : '';
				var i = {name:item.name,items:items,fn:func};
				self.$el.append(self.template_parent(i));	
			}
		});
	},
	itemClicked: function(evt) {
		// see if it has a "fn" attribute
		var fn = $(evt.currentTarget).attr('fn');
		if (typeof this.options[fn] !== 'undefined') {
			this.options[fn](evt.currentTarget);
		}
	}
});

var nview = new NavView({
	el: $('.nav-items'),
	navItems: [
		{
			name: 'Home',
			href: '#'
		},
		{
			name: 'Applicants',
			href: '#',
			menu: [
				{
					name: 'Add New',
					href: '#',
					fn: 'addNewApplicant'
				}
			]
		},
		{
			name: 'Positions',
			href: '#'
		}
	],
	addNewApplicant: function(target){
		jtUtility.enableForm();
	}
});
