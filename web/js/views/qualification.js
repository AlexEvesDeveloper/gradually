var app = app || {};

$(function(){
	app.QualificationView = Backbone.View.extend({
		tagName: 'div',
		className: 'qualificationContainer',
		template: _.template($('#qualificationTemplate').html()),
		render: function(){
			this.$el.html(this.template(this.model.attributes));
			return this;
		}
	});
});