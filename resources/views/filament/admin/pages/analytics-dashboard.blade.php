<x-filament-panels::page>
<div class="space-y-6">

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['label'=>'Total Views',     'value'=>$stats['total_views'],     'icon'=>'👁'],
            ['label'=>'Today',           'value'=>$stats['today_views'],     'icon'=>'📅'],
            ['label'=>'Last 7 Days',     'value'=>$stats['week_views'],      'icon'=>'📈'],
            ['label'=>'CV Downloads',    'value'=>$stats['cv_downloads'],    'icon'=>'📄'],
            ['label'=>'GitHub Clicks',   'value'=>$stats['github_clicks'],   'icon'=>'💻'],
            ['label'=>'LinkedIn Clicks', 'value'=>$stats['linkedin_clicks'], 'icon'=>'🔗'],
            ['label'=>'Project Views',   'value'=>$stats['project_views'],   'icon'=>'🚀'],
            ['label'=>'Contacts',        'value'=>$stats['contacts'],        'icon'=>'✉️'],
        ] as $s)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="text-2xl mb-1">{{ $s['icon'] }}</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $s['value'] }}</div>
            <div class="text-xs text-gray-500">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Top pages --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Top Pages</h3>
            @forelse($topPages as $p)
            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $p['page'] ?? '/' }}</span>
                <span class="text-sm font-bold text-blue-500">{{ $p['total'] }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400">No data yet</p>
            @endforelse
        </div>

        {{-- CV downloads --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">CV Downloads by Type</h3>
            @forelse($cvStats as $cv)
            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $cv['label'] ?? 'Unknown' }}</span>
                <span class="text-sm font-bold text-emerald-500">{{ $cv['total'] }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400">No downloads yet</p>
            @endforelse
        </div>
    </div>

    {{-- 7-day chart --}}
    @if(count($daily7))
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Page Views – Last 7 Days</h3>
        <div class="flex items-end gap-2 h-24">
            @php $max = max(array_column($daily7,'total')) ?: 1; @endphp
            @foreach($daily7 as $d)
            <div class="flex flex-col items-center flex-1">
                <div class="w-full bg-blue-500 rounded-t" style="height:{{ round($d['total']/$max*80) }}px"></div>
                <span class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($d['date'])->format('M j') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
</x-filament-panels::page>
