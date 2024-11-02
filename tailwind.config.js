/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
module.exports = {
    content: [
        "./assets/**/*.{js,jsx,ts,tsx}",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}