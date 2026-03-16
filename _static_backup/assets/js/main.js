document.addEventListener('DOMContentLoaded', () => {

    // --- Rotating Banner Titles ---
    const rotatingWords = ['BSR Optimization', 'Brand Awareness', 'Keyword Ranking', 'Market Places'];
    const rotatingSpan = document.querySelector('h1 .text-indigo-500');
    if (rotatingSpan) {
        let wordIndex = 0;
        setInterval(() => {
            wordIndex = (wordIndex + 1) % rotatingWords.length;
            rotatingSpan.style.opacity = '0';
            setTimeout(() => {
                rotatingSpan.textContent = rotatingWords[wordIndex];
                rotatingSpan.style.opacity = '1';
            }, 400);
        }, 2000);
    }

    // --- Create / Collaborate / Disrupt hover bg image ---
    const ccdSection = document.querySelector('.transition-all.duration-700.w-full.bg-cover');
    if (ccdSection) {
        const isHome = !window.location.pathname.includes('/work/') &&
            !window.location.pathname.includes('/services/') &&
            !window.location.pathname.includes('/team/');
        if (isHome) {
            const bgBase = window.location.pathname.includes('/index.html') || window.location.pathname.endsWith('/xpertva/') || window.location.pathname.endsWith('/xpertva') ? '' : '';
            const prefix = window.location.pathname.includes('/xpertva/') || document.querySelector('link[href="assets/css/main.css"]') ? 'assets/' : '../assets/';
            const rows = ccdSection.querySelectorAll('.min-h-64');
            const bgImages = [
                prefix + 'images/bg-work.jpg',
                prefix + 'images/bg-services.jpg',
                prefix + 'images/bg-call.jpg'
            ];
            rows.forEach((row, i) => {
                row.addEventListener('mouseenter', () => {
                    ccdSection.style.backgroundImage = `url('${bgImages[i % bgImages.length]}')`;
                    ccdSection.style.backgroundSize = 'cover';
                    ccdSection.style.backgroundPosition = 'center';
                    const h2 = row.querySelector('h2');
                    if (h2) {
                        h2.style.transform = 'translateX(0)';
                        h2.style.opacity = '1';
                    }
                });
                row.addEventListener('mouseleave', () => {
                    ccdSection.style.backgroundImage = '';
                    const h2 = row.querySelector('h2');
                    if (h2) {
                        h2.style.transform = 'translateX(-40px)';
                        h2.style.opacity = '0.5';
                    }
                });
            });
        }
    }

    // --- Header & Modals Logic ---
    const header = document.querySelector('header');
    const logoContainer = header?.querySelector('.translate-x-2');
    const touchButton = header?.querySelector('.hidden.md\\:block');
    const floatingButtons = document.querySelectorAll('.fixed.bottom-4');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            header?.classList.remove('py-6');
            header?.classList.add('py-2', 'bg-transparent');
            if (logoContainer) {
                logoContainer.classList.remove('translate-x-2');
                logoContainer.classList.add('translate-x-0');
            }
            if (touchButton) {
                touchButton.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                touchButton.classList.remove('opacity-100', 'scale-100');
            }
            floatingButtons.forEach(btn => btn.classList.remove('hidden'));
        } else {
            header?.classList.add('py-6');
            header?.classList.remove('py-2');
            if (logoContainer) {
                logoContainer.classList.add('translate-x-2');
                logoContainer.classList.remove('translate-x-0');
            }
            if (touchButton) {
                touchButton.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                touchButton.classList.add('opacity-100', 'scale-100');
            }
            floatingButtons.forEach(btn => btn.classList.add('hidden'));
        }
    });

    // Modals
    const menuModal = document.getElementById('menu-modal');
    const contactModal = document.getElementById('contact-modal');
    const auditModal = document.getElementById('audit-modal');

    // Hamburger button — uses the id we injected
    const menuBtn = document.getElementById('hamburger-btn');
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            if (menuModal) menuModal.classList.remove('hidden');
        });
    }

    // Contact & Audit buttons
    document.querySelectorAll('button').forEach(btn => {
        const text = btn.textContent.trim();
        if (text.includes('Get in touch')) {
            btn.addEventListener('click', () => {
                if (contactModal) contactModal.classList.remove('hidden');
            });
        }
        if (text.includes('Request Free Audit')) {
            btn.addEventListener('click', () => {
                if (auditModal) auditModal.classList.remove('hidden');
            });
        }
    });

    // Close buttons
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const modal = e.target.closest('.fixed.inset-0.z-50') || e.target.closest('[id$="-modal"]');
            if (modal) modal.classList.add('hidden');
        });
    });

    // Close on Escape
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            [menuModal, contactModal, auditModal].forEach(modal => {
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                }
            });
        }
    });

    // --- Testimonials Slider Logic ---
    const testimonials = [
        { quote: "It would be great to say that XpertVA really deserves 5 Stars. I am selling on multiple sales channels, I was also busy with my wholesale shop so I hired XpertVA to manage e-commerce business and they done it amazingly. I truly recommend them.", name: "David Setareh", designation: "Recommended Xpert VA" },
        { quote: "5 Star service, very happy with Xpert VA and their team. They enable me to focus on growing my business with the assurance that my VA tasks are well taken care of.", name: "Abdul Basit Rafi", designation: "Recommended Xpert VA" },
        { quote: "They have a great team of experts helping in our Amazon PPC and Seller Central management. Very helpful, dedicated VAs. Highly recommended!", name: "Alyysa Noah", designation: "Recommended Xpert VA" },
        { quote: "Hello, I just wanted to say that I am VERY pleased with the quality of work that was delivered by Xpert VA. As an Amazon seller, branding is very important and Xpert VA helped me to take my listings to the next level with the EBC content they provided. I was impressed with the quality, the responsiveness and the natural talent that was displayed by my consultant Hussain. I will certainly reach out to XpertVA for future projects!", name: "Chi Ele", designation: "Recommended Xpert VA" },
        { quote: "We run a small home & kitchen brand and I was completely overwhelmed with Amazon. XpertVA stepped in and took over listings, images, and backend clean-up. They also tuned our PPC so we weren't wasting money on random clicks. Sales are up and my stress is down – I'm sticking with XpertVA long term.", name: "Timothy", designation: "Home & Kitchen Brand" },
        { quote: "As a supplements seller, compliance and branding are everything. XpertVA helped me refine my A+ content, optimize keywords, and keep my listings clean and on-brand. Whenever there's an issue, Ali Zaidi and his team jump on a call and sort it quickly. I genuinely feel like I have an in-house Amazon department now.", name: "Thiago Monteiro", designation: "Nutritional Supplements" },
        { quote: "We sell consumer electronics and the competition on Amazon is brutal. XpertVA rebuilt our listings, set up structured campaigns for Amazon PPC management, and started tracking the numbers properly. Within a few months our ACOS dropped and we're ranking on page one for several key terms. Couldn't have done it without them.", name: "Martin Doherty", designation: "Electronics & Gadgets" },
        { quote: "I run a growing apparel line and didn't have time to babysit Seller Central. XpertVA now handles uploads, size variations, stock updates – all of it. They're responsive on WhatsApp, send clear reports, and catch issues before I do. It feels like having a reliable operations partner inside Amazon.", name: "Tony Kath", designation: "Apparel Brand" },
        { quote: "For my skincare brand, presentation is everything. XpertVA helped with keyword-rich titles, bullet points, and beautiful A+ layouts that still followed Amazon rules. They understand the beauty niche and how customers read listings. Since working with them, our conversion rate has clearly improved.", name: "Aina Walid", designation: "Beauty & Skincare" },
        { quote: "We sell outdoor and fitness gear and our catalog is fairly technical. XpertVA took the time to understand the products, rewrite the copy, and organize variations properly. They manage reviews, questions, and basic support so I can focus on sourcing. Solid, dependable team.", name: "Marcu Walidsper", designation: "Fitness & Outdoors" },
        { quote: "My home décor brand was stuck with low impressions and almost no organic sales. XpertVA reworked my listings, suggested better images, and helped with small but important backend fixes. The difference in traffic and sales is very noticeable. I'm very happy with their work.", name: "Veronica", designation: "Home Décor" },
        { quote: "We're in the tools/hardware space and accuracy matters. XpertVA cleaned up our specs, fixed variations, and made sure everything matched our packaging. They handle flat files, case logs, and random Amazon headaches so I don't have to. Highly recommend them for any serious seller.", name: "John Walter", designation: "Tools & Hardware" },
        { quote: "I've tried a few 'Amazon experts' before, but XpertVA is the first team that actually understood numbers and strategy. They're careful with bids, track keyword performance, and always come back with suggestions instead of just waiting for instructions. Great support for our electronics brand.", name: "Steven Gao", designation: "Private Label Electronics" },
        { quote: "I sell fashion accessories and I'm not very technical with Amazon. Ali Zaidi and the XpertVA team walked me through everything, then took over the day-to-day work. They keep my catalog organized, run promos, and send clear weekly updates. It's been a huge relief having them on board.", name: "Harleen Gupta", designation: "Fashion Accessories" },
        { quote: "Our pet products brand was burning cash on ads before XpertVA came in. Ali and his PPC team restructured our Amazon PPC management, killed useless keywords, and scaled the ones that actually convert. We finally have profitable campaigns and consistent sales instead of guesswork.", name: "Jeremy Weart", designation: "Pet Products (PPC Focus)" },
        { quote: "I use Amazon mainly to support my coaching and content brand. XpertVA set everything up – from book listings to backend keywords and reporting. Ali Zaidi personally checked in several times to make sure everything aligned with my brand. Great team, super easy to work with.", name: "Law Payne", designation: "Coaching / Digital Products" },
        { quote: "In the baby products niche you can't afford mistakes. XpertVA helped with listing compliance, keywords, and organizing variations in a way that parents actually understand. They handle the routine tasks quietly in the background and send reports that make sense. I feel very safe with them managing my account.", name: "Monique Mancilla", designation: "Baby Products" },
        { quote: "I was juggling multiple health & wellness SKUs and constantly falling behind on Amazon tasks. XpertVA took over catalog management, audits, and SEO updates. They're methodical, polite, and always on time. My store finally feels under control.", name: "Meena Visht", designation: "Health & Wellness" },
        { quote: "As an author and educator, I wanted my books to be easy to find and professionally presented. XpertVA optimized my listings, categories, and backend keywords, and even helped with small design suggestions. The visibility and steady sales growth speak for themselves.", name: "John Rowbotham", designation: "Books & Education" },
        { quote: "We sell across several European marketplaces and the complexity was getting out of hand. XpertVA helped us standardize listings, localize content, and manage inventory across regions. Communication is smooth and they understand the nuances of the EU platforms very well.", name: "Yannick De Ridder", designation: "EU Marketplaces" },
        { quote: "I work with bundles and subscription-style beauty boxes. XpertVA structured my variations, cleaned up the titles, and helped position the value clearly for shoppers. They're creative, fast, and they actually care about the brand.", name: "Amanda Lewis", designation: "Beauty Subscription / Bundles" },
        { quote: "My brand is more on the handmade, lifestyle side, and I was worried an agency wouldn't 'get' it. XpertVA surprised me. They kept the authentic tone of my brand while still optimizing for search and conversions. Their balance between art and algorithm is impressive.", name: "Kerri Fox", designation: "Handmade / Lifestyle" },
        { quote: "Automotive accessories come with lots of compatibility questions. XpertVA organized our bullet points, added the right details, and set up a system to handle customer questions quickly. Our return rate dropped and reviews improved. Really glad I partnered with them.", name: "Tim Scott", designation: "Automotive Accessories" },
        { quote: "In the tech gadgets niche, PPC can make or break you. XpertVA rebuilt our campaigns from scratch, grouped keywords intelligently, and monitored bids closely. Our ad spend is finally under control and we're scaling winning products properly.", name: "Rezwan Kabir", designation: "Tech & Gadgets (PPC Focus)" },
        { quote: "I use Amazon as an additional channel for my professional services and publications. XpertVA set up a clean, credible presence that matches my brand. They're organized, responsive, and respectful of my time – exactly what I need from a VA team.", name: "Carl Schlacher", designation: "Professional / Consulting Brand" },
        { quote: "For our camping brand, seasonality is everything. XpertVA helped plan promos around peak months, fixed our content, and made sure inventory and listings were ready ahead of time. They think ahead instead of just reacting, which I really appreciate.", name: "Ernest Morales", designation: "Outdoor & Camping" },
        { quote: "We're scaling a lifestyle apparel brand and needed structured support. XpertVA took over catalog uploads, flat files, and ongoing optimization. They're reliable, friendly, and comfortable working with a fast-moving team. Strongly recommended.", name: "Dean Wegner", designation: "Apparel / Lifestyle" },
        { quote: "I run a supplements brand and was very cautious about who to trust with my Amazon account. XpertVA, led by Ali Zaidi, has been excellent – they understand compliance, positioning, and reviews management. Their mix of strategy and execution is exactly what I needed.", name: "Kenneth Byra", designation: "Supplements" },
        { quote: "My hair care line was already doing okay, but I knew it could do better on Amazon. XpertVA refreshed the images, improved the copy, and set up deals that actually moved stock. They're creative but still very data-driven, which I love.", name: "Keshia Horton", designation: "Hair & Beauty" },
        { quote: "Home improvement products are detail-heavy, and XpertVA handled that really well. They made sure specs, measurements, and compatibility info were crystal clear. We've seen fewer returns and better reviews since they took over.", name: "Uduka Prince", designation: "Home Improvement" },
        { quote: "For our sports gear brand, Ali Zaidi and the XpertVA team have been more like partners than VAs. They rebuilt our Amazon PPC structure, fixed messy listings, and constantly bring new ideas to test. Revenue is up and we finally have a clear growth plan.", name: "Chris Thompson", designation: "Sports & Fitness (PPC)" },
        { quote: "Selling electronics in Europe means tight margins and tough competition. XpertVA helped us refine our content and dial in PPC so we weren't burning cash on broad, irrelevant terms. Their regular reports and suggestions make decision-making simple.", name: "Haci Sahin", designation: "EU Electronics (PPC)" },
        { quote: "I sell premium kitchenware and needed the listings to match the quality of the products. XpertVA delivered exactly that – clean, elegant listings, better keywords, and organized variations. The brand now looks and performs the way I always wanted.", name: "Alina Wittling", designation: "Kitchenware" },
        { quote: "My home & living brand felt invisible on Amazon before working with XpertVA. They focused on SEO, images, and small conversion tweaks that made a big difference. I feel supported, informed, and genuinely looked after by their team.", name: "Nanlika Wit", designation: "Home & Living" },
    ];

    const testimonialContainer = document.getElementById('testimonial-container');
    const testimonialText = document.getElementById('testimonial-text');
    const quoteEl = document.getElementById('testimonial-quote');
    const nameEl = document.getElementById('testimonial-name');
    const designationEl = document.getElementById('testimonial-designation');

    if (testimonialContainer && quoteEl && nameEl && designationEl) {
        let currentIndex = 0;

        const updateTestimonial = () => {
            const item = testimonials[currentIndex];

            // Fade out
            if (testimonialText) testimonialText.style.opacity = '0';
            const videoContainer = testimonialContainer.querySelector('.video-container');
            if (videoContainer) videoContainer.style.opacity = '0';

            setTimeout(() => {
                quoteEl.textContent = `\u201C${item.quote}\u201D`;
                nameEl.textContent = item.name;
                designationEl.textContent = item.designation;

                // Handle video
                if (item.video) {
                    let vidDiv = testimonialContainer.querySelector('.video-container');
                    if (!vidDiv) {
                        vidDiv = document.createElement('div');
                        vidDiv.className = 'video-container md:w-1/2 transition-opacity duration-500 w-full';
                        vidDiv.innerHTML = `<video src="${item.video}" controls class="rounded-md w-full h-auto aspect-video object-cover"></video>`;
                        testimonialContainer.appendChild(vidDiv);
                    } else {
                        const vid = vidDiv.querySelector('video');
                        if (vid) vid.src = item.video;
                    }
                    requestAnimationFrame(() => { if (vidDiv) vidDiv.style.opacity = '1'; });
                } else {
                    const vidDiv = testimonialContainer.querySelector('.video-container');
                    if (vidDiv) vidDiv.remove();
                }

                // Fade in text
                if (testimonialText) testimonialText.style.opacity = '1';
            }, 500);
        };

        setInterval(() => {
            currentIndex = (currentIndex + 1) % testimonials.length;
            updateTestimonial();
        }, 6000);
    }

    // --- Portfolio Category Filtering ---
    const categoryButtons = document.querySelectorAll('.category-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    const categoryBar = document.getElementById('category-bar');
    const scrollLeftBtn = document.getElementById('cat-scroll-left');
    const scrollRightBtn = document.getElementById('cat-scroll-right');

    if (categoryButtons.length > 0 && portfolioItems.length > 0) {
        categoryButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const selected = btn.getAttribute('data-category');

                // Update active button style
                categoryButtons.forEach(b => {
                    b.classList.remove('border-white', 'text-white');
                    b.classList.add('border-transparent', 'text-gray-400');
                });
                btn.classList.remove('border-transparent', 'text-gray-400');
                btn.classList.add('border-white', 'text-white');

                // Filter portfolio items
                portfolioItems.forEach(item => {
                    const cat = item.getAttribute('data-category');
                    if (selected === 'All' || cat === selected) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // Category bar arrow scrolling
    if (scrollLeftBtn && categoryBar) {
        scrollLeftBtn.addEventListener('click', () => {
            categoryBar.scrollBy({ left: -200, behavior: 'smooth' });
        });
    }
    if (scrollRightBtn && categoryBar) {
        scrollRightBtn.addEventListener('click', () => {
            categoryBar.scrollBy({ left: 200, behavior: 'smooth' });
        });
    }
});
