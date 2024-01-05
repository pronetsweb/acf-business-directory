<?php if($value == '') { return; } ?>
<?php echo $content; ?>
<?php

switch($field) {
	case 'email':
		echo '<div><a href="' . esc_attr('mailto:' . $value) . '">' . esc_html($value) . '</a></div>';
		break;
	case 'phone':
		echo '<div>' . esc_html($value) . '</div>';
		break;
	case 'website':
		echo '<a href="' . esc_attr($value) . '">' . esc_html($value) . '</a>';
		break;
}

?>
