<?php

/*
| NahauAfrica site structure (from the developer specification).
| Edit sections, taglines, formats and slugs here; interface words live in lang/sw.json.
*/
return [
    'locales' => ['en', 'sw'],

    // key => [category slug in newscategories, URL slugs, copy, formats]
    'sections' => [
        'fiction' => [
            'slug' => ['en' => 'fiction', 'sw' => 'hadithi'],
            'name' => ['en' => 'Fiction', 'sw' => 'Hadithi'],
            'tagline' => ['en' => 'Stories That Stay With You', 'sw' => 'Hadithi Zinazobaki Nawe'],
            'intro' => ['en' => 'Short stories, flash fiction and serialised chapters set in African places and lives.', 'sw' => 'Hadithi fupi, hadithi za papo hapo na sura za mfululizo zilizowekwa katika maeneo na maisha ya Kiafrika.'],
            'formats' => ['Short story', 'Serialised', 'Flash fiction', 'Collection'],
            'prompt' => ['en' => 'story to tell', 'sw' => 'hadithi ya kusimulia'],
            'label' => 'Fiction',
        ],
        'relationships' => [
            'slug' => ['en' => 'relationships', 'sw' => 'mahusiano'],
            'name' => ['en' => 'Relationships', 'sw' => 'Mahusiano'],
            'tagline' => ['en' => 'The People Who Shape Our Lives', 'sw' => 'Watu Wanaounda Maisha Yetu'],
            'intro' => ['en' => 'Personal essays, interviews and stories about love, family, friendship and community.', 'sw' => 'Insha binafsi, mahojiano na hadithi kuhusu upendo, familia, urafiki na jamii.'],
            'formats' => ['Personal essay', 'Fiction', 'Interview', 'Reader story'],
            'prompt' => ['en' => 'relationship story', 'sw' => 'hadithi ya mahusiano'],
            'label' => 'Personal experience',
        ],
        'jobs-careers' => [
            'slug' => ['en' => 'jobs-careers', 'sw' => 'kazi'],
            'name' => ['en' => 'Jobs & Careers', 'sw' => 'Kazi na Taaluma'],
            'tagline' => ['en' => 'Work, Ambition, and Everyday Progress', 'sw' => 'Kazi, Matamanio na Maendeleo ya Kila Siku'],
            'intro' => ['en' => 'Working-life stories, career changes, business journeys and lessons from setbacks.', 'sw' => 'Hadithi za maisha ya kazi, mabadiliko ya taaluma, safari za biashara na mafunzo kutokana na changamoto.'],
            'formats' => ['Interview', 'Personal essay', 'Business journey', 'Lessons'],
            'prompt' => ['en' => 'working-life lesson', 'sw' => 'funzo la maisha ya kazi'],
            'label' => 'Personal experience',
        ],
        'african-heroes' => [
            'slug' => ['en' => 'african-heroes', 'sw' => 'mashujaa'],
            'name' => ['en' => 'African Heroes', 'sw' => 'Mashujaa wa Afrika'],
            'tagline' => ['en' => 'Lives Worth Remembering', 'sw' => 'Maisha Yanayostahili Kukumbukwa'],
            'intro' => ['en' => 'Researched profiles and community hero nominations, with sources for factual claims.', 'sw' => 'Wasifu uliofanyiwa utafiti na uteuzi wa mashujaa wa jamii, pamoja na vyanzo vya madai ya kweli.'],
            'formats' => ['Biography', 'Interview', 'Community hero', 'Historical essay', 'Photo story'],
            'prompt' => ['en' => 'hero we should know', 'sw' => 'shujaa tunayepaswa kumjua'],
            'label' => 'Researched biography',
        ],
    ],

    'labels' => ['Fiction', 'Personal experience', 'Opinion', 'Researched biography', 'Interview', 'Sponsored'],
    'opportunity_types' => ['job' => 'Job', 'internship' => 'Internship', 'training' => 'Training', 'grant' => 'Grant'],
    'report_reasons' => ['Asks for payment', 'Fake employer', 'Job no longer available', 'Other'],
    'contact_reasons' => ['General enquiry', 'Correction request', 'Partnership proposal', 'Reader feedback', 'Report a suspicious advert'],

    // Page URL slugs per language
    'pages' => [
        'home' => ['en' => '', 'sw' => ''],
        'opportunities' => ['en' => 'jobs-careers/opportunities', 'sw' => 'kazi/fursa'],
        'series' => ['en' => 'series', 'sw' => 'mfululizo'],
        'chapter' => ['en' => 'chapter-', 'sw' => 'sura-'],
        'authors' => ['en' => 'authors', 'sw' => 'waandishi'],
        'search' => ['en' => 'search', 'sw' => 'tafuta'],
        'write' => ['en' => 'write-for-us', 'sw' => 'andika-nasi'],
        'about' => ['en' => 'about', 'sw' => 'kuhusu'],
        'contact' => ['en' => 'contact', 'sw' => 'wasiliana'],
        'privacy' => ['en' => 'privacy', 'sw' => 'faragha'],
        'terms' => ['en' => 'terms', 'sw' => 'masharti'],
        'copyright' => ['en' => 'copyright', 'sw' => 'hakimiliki'],
        'standards' => ['en' => 'editorial-standards', 'sw' => 'viwango-vya-uhariri'],
    ],

    'spotlight_seconds' => 6,
    'reply_weeks' => 2,                         // shown in Write for Us ("We aim to reply within N weeks")
    'editor_email' => env('NAHAU_EDITOR_EMAIL', env('MAIL_FROM_ADDRESS', 'editors@nahauafrica.com')),
    'contact_email' => env('NAHAU_CONTACT_EMAIL', 'hello@nahauafrica.com'),
    'city' => 'Dar es Salaam',
];
