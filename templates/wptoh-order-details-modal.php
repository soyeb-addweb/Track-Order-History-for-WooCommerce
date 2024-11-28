<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="container mainDivContainer">
	<!-- Button to Open the Modal -->
	<?php if( $count > 0 ){ ?>
	<button type="button" class="btn btn-primary btn-count" name="pastOrderCount"  data-uid="<?php echo esc_attr( $order_row_uid ); ?>" data-ordrid="<?php echo esc_attr( $post_id ); ?>" data-toggle="modal" data-target="#myModal_<?php echo esc_attr( $post_id ); ?>">
		<?php echo esc_attr( $count ); ?>
	</button>

	<?php } else { ?>
		
	<button type="button" class="btn btn-primary btn-count">
		<?php echo esc_attr( $count ); ?>
	</button>
	<?php } ?>
</div>