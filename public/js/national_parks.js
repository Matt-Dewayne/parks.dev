(function() {
	"use strict";

	$("td").click(function(){
		switch(this.innerText) {
			case "Acadia":
				$("body").css("background-image", "url('/img/acadia.jpg')");
				$("h2").html(this.innerText);$("h2").css("color","honeydew");
				break;
			case "American Samoa":
				$("body").css("background-image", "url('/img/american_samoa.jpg')");
				$("h2").html(this.innerText);$("h2").css("color","honeydew");
				break;
			case "Arches":
				$("body").css("background-image", "url('/img/arches.jpg')");
				$("h2").html(this.innerText).css("color","black");
				break;
			case "Badlands":
				$("body").css("background-image", "url('/img/badlands.jpg')");
				$("h2").html(this.innerText).css("color","black");
				break;
			case "Big Bend":
				$("body").css("background-image", "url('/img/big_bend.jpg')");
				$("h2").html(this.innerText);$("h2").css("color","honeydew");
				break;
			case "Biscayne":
				$("body").css("background-image", "url('/img/biscayne.jpg')");
				$("h2").html(this.innerText);$("h2").css("color","honeydew");
				break;
			case "Black Canyon of the Gunnison":
				$("body").css("background-image", "url('/img/black_canyon_gunnison.jpg')");
				$("h2").html(this.innerText).css("color","black");
				break;
			case "Bryce Canyon":
				$("body").css("background-image", "url('/img/bryce_canyon.jpg')");
				$("h2").html(this.innerText).css("color","black");
				break;
			case "Canyonlands":
				$("body").css("background-image", "url('/img/canyonlands.jpg')");
				$("h2").html(this.innerText).css("color","black");
				break;
			case "Capitol Reef":
				$("body").css("background-image", "url('/img/capitol_reef.jpg')");
				$("h2").html(this.innerText).css("color","black");
				break;      
		}
	});

	$("td").dblclick(function(){
		$("body").css("background-image", "none");
		$("h2").html("National Parks");
		$("h2").css("color","black");
	});

})();
