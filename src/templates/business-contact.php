<?php if($value == '') { return; } ?>
<?php echo $content; ?>
<?php

switch($field) {
	case 'email':
		echo '<div><a href="' . esc_attr('mailto:' . $value) . '">' . esc_html($value) . '</a></div>';
		break;
	case 'phone':
		if( $link !== false ) {
			echo '<div><a href="' . esc_attr($link) . '">' . esc_html($value) . '</a></div>';
		} else {
			echo '<div>' . esc_html($value) . '</div>';
		}
		break;
	case 'website':
		echo '<a href="' . esc_attr($value) . '" target="_blank" rel="nofollow">' . esc_html($value) . '</a>';
		break;
	case 'social':
		echo '<ul>';
		foreach( $value as $link ) {
			echo '<li class="' . esc_attr($link['class']) . '"><a href="' . esc_attr($link['href']) . '">' . $link['text'] . '</a></li>';
		}
		echo '</ul>';
		break;
}

?>
