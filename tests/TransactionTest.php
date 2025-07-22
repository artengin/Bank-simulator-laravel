<?php

namespace Tests;

use App\Support\Arr;
use RonasIT\Support\Testing\ModelTestState;
use App\Models\Transaction;
use App\Models\User;
use Tests\Support\BankMockTrait;
use Symfony\Component\HttpFoundation\Response;

class TransactionTest extends TestCase
{
    use BankMockTrait;

    protected static ModelTestState $transactionState;
    protected static User $user;

    public function setUp(): void
    {
        parent::setUp();

        self::$transactionState ??= new ModelTestState(Transaction::class);

        self::$user ??= User::find(1);
    }

    public function testTransactionNotAuthorizated()
    {
        $response = $this->postJson('/transactions/outgoing');

        $response->assertUnauthorized();

        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testTransactionSuccessWithoutName()
    {
        Arr::fake([
            'random' => ['Amazon']
        ]);

        $this->mockHttpRequestService([
            $this->webhookTransactions(
                requestData: [
                    'card_number' => '7507297011021267',
                    'amount' => '1',
                    'type' => 'incoming',
                    'name' => 'Amazon',
                ],
                statusCode: Response::HTTP_OK,
            )]);

        $data = $this->getJsonFixture('transaction_without_name');

        $response = $this->actingAs(self::$user)->postJson('/transactions/incoming', $data);

        $response->assertNoContent();

        self::$transactionState->assertChangesEqualsFixture('transaction_without_name');
    }

    public function testTransactionSuccessOutgoing()
    {
        $this->mockHttpRequestService([
            $this->webhookTransactions(
                requestData: [
                    'card_number' => '7507297011021267',
                    'amount' => '1',
                    'type' => 'outgoing',
                    'name' => 'test',
                ],
                statusCode: Response::HTTP_OK,
            )]);

        $data = $this->getJsonFixture('transaction');

        $response = $this->actingAs(self::$user)->postJson('/transactions/outgoing', $data);

        $response->assertNoContent();

        self::$transactionState->assertChangesEqualsFixture('transaction_outgoing');
    }

    public function testTransactionSuccessIncoming()
    {
        $this->mockHttpRequestService([
            $this->webhookTransactions(
                requestData: [
                    'card_number' => '7507297011021267',
                    'amount' => '1',
                    'type' => 'incoming',
                    'name' => 'test',
                ],
                statusCode: Response::HTTP_OK,
            )]);

        $data = $this->getJsonFixture('transaction');

        $response = $this->actingAs(self::$user)->postJson('/transactions/incoming', $data);

        $response->assertNoContent();

        self::$transactionState->assertChangesEqualsFixture('transaction_incoming');
    }

    public function testTransactionBadRequest()
    {
        $this->mockHttpRequestService([
            $this->webhookTransactions(
                requestData: [
                    'card_number' => '7507297011021267',
                    'amount' => '1',
                    'type' => 'incoming',
                    'name' => 'test',
                ],
                statusCode: Response::HTTP_BAD_REQUEST,
            )]);

        $data = $this->getJsonFixture('transaction');

        $response = $this->actingAs(self::$user)->postJson('/transactions/incoming', $data);

        $response->assertNoContent();
    }
}
