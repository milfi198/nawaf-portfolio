<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Nawaf Milfi M')</title>
    <link rel="icon" type="image/png" href="{{ asset('a80841e3-34ae-47fa-9790-96787ca175c4.png') }}?v=2">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>

    @stack('styles')
    @stack('head-scripts')

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "#faf9fe",
                        "background": "#faf9fe",
                        "surface-container-low": "#f4f3f8",
                        "surface-container": "#eeedf3",
                        "surface-container-high": "#e9e7ed",
                        "surface-variant": "#e3e2e7",
                        "on-background": "#1a1b1f",
                        "on-surface": "#1a1b1f",
                        "on-surface-variant": "#414755",
                        "outline": "#717786",
                        "outline-variant": "#c1c6d7",
                        "primary": "#0058bc",
                        "on-primary": "#ffffff",
                        "primary-container": "#0070eb",
                        "on-primary-container": "#fefcff",
                        "secondary": "#5e5e5e",
                        "on-secondary": "#ffffff",
                        "tertiary": "#9e3d00",
                        "on-tertiary": "#ffffff",
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "stack-sm": "16px",
                        "stack-md": "32px",
                        "section-padding": "120px",
                        "base-unit": "8px",
                        "gutter": "24px",
                        "container-max": "1280px"
                    },
                    fontFamily: {
                        "body-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-xl": ["Inter"]
                    },
                    fontSize: {
                        "body-md": ["16px", { lineHeight: "1.6", fontWeight: "400" }],
                        "label-sm": ["14px", { lineHeight: "1.0", letterSpacing: "0.05em", fontWeight: "500" }],
                        "headline-md": ["24px", { lineHeight: "1.3", fontWeight: "600" }],
                        "headline-lg": ["32px", { lineHeight: "1.2", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                        "display-xl": ["64px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-background text-on-background font-body-md text-body-md antialiased selection:bg-primary-container selection:text-on-primary-container">

    @yield('content')

    @stack('scripts')

</body>
</html>
