<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderData;
use App\Repositories\Admin\SliderDataRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\PhotoService;

class SliderDataController extends Controller
{
    protected $sliderData;
    protected $photoService;

    public function __construct(SliderDataRepository $sliderData, PhotoService $photoService)
    {
        $this->sliderData = $sliderData;
        $this->photoService = $photoService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.slider_pages.slider_page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider_pages.add_slider_data_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:5', 'max:100'],
            'url' => ['required', 'url'],
            'button_name' => ['required', 'string', 'min:3', 'max:15'],
            'background' => ['file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $newSlider = $this->sliderData->save($data);
        //saving photo
        if (request()->hasFile('background')) { //if has file
            $photo = request()->file('background'); //save file to $photo
            $this->photoService->saveSliderPhoto($photo, $newSlider, 'background');
        }
        session()->put('system_message', 'Slider Added Successfully');
        return redirect()->route('admin.sliders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $slug)
    {
        $sliderForEdit = $this->sliderData->editSliderPage($id, $slug);
        return view('admin.slider_pages.edit_slider_page', compact(
            'sliderForEdit'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderData $sliderForEdit, Request $request)
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:5', 'max:100'],
            'url' => ['required', 'url'],
            'button_name' => ['required', 'string', 'min:3', 'max:15'],
            'background' => ['file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $sliderForEdit = $this->sliderData->editSlider($data, $sliderForEdit);
        //saving photo
        if ($request->hasFile('background')) {
            $this->photoService->deleteSliderPhoto($sliderForEdit, 'background');
            $this->photoService->saveSliderPhoto($request->file('background'), $sliderForEdit, 'background');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->photoService->deleteSliderPhoto($sliderForEdit, 'background');
        }
        session()->put('system_message', 'Slider Data Edited Successfully');
        return redirect()->route('admin.sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Pokušaj da pronađeš slider po ID-u
        $slider = SliderData::find($id);

        if (!$slider) {
            // Vraćamo JSON grešku ako slider ne postoji
            return response()->json([
                'error' => 'Slider not found'
            ], 404);
        }

        // Obrisi sliku ako postoji
        if (isset($this->photoService)) {
            $this->photoService->deleteSliderPhoto($slider, 'background');
        }

        // Obrisi zapis
        $slider->delete();

        return response()->json(['success' => 'Slider Deleted Successfully']);
    }

    public function datatable()
    {
        $query = $this->sliderData->getFilteredSliderData();
        return DataTables::of($query)
            ->addColumn('background', fn($row) => "<img src='" . e($row->sliderImageUrl()) . "' width='100' class='img-rounded' />"
            )
            ->addColumn('heading', fn($row) => $row->heading)
            ->addColumn('url', fn($row) => $row->url)
            ->addColumn('button_name', fn($row) => $row->button_name)
            ->addColumn('position', fn($row) => $row->position) // ovo RowReorder koristi
            ->addColumn('status', fn($row) => $row->status
                ? '<span class="badge badge-success">Enabled</span>'
                : '<span class="badge badge-danger">Disabled</span>')
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s')
            )
            ->addColumn('actions', fn($row) => view('admin.slider_pages.partials.actions', compact('row'))
            )
            ->rawColumns(['background', 'actions', 'status'])
            ->setRowId('id') // <tr id="5">
            ->toJson();
    }
    public function disableSlider()
    {
        $data = request()->validate([
            'slider_for_disable_id' => ['required', 'numeric', 'exists:slider_data,id'],
        ]);
        $this->sliderData->disable($data);
        return response()->json(['success' => 'Slider Disabled Successfully']);
    }

    public function enableSlider()
    {
        $data = request()->validate([
            'slider_for_enable_id' => ['required', 'numeric', 'exists:slider_data,id'],
        ]);
        $this->sliderData->enable($data);
        return response()->json(['success' => 'Slider Enabled Successfully']);
    }

    public function sort(Request $request)
    {
        $this->sliderData->sorting($request);

        return response()->json(['status' => 'success']);
    }
}
