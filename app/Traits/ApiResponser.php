<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
 
 protected function successResponse($data, $code)
 {
    return response()->json($data,$code);
 }

 
protected function errorResponse($message,$code)
 {
    return response()->json(['error'=>$message,'code'=>$code],$code);
 }

 
 protected function showAll(Collection $collection,$code = 200)
 {
   $collection = $this->filterData($collection);  
   $collection = $this->sortData($collection);
   $collection = $this->paginate($collection);
   return $this->successResponse(['data'=>$collection],$code=200);
   
 }
 
 protected function showOne(Model $model,$code)
 {
    return $this->successResponse(['data'=>$model],$code=200);
 }

 public function sortData(Collection $collection)
 {
    if(request()->has('sort_by'))
    {
       $attribute = request()->sort_by;
       $collection = $collection->sortBy->{$attribute};
    }
    return $collection;
 }

 protected function filterData(Collection $collection)
 {
    foreach(request()->query as $query=>$value)
    {
       $attribute = $query;

       if(isset($attribute,$value))
       {
          $collection=$collection->where($attribute,$value);
       }
    }

    return $collection;
 }

 protected function paginate(Collection $collection)
 {
   $page = LengthAwarePaginator::resolveCurrentPage();
   $per_page = 10;
   $result = $collection->slice(($page - 1) * $per_page, $per_page)->values();
   $paginated = new LengthAwarePaginator($result,$collection->count(),$per_page,$page,['path'=>LengthAwarePaginator::resolveCurrentPath()]);
   $paginated->appends(request()->all());
   return $paginated;


 }

}
?>