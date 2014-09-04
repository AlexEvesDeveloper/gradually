var app = app || {};

app.GraduateView = Backbone.View.extend({
	el: '#qualifications',
	initialize: function(initialQualifications){
		this.collection = new app.Graduate(initialQualifications);
		this.render();
	},
	render: function(){
		this.collection.each(function(item){
			this.renderQualification(item);
		}, this);
	},
	renderQualification: function(item){
		var qualificationView = new app.QualificationView({
			model: item
		});
		this.$el.append(qualificationView.render().el);
	}
});