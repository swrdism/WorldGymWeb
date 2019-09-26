<?php

namespace App\Http\Controllers\Api;

use App\Services\DataService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function getStoreDataList(){
        return (new DataService())->getStoreDataList();
    }

    public function getIsUpdated(){
        return (new DataService())->getIsUpdated();
    }

    public function getClassNameDataList(){
        return (new dataService())->getClassNameDataList();
    }
    public function getTeacherDataList()
    {
        return (new dataService())->getTeacherDataList();
    }
    public function getWorldGymClassList()
    {
        return (new dataService())->getWorldGymClassList();
    }
}
