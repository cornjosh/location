<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index(Request $request){
      $user = $request->user();
      $devices = $user->devices;
      return view('device.index', compact('devices'));
    }

    public function create(){

    }

    public function show(Device $device){

    }

    public function store(){

    }

    public function edit(Device $device){

    }

    public function update(Device $device){

    }

    public function destroy(Device $device){

    }
}
