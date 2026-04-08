<?php 

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Router;
use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\Mikrotik;
use RouterOS\Query;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    /**
     * Display a listing of packages
     */
    public function index(Request $request)
    {
        // Initialize date variables
        $fromDate = null;
        $toDate = null;
        $packageUsers = null;
        $packageStats = null;
        
        if (auth()->user()->isUser()) {
            $user = auth()->user();
            $router = Router::where("name", $user->detail->router_name)->firstOrFail();
            $packages = Package::where('router_id', $router->id)->orderBy('name')->get();
            return view('packages.index', compact('packages', 'fromDate', 'toDate', 'packageUsers', 'packageStats'));
        }

        if (auth()->user()->isAdmin()) {
            $packages = Package::orderBy('name')->get();
            
            // Get date filters
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            
            // Build the query for package-wise user details
            $query = DB::table('packages')
                ->join('details', 'packages.name', '=', 'details.package_name')
                ->join('users', 'details.user_id', '=', 'users.id')
                ->select(
                    'packages.id as package_id',
                    'packages.name as package_name',
                    'packages.price as package_price',
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.email as user_email',
                    'details.phone',
                    'details.address',
                    'details.package_start',
                    'details.due',
                    'details.status'
                );
            
            // Apply date filters if provided
            if ($fromDate) {
                $query->whereDate('details.package_start', '>=', $fromDate);
            }
            
            if ($toDate) {
                $query->whereDate('details.package_start', '<=', $toDate);
            }
            
            $packageUsers = $query
                ->orderBy('packages.name')
                ->orderBy('users.name')
                ->get()
                ->groupBy('package_name');
            
            // Get package statistics with date filters
            $statsQuery = DB::table('packages')
                ->leftJoin('details', 'packages.name', '=', 'details.package_name')
                ->leftJoin('users', 'details.user_id', '=', 'users.id')
                ->select(
                    'packages.id',
                    'packages.name',
                    'packages.price',
                    DB::raw('COUNT(DISTINCT users.id) as total_users'),
                    DB::raw('COUNT(DISTINCT CASE WHEN details.status = "active" THEN users.id END) as active_users'),
                    DB::raw('SUM(CASE WHEN details.due > 0 THEN details.due ELSE 0 END) as total_due')
                );
            
            // Apply date filters to statistics
            if ($fromDate) {
                $statsQuery->whereDate('details.package_start', '>=', $fromDate);
            }
            
            if ($toDate) {
                $statsQuery->whereDate('details.package_start', '<=', $toDate);
            }
            
            $packageStats = $statsQuery
                ->groupBy('packages.id', 'packages.name', 'packages.price')
                ->orderBy('packages.name')
                ->get();
            
            return view('packages.index', compact('packages', 'packageUsers', 'packageStats', 'fromDate', 'toDate'));
        }
    }

    /**
     * Show the form for creating a new package
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $routers = Router::orderBy('name')->get();

        if ($routers->isEmpty()) {
            return redirect()->route('packages.index')->with('error', __('Add a router first'));
        }

        // Dummy or real Mikrotik client
        $mikrotik = new Mikrotik();
        $client = $mikrotik->getClient();

        // Check connection
        $connectionFails = false;
        try {
            $client->query(new Query('/system/resource/print'))->read();
        } catch (\Exception $e) {
            $connectionFails = true;
        }

        return view('packages.create', compact('routers', 'connectionFails'));
    }

    /**
     * Store a newly created package in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:packages',
            'router_id'=> 'required|exists:routers,id',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $router = Router::findOrFail($request->router_id);

        // Try to connect to MikroTik or fallback to dummy
        $mikrotik = new Mikrotik();
        $client = $mikrotik->getClient();

        try {
            $query = new Query("/ppp/profile/add");
            $query->equal("name", $request->name);
            $client->query($query)->read();
        } catch (\Exception $e) {
            // DO NOT block package creation
            // Just log the error and continue
            \Log::warning('MikroTik connection failed during package creation: ' . $e->getMessage());
        }

        try {
            $package = new Package();
            $package->fill($validated);
            $package->save();

            return redirect()->route('packages.index')
                ->with('success', __('Package successfully added'));
                
        } catch (\Exception $e) {
            \Log::error('Package creation error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', __('Failed to create package: ') . $e->getMessage());
        }
    }

    /**
     * Display the specified package
     */
    public function show(Package $package)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isUser()) {
            return redirect('/');
        }

        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified package
     */
    public function edit(Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $routers = Router::orderBy('name')->get();
        
        // Check MikroTik connection
        $connectionFails = false;
        try {
            $mikrotik = new Mikrotik();
            $client = $mikrotik->getClient();
            $client->query(new Query('/system/resource/print'))->read();
        } catch (\Exception $e) {
            $connectionFails = true;
        }

        return view('packages.edit', compact('package', 'routers', 'connectionFails'));
    }

    /**
     * Update the specified package in storage
     */
    public function update(Request $request, Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        // Validate only the price field since name and router are disabled
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        try {
            // Update only the price
            $package->update($validated);

            return redirect()->route('packages.index')
                ->with('success', __('Package price updated successfully'));
                
        } catch (\Exception $e) {
            \Log::error('Package update error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', __('Failed to update package: ') . $e->getMessage());
        }
    }

    /**
     * Remove the specified package from storage
     */
    public function destroy(Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        try {
            // Check if package is being used by any users
            $usersCount = DB::table('details')
                ->where('package_name', $package->name)
                ->count();

            if ($usersCount > 0) {
                return back()->with('error', __('Cannot delete package. It is currently assigned to :count user(s).', ['count' => $usersCount]));
            }

            // Try to delete from MikroTik
            try {
                $mikrotik = new Mikrotik();
                $client = $mikrotik->getClient();
                
                $query = new Query("/ppp/profile/remove");
                $query->equal(".id", $package->name);
                $client->query($query)->read();
            } catch (\Exception $e) {
                \Log::warning('MikroTik deletion failed: ' . $e->getMessage());
            }

            $package->delete();

            return redirect()->route('packages.index')
                ->with('success', __('Package deleted successfully'));
                
        } catch (\Exception $e) {
            \Log::error('Package deletion error: ' . $e->getMessage());
            
            return back()->with('error', __('Failed to delete package: ') . $e->getMessage());
        }
    }
}