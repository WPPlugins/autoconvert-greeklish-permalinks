<?php

if ( $log && $log['status'] === 'done' ) {

	$posts_count_complete = $log['converted']['posts'];
	$terms_count_complete = $log['converted']['terms'];

	$posts_count_estimate = $log['estimated']['posts'];
	$terms_count_estimate = $log['estimated']['terms'];

	$errors = $log['errors'];

	$posts_txt = $posts_count_estimate == 1 ? __( 'post', 'agp' ) : __( 'posts', 'agp' );
	$terms_txt = $terms_count_estimate == 1 ? __( 'term', 'agp' ) : __( 'terms', 'agp' );
	$duration  = $log['ended'] - $log['started'];

	?>
	<div class="card" id="report">
		<h2><?php echo __( 'Report of last conversion', 'agp' ) ?></h2>
		<p>
			<?php echo sprintf( __( 'Started at %s and finished at %s. <br>Duration: %d second(s)', 'agp' ), date( 'd/m/Y H:i:s', $log['started'] ), date( 'd/m/Y H:i:s', $log['ended'] ), $duration ); ?>
		</p>
		<p>
			<?php echo sprintf( __( 'Permalinks successfully converted %d/%d %s and %d/%d %s.', 'agp' ), $posts_count_complete, $posts_count_estimate, $posts_txt, $terms_count_complete, $terms_count_estimate, $terms_txt ); ?>
		</p>
		<p>
			<?php
			if ( ! empty( $errors ) ) {
			echo '<b>' . __( 'The following errors occurred', 'agp' ) . ':</b><ul>';

			foreach ( $errors

			as $error ) {
			if ( $error['type'] === 'post' ) {
			$post_id = $error['id'];
			?>
		<li><?php echo sprintf( __( 'The post <a href="%s">%s</a> was not converted. %s', 'agp' ), get_edit_post_link( $post_id ), get_the_title( $post_id ), $error['message'] ); ?></li>
		<?php
		} elseif ( $error['type'] === 'term' ) {
			$term = get_term( $error['id'] );
			?>
			<li><?php echo sprintf( __( 'The term <a href="%s">%s</a> was not converted. %s', 'agp' ), get_edit_term_link( $term->term_id ), $term->name, $error['message'] ); ?></li>
			<?php
		}
		}
		echo '</ul>';
		}
		?>
		</p>
	</div>
	<?php
}