<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RepositoriesController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index(Request $request)
    {
        return response()->json($this->user->repositories);
    }

    public function commits()
    {
        $commits = $this->user->commits()
            ->latest()
            ->get();

        return response()->json($commits);
    }

    public function repositoryCommits(Request $request, $username, $repository)
    {
        $commits = $this->user->repositories()
            ->findByName($username . '/' . $repository)
            ->commits()
            ->latest()
            ->get();

        return response()->json($commits);
    }
}
