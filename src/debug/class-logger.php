<?php

namespace UnofficialConvertKit\Debug;


class Logger {

	const EXIT_CODE = '<?php exit; ?>';

	protected static $file_path;

	protected $file;
	/**
	 * @var int
	 */
	protected $level;
	/**
	 * @var resource
	 */
	protected $stream;

	public function __construct( int $level = Log::DEBUG ) {
		$this->file  = static::get_log_file_path();
		$this->level = $level;
	}

	/**
	 * @param string $message
	 * @param int $level
	 *
	 * @return bool
	 */
	public function log( string $message, int $level ): bool {
		$log = new Log( $message, $level );

		$level = $log->get_level();

		// only log if message level is higher than log level
		if ( $level < $this->level ) {
			return false;
		}

		// generate line
		$message = (string) $log . PHP_EOL;

		// did we open stream yet?
		if ( ! is_resource( $this->stream ) ) {

			$dirname = dirname( $this->file );
			if ( ! is_dir( $dirname ) ) {
				@mkdir( $dirname, 0755, true );
			}

			// open stream
			$this->stream = @fopen( $this->file, 'cb+' );

			// if this failed, bail..
			if ( ! is_resource( $this->stream ) ) {
				return false;
			}

			// make sure first line of log file is a PHP tag + exit statement (to prevent direct file access)
			$line            = fgets( $this->stream );
			$php_exit_string = self::EXIT_CODE;
			if ( strpos( $line, $php_exit_string ) !== 0 ) {
				rewind( $this->stream );
				fwrite( $this->stream, $php_exit_string . PHP_EOL . $line );
			}

			// place pointer at end of file
			fseek( $this->stream, 0, SEEK_END );
		}

		// lock file while we write, ignore errors (not much we can do)
		flock( $this->stream, LOCK_EX );

		// write the message to the file
		fwrite( $this->stream, $message );

		// unlock file again, but don't close it for remainder of this request
		flock( $this->stream, LOCK_UN );

		$this->protect_log_file();

		return true;
	}

	/**
	 * This writes a .htaccess file to the directory that the log file is in on servers supporting it.
	 */
	private function protect_log_file() {
		if ( ! isset( $_SERVER['SERVER_SOFTWARE'] ) || strpos( $_SERVER['SERVER_SOFTWARE'], 'Apache' ) !== 0 ) {
			return;
		}

		$filename      = basename( $this->file );
		$dirname       = dirname( $this->file );
		$htaccess_file = $dirname . '/.htaccess';
		$lines         = array(
			'# MC4WP Start',
			'# Apache 2.2',
			'<IfModule !authz_core_module>',
			"<Files $filename>",
			'deny from all',
			'</Files>',
			'</IfModule>',
			'# Apache 2.4+',
			'<IfModule authz_core_module>',
			"<Files $filename>",
			'Require all denied',
			'</Files>',
			'</IfModule>',
			'# MC4WP End',
		);

		if ( ! file_exists( $htaccess_file ) ) {
			file_put_contents( $htaccess_file, implode( PHP_EOL, $lines ) );

			return;
		}

		$htaccess_content = file_get_contents( $htaccess_file );
		if ( strpos( $htaccess_content, $lines[0] ) === false ) {
			file_put_contents( $htaccess_file, PHP_EOL . PHP_EOL . implode( PHP_EOL, $lines ), FILE_APPEND );

			return;
		}
	}

	/**
	 * Return the
	 *
	 * @return string
	 */
	public static function get_log_file_path(): string {
		if ( empty( static::$file_path ) ) {
			static::$file_path = sprintf( '%s/%s/log.php', wp_upload_dir( null, false )['basedir'], UNOFFICIAL_CONVERTKIT );
		}

		return static::$file_path;
	}
}
