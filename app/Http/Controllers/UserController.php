<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Package;
use App\Models\Router;
use App\Models\Detail;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get search query
        $search = $request->input('search');
        
        // Get Users (role = 'user') with search
        $usersQuery = User::where('role', 'user')->with('detail');
        if ($search) {
            $usersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $usersQuery->orderBy('created_at', 'desc')->get();
        
        // Get Customers with search (for compatibility with customer portal)
        $customersQuery = \App\Models\Customer::with('detail');
        if ($search) {
            $customersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $customers = $customersQuery->orderBy('created_at', 'desc')->get();
        
        // Get Pending Package Requests
        $pendingPackageRequests = \App\Models\PackageRequest::where('status', 'pending')
            ->with(['customer', 'package'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('users.index', compact('users', 'customers', 'pendingPackageRequests', 'search'));
    }

    public function create()
    {
        $packages = Package::orderBy('name')->get();
        $routers = Router::orderBy('name')->get();
        
        return view('users.create', compact('packages', 'routers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'dob' => 'required|date',
            'pin' => 'nullable|string|max:50',
            'package_name' => 'required|exists:packages,id',
            'router_name' => 'required|exists:routers,id',
            'router_password' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $package = Package::findOrFail($request->package_name);
            $router = Router::findOrFail($request->router_name);

            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            // Create Detail for User
            Detail::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'dob' => $request->dob,
                'pin' => $request->pin,
                'router_name' => $router->name,
                'router_password' => $request->router_password,
                'package_name' => $package->name,
                'package_price' => $package->price,
                'package_start' => now(),
                'due' => $package->price,
                'status' => 'active',
            ]);

            // Auto-generate initial billing record
            Billing::create([
                'invoice' => $this->generateInvoiceNumber(),
                'package_name' => $package->name,
                'package_price' => $package->price,
                'package_start' => now(),
                'user_id' => $user->id,
                'status' => 'unpaid',
                'paid_amount' => 0,
                'due_amount' => $package->price,
            ]);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully with billing generated!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('User creation error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $packages = Package::orderBy('name')->get();
        $routers = Router::orderBy('name')->get();
        
        return view('users.edit', compact('user', 'packages', 'routers'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'phone' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date',
            'pin' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->email = $request->email;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            if ($user->detail) {
                $user->detail->update([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'pin' => $request->pin,
                ]);
            }

            DB::commit();
            return redirect()->route('users.show', $user->id)->with('success', 'User updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('User update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            // Delete related records
            if ($user->detail) {
                $user->detail->delete();
            }
            
            // Delete billings
            Billing::where('user_id', $user->id)->delete();
            
            // Delete payments
            \App\Models\Payment::where('user_id', $user->id)->delete();
            
            // Delete tickets
            if (method_exists($user, 'tickets')) {
                $user->tickets()->delete();
            }
            
            // Delete the user
            $user->delete();
            
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Delete error: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Failed to delete: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique invoice number
     */
    private function generateInvoiceNumber()
    {
        do {
            $invoice = mt_rand(100000000, 999999999);
        } while (Billing::where('invoice', $invoice)->exists());
        
        return $invoice;
    }
}