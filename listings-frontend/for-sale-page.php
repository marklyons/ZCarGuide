[php]
	parse_str($_SERVER['QUERY_STRING'], $next_query_string);
	parse_str($_SERVER['QUERY_STRING'], $prev_query_string);

	$selectedFilters = false;
	$color = NULL;
	$highPrice = NULL;
	$lowPrice = NULL;
	$zipCode = NULL;
	$searchRadius = NULL;
	$listingSites = NULL;
	$transmission = NULL;
	$highMileage = NULL;
	$lowMileage = NULL;
	$condition = NULL;

	$all_filters = array();

	if(isset($_GET["color"])) {
		$color = $_GET["color"];
		$selectedFilters = true;
		array_push($all_filters, 'color');
	}

	if(isset($_GET["highPrice"])) {
		$highPrice = $_GET["highPrice"];
		$selectedFilters = true;
	}

	if(isset($_GET["lowPrice"])) {
		$lowPrice = $_GET["lowPrice"];
		$selectedFilters = true;
	}

	if(isset($_GET["zipCode"])) {
		$zipCode = $_GET["zipCode"];
		$selectedFilters = true;
	}

	if(isset($_GET["searchRadius"])) {
		$searchRadius = $_GET["searchRadius"];
		$selectedFilters = true;
	}

	if(isset($_GET["listingSites"])) {
		$listingSites = $_GET["listingSites"];
		$selectedFilters = true;
		array_push($all_filters, 'listingSites');
	}

	if(isset($_GET["transmission"])) {
		$transmission = $_GET["transmission"];
		$selectedFilters = true;
		array_push($all_filters, 'transmission');
	}

	if(isset($_GET["highMileage"])) {
		$highMileage = $_GET["highMileage"];
		$selectedFilters = true;
	}

	if(isset($_GET["lowMileage"])) {
		$lowMileage = $_GET["lowMileage"];
		$selectedFilters = true;
	}

	if(isset($_GET["condition"])) {
		$condition = $_GET["condition"];
		$selectedFilters = true;
		array_push($all_filters, 'condition');
	}

	if(isset($_GET["zipCode"]) && isset($_GET["searchRadius"])) {
		array_push($all_filters, 'location');
	}

	if(isset($_GET["highPrice"]) || isset($_GET["lowPrice"])) {
		array_push($all_filters, 'price');
	}


	if(isset($_GET["highMileage"]) || isset($_GET["lowMileage"])) {
		array_push($all_filters, 'mileage');
	}




[/php]

