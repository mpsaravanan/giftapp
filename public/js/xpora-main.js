$(document).ready(function() {
	$(".nav-tabs a").click(function() {
		$(this).tab('show');
	});
	$(".start_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$(".end_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#fromdatesearch").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#todatesearch").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#start_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#end_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#cstart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#cend_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#dc_start_date").appendDtpicker({
		dateFormat: "YYYY-MM-DD hh:mm:00"
	});
	$("#dc_end_date").appendDtpicker({
		dateFormat: "YYYY-MM-DD hh:mm:00"
	});
	$("#tlstart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#tlend_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#alstart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#alend_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#mcastart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#mcaend_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#bstart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#bend_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#ustart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#usend_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#Sstart_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#Send_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	// $("#scheduled_date").datepicker({ dateFormat: "yy-mm-dd"});
	$("#scheduled_date").appendDtpicker({
		"dateFormat": "YY-MM-DD hh:mm:00"
	});
	$('#example1').DataTable();
	$('.editButton').on('click', function() {
		// Get the record's ID via attribute
		var id = $(this).attr('data-id');
		var emp_id = $(this).attr('data-empid');
		var name = $(this).attr('data-name');
		var email = $(this).attr('data-email');
		console.log(id + "-" + emp_id + "-" + name + "-" + email);
		$(".u_id").val(id);
		$(".u_empid").val(emp_id);
		$(".u_name").val(name);
		$(".u_email").val(email);
	});
	//Dashboard Counts Get Method...
	//getDashboardCounts();
	getSingleSearchCity();
	getCompetencyCity();
	getSingleCity();
	$.ajax({
		url: configAjax.jsRoutes[6].Getlocation,
		type: "get",
		dataType: "json",
		data: {
			getLoc: "val"
		},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<select data-placeholder="Choose a Location" class="chosen-select" style="width:220px;" tabindex="4" name="inputLoc[]" id="inputLoc" multiple>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>'
				}
				dropdownval += '</select>';
				$("#locVal").html(dropdownval);
				dropDownconfig();
			}
		}
	});
	getSipnumbers();
});

function editCompetency() {
	var source = $('#source').val();
	var source_1 = source.split(",");
	if (isInArray("Want Ad", source_1)) {
		$("#sourceWA").prop("checked", true);
	} else {
		$("#sourceWA").prop("checked", false);
	}
	if (isInArray("Requirement Popup", source_1)) {
		$("#sourceRP").prop("checked", true);
	} else {
		$("#sourceRP").prop("checked", false);
	}
	if (isInArray("Enquiry", source_1)) {
		$("#sourceEnq").prop("checked", true);
	} else {
		$("#sourceEnq").prop("checked", false);
	}
	if (isInArray("Click To Call In Listing", source_1)) {
		$("#sourceCCL").prop("checked", true);
	} else {
		$("#sourceCCL").prop("checked", false);
	}
	if (isInArray("Im Interested In Project", source_1)) {
		$("#sourceIP").prop("checked", true);
	} else {
		$("#sourceIP").prop("checked", false);
	}
	if (isInArray("Click To View In Listing", source_1)) {
		$("#sourceVL").prop("checked", true);
	} else {
		$("#sourceVL").prop("checked", false);
	}
	if (isInArray("Contact In Listing SNB", source_1)) {
		$("#sourceCLS").prop("checked", true);
	} else {
		$("#sourceCLS").prop("checked", false);
	}
	if (isInArray("Project Contact In BUILDER", source_1)) {
		$("#sourcePCB").prop("checked", true);
	} else {
		$("#sourcePCB").prop("checked", false);
	}
	if (isInArray("Project Contact In Project", source_1)) {
		$("#sourcePCP").prop("checked", true);
	} else {
		$("#sourcePCP").prop("checked", false);
	}
	if (isInArray("Contact In Listing Project", source_1)) {
		$("#sourceCLP").prop("checked", true);
	} else {
		$("#sourceCLP").prop("checked", false);
	}
	if (isInArray("Contact In Listing Flp", source_1)) {
		$("#sourceCLF").prop("checked", true);
	} else {
		$("#sourceCLF").prop("checked", false);
	}
	if (isInArray("Im Interested In Builder", source_1)) {
		$("#sourceIIB").prop("checked", true);
	} else {
		$("#sourceIIB").prop("checked", false);
	}
	if (isInArray("Chat in Listing", source_1)) {
		$("#sourceCL").prop("checked", true);
	} else {
		$("#sourceCL").prop("checked", false);
	}
	if (isInArray("QC", source_1)) {
		$("#sourceQC").prop("checked", true);
	} else {
		$("#sourceQC").prop("checked", false);
	}
	if (isInArray("Home Page Alert", source_1)) {
		$("#sourceHPA").prop("checked", true);
	} else {
		$("#sourceHPA").prop("checked", false);
	}
	var primary = $('#PI1').val();
	var primary_1 = primary.split(",");
	var primary2 = $('#PI2').val();
	var primary_2 = primary2.split(",");
	if (isInArray("Buy", primary_1)) {
		$("#primaryBuy").prop("checked", true);
	} else {
		$("#primaryBuy").prop("checked", false);
	}
	if (isInArray("Sell", primary_2)) {
		$("#primarySell").prop("checked", true);
	} else {
		$("#primarySell").prop("checked", false);
	}
	if (isInArray("Rent In", primary_1)) {
		$("#primaryRI").prop("checked", true);
	} else {
		$("#primaryRI").prop("checked", false);
	}
	if (isInArray("Rent Out", primary_2)) {
		$("#primaryRO").prop("checked", true);
	} else {
		$("#primaryRO").prop("checked", false);
	}
	if (isInArray("Pg in", primary_1)) {
		$("#primaryPI").prop("checked", true);
	} else {
		$("#primaryPI").prop("checked", false);
	}
	if (isInArray("Pg out", primary_2)) {
		$("#primaryPO").prop("checked", true);
	} else {
		$("#primaryPO").prop("checked", false);
	}
	var secondary = $('#SI1').val();
	var secondary_1 = secondary.split(",");
	var secondary2 = $('#SI2').val();
	var secondary_2 = secondary2.split(",");
	if (isInArray("Residential", secondary_1)) {
		$("#residentialedit").prop("checked", true);
	} else {
		$("#residentialedit").prop("checked", false);
	}
	if (isInArray("Apartment", secondary_2)) {
		$("#secondaryApt").prop("checked", true);
	} else {
		$("#secondaryApt").prop("checked", false);
	}
	if (isInArray("Builder Floor", secondary_2)) {
		$("#secondaryBF").prop("checked", true);
	} else {
		$("#secondaryBF").prop("checked", false);
	}
	if (isInArray("Villa", secondary_2)) {
		$("#secondaryVilla").prop("checked", true);
	} else {
		$("#secondaryVilla").prop("checked", false);
	}
	if (isInArray("Residential Plot", secondary_2)) {
		$("#secondaryRP").prop("checked", true);
	} else {
		$("#secondaryRP").prop("checked", false);
	}
	if (isInArray("Commercial", secondary_1)) {
		$("#commercialedit").prop("checked", true);
	} else {
		$("#commercialedit").prop("checked", false);
	}
	if (isInArray("Retail Shop", secondary_2)) {
		$("#secondaryRS").prop("checked", true);
	} else {
		$("#secondaryRS").prop("checked", false);
	}
	if (isInArray("Complex Office", secondary_2)) {
		$("#secondaryCO").prop("checked", true);
	} else {
		$("#secondaryCO").prop("checked", false);
	}
	if (isInArray("Commercial Plot", secondary_2)) {
		$("#secondaryCP").prop("checked", true);
	} else {
		$("#secondaryCP").prop("checked", false);
	}
	if (isInArray("Agriculture", secondary_1)) {
		$("#agricultureedit").prop("checked", true);
	} else {
		$("#agricultureedit").prop("checked", false);
	}
	if (isInArray("Agriculture Plot", secondary_2)) {
		$("#secondaryAP").prop("checked", true);
	} else {
		$("#secondaryAP").prop("checked", false);
	}
	getCompetencyCityEdit();
	var cityid = $("#city_name").val();
	var cityids = cityid.split(",");
	var city = $("#cityval").text();
	var citys = city.split(",");
	$("#justRefreshedit_txt").on('click', '.remove', function() {
		$(this).parent().parent().remove();
	});
}

function isInArray(value, array) {
	return array.indexOf(value) > -1;
}

