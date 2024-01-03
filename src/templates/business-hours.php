<div class="hours">
    <dl class="hours-list">
<?php foreach( $sorted_hours as $day => $_hours ) : ?>
        <?php
            if( $_hours == [] ) {
                $hours = __('Closed', 'acf-business-directory');
            } else {
                if( !$_hours['all_day'] ) {
                    $hours = implode(', ', array_map( function( $start, $end ) {
                        return implode(' - ', [ $start, $end ]);
                    }, $_hours['start'], $_hours['end'] ) );
                } else {
                    $hours = __('All Day', 'acf-business-directory');
                }
            }
        ?>
        <dt><?php echo $day; ?></dt>
        <dd><?php echo $hours; ?></dd>
<?php endforeach; ?>
    </dl>
</div>
