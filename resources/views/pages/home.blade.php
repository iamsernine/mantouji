<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Home</title>
        <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: "#E25C1A",
                    accent: "#F4C95D",
                    foreground: "#ffffff",
                    background: "#0F0F0F",
                },
            },
        },
    };
</script>
<style>

    .text-gradient {
        background: linear-gradient(90deg, #E25C1A, #F4C95D);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    .animate-float-delayed {
        animation: float 5s ease-in-out infinite;
        animation-delay: 1s;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-up {
        animation: fadeUp 1s ease forwards;
    }

    .animate-fade-up-delayed {
        animation: fadeUp 1.4s ease forwards;
    }

</style>
</head>
<body>
<x-navbar />
<section
    id="hero"
    class="relative min-h-screen flex items-center justify-center overflow-hidden"
    dir="rtl"
>

    <div
        class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('/images/bg/figig-1.jpeg') }}')"
    >
        <div class="absolute inset-0 bg-gradient-to-b from-foreground/20 via-foreground/40 to-foreground/50"></div>
    </div>

    <div class="absolute top-1/4 right-10 w-20 h-20 rounded-full bg-primary/20 blur-2xl animate-float"></div>
    <div class="absolute bottom-1/3 left-20 w-32 h-32 rounded-full bg-accent/20 blur-3xl animate-float-delayed"></div>

    <div class="relative z-10 container mx-auto px-4 text-center">
        <div class="max-w-4xl mx-auto">

            <h1 class="font-amiri text-5xl md:text-7xl lg:text-8xl font-bold text-primary-foreground mb-6 animate-fade-up leading-tight">
                ثروة <span class="text-gradient">فكيك</span> في كل منتج
            </h1>

            <p class="text-xl md:text-2xl text-primary-foreground/80 mb-10 animate-fade-up-delayed max-w-2xl mx-auto leading-relaxed">
                تمور وحرف فكيك… أصالة تعبر الأجيال <br />
                <span class="text-primary-foreground/60 text-lg">
                    اكتشف كنوز واحة فكيك الأصيلة
                </span>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-up-delayed">

                <a href="#service"
                    class="px-6 py-3 rounded-full font-medium transition-all duration-300 
                            bg-primary text-white hover:bg-primary/80 shadow-lg text-center">
                       مسجل بالفعل؟
                    </a>
                
                <a href="{{Route('login')}}"
                    class="px-6 py-3 rounded-full font-medium transition-all duration-300 
                            border border-primary text-primary hover:bg-primary hover:text-white text-center">
التسجيل                     
                </a>
                    
            </div>

            <div class="grid grid-cols-3 gap-8 mt-16 max-w-lg mx-auto animate-fade-up-delayed">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-1">+50</div>
                    <div class="text-primary-foreground/60 text-sm">تعاونية</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-1">+1000</div>
                    <div class="text-primary-foreground/60 text-sm">منتج</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-1">+5000</div>
                    <div class="text-primary-foreground/60 text-sm">عميل</div>
                </div>
            </div>

        </div>

        <a
            href="#about"
            class=" mt-8 absolute  left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-primary-foreground/60 hover:text-primary transition-colors animate-bounce"
        >
            <span class="text-xs">اكتشف المزيد</span>
            <i data-lucide="arrow-down" class="w-5 h-5"></i>
        </a>

    </div>
