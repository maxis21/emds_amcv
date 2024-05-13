<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DirectoryController extends Controller
{
    /**
     * Creating new directory function here
     * Expand function if needed
     */
    public function createDirectory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string', // If path is not provided, assume root directory
        ]);

        //dd($request->input('path')); --debugging function for validating path string value
        /**
         * 
         */

        $path = $validatedData['path'] ?? '';
        $directoryName = $validatedData['name'];

        if (Storage::exists($path . '/' . $directoryName)) {
            return response()->json(['message' => 'Directory already exists'], 422);
        }

        Storage::makeDirectory($path . '/' . $directoryName);

        return response()->json(['message' => 'Directory created successfully'], 200);
    }

    /**
     * Renaming directory function here
     * Expand function if needed
     */
    public function renameDirectory(Request $request)
    {
        $validatedData = $request->validate([
            'old_name' => 'required|string|max:255',
            'new_name' => 'required|string|max:255',
            'path' => 'nullable|string', // If path is not provided, assume root directory

        ]);


        //dd($request->input('path')); --debugging function for validating path string value
        /**
         * 
         */

        $path = $validatedData['path'] ?? '';
        $oldName = $validatedData['old_name'];
        $newName = $validatedData['new_name'];

        if (!Storage::exists($path . '/' . $oldName)) {
            return response()->json(['message' => 'Directory not found'], 404);
        }

        Storage::move($path . '/' . $oldName, $path . '/' . $newName);

        return response()->json(['message' => 'Directory renamed successfully'], 200);
    }

    /**
     * Removing directory function here
     * Expand function if needed
     */
    public function removeDirectory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string', // If path is not provided, assume root directory
        ]);

        //dd($request->input('path')); --debugging function for validating path string value
        /**
         * 
         */

        $path = $validatedData['path'] ?? '';
        $directoryName = $validatedData['name'];

        if (!Storage::exists($path . '/' . $directoryName)) {
            return response()->json(['message' => 'Directory not found'], 404);
        }

        Storage::deleteDirectory($path . '/' . $directoryName);

        return response()->json(['message' => 'Directory deleted successfully'], 200);
    }

    /**
     * Moving directory function here
     * Expand function if needed
     */
    public function moveDirectory(Request $request)
    {
        $validatedData = $request->validate([
            'source_path' => 'required|string',
            'destination_path' => 'required|string',
            'directory_name' => 'required|string',
        ]);

        //dd($request->input('source_path')); --debugging function for validating path string value
        /**
         * 
         */

        $sourcePath = $validatedData['source_path'];
        $destinationPath = $validatedData['destination_path'];
        $directoryName = $validatedData['directory_name'];

        if (!Storage::exists($sourcePath . '/' . $directoryName)) {
            return response()->json(['message' => 'Directory not found in source path'], 404);
        }

        if (Storage::exists($destinationPath . '/' . $directoryName)) {
            return response()->json(['message' => 'Directory already exists in destination path'], 422);
        }

        Storage::move($sourcePath . '/' . $directoryName, $destinationPath . '/' . $directoryName);

        return response()->json(['message' => 'Directory moved successfully'], 200);
    }

    /**
     * Acts as index 
     * Browse directories function here
     * Expand functions here
     */
    public function browse()
    {
        $defaultDirectoryPath = public_path('storage'); // Specify the default directory path here
        $directories = Storage::directories($defaultDirectoryPath);
        $files = Storage::files($defaultDirectoryPath);

        return view('browse', compact('directories', 'contents'));
    }

    public function fetchFolderContents(Request $request)
    {
        $folder = $request->query('folder'); // Access query parameter 'folder'

        // Validate the folder path to prevent directory traversal
        /*     if (!Str::startsWith($folder, 'storage/')) {
                abort(403, 'Unauthorized action.');
            } */

        $directories = Storage::directories($folder);
        $files = Storage::files($folder);

        return response()->json([
            'directories' => $directories,
            'contents' => $files
        ]);
    }

}
