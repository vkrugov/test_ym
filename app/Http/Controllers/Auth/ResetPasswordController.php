<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class ResetPasswordController extends Controller
{
    /**
     * @param \App\Http\Requests\Auth\ResetPasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(ResetPasswordRequest $request): JsonResponse
    {
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }
    }

    /**
     * @param \App\Models\User $user
     * @param string           $password
     *
     * @return void
     */
    protected function resetPassword(User $user, string $password): void
    {
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
    }

    /**
     * @param \App\Models\User $user
     * @param string           $password
     *
     * @return void
     */
    protected function setUserPassword(User $user, string $password): void
    {
        $user->password = Hash::make($password);
    }

    /**
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }

    /**
     * @param \App\Http\Requests\Auth\ResetPasswordRequest $request
     *
     * @return array
     */
    private function credentials(ResetPasswordRequest $request): array
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
}