function getSingleSearchCity() {
	//alert(1);
	$.ajax({
		url: configAjax.jsRoutes[20].GetSinglecity,
		type: "get",
		dataType: "json",
		data: {
			getCity: "val"
		},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<label for="city" class="control-label">City<span class="requiredstar">*</span></label><select data-placeholder="Choose a City" class="chosen-select" style="width:220px;" tabindex="4" name="uscity[]" id="uscity" onchange="getSingleSearchLocality(this.value);" multiple>';
				dropdownval += '<option value="N">Choose a City</option>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
				}
				dropdownval += '</select>';
				//       alert(dropdownval);
				$("#uscityValue").html(dropdownval);
				dropDownconfig();
			}
		}
	});
}

function getCompetencyCityEdit() {
	$.ajax({
		url: configAjax.jsRoutes[5].Getcity,
		type: "get",
		dataType: "json",
		data: {
			getCity: "val"
		},
		success: function(resp) {
			console.log(resp);
			if (resp.length >= 1) {
				var dropdownvaledit = '<select data-placeholder="Choose a City" class="chosen-select" style="width:220px;" tabindex="4" multiple name="inputCityedit[]" id="inputCityedit"><option value="">Select City</option>';
				var cityid = $("#city_name").val();
				var cityids = cityid.split(",");
				var city = $("#cityval").text();
				var citys = city.split(",");
				console.log(cityids);
				for (var i = 0; i < resp.length; i++) {
                    var cityidvalue=(resp[i].id).toString();
					if (cityids.indexOf(cityidvalue) != -1) {
						dropdownvaledit += '<option selected="selected" value="' + resp[i].id + '">' + resp[i].name + '</option>';
					} else {
						dropdownvaledit += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					}
				}
				dropdownvaledit += '</select>';
				$("#cityValedit").html(dropdownvaledit);
				dropDownconfig();
				$('#inputCityedit').chosen().change(function() {
					var values = $("#inputCityedit").chosen().val();
				});
			}
		}
	});
}

function getCompetencyCity() {
	$.ajax({
		url: configAjax.jsRoutes[5].Getcity,
		type: "get",
		dataType: "json",
		data: {
			getCity: "val"
		},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<select data-placeholder="Choose a City" class="chosen-select" style="width:220px;" tabindex="4" multiple name="inputCity[]" id="inputCity" ><option value="">Select City</option>';
				var dropdowncamp = '<label for="city_name_campaign" class="control-label">City</label><select data-placeholder="Choose a City" class="chosen-select" style="width:240px;" tabindex="4" multiple name="city_name_campaign" id="city_name_campaign"><option value="">Select City</option>';
				var dropdownagent = '<label for="city_name_agent" class="control-label">City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/></label><select data-placeholder="Choose a City" class="chosen-select" style="width:240px;" tabindex="4" multiple name="city_name_agent" id="city_name_agent"><option value="">Select City</option>';
				var dropdowncall = '<label for="city_name_call" class="control-label">City &nbsp;&nbsp;&nbsp;&nbsp;</label><select data-placeholder="Choose a City" class="chosen-select" style="width:260px;" multiple name="city_name_call" id="city_name_call">';
				var dropdownal = '<label for="city_name_al" class="control-label">City</label><select data-placeholder="Choose a City" class="chosen-select" style="width:240px;" tabindex="4" multiple name="city_name_al" id="city_name_al"><option value="">Select City</option>';
				var dropdownbrk = '<label for="city_name_brk" class="control-label">City</label><select data-placeholder="Choose a City" class="chosen-select" style="width:240px;" tabindex="4" multiple name="city_name_brk" id="city_name_brk"><option value="">Select City</option>';
				var dropdownsummary = '<label for="Scity_name_agent" class="control-label">City</label><select data-placeholder="Choose a City" class="chosen-select" style="width:240px;" tabindex="4" multiple name="Scity_name_agent" id="Scity_name_agent"><option value="">Select City</option>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdowncamp += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdownagent += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdowncall += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdownal += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdownbrk += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdownsummary += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
				}
				dropdownval += '</select>';
				dropdowncamp += '</select>';
				dropdownagent += '</select>';
				dropdowncall += '</select>';
				dropdownal += '</select>';
				dropdownbrk += '</select>';
				dropdownsummary += '</select>';
				$("#cityVal").html(dropdownval);
				$("#city_name_camp").html(dropdowncamp);
				$("#city_agent").html(dropdownagent);
				$("#city_name_dc").html(dropdowncall);
				$("#city_agentlog").html(dropdownal);
				$("#city_brk").html(dropdownbrk);
				$("#Scity_summary").html(dropdownsummary);
				dropDownconfig();
				$('#inputCity').chosen().change(function() {
					var values = $("#inputCity").chosen().val();
					//filter_GetLocationbaseCity(values);
				});
				$('#city_name_campaign').chosen().change(function() {
					var values = $("#city_name_campaign").chosen().val();
				});
				$('#city_name_agent').chosen().change(function() {
					var values = $("#city_name_agent").chosen().val();
				});
				$('#city_name_call').chosen().change(function() {
					var values = $("#city_name_call").chosen().val();
				});
				$('#city_name_al').chosen().change(function() {
					var values = $("#city_name_al").chosen().val();
				});
				$('#city_name_brk').chosen().change(function() {
					var values = $("#city_name_brk").chosen().val();
				});
				$('#Scity_name_agent').chosen().change(function() {
					var values = $("#Scity_name_agent").chosen().val();
				});
			}
		}
	});
}

function getSingleCity() {
	$.ajax({
		url: configAjax.jsRoutes[20].GetSinglecity,
		type: "get",
		dataType: "json",
		data: {
			getCity: "val"
		},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<label for="city" class="control-label">City<span class="requiredstar">*</span></label><select data-placeholder="Choose a City" class="chosen-select" style="width:220px;" tabindex="4" name="mcacity" id="mcacity" onchange="filter_telecaller(this.value);" ><option value="N">Choose City</option>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].name + '">' + resp[i].name + '</option>'
				}
				dropdownval += '</select>';
				$("#cityValue").html(dropdownval);
				dropDownconfig();
			}
		}
	});
}

function resetForm() {
	$('#createAgent')[0].reset();
}

function showDashboard() {
	$(".dashboardCont").css('display', 'block');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
}

function showCreateuser() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'block');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
}

function showProfile() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'block');
	$(".competency").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
}

function showSettings() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'block');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
}

function showCompetency() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'block');
	$(".currentStatus").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
}


function showReportDetails() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".showReportDetails").css('display', 'block');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
	//filterAgent();
}

function showCurrentReport() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".currentStatus").css('display', 'block');
	$(".showReportDetails").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'none');
	getCurrentStatus();
}
function showSummaryReport(){
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".pendingDetails").css('display', 'none');
	$(".summaryDetails").css('display', 'block');
	getSummaryDetails();
}
function showpendingReport() {
	$(".dashboardCont").css('display', 'none');
	$(".createuserCont").css('display', 'none');
	$(".showSettings").css('display', 'none');
	$(".showProfile").css('display', 'none');
	$(".competency").css('display', 'none');
	$(".showReportDetails").css('display', 'none');
	$(".currentStatus").css('display', 'none');
	$(".pendingDetails").css('display', 'block');
	$(".summaryDetails").css('display', 'none');
}
$('#commercialedit').click(function(event) {
	if (this.checked) {
		// Iterate each checkbox
		$('.commercialedit').each(function() {
			this.checked = true;
			this.disabled = false;
		});
	} else {
		// Iterate each checkbox 
		$(".commercialedit").each(function() {
			this.checked = false;
			this.disabled = true;
		});
	}
});
$('#residentialedit').click(function(event) {
	if (this.checked) {
		// Iterate each checkbox
		$('.residentialedit').each(function() {
			this.checked = true;
			this.disabled = false;
		});
	} else {
		// Iterate each checkbox 
		$(".residentialedit").each(function() {
			this.checked = false;
			this.disabled = true;
		});
	}
});
$('#agricultureedit').click(function(event) {
	if (this.checked) {
		// Iterate each checkbox
		$('.agricultureedit').each(function() {
			this.checked = true;
			this.disabled = false;
		});
	} else {
		// Iterate each checkbox 
		$(".agricultureedit").each(function() {
			this.checked = false;
			this.disabled = true;
		});
	}
});
$('#commercial').click(function(event) {
	if (this.checked) {
		// Iterate each checkbox
		$('.commercial').each(function() {
			this.checked = true;
			this.disabled = false;
		});
	} else {
		// Iterate each checkbox 
		$(".commercial").each(function() {
			this.checked = false;
			this.disabled = true;
		});
	}
});
$('#residential').click(function(event) {
	if (this.checked) {
		// Iterate each checkbox
		$('.residential').each(function() {
			this.checked = true;
			this.disabled = false;
		});
	} else {
		// Iterate each checkbox 
		$(".residential").each(function() {
			this.checked = false;
			this.disabled = true;
		});
	}
});
$('#agriculture').click(function(event) {
	if (this.checked) {
		// Iterate each checkbox
		$('.agriculture').each(function() {
			this.checked = true;
			this.disabled = false;
		});
	} else {
		// Iterate each checkbox 
		$(".agriculture").each(function() {
			this.checked = false;
			this.disabled = true;
		});
	}
});

