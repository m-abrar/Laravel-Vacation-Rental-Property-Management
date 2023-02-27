<?php
		//var_dump( $_POST );
		if( !isset( $_POST ) || sizeof( $_POST ) == 0 ) {
			
			$_POST[ 'type' ] = 'both';
			$_POST[ 'multiple' ] = 'true';
			$_POST[ 'autocomplete' ] = 'true';
			$_POST[ 'userLocation' ] = 'true';
			$_POST[ 'routeMode' ] = 'true';
			$_POST[ 'placesList' ] = 'true';
			$_POST[ 'placeDetails' ] = 'true';
			$_POST[ 'routeTime' ] = 'true';
			$_POST[ 'route' ] = 'true';
			$_POST[ 'cluster' ] = 'true';
			$_POST[ 'wheelScroll' ] = 'true';
			$_POST[ 'zoom' ] = 15;
			
			$_POST[ 'filter-size' ] = array('1');
			$_POST[ 'filter1-name' ] = 'ATM';
			$_POST[ 'filter1-icon' ] = 'map-icon-atm';
			$_POST[ 'filter1-types' ] = array( 'atm' );
			$_POST[ 'filter1-icon-type' ] = 'automatic';
			$_POST[ 'fb' ] = 1;
		}
		
		?>
<!DOCTYPE html>
<html>
	<head>
		<title>Place searches</title>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<!-- Map Icons -->
		<link href="../src/map-icons-master/dist/css/map-icons.css" rel="stylesheet" type="text/css">
		<link href="../src/awesomePOI.css" media="all" rel="stylesheet" type="text/css" />
		<link id="poiskin" href="../src/skins/skin<?php echo $_POST[ 'fb' ]; ?>.css" media="all" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="multiple-select-master/multiple-select.css" />
		<link rel="stylesheet" href="bootstrap-iconpicker-1.8.2/icon-fonts/map-icons-2.1.0/css/map-icons.min.css"/>
		<link rel="stylesheet" href="bootstrap-iconpicker-1.8.2/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css"/>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
		
		<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkJgWmx1PGNLDl5my-EEgeYIEOtI5ij2w&sensor=false&libraries=places"></script>  		
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script type="text/javascript" src="bootstrap-iconpicker-1.8.2/bootstrap-iconpicker/js/iconset/iconset-mapicon-2.1.0.min.js"></script>
		<script type="text/javascript" src="bootstrap-iconpicker-1.8.2/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
		<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
		
		<style>
		
		body {
			background-color: #fcfcfc;
		}
		
		label > input.skin{ /* HIDE RADIO */
		  visibility: hidden; /* Makes input not-clickable */
		  position: absolute; /* Remove input from document flow */
		}
		label > input.skin + img{ /* IMAGE STYLES */
		  cursor: pointer;
		  border: 4px solid transparent;
		  border-radius: 4px;		  
		  padding: 2px;
		}
		label > input.skin:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
		  border: 4px solid #0088cc;
		  
		}
		
		.ms-choice {
			height: 34px;
			line-height: 34px;
			border-color: #ccc;
		}
		.ms-choice > div {
			top: 5px;
		}
		
		option {
			padding: 5px;
		}
		
		.head {
				
			background-image: -webkit-gradient(linear,left top,left bottom,from(#563d7c),to(#6f5499));
			background-image: -webkit-linear-gradient(top,#563d7c 0,#6f5499 100%);
			background-image: -o-linear-gradient(top,#563d7c 0,#6f5499 100%);
			background-image: linear-gradient(to bottom,#563d7c 0,#6f5499 100%);
			color: #fff;
			text-shadow: 0 1px 0 rgba(0,0,0,.1);
			background-color: #6f5499;

		}
				
		.footer {
			padding-top: 30px;
			padding-bottom: 20px;
			color: #99979c;
			background-color: #2a2730;
			margin-top: 50px;
		}
		</style>
		
		<script>
		var markup = '<section class="apoi-section">					<div class="apoi-filter-container">					<div class="apoi-filter" data-types="atm,bank,school,bus_station,train_station,transit_station,post_office,fire_station,hospital,police,doctor,church,city_hall,local_government_office,food,grocery_or_supermarket,university">						<span class="apoi-map-icon map-icon-doctor"></span>						Hospitals					</div>					<div class="apoi-filter" data-types="bakery,laundry" data-icon-font="map-icon-point-of-interest">						<span class="apoi-map-icon map-icon-grocery-or-supermarket"></span>						Stores					</div>					<div class="apoi-filter" data-types="restaurant" data-icon-img="../src/icons/icon-pin1-blue.png">						<span class="apoi-map-icon map-icon-restaurant"></span>						Restaurants					</div>					<div class="apoi-filter" data-types="subway_station">						<span class="apoi-map-icon map-icon-transit-station"></span>						Transportation					</div>					<div class="apoi-filter" data-types="toilets,photos" data-source="json">						<span class="apoi-map-icon map-icon-crosshairs"></span>						JSON FIle					</div>					<div class="apoi-filter" data-types="toilets" data-source="json">						<span class="apoi-map-icon map-icon-museum"></span>						JSON Toilets					</div>					<div class="apoi-filter" data-types="photos" data-source="json">						<span class="apoi-map-icon map-icon-bakery"></span>						JSON Photos					</div>				</div>				<div id="apoi-list"></div>				<div id="apoi-details-container"></div>				<div class="apoi-autocomplete-container">					<input id="apoi-autocomplete" type="text" placeholder="Enter a location" />					<a href="#" id="apoi-geolocation"><span class="apoi-map-icon map-icon-crosshairs"></span></a>				</div>				<div class="apoi-transport-modes">					<input id="apoi-driving" type="radio" name="apoi-mode" value="DRIVING" checked /><label for="apoi-driving"><span class="apoi-map-icon map-icon-taxi-stand"></span></label>					<input id="apoi-bicycling" type="radio" name="apoi-mode" value="BICYCLING" /><label for="apoi-bicycling"><span class="apoi-map-icon map-icon-bicycling"></span></label> 					<input id="apoi-transit" type="radio" name="apoi-mode" value="TRANSIT" /><label for="apoi-transit"><span class="apoi-map-icon map-icon-bus-station"></span></label>					<input id="apoi-walking" type="radio" name="apoi-mode" value="WALKING" /><label for="apoi-walking"><span class="apoi-map-icon map-icon-walking"></span></label>				</div>				<a href="#" id="apoi-switch-street"><span class="apoi-map-icon map-icon-male"></span></a>  			<a href="#" id="apoi-switch-map"><span class="apoi-map-icon map-icon-map-pin"></span></a>					<div id="apoi-route-time"></div>				<div id="apoi-maps-container"></div></section>';
		
		<?php
		$j = isset( $_POST[ 'filter-size' ] ) && sizeof( $_POST[ 'filter-size' ] ) > 0 ? sizeof( $_POST[ 'filter-size' ] ) + 1 : 2;
		?>
		$(document).ready(function() {
			$("input[name='fb']").change( function() {
				$("#poiskin").attr( 'href', '../src/skins/skin' + $("input[name='fb']:checked").val() + '.css' )
			});
			<?php 
			for( $i = 1; $i < $j; $i ++ ) {
			?>
				if($("#filter<?php echo $i; ?>-icon-type").val() == 'automatic' ) {
					$("#filter<?php echo $i; ?>-image-icon-div").hide();
					$("#filter<?php echo $i; ?>-image-font-div").hide();
				} else if($("#filter<?php echo $i; ?>-icon-type").val() == 'image' ) {
					$("#filter<?php echo $i; ?>-image-icon-div").show();
					$("#filter<?php echo $i; ?>-image-font-div").hide();
				} else {
					$("#filter<?php echo $i; ?>-image-icon-div").hide();
					$("#filter<?php echo $i; ?>-image-font-div").show();
				}
				
				$("#filter<?php echo $i; ?>-icon-type").change( function() {
					if($("#filter<?php echo $i; ?>-icon-type").val() == 'automatic' ) {
						$("#filter<?php echo $i; ?>-image-icon-div").hide();
						$("#filter<?php echo $i; ?>-image-font-div").hide();
					} else if($("#filter<?php echo $i; ?>-icon-type").val() == 'image' ) {
						$("#filter<?php echo $i; ?>-image-icon-div").show();
						$("#filter<?php echo $i; ?>-image-font-div").hide();
					} else {
						$("#filter<?php echo $i; ?>-image-icon-div").hide();
						$("#filter<?php echo $i; ?>-image-font-div").show();
					}
				});
				
				if($("#filter<?php echo $i; ?>-source").val() == 'json' ) {
					$("#filter<?php echo $i; ?>-types-div").hide();
					$("#filter<?php echo $i; ?>-json-div").show();			
				} else {
					$("#filter<?php echo $i; ?>-types-div").show();
					$("#filter<?php echo $i; ?>-json-div").hide();	
				}
				
				$("#filter<?php echo $i; ?>-source").change( function() {
					if($("#filter<?php echo $i; ?>-source").val() == 'json' ) {
						$("#filter<?php echo $i; ?>-types-div").hide();
						$("#filter<?php echo $i; ?>-json-div").show();			
					} else {
						$("#filter<?php echo $i; ?>-types-div").show();
						$("#filter<?php echo $i; ?>-json-div").hide();	
					}
				});
				
				
				
			<?php			
			}
			?>
			$("#add-filter").click( function(e) {
				e.preventDefault();
				var i = $(this).data('i');
				
				
				
				
									
				
				
				$("#filters").append( '<div class="row" id="filter' + i + '" style="background: #efefef; padding: 10px; margin-bottom: 5px;"><div class="col-xs-12 col-sm-6 col-md-4 col-lg-1"><input type="hidden" id="filter' + i + '-size" name="filter-size[]" value="' + i + '" /><h4 style="margin-top: 5px;">Filter ' + i + '</h4><button class="remove-filter btn btn-danger btn-sm pull-right" data-i="' + i + '" data-toggle="tooltip" data-placement="top" title="Remove this menu position.">X Remove</button></div><div class="col-xs-12 col-sm-6 col-md-4 col-lg-2"><div class="form-group"><label for="filter' + i + '-name" data-toggle="tooltip" data-placement="top" title="Places filter menu name">Filter name</label><input id="filter' + i + '-name" type="text" value="" name="filter' + i + '-name" class="form-control" />								</div>						</div>						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-1"><label for="filter' + i + '-icon" data-toggle="tooltip" data-placement="top" title="Places filter menu icon">Icon</label><button id="filter' + i + '-name-picker" class="btn btn-default"></button><script>$("#filter' + i + '-name-picker").iconpicker({ icon: "", iconset: "mapicon", cols: 10, rows: 6 }).on("change", function(e) {$("#filter' + i + '-icon").val(e.icon);});	<\/script><input type="hidden" id="filter' + i + '-icon" name="filter' + i + '-icon" value="" /></div><div class="col-xs-12 col-sm-6 col-md-4 col-lg-2"><label for="filter' + i + '-source" data-toggle="tooltip" data-placement="top" title="Source of the places database. Default is Google Places Library, but you can use a custom JOSN file.">Source</label><select id="filter' + i + '-source"  name="filter' + i + '-source" class="form-control"><option value="google">Google Places</option>									<option value="json">JSON File</option>								</select>						</div>						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">									<div class="form-group" id="filter' + i + '-types-div">									<label for="filter' + i + '-types" data-toggle="tooltip" data-placement="top" title="Choose places categories for this link (you can choose more than one).">Filter Types</label>									<select id="filter' + i + '-types" name="filter' + i + '-types[]" placeholder="Start Types" multiple><option value="accounting"> accounting</option><option value="airport"> airport</option><option value="amusement_park"> amusement park</option><option value="aquarium"> aquarium</option><option value="art_gallery"> art gallery</option><option value="atm"> atm</option><option value="bakery"> bakery</option><option value="bank"> bank</option><option value="bar"> bar</option><option value="beauty_salon"> beauty salon</option><option value="bicycle_store"> bicycle store</option><option value="book_store"> book store</option><option value="bowling_alley"> bowling alley</option><option value="bus_station"> bus station</option><option value="cafe"> cafe</option><option value="campground"> campground</option><option value="car_dealer"> car dealer</option><option value="car_rental"> car rental</option><option value="car_repair"> car repair</option><option value="car_wash"> car wash</option><option value="casino"> casino</option><option value="cemetery"> cemetery</option><option value="church"> church</option><option value="city_hall"> city hall</option><option value="clothing_store"> clothing store</option><option value="convenience_store"> convenience store</option><option value="courthouse"> courthouse</option><option value="dentist"> dentist</option><option value="department_store"> department store</option><option value="doctor"> doctor</option><option value="electrician"> electrician</option><option value="electronics_store"> electronics store</option><option value="embassy"> embassy</option><option value="fire_station"> fire station</option><option value="florist"> florist</option><option value="funeral_home"> funeral home</option><option value="furniture_store"> furniture store</option><option value="gas_station"> gas station</option><option value="gym"> gym</option><option value="hair_care"> hair care</option><option value="hardware_store"> hardware store</option><option value="hindu_temple"> hindu temple</option><option value="home_goods_store"> home goods store</option><option value="hospital"> hospital</option><option value="insurance_agency"> insurance agency</option><option value="jewelry_store"> jewelry store</option><option value="laundry"> laundry</option><option value="lawyer"> lawyer</option><option value="library"> library</option><option value="liquor_store"> liquor store</option><option value="local_government_office"> local government office</option><option value="locksmith"> locksmith</option><option value="lodging"> lodging</option><option value="meal_delivery"> meal delivery</option><option value="meal_takeaway"> meal takeaway</option><option value="mosque"> mosque</option><option value="movie_rental"> movie rental</option><option value="movie_theater"> movie theater</option><option value="moving_company"> moving company</option><option value="museum"> museum</option><option value="night_club"> night club</option><option value="painter"> painter</option><option value="park"> park</option><option value="parking"> parking</option><option value="pet_store"> pet store</option><option value="pharmacy"> pharmacy</option><option value="physiotherapist"> physiotherapist</option><option value="plumber"> plumber</option><option value="police"> police</option><option value="post_office"> post office</option><option value="real_estate_agency"> real estate agency</option><option value="restaurant"> restaurant</option><option value="roofing_contractor"> roofing contractor</option><option value="rv_park"> rv park</option><option value="school"> school</option><option value="shoe_store"> shoe store</option><option value="shopping_mall"> shopping mall</option><option value="spa"> spa</option><option value="stadium"> stadium</option><option value="storage"> storage</option><option value="store"> store</option><option value="subway_station"> subway station</option><option value="synagogue"> synagogue</option><option value="taxi_stand"> taxi stand</option><option value="train_station"> train station</option><option value="transit_station"> transit station</option><option value="travel_agency"> travel agency</option><option value="university"> university</option><option value="veterinary_care"> veterinary care</option><option value="zoo"> zoo</option></select>									<script>									$(function() {										$("#filter' + i + '-types").multipleSelect({width: "100%"});									});									<\/script>								</div>								<div class="form-group" id="filter' + i + '-json-div">									<label for="filter' + i + '-json" data-toggle="tooltip" data-placement="top" title="Add comma-separated categories from JSON file.">JSON categories</label><input id="filter' + i + '-json" type="text" value="" name="filter' + i + '-json" class="form-control" />								</div>						</div>						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">								<label for="filter' + i + '-icon-type" data-toggle="tooltip" data-placement="top" title="Script uses automatic marker icons for places, but you can override it with your own.">Marker</label>								<select id="filter' + i + '-icon-type"  name="filter' + i + '-icon-type" class="form-control">									<option value="automatic">automatic</option>									<option value="image">image</option>									<option value="font">font-icon</option>								</select>						</div>						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">								<div class="form-group" id="filter' + i + '-image-icon-div">									<label for="filter' + i + '-image-icon" data-toggle="tooltip" data-placement="top" title="Enter marker image URL or path.">Marker Image</label><input id="filter' + i + '-image-icon" type="text" value="" name="filter' + i + '-image-icon" class="form-control" />								</div>								<div class="form-group" id="filter' + i + '-image-font-div">									<label for="filter' + i + '-font-icon" data-toggle="tooltip" data-placement="top" title="Enter MapIcon font here. You can browse icons here: http://map-icons.com/">Marker Font Icon</label><button id="filter' + i + '-font-picker" class="btn btn-default"></button>								<script>								$("#filter' + i + '-font-picker").iconpicker({ icon: "", iconset: "mapicon", cols: 10, rows: 6 }).on("change", function(e) {									$("#filter' + i + '-font-icon").val(e.icon);								});																<\/script>								<input type="hidden" id="filter' + i + '-font-icon" name="filter' + i + '-font-icon" value="" />								</div>							</div>					</div>');
				$("#filters").append( '<script>if($("#filter' + i + '-icon-type").val() == "automatic" ) {					$("#filter' + i + '-image-icon-div").hide();					$("#filter' + i + '-image-font-div").hide();				} else if($("#filter' + i + '-icon-type").val() == "image" ) {					$("#filter' + i + '-image-icon-div").show();					$("#filter' + i + '-image-font-div").hide();				} else {					$("#filter' + i + '-image-icon-div").hide();					$("#filter' + i + '-image-font-div").show();				}								$("#filter' + i + '-icon-type").change( function() {					if($("#filter' + i + '-icon-type").val() == "automatic" ) {						$("#filter' + i + '-image-icon-div").hide();						$("#filter' + i + '-image-font-div").hide();					} else if($("#filter' + i + '-icon-type").val() == "image" ) {						$("#filter' + i + '-image-icon-div").show();						$("#filter' + i + '-image-font-div").hide();					} else {						$("#filter' + i + '-image-icon-div").hide();						$("#filter' + i + '-image-font-div").show();					}				});								if($("#filter' + i + '-source").val() == "json" ) {					$("#filter' + i + '-types-div").hide();					$("#filter' + i + '-json-div").show();							} else {					$("#filter' + i + '-types-div").show();					$("#filter' + i + '-json-div").hide();					}								$("#filter' + i + '-source").change( function() {					if($("#filter' + i + '-source").val() == "json" ) {						$("#filter' + i + '-types-div").hide();						$("#filter' + i + '-json-div").show();								} else {						$("#filter' + i + '-types-div").show();						$("#filter' + i + '-json-div").hide();						}				});<\/script>');
				$("#filters").append( '<script>$(".remove-filter").click( function(e) {e.preventDefault();	$("#filter' + i + '").remove();});<\/script>' );
				
				$(this).data('i', i + 1 );
			});
			
			$(".remove-filter").click( function(e) {
				e.preventDefault();
				var i = $(this).data('i');
				$("#filter"+ i ).remove();
			});
			
			
				$('#pin1').attr('src', '../src/icons/icon-pin1-' + $("#iconColor").val() + '.png');
				$('#pin2').attr('src', '../src/icons/icon-pin2-' + $("#iconColor").val() + '.png');
				$('#pin3').attr('src', '../src/icons/icon-pin3-' + $("#iconColor").val() + '.png');
				$('#pin4').attr('src', '../src/icons/icon-pin4-' + $("#iconColor").val() + '.png');
				$('#pin5').attr('src', '../src/icons/icon-pin5-' + $("#iconColor").val() + '.png');
				$('#pin6').attr('src', '../src/icons/icon-pin6-' + $("#iconColor").val() + '.png');
				$('#pin7').attr('src', '../src/icons/icon-pin7-' + $("#iconColor").val() + '.png');
				$('#pin8').attr('src', '../src/icons/icon-pin8-' + $("#iconColor").val() + '.png');
				$('#pin9').attr('src', '../src/icons/icon-pin9-' + $("#iconColor").val() + '.png');
				$('#pin10').attr('src', '../src/icons/icon-pin10-' + $("#iconColor").val() + '.png');
				$('#pin11').attr('src', '../src/icons/icon-pin11-' + $("#iconColor").val() + '.png');
				$('#pin12').attr('src', '../src/icons/icon-pin12-' + $("#iconColor").val() + '.png');
				$('#pin13').attr('src', '../src/icons/icon-pin13-' + $("#iconColor").val() + '.png');
				$('#pin14').attr('src', '../src/icons/icon-pin14-' + $("#iconColor").val() + '.png');
			$("#iconColor").change( function() {
				$('#pin1').attr('src', '../src/icons/icon-pin1-' + $("#iconColor").val() + '.png');
				$('#pin2').attr('src', '../src/icons/icon-pin2-' + $("#iconColor").val() + '.png');
				$('#pin3').attr('src', '../src/icons/icon-pin3-' + $("#iconColor").val() + '.png');
				$('#pin4').attr('src', '../src/icons/icon-pin4-' + $("#iconColor").val() + '.png');
				$('#pin5').attr('src', '../src/icons/icon-pin5-' + $("#iconColor").val() + '.png');
				$('#pin6').attr('src', '../src/icons/icon-pin6-' + $("#iconColor").val() + '.png');
				$('#pin7').attr('src', '../src/icons/icon-pin7-' + $("#iconColor").val() + '.png');
				$('#pin8').attr('src', '../src/icons/icon-pin8-' + $("#iconColor").val() + '.png');
				$('#pin9').attr('src', '../src/icons/icon-pin9-' + $("#iconColor").val() + '.png');
				$('#pin10').attr('src', '../src/icons/icon-pin10-' + $("#iconColor").val() + '.png');
				$('#pin11').attr('src', '../src/icons/icon-pin11-' + $("#iconColor").val() + '.png');
				$('#pin12').attr('src', '../src/icons/icon-pin12-' + $("#iconColor").val() + '.png');
				$('#pin13').attr('src', '../src/icons/icon-pin13-' + $("#iconColor").val() + '.png');
				$('#pin14').attr('src', '../src/icons/icon-pin14-' + $("#iconColor").val() + '.png');
			});
		});
				
		
		</script>
		
	</head>
		
<body>
		
		
		
	<section class="head">
	<div class="container">
		<div class="row" style="margin: 50px 0 50px 0">
			<div class="col-xs-12 text-center">
				<h1>awesomePOI - BUILDER</h1>
				<p>Better contact map & nearby place seach plugin.</b>
				
			</div>
		</div>
		<div class="row">
              <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="row" style="margin: 0 0 50px 0">
                  <div class="col-xs-6 text-right wow fadeInUp" data-wow-delay="1s">
                    <a href="http://chart.civ.pl/plugins/awesomePOI" target="blank" class="btn btn-default btn-lg">Plugin Overview</a>
                  </div>
                  <div class="col-xs-6 text-left wow fadeInUp" data-wow-delay="1.4s">
                    <a href="http://chart.civ.pl/plugins/awesomePOI/jquery-awesomePOI/documentation/" target="blank" class="btn btn-info btn-lg">Documentation</a>
                  </div>
                </div><!--End Button Row-->  
              </div>
            </div>
	</div>
	</section>
	<section>
	<form action="" method="POST">
		<div class="container">
			<div class="row" style="margin: 50px 0 50px 0">
				<div class="col-xs-12 col-md-10 col-md-offset-1 text-center">
					<p>If the map is not working, make sure you added Google Maps API key. You can generate it for free here: <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="blank">https://developers.google.com/maps/documentation/javascript/get-api-key</a>, and replace "YOUR_API_KEY" in the builder.php file:
		<pre>&lt;script src="http://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&sensor=false&libraries=places">&lt;/script></pre></p>
				</div>
			</div>
			<div class="row" style="margin: 50px 0 50px 0">
				<div class="col-xs-12 col-md-10 col-md-offset-1 text-center">
					<p>Use the builder to adjust the plugins to your needs without any HTML/Javacript knowlege. If you're more experienced users you can consult the documentation and do more customization, add custom skin and use callback functions.</p>
				</div>
			</div>
			<div class="row" style="margin: 50px 0 50px 0">
				<div class="col-xs-12">
					<hr/><h3 style="margin-bottom: 50px;">a) Choose skin</h3>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-lg-offset-1">
					<label>
						<input class="skin" type="radio" name="fb" value="1" <?php echo isset( $_POST[ 'fb' ] ) && $_POST[ 'fb' ] == '1' ? 'checked' : ''; ?> />
						<img src="img/skin1.png" class="img-responsive" style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);" />
					</label>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
					<label>
						<input class="skin" type="radio" name="fb" value="2" <?php echo isset( $_POST[ 'fb' ] ) && $_POST[ 'fb' ] == '2' ? 'checked' : ''; ?> />
						<img src="img/skin2.png" class="img-responsive" style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);" />
					</label>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">  
					<label>
						<input class="skin" id="fb3" type="radio" name="fb" value="3" <?php echo isset( $_POST[ 'fb' ] ) && $_POST[ 'fb' ] == '3' ? 'checked' : ''; ?> />
						<img src="img/skin3.png" class="img-responsive" style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);" />
					</label>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">  
					<label>
						<input class="skin" id="fb4" type="radio" name="fb" value="4" <?php echo isset( $_POST[ 'fb' ] ) && $_POST[ 'fb' ] == '4' ? 'checked' : ''; ?> />
						<img src="img/skin4.png" class="img-responsive"  style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);"/>
					</label>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
					<label>
						<input class="skin" id="fb5" type="radio" name="fb" value="5" <?php echo isset( $_POST[ 'fb' ] ) && $_POST[ 'fb' ] == '5' ? 'checked' : ''; ?> />
						<img src="img/skin5.png" class="img-responsive" style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);" />
					</label>
				</div>		 
			</div>
		</div>
		<div class="container" id="filters">
			<div class="row">
				<div class="col-xs-12"><hr/><h3 style="margin-bottom: 50px;">b) Create filters navigation</h3></div>
			</div>
			<?php 
			
			for( $i = 1; $i < $j; $i ++ ) {
				
				?>
					<div class="row" id="filter<?php echo $i; ?>" style="background: #efefef; padding: 10px; margin-bottom: 5px;">
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-1">							
								<input type="hidden" id="filter<?php echo $i; ?>-size" name="filter-size[]" value="<?php echo $i; ?>" />
								<h4 style="margin-top: 5px;">Filter <?php echo $i; ?></h4>
								<button class="remove-filter btn btn-danger btn-sm pull-right" data-i="<?php echo $i; ?>" data-toggle="tooltip" data-placement="top" title="Remove this menu position.">X Remove</button>	
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
								<div class="form-group">
									<label for="filter<?php echo $i; ?>-name" data-toggle="tooltip" data-placement="top" title="Places filter menu name">Filter name</label><input id="filter<?php echo $i; ?>-name" type="text" value="<?php echo isset( $_POST[ 'filter'. $i . '-name' ] ) && $_POST[ 'filter'. $i . '-name' ] ? $_POST[ 'filter'. $i . '-name' ]  : ''; ?>" name="filter<?php echo $i; ?>-name" class="form-control" />
								</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-1">
								<label for="filter<?php echo $i; ?>-icon" data-toggle="tooltip" data-placement="top" title="Places filter menu icon">Icon</label>
								<button id="filter<?php echo $i; ?>-name-picker" class="btn btn-default"></button>
								<script>
								$("#filter<?php echo $i; ?>-name-picker").iconpicker({ icon: "<?php echo isset( $_POST[ 'filter'. $i . '-icon' ] ) && $_POST[ 'filter'. $i . '-icon' ] ? $_POST[ 'filter'. $i . '-icon' ]  : ''; ?>", iconset: "mapicon", cols: 10, rows: 6 }).on("change", function(e) {
									$("#filter<?php echo $i; ?>-icon").val(e.icon);
								});								
								</script>
								<input type="hidden" id="filter<?php echo $i; ?>-icon" name="filter<?php echo $i; ?>-icon" value="<?php echo isset( $_POST[ 'filter'. $i . '-icon' ] ) && $_POST[ 'filter'. $i . '-icon' ] ? $_POST[ 'filter'. $i . '-icon' ]  : ''; ?>" />
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
								<label for="filter<?php echo $i; ?>-source" data-toggle="tooltip" data-placement="top" title="Source of the places database. Default is Google Places Library, but you can use a custom JOSN file.">Source</label>
								<select id="filter<?php echo $i; ?>-source"  name="filter<?php echo $i; ?>-source" class="form-control">
									<option value="google" <?php echo isset( $_POST[ 'filter'. $i . '-source' ] ) && $_POST[ 'filter'. $i . '-source' ] == 'google' ? 'selected' : ''; ?>>Google Places</option>
									<option value="json" <?php echo isset( $_POST[ 'filter'. $i . '-source' ] ) && $_POST[ 'filter'. $i . '-source' ] == 'json'  ? 'selected' : ''; ?>>JSON File</option>
								</select>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">	
								<div class="form-group" id="filter<?php echo $i; ?>-types-div">
									<label for="filter<?php echo $i; ?>-types" data-toggle="tooltip" data-placement="top" title="Choose places categories for this link (you can choose more than one).">Filter Types</label>
									<select id="filter<?php echo $i; ?>-types" name="filter<?php echo $i; ?>-types[]" placeholder="Start Types" multiple>
										<option value="accounting" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'accounting', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> accounting</option>
										<option value="airport" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'airport', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> airport</option>
										<option value="amusement_park" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'amusement_park', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> amusement park</option>
										<option value="aquarium" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'aquarium', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> aquarium</option>
										<option value="art_gallery" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'art_gallery', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> art gallery</option>
										<option value="atm" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'atm', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> atm</option>
										<option value="bakery" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'bakery', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> bakery</option>
										<option value="bank" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'bank', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> bank</option>
										<option value="bar" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'bar', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> bar</option>
										<option value="beauty_salon" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'beauty_salon', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> beauty salon</option>
										<option value="bicycle_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'bicycle_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> bicycle store</option>
										<option value="book_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'book_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> book store</option>
										<option value="bowling_alley" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'bowling_alley', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> bowling alley</option>
										<option value="bus_station" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'bus_station', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> bus station</option>
										<option value="cafe" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'cafe', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> cafe</option>
										<option value="campground" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'campground', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> campground</option>
										<option value="car_dealer" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'car_dealer', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> car dealer</option>
										<option value="car_rental" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'car_rental', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> car rental</option>
										<option value="car_repair" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'car_repair', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> car repair</option>
										<option value="car_wash" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'car_wash', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> car wash</option>
										<option value="casino" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'casino', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> casino</option>
										<option value="cemetery" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'cemetery', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> cemetery</option>
										<option value="church" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'church', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> church</option>
										<option value="city_hall" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'city_hall', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> city hall</option>
										<option value="clothing_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'clothing_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> clothing store</option>
										<option value="convenience_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'convenience_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> convenience store</option>
										<option value="courthouse" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'courthouse', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> courthouse</option>
										<option value="dentist" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'dentist', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> dentist</option>
										<option value="department_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'department_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> department store</option>
										<option value="doctor" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'doctor', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> doctor</option>
										<option value="electrician" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'electrician', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> electrician</option>
										<option value="electronics_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'electronics_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> electronics store</option>
										<option value="embassy" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'embassy', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> embassy</option>
										<option value="fire_station" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'fire_station', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> fire station</option>
										<option value="florist" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'florist', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> florist</option>
										<option value="funeral_home" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'funeral_home', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> funeral home</option>
										<option value="furniture_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'furniture_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> furniture store</option>
										<option value="gas_station" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'gas_station', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> gas station</option>
										<option value="gym" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'gym', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> gym</option>
										<option value="hair_care" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'hair_care', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> hair care</option>
										<option value="hardware_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'hardware_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> hardware store</option>
										<option value="hindu_temple" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'hindu_temple', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> hindu temple</option>
										<option value="home_goods_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'home_goods_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> home goods store</option>
										<option value="hospital" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'hospital', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> hospital</option>
										<option value="insurance_agency" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'insurance_agency', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> insurance agency</option>
										<option value="jewelry_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'jewelry_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> jewelry store</option>
										<option value="laundry" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'laundry', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> laundry</option>
										<option value="lawyer" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'lawyer', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> lawyer</option>
										<option value="library" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'library', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> library</option>
										<option value="liquor_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'liquor_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> liquor store</option>
										<option value="local_government_office" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'local_government_office', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> local government office</option>
										<option value="locksmith" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'locksmith', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> locksmith</option>
										<option value="lodging" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'lodging', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> lodging</option>
										<option value="meal_delivery" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'meal_delivery', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> meal delivery</option>
										<option value="meal_takeaway" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'meal_takeaway', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> meal takeaway</option>
										<option value="mosque" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'mosque', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> mosque</option>
										<option value="movie_rental" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'movie_rental', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> movie rental</option>
										<option value="movie_theater" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'movie_theater', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> movie theater</option>
										<option value="moving_company" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'moving_company', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> moving company</option>
										<option value="museum" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'museum', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> museum</option>
										<option value="night_club" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'night_club', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> night club</option>
										<option value="painter" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'painter', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> painter</option>
										<option value="park" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'park', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> park</option>
										<option value="parking" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'parking', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> parking</option>
										<option value="pet_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'pet_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> pet store</option>
										<option value="pharmacy" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'pharmacy', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> pharmacy</option>
										<option value="physiotherapist" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'physiotherapist', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> physiotherapist</option>
										<option value="plumber" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'plumber', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> plumber</option>
										<option value="police" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'police', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> police</option>
										<option value="post_office" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'post_office', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> post office</option>
										<option value="real_estate_agency" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'real_estate_agency', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> real estate agency</option>
										<option value="restaurant" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'restaurant', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> restaurant</option>
										<option value="roofing_contractor" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'roofing_contractor', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> roofing contractor</option>
										<option value="rv_park" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'rv_park', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> rv park</option>
										<option value="school" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'school', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> school</option>
										<option value="shoe_store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'shoe_store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> shoe store</option>
										<option value="shopping_mall" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'shopping_mall', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> shopping mall</option>
										<option value="spa" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'spa', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> spa</option>
										<option value="stadium" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'stadium', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> stadium</option>
										<option value="storage" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'storage', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> storage</option>
										<option value="store" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'store', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> store</option>
										<option value="subway_station" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'subway_station', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> subway station</option>
										<option value="synagogue" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'synagogue', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> synagogue</option>
										<option value="taxi_stand" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'taxi_stand', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> taxi stand</option>
										<option value="train_station" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'train_station', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> train station</option>
										<option value="transit_station" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'transit_station', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> transit station</option>
										<option value="travel_agency" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'travel_agency', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> travel agency</option>
										<option value="university" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'university', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> university</option>
										<option value="veterinary_care" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'veterinary_care', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> veterinary care</option>
										<option value="zoo" <?php echo isset( $_POST[ 'filter'. $i . '-types' ] ) && in_array( 'zoo', $_POST[ 'filter'. $i . '-types' ] ) ? 'selected' : ''; ?>> zoo</option>
									
									</select>
									<script>
									$(function() {
										$("#filter<?php echo $i; ?>-types").multipleSelect({width: "100%"});
									});
									</script>
								</div>
								<div class="form-group" id="filter<?php echo $i; ?>-json-div">
									<label for="filter<?php echo $i; ?>-json" data-toggle="tooltip" data-placement="top" title="Add comma-separated categories from JSON file.">JSON categories</label><input id="filter<?php echo $i; ?>-json" type="text" value="<?php echo isset( $_POST[ 'filter'. $i . '-json' ] ) && $_POST[ 'filter'. $i . '-json' ] ? $_POST[ 'filter'. $i . '-json' ]  : ''; ?>" name="filter<?php echo $i; ?>-json" class="form-control" />
								</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
								<label for="filter<?php echo $i; ?>-icon-type" data-toggle="tooltip" data-placement="top" title="Script uses automatic marker icons for places, but you can override it with your own.">Marker</label>
								<select id="filter<?php echo $i; ?>-icon-type"  name="filter<?php echo $i; ?>-icon-type" class="form-control">
									<option value="automatic" <?php echo isset( $_POST[ 'filter'. $i . '-icon-type' ] ) && $_POST[ 'filter'. $i . '-icon-type' ] == 'automatic' ? 'selected' : ''; ?>>automatic</option>
									<option value="image" <?php echo isset( $_POST[ 'filter'. $i . '-icon-type' ] ) && $_POST[ 'filter'. $i . '-icon-type' ] == 'image'  ? 'selected' : ''; ?>>image</option>
									<option value="font" <?php echo isset( $_POST[ 'filter'. $i . '-icon-type' ] ) && $_POST[ 'filter'. $i . '-icon-type' ] == 'font' ? 'selected' : ''; ?>>font-icon</option>
								</select>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
								<div class="form-group" id="filter<?php echo $i; ?>-image-icon-div">
									<label for="filter<?php echo $i; ?>-image-icon" data-toggle="tooltip" data-placement="top" title="Enter marker image URL or path.">Marker Image</label><input id="filter<?php echo $i; ?>-image-icon" type="text" value="<?php echo isset( $_POST[ 'filter'. $i . '-image-icon' ] ) && $_POST[ 'filter'. $i . '-image-icon' ] ? $_POST[ 'filter'. $i . '-image-icon' ]  : ''; ?>" name="filter<?php echo $i; ?>-image-icon" class="form-control" />
								</div>
								<div class="form-group" id="filter<?php echo $i; ?>-image-font-div">
									<label for="filter<?php echo $i; ?>-font-icon" data-toggle="tooltip" data-placement="top" title="Enter MapIcon font here. You can browse icons here: http://map-icons.com/">Marker Font Icon</label>
									<button id="filter<?php echo $i; ?>-font-picker" class="btn btn-default"></button>
								<script>
								$("#filter<?php echo $i; ?>-font-picker").iconpicker({ icon: "<?php echo isset( $_POST[ 'filter'. $i . '-font-icon' ] ) && $_POST[ 'filter'. $i . '-font-icon' ] ? $_POST[ 'filter'. $i . '-font-icon' ]  : ''; ?>", iconset: "mapicon", cols: 10, rows: 6 }).on("change", function(e) {
									$("#filter<?php echo $i; ?>-font-icon").val(e.icon);
								});								
								</script>
								<input type="hidden" id="filter<?php echo $i; ?>-font-icon" name="filter<?php echo $i; ?>-font-icon" value="<?php echo isset( $_POST[ 'filter'. $i . '-font-icon' ] ) && $_POST[ 'filter'. $i . '-font-icon' ] ? $_POST[ 'filter'. $i . '-font-icon' ]  : ''; ?>" />
								</div>	
						</div>		
					</div>
			<?php			
			}
			?>
		</div>
		<div class="container">
			<div class="row">				
				<div class="col-xs-12">
					<button id="add-filter" class="btn btn-success pull-right" style="margin-top: 15px;" data-i="<?php echo $j; ?>">Add Filter</button>
				</div>	
			</div>
		</div>
		
		<div class="container">
			<div class="row">		
				<div class="col-xs-12"><hr/><h3 style="margin-bottom: 50px;">c) Adjust settings</h3></div>			
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<div class="form-group">
						<p class="help-block" data-toggle="tooltip" data-placement="top" title="Enter latitiude and longitiude of the map center point. Alternatively you can add an address below.">Enter center point position:</p>
						<label for="lat">Center Point Lat</label><input id="lat" type="text" value="<?php echo isset( $_POST[ 'lat' ] ) && $_POST[ 'lat' ] ?  $_POST[ 'lat' ] : ''; ?>" name="lat"  class="form-control" />
					</div>
					<div class="form-group">
						<label for="lng">Center Point Lng</label><input id="lng" type="text" value="<?php echo isset( $_POST[ 'lng' ] ) && $_POST[ 'lng' ] ?  $_POST[ 'lng' ] : ''; ?>" name="lng"  class="form-control" />
					</div>
					<div class="form-group">
						<p class="help-block">Or address (street & city):</p>
						<label for="address">Address</label><input id="address" type="text" value="<?php echo isset( $_POST[ 'address' ] ) && $_POST[ 'address' ] ?  $_POST[ 'address' ] : ''; ?>" name="address"  class="form-control" />
					</div>
					
					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Radius of the Nearby Places search in meters. High radius can make your free API calls to end quicker.">
						<label for="radius">Radius</label><input id="radius" type="text" value="1500" name="radius" class="form-control" />
					</div>
					<div class="form-group">
						<label for="zoom">Starting Map Zoom</label>
						<select id="zoom" name="zoom" class="form-control" placeholder="Starting Map Zoom">
							<option value="12" <?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] == '12' ? 'selected' : ''; ?>>12</option>
							<option value="13" <?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] == '13' ? 'selected' : ''; ?>>13</option>
							<option value="14" <?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] == '14' ? 'selected' : ''; ?>>14</option>
							<option value="15" <?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] == '15' ? 'selected' : ''; ?>>15</option>
							<option value="16" <?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] == '16' ? 'selected' : ''; ?>>16</option>
						</select>
					</div>
					
					<div class="checkbox">
						<label for="wheelScroll" data-toggle="tooltip" data-placement="top" title="Check to enable map zooming using mose scroll whell"><input id="wheelScroll" type="checkbox" value="true" name="wheelScroll" <?php echo isset( $_POST[ 'wheelScroll' ] ) && $_POST[ 'wheelScroll' ] === 'true' ? 'checked' : ''; ?> /> Mouse Whell Zooming</label>
					</div>
				</div>				
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
					
					<p class="help-block" data-toggle="tooltip" data-placement="top" title="Choose what will be visible after the map loads. It can be single marker on the enter, nearby places of selected types or both.">Show on map start:</p>
						
					<div class="radio-inline">
						<input class="start" type="radio" name="start" value="point" <?php echo isset( $_POST[ 'start' ] ) && $_POST[ 'start' ] == 'point' ? 'checked' : ''; ?> /><label for="center">point</label>
					</div>
					<div class="radio-inline">
						<input class="start" type="radio" name="start" value="type" <?php echo isset( $_POST[ 'start' ] ) && $_POST[ 'start' ] == 'type' ? 'checked' : ''; ?> /><label for="center">type</label>
					</div>
					<div class="radio-inline">
						<input class="start" type="radio" name="start" value="both" <?php echo isset( $_POST[ 'start' ] ) && $_POST[ 'start' ] == 'both' ? 'checked' : ''; ?> /><label for="center">both</label>
					</div>
					
					<div class="form-group" style="margin-top: 15px;" data-toggle="tooltip" data-placement="top" title='If you chose "type" or "both" above, you can choose what type of nearby plces will be visible.'>
						<label for="startTypes">Starting Types</label>
						<select id="startTypes" name="startTypes[]" class="" placeholder="Start Types" multiple>
							<option value="accounting" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'accounting', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> accounting</option>
							<option value="airport" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'airport', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> airport</option>
							<option value="amusement_park" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'amusement_park', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> amusement park</option>
							<option value="aquarium" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'aquarium', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> aquarium</option>
							<option value="art_gallery" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'art_gallery', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> art gallery</option>
							<option value="atm" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'atm', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> atm</option>
							<option value="bakery" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'bakery', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> bakery</option>
							<option value="bank" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'bank', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> bank</option>
							<option value="bar" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'bar', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> bar</option>
							<option value="beauty_salon" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'beauty_salon', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> beauty salon</option>
							<option value="bicycle_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'bicycle_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> bicycle store</option>
							<option value="book_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'book_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> book store</option>
							<option value="bowling_alley" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'bowling_alley', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> bowling alley</option>
							<option value="bus_station" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'bus_station', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> bus station</option>
							<option value="cafe" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'cafe', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> cafe</option>
							<option value="campground" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'campground', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> campground</option>
							<option value="car_dealer" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'car_dealer', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> car dealer</option>
							<option value="car_rental" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'car_rental', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> car rental</option>
							<option value="car_repair" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'car_repair', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> car repair</option>
							<option value="car_wash" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'car_wash', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> car wash</option>
							<option value="casino" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'casino', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> casino</option>
							<option value="cemetery" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'cemetery', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> cemetery</option>
							<option value="church" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'church', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> church</option>
							<option value="city_hall" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'city_hall', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> city hall</option>
							<option value="clothing_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'clothing_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> clothing store</option>
							<option value="convenience_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'convenience_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> convenience store</option>
							<option value="courthouse" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'courthouse', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> courthouse</option>
							<option value="dentist" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'dentist', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> dentist</option>
							<option value="department_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'department_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> department store</option>
							<option value="doctor" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'doctor', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> doctor</option>
							<option value="electrician" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'electrician', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> electrician</option>
							<option value="electronics_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'electronics_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> electronics store</option>
							<option value="embassy" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'embassy', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> embassy</option>
							<option value="fire_station" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'fire_station', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> fire station</option>
							<option value="florist" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'florist', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> florist</option>
							<option value="funeral_home" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'funeral_home', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> funeral home</option>
							<option value="furniture_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'furniture_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> furniture store</option>
							<option value="gas_station" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'gas_station', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> gas station</option>
							<option value="gym" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'gym', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> gym</option>
							<option value="hair_care" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'hair_care', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> hair care</option>
							<option value="hardware_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'hardware_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> hardware store</option>
							<option value="hindu_temple" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'hindu_temple', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> hindu temple</option>
							<option value="home_goods_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'home_goods_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> home goods store</option>
							<option value="hospital" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'hospital', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> hospital</option>
							<option value="insurance_agency" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'insurance_agency', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> insurance agency</option>
							<option value="jewelry_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'jewelry_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> jewelry store</option>
							<option value="laundry" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'laundry', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> laundry</option>
							<option value="lawyer" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'lawyer', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> lawyer</option>
							<option value="library" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'library', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> library</option>
							<option value="liquor_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'liquor_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> liquor store</option>
							<option value="local_government_office" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'local_government_office', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> local government office</option>
							<option value="locksmith" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'locksmith', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> locksmith</option>
							<option value="lodging" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'lodging', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> lodging</option>
							<option value="meal_delivery" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'meal_delivery', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> meal delivery</option>
							<option value="meal_takeaway" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'meal_takeaway', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> meal takeaway</option>
							<option value="mosque" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'mosque', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> mosque</option>
							<option value="movie_rental" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'movie_rental', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> movie rental</option>
							<option value="movie_theater" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'movie_theater', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> movie theater</option>
							<option value="moving_company" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'moving_company', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> moving company</option>
							<option value="museum" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'museum', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> museum</option>
							<option value="night_club" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'night_club', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> night club</option>
							<option value="painter" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'painter', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> painter</option>
							<option value="park" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'park', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> park</option>
							<option value="parking" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'parking', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> parking</option>
							<option value="pet_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'pet_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> pet store</option>
							<option value="pharmacy" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'pharmacy', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> pharmacy</option>
							<option value="physiotherapist" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'physiotherapist', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> physiotherapist</option>
							<option value="plumber" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'plumber', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> plumber</option>
							<option value="police" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'police', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> police</option>
							<option value="post_office" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'post_office', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> post office</option>
							<option value="real_estate_agency" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'real_estate_agency', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> real estate agency</option>
							<option value="restaurant" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'restaurant', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> restaurant</option>
							<option value="roofing_contractor" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'roofing_contractor', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> roofing contractor</option>
							<option value="rv_park" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'rv_park', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> rv park</option>
							<option value="school" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'school', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> school</option>
							<option value="shoe_store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'shoe_store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> shoe store</option>
							<option value="shopping_mall" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'shopping_mall', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> shopping mall</option>
							<option value="spa" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'spa', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> spa</option>
							<option value="stadium" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'stadium', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> stadium</option>
							<option value="storage" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'storage', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> storage</option>
							<option value="store" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'store', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> store</option>
							<option value="subway_station" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'subway_station', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> subway station</option>
							<option value="synagogue" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'synagogue', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> synagogue</option>
							<option value="taxi_stand" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'taxi_stand', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> taxi stand</option>
							<option value="train_station" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'train_station', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> train station</option>
							<option value="transit_station" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'transit_station', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> transit station</option>
							<option value="travel_agency" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'travel_agency', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> travel agency</option>
							<option value="university" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'university', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> university</option>
							<option value="veterinary_care" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'veterinary_care', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> veterinary care</option>
							<option value="zoo" <?php echo isset( $_POST[ 'startTypes' ] ) && in_array( 'zoo', $_POST[ 'startTypes' ] ) ? 'selected' : ''; ?>> zoo</option>
						</select>
					</div>
					<div class="form-group" data-toggle="tooltip" data-placement="top" title='Enter url or src of the icon that will be used for center point (if you chose "point" or "both" above)'>
						<label for="startPointIcon">Start Point Icon</label><input id="startPointIcon" type="text" value="<?php echo isset( $_POST[ 'startPointIcon' ] ) && $_POST[ 'startPointIcon' ] ?  $_POST[ 'startPointIcon' ] : ''; ?>" name="startPointIcon"  class="form-control" />
					</div>
					
					<div class="form-group" data-toggle="tooltip" data-placement="top" title='Enter url or src of the icon that will be used for starting types (if you chose "type" or "both" above)'>
						<label for="startTypesIcon">Start Types Icon</label><input id="startTypesIcon" type="text" value="<?php echo isset( $_POST[ 'startTypesIcon' ] ) && $_POST[ 'startTypesIcon' ] ?  $_POST[ 'startTypesIcon' ] : ''; ?>" name="startTypesIcon"  class="form-control" />
					</div>
					
					<p class="help-block" data-toggle="tooltip" data-placement="top" title="Allow to select multiple filters at the time (doen't work with markers from JSON file)">Allow to select multiple filters:</p>
					
					<div class="checkbox">
						<label for="multiple"><input id="multiple" type="checkbox" value="true" name="multiple" <?php echo isset( $_POST[ 'multiple' ] ) && $_POST[ 'multiple' ] === 'true' ? 'checked' : ''; ?> /> Multiple</label>
					</div>
					
					<p class="help-block" data-toggle="tooltip" data-placement="top" title="Choose which elemwents will be visible on map">Choose map blocks:</p>
					
					
					<div class="checkbox">
						<label for="streetView"><input id="streetView" type="checkbox" value="true" name="streetView" <?php echo isset( $_POST[ 'streetView' ] ) && $_POST[ 'streetView' ] === 'true' ? 'checked' : ''; ?> /> Street View</label>
					</div>
					<div class="checkbox">
						<label for="autocomplete"><input id="autocomplete" type="checkbox" value="true" name="autocomplete" <?php echo isset( $_POST[ 'autocomplete' ] ) && $_POST[ 'autocomplete' ] === 'true' ? 'checked' : ''; ?> /> Autocomplete</label>
					</div>
					
					<div class="checkbox">
						<label for="userLocation"><input id="userLocation" type="checkbox" value="true" name="userLocation" <?php echo isset( $_POST[ 'userLocation' ] ) && $_POST[ 'userLocation' ] === 'true' ? 'checked' : ''; ?> /> User Location</label>
					</div>
					
					<div class="checkbox">
						<label for="routeMode"><input id="routeMode" type="checkbox" value="true" name="routeMode" <?php echo isset( $_POST[ 'routeMode' ] ) && $_POST[ 'routeMode' ] === 'true' ? 'checked' : ''; ?> /> Route Mode</label>
					</div>
					
					<div class="checkbox">
						<label for="placesList"><input id="placesList" type="checkbox" value="true" name="placesList" <?php echo isset( $_POST[ 'placesList' ] ) && $_POST[ 'placesList' ] === 'true' ? 'checked' : ''; ?> /> Places List</label>
					</div>
					
					<div class="checkbox">
						<label for="placeDetails"><input id="placeDetails" type="checkbox" value="true" name="placeDetails" <?php echo isset( $_POST[ 'placeDetails' ] ) && $_POST[ 'placeDetails' ] === 'true' ? 'checked' : ''; ?> /> Place Details</label>
					</div>
					
					<div class="checkbox">
						<label for="routeTime"><input id="routeTime" type="checkbox" value="true" name="routeTime" <?php echo isset( $_POST[ 'routeTime' ] ) && $_POST[ 'routeTime' ] === 'true' ? 'checked' : ''; ?> /> Route Time</label>
					</div>
					
					<div class="checkbox">
						<label for="route"><input id="route" type="checkbox" value="true" name="route" <?php echo isset( $_POST[ 'route' ] ) && $_POST[ 'route' ] === 'true' ? 'checked' : ''; ?> /> Route</label>
					</div>
				</div>				
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				
					<div class="form-group">
						<label for="zoom">Icon Size</label>
						<select id="iconSize" name="iconSize" class="form-control" placeholder="Icon Size">
							<option value="large" <?php echo isset( $_POST[ 'iconSize' ] ) && $_POST[ 'iconSize' ] === 'large' ? 'selected' : ''; ?>>large</option>
							<option value="medium" <?php echo isset( $_POST[ 'iconSize' ] ) && $_POST[ 'iconSize' ] === 'medium' ? 'selected' : ''; ?>>medium</option>
							<option value="small" <?php echo isset( $_POST[ 'iconSize' ] ) && $_POST[ 'iconSize' ] === 'small' ? 'selected' : ''; ?>>small</option>
						</select>
					</div>
					<div class="form-group">
						<label for="zoom">Icon Color</label>
						<select id="iconColor" name="iconColor" class="form-control" placeholder="Icon Color">
							<option value="turquoise" style="background: #28beca; color: #fff;"<?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'turquoise' ? 'selected' : ''; ?>>turquoise</option>
							<option value="blue" style="background: #1091dd; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'blue' ? 'selected' : ''; ?>>blue</option>
							<option value="green" style="background: #5bb52b; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'green' ? 'selected' : ''; ?>>green</option>
							<option value="red" style="background: #e04930; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'red' ? 'selected' : ''; ?>>red</option>
							<option value="purple" style="background: #633378; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'purple' ? 'selected' : ''; ?>>purple</option>
							<option value="yellow" style="background: #edc525;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'yellow' ? 'selected' : ''; ?>>yellow</option>
							<option value="pink" style="background: #ff4b7e; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'pink' ? 'selected' : ''; ?>>pink</option>
							<option value="gold" style="background: #b9a05b; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'gold' ? 'selected' : ''; ?>>gold</option>
							<option value="grey" style="background: #545454; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'grey' ? 'selected' : ''; ?>>grey</option>
							<option value="navy" style="background: #2854a1; color: #fff;" <?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] === 'navy' ? 'selected' : ''; ?>>navy</option>
						</select>
					</div>
					<div class="form-group">
						
						<label for="iconType">Icon Type</label><br/>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin1" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin1' ? 'checked' : ''; ?> />
							<img id="pin1" src="../src/icons/icon-pin1-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin2" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin2' ? 'checked' : ''; ?> />
							<img id="pin2" src="../src/icons/icon-pin2-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin3" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin3' ? 'checked' : ''; ?> />
							<img id="pin3" src="../src/icons/icon-pin3-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin4" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin4' ? 'checked' : ''; ?> />
							<img id="pin4" src="../src/icons/icon-pin4-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin5" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin5' ? 'checked' : ''; ?> />
							<img id="pin5" src="../src/icons/icon-pin5-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin6" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin6' ? 'checked' : ''; ?> />
							<img id="pin6" src="../src/icons/icon-pin6-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin7" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin7' ? 'checked' : ''; ?> />
							<img id="pin7" src="../src/icons/icon-pin7-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin8" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin8' ? 'checked' : ''; ?> />
							<img id="pin8" src="../src/icons/icon-pin8-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin9" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin9' ? 'checked' : ''; ?> />
							<img id="pin9" src="../src/icons/icon-pin9-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin10" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin10' ? 'checked' : ''; ?> />
							<img id="pin10" src="../src/icons/icon-pin10-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin11" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin11' ? 'checked' : ''; ?> />
							<img id="pin11" src="../src/icons/icon-pin11-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin12" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin12' ? 'checked' : ''; ?> />
							<img id="pin12" src="../src/icons/icon-pin12-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin13" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin13' ? 'checked' : ''; ?> />
							<img id="pin13" src="../src/icons/icon-pin13-turquoise.png" />
						</label>
						<label>
							<input class="skin" type="radio" name="iconType" value="pin14" <?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] == 'pin14' ? 'checked' : ''; ?> />
							<img id="pin14" src="../src/icons/icon-pin14-turquoise.png" />
						</label>
					</div>
					<div class="clearfix"></div>
					
					
				</div>	
				
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">	
					
					<p class="help-block" data-toggle="tooltip" data-placement="top" title="Marker Clustering combine markers of close proximity into clusters, and simplify the display of markers on the map">Turn on Marker Clustering:</p>
					
					<div class="checkbox">
						<label for="cluster"><input id="cluster" type="checkbox" value="true" name="cluster" <?php echo isset( $_POST[ 'cluster' ] ) && $_POST[ 'cluster' ] === 'true' ? 'checked' : ''; ?>  /> Markers Clustering</label>
					</div>
					
					<div class="form-group">
						<label for="zoom" data-toggle="tooltip" data-placement="top" title="Choose an icon that will be used by Marker Clustering or leave empty for default.">Cluster Icon</label><input id="clusterIcon" type="text" value="<?php echo isset( $_POST[ 'clusterIcon' ] ) && $_POST[ 'clusterIcon' ] ?  $_POST[ 'clusterIcon' ] : ''; ?>" name="clusterIcon"  class="form-control" />
					</div>
					
					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Add an url to the JSON file. Please check the docuemtation to find how this file should be formatted.">
						<label for="jsonFile">JOSN File</label><input id="jsonFile" type="text" value="<?php echo isset( $_POST[ 'jsonFile' ] ) && $_POST[ 'jsonFile' ] ?  $_POST[ 'jsonFile' ] : ''; ?>" name="jsonFile"  class="form-control" />
					</div>
					
					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Add an url to the valid KML file.">
						<label for="kmlFile">KML File</label><input id="kmlFile" type="text" value="<?php echo isset( $_POST[ 'kmlFile' ] ) && $_POST[ 'kmlFile' ] ?  $_POST[ 'kmlFile' ] : ''; ?>" name="kmlFile"  class="form-control" />
					</div>
					
					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Add an url to the valid geoJOSN file.">
						<label for="geoJOSNFile">GeoJOSN File</label><input id="geoJOSNFile" type="text" value="<?php echo isset( $_POST[ 'geoJOSNFile' ] ) && $_POST[ 'geoJOSNFile' ] ?  $_POST[ 'geoJOSNFile' ] : ''; ?>" name="geoJOSNFile"  class="form-control" />
					</div>
					
					
					<label for="mapStyle" data-toggle="tooltip" data-placement="top" title="You can style the map. Snazzy Map offers many free map styles.">Map Style</label><textarea id="mapStyle" name="mapStyle" class="form-control" rows="3"><?php echo isset( $_POST[ 'mapStyle' ] ) && $_POST[ 'mapStyle' ] ?  $_POST[ 'mapStyle' ] : ''; ?></textarea>
					<p class="help-block">You can find some Google Maps styles on <a href="https://snazzymaps.com/" target="blank">snazzymaps.com</a></p>
					
				</div>
				
				
				<div class="container">
					<div class="row">		
						<div class="col-xs-12"><hr/><h3 style="margin-bottom: 50px;">d) Save Changes</h3></div>			
						<div class="col-xs-12"><input type="submit" id="save" class="btn btn-primary" value="Save & Preview" /></div>
					</div>
				</div>	
					
					
				</div>				
			</div>
		</div>
		</form>
		
		<div class="container">
					<div class="row">		
						<div class="col-xs-12"><hr/><h3 style="margin-bottom: 50px; margin-top: 50px;">e) Preview</h3></div>								
					</div>
				</div>	
		</section>
		
		<div id="builder-cont" style="padding: 20px; margin-bottom: 10px; background: #efefef;">
		
			<section class="apoi-section">
				<!-- MARKUP -->
				
				<!-- FILTERS --->
				<div class="apoi-filter-container">
				
				<?php
					for( $i = 1; $i < $j; $i ++ ) {
					$types = '';
					if( isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-source' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-source' ] == 'json' ) {
						$types = $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-json' ];
					} elseif( isset($_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-types' ]) ) {
						$types = implode( ',', $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-types' ] ); 
					}
				?>
					<div class="apoi-filter" data-types="<?php echo $types ?>"
					
						<?php echo isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-source' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-source' ] == 'json' ? ' data-source="json"' : ''; ?>
						<?php echo isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-icon-type' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-icon-type' ] == 'image' && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-image-icon' ] ? ' data-icon-img="' . $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-image-icon' ] . '"' : ''; ?>
						<?php echo isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-icon-type' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-icon-type' ] == 'font' && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-font-icon' ] ? ' data-icon-font="' . $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-font-icon' ] . '"' : ''; ?>
					>
						<span class="apoi-map-icon <?php echo $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-icon' ];?>"></span>
						<?php echo $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-name' ];?>
					</div>
				
				<?php
					}
				?>
				</div>
				
				<!-- PLACES LIST CONTAINER -->
				<div id="apoi-list"></div>
				
				<!-- PLACE DETAILS CONTAINER -->
				<div id="apoi-details-container"></div>
				
				<!-- AUTOCOMPLETE INPUT -->
				<div class="apoi-autocomplete-container">
					<input id="apoi-autocomplete" type="text" placeholder="Enter a location" />
					<a href="#" id="apoi-geolocation"><span class="apoi-map-icon map-icon-crosshairs"></span></a>
				</div>
				
				<!-- TRANSPORT MODE -->
				<div class="apoi-transport-modes">
					<input id="apoi-driving" type="radio" name="apoi-mode" value="DRIVING" checked /><label for="apoi-driving"><span class="apoi-map-icon map-icon-taxi-stand"></span></label>
					<input id="apoi-bicycling" type="radio" name="apoi-mode" value="BICYCLING" /><label for="apoi-bicycling"><span class="apoi-map-icon map-icon-bicycling"></span></label> 
					<input id="apoi-transit" type="radio" name="apoi-mode" value="TRANSIT" /><label for="apoi-transit"><span class="apoi-map-icon map-icon-bus-station"></span></label>
					<input id="apoi-walking" type="radio" name="apoi-mode" value="WALKING" /><label for="apoi-walking"><span class="apoi-map-icon map-icon-walking"></span></label>
				</div>
				
				<!-- MAP / STREET VIEW SWITCH -->
				<a href="#" id="apoi-switch-street"><span class="apoi-map-icon map-icon-male"></span></a>  
				<a href="#" id="apoi-switch-map"><span class="apoi-map-icon map-icon-map-pin"></span></a>			
				
				<!-- ROUTE TIME -->
				<div id="apoi-route-time"></div>
				
				<!-- MAP CONTAINER -->
				<div id="apoi-maps-container"></div>
				
				
		
			</section>
		</div>
		<div class="container">
					<div class="row">		
						<div class="col-xs-12"><hr/><h3 style="margin-bottom: 50px; margin-top: 50px;">f) Copy the code</h3></div>								
					</div>
				</div>	
	<div class="container">
			<div class="row">		

				<div class="col-xs-12">	
				<h4>Add to &lt;head> tag</h4>
		<pre id="code" style="width: 100%; height: 200px;" class="prettyprint lang-html">
