import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        // './storage/framework/views/*.php',
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.ts",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            base: {
                colors: {
                    gray: {
                        light: "#f8f9fa",
                        DEFAULT: "#adb5bd",
                        dark: "#495057",
                    },
                    contextual: {
                        light: {
                            primary: { default: "#5324FF", hover: "#0056b3" },
                        },
                        dark: {
                            primary: { default: "#375a7f", hover: "#23395d" },
                        },
                    },
                },
                boxShadows: {
                    light: { sm: "0px 1px 2px rgba(0, 0, 0, 0.05)" },
                    dark: { sm: "0px 1px 2px rgba(255, 255, 255, 0.05)" },
                },
            },
            custom: {
                components: {
                    common: {
                        backgrounds: {
                            light: { card: "#ffffff", modal: "#f8f9fa" },
                            dark: { card: "#343a40", modal: "#212529" },
                        },
                        borders: {
                            light: { card: "#dee2e6", modal: "#adb5bd" },
                            dark: { card: "#495057", modal: "#6c757d" },
                        },
                        boxShadows: {
                            light: { card: "0px 4px 6px rgba(0, 0, 0, 0.1)" },
                            dark: { card: "0px 4px 6px rgba(255, 255, 255, 0.1)" },
                        },
                    },
                },
            },
        },
    },

    plugins: [
        // forms,
        require("./resources/metronic/core/plugins/plugin"),
        require("./resources/metronic/core/plugins/components/theme"),
    ],
};
