/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                primary: ["IBM Plex Sans", "sans-serif"],
            },
            animation: {
                "gentle-pulse": "gentlePulse 3s ease-in-out infinite",
                "spin-bounce": "spinBounce 2s ease-in-out infinite",
                typing: "typing 2s steps(40, end) forwards",
                sparkle: "sparkle 3s ease-in-out infinite",
                "confetti-fall": "confettiFall 4s linear forwards",
            },
            keyframes: {
                gentlePulse: {
                    "0%, 100%": { transform: "scale(1)" },
                    "50%": { transform: "scale(1.02)" },
                },
                spinBounce: {
                    "0%": { transform: "rotate(0deg) scale(1)" },
                    "50%": { transform: "rotate(180deg) scale(1.2)" },
                    "100%": { transform: "rotate(360deg) scale(1)" },
                },
                typing: {
                    from: { width: "0" },
                    to: { width: "100%" },
                },
                sparkle: {
                    "0%, 100%": { opacity: "0", transform: "scale(0.5)" },
                    "50%": { opacity: "1", transform: "scale(1.2)" },
                },
                confettiFall: {
                    "0%": {
                        transform:
                            "translateY(0) rotate(0deg) scale(var(--random-scale))",
                        opacity: "1",
                    },
                    "100%": {
                        transform:
                            "translateY(-100vh) rotate(var(--random-rotation)) translateX(var(--random-x)) scale(0.2)",
                        opacity: "0",
                    },
                },
            },
        },
    },
    plugins: [],
};