</section>

    <section id="about" class="py-24 bg-white pattern-moroccan" dir="rtl">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Image Side -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img 
                            src="{{ asset('images/bg/cooperative-1.jpg') }}" 
                            alt="تعاونيات فكيك"
                            class="w-full h-[500px] object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-foreground/50 to-transparent"></div>
                    </div>

                    <!-- Floating Card -->
                    <div class="absolute -bottom-8 -left-8 glass-card rounded-2xl p-6 max-w-xs animate-float">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i data-lucide="users" class="w-7 h-7 text-primary"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-foreground">+50</div>
                                <div class="text-gray-400 text-sm">تعاونية شريكة</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Side -->
                <div>
                    <span class="text-primary font-semibold text-sm tracking-wide uppercase">
                        من نحن
                    </span>

                    <h2 class="font-amiri text-4xl md:text-5xl font-bold text-black mt-3 mb-6">
                        من فكيك <span class="text-gradient">إليك</span>
                    </h2>

                    <p class="text-gray-400 text-lg leading-relaxed mb-8">
                        منتوجي هي منصة رقمية تهدف إلى ربط تعاونيات واحة فكيك بالعملاء في جميع 
                        أنحاء المغرب والعالم. نحن نؤمن بأن كل منتج من فكيك يحمل قصة وتراثاً غنياً 
                        يستحق أن يصل إلى كل بيت.
                    </p>

                    <!-- Features Grid -->
                    <div class="grid sm:grid-cols-2 gap-6">

                        <!-- Item 1 -->
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-card transition-colors duration-300">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i data-lucide="heart" class="w-6 h-6 text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">منتجات أصيلة</h3>
                                <p class="text-gray-400 text-sm">
                                    نقدم لك أجود منتجات واحة فكيك الطبيعية والتقليدية
                                </p>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-card transition-colors duration-300">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i data-lucide="users" class="w-6 h-6 text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">دعم التعاونيات</h3>
                                <p class="text-gray-400 text-sm">
                                    نساعد التعاونيات المحلية على الوصول إلى أسواق أوسع
                                </p>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-card transition-colors duration-300">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i data-lucide="award" class="w-6 h-6 text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">جودة مضمونة</h3>
                                <p class="text-gray-400 text-sm">
                                    جميع منتجاتنا تخضع لمعايير جودة صارمة
                                </p>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-card transition-colors duration-300">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-6 h-6 text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">تنمية مستدامة</h3>
                                <p class="text-gray-400 text-sm">
                                    نسعى لتحقيق التنمية الاقتصادية المستدامة للمنطقة
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-100" dir="rtl">
        <div class="container mx-auto px-4">

            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold text-sm tracking-wide uppercase">
                    كيف يعمل
                </span>

                <h2 class="font-amiri text-4xl md:text-5xl font-bold text-black mt-3 mb-6">
                    اكتشف <span class="text-gradient">بسرعة!</span>
                </h2>

                <p class="text-muted-foreground text-lg">
                    خطوات بسيطة للبدء في رحلتك مع منتوجي
                </p>
            </div>

            {{-- Steps --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

                {{-- Step 1 --}}
                <div class="group relative bg-white rounded-md shadow-md">
                    <div class="absolute -top-4 right-6 bg-primary text-primary-foreground text-sm font-bold px-3 py-1 rounded-full">
                        01
                    </div>

                    <div class="glass-card rounded-2xl p-8 h-full hover-lift group-hover:border-primary/30 transition-all duration-500">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                            <i data-lucide="user-plus" class="w-8 h-8 text-primary"></i>
                        </div>

                        <h3 class="font-semibold text-xl text-black mb-3">اختر ملفك الشخصي</h3>
                        <p class="text-muted-foreground leading-relaxed">
                            حدد دورك: عميل للشراء، أو تعاونية لعرض وبيع منتجاتك
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="group relative bg-white rounded-md shadow-md">
                    <div class="absolute -top-4 right-6 bg-primary text-primary-foreground text-sm font-bold px-3 py-1 rounded-full">
                        02
                    </div>

                    <div class="glass-card rounded-2xl p-8 h-full hover-lift group-hover:border-primary/30 transition-all duration-500">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                            <i data-lucide="clipboard-list" class="w-8 h-8 text-primary"></i>
                        </div>

                        <h3 class="font-semibold text-xl text-black mb-3">أنشئ حسابك</h3>
                        <p class="text-muted-foreground leading-relaxed">
                            املأ استمارة التسجيل بمعلوماتك وسيتم تفعيل حسابك فوراً
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="group relative bg-white rounded-md shadow-md">
                    <div class="absolute -top-4 right-6 bg-primary text-primary-foreground text-sm font-bold px-3 py-1 rounded-full">
                        03
                    </div>

                    <div class="glass-card rounded-2xl p-8 h-full hover-lift group-hover:border-primary/30 transition-all duration-500">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                            <i data-lucide="shopping-bag" class="w-8 h-8 text-primary"></i>
                        </div>

                        <h3 class="font-semibold text-xl text-black mb-3">تصفح وتسوق</h3>
                        <p class="text-muted-foreground leading-relaxed">
                            اكتشف منتجات فكيك الأصيلة واختر ما يناسبك
                        </p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="group relative bg-white rounded-md shadow-md">
                    <div class="absolute -top-4 right-6 bg-primary text-primary-foreground text-sm font-bold px-3 py-1 rounded-full">
                        04
                    </div>

                    <div class="glass-card rounded-2xl p-8 h-full hover-lift group-hover:border-primary/30 transition-all duration-500">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                            <i data-lucide="message-square" class="w-8 h-8 text-primary"></i>
                        </div>

                        <h3 class="font-semibold text-xl text-black mb-3">شارك رأيك</h3>
                        <p class="text-muted-foreground leading-relaxed">
                            قيّم المنتجات وشارك تجربتك لمساعدة الآخرين
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <div class="figuig-to-you-container" id="propo">
        <div class="figuig-to-you"> 
            <p>De Figuig à vous</p>
        </div>
        <div class="figuig-to-you-content">
            <p>
                Mantouji est une plateforme dédiée à la valorisation des produits agricoles, agroalimentaires et
                artisanaux, avec un ancrage fort dans la région de Figuig.
                Elle met en relation directe les producteurs, coopératives et artisans locaux avec les
                consommateurs et partenaires, en garantissant authenticité, traçabilité et qualité.
            </p>
            <p>
                هدفنا هو دعم الاقتصاد المحلي، إبراز هوية فكيك التراثية، وتقديم منتجات عالية الجودة مباشرة من المنتج إلى المستهلك.
            </p>

            <div class="ligne">
                <div class="ligne-container">
                    <img src="/images/bg/ligne.jpeg" alt="" srcset="">
                    <img src="/images/bg/ligne.jpeg" alt="" srcset="">
                </div>
            </div>
        </div>
        {{-- <div class="ligne">
            <div class="ligne-container">
                <img src="/images/bg/ligne.jpeg" alt="" srcset="">
                <img src="/images/bg/ligne.jpeg" alt="" srcset="">
            </div>
        </div> --}}
    </div>
    <div class="auth" id="service">
        <div class="auth-header">
            <p>Please Tell us who you are !</p>
        </div>
        <div class="auth-cards">
            <div class="card">
                <div class="card-content-header">
                    <div class="card-content">
                        <div class="card-container-image">
                            <img src="/images/icones/client.png" alt="" srcset="">
                        </div>
                        <p><a href="{{Route('register', ['type' => 0])}}">Client ?</a></p>
                    </div>
                </div>
            </div>
            <div class="auth-card-or">
                <p>OR</p>
            </div>
            <div class="card">
                <div class="card-content-header">
                    <div class="card-content">
                        <div class="card-container-image">
                            <img src="/images/icones/store.png" alt="" srcset="">
                        </div>
                        <p><a href="{{Route('register', ['type' => 1])}}">Association ?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer" id="conta">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="/images/logo.png" alt="" srcset="">
            </div>
            <div class="footer-links-container">
                <div class="footer-links">
                    <ul>
                        <li style="font-weight: bold">Information</li>
                        <li style="margin-top: 15px"><a href="#">Industry analystics</a></li>
                        <li><a href="#">News and release</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">About Us</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <ul>
                        <li style="font-weight: bold">Useful Links</li>
                        <li style="margin-top: 15px"><a href="#acc">Acceuile</a></li>
                        <li><a href="#propo">A propos</a></li>
                        <li><a href="#service">Services</a></li>
                        <li><a href="#conta">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <ul>
                        <li style="font-weight: bold">Contact</li>
                        <li style="margin-top: 15px"><a href="https://www.tech-da.com/">Tech-da</a></li>
                        {{-- <li>Home</li>
                        <li>Home</li>
                        <li>Home</li> --}}
                    </ul>
                </div>
            </div>

            <div class="footer-logo">
                <img src="/images/bg/footer.png" alt="" srcset="" style="border-radius: 12px; padding-top: 30px; padding-bottom: 15px;">
            </div>
        </div>
        <hr style="width: 90%; margin: auto; margin-top: 20px; border: 0.5px solid gray">
        <div class="footer-bottom">
            <div>
                <p>Copyright</p>
            </div>
            <div class="footer-terms">
                <ul>
                    <li>Terms</li>
                    <li>Privacy</li>
                    <li>Police and Cookie Policy</li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
        <script>
            lucide.createIcons();
        </script>
    <script src="js/navbar.js"></script>
</body>
</html>