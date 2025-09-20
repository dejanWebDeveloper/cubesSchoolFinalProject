<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index_page.index_page');
    }
    public function sliderHomepage()
    {
        return view('admin.slider_pages.slider_page');
    }
    public function addSliderData()
    {
        return view('admin.slider_pages.add_slider_data_form');
    }
    public function datatable(Request $request)
    {
        //$query = SliderData::query();
        $query = SliderData::select(['id', 'heading', 'slug', 'background', 'url', 'button_name', 'status', 'position', 'created_at'])
            ->orderBy('position', 'asc');


        return DataTables::of($query)
            ->addColumn('background', fn($row) =>
                "<img src='" . e($row->sliderImageUrl()) . "' width='100' class='img-rounded' />"
            )
            ->addColumn('heading', fn($row) => $row->heading)
            ->addColumn('url', fn($row) => $row->url)
            ->addColumn('button_name', fn($row) => $row->button_name)
            ->addColumn('position', fn($row) => $row->position) // ovo RowReorder koristi
            ->addColumn('status', fn($row) => $row->status
                ? '<span class="badge badge-success">Enabled</span>'
                : '<span class="badge badge-danger">Disabled</span>')
            ->editColumn('created_at', fn($row) =>
            $row->created_at?->format('d/m/Y H:i:s')
            )
            ->addColumn('actions', fn($row) =>
            view('admin.slider_pages.partials.actions', compact('row'))
            )
            ->rawColumns(['background', 'actions', 'status'])
            ->setRowId('id') // <tr id="5">
            ->toJson();

    }
    public function storeSlider()
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:5', 'max:100'],
            'url' => ['required', 'url'],
            'button_name' => ['required', 'string', 'min:3', 'max:15'],
            'background' => ['file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $data['slug'] = Str::slug($data['heading']);
        $data['position'] = 1;
        $data['status'] = 1;
        $data['created_at'] = now();
        $newSlider = new SliderData();
        $newSlider->fill($data)->save();
        //saving photo
        if (request()->hasFile('background')) { //if has file
            $photo = request()->file('background'); //save file to $photo
            //helper methode
            $this->savePhoto($photo, $newSlider, 'background');
        }
        session()->put('system_message', 'Slider Added Successfully');
        return redirect()->route('admin_sliders_page');
    }

    public function savePhoto($photo, $slider, $field)
    {
        // Generate unique filename
        $photoName = $slider->id . '_' . $field . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

        // Delete old photo if exists
        if ($slider->$field) {
            $oldPath = 'photo/slider/' . $slider->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Save new photo to storage
        $path = $photo->storeAs('photo/slider/', $photoName, 'public');

        // Update DB
        $slider->$field = basename($path);
        $slider->save();
    }

    public function deletePhoto($slider, $field)
    {
        if (!$slider->$field) return false;

        $path = 'photo/slider/' . $slider->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $slider->$field = null;
        $slider->save();

        return true;
    }
    public function deleteSlider()
    {
        $data = request()->validate([
            'slider_for_delete_id' => ['required', 'numeric', 'exists:slider_data,id'],
        ]);
        $slider = SliderData::findOrFail($data['slider_for_delete_id']);
        $this->deletePhoto($slider, 'background');
        $slider->delete();
        //delete data from post_tags table
        return response()->json(['success' => 'Slider Deleted Successfully']);
    }
    public function editSlider($id, $slug)
    {
        $sliderForEdit = SliderData::where('slug', $slug)->where('id', $id)->firstOrFail();
        return view('admin.slider_pages.edit_slider_page', compact(
            'sliderForEdit'
        ));
    }
    public function storeEditedSlider(SliderData $sliderForEdit, Request $request)
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:5', 'max:100'],
            'url' => ['required', 'url'],
            'button_name' => ['required', 'string', 'min:3', 'max:15'],
            'background' => ['file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $data['slug'] = Str::slug($data['heading']);
        $data['status'] = $sliderForEdit->status;
        $data['position'] = $sliderForEdit->position;
        $data['updated_at'] = now();
        $sliderForEdit->fill($data)->save();
        //saving photo
        if ($request->hasFile('background')) {
            $this->deletePhoto($sliderForEdit, 'background');
            $this->savePhoto($request->file('background'), $sliderForEdit, 'background');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->deletePhoto($sliderForEdit, 'background');
        }
        session()->put('system_message', 'Slider Data Edited Successfully');
        return redirect()->route('admin_sliders_page');
    }
    public function disableSlider()
    {
        $data = request()->validate([
            'slider_for_disable_id' => ['required', 'numeric', 'exists:slider_data,id'],
        ]);
        $slider = SliderData::findOrFail($data['slider_for_disable_id']);
        $slider->status = 0;
        $slider->save();
        return response()->json(['success' => 'Slider Disabled Successfully']);
    }
    public function enableSlider()
    {
        $data = request()->validate([
            'slider_for_enable_id' => ['required', 'numeric', 'exists:slider_data,id'],
        ]);
        $slider = SliderData::findOrFail($data['slider_for_enable_id']);
        $slider->status = 1;
        $slider->save();
        return response()->json(['success' => 'Slider Enabled Successfully']);
    }

    public function sort(Request $request)
    {
        foreach ($request->order as $item) {
            SliderData::where('id', $item['id'])
                ->update(['position' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }




}
