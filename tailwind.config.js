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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'sans-serif'],
            },
            colors: {
                primary: "#B9B28A",
                secondary: "#fdf7f0",
                background: "#ffffff",
                accent1: "#557bcf",
                accent2: "#a4c6e9",
                text: "##4A4A4A",
                error: "#e3342f",
                success: "#00a65a",
                warning: "#f6c23e",
            }
        },
    },
    plugins: [],
};