function confirmDelete(id) {
	var r = confirm("Do you really want to delete?")
	if (r == true) {
		$.ajax({
			url: configAjax.jsRoutes[3].Deleteuser,
			type: "get",
			dataType: "json",
			data: {
				id: id
			},
			success: function(resp) {
				if (resp.status == 'Success') {
					alert("Deleted Successfully");
					location.reload();
				} else {
					alert("You can't Delete,Someone Reporting to this Person");
				}
			}
		});
	}
}

function getReportingto(elem) {
	var token = $("#_token").val();
	$.ajax({
		url: configAjax.jsRoutes[2].Reportingto,
		type: "get",
		dataType: "json",
		data: {
			level: elem
		},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<label for="inputReportingto" class="control-label">Reporting To<span class="requiredstar">*</span></label>';
				dropdownval += '<select class="form-control" name="inputReportingto" id="inputReportingto">';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '-(' + resp[i].email + ' - ' + resp[i].level + ')</option>'
				}
				dropdownval += '</select>';
				$("#reporting_tonew").html(dropdownval);
			}
		}
	});
}

function getSipnumbers() {
	$.ajax({
		url: configAjax.jsRoutes[12].Getavailsipnumber,
		type: "get",
		dataType: "json",
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<label for="sipNumber" class="control-label">Sip Number:<span class="requiredstar">*</span></label>';
				dropdownval += '<select class="form-control" name="sipNumber" id="sipNumber">';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].sip_number + '</option>'
				}
				dropdownval += '</select>';
				$("#sip_nonew").html(dropdownval);
				$("#createUserbutton").prop('disabled', false);
			} else {
				var dropdownval = '<label for="sipNumber" class="control-label">Sip Number:<span class="requiredstar">*</span></label>';
				dropdownval += '<select class="form-control" name="sipNumber" id="sipNumber">';
				dropdownval += '<option value="">-Sip Number Not Available-</option>';
				dropdownval += '</select>';
				$("#sip_nonew").html(dropdownval);
				$("#createUserbutton").prop('disabled', true);
			}
		}
	});
}

function updateProfile() {
	$.ajax({
		url: configAjax.jsRoutes[4].Edituser,
		type: "post",
		data: $('form.editProfile').serialize(),
		dataType: "json",
		success: function(resp) {
			if (resp.status == 'success') {
				alert("Updated Successfully");
				$("#form-content").modal('hide');
				location.reload();
			} else {
				alert("Error: Please try Again");
				//location.reload();
			}
		}
	});
}

function resetPassword() {
	var pass1 = $("#inputPassword").val();
	var pass2 = $("#inputConfirm").val();
	if (pass1 == "" || pass2 == "") {
		$("#errormsg").html("*Enter Password");
		return false;
	}
	if (pass1 != pass2) {
		$("#errormsg").html("*Password not Matching");
		return false;
	}
	$.ajax({
		url: configAjax.jsRoutes[0].Updatepassword,
		type: "post",
		dataType: "json",
		data: $('#reset-form').serialize(),
		success: function(resp) {
			if (resp.status == "success") {
				$("#errormsg").css('color', 'green');
				$('#reset-form')[0].reset();
				$("#errormsg").html("Password Updated Successfully");
			} else {
				$("#errormsg").html(resp.message);
			}
		}
	});
}

function createUserAgent() {
	var username = $("#inputName").val();
	var empid = $("#inputEmpidnew").val();
	var emailid = $("#inputEmail").val();
	var pass1 = $("#inputPasswordnew").val();
	var pass2 = $("#inputConfirmnew").val();
	var level = $("#inputLevel").val();
	var reportto = $("#inputReportingto").val();
	console.log(username);
	if (username == "") {
		alert("Enter User Name");
		return false;
	}
	if (empid == "") {
		alert("Enter Employee Id ");
		return false;
	}
	if (emailid == "") {
		alert("Enter Email Id ");
		return false;
	}
	if (pass1 == "") {
		alert("Enter Password");
		return false;
	}
	if (pass1 != pass2) {
		alert("Confirm Password Not Matching");
		return false;
	}
	$.ajax({
		url: configAjax.jsRoutes[1].Createagentpost,
		type: "post",
		data: $("#createAgent").serialize(),
		dataType: "json",
		success: function(resp) {
			if (resp.status == "success") {
				alert("Created Successfully");
				location.reload();
			} else if (resp.status == "exist") {
				alert("Employee Id Already Exist");
				location.reload();
			} else {
				alert("Failed to Update");
			}
		}
	});
}

function filterDashboard() {
	var namesearch = $("#nameSearch").val();
	var empidsearch = $("#empidSearch").val();
	var levelsearch = $("#levelSearch").val();
	if (namesearch == "") {
		namesearch = "N";
	}
	if (empidsearch == "") {
		empidsearch = "N";
	}
	if (levelsearch == "") {
		levelsearch = "N";
	}
	$.ajax({
		url: configAjax.jsRoutes[13].filterDashboard,
		type: "get",
		dataType: "json",
		data: {
			name: namesearch,
			empid: empidsearch,
			level: levelsearch
		},
		success: function(resp) {
			var tbl_row = '<div class="col-sm-12" id="searchTable">';
			tbl_row += '<table id="dashboardTable" style="font-size:10px;" class="table table-striped table-bordered" cellspacing="0" width="100%">';
			tbl_row += '<thead><tr style="background:#6F6F6F;color:#fff;"><th>Name</th><th>Emp ID</th><th>Email ID</th><th>Level</th><th>Reporting to</th><th>Profile Created at</th><th>Profile Updated at</th><th>View/Edit</th></tr></thead>';
			tbl_row += '<tbody id="app_table_body">';
			if (resp.length >= 1) {
				for (var i = 0; i < resp.length; i++) {
					tbl_row += "<tr>";
					tbl_row += '<td><a href="javascript:void(0);" onclick="showOrgChart(' + resp[i].id + ',' + resp[i].level + ');">' + resp[i].name + '</a></td>';
					tbl_row += "<td>" + resp[i].emp_id + "</td>";
					tbl_row += "<td>" + resp[i].email + "</td>";
					tbl_row += "<td>" + resp[i].level + "</td>";
					tbl_row += "<td>" + resp[i].reporting_name + "- (" + resp[i].reporting_level + ")</td>";
					tbl_row += "<td>" + resp[i].created_time + "</td>";
					tbl_row += "<td>" + resp[i].updated_time + "</td>";
					tbl_row += '<td><a href="javascript:void(0);" data-id="' + resp[i].id + '" data-empid="' + resp[i].emp_id + '" data-name="' + resp[i].name + '" data-email="' + resp[i].email + '" data-toggle="modal" data-target="#myModal" class="editButton">Edit</a>&nbsp;/&nbsp<a href="javascript:void(0);" onclick="confirmDelete(' + resp[i].id + ');">Delete</a></td>';
					tbl_row += "</tr>";
				}
				tbl_row += "</tbody></table></div>";
				$('#agentsDashboardTable').html(tbl_row);
				$('#dashboardTable').DataTable();
			} else {
				tbl_row += "";
				$('#agentsDashboardTable').html(tbl_row);
				$('#dashboardTable').DataTable();
			}
		}
	});
}

