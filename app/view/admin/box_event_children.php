<?php
if ( empty( $parent ) && empty( $children ) ) {
	return '';
}
?>
<div class="accordion-heading">
	<a class="accordion-toggle" data-toggle="ai1ec_collapse"
		data-parent="#ai1ec-add-new-event-accordion"
		href="#ai1ec-event-children-box">
		<i class="icon-retweet"></i> <?php
		if ( $parent ) {
			_e( 'Base recurrence event', AI1EC_PLUGIN_NAME );
		} else {
			_e( 'Modified recurrence events', AI1EC_PLUGIN_NAME );
		}
	?>
	</a>
</div>
<div id="ai1ec-event-children-box" class="accordion-body collapse">
	<div class="accordion-inner">
	<?php if ( $parent ) : ?>
	<?php _e( 'Edit parent:', AI1EC_PLUGIN_NAME ); ?>
	<a href="<?php echo get_edit_post_link( $parent->post_id ); ?>"><?php
	echo apply_filters( 'the_title', $parent->post->post_title, $parent->post_id );
	?></a>
	<?php else : /* children */ ?>
	<h4><?php _e( 'Modified Events', AI1EC_PLUGIN_NAME ); ?></h4>
	<ul>
		<?php foreach ( $children as $child ) : ?>
		<li>
			<?php _e( 'Edit:', AI1EC_PLUGIN_NAME ); ?>
			<a href="<?php echo get_edit_post_link( $child->post_id ); ?>"><?php
			echo $child->post->post_title;
			?></a>, <?php echo $child->get_timespan_html( 'long' ); ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	</div>
</div>
