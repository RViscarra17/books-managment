<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/login",
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="email",
     *                  description="User email",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  description="User password",
     *                  type="string",
     *              ),
     *          ),
     *      ),
     *  ),
     *   @OA\Response(
     *       response=200,
     *       description="User logged",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="token",
     *                  description="User email",
     *                  type="string",
     *                  example="15|dHhS5hMHJHmBMPzTbSWESoDW1mKPbqvzqFBuGGwA"
     *              ),
     *          ),
     *      ),
     *   )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();

        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;
        return response(['token' => $token], Response::HTTP_OK);
    }
}
