<?php

namespace App\Http\Controllers;

use App\Models\ToDoItem;
use App\Http\Requests\StoreToDoItemRequest;
use App\Http\Requests\UpdateToDoItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $toDoItems = ToDoItem::where('user_id',Auth::id())->orderBy('id','DESC')->withTrashed()->paginate(10);
        return view('to_do_item.index', compact('toDoItems'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('to_do_item.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToDoItemRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $data=$request->except('_token');
        $data['user_id'] = Auth::id();
        $createToDoItem = ToDoItem::create($data);
        return redirect('/todoitems')->with('success', 'Item was successfully created');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToDoItem $toDoItem)
    {
        return view('to_do_item.edit', compact('toDoItem'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToDoItemRequest $request, ToDoItem $toDoItem)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $data = $request->except('_token');
        if(!isset($data['is_completed'])){
            $data['is_completed'] = 0;
        }
        $toDoItem->update($data);
        return redirect('/todoitems')->with('success', 'Item was successfully updated');

    }
    public function complete(ToDoItem $toDoItem)
    {
        $toDoItem->is_completed = 1;
        $toDoItem->save();
        return redirect('/todoitems')->with('success', 'Item was successfully completed');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyHandler(ToDoItem $toDoItem,$isDestroy)
    {
        if($isDestroy){
            $toDoItem->delete();
            return redirect()->back()->with('success', 'Item was successfully deleted');
        }
        else{
            $toDoItem->restore();
            return redirect()->back()->with('success', 'Item was successfully restored');
        }
    }






    /////////////////////////
    //showcase dynamic methods
    public function dynamicIndex(Request $request)
    {
        //dynamic search by name
        $model = ToDoItem::where([
            ['id', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->where('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(10);
        $fillable = new ToDoItem();
        $fillable = $fillable->getFillable();
        $modelName = "ToDoItem";
        $parentId= null;
        return view('dynamic_views.index', compact('model', 'modelName', 'fillable', 'parentId'));
    }

    public function dynamicSaveView($id = null, $parentId = null)
    {

        if ($id == 0) {
            $id = null;
        }

        $selectOptions = Model::where('parent_id')->get();
        $modelName = "ToDoItem";
        $toDoItem = new ToDoItem();
        $selectedParent = null;
        $parentName = null;
        $modelInputsConfigs = $toDoItem->getInputsConfigs();
        $checkBoxOptions = null;
        $multipleSelectBoxes = false;
        $lastPriority = null;
        //create
        if ($id == null) {
            return view('dynamic_views.save', compact('lastPriority', 'id', 'modelInputsConfigs', 'modelName', 'selectOptions', 'selectedParent', 'parentId', 'parentName', 'checkBoxOptions', 'multipleSelectBoxes'));
        } //edit
        else {
            $toDoItem = ToDoItem::findOrFail($id);
            $selectedParent = Model::where('id',$toDoItem->model_id)->first();

            $modelAttributes = $toDoItem->getAttributes();
            foreach ($modelInputsConfigs as $fillableName => $fillableConfig) {
                $modelInputsConfigs[$fillableName]['value'] = $modelAttributes[$fillableName];
            }
            return view('dynamic_views.save', compact('lastPriority', 'id', 'modelInputsConfigs', 'modelName', 'selectOptions', 'selectedParent', 'parentId', 'parentName', 'checkBoxOptions', 'multipleSelectBoxes'));
        }
    }
}
