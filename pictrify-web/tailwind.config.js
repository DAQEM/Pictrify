/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './src/**/*.{html,js,svelte,ts}',
    './node_modules/flowbite-svelte/**/*.{html,js,svelte,ts}'
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#16181c',
        'secondary': '#26292f',
        'tertiary': '#434956',
        'theme': '#0077c2',
        'theme-light': '#00a0e9',
        'theme-dark': '#005fa3',
        't-light': '#ecf9fb',
        't-dark': '#b0bac5',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
  darkMode: 'class',
}

