/** @type {import('tailwindcss').Config} */
export default {
  daisyui: {
      themes: ["light", "dark", "cupcake"],
  },
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
      color: {
        bgwhite : "#F9F9F9",
          'tag-blue': '#00f',
      }
  },
  plugins: [
        require("daisyui"),
  ],
}

