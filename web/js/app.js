var app = app || {};

$(function(){
	var qualifications = [
		{university: 'University of London', degree: 'Computer Science', degreeLevel: 'MSc', result: '2', yearAttained: '2008'},
		{university: 'University of London', degree: 'Computer Science', degreeLevel: 'PhD', result: '1', yearAttained: '2009'},
	];

	new app.GraduateView(qualifications);
});