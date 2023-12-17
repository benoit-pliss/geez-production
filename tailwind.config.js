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
  },
  plugins: [
        require("daisyui"),
  ],
}

