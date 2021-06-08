<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vladpitomnik
 */
?>
		</div><!-- end wrapper -->
		<footer class="footer" id="footer">
			<div class="footer_start">
				<nav class="bottom_nav">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					?>
				</nav>
			</div>
			<div class="footer_middle">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
					<?$custom_logo__url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )?>
					<img src="<?=$custom_logo__url[0]?>" alt="">
					ВМКУ "Владпитомник"
				</a>
				<?php
					wp_nav_menu(
						array(
							'theme_location' 	=> 'menu-socicon',
							'menu_id'        	=> 'menu-socicon',
							'menu_class'      => 'soc_icon',
						)
					);
				?>
			</div>
			<div class="footer_end">
			<?php dynamic_sidebar( 'Контакты-внизу' ); ?>
			</div>
		</footer>
	<?php wp_footer(); ?>
</body>
</html>
