<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;

class ApiValidationException extends ValidationException
{
   public function render($request)
    {
        return response()->unauthorized('INVALIDATE', 'Validation failed!', $this->validator->errors()->toArray());
    }
}
