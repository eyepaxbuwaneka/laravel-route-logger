<?php

    use PHPUnit\Framework\TestCase;
    use Eyepax\RouteLogger\RequestResponseLogger;

    class RequestResponseLoggerTest extends TestCase {

        private $request;
        private $db;
        private $carbon;
        private $schema;

        /**
         * setup the values needed for the test
         */
        public function setUp() {

            $this->request = Mockery::mock('alias:Request');
            $this->carbon = Mockery::mock('alias:Carbon\Carbon');
            $this->db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
            $this->schema = Mockery::mock('alias:Illuminate\Support\Facades\Schema');

            $this->request->shouldReceive('getClientIp')
                ->andReturn('127.0.0.1')
                ->shouldReceive('server')
                ->andReturn('Chrome')
                ->shouldReceive('getMethod')
                ->andReturn('GET')
                ->shouldReceive('url')
                ->andReturn('www.test-module.com')
                ->shouldReceive('query')
                ->andReturn('{name : eyepax}');

            $this->carbon->shouldReceive("now")
                ->andReturn($this->carbon)
                ->shouldReceive('toDateTimeString')
                ->andReturn('2017-08-16 12:51:00');

            $this->db->shouldReceive('table')
                ->andReturn($this->db)
                ->shouldReceive('insert')
                ->andReturn(true);

        }

        /**
         * clear up the values after each funtion
         */
        public function tearDown() {
            Mockery::close();
        }

        /**
         * test the success of getting values
         */
        public function testGetDataSuccess() {
            $class = new RequestResponseLogger();
            $value = $class->getData($this->request, 1, 1, 1, 1, 1, 'Asia/Colombo');
            $this->assertContains('www.test-module.com', $value["url"]);
            $this->assertContains('127.0.0.1', $value["ip"]);
            $this->assertContains('Chrome', $value["user_agent"]);
            $this->assertContains('GET', $value["method"]);
            $this->assertContains('{name : eyepax}', $value["query_values"]);
        }

        /**
         * test the failure of getting values
         */
        public function testGetDataFailure() {
            $this->request = null;
            $class = new RequestResponseLogger();
            $value = $class->getData($this->request, 1, 1, 1, 1, 1, 'Asia/Colombo');
            $this->assertContains("no value", $value["url"]);
            $this->assertContains("no value", $value["ip"]);
            $this->assertContains("no value", $value["method"]);
            $this->assertContains("{value: no value}", $value["user_agent"]);
            $this->assertContains("{value: no value}", $value["query_values"]);
        }

        /**
         * test the success of inserting values
         */
        public function testInsertSuccess() {
            $this->schema->shouldReceive('hasTable')
                ->andReturn(true);

            $value = [
                "ip" => "127.0.0.1",
            ];
            $class = new RequestResponseLogger();
            $log = $class->log($value, 'trn_route_log');
            $this->assertTrue($log);
        }

        /**
         * test the failure of inserting values
         */
        public function testInsertFailure() {
            $this->schema->shouldReceive('hasTable')
                ->andReturn(true);

            $value = [];
            $class = new RequestResponseLogger();
            $log = $class->log($value, 'trn_route_log');
            $this->assertFalse($log);
        }

        /**
         * test the failure of inserting values when table doesn't exist
         */
        public function testFailureTableDoesntExist() {
            $this->schema->shouldReceive('hasTable')
                ->andReturn(false);

            $value = [
                "ip" => "127.0.0.1",
            ];

            $class = new RequestResponseLogger();
            $log = $class->log($value, 'trn_route_log');
            $this->assertFalse($log);
        }

    }
