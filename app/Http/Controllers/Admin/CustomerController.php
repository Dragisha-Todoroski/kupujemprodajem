<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequests\StoreCustomerRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerRequest;
use App\Contracts\CustomerService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerService $customerService)
    {
        // Only authenticated users can access these routes
        $this->middleware(['auth', 'is_admin']);

        // Applies policy automatically to action methods
        $this->authorizeResource(User::class, 'customer');
    }

    /**
     * Display all customers in admin dashboard
     */
    public function index(): View
    {
        $customers = $this->customerService->getAll(5);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create(): View
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer in storage
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $this->customerService->create($request->validated());
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer created successfully.');
    }

    /**
     * Show the form for editing any specific customer
     */
    public function edit(User $customer): View
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage
     */
    public function update(UpdateCustomerRequest $request, User $customer): RedirectResponse
    {
        $this->customerService->update($customer, $request->validated());
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer updated successfully.');
    }

/**
     * Remove the specified customer from storage
     */
    public function destroy(User $customer): RedirectResponse
    {
        // If deleted user was a customer, redirect with success message
        if ($this->customerService->delete($customer)) {
            return redirect()->route('admin.customers.index')
                             ->with('success', 'Customer deleted successfully.');
        }

        // Otherwise, if admin, redirect with error message
        return redirect()->route('admin.customers.index')
                         ->with('error', 'Cannot delete admin users.');
    }
}
