/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js" // set up the path to the flowbite package
  ],
  theme: {
    colors:{
      phBlack : '#1f1f1f',
      phGrayDark : '#272727',
      phGray : '#303030',
      phGrayLight : '#7c7c7c',
      phOrangeDark : '#fc9a1c',
      phOrange : '#ffa126'
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