function filterPendingReport() {
	var tc_name = $("#tc_name").val();
	var source = $("#source").val();
	var category = $("#category").val();
	var getVal = {
		tc_name: tc_name,
		source: source,
		category: category
	};
	$.ajax({
		url: configAjax.jsRoutes[19].PendingReport,
		type: "get",
		dataType: "json",
		data: getVal,
		success: function(resp) {
			var tbl_row = '<div class="col-sm-12" id="searchTable">';
			tbl_row += '<table id="example7" style="font-size:10px;" class="table table-striped table-bordered" cellspacing="0" width="100%">';
			tbl_row += '<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Date/Time</th><th>User Name</th><th>Telecaller Name</th><th>(Competency Profile)City</th><th>Source</th><th>Category</th><th>Property types</th><th>Disposition Status</th><th>Call Status</th><th>Seeker No</th></tr></thead>';
			tbl_row += '<tbody id="app_table_body">';
			if (resp.length >= 1) {
				for (var i = 0; i < resp.length; i++) {
					tbl_row += "<tr>";
					tbl_row += "<td>" + (i + 1) + "</td>";
					tbl_row += "<td>" + resp[i].datetime + "</td>";
					tbl_row += "<td>" + resp[i].req_username + "</td>";
					tbl_row += "<td>" + resp[i].agent_name + "</td>";
					tbl_row += "<td>" + resp[i].city + "</td>";
					tbl_row += "<td>" + resp[i].source + "</td>";
					tbl_row += "<td>" + resp[i].category + "</td>";
					tbl_row += "<td>" + resp[i].property_types + "</td>";
					tbl_row += "<td>" + resp[i].dis_status + "</td>";
					tbl_row += "<td>" + resp[i].call_status + "</td>";
					tbl_row += "<td>" + resp[i].seeker_no + "</td>";
					tbl_row += "</tr>";
				}
				tbl_row += "</tbody></table></div>";
				$('#pendingDetails').html(tbl_row);
				$('#example7').DataTable();
			} else {
				tbl_row += "</tbody></table></div>";
				tbl_row += "";
				$('#pendingDetails').html(tbl_row);
				$('#example7').DataTable();
			}
		}
	});
}

function filter_telecaller(elem) {
	$.ajax({
		url: configAjax.jsRoutes[21].GetTelecaller,
		type: "get",
		dataType: "json",
		data: {
			getCity: elem
		},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<br><br><br><label for="telecaller" class="control-label">Assign To<span class="requiredstar">*</span></label><select data-placeholder="Tele Caller" class="chosen-select" id="mcatelecaller" style="width:220px;" tabindex="4" name="mcatelecaller" ><option value="N">Tele Caller</option>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].agent_id + '">' + resp[i].agent_name + '</option>'
				}
				dropdownval += '</select>';
				$("#telecallerValue").html(dropdownval);
			}
		}
	});
}

function filter_manual_call_assignment() {
	var start_date = $("#mcastart_date").val();
	var end_date = $("#mcaend_date").val();
	if (start_date == '') {
		start_date = 'N';
	}
	if (end_date == '') {
		end_date = 'N';
	}
	var city = $("#mcacity").val();
	if (city == '' || city == null || city == 'N') {
		alert("Please select City");
		return false;
	}
	var getCall = {
		city: city,
		start_date: start_date,
		end_date: end_date,
		action: "val"
	};
	$.ajax({
		url: configAjax.jsRoutes[23].MannualCallAssignment,
		type: "get",
		dataType: "json",
		data: getCall,
		success: function(resp) {
			var tbl_row = '<div class="col-sm-12" id="searchTable" style="overflow: scroll; width: 100%; max-height: 500px;"  >';
			tbl_row += '<table id="manual3" style="font-size:10px;"   class="table table-striped table-bordered" cellspacing="0" width="100%">';
			tbl_row += '<thead><tr style="background:#6F6F6F;color:#fff;"><th><input name="pending_call_checkbox[]" id="pending_call_checkbox" class="consph" type="checkbox" onClick="pending_call_checkbox_all()"/></th><th>Sr No.</th><th>Req id</th><th>Mobile No.</th><th>City</th><th>Timestamp</th></tr></thead>';
			tbl_row += '<tbody id="app_table_body">';
			if (resp.length >= 1) {
				var j = 1;
				for (var i = 0; i < resp.length; i++) {
					tbl_row += "<tr>";
					tbl_row += "<td><input name='pending_call[]' id='pending_call' class='consph' type='checkbox'  value='" + resp[i].req_id + "' /></td>";
					tbl_row += "<td>" + j + " id : " + resp[i].id + "</td>";
					tbl_row += "<td>" + resp[i].req_id + "</td>";
					tbl_row += "<td>" + resp[i].phone_no + "</td>";
					tbl_row += "<td>" + resp[i].city + "</td>";
					tbl_row += "<td>" + resp[i].inserted_time + "</td>";
					tbl_row += "</tr>";
					j++;
				}
				tbl_row += "</tbody></table></div>";
				$('#manual_call_assignmentDetails').html(tbl_row);
				$('#manual3').DataTable();
				$(".showbutton").css("display", "block");
			} else {
				tbl_row += "";
				$('#manual_call_assignmentDetails').html(tbl_row);
				$('#manual3').DataTable();
			}
		}
	});
}

function user_search_make_call() {
	var uscity = $("#uscity").val();
	if (uscity == '' || uscity == null || uscity == 'null' || uscity == 'N') {
		alert("Please select City");
		return false;
	}
	var usreqid = $("#usreqid").val();
	var ustart_date = $("#ustart_date").val();
	var usend_date = $("#usend_date").val();
	var usemail = $("#usemail").val();
	var uslocality = $("#uslocality").val();
	var uslast_call_dispotion = $("#uslast_call_dispotion").val();
	var getData = {
		uscity: uscity,
		ustart_date: ustart_date,
		usreqid: usreqid,
		usend_date: usend_date,
		usemail: usemail,
		uslocality: uslocality,
		uslast_call_dispotion: uslast_call_dispotion
	};
	$.ajax({
		url: configAjax.jsRoutes[35].GetUserSearchMakeCall,
		type: "get",
		dataType: "json",
		data: getData,
		success: function(resp) {
			var tbl_row = '<div class="col-sm-12" id="searchTable" style="overflow: scroll; width: 100%; max-height: 500px;"  >';
			tbl_row += '<table id="manual3" style="font-size:10px;"   class="table table-striped table-bordered" cellspacing="0" width="100%">';
			tbl_row += '<thead><tr style="background:#6F6F6F;color:#fff;"><th><input name="user_search_call_checkbox[]" id="user_search_call_checkbox" class="consph" type="checkbox" onClick="user_search_call_checkbox_all()"/></th><th>Timestamp</th><th>Req id</th><th>Profile City</th><th>Source</th><th>Category</th><th>Property Type</th><th> Call Disposition </th><th>Sheeker No</th></tr></thead>';
			tbl_row += '<tbody id="app_table_body">';
			if (resp.length >= 1) {
				var j = 1;
				for (var i = 0; i < resp.length; i++) {
					tbl_row += "<tr>";
					tbl_row += "<td><input name='user_search_call[]' id='user_search_call' class='consph1' type='checkbox'  value='" + resp[i].xpora_req_id + "' /></td>";
					tbl_row += "<td>" + resp[i].start_datetime_legA + "</td>";
					tbl_row += "<td><a href='http://172.16.1.156/xpora-reloaded/public/LeadformReq/" + resp[i].xpora_req_id + "'>" + resp[i].xpora_req_id + "</a></td>";
					//   tbl_row+="<td>"+resp[i].agent_name+"</td>";
					tbl_row += "<td>" + resp[i].city_id + "</td>";
					tbl_row += "<td>" + resp[i].source + "</td>";
					tbl_row += "<td>" + resp[i].category + "</td>";
					tbl_row += "<td>" + resp[i].property_types + "</td>";
					tbl_row += "<td>" + resp[i].status + "</td>";
					tbl_row += "<td>" + resp[i].caller_no + "</td>";
					// tbl_row+="<td><button  style='margin-top:5px;' class='btn btn-primary pull-right' type='button' onclick='user_search_make_call_call();' value='"+resp[i].xpora_req_id+"'>Call</button></td>";
					tbl_row += "</tr>";
					j++;
				}
				tbl_row += "</tbody></table></div>";
				$('#user_search_callDetails').html(tbl_row);
				$('#manual3').DataTable();
				$(".showbutton").css("display", "block");
			} else {
				tbl_row += "";
				$('#user_search_callDetails').html(tbl_row);
				$('#manual3').DataTable();
			}
		}
	});
}

function user_search_call_checkbox_all() {
	$("#user_search_call_checkbox").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
}

function assign_user_search_make_call() {
	var scheduled_date = $("#scheduled_date").val();
	var user_search_call_checkbox_req_id = "";
	var user_search_call_checkbox_req_id = $('input:checkbox:checked.consph1').map(function() {
		return this.value;
	}).get();
	//console.log(user_search_call_checkbox_req_id);
	//console.log(scheduled_date);
	//alert("scheduled_date  "+scheduled_date);
	$.ajax({
		url: configAjax.jsRoutes[37].AssignUserSearchMakeCall,
		type: "post",
		data: $("#user_search_call-form").serialize(),
		dataType: "json",
		success: function(resp) {
			if (resp.status == "success") {
				alert(resp.message);
				//location.reload();
				//alert("hello");
				window.location.href = window.location.href.split('#')[0];
			} else {
				alert("Failed to add Assignment pending call");
			}
		}
	});
}

