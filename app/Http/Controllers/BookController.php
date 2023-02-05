<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResponse;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $bookCollection = $user->books->load('genre');

        return response(BookResponse::collection($bookCollection), Response::HTTP_OK);
    }

    public function store(BookRequest $request)
    {
        $bookInformation = $request->all();

        /** @var User $user */
        $user = Auth::user();

        $book = $user->books()->save(new Book($bookInformation));

        return response(new BookResponse($book->load('genre')), Response::HTTP_CREATED);
    }
}
