<?php

/*
|--------------------------------------------------------------------------
| Blog <-> service page linking
|--------------------------------------------------------------------------
|
| The 2026-11 SEO audit found blog posts competing with the service pages
| they should support: the PPC post against /services/amazon/ppc-management,
| the listing post against its service page, and so on. Google had two URLs
| answering one query and could not tell which to rank.
|
| The fix is a clear division of labour. Posts answer the how-to question
| and hand the reader on to the service; the service page sells and points
| back to the post for the background. This file is the single map both
| sides read, so the link always goes in both directions.
|
*/

return [

    // Every service page a post can hand off to. Keyed by route name.
    'services' => [
        'services.amazon' => [
            'label' => 'Amazon account management',
            'pitch' => 'We run Amazon accounts day to day: listings, advertising, account health and inventory, handled by one named operator.',
        ],
        'services.amazon.ppc-management' => [
            'label' => 'Amazon PPC management',
            'pitch' => 'Rather have someone run the campaigns? We build, bid and prune Sponsored Products, Brands and Display against your break-even ACoS.',
        ],
        'services.amazon.listing-optimization' => [
            'label' => 'Amazon listing optimization',
            'pitch' => 'We rewrite titles, bullets, backend terms and images from keyword research, then track rank and conversion after the change.',
        ],
        'services.amazon.a-plus-storefront' => [
            'label' => 'Amazon A+ Content and Storefront design',
            'pitch' => 'A+ modules, Brand Story and multi-page Amazon Stores, designed for a phone screen first and tested where your brand is eligible.',
        ],
        'services.amazon.brand-protection' => [
            'label' => 'Amazon brand protection',
            'pitch' => 'Hijacker removal, counterfeit reports and MAP enforcement through Brand Registry, with a monthly record of what was filed.',
        ],
        'services.amazon.account-management' => [
            'label' => 'Amazon account management',
            'pitch' => 'We watch account health daily, handle cases and appeals, and fix listing errors before they turn into suspensions.',
        ],
        'services.amazon-ops' => [
            'label' => 'Amazon operations',
            'pitch' => 'Forecasting, replenishment, cases and Brand Registry run by an operator who knows your catalogue.',
        ],
        'services.amazon-va' => [
            'label' => 'Amazon virtual assistant services',
            'pitch' => 'Hire a dedicated Amazon VA who already knows Seller Central: listings, buyer messages, FBA shipments, cases and weekly reporting.',
        ],
        'services.va' => [
            'label' => 'eCommerce virtual assistants',
            'pitch' => 'Hire a trained eCommerce virtual assistant who already knows Seller Central, Shopify and the marketplace tools you use.',
        ],
        'services.web-dev' => [
            'label' => 'eCommerce website development',
            'pitch' => 'Shopify, WooCommerce and custom builds, scoped in writing before any work starts.',
        ],
        'services.design' => [
            'label' => 'Design and development',
            'pitch' => 'Brand, product and interface design for eCommerce teams, delivered by the people who build it.',
        ],
        'services.marketing' => [
            'label' => 'eCommerce marketing',
            'pitch' => 'Paid search, paid social and marketplace advertising measured on blended acquisition cost.',
        ],
    ],

    // Which service each post supports. Keyed by blog slug.
    'post_service' => [
        'amazon-ppc-management-in-2026-how-to-lower-acos-and-scale-profitably' => 'services.amazon.ppc-management',
        'amazon-listing-optimization-in-2026-how-to-rank-higher-and-convert-more-shoppers' => 'services.amazon.listing-optimization',
        'how-to-list-items-on-amazon-a-step-by-step-guide-for-sellers' => 'services.amazon.listing-optimization',
        'why-amazon-account-management-can-make-or-break-your-store-and-how-xpertva-handles-it-for-you' => 'services.amazon.account-management',
        // Amazon VA cluster (from the keyword brief, 2026-11-25). The service
        // page targets "amazon virtual assistant services"; these three take
        // the informational and hiring questions and hand off to it.
        'what-does-an-amazon-virtual-assistant-do-a-complete-guide-for-sellers' => 'services.amazon-va',
        'how-to-choose-the-right-amazon-virtual-assistant-service-in-2026' => 'services.amazon-va',
        'amazon-virtual-assistant-job-description' => 'services.amazon-va',
        'virtual-assistant-cost-in-2026-offshore-va-vs-in-house-hire' => 'services.va',
        'what-is-the-amazon-forecast-algorithm-a-sellers-guide-to-predicting-demand' => 'services.amazon-ops',
        'what-is-an-amazon-product-manager-roles-responsibilities-and-importance' => 'services.amazon-ops',
        'the-ultimate-guide-to-successfully-launching-your-product-on-amazon' => 'services.amazon',
        'unveiling-success-the-ultimate-guide-to-selecting-profitable-products-on-amazon-fba' => 'services.amazon',
        '35-high-demand-and-trending-products-to-sell-online-in-2026' => 'services.amazon',
        'how-much-does-ecommerce-website-development-cost-in-2026-a-complete-breakdown' => 'services.web-dev',
        'how-long-does-it-take-to-build-design-a-website-in-usa' => 'services.web-dev',
        'graphic-designing-service-making-a-name-graphically' => 'services.design',
        'social-media-management-for-ecommerce-brands-a-practical-guide-for-2026' => 'services.marketing',
    ],

    /*
    |----------------------------------------------------------------------
    | Merged posts (301)
    |----------------------------------------------------------------------
    |
    | Three thin posts (370-436 words) all answered "should I hire an Amazon
    | virtual assistant" and split whatever authority that topic earned three
    | ways. "10 reasons" is folded into the "what does an Amazon VA do" guide
    | and answers with a 301. It drops out of the blog index, related posts
    | and the sitemap. The row stays in the database; deleting this entry
    | brings it back.
    |
    | "How to choose" was going to be merged too, but the keyword brief gave
    | it a job of its own (hire / agency / best / cheap), so it was rewritten
    | in place instead: database/content/amazon-va-cluster.json.
    |
    */
    'blog_redirects' => [
        '10-reasons-to-hire-an-amazon-virtual-assistant-for-your-fba-business'
            => 'what-does-an-amazon-virtual-assistant-do-a-complete-guide-for-sellers',
    ],

    /*
    |----------------------------------------------------------------------
    | Search titles for posts
    |----------------------------------------------------------------------
    |
    | The <title> tag only, keyword first and at most 50 characters so it
    | stays under 60 once " | XpertVA" is added. The on-page H1 keeps the
    | post's own title from the admin. Posts not listed here fall back to
    | that title. Keyed by slug.
    |
    */
    'seo_titles' => [
        'what-i-learned-about-ppc-management-the-hard-way' => 'Amazon PPC Mistakes: What I Learned the Hard Way',
        'a-4-step-guide-to-merging-listings-on-amazon-parent-child-variations-duplicate-asins' => 'How to Merge Listings on Amazon in 4 Steps',
        'the-ultimate-guide-to-training-your-amazon-virtual-assistant-for-maximum-efficiency' => 'How to Train an Amazon Virtual Assistant',
        'virtual-assistant-cost-in-2026-offshore-va-vs-in-house-hire' => 'Virtual Assistant Cost 2026: Offshore vs In-House',
        'social-media-management-for-ecommerce-brands-a-practical-guide-for-2026' => 'Social Media Management for eCommerce Brands',
        'how-much-does-ecommerce-website-development-cost-in-2026-a-complete-breakdown' => 'eCommerce Website Development Cost in 2026',
        'amazon-listing-optimization-in-2026-how-to-rank-higher-and-convert-more-shoppers' => 'How to Optimize an Amazon Listing in 2026',
        'amazon-ppc-management-in-2026-how-to-lower-acos-and-scale-profitably' => 'How to Lower ACoS on Amazon: A 2026 Guide',
        '35-high-demand-and-trending-products-to-sell-online-in-2026' => '35 Trending Products to Sell Online in 2026',
        'how-long-does-it-take-to-build-design-a-website-in-usa' => 'How Long Does It Take to Build a Website?',
        'how-to-choose-the-right-amazon-virtual-assistant-service-in-2026' => 'How to Hire an Amazon Virtual Assistant in 2026',
        'what-does-an-amazon-virtual-assistant-do-a-complete-guide-for-sellers' => 'What Does an Amazon Virtual Assistant Do?',
        'amazon-virtual-assistant-job-description' => 'Amazon VA Job Description: Duties and Skills',
        'what-is-the-amazon-forecast-algorithm-a-sellers-guide-to-predicting-demand' => 'Amazon Forecast Algorithm: Predicting Demand',
        'how-to-list-items-on-amazon-a-step-by-step-guide-for-sellers' => 'How to List Items on Amazon: Step-by-Step Guide',
        'what-is-an-amazon-product-manager-roles-responsibilities-and-importance' => 'Amazon Product Manager: Role and Responsibilities',
        'why-amazon-account-management-can-make-or-break-your-store-and-how-xpertva-handles-it-for-you' => 'Amazon Account Health: How to Avoid Suspension',
        'graphic-designing-service-making-a-name-graphically' => 'Graphic Design Services for eCommerce Brands',
        'unveiling-success-the-ultimate-guide-to-selecting-profitable-products-on-amazon-fba' => 'How to Find Profitable Products for Amazon FBA',
        'the-ultimate-guide-to-successfully-launching-your-product-on-amazon' => 'How to Launch a Product on Amazon: Full Guide',
    ],

    /*
    |----------------------------------------------------------------------
    | Authors
    |----------------------------------------------------------------------
    |
    | Only the two people on /team with real portraits. Bios say nothing
    | beyond their role, because nothing else about them has been supplied:
    | add experience, background and a LinkedIn URL here and the bio page,
    | the byline and the Person schema all pick it up. A null linkedin is
    | simply left out of sameAs.
    |
    | post_author maps blog slug -> author key; anything unlisted gets
    | default_author. The split below is a proposal for the client to
    | confirm: operations and VA topics to the COO, the rest to the founder.
    |
    */
    'authors' => [
        'ali-zaidi' => [
            'name'     => 'Ali Zaidi',
            'role'     => 'Chief Executive Officer and founder',
            'photo'    => 'assets/images/alizaidi.jpeg',
            'linkedin' => null,
            'bio'      => [
                'Ali Zaidi founded XpertVA in 2017 in Englishtown, New Jersey, and leads the company as Chief Executive Officer.',
                'XpertVA runs marketplace operations for brands selling on Amazon, Shopify, Walmart and eBay: listings, advertising, account health and creative, handled by in-house operators.',
            ],
            'knowsAbout' => ['Amazon Seller Central', 'Amazon PPC', 'Amazon listing optimization', 'eCommerce operations'],
        ],
        'ebraheem-azhar' => [
            'name'     => 'Ebraheem Azhar',
            'role'     => 'Chief Operating Officer',
            'photo'    => 'assets/images/Ebraheem.jpeg',
            'linkedin' => null,
            'bio'      => [
                'Ebraheem Azhar is Chief Operating Officer at XpertVA.',
                'XpertVA puts one named operator on each client account, with a trained backup, across Amazon, Shopify, Walmart and eBay.',
            ],
            'knowsAbout' => ['Amazon virtual assistants', 'Amazon FBA operations', 'Seller Central account health'],
        ],
    ],

    'default_author' => 'ali-zaidi',

    'post_author' => [
        // Amazon VA cluster and staffing topics
        'what-does-an-amazon-virtual-assistant-do-a-complete-guide-for-sellers' => 'ebraheem-azhar',
        'how-to-choose-the-right-amazon-virtual-assistant-service-in-2026' => 'ebraheem-azhar',
        'amazon-virtual-assistant-job-description' => 'ebraheem-azhar',
        'the-ultimate-guide-to-training-your-amazon-virtual-assistant-for-maximum-efficiency' => 'ebraheem-azhar',
        'virtual-assistant-cost-in-2026-offshore-va-vs-in-house-hire' => 'ebraheem-azhar',
        'why-amazon-account-management-can-make-or-break-your-store-and-how-xpertva-handles-it-for-you' => 'ebraheem-azhar',
        'what-is-the-amazon-forecast-algorithm-a-sellers-guide-to-predicting-demand' => 'ebraheem-azhar',
        // PPC and listing posts, and everything else, fall to the default
        'amazon-ppc-management-in-2026-how-to-lower-acos-and-scale-profitably' => 'ali-zaidi',
        'what-i-learned-about-ppc-management-the-hard-way' => 'ali-zaidi',
        'amazon-listing-optimization-in-2026-how-to-rank-higher-and-convert-more-shoppers' => 'ali-zaidi',
        'how-to-list-items-on-amazon-a-step-by-step-guide-for-sellers' => 'ali-zaidi',
        'a-4-step-guide-to-merging-listings-on-amazon-parent-child-variations-duplicate-asins' => 'ali-zaidi',
    ],

    /*
    |----------------------------------------------------------------------
    | Case studies
    |----------------------------------------------------------------------
    |
    | Every figure below was read off a Seller Central sales-dashboard
    | screenshot in public/assets. Nothing is estimated. Brand names stay
    | out, matching the rest of the site.
    |
    | "earliest" and "latest" are the first and last reports we hold, not
    | the start and end of the engagement, because the engagement dates
    | were not supplied. challenge and actions are null until the client
    | writes them; the page shows those sections only when they are filled.
    |
    */
    'case_studies' => [
        'amazon-brand-9-2-million-in-14-months' => [
            'title'     => 'Amazon Case Study: $9.2M in Sales Over 14 Months',
            'h1'        => '$9.2 million in Amazon sales over fourteen months',
            'summary'   => 'One US Amazon account we manage, from $288K in March 2024 to $909.7K in October 2025, with $9.23M ordered across September 2024 to November 2025.',
            'account'   => 'US Amazon brand, name withheld at the client\'s request',
            'channel'   => 'Amazon US',
            'timeframe' => 'March 2024 to November 2025',
            'related'   => ['services.amazon', 'services.amazon.ppc-management', 'services.amazon.listing-optimization'],
            'cover'     => 'assets/proof/case-year.jpg',
            'headline'  => [
                ['value' => '$9,226,488', 'label' => 'Ordered product sales, 15 Sep 2024 to 15 Nov 2025'],
                ['value' => '54,039', 'label' => 'Order items in the same period'],
                ['value' => '+145%', 'label' => 'Units sold, October 2025 vs October 2024'],
            ],
            'before' => [
                'label'  => 'March 2024',
                'source' => 'assets/case-study-sds/sales-march-2024.jpg',
                'rows'   => [
                    ['Ordered product sales', '$288,423.84'],
                    ['Order items', '1,762'],
                    ['Units ordered', '2,950'],
                ],
            ],
            'after' => [
                'label'  => 'October 2025',
                'source' => null,
                'rows'   => [
                    ['Ordered product sales', '$909.7K (+26% year on year)'],
                    ['Units sold', '10,313 (+145% year on year)'],
                    ['Featured offer (Buy Box) share', '39.6% (+978 basis points year on year)'],
                ],
                'note'   => 'From Amazon\'s Business Performance Insights summary shown on the same dashboard.',
            ],
            'timeline' => [
                ['Jan to Mar 2024', '$976,715.50', '4,308 order items, 7,355 units', 'assets/case-study-sds/sales-q1-2024.jpg'],
                ['Sep 2024', '$658,138.75', '2,186 order items, 3,544 units', 'assets/case-study-sds/sales-september-2024.jpg'],
                ['Oct to Dec 2024', '$2,086,577.20', '7,638 order items, 12,585 units', 'assets/case-study-sds/sales-q4-2024.jpg'],
                ['15 Sep 2024 to 15 Nov 2025', '$9,226,488.00', '54,039 order items, 85,277 units', 'assets/case-study-sds/sales-last-quarter-2025.jpg'],
            ],
            'challenge' => null,
            'actions'   => null,
        ],
        'toy-brand-amazon-q4-sales-up-6-6x' => [
            'title'     => 'Amazon Toy Brand Case Study: Q4 Sales Up 6.6x',
            'h1'        => 'A toy brand\'s Amazon sales, up 6.6 times in one year\'s peak',
            'summary'   => 'An Amazon toy brand went from $32,361 in Q1 2024 to $214,036 in Q4 2024. A year later its featured offer share stood at 97.8%, up 96.6 points.',
            'account'   => 'US Amazon toy brand',
            'channel'   => 'Amazon US',
            'timeframe' => 'January 2024 to October 2025',
            'related'   => ['services.amazon', 'services.amazon.account-management', 'services.amazon.ppc-management'],
            'cover'     => 'assets/case-study-tubelox/sales-q4-2024.png',
            'headline'  => [
                ['value' => '6.6x', 'label' => 'Ordered product sales, Q4 2024 vs Q1 2024'],
                ['value' => '$214,036', 'label' => 'Ordered product sales, October to December 2024'],
                ['value' => '97.8%', 'label' => 'Featured offer share, October 2025 (+96.6 points year on year)'],
            ],
            'before' => [
                'label'  => 'January to March 2024',
                'source' => 'assets/case-study-tubelox/sales-q1-2024.png',
                'rows'   => [
                    ['Ordered product sales', '$32,361.37'],
                    ['Order items', '189'],
                    ['Units ordered', '243'],
                ],
            ],
            'after' => [
                'label'  => 'October to December 2024',
                'source' => 'assets/case-study-tubelox/sales-q4-2024.png',
                'rows'   => [
                    ['Ordered product sales', '$214,036.28'],
                    ['Order items', '642'],
                    ['Units ordered', '666'],
                ],
            ],
            'timeline' => [
                ['Jan to Mar 2024', '$32,361.37', '189 order items, 243 units', 'assets/case-study-tubelox/sales-q1-2024.png'],
                ['Oct to Dec 2024', '$214,036.28', '642 order items, 666 units', 'assets/case-study-tubelox/sales-q4-2024.png'],
                ['Oct 2025', 'Featured offer 97.8%', '+96.6 percentage points year on year, per Amazon\'s insights summary', null],
            ],
            'challenge' => null,
            'actions'   => null,
        ],
    ],

    /*
    | A third-party review profile (Trustpilot, Clutch, Google). Shown on
    | /work and the case studies once set. Left null until a profile with
    | real reviews exists: linking an empty one hurts more than it helps.
    */
    'review_profile' => null,

];
