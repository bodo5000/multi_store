<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidOrderException extends Exception
{
    public function report()
    {
        //code
    }

    public function render(Request $request)
    {
        return redirect()
            ->route('front.home')
            ->withInput()
            ->withErrors(['message' => $this->getMessage()])
            ->with('info', $this->getMessage());
    }
}
