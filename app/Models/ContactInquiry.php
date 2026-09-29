<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = [
        'name','email','company','phone','reason','subject',
        'message','status','ip_address','user_agent',
    ];

    const REASONS = [
        'job_opportunity'  => 'Job Opportunity',
        'freelance_project'=> 'Freelance Project',
        'contract_work'    => 'Contract Work',
        'internship'       => 'Internship',
        'collaboration'    => 'Collaboration',
        'reference_request'=> 'Reference Request',
        'other'            => 'Other',
    ];

    const REASON_ICONS = [
        'job_opportunity'   => '💼',
        'freelance_project' => '🚀',
        'contract_work'     => '📋',
        'internship'        => '🎓',
        'collaboration'     => '🤝',
        'reference_request' => '📝',
        'other'             => '💬',
    ];

    public function getReasonLabelAttribute(): string
    {
        return self::REASONS[$this->reason] ?? ucfirst($this->reason);
    }

    public function getReasonIconAttribute(): string
    {
        return self::REASON_ICONS[$this->reason] ?? '💬';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'new'      => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
            'read'     => 'bg-gray-500/15 text-gray-400 border-gray-500/30',
            'replied'  => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
            'archived' => 'bg-red-500/15 text-red-400 border-red-500/30',
            default    => 'bg-gray-500/15 text-gray-400 border-gray-500/30',
        };
    }
}
