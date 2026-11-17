<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Portal | RentTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Top Navigation -->
    <nav class="bg-slate-900 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-emerald-500 text-slate-900 font-extrabold px-2.5 py-1 rounded text-sm">RT</div>
                <span class="font-bold text-lg tracking-wide">
                    RentTrack <span class="text-slate-400 font-normal text-sm">| Tenant Portal</span>
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-300 hidden sm:inline">{{ $user->email }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3.5 py-2 rounded-md transition">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-8 space-y-8">

        <!-- Welcome & Status Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Hello, {{ $user->name }}</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Assigned Unit: <span class="font-semibold text-slate-800">{{ $tenancy->unit_label ?? 'Unassigned' }}</span>
                    @if ($tenancy)
                        <span class="mx-2 text-slate-300">|</span>
                        Monthly Rate: <span class="font-semibold text-slate-800">KES {{ number_format($tenancy->monthly_rent, 2) }}</span>
                    @endif
                </p>
            </div>
            <div>
                @if ($paymentStatus === 'Paid')
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        ● {{ $paymentStatus }}
                    </span>
                @elseif ($paymentStatus === 'Arrears')
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                        ● {{ $paymentStatus }}
                    </span>
                @else
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                        ● {{ $paymentStatus }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Financial KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Rent Billed</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">KES {{ number_format($totalRentDue, 2) }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Confirmed Total Paid</p>
                <p class="text-2xl font-bold text-emerald-600 mt-2">KES {{ number_format($totalPaid, 2) }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Outstanding Balance</p>
                <p class="text-2xl font-bold mt-2 {{ $outstandingBalance > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                    KES {{ number_format($outstandingBalance, 2) }}
                </p>
            </div>
        </div>

        <!-- Payment History Ledger -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Payment History</h2>
                <span class="text-xs text-slate-500">{{ $payments->count() }} transaction(s)</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Month Paid For</th>
                            <th class="px-6 py-3 text-left">M-Pesa Reference</th>
                            <th class="px-6 py-3 text-left">Amount</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $payment->month_paid_for)->format('M Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-600">
                                    {{ $payment->mpesa_reference }}
                                </td>
                                <td class="px-6 py-4 font-bold {{ $payment->status === 'confirmed' ? 'text-emerald-600' : 'text-slate-500' }}">
                                    KES {{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($payment->status === 'confirmed')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Confirmed</span>
                                    @elseif ($payment->status === 'rejected')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    No payments have been recorded for your account yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>