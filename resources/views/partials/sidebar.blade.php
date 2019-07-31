<nav id="sidebar">
    <div class="user-head">
        <a class="inbox-avatar" href="javascript:;">
            <img src="https://api.adorable.io/avatars/285/{{ md5($user->email) }}.png" height="60"  width="60">
        </a>
        <div class="user-name">
            <h5><a href="#">{{ $user->name }}</a></h5>
            @if(Auth::guard('student')->check())
                <span><a href="#">{{ $user->login }}</a></span>
            @else
                <span><a href="#">{{ $user->email }}</a></span>
            @endif
        </div>

        <div class="float-right">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        </div>

    </div>

    <div class="inbox-body">
        <a href="{{ route('messages.create') }}" title="Compose" class="btn btn-compose">
            <i class="fas fa-paper-plane"></i>
            <span>{{ trans('sidebar.new-message') }}</span>
        </a>
    </div>

    @auth("admin")

    @endauth

    <ul class="list-unstyled inbox-divider labels-info">
        <li><h4>Messages</h4></li>

        <li class="{{ setActive('messages/drafts') }}">
            <a href="{{ route('messages.drafts') }}">
                <i class="fas fa-pen"></i>
                <span>{{ trans('sidebar.drafts') }}</span>
            </a>
        </li>
        <li class="{{ setActive('messages') }}">
            <a href="{{ route('messages.index') }}">
                <i class="fas fa-envelope"></i>
                <span>{{ trans('sidebar.received-messages') }}</span>
            </a>
        </li>
        <li class="{{ setActive('messages/sent') }}">
            <a href="{{ route('messages.sent') }}">
                <i class="fas fa-paper-plane"></i>
                <span>{{ trans('sidebar.sent-messages') }}</span>
            </a>
        </li>
        @auth('teacher')
            <li class="{{ setActive('messages/moderation') }}">
                <a href="{{ route('messages.moderation') }}">
                    <i class="fas fa-clock"></i>
                    <span>{{ trans('sidebar.moderation-messages') }}</span>
                </a>
            </li>
        @endauth
    </ul>

    <ul class="list-unstyled inbox-divider labels-info">

        <li><h4>Espace personnel</h4></li>

        @auth('student')
            <li class="{{ setActive('students/' . $user->id, 'active') }}">
                <a href="{{ route('students.show', $user->id) }}">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ trans('sidebar.profile') }}</span>
                </a>
            </li>
            <li class="{{ setActive('students/' . $user->id . '/correspondents', 'active') }}">
                <a href="{{ route('students.correspondents', $user->id) }}">
                    <i class="fas fa-envelope"></i>
                    <span>{{ trans('sidebar.correspondents') }}</span>
                </a>
            </li>
        @endauth
        @auth('teacher')
            <li class="{{ setActive('teachers/' . $user->id . '/edit', 'active') }}">
                <a href="{{ route('teachers.edit', $user->id) }}">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ trans('sidebar.profile') }}</span>
                </a>
            </li>
        @endauth
        @auth('admin')
            <li class="{{ setActive('admins/' . $user->id . '/edit', 'active') }}">
                <a href="{{ route('admins.edit', $user->id) }}">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ trans('sidebar.profile') }}</span>
                </a>
            </li>
        @endauth
    </ul>

    @auth("teacher")
        <ul class="list-unstyled inbox-divider labels-info">

            <li><h4>Mes classes</h4></li>

            @foreach($user->scheduledEducationalActivities as $scheduledEducationalActivity)
                <li class="{{ setActive('classes/' . $scheduledEducationalActivity->id, 'active') }}">
                    <a href="{{ route('classes.show', $scheduledEducationalActivity->id) }}">
                        <i class="fas fa-users"></i>
                        <span>{{ $scheduledEducationalActivity->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endauth

    @auth("admin")
        <ul class="list-unstyled inbox-divider labels-info">

            <li><h4>Administration</h4></li>

            <li class="{{ setActive('teachers') }}">
                <a href="{{ route('teachers.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>{{ trans('sidebar.all-teachers') }}</span>
                </a>
            </li>
            <li class="{{ setActive('classes') }}">
                <a href="{{ route('classes.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ trans('sidebar.all-classes') }}</span>
                </a>
            </li>
            <li class="{{ setActive('students') }}">
                <a href="{{ route('students.index') }}">
                    <i class="fas fa-user"></i>
                    <span>{{ trans('sidebar.all-students') }}</span>
                </a>
            </li>
            <li class="{{ setActive('keywords') }}">
                <a href="{{ route('keywords.index') }}">
                    <i class="fas fa-tags"></i>
                    <span>{{ trans('sidebar.all-keywords') }}</span>
                </a>
            </li>
            <li class="{{ setActive('images') }}">
                <a href="{{ route('images.index') }}">
                    <i class="fas fa-images"></i>
                    <span>{{ trans('sidebar.all-images') }}</span>
                </a>
            </li>
        </ul>
    @endauth

    <ul class="list-unstyled inbox-divider labels-info">

        <li><h4>Recherche</h4></li>

        <li class="{{ setActive('search', 'active') }}">
            <a href="{{ route('search.show') }}">
                <i class="fas fa-search"></i>
                <span>{{ trans('sidebar.search-standard') }}</span>
            </a>
        </li>
        <li class="{{ setActive('search/keywords', 'active') }}">
            <a href="{{ route('search.keywords.show') }}">
                <i class="fas fa-tags"></i>
                <span>{{ trans('sidebar.search-keywords') }}</span>
            </a>
        </li>
        <li class="{{ setActive('search/classes', 'active') }}">
            <a href="{{ route('search.classes.show') }}">
                <i class="fas fa-users"></i>
                <span>{{ trans('sidebar.search-classes') }}</span>
            </a>
        </li>
    </ul>
</nav>
