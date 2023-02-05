<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResponse;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function store(BookRequest $request)
    {
        $bookInformation = $request->all();

        /** @var User $user */
        $user = Auth::user();

        $book = $user->books()->save(new Book($bookInformation));

        return response(new BookResponse($book->load('genre')), Response::HTTP_CREATED);
    }
}
