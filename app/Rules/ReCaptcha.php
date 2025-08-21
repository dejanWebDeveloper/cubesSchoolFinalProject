<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class ReCaptcha implements Rule
{
    public function passes($attribute, $value): bool
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
            'response' => $value,
        ]);

        return $response->json('success') ?? false;
    }

    public function message(): string
    {
        return 'ReCaptcha verification failed.';
    }
}
