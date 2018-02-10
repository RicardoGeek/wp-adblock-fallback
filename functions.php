<?php
/* I know the following function is stupid ;) */
function get_countries() {
  return array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua & Deps",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina",
    "Burundi",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cape Verde",
    "Central African Rep",
    "Chad",
    "Chile",
    "China",
    "Colombia",
    "Comoros",
    "Congo",
    "Congo {Democratic Rep}",
    "Costa Rica",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland {Republic}",
    "Israel",
    "Italy",
    "Ivory Coast",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea North",
    "Korea South",
    "Kosovo",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Morocco",
    "Mozambique",
    "Myanmar, {Burma}",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russian Federation",
    "Rwanda",
    "St Kitts & Nevis",
    "St Lucia",
    "Saint Vincent & the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome & Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Swaziland",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad & Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
  );
}

/* Functions */
function get_ad_zones() {
  global $wpdb;
  $ad_table_name = $wpdb->prefix."ad";
  $zones = $wpdb->get_results( "SELECT * FROM $ad_table_name"  );
  return $zones;
}

function increase_zone_impression_count($zoneId) {
  global $wpdb;
  $impression_table_name = $wpdb->prefix."impression";
  $adZone = $wpdb->get_results( "SELECT * FROM $impression_table_name WHERE id=$zoneId; "  );
  if($adZone) {
    $wpdb->query( $wpdb->prepare(  "UPDATE $impression_table_name SET count = count + 1 WHERE adId=%d",  array($zoneId) ) );
  } else {
    $wpdb->query( $wpdb->prepare(  "INSERT INTO $impression_table_name (adId, count) VALUES (%d, %d)",  array($zoneId, 1) ) );
  }
}

/* Here is the magic sauce */
function detect_country($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

function monetize_shorcode($atts) {
  global $wpdb;

  $a = shortcode_atts( array(
		'size' => '200x200',
	), $atts );
  $ad_table_name = $wpdb->prefix."ad";

  $size = $a['size'];
  $country = detect_country("Visitor", "Country");

  $zones = $wpdb->get_results( "SELECT * FROM $ad_table_name WHERE size='$size' AND countryId='$country'; "  );
  if(!$zones) {
    $zones = $wpdb->get_results( "SELECT * FROM $ad_table_name WHERE size='$size' AND countryId='default'; "  );
  }

  if($zones) {
    $zones_count = count($zones);
    if($zones_count > 1) {
      $keyZone = array_rand($zones, 1);
      $zone = $zones[$keyZone];
    } else {
      $zone = $zones[0];
    }

    increase_zone_impression_count($zone->id);
    return "<a href='".$zone->link."' class='track-me' data-id='$zone->id' target='_blank'><img src='".$zone->banner."'/></a>";
  } else {
    return "<!-- Cannot find any ad zones configured -->";
  }
}
add_shortcode( 'monetize', 'monetize_shorcode' );

/* AJAX Functions */
add_action('wp_ajax_create_new_zone', 'create_new_zone');
function create_new_zone() {
  global $wpdb;

  $ad_table_name = $wpdb->prefix."ad";

  $country = $_POST['country'];
  $size = $_POST['size'];
  $banner = $_POST['banner'];
  $link = $_POST['link'];

  $wpdb->query( $wpdb->prepare(  "INSERT INTO $ad_table_name (banner, link, size, countryId ) VALUES ( %s, %s, %s, %s )",  array($banner, $link, $size, $country) ) );

  echo "Ad Zone Created";
  wp_die();
}

add_action('wp_ajax_delete_zone', 'delete_zone');
function delete_zone() {
  global $wpdb;

  $ad_table_name = $wpdb->prefix."ad";
  $id = $_POST['id'];

  $wpdb->delete( $ad_table_name, array( 'id' => $id ) );

  echo "Ad Zone Deleted!";
  wp_die();
}

add_action('wp_ajax_get_zone', 'get_zone');
function get_zone() {
    global $wpdb;
    $ad_table_name = $wpdb->prefix."ad";

    $id = $_POST['id'];

    $zone = $wpdb->get_results( "SELECT * FROM $ad_table_name WHERE id = $id; "  );

    echo json_encode($zone);
    wp_die();
}

add_action('wp_ajax_increase_click_count', 'increase_click_count');
add_action('wp_ajax_nopriv_increase_click_count', 'increase_click_count');
function increase_click_count() {
  global $wpdb;
  $zoneId = $_POST['zoneId'];
  $click_table_name = $wpdb->prefix."click";
  $adZone = $wpdb->get_results( "SELECT * FROM $click_table_name WHERE adId=$zoneId; "  );
  if($adZone) {
    $wpdb->query( $wpdb->prepare(  "UPDATE $click_table_name SET count = count + 1 WHERE adId=%d",  array($zoneId) ) );
  } else {
    $wpdb->query( $wpdb->prepare(  "INSERT INTO $click_table_name (adId, count) VALUES (%d, %d)",  array($zoneId, 1) ) );
  }
  wp_die();
}
