<?php
/*
*Google map init
*/
?>

var geocoder = new google.maps.Geocoder();

var latlong;
var styles = [
{
stylers: [
{ hue: '<?php echo esc_attr( $data['atts']['hue'] ); ?>'  },
{ saturation: <?php echo esc_attr( $data['atts']['saturation'] ); ?> },
{ lightness: <?php echo esc_attr( $data['atts']['lightness'] ); ?> },
{ gamma: <?php echo esc_attr( $data['atts']['gamma'] ); ?> }
]
}
];

var googleMapOptions = {
zoom: <?php echo esc_attr( absint( $data['atts']['zoom'] ) ); ?>,
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
var map = new google.maps.Map(document.getElementById('google-map-id-<?php echo esc_attr( $data['atts']['el_id'] ); ?>'), googleMapOptions);

geocoder.geocode({'address': '<?php echo esc_html( $data['atts']['address'] ); ?>'}, function (results, status) {
if (status == google.maps.GeocoderStatus.OK) {
latlong = results[0].geometry.location;
var marker = new google.maps.Marker({
position: latlong,
map: map,
<?php if ( $data['atts']['pin_icon'] !== '' ) { ?>
	icon: {
	url: '<?php echo esc_url( wp_get_attachment_url( $data['atts']['pin_icon'] ) ) ?>',
	<?php if ( $data['atts']['pin_labelorigin'] !== '' ) { ?>
		labelOrigin: new google.maps.Point(<?php echo $data['atts']['pin_labelorigin']; ?>),
	<?php } ?>
	},
<?php }
if ( $data['atts']['pin_label'] !== '' ) { ?>
	label: {
	text: '<?php echo $data['atts']['pin_label']; ?>',
	color: "<?php echo $data['atts']['pin_color']; ?>",
	fontWeight: '<?php echo $data['atts']['pin_fontweight']; ?>'}
<?php } ?>

});

map.setCenter(latlong);

map.panBy( <?php echo esc_attr( $data['atts']['pin_offset_x'] ); ?>, <?php echo esc_attr( $data['atts']['pin_offset_y'] ); ?>);
	
}
});
}, 1000);