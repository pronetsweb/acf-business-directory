<?php use ACF_Business_Directory\Internals\Business; ?>
<?php if(!is_array($values) || count($values) == 0) { return; } ?>
<?php echo $content; ?>
<dl>
<?php foreach( $values as $value ) : ?>
	<?php
	$label = isset($value['label']) && $value['label'] != '' ? esc_html($value['label']) : '';
	$content = '';
	$link = null;
	switch( $value['type'] ) {
		case 'names':
			$content = esc_html($value['value']);
			break;
		case 'email':
			$content = esc_html($value['value']);
			$link = esc_attr('mailto:' . $value['value']);
			break;
		case 'phone':
			$content = esc_html(Business::try_format_phone( $value['value'] ));
			$link = esc_attr(Business::try_make_phone_link( $value['value'] ));
			break;
		case 'website':
		case 'socials':
			$content = esc_html(Business::try_format_url( $value['value'], $value['type'] ));
			$link = esc_attr(Business::try_make_valid_url( $value['value'], $value['type'] ));
			break;
	}
	?>
	<div class="field-<?php echo esc_attr( $value['type'] ) ?>">
		<dt><?php echo $label; ?></dt>
		<dd>
		<?php if($link) : ?>
			<a href="<?php echo $link; ?>"><?php echo $content; ?></a>
		<?php else : ?>
			<?php echo $content; ?>
		<?php endif; ?>
		</dd>
	</div>
<?php endforeach ?>
</dl>
