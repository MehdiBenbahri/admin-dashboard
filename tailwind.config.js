/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors');

export default {
  content: [
    "./public/**/*.{js,ts,jsx,tsx}",
    "./templates/**/*.{html,twig,jsx,tsx}",
    "./assets/**/*.{html,twig,jsx,tsx,css,scss}"
  ],
  theme: {
    extend: {},
    colors: {
			primary: colors.sky,
			secondary: colors.violet,
			accent: colors.accent,
			neutral: colors.neutral,
			info: colors.cyan,
			success: colors.green,
			warning: colors.amber,
			danger: colors.red,
			panel: colors.gray,
      slate: colors.slate
		},
  },
  plugins: [],
  darkMode: 'class'
}

