/* ============================================
   VEEPING - INTERACTIVE SCRIPTS
   ============================================ */

(function() {
    'use strict';

    /* ---------- دسترس‌پذیری: اطمینان از داشتن label برای همه select ها ---------- */
    /* برخی select های تولیدشده توسط هسته ووکامرس (مثلاً دراپ‌داون انتخاب متغیر محصول)
       ممکن است label مرتبط نداشته باشند؛ این تابع به‌صورت دفاعی aria-label مناسب اضافه می‌کند */
    function veepingFixSelectLabels() {
        document.querySelectorAll('select').forEach((select) => {
            if (select.getAttribute('aria-label') || select.getAttribute('aria-labelledby')) return;
            if (select.id) {
                const linkedLabel = document.querySelector('label[for="' + CSS.escape(select.id) + '"]');
                if (linkedLabel && linkedLabel.textContent.trim()) return;
            }
            // به دنبال یک label نزدیک (والد یا خواهر/برادر قبلی) بگرد
            const wrapper = select.closest('tr, .form-row, div');
            let labelText = '';
            if (wrapper) {
                const nearbyLabel = wrapper.querySelector('label');
                if (nearbyLabel) labelText = nearbyLabel.textContent.trim();
            }
            if (!labelText && select.name) {
                labelText = select.name.replace(/^attribute_(pa_)?/, '').replace(/[-_]/g, ' ');
            }
            select.setAttribute('aria-label', labelText || 'انتخاب گزینه');
        });
    }

    /* ---------- لودر صفحه ---------- */
    window.addEventListener('load', () => {
        const loader = document.querySelector('.page-loader');
        if (loader) {
            setTimeout(() => loader.classList.add('hidden'), 300);
        }
        veepingFixSelectLabels();
    });
    document.addEventListener('DOMContentLoaded', veepingFixSelectLabels);
    // فرم انتخاب متغیر محصول به‌صورت AJAX توسط ووکامرس بازسازی می‌شود
    document.body.addEventListener('woocommerce_variation_form_init', veepingFixSelectLabels);
    document.body.addEventListener('reset_data', veepingFixSelectLabels);

    /* ---------- Intersection Observer برای انیمیشن‌های ورود ---------- */
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
        revealObserver.observe(el);
    });

    /* ---------- شمارنده متحرک ---------- */
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseFloat(counter.dataset.target);
                const suffix = counter.dataset.suffix || '';
                const duration = 2000;
                const start = performance.now();

                const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);

                const update = (now) => {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    const value = (target * easeOutQuart(progress));
                    const display = Number.isInteger(target) ? Math.floor(value) : value.toFixed(1);
                    counter.textContent = display + suffix;
                    if (progress < 1) requestAnimationFrame(update);
                    else counter.textContent = (Number.isInteger(target) ? target : target.toFixed(1)) + suffix;
                };
                requestAnimationFrame(update);
                counterObserver.unobserve(counter);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.counter').forEach(c => counterObserver.observe(c));

    /* ---------- افکت مغناطیسی دکمه‌ها ---------- */
    document.querySelectorAll('.magnetic-btn').forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = '';
        });
    });

    /* ---------- افکت 3D Tilt روی کارت‌ها ---------- */
    document.querySelectorAll('.card-3d').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width;
            const y = (e.clientY - rect.top) / rect.height;
            const rotateX = (y - 0.5) * -10;
            const rotateY = (x - 0.5) * 10;
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
        });
    });

    /* ---------- ریپل دکمه‌ها ---------- */
    document.querySelectorAll('.btn-ripple').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    /* ---------- ایجاد پارتیکل‌های پویا در Hero ---------- */
    /* با requestIdleCallback به تعویق می‌افتد و با DocumentFragment یکجا درج می‌شود
       تا از long main-thread task در بارگذاری اولیه صفحه جلوگیری شود */
    const particlesContainer = document.querySelector('.particles-container');
    if (particlesContainer) {
        const createParticles = () => {
            const particleCount = window.innerWidth < 768 ? 12 : 30;
            const fragment = document.createDocumentFragment();
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 4 + 1;
                particle.style.width = particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                particle.style.animationDelay = (Math.random() * 5) + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.3;
                fragment.appendChild(particle);
            }
            particlesContainer.appendChild(fragment);
        };

        if ('requestIdleCallback' in window) {
            requestIdleCallback(createParticles, { timeout: 2000 });
        } else {
            setTimeout(createParticles, 200);
        }
    }

    /* ---------- دنبال کردن ماوس با گرادینت ---------- */
    const cursorGlow = document.querySelector('.cursor-glow');
    if (cursorGlow && window.innerWidth > 768) {
        document.addEventListener('mousemove', (e) => {
            cursorGlow.style.left = e.clientX + 'px';
            cursorGlow.style.top  = e.clientY + 'px';
        });
    }

    /* ---------- پارالاکس ساده ---------- */
    const parallaxItems = document.querySelectorAll('[data-parallax]');
    if (parallaxItems.length && window.innerWidth > 768) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            parallaxItems.forEach(item => {
                const speed = parseFloat(item.dataset.parallax) || 0.3;
                item.style.transform = `translateY(${scrolled * speed}px)`;
            });
        }, { passive: true });
    }

    /* ---------- Navbar شفاف در اسکرول ---------- */
    const navbar = document.querySelector('.site-navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }, { passive: true });
    }

    /* ---------- منو فعال بر اساس اسکرول ---------- */
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link-magic');
    if (sections.length && navLinks.length) {
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const top = section.offsetTop - 100;
                if (window.scrollY >= top) current = section.id;
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        }, { passive: true });
    }

    /* ---------- اسلایدر چرخشی (اختیاری) ---------- */
    const slider = document.querySelector('.testimonial-slider');
    if (slider) {
        const items = slider.querySelectorAll('.testimonial-item');
        if (items.length > 1) {
            let current = 0;
            setInterval(() => {
                items[current].classList.remove('active');
                current = (current + 1) % items.length;
                items[current].classList.add('active');
            }, 5000);
        }
    }

    /* ---------- کاروسل افقی پلن‌ها (صفحه اصلی) ---------- */
    window.veepingScrollCarousel = function (id, dir) {
        const el = document.getElementById(id);
        if (!el) return;
        const amount = el.clientWidth * 0.85;
        el.scrollBy({ left: -dir * amount, behavior: 'smooth' });
    };

    /* ---------- خرید سریع درجا (صفحه اصلی) ---------- */
    document.querySelectorAll('.quick-buy-block').forEach((block) => {
        const card = block.closest('.pricing-card');
        const buyBtn = card ? card.querySelector('.quick-buy-btn') : null;
        if (!buyBtn) {
            console.warn('veeping quick-buy: .quick-buy-btn not found for block', block);
            return;
        }

        const isVariable = block.dataset.variable === '1';
        const errorEl = block.querySelector('.quick-buy-error');
        const labelSpan = buyBtn.querySelector('.quick-buy-btn-label');
        const labelText = labelSpan ? labelSpan.querySelector('span') : null;
        const loadingSpan = buyBtn.querySelector('.quick-buy-btn-loading');

        function setError(message) {
            if (!errorEl) return;
            if (message) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            } else {
                errorEl.textContent = '';
                errorEl.classList.add('hidden');
            }
        }

        function setLoading(isLoading) {
            if (labelSpan) labelSpan.classList.toggle('hidden', isLoading);
            if (loadingSpan) {
                loadingSpan.classList.toggle('hidden', !isLoading);
                loadingSpan.classList.toggle('inline-flex', isLoading);
            }
        }

        if (isVariable) {
            let variations = [];
            try {
                variations = block.dataset.variations ? JSON.parse(block.dataset.variations) : [];
            } catch (e) {
                console.error('veeping quick-buy: could not parse variations data', e, block.dataset.variations);
                variations = [];
            }

            if (!variations.length) {
                console.warn('veeping quick-buy: no variations data found for product', block.dataset.productId);
            }

            const selects = Array.from(block.querySelectorAll('.quick-buy-attribute'));
            const priceEl = block.querySelector('.quick-buy-price');

            function refresh() {
                setError('');
                const selected = {};
                selects.forEach((s) => { selected[s.name] = s.value; });
                const allChosen = selects.every((s) => s.value !== '');

                if (!allChosen) {
                    if (priceEl) {
                        priceEl.className = 'quick-buy-price text-xl font-black text-gray-500';
                        priceEl.textContent = 'یک گزینه انتخاب کنید';
                    }
                    buyBtn.disabled = true;
                    buyBtn.dataset.variationId = '';
                    if (labelText) labelText.textContent = 'ابتدا گزینه را انتخاب کنید';
                    return;
                }

                const match = variations.find((v) =>
                    Object.keys(selected).every((key) => {
                        const vAttr = v.attributes ? v.attributes[key] : undefined;
                        return !vAttr || vAttr === selected[key];
                    })
                );

                if (!match) {
                    console.warn('veeping quick-buy: no matching variation for selection', selected, variations);
                }

                if (!match || !match.in_stock) {
                    if (priceEl) {
                        priceEl.className = 'quick-buy-price text-base font-bold text-red-400';
                        priceEl.textContent = 'این ترکیب موجود نیست';
                    }
                    buyBtn.disabled = true;
                    buyBtn.dataset.variationId = '';
                    if (labelText) labelText.textContent = 'ناموجود';
                    return;
                }

                if (priceEl) {
                    priceEl.className = 'quick-buy-price text-xl font-black fancy-text';
                    priceEl.innerHTML = match.price_html;
                }
                buyBtn.disabled = false;
                buyBtn.dataset.variationId = match.id;
                if (labelText) labelText.textContent = 'خرید پلن';
            }

            selects.forEach((s) => s.addEventListener('change', refresh));
            refresh();
        }

        buyBtn.addEventListener('click', function () {
            if (buyBtn.disabled) return;
            setError('');
            setLoading(true);
            buyBtn.disabled = true;

            const cfg = window.veepingQuickBuy || {};
            const formData = new FormData();
            formData.append('action', 'veeping_quick_buy');
            formData.append('nonce', cfg.nonce || '');
            formData.append('product_id', buyBtn.dataset.productId || '');
            if (isVariable) {
                formData.append('variation_id', buyBtn.dataset.variationId || '');
                block.querySelectorAll('.quick-buy-attribute').forEach((s) => {
                    formData.append('attributes[' + s.name + ']', s.value);
                });
            }

            fetch(cfg.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData,
            })
                .then((r) => r.text().then((text) => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('veeping quick buy: unexpected response', text);
                        throw new Error('bad-response');
                    }
                }))
                .then((res) => {
                    if (res && res.success && res.data && res.data.redirect) {
                        window.location.href = res.data.redirect;
                        return;
                    }
                    setError((res && res.data && res.data.message) || 'خطایی رخ داد. لطفاً دوباره تلاش کنید.');
                    setLoading(false);
                    buyBtn.disabled = false;
                })
                .catch((err) => {
                    console.error('veeping quick buy error:', err);
                    setError('خطا در ارتباط با سرور. اتصال اینترنت را بررسی کنید.');
                    setLoading(false);
                    buyBtn.disabled = false;
                });
        });
    });

})();