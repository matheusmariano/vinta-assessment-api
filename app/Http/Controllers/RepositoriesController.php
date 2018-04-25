<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use GrahamCampbell\GitHub\Facades\GitHub;
use App\Repository;
use Carbon\Carbon;

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

    public function add(Request $request, $username, $repository)
    {
        $res = GitHub::repo()->show($username, $repository);

        $repo = $this->user->repositories()->create([
            'name' => $res['full_name'],
        ]);

        $latestCommits = GitHub::repo()->commits()->all($username, $repository, ['sha' => 'master']);

        foreach ($latestCommits as $commit) {
            $repo->commits()->create([
                'author' => $commit['author'],
                'message' => $commit['commit']['message'],
                'timestamp' => Carbon::parse($commit['commit']['author']['date']),
                'uid' => $commit['sha'],
            ]);
        }

        return response()->json($repo);
    }
}
