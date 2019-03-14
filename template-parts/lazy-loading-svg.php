<svg width="<?php echo $data['width']; ?>" height="<?php echo $data['height']; ?>"
	 viewBox="<?php echo round( ( 12 - ( $data['width'] / 2 ) ) * 5.333 ); ?> <?php echo round( ( 12 - ( $data['height'] / 2 ) ) * 5.333 ); ?> <?php echo round( $data['width'] * 5.3333 ); ?> <?php echo round( $data['height'] * 5.3333 ); ?>"
	 xmlns="http://www.w3.org/2000/svg">
	<style>circle {
			fill: <?php echo $data['fill']; ?>
		}</style>
	<g>
		<circle transform="rotate(45,64,64)" cx="16" cy="64" r="16" fill-opacity="1"/>
		<circle transform="rotate(90,64,64)" cx="16" cy="64" r="16" fill-opacity="0.8"/>
		<circle transform="rotate(135,64,64)" cx="16" cy="64" r="16" fill-opacity="0.65"/>
		<circle transform="rotate(180,64,64)" cx="16" cy="64" r="16" fill-opacity="0.5"/>
		<circle transform="rotate(225,64,64)" cx="16" cy="64" r="16" fill-opacity="0.25"/>
		<circle transform="rotate(270,64,64)" cx="16" cy="64" r="16" fill-opacity="0.2"/>
		<circle transform="rotate(315,64,64)" cx="16" cy="64" r="16" fill-opacity="0.2"/>
		<animateTransform attributeName="transform" calcMode="discrete" dur="720ms" repeatCount="indefinite" type="rotate"
						  values="0 64 64;315 64 64;270 64 64;225 64 64;180 64 64;135 64 64;90 64 64;45 64 64"/>
	</g>
</svg>