<div id="priceModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Price Filter</h2>
    <p>Simply enter a price range using the two input boxes below to return only cars for sale which fall into that price range.</p>

    <label for="low-price">Low Price: </label>
    $ <input type="text" name="low-price" id="lowPriceFilter" placeholder="Low price, in USD">
    <br>
    <label for="high-price">High Price: </label>
    $ <input type="text" name="high-price" id="highPriceFilter" placeholder="High price, in USD">
    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<div id="colorModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Color Filter</h2>
    <p>Select the color you are interested in from the dropdown below.</p>

    <label for="color">Color: </label>
    <select id="colorSelect" name="color">
    	<option value="black">Black</option>
		<option value="blue">Blue</option>
		<option value="brown">Brown</option>
		<option value="green">Green</option>
		<option value="orange">Orange</option>
		<option value="purple">Purple</option>
		<option value="red">Red</option>
		<option value="silver">Silver</option>
		<option value="white">White</option>
		<option value="yellow">Yellow</option>
    </select>

    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<div id="locationModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Location Filter</h2>
    <p>Specify a search radius by entering a ZIP code and a mile limit and we will only return listings located within the search radius.</p>

    <label for="zip">ZIP Code: </label>
    <input type="text" name="zip" id="zipFilter" placeholder="5-digit ZIP code">
    <br>
    <label for="radius">Search Radius: </label>
    <input type="text" name="radius" id="radiusFilter" placeholder="Search radius in miles">

    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<div id="listingSiteModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Listing Site Filter</h2>
    <p>Select the listing site(s) you wish to search from using the checkboxes below, and we will only return listings from those sites.</p>

    <div class="checkbox-contain">
    	<input id="zcarguide" class="listingSiteCB" name="zcarguide" type="checkbox" value="zcarguide" />
		<label for="autotrader">ZCarGuide</label>
	</div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="autotrader" name="autotrader" value="autotrader" class="listingSiteCB">
	    <label for="autotrader">Autotrader Classics</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="craigslist" name="craigslist" value="craigslist" class="listingSiteCB">
	    <label for="craigslist">Craigslist</label>
    </div>

    <div class="checkbox-contain">
    	<input type="checkbox" id="zcartrader" name="zcartrader" value="zcartrader" class="listingSiteCB">
    	<label for="zcartrader">ZCarTrader</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="carsforsale" name="carsforsale" value="carsforsale" class="listingSiteCB">
	    <label for="carsforsale">CarsForSale.com</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="hemmings" name="hemmings" value="hemmings" class="listingSiteCB">
	    <label for="hemmings">Hemmings</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="ebay" name="ebay" value="ebay" class="listingSiteCB">
	    <label for="ebay">eBay Motors</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="bringatrailer" name="bringatrailer" value="bringatrailer" class="listingSiteCB">
	    <label for="bringatrailer">Bring a Trailer</label>
    </div>

    <div class="checkbox-contain">
    	<input type="checkbox" id="carscom" name="carscom" value="carscom" class="listingSiteCB">
    	<label for="carscom">Cars.com</label>
    </div>

    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<div id="transmissionModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Transmission Filter</h2>
    <p>Specify whether you are searching for a manual or automatic transmission, and we will only return vehicles with that type of transmission.</p>

    <div class="radio-contain">
	    <input type="radio" id="manualChoice" name="transmission" value="manual" checked="checked">
	    <label for="manualChoice">Manual</label>
    </div>

    <div class="radio-contain">
	    <input type="radio" id="autoChoice" name="transmission" value="automatic">
	    <label for="autoChoice">Automatic</label>
    </div>

    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<div id="mileageModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Mileage Filter</h2>
    <p>Simply enter a mileage range using the two input boxes below to return only cars for sale which fall into that mileage range.</p>

    <label for="low-mileage">Low Mileage: </label>
    <input type="text" name="low-mileage" id="lowMileageFilter" placeholder="Low mileage"> miles
    <br>
    <label for="high-mileage">High Mileage: </label>
    <input type="text" name="high-mileage" id="highMileageFilter" placeholder="High mileage"> miles
    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<div id="conditionModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Apply Condition Filter</h2>
    <p>We organize listings by our estimate of their condition, based on what we can tell from the listing.</p>

    <div class="checkbox-contain">
	    <input type="checkbox" id="concoursCondition" class="selCondition" name="concoursCondition" value="concoursCondition">
	    <label for="concoursCondition">Concours Condition</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="excellentCondition" class="selCondition" name="excellentCondition" value="excellentCondition">
	    <label for="excellentCondition">Excellent Condition</label>
    </div>

    <div class="checkbox-contain">
    	<input type="checkbox" id="goodCondition" class="selCondition" name="goodCondition" value="goodCondition">
    	<label for="goodCondition">Good Condition</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="poorCondition" class="selCondition" name="poorCondition" value="poorCondition">
	    <label for="poorCondition">Poor Condition</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="partsSalvageCondition" class="selCondition" name="partsSalvageCondition" value="partsSalvageCondition">
	    <label for="partsSalvageCondition">Parts Salvage Condition</label>
    </div>

    <div class="checkbox-contain">
	    <input type="checkbox" id="highlyModifiedCondition" class="selCondition" name="highlyModifiedCondition" value="highlyModifiedCondition">
	    <label for="highlyModifiedCondition">Highly Modified Condition</label>
    </div>

    <br><br>
    <input type="button" id="applyFilter" class="applyFilterCls" value="Apply Filter">
    <input type="button" id="cancelFilter" class="cancelFilterCls" value="Cancel">

    <div class="error-box">
    	<h2>Errors:</h2>
    	<ul></ul>
    </div>
  </div>

