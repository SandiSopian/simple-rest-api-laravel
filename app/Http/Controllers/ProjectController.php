<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource (REST LIST).
     */
    public function index(Request $request)
    {
        $query = Project::query();

        // 🔍 Pencarian berdasarkan nama
        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // 🔃 Sortir berdasarkan kolom (default: id)
        $sort = $request->get('sort', 'id');
        $query->orderBy($sort, 'asc');

        // 📄 Pagination
        $projects = $query->paginate(5); // bisa diganti 10, 20, dst

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🛡️ Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create($validated);

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // 🛡️ Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
