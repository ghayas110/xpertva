@extends('layouts.app')

@section('title', 'About XpertVA - Professional Virtual Assistant Services')

@section('content')
<div class="bg-black text-white mt-10">
    <section class="pt-24 pb-12 md:pt-28 md:pb-20 px-6 text-center max-w-4xl mx-auto">
        <h1 class="text-5xl font-semibold mb-6">About XpertVA</h1>
        <p class="text-gray-300 text-lg leading-relaxed">Supporting businesses globally with expert eCommerce services. We believe in innovation, teamwork, and world-class results.</p>
    </section>

    <!-- Services Overview -->
    <section class="py-16 px-6 max-w-5xl mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 text-center">
        @php
        $stats_icons = [
            ['name' => 'Amazon Services', 'color' => 'text-yellow-400', 'svg' => 'M257.2 162.7c-48.7 1.8-169.5 15.5-169.5 117.5 0 109.5 138.3 114 183.5 43.2 6.5 10.2 35.4 37.5 45.3 46.8l56.8-56S341 288.9 341 261.4V114.3C341 89 316.5 32 228.7 32 140.7 32 94 87 94 136.3l73.5 6.8c16.3-49.5 54.2-49.5 54.2-49.5 40.7-.1 35.5 29.8 35.5 69.1zm0 86.8c0 80-84.2 68-84.2 17.2 0-47.2 50.5-56.7 84.2-57.8v40.6zm136 163.5c-7.7 10-70 67-174.5 67S34.2 408.5 9.7 379c-6.8-7.7 1-11.3 5.5-8.3C88.5 415.2 203 488.5 387.7 401c7.5-3.7 13.3 2 5.5 12zm39.8 2.2c-6.5 15.8-16 26.8-21.2 31-5.5 4.5-9.5 2.7-6.5-3.8s19.3-46.5 12.7-55c-6.5-8.3-37-4.3-48-3.2-10.8 1-13 2-14-.3-2.3-5.7 21.7-15.5 37.5-17.5 15.7-1.8 41-.8 46 5.7 3.7 5.1 0 27.1-6.5 43.1z'],
            ['name' => 'eBay Services', 'color' => 'text-blue-400', 'svg' => 'M606 189.5l-54.8 109.9-54.9-109.9h-37.5l10.9 20.6c-11.5-19-35.9-26-63.3-26-31.8 0-67.9 8.7-71.5 43.1h33.7c1.4-13.8 15.7-21.8 35-21.8 26 0 41 9.6 41 33v3.4c-12.7 0-28 .1-41.7.4-42.4.9-69.6 10-76.7 34.4 1-5.2 1.5-10.6 1.5-16.2 0-52.1-39.7-76.2-75.4-76.2-21.3 0-43 5.5-58.7 24.2v-80.6h-32.1v169.5c0 10.3-.6 22.9-1.1 33.1h31.5c.7-6.3 1.1-12.9 1.1-19.5 13.6 16.6 35.4 24.9 58.7 24.9 36.9 0 64.9-21.9 73.3-54.2-.5 2.8-.7 5.8-.7 9 0 24.1 21.1 45 60.6 45 26.6 0 45.8-5.7 61.9-25.5 0 6.6.3 13.3 1.1 20.2h29.8c-.7-8.2-1-17.5-1-26.8v-65.6c0-9.3-1.7-17.2-4.8-23.8l61.5 116.1-28.5 54.1h35.9L640 189.5zM243.7 313.8c-29.6 0-50.2-21.5-50.2-53.8 0-32.4 20.6-53.8 50.2-53.8 29.8 0 50.2 21.4 50.2 53.8 0 32.3-20.4 53.8-50.2 53.8zm200.9-47.3c0 30-17.9 48.4-51.6 48.4-25.1 0-35-13.4-35-25.8 0-19.1 18.1-24.4 47.2-25.3 13.1-.5 27.6-.6 39.4-.6zm-411.9 1.6h128.8v-8.5c0-51.7-33.1-75.4-78.4-75.4-56.8 0-83 30.8-83 77.6 0 42.5 25.3 74 82.5 74 31.4 0 68-11.7 74.4-46.1h-33.1c-12 35.8-87.7 36.7-91.2-21.6zm95-21.4H33.3c6.9-56.6 92.1-54.7 94.4 0z'],
            ['name' => 'Shopify Services', 'color' => 'text-green-400', 'svg' => 'M15.337 23.979l7.216-1.561s-2.604-17.613-2.625-17.73c-.018-.116-.114-.192-.211-.192s-1.929-.136-1.929-.136-1.275-1.274-1.439-1.411c-.045-.037-.075-.057-.121-.074l-.914 21.104h.023zM11.71 11.305s-.81-.424-1.774-.424c-1.447 0-1.504.906-1.504 1.141 0 1.232 3.24 1.715 3.24 4.629 0 2.295-1.44 3.76-3.406 3.76-2.354 0-3.54-1.465-3.54-1.465l.646-2.086s1.245 1.066 2.28 1.066c.675 0 .975-.545.975-.932 0-1.619-2.654-1.694-2.654-4.359-.034-2.237 1.571-4.416 4.827-4.416 1.257 0 1.875.361 1.875.361l-.945 2.715-.02.01zM11.17.83c.136 0 .271.038.405.135-.984.465-2.064 1.639-2.508 3.992-.656.213-1.293.405-1.889.578C7.697 3.75 8.951.84 11.17.84V.83zm1.235 2.949v.135c-.754.232-1.583.484-2.394.736.466-1.777 1.333-2.645 2.085-2.971.193.501.309 1.176.309 2.1zm.539-2.234c.694.074 1.141.867 1.429 1.755-.349.114-.735.231-1.158.366v-.252c0-.752-.096-1.371-.271-1.871v.002zm2.992 1.289c-.02 0-.06.021-.078.021s-.289.075-.714.21c-.423-1.233-1.176-2.37-2.508-2.37h-.115C12.135.209 11.669 0 11.265 0 8.159 0 6.675 3.877 6.21 5.846c-1.194.365-2.063.636-2.16.674-.675.213-.694.232-.772.87-.075.462-1.83 14.063-1.83 14.063L15.009 24l.927-21.166z'],
            ['name' => 'Walmart Services', 'color' => 'text-blue-500', 'svg' => 'M21.41818 9.10219c-.22048 0-.39583.12308-.39583.27297l.13393 1.51627c.01478.09132.12669.16185.26197.16185.13555-.00017.24705-.07065.26214-.16185l.13424-1.51627c0-.1499-.17555-.27297-.39645-.27297zM-.00002 10.3184s.59713 2.44699.69242 2.84417c.11123.46362.3117.63419.88954.51913l.37291-1.51718c.0945-.37683.1579-.64553.21866-1.02883h.01065c.04269.3871.10354.65314.18131 1.03017 0 0 .15176.68869.22949 1.05042.07795.36163.29482.5895.86083.46542l.88851-3.3633h-.71735l-.30339 1.45411c-.08155.42325-.15544.75396-.21251 1.14117h-.01022c-.05189-.38347-.11777-.70096-.20072-1.11331l-.31586-1.48197h-.7474l-.3378 1.44462c-.09569.43899-.18528.79337-.2422 1.16745h-.01023c-.05832-.35224-.13599-.7977-.22006-1.22261 0 0-.20074-1.03328-.27115-1.38946zm6.83845 0v3.3633h.68299v-3.3633zm9.6188 0v2.48118c0 .34202.0644.5817.20213.72811.12033.12806.31854.21094.55604.21094.20193 0 .40062-.0383.49426-.07317l-.0088-.53367c-.06968.01711-.1498.03078-.25942.03078-.23265 0-.31068-.149-.31068-.45611v-.94921h.59479v-.64351h-.59481v-.79533zm2.77885 0c-.11446.0027-.24452.08936-.32723.23277-.11062.19096-.09105.40434.03838.47923l1.3799.64254c.0862.03205.20323-.02912.27103-.14597.06814-.11745.0629-.2496-.0088-.3082l-1.24635-.8741c-.03237-.01874-.06877-.02717-.10693-.02627zm4.36427 0c-.03815-.0009-.0745.0075-.1068.02628l-1.2464.8741c-.07112.05846-.07653.1901-.0092.30734.00006.00013.00015.00023.00025.00036.00009.00016.00015.00033.00024.00049.06804.11686.18472.17803.27091.14598l1.38004-.64254c.12997-.0749.14861-.28827.03874-.47923-.08309-.1434-.21333-.23006-.32777-.23277zM5.312 11.0981c-.42444 0-.76136.11916-.94501.22529l.13442.46019c.16808-.10595.43566-.19366.68907-.19366.41954-.0011.48817.23728.48817.39012v.03613c-.9142-.0014-1.49164.31493-1.49164.9598 0 .3937.29399.76266.80512.76266.31466 0 .57778-.12554.73548-.32662h.01545s.10445.4367.67982.26969c-.03022-.18174-.04002-.37546-.04002-.60884v-.89849c0-.57263-.24452-1.07627-1.07086-1.07627zm4.08552 0c-.42739 0-.61944.2166-.7359.40034h-.01016v-.34335h-.65173v2.5266h.68658V12.2c0-.06945.00799-.1429.03223-.2068.05689-.1492.19565-.3237.41725-.3237.27704 0 .40667.2342.40667.57222v1.44h.68585v-1.4996c0-.06636.0091-.14622.02859-.20486.05639-.16969.20602-.30776.41201-.30776.28086 0 .41567.23012.41567.62788v1.38434h.68633v-1.48805c0-.78478-.39845-1.09555-.8483-1.09555-.19922 0-.35646.04996-.49863.13722-.1195.07334-.22655.17753-.32006.3147h-.0101c-.10853-.27228-.36375-.45192-.6963-.45192zm3.7702 0c-.42435 0-.76113.11916-.94495.22529l.13454.46019c.16792-.10595.43572-.19366.689-.19366.41926-.0011.48806.23728.48806.39012v.03613c-.91407-.0014-1.49164.31494-1.49164.9598 0 .3937.29418.76266.8056.76266.31441 0 .57759-.12554.735-.32662h.01557s.10437.4367.67982.26969c-.03027-.18174-.03996-.37546-.03996-.60884v-.89849c0-.57263-.24458-1.07627-1.07104-1.07627zm2.85129 0c-.26292 0-.56205.1697-.68761.53354h-.0191v-.47655h-.6181v2.5266h.70453V12.388c0-.06985.0042-.1307.01527-.1865.0521-.27102.25945-.44425.55696-.44425.08167 0 .1401.0088.20333.018v-.66151c-.05302-.0107-.0893-.01563-.15528-.01563zm4.35946 1.22067c-.01785-.00025-.03513.0026-.05134.0087l-1.3799.6418c-.12943.07519-.149.28868-.03838.47984.11028.1906.30469.28118.43415.20644l1.24634-.87349c.0717-.05929.07696-.19127.0088-.30862l.0006.00025c-.05507-.09558-.14292-.15388-.22027-.15492zm2.07955 0c-.07727.001-.1649.05934-.22012.15491l.00049-.00025c-.06781.11735-.06254.24934.0088.30862l1.2464.87349c.12921.07474.3238-.01584.43458-.20644.10986-.19116.09122-.40466-.03875-.47983l-1.38012-.64181c-.0162-.0061-.03344-.0089-.05128-.0087zm-16.75741.14518v.31519c0 .0466-.00406.09467-.01697.13673-.05286.17506-.23415.32303-.46086.32303-.18901 0-.33916-.1073-.33916-.33422 0-.34707.38204-.443.81699-.44073zm7.85577 0v.31519c0 .0466-.0041.09467-.0169.13673-.05287.17506-.23421.32303-.46093.32303-.18905 0-.3392-.1073-.3392-.33422 0-.34707.38209-.443.81703-.44073zm7.86138.48324c-.13506.00016-.24672.07024-.26148.16137l-.13393 1.5162c0 .15015.17535.27304.39583.27304.2209 0 .39645-.12289.39645-.27303l-.13424-1.51621c-.01509-.09113-.12659-.1612-.26214-.16137z'],
            ['name' => 'Graphic Designing', 'color' => 'text-pink-400', 'svg' => 'M136.6 138.79a64.003 64.003 0 0 0-43.31 41.35L0 460l14.69 14.69L164.8 324.58c-2.99-6.26-4.8-13.18-4.8-20.58 0-26.51 21.49-48 48-48s48 21.49 48 48-21.49 48-48 48c-7.4 0-14.32-1.81-20.58-4.8L37.31 497.31 52 512l279.86-93.29a64.003 64.003 0 0 0 41.35-43.31L416 224 288 96l-151.4 42.79zm361.34-64.62l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.75 18.75-49.15 0-67.91z'],
            ['name' => 'Data Driven Marketing', 'color' => 'text-purple-400', 'svg' => 'M496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zM464 96H345.94c-21.38 0-32.09 25.85-16.97 40.97l32.4 32.4L288 242.75l-73.37-73.37c-12.5-12.5-32.76-12.5-45.25 0l-68.69 68.69c-6.25 6.25-6.25 16.38 0 22.63l22.62 22.62c6.25 6.25 16.38 6.25 22.63 0L192 237.25l73.37 73.37c12.5 12.5 32.76 12.5 45.25 0l96-96 32.4 32.4c15.12 15.12 40.97 4.41 40.97-16.97V112c.01-8.84-7.15-16-15.99-16z']
        ];
        @endphp
        @foreach($stats_icons as $stat)
        <div class="flex flex-col items-center bg-gray-900 rounded-lg py-6 hover:bg-gray-800 transition group">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="text-4xl {{ $stat['color'] }} group-hover:scale-110 transition" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="{{ $stat['svg'] }}"></path>
            </svg>
            <p class="mt-3 text-gray-300 text-sm whitespace-nowrap">{{ $stat['name'] }}</p>
        </div>
        @endforeach
    </section>

    <!-- Success Stats -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-10 text-center">
            <div><div class="text-4xl sm:text-5xl font-semibold"><span>500+</span></div><p class="uppercase text-gray-400 text-xs mt-2">USERS WORLDWIDE</p></div>
            <div><div class="text-4xl sm:text-5xl font-semibold"><span>100+</span></div><p class="uppercase text-gray-400 text-xs mt-2">PROFESSIONAL WEBSITES</p></div>
            <div><div class="text-4xl sm:text-5xl font-semibold"><span>98%</span></div><p class="uppercase text-gray-400 text-xs mt-2">SATISFIED CUSTOMERS</p></div>
            <div><div class="text-4xl sm:text-5xl font-semibold"><span>4.9</span></div><p class="uppercase text-gray-400 text-xs mt-2">5 STAR RATINGS</p></div>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="py-12 md:py-24 px-6 text-center max-w-5xl mx-auto">
        <h2 class="text-4xl font-semibold mb-10">Meet Our Creative Team</h2>
        <p class="text-gray-300 max-w-3xl mx-auto mb-14 leading-relaxed">The core leadership behind XpertVA’s success.</p>
        <div class="flex flex-col sm:flex-row gap-14 justify-center">
            <div class="flex flex-col items-center">
                <img alt="Ali Zaidi" loading="lazy" width="180" height="180" class="rounded-xl shadow-lg" src="{{ asset('assets/images/alizaidi.jpeg') }}"/>
                <p class="mt-5 text-xl font-semibold">Ali Zaidi</p>
                <p class="text-gray-400 text-sm">CEO / Founder</p>
            </div>
            <div class="flex flex-col items-center">
                <img alt="Ebraheem Azhar" loading="lazy" width="180" height="180" class="rounded-xl shadow-lg" src="{{ asset('assets/images/Ebraheem.jpeg') }}"/>
                <p class="mt-5 text-xl font-semibold">Ebraheem Azhar</p>
                <p class="text-gray-400 text-sm">COO</p>
            </div>
        </div>
    </section>

    <!-- Testimonials / Video -->
    <section class="py-12 md:py-24 px-6 bg-gray-900 overflow-hidden">
        <h2 class="text-4xl text-center font-semibold mb-12">Testimonials</h2>
        <div class="w-full mt-12 sm:mt-16 md:mt-20 mx-auto mb-12">
            <video loop muted playsinline class="w-full max-w-2xl h-auto mx-auto rounded-xl shadow-xl border border-gray-700 cursor-pointer" autoplay>
                <source src="{{ asset('assets/videos/customer.mp4') }}" type="video/mp4"/>
                Your browser does not support video.
            </video>
        </div>
        <div class="max-w-4xl mx-auto grid grid-cols-1 gap-6">
            <div class="bg-gray-800 p-10 rounded-xl shadow-xl text-center">
                <p class="text-gray-300 italic text-lg">XpertVA helped scale my Amazon business beyond expectations. Their professionalism and deep understanding of eCommerce sets them apart.</p>
                <p class="text-gray-500 mt-3 text-sm">— Client Review</p>
            </div>
            <div class="bg-gray-800 p-10 rounded-xl shadow-xl text-center">
                <p class="text-gray-300 italic text-lg">Outstanding service! My Shopify store saw instant improvement. Highly recommend their VA team.</p>
                <p class="text-gray-500 mt-3 text-sm">— Client Review</p>
            </div>
        </div>
    </section>

    <!-- Career Openings -->
    <section class="py-12 md:py-24 px-6 max-w-5xl mx-auto">
        <h2 class="text-4xl font-semibold mb-12 text-center">Career Openings</h2>
        <div class="grid md:grid-cols-2 gap-10">
            @php
            $jobs = [
                ['title' => 'Senior Amazon VA', 'icon' => 'users', 'desc' => 'Looking for an experienced Amazon VA with deep expertise in Seller Central.'],
                ['title' => 'Web Developer (Shopify / Next.js)', 'icon' => 'code', 'desc' => 'Build world-class eCommerce websites for global clients.'],
                ['title' => 'Customer Support VA', 'icon' => 'headset', 'desc' => 'Provide outstanding support across Amazon, Walmart & Shopify.'],
                ['title' => 'Marketing Specialist', 'icon' => 'megaphone', 'desc' => 'Run data-driven campaigns and optimize digital marketing funnels.']
            ];
            @endphp
            @foreach($jobs as $job)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 hover:bg-gray-800 transition group">
                <h3 class="text-xl font-semibold mb-2 group-hover:text-blue-400 transition">{{ $job['title'] }}</h3>
                <p class="text-gray-400 text-sm mb-4">{{ $job['desc'] }}</p>
                <button class="flex items-center gap-2 text-blue-400 hover:underline">Apply Now <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg></button>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