&lt;link href="../src/awesomePOI.css" media="all" rel="stylesheet" type="text/css" />
&lt;link id="poiskin" href="../src/skin<?php echo $_POST[ 'fb' ]; ?>.css" media="all" rel="stylesheet" type="text/css" />
&lt;script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>		
		</pre>
	</div>
			
				<div class="col-xs-12">	
		<h4>Add to &lt;body> tag</h4>
		<pre id="code" style="width: 100%; height: 200px;" class="prettyprint lang-html">
&lt;section class="apoi-section">
&lt;!-- MARKUP -->
				
&lt;!-- FILTERS --->
	&lt;div class="apoi-filter-container">
<?php
for( $i = 1; $i < $j; $i ++ ) {
	$types = '';
	if( isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-source' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-source' ] == 'json' ) {
		$types = $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-json' ];
	} elseif( isset($_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-types' ]) ) {
		$types = implode( ',', $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-types' ] ); 
	}
?>
		&lt;div class="apoi-filter" data-types="<?php echo $types ?>"<?php echo isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-source' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-source' ] == 'json' ? ' data-source="json"' : ''; ?><?php echo isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-icon-type' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-icon-type' ] == 'image' && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-image-icon' ] ? ' data-icon-img="' . $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-image-icon' ] . '"' : ''; ?><?php echo isset( $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1  ] . '-icon-type' ] ) && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-icon-type' ] == 'font' && $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-font-icon' ] ? ' data-icon-font="' . $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-font-icon' ] . '"' : ''; ?>>&lt;span class="apoi-map-icon <?php echo $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-icon' ];?>">&lt;/span><?php echo $_POST[ 'filter' . $_POST[ 'filter-size' ][ $i-1 ] . '-name' ];?>&lt;/div>
