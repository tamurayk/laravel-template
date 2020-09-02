<?php
declare(strict_types=1);

namespace App\Http\Requests\Contracts;

/**
 * Interface FormRequest
 * @package App\Http\Requests\Contracts
 */
interface FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool;
}
