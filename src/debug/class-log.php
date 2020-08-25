<?php

namespace UnofficialConvertKit\Debug;

use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

use function UnofficialConvertKit\obfuscate_email_addresses;

final class Log {

	/**
	 * @var string
	 */
	private $message;
	/**
	 * @var int
	 */
	private $level;
	/**
	 * @var string
	 */
	private $level_name;
	/**
	 * @var DateTimeInterface|null
	 */
	private $date_time;

	const DEBUG = 100;

	const INFO = 200;

	const WARNING = 300;

	const ERROR = 400;

	private static $regex = '/^(\[[\d \-\:]+\]) (\w+)(?:\:) (.*)$/';

	private static $date_format = 'Y-m-d H:i:s';

	private static $levels = array(
		self::DEBUG   => 'DEBUG',
		self::INFO    => 'INFO',
		self::WARNING => 'WARNING',
		self::ERROR   => 'ERROR',
	);

	/**
	 * Log constructor.
	 *
	 * @param string $message
	 * @param int $code
	 * @param DateTimeInterface|null $date_time
	 */
	public function __construct( string $message, int $code, DateTimeInterface $date_time = null ) {

		// obfuscate email addresses in log message since log might be public.
		$message = obfuscate_email_addresses( $message );
		// first, get rid of everything between "invisible" tags
		$message = preg_replace( '/<(?:style|script|head)>.+?<\/(?:style|script|head)>/is', '', $message );
		// then, strip tags (while retaining content of these tags)
		$message         = strip_tags( $message );
		$message         = trim( $message );
		$this->message   = $message;
		$this->level     = $code;
		$this->date_time = $date_time ?? new DateTime();

		if ( ! isset( static::$levels[ $code ] ) ) {
			throw new InvalidArgumentException( 'Invalid log code given.' );
		}

		$this->level_name = static::$levels[ $code ];
	}

	/**
	 * @return string
	 */
	public function get_message(): string {
		return $this->message;
	}

	/**
	 * @return int
	 */
	public function get_level(): int {
		return $this->level;
	}

	/**
	 * @return string
	 */
	public function get_level_name(): string {
		return $this->level_name;
	}

	/**
	 * @return DateTimeInterface
	 */
	public function get_date(): DateTimeInterface {
		return $this->date_time;
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		return sprintf(
			'[%s] %s: %s',
			$this->get_date()->format( static::$date_format ),
			$this->get_level_name(),
			$this->get_message()
		);
	}

	/**
	 * Create from the format
	 *
	 * @param string $line
	 *
	 * @return null|Log
	 */
	public static function from_format( string $line ) {
		preg_match( static::$regex, $line, $matches, null, 0 );

		array_shift( $matches );

		if ( count( $matches ) !== 3 ) {
			return null;
		}

		try {
			return new Log(
				$matches[2],
				self::map_level_to_code( $matches[1] ),
				DateTime::createFromFormat(
					sprintf( '[%s]', static::$date_format ),
					$matches[0]
				)
			);
		} catch ( Exception $e ) {
			return null;
		}
	}

	/**
	 * Map the level to the code.
	 *
	 * @param string $level
	 *
	 * @return int
	 */
	public static function map_level_to_code( string $level ): int {
		$search = array_search( $level, static::$levels, true );

		if ( false === $search ) {
			throw new InvalidArgumentException( 'Invalid level given.' );
		}

		return $search;
	}
}
