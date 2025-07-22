<?php

namespace Tests;

use RonasIT\Support\Testing\ModelTestState;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class KycTest extends TestCase
{
    protected static ModelTestState $clientState;
    protected array $authToken;

    public function setUp(): void
    {
        parent::setUp();

        self::$clientState ??= new ModelTestState(Client::class);

        $this->authToken = ['Authorization' => Hash::make('pillar-bank')];
    }

    public function testUserNotAuthorizated()
    {
        $data = $this->getJsonFixture('create_approve_request');

        $response = $this->postJson('/kyc', $data);

        $response->assertForbidden();
    }

    public function testCreateWithApprove()
    {
        $data = $this->getJsonFixture('create_approve_request');

        $response = $this->postJson('/kyc', $data, $this->authToken);

        $response->assertCreated();

        $response->assertJson(['status' => 'approve']);

        self::$clientState->assertChangesEqualsFixture('create_approve');
    }

    public function testCreateWithReject()
    {
        $data = $this->getJsonFixture('create_reject_request');

        $response = $this->postJson('/kyc', $data, $this->authToken);

        $response->assertCreated();

        $response->assertJson(['status' => 'reject']);

        self::$clientState->assertChangesEqualsFixture('create_reject');
    }

    public function testValidationErrors()
    {
        $invalidData = $this->getJsonFixture('invalid_request');

        $response = $this->postJson('/kyc', $invalidData, $this->authToken);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'first_name',
            'last_name',
            'ssn',
            'phone',
            'email',
        ]);
    }

    public function testPhoneWithDifferentSsn()
    {
        $data = $this->getJsonFixture('phone_with_different_ssn');

        $response = $this->postJson('/kyc', $data, $this->authToken);

        $response->assertUnprocessable();

        $response->assertJson(['message' => 'Phone number exists with a different SSN']);
    }

    public function testSsnWithDifferentPhone()
    {
        $data = $this->getJsonFixture('ssn_with_different_phone');

        $response = $this->postJson('/kyc', $data, $this->authToken);

        $response->assertUnprocessable();

        $response->assertJson(['message' => 'SSN exists with a different phone number']);
    }

    public function testPhoneExistsWithReject()
    {
        $data = $this->getJsonFixture('phone_exists_with_reject');

        $response = $this->postJson('/kyc', $data, $this->authToken);

        $response->assertUnprocessable();

        $response->assertJson(['message' => 'Phone number exists with a different SSN']);
    }

    public function testClientAlreadyExists()
    {
        $data = $this->getJsonFixture('client_already_exists');

        $response = $this->postJson('/kyc', $data, $this->authToken);

        $response->assertOk();

        $response->assertJson(['status' => 'approve']);

        self::$clientState->assertNotChanged();
    }
}
