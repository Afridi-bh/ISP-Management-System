const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
        './resources/js/**/*.jsx',
        './app/Http/Livewire/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', 'system-ui', 'sans-serif'],
            },

            /**
             * ✔ KEEP DEFAULT TAILWIND COLORS
             * ✔ ADD YOUR CUSTOM COLORS
             * (this prevents “install essential colors” warnings)
             */
            colors: {
                ...colors,

                primary: {
                    50:'#f0f9ff',100:'#e0f2fe',200:'#bae6fd',300:'#7dd3fc',
                    400:'#38bdf8',500:'#0ea5e9',600:'#0284c7',700:'#0369a1',
                    800:'#075985',900:'#0c4a6e', DEFAULT:'#0ea5e9'
                },
                secondary: {
                    50:'#faf5ff',100:'#f3e8ff',200:'#e9d5ff',300:'#d8b4fe',
                    400:'#c084fc',500:'#a855f7',600:'#9333ea',700:'#7c3aed',
                    800:'#6b21a8',900:'#581c87', DEFAULT:'#a855f7'
                },
                success: {
                    50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',
                    400:'#4ade80',500:'#22c55e',600:'#16a34a',700:'#15803d',
                    800:'#166534',900:'#14532d', DEFAULT:'#22c55e'
                },
                danger: {
                    50:'#fef2f2',100:'#fee2e2',200:'#fecaca',300:'#fca5a5',
                    400:'#f87171',500:'#ef4444',600:'#dc2626',700:'#b91c1c',
                    800:'#991b1b',900:'#7f1d1d', DEFAULT:'#ef4444'
                },
                warning: {
                    50:'#fffbeb',100:'#fef3c7',200:'#fde68a',300:'#fcd34d',
                    400:'#fbbf24',500:'#f59e0b',600:'#d97706',700:'#b45309',
                    800:'#92400e',900:'#78350f', DEFAULT:'#f59e0b'
                },
                info: {
                    50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',
                    400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',
                    800:'#1e40af',900:'#1e3a8a', DEFAULT:'#3b82f6'
                },

                darkbg: {
                    primary:'#111827',
                    secondary:'#1f2937',
                    tertiary:'#374151',
                },
            },

            backgroundImage: {
                'gradient-primary':'linear-gradient(135deg, #0ea5e9, #a855f7)',
                'gradient-secondary':'linear-gradient(135deg, #8b5cf6, #ec4899)',
                'gradient-dark':'linear-gradient(135deg, #1f2937, #111827)',
                'gradient-light':'linear-gradient(135deg, #eef2ff, #faf5ff, #fce7f3)',
                'gradient-dashboard':'linear-gradient(135deg, #c7d2fe, #ddd6fe, #fbcfe8)',
                'gradient-login':'linear-gradient(135deg, #1e3a8a, #0f766e, #0891b2)',
                'gradient-glass':'linear-gradient(135deg, rgba(255,255,255,.1), rgba(255,255,255,.05))',
            },

            boxShadow: {
                glass: '0 8px 32px rgba(31, 38, 135, 0.37)',
                'glass-lg': '0 20px 40px rgba(31, 38, 135, 0.3)',
                neumorphism:'20px 20px 60px #d9d9d9, -20px -20px 60px #fff',
                'neumorphism-dark':'20px 20px 60px #0f141e, -20px -20px 60px #1d2630',
            },

            backdropBlur: { xs: '2px' },

            keyframes: {
                'fade-in': { '0%':{opacity:0}, '100%':{opacity:1}},
                'fade-in-up': { '0%':{opacity:0,transform:'translateY(20px)'}, '100%':{opacity:1,transform:'translateY(0)'}},
                'fade-in-left': { '0%':{opacity:0,transform:'translateX(-20px)'}, '100%':{opacity:1,transform:'translateX(0)'}},
                'fade-in-right': { '0%':{opacity:0,transform:'translateX(20px)'}, '100%':{opacity:1,transform:'translateX(0)'}},
                'scale-in': { '0%':{opacity:0,transform:'scale(.9)'}, '100%':{opacity:1,transform:'scale(1)'}},
                'bounce-in': { '0%':{opacity:0,transform:'scale(.3)'}, '50%':{opacity:1,transform:'scale(1.05)'}, '100%':{transform:'scale(1)'}},
                'spin-slow': { '0%':{transform:'rotate(0deg)'}, '100%':{transform:'rotate(360deg)'}},
                'gradient-shift': { '0%':{backgroundPosition:'0% 50%'}, '50%':{backgroundPosition:'100% 50%'}, '100%':{backgroundPosition:'0% 50%'}},
            },

            animation: {
                'fade-in':'fade-in .5s ease-out',
                'fade-in-up':'fade-in-up .6s ease-out',
                'fade-in-left':'fade-in-left .6s ease-out',
                'fade-in-right':'fade-in-right .6s ease-out',
                'scale-in':'scale-in .4s ease-out',
                'bounce-in':'bounce-in .6s ease-out',
                'spin-slow':'spin-slow 3s linear infinite',
                'gradient-shift':'gradient-shift 15s ease infinite',
            },

            spacing: {
                18: '4.5rem',
                88: '22rem',
                128: '32rem',
                144: '36rem',
            },

            borderRadius: {
                '4xl': '2rem',
                '5xl': '2.5rem',
            },

            zIndex: {
                60: 60,
                70: 70,
                80: 80,
                90: 90,
                100: 100,
            },

            minHeight: { 'screen-75': '75vh' },
            maxHeight: { 'screen-90': '90vh' },
            minWidth: { 'screen-50': '50vw' },

            transitionProperty: {
                height: 'height',
                spacing: 'margin, padding',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),

        function ({ addUtilities, theme }) {
            addUtilities({
                '.glass': {
                    background: 'rgba(255,255,255,0.1)',
                    backdropFilter: 'blur(10px)',
                    border: '1px solid rgba(255,255,255,0.2)',
                },
                '.glass-dark': {
                    background: 'rgba(17,24,39,0.1)',
                    backdropFilter: 'blur(10px)',
                    border: '1px solid rgba(255,255,255,0.1)',
                },
                '.text-gradient': {
                    background: `linear-gradient(135deg, ${theme('colors.primary.500')}, ${theme('colors.secondary.500')})`,
                    backgroundClip: 'text',
                    WebkitBackgroundClip: 'text',
                    color: 'transparent',
                },
            })
        },
    ],
}
