<?php

namespace App\Http\Controllers;

use App\Models\Cloth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model as Model;



class ProductController extends Controller {

	// set index page view
	public function index() {
		return view('index');
	}

	// handle fetch all products ajax request
	public function fetchAll() {
		$cloth = Cloth::all();
		$output = '';
		if ($cloth->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Image</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($cloth as $clo) {
				$output .= '<tr>
                <td>' . $clo->_id . '</td>
		        <td>' . $clo->name  . '</td>
                <td>' . $clo->category . '</td>
                <td>' . $clo->price . '</td>
                <td>' . $clo->description . '</td>
                <td>' . $clo->quantity . '</td>
				<td><img src="storage/images/' . $clo->image . '" width="100" ></td>
                <td>
                  <a href="#" id="' . $clo->_id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editProductModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $clo->_id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	
	// handle insert a new product ajax request
	public function store(Request $request) {
		$file = $request->file('image');
		$fileName = time().'_'.$file->getClientOriginalName();
		$file->storeAs('public/images', $fileName);
		$cloData = ['name' => $request->name, 'category' => $request->category, 'price' => $request->price, 'description' => $request->description, 'quantity' => $request->quantity, 'image' => $fileName];
		Cloth::create($cloData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit an product ajax request
	public function edit(Request $request) {
		// $clo = Cloth::where('_id',$request->id);
		$clo = Cloth::find($request->id);
		return response()->json($clo);
	}

	// handle update an product ajax request
	public function update(Request $request) {
		$fileName = '';
		$clo = Cloth::find($request->id);
		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$fileName = time().'_'.$file->getClientOriginalName();
			
			$file->storeAs('public/images', $fileName);
			
			if ($clo->image) {
				Storage::delete('public/images/' . $clo->image);
			}
		} else {
			$fileName = $request->image;
		}

        
		$cloData = ['name' => $request->name, 'category' => $request->category, 'price' => $request->price, 'description' => $request->description, 'quantity' => $request->quantity, 'image' => $fileName];

		$clo->update($cloData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete an product ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$clo = Cloth::find($id);
		if (Storage::delete('public/images/' . $clo->image)) {
			Cloth::destroy($id);
		}
	}
}   