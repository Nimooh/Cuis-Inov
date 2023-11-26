/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js" // set up the path to the flowbite package
  ],
  theme: {
    extend: {
      colors: {
        'orange-peel': '#fc9a1c',
        'gray': '#7c7c7c',
        'jet': '#303030',
        'raisin-black': '#272727',
        'eerie-black': '#1f1f1f',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
