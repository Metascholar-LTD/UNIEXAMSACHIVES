<div class="col-xl-12">
    <div class="uda-hero">
        <div class="uda-hero-grid">
            <!-- Greeting -->
            <div class="uda-greeting">
                <div class="uda-avatar-wrap">
                    <span class="uda-avatar-inner">
                        @if (auth()->user()->profile_picture)
                            <img class="uda-avatar" loading="lazy" src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile Picture" onerror="this.src='/img/dashbord/profile.png'">
                        @else
                            <img class="uda-avatar" loading="lazy" src="/img/dashbord/profile.png" alt="Profile Picture">
                        @endif
                    </span>
                    <a href="{{ route('dashboard.settings') }}" class="uda-avatar-edit" title="Update profile picture" aria-label="Update profile picture">
                        <i class="icofont-plus"></i>
                    </a>
                </div>
                <div class="uda-greeting-text">
                    <div class="uda-hello">Hello</div>
                    <div class="uda-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                </div>
            </div>

            <!-- Search -->
            <div class="uda-search">
                <form action="{{ route('exam.search') }}" method="GET">
                    <div class="uda-search-box">
                        <i class="icofont-search-1 uda-search-icon" aria-hidden="true"></i>
                        <input class="uda-search-input" type="search" name="query" placeholder="Search for documents..." aria-label="Search for documents">
                        <button type="submit" class="uda-btn uda-btn-primary uda-search-btn">Search</button>
                    </div>
                </form>
            </div>

            <!-- Actions -->
            <div class="uda-actions">
                <a href="{{ route('dashboard.create') }}" class="uda-btn uda-btn-primary">
                    <i class="icofont-plus-circle"></i>
                    <span>Add Exam</span>
                </a>
                <a href="{{ route('dashboard.file.create') }}" class="uda-btn uda-btn-secondary">
                    <i class="icofont-file-alt"></i>
                    <span>Add File</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- <style>
.form-control:focus {
  box-shadow: none;
} 

.form-control-underlined {
  border-width: 0;
  border-bottom-width: 1px;
  border-radius: 0;
  padding-left: 0;
}
</style> -->
