<nav class="navbar navbar-light navbar-expand-md navbar-spark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <svg class="h-37 w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 43" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path id="a" d="M22 2.5c4-3.8 6.7-2.4 6 3.2l-1.5 10h4.2c5.5 0 6.7 3.2 2.6 7L14 40.7c-4 3.7-6.7 2.3-6-3.3l1.5-10H5.3c-5.5 0-6.7-3-2.6-7L22 2.4z"/>
                    <linearGradient id="b" x1="59.1%" x2="88.7%" y1="55.6%" y2="100%">
                        <stop stop-color="#F1C476" offset="0%"/>
                        <stop stop-color="#CC973B" offset="100%"/>
                    </linearGradient>
                    <linearGradient id="d" x1="11.3%" x2="40.9%" y1="0%" y2="44.4%">
                        <stop stop-color="#CC973B" offset="0%"/>
                        <stop stop-color="#F1C476" offset="100%"/>
                    </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <path fill="#F1C476" d="M16 8.4c7.3-7 12.3-4.4 10.8 5.7l-.2 2c7.8 0 8 5.7.6 12.7l-7 6.5c-7.5 7-12.4 4.5-11-5.7l.3-1.8c-7.8 0-8-5.7-.7-12.6l7-6.5z"/>
                    <g transform="translate(.037 .147)">
                        <mask id="c" fill="#fff">
                            <use xlink:href="#a"/>
                        </mask>
                        <use fill="#F1C476" xlink:href="#a"/>
                        <path fill="url(#b)" d="M3.8-1.5h25.6v17.3H3.8" mask="url(#c)"/>
                        <path fill="url(#d)" d="M6.6 27.3h25.6v17.3H6.6z" mask="url(#c)"/>
                    </g>
                </g>
            </svg>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/login">{{__('Login')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">{{__('Register')}}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>