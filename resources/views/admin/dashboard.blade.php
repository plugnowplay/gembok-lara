@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-purple-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0" 
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-black bg-opacity-20">
            <div class="flex items-center space-x-2">
                <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-network-wired text-blue-600"></i>
                </div>
                <span class="text-white font-bold text-xl">GEMBOK LARA</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-8 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-20 rounded-lg">
                <i class="fas fa-home mr-3"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-users mr-3"></i>
                <span>Customers</span>
            </a>
            
            <a href="{{ route('admin.packages.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-box mr-3"></i>
                <span>Packages</span>
            </a>
            
            <a href="{{ route('admin.invoices.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-file-invoice mr-3"></i>
                <span>Invoices</span>
            </a>
            
            <a href="{{ route('admin.technicians.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-tools mr-3"></i>
                <span>Technicians</span>
            </a>
            
            <a href="{{ route('admin.collectors.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-hand-holding-usd mr-3"></i>
                <span>Collectors</span>
            </a>
            
            <a href="{{ route('admin.agents.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-user-tie mr-3"></i>
                <span>Agents</span>
            </a>
            
            <a href="{{ route('admin.vouchers.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-ticket-alt mr-3"></i>
                <span>Vouchers</span>
            </a>
            
            <a href="{{ route('admin.network.map') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-map-marked-alt mr-3"></i>
                <span>Network Map</span>
            </a>
            
            <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition">
                <i class="fas fa-cog mr-3"></i>
                <span>Settings</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="absolute bottom-0 w-full p-4">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64">
        <!-- Top Bar -->
        <div class="sticky top-0 z-40 bg-white shadow-md">
            <div class="flex items-center justify-between h-16 px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="p-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Customers -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Customers</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_customers'] }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                <i class="fas fa-check-circle"></i> {{ $stats['active_customers'] }} active
                            </p>
                        </div>
                        <div class="h-14 w-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                            <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Paid invoices</p>
                        </div>
                        <div class="h-14 w-14 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Revenue -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Pending Revenue</p>
                            <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($stats['pending_revenue'], 0, ',', '.') }}</p>
                            <p class="text-xs text-yellow-600 mt-1">
                                <i class="fas fa-clock"></i> {{ $stats['unpaid_invoices'] }} unpaid
                            </p>
                        </div>
                        <div class="h-14 w-14 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Packages -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Packages</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_packages'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Active packages</p>
                        </div>
                        <div class="h-14 w-14 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-box text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Invoices -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                        Recent Invoices
                    </h3>
                    <div class="space-y-3">
                        @forelse($recent_invoices as $invoice)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $invoice->customer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $invoice->invoice_number }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No invoices yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Customers -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-user-plus mr-2 text-green-600"></i>
                        Recent Customers
                    </h3>
                    <div class="space-y-3">
                        @forelse($recent_customers as $customer)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $customer->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $customer->phone }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ $customer->package->name ?? 'No Package' }}</p>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No customers yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
