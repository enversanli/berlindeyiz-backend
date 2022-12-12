<?php

namespace App\Http\Controllers;

use App\Http\Actions\Category\GetCategoryListAction;
use App\Http\Resources\CategoryResource;
use App\Support\Enum\ServiceType;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /** @var GetCategoryListAction */
    protected $getCategoryListAction;

    public function __construct(GetCategoryListAction $getCategoryListAction){
        $this->getCategoryListAction = $getCategoryListAction;
    }

    public function index(Request $request){

        $categories = $this->getCategoryListAction->list($request->input('type', ServiceType::ACTIVITY));

        if (!$categories->status){
            return ResponseMessage::custumized();
        }

        return ResponseMessage::success('Başarılı', CategoryResource::collection($categories->data));
    }
}
