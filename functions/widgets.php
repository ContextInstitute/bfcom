<?php


// new widget to show topics, but with latest author

function register_la_widget() {
    register_widget("bsp_Activity_Widget");

}

add_action('widgets_init', 'register_la_widget');


//latest activity widget
class bsp_Activity_Widget extends WP_Widget {

	/**
	 * bbPress Topic Widget
	 *
	 * Registers the topic widget
	 *
	 * @since bbPress (r2653)
	 *
	 * @uses apply_filters() Calls 'bbp_topics_widget_options' with the
	 *                        widget options
	 */
	public function __construct() {
		$widget_ops = apply_filters( 'bsp_topics_widget_options', array(
			'classname'   => 'widget_display_topics',
			'description' => __( 'A list of recent topics, sorted by popularity or freshness with latest author.', 'bbp-style-pack' )
		) );

		parent::__construct( false, __( '(Style Pack) Latest Activity', 'bbp-style-pack' ), $widget_ops );
	}

	/**
	 * Register the widget
	 *
	 * @since bbPress (r3389)
	 *
	 * @uses register_widget()
	 */
	public static function register_widget() {
		register_widget( 'bsp_Activity_Widget' );
	}

	/**
	 * Displays the output, the topic list
	 *
	 * @since bbPress (r2653)
	 *
	 * @param mixed $args
	 * @param array $instance
	 * @uses apply_filters() Calls 'bbp_topic_widget_title' with the title
	 * @uses bbp_topic_permalink() To display the topic permalink
	 * @uses bbp_topic_title() To display the topic title
	 * @uses bbp_get_topic_last_active_time() To get the topic last active
	 *                                         time
	 * @uses bbp_get_topic_id() To get the topic id
	 */
	public function widget( $args = array(), $instance = array() ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance );

		// Typical WordPress filter
		$settings['title'] = apply_filters( 'widget_title',           $settings['title'], $instance, $this->id_base );

		// bbPress filter
		$settings['title'] = apply_filters( 'bsp_latest_activity_widget_title', $settings['title'], $instance, $this->id_base );
		
		//set default for exclude
		
		//see if we have multiple forums
				//check if it's any and if so set post_parent__in
				if ($settings['parent_forum'] == 'any' ) $settings['post_parent__in'] =''; //to set up a null post parent in 
				//then test if it's not number (either single forum or 0 for root) - if it is, then that's also ok, so don't do further tests
				elseif ( !is_numeric( $settings['parent_forum'] ) ) {
						//otherwise it is a list of forums (or rubbish!) so we need to create a post_parent_in array
						$settings['post_parent__in'] = explode(",",$settings['parent_forum']);
						$settings['parent_forum'] = '' ; // to nullify it
					}
				//it's a single forum so 
				else $settings['post_parent__in'] =''; //to set up a null post parent in
				
				//now check if we should actually be excluding instead of including - done this way as $settings['exclude_forum'] may be blank, which means we need to do the above to ensure it catches include forums if it is.
				if (!empty ($settings['exclude_forum'])) {
					$settings['post_parent__in'] = '' ; // to get rid of it
					$settings['parent_forum'] = '' ; // to nullify it
					//we should be excluding, so ...
					//check if it makes sense !
						if (is_numeric( $settings['excluded_forum'] ) ) $settings['post_parent__not_in'] =  array ($settings['excluded_forum']) ;
						if ( !is_numeric( $settings['excluded_forum'] ) ) {
								//otherwise it is a list of forums (or rubbish!) so we need to create a post_parent__not_in  array
								$settings['post_parent__not_in'] = explode(",",$settings['excluded_forum']);
						}
						
				}
		
		// How do we want to order our results?
		switch ( $settings['order_by'] ) {

			// Order by most recent replies
			case 'freshness' :
				$topics_query = array(
					'post_type'           => bbp_get_topic_post_type(),
					'post_parent'         => $settings['parent_forum'],
					'posts_per_page'      => (int) $settings['max_shown'],
					'post_status'         => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ),
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					'meta_key'            => '_bbp_last_active_time',
					'orderby'             => 'meta_value',
					'order'               => 'DESC',
				);
				break;

