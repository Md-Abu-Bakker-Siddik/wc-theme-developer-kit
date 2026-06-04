
		<?php if( !empty( $title ) ) : ?>
		<<?php echo esc_attr( $title_tag );?> class="title">
			<?php if( $link_title == 'yes' && !empty( $url ) ): ?>
			<a
				href="<?php echo esc_url( $url ); ?>"
				<?php echo ! empty( $link['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php echo wp_kses( $title, 'post' ); ?>
			</a>
			<?php else: ?>
				<?php echo wp_kses( $title, 'post' ); ?>
			<?php endif ?>
		</<?php echo esc_attr( $title_tag );?>>
		<?php endif; ?>