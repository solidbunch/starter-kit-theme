<?php $atts = vc_map_get_attributes($this->getShortcode(), $atts); ?>
<div id="google-map-id-<?php echo $atts['el_id']; ?>" class="fruitfulblankprefix-google-map"
	 style="width: 100%; height: <?php echo esc_attr($atts['height']); ?>px;"></div>

<script src="//maps.googleapis.com/maps/api/js<?php if ($atts['api_key'] != ''): ?>?key=<?php echo $atts['api_key']; ?><?php endif; ?>"></script>

<script type="text/javascript">

	var geocoder = new google.maps.Geocoder();

	var latlong;

	var styles = [
		{
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#f5f5f5"
				}
			]
		},
		{
			"elementType": "labels.icon",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#616161"
				}
			]
		},
		{
			"elementType": "labels.text.stroke",
			"stylers": [
				{
					"color": "#f5f5f5"
				}
			]
		},
		{
			"featureType": "administrative.land_parcel",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#bdbdbd"
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#eeeeee"
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#757575"
				}
			]
		},
		{
			"featureType": "poi.park",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#e5e5e5"
				}
			]
		},
		{
			"featureType": "poi.park",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#9e9e9e"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#ffffff"
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#757575"
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#dadada"
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#616161"
				}
			]
		},
		{
			"featureType": "road.local",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#9e9e9e"
				}
			]
		},
		{
			"featureType": "transit.line",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#e5e5e5"
				}
			]
		},
		{
			"featureType": "transit.station",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#eeeeee"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#c9c9c9"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#9e9e9e"
				}
			]
		}
	];

	var googleMapOptions = {
		zoom: <?php echo absint($atts['zoom']); ?>,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.roadmap,
		panControl: false,
		zoomControl: true,
		scrollwheel: false,
		disableDoubleClickZoom: true,
		disableDefaultUI: true,
		draggable: true,
		scaleControl: true,
		styles: styles
	};

	setTimeout( function() {

	var map = new google.maps.Map(document.getElementById('google-map-id-<?php echo $atts['el_id']; ?>'), googleMapOptions);

	geocoder.geocode({'address': '<?php echo esc_html($atts['address']); ?>'}, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			latlong = results[0].geometry.location;

			var marker = new google.maps.Marker({
				position: latlong,
				map: map,
				icon: '<?php echo wp_get_attachment_url($atts['pin_icon']) ?>'
			});

			map.setCenter(latlong);

			map.panBy( <?php echo $atts['pin_offset_x']; ?>, <?php echo $atts['pin_offset_y']; ?>);
			
			<?php if( filter_var($atts['info_window'], FILTER_VALIDATE_BOOLEAN) ): ?>

				var contentString = '<div class="map-info-window-content">' +
					
				'<div class="map-marker-text">' +
				
				<?php if( $atts['info_window_title'] <> '' ): ?>
				'<h2 class="map-marker-heading"><?php echo $atts['info_window_title']; ?></h2>' +
				<?php endif; ?>

				<?php if( $atts['info_window_phone'] <> '' ): ?>
				'<div class="phone iconic-text">' +
					'<p><i class="fa fa-phone-square"></i> <?php echo $atts['info_window_phone']; ?></p>' +
				'</div>' +
				<?php endif; ?>

				<?php if( $atts['info_window_email'] <> '' ): ?>
				'<div class="email iconic-text">' +
					'<p><i class="fa fa-envelope"></i> <?php echo $atts['info_window_email']; ?></p>' +
				'</div>' +
				<?php endif; ?>

				<?php if( $atts['info_window_address'] <> '' ): ?>
				'<div class="email iconic-text">' +
					'<p><i class="fa fa-map-marker"></i> <?php echo preg_replace('/\s+/', ' ', trim( $atts['info_window_address'] ) ); ?></p>' +
				'</div>' +
				<?php endif; ?>

				<?php if( $atts['info_window_wh'] <> '' ): ?>
				'<div class="email iconic-text">' +
					'<p><i class="fa fa-clock-o"></i> <?php echo preg_replace('/\s+/', ' ', trim( $atts['info_window_wh'] ) ); ?></p>' +
				'</div>' +
				<?php endif; ?>

				<?php if( $atts['info_window_follow_us_text'] <> '' ): ?>
				'<h2 class="map-marker-heading"><?php echo $atts['info_window_follow_us_text']; ?></h2>' +
				<?php endif; ?>

				'<div class="social-links">' +

				<?php if( $atts['info_window_fb_url'] <> '' ): ?>
				'<a href="<?php echo $atts['info_window_fb_url']; ?>" target="_blank"><i class="fa fa-facebook"></i></a>' + 
				<?php endif; ?>

				<?php if( $atts['info_window_twitter_url'] <> '' ): ?>
				'<a href="<?php echo $atts['info_window_twitter_url']; ?>" target="_blank"><i class="fa fa-twitter"></i></a>' + 
				<?php endif; ?>

				<?php if( $atts['info_window_google_plus_url'] <> '' ): ?>
				'<a href="<?php echo $atts['info_window_google_plus_url']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>' + 
				<?php endif; ?>

				<?php if( $atts['info_window_linkedin_url'] <> '' ): ?>
				'<a href="<?php echo $atts['info_window_linkedin_url']; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>' + 
				<?php endif; ?>

				'</div>' +

				'<div class="clearfix"></div></div></div>';

				var infowindow = new google.maps.InfoWindow({
					content: contentString,
					pixelOffset: new google.maps.Size(<?php echo $atts['info_window_offset_x']; ?>, <?php echo $atts['info_window_offset_y']; ?>),
					maxWidth: 400
				});

				infowindow.open(map, marker);

				// *
				// START INFOWINDOW CUSTOMIZE.
				// The google.maps.event.addListener() event expects
				// the creation of the infowindow HTML structure 'domready'
				// and before the opening of the infowindow, defined styles are applied.
				// *
				google.maps.event.addListener(infowindow, 'domready', function() {

					// Reference to the DIV that wraps the bottom of infowindow
					var iwOuter = jQuery('.gm-style-iw');

					/* Since this div is in a position prior to .gm-div style-iw.
					* We use jQuery and create a iwBackground variable,
					* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
					*/
					var iwBackground = iwOuter.prev();

					// Removes background shadow DIV
					iwBackground.children(':nth-child(2)').css({'display' : 'none'});

					// Removes white background DIV
					iwBackground.children(':nth-child(4)').css({'display' : 'none'});

					// Moves the infowindow 115px to the right.
					iwOuter.parent().parent().css({left: '115px'});

					// Moves the shadow of the arrow 76px to the left margin.
					iwBackground.children(':nth-child(1)').hide();

					// Moves the arrow 76px to the left margin.
					iwBackground.children(':nth-child(3)').hide();

					// Changes the desired tail shadow color.
					iwBackground.children(':nth-child(3)').hide();

					// Reference to the div that groups the close button elements.
					var iwCloseBtn = iwOuter.next();

					// Apply the desired effect to the close button
					iwCloseBtn.css({opacity: '0'});

					// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
					if( jQuery('.iw-content').height() < 140){
						jQuery('.iw-bottom-gradient').css({display: 'none'});
					}

					// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
					iwCloseBtn.mouseout(function(){
						jQuery(this).css({opacity: '1'});
					});

				});

			<?php endif; ?>

		}
	});

	}, 1000);

</script>