			// Order by total number of replies
			case 'popular' :
				$topics_query = array(
					'post_type'           => bbp_get_topic_post_type(),
					'post_parent'         => $settings['parent_forum'],
					'posts_per_page'      => (int) $settings['max_shown'],
					'post_status'         => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ),
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					'meta_key'            => '_bbp_reply_count',
					'orderby'             => 'meta_value',
					'order'               => 'DESC'
				);
				break;

			// Order by which topic was created most recently
			case 'newness' :
			default :
				$topics_query = array(
					'post_type'           => bbp_get_topic_post_type(),
					'post_parent'         => $settings['parent_forum'],
					'posts_per_page'      => (int) $settings['max_shown'],
					'post_status'         => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ),
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					'order'               => 'DESC'
				);
				break;
		}
		//set size for avatar
		global $bsp_style_settings_la ;
		$avatar_size = (!empty($bsp_style_settings_la['AvatarSize']) ? $bsp_style_settings_la['AvatarSize']  : '14') ;
		
		
		//allow other plugin (eg private groups) to filter this query
		$topics_query = apply_filters( 'bsp_activity_widget', $topics_query ) ;
		
		// The default forum query with allowed forum ids array added
		//reset the max to be shown
		$topics_query['posts_per_page'] =(int) $settings['max_shown'] ;
		
		//add any include/exclude forums ;
		if (!empty ($settings['post_parent__not_in'])) $topics_query['post_parent__not_in'] = $settings['post_parent__not_in'] ;
		else $topics_query['post_parent__in']= $settings['post_parent__in'] ;
		
		// Note: private and hidden forums will be excluded via the
		// bbp_pre_get_posts_normalize_forum_visibility action and function.
		$widget_query = new WP_Query( $topics_query );
				// Bail if no topics are found
		if ( ! $widget_query->have_posts() ) {
			return;
		}
		
		

		echo $args['before_widget'];

		if ( !empty( $settings['title'] ) ) {
			echo '<span class="bsp-la-title">' . $args['before_title'] .  $settings['title'] . $args['after_title'] . '</span>' ;
		} ?>
		
		<ul>

			<?php while ( $widget_query->have_posts() ) :
				

				$widget_query->the_post();
				$topic_id    = bbp_get_topic_id( $widget_query->post->ID );
				$author_link = '';
				
				//check if this topic has a reply
				$reply = get_post_meta( $topic_id, '_bbp_last_reply_id',true);
				
				// Maybe get the topic author
				if ( ! empty( $settings['show_user'] ) ) {
				//do we display avatar?
					if (!empty ($settings['hide_avatar'])) $type='name' ;
					else $type='both' ;
				//if no reply the author
				if (empty ($reply)) $author_link = bbp_get_topic_author_link( array( 'post_id' => $topic_id, 'type' => $type, 'size' => $avatar_size ) );
				//if has a reply then get the author of the reply
				else $author_link = bbp_get_reply_author_link( array( 'post_id' => $reply, 'type' => $type, 'size' => $avatar_size) );
				} ?>

				<li>
				<?php 
				//if no replies set the link to the topic
				if (empty ($reply)) {?>
					<a class="bsp-la-reply-topic-title" href="<?php bbp_topic_permalink( $topic_id ); ?>"><?php bbp_topic_title( $topic_id ); ?></a>
				<?php } 
				//if replies then set link to the latest reply
				else { 
					echo '<a class="bsp-la-reply-topic-title " href="' . esc_url( bbp_get_reply_url( $reply ) ) . '" title="' . esc_attr( bbp_get_reply_excerpt( $reply, 50 ) ) . '">' . bbp_get_reply_topic_title( $reply ) . '</a>';
				} ?>
				
					<?php if ( ! empty( $author_link ) ) : ?>
						<div class = "bsp-activity-author">
						<?php 
						
							if (empty($reply)) {
							echo '<span class="bsp-la-text">' ;
							printf( _x( 'topic by %1$s', 'widgets', 'bbp-style-pack' ), '</span> <span class="bsp-la-topic-author topic-author">' . $author_link . '</span>' ); 
							}
							else {
							echo '<span class="bsp-la-text">' ;
							printf( _x( 'reply by %1$s', 'widgets', 'bbp-style-pack' ), '</span> <span class=" bsp-la-topic-author topic-author">' . $author_link . '</span>' ); 
							} ?>
							
						</div>
						<?php endif; ?>
										
					
					<?php if ( ! empty( $settings['show_count'] ) && bbp_get_topic_post_type() == get_post_type()) {
									$topic = get_the_ID(); ?>
										<span class="bsp-topic-posts">
											<?php if ( ! empty( $settings['reply_count_label'] )) echo $settings['reply_count_label'] ; ?>
											<?php bbp_topic_reply_count($topic); ?>
										</span>
					<?php } ?>
					
					
					

					<?php if ( ! empty( $settings['show_freshness'] ) ) : ?>
					<?php $output = bbp_get_topic_last_active_time( $topic_id ) ; 
						//shorten freshness?
						if ( ! empty( $settings['shorten_freshness'] ) ) $output = preg_replace( '/, .*[^ago]/', ' ', $output ); ?>
						<div class = "bsp-activity-freshness"><?php 
						echo '<span class="bsp-la-freshness">'.$output. '</span>'  ;
						//bbp_topic_last_active_time( $topic_id ); ?></div>
					
					<?php endif; ?>
					
					<?php if ( ! empty( $settings['show_forum'] ) ) : ?>
					<div class = "bsp-activity-forum">
						<?php
						$forum = bbp_get_topic_forum_id($topic_id);
						$forum1 = bbp_get_forum_title($forum) ;
						$forum2 = esc_url( bbp_get_forum_permalink( $forum )) ;
						echo '<span class="bsp-la-text">' ;
						_e ( 'in ', 'bbp-style-pack' ) ;
						echo '</span>' ; ?>
						<a class="bsp-la-forum-title bbp-forum-title" href="<?php echo $forum2; ?>"><?php echo $forum1 ; ?></a>
					</div>
					<?php endif; ?>
				
						

					

				</li>

			<?php endwhile; ?>

		</ul>

		<?php echo $args['after_widget'];

		// Reset the $post global
		wp_reset_postdata();
	}

	/**
	 * Update the topic widget options
	 *
	 * @since bbPress (r2653)
	 *
	 * @param array $new_instance The new instance options
	 * @param array $old_instance The old instance options
	 */
	public function update( $new_instance = array(), $old_instance = array() ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['order_by']     = strip_tags( $new_instance['order_by'] );
		$instance['exclude_forum']     = (bool) $new_instance['exclude_forum'] ;
		$instance['excluded_forum']     = sanitize_text_field ($new_instance['excluded_forum'] );
		$instance['parent_forum'] = sanitize_text_field( $new_instance['parent_forum'] );
		$instance['show_freshness']    = (bool) $new_instance['show_freshness'];
		$instance['show_user']    = (bool) $new_instance['show_user'];
		$instance['show_forum']    = (bool) $new_instance['show_forum'];
		$instance['show_count']    = (bool) $new_instance['show_count'];
		$instance['reply_count_label']    = $new_instance['reply_count_label'];
		$instance['max_shown']    = (int) $new_instance['max_shown'];
		$instance['shorten_freshness']    = (int) $new_instance['shorten_freshness'];
		$instance['hide_avatar']    = (int) $new_instance['hide_avatar'];

		
		//strip spaces
		$instance['parent_forum'] = str_replace(' ', '', $instance['parent_forum']);
		//check that parent_forum only contains numbers or numbers separated by commas
		$re = '/^\d+(?:,\d+)*$/';
		if ( !preg_match($re, $instance['parent_forum']) ) {
    	$instance['parent_forum'] = 'any';
		}
		
		$instance['excluded_forum'] = str_replace(' ', '', $instance['excluded_forum']);
		//check that parent_forum only contains numbers or numbers separated by commas
		if ( !preg_match($re, $instance['excluded_forum']) ) {
    	$instance['excluded_forum'] = '';
		}
		
		return $instance;
	}

	/**
	 * Output the topic widget options form
	 *
	 * @since bbPress (r2653)
	 *
	 * @param $instance Instance
	 * @uses BBP_Topics_Widget::get_field_id() To output the field id
	 * @uses BBP_Topics_Widget::get_field_name() To output the field name
	 */
	public function form( $instance = array() ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance ); ?>
		
		<p><label for="<?php echo $this->get_field_id( 'title'     ); ?>"><?php _e( 'Title:',                  'bbp-style-pack' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'title'     ); ?>" name="<?php echo $this->get_field_name( 'title'     ); ?>" type="text" value="<?php echo esc_attr( $settings['title']     ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'max_shown' ); ?>"><?php _e( 'Maximum topics to show:', 'bbp-style-pack' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'max_shown' ); ?>" name="<?php echo $this->get_field_name( 'max_shown' ); ?>" type="text" value="<?php echo esc_attr( $settings['max_shown'] ); ?>" /></label></p>
		<hr>
		<p>
		<label for="<?php echo $this->get_field_id( 'exclude_forum' ); ?>"><input type="radio" id="<?php echo $this->get_field_id( 'exclude_forum' ); ?>" name="<?php echo $this->get_field_name( 'exclude_forum' ); ?>" <?php checked( false, $settings['exclude_forum'] ); ?> value="0" /></label>
			
			<label for="<?php echo $this->get_field_id( 'parent_forum' ); ?>"><?php _e( 'From Forum ID(s):', 'bbp-style-pack' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'parent_forum' ); ?>" name="<?php echo $this->get_field_name( 'parent_forum' ); ?>" type="text" value="<?php echo esc_attr( $settings['parent_forum'] ); ?>" />
			</label>

			<br />

			<small><?php _e( '"0" to show only root - "any" to show all - ', 'bbp-style-pack' ); ?></small>
			<small><br /><?php _e( 'a single forum eg "2921"  - or forums separated by commas eg "2921,2922"', 'bbp-style-pack' ); ?></small>
			<small><br /><?php _e( 'See dashboard>forums>all forums to find the ID of a forum', 'bbp-style-pack' ); ?></small>
			
		</p>
		<?php _e( 'OR', 'bbp-style-pack' ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_forum' ); ?>"><input type="radio" id="<?php echo $this->get_field_id( 'exclude_forum' ); ?>" name="<?php echo $this->get_field_name( 'exclude_forum' ); ?>" <?php checked( true, $settings['exclude_forum'] ); ?> value="1" /></label>
			
			<label for="<?php echo $this->get_field_id( 'excluded_forum' ); ?>"><?php _e( 'Exclude Forum ID(s):', 'bbp-style-pack' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'excluded_forum' ); ?>" name="<?php echo $this->get_field_name( 'excluded_forum' ); ?>" type="text" value="<?php echo esc_attr( $settings['excluded_forum'] ); ?>" />
			</label>

			<br />

			<small><br /><?php _e( 'a single forum eg "2921"  - or forums separated by commas eg "2921,2922"', 'bbp-style-pack' ); ?></small>
						
		</p>
		<hr>
		<p><label for="<?php echo $this->get_field_id( 'show_freshness' ); ?>"><?php _e( 'Show Freshness:',    'bbp-style-pack' ); ?> <input type="checkbox" id="<?php echo $this->get_field_id( 'show_freshness' ); ?>" name="<?php echo $this->get_field_name( 'show_freshness' ); ?>" <?php checked( true, $settings['show_freshness'] ); ?> value="1" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'shorten_freshness' ); ?>"><?php _e( 'Shorten freshness:',    'bbp-style-pack' ); ?> <input type="checkbox" id="<?php echo $this->get_field_id( 'shorten_freshness' ); ?>" name="<?php echo $this->get_field_name( 'shorten_freshness' ); ?>" <?php checked( true, $settings['shorten_freshness'] ); ?> value="1" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'show_user' ); ?>"><?php _e( 'Show topic author:', 'bbp-style-pack' ); ?> <input type="checkbox" id="<?php echo $this->get_field_id( 'show_user' ); ?>" name="<?php echo $this->get_field_name( 'show_user' ); ?>" <?php checked( true, $settings['show_user'] ); ?> value="1" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'hide_avatar' ); ?>"><?php _e( 'Hide Avatar',    'bbp-style-pack' ); ?> <input type="checkbox" id="<?php echo $this->get_field_id( 'hide_avatar' ); ?>" name="<?php echo $this->get_field_name( 'hide_avatar' ); ?>" <?php checked( true, $settings['hide_avatar'] ); ?> value="1" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'show_forum' ); ?>"><?php _e( 'Show Forum:',    'bbp-style-pack' ); ?> <input type="checkbox" id="<?php echo $this->get_field_id( 'show_forum' ); ?>" name="<?php echo $this->get_field_name( 'show_forum' ); ?>" <?php checked( true, $settings['show_forum'] ); ?> value="1" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Show reply count:',    'bbp-style-pack' ); ?> <input type="checkbox" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" <?php checked( true, $settings['show_count'] ); ?> value="1" /></label></p>
		<label for="<?php echo $this->get_field_id( 'reply_count_label' ); ?>"><?php _e( 'Reply Count Label:', 'bbp-style-pack' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'reply_count_label' ); ?>" name="<?php echo $this->get_field_name( 'reply_count_label' ); ?>" type="text" value="<?php echo $settings['reply_count_label']; ?>" />
			</label>
			<br />

			<small><?php _e( 'eg Replies:, No. Replies - etc', 'bbp-style-pack' ); ?></small>
		<p>
			<label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order By:',        'bbp-style-pack' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'order_by' ); ?>" id="<?php echo $this->get_field_name( 'order_by' ); ?>">
				<option <?php selected( $settings['order_by'], 'freshness' ); ?> value="freshness"><?php _e( 'Topics With Recent Replies', 'bbp-style-pack' ); ?></option>
				<option <?php selected( $settings['order_by'], 'newness' );   ?> value="newness"><?php _e( 'Newest Topics',                'bbp-style-pack' ); ?></option>
				<option <?php selected( $settings['order_by'], 'popular' );   ?> value="popular"><?php _e( 'Popular Topics',               'bbp-style-pack' ); ?></option>
				
			</select>
		</p>

		<?php
	}

	/**
	 * Merge the widget settings into defaults array.
	 *
	 * @since bbPress (r4802)
	 *
	 * @param $instance Instance
	 * @uses bbp_parse_args() To merge widget options into defaults
	 */
	public function parse_settings( $instance = array() ) {
		return bbp_parse_args( $instance, array(
			'title'        => __( 'Latest Activity', 'bbp-style-pack' ),
			'max_shown'    => 5,
			'show_date'    => false,
			'show_user'    => false,
			'exclude_forum' => false,
			'excluded_forum' => '',
			'parent_forum' => 'any',
			'show_freshness' => false,
			'shorten_freshness' => false,
			'hide_avatar' => false,
			'show_forum' => false,
			'show_count' => false,
			'reply_count_label' => false,
			'order_by'     => false
		), 'latest_activity_widget_settings' );
	}
}


