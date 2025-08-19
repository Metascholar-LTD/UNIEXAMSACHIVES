@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<div class="dashboardarea sp_bottom_100">
    <div class="container-fluid full__width__padding">
        <div class="row">
            @include('components.create_section')
        </div>
    </div>
    <div class="dashboard">
        <div class="container-fluid full__width__padding">
            <div class="row">
                @include('components.sidebar')

                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>Communication Statistics</h4>
                            <div class="dashboard__section__actions">
                                <a href="{{route('admin.communication.index')}}" class="default__button">
                                    <i class="icofont-arrow-left"></i> Back to Emails
                                </a>
                                <a href="{{route('admin.communication.create')}}" class="default__button">
                                    <i class="icofont-plus"></i> Compose Email
                                </a>
                            </div>
                        </div>

                        <!-- Overview Statistics -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter stats-card total">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-email"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['total_campaigns'] }}</span>
                                            </div>
                                             <p>Total Emails</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter stats-card sent">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-check-circled"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['sent_campaigns'] }}</span>
                                            </div>
                                             <p>Sent Emails</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter stats-card emails">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-send-mail"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['total_emails_sent'] }}</span>
                                            </div>
                                            <p>Emails Delivered</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter stats-card users">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-users-alt-3"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['total_users'] }}</span>
                                            </div>
                                            <p>Active Users</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email Status Breakdown -->
                            <div class="col-xl-6 col-lg-12">
                                <div class="dashboard__form__wraper">
                                    <div class="chart-header">
                                        <h5><i class="icofont-pie-chart"></i> Email Status Breakdown</h5>
                                    </div>
                                    
                                    <div class="status-breakdown">
                                        <div class="status-item">
                                            <div class="status-info">
                                                <div class="status-icon draft">
                                                    <i class="icofont-edit"></i>
                                                </div>
                                                <div class="status-details">
                                                     <span class="status-name">Draft Emails</span>
                                                    <span class="status-count">{{ $stats['draft_campaigns'] }}</span>
                                                </div>
                                            </div>
                                            <div class="status-bar">
                                                <div class="status-progress" 
                                                     style="width: {{ $stats['total_campaigns'] ? ($stats['draft_campaigns'] / $stats['total_campaigns']) * 100 : 0 }}%; background-color: #6c757d;"></div>
                                            </div>
                                        </div>

                                        <div class="status-item">
                                            <div class="status-info">
                                                <div class="status-icon scheduled">
                                                    <i class="icofont-clock-time"></i>
                                                </div>
                                                <div class="status-details">
                                                     <span class="status-name">Scheduled Emails</span>
                                                    <span class="status-count">{{ $stats['scheduled_campaigns'] }}</span>
                                                </div>
                                            </div>
                                            <div class="status-bar">
                                                <div class="status-progress" 
                                                     style="width: {{ $stats['total_campaigns'] ? ($stats['scheduled_campaigns'] / $stats['total_campaigns']) * 100 : 0 }}%; background-color: #ffc107;"></div>
                                            </div>
                                        </div>

                                        <div class="status-item">
                                            <div class="status-info">
                                                <div class="status-icon sent">
                                                    <i class="icofont-check-circled"></i>
                                                </div>
                                                <div class="status-details">
                                                     <span class="status-name">Sent Emails</span>
                                                    <span class="status-count">{{ $stats['sent_campaigns'] }}</span>
                                                </div>
                                            </div>
                                            <div class="status-bar">
                                                <div class="status-progress" 
                                                     style="width: {{ $stats['total_campaigns'] ? ($stats['sent_campaigns'] / $stats['total_campaigns']) * 100 : 0 }}%; background-color: #28a745;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($stats['total_campaigns'] > 0)
                                        <div class="summary-stats">
                                            <div class="summary-item">
                                                <span class="summary-label">Success Rate:</span>
                                                <span class="summary-value">{{ round(($stats['sent_campaigns'] / $stats['total_campaigns']) * 100, 1) }}%</span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Average Recipients:</span>
                                                <span class="summary-value">{{ $stats['total_campaigns'] ? round($stats['total_emails_sent'] / $stats['total_campaigns']) : 0 }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Monthly Activity Chart -->
                            <div class="col-xl-6 col-lg-12">
                                <div class="dashboard__form__wraper">
                                    <div class="chart-header">
                                        <h5><i class="icofont-chart-line"></i> Monthly Email Activity</h5>
                                    </div>
                                    
                                    <div class="monthly-chart">
                                        @if($monthlyStats->isEmpty())
                                            <div class="no-data">
                                                <i class="icofont-chart-line" style="font-size: 48px; color: #ccc;"></i>
                                                <p>No email data available yet</p>
                                            </div>
                                        @else
                                            <div class="chart-bars">
                                                @foreach($monthlyStats as $month)
                                                    @php
                                                        $maxCount = $monthlyStats->max('count');
                                                        $height = $maxCount > 0 ? ($month->count / $maxCount) * 100 : 0;
                                                    @endphp
                                                    <div class="chart-bar">
                                                         <div class="bar" style="height: {{ $height }}%" title="{{ $month->count }} emails"></div>
                                                        <div class="bar-label">{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</div>
                                                        <div class="bar-value">{{ $month->count }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="dashboard__form__wraper">
                                    <div class="chart-header">
                                        <h5><i class="icofont-history"></i> Recent Email Activity</h5>
                                    </div>
                                    
                                    @if($recentActivity->isEmpty())
                                        <div class="no-activity">
                                            <i class="icofont-history" style="font-size: 48px; color: #ccc;"></i>
                                            <p>No recent email activity</p>
                                            <a href="{{ route('admin.communication.create') }}" class="btn btn-primary">
                                                Create Your First Email
                                            </a>
                                        </div>
                                    @else
                                        <div class="activity-timeline">
                                            @foreach($recentActivity as $campaign)
                                                <div class="timeline-item">
                                                    <div class="timeline-marker status-{{ $campaign->status }}">
                                                        @switch($campaign->status)
                                                            @case('draft')
                                                                <i class="icofont-edit"></i>
                                                                @break
                                                            @case('scheduled')
                                                                <i class="icofont-clock-time"></i>
                                                                @break
                                                            @case('sending')
                                                                <i class="icofont-spinner"></i>
                                                                @break
                                                            @case('sent')
                                                                <i class="icofont-check-circled"></i>
                                                                @break
                                                            @case('failed')
                                                                <i class="icofont-close-circled"></i>
                                                                @break
                                                        @endswitch
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="timeline-header">
                                                             <h6><a href="{{ route('admin.communication.show', $campaign) }}">{{ Str::limit($campaign->subject, 40) }}</a></h6>
                                                            <span class="timeline-date">{{ $campaign->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="timeline-description">
                                                            {{ Str::limit($campaign->subject, 80) }}
                                                        </p>
                                                        <div class="timeline-meta">
                                                            <span class="meta-item">
                                                                <i class="icofont-users"></i> {{ $campaign->total_recipients }} recipients
                                                            </span>
                                                            <span class="meta-item">
                                                                <i class="icofont-user"></i> by {{ $campaign->creator->first_name }} {{ $campaign->creator->last_name }}
                                                            </span>
                                                            @if($campaign->attachments && count($campaign->attachments) > 0)
                                                                <span class="meta-item">
                                                                    <i class="icofont-attachment"></i> {{ count($campaign->attachments) }} attachment{{ count($campaign->attachments) > 1 ? 's' : '' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-card.total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stats-card.sent {
    background: linear-gradient(135deg, #57F287 0%, #00D04F 100%);
    color: white;
}

.stats-card.emails {
    background: linear-gradient(135deg, #5865F2 0%, #3B82F6 100%);
    color: white;
}

.stats-card.users {
    background: linear-gradient(135deg, #EB459E 0%, #D946EF 100%);
    color: white;
}

.chart-header {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.chart-header h5 {
    color: #495057;
    margin: 0;
}

.status-breakdown {
    margin-bottom: 30px;
}

.status-item {
    margin-bottom: 25px;
}

.status-info {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.status-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 18px;
}

.status-icon.draft { background-color: #6c757d; }
.status-icon.scheduled { background-color: #ffc107; }
.status-icon.sent { background-color: #28a745; }

.status-details {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.status-name {
    font-weight: 600;
    color: #495057;
}

.status-count {
    font-weight: bold;
    font-size: 18px;
    color: #495057;
}

.status-bar {
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.status-progress {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.summary-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.summary-label {
    font-weight: 600;
    color: #6c757d;
}

.summary-value {
    font-weight: bold;
    font-size: 18px;
    color: #495057;
}

.monthly-chart {
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-bars {
    display: flex;
    align-items: end;
    justify-content: center;
    gap: 15px;
    height: 200px;
    width: 100%;
}

.chart-bar {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    max-width: 60px;
}

.bar {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px 4px 0 0;
    transition: all 0.3s ease;
    cursor: pointer;
    min-height: 5px;
}

.bar:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

.bar-label {
    font-size: 11px;
    color: #6c757d;
    margin-top: 8px;
    transform: rotate(-45deg);
    white-space: nowrap;
}

.bar-value {
    font-weight: bold;
    font-size: 12px;
    color: #495057;
    margin-bottom: 5px;
}

.no-data, .no-activity {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.activity-timeline {
    position: relative;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 25px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    display: flex;
    align-items: flex-start;
}

.timeline-marker {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    color: white;
    font-size: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    z-index: 1;
}

.timeline-marker.status-draft { background-color: #6c757d; }
.timeline-marker.status-scheduled { background-color: #ffc107; }
.timeline-marker.status-sending { background-color: #17a2b8; }
.timeline-marker.status-sent { background-color: #28a745; }
.timeline-marker.status-failed { background-color: #dc3545; }

.timeline-content {
    flex: 1;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #e9ecef;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.timeline-header h6 {
    margin: 0;
}

.timeline-header h6 a {
    color: #495057;
    text-decoration: none;
}

.timeline-header h6 a:hover {
    color: #007bff;
}

.timeline-date {
    font-size: 12px;
    color: #6c757d;
}

.timeline-description {
    margin-bottom: 15px;
    color: #6c757d;
    line-height: 1.5;
}

.timeline-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.meta-item {
    font-size: 12px;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 5px;
}

@media (max-width: 768px) {
    .chart-bars {
        gap: 8px;
    }
    
    .bar-label {
        font-size: 10px;
    }
    
    .timeline-item {
        flex-direction: column;
        text-align: center;
    }
    
    .timeline-marker {
        margin: 0 auto 15px;
    }
    
    .timeline-content {
        border-left: none;
        border-top: 4px solid #e9ecef;
    }
    
    .activity-timeline::before {
        display: none;
    }
    
    .timeline-meta {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.innerText;
            const count = +counter.dataset.count || 0;
            const increment = target / speed;

            if (count < target) {
                counter.dataset.count = Math.ceil(count + increment);
                counter.innerText = counter.dataset.count;
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    // Animate progress bars
    const progressBars = document.querySelectorAll('.status-progress');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });

    // Animate chart bars
    const chartBars = document.querySelectorAll('.bar');
    chartBars.forEach((bar, index) => {
        const height = bar.style.height;
        bar.style.height = '0%';
        setTimeout(() => {
            bar.style.height = height;
        }, 100 * (index + 1));
    });
});
</script>
@endsection