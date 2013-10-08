<div class="ai1ec-support-placeholder"><span class="ai1ec-loader-icon-small"></span></div>
<script src="<?php echo $support_box_js ?>"></script>
<div class="ai1ec-news">
	<h2><?php _e( 'Timely News', AI1EC_PLUGIN_NAME ); ?> <small><a href="http://time.ly/blog?utm_source=dashboard&utm_medium=blog&utm_term=ai1ec-standard&utm_content=1.10.1&utm_campaign=news" target="_blank"><?php _e( 'view all news', AI1EC_PLUGIN_NAME ); ?> <i class="icon-arrow-right"></i></a></small></h2>
	<div>
	<?php if( count( $news ) > 0 ) : ?>
		<?php foreach( $news as $n ) : ?>
			<article>
				<header>
					<strong><a href="<?php
						$ga_args   = array(
							'utm_source'   => 'dashboard',
							'utm_medium'   => 'blog',
							'utm_campaign' => 'news',
							'utm_term'     => urlencode(
								strtolower( substr( $n->get_title(), 0, 40 ) )
							),
						);
						echo add_query_arg( $ga_args, $n->get_permalink() );
					?>" target="_blank"><?php echo $n->get_title() ?></a></strong>
				</header>
				<div>
					<?php echo preg_replace( '/\s+?(\S+)?$/', '', $n->get_description() ); ?>
				</div>
			</article>
		<?php endforeach ?>
	<?php else : ?>
		<p><em>No news available.</em></p>
	<?php endif ?>
	</div>
</div>

<div class="ai1ec-follow-fan">
	<div class="ai1ec-facebook-like-top">
		<script src="//connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<fb:like href="http://www.facebook.com/timelycal" layout="button_count" show_faces="true" width="110" font="lucida grande"></fb:like>
	</div>
	<a href="http://twitter.com/_Timely" class="twitter-follow-button"><?php _e( 'Follow @_Timely', AI1EC_PLUGIN_NAME ) ?></a>
	<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
</div>

<br class="clear" />
