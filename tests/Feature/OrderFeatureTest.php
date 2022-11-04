<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Transaction;
use Tests\TestCase;

class OrderFeatureTest extends TestCase
{
    public function test_send_money_must_be_for_authorized_user()
    {
        $this->json('POST', 'api/create-order')->assertUnauthorized();
    }
    public function test_order_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $formData = [
            'customer_name' => "Rifat",
            'customer_email' => "rifat@seazoo.co.jp",
            'customer_phone' => "01867254624",
            'customer_street' => "609",
            'customer_city' => "Dahak",
            'customer_state' => "Dahak",
            'customer_zipcode' => "1219",
            'customer_country' => "BGD",
            'product_name' => "Headphone",
            'product_description' => "Test",
            'amount' => 1222.22,
        ];
        $this->json('POST', 'api/create-order', $formData)
            ->assertStatus(201);
    }

    public function test_order_validation()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->json('POST', 'api/create-order')
            ->assertStatus(422)
            ->assertJson([
                "success" => false,
                "message" => [
                    "customer_name" => [
                        "The customer name field is required."
                    ],
                    "customer_email" => [
                        "The customer email field is required."
                    ],
                    "customer_phone" => [
                        "The customer phone field is required."
                    ],
                    "customer_street" => [
                        "The customer street field is required."
                    ],
                    "customer_city" => [
                        "The customer city field is required."
                    ],
                    "customer_state" => [
                        "The customer state field is required."
                    ],
                    "customer_zipcode" => [
                        "The customer zipcode field is required."
                    ],
                    "customer_country" => [
                        "The customer country field is required."
                    ],
                    "product_name" => [
                        "The product name field is required."
                    ],
                    "product_description" => [
                        "The product description field is required."
                    ],
                    "amount" => [
                        "The amount field is required."
                    ]
                ],
                "data" => [
                    "error" => "Validation errors"
                ]
            ]);
    }
}
