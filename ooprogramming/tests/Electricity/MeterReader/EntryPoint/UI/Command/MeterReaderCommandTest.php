<?php

namespace App\Tests\Electricity\MeterReader\EntryPoint\UI\Command;

use App\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class MeterReaderCommandTest extends IntegrationTestCase
{
    protected $command;
    protected CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = $this->application->find('execute:electricity-meter-reader');
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @test
     */
    public function invalid_source_type_call_validation_exception(): void
    {
        $this->commandTester->execute(array(
              'command'  => $this->command->getName(),

              // pass arguments to the helper
              'path' => 'public/feed/2016-readings.xml',
              'source-type' => 'url',
          ));

        $output = $this->commandTester->getDisplay();
        self::assertEquals('{"message":"Source-type unsupported","errors":["The source-type url is not supported. Use \'file\' source-type"]}', $output);
    }

    /**
     * @test
     */
    public function invalid_path_call_validation_exception(): void
    {
        $this->commandTester->execute(array(
              'command'  => $this->command->getName(),

              // pass arguments to the helper
              'path' => 'public/feed/2018-readings.xml',
              'source-type' => 'file',
          ));

        $output = $this->commandTester->getDisplay();
        self::assertEquals('{"message":"File not found","errors":["The file public\/feed\/2018-readings.xml doesn\'t exist"]}', $output);
    }

    /**
     * @test
     */
    public function execute_command_xml_works(): void
    {
        $this->commandTester->execute(array(
              'command'  => $this->command->getName(),

              // pass arguments to the helper
              'path' => __DIR__ . '/testing-2016-readings.xml',
              'source-type' => 'file',
          ));

        self::assertEquals(Command::SUCCESS, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function execute_command_csv_works(): void
    {
        $this->commandTester->execute(array(
              'command'  => $this->command->getName(),

              // pass arguments to the helper
              'path' => __DIR__ . '/testing-2016-readings.csv',
              'source-type' => 'file',
          ));

        self::assertEquals(Command::SUCCESS, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function execute_command_csv_fails_by_wrong_clientId_header(): void
    {
        $this->commandTester->execute(array(
              'command'  => $this->command->getName(),

              // pass arguments to the helper
              'path' => __DIR__ . '/wrong-testing-2016-readings.csv',
              'source-type' => 'file',
          ));

        self::assertEquals(Command::FAILURE, $this->commandTester->getStatusCode());
        self::assertEquals('{"message":"The attribute clientID has not been found","errors":{"clientID":["Attribute not found. Check headers of file"]}}', $this->commandTester->getDisplay());
    }
}