function getSingleSearchLocality(elem) {
	var cityids = $("#uscity").val();
	if (cityids != null) {
		if (cityids.length > 1) {
			$("#uslocalityValue").css('display', 'none');
		} else {
			$("#uslocalityValue").css('display', 'block');
			console.log(cityids);
			var token = $("#_token").val();
			$.ajax({
				url: configAjax.jsRoutes[36].GetSingleSearchLocality,
				type: "get",
				dataType: "json",
				data: {
					getCity: elem
				},
				success: function(resp) {
					if (resp.length >= 1) {
						var dropdownval = '<label for="uslocality" class="control-label">Locality show</label><select data-placeholder="Choose a Locality" class="chosen-select form-control" id="uslocality" style="width:220px;" tabindex="4" name="uslocality" multiple="multiple" >';
						for (var i = 0; i < resp.length; i++) {
							dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
						}
						dropdownval += '</select>';
						//       alert(dropdownval);
						$("#uslocalityValue").html(dropdownval);
						dropDownconfig();
					}
				}
			});
		}
	}
}

function pending_call_checkbox_all() {
	$("#pending_call_checkbox").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
}

function assign_call_to_caller_val() {
	var telecallr = $("#mcatelecaller").val();
	if (telecallr == '' || telecallr == null || telecallr == 'N') {
		alert("Please select Telecaller");
		return false;
	}
	$.ajax({
		url: configAjax.jsRoutes[22].PendingCallpost,
		type: "post",
		data: $("#manual_call-form").serialize(),
		dataType: "json",
		success: function(resp) {
			if (resp.status == "success") {
				alert("Added Successfully");
				window.location.href = window.location.href.split('#')[0];
			} else {
				alert("Failed to add Assignment pending call");
			}
		}
	});
}

function filter_GetLocationbaseCity(elem) {
	$.ajax({
		url: configAjax.jsRoutes[33].GetLocationbaseCity + '?cityid=' + elem,
		type: "get",
		dataType: "json",
		//data:{cityid:elem},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<select data-placeholder="Choose a Locality" class="chosen-select" id="inputLocality" style="width:220px;" tabindex="4" name="inputLocality[]"><option value="">Select Location</option>';
				var dropdownvaledit = '<select data-placeholder="Choose a Locality" class="chosen-select" id="inputLocalityedit" style="width:200px;" tabindex="4" name="inputLocalityedit[]"><option value="">Select Location</option>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdownvaledit += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
				}
				dropdownval += '</select>';
				dropdownvaledit += '</select>';
				$("#localityValedit").html(dropdownvaledit);
				$("#localityVal").html(dropdownval);
				dropDownconfig();
				$('#inputLocality').chosen().change(function() {
					var values = $("#inputLocality").chosen().val();
					filter_GetProjectbaseLocation(values);
				});
				$('#inputLocalityedit').chosen().change(function() {
					var values = $("#inputLocalityedit").chosen().val();
					filter_GetProjectbaseLocation(values);
				});
			}
		}
	});
}

function AddLocality_select() {
	var cityIdsval = $("#inputCity").val();
	var cityIdsvaltxt = $("#inputCity option:selected").text();
	if (document.getElementById('cityIdsval').value == "") {
		document.getElementById('cityIdsval').value = cityIdsval;
	} else {
		document.getElementById('cityIdsval').value += "," + cityIdsval;
	}
	var divvalue = '<div class="col-lg-3 hrclass"><label for="city" class="control-label">City</label>';
	divvalue += '<div class="form-group" id="cityVal"><select data-placeholder="Choose a City" class="chosen-select" id="inputCity" style="width:220px;" tabindex="4" name="inputCity[]" >';
	divvalue += '</select>';
	divvalue += '</div>';
	divvalue += '</div>';
	tbl_row += "</tbody></table></div>";
	$('#justRefresh_txt').append(tbl_row);
	$("#justRefresh_txt").on('click', '.remCF', function() {
		$(this).parent().parent().remove();
	});
}

function AddLocality_selectEdit() {
	var cityIdsvaledit = $("#inputCityedit").val();
	var cityIdsvaledittxt = $("#inputCityedit option:selected").text();
	if (document.getElementById('cityIdsvaledit').value == "") {
		document.getElementById('cityIdsvaledit').value = cityIdsvaledit;
	} else {
		document.getElementById('cityIdsvaledit').value += "," + cityIdsvaledit;
	}
	divvalue += '<input type="button" style="float:right;margin-top:20px;" value="ADD" onclick="AddLocality_selectEdit();" name="addlocalityedit" id="addlocalityedit" class="btn btn-primary" />';
	$("#justRefreshedit").html(divvalue);
	getCompetencyCity();
	dropDownconfig();
	tbl_row += "</tbody></table></div>";
	$('#justRefreshedit_txt').append(tbl_row);
	$("#justRefreshedit_txt").on('click', '.remCF', function() {
		$(this).parent().parent().remove();
	});
}

function filter_GetProjectbaseLocation(elem) {
	$.ajax({
		url: configAjax.jsRoutes[34].GetProjectbaseLocation + '?localityId=' + elem,
		type: "get",
		dataType: "json",
		//data:{getLocality:elem},
		success: function(resp) {
			if (resp.length >= 1) {
				var dropdownval = '<select data-placeholder="Choose a Project" class="chosen-select" id="inputProject" style="width:220px;" multiple tabindex="4" name="inputProject[]"><option value="">Select Project</option>';
				var dropdownvaledit = '<select data-placeholder="Choose a Project" class="chosen-select" style="width:150px;" tabindex="4" name="inputProjectedit[]" id="inputProjectedit" multiple><option value="">Select Project</option>';
				for (var i = 0; i < resp.length; i++) {
					dropdownval += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
					dropdownvaledit += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>'
				}
				dropdownval += '</select>';
				dropdownvaledit += '</select>';
				$("#proVal").html(dropdownval);
				$("#proValedit").html(dropdownvaledit);
				dropDownconfig();
			}
		}
	});
}

