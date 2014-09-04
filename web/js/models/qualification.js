var app = app || {};

app.Qualification = Backbone.Model.extend({
	defaults: {
		university: 'No university',
		degree: 'No degree',
		degreeLevel: 'No degree level',
		result: 'No result',
		yearAttained: 'No year'
	}
});