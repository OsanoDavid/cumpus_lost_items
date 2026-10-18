<!-- Kisii University Accessibility Floating Widget & Options Drawer -->
<div id="accessibilityContainer">
    <!-- Floating Trigger Button -->
    <button id="accessibilityToggleBtn" onclick="toggleAccessibilityMenu()" 
            class="fixed bottom-6 right-6 z-[9990] flex items-center gap-2.5 bg-emerald-900/95 hover:bg-emerald-800 text-white font-bold px-4 py-3 rounded-full shadow-2xl border border-emerald-400/50 hover:border-emerald-300 hover:scale-105 active:scale-95 transition-all duration-200 cursor-pointer backdrop-blur-md group" 
            aria-label="Open Accessibility Tools" title="Accessibility Tools">
        <span class="w-7 h-7 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-200 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-universal-access text-base"></i>
        </span>
        <span class="text-xs tracking-wide font-semibold pr-1">Accessibility</span>
    </button>

    <!-- Modal / Drawer Backdrop -->
    <div id="accessibilityBackdrop" onclick="toggleAccessibilityMenu()" 
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-[9991] hidden opacity-0 transition-opacity duration-300"></div>

    <!-- Accessibility Control Panel Drawer -->
    <div id="accessibilityDrawer" 
         class="fixed bottom-20 right-6 sm:bottom-24 sm:right-6 w-[92vw] max-w-sm bg-white rounded-3xl shadow-2xl border border-slate-200 z-[9992] hidden opacity-0 translate-y-4 transition-all duration-300 overflow-hidden text-slate-800">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-900 to-teal-900 text-white px-5 py-4 flex items-center justify-between border-b border-emerald-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-300">
                    <i class="fa-solid fa-universal-access text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold tracking-tight">Accessibility Tools</h3>
                    <p class="text-[10px] text-emerald-200/90 font-medium">Customize your viewing preferences</p>
                </div>
            </div>
            <button onclick="toggleAccessibilityMenu()" class="w-7 h-7 rounded-lg bg-emerald-800/80 hover:bg-emerald-700 text-emerald-200 flex items-center justify-center text-xs transition" aria-label="Close accessibility menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Options Body -->
        <div class="p-5 space-y-4 max-h-[70vh] overflow-y-auto text-xs">
            
            <!-- 1. Text Sizing -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-text-height text-emerald-600"></i> Text Size
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="setTextSize('normal')" id="btnTextNormal" 
                            class="px-3 py-2 rounded-xl border border-slate-200 font-semibold hover:border-emerald-500 text-center transition">
                        A <span class="text-[10px] text-slate-400 block font-normal">Default</span>
                    </button>
                    <button type="button" onclick="setTextSize('large')" id="btnTextLarge" 
                            class="px-3 py-2 rounded-xl border border-slate-200 font-semibold hover:border-emerald-500 text-center transition text-sm">
                        A+ <span class="text-[10px] text-slate-400 block font-normal">Large</span>
                    </button>
                    <button type="button" onclick="setTextSize('xlarge')" id="btnTextXLarge" 
                            class="px-3 py-2 rounded-xl border border-slate-200 font-semibold hover:border-emerald-500 text-center transition text-base font-bold">
                        A++ <span class="text-[10px] text-slate-400 block font-normal">X-Large</span>
                    </button>
                </div>
            </div>

            <!-- 2. High Contrast Mode Toggle -->
            <div class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 bg-slate-50/70 hover:bg-slate-50 transition">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-circle-half-stroke"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">High Contrast Mode</div>
                        <div class="text-[10px] text-slate-500">Dark background with vivid text</div>
                    </div>
                </div>
                <button type="button" onclick="toggleContrast()" id="btnContrastToggle" 
                        class="w-11 h-6 rounded-full bg-slate-300 p-0.5 transition duration-200 flex items-center" 
                        aria-pressed="false">
                    <div class="w-5 h-5 rounded-full bg-white shadow-md transform transition-transform duration-200" id="contrastKnob"></div>
                </button>
            </div>

            <!-- 3. Dyslexia-Friendly Font -->
            <div class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 bg-slate-50/70 hover:bg-slate-50 transition">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-font"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Dyslexia-Friendly Font</div>
                        <div class="text-[10px] text-slate-500">High-legibility spacious typography</div>
                    </div>
                </div>
                <button type="button" onclick="toggleDyslexiaFont()" id="btnDyslexiaToggle" 
                        class="w-11 h-6 rounded-full bg-slate-300 p-0.5 transition duration-200 flex items-center" 
                        aria-pressed="false">
                    <div class="w-5 h-5 rounded-full bg-white shadow-md transform transition-transform duration-200" id="dyslexiaKnob"></div>
                </button>
            </div>

            <!-- 4. Underline Links -->
            <div class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 bg-slate-50/70 hover:bg-slate-50 transition">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-link"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Underline Links</div>
                        <div class="text-[10px] text-slate-500">Highlight all clickable navigation links</div>
                    </div>
                </div>
                <button type="button" onclick="toggleUnderlineLinks()" id="btnUnderlineToggle" 
                        class="w-11 h-6 rounded-full bg-slate-300 p-0.5 transition duration-200 flex items-center" 
                        aria-pressed="false">
                    <div class="w-5 h-5 rounded-full bg-white shadow-md transform transition-transform duration-200" id="underlineKnob"></div>
                </button>
            </div>

            <!-- 5. Big Cursor -->
            <div class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 bg-slate-50/70 hover:bg-slate-50 transition">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-arrow-pointer"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Enlarged Cursor</div>
                        <div class="text-[10px] text-slate-500">Larger cursor for easier tracking</div>
                    </div>
                </div>
                <button type="button" onclick="toggleBigCursor()" id="btnCursorToggle" 
                        class="w-11 h-6 rounded-full bg-slate-300 p-0.5 transition duration-200 flex items-center" 
                        aria-pressed="false">
                    <div class="w-5 h-5 rounded-full bg-white shadow-md transform transition-transform duration-200" id="cursorKnob"></div>
                </button>
            </div>

            <!-- Reset Button -->
            <div class="pt-2">
                <button type="button" onclick="resetAccessibility()" 
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-rotate-left text-xs"></i>
                    <span>Reset to Default Settings</span>
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Accessibility CSS Classes -->
<style>
    /* Font Size Scalers */
    html.text-size-large {
        font-size: 112% !important;
    }
    html.text-size-xlarge {
        font-size: 125% !important;
    }

    /* High Contrast Mode */
    html.high-contrast {
        filter: contrast(125%) !important;
    }
    html.high-contrast body {
        background-color: #020617 !important;
        color: #f8fafc !important;
    }
    html.high-contrast a {
        color: #38bdf8 !important;
        text-decoration: underline !important;
    }
    html.high-contrast .bg-white {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }
    html.high-contrast .bg-slate-50 {
        background-color: #020617 !important;
    }
    html.high-contrast .text-slate-900,
    html.high-contrast .text-gray-900 {
        color: #ffffff !important;
    }
    html.high-contrast .text-slate-600,
    html.high-contrast .text-slate-500,
    html.high-contrast .text-gray-500 {
        color: #cbd5e1 !important;
    }

    /* Dyslexia-Friendly Typography */
    html.dyslexia-font,
    html.dyslexia-font * {
        font-family: 'Comic Sans MS', 'Trebuchet MS', 'Verdana', sans-serif !important;
        letter-spacing: 0.05em !important;
        word-spacing: 0.1em !important;
        line-height: 1.7 !important;
    }

    /* Underline Links */
    html.underline-links a {
        text-decoration: underline !important;
        text-underline-offset: 3px !important;
    }

    /* Big Cursor */
    html.big-cursor,
    html.big-cursor * {
        cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 24 24' fill='%23064e3b' stroke='%23ffffff' stroke-width='2'%3E%3Cpath d='M3 3l7 18 3-7 7-3L3 3z'/%3E%3C/svg%3E"), auto !important;
    }