function createCompetency() {
	var channel = "";
	var channel_val = $('input:checkbox:checked.channel').map(function() {
		return this.value;
	}).get();
	if (channel_val.length >= 1) {
		channel = channel_val.join(",");
	}
	var role = "";
	var role_val = $('input:checkbox:checked.role').map(function() {
		return this.value;
	}).get();
	if (role_val.length >= 1) {
		role = role_val.join(",");
	}
	var gender = "";
	var gender_val = $('input:checkbox:checked.gender').map(function() {
		return this.value;
	}).get();
	if (gender_val.length >= 1) {
		gender = gender_val.join(",");
	}
	var followups = "";
	var followup_count = $('input:checkbox:checked.followups').map(function() {
		return this.value;
	}).get();
	if (followup_count.length >= 1) {
		followups = followup_count.join(",");
	}
	var source = "";
	var source_val = $('input:checkbox:checked.source').map(function() {
		return this.value;
	}).get();
	if (source_val.length >= 1) {
		source = source_val.join(",");
	}
	var profession = "";
	var profession_val = $('input:checkbox:checked.prof').map(function() {
		return this.value;
	}).get();
	if (profession_val.length >= 1) {
		profession = profession_val.join(",");
	}
	var propertyfor1 = "";
	var propfor1 = $('input:checkbox:checked.propfr1').map(function() {
		return this.value;
	}).get();
	if (propfor1.length >= 1) {
		propertyfor1 = propfor1.join(",");
	}
	var propertyfor2 = "";
	var propfor2 = $('input:checkbox:checked.propfr2').map(function() {
		return this.value;
	}).get();
	if (propfor2.length >= 1) {
		propertyfor2 = propfor2.join(",");
	}
	var category = "";
	var categoryval = $('input:checkbox:checked.propcategory').map(function() {
		return this.value;
	}).get();
	if (categoryval.length >= 1) {
		category = categoryval.join(",");
	}
	//agriprop commprop aptprop
	var propertyTypes = "";
	var proptypes = $('input:checkbox:checked.subcatptype').map(function() {
		return this.value;
	}).get();
	if (proptypes.length < 1) {
		alert("Please select Property Type");
		return false;
	} else {
		var propertyTypes = proptypes.join(",");
	}
	var cons_phase = "";
	var cons_val = $('input:checkbox:checked.consph').map(function() {
		return this.value;
	}).get();
	if (cons_val.length >= 1) {
		cons_phase = cons_val.join(",");
	}
	var price_min = "";
	var price_max = "";
	$('#budget_range').find('input:checkbox:checked.price_range').each(function() {
		var price_array = $(this).val();
		if (price_array != '') {
			var price1 = price_array.split('-');
			if (price_min == "") {
				price_min = price1[0];
			} else {
				price_min += "," + price1[0];
			}
			if (price_max == "") {
				price_max = price1[1];
			} else {
				price_max += "," + price1[1];
			}
		}
	});
	var area_min = "";
	var area_max = "";
	$('#area_range').find('input:checkbox:checked.area').each(function() {
		var area_array = $(this).val();
		if (area_array != '') {
			var area1 = area_array.split('-');
			if (area_min == "") {
				area_min = area1[0];
			} else {
				area_min += "," + area1[0];
			}
			if (area_max == "") {
				area_max = area1[1];
			} else {
				area_max += "," + area1[1];
			}
		}
	});
	var bhk = "";
	var bhk_val = $('input:checkbox:checked.bhkbuttons').map(function() {
		return this.value;
	}).get();
	if (bhk_val.length >= 1) {
		bhk = bhk_val.join(",");
	}
	var loan_req = "";
	var loan_val = $('input:checkbox:checked.loan_req').map(function() {
		return this.value;
	}).get();
	if (loan_val.length >= 1) {
		loan_req = loan_val.join(",");
	}
	var purpose = "";
	var purpose_val = $('input:checkbox:checked.purpose').map(function() {
		return this.value;
	}).get();
	if (purpose_val.length >= 1) {
		purpose = purpose_val.join(",");
	}
	var urgency = "";
	var urgency_val = $('input:checkbox:checked.urgency').map(function() {
		return this.value;
	}).get();
	if (urgency_val.length >= 1) {
		urgency = urgency_val.join(",");
	}
	var user = $("#inputUser").val();
	var user_val = user.split("-");
	var userid = user_val[0];
	var username = user_val[1];
	var stateIdsarr = $("#inputState").val();
	if (stateIdsarr != null) {
		var stateIds = stateIdsarr.toString();
	} else {
		var stateIds = "";
	}
	var cityIds = [];
	cityIdsarr = $("#inputCity").val();
	if (cityIdsarr != null) {
		var cityIds = cityIdsarr.toString();
	} else {
		var cityIds = "";
	}
    if (cityIds == "") {
		alert("Please select City");
		return false;
	}
	var _token = $("#_tokencomp").val();
	var postData = {
		_token: _token,
		channel: channel,
		userid: userid,
		username: username,
		role: role,
		gender: gender,
		followups: followups,
		source: source,
		profession: profession,
		propertyfor1: propertyfor1,
		propertyfor2: propertyfor2,
		stateIds: stateIds,
		cityIds: cityIds,
		category: category,
		propertyTypes: propertyTypes,
		cons_phase: cons_phase,
		price_min: price_min,
		price_max: price_max,
		area_min: area_min,
		area_max: area_max,
		bhk: bhk,
		loan_req: loan_req,
		purpose: purpose,
		urgency: urgency
	};
	//console.log(postData);
	$.ajax({
		url: configAjax.jsRoutes[8].createCompetency,
		type: "post",
		data: postData,
		dataType: "json",
		success: function(resp) {
			if (resp.status == "success") {
				alert("Added Successfully");
				location.reload();
			} else {
				alert("Failed to Add");
			}
		}
	});
}

function addEditCompetency(elem) {
	if (elem == 1) {
		$.ajax({
			url: configAjax.jsRoutes[11].NewCompetency,
			type: "get",
			dataType: "json",
			success: function(resp) {
				if (resp.length >= 1) {
					var uservalues = "";
					uservalues += '<select class="form-control" style="width:40%;" name="inputUser" id="inputUser">';
					for (var i = 0; i < resp.length; i++) {
						if (resp[i].level == 0) {
							var levelval = "Superuser";
						} else if (resp[i].level == 1) {
							var levelval = "Manager";
						} else if (resp[i].level == 2) {
							var levelval = "Team Leader";
						} else {
							var levelval = "Telecaller";
						}
						var levelname = resp[i].level
						uservalues += '<option value="' + resp[i].id + "-" + resp[i].name + '">' + resp[i].name + '-(' + resp[i].email + ' - ' + levelval + ')</option>'
					}
					uservalues += '</select>';
					$("#newuserComp").html(uservalues);
					$("#competencyForm").css('display', 'block');
					$("#existNewcomp").css('display', 'block');
					$("#competencyprofilev").css('display', 'none');
				} else {
					$("#competencyForm").css('display', 'none');
				}
			}
		});
	} else {
		$.ajax({
			url: configAjax.jsRoutes[10].ExistCompetency,
			type: "get",
			dataType: "json",
			success: function(resp) {
				if (resp.length >= 1) {
					var uservalues = "";
					uservalues += '<select class="form-control" style="width:40%;" name="inputUser" onchange="showCompetencyprofile(this.value);" id="inputUser">';
					uservalues += '<option value="">Select</option>';
					for (var i = 0; i < resp.length; i++) {
						if (resp[i].level == 0) {
							var levelval = "Superuser";
						} else if (resp[i].level == 1) {
							var levelval = "Manager";
						} else if (resp[i].level == 2) {
							var levelval = "Team Leader";
						} else {
							var levelval = "Telecaller";
						}
						var levelname = resp[i].level
						uservalues += '<option value="' + resp[i].id + '">' + resp[i].name + '-(' + resp[i].email + ' - ' + levelval + ')</option>'
					}
					uservalues += '</select>';
					$("#newuserComp").html(uservalues);
					$("#existNewcomp").css('display', 'none');
					$("#competencyForm").css('display', 'block');
				} else {
					$("#existNewcomp").css('display', 'block');
					$("#competencyForm").css('display', 'none');
				}
			}
		});
	}
}
/*window.setInterval(function() {
	getDashboardCounts();
	getCurrentStatus();
}, 60000);
*/
function getDashboardCounts() {
	//pendingcalls assignededcalls completedcalls noofenq
	$.ajax({
		url: configAjax.jsRoutes[24].DashboardCounts,
		type: "get",
		dataType: "json",
		success: function(resp) {
			$("#noofenq").html(resp.noofenqs);
			$("#completedcalls").html(resp.completedcalls);
			$("#assignededcalls").html(resp.assignedcalls);
			$("#pendingcalls").html(resp.pendingcalls);
		}
	});
}

function showfilterEnq() {
	$('.showenqdetails').css('display', 'block');
}

function showNoofEnq() {
	var cityname = $("#citysearch").val();
	$.ajax({
		url: configAjax.jsRoutes[30].CountsNotification,
		type: "get",
		dataType: "json",
		data: $("#showEnqdetailFrom").serialize(),
		success: function(resp) {
			var fromdate = $("#fromdatesearch").val();
			var todate = $("#todatesearch").val();
			if (fromdate == '' || todate == '') {
				var textshow = "Todays Records";
			} else {
				var textshow = "From : " + fromdate + " -  To : " + todate;
			}
			var detailsEnq = "";
			detailsEnq += '<table id="detaildashboardtable"  style="font-size:12px;" class="table table-bordered text-center countsDashboard" cellspacing="0" width="100%">';
			detailsEnq += '<thead><tr style="background:#6F6F6F;color:#fff;"><td colspan="4">' + textshow + '</td></tr>';
			detailsEnq += '<tr style="background:#6F6F6F;color:#fff;"><th>City Name</th><th>Count</th><th>Source & Count</th><th>Primary Intent & Count</th></tr></thead><tbody>';
			if (resp.details.length >= 1) {
				for (var i = 0; i < resp.details.length; i++) {
					detailsEnq += '<tr><td>' + resp.details[i].city_details.cityname + '</td>';
					detailsEnq += '<td>' + resp.details[i].city_details.city_count + '</td>';
					detailsEnq += '<td>';
					detailsEnq += '<table class="table table-bordered text-center" cellspacing="0" width="100%">';
					detailsEnq += '<thead><tr style="background:#BCBCBC;color:#fff;"><th>Source</th><th>Source Count</th></tr></thead><tbody>';
					var source_countnew = 0;
					for (var j = 0; j < resp.details[i].city_details.source.length; j++) {
						detailsEnq += '<tr><td>' + resp.details[i].city_details.source[j].sourcename + '</td>';
						detailsEnq += '<td>' + resp.details[i].city_details.source[j].source_count + '</td></tr>';
						source_countnew += parseInt(resp.details[i].city_details.source[j].source_count);
					}
					detailsEnq += '<tr><td style="font-weight:bold;">Total</td><td>' + source_countnew + '</td></tr>';
					detailsEnq += '</tbody></table>';
					detailsEnq += '</td>';
					detailsEnq += '<td>';
					detailsEnq += '<table class="table table-bordered text-center" cellspacing="0" width="100%">';
					detailsEnq += '<thead><tr style="background:#BCBCBC;color:#fff;"><th>Primary Intent</th><th> Count</th></tr></thead><tbody>';
					var pi_countnew = 0;
					for (var k = 0; k < resp.details[i].city_details.primaryintent.length; k++) {
						detailsEnq += '<tr><td>' + resp.details[i].city_details.primaryintent[k].primaryintent + '</td>';
						detailsEnq += '<td>' + resp.details[i].city_details.primaryintent[k].pi_count + '</td></tr>';
						pi_countnew += parseInt(resp.details[i].city_details.primaryintent[k].pi_count);
					}
					detailsEnq += '<tr><td style="font-weight:bold;">Total</td><td>' + pi_countnew + '</td></tr>';
					detailsEnq += '</tbody></table>';
					detailsEnq += '</td>';
					detailsEnq += '</tr>';
				}
			} else {
				detailsEnq += '<tr>No records Found</tr>';
			}
			detailsEnq += '</table>';
			$("#customNotification").html(detailsEnq);
			$('.showenqdetails').css('display', 'block');
			$('.viewdetails').css('display', 'block');
		}
	});
}

