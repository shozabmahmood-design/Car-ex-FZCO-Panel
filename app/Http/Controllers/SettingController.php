<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;

class SettingController extends Controller
{
    public function index($userId)
    {
        $settings = Setting::where('user_id', $userId)->first();
        return $settings->toArray();
    }

    public function store(Request $request)
    {
        // Adding Validation Rules
        $validations = [
            'businessName' => 'required',
            'businessEmail' => 'required|email',
            'businessPhone' => 'required|numeric',
            'businessAddress' => 'required',
        ];
        // Checking Validations
        $request->validate($validations);
        // Checking if Settings are available
        $settings = Setting::where('user_id', $request->user_id)->first();
        $settings->businessName = $request->businessName;
        $settings->businessPhone = $request->businessPhone;
        $settings->businessEmail = $request->businessEmail;
        $settings->businessAddress = $request->businessAddress;
        $settings->businessWebsite = $request->businessWebsite;
        // Uploading Images
        if ($request->hasFile('businessLogo')) {
            $image = $request->file('businessLogo');
            $imgName = time() . rand(1000, 9999999) . "-" . str_replace(" ", "_", $image->getClientOriginalName());
            $image->move(public_path('uploads'), $imgName);
            $settings->businessLogo = $imgName;
        }
        
        $settings->footerText = $request->footerText;
        $settings->showPhone = $request->showPhone == "false" ? 0 : 1;
        $settings->showEmail = $request->showEmail == "false" ? 0 : 1;
        $settings->showAddress = $request->showAddress == "false" ? 0 : 1;
        $settings->save();
        // echo "<pre>";
        // print_r($request->all());
        // print_r($settings->toArray());
        // exit();

        // Returning Back with Response
        return response()->json([
            'settings' => $settings,
            'message' => 'Settings saved successfully!'
        ]);
    }
}
