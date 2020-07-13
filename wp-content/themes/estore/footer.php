<?php
/**
 * Theme Footer Section for our theme.
 *
 * Displays all of the footer section and starting from <footer> tag.
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */
?>

	  <footer id="colophon">
		 <?php get_sidebar( 'footer' ); ?>
		 <div class="bottom_nav">
			 <div class="tg-container">
			 <?php $args = ['menu'=>'footer'];
			 wp_nav_menu( $args); 
			 ?>
			 </div>
		 </div>
		 <div id="bottom-footer" class="clearfix">
			<div class="tg-container">
				<div class="copy-right">
					<?php printf( esc_html__( 'Copyright &copy; 2020-21 | Proudly powered by %s.', 'Mic' ), '<a href="'.esc_url ( 'https://yourmic.in/' ).'">Slow Movement Pvt.Ltd</a>' ); ?>
				</div>
				<?php
				$logos = array();
				for ( $i = 1; $i < 5; $i++ ) {
					$paymentlogo = get_theme_mod('estore_payment_logo'.$i);
					if($paymentlogo) {
						array_push($logos, $paymentlogo);
					}
				}
				$totallogo = count($logos);
				if($totallogo > 0){ ?>
					<div class="payment-partner-wrapper">
						<ul>
						<?php for($j = 0; $j < $totallogo; $j++ ) { ?>
							<li><img src="<?php echo esc_url($logos[$j])?>" /></li>
						<?php } ?>
						</ul>
					</div>
				<?php } ?>
			</div>
		</div>
	  </footer>
	  <a href="#" class="scrollup"><i class="fa fa-angle-up"> </i> </a>
   </div> <!-- Page end -->
   <?php wp_footer(); ?>
</body>
</html>
