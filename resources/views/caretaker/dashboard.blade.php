<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard | RentTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Top Navigation -->
    <nav class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-500 text-white font-extrabold px-2.5 py-1 rounded text-sm">RT</div>
                <span class="font-bold text-lg tracking-wide">
                    RentTrack <span class="text-slate-400 font-normal text-sm">| {{ ucfirst(Auth::user()->role) }} Console</span>
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-300 hidden sm:inline">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3.5 py-2 rounded-md transition">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">

        <!-- Alerts -->
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r shadow-sm text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r shadow-sm text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r shadow-sm text-sm">
                <p class="font-bold mb-1">Please fix the following errors:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header & KPIs -->
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Property Financial Overview</h1>
            <p class="text-sm text-slate-500">Real-time rent collection and unit occupancy tracking</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase text-slate-400">Occupied Units</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $occupiedUnits }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase text-slate-400">Monthly Rent Roll</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">KES {{ number_format($totalExpectedRent, 2) }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase text-slate-400">Total Collected</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">KES {{ number_format($totalCollected, 2) }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase text-slate-400">Total Outstanding Arrears</p>
                <p class="text-2xl font-bold text-red-600 mt-1">KES {{ number_format($totalArrears, 2) }}</p>
            </div>
        </div>

        <!-- Caretaker-Only Action Forms Grid -->
        @if (Auth::user()->role === 'caretaker')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Register New Tenant -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Onboard New Tenant</h2>
                    <form method="POST" action="{{ route('caretaker.storeTenant') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Jane Doe" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="jane@example.com" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Unit No.</label>
                                <input type="text" name="unit_label" value="{{ old('unit_label') }}" placeholder="A102" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Monthly Rent</label>
                                <input type="number" step="0.01" name="monthly_rent" value="{{ old('monthly_rent') }}" placeholder="15000" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Temp Password</label>
                                <input type="password" name="password" placeholder="••••••" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-2.5 rounded-lg transition">
                            Create Tenant & Assign Unit
                        </button>
                    </form>
                </div>

                <!-- Record Rent Payment -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Record Rent Payment</h2>
                    <form method="POST" action="{{ route('caretaker.recordPayment') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase">Select Tenant / Unit</label>
                            <select name="tenancy_id" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-emerald-500">
                                <option value="">-- Choose Tenant --</option>
                                @foreach ($tenants as $tenant)
                                    @if ($tenant->tenancy)
                                        <option value="{{ $tenant->tenancy->id }}" @selected(old('tenancy_id') == $tenant->tenancy->id)>
                                            [{{ $tenant->tenancy->unit_label }}] {{ $tenant->name }} — Bal: KES {{ number_format($tenant->tenancy->outstanding(), 2) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Amount (KES)</label>
                                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" placeholder="15000" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">Month Paid For</label>
                                <input type="month" name="month_paid_for" value="{{ old('month_paid_for', date('Y-m')) }}" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase">M-Pesa / Ref Code</label>
                                <input type="text" name="mpesa_reference" value="{{ old('mpesa_reference') }}" placeholder="SGH89KLP12" required class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm uppercase focus:outline-none focus:border-emerald-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition">
                            Record Payment
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Tenant Balances Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-slate-800">Tenant Directory & Balance Ledger</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Unit</th>
                            <th class="px-6 py-3 text-left">Tenant Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Monthly Rent</th>
                            <th class="px-6 py-3 text-left">Current Balance</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($tenants as $tenant)
                            @php
                                $tenancy = $tenant->tenancy;
                                $bal = $tenancy ? $tenancy->outstanding() : 0;
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $tenancy->unit_label ?? '—' }}</td>
                                <td class="px-6 py-4 font-medium">{{ $tenant->name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $tenant->email }}</td>
                                <td class="px-6 py-4">KES {{ number_format($tenancy->monthly_rent ?? 0, 2) }}</td>
                                <td class="px-6 py-4 font-bold {{ $bal > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    KES {{ number_format($bal, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($bal <= 0)
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Paid</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Arrears</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">No tenants registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Transactions Feed -->
               <!-- Recent Transactions Feed -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-slate-800">Recent Rent Payments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Month</th>
                            <th class="px-6 py-3 text-left">Unit</th>
                            <th class="px-6 py-3 text-left">Tenant</th>
                            <th class="px-6 py-3 text-left">Reference</th>
                            <th class="px-6 py-3 text-left">Amount</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            @if (Auth::user()->role === 'caretaker')
                                <th class="px-6 py-3 text-left">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($recentPayments as $payment)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::createFromFormat('Y-m', $payment->month_paid_for)->format('M Y') }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $payment->tenancy->unit_label ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $payment->tenancy->tenant->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-600">{{ $payment->mpesa_reference }}</td>
                                <td class="px-6 py-4 font-bold {{ $payment->status === 'confirmed' ? 'text-emerald-600' : 'text-slate-500' }}">KES {{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if ($payment->status === 'confirmed')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Confirmed</span>
                                    @elseif ($payment->status === 'rejected')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                                    @endif
                                </td>
                                @if (Auth::user()->role === 'caretaker')
                                    <td class="px-6 py-4">
                                        @if ($payment->status === 'pending')
                                            <div class="flex space-x-2">
                                                <form method="POST" action="{{ route('caretaker.confirmPayment', $payment) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">Confirm</button>
                                                </form>
                                                <form method="POST" action="{{ route('caretaker.rejectPayment', $payment) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">Reject</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-400">No payments logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>