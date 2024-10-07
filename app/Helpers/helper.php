<?php

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;

if (!function_exists('admin_logged_in')) {
    function admin_logged_in()
    {
        if(Auth::user()){
            if(Auth::user()->user_role === 'admin'){
                return true;
            }
            return false;
        }
    }
}
if (!function_exists('user_logged_in')) {
    function user_logged_in()
    {
        if(Auth::user()){
            if(Auth::user()->user_role === 'user'){
                return true;
            }
            return false;
        }
    }
}

if (!function_exists('fileUpload')) {
    function fileUpload($request, $name, $store_path)
    {
        if ($request->hasFile($name)) {
            $request->validate([
                $name => 'mimes:jpg,jpeg,png,pdf|file|max:2048'
            ]);
            $extension = $request->file($name)->getClientOriginalExtension();
            $imgName = uniqid() . '.' . $extension;
            $request->file($name)->storeAs($store_path,$imgName,'public');
            
            return '/storage/images/'.$imgName;
        }
    }
}

// update the file uploaded
if (!function_exists('updateFileUpload')) {
    function updateFileUpload($request, $file_name, $destination_path, $model, $column_name)
    {
        if ($request->hasFile($file_name)) {
            $request->validate([
                $file_name => 'mimes:jpg,jpeg,png,pdf|max:2048'
            ]);
            $extension = $request->file($file_name)->getClientOriginalExtension();
            $img = uniqid() . '.' . $extension;
            $request->file($file_name)->storeAs($destination_path, $img,'public');

            return '/storage/images/'.$img;
        } else {
            return $model->$column_name;
        }
    }
}

if (!function_exists('get_option')) {
    function get_option($option_key)
    {
        $getOption = GeneralSetting::select('option_value')->where('option_key', $option_key)->where('status', 1)->firstOrFail();
        return $getOption->option_value;
    }
}
if (!function_exists('update_option')) {
    function update_option($key, $value)
    {
        $option = GeneralSetting::where('option_key', $key)->firstOrFail();
        $option->option_value = $value;
        $option->save();
    }
}