function getcustomViewdetails() {
	var cityname = $("#citysearch").val();
	if (cityname == '') {
		$("#cityidsearch").val('');
	}
	$.ajax({
		url: configAjax.jsRoutes[32].CountsNotificationDetails,
		type: "get",
		dataType: "json",
		data: $("#showEnqdetailFrom").serialize(),
		success: function(resp) {
			var detailsEnq = '';
			detailsEnq += '<table style="font-size:10px;border:1px solid #bcbcbc;" class="table table-bordered viewcountsDetails" cellspacing="0" width="100%">';
			detailsEnq += '<thead>';
			detailsEnq += '<tr style="background:#6F6F6F;color:#fff;"><th>Req_id</th><th>City</th><th>Phone Number</th><th>Source</th><th style="background:#F5B142;">Latest Dispostion</th><th style="background:#F5B142;">Date & Time of Latest Disposition</th><th>Date & Time Added</th></tr></thead>';
			if (resp.length >= 1) {
				detailsEnq += '<tbody>';
				for (var i = 0; i < resp.length; i++) {
					detailsEnq += '<tr><td>' + resp[i].req_id + '</td><td>' + resp[i].city + '</td><td>' + resp[i].phone_no + '</td><td>' + resp[i].source_1 + '</td><td>' + resp[i].status + '</td><td>' + resp[i].updated_time + '</td><td>' + resp[i].inserted_time + '</td></tr>';
				}
				detailsEnq += '</tbody>';
			}
			$("#customViewDetails").html(detailsEnq);
			$('#customViewDetails').css('display', 'block');
			$('#customViewDetailsdownload').css('display', 'block');
		}
	});
}

function showCompetencyprofilePopup(elem) {
	$.ajax({
		url: configAjax.jsRoutes[18].Viewcompetency,
		type: "get",
		dataType: "json",
		data: {
			id: elem
		},
		success: function(resp) {
			if (resp.length >= 1) {
				for (var i = 0; i < resp.length; i++) {
					var profileexist = '<table id="example4" style="font-size:12px;" class="table table-bordered" cellspacing="0" width="100%">';
					profileexist += '<tbody><tr><td>Name </td><td>' + resp[i].agent_name + '</td></tr>';
					profileexist += '<tr><td>Source </td><td>' + resp[i].source_1 + '</td></tr>';
					profileexist += '<tr><td>City</td><td>' + resp[i].city_name + '</td></tr>';
					profileexist += '<tr><td>Primary Intent</td><td>' + resp[i].property_for_1 + ' ' + resp[i].property_for_2 + '</td></tr>';
					profileexist += '<tr><td>Secondary Intent</td><td>' + resp[i].category + ' - ' + resp[i].property_types + '</td></tr></tbody>';
					profileexist += '</table>';
				}
			} else {
				var profileexist = "";
			}
			$("#competency_prof").html(profileexist);
			$("#myCompetencyModel").modal('show');
		}
	});
}

function showVLProjectPopup(req_id) {
	$.ajax({
		url: configAjax.jsRoutes[27].ViewVLProjects,
		type: "get",
		dataType: "json",
		data: {
			id: req_id
		},
		success: function(resp) {
			if (resp.length >= 1) {
				for (var i = 0; i < resp.length; i++) {
					var projectexist = '<table id="example5" style="font-size:12px;" class="table table-bordered" cellspacing="0" width="100%">';
					projectexist += '<tbody><th><td>Project Name </td><td>Builder Name </td></th>';
					projectexist += '<tr><td>' + resp[i].project + '</td></tr>';
					projectexist += '<tr><td>City</td><td>' + resp[i].builder + '</td></tr>';
					projectexist += '</table>';
				}
			} else {
				var projectexist = "";
			}
			$("#vl_projects").html(profileexist);
			$("#VlProjectModel").modal('show');
		}
	});
}

function getCurrentStatus() {
	$.ajax({
		url: configAjax.jsRoutes[28].CurrentStatus,
		type: "get",
		dataType: "json",
		success: function(resp) {
			var tbl_row = '<div class="col-sm-12" id="currentStatus">';
			tbl_row += '<table id="currentstatTable" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">';
			tbl_row += '<thead><tr style="background:#FFFFCC;color:#6D6D6D;font-size:13px;text-align:center;">';
			tbl_row += '<th colspan="9" style="border-top:1px solid red;border-bottom:1px solid red;"><label class="tophtable">Loggedin: ' + resp.loggedin + '</label>';
			tbl_row += '<label class="tophtable">Ringing: ' + resp.ringing + '</label>';
			tbl_row += '<label class="tophtable">Dailing: ' + resp.dialing + '</label>';
			tbl_row += '<label class="tophtable">Incall: ' + resp.incall + '</label>';
			tbl_row += '<label class="tophtable">Not Ready: ' + resp.notready + '</label>';
			tbl_row += '<label class="tophtable">Logged in-Idle: ' + resp.free + '</label>';
			tbl_row += '<label class="tophtable">Logged Out: ' + resp.loggedout + '</label></th></tr>';
			tbl_row += '<tr style="background:#6F6F6F;color:#fff;"><th>Agent ID</th><th>Agent Name</th><th>Team Leader</th><th>Agent Mode</th><th>Login Time</th><th>Extension</th><th>Free Time</th><th>Call State</th><th>Action</th></tr></thead>';
			tbl_row += '<tbody id="app_table_body">';
			if (typeof resp.data != 'undefined') {
				if (resp.data.length >= 1) {
					for (var i = 0; i < resp.data.length; i++) {
						tbl_row += "<tr>";
						tbl_row += "<td>" + resp.data[i].agent_id + "</td>";
						tbl_row += "<td>" + resp.data[i].agent_name + "</td>";
						tbl_row += "<td>" + resp.data[i].teamleader + "</td>";
						tbl_row += "<td class='text-success'>" + resp.data[i].curent_mode + "</td>";
						tbl_row += "<td>" + resp.data[i].login_time + "</td>";
						tbl_row += "<td>" + resp.data[i].sip_number + "</td>";
						if (resp.data[i].call_status == '1') {
							if (resp.data[i].incall == '1') {
								tbl_row += "<td>00:00:00</td>";
								tbl_row += "<td class='incall'>INCALL</td>";
								tbl_row += "<td></td>";
							} else if (resp.data[i].incall == '2') {
								tbl_row += "<td>00:00:00</td>";
								tbl_row += "<td class='dialing'>DIALING</td>";
								tbl_row += "<td></td>";
							} else if (resp.data[i].incall == '3') {
								tbl_row += "<td>00:00:00</td>";
								tbl_row += "<td class='ringing'>RINGING</td>";
								tbl_row += "<td></td>";
							} else {
								tbl_row += "<td>" + resp.data[i].free_time + "</td>";
								tbl_row += "<td class='free'>Logged in-Idle</td>";
								tbl_row += "<td><button class='btn btn-primary' type='button' onclick='forcetoLogout(" + resp.data[i].agent_id + ");' id='forcelogoutUser'>Logout</button></td>";
							}
						} else if (resp.data[i].call_status == "") {
							tbl_row += "<td>00:00:00</td>";
							tbl_row += "<td class='loggedout'>LOGGED OUT</td>";
							tbl_row += "<td></td>";
						} else {
							if (resp.data[i].pick_call_status == 'yes') {
								tbl_row += "<td>" + resp.data[i].free_time + "</td>";
								tbl_row += "<td class='free'>Logged in-Idle</td>";
								tbl_row += "<td><button class='btn btn-primary' type='button' onclick='forcetoLogout(" + resp.data[i].agent_id + ");' id='forcelogoutUser'>Logout</button></td>";
							} else {
								tbl_row += "<td>" + resp.data[i].free_time + "</td>";
								tbl_row += "<td class='closure'>NOT READY</td>";
								tbl_row += "<td><button class='btn btn-primary' type='button' onclick='forcetoLogout(" + resp.data[i].agent_id + ");' id='forcelogoutUser'>Logout</button></td>";
							}
						}
						tbl_row += "</tr>";
					}
					tbl_row += "</tbody></table></div>";
					$('#currentStatusTelecallers').html(tbl_row);
					$('#currentstatTable').DataTable({
						"paging": false
					});
				} else {
					tbl_row += "";
					$('#currentStatusTelecallers').html(tbl_row);
					$('#currentstatTable').DataTable({
						"paging": false
					});
				}
			} else {
				tbl_row += "";
				$('#currentStatusTelecallers').html(tbl_row);
				$('#currentstatTable').DataTable({
					"paging": false
				});
			}
		}
	});
}

