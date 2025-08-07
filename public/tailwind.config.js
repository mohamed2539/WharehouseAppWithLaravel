/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.html',
    './core/templates/**/*.html',
    './core/**/*.html',
    './**/*.html'
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  safelist: [
    'fade-in-up',
    'animate-fade-in-up', // لو عندك اسم تاني للأنيميشن
    // ممكن تضيف أكتر من كلاس هنا
  ]
}