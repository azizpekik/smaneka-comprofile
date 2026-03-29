import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Roboto', ...defaultTheme.fontFamily.sans],
                heading: ['Raleway', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#313575',
                    50: '#f0f1f8',
                    100: '#e1e3f0',
                    200: '#c5c8e2',
                    300: '#a1a6d0',
                    400: '#7a80bc',
                    500: '#5d63a8',
                    600: '#464b8f',
                    700: '#3b3f7a',
                    800: '#313575',
                    900: '#183152', // UniPulse heading color
                    950: '#0f1f3a',
                },
                secondary: {
                    DEFAULT: '#E8A202',
                    50: '#fef9e6',
                    100: '#fdf2cd',
                    200: '#fae59b',
                    300: '#f6d360',
                    400: '#f3bc2e',
                    500: '#E8A202',
                    600: '#d08a02',
                    700: '#ad6e03',
                    800: '#8d5806',
                    900: '#744708',
                    950: '#442602',
                },
                accent: {
                    DEFAULT: '#B50038',
                    50: '#fdf0f3',
                    100: '#fae1e7',
                    200: '#f5c5d1',
                    300: '#ed9cb1',
                    400: '#e16989',
                    500: '#d34269',
                    600: '#B50038',
                    700: '#9a0232',
                    800: '#7e052e',
                    900: '#69082c',
                    950: '#3b0117',
                },
                // UniPulse-inspired neutral colors
                slate: {
                    394757: '#394757', // Default text color
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out',
                'slide-up': 'slideUp 0.6s ease-out',
                'slide-down': 'slideDown 0.6s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%': { opacity: '0', transform: 'translateY(-20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
