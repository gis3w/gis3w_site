<?php
$sidebar = mts_custom_sidebar();
if ( $sidebar != 'mts_nosidebar' ) {
?>
<aside class="sidebar c-4-12">
	<div id="sidebars" class="g">
		<div class="sidebar">
			<div class="sidebar_list">
				<?php if (!dynamic_sidebar($sidebar)) : ?>
					<div id="sidebar-search" class="widget">
						<div class="widget-content">
							<h3><?php _e('Search', 'mythemeshop'); ?></h3>
							<?php get_search_form(); ?>
						</div>
					</div>
					<div id="sidebar-archives" class="widget">
						<div class="widget-content">
							<h3><?php _e('Archives', 'mythemeshop') ?></h3>
							<ul>
								<?php wp_get_archives( 'type=monthly' ); ?>
							</ul>
						</div>
					</div>
					<div id="sidebar-meta" class="widget">
						<div class="widget-content">
							<h3><?php _e('Meta', 'mythemeshop') ?></h3>
							<ul>
								<?php wp_register(); ?>
								<li><?php wp_loginout(); ?></li>
								<?php wp_meta(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div><!--sidebars-->
</aside>
<?php } ?>