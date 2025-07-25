<?php
namespace App\Http\Controllers;

use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanProductController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        date_default_timezone_set(get_timezone());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $assets = ['datatable'];
        $loanproducts = LoanProduct::all()->sortByDesc("id");
        return view('backend.admin.loan_product.list', compact('loanproducts', 'assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $alert_col = 'col-lg-8 offset-lg-2';
        return view('backend.admin.loan_product.create', compact('alert_col'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'                      => 'required',
            'loan_id_prefix'            => 'nullable|max:10',
            'starting_loan_id'          => 'required|integer',
            'minimum_amount'            => 'required|numeric',
            'maximum_amount'            => 'required|numeric',
            'interest_rate'             => 'required|numeric',
            'interest_type'             => 'required',
            'term'                      => 'required|integer',
            'term_period'               => 'required',
            'status'                    => 'required',
            'loan_application_fee'      => 'required',
            'loan_application_fee_type' => 'required',
            'loan_processing_fee'       => 'required',
            'loan_processing_fee_type'  => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('loan_products.create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $loanproduct                            = new LoanProduct();
        $loanproduct->name                      = $request->input('name');
        $loanproduct->loan_id_prefix            = $request->input('loan_id_prefix');
        $loanproduct->starting_loan_id          = $request->input('starting_loan_id');
        $loanproduct->minimum_amount            = $request->minimum_amount;
        $loanproduct->maximum_amount            = $request->maximum_amount;
        $loanproduct->description               = $request->input('description');
        $loanproduct->interest_rate             = $request->input('interest_rate');
        $loanproduct->interest_type             = $request->input('interest_type');
        $loanproduct->term                      = $request->input('term');
        $loanproduct->term_period               = $request->input('term_period');
        $loanproduct->late_payment_penalties    = $request->input('late_payment_penalties');
        $loanproduct->status                    = $request->input('status');
        $loanproduct->loan_application_fee      = $request->loan_application_fee;
        $loanproduct->loan_application_fee_type = $request->loan_application_fee_type;
        $loanproduct->loan_processing_fee       = $request->loan_processing_fee;
        $loanproduct->loan_processing_fee_type  = $request->loan_processing_fee_type;

        $loanproduct->save();

        //Prefix Output
        $loanproduct->interest_type = ucwords(str_replace("_", " ", $loanproduct->interest_type));
        $loanproduct->term_period   = ucwords($loanproduct->term_period);

        if (! $request->ajax()) {
            return redirect()->route('loan_products.index')->with('success', _lang('Saved successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Saved successfully'), 'data' => $loanproduct, 'table' => '#loan_products_table']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $tenant, $id) {
        $loanproduct = LoanProduct::find($id);
        if (! $request->ajax()) {
            return view('backend.admin.loan_product.view', compact('loanproduct', 'id'));
        } else {
            return view('backend.admin.loan_product.modal.view', compact('loanproduct', 'id'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $tenant, $id) {
        $alert_col   = 'col-lg-8 offset-lg-2';
        $loanproduct = LoanProduct::find($id);
        return view('backend.admin.loan_product.edit', compact('loanproduct', 'id', 'alert_col'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tenant, $id) {
        $validator = Validator::make($request->all(), [
            'name'                      => 'required',
            'loan_id_prefix'            => 'nullable|max:10',
            'starting_loan_id'          => 'required|integer',
            'minimum_amount'            => 'required|numeric',
            'maximum_amount'            => 'required|numeric',
            'interest_rate'             => 'required|numeric',
            'interest_type'             => 'required',
            'term'                      => 'required|integer',
            'term_period'               => 'required',
            'status'                    => 'required',
            'loan_application_fee'      => 'required',
            'loan_application_fee_type' => 'required',
            'loan_processing_fee'       => 'required',
            'loan_processing_fee_type'  => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('loan_products.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $loanproduct                            = LoanProduct::find($id);
        $loanproduct->name                      = $request->input('name');
        $loanproduct->loan_id_prefix            = $request->input('loan_id_prefix');
        $loanproduct->starting_loan_id          = $request->input('starting_loan_id');
        $loanproduct->minimum_amount            = $request->minimum_amount;
        $loanproduct->maximum_amount            = $request->maximum_amount;
        $loanproduct->description               = $request->input('description');
        $loanproduct->interest_rate             = $request->input('interest_rate');
        $loanproduct->interest_type             = $request->input('interest_type');
        $loanproduct->term                      = $request->input('term');
        $loanproduct->term_period               = $request->input('term_period');
        $loanproduct->late_payment_penalties    = $request->input('late_payment_penalties');
        $loanproduct->status                    = $request->input('status');
        $loanproduct->loan_application_fee      = $request->loan_application_fee;
        $loanproduct->loan_application_fee_type = $request->loan_application_fee_type;
        $loanproduct->loan_processing_fee       = $request->loan_processing_fee;
        $loanproduct->loan_processing_fee_type  = $request->loan_processing_fee_type;

        $loanproduct->save();

        //Prefix Output
        $loanproduct->interest_type = ucwords(str_replace("_", " ", $loanproduct->interest_type));
        $loanproduct->term_period   = ucwords($loanproduct->term_period);

        if (! $request->ajax()) {
            return redirect()->route('loan_products.index')->with('success', _lang('Updated successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Updated successfully'), 'data' => $loanproduct, 'table' => '#loan_products_table']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tenant, $id) {
        $loanproduct = LoanProduct::find($id);
        $loanproduct->delete();
        return redirect()->route('loan_products.index')->with('success', _lang('Deleted successfully'));
    }
}