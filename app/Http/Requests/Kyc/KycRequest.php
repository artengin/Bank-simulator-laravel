<?php

namespace App\Http\Requests\Kyc;

use App\Http\Requests\Request;
use App\Services\ClientService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Arr;

/**
 * @summary KYC Submission
 * @description Submit KYC data for user verification
 * @_200 KYC data accepted and processed successfully
 * @_401 Unauthorized access (authentication required)
 * @_422 Validation failed (invalid or missing data)
 */
class KycRequest extends Request
{
    protected ClientService $clientService;

    public function authorize(): bool
    {
        return Hash::check(config('defaults.authorization.kyc'), $this->header('Authorization'));
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'ssn' => 'required|string|regex:/^\d{3}-\d{2}-\d{4}$/',
            'phone' => 'required|string',
            'email' => 'required|email',
        ];
    }

    public function validateResolved(): void
    {
        parent::validateResolved();

        $this->init();

        $this->checkPhoneWithDifferentSsn();

        if (!Arr::has(config('defaults.ssn_status'), $this->input('ssn'))) {
            $this->checkSsnWithDifferentPhone();
        }
    }

    protected function init(): void
    {
        $this->clientService = app(ClientService::class);
    }

    protected function checkPhoneWithDifferentSsn()
    {
        $client = $this->clientService->first(['phone' => $this->input('phone')]);

        if (!empty($client) && $client->ssn !== $this->input('ssn')) {
            throw new UnprocessableEntityHttpException(__('validation.exceptions.phone_with_different_ssn'));
        }
    }

    protected function checkSsnWithDifferentPhone()
    {
        $client = $this->clientService->first(['ssn' => $this->input('ssn')]);

        if (!empty($client) && $client->phone !== $this->input('phone')) {
            throw new UnprocessableEntityHttpException(__('validation.exceptions.ssn_with_different_phone'));
        }
    }
}
