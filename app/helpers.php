<?php
// use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\WemaVirtualAccount;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;


    // function audit($action, $modelType, $modelId, $oldValues = [], $newValues = [], $description = null, $agents = null)
    // {
    // $agent = new Agent();
    // // Get device information
    // $deviceName = $agent->device();
    // // $deviceName = $device['device'];
    // // Get operating system information
    // $platform = $agent->platform();
    // // Get browser information
    // $browser = $agent->browser();
    // $userAgent = $agent->getUserAgent();
    // // dd($userAgent);
    // //   $deviceName = Agent::device();
    // //   $platform = Agent::platform();
    // //   $browser = Agent::browser();
    //     $userId = Auth::id();
    //     $name = Auth::user()->first_name . ' '. Auth::user()->last_name;
    //     DB::table('audit_trails')->insert([
    //         'user_id' => $userId,
    //         'action' => $action,
    //         'description' => $description,
    //         'model_type' => $modelType,
    //         'url' => url()->current(),
    //         'machine_name' => $deviceName . ' , ' . $platform . ' , ' . $browser . ' '. $userAgent,
    //         'ip_address' => request()->ip(),
    //         'model_id' => $modelId,
    //         'old_values' => json_encode($oldValues),
    //         'new_values' => json_encode($newValues),
    //         'created_at' => now(),
    //     ]);
    // }

    function uploadImage($file, $path)
    {
        $image_name = $file->getClientOriginalName();
        $image_name_withoutextensions = pathinfo($image_name, PATHINFO_FILENAME);
        $name = str_replace(" ", "", $image_name_withoutextensions);
        $image_extension = $file->getClientOriginalExtension();
        $file_name_extension = trim($name . '.' . $image_extension);
        $uploadedFile = $file->move(public_path($path), $file_name_extension);
        return $path . '/' . $file_name_extension;
    }
