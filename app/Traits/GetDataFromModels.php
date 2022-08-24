<?php

namespace App\Traits;

trait GetDataFromModels
{


    public  function  getDataAll($model){

        return $model::all();
    }

    public  function  getDataById($model,$id){

        return $model::findOrFail($id);
    }

    public  function  getDataBywhere($model,$column_name,$id){

        return $model::where($column_name,$id)->get();
    }

    public  function  getDataBywhereuseFirst($model,$column_name,$id){

        return $model::where($column_name,$id)->first();
    }
}
