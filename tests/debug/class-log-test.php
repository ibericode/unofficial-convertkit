<?php

namespace UnofficialConvertKit\Tests\Debug;

use DateTime;
use UnofficialConvertKit\Debug\Log;
use WP_Mock;
use WP_Mock\Tools\TestCase;

class Log_Test extends TestCase {

	public function setUp(): void {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/debug/class-log.php';
	}

	/**
	 * @test
	 */
	public function parse_string_into_log_object() {
		$message = 'foo bar baz';

		WP_Mock::userFunction( 'UnofficialConvertKit\obfuscate_email_addresses' )->andReturn( $message );

		$log = new Log(
			$message,
			300,
			DateTime::createFromFormat( 'Y-m-d H:i:s', '2020-08-24 11:18:51' )
		);

		$parsed_log = Log::from_format( (string) $log );

		self::assertNotNull( $parsed_log );
		self::assertEquals( $log->get_date(), $parsed_log->get_date() );
		self::assertEquals( $log->get_message(), $parsed_log->get_message() );
		self::assertEquals( $log->get_level(), $parsed_log->get_level() );
		self::assertEquals( $log->get_level_name(), $parsed_log->get_level_name() );
	}
}