<?php
}
?>
	&lt;/div>
				
	&lt;!-- PLACES LIST CONTAINER -->
	&lt;div id="apoi-list">&lt;/div>
				
	&lt;!-- PLACE DETAILS CONTAINER -->
	&lt;div id="apoi-details-container">&lt;/div>
				
	&lt;!-- AUTOCOMPLETE INPUT -->
	&lt;div class="apoi-autocomplete-container">
		&lt;input id="apoi-autocomplete" type="text" placeholder="Enter a location" />
		&lt;a href="#" id="apoi-geolocation">&lt;span class="apoi-map-icon map-icon-crosshairs">&lt;/span>&lt;/a>
	&lt;/div>
				
	&lt;!-- TRANSPORT MODE -->
	&lt;div class="apoi-transport-modes">
		&lt;input id="apoi-driving" type="radio" name="apoi-mode" value="DRIVING" checked />&lt;label for="apoi-driving">&lt;span class="apoi-map-icon map-icon-taxi-stand">&lt;/span>&lt;/label>
		&lt;input id="apoi-bicycling" type="radio" name="apoi-mode" value="BICYCLING" />&lt;label for="apoi-bicycling">&lt;span class="apoi-map-icon map-icon-bicycling">&lt;/span>&lt;/label> 
		&lt;input id="apoi-transit" type="radio" name="apoi-mode" value="TRANSIT" />&lt;label for="apoi-transit">&lt;span class="apoi-map-icon map-icon-bus-station">&lt;/span>&lt;/label>
		&lt;input id="apoi-walking" type="radio" name="apoi-mode" value="WALKING" />&lt;label for="apoi-walking">&lt;span class="apoi-map-icon map-icon-walking">&lt;/span>&lt;/label>
	&lt;/div>
				
	&lt;!-- MAP / STREET VIEW SWITCH -->
	&lt;a href="#" id="apoi-switch-street">&lt;span class="apoi-map-icon map-icon-male">&lt;/span>&lt;/a>  
	&lt;a href="#" id="apoi-switch-map">&lt;span class="apoi-map-icon map-icon-map-pin">&lt;/span>&lt;/a>			
				
	&lt;!-- ROUTE TIME -->
	&lt;div id="apoi-route-time">&lt;/div>
				
	&lt;!-- MAP CONTAINER -->
	&lt;div id="apoi-maps-container">&lt;/div>

