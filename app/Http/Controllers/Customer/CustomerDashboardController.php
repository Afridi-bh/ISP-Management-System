<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Detail;
use App\Models\Billing;
use App\Models\Payment;
use App\Models\PackageRequest;
use Carbon\Carbon;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        // Find the associated User record by email
        $user = User::where('email', $customer->email)->first();
        
        if (!$user) {
            // No associated user found, show empty dashboard with zeros
            return view('customer.dashboard', [
                'customer' => $customer,
                'user' => null,
                'detail' => null,
                'monthlyBill' => 0,
                'advanceAmount' => 0,
                'totalDueBill' => 0,
                'packageExpireDate' => null,
                'daysUntilExpiry' => 0,
                'networkSpeed' => $this->getDefaultNetworkSpeed(),
                'usage' => (object)[
                    'download' => 0,
                    'upload' => 0,
                    'quota' => 0,
                    'total' => 0,
                ],
                'usagePercent' => 0,
                'notifications' => collect(),
            ]);
        }

        // Get user's detail information using user_id
        $detail = Detail::where('user_id', $user->id)->first();
        
        // Calculate financial data
        $monthlyBill = $detail ? $detail->package_price : 0;
        $totalDueBill = $detail ? $detail->due : 0;
        
        // Calculate advance amount (total paid - total billed)
        $totalPaid = Payment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('package_price');
        
        $totalBilled = Billing::where('user_id', $user->id)->sum('package_price');
        
        $advanceAmount = max(0, $totalPaid - $totalBilled);

        // Calculate package expiry
        $packageExpireDate = null;
        $daysUntilExpiry = 0;
        
        if ($detail && $detail->package_start) {
            // Assuming monthly package, add 30 days from start date
            $packageExpireDate = Carbon::parse($detail->package_start)->addDays(30);
            $daysUntilExpiry = Carbon::now()->diffInDays($packageExpireDate, false);
            
            // Allow negative days to show "expired"
            if ($daysUntilExpiry < 0) {
                $daysUntilExpiry = 0;
            }
        }

        // Get network speed data (dummy data)
        $networkSpeed = $this->getNetworkSpeed($detail);

        // Get usage data
        $usage = $this->getUsageData($user->id, $detail);
        $usagePercent = $usage->quota > 0 ? min(100, (($usage->download + $usage->upload) / $usage->quota) * 100) : 0;

        // Get recent notifications (NOW INCLUDES PACKAGE REQUESTS)
        $notifications = $this->getNotifications($user->id, $customer->id, $detail);

        return view('customer.dashboard', compact(
            'customer',
            'user',
            'detail',
            'monthlyBill',
            'advanceAmount',
            'totalDueBill',
            'packageExpireDate',
            'daysUntilExpiry',
            'networkSpeed',
            'usage',
            'usagePercent',
            'notifications'
        ));
    }

    /**
     * Get network speed data for chart (DUMMY DATA)
     */
    private function getNetworkSpeed($detail)
    {
        // Extract package speed from package name (e.g., "10Mbps" or "15MBps")
        $maxSpeed = 10; // Default 10 Mbps
        
        if ($detail && $detail->package_name) {
            // Try to extract speed from package name
            preg_match('/(\d+)\s*MB/i', $detail->package_name, $matches);
            if (isset($matches[1])) {
                $maxSpeed = (int)$matches[1];
            }
        }

        // Generate timestamps for last 20 data points (every 2 seconds)
        $timestamps = [];
        for ($i = 19; $i >= 0; $i--) {
            $timestamps[] = Carbon::now()->subSeconds($i * 2)->format('H:i:s');
        }

        // Generate realistic dummy speed data with some variation
        $data = [];
        for ($i = 0; $i < 20; $i++) {
            // Random variation between 60-95% of max speed
            $downloadVariation = (rand(60, 95) / 100);
            // Upload typically 20-30% of download speed
            $uploadVariation = (rand(50, 80) / 100);
            
            $downloadSpeed = round($maxSpeed * $downloadVariation, 1);
            $uploadSpeed = round(($maxSpeed * 0.25) * $uploadVariation, 1);
            
            $data[] = [
                'download' => $downloadSpeed,
                'upload' => $uploadSpeed,
            ];
        }

        return [
            'timestamps' => $timestamps,
            'data' => $data,
            'max_speed' => $maxSpeed,
            'current_download' => end($data)['download'],
            'current_upload' => end($data)['upload'],
        ];
    }

    /**
     * Get default network speed when no detail exists
     */
    private function getDefaultNetworkSpeed()
    {
        $timestamps = [];
        for ($i = 19; $i >= 0; $i--) {
            $timestamps[] = Carbon::now()->subSeconds($i * 2)->format('H:i:s');
        }

        $data = array_fill(0, 20, ['download' => 0, 'upload' => 0]);

        return [
            'timestamps' => $timestamps,
            'data' => $data,
            'max_speed' => 10,
            'current_download' => 0,
            'current_upload' => 0,
        ];
    }

    /**
     * Get usage data (DUMMY DATA based on current date)
     */
    private function getUsageData($userId, $detail)
    {
        // Extract quota from package name if available
        $quota = 100; // Default 100 GB
        
        if ($detail && $detail->package_name) {
            // Try to extract quota from package name (e.g., "50GB", "100 GB")
            preg_match('/(\d+)\s*GB/i', $detail->package_name, $matches);
            if (isset($matches[1])) {
                $quota = (int)$matches[1];
            }
        }

        // Generate dummy usage based on how far into the month we are
        $currentDay = Carbon::now()->day;
        $daysInMonth = Carbon::now()->daysInMonth;
        
        // Calculate usage percentage (assume 70-85% usage rate based on days passed)
        $usageRate = rand(70, 85) / 100;
        $usagePercent = ($currentDay / $daysInMonth) * $usageRate;
        
        $download = round($quota * $usagePercent * 0.85, 2); // 85% is download
        $upload = round($quota * $usagePercent * 0.15, 2);   // 15% is upload

        return (object)[
            'download' => $download,
            'upload' => $upload,
            'quota' => $quota,
            'total' => $download + $upload,
        ];
    }

    /**
     * Get notifications for the user
     * NOW INCLUDES PACKAGE REQUEST APPROVALS/REJECTIONS/PENDING
     */
    private function getNotifications($userId, $customerId, $detail)
    {
        $notifications = collect();

        // ===== PACKAGE REQUEST NOTIFICATIONS =====
        // Removed date filter to show ALL package requests regardless of date
        $packageRequests = PackageRequest::where('customer_id', $customerId)
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->with('package')
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($packageRequests as $request) {
            if ($request->status === 'pending') {
                $notifications->push((object)[
                    'title' => 'Package Request Pending ⏳',
                    'message' => "Your request for {$request->package->name} package is awaiting admin review.",
                    'type' => 'info',
                    'created_at' => $request->created_at,
                    'package_name' => $request->package->name,
                    'admin_remarks' => null,
                    'status' => $request->status,
                ]);
            } elseif ($request->status === 'approved') {
                $notifications->push((object)[
                    'title' => 'Package Request Approved ✓',
                    'message' => "Your request for {$request->package->name} package has been approved.",
                    'type' => 'success',
                    'created_at' => $request->updated_at ?? $request->created_at,
                    'package_name' => $request->package->name,
                    'admin_remarks' => $request->admin_remarks,
                    'status' => $request->status,
                ]);
            } elseif ($request->status === 'rejected') {
                $notifications->push((object)[
                    'title' => 'Package Request Rejected ✗',
                    'message' => "Your request for {$request->package->name} package has been rejected.",
                    'type' => 'danger',
                    'created_at' => $request->updated_at ?? $request->created_at,
                    'package_name' => $request->package->name,
                    'admin_remarks' => $request->admin_remarks,
                    'status' => $request->status,
                ]);
            }
        }

        // ===== OTHER NOTIFICATIONS =====
        
        // Check for due bills
        if ($detail && $detail->due > 0) {
            $notifications->push((object)[
                'title' => 'Payment Due',
                'message' => 'You have an outstanding balance of ৳' . number_format($detail->due, 2),
                'type' => 'warning',
                'created_at' => Carbon::now()->subHours(2),
            ]);
        }

        // Check for package expiry
        if ($detail && $detail->package_start) {
            $expireDate = Carbon::parse($detail->package_start)->addDays(30);
            $daysLeft = Carbon::now()->diffInDays($expireDate, false);
            
            if ($daysLeft >= 0 && $daysLeft <= 7) {
                $notifications->push((object)[
                    'title' => 'Package Expiring Soon',
                    'message' => "Your package will expire in {$daysLeft} days. Please renew to avoid service interruption.",
                    'type' => 'warning',
                    'created_at' => Carbon::now()->subHours(5),
                ]);
            } elseif ($daysLeft < 0) {
                $notifications->push((object)[
                    'title' => 'Package Expired',
                    'message' => 'Your package has expired. Please renew immediately to restore service.',
                    'type' => 'danger',
                    'created_at' => Carbon::now()->subHours(1),
                ]);
            }
        }

        // Check package status
        if ($detail && $detail->status === 'inactive') {
            $notifications->push((object)[
                'title' => 'Service Inactive',
                'message' => 'Your internet service is currently inactive. Please contact support or make a payment.',
                'type' => 'danger',
                'created_at' => Carbon::now()->subHours(3),
            ]);
        }

        // Welcome notification for new users (within last 7 days)
        if ($detail && Carbon::parse($detail->created_at)->diffInDays(Carbon::now()) < 7) {
            $notifications->push((object)[
                'title' => 'Welcome to BetterNet!',
                'message' => 'Thank you for choosing us. Enjoy your high-speed internet service!',
                'type' => 'success',
                'created_at' => Carbon::parse($detail->created_at),
            ]);
        }

        // Check for low balance (advance amount running low)
        $totalPaid = Payment::where('user_id', $userId)
            ->where('status', 'completed')
            ->sum('package_price');
        $totalBilled = Billing::where('user_id', $userId)->sum('package_price');
        $advanceAmount = max(0, $totalPaid - $totalBilled);
        
        if ($detail && $advanceAmount > 0 && $advanceAmount < $detail->package_price) {
            $notifications->push((object)[
                'title' => 'Low Advance Balance',
                'message' => "Your advance balance is ৳{$advanceAmount}. Consider adding more to avoid service interruption.",
                'type' => 'info',
                'created_at' => Carbon::now()->subHours(12),
            ]);
        }

        return $notifications->sortByDesc('created_at')->take(10);
    }
}