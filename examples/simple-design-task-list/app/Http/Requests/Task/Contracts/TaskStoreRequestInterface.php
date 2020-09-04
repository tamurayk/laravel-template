<?php
declare(strict_types=1);

namespace App\Http\Requests\Task\Contracts;

use App\Http\Requests\Contracts\FormRequest;

/**
 * Interface TaskStoreRequest
 * @package App\Http\Requests\Contracts\Task
 */
interface TaskStoreRequestInterface extends FormRequest
{
    /**
     * @return array
     */
    public function attributes(): array;

    public function prepareForValidation(): void;

    /**
     * @return array
     */
    public function rules(): array;

    /**
     * @return array
     */
    public function messages(): array;
}