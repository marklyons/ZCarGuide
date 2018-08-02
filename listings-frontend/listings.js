$(document).ready(function() {
	$(".selected-filter-btn").mouseenter(function() {
		$(this).find("img").attr("src", "/wp-content/uploads/filter-x-hover.png");
	});

	$(".selected-filter-btn").mouseleave(function() {
		$(this).find("img").attr("src", "/wp-content/uploads/filter-x.png");
	});

	$(".selected-filter-btn").click(function() {
		var btnId = $(this).attr("id");
		var baseURL = window.location.href;
		var newUrl;

		if(btnId == "selectedPriceBtn") {
			var intermediateUrl = removeURLParameter(baseURL, "highPrice");
			newUrl = removeURLParameter(intermediateUrl, "lowPrice");
		} else if (btnId == "selectedColorBtn") {
			newUrl = removeURLParameter(baseURL, "color");
		} else if (btnId == "selectedLocationBtn") {
			var intermediateUrl = removeURLParameter(baseURL, "zipCode");
			newUrl = removeURLParameter(intermediateUrl, "searchRadius");
		} else if (btnId == "selectedListingSitesBtn") {
			newUrl = removeURLParameter(baseURL, "listingSites");
		} else if (btnId == "selectedTransmissionBtn") {
			newUrl = removeURLParameter(baseURL, "transmission");
		} else if (btnId == "selectedMileageBtn") {
			var intermediateUrl = removeURLParameter(baseURL, "lowMileage");
			newUrl = removeURLParameter(intermediateUrl, "highMileage");
		} else if (btnId == "selectedConditionBtn") {
			newUrl = removeURLParameter(baseURL, "condition");
		} 

		newUrl = updateQueryStringParameter(newUrl, "pagenum", "1");
		window.location.href = newUrl;
	});

	// Get the modal
	var priceModal = $('#priceModal');
	var colorModal = $('#colorModal');
	var locationModal = $('#locationModal');
	var listingSiteModal = $("#listingSiteModal");
	var transmissionModal = $("#transmissionModal");
	var mileageModal = $("#mileageModal");
	var conditionModal = $("#conditionModal");


	// When the user clicks on the button, open the modal 
	$(".filter-btn").click(function() {
		var modal;
		var currBtn = $(this).attr("id");

		if(currBtn == "priceBtn") {
			modal = priceModal;
		} else if(currBtn == "colorBtn") {
			modal = colorModal;
		} else if(currBtn == "locationBtn") {
			modal = locationModal;
		} else if(currBtn == "listingSiteBtn") {
			modal = listingSiteModal;
		} else if(currBtn == "transmissionBtn") {
			modal = transmissionModal;
		} else if(currBtn == "mileageBtn") {
			modal = mileageModal;
		} else if(currBtn == "conditionBtn") {
			modal = conditionModal;
		} 

	    modal.show();

	    modal.find(".error-box").hide();
	    var errorList = modal.find(".error-box ul");
	    errorList.empty();
		$(".error-input").each(function() {
			$(this).removeClass("error-input");
		});
	});

	// When the user clicks on <span> (x), close the modal
	$("span.close").click(function() {
		$(this).parent().parent().hide();
	});


	$(".cancelFilterCls").click(function() {
		$(this).parent().parent().hide();
	});

	$(".applyFilterCls").click(function() {
		applyFilterClicked($(this));
	});


});

$(document).keypress(function(e) {
	if(e.which == 13) {
		$(".modal").each(function() {
			if($(this).is(":visible")) {
				$(this).find("#applyFilter").click();
			}
		});
	}
});

