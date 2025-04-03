<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TaskController extends Controller
{
    /**
     * Méthode pour afficher la liste des tâches
     */
    public function index()
    {
        $tasks = Task::all();

       return view('task.index', ['tasks' => $tasks]);
    }

    /**
     * Méthode pour afficher le formulaire de création d'une tâche
     */
    public function create()
    {
        $categories = Category::categories();

       // return view('task.create', ['categories' => $categories]);
        return view('task.create', compact('categories'));
    }

    /**
     * Méthode pour stocker une nouvelle tâche
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'min:10|string',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
            'category_id' => 'required|exists:categories,id'
        ],
        [], //message custom
        ['category_id'=> 'category']);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
            'user_id' => Auth::user()->id, // Récupérer l'ID de l'utilisateur connecté
            'category_id' => $request->category_id
        ]);

        return redirect()->route('task.show', $task->id)->with('success', 'Task created successfully!');

    }

    /**
     * Méthode pour afficher une tâche spécifique
     */
    public function show(Task $task)
    {
        //select * from tasks where id = $task;
        //$task = Task::find($task);

       return view('task.show', ['task' => $task]);
    }

    /**
     * Méthode pour afficher le formulaire d'édition d'une tâche
     */
    public function edit(Task $task)
    {
        return view('task.edit', ['task' => $task]);
    }

    /**
     * Méthode pour mettre à jour une tâche
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'min:10|string',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
        ]);
        
        return redirect()->route('task.show', $task->id)->withSuccess('Task updated!');
    
    }

    /**
     * Méthode pour supprimer une tâche
     */
    public function destroy(Task $task)
    {
        // Vérifier si l'utilisateur a la permission de supprimer une tâche
        $this->authorize('delete-task'); 
        //Auth::user()->can('delete-task');
        $id = $task->id;
        $task->delete();

        return redirect()->route('task.index')->withSuccess('Task number '.$id.' deleted!');
    }

    /**
     * Méthode pour afficher les tâches terminées ou non terminées
     */
    public function completed($completed){
       $tasks = Task::where('completed', $completed)->get();
       return view('task.index', ['tasks' => $tasks]);
    }


    /**
     * Méthode pour générer un PDF d'une tâche
     */
    public function pdf(Task $task)
    {
     $qrCode = QrCode::size(200)->generate(route('task.show', $task->id));
     $pdf = new Dompdf();
     $pdf->setPaper('letter', 'portrait');
     $pdf->loadHtml(view('task.show-pdf', ['task' => $task, 'qrCode' => $qrCode]));
     $pdf->render();
     return $pdf->stream('task_'.$task->id.'.pdf');
    }

}
