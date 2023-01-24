<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string idempotency_key
 * @property string transfer_from
 * @property string transfer_to
 * @property string currency
 * @property int amount
 */
class NewTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "idempotency_key" => "string|required|unique:transaction|size:" . Transaction::IDEMPOTENCY_KEY_SIZE,
            "transfer_from" => "int|required|exists:account,id",
            "transfer_to" => "int|required|exists:account,id|different:transfer_from",
            "currency" => "int|required|exists:currency,id",
            "amount" => "int|required|min:" . Transaction::MIN_SEND_AMOUNT
        ];
    }
}