</div>

<p>
	ZCarGuide.com maintains the world's largest collection of Z-Car listings from across the entire internet. Below we have aggregated a large collection of listings by hand, manually recording every 280Z for sale we can find on the internet, so you don't have to. Please do not hesitate to <a href="http://zcarguide.com/contact-us/">contact us</a> if you have any questions or suggestions regarding this page.
</p>

<p>
	<strong>Want to list your 280Z for sale on ZCarGuide.com? Simply email us at <a href="mailto:zcarguide@gmail.com">zcarguide@gmail.com</a> with a brief description, some pictures, your location, and your asking price and we will list it here for you.</strong>
</p>
<br><br>

[php]
	$total_filters = array("price", "color", "location", "listingSites", "transmission", "mileage", "condition");
	$unapplied_filters = array_values(array_diff($total_filters, $all_filters));
[/php]

<div id="search-options-container">
	[php]
		if(count($unapplied_filters) > 0) {
	[/php]
		<h2>Add Search Filters</h2>
	[php]
			for ($i = 0; $i < count($unapplied_filters); $i++) {
				$curr_filt = $unapplied_filters[$i];

				if($curr_filt == "price"){
					$btn_id = "priceBtn";
					$btn_name = "Price";
				} else if($curr_filt == "color") {
					$btn_id = "colorBtn";
					$btn_name = "Color";
				} else if($curr_filt == "location") {
					$btn_id = "locationBtn";
					$btn_name = "Location";
				} else if($curr_filt == "listingSites") {
					$btn_id = "listingSiteBtn";
					$btn_name = "Listing Site";
				} else if($curr_filt == "transmission") {
					$btn_id = "transmissionBtn";
					$btn_name = "Transmission";
				} else if($curr_filt == "mileage") {
					$btn_id = "mileageBtn";
					$btn_name = "Mileage";
				} else if($curr_filt == "condition") {
					$btn_id = "conditionBtn";
					$btn_name = "Condition";
				}
	[/php]

					<button id="[php] echo $btn_id; [/php]" type="button" class="btn filter-btn">
						[php] echo $btn_name; [/php]
						<img src="/wp-content/uploads/filter-plus.png" class="filter-plus">
					</button>
	[php]
			}
		}
	[/php]
</div>


[php]

	if($selectedFilters) {

[/php]
	<h2>Selected Filters</h2>
	<div id="selected-filters-container">
		[php]

			for ($i = 0; $i < count($all_filters); $i++) {
				$currValue = $all_filters[$i];

				if($currValue == "price"){
					if(isset($_GET["highPrice"]) && !isset($_GET["lowPrice"])) {
						$label = "Price: up to $".number_format($highPrice);
					} else if(isset($_GET["lowPrice"]) && !isset($_GET["highPrice"])) {
						$label = "Price: over $".number_format($lowPrice);
					} else {
						$label = "Price: $".number_format($lowPrice)." to $".number_format($highPrice);
					}
					$sel_id = "selectedPriceBtn";
				} else if($currValue == "color") {
					$label = "Color: ".$color;
					$sel_id = "selectedColorBtn";
				} else if($currValue == "location") {
					$label = "Location: ".number_format($searchRadius)." miles from ".$zipCode;
					$sel_id = "selectedLocationBtn";
				} else if($currValue == "listingSites") {
					$listing_spl = split(",", $listingSites);
					$amt_sites_selected = count($listing_spl);
					$label = "Listing sites: (".$amt_sites_selected.") selected";
					$sel_id = "selectedListingSitesBtn";
				} else if($currValue == "transmission") {
					$label = "Transmission: ".$transmission;
					$sel_id = "selectedTransmissionBtn";
				} else if($currValue == "mileage") {
					if(isset($_GET["highMileage"]) && !isset($_GET["lowMileage"])) {
						$label = "Mileage: up to ".number_format($highMileage)." miles";
					} else if(isset($_GET["lowMileage"]) && !isset($_GET["highMileage"])) {
						$label = "Mileage: over ".number_format($lowMileage)." miles";
					} else {
						$label = "Mileage: ".number_format($lowMileage)." to ".number_format($highMileage)." miles";
					}

					$sel_id = "selectedMileageBtn";
				} else if($currValue == "condition") {
					$cond_spl = split(",", $condition);
					$cond_amt = count($cond_spl);
					$label = "Condition: (".$cond_amt.") selected";
					$sel_id = "selectedConditionBtn";
				}
		[/php]
				<button id="[php] echo $sel_id; [/php]" type="button" class="btn selected-filter-btn">
					[php] echo $label; [/php]
					<img src="/wp-content/uploads/filter-x.png" class="filter-plus">
				</button>
		[php]
			}
		[/php]
	</div>
	<br><br>


[php]
	}
