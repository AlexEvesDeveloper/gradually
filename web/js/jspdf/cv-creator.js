function demoTwoPageDocument() {
	var doc = new jsPDF();

	doc.setFont("helvetica");
	doc.setFontType("normal");

	// name
	doc.text(20, 10, fullName);
	// e-mail
	doc.setFontSize(10);
	doc.text(70, 10, 'E-mail: ' + email);
	doc.setLineWidth(0.1);
	// how far from the left, y axis of the start point, length, y axis of the end point 
	doc.line(20, 20, 190, 20);

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

	
	// Save the PDF
	doc.output('save','Test.pdf');
}