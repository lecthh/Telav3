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
      animation: {
        'fade-in': 'fade-in 0.6s ease-in',
        "fade-in-up": "fade-in-up 0.6s ease-in-out",
        "float": "float 1s ease-in-out",
      },
      keyframes: {
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        "fade-in-up": {
          "0%": {
            "opacity": "0",
            "transform": "translateY(20px)"
          },
          "100%": {
            "opacity": "1",
            "transform": "translateY(0)"
          }
        },
        "float": {
          "0%": {
            "transform": "translateY(0)"
          },
          "50%": {
            "transform": "translateY(-10px)"
          },
          "100%": {
            "transform": "translateY(0)"
          }
        }
      },
    },
  },
  plugins: [
    require("tailwindcss-animate"),
  ],
}