[/php]


<div id="listings-outer-container"></div>

[php]
	$server_name = "redacted";
	$database_name = "redacted";
	$username = "redacted";
	$password = "redacted";

[/php]

<br>

<div id="listings-box">
[php]

	$conn = new mysqli($server_name, $username, $password, $database_name);

	if($conn->connect_error) {
		die("Error in connecting to listings database.");
	} else {
		if(isset($_GET["pagenum"])) {
			$desired_page = (int) $_GET["pagenum"];
		} else {
			$desired_page = 1;
		}


		$start_idx = ($desired_page - 1)*15;

		$filtration_mods = array();
		$filtration_modifier = "";

		if($highPrice != NULL) {
			$highPrice = $conn->real_escape_string($highPrice);
			$filt_str = "price < '".$highPrice."'";
			array_push($filtration_mods, $filt_str);
		}

		if($lowPrice != NULL) {
			$lowPrice = $conn->real_escape_string($lowPrice);
			$filt_str = "price > '".$lowPrice."'";
			array_push($filtration_mods, $filt_str);
		}

		if($color != NULL) {
			$color = $conn->real_escape_string($color);
			$filt_str = "color = '".$color."'";
			array_push($filtration_mods, $filt_str);
		}

		if($listingSites != NULL) {
			$all_sites = split(",", $listingSites);
			$formatted_sites = array();

			for($i = 0; $i < count($all_sites); $i++) {
				$curr_site = $all_sites[$i];
				if($curr_site == "zcarguide") {
					array_push($formatted_sites, "site = 'ZCarGuide'");
				} else if($curr_site == "autotrader") {
					array_push($formatted_sites, "site = 'Autotrader Classics'");
				} else if($curr_site == "craigslist") {
					array_push($formatted_sites, "site = 'Craigslist'");
				} else if($curr_site == "zcartrader") {
					array_push($formatted_sites, "site = 'ZCarTrader'");
				} else if($curr_site == "carsforsale") {
					array_push($formatted_sites, "site = 'CarsForSale'");
				} else if($curr_site == "hemmings") {
					array_push($formatted_sites, "site = 'Hemmings'");
				} else if($curr_site == "ebay") {
					array_push($formatted_sites, "site = 'eBay'");
				} else if($curr_site == "bringatrailer") {
					array_push($formatted_sites, "site = 'Bring a Trailer'");
				} else if($curr_site == "carscom") {
					array_push($formatted_sites, "site = 'Cars.com'");
				}
			}

			$formatted_site_mod = implode(" OR ", $formatted_sites);
			if(count($formatted_sites) == 1) {
				array_push($filtration_mods, $formatted_site_mod);
			} else if(count($formatted_sites) > 1) {
				$final_sites_str = "(".$formatted_site_mod.")";
				array_push($filtration_mods, $final_sites_str);
			}
		}

		if($transmission != NULL) {
			$transmission = $conn->real_escape_string($transmission);
			$filt_str = "transmission = '".$transmission."'";
			array_push($filtration_mods, $filt_str);
		}

		if($highMileage != NULL) {
			$highMileage = $conn->real_escape_string($highMileage);
			$filt_str = "miles < '".$highMileage."'";
			array_push($filtration_mods, $filt_str);
		}

		if($lowMileage != NULL) {
			$lowMileage = $conn->real_escape_string($lowMileage);
			$filt_str = "price > '".$lowMileage."'";
			array_push($filtration_mods, $filt_str);
		}

		if($condition != NULL) {
			$all_conds = split(",", $condition);
			$formatted_conds = array();

			for($i = 0; $i < count($all_conds); $i++) {
				$curr_cond = $all_conds[$i];
				if($curr_cond == "concoursCondition") {
					array_push($formatted_conds, "`condition` = 'Concours'");
				} else if($curr_cond == "excellentCondition") {
					array_push($formatted_conds, "`condition` = 'Excellent'");
				} else if($curr_cond == "goodCondition") {
					array_push($formatted_conds, "`condition` = 'Good'");
				} else if($curr_cond == "poorCondition") {
					array_push($formatted_conds, "`condition` = 'Poor'");
				} else if($curr_cond == "partsSalvageCondition") {
					array_push($formatted_conds, "`condition` = 'Parts Salvage'");
				} else if($curr_cond == "highlyModifiedCondition") {
					array_push($formatted_conds, "`condition` = 'Highly Modified'");
				}
			}

			$formatted_conds_mod = implode(" OR ", $formatted_conds);
			if(count($formatted_conds) == 1) {
				array_push($filtration_mods, $formatted_conds_mod);
			} else if(count($formatted_sites) > 1) {
				$final_conds_str = "(".$formatted_conds_mod.")";
				array_push($filtration_mods, $final_conds_str);
			}
		}

		if($zipCode != NULL && $searchRadius != NULL) {
		    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zipCode)."&key=AIzaSyA3D16doczDkSa2grUjW9f5O0cnH11XHLo&sensor=false";
		    $result_string = file_get_contents($url);
		    $result = json_decode($result_string, true);
		    $geoData = $result['results'][0]['geometry']['location'];

			$givenLat = $geoData['lat'];
			$givenLng = $geoData['lng'];
		}

		array_push($filtration_mods, "model = '280Z'");

		if(count($filtration_mods) > 0) {
			$clauses = implode(" AND ", $filtration_mods);
			$filtration_modifier = " WHERE ".$clauses;
		}

		if($zipCode != NULL && $searchRadius != NULL) {
			$searchRadius = $conn->real_escape_string($searchRadius);
			$query = "SELECT *, (
					3959 * acos (
						cos ( radians(".$givenLat.") )
						* cos( radians( lat ) )
						* cos( radians( lng ) - radians(".$givenLng.") )
						+ sin ( radians(".$givenLat.") )
						* sin( radians( lat ) )
		    		)
	  			) AS distance FROM new_listings ".$filtration_modifier." HAVING distance < ".$searchRadius." ORDER BY distance DESC LIMIT " . $start_idx . ",15";

			$total_pgs_qry = "SELECT *, (
					3959 * acos (
						cos ( radians(".$givenLat.") )
						* cos( radians( lat ) )
						* cos( radians( lng ) - radians(".$givenLng.") )
						+ sin ( radians(".$givenLat.") )
						* sin( radians( lat ) )
		    		)
	  			) AS distance FROM new_listings ".$filtration_modifier." HAVING distance < ".$searchRadius." ORDER BY distance";
		} else {
			$query = "SELECT * from new_listings ".$filtration_modifier." ORDER BY location DESC LIMIT " . $start_idx . ",15";
			$total_pgs_qry = "SELECT * from new_listings ".$filtration_modifier." ORDER BY location";
		}

		$total_res = $conn->query($total_pgs_qry);
		$total_num_rows = $total_res->num_rows;

		$result = $conn->query($query);
		$num_rows = $result->num_rows;
		$num_pages = ceil($num_rows / 15);
		$total_num_pages = ceil($total_num_rows / 15);

		if($num_rows > 0) {
			$ad_counter = 1;

			for($i = 0; $i < $num_rows; $i++) {
				$row = $result->fetch_assoc();
				$id = $row["id"];
				$year = $row["year"];
				$model = $row["model"];
				$location = $row["location"];
				$transmission = $row["transmission"];
				$color = $row["color"];
				$miles = $row["miles"];
				$site = $row["site"];
				$url = $row["url"];
				$description = $row["description"];
				$price = $row["price"];
				$lat = $row["lat"];
				$lng = $row["lng"];
				$images = $row["images"];
				$img_arr = explode(",", $images);
				$first_img_id = $img_arr[0];

				$attachment_data = wp_get_attachment_image_src($first_img_id);
				$primary_img = $attachment_data[0];

				$price_string = "Auction";

				if($price != -1) {
					$price_string = "$" . number_format($price);
				}

				$description = str_replace(array("\r", "\n"), '', $description);
				$description_string = substr($description, 0, 200);
				$miles_string = "Mileage not specified";

				if($miles != -1) {
					$miles_string = number_format($miles) . " miles";
				}

				if(strlen($description) > 200) {
					$description_string .= "...";
				}

				if($ad_counter == 4) {

[/php]
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- zc-within-listings -->
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-client="ca-pub-5315962531624790"
	     data-ad-slot="8185049967"
	     data-ad-format="auto"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
[php]
		$ad_counter = 0;
	}
[/php]

<a href="/datsun-280z-for-sale-listing?id=[php] echo $id; [/php]">
	<div class="listing-container">
		<div class="left-listing">
			<span class="listing-title">[php] echo $year [/php] Datsun [php] echo $model; [/php]</span>
			<img src="[php] echo $primary_img; [/php]">
		</div>
		<div class="middle-listing">
			<span class="listing-location">[php] echo $location; [/php]</span>
			<span class="listing-subtitle">[php] echo $color; [/php] - [php] echo $miles_string; [/php] - [php] echo $transmission; [/php]</span>

			<p class="listing-description">
				[php] echo $description_string; [/php]
			</p>
		</div>

		<div class="right-listing">
			<span class="listing-price">[php] echo $price_string; [/php]</span>
			<span class="listing-site">[php] echo $site; [/php]</span>
		</div>
	</div>
</a>

[php]
		$ad_counter++;
			}

			if($total_num_rows > 15) {
				[/php]
					<div id="endofresults"></div>
					<div id="outer-pagination-container">
					<div id="pagination-container">
					[php]
						$next_query_string['pagenum'] = (string) ($desired_page + 1);
						$prev_query_string['pagenum'] = (string) ($desired_page - 1);
						$new_qs_next = http_build_query($next_query_string);
						$new_qs_prev = http_build_query($prev_query_string);

						$prev_button_large = '<a href="?' . $new_qs_prev . '" class="prev-button reg-pagination" disabled>Previous Page</a>';
						$prev_button_small = '<a href="?' . $new_qs_prev . '" class="prev-button small-pagination" disabled><<</a>';

						$next_button_large = '<a href="?' . $new_qs_next . '" class="btn next-button reg-pagination">Next Page</a>';
						$next_button_small = '<a href="?' . $new_qs_next . '" class="prev-button small-pagination" disabled>>></a>';

						$middle_input = '<input class="page-input" readonly="readonly" type="text" value="'.$desired_page.'" />';

						if($desired_page == 1) {
							if($desired_page == $total_num_pages) {
								$pagination_buttons = 'Page ' . $middle_input . ' of 1';
							} else {
								$pagination_buttons = $middle_input . $next_button_small . $next_button_large;
							}
						} else {
							if($desired_page == $total_num_pages) {
								$pagination_buttons = $prev_button_large . $prev_button_small . $middle_input;
							} else {
								$pagination_buttons = $prev_button_large . $prev_button_small . $middle_input . $next_button_small . $next_button_large;
							}
						}


						echo $pagination_buttons;
					[/php]
					</div>
					</div>
				[php]
			}


		} else {
			[/php]
			<div id="noresults">Unfortunately, this search returned no results. Maybe the filters you have selected are too restrictive. Feel free to try again or refresh the page if you'd like to start over.</div>
			[php]
		}
	}

[/php]

</div>