</style>

<!-- Accessibility Script with LocalStorage Persistence -->
<script>
    (function() {
        const drawer = document.getElementById('accessibilityDrawer');
        const backdrop = document.getElementById('accessibilityBackdrop');

        window.toggleAccessibilityMenu = function() {
            if (!drawer || !backdrop) return;
            const isHidden = drawer.classList.contains('hidden');
            if (isHidden) {
                drawer.classList.remove('hidden');
                backdrop.classList.remove('hidden');
                setTimeout(() => {
                    drawer.classList.remove('opacity-0', 'translate-y-4');
                    backdrop.classList.remove('opacity-0');
                }, 10);
            } else {
                drawer.classList.add('opacity-0', 'translate-y-4');
                backdrop.classList.add('opacity-0');
                setTimeout(() => {
                    drawer.classList.add('hidden');
                    backdrop.classList.add('hidden');
                }, 250);
            }
        };

        window.setTextSize = function(size) {
            const html = document.documentElement;
            html.classList.remove('text-size-large', 'text-size-xlarge');
            if (size === 'large') html.classList.add('text-size-large');
            if (size === 'xlarge') html.classList.add('text-size-xlarge');
            localStorage.setItem('a11y_text_size', size);
            updateButtonStyles();
        };

        window.toggleContrast = function() {
            const html = document.documentElement;
            const enabled = html.classList.toggle('high-contrast');
            localStorage.setItem('a11y_contrast', enabled ? '1' : '0');
            updateToggleVisual('btnContrastToggle', 'contrastKnob', enabled);
        };

        window.toggleDyslexiaFont = function() {
            const html = document.documentElement;
            const enabled = html.classList.toggle('dyslexia-font');
            localStorage.setItem('a11y_dyslexia', enabled ? '1' : '0');
            updateToggleVisual('btnDyslexiaToggle', 'dyslexiaKnob', enabled);
        };

        window.toggleUnderlineLinks = function() {
            const html = document.documentElement;
            const enabled = html.classList.toggle('underline-links');
            localStorage.setItem('a11y_underline', enabled ? '1' : '0');
            updateToggleVisual('btnUnderlineToggle', 'underlineKnob', enabled);
        };

        window.toggleBigCursor = function() {
            const html = document.documentElement;
            const enabled = html.classList.toggle('big-cursor');
            localStorage.setItem('a11y_cursor', enabled ? '1' : '0');
            updateToggleVisual('btnCursorToggle', 'cursorKnob', enabled);
        };

        window.resetAccessibility = function() {
            const html = document.documentElement;
            html.classList.remove('text-size-large', 'text-size-xlarge', 'high-contrast', 'dyslexia-font', 'underline-links', 'big-cursor');
            localStorage.removeItem('a11y_text_size');
            localStorage.removeItem('a11y_contrast');
            localStorage.removeItem('a11y_dyslexia');
            localStorage.removeItem('a11y_underline');
            localStorage.removeItem('a11y_cursor');
            updateButtonStyles();
            updateToggleVisual('btnContrastToggle', 'contrastKnob', false);
            updateToggleVisual('btnDyslexiaToggle', 'dyslexiaKnob', false);
            updateToggleVisual('btnUnderlineToggle', 'underlineKnob', false);
            updateToggleVisual('btnCursorToggle', 'cursorKnob', false);
        };

        function updateToggleVisual(btnId, knobId, active) {
            const btn = document.getElementById(btnId);
            const knob = document.getElementById(knobId);
            if (!btn || !knob) return;
            if (active) {
                btn.classList.remove('bg-slate-300');
                btn.classList.add('bg-emerald-600');
                knob.classList.add('translate-x-5');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('bg-emerald-600');
                btn.classList.add('bg-slate-300');
                knob.classList.remove('translate-x-5');
                btn.setAttribute('aria-pressed', 'false');
            }
        }

        function updateButtonStyles() {
            const size = localStorage.getItem('a11y_text_size') || 'normal';
            ['normal', 'large', 'xlarge'].forEach(s => {
                const b = document.getElementById('btnText' + s.charAt(0).toUpperCase() + s.slice(1));
                if (b) {
                    if (s === size) {
                        b.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-900', 'font-bold');
                        b.classList.remove('border-slate-200');
                    } else {
                        b.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-900', 'font-bold');
                        b.classList.add('border-slate-200');
                    }
                }
            });
        }

        // Apply saved preferences on load
        document.addEventListener('DOMContentLoaded', function() {
            const textSize = localStorage.getItem('a11y_text_size');
            if (textSize) setTextSize(textSize);

            const contrast = localStorage.getItem('a11y_contrast') === '1';
            if (contrast) {
                document.documentElement.classList.add('high-contrast');
                updateToggleVisual('btnContrastToggle', 'contrastKnob', true);
            }

            const dyslexia = localStorage.getItem('a11y_dyslexia') === '1';
            if (dyslexia) {
                document.documentElement.classList.add('dyslexia-font');
                updateToggleVisual('btnDyslexiaToggle', 'dyslexiaKnob', true);
            }

            const underline = localStorage.getItem('a11y_underline') === '1';
            if (underline) {
                document.documentElement.classList.add('underline-links');
                updateToggleVisual('btnUnderlineToggle', 'underlineKnob', true);
            }

            const cursor = localStorage.getItem('a11y_cursor') === '1';
            if (cursor) {
                document.documentElement.classList.add('big-cursor');
                updateToggleVisual('btnCursorToggle', 'cursorKnob', true);
            }

            updateButtonStyles();
        });
    })();
</script>
