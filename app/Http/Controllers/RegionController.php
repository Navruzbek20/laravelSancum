<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistrictResource;
use App\Http\Resources\RegionResource;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
  public function getRegion(){
    return DistrictResource::collection(District::paginate(env('pg')));
  }

}
