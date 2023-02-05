<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResponse;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *   tags={"Book"},
     *   path="/books",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *       response=200,
     *       description="List of books",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *               type="array",
     *               @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         description="Book id",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="title",
     *                         description="Book title",
     *                         type="string",
     *                         example="Title"
     *                    ),
     *                    @OA\Property(
     *                         property="author",
     *                         description="Book author",
     *                         type="string",
     *                         example="Author"
     *                    ),
     *                    @OA\Property(
     *                         property="genre",
     *                         description="Book genre name",
     *                         type="string",
     *                         example="Genre"
     *                    ),
     *               ),
     *          ),
     *      ),
     *   ),
     * ),
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $bookCollection = $user->books->load('genre');

        return response(BookResponse::collection($bookCollection), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *   tags={"Book"},
     *   path="/books",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="title",
     *                  description="Book title",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="author",
     *                  description="Book author",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="genre_id",
     *                  description="Book genre id",
     *                  type="integer",
     *              ),
     *          ),
     *      ),
     *  ),
     *   @OA\Response(
     *       response=201,
     *       description="Book created",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *                     @OA\Property(
     *                         property="id",
     *                         description="Book id",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="title",
     *                         description="Book title",
     *                         type="string",
     *                         example="Title"
     *                    ),
     *                    @OA\Property(
     *                         property="author",
     *                         description="Book author",
     *                         type="string",
     *                         example="Author"
     *                    ),
     *                    @OA\Property(
     *                         property="genre",
     *                         description="Book genre name",
     *                         type="string",
     *                         example="Genre"
     *                    ),
     *          ),
     *      ),
     *   )
     * )
     */
    public function store(BookRequest $request)
    {
        $bookInformation = $request->all();

        /** @var User $user */
        $user = Auth::user();

        $book = $user->books()->save(new Book($bookInformation));

        return response(new BookResponse($book->load('genre')), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Book"},
     *   path="/books/{book_id}",
     *   security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="book_id",
     *         description="Book id to delete",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *   @OA\Response(
     *       response=204,
     *       description="Returns empty body",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *          ),
     *      ),
     *   )
     * )
     */
    public function destroy(Book $book)
    {
        /** @var User $user */
        $user = Auth::user();

        if($user->id != $book->user_id){
            return response([
                'message' => 'This book is not in your favorite list.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $book->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }
}
