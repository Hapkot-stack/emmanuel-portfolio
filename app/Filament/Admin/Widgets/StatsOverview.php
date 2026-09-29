<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AnalyticsEvent;
use App\Models\ContactInquiry;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Published Projects', Project::whereIn('status', ['published','live'])->count())
                ->description(Project::count() . ' total projects')
                ->color('success')
                ->icon('heroicon-o-code-bracket'),

            Stat::make('Skills', Skill::count())
                ->description(Skill::where('featured', true)->count() . ' featured')
                ->color('info')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('New Inquiries', ContactInquiry::where('status', 'new')->count())
                ->description(ContactInquiry::count() . ' total messages')
                ->color('warning')
                ->icon('heroicon-o-envelope'),

            Stat::make('Page Views (7d)', AnalyticsEvent::where('event_type', 'page_view')
                    ->where('created_at', '>=', now()->subDays(7))->count())
                ->description('Last 7 days')
                ->color('primary')
                ->icon('heroicon-o-eye'),

            Stat::make('CV Downloads', AnalyticsEvent::where('event_type', 'cv_download')->count())
                ->description('All time')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),

            Stat::make('GitHub Clicks', AnalyticsEvent::where('event_type', 'github_click')->count())
                ->description('All time')
                ->color('gray')
                ->icon('heroicon-o-code-bracket-square'),
        ];
    }
}
