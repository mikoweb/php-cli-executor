<?php

declare(strict_types=1);

use Mikoweb\CLIExecutor\Executor;
use Mikoweb\CLIExecutor\Config;
use Mikoweb\CLIExecutor\Output\OutputStatus;
use PHPUnit\Framework\TestCase;

final class ExecutorTest extends TestCase
{
    public function testSuccessfulCase1(): void
    {
        $config = new Config(__DIR__ . '/scripts/successful-cli-case1.php');
        $executor = new Executor($config);

        $output = $executor->execute(['app:test']);

        $this->assertTrue($output->isSuccessful());
        $this->assertNull($output->getErrorMessage());
        $this->assertEquals(200, $output->getStatus());
        $this->assertIsString($output->getRawOutput());
        $this->assertIsArray($output->getData()->getData());
        $this->assertNotEmpty($output->getData()->getData());
        $this->assertTrue($output->getData()->has('message'));
        $this->assertEquals('ok', $output->getData()->get('message'));
    }

    public function testAsyncSuccessfulCase1(): void
    {
        $config = new Config(__DIR__ . '/scripts/successful-cli-case1.php');
        $executor = new Executor($config);

        $output = $executor->executeAsync(['app:test']);
        $output->getProcess()->wait();

        $this->assertTrue($output->isSuccessful());
        $this->assertNull($output->getErrorMessage());
        $this->assertEquals(OutputStatus::STATUS_SUCCESS, $output->getStatus());
        $this->assertIsString($output->getRawOutput());
        $this->assertIsArray($output->getData()->getData());
        $this->assertNotEmpty($output->getData()->getData());
        $this->assertTrue($output->getData()->has('message'));
        $this->assertEquals('ok', $output->getData()->get('message'));
    }

    public function testFailCase1(): void
    {
        $config = new Config(__DIR__ . '/scripts/fail-cli-case1.php');
        $executor = new Executor($config);

        $output = $executor->execute(['app:test']);

        $this->assertFalse($output->isSuccessful());
        $this->assertEquals('something\'s wrong', $output->getErrorMessage());
        $this->assertEquals(OutputStatus::STATUS_INTERNAL_ERROR, $output->getStatus());
        $this->assertIsString($output->getRawOutput());
        $this->assertIsArray($output->getData()->getData());
        $this->assertNotEmpty($output->getData()->getData());
        $this->assertFalse($output->getData()->has('message'));
        $this->assertNull($output->getData()->get('message'));
    }

    public function testFailCase2(): void
    {
        $config = new Config(__DIR__ . '/scripts/fail-cli-case2.php');
        $executor = new Executor($config);

        $output = $executor->execute(['app:test']);

        $this->assertFalse($output->isSuccessful());
        $this->assertStringContainsString('failed.', $output->getErrorMessage());
        $this->assertEquals(1, $output->getStatus());
        $this->assertIsString($output->getRawOutput());
        $this->assertIsArray($output->getData()->getData());
        $this->assertNotEmpty($output->getData()->getData());
        $this->assertFalse($output->getData()->has('message'));
        $this->assertNull($output->getData()->get('message'));
    }
}
