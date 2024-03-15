const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    theme: {
        extend: {
            colors:{
                'content-dark':'#585958',
                'gray-light':'#F7F7F7',
                'gray-dark':'#C8C8C8',
                'primary-blue':'#36737A',
                'primary-lite':'#E9EFF6',
                'secondary-red':'#9F1236', 
                'gradient-start':'#789866',
                'gradient-end':'#367379',
            },
            fontFamily: {
                sans: ['Prompt','Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',

        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
