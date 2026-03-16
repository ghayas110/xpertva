<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;

class PublicLeadTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_creates_lead()
    {
        $response = $this->post(route('contact.submit'), [
            'fullName' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'message' => 'Test message',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', [
            'company_name' => 'John Doe',
            'status' => 'Lead',
            'source' => 'Contact Form',
        ]);
        
        $client = Client::where('company_name', 'John Doe')->first();
        $this->assertContains('john@example.com', $client->email);
        $this->assertContains('1234567890', $client->phone);
    }

    public function test_audit_form_submission_creates_lead()
    {
        $response = $this->post(route('audit.submit'), [
            'fullName' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'storeLink' => 'https://amazon.com/store',
            'preferredAsin' => 'B000123456',
            'message' => 'Audit request',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', [
            'company_name' => 'Jane Smith',
            'status' => 'Lead',
            'source' => 'Audit Form',
        ]);

        $client = Client::where('company_name', 'Jane Smith')->first();
        $this->assertStringContainsString('https://amazon.com/store', $client->background_info);
        $this->assertStringContainsString('B000123456', $client->background_info);
    }
}
