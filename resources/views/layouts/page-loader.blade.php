<!-- Kisii University Global Page Navigation Spinner & Progress Bar -->
<div id="topProgressBar" class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-amber-400 z-[10000] w-0 transition-all duration-300 opacity-0 pointer-events-none"></div>

<div id="globalPageSpinner" class="fixed inset-0 bg-slate-950/45 backdrop-blur-[2px] z-[9999] hidden opacity-0 transition-opacity duration-200 items-center justify-center pointer-events-auto">
    <div class="bg-white/95 backdrop-blur-md px-5 py-4 rounded-2xl shadow-2xl border border-emerald-600/30 flex items-center gap-3.5 transform scale-95 transition-transform duration-200">
        <div class="relative w-9 h-9 flex items-center justify-center shrink-0">
            <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii Logo" class="w-5 h-5 object-contain z-10">
            <i class="fa-solid fa-circle-notch fa-spin text-emerald-700 text-3xl absolute inset-0 flex items-center justify-center"></i>
        </div>
        <div>
            <div class="text-xs font-extrabold text-slate-900 tracking-tight">Kisii University Portal</div>
            <div class="text-[10px] text-emerald-700 font-semibold flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Loading destination...</span>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const progressBar = document.getElementById('topProgressBar');
        const spinner = document.getElementById('globalPageSpinner');

        function showLoader() {
            if (progressBar) {
                progressBar.classList.remove('opacity-0');
                progressBar.style.width = '65%';
            }
            if (spinner) {
                spinner.classList.remove('hidden');
                setTimeout(() => {
                    spinner.classList.remove('opacity-0');
                    const card = spinner.querySelector('div');
                    if (card) card.classList.remove('scale-95');
                }, 10);
            }
        }

        function hideLoader() {
            if (progressBar) {
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBar.classList.add('opacity-0');
                    progressBar.style.width = '0%';
                }, 200);
            }
            if (spinner) {
                spinner.classList.add('opacity-0');
                const card = spinner.querySelector('div');
                if (card) card.classList.add('scale-95');
                setTimeout(() => {
                    spinner.classList.add('hidden');
                }, 200);
            }
        }

        // Intercept internal link clicks
        document.addEventListener('click', function(e) {
            const anchor = e.target.closest('a');
            if (!anchor) return;
            const href = anchor.getAttribute('href');
            const target = anchor.getAttribute('target');

            // Skip anchor links, javascript, blank, tel, mailto, etc.
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:') || target === '_blank') {
                return;
            }

            // If same origin
            try {
                const url = new URL(anchor.href, window.location.origin);
                if (url.origin === window.location.origin && url.pathname !== window.location.pathname) {
                    showLoader();
                }
            } catch(err) {
                // Ignore parse errors
            }
        });

        // Intercept form submissions (e.g. login, register, search)
        document.addEventListener('submit', function(e) {
            // Check if form is valid before showing loader
            const form = e.target;
            if (form && !form.hasAttribute('data-no-loader')) {
                showLoader();
            }
        });

        // Hide loader when navigating back or forward or loaded with smooth slow landing effect
        function landPageSmoothly() {
            hideLoader();
            const mainContent = document.querySelector('main') || document.querySelector('.page-content') || document.body;
            if (mainContent && !mainContent.classList.contains('page-landing-enter')) {
                mainContent.classList.add('page-landing-enter');
            }
        }

        window.addEventListener('pageshow', landPageSmoothly);
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(landPageSmoothly, 60);
        } else {
            document.addEventListener('DOMContentLoaded', landPageSmoothly);
        }
    })();
</script>

<style>
    /* Slow, elegant landing animation with delayed reveal */
    @keyframes pageLandSlowly {
        0% {
            opacity: 0;
            transform: translateY(18px);
            filter: blur(1.5px);
        }
        50% {
            opacity: 0.8;
            filter: blur(0.5px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
    }

    .page-landing-enter {
        animation: pageLandSlowly 0.85s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .delay-land-1 { animation: pageLandSlowly 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both; }
    .delay-land-2 { animation: pageLandSlowly 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.24s both; }
    .delay-land-3 { animation: pageLandSlowly 1.0s cubic-bezier(0.16, 1, 0.3, 1) 0.36s both; }
    .delay-land-4 { animation: pageLandSlowly 1.05s cubic-bezier(0.16, 1, 0.3, 1) 0.48s both; }
</style>
