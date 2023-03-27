<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;

    /**
     * @param \App\Repositories\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $params = $request->only([
            'email', 'password', 'first_name', 'last_name',
        ]);

        $user = $this->userRepository->create($params);
        $token = Auth::login($user);

        return $this->respondWithToken($token, Response::HTTP_CREATED);
    }

    /**
     * @param \App\Http\Requests\Auth\SignInRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'These credentials are not correct.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function self(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'user' => new UserResource($user->load('profile')),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param string $token
     * @param int    $responseCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken(string $token, int $responseCode = Response::HTTP_OK): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'auth' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60,
            ],
            'user' => new UserResource($user->load('profile')),
        ], $responseCode);
    }
}
