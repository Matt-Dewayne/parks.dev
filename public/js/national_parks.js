(function() {
	"use strict";

	$("td").click(function(){
		switch(this.innerText) {
			case "Acadia":
				$("body").css("background-image", "url('/img/parks/acadia.jpg')");
				$("h1").html(this.innerText);$("h1").css("color","honeydew");
				break;
			case "American Samoa":
				$("body").css("background-image", "url('/img/parks/american_samoa.jpg')");
				$("h1").html(this.innerText);$("h1").css("color","honeydew");
				break;
			case "Arches":
				$("body").css("background-image", "url('/img/parks/arches.jpg')");
				$("h1").html(this.innerText).css("color","black");
				break;
			case "Badlands":
				$("body").css("background-image", "url('/img/parks/badlands.jpg')");
				$("h1").html(this.innerText).css("color","black");
				break;
			case "Big Bend":
				$("body").css("background-image", "url('/img/parks/big_bend.jpg')");
				$("h1").html(this.innerText);$("h1").css("color","honeydew");
				break;
			case "Biscayne":
				$("body").css("background-image", "url('/img/parks/biscayne.jpg')");
				$("h1").html(this.innerText);$("h1").css("color","honeydew");
				break;
			case "Black Canyon of the Gunnison":
				$("body").css("background-image", "url('/img/parks/black_canyon_gunnison.jpg')");
				$("h1").html(this.innerText).css("color","black");
				break;
			case "Bryce Canyon":
				$("body").css("background-image", "url('/img/parks/bryce_canyon.jpg')");
				$("h1").html(this.innerText).css("color","black");
				break;
			case "Canyonlands":
				$("body").css("background-image", "url('/img/parks/canyonlands.jpg')");
				$("h1").html(this.innerText).css("color","black");
				break;
			case "Capitol Reef":
				$("body").css("background-image", "url('/img/parks/capitol_reef.jpg')");
				$("h1").html(this.innerText).css("color","black");
				break;      
		}
	});

	$("td").dblclick(function(){
		$("body").css("background-image", "none");
		$("h1").html("National Parks");
		$("h1").css("color","black");
	});

})();