function applyFilterClicked(clickedBtn) {
	clickedBtn.parent().find(".error-box").hide();
	var filterModalType = clickedBtn.parent().parent().attr("id");

	var errorMsgs = [];
	var inputsToFlag = [];
	var errorList = clickedBtn.parent().find(".error-box ul");

	errorList.empty();
	$(".error-input").each(function() {
		$(this).removeClass("error-input");
	});


	if(filterModalType == "priceModal") {
		var lowPriceElem = $("#lowPriceFilter");
		var highPriceElem = $("#highPriceFilter");
		var lowPrice = lowPriceElem.val();
		var highPrice = highPriceElem.val();

		if(!lowPrice && !highPrice) {
			inputsToFlag.push(lowPriceElem);
			inputsToFlag.push(highPriceElem);
			errorMsgs.push("Must set either a low or high price boundary, or both.");
		} else {
			var numericValidLow = /^[0-9,]*$/.test(lowPrice);
			var numericValidHigh = /^[0-9,]*$/.test(highPrice);

			if(highPrice && !numericValidHigh) {
				inputsToFlag.push(highPriceElem);
				errorMsgs.push("High price needs to be a number (commas allowed).");
			}

			if(lowPrice && !numericValidLow) {
				inputsToFlag.push(lowPriceElem);
				errorMsgs.push("Low price needs to be a number (commas allowed).");
			}

			var intLow = parseFloat($("#lowPriceFilter").val().replace(/,/g, ''));
			var intHigh = parseFloat($("#highPriceFilter").val().replace(/,/g, ''));

			if(numericValidLow && numericValidHigh && (intLow > intHigh)) {
				inputsToFlag.push(lowPriceElem);
				inputsToFlag.push(highPriceElem);
				errorMsgs.push("High price must be greater than low price.")
			}
		}
	}

	if(filterModalType == "locationModal") {
		var zipElem = $("#zipFilter");
		var radiusElem = $("#radiusFilter");
		var selectedZIP = $("#zipFilter").val();
		var selectedRadius = $("#radiusFilter").val();

		if(!selectedZIP || !selectedRadius) {
			errorMsgs.push("You need to specify both a ZIP code and a search radius.");
			if(!selectedZIP) {
				inputsToFlag.push(zipElem);
			}

			if(!selectedRadius) {
				inputsToFlag.push(radiusElem);
			}
		} else {
			var radiusNumeric = /^[0-9,]*$/.test(selectedRadius);
			var zipRawNumbers = /^\d+$/.test(selectedZIP);

			if(!radiusNumeric) {
				inputsToFlag.push(radiusElem);
				errorMsgs.push("Search radius needs to be a number (commas allowed).")
			}

			if(!zipRawNumbers) {
				inputsToFlag.push(zipElem);
				errorMsgs.push("ZIP Code must be numbers only.");
			}

			if(selectedZIP.length != 5) {
				inputsToFlag.push(zipElem);
				errorMsgs.push("Only 5-digit ZIP codes allowed.");
			}


		}


	}

	if(filterModalType == "mileageModal") {
		var lowMileageElem = $("#lowMileageFilter");
		var highMileageElem = $("#highMileageFilter");
		var lowMileage = $("#lowMileageFilter").val();
		var highMileage = $("#highMileageFilter").val();

		if(!lowMileage && !highMileage) {
			inputsToFlag.push(lowMileageElem);
			inputsToFlag.push(highMileageElem);
			errorMsgs.push("Must set either a low or high mileage boundary, or both.");
		} else {
			var numericValidLow = /^[0-9,]*$/.test(lowMileage);
			var numericValidHigh = /^[0-9,]*$/.test(highMileage);

			if(highMileage.length > 0 && !numericValidHigh) {
				inputsToFlag.push(highMileageElem);
				errorMsgs.push("High mileage needs to be a number (commas allowed).");
			}

			if(lowMileage.length > 0 && !numericValidLow) {
				inputsToFlag.push(lowMileageElem);
				errorMsgs.push("Low mileage needs to be a number (commas allowed).");
			}

			var intLow = parseFloat($("#lowMileageFilter").val().replace(/,/g, ''));
			var intHigh = parseFloat($("#highMileageFilter").val().replace(/,/g, ''));

			if(numericValidLow && numericValidHigh && (intLow > intHigh)) {
				inputsToFlag.push(lowMileageElem);
				inputsToFlag.push(highMileageElem);
				errorMsgs.push("High mileage must be greater than low mileage.")
			}
		}
	}

	if(inputsToFlag.length > 0 || errorMsgs.length > 0) {
		for(i = 0; i < inputsToFlag.length; i++) {
			var currInput = inputsToFlag[i];
			currInput.addClass('error-input');
		}

		for(i = 0; i < errorMsgs.length; i++) {
			var currentErrorMsg = errorMsgs[i];
			errorList = clickedBtn.parent().find(".error-box ul");
			var addedListElem = errorList.append("<li>" + currentErrorMsg + "</li>");
		}

		clickedBtn.parent().find(".error-box").show();

	} else {
		var finalURL;

		var baseURL = window.location.href;
		var pagenumFixed = updateQueryStringParameter(baseURL, "pagenum", "1");

		if(filterModalType == "priceModal") {
			var lowPrice = parseFloat($("#lowPriceFilter").val().replace(/,/g, ''));
			var highPrice = parseFloat($("#highPriceFilter").val().replace(/,/g, ''));
			var currURL = pagenumFixed;

			if(highPrice) {
				currURL = updateQueryStringParameter(currURL, "highPrice", highPrice);
			}

			if(lowPrice) {
				currURL = updateQueryStringParameter(currURL, "lowPrice", lowPrice);
			}

			finalURL = currURL;
		} else if (filterModalType == "colorModal"){
			var selectedColor = $("#colorSelect").val();
			finalURL = updateQueryStringParameter(pagenumFixed, "color", selectedColor);
		} else if (filterModalType == "locationModal") {
			var selectedZIP = $("#zipFilter").val();
			var selectedRadius = parseFloat($("#radiusFilter").val().replace(/,/g, ''));

			var nUrl1 = updateQueryStringParameter(pagenumFixed, "zipCode", selectedZIP);
			finalURL = updateQueryStringParameter(nUrl1, "searchRadius", selectedRadius);
		} else if (filterModalType == "listingSiteModal") {
			listingSites = [];
			$('.listingSiteCB:checkbox:checked').each(function() {
				var currentSite = $(this).val();
				listingSites.push(currentSite);
			});

			var specifiedSites = listingSites.join("%2C");
			if(listingSites.length > 0) {
				finalURL = updateQueryStringParameter(pagenumFixed, "listingSites", specifiedSites);
			} else {
				finalURL = pagenumFixed;
			}
		} else if (filterModalType == "transmissionModal") {
			var selectedTrans = $('input[name=transmission]:checked').val();
			finalURL = updateQueryStringParameter(pagenumFixed, "transmission", selectedTrans);
		} else if (filterModalType == "mileageModal") {
			var lowMileage = parseFloat($("#lowMileageFilter").val().replace(/,/g, ''));
			var highMileage = parseFloat($("#highMileageFilter").val().replace(/,/g, ''));

			var currURL = pagenumFixed;
			if(highMileage) {
				currURL = updateQueryStringParameter(currURL, "highMileage", highMileage);
			}

			if(lowMileage) {
				currURL = updateQueryStringParameter(currURL, "lowMileage", lowMileage);
			}

			finalURL = currURL;
		} else if (filterModalType == "conditionModal") {
			acceptedConditions = [];

			$('.selCondition:checkbox:checked').each(function() {
				var currentCondition = $(this).val();
				acceptedConditions.push(currentCondition);
			});

			var conditions = acceptedConditions.join("%2C");

			if(acceptedConditions.length > 0) {
				finalURL = updateQueryStringParameter(pagenumFixed, "condition", conditions);
			} else {
				finalURL = pagenumFixed;
			}
		}


		window.location.href = finalURL;
	}
}

/* From StackOverflow: https://stackoverflow.com/questions/5999118/how-can-i-add-or-update-a-query-string-parameter */
function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

/* From StackOverflow: https://stackoverflow.com/questions/1634748/how-can-i-delete-a-query-string-parameter-in-javascript */
function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        url= urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}