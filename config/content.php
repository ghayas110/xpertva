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

];
