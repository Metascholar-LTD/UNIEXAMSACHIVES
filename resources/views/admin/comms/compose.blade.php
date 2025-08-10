@extends('layout.app')

@section('content')
<section class="dashboard__area pt-120 pb-120">
  <div class="container">
    <div class="row">
      @include('components.sidebar')
      <div class="col-xl-9 col-lg-9 col-md-12">
        <div class="dashboard__content__wraper">
          <div class="dashboard__section__title">
            <h4>Advanced Communication - Compose</h4>
          </div>
          <form action="{{ route('comms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="dashboard__form__wraper">
              <div class="dashboard__form__input">
                <label>Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required />
              </div>

              <div class="dashboard__form__input">
                <label>Selection</label>
                <select name="selection_mode" id="selection_mode" class="form-select">
                  <option value="custom">Select users</option>
                  <option value="all">All registered users</option>
                </select>
              </div>

              <div id="recipient_picker" class="dashboard__form__input">
                <label>Recipients</label>
                <input type="text" id="user_search" placeholder="Search by name or email" />
                <div id="search_results" class="mt-2"></div>
                <div id="selected_recipients" class="mt-2"></div>
              </div>

              <div class="dashboard__form__input">
                <label>Body</label>
                <textarea name="body_html" class="tiny" rows="10">{!! old('body_html') !!}</textarea>
              </div>

              <div class="dashboard__form__input">
                <label>Attachments</label>
                <input type="file" name="attachments[]" multiple />
                <p class="mt-1" style="font-size: 12px; color: #666">Max 20MB per file. Use links for very large assets.</p>
              </div>

              <button class="default__button" type="submit">Send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function() {
    const searchInput = document.getElementById('user_search');
    const results = document.getElementById('search_results');
    const selected = document.getElementById('selected_recipients');
    const selectionMode = document.getElementById('selection_mode');

    const selectedMap = new Map();

    function renderSelected() {
      selected.innerHTML = '';
      selectedMap.forEach((user, id) => {
        const pill = document.createElement('span');
        pill.className = 'badge bg-primary me-2 mb-2';
        pill.textContent = user.first_name + ' ' + user.last_name + ' (' + user.email + ')';
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'btn btn-sm btn-light ms-2';
        remove.textContent = 'x';
        remove.onclick = () => { selectedMap.delete(id); renderSelected(); };
        pill.appendChild(remove);
        selected.appendChild(pill);
      });

      document.querySelectorAll('input[name="recipients[]"]').forEach(e => e.remove());
      selectedMap.forEach((_, id) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'recipients[]';
        input.value = id;
        selected.appendChild(input);
      });
    }

    function searchUsers(q) {
      if (!q || q.length < 2) { results.innerHTML = ''; return; }
      fetch(`{{ route('comms.users.search') }}?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(data => {
          results.innerHTML = '';
          if (!Array.isArray(data) || data.length === 0) { results.textContent = 'No users found'; return; }
          data.forEach(u => {
            const item = document.createElement('div');
            item.className = 'p-2 border rounded mb-1';
            item.style.cursor = 'pointer';
            item.textContent = `${u.first_name} ${u.last_name} (${u.email})`;
            item.onclick = () => { selectedMap.set(u.id, u); renderSelected(); };
            results.appendChild(item);
          });
        });
    }

    searchInput && searchInput.addEventListener('input', (e) => {
      searchUsers(e.target.value);
    });

    selectionMode && selectionMode.addEventListener('change', (e) => {
      const isCustom = e.target.value === 'custom';
      document.getElementById('recipient_picker').style.display = isCustom ? 'block' : 'none';
    });

    document.getElementById('recipient_picker').style.display = 'block';
  })();
</script>
@endsection


