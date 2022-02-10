<?php

// flash success message 

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

// send success
function send_success($msg)
{
    return redirect()->back()->with("success", $msg);
}

// send error
function send_error($msg)
{
    return redirect()->back()->with("error", $msg);
}

// delete file
function delete_file($path)
{
    if (Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }
}
