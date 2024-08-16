<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />
        
        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            <!-- Doughnut chart (Top Countries) -->
            <x-dashboard.dashboard-card-06 />

            <!-- Card (Customers)  -->
            <x-dashboard.dashboard-card-10 :clientesTop="$clientesTop" />

            {{-- <!-- Table (Top Channels) -->
            <x-dashboard.dashboard-card-07 />

            <!-- Line chart (Sales Over Time)  -->
            <x-dashboard.dashboard-card-08 />

            <!-- Stacked bar chart (Sales VS Refunds) -->
            <x-dashboard.dashboard-card-09 />

            <!-- Card (Income/Expenses) -->
            <x-dashboard.dashboard-card-13 /> --}}

        </div>

    </div>
</x-app-layout>