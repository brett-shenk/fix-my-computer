const CONFIG = {
    "files": [
        {
            "id": "theme",
            "styles": [
                "assets/sass/theme.scss",
            ],
            "js": [
                "assets/js/theme.js"
            ],
            "images": [
                "assets/images/*",
                "assets/images/**/*"
            ]
        },
        {
            "id": "admin",
            "styles": [
                "assets/sass/admin.scss"
            ],
            "js": []
        },
        {
            "id": "custom-editor",
            "styles": [
                "assets/sass/custom-editor.scss"
            ]
        },
        {
            "id": "login-styles",
            "styles": [
                "assets/sass/login-styles.scss"
            ]
        },
        {
            "id": "vendor",
            "js": [
                'assets/js/vendor/slick/slick.min.js',
                'assets/js/vendor/mmenu-light/mmenu-light.js',
                'assets/js/vendor/phone-mask/phone-mask.min.js'
            ]
        },
        {
            "id": "alert-bar",
            "styles": [
                "assets/sass/alert-bar.scss"
            ],
            "js": [
                'assets/js/alert-bar.js'
            ]
        },
    ],
    "font": {
        pathIn: './assets/fonts/',              // Absolute path only
        pathOut: './assets/fonts/',
        outputFormats: ['.woff', '.woff2'],
        inputFormats: ['.ttf'],                 // woff, woff2, svg, ttf, otf
    },
    "iconFont": {
        name : 'shenks-icons',
        folder : 'assets/svgs/*.svg',                           // Files to be included in the icon font
        cssPath : '../svgs/',                                   // Included into sass as the path to the icon font
        sassInput : './assets/sass/setup/_icons-template.scss', // The raw sass file before being compiled
        sassOutput : '../../sass/global/_icons.scss',                  // The compiled Icon font sass file
    },
    "watch": {
        "styles": [
            "assets/sass/**/*.scss",
            "assets/sass/*.scss"
        ],
        "scripts": [
            "assets/js/*.js",
            "assets/js/vendor/**/*.js"
        ],
        "images": [
            "assets/images/*",
            "assets/images/**/*"
        ]
    },
    "dest":  {
        "styles": "./assets/dist/css",
        "scripts": "./assets/dist/js",
        "images": "./assets/dist/images",
        "fontFolder": "assets/dist/svgs/",
        "fontFile": "assets/dist/svgs/*.svg",
    }
};

exports.CONFIG = CONFIG;
