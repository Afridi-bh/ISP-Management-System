<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // If regular user, show user dashboard
        if (auth()->user()->isUser()) {
            return $this->userDashboard();
        }

        // Otherwise, show admin dashboard
        return $this->adminDashboard();
    }

    /**
     * User Dashboard - Shows user-specific statistics
     */
    private function userDashboard()
    {
        $userId = auth()->id();
        $user = User::with('detail')->where('id', $userId)->firstOrFail();
        
        // User-specific totals
        $totalBills = Billing::where('user_id', $userId)->sum('package_price') ?? 0;
        $totalPayments = Payment::where('user_id', $userId)->sum('package_price') ?? 0;
        
        // This month stats
        $billsThisMonth = Billing::where('user_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('package_price') ?? 0;
            
        $paymentsThisMonth = Payment::where('user_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('package_price') ?? 0;
        
        // This year stats
        $billsThisYear = Billing::where('user_id', $userId)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('package_price') ?? 0;
            
        $paymentsThisYear = Payment::where('user_id', $userId)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('package_price') ?? 0;
        
        // Monthly data for charts (last 12 months)
        $billingData = [];
        $paymentData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            
            $billingData[] = Billing::where('user_id', $userId)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('package_price') ?? 0;
                
            $paymentData[] = Payment::where('user_id', $userId)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('package_price') ?? 0;
        }
        
        // Daily data for charts (last 30 days)
        $dailyBillingData = [];
        $dailyPaymentData = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            
            $dailyBillingData[] = Billing::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->sum('package_price') ?? 0;
                
            $dailyPaymentData[] = Payment::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->sum('package_price') ?? 0;
        }
        
        // Recent data for user
        $recentPayments = Payment::where('user_id', $userId)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $recentTickets = Ticket::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
        
        // Calculate due amount safely
        $dueAmount = $this->calculateUserDue($user, $userId, $totalBills, $totalPayments);
        
        // Dummy values for user dashboard compatibility
        $totalUsers = 1;
        $usersWithDueCount = ($dueAmount > 0) ? 1 : 0;
        $usersWithDueList = collect();
        $recentUsers = collect();
        
        return view('dashboard', compact(
            'user',
            'totalBills',
            'totalPayments',
            'billsThisMonth',
            'paymentsThisMonth',
            'billsThisYear',
            'paymentsThisYear',
            'billingData',
            'paymentData',
            'dailyBillingData',
            'dailyPaymentData',
            'recentPayments',
            'recentTickets',
            'dueAmount',
            'totalUsers',
            'usersWithDueCount',
            'usersWithDueList',
            'recentUsers'
        ));
    }

    /**
     * Admin Dashboard - Shows all system statistics
     */
    private function adminDashboard()
    {
        // Basic counts
        $totalPackages = Package::count();
        $totalBills = Billing::sum('package_price') ?? 0;
        $totalPayments = Payment::sum('package_price') ?? 0;
        $totalUsers = User::where('role', 'user')->count();
        $openTickets = Ticket::where('status', 'Open')->count();

        // This month stats
        $paymentsThisMonth = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('package_price') ?? 0;
            
        $billsThisMonth = Billing::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('package_price') ?? 0;

        // This year stats
        $paymentsThisYear = Payment::whereYear('created_at', now()->year)
            ->sum('package_price') ?? 0;
            
        $billsThisYear = Billing::whereYear('created_at', now()->year)
            ->sum('package_price') ?? 0;

        // Recent records - WITH NULL SAFETY
        $recentUsers = User::with('detail')
            ->where('role', 'user')
            ->latest()
            ->take(5)
            ->get()
            ->filter(function($user) {
                return $user->detail !== null; // Filter out users without details
            });

        $recentPayments = Payment::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->filter(function($payment) {
                return $payment->user !== null; // Filter out payments without users
            });

        $recentTickets = Ticket::latest()->take(5)->get();

        // Users with due - WITH SAFE CALCULATION
        $usersWithDue = User::with('detail')
            ->where('role', 'user')
            ->get()
            ->filter(function($user) {
                // Filter users who have detail and positive due amount
                if ($user->detail === null) {
                    return false;
                }
                
                try {
                    if (method_exists($user, 'due_amount')) {
                        $dueAmount = $user->due_amount($user->id);
                        return $dueAmount > 0;
                    }
                } catch (\Exception $e) {
                    \Log::error('Error calculating due amount for user ' . $user->id . ': ' . $e->getMessage());
                }
                
                return false;
            });

        $usersWithDueCount = $usersWithDue->count();
        $usersWithDueList = $usersWithDue->take(10);

        // Sales statistics
        $todaysSales = Payment::whereDate('created_at', today())
            ->sum('package_price') ?? 0;

        $thisMonthSales = $paymentsThisMonth;
        $thisYearSales = $paymentsThisYear;
        $totalProducts = $totalPackages;

        // Monthly data for charts (last 12 months)
        $monthlySales = [];
        $billingData = [];
        $paymentData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            
            $monthlyPayment = Payment::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('package_price') ?? 0;
                
            $monthlyBilling = Billing::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('package_price') ?? 0;
            
            $monthlySales[] = $monthlyPayment;
            $billingData[] = $monthlyBilling;
            $paymentData[] = $monthlyPayment;
        }

        // Daily data for charts (current month)
        $daysInMonth = Carbon::now()->daysInMonth;
        $daysOfMonth = range(1, $daysInMonth);
        $dailySales = [];
        $dailyBillingData = [];
        $dailyPaymentData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateStr = now()->format("Y-m") . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
            
            $dailyPayment = Payment::whereDate('created_at', $dateStr)
                ->sum('package_price') ?? 0;
                
            $dailyBilling = Billing::whereDate('created_at', $dateStr)
                ->sum('package_price') ?? 0;

            $dailySales[] = $dailyPayment;
            $dailyBillingData[] = $dailyBilling;
            $dailyPaymentData[] = $dailyPayment;
        }

        // Calculate total due amount for admin dashboard
        $dueAmount = max(0, $totalBills - $totalPayments);

        return view('dashboard', compact(
            'totalUsers',
            'totalBills',
            'totalPayments',
            'paymentsThisMonth',
            'billsThisMonth',
            'recentPayments',
            'recentUsers',
            'totalPackages',
            'paymentsThisYear',
            'billsThisYear',
            'usersWithDueCount',
            'usersWithDueList',
            'openTickets',
            'billingData',
            'paymentData',
            'dailyBillingData',
            'dailyPaymentData',
            'recentTickets',
            'todaysSales',
            'thisMonthSales',
            'thisYearSales',
            'totalProducts',
            'monthlySales',
            'daysOfMonth',
            'dailySales',
            'dueAmount'
        ));
    }

    /**
     * Calculate user due amount safely
     */
    private function calculateUserDue($user, $userId, $totalBills, $totalPayments)
    {
        $dueAmount = 0;
        
        if ($user && method_exists($user, 'due_amount')) {
            try {
                $dueAmount = $user->due_amount($userId) ?? 0;
            } catch (\Exception $e) {
                \Log::error('Error calculating due amount for user ' . $userId . ': ' . $e->getMessage());
                $dueAmount = $totalBills - $totalPayments;
            }
        } else {
            $dueAmount = $totalBills - $totalPayments;
        }
        
        return max(0, $dueAmount);
    }
}