<ol>
<?php
$images = $business->get_gallery();
$size = apply_filters( 'acf_bd_business_photos_size', 'large' );
?>

<?php if( $images ): ?>
	<?php foreach( $images as $image ): ?>
		<li><?php echo wp_get_attachment_image( $image["ID"], $size ); ?></li>
	<?php endforeach ?>
<?php endif ?>

</ol>