&lt;/section>			
		
		</pre>		
		
	</div>
	<div class="col-xs-12">	
		<h4>Add just before &lt;/body> tag</h4>
		<pre id="code" style="width: 100%; height: 200px;" class="prettyprint lang-html">
&lt;script src="http://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&sensor=false&libraries=places"></script>  
&lt;script src="../src/jquery.awesomePOI.js"></script>
&lt;script>
	$( window ).load(function() {
		$('#apoi-maps-container').awesomePOI({
			<?php echo isset( $_POST[ 'start' ] ) && $_POST[ 'start' ] ? 'start: "'.  $_POST[ 'start' ] . '",' : ''; ?><?php echo isset( $_POST[ 'address' ] ) && $_POST[ 'address' ] ? 'address: "'.  $_POST[ 'address' ] . '",' : ''; ?><?php echo isset( $_POST[ 'lat' ] ) && isset( $_POST[ 'lng' ] ) &&  $_POST[ 'lat' ] && $_POST[ 'lng' ] ? 'pyrmont: {lat: '.  $_POST[ 'lat' ] . ', lng: '.  $_POST[ 'lng' ] . '},' : ''; ?><?php echo isset( $_POST[ 'radius' ] ) && $_POST[ 'radius' ] ? 'radius: "'.  $_POST[ 'radius' ] . '",' : ''; ?><?php echo isset( $_POST[ 'streetView' ] ) && $_POST[ 'streetView' ] == true ? 'streetView: true,' : 'streetView: false,'; ?><?php echo isset( $_POST[ 'autocomplete' ] ) && $_POST[ 'autocomplete' ] == true ? 'autocomplete: true,' : 'autocomplete: false,'; ?><?php echo isset( $_POST[ 'userLocation' ] ) && $_POST[ 'userLocation' ] == true ? 'userLocation: true,' : 'userLocation: false,'; ?><?php echo isset( $_POST[ 'routeMode' ] ) && $_POST[ 'routeMode' ] == true ? 'routeMode: true,' : 'routeMode: false,'; ?><?php echo isset( $_POST[ 'placesList' ] ) && $_POST[ 'placesList' ] == true ? 'placesList: true,' : 'placesList: false,'; ?><?php echo isset( $_POST[ 'placeDetails' ] ) && $_POST[ 'placeDetails' ] == true ? 'placeDetails: true,' : 'placeDetails: false,'; ?><?php echo isset( $_POST[ 'routeTime' ] ) && $_POST[ 'routeTime' ] == true ? 'routeTime: true,' : 'routeTime: false,'; ?><?php echo isset( $_POST[ 'route' ] ) && $_POST[ 'route' ] == true ? 'route: true,' : 'route: false,'; ?><?php echo isset( $_POST[ 'multiple' ] ) && $_POST[ 'multiple' ] == true ? 'multiple: true,' : 'multiple: false,'; ?><?php echo isset( $_POST[ 'iconSize' ] ) && $_POST[ 'iconSize' ] ? 'iconSize: "'.  $_POST[ 'iconSize' ] . '",' : ''; ?><?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] ? 'iconType: "'.  $_POST[ 'iconType' ] . '",' : ''; ?><?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] ? 'iconColor: "'.  $_POST[ 'iconColor' ] . '",' : ''; ?><?php echo isset( $_POST[ 'kmlFile' ] ) && $_POST[ 'kmlFile' ] ? 'kmlFile: "'.  $_POST[ 'kmlFile' ] . '",' : ''; ?><?php echo isset( $_POST[ 'geoJOSNFile' ] ) && $_POST[ 'geoJOSNFile' ] ? 'geoJOSNFile: "'.  $_POST[ 'geoJOSNFile' ] . '",' : ''; ?><?php echo isset( $_POST[ 'jsonFile' ] ) && $_POST[ 'jsonFile' ] ? 'jsonFile: "'.  $_POST[ 'jsonFile' ] . '",' : ''; ?><?php echo isset( $_POST[ 'startTypes' ] ) && is_array( $_POST[ 'startTypes' ] ) && sizeof($_POST[ 'startTypes' ]) > 0 ? 'startTypes: "'. implode( ',', $_POST[ 'startTypes' ] ) . '",' : ''; ?><?php echo isset( $_POST[ 'startPointIcon' ] ) && $_POST[ 'startPointIcon' ] ? 'startPointIcon: "'.  $_POST[ 'startPointIcon' ] . '",' : ''; ?><?php echo isset( $_POST[ 'startTypesIcon' ] ) && $_POST[ 'startTypesIcon' ] ? 'startTypesIcon: "'.  $_POST[ 'startTypesIcon' ] . '",' : ''; ?><?php echo isset( $_POST[ 'cluster' ] ) && $_POST[ 'cluster' ] == true ? 'cluster: true,' : 'cluster: false,'; ?><?php echo isset( $_POST[ 'clusterIcon' ] ) && $_POST[ 'clusterIcon' ] ? 'clusterIcon: "'.  $_POST[ 'clusterIcon' ] . '",' : ''; ?><?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] ? 'zoom: '.  $_POST[ 'zoom' ] . ',' : ''; ?><?php echo isset( $_POST[ 'wheelScroll' ] ) && $_POST[ 'wheelScroll' ] == true ? 'wheelScroll: true,' : 'wheelScroll: false,'; ?>
		});				
	});		
