/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js" // set up the path to the flowbite package
  ],
  theme: {
    colors:{
      cuiBlack : '#1f1f1f',
      cuiGrayDark : '#272727',
      cuiGray : '#303030',
      cuiGrayLight : '#7c7c7c',
      cuiOrange : '#fc9a1c',
      cuiOrangeLight : '#ffa126'
    },
    fontFamily: {
      cuiInter: ['Inter', 'sans-serif']
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
