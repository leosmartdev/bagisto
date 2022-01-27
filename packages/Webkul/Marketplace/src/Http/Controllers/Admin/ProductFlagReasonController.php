<?php

namespace Webkul\Marketplace\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webkul\Marketplace\Repositories\ProductFlagReasonRepository;

class ProductFlagReasonController extends Controller
{

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Contains intance of ProductFlagRepository
     *
     * @var object
     */
    protected $productFlagReasonRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Marketplace\Repositories\ProductFlagReasonRepository $ProductFlagReasonRepository
     */
    public function __construct(
        ProductFlagReasonRepository $productFlagReasonRepository
    )
    {
        $this->_config = request('_config');

        $this->productFlagReasonRepository = $productFlagReasonRepository;

        $this->middleware('admin');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->productFlagReasonRepository->create(request()->all());

        session()->flash('success', trans('marketplace::app.admin.products.flag.create-success'));

        return redirect()->route($this->_config['redirect']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flagReason  = $this->productFlagReasonRepository->find($id);

        return view($this->_config['view'], compact('flagReason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $flagReason  = $this->productFlagReasonRepository->find($id);

        $data  = request()->all();

        $data['status'] = $data['status'] == 'on' ? 1 : 0;

        $flagReason->update($data);

        session()->flash('success', trans('marketplace::app.admin.products.flag.update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $flagReason  = $this->productFlagReasonRepository->delete($id);

        session()->flash('success', trans('marketplace::app.admin.products.flag.delete-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * To mass delete the customer
     *
     * @return \Illuminate\Http\Response
     */
    public function massDelete()
    {
        $flagReasonIds = explode(',', request()->input('indexes'));

        foreach ($flagReasonIds as $flagReasonId) {
            $this->productFlagReasonRepository->deleteWhere(['id' => $flagReasonId]);
        }

        session()->flash('success', trans('marketplace::app.admin.products.flag.delete-success'));

        return redirect()->back();

    }
}
