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
                            <h4>Advanced Communication System</h4>
                            <div class="dashboard__section__actions">
                                <a href="{{route('admin.communication.create')}}" class="default__button">
                                    <i class="icofont-plus"></i> Compose Email
                                </a>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter communication-stats">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-email" style="font-size: 40px; color: #5865F2;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $totalCampaigns }}</span>
                                            </div>
                                            <p>Total Emails</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter communication-stats">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-check-circled" style="font-size: 40px; color: #57F287;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $sentCampaigns }}</span>
                                            </div>
                                            <p>Sent Emails</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter communication-stats">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-clock-time" style="font-size: 40px; color: #FEE75C;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $pendingCampaigns }}</span>
                                            </div>
                                            <p>Pending Emails</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__single__counter communication-stats">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <i class="icofont-users-alt-3" style="font-size: 40px; color: #EB459E;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $totalUsers }}</span>
                                            </div>
                                            <p>Active Users</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emails Table -->
                        <div class="dashboard__table__wrapper">
                            <div class="dashboard__table__top">
                                <h4>Emails</h4>
                                <div class="dashboard__table__actions">
                                    <form method="GET" class="dashboard__search__form">
                                        <input type="text" name="search" placeholder="Search campaigns..." 
                                               value="{{ request('search') }}" class="form-control">
                                        <button type="submit"><i class="icofont-search-1"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped campaign-table">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Recipients</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($campaigns as $campaign)
                                        <tr>
                                            <td>
                                                <div class="campaign-title">
                                                    <strong>{{ Str::limit($campaign->subject, 40) }}</strong>
                                                    @if($campaign->attachments && count($campaign->attachments) > 0)
                                                        <i class="icofont-attachment" title="Has attachments"></i>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $campaign->total_recipients }} users</span>
                                            </td>
                                            <td>
                                                <span class="campaign-status status-{{ $campaign->status }}">
                                                    @switch($campaign->status)
                                                        @case('draft')
                                                            <i class="icofont-edit"></i> Draft
                                                            @break
                                                        @case('scheduled')
                                                            <i class="icofont-clock-time"></i> Scheduled
                                                            @break
                                                        @case('sending')
                                                            <i class="icofont-spinner"></i> Sending
                                                            @break
                                                        @case('sent')
                                                            <i class="icofont-check-circled"></i> Sent
                                                            @break
                                                        @case('failed')
                                                            <i class="icofont-close-circled"></i> Failed
                                                            @break
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>
                                                @if($campaign->status === 'sent')
                                                    <div class="progress-bar-wrapper">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                                        </div>
                                                        <small>{{ $campaign->sent_count }}/{{ $campaign->total_recipients }}</small>
                                                    </div>
                                                @elseif($campaign->status === 'sending')
                                                    <div class="progress-bar-wrapper">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width: {{ $campaign->progress_percentage }}%"></div>
                                                        </div>
                                                        <small>{{ $campaign->sent_count }}/{{ $campaign->total_recipients }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $campaign->created_at->format('M j, Y') }}</td>
                                            <td>
                                                <div class="campaign-actions">
                                                    <a href="{{ route('admin.communication.show', $campaign) }}" 
                                                       class="btn btn-sm btn-info" title="View Details">
                                                        <i class="icofont-eye"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.communication.destroy', $campaign) }}" 
                                                          style="display: inline-block;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this email?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="icofont-trash"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    @if($campaign->status === 'draft')
                                                        <a href="{{ route('admin.communication.edit', $campaign) }}" 
                                                           class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="icofont-edit"></i>
                                                        </a>
                                                    @endif

                                                    @if(in_array($campaign->status, ['draft', 'scheduled']))
                                                        <form method="POST" action="{{ route('admin.communication.send', $campaign) }}" 
                                                              style="display: inline-block;" 
                                                              onsubmit="return confirm('Are you sure you want to send this email?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" title="Send Now">
                                                                <i class="icofont-send-mail"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="icofont-inbox" style="font-size: 48px; color: #ccc;"></i>
                                                    <h5>No Emails Found</h5>
                                                    <p>Start by composing your first email to communicate with users.</p>
                                                    <a href="{{ route('admin.communication.create') }}" class="btn btn-primary">
                                                        <i class="icofont-plus"></i> Compose Email
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($campaigns->hasPages())
                                <div class="dashboard__pagination">
                                    {{ $campaigns->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.communication-stats .dashboard__single__counter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.campaign-table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.campaign-status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-draft { background: #e9ecef; color: #6c757d; }
.status-scheduled { background: #fff3cd; color: #856404; }
.status-sending { background: #cce5ff; color: #0066cc; }
.status-sent { background: #d4edda; color: #155724; }
.status-failed { background: #f8d7da; color: #721c24; }

.progress-bar-wrapper {
    min-width: 120px;
}

.progress {
    height: 8px;
    border-radius: 4px;
    background-color: #e9ecef;
}

.campaign-actions .btn {
    margin: 0 2px;
    padding: 5px 8px;
}

.campaign-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.empty-state {
    padding: 40px;
    text-align: center;
    color: #6c757d;
}

.dashboard__table__top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.dashboard__search__form {
    position: relative;
    display: flex;
    align-items: center;
}

.dashboard__search__form input {
    padding-right: 40px;
    border-radius: 20px;
    border: 1px solid #ddd;
}

.dashboard__search__form button {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Refresh page every 30 seconds for sending campaigns
    const hasSendingCampaigns = document.querySelector('.status-sending');
    if (hasSendingCampaigns) {
        setTimeout(function() {
            location.reload();
        }, 30000);
    }
});
</script>
@endsection