<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/api/v1/get-all-customers');

        $response->assertStatus(200);
    }

    public function test_create_customer()
    {
        $customerData = [
            'full_name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '1234567890',
        ];

        $response = $this->post('/api/v1/create-customer', $customerData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Customer created successfully']);

        $this->assertDatabaseHas('customer', $customerData);
    }

    public function test_get_all_customers()
    {
        $response = $this->get('/api/v1/get-all-customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'customers' => [
                    '*' => [
                        'id',
                        'full_name',
                        'email',
                        'phone_number',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_update_customer()
    {
        // First, create a new customer
        $customerData = [
            'full_name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '1234567890',
        ];
        $createResponse = $this->post('/api/v1/create-customer', $customerData);
        $createResponse->assertStatus(200);
        $customerId = $createResponse->json()['id'];

        // Update the customer's phone number
        $updatedCustomerData = [
            'phone_number' => '5555555555',
        ];
        $updateResponse = $this->put("/api/v1/update-customer/$customerId", $updatedCustomerData);
        $updateResponse->assertStatus(200);
        $updateResponse->assertJson([
            'message' => 'Customer updated successfully'
        ]);

        // Check that the customer's phone number was updated
        $getResponse = $this->get("/api/v1/get-customer/$customerId");
        $getResponse->assertStatus(200);
        $getResponse->assertJson([
            'customer' => [
                'phone_number' => '5555555555',
            ],
        ]);
    }

    public function test_get_customer()
    {
        // First, create a new customer
        $customerData = [
            'full_name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '1234567890',
        ];
        $createResponse = $this->post('/api/v1/create-customer', $customerData);
        $createResponse->assertStatus(200);
        $customerId = $createResponse->json()['id'];

        // Get the customer by ID
        $getResponse = $this->get("/api/v1/get-customer/$customerId");
        $getResponse->assertStatus(200);
        $getResponse->assertJson([
            'customer' => [
                'full_name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone_number' => '1234567890',
            ]
        ]);
    }


}
