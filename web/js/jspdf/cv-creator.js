function demoTwoPageDocument() {
	var doc = new jsPDF({'orientation':'portrait', 'lineHeight':1.5, 'textColor':'0.3 g'});

	doc.setFont("helvetica");

	// keep track of where we are
	verticalOffset = 10;

//--TOP BAR------------------------------------------------------

	// name
	doc.setFontType("bold");
	doc.text(20, verticalOffset, fullName);
	// e-mail
	doc.setFontType("normal");
	doc.setFontSize(10);
	doc.text(70, verticalOffset, 'E-mail: ' + email);

//--PROFILE-------------------------------------------------

	verticalOffset += 15;
	doc.setFontSize(12);
	doc.setFontType("bold");
	doc.text(20, verticalOffset, 'Profile');
	verticalOffset += 2;
	doc.setLineWidth(0.1);
	doc.line(20, verticalOffset, 190, verticalOffset);

	verticalOffset += 5;
	size = 9;
	doc.setFontType("normal");
	lines = doc.setFontSize(size).splitTextToSize(profile, 170)
	doc.text(20, verticalOffset + size / 72, lines);

//--WORK EXPERIENCE-------------------------------------------------

	verticalOffset += (lines.length * 5) + 5;
	doc.setFontSize(12);
	doc.setFontType("bold");
	doc.text(20, verticalOffset, 'Work Experience');
	verticalOffset += 2;
	doc.setLineWidth(0.1);
	doc.line(20, verticalOffset, 190, verticalOffset);

	verticalOffset += 5;
	doc.setFontSize(9);	
	for(var inner in exp){
		var obj = exp[inner];
				
		doc.setFontType("bold");
		doc.text(20, verticalOffset, obj["company"]);
		doc.text(170, verticalOffset, obj["yearFrom"] + " to " + obj["yearTo"]);
				
		verticalOffset +=5;
		doc.setFontType("normal");
		doc.text(20, verticalOffset, obj["summary"]);

		verticalOffset += 10;
	}

	
	// Save the PDF
	doc.output('save','Test.pdf');
}