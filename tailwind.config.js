/** @type {import('tailwindcss').Config} */
export default {
  mode: 'jit',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'cPrimary': '#AC31FF',
        'cSecondary': '#D69FFB',
        'cNot-black': '#0F0F0F',
        'cAccent': '#FE94D3',
        'cGreen': '#30EAA1',
        'cGrey': '#F0F0F0',
        'cDarkGrey': '#787878'
      },
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
        'gilroy': ['Gilroy', 'sans-serif'],
      },
    },
  },
  plugins: [],
}