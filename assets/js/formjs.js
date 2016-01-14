//polingdistrictid: store parend polling district id as global
var polingdistrictid = '';
// store current selected poling divition id
function getdivisionid(id) {
	polingdistrictid = id;
	// alert(polingdistrictid);

}
// create xmlHttpRequest object
function createRequestObject() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	return xmlhttp;
}
/*
 * 'newdistrict','show-hide-div-1','show-hide-message-1','Polling_District_dropdown'
 * @str: input field id @showhidedivid: hiddn div id @messageid: mesage
 * id(success,error) @dropdownid:dropdown list id
 */
function addField(str, showhidedivid, messageid, dropdownid) {
	var title = document.getElementById(str).value;
	if (title == "") {
		alert('please add a poling district OR select existing one');
	} else {

		var xmlhttp = createRequestObject();

		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				document.getElementById(str).value = document
						.getElementById(str).defaultValue;
				document.getElementById(showhidedivid).style.display = "none";
				// document.getElementById(messageid).style.display = "block";
				document.getElementById(dropdownid).innerHTML = xmlhttp.responseText;

			}
		}
		var res = encodeURIComponent(title);
		xmlhttp.open("GET",
				"http://localhost/bulkuiisuru/index.php/atomVoteController/adddata/"
						+ res + "/" + polingdistrictid, true);
		xmlhttp.send();
	}

}

/*
 * show, hide,collapse input field: if polingdistrictid not selected alert
 * error, else show input field
 */
function showtogle() {
	if (polingdistrictid == '' || polingdistrictid == -1) {
		alert('Please Select a Polling Division');
	} else {
		$("#show-hide-div-1").slideToggle("slow");

	}
}