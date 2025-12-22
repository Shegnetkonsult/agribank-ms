// JavaScript Document
function ShowPass1() {
var x = document.getElementById("password");
var y = document.getElementById("checker");
	if (y.checked) {
		x.type = "text";
	} 
	else {
		x.type = "password";
	}
}

function ShowPass() {
var w = document.getElementById("r_password");
var x = document.getElementById("password");
var y = document.getElementById("checker");
	if (y.checked) {
		w.type = "text";
		x.type = "text";
	} 
	else {
		w.type = "password";
		x.type = "password";
	}
}

function ShowSSCE() {
var w = document.getElementById("ssce2possess");
var x = document.getElementById("switch_no_of_sittings");
var y = document.getElementById("second_sitting");
var z = document.getElementById("checker");
	if (z.checked) {
		x.style = "visibility:hidden";
		y.style = "visibility:visible";
		w.value = "1";
	} 
	else {
		x.style = "visibility:visible";
		y.style = "visibility:hidden";
		w.value = "0";
	}
}

function submit_form(){
	var w = document.getElementById("ssce1");
	var x = document.getElementById("ssce2");
	var y = document.getElementById("one_sitting_checker");
	var z = document.getElementById("two_sitting_checker");
	if (z.checked) {
		w.value = "1";
		x.value = "1";
	} 
	else if (y.checked) {
		w.value = "1";
		x.value = "0";
	}	
	document.getElementById("frm_check_two_sittings").submit();
}

function show_depts(){
	document.getElementById("dept_request").submit();
}

$(function(){
	$("#dept_request").live(change, function () {
		("#dept_request").submit();
	$("#dept_request").blur();
	});
})