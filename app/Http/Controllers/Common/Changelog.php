<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;

class Changelog extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add permission check
        $this->middleware('permission:read-common-reports');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commits = $this->getGitCommits();

        return view('common.changelog.index', compact('commits'));
    }

    /**
     * Get the latest git commits.
     *
     * @return array
     */
    private function getGitCommits()
    {
        try {
            $filePath = base_path('CHANGELOG.md');

            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                $lines = explode("\n", trim($content));
                $commits = [];

                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line) || !str_starts_with($line, '- ')) continue;

                    // Remove the '- ' prefix
                    $line = substr($line, 2);

                    // Split hash and message
                    $parts = explode(': ', $line, 2);
                    if (count($parts) == 2) {
                        $commits[] = [
                            'hash' => $parts[0],
                            'message' => $parts[1],
                        ];
                    }
                }

                return $commits;
            }
        } catch (\Exception $e) {
            // If fails, return empty array
        }

        return [];
    }
}