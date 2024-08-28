<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ToDoItem;
use App\Http\Requests\StoreToDoItemRequest;
use App\Http\Requests\UpdateToDoItemRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::get();
        $appliedFilters = [];
        //initial query
        //display my data + check for shared with me
        $toDoItemsQuery = ToDoItem::where(function ($query) {
            $query->where('user_id', Auth::id())
            ->orWhereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            });
        })->orderBy('id', 'DESC')->withTrashed();

        //cat filter
        if (isset($request->category)) {
            $toDoItemsQuery->whereHas('categories', function($q) use ($request) {
                $q->where('id', $request->category);
            });
            array_push($appliedFilters,$request->category);
        }
        //completed filter
        if (isset($request->is_completed)) {
            $toDoItemsQuery->where('is_completed', $request->is_completed);
            array_push($appliedFilters,$request->is_completed);
        }
        //my or shared items
        if (isset($request->ownership)) {
            if ($request->ownership === 'mine') {
                // Filter to only include items owned by the authenticated user
                $toDoItemsQuery->where('user_id', Auth::id());
            }
            elseif ($request->ownership === 'shared') {
                // Filter to only include items shared with the authenticated user
                $toDoItemsQuery->whereHas('users', function($q) {
                    $q->where('user_id', Auth::id());
                });
            }
            array_push($appliedFilters,$request->ownership);

        }
        $toDoItems = $toDoItemsQuery->paginate(10);


        //add indicator that it has been shared with me or not - bool
        foreach ($toDoItems as $item) {
            $item->is_shared = $item->user_id !== Auth::id();
        }
        return view('to_do_item.index', compact('toDoItems','categories','appliedFilters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        $users = User::whereNot('id',Auth::id())->get();
        return view('to_do_item.create', compact('users','categories'));

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
        if (isset($data['users'])) {
            $userIds = $data['users'];
            unset($data['users']);
        }
        if (isset($data['categories'])) {
            $categoryIds = $data['categories'];
            unset($data['categories']);
        }

        $data['user_id'] = Auth::id();
        $toDoItem = ToDoItem::create($data);


        if (!empty($userIds)) {
            $toDoItem->users()->attach($userIds);
        }
        if (!empty($categoryIds)) {
            $toDoItem->categories()->attach($categoryIds);
        }
        return redirect('/todoitems')->with('success', 'Item was successfully created');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToDoItem $toDoItem)
    {
        if (Auth::id() != $toDoItem->user_id && !$toDoItem->users->pluck('id')->contains(Auth::id())) {
            return redirect('/todoitems')->withErrors("This item hasn't been shared with you");
        }

        $canEditUsers = false;
        $users = User::whereNot('id',Auth::id())->get();
        $categories = Category::get();
        $selectedUserIds = $toDoItem->users()->pluck('id')->toArray();
        $selectedCategoryIds = $toDoItem->categories()->pluck('id')->toArray();
        if(Auth::id() == $toDoItem->user_id){
            $canEditUsers = true;
        }
        return view('to_do_item.edit', compact('toDoItem','users','selectedUserIds','selectedCategoryIds','canEditUsers','categories'));


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

        //handle users
        if($toDoItem->user_id == Auth::id()){
            if (isset($data['users'])) {
                $toDoItem->users()->sync($data['users']);
            }
            else {
                $toDoItem->users()->detach();
            }
        }

        //handle cats
        if (isset($data['categories'])) {
            $toDoItem->categories()->sync($data['categories']);
        } else {
            $toDoItem->categories()->detach();
        }

        return redirect('/todoitems')->with('success', 'Item was successfully updated');

    }
    public function complete(ToDoItem $toDoItem)
    {
        $toDoItem->is_completed = 1;
        $toDoItem->save();
        return redirect()->back()->with('success', 'Item was successfully completed');

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
