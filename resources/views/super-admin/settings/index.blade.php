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
                            <h4><i class="icofont-settings-alt"></i> System Settings</h4>
                            <p class="text-muted">Configure system-wide settings and preferences</p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <form method="POST" action="{{ route('super-admin.settings.test-paystack') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-block">
                                        <i class="icofont-verification-check"></i> Test Paystack
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form method="POST" action="{{ route('super-admin.settings.clear-cache') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-block">
                                        <i class="icofont-refresh"></i> Clear Cache
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form method="POST" action="{{ route('super-admin.settings.optimize') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="icofont-speed-meter"></i> Optimize
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('super-admin.settings.export') }}" class="btn btn-secondary btn-block">
                                    <i class="icofont-download"></i> Export Settings
                                </a>
                            </div>
                        </div>

                        {{-- Settings Form --}}
                        <form method="POST" action="{{ route('super-admin.settings.update') }}">
                            @csrf

                            @foreach($settings as $category => $categorySettings)
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="icofont-ui-settings"></i> 
                                        {{ ucwords(str_replace('_', ' ', $category)) }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @foreach($categorySettings as $setting)
                                    <div class="form-group row mb-3">
                                        <label class="col-md-4 col-form-label">
                                            <strong>{{ $setting->label }}</strong>
                                            @if($setting->description)
                                            <br><small class="text-muted">{{ $setting->description }}</small>
                                            @endif
                                        </label>
                                        <div class="col-md-8">
                                            @if($setting->data_type === 'boolean')
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" 
                                                           class="custom-control-input" 
                                                           id="{{ $setting->key }}" 
                                                           name="{{ $setting->key }}"
                                                           {{ $setting->typed_value ? 'checked' : '' }}
                                                           {{ !$setting->is_editable ? 'disabled' : '' }}>
                                                    <label class="custom-control-label" for="{{ $setting->key }}">
                                                        {{ $setting->typed_value ? 'Enabled' : 'Disabled' }}
                                                    </label>
                                                </div>
                                            @elseif($setting->data_type === 'json')
                                                <textarea class="form-control" 
                                                          name="{{ $setting->key }}" 
                                                          rows="3"
                                                          {{ !$setting->is_editable ? 'readonly' : '' }}>{{ $setting->value }}</textarea>
                                            @else
                                                <input type="{{ $setting->data_type === 'integer' ? 'number' : 'text' }}" 
                                                       class="form-control" 
                                                       name="{{ $setting->key }}" 
                                                       value="{{ $setting->value }}"
                                                       {{ !$setting->is_editable ? 'readonly' : '' }}
                                                       @if($setting->key === 'paystack_secret_key' || $setting->key === 'paystack_webhook_secret') type="password" @endif>
                                            @endif
                                            
                                            @if($setting->requires_restart)
                                            <small class="text-warning">
                                                <i class="icofont-warning"></i> Requires application restart
                                            </small>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="icofont-save"></i> Save All Settings
                                </button>
                            </div>
                        </form>

                        {{-- Maintenance Mode Toggle --}}
                        <div class="card shadow-sm mt-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0"><i class="icofont-warning"></i> Danger Zone</h5>
                            </div>
                            <div class="card-body">
                                <h6>Maintenance Mode</h6>
                                <p class="text-muted">When enabled, only super admins can access the system.</p>
                                <form method="POST" action="{{ route('super-admin.settings.toggle-maintenance') }}" class="d-inline">
                                    @csrf
                                    @if(App\Models\SystemSetting::getMaintenanceMode())
                                    <button type="submit" class="btn btn-success">
                                        <i class="icofont-check-circled"></i> Disable Maintenance Mode
                                    </button>
                                    @else
                                    <input type="hidden" name="enable" value="1">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure? This will block all users except super admins.')">
                                        <i class="icofont-ban"></i> Enable Maintenance Mode
                                    </button>
                                    @endif
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}
.btn-block {
    width: 100%;
}
</style>

@endsection

