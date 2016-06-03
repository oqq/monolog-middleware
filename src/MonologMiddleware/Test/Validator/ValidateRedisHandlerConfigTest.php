<?php


namespace MonologMiddleware\Test;

use MonologMiddleware\Validator\ValidateRedisHandlerConfig;

class ValidateRedisHandlerConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testValidate()
    {
        $configArray = [
            'type'  => 'redis',
            'level' => 'INFO',
            'redis' => new \Redis(),
            'key'   => 'monolog'
        ];

        $redisValidator = new ValidateRedisHandlerConfig($configArray);
        $this->assertTrue($redisValidator->validate());
    }

    public function testHasRedisClient()
    {
        $configArray = [
            'type'  => 'redis',
            'level' => 'INFO',
            'redis' => new \Redis(),
        ];

        $redisValidator = new ValidateRedisHandlerConfig($configArray);
        $this->assertTrue($redisValidator->hasRedisClient());
    }

    public function testNotHasRedisClient()
    {
        $configArray = [
            'type'  => 'redis',
            'level' => 'INFO',
            'key'   => 'monolog'
        ];

        self::setExpectedException('MonologMiddleware\Exception\MonologConfigException');
        $redisValidator = new ValidateRedisHandlerConfig($configArray);
        $redisValidator->hasRedisClient();
    }

    public function testHasRedisValueButNotRedisClient()
    {
        $configArray = [
            'type'  => 'redis',
            'level' => 'INFO',
            'redis' => 'REDIS',
        ];
        self::setExpectedException('MonologMiddleware\Exception\MonologConfigException');
        $redisValidator = new ValidateRedisHandlerConfig($configArray);
        $redisValidator->hasRedisClient();
    }

    public function testHasKey()
    {
        $configArray = [
            'type'  => 'redis',
            'level' => 'INFO',
            'key'   => 'monolog'
        ];

        $redisValidator = new ValidateRedisHandlerConfig($configArray);
        $this->assertTrue($redisValidator->hasKey());
    }

    public function testHasNoKey()
    {
        $configArray = [
            'type'  => 'redis',
            'level' => 'INFO',
        ];
        
        self::setExpectedException('MonologMiddleware\Exception\MonologConfigException');
        $redisValidator = new ValidateRedisHandlerConfig($configArray);
        $this->assertTrue($redisValidator->hasKey());
    }
}
