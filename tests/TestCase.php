<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Assert as PHPUnit;
use App\Plan;
use App\User;
use App\Customer;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $plan;
    protected $backend_admin;
    protected $cust_admin;

    public function setUp()
    {        
        parent::setUp();

        $this->plan = $this->getPlan();
        $this->backend_admin = factory(User::class)->create(['username' => 'admin_backend']);
        $this->cust_admin = factory(Customer::class)->create([ 'username' => 'admin']);
    }

    protected function getPlan()
    {
      $plan = factory(Plan::class)->create([ 
            'name' => 'Platinum',
            'min_deposit' => 3000,
            'max_deposit' => 10000,
            'sponsor' => 0.1, 
            'pairing' => 0.05, 
            'daily' => 0.03, 
            'duration' => 60,
            'image' => 'images/logo/3.png'
        ]);

        $plan->sponsor_levels()->createMany([
            [ 'level' => 1, 'type' => 'D', 'commission' => 0.07 ],
            [ 'level' => 2, 'type' => 'I', 'commission' => 0.05 ],
            [ 'level' => 3, 'type' => 'I', 'commission' => 0.03 ],
            [ 'level' => 4, 'type' => 'I', 'commission' => 0.02 ],
            [ 'level' => 5, 'type' => 'I', 'commission' => 0.01 ],
        ]);

        return $plan;
    }

    public function assertArrayStructure(array $structure = null, $responseData = null)
    {
        if (is_null($structure)) {
            return $this->assertJson();
        }

        if (is_null($responseData)) {
            $responseData = $this->decodeResponseJson();
        }

        foreach ($structure as $key => $value) {
            if (is_array($value) && $key === '*') {
                PHPUnit::assertInternalType('array', $responseData);

                foreach ($responseData as $responseDataItem) {
                    $this->assertArrayStructure($structure['*'], $responseDataItem);
                }
            } elseif (is_array($value)) {
                PHPUnit::assertArrayHasKey($key, $responseData);

                $this->assertArrayStructure($structure[$key], $responseData[$key]);
            } else {
                PHPUnit::assertArrayHasKey($value, $responseData);
            }
        }

        return $this;
    }
}
