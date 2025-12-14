

    <header
    id="mainHeader"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-transparent py-4"
    dir="rtl"
>
    <div class="container mx-auto px-4 flex items-center justify-between">

        <a href="#" class="flex items-center gap-2">
            <img src="{{ asset('/images/logo.png') }}" alt="Mantouji" class="h-12 w-auto">
        </a>

        <nav class="hidden md:flex items-center gap-8">
            <a href="#acc" class="text-sm font-medium transition-colors duration-300 hover:text-primary text-primary-foreground">
                الرئيسية
            </a>
            <a href="#propo" class="text-sm font-medium transition-colors duration-300 hover:text-primary text-primary-foreground">
                من نحن
            </a>
            <a href="#service" class="text-sm font-medium transition-colors duration-300 hover:text-primary text-primary-foreground">
                الخدمات
            </a>
            <a href="#conta" class="text-sm font-medium transition-colors duration-300 hover:text-primary text-primary-foreground">
                المنتجات
            </a>
        </nav>

        <div class="hidden md:flex items-center gap-4">
        <a href="{{Route('login')}}"
            class="px-3 py-1 rounded-full font-medium transition-all duration-300 
                    border border-primary text-primary hover:bg-primary hover:text-white text-center">
التسجيل         
        </a>

    </div>

        <button id="mobileMenuBtn" class="md:hidden p-2">
            <i data-lucide="menu" class="w-6 h-6 text-primary-foreground"></i>
        </button>

    </div>

    <div
        id="mobileMenu"
        class="hidden md:hidden absolute top-full left-0 right-0 bg-background/98 backdrop-blur-md border-b border-border shadow-lg animate-fade-up"
    >
        <nav class="container mx-auto px-4 py-6 flex flex-col gap-4">

            <a href="#acc" class="text-foreground font-medium py-2 hover:text-primary transition-colors">
                الرئيسية
            </a>
            <a href="#propo" class="text-foreground font-medium py-2 hover:text-primary transition-colors">
                من نحن
            </a>
            <a href="#service" class="text-foreground font-medium py-2 hover:text-primary transition-colors">
                الخدمات
            </a>
            <a href="#conta" class="text-foreground font-medium py-2 hover:text-primary transition-colors">
                المنتجات
            </a>

            <div class="flex flex-col gap-3 pt-4 border-t border-border">
                <a href="{{Route('login')}}" class="btn w-full text-center">التسجيل</a>
            </div>

        </nav>
    </div>
</header>

<script>
    const header = document.getElementById("mainHeader");
    const navLinks = document.querySelectorAll("nav a");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 20) {
            header.classList.add("bg-background/95", "backdrop-blur-md", "shadow-md");
            header.classList.remove("bg-transparent");

            navLinks.forEach(link => {
                link.classList.remove("text-primary-foreground");
                link.classList.add("text-white");
            });
        } else {
            header.classList.remove("bg-background/95", "backdrop-blur-md", "shadow-md");
            header.classList.add("bg-transparent");

            navLinks.forEach(link => {
                link.classList.remove("text-white");
                link.classList.add("text-primary-foreground");
            });
        }
    });
</script>
