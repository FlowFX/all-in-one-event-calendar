<?php do_action( 'ai1ec_general_settings_before' ); ?>

<ul class="nav nav-tabs">
	<li><a href="#ai1ec-viewing-events" data-toggle="tab"><?php _e( 'Viewing Events', AI1EC_PLUGIN_NAME ); ?></a></li>
	<li><a href="#ai1ec-editing-events" data-toggle="tab"><?php _e( 'Adding/Editing Events', AI1EC_PLUGIN_NAME ); ?></a></li>
	<li><a href="#ai1ec-advanced" data-toggle="tab"><?php _e( 'Advanced Settings', AI1EC_PLUGIN_NAME ); ?></a></li>
</ul>

<div class="tab-content ai1ec-boxed-tabs">

	<div class="ai1ec-gzip-causes-js-failure"><?php
	printf(
		__(
			'If the form below is not working please follow <a href="%s">this link</a>.',
			AI1EC_PLUGIN_NAME
		),
		add_query_arg( 'ai1ec_disable_gzip_compression', '1' )
	); ?></div>

	<div class="tab-pane" id="ai1ec-viewing-events">
		<h2><?php _e( 'Viewing Events', AI1EC_PLUGIN_NAME ); ?></h2>

		<div class="clearfix">
			<label class="textinput" for="calendar_page_id"><?php _e( 'Calendar page:', AI1EC_PLUGIN_NAME ); ?></label>
			<div class="pull-left"><?php echo $calendar_page ?></div>
		</div>

		<?php if( $show_timezone ) : ?>
			<div class="clearfix">
				<label class="textinput" for="timezone"><?php _e( 'Timezone:', AI1EC_PLUGIN_NAME ); ?></label>
				<?php echo $timezone_control ?>
			</div>
		<?php endif; ?>

		<div class="clearfix">
			<label class="textinput" for="week_start_day"><?php _e( 'Week starts on', AI1EC_PLUGIN_NAME ); ?></label>
			<?php echo $week_start_day ?>
		</div>

		<div class="ai1ec-admin-view-settings clearfix">
			<label><?php _e( 'Available views:', AI1EC_PLUGIN_NAME ); ?></label>
			<?php echo $default_calendar_view; ?>
		</div>

		<?php if ( ! empty( $default_categories ) || ! empty( $default_tags ) ) : ?>
			<div class="ai1ec-default-filters clearfix">
				<label class="textinput"><?php
					_e( 'Preselected calendar filters:', AI1EC_PLUGIN_NAME );
				?><div class="help-block"><?php
					_e( 'To clear, hold ⌘/<abbr class="initialism">CTRL</abbr> and click selection.', AI1EC_PLUGIN_NAME );
				?></div>
				</label>
				<div class="pull-left">
					<?php if ( ! empty( $default_categories ) ) : ?>
						<div class="pull-left">
							<label for="default_categories"><?php _e( 'Categories:', AI1EC_PLUGIN_NAME ); ?></label>
							<?php echo $default_categories; ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $default_tags ) ) : ?>
						<div class="pull-left">
							<label for="default_tags"><?php _e( 'Tags:', AI1EC_PLUGIN_NAME ); ?></label>
							<?php echo $default_tags; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="clearfix">
			<label class="textinput" for="exact_date">
				<?php _e( 'Default calendar start date (optional):', AI1EC_PLUGIN_NAME ); ?>
			</label>
			<input data-date-format="<?php echo esc_attr( $date_format_pattern ); ?>"
				data-date-weekstart="<?php echo esc_attr( $week_start_day_val ); ?>"
				name="exact_date" id="exact_date" type="text" size="8" class="input-small"
				value="<?php echo esc_attr( $exact_date ) ?>" />
		</div>

		<label class="textinput" for="posterboard_tile_min_width">
			<?php _e( 'Posterboard tile minimum width', AI1EC_PLUGIN_NAME ) ?>
		</label>
		<div class="input-append">
			<input name="posterboard_tile_min_width" id="posterboard_tile_min_width"
				type="text" class="input-mini"
				value="<?php echo esc_attr( $posterboard_tile_min_width ) ?>"
				/><span class="add-on"><?php _e( 'px', AI1EC_PLUGIN_NAME ) ?></span>
		</div>

		<label class="textinput" for="posterboard_events_per_page">
			<?php _e( 'Posterboard pages show at most', AI1EC_PLUGIN_NAME ) ?>
		</label>
		<div class="input-append">
			<input name="posterboard_events_per_page" id="posterboard_events_per_page"
				type="text" class="input-mini"
				value="<?php echo esc_attr( $posterboard_events_per_page ) ?>"
				/><span class="add-on"><?php _e( 'events', AI1EC_PLUGIN_NAME ) ?></span>
		</div>

		<label class="textinput" for="agenda_events_per_page">
			<?php _e( 'Agenda pages show at most', AI1EC_PLUGIN_NAME ) ?>
		</label>
		<div class="input-append">
			<input name="agenda_events_per_page" id="agenda_events_per_page" type="text"
				class="input-mini" value="<?php echo esc_attr( $agenda_events_per_page ) ?>"
				/><span class="add-on"><?php _e( 'events', AI1EC_PLUGIN_NAME ) ?></span>
		</div>

		<label for="agenda_include_entire_last_day">
			<input name="agenda_include_entire_last_day"
				id="agenda_include_entire_last_day"
				type="checkbox" class="checkbox" value="1"
				<?php echo $agenda_include_entire_last_day; ?>
				/>
			<?php printf(
				__( 'In <span %s>Agenda-like views</span>, <strong>include all events from last day shown</strong>', AI1EC_PLUGIN_NAME ),
				'class="ai1ec-tooltip-toggle" title="' .
					__( 'These include Agenda view, Posterboard view, and the Upcoming Events widget.', AI1EC_PLUGIN_NAME )
					. '"'
				); ?>
		</label>

		<label for="agenda_events_expanded">
			<input class="checkbox" name="agenda_events_expanded" id="agenda_events_expanded" type="checkbox" value="1" <?php echo $agenda_events_expanded ?> />
			<?php _e( 'Keep all events <strong>expanded</strong> in Agenda view', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="show_year_in_agenda_dates">
			<input class="checkbox" name="show_year_in_agenda_dates" id="show_year_in_agenda_dates" type="checkbox" value="1" <?php echo $show_year_in_agenda_dates ?> />
			<?php _e( '<strong>Show year</strong> in Posterboard, Agenda and widget view date labels', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="show_location_in_title">
			<input class="checkbox" name="show_location_in_title" id="show_location_in_title" type="checkbox" value="1" <?php echo $show_location_in_title ?> />
			<?php _e( '<strong>Show location in event titles</strong> in calendar views', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="exclude_from_search">
			<input class="checkbox" name="exclude_from_search" id="exclude_from_search" type="checkbox" value="1" <?php echo $exclude_from_search ?> />
			<?php _e( '<strong>Exclude</strong> events from search results', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="turn_off_subscription_buttons">
			<input class="checkbox" name="turn_off_subscription_buttons" id="turn_off_subscription_buttons" type="checkbox" value="1" <?php echo $turn_off_subscription_buttons ?> />
			<?php _e( 'Hide <strong>Subscribe</strong>/<strong>Add to Calendar</strong> buttons in calendar and single event views', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="hide_maps_until_clicked">
		<input class="checkbox" name="hide_maps_until_clicked" id="hide_maps_until_clicked" type="checkbox" value="1" <?php echo $hide_maps_until_clicked ?> />
		<?php _e( 'Hide <strong>Google Maps</strong> until clicked', AI1EC_PLUGIN_NAME ) ?>
		</label>
		<br class="clear" />

		<label for="inject_categories">
		<input class="checkbox" name="inject_categories" id="inject_categories" type="checkbox" value="1" <?php echo $inject_categories ?> />
		<?php _e( 'Include <strong>event categories</strong> in post category lists', AI1EC_PLUGIN_NAME ) ?>
		</label>
		<br class="clear" />

		<p></p><p>
			<a href="#ai1ec-embedding" id="ai1ec-embedding-trigger"
				data-toggle="ai1ec_collapse">
				<i class="icon-info-sign icon-large"></i>
				<?php _e( 'Alternative methods to embed a calendar', AI1EC_PLUGIN_NAME ); ?>
				<i class="icon-caret-down"></i>
				<i class="icon-caret-up hide"></i>
			</a>
		</p>
		<div id="ai1ec-embedding" class="collapse">
			<div class="well">
				<h4><?php _e( 'With a shortcode', AI1EC_PLUGIN_NAME ); ?></h4>
				<p><?php _e( 'Insert one of these shortcodes into your page body to embed the calendar into any arbitrary WordPress Page:', AI1EC_PLUGIN_NAME ); ?></p>
				<ul>
					<li><?php _e( 'Posterboard view:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec view="posterboard"]</code></li>
					<li><?php _e( 'Month view:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec view="monthly"]</code></li>
					<li><?php _e( 'Week view:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec view="weekly"]</code></li>
					<li><?php _e( 'Day view:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec view="daily"]</code></li>
					<li><?php _e( 'Agenda view:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec view="agenda"]</code></li>
					<li><?php _e( 'Default view as per settings:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec]</code></li>
				</ul>
				<p>
					<span class="muted"><?php _e( 'Optional.', AI1EC_PLUGIN_NAME ); ?></span>
					<?php _e( 'Add options to display a filtered calender. (You can find out category and tag IDs by inspecting the URL of your filtered calendar page.)', AI1EC_PLUGIN_NAME ); ?>
				</p>
				<ul>
					<li><?php _e( 'Filter by event category name/slug:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec cat_name="<?php _e( 'Holidays', AI1EC_PLUGIN_NAME ); ?>"]</code></li>
					<li><?php _e( 'Filter by event category names/slugs (separate names by comma):', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec cat_name="<?php _e( 'Lunar Cycles', AI1EC_PLUGIN_NAME ); ?>,<?php _e( 'zodiac-date-ranges', AI1EC_PLUGIN_NAME ); ?>"]</code></li>
					<li><?php _e( 'Filter by event category ID:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec cat_id="1"]</code></li>
					<li><?php _e( 'Filter by event category IDs (separate IDs by comma):', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec cat_id="1,2"]</code></li>

					<li><?php _e( 'Filter by event tag name/slug:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec tag_name="<?php _e( 'tips-and-tricks', AI1EC_PLUGIN_NAME ); ?>"]</code></li>
					<li><?php _e( 'Filter by event tag names/slugs (separate names by comma):', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec tag_name="<?php _e( 'creative writing', AI1EC_PLUGIN_NAME ); ?>,<?php _e( 'performing arts', AI1EC_PLUGIN_NAME ); ?>"]</code></li>
					<li><?php _e( 'Filter by event tag ID:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec tag_id="1"]</code></li>
					<li><?php _e( 'Filter by event tag IDs (separate IDs by comma):', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec tag_id="1,2"]</code></li>

					<li><?php _e( 'Filter by post ID:', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec post_id="1"]</code></li>
					<li><?php _e( 'Filter by post IDs (separate IDs by comma):', AI1EC_PLUGIN_NAME ); ?> <code>[ai1ec post_id="1,2"]</code></li>
				</ul>
				<div class="alert alert-block">
					<p><strong><?php _e( 'Warning', AI1EC_PLUGIN_NAME ); ?></strong></p>
					<p><?php _e( 'It is currently not supported to embed more than one calendar in the same page. Do not attempt to embed the calendar via shortcode in a page that already displays the calendar.', AI1EC_PLUGIN_NAME ); ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-pane" id="ai1ec-editing-events">
		<h2><?php _e( 'Adding/Editing Events', AI1EC_PLUGIN_NAME ); ?></h2>

		<div class="clearfix">
			<label class="textinput" for="input_date_format"><?php _e( 'Input dates in this format:', AI1EC_PLUGIN_NAME ) ?></label>
			<?php echo $input_date_format; ?>
		</div>

		<label for="input_24h_time">
			<input class="checkbox" name="input_24h_time" id="input_24h_time" type="checkbox" value="1" <?php echo $input_24h_time ?> />
			<?php _e( 'Use <strong>24h time</strong> in time pickers', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="disable_autocompletion">
			<input class="checkbox" name="disable_autocompletion" id="disable_autocompletion" type="checkbox" value="1" <?php echo $disable_autocompletion ?> />
			<?php _e( '<strong>Disable address autocomplete</strong> function', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="geo_region_biasing">
			<input class="checkbox" name="geo_region_biasing" id="geo_region_biasing" type="checkbox" value="1" <?php echo $geo_region_biasing ?> />
			<?php _e( 'Use the configured <strong>region</strong> (WordPress locale) to bias the address autocomplete function', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="show_publish_button">
			<input class="checkbox" name="show_publish_button" id="show_publish_button" type="checkbox" value="1" <?php echo $show_publish_button ?> />
			<?php _e( 'Display <strong>Publish</strong> at bottom of Edit Event form', AI1EC_PLUGIN_NAME ) ?>
		</label>

		<label for="show_create_event_button">
			<input class="checkbox" name="show_create_event_button" id="show_create_event_button" type="checkbox" value="1" <?php echo $show_create_event_button ?> />
			<?php _e( 'Show the old <strong>Post Your Event</strong> button above the calendar to privileged users', AI1EC_PLUGIN_NAME ); ?>
			<div class="help-block">
				<?php printf(
					__( '<a %s>Upgrade to Pro</a> for the new <strong>front-end Post Your Event form</strong>.', AI1EC_PLUGIN_NAME ),
					'href="http://time.ly/pro-calendar" target="_blank"'
				); ?>
			</div>
		</label>

	</div>

	<div class="tab-pane" id="ai1ec-advanced">
		<h2><?php _e( 'Advanced Settings', AI1EC_PLUGIN_NAME ); ?></h2>

		<?php do_action( 'ai1ec_advanced_settings_before' ); ?>

		<div class="clearfix">
			<label class="textinput" for="calendar_css_selector"><?php _e( 'Move calendar into this DOM element:', AI1EC_PLUGIN_NAME ) ?></label>
			<input name="calendar_css_selector" id="calendar_css_selector" type="text"
				class="input-xlarge"
				value="<?php echo esc_attr( $calendar_css_selector ) ?>" />
			<span class="help-block"><?php _e( 'Optional. Use this JavaScript-based shortcut to place the calendar a DOM element other than the usual page content container if you are unable to create an appropriate page template for the calendar page. To use, enter a <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery selector</a> that evaluates to a single DOM element. Any existing markup found within the target will be replaced by the calendar.', AI1EC_PLUGIN_NAME ) ?></span>
		</div>

		<div class="clearfix">
			<label for="skip_in_the_loop_check">
			<input class="checkbox" name="skip_in_the_loop_check" id="skip_in_the_loop_check" type="checkbox" value="1" <?php echo $skip_in_the_loop_check; ?> />
			<?php _e( '<strong>Skip <tt>in_the_loop()</tt> check</strong> that protects against multiple calendar output', AI1EC_PLUGIN_NAME ); ?>
			</label>
		</div>
		<span class="help-block"><?php _e( 'Try enabling this option if your calendar does not appear on the calendar page. It is needed for compatibility with a small number of themes that call <tt>the_content()</tt> from outside of The Loop. Leave disabled otherwise.', AI1EC_PLUGIN_NAME ) ?></span>

		<label for="disable_gzip_compression">
			<input class="checkbox" name="disable_gzip_compression" id="disable_gzip_compression" type="checkbox" value="1" <?php echo $disable_gzip_compression; ?> />
			<?php printf(
				__(
					'Disable <strong>gzip</strong> compression. Use this option if calendar is non-responsive. Read <a href="%s">more about</a> the issue.',
					AI1EC_PLUGIN_NAME
				),
				'http://support.time.ly/disable-gzip-compression/'
			); ?>
		</label>

		<?php if( $display_event_platform ): ?>
			<label for="event_platform">
				<input class="checkbox" name="event_platform" id="event_platform" type="checkbox" value="1"
					<?php echo $event_platform; ?>
					<?php echo $event_platform_disabled; ?> />
				<?php _e( 'Turn this blog into an <strong>events-only platform</strong>', AI1EC_PLUGIN_NAME ); ?>
				<?php if( $event_platform_disabled ): ?>
					<span class="help-block"><?php _e( 'To deactivate event platform mode, set <code>AI1EC_EVENT_PLATFORM</code> in <code>all-in-one-event-calendar.php</code> to <code>FALSE</code>.', AI1EC_PLUGIN_NAME ) ?></span>
				<?php endif; ?>
			</label>

			<label for="event_platform_strict">
				<input class="checkbox" name="event_platform_strict" id="event_platform_strict" type="checkbox" value="1"
					<?php echo $event_platform_strict; ?> />
				<?php _e( '<strong>Strict</strong> event platform mode', AI1EC_PLUGIN_NAME ); ?>
				<span class="help-block"><?php _e( 'Prevents plugins from adding menu items unrelated to calendar/media/user management', AI1EC_PLUGIN_NAME ); ?></span>
			</label>
		<?php endif; ?>

		<div class="clear"></div>

		<?php do_action( 'ai1ec_advanced_settings_after' ); ?>
	</div>

	<div class="ai1ec-tab-pane-not-loaded">
		<em class="muted"><?php _e( 'Please reload this page if settings pane does not appear.', AI1EC_PLUGIN_NAME ); ?></em>
	</div>
</div>

<?php do_action( 'ai1ec_general_settings_after' ); ?>
