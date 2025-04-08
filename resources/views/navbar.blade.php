<nav class="navbar">
    <ul class="navbar-list">
        @if(isset($menu) && count($menu) > 0)
            @foreach ($menu as $item)
                <li>
                    <a href="{{ $item['link'] }}">{{ $item['text'] }}</a>
                </li>
            @endforeach
        @endif
        
        <!-- User greeting section -->
        <li class="user-greeting">
            <div class="d-flex align-items-center">
                @if(session('user'))
                    <span class="me-3 text-light">Bonjour, {{ session('user')['id'] }} !</span>
                @else
                    <span class="me-3 text-light">Utilisateur non identifié !</span>
                @endif
            </div>
        </li>
    </ul>
</nav>

<style>
    .navbar {
        background-color: #333;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: var(--navbar-height, 60px);
        z-index: 1001;
        display: flex;
        align-items: center;
    }

    .navbar-list {
        list-style: none;
        display: flex;
        justify-content: space-between; /* Changed to space-between */
        align-items: center;
        margin: 0;
        padding: 0 20px;
        width: 100%;
        height: 100%;
    }

    .navbar-list li {
        display: flex;
        align-items: center;
        height: 100%;
        flex: 1; /* Make items grow to fill space */
    }

    .navbar-list li a {
        color: white;
        text-decoration: none;
        padding: 0 15px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s;
        width: 100%; /* Make links fill the li width */
    }

    .navbar-list li a:hover {
        background-color: #575757;
    }

    .user-greeting {
        flex: 0 0 auto !important; /* Don't grow, don't shrink, auto basis */
        margin-left: auto;
        padding: 0 15px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .navbar {
            height: auto;
            position: static;
        }

        .navbar-list {
            flex-direction: column;
            padding: 10px;
        }

        .navbar-list li {
            width: 100%;
            height: 40px;
        }

        .user-greeting {
            margin-left: 0;
            justify-content: center;
        }
    }
</style>