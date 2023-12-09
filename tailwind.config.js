/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js" // set up the path to the flowbite package
  ],
  theme: {
    colors:{
      Black : '#1f1f1f',
      GrayDark : '#272727',
      Gray : '#303030',
      GrayLight : '#7c7c7c',
      Orange : '#fc9a1c',
      OrangeLight : '#ffa126'
    },
    fontFamily: {
      interPh: ['Inter', 'sans-serif']
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
