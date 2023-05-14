/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    600: "#7F56D9",
                },
            },
        },
    },
    plugins: [],
};
