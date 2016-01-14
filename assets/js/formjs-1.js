/* @slelectid: drop down id
 * @value: selected value in drop down for show text field
 * @shwhideid: input field id fo adding new item to the dro down
 *
 **/
/*function addPolingDistrict(slelectid, value, shwhideid) {
 var dropdown = document.getElementById(slelectid);
 dropdown.onchange = function showhide() {
 var selectedValue = dropdown.options[dropdown.selectedIndex].value;

 if (selectedValue == value) {
 document.getElementById(showhideid).style.display = "block";
 } else {
 document.getElementById(showhideid).style.display = "none";
 }
 }
 }*/
/*
 * when user select other, open the input field and that value will go to db and
 * also
 * 
 */
function createRequestObject() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	return xmlhttp;
}
function showUser(str,shwhideid,messagediv,dropdownid) {
	alert(str);
	var title = document.getElementById(str).value;
	alert(title);
	if (title == "") {
		/*
		 * document.getElementById("txtHint").innerHTML = ""; return;
		 */
		alert('please add a poling district OR select existing one');
	}

	var xmlhttp = createRequestObject();

	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

			document.getElementById(str).value = document.getElementById(str).defaultValue;
			document.getElementById(shwhideid).style.display = "none";
			document.getElementById(messagediv).style.display = "block";
			document.getElementById(dropdownid).innerHTML = xmlhttp.responseText;

		}
	}

	xmlhttp.open("GET",
			"http://localhost/bulkui/index.php/atomVoteController/adddata/"
					+ title, true);
	xmlhttp.send();

}

function addPolingDistrict(slelectid, value, shwhideid,messagediv) {
	var dropdown = document.getElementById(slelectid);
	var firstval = dropdown.options[dropdown.selectedIndex].value;
	if (firstval == value) {
		document.getElementById(shwhideid).style.display = "block";
	}
	dropdown.onchange = function showhide() {
		var selectedValue = dropdown.options[dropdown.selectedIndex].value;

		if (selectedValue == value) {

			document.getElementById(shwhideid).style.display = "block";
			document.getElementById(messagediv).style.display = "none";
		} else {

			document.getElementById(shwhideid).style.display = "none";
			document.getElementById(messagediv).style.display = "none";
		}
	}
}