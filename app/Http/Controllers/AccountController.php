<?php

namespace App\Http\Controllers;

use App\DataTables\AccountDataTable;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Traits\AccountConfigTrait;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use AccountConfigTrait;

    private $parentFolder = 'transparency';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AccountDataTable $accountDatatable)
    {
        $status = !$request->ajax() ? $this->getAllStatus() : [];

        return $accountDatatable->render("$this->parentFolder.account-config.index", compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("$this->parentFolder.account-config.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        try {
            Account::create($request->validated());

            return redirect()->route("account-config.index")->with('success', 'Account Configuration Detail Stores Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $accountConfig)
    {
        return view("$this->parentFolder.account-config.edit", compact('accountConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $accountConfig)
    {
        try {
            $accountConfig->update($request->validated());

            return redirect()->route("account-config.index")->with('success', 'Account Configuration Detail Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $accountConfig)
    {
        try {
            $accountConfig->delete();

            return redirect()->route('account-config.index')->with('success', 'Account Configuration Detail Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
