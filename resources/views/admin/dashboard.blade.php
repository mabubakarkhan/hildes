<x-admin-layout title="Dashboard">
    <div class="grid md:grid-cols-4 gap-4 mb-6">
        <div class="bg-slate-900 p-4 panel"><p class="text-slate-400">Jobs</p><p class="text-3xl font-bold">{{ $stats['jobs'] }}</p></div>
        <div class="bg-slate-900 p-4 panel"><p class="text-slate-400">New Applications</p><p class="text-3xl font-bold">{{ $stats['newApplications'] }}</p></div>
        <div class="bg-slate-900 p-4 panel"><p class="text-slate-400">Users</p><p class="text-3xl font-bold">{{ $stats['users'] }}</p></div>
        <div class="bg-slate-900 p-4 panel"><p class="text-slate-400">Unread Notifications</p><p class="text-3xl font-bold">{{ $stats['notifications'] }}</p></div>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div class="bg-slate-900 p-6 panel">
            <h3 class="text-lg mb-4 font-semibold">Career Jobs Status</h3>
            <canvas id="jobsChart" height="120"></canvas>
        </div>
        <div class="bg-slate-900 p-6 panel">
            <h3 class="text-lg mb-4 font-semibold">Monthly Traffic (Demo)</h3>
            <canvas id="trafficChart" height="120"></canvas>
        </div>
        <div class="bg-slate-900 p-6 panel">
            <h3 class="text-lg mb-4 font-semibold">Service Share (Demo)</h3>
            <canvas id="serviceChart" height="120"></canvas>
        </div>
        <div class="bg-slate-900 p-6 panel">
            <h3 class="text-lg mb-4 font-semibold">Applications Per Week (Demo)</h3>
            <canvas id="applicationsChart" height="120"></canvas>
            <div class="mt-6">
                <h4 class="text-base mb-3 heading-text">Applications Status Mix (Demo)</h4>
                <canvas id="applicationsStatusChart" height="110"></canvas>
            </div>
        </div>
        <div class="bg-slate-900 p-6 panel md:col-span-2">
            <h3 class="text-lg mb-4 font-semibold">Hiring Funnel (Demo)</h3>
            <canvas id="conversionChart" height="90"></canvas>
        </div>
    </div>

    <div class="bg-slate-900 p-6 panel mt-5">
        <h3 class="text-lg mb-4 font-semibold">Quick Data Table (Demo)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm data-table">
                <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Metric</th>
                    <th class="p-3 text-left">Current</th>
                    <th class="p-3 text-left">Target</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr class="border-t border-slate-800"><td class="p-3">Monthly Leads</td><td class="p-3">420</td><td class="p-3">500</td><td class="p-3">In Progress</td></tr>
                <tr class="border-t border-slate-800"><td class="p-3">Job Applications</td><td class="p-3">48</td><td class="p-3">60</td><td class="p-3">On Track</td></tr>
                <tr class="border-t border-slate-800"><td class="p-3">Client Conversion</td><td class="p-3">12%</td><td class="p-3">15%</td><td class="p-3">Needs Boost</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-slate-900 p-6 panel mt-5">
        <h3 class="text-lg mb-4 font-semibold">Revenue Projection (Demo)</h3>
        <canvas id="revenueProjectionChart" height="85"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('jobsChart'), {
            type: 'line',
            data: {
                labels: @json($jobStatusLabels),
                datasets: [{
                    label: 'Jobs',
                    data: @json($jobStatusData),
                    borderColor: '#ff6600',
                    backgroundColor: 'rgba(255,102,0,.25)',
                    fill: true,
                    tension: 0.35
                }]
            },
        });

        new Chart(document.getElementById('trafficChart'), {
            type: 'bar',
            data: {
                labels: @json($demoCharts['trafficLabels']),
                datasets: [{
                    label: 'Visits',
                    data: @json($demoCharts['trafficValues']),
                    backgroundColor: 'rgba(255,102,0,.35)',
                    borderColor: '#ff6600',
                    borderWidth: 1
                }]
            }
        });

        new Chart(document.getElementById('serviceChart'), {
            type: 'doughnut',
            data: {
                labels: @json($demoCharts['serviceLabels']),
                datasets: [{
                    data: @json($demoCharts['serviceValues']),
                    backgroundColor: ['#ff6600', '#ff8a3d', '#ffc089', '#3f5f99', '#5d7cbc']
                }]
            }
        });

        new Chart(document.getElementById('applicationsChart'), {
            type: 'line',
            data: {
                labels: @json($demoCharts['applicationsLabels']),
                datasets: [{
                    label: 'Applications',
                    data: @json($demoCharts['applicationsValues']),
                    borderColor: '#ff8a3d',
                    backgroundColor: 'rgba(255,138,61,.18)',
                    fill: true,
                    tension: .35
                }]
            }
        });

        new Chart(document.getElementById('applicationsStatusChart'), {
            type: 'bar',
            data: {
                labels: ['New', 'Accepted', 'Rejected'],
                datasets: [{
                    label: 'Applications',
                    data: [17, 6, 4],
                    backgroundColor: ['#ff6600', '#ff9a56', '#3f5f99'],
                    borderColor: ['#ff6600', '#ff9a56', '#3f5f99'],
                    borderWidth: 1
                }]
            }
        });

        new Chart(document.getElementById('conversionChart'), {
            type: 'bar',
            data: {
                labels: @json($demoCharts['conversionLabels']),
                datasets: [{
                    label: 'Count',
                    data: @json($demoCharts['conversionValues']),
                    backgroundColor: ['#ff6600', '#ff8a3d', '#ffb47f', '#ffd7b8']
                }]
            }
        });

        new Chart(document.getElementById('revenueProjectionChart'), {
            type: 'line',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6'],
                datasets: [{
                    label: 'Projected Revenue (k)',
                    data: [90, 120, 140, 165, 210, 245],
                    borderColor: '#ff6600',
                    backgroundColor: 'rgba(255,102,0,.2)',
                    tension: 0.38,
                    fill: true
                }]
            }
        });
    </script>
</x-admin-layout>
