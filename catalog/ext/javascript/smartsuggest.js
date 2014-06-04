var selectedRowIndex = -1;
var inputedText = "";

var timeout;
var delay = 500;

//Gets the browser specific XmlHttpRequest Object
function getXmlHttpRequestObject() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		alert("Your Browser Sucks!\nIt's about time to upgrade don't you think?");
	}
}

//Our XmlHttpRequest object to get the auto suggest
var searchReq = getXmlHttpRequestObject();

//Called from keyup on the search textbox.
//Starts the AJAX request.
function searchSuggest(e) {
	e = (!e) ? window.event : e;
	//Get the event's target
	var target = (!e.target) ? e.srcElement : e.target;
	if (target.nodeType == 3)
		target = target.parentNode;
	//Get the character code of the pressed button
	var code = (e.charCode) ? e.charCode :
	       ((e.keyCode) ? e.keyCode :
	       ((e.which) ? e.which : 0));

	//Simply ignore non-interesting characters
	if ((code < 13 && code != 8) || 
    (code >=14 && code < 32 && code != 27) || 
    (code >= 33 && code <= 46 && code != 38 && code != 40) || 
    (code >= 112 && code <= 123)) {
	//If Esc pressed
	} else if (code == 27) {
		document.getElementById('txtSearch').value = inputedText;
		var ss = document.getElementById('smartsuggest');
		ss.innerHTML = '';
	//If the down arrow is pressed we go to the next suggestion
	} else if (code == 40){
		deselectAll();
		var rowUnselected = document.getElementsByClassName('suggest_link');
		if (selectedRowIndex >= rowUnselected.length - 1) selectedRowIndex = -1;
		if (rowUnselected.length) selectedRow = suggestOver(rowUnselected[++selectedRowIndex]);
		document.getElementById('txtSearch').value = selectedRow.textContent != undefined ? selectedRow.textContent : selectedRow.innerText;
	//If the up arrow is pressed we go to the previous suggestion
	} else if (code == 38){
		deselectAll();
		var rowUnselected = document.getElementsByClassName('suggest_link');
		if (selectedRowIndex <= 0) selectedRowIndex = rowUnselected.length;
		if (rowUnselected.length) selectedRow = suggestOver(rowUnselected[--selectedRowIndex]);
		document.getElementById('txtSearch').value = selectedRow.textContent != undefined ? selectedRow.textContent : selectedRow.innerText;		
	} else {
		if (timeout) clearTimeout(timeout);
		
		//Wait if previously loading
		if (searchReq.readyState != 4 && searchReq.readyState != 0) {
			sleep(delay);
		}

		var str = escape(document.getElementById('txtSearch').value);

		//Skip for one character
		if (str.length > 1) {

			timeout = setTimeout(function() {
				searchReq.open("GET", 'smartsuggest.php?keywords=' + str, true);
				searchReq.onreadystatechange = handleSearchSuggest; 
				searchReq.send(null);
		
				selectedRowIndex = -1;
				inputedText = str;
			}, delay);
				
		}
	}
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

//Called when the AJAX response is returned.
function handleSearchSuggest() {
	if (searchReq.readyState == 4) {
		var ss = document.getElementById('smartsuggest');

		ss.innerHTML = '';
		
		var str = searchReq.responseText.split("\n");
		
		for(i=0; i < str.length - 1; i++) {
			//Build our element string.  This is cleaner using the DOM, but
			//IE doesn't support dynamically added attributes.
		
			var suggest = '<div tabindex="i" onmouseover="javascript:suggestOver(this);" ';
			suggest += 'onmouseout="javascript:suggestOut(this);" ';
			suggest += 'onclick="javascript:setSearch(this.innerHTML);" ';
			suggest += 'class="suggest_link"">' + str[i] + '</div>';
			ss.innerHTML += suggest;
		}
	}
}

//Mouse over function
function suggestOver(div_value) {
	deselectAll();
	div_value.className = 'suggest_link_over';
	return div_value;
}

//Mouse out function
function suggestOut(div_value) {
	div_value.className = 'suggest_link';
}

//Deselect all row
function deselectAll() {
	var rowSelected = document.getElementsByClassName('suggest_link_over');
	if (rowSelected.length) rowSelected[0].className = 'suggest_link';
}

//Click function
function setSearch(value) {
	document.getElementById('smartsuggest').innerHTML = '';
	document.getElementById('txtSearch').value = stripHTML(value);
	document.getElementById('frmSearch').submit();
}

function stripHTML(str){ 
    return str.replace(/<[^>]*>/g, "");
}