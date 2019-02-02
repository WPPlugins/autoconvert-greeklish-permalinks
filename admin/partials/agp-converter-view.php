<?php

$log      = get_option( 'agp_conversion' );
$status   = $log['status'] === 'started';
$disabled = $status ? 'disabled' : '';

if ( isset( $_POST['convert-button'] ) ) {

	$posts_type = isset( $_POST['post-type'] ) ? $_POST['post-type'] : false;
	$taxonomy   = isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : false;

	$has_posts = $this->convert( $posts_type, $taxonomy );

	if ( ! $has_posts ) {
		?>
		<div class="notice notice-info is-dismissible">
			<p><?php _e( '<b>No permalink was converted.</b> All your permalinks were already in latin characters.', 'agp' ) ?></p>
		</div>
		<?php
	} else {
		?>
		<div class="notice notice-success is-dismissible">
			<p><b><?php _e( 'Permalinks conversion has started in the background.', 'agp' ) ?></b></p>
		</div>
		<?php
	}
}
?>
<div>

	<div class="card">
		<h3 class="title"><?php _e( 'Convert old posts/terms', 'agp' ); ?></h3>
		<p><?php _e( 'Depending on your server and the amount of permalinks that needs to be converted, the conversion might take a few minutes to complete.', 'agp' ) ?></p>
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>" method="post">
			<table class="form-table">
				<tbody>
				<tr>
					<th>
						<label for="post-type[]"><?php _e( 'Post types to convert', 'agp' ); ?></label>
					</th>
					<td>
						<select title="<?php _e( 'Post types to convert', 'agp' ); ?>"
								name="post-type[]" class="select2" <?php echo $disabled ?>
								data-placeholder="<?php _e( 'Select one or more post types', 'agp' ); ?>"
								multiple>
							<?php
							$args       = array(
								'public' => true,
							);
							$post_types = get_post_types( $args, 'names' );
							?>
							<?php
							foreach ( $post_types as $post_type ) {
								$obj = get_post_type_object( $post_type );
								?>
								<option value="<?php esc_attr_e( $post_type ); ?>">
									<?php echo $obj->labels->name; ?>
								</option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="taxonomy[]"><?php _e( 'Taxonomies to convert', 'agp' ); ?></label>
					</th>
					<td>
						<select title="<?php _e( 'Taxonomies to convert', 'agp' ); ?>"
								name="taxonomy[]" class="select2" <?php echo $disabled ?>
								data-placeholder="<?php _e( 'Select one or more taxonomies', 'agp' ); ?>"
								multiple>
							<?php
							$args       = array(
								'public' => true,
							);
							$taxonomies = get_taxonomies( $args, 'objects' );
							foreach ( $taxonomies as $taxonomy ) { ?>
								<option value="<?php esc_attr_e( $taxonomy->name ); ?>">
									<?php echo $taxonomy->labels->name; ?>
								</option>
							<?php } ?>
						</select>
					</td>
				</tr>
				</tbody>
			</table>

			<input name="convert-button" type="hidden" value="1"/>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary"
					<?php echo $log['status'] === 'started' ? 'disabled' : ''; ?>
					   value="<?php _e( 'Convert Permalinks', 'agp' ); ?>">
			</p>
		</form>
	</div>

	<?php include_once( 'agp-log-view.php' ); ?>

</div>
<script>
	jQuery(function () {
		jQuery('.select2').select2();
	});
</script>