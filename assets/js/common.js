function selectCollection(id) {
   // alert("if condition start in collection");
    if (id != "-1") {
        loadData('Series', id); // get from option value id
    }
}

function selectSeries(series_id) {
    //alert("if condition start in series");
    if (series_id != "-1") {
        loadData('District', series_id);
    }
}

function selectDistrict(district_id) {
    if (district_id != "-1") {
        loadData('Year', district_id);
    }
}

function selectYear(year_id) {
    if (year_id != "-1") {
        loadData('Division', year_id);
    }
}

function selectDivision(division_id) {
    if (division_id != "-1") {
        loadData('Polling_District', division_id);
    }
}
/*function selectPolingDistrict(division_id) {
    if (division_id != "-1") {
        loadData('Polling_District', division_id);
    }
}*/

function loadData(loadType, loadId) {
    var dataString = 'loadType=' + loadType + '&loadId=' + loadId;
    $("#" + loadType + "_loader").show();
    $("#" + loadType + "_loader").fadeIn(400).html('Please wait... <img src="image/loading.gif" />');
    $.ajax({
        type: "POST",
        url: "loadData",
        data: dataString,
        cache: false,
        success: function (result) {
            $("#" + loadType + "_loader").hide();
            $("#" + loadType + "_dropdown").html("<option value='-1'>Select " + loadType + "</option>");
            $("#" + loadType + "_dropdown").append(result);
        }
    });
}
/* ajax error viewer */
$(function () {
    $.ajaxSetup({
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                //alert('Internal Server Error [500].');
                alert('No records in database');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
    });
});