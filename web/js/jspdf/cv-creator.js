function demoTwoPageDocument() {
	var doc = new jsPDF({'orientation':'portrait', 'lineHeight':1.5, 'textColor':'0.3 g'});

	doc.setFont("helvetica");

	// keep track of where we are
	verticalOffset = 10;

//--------------------------------------------------------
	// name
	doc.setFontType("bold");
	doc.text(20, verticalOffset, fullName);
	// e-mail
	doc.setFontType("normal");
	doc.setFontSize(10);
	doc.text(70, verticalOffset, 'E-mail: ' + email);

//--------------------------------------------------------

	verticalOffset += 15;
	doc.setFontSize(12);
	doc.setFontType("bold");
	doc.text(20, verticalOffset, 'Profile');
	doc.setLineWidth(0.1);
	verticalOffset += 2;
	// how far from the left, y axis of the start point, length, y axis of the end point 
	doc.line(20, verticalOffset, 190, verticalOffset);

	// PROFILE
	verticalOffset += 5;
	size = 9;
	doc.setFontType("normal");
	lines = doc.setFontSize(size).splitTextToSize(profile, 170)
	console.log(lines.length);
	doc.text(20, verticalOffset + size / 72, lines);
	verticalOffset += (lines.length * 5) + 5;
	doc.setLineWidth(0.1);
	doc.line(20, verticalOffset, 190, verticalOffset);
/*
	y = 30;
	console.log(exp);
	for(var inner in exp){
		var obj = exp[inner];
		for(var property in obj){
			if(obj.hasOwnProperty(property)){

				doc.text(20, y, property + ": " + obj[property]);
				//console.log(property);
				//console.log(obj[property]);
				y += 10;
			}
		}

		y += 10;
	}
*/
	
	// Save the PDF
	doc.output('save','Test.pdf');
}