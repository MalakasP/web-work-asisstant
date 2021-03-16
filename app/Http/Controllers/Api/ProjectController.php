<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Get created and teams projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $createdProjects = Auth::user()->createdProjects;

        $user_teams = Auth::user()->teams;

        if (!$user_teams->isEmpty()) {
            foreach ($user_teams as $team) {
                $teams_projects[] = Project::where('team_id', $team->id)->get();
            }
        }
        
        if ($createdProjects->isEmpty() && $teams_projects->isEmpty()) {
            return response()->json([
                'error' => 'No projects found!'
            ], 404);
        }

        return response()->json([
            'createdProjects'    => $createdProjects,
            'createdTasks'    => $teams_projects ? $teams_projects : null
        ]);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \App\Http\Requests\CreateProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return response()->json([
            'project' => $project,
            'message' => 'Project created successfully!'
        ]);
    }

    /**
     * Display the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json([
            'project' => $project
        ]);
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($project->author_id != Auth::user()->id) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }

        $project->update($request->validated());

        return response()->json([
            'project' => $project,
            'message' => 'Project updated successfully!'
        ]);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->author_id != Auth::user()->id) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }

        $project->delete();

        return response()->json([
            'project' => $project,
            'message' => 'Project deleted successfully!'
        ]);
    }
}
