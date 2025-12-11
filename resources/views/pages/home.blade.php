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
    <!-- <div class="home">
        <x-navbar />
        <div class="content-container" id="Accueil">
            <div class="logo">
                <img src="/images/logo.png" alt="" srcset="">
            </div>
            <div class="content">
                <div class="left-content">
                    <p>La richesse de Figuig dans chaque <span>produit</span></p>
                    <p>تمور وحرف فكيك… أصالة تعبر الأجيال</p>
                </div>
            </div>
        </div>

        <div class="btn-home">
            <div class="btn-home-left"><a href="#service">S'inscrire</a></div>
            <div class="btn-home-right">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Bienvennue !</a>
                    @else
                        <a href="{{Route('login')}}">Déjà-inscrit ?</a>
                    @endauth
                @endif
            </div>
        </div>
    </div> -->
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

    <div class="guide-container">
        <div class="guide-left">
            <div class="guide-left-text">
                <p>Votre guide vers les meilleurs produits de Figuig ✨</p>
            </div>
            <div class="guide-left-ste">
                <p>Get iton</p>
                <p>🌐   Www.Mantouji.org</p>
            </div>
        </div>
        <div class="guide-right">
            <div class="guide-right-img-1">
                <img src="{{ asset('images/bg/fiig.png') }}" alt="" srcset="">
            </div>
            <div class="guide-right-img-2">
                <img src="{{ asset('images/bg/fiig-2.png') }}" alt="" srcset="">
            </div>
        </div>
    </div>

    <div class="etapes-header">
        <p>Découvrez rapidement !</p>
    </div>
    <div class="etapes-container">
        <div class="etapes">
            <div class="etapes-parte-1">
                <div class="etapes-parte-1-header">
                    <p>Etape 1</p>
                    <p>Choisir Ton Profil</p>
                </div>
                <div class="etapes-parte-1-content">
                    <img src="/images/bg/etape 1.PNG" alt="" srcset="">
                    <p>Choose th way u wanna join us with </p>
                    <p>A range of powerful tools for viewing, querying and filtering your data.</p>
                </div>
            </div>
            <div class="etapes-parte-2">
                <img src="/images/bg/etape 1 circle.png" alt="" srcset="">
            </div>
        </div>

        <div class="etapes-r">
            <div class="etapes-parte-1">
                <div class="etapes-parte-1-header">
                    <p>Etape 2</p>
                    <p>Créer Votre Compte</p>
                </div>
                <div class="etapes-parte-1-content">
                    <img src="/images/bg/etape 2.PNG" alt="" srcset="">
                    <p class="etapes-parte-1-content-r">Choose th way u wanna join us with  </p>
                    <p class="etapes-parte-1-content-r">A range of powerful tools for viewing, querying and filtering your data.</p>
                </div>
            </div>
            <div class="etapes-parte-2-r">
                <img src="/images/bg/etape 2 circle.png" alt="" srcset="">
            </div>
        </div>

        <div class="etapes">
            <div class="etapes-parte-1">
                <div class="etapes-parte-1-header">
                    <p>Etape 3</p>
                    <p>laisser Vos Avis</p>
                </div>
                <div class="etapes-parte-1-content">
                    <img src="/images/bg/etape 3.PNG" alt="" srcset="">
                    <p>Choose th way u wanna join us with </p>
                    <p>A range of powerful tools for viewing, querying and filtering your data.</p>
                </div>
            </div>
            <div class="etapes-parte-2">
                <img src="/images/bg/etape 3 circle.png" alt="" srcset="">
            </div>
        </div>
    </div>

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