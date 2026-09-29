<?php

namespace App\Filament\Admin\Pages;

use App\Models\AnalyticsEvent;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?string $navigationLabel = 'Analytics';
    protected static ?int    $navigationSort  = 2;
    protected static string  $view            = 'filament.admin.pages.analytics-dashboard';

    public array $stats     = [];
    public array $topPages  = [];
    public array $cvStats   = [];
    public array $daily7    = [];

    public function mount(): void
    {
        $this->stats = [
            'total_views'    => AnalyticsEvent::where('event_type', 'page_view')->count(),
            'today_views'    => AnalyticsEvent::where('event_type', 'page_view')->whereDate('created_at', today())->count(),
            'week_views'     => AnalyticsEvent::where('event_type', 'page_view')->where('created_at', '>=', now()->subDays(7))->count(),
            'cv_downloads'   => AnalyticsEvent::where('event_type', 'cv_download')->count(),
            'github_clicks'  => AnalyticsEvent::where('event_type', 'github_click')->count(),
            'linkedin_clicks' => AnalyticsEvent::where('event_type', 'linkedin_click')->count(),
            'project_views'  => AnalyticsEvent::where('event_type', 'project_view')->count(),
            'contacts'       => AnalyticsEvent::where('event_type', 'contact_submit')->count(),
        ];

        $this->topPages = AnalyticsEvent::where('event_type', 'page_view')
            ->select('page', DB::raw('count(*) as total'))
            ->groupBy('page')->orderByDesc('total')->limit(10)->get()->toArray();

        $this->cvStats = AnalyticsEvent::where('event_type', 'cv_download')
            ->select('label', DB::raw('count(*) as total'))
            ->groupBy('label')->orderByDesc('total')->get()->toArray();

        $this->daily7 = AnalyticsEvent::where('event_type', 'page_view')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')->orderBy('date')->get()->toArray();
    }
}