&lt;/script>		
		</pre>
	</div>
	</div>
	</div>
		
	<section class="footer">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					
					<p>&copy; Jan Skwara</b>
					
				</div>
			</div>
			
		</div>
	</section>
		
		
		<script src="../src/jquery.awesomePOI.js"></script>
		<script>
			$( window ).load(function() {
				$('#apoi-maps-container').awesomePOI({
					<?php echo isset( $_POST[ 'start' ] ) && $_POST[ 'start' ] ? 'start: "'.  $_POST[ 'start' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'address' ] ) && $_POST[ 'address' ] ? 'address: "'.  $_POST[ 'address' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'lat' ] ) && isset( $_POST[ 'lng' ] ) &&  $_POST[ 'lat' ] && $_POST[ 'lng' ] ? 'pyrmont: {lat: '.  $_POST[ 'lat' ] . ', lng: '.  $_POST[ 'lng' ] . '},' : ''; ?>
					<?php echo isset( $_POST[ 'radius' ] ) && $_POST[ 'radius' ] ? 'radius: "'.  $_POST[ 'radius' ] . '",' : ''; ?>					
					<?php echo isset( $_POST[ 'streetView' ] ) && $_POST[ 'streetView' ] == true ? 'streetView: true,' : 'streetView: false,'; ?>
					<?php echo isset( $_POST[ 'autocomplete' ] ) && $_POST[ 'autocomplete' ] == true ? 'autocomplete: true,' : 'autocomplete: false,'; ?>
					<?php echo isset( $_POST[ 'userLocation' ] ) && $_POST[ 'userLocation' ] == true ? 'userLocation: true,' : 'userLocation: false,'; ?>
					<?php echo isset( $_POST[ 'routeMode' ] ) && $_POST[ 'routeMode' ] == true ? 'routeMode: true,' : 'routeMode: false,'; ?>
					<?php echo isset( $_POST[ 'placesList' ] ) && $_POST[ 'placesList' ] == true ? 'placesList: true,' : 'placesList: false,'; ?>
					<?php echo isset( $_POST[ 'placeDetails' ] ) && $_POST[ 'placeDetails' ] == true ? 'placeDetails: true,' : 'placeDetails: false,'; ?>
					<?php echo isset( $_POST[ 'routeTime' ] ) && $_POST[ 'routeTime' ] == true ? 'routeTime: true,' : 'routeTime: false,'; ?>
					<?php echo isset( $_POST[ 'route' ] ) && $_POST[ 'route' ] == true ? 'route: true,' : 'route: false,'; ?>
					<?php echo isset( $_POST[ 'multiple' ] ) && $_POST[ 'multiple' ] == true ? 'multiple: true,' : 'multiple: false,'; ?>					
					<?php echo isset( $_POST[ 'iconSize' ] ) && $_POST[ 'iconSize' ] ? 'iconSize: "'.  $_POST[ 'iconSize' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'iconType' ] ) && $_POST[ 'iconType' ] ? 'iconType: "'.  $_POST[ 'iconType' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'iconColor' ] ) && $_POST[ 'iconColor' ] ? 'iconColor: "'.  $_POST[ 'iconColor' ] . '",' : ''; ?>					
					<?php echo isset( $_POST[ 'kmlFile' ] ) && $_POST[ 'kmlFile' ] ? 'kmlFile: "'.  $_POST[ 'kmlFile' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'geoJOSNFile' ] ) && $_POST[ 'geoJOSNFile' ] ? 'geoJOSNFile: "'.  $_POST[ 'geoJOSNFile' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'jsonFile' ] ) && $_POST[ 'jsonFile' ] ? 'jsonFile: "'.  $_POST[ 'jsonFile' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'startTypes' ] ) && is_array( $_POST[ 'startTypes' ] ) && sizeof($_POST[ 'startTypes' ]) > 0 ? 'startTypes: "'. implode( ',', $_POST[ 'startTypes' ] ) . '",' : ''; ?>
					<?php echo isset( $_POST[ 'startPointIcon' ] ) && $_POST[ 'startPointIcon' ] ? 'startPointIcon: "'.  $_POST[ 'startPointIcon' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'startTypesIcon' ] ) && $_POST[ 'startTypesIcon' ] ? 'startTypesIcon: "'.  $_POST[ 'startTypesIcon' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'cluster' ] ) && $_POST[ 'cluster' ] == true ? 'cluster: true,' : 'cluster: false,'; ?>
					<?php echo isset( $_POST[ 'clusterIcon' ] ) && $_POST[ 'clusterIcon' ] ? 'clusterIcon: "'.  $_POST[ 'clusterIcon' ] . '",' : ''; ?>
					<?php echo isset( $_POST[ 'zoom' ] ) && $_POST[ 'zoom' ] ? 'zoom: '.  $_POST[ 'zoom' ] . ',' : ''; ?>
					<?php echo isset( $_POST[ 'wheelScroll' ] ) && $_POST[ 'wheelScroll' ] == true ? 'wheelScroll: true,' : 'wheelScroll: false,'; ?>
				});				
			});
			
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})

		</script>
		<script src="multiple-select-master/multiple-select.js"></script>
		<script>
		$(function() {
			$('#startTypes').multipleSelect({
				width: '100%'
			});
		});
		</script>
		
		
		
	</body>
</html>
