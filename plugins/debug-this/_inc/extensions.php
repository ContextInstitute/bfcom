<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Debug_This_Extensions {
	public function __construct() {
		$version = get_bloginfo( 'version' );
		add_debug_extension( 'actions', __( 'Actions', 'debug-this' ), __( '$wp_actions contains all active registered actions', 'debug-this' ), array(
			$this,
			'actions'
		), 'Filters And Actions' );
		add_debug_extension( 'apache', __( 'Apache Information', 'debug-this' ), __( 'Apache version and list of modules', 'debug-this' ), array(
			$this,
			'apache'
		), 'Server' );
		add_debug_extension( 'attachments', __( 'Attachments', 'debug-this' ), __( 'List of post attachments', 'debug-this' ), array(
			$this,
			'attachments'
		), 'Media' );
		add_debug_extension( 'author', __( 'Post Author', 'debug-this' ), __( 'Current author data', 'debug-this' ), array(
			$this,
			'author'
		), 'Users' );
		add_debug_extension( 'backtrace', __( 'Backtrace', 'debug-this' ), __( 'PHP Backtrace', 'debug-this' ), array(
			$this,
			'backtrace'
		), 'PHP' );
		add_debug_extension( 'bloginfo', __( 'Blog Info', 'debug-this' ), __( 'Key/Values for get_bloginfo() or bloginfo()', 'debug-this' ), array(
			$this,
			'bloginfo'
		) );
		add_debug_extension( 'classes', __( 'Classes', 'debug-this' ), __( 'Declared Classes', 'debug-this' ), array(
			$this,
			'classes'
		), 'PHP' );
		add_debug_extension( 'cache', __( 'Object Cache', 'debug-this' ), __( 'Object Cache stats', 'debug-this' ), array(
			$this,
			'cache'
		), 'Cache' );
		add_debug_extension( 'constants', __( 'Constants', 'debug-this' ), __( 'Defined Constants', 'debug-this' ), array(
			$this,
			'constants'
		), 'PHP' );
		add_debug_extension( 'constants-wp', __( 'Constants (WordPress)', 'debug-this' ), __( 'Defined WordPress Constants', 'debug-this' ), array(
			$this,
			'constants_wordpress'
		), 'PHP' );
		add_debug_extension( 'content-width', __( 'Content Width', 'debug-this' ), __( 'global $content_width', 'debug-this' ), array(
			$this,
			'content_width'
		), 'Themes' );
		add_debug_extension( 'context', __( 'Context', 'debug-this' ), __( 'Conditional Context Tags', 'debug-this' ), array(
			$this,
			'context'
		), 'Query' );
		add_debug_extension( 'cron-schedules', __( 'WP Cron Schedules', 'debug-this' ), __( 'WP Cron Schedules', 'debug-this' ), array(
			$this,
			'cron_schedules'
		), 'Cron' );
		add_debug_extension( 'cron-jobs', __( 'WP Cron Jobs', 'debug-this' ), __( 'WP Cron Jobs', 'debug-this' ), array(
			$this,
			'cron_jobs'
		), 'Cron' );
		add_debug_extension( 'css', __( 'CSS', 'debug-this' ), __( 'Rendered CSS', 'debug-this' ), array(
			$this,
			'css'
		), 'Rendered HTML' );
		add_debug_extension( 'dropins', __( 'Dropins', 'debug-this' ), __( 'List of all dropins that replace core WP functionality', 'debug-this' ), array(
			$this,
			'dropins'
		), 'Plugins' );
		add_debug_extension( 'php-extensions', __( 'Extensions', 'debug-this' ), __( 'List of all loaded PHP extensions', 'debug-this' ), array(
			$this,
			'extensions'
		), 'PHP' );
		add_debug_extension( 'file-permissions', __( 'File Permissions', 'debug-this' ), __( 'Info about WP root, plugins and theme directories.', 'debug-this' ), array(
			$this,
			'file_permissions'
		), 'Server' );
		add_debug_extension( 'files', __( 'Files', 'debug-this' ), __( 'All required and included files', 'debug-this' ), array(
			$this,
			'files'
		), 'PHP' );
		add_debug_extension( 'filters', __( 'Filters', 'debug-this' ), __( '$wp_filter contains all registered filters. Callback functions are contained in parentheses', 'debug-this' ), array(
			$this,
			'filters'
		), 'Filters And Actions' );
		add_debug_extension( 'filters-current', __( 'Current', 'debug-this' ), __( 'Current Filters and Actions', 'debug-this' ), array(
			$this,
			'filters_current'
		), 'Filters And Actions' );
		add_debug_extension( 'functions', __( 'Functions', 'debug-this' ), __( 'All defined user functions', 'debug-this' ), array(
			$this,
			'functions'
		), 'PHP' );
		add_debug_extension( 'images', __( 'Images', 'debug-this' ), __( 'Rendered images on the current page/post', 'debug-this' ), array(
			$this,
			'images'
		), 'Rendered HTML' );
		add_debug_extension( 'imagesizes', __( 'Image Sizes', 'debug-this' ), __( 'All registered image sizes. Uses get_intermediate_image_sizes() & global $_wp_additional_image_sizes', 'debug-this' ), array(
			$this,
			'imagesizes'
		), 'Media' );
		add_debug_extension( 'js', __( 'JavaScript', 'debug-this' ), __( 'Rendered JS', 'debug-this' ), array(
			$this,
			'js'
		), 'Rendered HTML' );
		add_debug_extension( 'load-time', __( 'Load Time', 'debug-this' ), __( 'True page load time (sans Debug This)', 'debug-this' ), array(
			$this,
			'load_time'
		), 'Rendered HTML' );
		add_debug_extension( 'menus', __( 'Registered Menus', 'debug-this' ), __( 'All registered menus', 'debug-this' ), array(
			$this,
			'menus'
		), 'Menus' );
		add_debug_extension( 'menus_dynamic', __( 'Dynamic Menus', 'debug-this' ), __( 'Dynamic Menus and Locations', 'debug-this' ), array(
			$this,
			'menus_dynamic'
		), 'Menus' );
		add_debug_extension( 'oembed', __( 'oEmbed', 'debug-this' ), __( 'Registered oEmbed providers', 'debug-this' ), array(
			$this,
			'oembed'
		), 'Media' );
		add_debug_extension( 'options', __( 'Options', 'debug-this' ), __( 'A list of all autoloaded options', 'debug-this' ), array(
			$this,
			'options'
		) );
		add_debug_extension( 'phpinfo', __( 'phpinfo()', 'debug-this' ), __( 'phpinfo()', 'debug-this' ), array(
			$this,
			'phpinfo'
		), 'PHP' );
		add_debug_extension( 'phpini', __( 'php.ini', 'debug-this' ), __( 'php.ini configuration', 'debug-this' ), array(
			$this,
			'phpini'
		), 'PHP' );
		add_debug_extension( 'plugins', __( 'Plugins', 'debug-this' ), __( 'A list of all plugins', 'debug-this' ), array(
			$this,
			'plugins'
		), 'Plugins' );
		add_debug_extension( 'post', __( 'Post', 'debug-this' ), __( 'Single post object', 'debug-this' ), array(
			$this,
			'post'
		), 'Queried Object' );
		add_debug_extension( 'post-meta', __( 'Post Meta', 'debug-this' ), __( 'Post meta for the queried object.', 'debug-this' ), array(
			$this,
			'post_meta'
		), 'Queried Object' );
		add_debug_extension( 'posts', __( 'Post Objects', 'debug-this' ), __( 'Archive post objects', 'debug-this' ), array(
			$this,
			'posts'
		), 'Query' );
		add_debug_extension( 'post-types', __( 'All Post Types', 'debug-this' ), __( 'Lists all registered post types in WordPress', 'debug-this' ), array(
			$this,
			'posttypes'
		), 'Post Types' );
		add_debug_extension( 'post-type-current', __( 'Current Post Type', 'debug-this' ), __( 'Post type for the queried object', 'debug-this' ), array(
			$this,
			'posttype_current'
		), 'Post Types' );
		add_debug_extension( 'queries', __( 'Saved Queries', 'debug-this' ), __( 'All queries run on the current page load (sans Debug This)', 'debug-this' ), array(
			$this,
			'queries'
		), 'Query' );
		add_debug_extension( 'request', __( 'Request', 'debug-this' ), __( 'Current request', 'debug-this' ), array(
			$this,
			'request'
		), 'Query' );
		add_debug_extension( 'rewrites', __( 'Rewrites', 'debug-this' ), __( 'A list of all cached rewrites. To refresh the cache, visit Settings->Permalinks', 'debug-this' ), array(
			$this,
			'rewrites'
		), 'Query' );
		add_debug_extension( 'scripts', __( 'Scripts', 'debug-this' ), __( 'List of registered scripts. Uses $wp_scripts', 'debug-this' ), array(
			$this,
			'scripts'
		), 'Enqueue' );
		add_debug_extension( 'server', __( '$_SERVER', 'debug-this' ), __( '$_SERVER information', 'debug-this' ), array(
			$this,
			'server'
		), 'Server' );
		add_debug_extension( 'shortcodes', __( 'Shortcodes', 'debug-this' ), __( 'List of all registered shortcodes', 'debug-this' ), array(
			$this,
			'shortcodes'
		), 'Shortcodes' );
		add_debug_extension( 'shortcodes-regex', __( 'Shortcodes Regex', 'debug-this' ), __( 'Dynamically generated shortcode regex - get_shortcode_regex()', 'debug-this' ), array(
			$this,
			'shortcodes_regex'
		), 'Shortcodes' );
		add_debug_extension( 'sidebars-current', __( 'Current Sidebars', 'debug-this' ), __( 'All instances of get_sidebar() and dynamic_sidebar() in the current template', 'debug-this' ), array(
			$this,
			'sidebars_rendered'
		), 'Sidebar' );
		add_debug_extension( 'sidebars', __( 'Registered Sidebars', 'debug-this' ), __( 'All registered sidebars. Uses $wp_registered_sidebars', 'debug-this' ), array(
			$this,
			'sidebars_registered'
		), 'Sidebar' );
		add_debug_extension( 'styles', __( 'Styles', 'debug-this' ), __( 'List of rendered and registered styles', 'debug-this' ), array(
			$this,
			'styles'
		), 'Enqueue' );
		add_debug_extension( 'taxonomies', __( 'Taxonomies', 'debug-this' ), __( 'Lists all registered taxonomies in WordPress', 'debug-this' ), array(
			$this,
			'taxonomies'
		), 'Taxonomy' );
		add_debug_extension( 'template', __( 'Current Template', 'debug-this' ), __( 'Current template file', 'debug-this' ), array(
			$this,
			'template'
		), 'Themes' );
		add_debug_extension( 'terms', __( 'Post Terms', 'debug-this' ), __( 'All terms for the current single post/page', 'debug-this' ), array(
			$this,
			'terms'
		), 'Taxonomy' );
		add_debug_extension( 'terms-all', __( 'All Terms', 'debug-this' ), __( 'A list of all terms', 'debug-this' ), array(
			$this,
			'terms_all'
		), 'Taxonomy' );
		if ( $version >= 3.4 ) {
			add_debug_extension( 'themes', __( 'Themes', 'debug-this' ), __( 'List of all WP_Theme objects', 'debug-this' ), array(
				$this,
				'themes'
			), 'Themes' );
		}
		add_debug_extension( 'users', __( 'All Users', 'debug-this' ), __( 'List of all users', 'debug-this' ), array(
			$this,
			'users'
		), 'Users' );
		add_debug_extension( 'variables', __( 'Variables', 'debug-this' ), __( 'List of all defined variables', 'debug-this' ), array(
			$this,
			'variables'
		), 'PHP' );
		add_debug_extension( 'widgets', __( 'Widgets' ), __( 'All registered widgets - uses $wp_widget_factor->widgets', 'debug-this' ), array(
			$this,
			'widgets'
		), 'Sidebar' );
		add_debug_extension( 'wp-debug', __( 'WP Debug' ), __( 'Displays a list of notices rendered by WP_DEBUG mode', 'debug-this' ), array(
			$this,
			'wp_debug'
		), 'PHP' );
		add_debug_extension( 'wp_query', __( 'WP_Query' ), __( 'Current WP_Query object - global $wp_query', 'debug-this' ), array(
			$this,
			'wp_query'
		), 'Query' );
		add_debug_extension( 'help', __( 'Debug This Menu', 'debug-this' ), __( 'Modes Navigation', 'debug-this' ), array(
			$this,
			'help'
		) );
	}

	public function actions() {
		global $wp_actions;
		$wp_actions['shutdown'] = 1;
		$debug                  = print_r( $wp_actions, true );

		return $debug;
	}

	public function attachments() {
		global $post;
		$args        = array(
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'posts_per_page' => - 1
		);
		$attachments = get_children( $args );
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$title = $attachment->post_title ? $attachment->post_title : __( 'No Title', 'debug-this' );
				$debug .= "<h3 class='emphasize'>$title</h3><ul>";
				$debug .= '<li>' . sprintf( __( 'ID: %s', 'debug-this' ), $attachment->ID ) . '</li>';
				$debug .= '<li>' . sprintf( __( 'Mime Type: %s', 'debug-this' ), $attachment->post_mime_type ) . '</li>';
				$url = wp_get_attachment_url( $attachment->ID );
				$debug .= '<li>' . __( 'URL: ', 'debug-this' ) . "<a href='$url'>$url</a></li>";
				if ( $attachment->post_content ) {
					$debug .= '<li>' . sprintf( __( 'Description: %s', 'debug-this' ), $attachment->post_content );
				}
				$debug .= '</ul>';
			}
		} else {
			$debug = __( 'No attachments found.', 'debug-this' );
		}

		return $debug;
	}

	public function apache() {
		if ( ! preg_match( '/[Aa]pache/', $_SERVER["SERVER_SOFTWARE"] ) ) {
			return __( 'This extension only works on Apache.', 'debug-this' );
		}

		$debug = '<h3 class="emphasize">' . __( 'Version', 'debug-this' ) . '</h3>';
		$debug .= apache_get_version();
		$debug .= '<h3 class="emphasize">' . __( 'Modules', 'debug-this' ) . '</h3>';
		$debug .= print_r( apache_get_modules(), true );
		if ( ! $debug ) {
			$debug = __( "No modules were found. This could be a symptom of running PHP as CGI.", 'debug-this' );
		}

		return $debug;
	}

	public function author() {
		if ( ! is_singular() ) {
			return __( 'This mode can only be used on a single post/page.', 'debug-this' );
		}
		global $post, $authordata;
		setup_postdata( $post );
		$debug = print_r( $authordata, true );

		return $debug;
	}

	public function backtrace() {
		$version = get_bloginfo( 'version' );
		if ( $version >= 3.4 ) {
			$debug = '<h3>' . __( 'Backtrace Summary', 'debug-this' ) . '</h3>';
			$debug .= print_r( explode( ', ', wp_debug_backtrace_summary() ), true );
		}
		$debug .= '<h3>' . __( 'debug_backtrace()', 'debug-this' ) . '</h3>';
		$debug .= htmlentities( print_r( debug_backtrace(), true ) );

		return $debug;
	}

	public function bloginfo() {
		global $wp_version;
		$bloginfo = array(
			'url'                  => get_bloginfo( 'url' ),
			'wpurl'                => get_bloginfo( 'wpurl' ),
			'description'          => get_bloginfo( 'description' ),
			'rdf_url'              => get_bloginfo( 'rdf_url' ),
			'rss_url'              => get_bloginfo( 'rss_url' ),
			'rss2_url'             => get_bloginfo( 'rss2_url' ),
			'atom_url'             => get_bloginfo( 'atom_url' ),
			'comments_atom_url'    => get_bloginfo( 'comments_atom_url' ),
			'comments_rss2_url'    => get_bloginfo( 'comments_rss2_url' ),
			'pingback_url'         => get_bloginfo( 'pingback_url' ),
			'stylesheet_url'       => get_bloginfo( 'stylesheet_url' ),
			'stylesheet_directory' => get_bloginfo( 'stylesheet_directory' ),
			'template_directory'   => get_bloginfo( 'template_directory' ),
			'template_url'         => get_bloginfo( 'template_url' ),
			'admin_email'          => get_bloginfo( 'admin_email' ),
			'charset'              => get_bloginfo( 'charset' ),
			'html_type'            => get_bloginfo( 'html_type' ),
			'version'              => get_bloginfo( 'version' ),
			'language'             => get_bloginfo( 'language' ),
			'name'                 => get_bloginfo( 'name' )
		);
		$debug    = print_r( $bloginfo, true );

		return $debug;
	}

	public function cache() {
		# Appropriated from WP Debug Bar Plugin - class-debug-bar-object-cache.php
		global $wp_object_cache;
		ob_start();
		$wp_object_cache->stats();
		$debug = ob_get_contents();
		ob_end_clean();

		return $debug;
	}

	public function classes() {
		$debug = print_r( get_declared_classes(), true );

		return $debug;
	}

	public function constants() {
		$constants = get_defined_constants();
		foreach ( $constants as $constant => $value ) {
			if ( $value === false ) {
				$constants[ $constant ] = '<span class="error">' . __( 'false', 'debug-this' ) . '</span>';
			} elseif ( $value === '' ) {
				$constants[ $constant ] = '<span class="error">' . __( 'empty string', 'debug-this' ) . '</span>';
			}
		}
		$debug = print_r( $constants, true );

		return $debug;
	}

	public function constants_wordpress() {
		$wp_constants = array(
			'AUTOSAVE_INTERVAL',
			'CORE_UPGRADE_SKIP_NEW_BUNDLED',
			'DISABLE_WP_CRON',
			'EMPTY_TRASH_DAYS',
			'IMAGE_EDIT_OVERWRITE',
			'MEDIA_TRASH',
			'WPLANG',
			'WP_DEFAULT_THEME',
			'WP_CRON_LOCK_TIMEOUT',
			'WP_MAIL_INTERVAL',
			'WP_POST_REVISIONS',
			'WP_MAX_MEMORY_LIMIT',
			'WP_MEMORY_LIMIT',
			'APP_REQUEST',
			'COMMENTS_TEMPLATE',
			'DOING_AJAX',
			'DOING_AUTOSAVE',
			'DOING_CRON',
			'IFRAME_REQUEST',
			'IS_PROFILE_PAGE',
			'SHORTINIT',
			'WP_ADMIN',
			'WP_BLOG_ADMIN',
			'WP_IMPORTING',
			'WP_INSTALLING',
			'WP_LOAD_IMPORTERS',
			'WP_NETWORK_ADMIN',
			'WP_REPAIRING',
			'WP_SETUP_CONFIG',
			'WP_UNINSTALL_PLUGIN',
			'WP_USER_ADMIN',
			'XMLRPC_REQUEST',
			'ABSPATH',
			'WPINC',
			'WP_LANG_DIR',
			'WP_PLUGIN_DIR',
			'WP_PLUGIN_URL',
			'WP_CONTENT_DIR',
			'WP_CONTENT_URL',
			'WP_HOME',
			'WP_SITEURL',
			'WP_TEMP_DIR',
			'WPMU_PLUGIN_DIR',
			'WPMU_PLUGIN_URL',
			'DB_CHARSET',
			'DB_COLLATE',
			'DB_HOST',
			'DB_NAME',
			'DB_PASSWORD',
			'DB_USER',
			'WP_ALLOW_REPAIR',
			'CUSTOM_USER_TABLE',
			'CUSTOM_USER_META_TABLE',
			'ALLOW_SUBDIRECTORY_INSTALL',
			'BLOGUPLOADDIR',
			'BLOG_ID_CURRENT_SITE',
			'DOMAIN_CURRENT_SITE',
			'DIEONDBERROR',
			'ERRORLOGFILE',
			'MULTISITE',
			'NOBLOGREDIRECT',
			'PATH_CURRENT_SITE',
			'UPLOADBLOGSDIR',
			'SITE_ID_CURRENT_SITE',
			'SUBDOMAIN_INSTALL',
			'SUNRISE',
			'UPLOADS',
			'WPMU_ACCEL_REDIRECT',
			'WPMU_SENDFILE',
			'WP_ALLOW_MULTISITE',
			'WP_CACHE',
			'COMPRESS_CSS',
			'COMPRESS_SCRIPTS',
			'CONCATENATE_SCRIPTS',
			'ENFORCE_GZIP',
			'FS_CHMOD_DIR',
			'FS_CHMOD_FILE',
			'FS_CONNECT_TIMEOUT',
			'FS_METHOD',
			'FS_TIMEOUT',
			'FTP_BASE',
			'FTP_CONTENT_DIR',
			'FTP_HOST',
			'FTP_LANG_DIR',
			'FTP_PASS',
			'FTP_PLUGIN_DIR',
			'FTP_PRIKEY',
			'FTP_PUBKEY',
			'FTP_SSH',
			'FTP_SSL',
			'FTP_USER',
			'WP_PROXY_BYPASS_HOSTS',
			'WP_PROXY_HOST',
			'WP_PROXY_PASSWORD',
			'WP_PROXY_PORT',
			'WP_PROXY_USERNAME',
			'WP_HTTP_BLOCK_EXTERNAL',
			'WP_ACCESSIBLE_HOSTS',
			'BACKGROUND_IMAGE',
			'HEADER_IMAGE',
			'HEADER_IMAGE_HEIGHT',
			'HEADER_IMAGE_WIDTH',
			'HEADER_TEXTCOLOR',
			'NO_HEADER_TEXT',
			'STYLESHEETPATH',
			'TEMPLATEPATH',
			'WP_USE_THEMES',
			'SAVEQUERIES',
			'SCRIPT_DEBUG',
			'WP_DEBUG',
			'WP_DEBUG_DISPLAY',
			'WP_DEBUG_LOG',
			'ADMIN_COOKIE_PATH',
			'ALLOW_UNFILTERED_UPLOADS',
			'AUTH_COOKIE',
			'AUTH_KEY',
			'AUTH_SALT',
			'COOKIEHASH',
			'COOKIEPATH',
			'COOKIE_DOMAIN',
			'CUSTOM_TAGS',
			'DISALLOW_FILE_EDIT',
			'DISALLOW_FILE_MODS',
			'DISALLOW_UNFILTERED_HTML',
			'FORCE_SSL_ADMIN',
			'FORCE_SSL_LOGIN',
			'LOGGED_IN_COOKIE',
			'LOGGED_IN_KEY',
			'LOGGED_IN_SALT',
			'NONCE_KEY',
			'NONCE_SALT',
			'PASS_COOKIE',
			'PLUGINS_COOKIE_PATH',
			'SECURE_AUTH_COOKIE',
			'SECURE_AUTH_KEY',
			'SECURE_AUTH_SALT',
			'SITECOOKIEPATH',
			'TEST_COOKIE',
			'USER_COOKIE'
		);
		ksort( $wp_constants );
		$defined_constants   = array();
		$undefined_constants = array();
		foreach ( $wp_constants as $constant ) {
			if ( ! defined( $constant ) ) {
				unset( $wp_constants[ $constant ] );
				$undefined_constants[] = $constant;
			} else {
				$value = constant( $constant );
				if ( $value === false ) {
					$defined_constants[ $constant ] = '<span class="error">' . __( 'false', 'debug-this' ) . '</span>';
				} elseif ( $value === '' ) {
					$defined_constants[ $constant ] = '<span class="error">' . __( 'empty string', 'debug-this' ) . '</span>';
				} else {
					$defined_constants[ $constant ] = $value;
				}
			}
		}
		ksort( $undefined_constants );
		$debug = '<h3 class="emphasize">' . __( 'Defined Constants', 'debug-this' ) . '</h3>';
		$debug .= print_r( $defined_constants, true );
		$debug .= '<h3 class="emphasize">' . __( 'Undefined Constants', 'debug-this' ) . '</h3>';
		$debug .= print_r( $undefined_constants, true );

		return $debug;
	}

	public function content_width() {
		global $content_width;

		return $content_width;
	}

	public function cron_schedules() {
		$schedules = wp_get_schedules();
		$debug     = print_r( $schedules, true );

		return $debug;
	}

	public function cron_jobs() {
		$jobs = _get_cron_array();
		if ( $jobs ) {
			$debug = print_r( $jobs, true );
		} else {
			$debug = __( 'No cron jobs found.', 'debug-this' );
		}

		return $debug;
	}

	public function context() {
		global $wp_query;

		$conditionals = array(
			'is_single',
			'is_preview',
			'is_page',
			'is_archive',
			'is_date',
			'is_year',
			'is_month',
			'is_day',
			'is_time',
			'is_author',
			'is_category',
			'is_tag',
			'is_tax',
			'is_search',
			'is_feed',
			'is_comment_feed',
			'is_trackback',
			'is_home',
			'is_404',
			'is_comments_popup',
			'is_paged',
			'is_admin',
			'is_attachment',
			'is_singular',
			'is_robots',
			'is_posts_page',
			'is_post_type_archive'
		);
		$debug        = "<ul>";
		foreach ( $conditionals as $conditional ) {
			if ( $wp_query->$conditional ) {
				$debug .= "<li>$conditional</li>";
			}
		}
		$debug .= "</ul>";
		$debug = apply_filters( 'debug_context', $debug );

		return $debug;
	}

	public function css( $buffer, $template ) {
		//Make backwards compatible for no pretty permalinks
		global $wp;
		$debug = sprintf( __( 'Template: %s', 'debug-this' ), $template ) . "\n";
		$debug .= sprintf( __( 'URL: %s', 'debug-this' ), get_bloginfo( 'url' ) . '/' . $wp->request ) . "\n";
		$debug .= '<h3 class="emphasize">' . __( 'Stylesheets', 'debug-this' ) . '</h3>';
		preg_match_all( '/(http.+\.css)/', $buffer, $matches );
		$debug .= print_r( $matches[0], true );

		return $debug;
	}

	public function dropins() {
		include_once ABSPATH . '/wp-admin/includes/plugin.php';
		$dropins = get_dropins();
		if ( $dropins ) {
			$debug = print_r( $dropins, true );
		} else {
			$debug = sprintf( __( "No dropins found. To learn more, please see: %s", 'debug-this' ), "<a href='http://hakre.wordpress.com/2010/05/01/must-use-and-drop-ins-plugins/'>http://hakre.wordpress.com/2010/05/01/must-use-and-drop-ins-plugins/</a>" );
		}

		return $debug;
	}

	public function extensions() {
		$debug = print_r( get_loaded_extensions(), true );

		return $debug;
	}

	public function file_permissions() {

		if ( ! preg_match( '/[Aa]pache/', $_SERVER["SERVER_SOFTWARE"] ) ) {
			return __( 'This extension has only been tested on Apache.', 'debug-this' );
		}

		function debug_this_file_info( $file, $recommended_perms, $current ) {
			$output = "<h3 class='emphasize'>$file</h3>";
			$perms  = debug_this_get_file_perms( $file );
			if ( $perms ) {
				$perms_output = '';
				$rwx          = debug_this_convert_perms_to_rwx( $perms, $file );
				if ( $perms !== $recommended_perms ) {
					$perms_output = '<span class="error">' . sprintf( __( '%s %s Recommended: %s - To change, run: chmod %s %s', 'debug-this' ), $perms, $rwx, $recommended_perms, $recommended_perms, $file ) . "</span>";
				}
				$perms .= " $rwx";
				$output .= sprintf( __( 'Permissions: %s', 'debug-this' ), $perms_output ? $perms_output : $perms ) . "\n";
			}

			$own = debug_this_get_file_ownership( $file );
			if ( $own ) {
				$user_perm  = $perms[1];
				$group_perm = $perms[2];
				if ( $current['user']['name'] === $own['user']['name'] && (int) $user_perm < 4 ) {
					$user = "<span class='error'>{$own['user']['name']}</span>";
				} else {
					$user = "<span class='okay'>{$own['user']['name']}</span>";
				}

				if ( $current['group']['name'] === $own['group']['name'] && (int) $group_perm < 4 ) {
					$group = "<span class='error'>{$own['group']['name']}</span>";
				} else {
					$group = "<span class='okay'>{$own['group']['name']}</span>";
				}

				if ( $current['group']['name'] !== $own['group']['name'] && $current['user']['name'] !== $own['user']['name'] ) {
					$output .= '<span class="error">' . __( 'The current WordPress user might not have access to this file/folder.', 'debug-this' ) . "</span>\n";
				}

				$output .= sprintf( __( 'Owner/Group: %s:%s', 'debug-this' ), $user, $group ) . "\n";
			}

			return $output;
		}

		$legend = '<span class="okay">' . __( 'access', 'debug-this' ) . '</span> - <span class="error">' . __( 'no access', 'debug-this' ) . "</span>";
		$debug  = sprintf( __( 'Rubric: %s', 'debug-this' ), $legend );

		$user         = posix_getpwuid( getmyuid() );
		$group        = posix_getgrgid( getmygid() );
		$current_user = compact( 'user', 'group' );

		$debug .= '<h3 class="emphasize">' . __( 'WordPress User', 'debug-this' ) . '</h3>';
		$debug .= sprintf( __( 'User: %s', 'debug-this' ), $user['name'] ) . "\n";
		$debug .= sprintf( __( 'Group: %s', 'debug-this' ), $group['name'] );

		$debug .= debug_this_file_info( ABSPATH, '0755', $current_user );
		if ( file_exists( ABSPATH . '.htaccess' ) ) {
			$debug .= debug_this_file_info( ABSPATH . '.htaccess', '0604', $current_user );
		}

		if ( file_exists( ABSPATH . 'php.ini' ) ) {
			$debug .= debug_this_file_info( ABSPATH . 'php.ini', '0600', $current_user );
		}

		if ( file_exists( ABSPATH . 'wp-config.php' ) ) {
			$debug .= debug_this_file_info( ABSPATH . 'wp-config.php', '0600', $current_user );
		} else {
			$parts = explode( '/', trim( ABSPATH, '/' ) );
			array_pop( $parts );
			$one_below = '/' . implode( '/', $parts ) . '/wp-config.php';
			if ( file_exists( $one_below ) ) {
				$debug .= debug_this_file_info( $one_below, '0600', $current_user );
			} else {
				$debug .= "<h3 class='emphasize error'>wp-config.php</h3>";
				$debug .= '<span class="error">' . __( "Couldn't find wp-config.php!", 'debug-this' ) . '</span>';
			}
		}

		$debug .= debug_this_file_info( WP_CONTENT_DIR, '0755', $current_user );
		$debug .= debug_this_file_info( WP_PLUGIN_DIR, '0755', $current_user );
		$debug .= debug_this_file_info( get_theme_root(), '0755', $current_user );
		$uploads = wp_upload_dir();
		$debug .= debug_this_file_info( $uploads['basedir'], '0755', $current_user );

		return $debug;
	}

	public function files() {
		$debug = '<h3 class="emphasize">' . __( 'Required Files', 'debug-this' ) . '</h3>';
		$debug .= print_r( get_required_files(), true );
		$debug .= '<h3 class="emphasize">' . __( 'Included Files', 'debug-this' ) . '</h3>';
		$debug .= print_r( get_included_files(), true );

		return $debug;
	}

	public function filters() {
		global $wp_filter;
		$debug = '';
		foreach ( $wp_filter as $id => $groups ) {
			$debug .= "<h3 class='emphasize'>$id</h3>\n<ul>";
			foreach ( $groups as $filters ) {
				foreach ( $filters as $filter => $values ) {
					$callback = is_string( $values['function'] ) ? $values['function'] : '(object)';
					$debug .= "<li>$filter ({$callback})</li>\n";
				}
			}
			$debug .= '</ul>';
		}

		return $debug;
	}

	public function filters_current() {
		global $debug_this_current_filter;
		$debug = print_r( $debug_this_current_filter, true );

		return $debug;
	}

	public function functions() {
		$functions = get_defined_functions();
		$debug     = print_r( $functions['user'], true );

		return $debug;
	}

	public function images( $buffer ) {
		;
		preg_match_all( '/src=[\'"](http.+\.(jpg|jpeg|png|svg))\'?"?/', $buffer, $matches );
		$debug = print_r( $matches[1], true );

		return $debug;
	}

	public function imagesizes() {
		global $_wp_additional_image_sizes;
		$sizes = get_intermediate_image_sizes();
		$debug = '<h3>' . __( 'Registered Sizes Names', 'debug-this' ) . '</h3>';
		$debug .= print_r( $sizes, true );
		$debug .= '<h3>' . __( 'Registered Size Definitions', 'debug-this' ) . '</h3>';
		$debug .= print_r( $_wp_additional_image_sizes, true );

		return $debug;
	}

	public function js( $buffer, $template ) {
		//make backwards compatible for no permalinks
		global $wp;
		$debug = sprintf( __( 'Template: %s', 'debug-this' ), $template ) . "\n";
		$debug .= sprintf( __( 'URL: %s', 'debug-this' ), get_bloginfo( 'url' ) . '/' . $wp->request ) . "\n";
		$debug .= '<h3 class="emphasize">' . __( 'JavaScript Files', 'debug-this' ) . '</h3>';
		preg_match_all( '/(http.+\.js)/', $buffer, $matches );
		$debug .= print_r( $matches[0], true );

		return $debug;
	}

	public function load_time( $buffer, $template ) {
		//make backwards compatible for no permalinks
		global $wp;
		$debug = sprintf( __( 'Template: %s', 'debug-this' ), $template ) . "\n";
		$debug .= sprintf( __( 'URL: %s', 'debug-this' ), get_bloginfo( 'url' ) . '/' . $wp->request ) . "\n";
		$debug .= sprintf( __( 'Execution Time: %s', 'debug-this' ), Debug_This::$execution_time . ' ' . __( 'seconds', 'debug-this' ) );

		return $debug;
	}

	public function menus() {
		$debug = print_r( get_registered_nav_menus(), true );

		return $debug;
	}

	public function menus_dynamic() {
		$debug = '<h3>' . __( 'Dynamic Menu Locations', 'debug-this' ) . '</h3>';
		$debug .= print_r( get_nav_menu_locations(), true );
		$debug .= '<h3>' . __( 'Dynamic Menus', 'debug-this' ) . '</h3>';
		$menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
		foreach ( $menus as $id => $menu ) {
			$menus[ $id ]->items = wp_get_nav_menu_items( $menu->term_id );
		}
		$debug .= print_r( $menus, true );

		return $debug;
	}

	public function oembed() {
		include_once ABSPATH . '/wp-includes/class-oembed.php';
		$debug = print_r( _wp_oembed_get_object(), true );

		return $debug;
	}

	public function options() {
		$debug = htmlentities( print_r( wp_load_alloptions(), true ) );

		return $debug;
	}

	public function phpinfo() {
		ob_start();
		phpinfo();
		$debug = ob_get_contents();
		ob_end_clean();
		Debug_This::$no_pre = true;

		return $debug;
	}

	public function phpini() {
		$debug = print_r( ini_get_all(), true );

		return $debug;
	}

	public function plugins() {
		include_once ABSPATH . '/wp-admin/includes/plugin.php';
		$debug = htmlentities( print_r( get_plugins(), true ) );

		return $debug;
	}

	public function post() {
		if ( is_singular() ) {
			global $post;
			$debug = htmlentities( print_r( $post, true ) );
		} else {
			$debug = __( 'This mode only works for single posts/pages', 'debug-this' );
		}

		return $debug;
	}

	public function posts() {
		if ( ! is_singular() ) {
			global $wp_query;
			$posts_count = count( $wp_query->posts );
			$debug       = sprintf( __( 'Number of Posts: %d' ), $posts_count ) . "\n\n";
			$debug .= htmlentities( print_r( $wp_query->posts, true ) );
		} else {
			$debug = __( 'This mode only works for archive/home pages', 'debug-this' );
		}

		return $debug;
	}

	public function post_meta() {
		if ( ! is_singular() ) {
			return __( 'This mode only works for single posts/pages', 'debug-this' );
		}

		global $post;
		$debug = print_r( get_post_custom( $post->ID ), true );

		return $debug;
	}

	public function posttypes() {
		global $post;
		$post_types = get_post_types( '', 'objects' );
		$debug      = print_r( $post_types, true );

		return $debug;
	}

	public function posttype_current() {
		global $wp_query;
		if ( $wp_query->queried_object ) {
			$post = $wp_query->queried_object;
		}
		$post_types = get_post_types( '', 'objects' );
		$debug      = print_r( array( $post->post_type => $post_types[ $post->post_type ] ), true ) . "\n\n";

		return $debug;
	}

	public function queries() {
		if ( Debug_This::$queries ) {
			$debug = print_r( Debug_This::$queries, true );
		} elseif ( ! defined( 'SAVEQUERIES' ) ) {
			$debug = '<span class="error">' . __( 'Please set define("SAVEQUERIES", true); in wp-config.php to see saved queries. Please disable when completed as this can be a large performance hit.', 'debug-this' ) . '</span>';
		} else {
			$debug = __( 'No queries found.', 'debug-this' );
		}

		return $debug;
	}

	public function request() {
		global $wp;
		$wp->matched_rule = "<a href='?debug=rewrites'>$wp->matched_rule</a>";
		$debug            = print_r( $wp, true );

		return $debug;
	}

	public function rewrites() {
		global $wp_rewrite, $wp;
		$permalink_structure = get_option( 'permalink_structure' );

		if ( ! $permalink_structure ) {
			return __( 'Pretty permalinks must be enabled to use this mode. To set a permalink structure, go to Settings->Permalinks in wp-admin.', 'debug-this' );
		}

		$debug = '<h3>' . __( 'Current Rewrite', 'debug-this' ) . '</h3>';
		$debug .= __( 'Matched Rule', 'debug-this' ) . ": <span class='current'>$wp->matched_rule</span>\n";
		$debug .= __( 'Matched Query', 'debug-this' ) . ": $wp->matched_query\n";
		$debug .= __( 'Query String', 'debug-this' ) . ": $wp->query_string\n\n";
		$debug .= '<h3>' . __( 'Rewrite Rules', 'debug-this' ) . '</h3>';

		if ( ! empty( $wp_rewrite->rules ) ) {
			$debug .= '<table><thead><tr>';
			$debug .= '<td><strong>' . __( 'Rule', 'debug-this' ) . '</strong></td><td><strong>' . __( 'Rewrite', 'debug-this' ) . '</strong></td>';
			$debug .= '</tr></thead><tbody>';
			foreach ( $wp_rewrite->rules as $rule => $rewrite ) {
				$class = $wp->matched_rule === $rule ? 'class="current"' : '';
				$debug .= '<tr><td ' . $class . '>' . $rule . '</td><td ' . $class . '>' . $rewrite . '</td></tr>';
			}
			$debug .= '</tbody></table>';
		} else {
			echo __( 'No rules defined.', 'debug-this' );
		}

		return $debug;
	}

	public function scripts() {
		global $wp_scripts;
		$debug = print_r( $wp_scripts->registered, true );

		return $debug;
	}

	public function server() {
		$debug = print_r( $_SERVER, true );

		return $debug;
	}

	public function shortcodes() {
		global $shortcode_tags;
		$debug = htmlentities( print_r( $shortcode_tags, true ) );

		return $debug;
	}

	public function shortcodes_regex() {
		$regex = get_shortcode_regex();
		$debug = htmlentities( print_r( $regex, true ) );

		return $debug;
	}

	public function sidebars_rendered( $buffer, $template ) {
		global $wp_registered_sidebars;
		$template_contents = file_get_contents( $template );
		preg_match_all( '/(get_sidebar|dynamic_sidebar).+\)/', $template_contents, $matches );
		$sidebars = array();
		foreach ( $matches[0] as $sidebar ) {
			if ( $sidebar === 'get_sidebar()' ) {
				$sidebars[] = 'get_sidebar() ' . locate_template( 'sidebar.php' );
			} else {
				preg_match_all( '/\(.+\)/', $sidebar, $parts );
				foreach ( $parts[0] as $part ) {
					$sidebar_name = trim( $part, ' )(\'"' );
					if ( preg_match( '/dynamic/', $sidebar ) ) {
						$sidebars[] = sprintf( __( 'Dynamic Sidebar: %s' ), $sidebar_name );
					} else {
						$path       = locate_template( "$sidebar_name.php" );
						$path       = $path ? $path : sprintf( __( 'Missing sidebar template for %s.php', 'debug-this' ), $sidebar_name );
						$sidebars[] = "get_sidebar('$sidebar_name') $path";
					}
				}
			}
		}
		$debug = sprintf( __( 'Current Template: %s', 'debug-this' ), $template ) . "\n\n";
		if ( $sidebars ) {
			$debug .= htmlentities( print_r( $sidebars, true ) ) . "\n";
		} else {
			$debug .= __( 'No sidebars were found in this template.', 'debug-this' );
		}

		return $debug;
	}

	public function sidebars_registered() {
		global $wp_registered_sidebars;
		$debug = '<h3>' . __( 'Registered Sidebars', 'debug-this' ) . '</h3>';
		$debug .= htmlentities( print_r( $wp_registered_sidebars, true ) );

		return $debug;
	}

	public function styles() {
		global $wp_styles;
		$debug = print_r( $wp_styles->registered, true );

		return $debug;
	}

	public function taxonomies() {
		$debug = print_r( get_taxonomies( '', 'objects' ), true );

		return $debug;
	}

	public function template() {
		$debug = Debug_This::$template_included;
		$debug .= "\n\nFor more information, consider these plugins: \n";
		$debug .= "<a href=\"https://wordpress.org/plugins/show-current-template/\">Show Current Template</a>\n";
		$debug .= "<a href=\"https://wordpress.org/plugins/which-template/\">Which Template</a>";

		return $debug;
	}

	public function terms_all() {
		$taxonomies = get_taxonomies( '', 'names' );
		$debug      = print_r( get_terms( $taxonomies ), true );

		return $debug;
	}

	public function terms() {
		global $post;
		if ( is_singular() ) {
			$debug      = '';
			$taxonomies = get_taxonomies( '', 'names' );
			foreach ( $taxonomies as $taxonomy ) {
				$terms = wp_get_post_terms( $post->ID, $taxonomy );
				if ( $terms ) {
					$debug .= "<h3 class='emphasize'>$taxonomy</h3><ul>";
					foreach ( $terms as $term ) {
						$debug .= '<li>' . sprintf( __( 'Term ID #%s - %s - %s', 'debug-this' ), $term->term_id, $term->slug, $term->name ) . '</li>';
					}
					$debug .= '</ul>';
				}
			}

		} else {
			$debug = '<span class="error">' . __( 'This mode only works on single pages/posts.', 'debug-this' ) . '</span>';
		}

		return $debug;
	}

	public function themes() {
		$debug = '<h3>' . __( 'Current Theme', 'debug-this' ) . '</h3>';
		$debug .= print_r( wp_get_theme(), true ) . "\n\n";
		$themes = wp_get_themes();
		$debug .= '<h3>' . __( 'Themes', 'debug-this' ) . '</h3>';
		$debug .= print_r( wp_get_themes(), true );

		return $debug;
	}

	public function users() {
		$users = get_users();
		$debug = '';
		foreach ( $users as $user ) {
			$login = property_exists( $user, 'data' ) ? $user->data->user_login : $user->user_login;
			$debug .= "<h3 class='emphasize'>{$login}</h3>";
			$debug .= print_r( $user, true );
		}

		return $debug;
	}

	public function variables() {
		$debug = '';
		foreach ( $GLOBALS as $id => $values ) {
			if ( $id === 'GLOBALS' || $id === 'html' ) {
				continue;
			}
			if ( is_array( $values ) && ! empty( $values ) ) {
				$debug .= "<h3>$id</h3>";
				//$debug .= htmlentities(print_r(array_keys($values), true));
				$debug .= htmlentities( print_r( $values, true ) );
			} elseif ( is_string( $values ) ) {
				$debug .= "<h3>$id</h3>";
				$debug .= htmlentities( "$values\n\n" );
			}
		}

		return $debug;
	}

	public function widgets() {
		global $wp_widget_factory;
		$debug = print_r( $wp_widget_factory->widgets, true );

		return $debug;
	}

	public function wp_debug() {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG === true ) {
			$path  = WP_CONTENT_DIR . '/debug.log';
			$debug = '';
			if ( file_exists( $path ) && is_writeable( $path ) ) {
				add_debug_header_link( Debug_This::get_current_debug_url() . '&clear-debug-log=true', __( 'Reset log file', 'debug-this' ) );
				if ( isset( $_GET['clear-debug-log'] ) ) {
					if ( file_put_contents( $path, '' ) === 0 ) {
						$debug .= __( 'Debug log was successfully cleared.', 'debug-this' );
					} else {
						$debug .= __( 'Debug log could not be reset. Please try again', 'debug-this' );
					}
				}
				$debug .= file_get_contents( $path );
				if ( ! $debug ) {
					$debug .= __( 'Looking good! No notices were logged.', 'debug-this' );
				}
			} elseif ( touch( $path ) ) {
				$debug = __( 'Looking good! No notices were logged.', 'debug-this' );
			} #Better reporting. If nothing was found, it's not a file perms error.
			else {
				$debug = __( 'Could not open debug.log. Please make sure your wp-content folder is writeable by the web server user.', 'debug-this' );
			}

			return $debug;
		} else {
			$debug = __( "Please add the following to wp-config.php to use this mode.\ndefine('WP_DEBUG', true);\ndefine('WP_DEBUG_LOG', true);\ndefine('WP_DEBUG_DISPLAY', false);", 'debug-this' );

			return $debug;
		}
	}

	public function wp_query() {
		global $wp_query;
		$debug = htmlentities( print_r( $wp_query, true ) );

		return $debug;
	}
}

new Debug_This_Extensions;
