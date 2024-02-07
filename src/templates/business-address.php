<?php if( !$business->is_address_empty() ) : ?>
<?php echo $content; ?>
<?php endif ?>
<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
    <?php if( $business->get_address_line_1() != '' || $business->get_address_line_2() != '' ) : ?>
    <span itemprop="streetAddress">
        <?php echo esc_html( $business->get_address_line_1() ) ; ?>
        <?php if( $business->get_address_line_2() != '' ) : ?>
        <?php echo esc_html( $business->get_address_line_2() ); ?>
        <?php endif; ?>
    </span>
    <?php endif; ?>

    <?php if( $business->get_city() != '' ) : ?>
    <span itemprop="addressLocality"><?php echo esc_html( $business->get_city() ); ?></span>,
    <?php endif; ?>

    <?php if( $business->get_state() != '' ) : ?>
    <span itemprop="addressRegion"><?php echo esc_html( $business->get_state() ); ?></span>
    <?php endif; ?>

    <?php if( $business->get_postcode() != '' ) : ?>
    <span itemprop="postalCode"><?php echo esc_html( $business->get_postcode() ); ?></span>
    <?php endif; ?>

</div>