function forcetoLogout(userid) {
	var token = $("#_token").val();
	$.ajax({
		url: configAjax.jsRoutes[38].ForceToLogout,
		type: "get",
		dataType: "json",
		data: {
			id: userid
		},
		success: function(resp) {
			if (resp.status == 'success') {
				alert("Successfully Logout");
				location.reload();
			}
		}
	});
}

function showCompetencyprofile(elem) {
	$.ajax({
		url: configAjax.jsRoutes[18].Viewcompetency,
		type: "get",
		dataType: "json",
		data: {
			id: elem
		},
		success: function(resp) {
			if (resp.length >= 1) {
				for (var i = 0; i < resp.length; i++) {
					var profileexist = '<table id="example4" style="font-size:12px;" class="table table-bordered" cellspacing="0" width="100%"><tbody>';
					profileexist += '<tr><td>Name </td><td>' + resp[i].agent_name + '</td></tr>';
					profileexist += '<tr><td>Source </td><td><input id="source" type="hidden" value="' + resp[i].source_1 + '" />' + resp[i].source_1 + '</td></tr>';
					profileexist += '<tr><td>City</td><td id="cityval"><input id="city_name" type="hidden" value="' + resp[i].cityid + '" />' + resp[i].city_name + '</td></tr>';
					//profileexist+='<tr><td>Locality</td><td id="locval"><input id="loc_name" type="hidden" value="'+resp[i].locid+'" />'+resp[i].loc_name+'</td></tr>';
					//profileexist+='<tr><td>Projects</td><td id="proval"><input id="project_name" type="hidden" value="'+resp[i].proid+'" />'+resp[i].project_name+'</td></tr>';
					profileexist += '<tr><td>Primary Intent</td><td><input id="PI1" type="hidden" value="' + resp[i].property_for_1 + '" /><input id="PI2" type="hidden" value="' + resp[i].property_for_2 + '" />' + resp[i].property_for_1 + ' ' + resp[i].property_for_2 + '</td></tr>';
					profileexist += '<tr><td>Secondary Intent</td><td><input id="SI1" type="hidden" value="' + resp[i].category + '" /><input id="SI2" type="hidden" value="' + resp[i].property_types + '" />' + resp[i].category + ' - ' + resp[i].property_types + '</td><input type="hidden" value=' + resp[i].agent_id + ' id="edit_agent_id" /></tr>';
					profileexist += '</tbody></table>';
					profileexist += '<input type="button" value="Edit" onclick="editCompetency();" class="btn btn-primary" data-toggle="modal" data-target="#editCompetencyModal" />';
				}
			} else {
				var profileexist = "";
			}
			$("#competencyprofilev").html(profileexist);
			$("#competencyprofilev").css('display', 'block');
		}
	});
}

function editUpdateCompetency() {
	id = $('#edit_agent_id').val();
	var source = "";
	var source_val = $('input:checkbox:checked.source_edit').map(function() {
		return this.value;
	}).get();
	if (source_val.length >= 1) {
		source = source_val.join(",");
	}
	var propertyfor1 = "";
	var propfor1 = $('input:checkbox:checked.propfor1').map(function() {
		return this.value;
	}).get();
	if (propfor1.length >= 1) {
		propertyfor1 = propfor1.join(",");
	}
	var propertyfor2 = "";
	var propfor2 = $('input:checkbox:checked.propfor2').map(function() {
		return this.value;
	}).get();
	if (propfor2.length >= 1) {
		propertyfor2 = propfor2.join(",");
	}
	var category = "";
	var categoryval = $('input:checkbox:checked.propcategoryedit').map(function() {
		return this.value;
	}).get();
	if (categoryval.length >= 1) {
		category = categoryval.join(",");
	}
	var propertyTypes = "";
	var proptypes = $('input:checkbox:checked.sub_catptype').map(function() {
		return this.value;
	}).get();
	if (proptypes.length < 1) {
		alert("Please select Property Type");
		return false;
	} else {
		var propertyTypes = proptypes.join(",");
	}
	var cityIds = [];
	cityIdsarr = $("#inputCityedit").val();
	if (cityIdsarr != null) {
		var cityIds = cityIdsarr.toString();
	} else {
		var cityIds = "";
	}
	if (cityIds == "") {
		alert("Please select City");
		return false;
	}
	var _token = $("#_tokencompedit").val();
	var postEdit = {
		_token: _token,
		agent_id: id,
		source: source,
		propertyfor1: propertyfor1,
		propertyfor2: propertyfor2,
		cityIds: cityIds,
		category: category,
		propertyTypes: propertyTypes
	};
	$.ajax({
		url: configAjax.jsRoutes[29].updateCompetency,
		type: "post",
		data: postEdit,
		dataType: "json",
		success: function(resp) {
			if (resp.status == "success") {
				alert("Added Successfully");
				location.reload();
			} else {
				alert("Failed to Add");
			}
		}
	});
}
google.charts.load('current', {
	packages: ["orgchart"]
});
//google.charts.setOnLoadCallback(drawChart);

function showOrgChart(id, level) {
	$.ajax({
		url: configAjax.jsRoutes[25].Orgchart,
		type: "get",
		dataType: "json",
		data: {
			id: id,
			level: level
		},
		success: function(resp) {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Value');
			data.addColumn('string', 'Name');
			data.addColumn('string', 'ToolTip');
			var rows = [];
			for (var i = 0; i < resp.length; i++) {
				rows.push([{
					v: resp[i].id,
					f: resp[i].name + '<div style="color:green; font-style:italic">(' + resp[i].position + ')</div>'
				},
				resp[i].reportingto, resp[i].name]);
			}
			data.addRows(rows);
			var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
			chart.draw(data, {
				allowHtml: true
			});
			$("#myOrgModel").modal('show');
		}
	});
}

function dropDownconfig() {
	var config = {
		'.chosen-select': {},
		'.chosen-select': {
			max_selected_options: 1
		},
		'.chosen-select-deselect': {
			allow_single_deselect: true
		},
		'.chosen-select-no-single': {
			disable_search_threshold: 10
		},
		'.chosen-select-no-results': {
			no_results_text: 'Oops, nothing found!'
		},
		'.chosen-select-width': {
			width: "95%"
		}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
}

function downLoadTable(classNameval) {
	$("." + classNameval).table2excel({
		exclude: ".noExl",
		name: "unsold-excel",
		filename: classNameval
	});
}
$("#citysearch").autocomplete({
	source: function(request, response) {
		$.ajax({
			url: configAjax.jsRoutes[31].CitySearch + "?cityidsearch=" + request.term,
			dataType: "json",
			success: function(data) {
				response($.map(data, function(value, key) {
					return {
						label: value,
						value: value,
						key: key
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#cityidsearch').val(ui.item.key);
	}
});