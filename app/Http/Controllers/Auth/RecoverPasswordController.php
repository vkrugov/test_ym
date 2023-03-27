<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RecoverPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class RecoverPasswordController extends Controller
{
    /**
     * @param \App\Http\Requests\Auth\RecoverPasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(RecoverPasswordRequest $request): JsonResponse
    {
        $response = $this->broker()->sendResetLink(
            ['email' => $request->get('email')]
        );

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
