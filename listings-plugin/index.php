<?php
/*
Plugin Name: Listings Plugin
Plugin URI: zcarguide.com
Description: Add listings to ZCarGuide
Author: Mark Lyons
Author URI: zcarguide.com
Version: 0.1
*/

add_action("admin_menu", "addMenu");

function addMenu() {
	add_menu_page("Listings", "Listings", 4, "zcarlistings", "zcarListings");
	add_submenu_page("zcarlistings", "Add New Listing", "Add New Listing", 4, "add-new-listing", "addNewListing");
}

function zcarListings() {
	$server_name = "redacted";
	$database_name = "redacted";
	$username = "redacted";
	$password = "redacted";

	$conn = new mysqli($server_name, $username, $password, $database_name);

	if($conn->connect_error) {
		die("Error in connecting to listings database.");
	} else {
		if(isset($_GET['del'])) {
			$del_id = $_GET['del'];
			$del_qry = "DELETE from new_listings WHERE id = ".$del_id;
			$res = $conn->query($del_qry);

			echo "<h2 style='color:green'>Listing ".$del_id." deleted<h2>";

		}

		$total_pgs_qry = "SELECT * from new_listings ORDER BY id DESC";
		$total_res = $conn->query($total_pgs_qry);

		$result = $conn->query($total_pgs_qry);
		$num_rows = $result->num_rows;

		if($num_rows > 0) {
			echo "<h1>Active For Sale Listings</h1><ul>";
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
				$curr_listng = "<li><a href='/datsun-240z-for-sale-listing?id=".$id."'>".$model." id #".$id."</a> - $".$price." in ".$location." -- <a href='?page=zcarlistings&del=".$id."'>DELETE</a></li>";
				echo $curr_listng;
			}
			echo "</ul>";
		} else {
			echo "No listings in database.";
		}
	}
}

function pippin_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];
}

function addNewListing() {
	$server_name = "redacted";
	$database_name = "redacted";
	$username = "redacted";
	$password = "redacted";

	$conn = new mysqli($server_name, $username, $password, $database_name);

	if(isset($_GET['year'])) {
		$year = $_GET['year'];
		$model = $_GET['model'];
		$price = $_GET['price'];
		$location = $_GET['location'];
		$mileage = $_GET['mileage'];
		$transmission = $_GET['transmission'];
		$color = $_GET['color'];
		$site = $_GET['site'];
		$url = $_GET['url'];
		$description = $_GET['description'];
		$condition = $_GET['condition'];

		$goog_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($location)."&key=AIzaSyA3D16doczDkSa2grUjW9f5O0cnH11XHLo&sensor=false";
	    $result_string = file_get_contents($goog_url);
	    $result = json_decode($result_string, true);
	    $geoData = $result['results'][0]['geometry']['location'];

		$lat = $geoData['lat'];
		$lng = $geoData['lng'];

		$images = array();
		if(isset($_GET['img1']) && strlen($_GET['img1']) > 0) {
			array_push($images, $_GET['img1']);
		}

		if(isset($_GET['img2']) && strlen($_GET['img2']) > 0) {
			array_push($images, $_GET['img2']);
		}

		if(isset($_GET['img3']) && strlen($_GET['img3']) > 0) {
			array_push($images, $_GET['img3']);
		}

		if(isset($_GET['img4']) && strlen($_GET['img4']) > 0) {
			array_push($images, $_GET['img4']);
		}

		$gallery_arr = array();

		for($i = 0; $i < count($images); $i++) {
			$img_resp = media_sideload_image($images[$i], 1773);

			$doc = new DOMDocument();
			$doc->loadHTML($img_resp);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"

			$img_id = pippin_get_image_id($src);
			array_push($gallery_arr, $img_id);
		}

		$gallery_str = implode(",", $gallery_arr);


		$ins_qry = "INSERT INTO `wp_zcarguide`.`new_listings` (`year`, `model`, `location`, `transmission`, `color`, `miles`, `site`, `url`, `description`, `price`, `condition`, `lat`, `lng`, `images`) VALUES ('$year', '$model', '$location', '$transmission', '$color', '$mileage', '$site', '$url', '$description', '$price', '$condition', '$lat', '$lng', '$gallery_str')";

		$total_res = $conn->query($ins_qry);
		echo "<h2 style='color:green'>Listing added.</h2>";
	}


	echo "<h1>Add New Listing</h1>";
	echo "<form method='GET' action='/wp-admin/admin.php'>";
	echo "<label for='year'>Year: </label><input type='text'  name='year'><br><br>";
	echo "<label for='model'>Model: </label><input type='text'  name='model'><br><br>";
	echo "<label for='price'>Price: </label><input type='text'  name='price'><br><br>";
	echo "<label for='location'>Location: </label><input type='text'  name='location'><br><br>";
	echo "<label for='mileage'>Mileage: </label><input type='text'  name='mileage'><br><br>";
	echo "<div class='radio-contain'><input type='radio' name='transmission' value='Manual' checked='checked'><label for='manualChoice'>Manual</label><div>";
	echo "<div class='radio-contain'><input type='radio' name='transmission' value='Automatic'><label for='manualChoice'>Automatic</label><div><br>";

	echo '<label for="color">Color: </label>
    <select id="colorSelect" name="color">
    	<option value="Black">Black</option>
		<option value="Blue">Blue</option>
		<option value="Brown">Brown</option>
		<option value="Green">Green</option>
		<option value="Orange">Orange</option>
		<option value="Purple">Purple</option>
		<option value="Red">Red</option>
		<option value="Silver">Silver</option>
		<option value="White">White</option>
		<option value="Yellow">Yellow</option>
    </select><br><br>';

    echo '<label for="site">Site: </label>
    <select id="siteSelect" name="site">
    	<option value="ZCarGuide">ZCarGuide</option>
    	<option value="Autotrader Classics">Autotrader Classics</option>
		<option value="Craigslist">Craigslist</option>
		<option value="ZCarTrader">ZCarTrader</option>
		<option value="CarsForSale">CarsForSale</option>
		<option value="Hemmings">Hemmings</option>
		<option value="eBay">eBay</option>
		<option value="Bring a Trailer">Bring a Trailer</option>
		<option value="Cars.com">Cars.com</option>
    </select><br><br>';
    echo "<label for='url'>URL: </label><input type='text'  name='url'><br><br>";
    echo "<label for='description'>Description: </label><textarea name='description'></textarea><br><br>";
    echo '<label for="condition">Condition Assessment: </label>
    <select id="conditionSelect" name="condition">
    	<option value="Concours">Concours</option>
		<option value="Excellent">Excellent</option>
		<option value="Good">Good</option>
		<option value="Poor">Poor</option>
		<option value="Parts Salvage">Parts Salvage</option>
		<option value="Highly Modified">Highly Modified</option>
    </select><br><br>';

    echo "<label for='img1'>Image 1: </label><input type='text'  name='img1'><br><br>";
    echo "<label for='img2'>Image 2: </label><input type='text'  name='img2'><br><br>";
    echo "<label for='img3'>Image 3: </label><input type='text'  name='img3'><br><br>";
    echo "<label for='img4'>Image 4: </label><input type='text'  name='img4'><br><br>";

    echo '<input type="hidden" name="page" value="add-new-listing">';
    echo '<input type="submit" value="Submit New Listing">';




	echo "</form>";
}
