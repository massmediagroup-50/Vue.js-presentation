<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Firm;

class FirmProfileController extends Controller
{
    private $user;
    private $firm;

    /**
     * FirmProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->firm = $this->user ? $this->user->firm : null;

            return $next($request);
        });
    }

    public function show()
    {
        return view('profile.firm', [
            'user' => $this->user,
            'firm' => $this->firm
        ]);
    }

    /**
     * @param Firm $firm
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(Firm $firm)
    {
        if ($this->firm->id === $firm->id) {
            Auth::guard()->logout();
            $firm->deactivate();
        }

        return response()->json([
            'success' => true
        ]);
    }
}